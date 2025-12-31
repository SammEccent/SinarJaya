<style>
    .bookings-container {
        max-width: 1200px;
        margin: 40px auto;
        padding: 0 20px;
    }

    .page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 40px;
        border-radius: 16px;
        margin-bottom: 30px;
    }

    .page-header h1 {
        margin: 0 0 10px 0;
        font-size: 32px;
        font-weight: 700;
    }

    .page-header p {
        margin: 0;
        opacity: 0.9;
        font-size: 16px;
    }

    .bookings-list {
        display: grid;
        gap: 20px;
    }

    .booking-card {
        background: white;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 24px;
        transition: all 0.3s ease;
    }

    .booking-card:hover {
        border-color: #667eea;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15);
        transform: translateY(-2px);
    }

    .booking-header {
        display: flex;
        justify-content: space-between;
        align-items: start;
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 2px solid #f3f4f6;
    }

    .booking-code {
        font-size: 18px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 5px;
    }

    .booking-date {
        color: #6b7280;
        font-size: 14px;
    }

    .booking-status {
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        text-transform: uppercase;
    }

    .status-pending {
        background: #fef3c7;
        color: #92400e;
    }

    .status-confirmed {
        background: #d1fae5;
        color: #065f46;
    }

    .status-cancelled {
        background: #fee2e2;
        color: #991b1b;
    }

    .status-expired {
        background: #f3f4f6;
        color: #6b7280;
    }

    .booking-details {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 20px;
    }

    .detail-item {
        display: flex;
        align-items: start;
        gap: 12px;
    }

    .detail-item i {
        color: #667eea;
        font-size: 20px;
        margin-top: 2px;
    }

    .detail-content {
        flex: 1;
    }

    .detail-label {
        font-size: 12px;
        color: #6b7280;
        text-transform: uppercase;
        margin-bottom: 4px;
    }

    .detail-value {
        font-size: 15px;
        color: #1f2937;
        font-weight: 600;
    }

    .booking-actions {
        display: flex;
        gap: 12px;
        padding-top: 20px;
        border-top: 2px solid #f3f4f6;
    }

    .btn {
        padding: 10px 20px;
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

    .btn-outline {
        background: white;
        color: #667eea;
        border: 2px solid #667eea;
    }

    .btn-outline:hover {
        background: #667eea;
        color: white;
    }

    .btn-danger {
        background: #ef4444;
        color: white;
    }

    .btn-danger:hover {
        background: #dc2626;
    }

    .empty-state {
        text-align: center;
        padding: 80px 20px;
        background: white;
        border-radius: 12px;
        border: 2px dashed #e5e7eb;
    }

    .empty-state i {
        font-size: 64px;
        color: #d1d5db;
        margin-bottom: 20px;
    }

    .empty-state h3 {
        margin: 0 0 10px 0;
        color: #1f2937;
        font-size: 20px;
    }

    .empty-state p {
        margin: 0 0 24px 0;
        color: #6b7280;
    }

    @media (max-width: 768px) {
        .booking-header {
            flex-direction: column;
            gap: 12px;
        }

        .booking-details {
            grid-template-columns: 1fr;
        }

        .booking-actions {
            flex-direction: column;
        }

        .btn {
            justify-content: center;
        }
    }
</style>

<div class="bookings-container">
    <div class="page-header">
        <h1><i class="fas fa-ticket-alt"></i> Pesanan Saya</h1>
        <p>Lihat dan kelola semua pesanan tiket bus Anda</p>
    </div>

    <?php if (!empty($bookings)): ?>
        <div class="bookings-list">
            <?php foreach ($bookings as $booking): ?>
                <div class="booking-card">
                    <div class="booking-header">
                        <div>
                            <div class="booking-code">
                                <i class="fas fa-hashtag"></i> <?php echo htmlspecialchars($booking['booking_code']); ?>
                            </div>
                            <div class="booking-date">
                                <i class="far fa-calendar"></i> Dipesan: <?php echo date('d M Y H:i', strtotime($booking['created_at'])); ?>
                            </div>
                        </div>
                        <span class="booking-status status-<?php echo $booking['booking_status']; ?>">
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

                    <div class="booking-details">
                        <div class="detail-item">
                            <i class="fas fa-route"></i>
                            <div class="detail-content">
                                <div class="detail-label">Rute</div>
                                <div class="detail-value">
                                    <?php echo htmlspecialchars($booking['origin_city']); ?> →
                                    <?php echo htmlspecialchars($booking['destination_city']); ?>
                                </div>
                            </div>
                        </div>

                        <div class="detail-item">
                            <i class="far fa-clock"></i>
                            <div class="detail-content">
                                <div class="detail-label">Keberangkatan</div>
                                <div class="detail-value">
                                    <?php echo date('d M Y, H:i', strtotime($booking['departure_datetime'])); ?>
                                </div>
                            </div>
                        </div>

                        <div class="detail-item">
                            <i class="fas fa-users"></i>
                            <div class="detail-content">
                                <div class="detail-label">Penumpang</div>
                                <div class="detail-value">
                                    <?php echo $booking['total_passengers']; ?> orang
                                </div>
                            </div>
                        </div>

                        <div class="detail-item">
                            <i class="fas fa-money-bill-wave"></i>
                            <div class="detail-content">
                                <div class="detail-label">Total Harga</div>
                                <div class="detail-value">
                                    Rp <?php echo number_format($booking['total_amount'], 0, ',', '.'); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="booking-actions">
                        <a href="<?php echo BASEURL; ?>user/booking/<?php echo $booking['id']; ?>" class="btn btn-primary">
                            <i class="fas fa-eye"></i> Lihat Detail
                        </a>

                        <?php if ($booking['booking_status'] === 'confirmed'): ?>
                            <a href="<?php echo BASEURL; ?>booking/downloadTicket/<?php echo $booking['id']; ?>" class="btn btn-outline" target="_blank">
                                <i class="fas fa-download"></i> Download E-Ticket
                            </a>
                        <?php endif; ?>

                        <?php if ($booking['booking_status'] === 'pending'): ?>
                            <a href="<?php echo BASEURL; ?>payment/create?booking_id=<?php echo $booking['id']; ?>" class="btn btn-outline">
                                <i class="fas fa-credit-card"></i> Bayar Sekarang
                            </a>
                            <button onclick="cancelBooking(<?php echo $booking['id']; ?>)" class="btn btn-danger">
                                <i class="fas fa-times"></i> Batalkan
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <i class="fas fa-inbox"></i>
            <h3>Belum Ada Pesanan</h3>
            <p>Anda belum memiliki pesanan tiket bus. Mulai pesan sekarang!</p>
            <a href="<?php echo BASEURL; ?>" class="btn btn-primary">
                <i class="fas fa-search"></i> Cari Tiket
            </a>
        </div>
    <?php endif; ?>
</div>

<script>
    function cancelBooking(bookingId) {
        if (!confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')) {
            return;
        }

        fetch('<?php echo BASEURL; ?>booking/cancel/' + bookingId, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    location.reload();
                } else {
                    alert(data.message || 'Gagal membatalkan pesanan');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat membatalkan pesanan');
            });
    }
</script>