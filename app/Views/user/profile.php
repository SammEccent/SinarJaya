c1<style>
    .profile-container {
        max-width: 900px;
        margin: 40px auto;
        padding: 0 20px;
    }

    .profile-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 40px;
        border-radius: 16px;
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        gap: 24px;
    }

    .profile-avatar {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 48px;
        font-weight: 700;
        border: 4px solid rgba(255, 255, 255, 0.3);
    }

    .profile-info h1 {
        margin: 0 0 8px 0;
        font-size: 28px;
        font-weight: 700;
    }

    .profile-info p {
        margin: 0;
        opacity: 0.9;
        font-size: 15px;
    }

    .profile-content {
        display: grid;
        gap: 24px;
    }

    .profile-section {
        background: white;
        border: 2px solid #e5e7eb;
        border-radius: 16px;
        overflow: hidden;
    }

    .section-header {
        padding: 24px;
        background: #f9fafb;
        border-bottom: 2px solid #e5e7eb;
    }

    .section-header h2 {
        margin: 0;
        font-size: 20px;
        font-weight: 700;
        color: #1f2937;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-header h2 i {
        color: #667eea;
    }

    .section-body {
        padding: 24px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group:last-child {
        margin-bottom: 0;
    }

    .form-label {
        display: block;
        font-weight: 600;
        margin-bottom: 8px;
        color: #1f2937;
        font-size: 14px;
    }

    .form-label .required {
        color: #ef4444;
    }

    .form-input {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        font-size: 15px;
        transition: all 0.3s ease;
        box-sizing: border-box;
    }

    .form-input:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .form-input:disabled {
        background: #f3f4f6;
        color: #6b7280;
        cursor: not-allowed;
    }

    textarea.form-input {
        min-height: 100px;
        resize: vertical;
    }

    .btn {
        padding: 12px 24px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }

    .btn-primary {
        background: #667eea;
        color: white;
    }

    .btn-primary:hover {
        background: #5568d3;
        transform: translateY(-1px);
    }

    .btn-secondary {
        background: white;
        color: #667eea;
        border: 2px solid #667eea;
    }

    .btn-secondary:hover {
        background: #f3f4f6;
    }

    .btn-danger {
        background: #ef4444;
        color: white;
    }

    .btn-danger:hover {
        background: #dc2626;
    }

    .alert {
        padding: 16px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .alert-success {
        background: #d1fae5;
        color: #065f46;
        border: 1px solid #10b981;
    }

    .alert-error {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #ef4444;
    }

    .alert ul {
        margin: 8px 0 0 0;
        padding-left: 20px;
    }

    .alert ul li {
        margin: 4px 0;
    }

    .form-actions {
        display: flex;
        gap: 12px;
        margin-top: 24px;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
    }

    .info-item {
        padding: 16px;
        background: #f9fafb;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
    }

    .info-label {
        font-size: 12px;
        color: #6b7280;
        text-transform: uppercase;
        font-weight: 600;
        margin-bottom: 6px;
    }

    .info-value {
        font-size: 16px;
        color: #1f2937;
        font-weight: 600;
    }

    @media (max-width: 768px) {
        .profile-header {
            flex-direction: column;
            text-align: center;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn {
            justify-content: center;
        }
    }
</style>

<div class="profile-container">
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> <?php echo $_SESSION['success'];
                                                unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i> <?php echo $_SESSION['error'];
                                                        unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['errors'])): ?>
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i> Terdapat beberapa kesalahan:
            <ul>
                <?php foreach ($_SESSION['errors'] as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
            <?php unset($_SESSION['errors']); ?>
        </div>
    <?php endif; ?>

    <div class="profile-header">
        <div class="profile-avatar">
            <?php echo strtoupper(substr($user['name'], 0, 1)); ?>
        </div>
        <div class="profile-info">
            <h1><?php echo htmlspecialchars($user['name']); ?></h1>
            <p><i class="fas fa-envelope"></i> <?php echo htmlspecialchars($user['email']); ?></p>
            <p><i class="fas fa-phone"></i> <?php echo htmlspecialchars($user['phone'] ?? '-'); ?></p>
        </div>
    </div>

    <div class="profile-content">
        <!-- Account Information -->
        <div class="profile-section">
            <div class="section-header">
                <h2><i class="fas fa-user"></i> Informasi Akun</h2>
            </div>
            <div class="section-body">
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Status Akun</div>
                        <div class="info-value">
                            <?php
                            if (isset($user['is_verified']) && $user['is_verified']) {
                                echo '<span style="color: #10b981;"><i class="fas fa-check-circle"></i> Terverifikasi</span>';
                            } else {
                                echo '<span style="color: #f59e0b;"><i class="fas fa-exclamation-circle"></i> Belum Terverifikasi</span>';
                            }
                            ?>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Tipe Akun</div>
                        <div class="info-value">
                            <?php
                            $roleLabels = [
                                'admin' => '<span style="color: #8b5cf6;"><i class="fas fa-crown"></i> Administrator</span>',
                                'user' => '<span style="color: #667eea;"><i class="fas fa-user"></i> Penumpang</span>'
                            ];
                            echo $roleLabels[$user['role']] ?? 'User';
                            ?>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Terdaftar Sejak</div>
                        <div class="info-value">
                            <?php echo date('d M Y', strtotime($user['created_at'])); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Profile Form -->
        <div class="profile-section">
            <div class="section-header">
                <h2><i class="fas fa-edit"></i> Edit Profil</h2>
            </div>
            <div class="section-body">
                <form action="<?php echo BASEURL; ?>user/updateProfile" method="POST">
                    <div class="form-group">
                        <label class="form-label">
                            Nama Lengkap <span class="required">*</span>
                        </label>
                        <input type="text" name="name" class="form-input"
                            value="<?php echo htmlspecialchars($_SESSION['old']['name'] ?? $user['name']); ?>"
                            required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Email <span class="required">*</span>
                        </label>
                        <input type="email" name="email" class="form-input"
                            value="<?php echo htmlspecialchars($_SESSION['old']['email'] ?? $user['email']); ?>"
                            required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            No HP <span class="required">*</span>
                        </label>
                        <input type="tel" name="phone" class="form-input"
                            value="<?php echo htmlspecialchars($_SESSION['old']['phone'] ?? $user['phone']); ?>"
                            required>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                        <a href="<?php echo BASEURL; ?>user/bookings" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Change Password Form -->
        <div class="profile-section">
            <div class="section-header">
                <h2><i class="fas fa-lock"></i> Ubah Password</h2>
            </div>
            <div class="section-body">
                <form action="<?php echo BASEURL; ?>user/changePassword" method="POST">
                    <div class="form-group">
                        <label class="form-label">
                            Password Saat Ini <span class="required">*</span>
                        </label>
                        <input type="password" name="current_password" class="form-input"
                            placeholder="Masukkan password saat ini" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Password Baru <span class="required">*</span>
                        </label>
                        <input type="password" name="new_password" class="form-input"
                            placeholder="Masukkan password baru (min. 6 karakter)" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Konfirmasi Password Baru <span class="required">*</span>
                        </label>
                        <input type="password" name="confirm_password" class="form-input"
                            placeholder="Ulangi password baru" required>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-key"></i> Ubah Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php unset($_SESSION['old']); ?>