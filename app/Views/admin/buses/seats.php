<div class="admin-header">
    <div class="admin-title">
        <h1>Kelola Kursi - <?php echo htmlspecialchars($bus['plate_number']); ?></h1>
        <p>Atur dan kelola kursi di bus ini</p>
    </div>
</div>

<div class="admin-body">
    <!-- Bus Info Card -->
    <div class="section" style="margin-bottom: 20px;">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div>
                <p style="color: #6b7280; margin: 0 0 5px 0; font-size: 0.9rem;">Plat Nomor</p>
                <h3 style="margin: 0; color: #1f2937;"><?php echo htmlspecialchars($bus['plate_number']); ?></h3>
            </div>
            <div>
                <p style="color: #6b7280; margin: 0 0 5px 0; font-size: 0.9rem;">Tata Letak</p>
                <h3 style="margin: 0; color: #1f2937;"><?php echo htmlspecialchars($bus['seat_layout']); ?></h3>
            </div>
            <div>
                <p style="color: #6b7280; margin: 0 0 5px 0; font-size: 0.9rem;">Total Kursi</p>
                <h3 style="margin: 0; color: #1f2937;"><?php echo htmlspecialchars($bus['total_seats']); ?> Kursi</h3>
            </div>
            <div>
                <p style="color: #6b7280; margin: 0 0 5px 0; font-size: 0.9rem;">Kursi Terdaftar</p>
                <h3 style="margin: 0; color: #10b981;"><?php echo count($seats ?? []); ?> Kursi</h3>
            </div>
        </div>
    </div>

    <!-- Add Seat Form -->
    <div class="section" style="margin-bottom: 20px;">
        <h2 style="margin-top: 0; color: #1f2937;">Tambah Kursi Baru</h2>
        <form action="<?php echo BASEURL; ?>admin/buses/<?php echo $bus['id']; ?>/seats" method="POST" style="display: grid; grid-template-columns: 1fr 1fr 1fr auto; gap: 12px; align-items: flex-end;">
            <div>
                <label for="seat_number" style="display: block; font-weight: 600; margin-bottom: 8px; color: #1f2937;">Nomor Kursi</label>
                <input type="text" id="seat_number" name="seat_number" placeholder="Contoh: A1, B5" required style="width: 100%; padding: 10px 12px; border: 1px solid #e5e7eb; border-radius: 6px; font-size: 1rem;" />
            </div>
            <div>
                <label for="seat_type" style="display: block; font-weight: 600; margin-bottom: 8px; color: #1f2937;">Tipe Kursi</label>
                <select name="seat_type" id="seat_type" style="width: 100%; padding: 10px 12px; border: 1px solid #e5e7eb; border-radius: 6px; font-size: 1rem;">
                    <option value="Reclining seat premium">Reclining seat premium</option>
                    <option value="Sleeper seat">Sleeper seat</option>
                </select>
            </div>
            <div>
                <label for="price_adjustment" style="display: block; font-weight: 600; margin-bottom: 8px; color: #1f2937;">Harga Tambahan</label>
                <input type="number" id="price_adjustment" name="price_adjustment" placeholder="0" step="1000" min="0" style="width: 100%; padding: 10px 12px; border: 1px solid #e5e7eb; border-radius: 6px; font-size: 1rem;" />
            </div>
            <button type="submit" class="btn btn-primary" style="padding: 10px 20px;">
                <i class="fas fa-plus"></i> Tambah
            </button>
        </form>
    </div>

    <!-- Seats List -->
    <div class="section">
        <h2 style="margin-top: 0; color: #1f2937;">Daftar Kursi</h2>

        <?php if (!empty($seats)): ?>
            <div style="overflow-x: auto;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Nomor Kursi</th>
                            <th>Tipe</th>
                            <th>Harga Tambahan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($seats as $seat): ?>
                            <tr>
                                <td><strong><?php echo htmlspecialchars($seat['seat_number']); ?></strong></td>
                                <td>
                                    <?php
                                    $stype = $seat['seat_type'] ?? '';
                                    $styleBg = '#e0e7ff';
                                    $styleColor = '#2563eb';
                                    $label = htmlspecialchars($stype);
                                    if (stripos($stype, 'reclining') !== false) {
                                        $styleBg = '#fef3c7';
                                        $styleColor = '#92400e';
                                        $label = 'Reclining Seat Premium';
                                    } elseif (stripos($stype, 'sleeper') !== false) {
                                        $styleBg = '#dbeafe';
                                        $styleColor = '#1e40af';
                                        $label = 'Sleeper Seat';
                                    }
                                    ?>
                                    <span style="padding: 4px 8px; border-radius: 4px; font-size: 0.85rem; font-weight: 500; background: <?php echo $styleBg; ?>; color: <?php echo $styleColor; ?>; "><?php echo $label; ?></span>
                                </td>
                                <td>
                                    <?php if (!empty($seat['price_adjustment']) && $seat['price_adjustment'] > 0): ?>
                                        <span style="color: #10b981; font-weight: 600;">+ Rp<?php echo number_format($seat['price_adjustment'], 0, ',', '.'); ?></span>
                                    <?php else: ?>
                                        <span style="color: #6b7280;">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($seat['status'] === 'available'): ?>
                                        <span style="padding: 4px 8px; background: #d1fae5; color: #065f46; border-radius: 4px; font-weight: 500; font-size: 0.85rem;">Tersedia</span>
                                    <?php elseif ($seat['status'] === 'booked'): ?>
                                        <span style="padding: 4px 8px; background: #fee2e2; color: #991b1b; border-radius: 4px; font-weight: 500; font-size: 0.85rem;">Dipesan</span>
                                    <?php else: ?>
                                        <span style="padding: 4px 8px; background: #f3f4f6; color: #6b7280; border-radius: 4px; font-weight: 500; font-size: 0.85rem;">Maintenance</span>
                                    <?php endif; ?>
                                </td>
                                <td style="display: flex; gap: 8px;">
                                    <a href="<?php echo BASEURL; ?>admin/seat/<?php echo $seat['id']; ?>/toggle" class="btn btn-outline" style="padding: 6px 12px; font-size: 0.85rem;">
                                        <i class="fas fa-exchange-alt"></i> Ubah
                                    </a>
                                    <a href="<?php echo BASEURL; ?>admin/seat/<?php echo $seat['id']; ?>/delete" class="btn btn-danger" style="padding: 6px 12px; font-size: 0.85rem;" onclick="return confirm('Hapus kursi ini?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div style="text-align: center; padding: 40px; background: #f9fafb; border-radius: 10px; color: #6b7280;">
                <i class="fas fa-chair" style="font-size: 2.5rem; margin-bottom: 15px; display: block; opacity: 0.5;"></i>
                <p style="font-size: 1.1rem; margin-bottom: 15px;">Belum ada kursi</p>
                <p style="margin-bottom: 20px;">Mulai dengan menambahkan kursi pertama</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Back Button -->
    <div style="margin-top: 20px;">
        <a href="<?php echo BASEURL; ?>admin/buses" class="btn" style="padding: 10px 20px; background: #f3f4f6; color: #374151; border: 1px solid #e5e7eb;">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Bus
        </a>
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
        color: #374151;
        font-weight: 600;
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

    form select {
        transition: all 0.3s ease;
    }

    form select:focus {
        outline: none;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    @media (max-width: 768px) {
        form {
            grid-template-columns: 1fr !important;
        }

        .data-table {
            font-size: 0.9rem;
        }

        .data-table th,
        .data-table td {
            padding: 8px;
        }
    }
</style>