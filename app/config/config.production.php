# ================================================
# PRODUCTION CONFIGURATION FILE
# ================================================
# Copy this file to config.php and update values
# DO NOT commit config.php to version control
# ================================================

<?php
// Set timezone to Asia/Jakarta (WIB)
date_default_timezone_set('Asia/Jakarta');

// ================================================
// ENVIRONMENT CONFIGURATION
// ================================================
// IMPORTANT: Change to 'production' on live server
define('ENVIRONMENT', 'production');

// Enable error reporting (OFF in production)
if (ENVIRONMENT === 'production') {
    error_reporting(0);
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
    ini_set('error_log', __DIR__ . '/../../logs/error.log');
} else {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

// ================================================
// BASE URL - CHANGE THIS TO YOUR DOMAIN
// ================================================
// Development: http://localhost/SinarJaya/public/
// Production: https://yourdomain.com/
defined('BASEURL') or define('BASEURL', 'https://yourdomain.com/');

// ================================================
// APPLICATION CONFIGURATION
// ================================================
define('APP_NAME', 'Sinar Jaya Premium Bus Travel');
define('APP_VERSION', '1.0.0');
define('APP_AUTHOR', 'Sinar Jaya Development Team');
define('APP_EMAIL', 'support@sinarjaya.com');

// ================================================
// DATABASE CONFIGURATION
// ================================================
// IMPORTANT: Change these credentials for production
define('DB_HOST', 'localhost');
define('DB_NAME', 'your_database_name');
define('DB_USER', 'your_database_user');
define('DB_PASS', 'your_strong_password');

// Database charset (recommended: utf8mb4)
define('DB_CHARSET', 'utf8mb4');
define('DB_COLLATION', 'utf8mb4_unicode_ci');

// ================================================
// SESSION CONFIGURATION
// ================================================
define('SESSION_PREFIX', 'sinarjaya_');
define('SESSION_LIFETIME', 7200); // 2 hours in seconds
define('SESSION_COOKIE_SECURE', true); // Set true if using HTTPS
define('SESSION_COOKIE_HTTPONLY', true);
define('SESSION_COOKIE_SAMESITE', 'Strict');

// ================================================
// SECURITY CONFIGURATION
// ================================================
define('HASH_COST', 12); // For password hashing (higher = more secure but slower)
define('MIN_PASSWORD_LENGTH', 8);
define('MAX_LOGIN_ATTEMPTS', 5);
define('LOGIN_TIMEOUT', 900); // 15 minutes

// CSRF Protection (Future implementation)
define('CSRF_TOKEN_LENGTH', 32);

// ================================================
// TICKET & BOOKING CONFIGURATION
// ================================================
define('MAX_BOOKING_DAYS', 30); // Maximum days in advance for booking
define('RESERVATION_TIMEOUT', 20); // Minutes until unpaid reservation expires
define('MAX_PASSENGERS_PER_BOOKING', 10);

// ================================================
// FILE UPLOAD CONFIGURATION
// ================================================
define('UPLOAD_PATH', __DIR__ . '/../../public/uploads/');
define('MAX_UPLOAD_SIZE', 2097152); // 2MB in bytes
define('ALLOWED_FILE_TYPES', ['image/jpeg', 'image/jpg', 'image/png', 'application/pdf']);

// ================================================
// MAINTENANCE MODE
// ================================================
define('MAINTENANCE_MODE', false);
define('MAINTENANCE_ALLOWED_IPS', ['127.0.0.1', '::1']); // IPs allowed during maintenance

// ================================================
// EMAIL CONFIGURATION (SMTP)
// ================================================
// IMPORTANT: Update with your email credentials
define('MAIL_DRIVER', 'smtp');
define('MAIL_HOST', 'smtp.gmail.com'); // or your mail server
define('MAIL_PORT', 587);
define('MAIL_USERNAME', 'your-email@gmail.com');
define('MAIL_PASSWORD', 'your-app-password'); // Use App Password for Gmail
define('MAIL_FROM_ADDRESS', 'noreply@yourdomain.com');
define('MAIL_FROM_NAME', APP_NAME);
define('MAIL_ENCRYPTION', 'tls');

// Note: For Gmail, use App Password
// Generate at: https://myaccount.google.com/apppasswords

// ================================================
// PAYMENT GATEWAY CONFIGURATION (Future)
// ================================================
// define('MIDTRANS_SERVER_KEY', 'your-server-key');
// define('MIDTRANS_CLIENT_KEY', 'your-client-key');
// define('MIDTRANS_IS_PRODUCTION', true);

// ================================================
// API KEYS (if needed)
// ================================================
// define('GOOGLE_MAPS_API_KEY', 'your-api-key');
// define('WHATSAPP_API_KEY', 'your-api-key');

// ================================================
// LOGGING CONFIGURATION
// ================================================
define('LOG_PATH', __DIR__ . '/../../logs/');
define('LOG_LEVEL', ENVIRONMENT === 'production' ? 'error' : 'debug');

// ================================================
// CACHE CONFIGURATION (Future)
// ================================================
define('CACHE_ENABLED', true);
define('CACHE_LIFETIME', 3600); // 1 hour

// ================================================
// RATE LIMITING (Future)
// ================================================
define('RATE_LIMIT_ENABLED', true);
define('RATE_LIMIT_REQUESTS', 100); // requests per window
define('RATE_LIMIT_WINDOW', 3600); // 1 hour

// ================================================
// TIMEZONE & LOCALE
// ================================================
define('APP_TIMEZONE', 'Asia/Jakarta');
define('APP_LOCALE', 'id_ID');
define('APP_CURRENCY', 'IDR');

// ================================================
// DEBUG MODE (Development only)
// ================================================
define('DEBUG_MODE', ENVIRONMENT !== 'production');
