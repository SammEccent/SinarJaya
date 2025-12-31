<?php

/**
 * Admin Sidebar Navigation Component
 * Used across all admin pages for consistent navigation
 */
?>
<div class="admin-sidebar">
    <div class="admin-sidebar-header">
        <h2>Sinar Jaya</h2>
        <p>Admin Panel</p>
    </div>
    <nav class="admin-nav">
        <ul>
            <?php
            $current_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            $base_path = parse_url(BASEURL, PHP_URL_PATH);

            // Ensure base_path always ends with a slash for consistent comparison
            if (substr($base_path, -1) !== '/') {
                $base_path .= '/';
            }

            // Remove base_path from current_path
            if (strpos($current_path, $base_path) === 0) {
                $relative_path = substr($current_path, strlen($base_path));
            } else {
                $relative_path = $current_path;
            }
            $relative_path = trim($relative_path, '/');
            $segments = explode('/', $relative_path);

            $current_admin_segment = '';
            if (isset($segments[0]) && $segments[0] === 'admin') {
                if (isset($segments[1])) {
                    $current_admin_segment = $segments[1];
                } else {
                    // If only 'admin' is present, it's the dashboard
                    $current_admin_segment = 'dashboard';
                }
            }
            ?>
            <li><a href="<?php echo BASEURL; ?>admin" class="<?php echo ($current_admin_segment === 'dashboard' || $current_admin_segment === '') ? 'active' : ''; ?>"><i class="fas fa-chart-line"></i> Dashboard</a></li>
            <li><a href="<?php echo BASEURL; ?>admin/buses" class="<?php echo ($current_admin_segment === 'buses') ? 'active' : ''; ?>"><i class="fas fa-bus"></i> Kelola Bus</a></li>
            <li><a href="<?php echo BASEURL; ?>admin/routes" class="<?php echo ($current_admin_segment === 'routes') ? 'active' : ''; ?>"><i class="fas fa-road"></i> Kelola Rute</a></li>
            <li><a href="<?php echo BASEURL; ?>admin/schedules" class="<?php echo ($current_admin_segment === 'schedules') ? 'active' : ''; ?>"><i class="fas fa-calendar-alt"></i> Kelola Jadwal</a></li>
            <li><a href="<?php echo BASEURL; ?>admin/bookings" class="<?php echo ($current_admin_segment === 'bookings') ? 'active' : ''; ?>"><i class="fas fa-ticket-alt"></i> Kelola Pemesanan</a></li>
            <li><a href="<?php echo BASEURL; ?>admin/payments" class="<?php echo ($current_admin_segment === 'payments') ? 'active' : ''; ?>"><i class="fas fa-credit-card"></i> Kelola Pembayaran</a></li>
            <li><a href="<?php echo BASEURL; ?>admin/users" class="<?php echo ($current_admin_segment === 'users') ? 'active' : ''; ?>"><i class="fas fa-users"></i> Kelola Pengguna</a></li>
        </ul>
    </nav>
    <div class="admin-sidebar-footer">
        <a href="<?php echo BASEURL; ?>auth/logout" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
</div>