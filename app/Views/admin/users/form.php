<div class="admin-header">
    <h1><?php echo isset($user) ? 'Edit Pengguna' : 'Tambah Pengguna'; ?></h1>
    <p><?php echo isset($user) ? 'Perbarui detail pengguna' : 'Buat akun pengguna baru'; ?></p>
</div>

<div class="admin-body">
    <div class="section">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
            <h2>Formulir Pengguna</h2>
            <a href="<?php echo BASEURL; ?>admin/users" class="btn btn-outline">← Kembali</a>
        </div>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?php echo isset($user) ? BASEURL . 'admin/users/edit/' . $user['id'] : BASEURL . 'admin/users/create'; ?>" method="POST">
            <div class="form-grid">
                <!-- Name -->
                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name'] ?? $old['name'] ?? ''); ?>" required>
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email'] ?? $old['email'] ?? ''); ?>" required>
                </div>

                <!-- Phone -->
                <div class="form-group">
                    <label for="phone">Telepon</label>
                    <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone'] ?? $old['phone'] ?? ''); ?>">
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" <?php echo isset($user) ? '' : 'required'; ?>>
                    <?php if (isset($user)): ?>
                        <small>Kosongkan jika tidak ingin mengubah password.</small>
                    <?php endif; ?>
                </div>

                <!-- Role -->
                <div class="form-group">
                    <label for="role">Role</label>
                    <select id="role" name="role">
                        <option value="user" <?php echo (isset($user['role']) && $user['role'] === 'user') || (isset($old['role']) && $old['role'] === 'user') ? 'selected' : ''; ?>>User</option>
                        <option value="admin" <?php echo (isset($user['role']) && $user['role'] === 'admin') || (isset($old['role']) && $old['role'] === 'admin') ? 'selected' : ''; ?>>Admin</option>
                    </select>
                </div>
                
                <!-- Is Verified -->
                <div class="form-group-checkbox">
                    <input type="checkbox" id="is_verified" name="is_verified" value="1" <?php echo (isset($user['is_verified']) && $user['is_verified']) || (isset($old['is_verified']) && $old['is_verified']) ? 'checked' : ''; ?>>
                    <label for="is_verified">Akun Terverifikasi</label>
                    <small>Centang jika status email pengguna sudah terverifikasi.</small>
                </div>

            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> <?php echo isset($user) ? 'Simpan Perubahan' : 'Buat Pengguna'; ?>
                </button>
            </div>
        </form>
    </div>
</div>

<style>
.section {
    background-color: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}
.form-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 20px;
}
@media (min-width: 768px) {
    .form-grid {
        grid-template-columns: 1fr 1fr;
        gap: 25px;
    }
}
.form-group {
    display: flex;
    flex-direction: column;
}
.form-group label, .form-group-checkbox label {
    font-weight: 600;
    color: #374151;
    margin-bottom: 8px;
}
.form-group input, .form-group select {
    width: 100%;
    padding: 12px;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    font-size: 1rem;
    transition: border-color 0.2s, box-shadow 0.2s;
}
.form-group input:focus, .form-group select:focus {
    outline: none;
    border-color: #1e40af;
    box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
}
.form-group small {
    margin-top: 6px;
    font-size: 0.85rem;
    color: #6b7280;
}
.form-group-checkbox {
    display: flex;
    align-items: center;
    grid-column: 1 / -1; /* Span full width */
    background: #f9fafb;
    padding: 15px;
    border-radius: 8px;
}
.form-group-checkbox input {
    width: auto;
    margin-right: 12px;
    height: 18px;
    width: 18px;
}
.form-group-checkbox label {
    margin-bottom: 0;
    cursor: pointer;
}
.form-group-checkbox small {
    margin-left: auto;
    padding-left: 20px;
}
.form-actions {
    margin-top: 30px;
    padding-top: 20px;
    border-top: 1px solid #e5e7eb;
    text-align: right;
}
.alert-danger {
    background-color: #fef2f2;
    color: #991b1b;
    padding: 15px;
    border-radius: 6px;
    border: 1px solid #fecaca;
    margin-bottom: 20px;
}
</style>
