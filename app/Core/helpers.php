<?php
defined('BASEURL') or exit('No direct script access allowed');

/**
 * Set flash message
 * @param string $name Message name/key
 * @param string $message Message content
 * @param string $type Message type (success, error, warning, info)
 * @return void
 */
function flash($name = '', $message = '', $type = 'info')
{
    if (!empty($name)) {
        if (!empty($message) && empty($_SESSION[$name])) {
            $_SESSION[$name] = $message;
            $_SESSION[$name . '_type'] = $type;
        } else if (empty($message) && !empty($_SESSION[$name])) {
            $flash_message = $_SESSION[$name];
            $flash_type = $_SESSION[$name . '_type'];
            unset($_SESSION[$name]);
            unset($_SESSION[$name . '_type']);
            return ['message' => $flash_message, 'type' => $flash_type];
        }
    }
    return null;
}

/**
 * Redirect to a specific URL
 * @param string $url URL to redirect to
 * @return void
 */
function redirect($url = '')
{
    header('Location: ' . BASEURL . $url);
    exit;
}

/**
 * Escape HTML entities in a string
 * @param string $string String to escape
 * @return string Escaped string
 */
function e($string)
{
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

/**
 * Get current URL
 * @return string Current URL
 */
function current_url()
{
    return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") .
        "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
}

/**
 * Format price to rupiah
 * @param float $price Price to format
 * @return string Formatted price
 */
function format_rupiah($price)
{
    return 'Rp ' . number_format($price, 0, ',', '.');
}

/**
 * Format date to Indonesian format
 * @param string $date Date to format (Y-m-d)
 * @return string Formatted date
 */
function format_tanggal($date)
{
    $bulan = [
        1 => 'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    ];

    $split = explode('-', $date);
    return $split[2] . ' ' . $bulan[(int)$split[1]] . ' ' . $split[0];
}
