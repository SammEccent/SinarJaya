<div class="admin-header">
    <div class="admin-title">
        <h1><?php echo isset($payment) ? 'Edit Pembayaran' : 'Buat Pembayaran Baru'; ?></h1>
        <p><?php echo isset($payment) ? 'Ubah informasi pembayaran' : 'Tambahkan pembayaran baru ke sistem'; ?></p>
    </div>
</div>

<div class="admin-body">
    <div class="form-container">
        <form action="<?php echo isset($payment) ? BASEURL . 'admin/payments/' . $payment['id'] . '/update' : BASEURL . 'admin/payments/store'; ?>" method="POST" class="form-section">

            <div class="form-group">
                <label for="booking_id">Booking <span style="color: #dc2626;">*</span></label>
                <?php if (isset($payment)): ?>
                    <!-- Show booking info if editing -->
                    <div style="padding: 10px; background: #f3f4f6; border-radius: 6px; margin-bottom: 10px;">
                        <strong><?php echo htmlspecialchars($payment['booking_code']); ?></strong> -
                        <?php echo htmlspecialchars($payment['name']); ?>
                        (Rp <?php echo number_format($payment['total_amount'], 0, ',', '.'); ?>)
                    </div>
                    <input type="hidden" name="booking_id" value="<?php echo $payment['booking_id']; ?>">
                <?php else: ?>
                    <!-- Dropdown for creating new payment -->
                    <select name="booking_id" id="booking_id" required>
                        <option value="">-- Pilih Booking --</option>
                        <?php if (!empty($bookings)): ?>
                            <?php foreach ($bookings as $booking): ?>
                                <option value="<?php echo $booking['id']; ?>">
                                    <?php echo htmlspecialchars($booking['booking_code']); ?> -
                                    <?php echo htmlspecialchars($booking['name']); ?>
                                    (Rp <?php echo number_format($booking['total_amount'], 0, ',', '.'); ?>)
                                </option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option value="" disabled>Tidak ada booking yang tersedia</option>
                        <?php endif; ?>
                    </select>
                <?php endif; ?>
                <small style="color: #6b7280;">Pilih booking yang akan diproses pembayarannya</small>
            </div>

            <div class="form-group">
                <label for="payment_method">Metode Pembayaran <span style="color: #dc2626;">*</span></label>
                <select name="payment_method" id="payment_method" required>
                    <option value="">-- Pilih Metode --</option>
                    <option value="bank_transfer" <?php echo (isset($payment) && $payment['payment_method'] === 'bank_transfer') ? 'selected' : ''; ?>>
                        Transfer Bank
                    </option>
                    <option value="credit_card" <?php echo (isset($payment) && $payment['payment_method'] === 'credit_card') ? 'selected' : ''; ?>>
                        Kartu Kredit
                    </option>
                    <option value="e_wallet" <?php echo (isset($payment) && $payment['payment_method'] === 'e_wallet') ? 'selected' : ''; ?>>
                        E-Wallet
                    </option>
                    <option value="qris" <?php echo (isset($payment) && $payment['payment_method'] === 'qris') ? 'selected' : ''; ?>>
                        QRIS
                    </option>
                </select>
                <small style="color: #6b7280;">Metode pembayaran yang digunakan pelanggan</small>
            </div>

            <div class="form-group">
                <label for="payment_code">Kode Pembayaran</label>
                <input
                    type="text"
                    name="payment_code"
                    id="payment_code"
                    placeholder="Contoh: PAY-QRIS-9921"
                    value="<?php echo isset($payment) ? htmlspecialchars($payment['payment_code'] ?? '') : ''; ?>">
                <small style="color: #6b7280;">Kode referensi atau invoice dari metode pembayaran</small>
            </div>

            <div class="form-group">
                <label for="amount">Jumlah Pembayaran <span style="color: #dc2626;">*</span></label>
                <div style="display: flex; align-items: center;">
                    <span style="padding: 10px; background: #f3f4f6; border-radius: 6px 0 0 6px; border: 1px solid #d1d5db; border-right: none;">Rp</span>
                    <input
                        type="number"
                        name="amount"
                        id="amount"
                        placeholder="250000"
                        step="100"
                        min="0"
                        required
                        value="<?php echo isset($payment) ? $payment['amount'] : ''; ?>"
                        style="border-radius: 0 6px 6px 0;">
                </div>
                <small style="color: #6b7280;">Jumlah pembayaran tanpa desimal</small>
            </div>

            <!-- Status field only shown when editing -->
            <?php if (isset($payment)): ?>
                <div class="form-group">
                    <label>Status Pembayaran</label>
                    <div style="padding: 10px; background: #f3f4f6; border-radius: 6px; border: 1px solid #d1d5db;">
                        <span style="padding: 6px 12px; border-radius: 4px; font-weight: 500; font-size: 0.9rem;
                        <?php
                        $status = $payment['payment_status'];
                        if ($status === 'paid'):
                            echo 'background: #d1fae5; color: #065f46;';
                        elseif ($status === 'pending'):
                            echo 'background: #fef3c7; color: #92400e;';
                        elseif ($status === 'failed'):
                            echo 'background: #fee2e2; color: #991b1b;';
                        elseif ($status === 'refunded'):
                            echo 'background: #e0e7ff; color: #3730a3;';
                        endif;
                        ?>
                        ">
                            <?php
                            $status_labels = [
                                'pending' => 'Menunggu Verifikasi',
                                'paid' => 'Sudah Dibayar',
                                'failed' => 'Gagal',
                                'refunded' => 'Dikembalikan'
                            ];
                            echo htmlspecialchars($status_labels[$status] ?? ucfirst($status));
                            ?>
                        </span>
                    </div>
                    <small style="color: #6b7280;">Ubah status di halaman detail pembayaran</small>
                </div>

                <div class="form-group">
                    <label>Tanggal Pembayaran</label>
                    <div style="padding: 10px; background: #f3f4f6; border-radius: 6px; border: 1px solid #d1d5db;">
                        <?php
                        if ($payment['paid_at']):
                            echo date('d/m/Y H:i:s', strtotime($payment['paid_at']));
                        else:
                            echo 'Belum dibayarkan';
                        endif;
                        ?>
                    </div>
                </div>
            <?php endif; ?>

            <div style="display: flex; gap: 10px; margin-top: 30px;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    <?php echo isset($payment) ? 'Simpan Perubahan' : 'Buat Pembayaran'; ?>
                </button>
                <a href="<?php echo isset($payment) ? BASEURL . 'admin/payments/' . $payment['id'] : BASEURL . 'admin/payments'; ?>" class="btn btn-outline">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>

