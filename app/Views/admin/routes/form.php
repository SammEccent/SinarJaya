<div class="admin-header">
    <div class="admin-title">
        <h1><?php echo isset($route) ? 'Edit Rute' : 'Tambah Rute'; ?></h1>
        <p><?php echo isset($route) ? 'Perbarui informasi rute' : 'Buat rute perjalanan baru'; ?></p>
    </div>
</div>

<div class="admin-body">
    <div class="section" style="max-width: 600px;">
        <?php if (!empty($errors)): ?>
            <div style="background: #fee2e2; color: #991b1b; padding: 15px; border-radius: 6px; margin-bottom: 20px; border-left: 4px solid #ef4444;">
                <strong>Kesalahan:</strong>
                <ul style="margin: 10px 0 0 20px; padding: 0;">
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" style="display: flex; flex-direction: column; gap: 20px;">
            <div>
                <label for="origin_city" style="display: block; margin-bottom: 8px; font-weight: 500; color: #374151;">Kota Asal <span style="color: #ef4444;">*</span></label>
                <input type="text" id="origin_city" name="origin_city" required
                    value="<?php echo isset($route) ? htmlspecialchars($route['origin_city']) : (isset($old['origin_city']) ? htmlspecialchars($old['origin_city']) : ''); ?>"
                    style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 1rem; box-sizing: border-box;"
                    placeholder="Contoh: Yogyakarta">
            </div>

            <div>
                <label for="destination_city" style="display: block; margin-bottom: 8px; font-weight: 500; color: #374151;">Kota Tujuan <span style="color: #ef4444;">*</span></label>
                <input type="text" id="destination_city" name="destination_city" required
                    value="<?php echo isset($route) ? htmlspecialchars($route['destination_city']) : (isset($old['destination_city']) ? htmlspecialchars($old['destination_city']) : ''); ?>"
                    style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 1rem; box-sizing: border-box;"
                    placeholder="Contoh: Tangerang">
            </div>

            <div>
                <label for="route_code" style="display: block; margin-bottom: 8px; font-weight: 500; color: #374151;">Kode Rute <span style="color: #ef4444;">*</span></label>
                <input type="text" id="route_code" name="route_code" required
                    value="<?php echo isset($route) ? htmlspecialchars($route['route_code']) : (isset($old['route_code']) ? htmlspecialchars($old['route_code']) : ''); ?>"
                    style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 1rem; box-sizing: border-box;"
                    placeholder="Contoh: YK-TGR">
                <small style="color: #6b7280; margin-top: 4px; display: block;">Gunakan format singkat untuk identifikasi rute</small>
            </div>

            <div>
                <label for="status" style="display: block; margin-bottom: 8px; font-weight: 500; color: #374151;">Status</label>
                <select id="status" name="status"
                    style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 1rem; box-sizing: border-box;">
                    <option value="active" <?php echo (isset($route) && $route['status'] === 'active') || (!isset($route) && (!isset($old['status']) || $old['status'] === 'active')) ? 'selected' : ''; ?>>Aktif</option>
                    <option value="inactive" <?php echo (isset($route) && $route['status'] === 'inactive') || (isset($old['status']) && $old['status'] === 'inactive') ? 'selected' : ''; ?>>Tidak Aktif</option>
                </select>
            </div>

            <div style="display: flex; gap: 10px; margin-top: 20px;">
                <button type="submit" class="btn btn-primary" style="flex: 1;">
                    <?php echo isset($route) ? 'Update Rute' : 'Buat Rute'; ?>
                </button>
                <a href="<?php echo BASEURL; ?>admin/routes" class="btn btn-outline" style="flex: 1; text-align: center;">Batal</a>
            </div>
        </form>
    </div>
</div>

<style>
    .section {
        background-color: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .section h2 {
        margin-top: 0;
        margin-bottom: 20px;
        color: #1f2937;
        font-size: 1.3rem;
    }

    .btn {
        padding: 10px 16px;
        border-radius: 6px;
        text-decoration: none;
        display: inline-block;
        font-weight: 500;
        font-size: 0.9rem;
        cursor: pointer;
        border: none;
        transition: all 0.2s ease;
    }

    .btn-primary {
        background-color: #3b82f6;
        color: white;
    }

    .btn-primary:hover {
        background-color: #2563eb;
        box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3);
    }

    .btn-outline {
        background-color: white;
        color: #3b82f6;
        border: 1px solid #3b82f6;
    }

    .btn-outline:hover {
        background-color: #f0f9ff;
    }
</style>