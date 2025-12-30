<div class="admin-header">
    <div class="admin-title">
        <h1><?php echo !empty($bus) ? 'Edit Bus' : 'Tambah Bus Baru'; ?></h1>
        <p><?php echo !empty($bus) ? 'Perbarui informasi bus' : 'Tambahkan bus baru ke dalam sistem'; ?></p>
    </div>
</div>

<div class="admin-body">
    <div class="section" style="max-width: 600px;">
        <?php if (!empty($errors)): ?>
            <div style="background: #fee2e2; border: 1px solid #fecaca; color: #991b1b; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px;">
                <h3 style="margin-top: 0; margin-bottom: 8px; font-size: 1rem;">Terjadi Kesalahan</h3>
                <ul style="margin: 0; padding-left: 20px;">
                    <?php foreach ($errors as $err): ?>
                        <li><?php echo htmlspecialchars($err); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?php echo BASEURL; ?>admin/buses/<?php echo !empty($bus) ? 'edit/' . $bus['id'] : 'create'; ?>" method="POST">
            <div class="form-group" style="margin-bottom: 20px;">
                <label for="plate_number" style="display: block; font-weight: 600; margin-bottom: 8px; color: #1f2937;">Plat Nomor <span style="color: #ef4444;">*</span></label>
                <input type="text" id="plate_number" name="plate_number" value="<?php echo htmlspecialchars($old['plate_number'] ?? $bus['plate_number'] ?? ''); ?>" placeholder="Contoh: AB 1234 CD" required style="width: 100%; padding: 10px 12px; border: 1px solid #e5e7eb; border-radius: 6px; font-size: 1rem; font-family: inherit;" />
                <small style="color: #6b7280;">Format: AB 1234 CD (sesuai STNK)</small>
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label for="total_seats" style="display: block; font-weight: 600; margin-bottom: 8px; color: #1f2937;">Total Kursi <span style="color: #ef4444;">*</span></label>
                <input type="number" id="total_seats" name="total_seats" value="<?php echo htmlspecialchars($old['total_seats'] ?? $bus['total_seats'] ?? '45'); ?>" min="1" max="100" required style="width: 100%; padding: 10px 12px; border: 1px solid #e5e7eb; border-radius: 6px; font-size: 1rem; font-family: inherit;" />
                <small style="color: #6b7280;">Jumlah kursi yang tersedia di bus ini</small>
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label for="bus_class_id" style="display: block; font-weight: 600; margin-bottom: 8px; color: #1f2937;">Kelas Bus <span style="color: #ef4444;">*</span></label>
                <select id="bus_class_id" name="bus_class_id" required style="width: 100%; padding: 10px 12px; border: 1px solid #e5e7eb; border-radius: 6px; font-size: 1rem; font-family: inherit;">
                    <option value="">-- Pilih Kelas Bus --</option>
                    <option value="1" <?php echo (!empty($bus) && $bus['bus_class_id'] == 1) ? 'selected' : ''; ?>>Executive</option>
                    <option value="2" <?php echo (!empty($bus) && $bus['bus_class_id'] == 2) ? 'selected' : ''; ?>>Suite Class</option>
                </select>
                <small style="color: #6b7280;">Pilih klasifikasi kelas bus</small>
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label for="operator_id" style="display: block; font-weight: 600; margin-bottom: 8px; color: #1f2937;">Operator</label>
                <input type="number" id="operator_id" name="operator_id" value="<?php echo htmlspecialchars($old['operator_id'] ?? $bus['operator_id'] ?? ''); ?>" style="width: 100%; padding: 10px 12px; border: 1px solid #e5e7eb; border-radius: 6px; font-size: 1rem; font-family: inherit;" />
                <small style="color: #6b7280;">ID Operator bus (opsional)</small>
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label for="seat_layout" style="display: block; font-weight: 600; margin-bottom: 8px; color: #1f2937;">Tata Letak Kursi</label>
                <input type="text" id="seat_layout" name="seat_layout" value="<?php echo htmlspecialchars($old['seat_layout'] ?? $bus['seat_layout'] ?? '2-2'); ?>" placeholder="Contoh: 2-2 atau 3-3" style="width: 100%; padding: 10px 12px; border: 1px solid #e5e7eb; border-radius: 6px; font-size: 1rem; font-family: inherit;" />
                <small style="color: #6b7280;">Format kolom-kolom (contoh: 2-2 atau 3-3)</small>
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label for="facilities" style="display: block; font-weight: 600; margin-bottom: 8px; color: #1f2937;">Fasilitas</label>
                <textarea id="facilities" name="facilities" placeholder="Contoh: AC, WiFi, Kursi Recline, Toilet" style="width: 100%; padding: 10px 12px; border: 1px solid #e5e7eb; border-radius: 6px; font-size: 1rem; font-family: inherit; min-height: 80px; resize: vertical;"><?php echo htmlspecialchars($old['facilities'] ?? $bus['facilities'] ?? ''); ?></textarea>
                <small style="color: #6b7280;">Sebutkan fasilitas yang tersedia (pisahkan dengan koma)</small>
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label for="status" style="display: block; font-weight: 600; margin-bottom: 8px; color: #1f2937;">Status <span style="color: #ef4444;">*</span></label>
                <select id="status" name="status" required style="width: 100%; padding: 10px 12px; border: 1px solid #e5e7eb; border-radius: 6px; font-size: 1rem; font-family: inherit;">
                    <option value="">-- Pilih Status --</option>
                    <option value="active" <?php echo (!empty($bus) && $bus['status'] === 'active') ? 'selected' : ''; ?>>Aktif</option>
                    <option value="maintenance" <?php echo (!empty($bus) && $bus['status'] === 'maintenance') ? 'selected' : ''; ?>>Maintenance</option>
                    <option value="inactive" <?php echo (!empty($bus) && $bus['status'] === 'inactive') ? 'selected' : ''; ?>>Tidak Aktif</option>
                </select>
                <small style="color: #6b7280;">Status operasional bus</small>
            </div>

            <div style="display: flex; gap: 12px; justify-content: space-between; align-items: center;">
                <div style="display: flex; gap: 12px;">
                    <button type="submit" class="btn btn-primary" style="padding: 10px 24px;">
                        <i class="fas fa-save"></i> <?php echo !empty($bus) ? 'Perbarui' : 'Tambah'; ?> Bus
                    </button>
                    <a href="<?php echo BASEURL; ?>admin/buses" class="btn" style="padding: 10px 24px; background: #f3f4f6; color: #374151; border: 1px solid #e5e7eb;">Batal</a>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    .section {
        background-color: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .form-group input {
        transition: all 0.3s ease;
    }

    .form-group input:focus {
        outline: none;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    @media (max-width: 768px) {
        .section {
            max-width: 100% !important;
        }

        .form-group input {
            font-size: 16px;
        }
    }
</style>