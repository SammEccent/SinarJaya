<?php

/**
 * Bootstrap file for the application
 * Can be used instead of complex index.php
 */

// Define base path
$basePath = dirname(__DIR__);

// Register autoloader
spl_autoload_register(function ($class) use ($basePath) {
    // Project-specific namespace
    $prefix = 'App\\';

    // Base directory for the namespace prefix
    $baseDir = $basePath . '/app/';

    // Does the class use the namespace prefix?
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        // No, move to the next registered autoloader
        return;
    }

    // Get the relative class name
    $relativeClass = substr($class, $len);

    // Replace the namespace prefix with the base directory,
    // replace namespace separators with directory separators
    // and append with .php
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    // If the file exists, require it
    if (file_exists($file)) {
        require $file;
    }
});

// Load helper functions
require $basePath . '/app/Helpers/functions.php';

// Return the base path for use in other files
return $basePath;
