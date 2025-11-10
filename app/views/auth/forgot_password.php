<?php defined('BASEURL') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Kata Sandi - Sinar Jaya</title>
    <link rel="stylesheet" href="<?= BASEURL ?>css/style.css">
    <style>
        html,
        body {
            font-family: Inter, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif
        }

        .visually-hidden {
            position: absolute !important;
            height: 1px;
            width: 1px;
            overflow: hidden;
            clip: rect(1px, 1px, 1px, 1px);
            white-space: nowrap;
            border: 0;
            padding: 0;
            margin: -1px
        }
    </style>
</head>

<body>
    <div class="auth-split">
        <div class="auth-image-side" aria-hidden="true">
            <div class="image-overlay"></div>
        </div>

        <div class="auth-form-side">
            <main class="login-card" role="main" aria-labelledby="forgot-heading">
                <div class="card-body">
                    <div class="login-brand">
                        <svg width="36" height="36" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" style="color: var(--color-primary);">
                            <rect x="1.5" y="6" width="21" height="10" rx="2" stroke="currentColor" stroke-width="1.25" fill="none" />
                            <circle cx="7" cy="17" r="1" fill="currentColor" />
                            <circle cx="17" cy="17" r="1" fill="currentColor" />
                            <path d="M3 9h18" stroke="currentColor" stroke-width="1" />
                        </svg>
                        <div class="brand-text">
                            <span class="brand-name">Sinar Jaya</span>
                            <small class="brand-tag">Premium Travel</small>
                        </div>
                    </div>

                    <h1 id="forgot-heading" class="login-title">Lupa Kata Sandi?</h1>
                    <p class="login-sub">Masukkan email Anda dan kami akan mengirimkan tautan untuk mengatur ulang kata sandi Anda.</p>

                    <form action="<?= BASEURL ?>auth/processForgotPassword" method="POST" class="login-form">
                        <label class="visually-hidden" for="email">Alamat Email</label>
                        <input id="email" name="email" class="login-input" type="email" placeholder="Alamat Email" required autofocus>

                        <button type="submit" class="btn btn-login">Kirim Tautan Reset</button>

                        <p class="signup-note">Ingat kata sandi Anda? <a href="<?= BASEURL ?>auth/login">Masuk</a></p>
                    </form>
                </div>
                <div class="card-accent" aria-hidden="true"></div>
            </main>
        </div>
    </div>
</body>

</html>