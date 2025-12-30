<div class="admin-header">
    <div class="admin-title">
        <h1>Edit Pemesanan</h1>
        <p>Ubah status, catatan, dan kelola penumpang</p>
    </div>
</div>

<div class="admin-body">
    <div class="section" style="max-width:900px;">
        <?php if (empty($booking)): ?>
            <p>Data tidak ditemukan.</p>
        <?php else: ?>
            <form method="POST" style="margin-bottom:20px;">
                <h3>Update Pemesanan</h3>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                    <div>
                        <label>Status</label>
                        <select name="booking_status" style="width:100%; padding:8px;">
                            <option value="pending" <?php echo $booking['booking_status'] === 'pending' ? 'selected' : ''; ?>>Pending</option>
                            <option value="confirmed" <?php echo $booking['booking_status'] === 'confirmed' ? 'selected' : ''; ?>>Confirmed</option>
                            <option value="cancelled" <?php echo $booking['booking_status'] === 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                            <option value="expired" <?php echo $booking['booking_status'] === 'expired' ? 'selected' : ''; ?>>Expired</option>
                        </select>
                    </div>
                    <div>
                        <label>Booking Code</label>
                        <input type="text" value="<?php echo htmlspecialchars($booking['booking_code']); ?>" disabled style="width:100%; padding:8px;" />
                    </div>
                    <div style="grid-column:1 / -1;">
                        <label>Catatan</label>
                        <textarea name="notes" rows="3" style="width:100%; padding:8px;"><?php echo htmlspecialchars($booking['notes'] ?? ''); ?></textarea>
                    </div>
                </div>
                <div style="margin-top:12px; display:flex; gap:10px;">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="<?php echo BASEURL; ?>admin/bookings" class="btn btn-outline">Batal</a>
                </div>
            </form>

            <div style="margin-bottom:20px;">
                <h3>Penumpang</h3>
                <?php if (!empty($passengers)): ?>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Seat</th>
                                <th>Phone</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($passengers as $i => $p): ?>
                                <tr>
                                    <td><?php echo $i + 1; ?></td>
                                    <td><?php echo htmlspecialchars($p['full_name']); ?></td>
                                    <td><?php echo htmlspecialchars($p['seat_number'] ?? $p['seat_id']); ?></td>
                                    <td><?php echo htmlspecialchars($p['phone']); ?></td>
                                    <td>
                                        <a href="<?php echo BASEURL; ?>admin/bookings/deletepassenger/<?php echo $p['id']; ?>" class="btn btn-danger" onclick="return confirm('Hapus penumpang ini?')">Hapus</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>Tidak ada penumpang.</p>
                <?php endif; ?>
            </div>

            <div>
                <h3>Tambah Penumpang</h3>
                <form method="POST" action="<?php echo BASEURL; ?>admin/bookings/addpassenger/<?php echo $booking['id']; ?>" style="display:grid; grid-template-columns:1fr 1fr; gap:10px; align-items:end;">
                    <div>
                        <label>Nama Lengkap</label>
                        <input type="text" name="full_name" required style="width:100%; padding:8px;" />
                    </div>
                    <div>
                        <label>Nomor Kursi (seat_id)</label>
                        <input type="text" name="seat_id" style="width:100%; padding:8px;" />
                    </div>
                    <div>
                        <label>Tipe ID</label>
                        <select name="id_card_type" style="width:100%; padding:8px;">
                            <option value="ktp">KTP</option>
                            <option value="sim">SIM</option>
                            <option value="passport">Passport</option>
                        </select>
                    </div>
                    <div>
                        <label>Nomor ID</label>
                        <input type="text" name="id_card_number" style="width:100%; padding:8px;" />
                    </div>
                    <div>
                        <label>Telepon</label>
                        <input type="text" name="phone" style="width:100%; padding:8px;" />
                    </div>
                    <div>
                        <label>Catatan Khusus</label>
                        <input type="text" name="special_request" style="width:100%; padding:8px;" />
                    </div>
                    <div style="grid-column:1 / -1; display:flex; gap:10px;">
                        <button type="submit" class="btn btn-primary">Tambah Penumpang</button>
                        <a href="<?php echo BASEURL; ?>admin/bookings" class="btn btn-outline">Selesai</a>
                    </div>
                </form>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
    .section {
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
    }

    .data-table th,
    .data-table td {
        padding: 10px;
        border-bottom: 1px solid #e5e7eb;
    }
</style>