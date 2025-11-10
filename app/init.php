<?php

// Mulai session di sini agar tersedia di seluruh aplikasi
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// 1. Muat file konfigurasi utama
require_once 'config/config.php';

// 2. Muat semua file Core
require_once 'Core/App.php';
require_once 'Core/Controller.php';
require_once 'Core/Database.php';
require_once 'Core/helpers.php';

// 3. Muat autoloader Composer untuk library eksternal (seperti PHPMailer)
require_once __DIR__ . '/../vendor/autoload.php';
