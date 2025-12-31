<div class="admin-header">
    <div class="admin-title">
        <h1>Kelola Jadwal</h1>
        <p>Kelola jadwal keberangkatan bus</p>
    </div>
</div>

<div class="admin-body">
    <div class="section">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2>Daftar Jadwal</h2>
            <div style="display: flex; gap: 10px;">
                <a href="<?php echo BASEURL; ?>admin/schedules/fix-seats" class="btn" style="background: #f59e0b; color: white;" onclick="return confirm('Proses ini akan menghitung ulang kursi tersedia untuk semua jadwal. Lanjutkan?')">
                    <i class="fas fa-wrench"></i> Perbaiki Kursi Tersedia
                </a>
                <a href="<?php echo BASEURL; ?>admin/schedules/create" class="btn btn-primary">+ Tambah Jadwal</a>
            </div>
        </div>

        <?php if (!empty($schedules)): ?>
            <div style="overflow-x: auto;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Bus</th>
                            <th>Rute</th>
                            <th>Berangkat</th>
                            <th>Tiba</th>
                            <th>Harga</th>
                            <th>Kursi Tersedia</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($schedules as $s): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($s['id']); ?></td>
                                <td><?php echo htmlspecialchars($s['plate_number'] ?? '-'); ?></td>
                                <td><?php echo htmlspecialchars(($s['route_code'] ?? '-') . ' (' . ($s['origin_city'] ?? '') . ' - ' . ($s['destination_city'] ?? '') . ')'); ?></td>
                                <td><?php echo htmlspecialchars($s['departure_datetime']); ?></td>
                                <td><?php echo htmlspecialchars($s['arrival_datetime']); ?></td>
                                <td>Rp <?php echo number_format($s['base_price'] ?? 0, 0, ',', '.'); ?></td>
                                <td><?php echo htmlspecialchars($s['available_seats']); ?></td>
                                <td>
                                    <span style="padding: 4px 8px; border-radius: 4px; font-size: 0.85rem; font-weight: 500; <?php echo ($s['status'] === 'scheduled') ? 'background: #d1fae5; color: #065f46;' : (($s['status'] === 'departed') ? 'background: #fef3c7; color: #92400e;' : 'background: #fee2e2; color: #991b1b;'); ?>">
                                        <?php echo ucfirst(htmlspecialchars($s['status'])); ?>
                                    </span>
                                </td>
                                <td style="display: flex; gap: 8px; flex-wrap: wrap; white-space: nowrap;">
                                    <a href="<?php echo BASEURL; ?>admin/schedules/edit/<?php echo $s['id']; ?>" class="btn btn-primary" style="padding: 6px 10px; font-size: 0.85rem;">Edit</a>
                                    <a href="<?php echo BASEURL; ?>admin/schedules/delete/<?php echo $s['id']; ?>" class="btn btn-danger" style="padding: 6px 10px; font-size: 0.85rem;" onclick="return confirm('Anda yakin ingin menghapus jadwal ini?')">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div style="text-align: center; padding: 40px; background: #f9fafb; border-radius: 10px; color: #6b7280;">
                <i class="fas fa-calendar" style="font-size: 2.5rem; margin-bottom: 15px; display: block; opacity: 0.5;"></i>
                <p style="font-size: 1.1rem; margin-bottom: 15px;">Belum ada jadwal</p>
                <p style="margin-bottom: 20px;">Tambahkan jadwal keberangkatan bus</p>
                <a href="<?php echo BASEURL; ?>admin/schedules/create" class="btn btn-primary">Tambah Jadwal Baru</a>
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

    .data-table {
        width: 100%;
        border-collapse: collapse;
        table-layout: auto;
    }

    .data-table thead {
        background-color: #f3f4f6;
    }

    .data-table th {
        padding: 12px 15px;
        text-align: left;
        font-weight: 600;
        color: #374151;
        border-bottom: 2px solid #e5e7eb;
        white-space: nowrap;
    }

    .data-table td {
        padding: 12px 15px;
        border-bottom: 1px solid #e5e7eb;
        color: #374151;
    }

    .data-table tbody tr:hover {
        background-color: #f9fafb;
    }

    @media (max-width: 768px) {
        .data-table {
            font-size: 0.9rem;
        }

        .data-table th,
        .data-table td {
            padding: 8px;
        }
    }
</style>