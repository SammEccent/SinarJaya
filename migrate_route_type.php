<?php

/**
 * Script untuk migrasi: Pindahkan route_type dari routes ke schedules
 * Logika baru: route_type ditentukan per jadwal, bukan per rute
 */

require_once 'app/init.php';

echo "=== Migrasi: Pindahkan route_type ke schedules ===\n\n";

try {
    $db = new Database();

    // Check if route_type exists in routes
    echo "1. Memeriksa kolom route_type di tabel routes...\n";
    $db->prepare("SHOW COLUMNS FROM routes LIKE 'route_type'");
    $hasInRoutes = $db->fetch();

    // Check if route_type exists in schedules
    $db->prepare("SHOW COLUMNS FROM schedules LIKE 'route_type'");
    $hasInSchedules = $db->fetch();

    if (!$hasInRoutes && $hasInSchedules) {
        echo "   ✓ Migrasi sudah selesai sebelumnya.\n";
        echo "   ✓ Kolom route_type sudah ada di schedules.\n\n";
        exit(0);
    }

    // Remove from routes if exists
    if ($hasInRoutes) {
        echo "   → Menghapus kolom route_type dari tabel routes...\n";
        $db->prepare("ALTER TABLE routes DROP COLUMN route_type");
        $db->execute();
        echo "   ✓ Kolom route_type dihapus dari routes.\n\n";
    } else {
        echo "   → Kolom route_type tidak ada di routes.\n\n";
    }

    // Add to schedules if not exists
    if (!$hasInSchedules) {
        echo "2. Menambahkan kolom route_type ke tabel schedules...\n";
        $db->prepare("
            ALTER TABLE schedules 
            ADD COLUMN route_type ENUM('forward', 'return') NOT NULL DEFAULT 'forward' 
            AFTER route_id
        ");
        $db->execute();
        echo "   ✓ Kolom route_type berhasil ditambahkan ke schedules.\n\n";
    } else {
        echo "2. Kolom route_type sudah ada di schedules.\n\n";
    }

    // Show current schedules
    echo "3. Menampilkan jadwal yang ada:\n";
    $db->prepare("
        SELECT s.id, s.route_id, s.route_type, s.departure_datetime, s.status,
               r.origin_city, r.destination_city, b.plate_number
        FROM schedules s
        JOIN routes r ON s.route_id = r.route_id
        JOIN buses b ON s.bus_id = b.id
        ORDER BY s.departure_datetime DESC
        LIMIT 10
    ");
    $schedules = $db->fetchAll();

    if (empty($schedules)) {
        echo "   → Belum ada jadwal di database.\n\n";
    } else {
        echo "   " . str_repeat("-", 100) . "\n";
        echo "   | ID  | Bus        | Rute                          | Berangkat        | Tipe   | Status    |\n";
        echo "   " . str_repeat("-", 100) . "\n";
        foreach ($schedules as $sch) {
            $route = $sch['origin_city'] . ' → ' . $sch['destination_city'];
            $type = $sch['route_type'] === 'forward' ? 'Berangkat' : 'Balik';
            printf(
                "   | %-3s | %-10s | %-29s | %-16s | %-6s | %-9s |\n",
                $sch['id'],
                substr($sch['plate_number'], 0, 10),
                substr($route, 0, 29),
                date('d/m/Y H:i', strtotime($sch['departure_datetime'])),
                $type,
                $sch['status']
            );
        }
        echo "   " . str_repeat("-", 100) . "\n\n";

        echo "   ℹ  Semua jadwal diset sebagai 'forward' (Arus Berangkat) secara default.\n";
        echo "   ℹ  Sistem akan otomatis memvalidasi arus balik saat tambah jadwal.\n\n";
    }

    echo "=== Migrasi Selesai ===\n";
    echo "✓ Database berhasil diupdate!\n\n";

    echo "Logika baru:\n";
    echo "1. route_type sekarang ada di tabel schedules (bukan routes)\n";
    echo "2. Ketika bus berangkat (Yogya → Tangerang), jadwal berikutnya otomatis\n";
    echo "   harus arus balik (Tangerang → Yogya)\n";
    echo "3. Validasi otomatis berdasarkan origin-destination yang dibalik\n\n";
} catch (Exception $e) {
    echo "\n❌ ERROR: " . $e->getMessage() . "\n";
    echo "\nMigrasi gagal. Silakan cek konfigurasi database Anda.\n";
    exit(1);
}
