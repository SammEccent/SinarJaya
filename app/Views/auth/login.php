<style>
    /* ============================================
   AUTH SPECIFIC STYLES
   ============================================ */
    .auth-wrapper {
        background-color: var(--light-color);
        min-height: calc(100vh - 80px);
        /* Menyesuaikan tinggi navbar */
        display: flex;
        align-items: center;
        padding: 40px 0;
    }

    .auth-card {
        background: white;
        max-width: 500px;
        width: 100%;
        margin: 0 auto;
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
    }

    .auth-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .auth-header h2 {
        margin-bottom: 10px;
        color: var(--primary-color);
    }

    .auth-header p {
        color: var(--text-light);
        font-size: 0.9rem;
    }

    .auth-form .form-group {
        margin-bottom: 20px;
    }

    .auth-form label {
        display: block;
        margin-bottom: 8px;
        color: #374151;
        font-weight: 600;
        font-size: 14px;
    }

    .auth-form input {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    .auth-form input:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        outline: none;
    }

    .btn-block {
        width: 100%;
        padding: 14px;
        font-weight: 600;
        margin-top: 10px;
    }

    .auth-footer {
        text-align: center;
        margin-top: 25px;
        font-size: 0.9rem;
        color: var(--text-light);
    }

    .alert {
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-size: 0.9rem;
    }

    .alert-danger {
        background-color: #fee2e2;
        color: var(--danger-color);
        border: 1px solid #fecaca;
    }

    .alert-success {
        background-color: #d1fae5;
        color: var(--success-color);
        border: 1px solid #a7f3d0;
    }

    .forgot-password {
        text-align: right;
        margin-top: -10px;
        margin-bottom: 20px;
    }

    .forgot-password a {
        color: var(--primary-color);
        font-size: 0.85rem;
        text-decoration: none;
    }

    .forgot-password a:hover {
        text-decoration: underline;
    }

    /* Responsif untuk Mobile */
    @media (max-width: 576px) {
        .auth-card {
            padding: 25px;
            margin: 0 15px;
        }
    }
</style>

<div class="auth-wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="auth-card">
                <div class="auth-header">
                    <h2>🚌 Login</h2>
                    <p>Masuk ke akun Sinar Jaya Anda</p>
                </div>

                <div class="card-body">
                    <?php if (isset($errors) && count($errors) > 0) : ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0" style="list-style: none; padding: 0; margin: 0;">
                                <?php foreach ($errors as $error) : ?>
                                    <li><?= $error ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['success'])) : ?>
                        <div class="alert alert-success">
                            <?= htmlspecialchars($_SESSION['success']) ?>
                            <?php unset($_SESSION['success']); ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?= BASEURL ?>auth/login" method="POST" class="auth-form">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                placeholder="contoh@email.com"
                                value="<?= isset($old['email']) ? $old['email'] : '' ?>"
                                required
                                autofocus>
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                placeholder="Masukkan password"
                                required>
                        </div>

                        <div class="forgot-password">
                            <a href="<?= BASEURL ?>auth/resendVerificationForm">Belum terverifikasi?</a>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-sign-in-alt"></i> Masuk
                        </button>

                        <div class="auth-footer">
                            Belum punya akun? <a href="<?= BASEURL ?>auth/register">Daftar di sini</a>
                            <br><br>
                            <small class="text-muted">Login sebagai admin? <a href="<?= BASEURL ?>admin">Klik di sini</a></small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>