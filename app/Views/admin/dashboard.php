<div class="admin-dashboard">
    <!-- Sidebar -->
    <div class="admin-sidebar">
        <div class="admin-sidebar-header">
            <h2>Sinar Jaya</h2>
            <p>Admin Panel</p>
        </div>
        <nav class="admin-nav">
            <ul>
                <li><a href="<?php echo BASEURL; ?>admin" class="active"><i class="fas fa-chart-line"></i> Dashboard</a></li>
                <li><a href="<?php echo BASEURL; ?>admin/buses"><i class="fas fa-bus"></i> Kelola Bus</a></li>
                <li><a href="<?php echo BASEURL; ?>admin/routes"><i class="fas fa-road"></i> Kelola Rute</a></li>
                <li><a href="<?php echo BASEURL; ?>admin/schedules"><i class="fas fa-calendar"></i> Jadwal</a></li>
                <li><a href="<?php echo BASEURL; ?>admin/bookings"><i class="fas fa-ticket-alt"></i> Pemesanan</a></li>
                <li><a href="<?php echo BASEURL; ?>admin/payments"><i class="fas fa-credit-card"></i> Pembayaran</a></li>
                <li><a href="<?php echo BASEURL; ?>admin/users"><i class="fas fa-users"></i> Pengguna</a></li>
            </ul>
        </nav>
        <div class="admin-sidebar-footer">
            <a href="<?php echo BASEURL; ?>auth/logout" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>

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
                        <h3 class="stat-value">12</h3>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon" style="background-color: #f3e5f5;">
                        <i class="fas fa-road" style="color: #9c27b0;"></i>
                    </div>
                    <div class="stat-info">
                        <p class="stat-label">Total Rute</p>
                        <h3 class="stat-value">8</h3>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon" style="background-color: #e8f5e9;">
                        <i class="fas fa-ticket-alt" style="color: #10b981;"></i>
                    </div>
                    <div class="stat-info">
                        <p class="stat-label">Pemesanan Hari Ini</p>
                        <h3 class="stat-value">24</h3>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon" style="background-color: #fff3e0;">
                        <i class="fas fa-credit-card" style="color: #f59e0b;"></i>
                    </div>
                    <div class="stat-info">
                        <p class="stat-label">Pendapatan Hari Ini</p>
                        <h3 class="stat-value">Rp 4.5M</h3>
                    </div>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="content-sections">
                <div class="section-row">
                    <!-- Recent Bookings -->
                    <div class="section">
                        <h2>Pemesanan Terbaru</h2>
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Penumpang</th>
                                    <th>Rute</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>#001</td>
                                    <td>John Doe</td>
                                    <td>Jakarta - Bandung</td>
                                    <td>2025-12-29</td>
                                    <td><span class="badge badge-success">Terkonfirmasi</span></td>
                                </tr>
                                <tr>
                                    <td>#002</td>
                                    <td>Jane Smith</td>
                                    <td>Jakarta - Yogyakarta</td>
                                    <td>2025-12-29</td>
                                    <td><span class="badge badge-warning">Menunggu</span></td>
                                </tr>
                                <tr>
                                    <td>#003</td>
                                    <td>Ahmad Rahman</td>
                                    <td>Bandung - Surabaya</td>
                                    <td>2025-12-29</td>
                                    <td><span class="badge badge-success">Terkonfirmasi</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="section-row">
                    <!-- Quick Actions -->
                    <div class="section">
                        <h2>Aksi Cepat</h2>
                        <div class="quick-actions">
                            <a href="<?php echo BASEURL; ?>admin/buses" class="action-btn">
                                <i class="fas fa-plus"></i>
                                Tambah Bus Baru
                            </a>
                            <a href="<?php echo BASEURL; ?>admin/schedules" class="action-btn">
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

