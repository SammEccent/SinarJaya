<div class="admin-header">
    <div class="admin-title">
        <h1>Kelola Lokasi Rute</h1>
        <p>Rute: <?php echo htmlspecialchars($route['origin_city'] . ' - ' . $route['destination_city']); ?></p>
    </div>
</div>

<div class="admin-body">
    <div class="section">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2>Daftar Lokasi</h2>
            <a href="<?php echo BASEURL; ?>admin/routes" class="btn btn-outline">← Kembali</a>
        </div>

        <div style="background: #f0f9ff; border: 1px solid #0284c7; padding: 15px; border-radius: 6px; margin-bottom: 30px; color: #0c4a6e;">
            <i class="fas fa-info-circle" style="margin-right: 8px;"></i>
            <strong>Informasi:</strong> Tambahkan lokasi penjemputan dan pemberhentian sesuai urutan perjalanan. Gunakan field sequence untuk menentukan urutan lokasi.
        </div>

        <?php if (!empty($route_locations)): ?>
            <div style="overflow-x: auto;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Lokasi</th>
                            <th>Kota</th>
                            <th>Tipe</th>
                            <th>Fungsi</th>
                            <th>Sequence</th>
                            <th style="width: 100px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        foreach ($route_locations as $loc): ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><strong><?php echo htmlspecialchars($loc['location_name']); ?></strong></td>
                                <td><?php echo htmlspecialchars($loc['city']); ?></td>
                                <td>
                                    <span style="padding: 4px 8px; border-radius: 4px; font-size: 0.8rem; font-weight: 500;
                                    <?php
                                    if ($loc['type'] === 'POOL') {
                                        echo 'background: #ddd6fe; color: #4c1d95;';
                                    } elseif ($loc['type'] === 'TERMINAL') {
                                        echo 'background: #dcfce7; color: #15803d;';
                                    } elseif ($loc['type'] === 'AGEN') {
                                        echo 'background: #fef3c7; color: #92400e;';
                                    } else {
                                        echo 'background: #f5f3ff; color: #6b21a8;';
                                    }
                                    ?>
                                    "><?php echo htmlspecialchars($loc['type']); ?></span>
                                </td>
                                <td>
                                    <span style="padding: 4px 8px; border-radius: 4px; font-size: 0.8rem; font-weight: 500;
                                    <?php
                                    if ($loc['fungsi'] === 'BOARDING') {
                                        echo 'background: #ccfbf1; color: #134e4a;';
                                    } elseif ($loc['fungsi'] === 'DROP') {
                                        echo 'background: #fed7aa; color: #92400e;';
                                    } else {
                                        echo 'background: #c7d2fe; color: #1e1b4b;';
                                    }
                                    ?>
                                    "><?php echo htmlspecialchars($loc['fungsi']); ?></span>
                                </td>
                                <td><strong><?php echo $loc['sequence']; ?></strong></td>
                                <td>
                                    <a href="<?php echo BASEURL; ?>admin/routelocation/delete/<?php echo $loc['route_location_id']; ?>"
                                        class="btn btn-danger"
                                        style="padding: 6px 10px; font-size: 0.85rem;"
                                        onclick="return confirm('Hapus lokasi ini dari rute?')">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div style="text-align: center; padding: 40px; background: #f9fafb; border-radius: 10px; color: #6b7280; margin-bottom: 30px;">
                <i class="fas fa-map-marker-alt" style="font-size: 2.5rem; margin-bottom: 15px; display: block; opacity: 0.5;"></i>
                <p style="font-size: 1.1rem; margin-bottom: 15px;">Belum ada lokasi dalam rute ini</p>
                <p style="margin-bottom: 20px;">Tambahkan lokasi penjemputan dan pemberhentian untuk rute ini</p>
            </div>
        <?php endif; ?>

        <h3 style="margin-top: 30px; margin-bottom: 20px; color: #1f2937;">Tambah Lokasi Baru</h3>
        <form method="POST" style="display: grid; grid-template-columns: 1fr 150px 150px 150px; gap: 15px; align-items: end;">
            <div>
                <label for="location_id" style="display: block; margin-bottom: 8px; font-weight: 500; color: #374151;">Pilih Lokasi <span style="color: #ef4444;">*</span></label>
                <select id="location_id" name="location_id" required
                    style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 0.9rem; box-sizing: border-box;">
                    <option value="">-- Pilih Lokasi --</option>
                    <?php foreach ($all_locations as $loc): ?>
                        <option value="<?php echo $loc['location_id']; ?>">
                            <?php echo htmlspecialchars($loc['location_name'] . ' (' . $loc['city'] . ')'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label for="fungsi" style="display: block; margin-bottom: 8px; font-weight: 500; color: #374151;">Fungsi <span style="color: #ef4444;">*</span></label>
                <select id="fungsi" name="fungsi" required
                    style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 0.9rem; box-sizing: border-box;">
                    <option value="BOTH">BOTH</option>
                    <option value="BOARDING">BOARDING</option>
                    <option value="DROP">DROP</option>
                </select>
            </div>

            <div>
                <label for="sequence" style="display: block; margin-bottom: 8px; font-weight: 500; color: #374151;">Urutan <span style="color: #ef4444;">*</span></label>
                <input type="number" id="sequence" name="sequence" required min="1"
                    value="<?php echo (int)count($route_locations) + 1; ?>"
                    style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 0.9rem; box-sizing: border-box;">
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 10px;">Tambah</button>
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

    .section h2 {
        margin-top: 0;
        margin-bottom: 20px;
        color: #1f2937;
        font-size: 1.3rem;
    }

    .section h3 {
        margin-bottom: 15px;
        color: #1f2937;
        font-size: 1.1rem;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
    }

    .data-table thead {
        background-color: #f3f4f6;
    }

    .data-table th {
        padding: 12px;
        text-align: left;
        font-weight: 600;
        color: #374151;
        border-bottom: 2px solid #e5e7eb;
    }

    .data-table td {
        padding: 12px;
        border-bottom: 1px solid #e5e7eb;
        color: #374151;
    }

    .data-table tbody tr:hover {
        background-color: #f9fafb;
    }

    .btn {
        padding: 8px 16px;
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

    .btn-danger {
        background-color: #ef4444;
        color: white;
    }

    .btn-danger:hover {
        background-color: #dc2626;
        box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
    }

    @media (max-width: 768px) {
        form {
            grid-template-columns: 1fr !important;
        }
    }
</style>