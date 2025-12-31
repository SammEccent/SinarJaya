<style>
    .instructions-container {
        max-width: 900px;
        margin: 40px auto;
        padding: 0 20px;
    }

    .instructions-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 30px;
        border-radius: 16px;
        margin-bottom: 30px;
        text-align: center;
    }

    .instructions-header h1 {
        margin: 0 0 10px 0;
        font-size: 28px;
        font-weight: 700;
    }

    .payment-code-box {
        background: rgba(255, 255, 255, 0.2);
        padding: 15px;
        border-radius: 12px;
        margin-top: 15px;
        display: inline-block;
    }

    .payment-code-label {
        font-size: 13px;
        opacity: 0.9;
        margin-bottom: 5px;
    }

    .payment-code {
        font-size: 24px;
        font-weight: 700;
        letter-spacing: 2px;
    }

    .status-banner {
        background: #fef3c7;
        border: 2px solid #fbbf24;
        padding: 20px;
        border-radius: 12px;
        margin-bottom: 30px;
        text-align: center;
    }

    .status-banner.success {
        background: #d1fae5;
        border-color: #10b981;
    }

    .status-icon {
        font-size: 48px;
        margin-bottom: 10px;
    }

    .status-text {
        font-size: 18px;
        font-weight: 700;
        color: #92400e;
        margin-bottom: 5px;
    }

    .status-banner.success .status-text {
        color: #065f46;
    }

    .status-desc {
        font-size: 14px;
        color: #92400e;
    }

    .status-banner.success .status-desc {
        color: #047857;
    }

    .payment-amount {
        background: white;
        border: 2px solid #e5e7eb;
        border-radius: 16px;
        padding: 30px;
        margin-bottom: 30px;
        text-align: center;
    }

    .amount-label {
        font-size: 16px;
        color: #6b7280;
        margin-bottom: 10px;
    }

    .amount-value {
        font-size: 36px;
        font-weight: 700;
        color: #667eea;
        margin-bottom: 20px;
    }

    .copy-btn {
        background: #667eea;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .copy-btn:hover {
        background: #5568d3;
        transform: translateY(-2px);
    }

    .instructions-section {
        background: white;
        border: 2px solid #e5e7eb;
        border-radius: 16px;
        padding: 30px;
        margin-bottom: 30px;
    }

    .section-title {
        font-size: 20px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .bank-accounts,
    .wallet-accounts {
        display: grid;
        gap: 15px;
        margin-bottom: 30px;
    }

    .account-card {
        background: #f9fafb;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .account-info {
        flex: 1;
    }

    .account-name {
        font-size: 18px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 5px;
    }

    .account-number {
        font-size: 20px;
        font-weight: 600;
        color: #667eea;
        margin-bottom: 3px;
        letter-spacing: 1px;
    }

    .account-holder {
        font-size: 13px;
        color: #6b7280;
    }

    .copy-account-btn {
        background: #667eea;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 8px;
        cursor: pointer;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .copy-account-btn:hover {
        background: #5568d3;
    }

    .qr-code-container {
        text-align: center;
        padding: 30px;
        background: #f9fafb;
        border-radius: 12px;
        margin-bottom: 30px;
    }

    .qr-code-image {
        max-width: 300px;
        width: 100%;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 20px;
        background: white;
    }

    .steps-list {
        list-style: none;
        padding: 0;
        counter-reset: step-counter;
    }

    .step-item {
        position: relative;
        padding-left: 50px;
        margin-bottom: 20px;
        counter-increment: step-counter;
    }

    .step-item::before {
        content: counter(step-counter);
        position: absolute;
        left: 0;
        top: 0;
        width: 35px;
        height: 35px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
    }

    .step-text {
        font-size: 15px;
        color: #4b5563;
        line-height: 1.6;
    }

    .upload-section {
        background: white;
        border: 2px solid #e5e7eb;
        border-radius: 16px;
        padding: 30px;
    }

    .upload-form {
        margin-top: 20px;
    }

    .file-input-wrapper {
        border: 2px dashed #d1d5db;
        border-radius: 12px;
        padding: 40px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .file-input-wrapper:hover {
        border-color: #667eea;
        background: #f9fafb;
    }

    .file-input-wrapper.dragover {
        border-color: #667eea;
        background: #f0f4ff;
    }

    .file-input {
        display: none;
    }

    .upload-icon {
        font-size: 48px;
        color: #9ca3af;
        margin-bottom: 15px;
    }

    .upload-text {
        font-size: 16px;
        color: #6b7280;
        margin-bottom: 10px;
    }

    .upload-hint {
        font-size: 13px;
        color: #9ca3af;
    }

    .file-preview {
        margin-top: 20px;
        display: none;
    }

    .file-preview.show {
        display: block;
    }

    .preview-image {
        max-width: 100%;
        border-radius: 12px;
        border: 2px solid #e5e7eb;
    }

    .upload-btn {
        width: 100%;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        padding: 16px;
        border-radius: 12px;
        border: none;
        font-weight: 700;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 20px;
    }

    .upload-btn:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
    }

    .upload-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
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
</style>

<div class="instructions-container">
    <div class="instructions-header">
        <h1><i class="fas fa-file-invoice-dollar"></i> Instruksi Pembayaran</h1>
        <p>Ikuti langkah-langkah di bawah untuk menyelesaikan pembayaran</p>

        <div class="payment-code-box">
            <div class="payment-code-label">Kode Pembayaran</div>
            <div class="payment-code"><?php echo htmlspecialchars($payment['payment_code']); ?></div>
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

    <?php if ($payment['payment_proof_image']): ?>
        <div class="status-banner success">
            <div class="status-icon">✓</div>
            <div class="status-text">Bukti Pembayaran Sudah Diupload</div>
            <div class="status-desc">Menunggu verifikasi dari admin (maksimal 2x24 jam)</div>
        </div>
    <?php else: ?>
        <div class="status-banner">
            <div class="status-icon">⏳</div>
            <div class="status-text">Menunggu Pembayaran</div>
            <div class="status-desc">Silakan lakukan pembayaran dan upload bukti transfer</div>
        </div>
    <?php endif; ?>

    <div class="payment-amount">
        <div class="amount-label">Jumlah yang Harus Dibayar</div>
        <div class="amount-value">Rp <?php echo number_format($payment['amount'], 0, ',', '.'); ?></div>
        <button class="copy-btn" onclick="copyAmount(<?php echo $payment['amount']; ?>)">
            <i class="fas fa-copy"></i> Salin Nominal
        </button>
    </div>

    <div class="instructions-section">
        <div class="section-title">
            <i class="fas <?php echo $instructions['icon'] ?? 'fa-info-circle'; ?>"></i>
            <?php echo $instructions['title'] ?? 'Cara Pembayaran'; ?>
        </div>

        <?php if (isset($instructions['banks'])): ?>
            <div class="bank-accounts">
                <?php foreach ($instructions['banks'] as $bank): ?>
                    <div class="account-card">
                        <div class="account-info">
                            <div class="account-name"><?php echo $bank['name']; ?></div>
                            <div class="account-number"><?php echo $bank['account']; ?></div>
                            <div class="account-holder">a.n. <?php echo $bank['holder']; ?></div>
                        </div>
                        <button class="copy-account-btn" onclick="copyText('<?php echo $bank['account']; ?>')">
                            <i class="fas fa-copy"></i> Salin
                        </button>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (isset($instructions['wallets'])): ?>
            <div class="wallet-accounts">
                <?php foreach ($instructions['wallets'] as $wallet): ?>
                    <div class="account-card">
                        <div class="account-info">
                            <div class="account-name"><?php echo $wallet['name']; ?></div>
                            <div class="account-number"><?php echo $wallet['number']; ?></div>
                        </div>
                        <button class="copy-account-btn" onclick="copyText('<?php echo $wallet['number']; ?>')">
                            <i class="fas fa-copy"></i> Salin
                        </button>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (isset($instructions['qr_code'])): ?>
            <div class="qr-code-container">
                <img src="<?php echo BASEURL; ?>assets/images/<?php echo $instructions['qr_code']; ?>"
                    alt="QR Code"
                    class="qr-code-image"
                    onerror="this.src='<?php echo BASEURL; ?>assets/images/qris-placeholder.png'">
                <p style="margin-top: 15px; color: #6b7280;">Scan kode QR di atas menggunakan aplikasi e-wallet Anda</p>
            </div>
        <?php endif; ?>

        <?php if (isset($instructions['steps'])): ?>
            <div class="section-title" style="font-size: 18px; margin-top: 30px;">
                <i class="fas fa-list-check"></i>
                Langkah-Langkah Pembayaran
            </div>
            <ol class="steps-list">
                <?php foreach ($instructions['steps'] as $step): ?>
                    <li class="step-item">
                        <div class="step-text"><?php echo $step; ?></div>
                    </li>
                <?php endforeach; ?>
            </ol>
        <?php endif; ?>
    </div>

    <?php if (!$payment['payment_proof_image']): ?>
        <div class="upload-section">
            <div class="section-title">
                <i class="fas fa-cloud-upload-alt"></i>
                Upload Bukti Pembayaran
            </div>

            <form action="<?php echo BASEURL; ?>payment/uploadProof" method="POST" enctype="multipart/form-data" id="uploadForm">
                <input type="hidden" name="payment_id" value="<?php echo $payment['id']; ?>">

                <div class="file-input-wrapper" onclick="document.getElementById('fileInput').click()">
                    <input type="file"
                        name="payment_proof"
                        id="fileInput"
                        class="file-input"
                        accept="image/jpeg,image/jpg,image/png"
                        required
                        onchange="previewFile(this)">
                    <div class="upload-icon">
                        <i class="fas fa-cloud-upload-alt"></i>
                    </div>
                    <div class="upload-text">Klik untuk pilih file atau drag & drop</div>
                    <div class="upload-hint">Format: JPG, JPEG, PNG (Maksimal 2MB)</div>
                </div>

                <div class="file-preview" id="filePreview">
                    <img src="" alt="Preview" class="preview-image" id="previewImage">
                </div>

                <button type="submit" class="upload-btn" id="uploadBtn">
                    <i class="fas fa-upload"></i>
                    Upload Bukti Pembayaran
                </button>
            </form>
        </div>
    <?php else: ?>
        <div class="upload-section">
            <div class="section-title">
                <i class="fas fa-check-circle"></i>
                Bukti Pembayaran
            </div>
            <div style="text-align: center; padding: 20px;">
                <img src="<?php echo BASEURL . $payment['payment_proof_image']; ?>"
                    alt="Bukti Pembayaran"
                    style="max-width: 100%; border-radius: 12px; border: 2px solid #e5e7eb;">
                <p style="margin-top: 15px; color: #6b7280;">
                    Bukti pembayaran sudah diupload. Menunggu verifikasi admin.
                </p>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
    function copyText(text) {
        navigator.clipboard.writeText(text).then(() => {
            alert('Nomor rekening berhasil disalin!');
        });
    }

    function copyAmount(amount) {
        navigator.clipboard.writeText(amount.toString()).then(() => {
            alert('Nominal berhasil disalin!');
        });
    }

    function previewFile(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('previewImage').src = e.target.result;
                document.getElementById('filePreview').classList.add('show');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Drag and drop
    const dropZone = document.querySelector('.file-input-wrapper');

    dropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropZone.classList.add('dragover');
    });

    dropZone.addEventListener('dragleave', () => {
        dropZone.classList.remove('dragover');
    });

    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.classList.remove('dragover');

        const files = e.dataTransfer.files;
        if (files.length > 0) {
            document.getElementById('fileInput').files = files;
            previewFile(document.getElementById('fileInput'));
        }
    });
</script>