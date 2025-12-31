<div class="admin-header">
    <div class="admin-title">
        <h1>Kelola Pembayaran</h1>
        <p>Kelola dan verifikasi pembayaran dari pelanggan</p>
    </div>
</div>

<div class="admin-body">
    <!-- Statistics Cards -->
    <div class="stats-container">
        <div class="stat-card">
            <div class="stat-icon" style="background: #dbeafe; color: #1e40af;">
                <i class="fas fa-credit-card"></i>
            </div>
            <div class="stat-content">
                <p class="stat-label">Total Pembayaran</p>
                <p class="stat-value"><?php echo isset($statistics['total_payments']) ? $statistics['total_payments'] : 0; ?></p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: #d1fae5; color: #065f46;">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-content">
                <p class="stat-label">Pembayaran Sukses</p>
                <p class="stat-value"><?php echo isset($statistics['paid_payments']) ? $statistics['paid_payments'] : 0; ?></p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: #fef3c7; color: #92400e;">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-content">
                <p class="stat-label">Menunggu Verifikasi</p>
                <p class="stat-value"><?php echo isset($statistics['pending_payments']) ? $statistics['pending_payments'] : 0; ?></p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: #fee2e2; color: #991b1b;">
                <i class="fas fa-redo"></i>
            </div>
            <div class="stat-content">
                <p class="stat-label">Total Refund</p>
                <p class="stat-value"><?php echo isset($statistics['refunded_payments']) ? $statistics['refunded_payments'] : 0; ?></p>
            </div>
        </div>
    </div>

    <div class="section">
        <!-- Search and Filter -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 10px;">
            <h2>Daftar Pembayaran</h2>
            <form action="" method="GET" style="display: flex; gap: 10px; flex-wrap: wrap;">
                <input type="text" name="search" placeholder="Cari booking, customer, atau kode pembayaran..." value="<?php echo htmlspecialchars($search ?? ''); ?>" style="padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; min-width: 300px;">
                <button type="submit" class="btn btn-primary" style="padding: 8px 16px;">Cari</button>
                <?php if ($search): ?>
                    <a href="<?php echo BASEURL; ?>admin/payments" class="btn btn-outline" style="padding: 8px 16px;">Reset</a>
                <?php endif; ?>
            </form>
        </div>

        <?php if (!empty($payments)): ?>
            <div style="overflow-x: auto; border-radius: 8px;">
                <table class="data-table" style="font-size: 0.95rem;">
                    <thead>
                        <tr>
                            <th>Booking Code</th>
                            <th>Customer</th>
                            <th>Metode</th>
                            <th style="text-align: right;">Jumlah</th>
                            <th>Status</th>
                            <th style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($payments as $payment): ?>
                            <tr>
                                <td><strong><?php echo htmlspecialchars($payment['booking_code']); ?></strong></td>
                                <td>
                                    <div style="margin: 0;"><?php echo htmlspecialchars($payment['name']); ?></div>
                                    <small style="color: #6b7280; display: block; margin-top: 2px;"><?php echo htmlspecialchars($payment['email']); ?></small>
                                </td>
                                <td>
                                    <?php
                                    $method_labels = [
                                        'bank_transfer' => 'Transfer',
                                        'credit_card' => 'Kartu',
                                        'e_wallet' => 'E-Wallet',
                                        'qris' => 'QRIS'
                                    ];
                                    $method = $payment['payment_method'];
                                    echo htmlspecialchars($method_labels[$method] ?? $method);
                                    ?>
                                </td>
                                <td style="text-align: right; font-weight: 500;">Rp <?php echo number_format($payment['amount'], 0, ',', '.'); ?></td>
                                <td>
                                    <span style="padding: 4px 8px; border-radius: 4px; font-size: 0.85rem; font-weight: 500; white-space: nowrap;
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
                                            'pending' => 'Pending',
                                            'paid' => 'Dibayar',
                                            'failed' => 'Gagal',
                                            'refunded' => 'Dikembalikan'
                                        ];
                                        echo htmlspecialchars($status_labels[$status] ?? ucfirst($status));
                                        ?>
                                    </span>
                                </td>
                                <td style="text-align: center; white-space: nowrap;">
                                    <a href="<?php echo BASEURL; ?>admin/payments/<?php echo $payment['id']; ?>" class="btn btn-primary" style="padding: 5px 10px; font-size: 0.8rem; margin: 2px;">Detail</a>
                                    <?php if ($payment['payment_status'] === 'pending'): ?>
                                        <a href="<?php echo BASEURL; ?>admin/payments/edit/<?php echo $payment['id']; ?>" class="btn btn-outline" style="padding: 5px 10px; font-size: 0.8rem; margin: 2px;">Edit</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php if ($totalPages > 1): ?>
                <div style="margin-top: 20px; display: flex; justify-content: center; gap: 8px; flex-wrap: wrap;">
                    <?php if ($page > 1): ?>
                        <a href="<?php echo BASEURL; ?>admin/payments?page=1<?php echo $search ? '&search=' . urlencode($search) : ''; ?>" class="btn btn-outline" style="padding: 8px 12px;">« Pertama</a>
                        <a href="<?php echo BASEURL; ?>admin/payments?page=<?php echo $page - 1; ?><?php echo $search ? '&search=' . urlencode($search) : ''; ?>" class="btn btn-outline" style="padding: 8px 12px;">‹ Sebelumnya</a>
                    <?php endif; ?>

                    <?php
                    $start = max(1, $page - 2);
                    $end = min($totalPages, $page + 2);
                    if ($start > 1): ?>
                        <span style="padding: 8px 12px;">...</span>
                    <?php endif;

                    for ($i = $start; $i <= $end; $i++): ?>
                        <?php if ($i === $page): ?>
                            <span style="padding: 8px 12px; background: #1e40af; color: white; border-radius: 6px; font-weight: 500;"><?php echo $i; ?></span>
                        <?php else: ?>
                            <a href="<?php echo BASEURL; ?>admin/payments?page=<?php echo $i; ?><?php echo $search ? '&search=' . urlencode($search) : ''; ?>" class="btn btn-outline" style="padding: 8px 12px;"><?php echo $i; ?></a>
                        <?php endif; ?>
                    <?php endfor;

                    if ($end < $totalPages): ?>
                        <span style="padding: 8px 12px;">...</span>
                    <?php endif; ?>

                    <?php if ($page < $totalPages): ?>
                        <a href="<?php echo BASEURL; ?>admin/payments?page=<?php echo $page + 1; ?><?php echo $search ? '&search=' . urlencode($search) : ''; ?>" class="btn btn-outline" style="padding: 8px 12px;">Selanjutnya ›</a>
                        <a href="<?php echo BASEURL; ?>admin/payments?page=<?php echo $totalPages; ?><?php echo $search ? '&search=' . urlencode($search) : ''; ?>" class="btn btn-outline" style="padding: 8px 12px;">Terakhir »</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div style="text-align: center; padding: 40px; background: #f9fafb; border-radius: 10px; color: #6b7280;">
                <i class="fas fa-wallet" style="font-size: 2.5rem; margin-bottom: 15px; display: block; opacity: 0.5;"></i>
                <p style="font-size: 1.1rem; margin-bottom: 15px;">Belum ada data pembayaran</p>
                <p style="margin-bottom: 20px;">Pembayaran dari pelanggan akan muncul di sini</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
    .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 15px;
        margin-bottom: 20px;
    }

    .stat-card {
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        display: flex;
        gap: 15px;
        align-items: center;
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .stat-content {
        flex: 1;
    }

    .stat-label {
        margin: 0;
        color: #6b7280;
        font-size: 0.9rem;
    }

    .stat-value {
        margin: 5px 0 0;
        font-size: 1.8rem;
        font-weight: bold;
        color: #1f2937;
    }

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

    .data-table {
        width: 100%;
        border-collapse: collapse;
    }

    .data-table thead {
        background-color: #f3f4f6;
    }

    .data-table th {
        padding: 12px;
        text-align: left;
        font-weight: 600;
        color: #374151;
        border-bottom: 2px solid #e5e7eb;
    }

    .data-table td {
        padding: 12px;
        border-bottom: 1px solid #e5e7eb;
        color: #374151;
    }

    .data-table tbody tr:hover {
        background-color: #f9fafb;
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

    input[type="text"] {
        border: 1px solid #d1d5db;
        padding: 8px 12px;
        border-radius: 6px;
        font-size: 0.95rem;
    }

    input[type="text"]:focus {
        outline: none;
        border-color: #1e40af;
        box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
    }
</style>