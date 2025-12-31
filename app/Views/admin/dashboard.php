<div class="admin-dashboard">
    <!-- Sidebar -->
    <?php require_once __DIR__ . '/../partials/admin_sidebar.php'; ?>

    <!-- Main Content -->
    <div class="admin-content">
        <div class="admin-header">
            <div class="admin-title">
                <h1>Dashboard</h1>
                <p>Selamat datang, <?php echo htmlspecialchars(isset($_SESSION['user_email']) ? $_SESSION['user_email'] : 'Admin'); ?></p>
            </div>
            <div class="admin-user-info">
                <span class="user-email"><?php echo htmlspecialchars(isset($_SESSION['user_email']) ? $_SESSION['user_email'] : 'Unknown'); ?></span>
            </div>
        </div>

        <div class="admin-body">
            <!-- Stats Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon" style="background-color: #e3f2fd;">
                        <i class="fas fa-bus" style="color: #2563eb;"></i>
                    </div>
                    <div class="stat-info">
                        <p class="stat-label">Total Bus</p>
                        <h3 class="stat-value"><?php echo htmlspecialchars($total_buses ?? 0); ?></h3>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon" style="background-color: #f3e5f5;">
                        <i class="fas fa-road" style="color: #9c27b0;"></i>
                    </div>
                    <div class="stat-info">
                        <p class="stat-label">Total Rute</p>
                        <h3 class="stat-value"><?php echo htmlspecialchars($total_routes ?? 0); ?></h3>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon" style="background-color: #e8f5e9;">
                        <i class="fas fa-users" style="color: #10b981;"></i>
                    </div>
                    <div class="stat-info">
                        <p class="stat-label">Total Pengguna</p>
                        <h3 class="stat-value"><?php echo htmlspecialchars($total_users ?? 0); ?></h3>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon" style="background-color: #fff3e0;">
                        <i class="fas fa-wallet" style="color: #f59e0b;"></i>
                    </div>
                    <div class="stat-info">
                        <p class="stat-label">Total Pendapatan</p>
                        <h3 class="stat-value"><?php echo 'Rp ' . number_format($payment_stats['total_revenue'] ?? 0, 0, ',', '.'); ?></h3>
                    </div>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="content-sections">
                <div class="section-row">
                    <!-- Recent Bookings -->
                    <div class="section">
                        <h2>Pemesanan Terbaru</h2>
                        <div class="table-container">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>Kode Booking</th>
                                        <th>Pengguna</th>
                                        <th>Rute</th>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($recent_bookings)): ?>
                                        <tr>
                                            <td colspan="5" style="text-align: center;">Tidak ada pemesanan terbaru.</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($recent_bookings as $booking): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($booking['booking_code'] ?? '-'); ?></td>
                                                <td><?php echo htmlspecialchars($booking['user_name'] ?? '-'); ?></td>
                                                <td><?php echo htmlspecialchars($booking['route_code'] ?? '-'); ?></td>
                                                <td><?php echo date('d/m/Y H:i', strtotime($booking['created_at'])); ?></td>
                                                <td>
                                                    <?php
                                                    $status_class = 'badge-secondary';
                                                    if ($booking['booking_status'] === 'confirmed') {
                                                        $status_class = 'badge-success';
                                                    } elseif ($booking['booking_status'] === 'pending') {
                                                        $status_class = 'badge-warning';
                                                    } elseif ($booking['booking_status'] === 'cancelled') {
                                                        $status_class = 'badge-danger';
                                                    }
                                                    ?>
                                                    <span class="badge <?php echo $status_class; ?>">
                                                        <?php echo ucfirst(htmlspecialchars($booking['booking_status'])); ?>
                                                    </span>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="section-row">
                    <!-- Quick Actions -->
                    <div class="section">
                        <h2>Aksi Cepat</h2>
                        <div class="quick-actions">
                            <a href="<?php echo BASEURL; ?>admin/buses/create" class="action-btn">
                                <i class="fas fa-plus"></i>
                                Tambah Bus Baru
                            </a>
                            <a href="<?php echo BASEURL; ?>admin/schedules/create" class="action-btn">
                                <i class="fas fa-calendar-plus"></i>
                                Buat Jadwal Baru
                            </a>
                            <a href="<?php echo BASEURL; ?>admin/users" class="action-btn">
                                <i class="fas fa-user-plus"></i>
                                Kelola Pengguna
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>