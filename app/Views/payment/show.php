<style>
    .payment-detail-container {
        max-width: 800px;
        margin: 40px auto;
        padding: 0 20px;
    }

    .payment-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 30px;
        border-radius: 16px;
        margin-bottom: 30px;
        text-align: center;
    }

    .payment-header h1 {
        margin: 0 0 10px 0;
        font-size: 28px;
        font-weight: 700;
    }

    .status-badge {
        display: inline-block;
        padding: 10px 20px;
        border-radius: 20px;
        font-weight: 700;
        font-size: 14px;
        margin-top: 15px;
    }

    .status-badge.pending {
        background: #fef3c7;
        color: #92400e;
    }

    .status-badge.paid {
        background: #d1fae5;
        color: #065f46;
    }

    .status-badge.failed {
        background: #fee2e2;
        color: #991b1b;
    }

    .detail-card {
        background: white;
        border: 2px solid #e5e7eb;
        border-radius: 16px;
        padding: 30px;
        margin-bottom: 25px;
    }

    .card-title {
        font-size: 20px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid #f3f4f6;
    }

    .detail-row:last-child {
        border-bottom: none;
    }

    .detail-label {
        color: #6b7280;
        font-size: 14px;
    }

    .detail-value {
        font-weight: 600;
        color: #1f2937;
        text-align: right;
    }

    .detail-value.highlight {
        color: #667eea;
        font-size: 18px;
    }

    .proof-image {
        width: 100%;
        border-radius: 12px;
        border: 2px solid #e5e7eb;
        margin-top: 15px;
    }

    .passengers-grid {
        display: grid;
        gap: 10px;
        margin-top: 15px;
    }

    .passenger-card {
        background: #f9fafb;
        padding: 15px;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
    }

    .passenger-name {
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 5px;
    }

    .passenger-details {
        font-size: 13px;
        color: #6b7280;
    }

    .action-buttons {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
        margin-top: 25px;
    }

    .btn {
        padding: 14px 20px;
        border-radius: 10px;
        border: none;
        font-weight: 700;
        font-size: 15px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-align: center;
        text-decoration: none;
        display: inline-block;
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
    }

    .btn-secondary {
        background: white;
        color: #667eea;
        border: 2px solid #667eea;
    }

    .btn-secondary:hover {
        background: #f0f4ff;
    }

    .alert {
        padding: 15px 20px;
        border-radius: 12px;
        margin-bottom: 20px;
    }

    .alert-success {
        background: #d1fae5;
        color: #065f46;
        border: 1px solid #10b981;
    }

    .alert-danger {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fca5a5;
    }

    @media (max-width: 768px) {
        .action-buttons {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="payment-detail-container">
    <div class="payment-header">
        <h1><i class="fas fa-receipt"></i> Detail Pembayaran</h1>
        <p>Informasi lengkap pembayaran Anda</p>

        <?php
        $statusClass = '';
        $statusText = '';
        $statusIcon = '';

        switch ($payment['payment_status']) {
            case 'pending':
                $statusClass = 'pending';
                $statusText = 'Menunggu Pembayaran';
                $statusIcon = 'fa-clock';
                break;
            case 'paid':
                $statusClass = 'paid';
                $statusText = 'Pembayaran Berhasil';
                $statusIcon = 'fa-check-circle';
                break;
            case 'failed':
                $statusClass = 'failed';
                $statusText = 'Pembayaran Gagal';
                $statusIcon = 'fa-times-circle';
                break;
            case 'refunded':
                $statusClass = 'failed';
                $statusText = 'Dikembalikan';
                $statusIcon = 'fa-undo';
                break;
        }
        ?>

        <div class="status-badge <?php echo $statusClass; ?>">
            <i class="fas <?php echo $statusIcon; ?>"></i>
            <?php echo $statusText; ?>
        </div>
    </div>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> <?php echo $_SESSION['success'];
                                                unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle"></i> <?php echo $_SESSION['error'];
                                                        unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <!-- Payment Information -->
    <div class="detail-card">
        <div class="card-title">
            <i class="fas fa-credit-card"></i>
            Informasi Pembayaran
        </div>

        <div class="detail-row">
            <span class="detail-label">Kode Pembayaran</span>
            <span class="detail-value"><?php echo htmlspecialchars($payment['payment_code']); ?></span>
        </div>

        <div class="detail-row">
            <span class="detail-label">Metode Pembayaran</span>
            <span class="detail-value">
                <?php
                $methods = [
                    'bank_transfer' => 'Transfer Bank',
                    'e_wallet' => 'E-Wallet',
                    'qris' => 'QRIS',
                    'credit_card' => 'Kartu Kredit'
                ];
                echo $methods[$payment['payment_method']] ?? $payment['payment_method'];
                ?>
            </span>
        </div>

        <div class="detail-row">
            <span class="detail-label">Jumlah Pembayaran</span>
            <span class="detail-value highlight">Rp <?php echo number_format($payment['amount'], 0, ',', '.'); ?></span>
        </div>

        <div class="detail-row">
            <span class="detail-label">Status</span>
            <span class="detail-value"><?php echo $statusText; ?></span>
        </div>

        <?php if ($payment['paid_at']): ?>
            <div class="detail-row">
                <span class="detail-label">Tanggal Pembayaran</span>
                <span class="detail-value"><?php echo date('d M Y, H:i', strtotime($payment['paid_at'])); ?> WIB</span>
            </div>
        <?php endif; ?>

        <div class="detail-row">
            <span class="detail-label">Dibuat</span>
            <span class="detail-value"><?php echo date('d M Y, H:i', strtotime($payment['created_at'])); ?> WIB</span>
        </div>
    </div>

    <!-- Booking Information -->
    <div class="detail-card">
        <div class="card-title">
            <i class="fas fa-ticket-alt"></i>
            Informasi Booking
        </div>

        <div class="detail-row">
            <span class="detail-label">Kode Booking</span>
            <span class="detail-value"><?php echo htmlspecialchars($payment['booking_code']); ?></span>
        </div>

        <div class="detail-row">
            <span class="detail-label">Rute</span>
            <span class="detail-value">
                <?php echo htmlspecialchars($payment['origin_city']); ?>
                →
                <?php echo htmlspecialchars($payment['destination_city']); ?>
            </span>
        </div>

        <div class="detail-row">
            <span class="detail-label">Tanggal Keberangkatan</span>
            <span class="detail-value">
                <?php echo date('d M Y, H:i', strtotime($payment['departure_datetime'])); ?> WIB
            </span>
        </div>

        <div class="detail-row">
            <span class="detail-label">Jumlah Penumpang</span>
            <span class="detail-value"><?php echo count($passengers); ?> orang</span>
        </div>
    </div>

    <!-- Passengers Information -->
    <div class="detail-card">
        <div class="card-title">
            <i class="fas fa-users"></i>
            Data Penumpang
        </div>

        <div class="passengers-grid">
            <?php foreach ($passengers as $index => $passenger): ?>
                <div class="passenger-card">
                    <div class="passenger-name">
                        <?php echo ($index + 1); ?>. <?php echo htmlspecialchars($passenger['full_name']); ?>
                    </div>
                    <div class="passenger-details">
                        <?php if ($passenger['seat_number']): ?>
                            Kursi <?php echo htmlspecialchars($passenger['seat_number']); ?> •
                        <?php endif; ?>
                        <?php echo htmlspecialchars($passenger['id_card_type']); ?>: <?php echo htmlspecialchars($passenger['id_card_number']); ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Payment Proof -->
    <?php if ($payment['payment_proof_image']): ?>
        <div class="detail-card">
            <div class="card-title">
                <i class="fas fa-image"></i>
                Bukti Pembayaran
            </div>
            <img src="<?php echo BASEURL . $payment['payment_proof_image']; ?>"
                alt="Bukti Pembayaran"
                class="proof-image">
        </div>
    <?php endif; ?>

    <!-- Actions -->
    <div class="action-buttons">
        <?php if ($payment['payment_status'] === 'pending' && !$payment['payment_proof_image']): ?>
            <a href="<?php echo BASEURL; ?>payment/instructions/<?php echo $payment['id']; ?>" class="btn btn-primary">
                <i class="fas fa-upload"></i> Upload Bukti Pembayaran
            </a>
        <?php endif; ?>

        <a href="<?php echo BASEURL; ?>booking/detail/<?php echo $payment['booking_id']; ?>" class="btn btn-secondary">
            <i class="fas fa-eye"></i> Lihat Booking
        </a>
    </div>
</div>