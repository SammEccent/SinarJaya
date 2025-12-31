<?php
// Set timezone to Asia/Jakarta (WIB)
date_default_timezone_set('Asia/Jakarta');

defined('BASEURL') or define('BASEURL', 'http://sinarjaya.test/');

// Environment Configuration
define('ENVIRONMENT', 'development'); // Change to 'production' on production server

// Application Configuration
define('APP_NAME', 'Sinar Jaya Premium Bus Travel');
define('APP_VERSION', '1.0.0');
define('APP_AUTHOR', 'Sinar Jaya Development Team');
define('APP_EMAIL', 'support@sinarjaya.com');

// Database Configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'sinarjaya_db');
define('DB_USER', 'root');
define('DB_PASS', '');

// Session Configuration
define('SESSION_PREFIX', 'sinarjaya_');

// Security Configuration
define('HASH_COST', 10); // For password hashing
define('MIN_PASSWORD_LENGTH', 8);

// Ticket Configuration
define('MAX_BOOKING_DAYS', 30); // Maximum days in advance for booking
define('RESERVATION_TIMEOUT', 15); // Minutes until unpaid reservation expires

// Maintenance Mode
define('MAINTENANCE_MODE', false);

// Email Configuration (SMTP)
define('MAIL_DRIVER', 'smtp'); // or 'sendmail' for local server
define('MAIL_HOST', 'smtp.gmail.com');
define('MAIL_PORT', 587);
define('MAIL_USERNAME', 'samirudin20160464@gmail.com'); // Change this
define('MAIL_PASSWORD', 'aoed hzah kkmc wuod'); // Change this - Use App Password for Gmail
define('MAIL_FROM_ADDRESS', 'noreply@sinarjaya.com');
define('MAIL_FROM_NAME', 'Sinar Jaya Bus');
define('MAIL_ENCRYPTION', 'tls');
// Note: For Gmail, use App Password (not regular password)
// How to get App Password: https://support.google.com/accounts/answer/185833
