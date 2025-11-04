<?php

/**
 * Header template
 * @var string $pageTitle - Title of the current page
 */
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? $pageTitle : 'Sinar Jaya Premium Bus Travel' ?></title>
    <base href="<?= BASEURL ?>">
    <link rel="stylesheet" href="/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>
    <header class="main-header">
        <div class="logo">
            <a href="<?= BASEURL ?>" class="logo-text">Sinar Jaya</a>
            <span class="logo-tagline">Premium Travel</span>
        </div>
        <nav class="auth-nav">
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="/dashboard" class="nav-link">Dashboard</a>
                <a href="/auth/logout" class="nav-link signin">Logout</a>
            <?php else: ?>
                <a href="/auth/login" class="nav-link signin">Sign In</a>
                <a href="/auth/register" class="nav-link signup">Sign Up</a>
            <?php endif; ?>
        </nav>
    </header>