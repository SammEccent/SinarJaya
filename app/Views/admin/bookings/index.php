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
                                <td><strong><?php echo htmlspecialchars($b['booking_code']); ?></strong></td>
                                <td><?php echo htmlspecialchars($b['user_name']); ?><br><small><?php echo htmlspecialchars($b['user_email']); ?></small></td>
                                <td><?php echo htmlspecialchars($b['route_code']); ?><br><small><?php echo date('d-m-Y H:i', strtotime($b['departure_datetime'])); ?></small></td>
                                <td><?php echo date('d-m-Y H:i', strtotime($b['created_at'])); ?></td>
                                <td style="text-align: right;">Rp <?php echo number_format($b['total_amount'], 0, ',', '.'); ?></td>
                                <td>
                                    <?php
                                        $status_class = 'badge-secondary'; // Default
                                        if ($b['booking_status'] === 'confirmed') {
                                            $status_class = 'badge-success';
                                        } elseif ($b['booking_status'] === 'pending') {
                                            $status_class = 'badge-warning';
                                        } elseif ($b['booking_status'] === 'cancelled') {
                                            $status_class = 'badge-danger';
                                        } elseif ($b['booking_status'] === 'completed') {
                                            $status_class = 'badge-info';
                                        }
                                    ?>
                                    <span class="badge <?php echo $status_class; ?>">
                                        <?php echo ucfirst(htmlspecialchars($b['booking_status'])); ?>
                                    </span>
                                </td>
                                <td style="display:flex; gap:8px; white-space: nowrap;">
                                    <a href="<?php echo BASEURL; ?>admin/bookings/view/<?php echo $b['id']; ?>" class="btn btn-outline" style="padding: 6px 10px; font-size: 0.85rem;">Lihat</a>
                                    <a href="<?php echo BASEURL; ?>admin/bookings/edit/<?php echo $b['id']; ?>" class="btn btn-primary" style="padding: 6px 10px; font-size: 0.85rem;">Edit</a>
                                    <a href="<?php echo BASEURL; ?>admin/bookings/delete/<?php echo $b['id']; ?>" class="btn btn-danger" style="padding: 6px 10px; font-size: 0.85rem;" onclick="return confirm('Hapus pemesanan ini?')">Hapus</a>
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
        padding: 12px 15px;
        text-align: left;
        color: #374151;
        font-weight: 600;
        border-bottom: 2px solid #e5e7eb;
    }

    .data-table td {
        padding: 12px 15px;
        border-bottom: 1px solid #e5e7eb;
        color: #374151;
    }

    .data-table tbody tr:hover {
        background-color: #f9fafb;
    }

    @media (max-width: 768px) {
        .data-table {
            font-size: 0.9rem;
        }

        .data-table th,
        .data-table td {
            padding: 8px;
        }
    }
</style>