<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .payment-container {
        max-width: 1100px;
        margin: 30px auto;
        padding: 0 20px;
    }

    .payment-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 35px;
        border-radius: 16px;
        margin-bottom: 30px;
        box-shadow: 0 4px 20px rgba(102, 126, 234, 0.25);
    }

    .payment-header h1 {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .payment-header p {
        font-size: 15px;
        opacity: 0.95;
    }

    .payment-content {
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 25px;
    }

    /* BOOKING SUMMARY */
    .booking-summary {
        background: white;
        border-radius: 16px;
        padding: 25px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        height: fit-content;
    }

    .summary-title {
        font-size: 19px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 18px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .trip-details {
        background: #f9fafb;
        padding: 18px;
        border-radius: 12px;
        margin-bottom: 18px;
    }

    .trip-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 12px;
        padding-bottom: 12px;
        border-bottom: 1px solid #e5e7eb;
    }

    .trip-row:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }

    .trip-label {
        color: #6b7280;
        font-size: 14px;
    }

    .trip-value {
        font-weight: 600;
        color: #1f2937;
        text-align: right;
    }

    .route-visual {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .route-point {
        font-weight: 700;
        color: #667eea;
    }

    .route-arrow {
        color: #9ca3af;
    }

    .passengers-list {
        background: #f9fafb;
        padding: 15px;
        border-radius: 12px;
        margin-bottom: 18px;
    }

    .passenger-item {
        padding: 8px 0;
        border-bottom: 1px solid #e5e7eb;
        font-size: 14px;
    }

    .passenger-item:last-child {
        border-bottom: none;
    }

    .price-breakdown {
        background: #f9fafb;
        padding: 18px;
        border-radius: 12px;
    }

    .price-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        font-size: 15px;
    }

    .price-label {
        color: #6b7280;
    }

    .price-value {
        font-weight: 600;
        color: #1f2937;
    }

    .price-total {
        margin-top: 10px;
        padding-top: 10px;
        border-top: 1px solid #e5e7eb;
    }

    .price-total .price-label {
        color: #1f2937;
        font-weight: 700;
        font-size: 16px;
    }

    .price-total .price-value {
        color: #667eea;
        font-size: 22px;
        font-weight: 700;
    }

    .payment-expiry {
        background: #fef3c7;
        border: 1px solid #fbbf24;
        padding: 14px;
        border-radius: 10px;
        margin-top: 18px;
        text-align: center;
    }

    .expiry-label {
        font-size: 12px;
        color: #92400e;
        margin-bottom: 4px;
    }

    .expiry-time {
        font-size: 18px;
        font-weight: 700;
        color: #92400e;
    }

    /* PAYMENT METHODS */
    .payment-methods {
        display: flex;
        flex-direction: column;
    }

    .methods-title {
        font-size: 20px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 20px;
    }

    .method-card {
        background: white;
        border: 2px solid #e5e7eb;
        border-radius: 14px;
        padding: 20px;
        margin-bottom: 12px;
        cursor: pointer;
        transition: all 0.2s ease;
        position: relative;
    }

    .method-card:hover {
        border-color: #c7d2fe;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .method-card.selected {
        border-color: #667eea;
        background: #f8f9ff;
        box-shadow: 0 4px 16px rgba(102, 126, 234, 0.12);
    }

    .method-card input[type="radio"] {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    .method-badge {
        position: absolute;
        top: 12px;
        right: 12px;
        background: #f59e0b;
        color: white;
        font-size: 10px;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 6px;
        text-transform: uppercase;
    }

    .method-header {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .method-icon {
        width: 52px;
        height: 52px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        flex-shrink: 0;
    }

    .method-info {
        flex: 1;
    }

    .method-name {
        font-size: 17px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 4px;
    }

    .method-desc {
        font-size: 13px;
        color: #6b7280;
        line-height: 1.4;
    }

    .method-check {
        width: 22px;
        height: 22px;
        border: 2px solid #d1d5db;
        border-radius: 50%;
        position: relative;
        flex-shrink: 0;
        background: white;
        transition: all 0.2s ease;
    }

    .method-card.selected .method-check {
        border-color: #667eea;
        background: #667eea;
    }

    .method-card.selected .method-check::after {
        content: '✓';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: white;
        font-weight: 700;
        font-size: 13px;
    }

    .method-details {
        margin-top: 16px;
        padding-top: 16px;
        border-top: 1px solid #e5e7eb;
        display: none;
    }

    .method-card.selected .method-details {
        display: block;
    }

    .bank-list,
    .wallet-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .bank-item,
    .wallet-item {
        background: #f9fafb;
        padding: 14px;
        border-radius: 10px;
        border: 1px solid #e5e7eb;
        display: flex;
        align-items: center;
        gap: 12px;
        transition: all 0.2s ease;
    }

    .bank-item:hover,
    .wallet-item:hover {
        background: white;
        border-color: #c7d2fe;
    }

    .bank-item::before,
    .wallet-item::before {
        content: '🏦';
        font-size: 22px;
        flex-shrink: 0;
    }

    .wallet-item::before {
        content: '💳';
    }

    .bank-info,
    .wallet-info {
        flex: 1;
    }

    .bank-name,
    .wallet-name {
        font-weight: 700;
        color: #1f2937;
        font-size: 14px;
        margin-bottom: 2px;
    }

    .bank-account,
    .wallet-number {
        color: #6b7280;
        font-size: 12px;
        font-family: 'Courier New', monospace;
    }

    .qris-info {
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        border-radius: 10px;
        padding: 14px;
        display: flex;
        gap: 10px;
    }

    .qris-info-icon {
        font-size: 20px;
        flex-shrink: 0;
    }

    .qris-info-text {
        font-size: 13px;
        color: #1e40af;
        line-height: 1.5;
    }

    .qris-info-text strong {
        font-weight: 700;
    }

    .submit-btn {
        width: 100%;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        padding: 16px;
        border-radius: 12px;
        border: none;
        font-weight: 700;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.2s ease;
        margin-top: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .submit-btn:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.35);
    }

    .submit-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    @media (max-width: 992px) {
        .payment-content {
            grid-template-columns: 1fr;
        }

        .method-icon {
            width: 48px;
            height: 48px;
            font-size: 22px;
        }
    }

    @media (max-width: 768px) {
        .payment-header {
            padding: 28px 22px;
        }

        .payment-header h1 {
            font-size: 24px;
        }

        .method-name {
            font-size: 16px;
        }
    }
</style>

<div class="payment-container">
    <div class="payment-header">
        <h1><i class="fas fa-credit-card"></i> Pembayaran</h1>
        <p>Pilih metode pembayaran untuk menyelesaikan pemesanan Anda</p>
    </div>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger" style="margin-bottom: 20px; padding: 15px; background: #fee2e2; border: 1px solid #fecaca; border-radius: 12px; color: #991b1b;">
            <i class="fas fa-exclamation-circle"></i> <?php echo $_SESSION['error'];
                                                        unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <div class="payment-content">
        <!-- Booking Summary -->
        <div class="booking-summary">
            <div class="summary-title">
                <i class="fas fa-receipt"></i>
                Ringkasan Pemesanan
            </div>

            <div class="trip-details">
                <div class="trip-row">
                    <div class="trip-label">Kode Booking</div>
                    <div class="trip-value"><?php echo htmlspecialchars($booking['booking_code']); ?></div>
                </div>
                <div class="trip-row">
                    <div class="trip-label">Rute</div>
                    <div class="trip-value">
                        <div class="route-visual">
                            <span class="route-point"><?php echo htmlspecialchars($booking['origin_city']); ?></span>
                            <i class="fas fa-arrow-right route-arrow"></i>
                            <span class="route-point"><?php echo htmlspecialchars($booking['destination_city']); ?></span>
                        </div>
                    </div>
                </div>
                <div class="trip-row">
                    <div class="trip-label">Tanggal & Waktu</div>
                    <div class="trip-value">
                        <?php echo date('d M Y, H:i', strtotime($booking['departure_datetime'])); ?> WIB
                    </div>
                </div>
                <div class="trip-row">
                    <div class="trip-label">Kelas Bus</div>
                    <div class="trip-value"><?php echo htmlspecialchars($booking['bus_class_name']); ?></div>
                </div>
                <div class="trip-row">
                    <div class="trip-label">Jumlah Penumpang</div>
                    <div class="trip-value"><?php echo $booking['total_passengers']; ?> orang</div>
                </div>
            </div>

            <div class="summary-title" style="font-size: 16px; margin-bottom: 12px;">
                <i class="fas fa-users"></i> Data Penumpang
            </div>
            <div class="passengers-list">
                <?php foreach ($passengers as $index => $passenger): ?>
                    <div class="passenger-item">
                        <strong><?php echo ($index + 1); ?>.</strong>
                        <?php echo htmlspecialchars($passenger['full_name']); ?>
                        <?php if (isset($passenger['seat_number']) && $passenger['seat_number']): ?>
                            <br>
                            <span style="color: #667eea; font-weight: 600; font-size: 12px;">
                                <i class="fas fa-chair"></i> Kursi <?php echo htmlspecialchars($passenger['seat_number']); ?>
                                <?php if (isset($passenger['seat_type']) && $passenger['seat_type']): ?>
                                    - <?php echo htmlspecialchars($passenger['seat_type']); ?>
                                <?php endif; ?>
                            </span>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="price-breakdown">
                <div class="price-row price-total">
                    <span class="price-label">Total Pembayaran</span>
                    <span class="price-value">Rp <?php echo number_format($booking['total_amount'], 0, ',', '.'); ?></span>
                </div>
            </div>

            <?php if ($payment_expiry): ?>
                <div class="payment-expiry">
                    <div class="expiry-label">Bayar Sebelum</div>
                    <div class="expiry-time">
                        <i class="fas fa-clock"></i>
                        <?php echo date('d M Y, H:i', strtotime($payment_expiry)); ?> WIB
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Payment Methods -->
        <div class="payment-methods">
            <div class="methods-title">Pilih Metode Pembayaran</div>

            <form action="<?php echo BASEURL; ?>payment/processMethod" method="POST" id="paymentForm">
                <input type="hidden" name="booking_id" value="<?php echo $booking['id']; ?>">

                <?php
                $method_index = 0;
                foreach ($paymentMethods as $key => $method):
                    $method_index++;
                ?>
                    <label class="method-card" data-method="<?php echo $key; ?>">
                        <input type="radio" name="payment_method" value="<?php echo $key; ?>" required>

                        <?php if ($method_index === 1): ?>
                            <div class="method-badge">Populer</div>
                        <?php endif; ?>

                        <div class="method-header">
                            <div class="method-icon">
                                <i class="fas <?php echo $method['icon']; ?>"></i>
                            </div>
                            <div class="method-info">
                                <div class="method-name"><?php echo $method['name']; ?></div>
                                <div class="method-desc"><?php echo $method['description']; ?></div>
                            </div>
                            <div class="method-check"></div>
                        </div>

                        <?php if ($key === 'bank_transfer' && isset($method['banks'])): ?>
                            <div class="method-details">
                                <div class="bank-list">
                                    <?php foreach ($method['banks'] as $bank): ?>
                                        <div class="bank-item">
                                            <div class="bank-info">
                                                <div class="bank-name"><?php echo $bank['name']; ?></div>
                                                <div class="bank-account"><?php echo $bank['account']; ?> - <?php echo $bank['holder']; ?></div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if ($key === 'e_wallet' && isset($method['wallets'])): ?>
                            <div class="method-details">
                                <div class="wallet-list">
                                    <?php foreach ($method['wallets'] as $wallet): ?>
                                        <div class="wallet-item">
                                            <div class="wallet-info">
                                                <div class="wallet-name"><?php echo $wallet['name']; ?></div>
                                                <div class="wallet-number"><?php echo $wallet['number']; ?></div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if ($key === 'qris'): ?>
                            <div class="method-details">
                                <div class="qris-info">
                                    <div class="qris-info-icon">📱</div>
                                    <div class="qris-info-text">
                                        <strong>Cara bayar dengan QRIS:</strong><br>
                                        Setelah klik lanjut, Anda akan mendapatkan kode QR yang bisa dipindai menggunakan aplikasi e-wallet atau mobile banking favorit Anda.
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </label>
                <?php endforeach; ?>

                <button type="submit" class="submit-btn" id="submitBtn" disabled>
                    <span>Lanjut ke Instruksi Pembayaran</span>
                    <i class="fas fa-arrow-right"></i>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    // Handle method selection
    const methodCards = document.querySelectorAll('.method-card');
    const submitBtn = document.getElementById('submitBtn');

    methodCards.forEach(card => {
        card.addEventListener('click', function() {
            // Remove selected class from all cards
            methodCards.forEach(c => c.classList.remove('selected'));

            // Add selected class to clicked card
            this.classList.add('selected');

            // Check the radio button
            const radio = this.querySelector('input[type="radio"]');
            radio.checked = true;

            // Enable submit button
            submitBtn.disabled = false;
        });
    });

    // Countdown timer
    <?php if ($payment_expiry): ?>
        const expiryTime = new Date('<?php echo date('Y-m-d H:i:s', strtotime($payment_expiry)); ?>').getTime();

        setInterval(function() {
            const now = new Date().getTime();
            const distance = expiryTime - now;

            if (distance < 0) {
                document.querySelector('.expiry-time').innerHTML = '<i class="fas fa-times-circle"></i> Waktu pembayaran habis';
                document.querySelector('.payment-expiry').style.background = '#fee2e2';
                document.querySelector('.payment-expiry').style.borderColor = '#fca5a5';
                submitBtn.disabled = true;

                // Redirect to bookings page after 2 seconds
                setTimeout(function() {
                    window.location.href = '<?php echo BASEURL; ?>user/bookings';
                }, 2000);
            }
        }, 1000);
    <?php endif; ?>
</script>