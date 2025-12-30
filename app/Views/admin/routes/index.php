<div class="admin-header">
    <div class="admin-title">
        <h1>Kelola Rute</h1>
        <p>Kelola rute perjalanan dan lokasi penghentian</p>
    </div>
</div>

<div class="admin-body">
    <div class="section">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2>Daftar Rute</h2>
            <a href="<?php echo BASEURL; ?>admin/routes/create" class="btn btn-primary">+ Tambah Rute</a>
        </div>

        <?php if (!empty($routes)): ?>
            <div style="overflow-x: auto;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Kode Rute</th>
                            <th>Asal</th>
                            <th>Tujuan</th>
                            <th>Status</th>
                            <th style="width: 240px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($routes as $route): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($route['route_id']); ?></td>
                                <td><strong><?php echo htmlspecialchars($route['route_code']); ?></strong></td>
                                <td><?php echo htmlspecialchars($route['origin_city']); ?></td>
                                <td><?php echo htmlspecialchars($route['destination_city']); ?></td>
                                <td>
                                    <span style="padding: 4px 8px; border-radius: 4px; font-size: 0.85rem; font-weight: 500;
                                    <?php if ($route['status'] === 'active'): ?>
                                        background: #d1fae5; color: #065f46;
                                    <?php else: ?>
                                        background: #fee2e2; color: #991b1b;
                                    <?php endif; ?>
                                    "><?php echo ucfirst(htmlspecialchars($route['status'])); ?></span>
                                </td>
                                <td style="display: flex; gap: 8px; flex-wrap: wrap;">
                                    <a href="<?php echo BASEURL; ?>admin/routes/<?php echo $route['route_id']; ?>/locations" class="btn btn-outline" style="padding: 6px 10px; font-size: 0.85rem;">Lokasi</a>
                                    <a href="<?php echo BASEURL; ?>admin/routes/edit/<?php echo $route['route_id']; ?>" class="btn btn-primary" style="padding: 6px 10px; font-size: 0.85rem;">Edit</a>
                                    <a href="<?php echo BASEURL; ?>admin/routes/delete/<?php echo $route['route_id']; ?>" class="btn btn-danger" style="padding: 6px 10px; font-size: 0.85rem;" onclick="return confirm('Anda yakin ingin menghapus rute ini?')">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div style="text-align: center; padding: 40px; background: #f9fafb; border-radius: 10px; color: #6b7280;">
                <i class="fas fa-road" style="font-size: 2.5rem; margin-bottom: 15px; display: block; opacity: 0.5;"></i>
                <p style="font-size: 1.1rem; margin-bottom: 15px;">Belum ada data rute</p>
                <p style="margin-bottom: 20px;">Mulai dengan menambahkan rute pertama Anda</p>
                <a href="<?php echo BASEURL; ?>admin/routes/create" class="btn btn-primary">Tambah Rute Baru</a>
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
        padding: 8px 16px;
        border-radius: 6px;
        text-decoration: none;
        display: inline-block;
        font-weight: 500;
        font-size: 0.9rem;
        cursor: pointer;
        border: none;
        transition: all 0.2s ease;
    }

    .btn-primary {
        background-color: #3b82f6;
        color: white;
    }

    .btn-primary:hover {
        background-color: #2563eb;
        box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3);
    }

    .btn-outline {
        background-color: white;
        color: #3b82f6;
        border: 1px solid #3b82f6;
    }

    .btn-outline:hover {
        background-color: #f0f9ff;
    }

    .btn-danger {
        background-color: #ef4444;
        color: white;
    }

    .btn-danger:hover {
        background-color: #dc2626;
        box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
    }
</style>