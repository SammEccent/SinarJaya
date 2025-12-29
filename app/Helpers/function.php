<?php

/**
 * Helper functions for the application
 */

if (!function_exists('config')) {
    /**
     * Get configuration value
     */
    function config(string $key, $default = null)
    {
        return \App\Core\Config::get($key, $default);
    }
}

if (!function_exists('env')) {
    /**
     * Get environment variable
     */
    function env(string $key, $default = null)
    {
        return \App\Core\Config::env($key, $default);
    }
}

if (!function_exists('session')) {
    /**
     * Get session instance or value
     */
    function session(?string $key = null, $default = null)
    {
        $session = \App\Core\Session::getInstance();

        if ($key === null) {
            return $session;
        }

        return $session->get($key, $default);
    }
}

if (!function_exists('redirect')) {
    /**
     * Redirect to URL
     */
    function redirect(string $url, int $statusCode = 302): void
    {
        header('Location: ' . $url, true, $statusCode);
        exit;
    }
}

if (!function_exists('back')) {
    /**
     * Redirect back to previous page
     */
    function back(): void
    {
        $referer = $_SERVER['HTTP_REFERER'] ?? '/';
        redirect($referer);
    }
}

if (!function_exists('url')) {
    /**
     * Generate URL
     */
    function url(string $path = ''): string
    {
        $baseUrl = config('app.base_url', 'http://localhost');

        if ($path && $path[0] !== '/') {
            $path = '/' . $path;
        }

        return $baseUrl . $path;
    }
}

if (!function_exists('asset')) {
    /**
     * Generate asset URL
     */
    function asset(string $path): string
    {
        return url('assets/' . ltrim($path, '/'));
    }
}

if (!function_exists('csrf_token')) {
    /**
     * Generate CSRF token
     */
    function csrf_token(): string
    {
        if (!session()->has('_csrf_token')) {
            session()->set('_csrf_token', bin2hex(random_bytes(32)));
        }

        return session()->get('_csrf_token');
    }
}

if (!function_exists('csrf_field')) {
    /**
     * Generate CSRF hidden input field
     */
    function csrf_field(): string
    {
        return '<input type="hidden" name="_token" value="' . csrf_token() . '">';
    }
}

if (!function_exists('method_field')) {
    /**
     * Generate method spoofing field
     */
    function method_field(string $method): string
    {
        return '<input type="hidden" name="_method" value="' . strtoupper($method) . '">';
    }
}

if (!function_exists('old')) {
    /**
     * Get old form input value
     */
    function old(string $key, $default = null)
    {
        return session()->getOldInput($key, $default);
    }
}

if (!function_exists('has_error')) {
    /**
     * Check if field has validation error
     */
    function has_error(string $field): bool
    {
        return !empty(session()->getErrors($field));
    }
}

if (!function_exists('error')) {
    /**
     * Get first error for field
     */
    function error(string $field): ?string
    {
        $errors = session()->getErrors($field);
        return $errors[0] ?? null;
    }
}

if (!function_exists('flash')) {
    /**
     * Get or set flash message
     */
    function flash(?string $key = null, ?string $message = null)
    {
        if ($key === null && $message === null) {
            // Get all flash messages
            $messages = [];
            foreach (session()->all() as $sessionKey => $value) {
                if (strpos($sessionKey, '_flash.') === 0) {
                    $type = substr($sessionKey, 6);
                    $messages[$type] = $value;
                }
            }
            return $messages;
        }

        if ($message === null) {
            // Get flash message
            return session()->getFlash($key);
        }

        // Set flash message
        session()->setFlash($key, $message);
        return null;
    }
}

if (!function_exists('dd')) {
    /**
     * Dump and die (for debugging)
     */
    function dd(...$vars): void
    {
        foreach ($vars as $var) {
            echo '<pre>';
            var_dump($var);
            echo '</pre>';
        }
        die();
    }
}

if (!function_exists('abort')) {
    /**
     * Abort with HTTP error code
     */
    function abort(int $code = 404, string $message = ''): void
    {
        http_response_code($code);

        $errorFile = APP_PATH . "/Views/errors/{$code}.php";

        if (file_exists($errorFile)) {
            include $errorFile;
        } else {
            echo "<h1>HTTP {$code}</h1>";
            if ($message) {
                echo "<p>{$message}</p>";
            }
        }

        exit;
    }
}

if (!function_exists('auth')) {
    /**
     * Get auth information
     */
    function auth(?string $key = null)
    {
        if (!session()->has('user_id')) {
            return null;
        }

        if ($key === null) {
            return [
                'id' => session()->get('user_id'),
                'name' => session()->get('user_name'),
                'email' => session()->get('user_email'),
                'role' => session()->get('user_role')
            ];
        }

        return session()->get('user_' . $key);
    }
}

if (!function_exists('is_authenticated')) {
    /**
     * Check if user is authenticated
     */
    function is_authenticated(): bool
    {
        return session()->has('user_id');
    }
}

if (!function_exists('is_admin')) {
    /**
     * Check if user is admin
     */
    function is_admin(): bool
    {
        return session()->get('user_role') === 'admin';
    }
}

if (!function_exists('format_currency')) {
    /**
     * Format currency (Indonesian Rupiah)
     */
    function format_currency(float $amount): string
    {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }
}

if (!function_exists('format_date')) {
    /**
     * Format date
     */
    function format_date(string $date, string $format = 'd M Y'): string
    {
        return date($format, strtotime($date));
    }
}

if (!function_exists('format_datetime')) {
    /**
     * Format datetime
     */
    function format_datetime(string $datetime, string $format = 'd M Y H:i'): string
    {
        return date($format, strtotime($datetime));
    }
}

if (!function_exists('sanitize')) {
    /**
     * Sanitize input
     */
    function sanitize(string $input): string
    {
        return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
    }
}
