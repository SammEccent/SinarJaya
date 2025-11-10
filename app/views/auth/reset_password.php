<?php defined('BASEURL') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atur Ulang Kata Sandi - Sinar Jaya</title>
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
            <main class="login-card" role="main" aria-labelledby="reset-heading">
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

                    <h1 id="reset-heading" class="login-title">Atur Ulang Kata Sandi</h1>
                    <p class="login-sub">Buat kata sandi baru yang kuat untuk akun Anda.</p>

                    <form action="<?= BASEURL ?>auth/processResetPassword" method="POST" class="login-form">
                        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

                        <label class="visually-hidden" for="new_password">Kata Sandi Baru</label>
                        <input id="new_password" name="new_password" class="login-input" type="password" placeholder="Kata Sandi Baru (min. 8 karakter)" required minlength="8">

                        <label class="visually-hidden" for="confirm_new_password">Konfirmasi Kata Sandi Baru</label>
                        <input id="confirm_new_password" name="confirm_new_password" class="login-input" type="password" placeholder="Konfirmasi Kata Sandi Baru" required>

                        <button type="submit" class="btn btn-login">Simpan Kata Sandi Baru</button>
                    </form>
                </div>
                <div class="card-accent" aria-hidden="true"></div>
            </main>
        </div>
    </div>
</body>

</html>