<?php

/**
 * Test script untuk mengecek status kursi dan booking
 */

require_once 'app/init.php';

// Create database instance
$db = new Database();

echo "=== Testing Seat Status System ===\n\n";

// Step 1: Update expired bookings manually
echo "Step 1: Checking and updating expired bookings...\n";
$db->prepare('
    UPDATE bookings 
    SET booking_status = "expired", updated_at = :updated_at
    WHERE booking_status = "pending" 
    AND payment_expiry IS NOT NULL 
    AND payment_expiry < :current_time
');
$currentTime = date('Y-m-d H:i:s');
$db->bind(':updated_at', $currentTime);
$db->bind(':current_time', $currentTime);
$db->execute();
$updated = $db->rowCount();
echo "Updated $updated booking(s) to expired status\n\n";

// Step 2: Check all bookings with status pending
$db = new Database();
$db->prepare("
    SELECT 
        b.id,
        b.booking_code,
        b.booking_status,
        b.payment_expiry,
        CASE 
            WHEN b.payment_expiry < NOW() THEN 'SHOULD BE EXPIRED'
            ELSE 'STILL VALID'
        END as expiry_check
    FROM bookings b
    WHERE b.booking_status IN ('pending', 'confirmed')
    ORDER BY b.created_at DESC
    LIMIT 10
");
$bookings = $db->fetchAll();

echo "Step 2: Recent active bookings:\n";
foreach ($bookings as $booking) {
    echo "  - {$booking['booking_code']}: {$booking['booking_status']} | Expiry: {$booking['payment_expiry']} | {$booking['expiry_check']}\n";
}
echo "\n";

// Step 3: Check seat 1B specifically
$db->prepare("
    SELECT 
        s.id,
        s.seat_number,
        s.status as seat_status,
        p.id as passenger_id,
        b.booking_code,
        b.booking_status,
        b.payment_expiry,
        CASE 
            WHEN b.payment_expiry < NOW() THEN 'EXPIRED'
            WHEN b.payment_expiry > NOW() THEN 'ACTIVE'
            ELSE 'NO EXPIRY'
        END as booking_state
    FROM seats s
    LEFT JOIN passengers p ON s.id = p.seat_id
    LEFT JOIN bookings b ON p.booking_id = b.id
    WHERE s.seat_number = '1B'
    ORDER BY b.created_at DESC
    LIMIT 1
");
$seat1B = $db->fetch();

echo "Step 3: Seat 1B details:\n";
if ($seat1B) {
    echo "  Seat ID: {$seat1B['id']}\n";
    echo "  Seat Status (physical): {$seat1B['seat_status']}\n";
    echo "  Passenger ID: " . ($seat1B['passenger_id'] ?: 'None') . "\n";
    echo "  Booking Code: " . ($seat1B['booking_code'] ?: 'None') . "\n";
    echo "  Booking Status: " . ($seat1B['booking_status'] ?: 'None') . "\n";
    echo "  Payment Expiry: " . ($seat1B['payment_expiry'] ?: 'None') . "\n";
    echo "  Booking State: " . ($seat1B['booking_state'] ?: 'None') . "\n";
} else {
    echo "  Seat 1B not found\n";
}
echo "\n";

// Step 4: Test the getByBus query for bus that has seat 1B
if ($seat1B && $seat1B['id']) {
    $db->prepare("SELECT bus_id FROM seats WHERE id = :id");
    $db->bind(':id', $seat1B['id']);
    $seatInfo = $db->fetch();

    if ($seatInfo) {
        echo "Step 4: Testing getByBus() for bus_id {$seatInfo['bus_id']}:\n";
        $seats = $seatModel->getByBus($seatInfo['bus_id']);

        foreach ($seats as $seat) {
            if ($seat['seat_number'] === '1B') {
                echo "  Seat 1B from getByBus():\n";
                echo "    - Status returned: {$seat['status']}\n";
                echo "    - Seat Number: {$seat['seat_number']}\n";
                break;
            }
        }
    }
}

echo "\n=== Test Complete ===\n";
