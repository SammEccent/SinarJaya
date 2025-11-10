<?php defined('BASEURL') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sinar Jaya</title>
    <link rel="stylesheet" href="<?= BASEURL ?>css/style.css">
    <style>
        /* Ensure readable sans-serif for this page */
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
            <main class="login-card" role="main" aria-labelledby="login-heading">
                <div class="card-body">
                    <div class="login-brand">
                        <!-- Minimal inline logo (bus icon) -->
                        <svg width="36" height="36" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <rect x="1.5" y="6" width="21" height="10" rx="2" stroke="#0f4bd9" stroke-width="1.25" fill="#ffffff" />
                            <circle cx="7" cy="17" r="1" fill="#0f4bd9" />
                            <circle cx="17" cy="17" r="1" fill="#0f4bd9" />
                            <path d="M3 9h18" stroke="#0f4bd9" stroke-width="1" />
                        </svg>
                        <div class="brand-text">
                            <span class="brand-name">Sinar Jaya</span>
                            <small class="brand-tag">Premium Travel</small>
                        </div>
                    </div>

                    <h1 id="login-heading" class="login-title">Welcome back</h1>
                    <p class="login-sub">Sign in to continue to your account</p>

                    <form action="<?= BASEURL ?>auth/processLogin" method="POST" class="login-form" autocomplete="on">
                        <label class="visually-hidden" for="username">Email</label>
                        <input id="email" name="email" class="login-input" type="text" placeholder="Email" required autofocus>

                        <label class="visually-hidden" for="password">Password</label>
                        <input id="password" name="password" class="login-input" type="password" placeholder="Password" required>

                        <div class="form-row">
                            <label class="checkbox-inline"><input type="checkbox" name="remember"> Remember me</label>
                            <a class="forgot-link" href="<?= BASEURL ?>auth/forgotPassword">Forgot?</a>
                        </div>

                        <button type="submit" class="btn btn-login">Login</button>

                        <p class="signup-note">Don't have an account? <a href="<?= BASEURL ?>auth/register">Sign up</a></p>
                    </form>
                </div>
                <div class="card-accent" aria-hidden="true"></div>
            </main>
        </div>
    </div>

</body>

</html>