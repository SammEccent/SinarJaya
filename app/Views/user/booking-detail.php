<style>
    .booking-detail-container {
        max-width: 1000px;
        margin: 40px auto;
        padding: 0 20px;
    }

    .back-button {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #667eea;
        text-decoration: none;
        font-weight: 600;
        margin-bottom: 20px;
        transition: all 0.3s ease;
    }

    .back-button:hover {
        color: #5568d3;
        transform: translateX(-4px);
    }

    .detail-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 30px;
        border-radius: 16px 16px 0 0;
    }

    .detail-header h1 {
        margin: 0 0 10px 0;
        font-size: 28px;
        font-weight: 700;
    }

    .detail-header .status-badge {
        display: inline-block;
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        background: rgba(255, 255, 255, 0.2);
    }

    .detail-content {
        background: white;
        border: 2px solid #e5e7eb;
        border-top: none;
        border-radius: 0 0 16px 16px;
        padding: 30px;
    }

    .section {
        margin-bottom: 30px;
        padding-bottom: 30px;
        border-bottom: 2px solid #f3f4f6;
    }

    .section:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }

    .section-title {
        font-size: 18px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-title i {
        color: #667eea;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
    }

    .info-item {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .info-label {
        font-size: 12px;
        color: #6b7280;
        text-transform: uppercase;
        font-weight: 600;
    }

    .info-value {
        font-size: 16px;
        color: #1f2937;
        font-weight: 600;
    }

    .passengers-list {
        display: grid;
        gap: 12px;
    }

    .passenger-card {
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 16px;
    }

    .passenger-name {
        font-size: 16px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 8px;
    }

    .passenger-details {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 12px;
        font-size: 14px;
        color: #6b7280;
    }

    .passenger-detail {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .passenger-detail i {
        color: #667eea;
    }

    .payment-info {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        border: 2px solid #fbbf24;
        border-radius: 12px;
        padding: 20px;
    }

    .payment-info.paid {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        border-color: #10b981;
    }

    .payment-status {
        font-size: 16px;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .payment-details {
        display: grid;
        gap: 8px;
        font-size: 14px;
    }

    .action-buttons {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .btn {
        padding: 12px 24px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }

    .btn-primary {
        background: #667eea;
        color: white;
    }

    .btn-primary:hover {
        background: #5568d3;
        transform: translateY(-1px);
    }

    .btn-success {
        background: #10b981;
        color: white;
    }

    .btn-success:hover {
        background: #059669;
    }

    .btn-danger {
        background: #ef4444;
        color: white;
    }

    .btn-danger:hover {
        background: #dc2626;
    }

    @media (max-width: 768px) {
        .info-grid {
            grid-template-columns: 1fr;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn {
            justify-content: center;
        }
    }
</style>

<div class="booking-detail-container">
    <a href="<?php echo BASEURL; ?>user/bookings" class="back-button">
        <i class="fas fa-arrow-left"></i> Kembali ke Daftar Pesanan
    </a>

    <div class="detail-header">
        <h1><i class="fas fa-ticket-alt"></i> <?php echo htmlspecialchars($booking['booking_code']); ?></h1>
        <span class="status-badge">
            <?php
            $statusLabels = [
                'pending' => 'Menunggu Pembayaran',
                'confirmed' => 'Terkonfirmasi',
                'cancelled' => 'Dibatalkan',
                'expired' => 'Kedaluwarsa'
            ];
            echo $statusLabels[$booking['booking_status']] ?? $booking['booking_status'];
            ?>
        </span>
    </div>

    <div class="detail-content">
        <!-- Trip Information -->
        <div class="section">
            <h2 class="section-title">
                <i class="fas fa-route"></i> Informasi Perjalanan
            </h2>
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Rute</span>
                    <span class="info-value">
                        <?php echo htmlspecialchars($booking['origin_city']); ?> →
                        <?php echo htmlspecialchars($booking['destination_city']); ?>
                    </span>
                </div>
                <div class="info-item">
                    <span class="info-label">Tanggal & Waktu Keberangkatan</span>
                    <span class="info-value">
                        <?php echo date('d M Y, H:i', strtotime($booking['departure_datetime'])); ?> WIB
                    </span>
                </div>
                <div class="info-item">
                    <span class="info-label">Kelas Bus</span>
                    <span class="info-value"><?php echo htmlspecialchars($booking['bus_class_name']); ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Jumlah Penumpang</span>
                    <span class="info-value"><?php echo $booking['total_passengers']; ?> orang</span>
                </div>
            </div>
        </div>

        <!-- Passengers -->
        <div class="section">
            <h2 class="section-title">
                <i class="fas fa-users"></i> Data Penumpang
            </h2>
            <div class="passengers-list">
                <?php foreach ($passengers as $index => $passenger): ?>
                    <div class="passenger-card">
                        <div class="passenger-name">
                            <?php echo ($index + 1); ?>. <?php echo htmlspecialchars($passenger['full_name']); ?>
                        </div>
                        <div class="passenger-details">
                            <?php if (isset($passenger['seat_number']) && $passenger['seat_number']): ?>
                                <div class="passenger-detail">
                                    <i class="fas fa-chair"></i>
                                    <span>Kursi <?php echo htmlspecialchars($passenger['seat_number']); ?></span>
                                    <?php if (isset($passenger['seat_type']) && $passenger['seat_type']): ?>
                                        <span>(<?php echo htmlspecialchars($passenger['seat_type']); ?>)</span>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                            <div class="passenger-detail">
                                <i class="fas fa-id-card"></i>
                                <span><?php echo htmlspecialchars($passenger['id_card_type']); ?>: <?php echo htmlspecialchars($passenger['id_card_number']); ?></span>
                            </div>
                            <div class="passenger-detail">
                                <i class="fas fa-phone"></i>
                                <span><?php echo htmlspecialchars($passenger['phone']); ?></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Payment Information -->
        <div class="section">
            <h2 class="section-title">
                <i class="fas fa-money-bill-wave"></i> Informasi Pembayaran
            </h2>

            <?php if ($payment): ?>
                <div class="payment-info <?php echo ($payment['payment_status'] === 'paid') ? 'paid' : ''; ?>">
                    <div class="payment-status">
                        <?php
                        $paymentStatusLabels = [
                            'pending' => '⏳ Menunggu Pembayaran',
                            'paid' => '✅ Pembayaran Berhasil',
                            'failed' => '❌ Pembayaran Gagal',
                            'refunded' => '🔄 Dana Dikembalikan'
                        ];
                        echo $paymentStatusLabels[$payment['payment_status']] ?? $payment['payment_status'];
                        ?>
                    </div>
                    <div class="payment-details">
                        <div><strong>Kode Pembayaran:</strong> <?php echo htmlspecialchars($payment['payment_code']); ?></div>
                        <div><strong>Metode:</strong>
                            <?php
                            $methodLabels = [
                                'bank_transfer' => 'Transfer Bank',
                                'e_wallet' => 'E-Wallet',
                                'qris' => 'QRIS'
                            ];
                            echo $methodLabels[$payment['payment_method']] ?? $payment['payment_method'];
                            ?>
                        </div>
                        <div><strong>Total:</strong> Rp <?php echo number_format($payment['amount'], 0, ',', '.'); ?></div>
                        <?php if ($payment['payment_status'] === 'paid' && $payment['paid_at']): ?>
                            <div><strong>Dibayar pada:</strong> <?php echo date('d M Y, H:i', strtotime($payment['paid_at'])); ?> WIB</div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php else: ?>
                <div class="payment-info">
                    <div class="payment-status">⏳ Belum Ada Pembayaran</div>
                    <div class="payment-details">
                        <div><strong>Total yang harus dibayar:</strong> Rp <?php echo number_format($booking['total_amount'], 0, ',', '.'); ?></div>
                        <div><strong>Batas waktu:</strong> <?php echo date('d M Y, H:i', strtotime($booking['payment_expiry'])); ?> WIB</div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Actions -->
        <div class="action-buttons">
            <?php if ($booking['booking_status'] === 'pending'): ?>
                <?php if ($payment): ?>
                    <a href="<?php echo BASEURL; ?>payment/show/<?php echo $payment['id']; ?>" class="btn btn-primary">
                        <i class="fas fa-eye"></i> Lihat Detail Pembayaran
                    </a>
                    <?php if ($payment['payment_status'] === 'pending'): ?>
                        <a href="<?php echo BASEURL; ?>payment/instructions/<?php echo $payment['id']; ?>" class="btn btn-success">
                            <i class="fas fa-upload"></i> Upload Bukti Pembayaran
                        </a>
                    <?php endif; ?>
                <?php else: ?>
                    <a href="<?php echo BASEURL; ?>payment/create?booking_id=<?php echo $booking['id']; ?>" class="btn btn-primary">
                        <i class="fas fa-credit-card"></i> Bayar Sekarang
                    </a>
                <?php endif; ?>

                <button onclick="cancelBooking(<?php echo $booking['id']; ?>)" class="btn btn-danger">
                    <i class="fas fa-times"></i> Batalkan Pesanan
                </button>
            <?php endif; ?>

            <?php if ($booking['booking_status'] === 'confirmed'): ?>
                <a href="<?php echo BASEURL; ?>booking/downloadTicket/<?php echo $booking['id']; ?>" class="btn btn-primary" target="_blank">
                    <i class="fas fa-download"></i> Download E-Ticket PDF
                </a>
                <button onclick="window.print()" class="btn btn-outline" style="border: 2px solid #667eea;">
                    <i class="fas fa-print"></i> Cetak Halaman Ini
                </button>
                <button onclick="cancelBooking(<?php echo $booking['id']; ?>)" class="btn btn-danger">
                    <i class="fas fa-undo"></i> Batalkan & Refund
                </button>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    function cancelBooking(bookingId) {
        if (!confirm('Apakah Anda yakin ingin membatalkan pesanan ini?\n\nJika Anda sudah melakukan pembayaran, dana akan dikembalikan dalam waktu 2x24 jam.')) {
            return;
        }

        fetch('<?php echo BASEURL; ?>user/cancel/' + bookingId, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    let message = data.message;

                    if (data.refund_needed) {
                        message += '\n\n📢 INFORMASI PENTING:\n';
                        message += '✓ Pembayaran Anda sudah diterima\n';
                        message += '✓ Dana akan diproses untuk pengembalian (refund)\n';
                        message += '✓ Proses refund: maksimal 2x24 jam\n';
                        message += '✓ Admin akan menghubungi Anda untuk konfirmasi';
                    }

                    alert(message);
                    location.reload();
                } else {
                    alert(data.message || 'Gagal membatalkan pesanan');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat membatalkan pesanan. Silakan coba lagi.');
            });
    }
</script>