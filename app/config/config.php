<?php
defined('BASEURL') or define('BASEURL', 'http://aplikasi-pemesanan-tiket-bus-sinar-jaya.test/');

// Environment Configuration
define('ENVIRONMENT', 'development'); // Change to 'production' on production server

// Application Configuration
define('APP_NAME', 'Sinar Jaya Premium Bus Travel');
define('APP_VERSION', '1.0.0');
define('APP_AUTHOR', 'Sinar Jaya Development Team');
define('APP_EMAIL', 'support@sinarjaya.com');

// Database Configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'bus_ticket_db');
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
