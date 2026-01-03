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
                <?php if (!empty($passengers) && is_array($passengers)): ?>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Nomor Kursi</th>
                                <th>No. ID Card</th>
                                <th>Telepon</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($passengers as $i => $p): ?>
                                <tr>
                                    <td><?php echo $i + 1; ?></td>
                                    <td><?php echo htmlspecialchars($p['full_name'] ?? '-'); ?></td>
                                    <td><?php echo htmlspecialchars($p['seat_number'] ?? '-'); ?></td>
                                    <td><?php echo htmlspecialchars($p['id_card_number'] ?? '-'); ?></td>
                                    <td><?php echo htmlspecialchars($p['phone'] ?? '-'); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p style="padding: 15px; background: #f3f4f6; border-radius: 6px; color: #6b7280;">Tidak ada data penumpang.</p>
                <?php endif; ?>
            </div>

            <div>
                <h3>Pembayaran</h3>
                <?php if (!empty($payment) && is_array($payment)): ?>
                    <div style="background: #f9fafb; padding: 15px; border-radius: 8px; border-left: 4px solid #10b981;">
                        <p><strong>Metode Pembayaran:</strong> <?php echo htmlspecialchars($payment['payment_method'] ?? '-'); ?></p>
                        <p><strong>Jumlah Dibayar:</strong> Rp <?php echo number_format($payment['amount'] ?? 0, 0, ',', '.'); ?></p>
                        <p><strong>Status Pembayaran:</strong> 
                            <span style="padding: 4px 10px; border-radius: 4px; font-size: 0.875rem; font-weight: 500; 
                                <?php 
                                $status = $payment['payment_status'] ?? '';
                                if ($status === 'verified') echo 'background: #d1fae5; color: #065f46;';
                                elseif ($status === 'pending') echo 'background: #fef3c7; color: #92400e;';
                                else echo 'background: #fee2e2; color: #991b1b;';
                                ?>">
                                <?php 
                                if ($status === 'verified') echo 'Terverifikasi';
                                elseif ($status === 'pending') echo 'Menunggu Verifikasi';
                                elseif ($status === 'rejected') echo 'Ditolak';
                                else echo ucfirst($status);
                                ?>
                            </span>
                        </p>
                        <?php if (!empty($payment['proof_image'])): ?>
                            <p><strong>Bukti Pembayaran:</strong> 
                                <a href="<?php echo BASEURL . 'uploads/payments/' . htmlspecialchars($payment['proof_image']); ?>" target="_blank" style="color: #2563eb; text-decoration: underline;">Lihat Bukti</a>
                            </p>
                        <?php endif; ?>
                        <?php if (!empty($payment['payment_datetime'])): ?>
                            <p><strong>Tanggal Pembayaran:</strong> <?php echo htmlspecialchars(date('d/m/Y H:i', strtotime($payment['payment_datetime']))); ?></p>
                        <?php endif; ?>
                        <?php if (!empty($payment['verified_at']) && $status === 'verified'): ?>
                            <p><strong>Diverifikasi Pada:</strong> <?php echo htmlspecialchars(date('d/m/Y H:i', strtotime($payment['verified_at']))); ?></p>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <p style="padding: 15px; background: #fef3c7; border-radius: 6px; color: #92400e; border-left: 4px solid #f59e0b;">
                        <i class="fas fa-exclamation-triangle"></i> Belum ada pembayaran tercatat.
                    </p>
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