<style>
    .admin-dashboard {
        display: flex;
        min-height: 100vh;
        background-color: #f9fafb;
    }

    .admin-sidebar {
        width: 260px;
        background-color: #1f2937;
        color: white;
        position: fixed;
        left: 0;
        top: 0;
        height: 100vh;
        overflow-y: auto;
        box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
    }

    .admin-sidebar-header {
        padding: 20px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .admin-sidebar-header h2 {
        color: #2563eb;
        margin: 0;
        font-size: 1.3rem;
    }

    .admin-sidebar-header p {
        color: #9ca3af;
        font-size: 0.85rem;
        margin: 5px 0 0 0;
    }

    .admin-nav ul {
        list-style: none;
        padding: 20px 0;
    }

    .admin-nav li {
        padding: 0;
        margin: 0;
    }

    .admin-nav a {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 20px;
        color: #d1d5db;
        text-decoration: none;
        transition: all 0.3s ease;
        border-left: 3px solid transparent;
    }

    .admin-nav a:hover {
        background-color: rgba(255, 255, 255, 0.1);
        color: white;
        border-left-color: #2563eb;
    }

    .admin-nav a.active {
        background-color: rgba(37, 99, 235, 0.1);
        color: #2563eb;
        border-left-color: #2563eb;
    }

    .admin-sidebar-footer {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 20px;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        background-color: rgba(0, 0, 0, 0.2);
    }

    .btn-logout {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 16px;
        background-color: #ef4444;
        color: white;
        border-radius: 6px;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .btn-logout:hover {
        background-color: #dc2626;
    }

    .admin-content {
        margin-left: 260px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .admin-header {
        background-color: white;
        padding: 20px 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #e5e7eb;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .admin-title h1 {
        margin: 0;
        font-size: 1.8rem;
    }

    .admin-title p {
        color: #6b7280;
        margin: 5px 0 0 0;
    }

    .admin-user-info {
        text-align: right;
    }

    .user-email {
        font-size: 0.9rem;
        color: #6b7280;
    }

    .admin-body {
        padding: 30px;
        flex: 1;
        overflow-y: auto;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background-color: white;
        padding: 20px;
        border-radius: 10px;
        display: flex;
        gap: 20px;
        align-items: center;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .stat-info {
        flex: 1;
    }

    .stat-label {
        color: #6b7280;
        margin: 0;
        font-size: 0.9rem;
    }

    .stat-value {
        color: #1f2937;
        margin: 5px 0 0 0;
        font-size: 1.8rem;
    }

    .content-sections {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .section-row {
        display: grid;
        grid-template-columns: 1fr;
        gap: 20px;
    }

    .section {
        background-color: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .section h2 {
        margin-top: 0;
        margin-bottom: 20px;
        color: #1f2937;
        font-size: 1.3rem;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
    }

    .data-table thead {
        background-color: #f3f4f6;
    }

    .data-table th {
        padding: 12px;
        text-align: left;
        color: #374151;
        font-weight: 600;
        border-bottom: 2px solid #e5e7eb;
    }

    .data-table td {
        padding: 12px;
        border-bottom: 1px solid #e5e7eb;
        color: #374151;
    }

    .data-table tbody tr:hover {
        background-color: #f9fafb;
    }

    .badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 500;
    }

    .badge-success {
        background-color: #d1fae5;
        color: #065f46;
    }

    .badge-warning {
        background-color: #fef3c7;
        color: #92400e;
    }

    .badge-danger {
        background-color: #fee2e2;
        color: #991b1b;
    }

    .quick-actions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
    }

    .action-btn {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
        padding: 20px;
        background-color: #f3f4f6;
        border-radius: 8px;
        color: #2563eb;
        text-decoration: none;
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }

    .action-btn:hover {
        background-color: #e0e7ff;
        border-color: #2563eb;
        color: #1e40af;
    }

    .action-btn i {
        font-size: 1.5rem;
    }

    @media (max-width: 1024px) {
        .admin-sidebar {
            width: 200px;
        }

        .admin-content {
            margin-left: 200px;
        }

        .admin-header {
            flex-direction: column;
            gap: 15px;
            align-items: flex-start;
        }
    }

    @media (max-width: 768px) {
        .admin-sidebar {
            position: fixed;
            left: -260px;
            z-index: 1000;
            transition: left 0.3s ease;
        }

        .admin-sidebar.active {
            left: 0;
        }

        .admin-content {
            margin-left: 0;
        }

        .admin-body {
            padding: 15px;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .section-row {
            grid-template-columns: 1fr;
        }
    }
</style>