<?php

namespace App\Middleware;

class AuthMiddleware
{
    public function handle()
    {
        if (!isset($_SESSION['user_id'])) {
            // Store intended URL for redirect after login
            $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];

            // Set flash message
            $_SESSION['error_message'] = 'Silakan login terlebih dahulu.';

            // Redirect to login
            header('Location: /login');
            exit;
        }
    }
}
