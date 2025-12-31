<?php

/**
 * Script untuk membersihkan status "booked" di tabel seats
 * Status "booked" seharusnya dihitung secara dinamis, bukan disimpan di database
 */

require_once 'app/init.php';

$db = new Database();

echo "=== Cleaning Seat Status Database ===\n\n";

// Check how many seats have status "booked"
$db->prepare('SELECT COUNT(*) as total FROM seats WHERE status = "booked"');
$result = $db->fetch();
echo "Found {$result['total']} seat(s) with status 'booked'\n\n";

// Update all "booked" status to "available"
$db->prepare('UPDATE seats SET status = "available" WHERE status = "booked"');
$db->execute();
$updated = $db->rowCount();

echo "Updated $updated seat(s) from 'booked' to 'available'\n\n";

// Verify
$db->prepare('SELECT COUNT(*) as total FROM seats WHERE status = "booked"');
$result = $db->fetch();
echo "Remaining seats with status 'booked': {$result['total']}\n\n";

// Show current seat status distribution
$db->prepare('
    SELECT 
        status,
        COUNT(*) as count
    FROM seats
    GROUP BY status
    ORDER BY status
');
$distribution = $db->fetchAll();

echo "Current seat status distribution:\n";
foreach ($distribution as $row) {
    echo "  - {$row['status']}: {$row['count']} seat(s)\n";
}

echo "\n=== Cleanup Complete ===\n";
echo "Note: Status 'booked' will now be calculated dynamically based on active bookings.\n";
