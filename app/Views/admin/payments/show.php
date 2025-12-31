<div class="admin-header">
    <div class="admin-title">
        <h1>Detail Pembayaran</h1>
        <p>Informasi dan verifikasi pembayaran</p>
    </div>
</div>

<div class="admin-body">
    <div class="section">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
            <h2>Pembayaran #<?php echo htmlspecialchars($payment['id']); ?></h2>
            <a href="<?php echo BASEURL; ?>admin/payments" class="btn btn-outline">← Kembali</a>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; margin-bottom: 30px;">
            <!-- Payment Info Card -->
            <div class="info-card">
                <h3 style="margin-top: 0; color: #1f2937; border-bottom: 2px solid #e5e7eb; padding-bottom: 10px;">Informasi Pembayaran</h3>

                <div class="info-row">
                    <span class="info-label">ID Pembayaran:</span>
                    <span class="info-value"><?php echo htmlspecialchars($payment['id']); ?></span>
                </div>

                <div class="info-row">
                    <span class="info-label">Kode Pembayaran:</span>
                    <span class="info-value"><?php echo htmlspecialchars($payment['payment_code'] ?? '-'); ?></span>
                </div>

                <div class="info-row">
                    <span class="info-label">Jumlah Pembayaran:</span>
                    <span class="info-value" style="font-weight: bold; font-size: 1.2rem; color: #059669;">
                        Rp <?php echo number_format($payment['amount'], 0, ',', '.'); ?>
                    </span>
                </div>

                <div class="info-row">
                    <span class="info-label">Metode Pembayaran:</span>
                    <span class="info-value">
                        <?php
                        $method_labels = [
                            'bank_transfer' => 'Transfer Bank',
                            'credit_card' => 'Kartu Kredit',
                            'e_wallet' => 'E-Wallet',
                            'qris' => 'QRIS'
                        ];
                        $method = $payment['payment_method'];
                        echo htmlspecialchars($method_labels[$method] ?? $method);
                        ?>
                    </span>
                </div>

                <div class="info-row">
                    <span class="info-label">Status Pembayaran:</span>
                    <span style="padding: 6px 12px; border-radius: 6px; font-weight: 500; font-size: 0.9rem;
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

                <div class="info-row">
                    <span class="info-label">Tanggal Pembayaran:</span>
                    <span class="info-value">
                        <?php
                        if ($payment['paid_at']):
                            echo date('d/m/Y H:i:s', strtotime($payment['paid_at']));
                        else:
                            echo '-';
                        endif;
                        ?>
                    </span>
                </div>

                <div class="info-row">
                    <span class="info-label">Dibuat:</span>
                    <span class="info-value"><?php echo date('d/m/Y H:i:s', strtotime($payment['created_at'])); ?></span>
                </div>

                <div class="info-row">
                    <span class="info-label">Diperbarui:</span>
                    <span class="info-value"><?php echo date('d/m/Y H:i:s', strtotime($payment['updated_at'])); ?></span>
                </div>
            </div>

            <!-- Booking Info Card -->
            <div class="info-card">
                <h3 style="margin-top: 0; color: #1f2937; border-bottom: 2px solid #e5e7eb; padding-bottom: 10px;">Informasi Booking</h3>

                <div class="info-row">
                    <span class="info-label">Kode Booking:</span>
                    <span class="info-value"><?php echo htmlspecialchars($payment['booking_code']); ?></span>
                </div>

                <div class="info-row">
                    <span class="info-label">Rute:</span>
                    <span class="info-value">
                        <?php echo htmlspecialchars($payment['origin_city'] . ' → ' . $payment['destination_city']); ?>
                    </span>
                </div>

                <div class="info-row">
                    <span class="info-label">Tanggal Keberangkatan:</span>
                    <span class="info-value">
                        <?php
                        if (!empty($payment['departure_datetime'])):
                            echo date('d/m/Y H:i', strtotime($payment['departure_datetime']));
                        else:
                            echo '-';
                        endif;
                        ?>
                    </span>
                </div>

                <div class="info-row">
                    <span class="info-label">Jumlah Penumpang:</span>
                    <span class="info-value"><?php echo $payment['total_passengers']; ?> orang</span>
                </div>

                <div class="info-row">
                    <span class="info-label">Total Booking:</span>
                    <span class="info-value">
                        Rp <?php echo number_format($payment['total_amount'], 0, ',', '.'); ?>
                    </span>
                </div>

                <div class="info-row">
                    <span class="info-label">Status Booking:</span>
                    <span style="padding: 6px 12px; border-radius: 6px; font-weight: 500; font-size: 0.9rem;
                    <?php
                    $booking_status = $payment['booking_status'];
                    if ($booking_status === 'confirmed'):
                        echo 'background: #d1fae5; color: #065f46;';
                    elseif ($booking_status === 'pending'):
                        echo 'background: #fef3c7; color: #92400e;';
                    elseif ($booking_status === 'cancelled'):
                        echo 'background: #fee2e2; color: #991b1b;';
                    endif;
                    ?>
                    ">
                        <?php
                        $booking_labels = [
                            'pending' => 'Tertunda',
                            'confirmed' => 'Dikonfirmasi',
                            'cancelled' => 'Dibatalkan',
                            'expired' => 'Kadaluarsa'
                        ];
                        echo htmlspecialchars($booking_labels[$booking_status] ?? ucfirst($booking_status));
                        ?>
                    </span>
                </div>

                <div class="info-row">
                    <span class="info-label">Kadaluarsa Pembayaran:</span>
                    <span class="info-value">
                        <?php
                        if ($payment['payment_expiry']):
                            echo date('d/m/Y H:i', strtotime($payment['payment_expiry']));
                        else:
                            echo '-';
                        endif;
                        ?>
                    </span>
                </div>
            </div>

            <!-- Customer Info Card -->
            <div class="info-card">
                <h3 style="margin-top: 0; color: #1f2937; border-bottom: 2px solid #e5e7eb; padding-bottom: 10px;">Informasi Pelanggan</h3>

                <div class="info-row">
                    <span class="info-label">Nama:</span>
                    <span class="info-value"><?php echo htmlspecialchars($payment['name']); ?></span>
                </div>

                <div class="info-row">
                    <span class="info-label">Email:</span>
                    <span class="info-value"><?php echo htmlspecialchars($payment['email']); ?></span>
                </div>

                <div class="info-row">
                    <span class="info-label">Telepon:</span>
                    <span class="info-value"><?php echo htmlspecialchars($payment['phone'] ?? '-'); ?></span>
                </div>

                <div class="info-row">
                    <span class="info-label">Alamat:</span>
                    <span class="info-value"><?php echo htmlspecialchars($payment['address'] ?? '-'); ?></span>
                </div>
            </div>
        </div>

        <!-- Payment Proof Section -->
        <?php if (!empty($payment['payment_proof_image'])): ?>
            <div style="margin-bottom: 30px;">
                <h3 style="margin-top: 0; color: #1f2937; border-bottom: 2px solid #e5e7eb; padding-bottom: 10px;">
                    <i class="fas fa-receipt"></i> Bukti Pembayaran
                </h3>
                <div class="info-card">
                    <div style="text-align: center;">
                        <img
                            src="<?php echo BASEURL . $payment['payment_proof_image']; ?>"
                            alt="Bukti Pembayaran"
                            style="max-width: 100%; max-height: 600px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); cursor: pointer;"
                            onclick="openImageModal(this.src)">
                        <p style="margin-top: 15px; color: #6b7280; font-size: 0.9rem;">
                            <i class="fas fa-info-circle"></i> Klik gambar untuk melihat ukuran penuh
                        </p>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Action Buttons -->
        <?php if ($payment['payment_status'] === 'pending'): ?>
            <div style="background: #f0f9ff; border-left: 4px solid #0284c7; padding: 15px; border-radius: 6px; margin-bottom: 30px;">
                <p style="margin-top: 0; color: #1e40af; font-weight: 500;">Status pembayaran masih dalam verifikasi. Pilih tindakan di bawah:</p>
            </div>

            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                <!-- Approve Form -->
                <form action="<?php echo BASEURL; ?>admin/payments/<?php echo $payment['id']; ?>" method="POST" style="display: inline;">
                    <input type="hidden" name="action" value="approve">
                    <button type="submit" class="btn btn-primary" onclick="return confirm('Setujui pembayaran ini?')">
                        <i class="fas fa-check"></i> Setujui Pembayaran
                    </button>
                </form>

                <!-- Reject Form -->
                <button type="button" class="btn btn-danger" onclick="showRejectForm()">
                    <i class="fas fa-times"></i> Tolak Pembayaran
                </button>

                <!-- Refund Form -->
                <button type="button" class="btn btn-outline" onclick="showRefundForm()">
                    <i class="fas fa-undo"></i> Kembalikan Dana
                </button>
            </div>

            <!-- Reject Form Modal -->
            <div id="rejectForm" style="display: none; margin-top: 20px; padding: 20px; background: #fef2f2; border: 1px solid #fecaca; border-radius: 6px;">
                <h3 style="margin-top: 0; color: #991b1b;">Tolak Pembayaran</h3>
                <form action="<?php echo BASEURL; ?>admin/payments/<?php echo $payment['id']; ?>" method="POST">
                    <input type="hidden" name="action" value="reject">
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 500;">Alasan Penolakan:</label>
                        <textarea name="reason" required style="width: 100%; padding: 10px; border: 1px solid #fca5a5; border-radius: 6px; font-family: inherit; font-size: 0.95rem; min-height: 100px;">Pembayaran ditolak</textarea>
                    </div>
                    <div style="display: flex; gap: 10px;">
                        <button type="submit" class="btn btn-danger">Konfirmasi Penolakan</button>
                        <button type="button" class="btn btn-outline" onclick="hideRejectForm()">Batal</button>
                    </div>
                </form>
            </div>

            <!-- Refund Form Modal -->
            <div id="refundForm" style="display: none; margin-top: 20px; padding: 20px; background: #f0f9ff; border: 1px solid #bae6fd; border-radius: 6px;">
                <h3 style="margin-top: 0; color: #0c4a6e;">Kembalikan Dana</h3>
                <form action="<?php echo BASEURL; ?>admin/payments/<?php echo $payment['id']; ?>" method="POST">
                    <input type="hidden" name="action" value="refund">
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 500;">Alasan Pengembalian Dana:</label>
                        <textarea name="refund_reason" required style="width: 100%; padding: 10px; border: 1px solid #7dd3fc; border-radius: 6px; font-family: inherit; font-size: 0.95rem; min-height: 100px;">Pengembalian dana</textarea>
                    </div>
                    <div style="display: flex; gap: 10px;">
                        <button type="submit" class="btn btn-primary">Konfirmasi Pengembalian</button>
                        <button type="button" class="btn btn-outline" onclick="hideRefundForm()">Batal</button>
                    </div>
                </form>
            </div>
        <?php elseif ($payment['payment_status'] === 'paid'): ?>
            <div style="background: #f0fdf4; border-left: 4px solid #22c55e; padding: 15px; border-radius: 6px; margin-bottom: 30px;">
                <p style="margin: 0; color: #15803d; font-weight: 500;">✓ Pembayaran telah diverifikasi dan diterima</p>
            </div>

            <div>
                <button type="button" class="btn btn-outline" onclick="showRefundForm()">
                    <i class="fas fa-undo"></i> Kembalikan Dana
                </button>

                <!-- Refund Form Modal -->
                <div id="refundForm" style="display: none; margin-top: 20px; padding: 20px; background: #f0f9ff; border: 1px solid #bae6fd; border-radius: 6px;">
                    <h3 style="margin-top: 0; color: #0c4a6e;">Kembalikan Dana</h3>
                    <form action="<?php echo BASEURL; ?>admin/payments/<?php echo $payment['id']; ?>" method="POST">
                        <input type="hidden" name="action" value="refund">
                        <div style="margin-bottom: 15px;">
                            <label style="display: block; margin-bottom: 5px; font-weight: 500;">Alasan Pengembalian Dana:</label>
                            <textarea name="refund_reason" required style="width: 100%; padding: 10px; border: 1px solid #7dd3fc; border-radius: 6px; font-family: inherit; font-size: 0.95rem; min-height: 100px;">Pengembalian dana</textarea>
                        </div>
                        <div style="display: flex; gap: 10px;">
                            <button type="submit" class="btn btn-primary">Konfirmasi Pengembalian</button>
                            <button type="button" class="btn btn-outline" onclick="hideRefundForm()">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        <?php elseif ($payment['payment_status'] === 'refunded'): ?>
            <div style="background: #e0e7ff; border-left: 4px solid #6366f1; padding: 15px; border-radius: 6px;">
                <p style="margin: 0; color: #3730a3; font-weight: 500;">↶ Pembayaran telah dikembalikan ke pelanggan</p>
            </div>
        <?php elseif ($payment['payment_status'] === 'failed'): ?>
            <div style="background: #fef2f2; border-left: 4px solid #ef4444; padding: 15px; border-radius: 6px;">
                <p style="margin: 0; color: #991b1b; font-weight: 500;">✗ Pembayaran ditolak</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
    .section {
        background-color: white;
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

    .info-card {
        background: #f9fafb;
        padding: 20px;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding: 10px 0;
        border-bottom: 1px solid #e5e7eb;
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-label {
        font-weight: 600;
        color: #6b7280;
        min-width: 150px;
    }

    .info-value {
        color: #1f2937;
        text-align: right;
        flex: 1;
        margin-left: 10px;
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

    .btn-danger {
        background-color: #dc2626;
        color: white;
    }

    .btn-danger:hover {
        background-color: #b91c1c;
    }

    textarea {
        border: 1px solid #d1d5db;
        padding: 10px;
        border-radius: 6px;
        font-family: inherit;
        font-size: 0.95rem;
    }

    textarea:focus {
        outline: none;
        border-color: #1e40af;
        box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
    }

    /* Modal styles */
    .image-modal {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.9);
        animation: fadeIn 0.3s;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    .modal-content-img {
        margin: auto;
        display: block;
        max-width: 90%;
        max-height: 90%;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        border-radius: 8px;
    }

    .close-modal {
        position: absolute;
        top: 20px;
        right: 35px;
        color: #f1f1f1;
        font-size: 40px;
        font-weight: bold;
        cursor: pointer;
        transition: 0.3s;
    }

    .close-modal:hover,
    .close-modal:focus {
        color: #bbb;
    }
</style>

<!-- Image Modal -->
<div id="imageModal" class="image-modal" onclick="closeImageModal()">
    <span class="close-modal">&times;</span>
    <img class="modal-content-img" id="modalImage">
</div>

<script>
    function showRejectForm() {
        document.getElementById('rejectForm').style.display = 'block';
        document.getElementById('refundForm').style.display = 'none';
    }

    function hideRejectForm() {
        document.getElementById('rejectForm').style.display = 'none';
    }

    function showRefundForm() {
        document.getElementById('refundForm').style.display = 'block';
        document.getElementById('rejectForm').style.display = 'none';
    }

    function hideRefundForm() {
        document.getElementById('refundForm').style.display = 'none';
    }

    function openImageModal(src) {
        const modal = document.getElementById('imageModal');
        const modalImg = document.getElementById('modalImage');
        modal.style.display = 'block';
        modalImg.src = src;
    }

    function closeImageModal() {
        document.getElementById('imageModal').style.display = 'none';
    }

    // Close modal with Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeImageModal();
        }
    });
</script>