<style>
    .form-container {
        background-color: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        max-width: 600px;
        margin: 0 auto;
    }

    .form-section {
        display: flex;
        flex-direction: column;
    }

    .form-group {
        margin-bottom: 25px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #1f2937;
        font-size: 0.95rem;
    }

    .form-group input[type="text"],
    .form-group input[type="number"],
    .form-group input[type="email"],
    .form-group input[type="date"],
    .form-group input[type="time"],
    .form-group textarea,
    .form-group select {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        font-family: inherit;
        font-size: 0.95rem;
        color: #1f2937;
        background: white;
        transition: all 0.3s ease;
        box-sizing: border-box;
    }

    .form-group input:focus,
    .form-group textarea:focus,
    .form-group select:focus {
        outline: none;
        border-color: #1e40af;
        box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
    }

    .form-group small {
        display: block;
        margin-top: 6px;
    }

    .btn {
        display: inline-block;
        padding: 10px 16px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 500;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 0.95rem;
    }

    .btn-primary {
        background-color: #1e40af;
        color: white;
    }

    .btn-primary:hover {
        background-color: #1e3a8a;
    }

    .btn-outline {
        background-color: transparent;
        color: #1e40af;
        border: 1px solid #1e40af;
    }

    .btn-outline:hover {
        background-color: #eff6ff;
    }

    select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%231f2937' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        padding-right: 35px;
    }

    @media (max-width: 768px) {
        .form-container {
            padding: 20px;
            max-width: 100%;
        }
    }
</style>