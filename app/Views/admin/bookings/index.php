<div class="admin-header">
    <div class="admin-title">
        <h1>Kelola Pemesanan</h1>
        <p>Daftar pemesanan tiket</p>
    </div>
</div>

<div class="admin-body">
    <div class="section">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
            <h2>Daftar Pemesanan</h2>
        </div>

        <?php if (!empty($bookings)): ?>
            <div style="overflow-x:auto;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Kode</th>
                            <th>Pemesan</th>
                            <th>Rute</th>
                            <th>Tanggal Pesan</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bookings as $b): ?>
                            <tr>
                                <td><?php echo $b['id']; ?></td>
                                <td><?php echo htmlspecialchars($b['booking_code']); ?></td>
                                <td><?php echo htmlspecialchars($b['user_name'] . ' <' . $b['user_email'] . '>'); ?></td>
                                <td><?php echo htmlspecialchars($b['route_code'] . ' (' . $b['departure_datetime'] . ')'); ?></td>
                                <td><?php echo htmlspecialchars($b['created_at']); ?></td>
                                <td>Rp <?php echo number_format($b['total_amount'], 0, ',', '.'); ?></td>
                                <td><?php echo htmlspecialchars(ucfirst($b['booking_status'])); ?></td>
                                <td style="display:flex; gap:8px;">
                                    <a href="<?php echo BASEURL; ?>admin/bookings/view/<?php echo $b['id']; ?>" class="btn btn-outline">Lihat</a>
                                    <a href="<?php echo BASEURL; ?>admin/bookings/edit/<?php echo $b['id']; ?>" class="btn btn-primary">Edit</a>
                                    <a href="<?php echo BASEURL; ?>admin/bookings/delete/<?php echo $b['id']; ?>" class="btn btn-danger" onclick="return confirm('Hapus pemesanan ini?')">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div style="text-align:center; padding:40px; background:#f9fafb; border-radius:10px; color:#6b7280;">
                <i class="fas fa-ticket-alt" style="font-size:2.5rem; margin-bottom:15px; display:block; opacity:0.5;"></i>
                <p style="font-size:1.1rem; margin-bottom:15px;">Belum ada pemesanan</p>
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
        padding: 12px;
        border-bottom: 1px solid #e5e7eb;
    }
</style>