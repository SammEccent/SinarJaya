<style>
    .auth-wrapper {
        background-color: var(--light-color);
        min-height: calc(100vh - 80px);
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

    .alert-info {
        background-color: #dbeafe;
        color: #1e40af;
        border: 1px solid #bfdbfe;
    }

    .info-box {
        background-color: #f0f9ff;
        border-left: 4px solid #2563eb;
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 4px;
    }

    .info-box p {
        margin: 0;
        font-size: 0.9rem;
        color: #1e40af;
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
                    <h2>📧 Kirim Ulang Email Verifikasi</h2>
                    <p>Belum menerima email verifikasi? Kirim ulang ke email Anda</p>
                </div>

                <div class="card-body">
                    <?php if (isset($_SESSION['error'])) : ?>
                        <div class="alert alert-danger">
                            <?= htmlspecialchars($_SESSION['error']) ?>
                            <?php unset($_SESSION['error']); ?>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['success'])) : ?>
                        <div class="alert alert-success">
                            <?= htmlspecialchars($_SESSION['success']) ?>
                            <?php unset($_SESSION['success']); ?>
                        </div>
                    <?php endif; ?>

                    <div class="info-box">
                        <p><strong>ℹ️ Informasi:</strong> Masukkan email yang Anda gunakan saat mendaftar. Kami akan mengirimkan link verifikasi baru ke email tersebut.</p>
                    </div>

                    <form action="<?= BASEURL ?>auth/resendVerification" method="POST" class="auth-form">
                        <div class="form-group mb-3">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" placeholder="Masukkan email Anda" required autofocus>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-paper-plane"></i> Kirim Ulang Email Verifikasi
                        </button>

                        <div class="auth-footer">
                            Sudah verifikasi? <a href="<?= BASEURL ?>auth/login">Login di sini</a>
                            <br>
                            <small class="text-muted">atau</small>
                            <br>
                            Belum punya akun? <a href="<?= BASEURL ?>auth/register">Daftar sekarang</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Auto-hide alerts after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            }, 5000);
        });
    });
</script>