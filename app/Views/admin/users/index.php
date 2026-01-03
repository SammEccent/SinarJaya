<div class="admin-header">
    <h1>Kelola Pengguna</h1>
    <p>Manajemen semua akun pengguna terdaftar</p>
</div>

<div class="admin-body">
    <?php require_once __DIR__ . '/../../partials/admin_alerts.php'; ?>
    <div class="section">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2>Daftar Pengguna</h2>
            <a href="<?php echo BASEURL; ?>admin/users/create" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Pengguna
            </a>
        </div>

        <div class="filter-container" style="margin-bottom: 20px;">
            <form action="<?php echo BASEURL; ?>admin/users" method="GET">
                <input type="text" name="search" placeholder="Cari nama atau email..." value="<?php echo htmlspecialchars($search ?? ''); ?>" style="padding: 8px; width: 300px; border-radius: 5px; border: 1px solid #ccc;">
                <button type="submit" class="btn btn-secondary"><i class="fas fa-search"></i> Cari</button>
            </form>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Telepon</th>
                        <th>Role</th>
                        <th>Bergabung pada</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($users)): ?>
                        <tr>
                            <td colspan="7" style="text-align: center;">Tidak ada pengguna ditemukan.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($user['id']); ?></td>
                                <td><?php echo htmlspecialchars($user['name']); ?></td>
                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                <td><?php echo htmlspecialchars($user['phone'] ?? '-'); ?></td>
                                <td>
                                    <span class="status-badge <?php echo $user['role'] === 'admin' ? 'status-admin' : 'status-user'; ?>">
                                        <?php echo ucfirst(htmlspecialchars($user['role'])); ?>
                                    </span>
                                </td>
                                <td><?php echo date('d/m/Y', strtotime($user['created_at'])); ?></td>
                                <td class="action-links">
                                    <a href="<?php echo BASEURL; ?>admin/users/edit/<?php echo $user['id']; ?>" class="btn-action btn-edit">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="<?php echo BASEURL; ?>admin/users/delete/<?php echo $user['id']; ?>" class="btn-action btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?');">
                                        <i class="fas fa-trash"></i> Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .section {
        background-color: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .table-container {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th,
    td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #e5e7eb;
        vertical-align: middle;
    }

    thead th {
        background-color: #f9fafb;
        font-weight: 600;
        color: #4b5563;
    }

    tbody tr:hover {
        background-color: #f9fafb;
    }

    .action-links {
        display: flex;
        gap: 8px;
    }

    .action-links a {
        text-decoration: none;
        padding: 6px 10px;
        border-radius: 5px;
        font-size: 0.9em;
    }

    .btn-action.btn-edit {
        background-color: #eff6ff;
        color: #1d4ed8;
    }

    .btn-action.btn-delete {
        background-color: #fef2f2;
        color: #b91c1c;
    }

    .status-badge {
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 0.85em;
        font-weight: 500;
        text-transform: capitalize;
    }

    .status-admin {
        background-color: #e0e7ff;
        color: #3730a3;
    }

    .status-user {
        background-color: #e5e7eb;
        color: #4b5563;
    }

    .status-verified {
        background-color: #dcfce7;
        color: #166534;
    }

    .status-not-verified {
        background-color: #fef9c3;
        color: #854d0e;
    }
</style>