<?php
// Start session
session_start();

// Load configurations
require_once 'config/config.php';

// Load core classes
require_once 'Core/App.php';
require_once 'Core/Controller.php';
require_once 'Core/Database.php';

// Load helper functions
require_once 'Core/helpers.php';

// Error reporting based on environment
if (ENVIRONMENT === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}
