<?php

/**
 * Script to fix available_seats in all schedules
 * This script recalculates available_seats based on actual seat bookings
 */

require_once __DIR__ . '/app/init.php';

// Load models manually
foreach (glob(__DIR__ . '/app/Models/*.php') as $model_file) {
    require_once $model_file;
}

$scheduleModel = new ScheduleModel();
$seatModel = new SeatModel();

echo "=== FIX AVAILABLE SEATS SCRIPT ===\n\n";

// Step 1: Release orphaned seats (seats marked as 'booked' but no passenger)
echo "Step 1: Releasing orphaned seats...\n";
$db = new Database();
$db->prepare('
    SELECT s.id, s.seat_number, s.bus_id, s.status 
    FROM seats s
    LEFT JOIN passengers p ON s.id = p.seat_id
    WHERE s.status = "booked" AND p.id IS NULL
');
$orphaned_seats = $db->fetchAll();

if (count($orphaned_seats) > 0) {
    echo "Found " . count($orphaned_seats) . " orphaned seats:\n";
    foreach ($orphaned_seats as $seat) {
        echo "  - Seat #{$seat['id']} ({$seat['seat_number']}) in bus #{$seat['bus_id']}\n";
        $seatModel->updateStatus($seat['id'], 'available');
    }
    echo "Orphaned seats released.\n\n";
} else {
    echo "No orphaned seats found.\n\n";
}

// Step 2: Recalculate available_seats for all schedules
echo "Step 2: Recalculating available_seats for all schedules...\n";
$fixed_ids = $scheduleModel->fixAllSchedulesAvailableSeats();

echo "Fixed " . count($fixed_ids) . " schedules:\n";
foreach ($fixed_ids as $id) {
    $schedule = $scheduleModel->findById($id);
    if ($schedule) {
        echo "  - Schedule #{$id}: {$schedule['route_code']} on " .
            date('Y-m-d H:i', strtotime($schedule['departure_datetime'])) .
            " -> {$schedule['available_seats']} seats available\n";
    }
}

echo "\n=== DONE ===\n";
