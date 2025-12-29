<?php

namespace App\Middleware;

class AdminMiddleware
{
    public function handle()
    {
        // First check if user is authenticated
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
            $_SESSION['error_message'] = 'Silakan login terlebih dahulu.';
            header('Location: /login');
            exit;
        }

        // Then check if user is admin
        if ($_SESSION['user_role'] !== 'admin' && $_SESSION['user_role'] !== 'bus_operator') {
            $_SESSION['error_message'] = 'Akses ditolak. Halaman untuk admin saja.';
            header('Location: /dashboard');
            exit;
        }
    }
}
