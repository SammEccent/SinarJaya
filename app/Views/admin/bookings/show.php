<div class="admin-header">
    <div class="admin-title">
        <h1>Detail Pemesanan</h1>
        <p>Informasi lengkap pemesanan</p>
    </div>
</div>

<div class="admin-body">
    <div class="section" style="max-width:900px;">
        <?php if (empty($booking)): ?>
            <p>Data tidak ditemukan.</p>
        <?php else: ?>
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
                <h2><?php echo htmlspecialchars($booking['booking_code']); ?></h2>
                <div>
                    <a href="<?php echo BASEURL; ?>admin/bookings" class="btn btn-outline">Kembali</a>
                </div>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:20px;">
                <div>
                    <h3>Informasi Pemesan</h3>
                    <p><strong>Nama:</strong> <?php echo htmlspecialchars($booking['user_name']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($booking['user_email']); ?></p>
                    <p><strong>Tanggal Pesan:</strong> <?php echo htmlspecialchars($booking['created_at']); ?></p>
                </div>
                <div>
                    <h3>Rincian</h3>
                    <p><strong>Rute:</strong> <?php echo htmlspecialchars($booking['route_code'] . ' - ' . $booking['origin_city'] . ' → ' . $booking['destination_city']); ?></p>
                    <p><strong>Jadwal:</strong> <?php echo htmlspecialchars($booking['departure_datetime'] . ' → ' . $booking['arrival_datetime']); ?></p>
                    <p><strong>Total Penumpang:</strong> <?php echo htmlspecialchars($booking['total_passengers']); ?></p>
                    <p><strong>Total Bayar:</strong> Rp <?php echo number_format($booking['total_amount'], 0, ',', '.'); ?></p>
                    <p><strong>Status:</strong> <?php echo htmlspecialchars($booking['booking_status']); ?></p>
                </div>
            </div>

            <div style="margin-bottom:20px;">
                <h3>Penumpang</h3>
                <?php if (!empty($booking['passengers'])): ?>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Seat</th>
                                <th>ID Card</th>
                                <th>Phone</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($booking['passengers'] as $i => $p): ?>
                                <tr>
                                    <td><?php echo $i + 1; ?></td>
                                    <td><?php echo htmlspecialchars($p['full_name']); ?></td>
                                    <td><?php echo htmlspecialchars($p['seat_id']); ?></td>
                                    <td><?php echo htmlspecialchars($p['id_card_number']); ?></td>
                                    <td><?php echo htmlspecialchars($p['phone']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>Tidak ada data penumpang.</p>
                <?php endif; ?>
            </div>

            <div>
                <h3>Pembayaran</h3>
                <?php if (!empty($booking['payment'])): ?>
                    <p><strong>Metode:</strong> <?php echo htmlspecialchars($booking['payment']['payment_method']); ?></p>
                    <p><strong>Jumlah:</strong> Rp <?php echo number_format($booking['payment']['amount'], 0, ',', '.'); ?></p>
                    <p><strong>Status:</strong> <?php echo htmlspecialchars($booking['payment']['payment_status']); ?></p>
                <?php else: ?>
                    <p>Belum ada pembayaran tercatat.</p>
                <?php endif; ?>
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