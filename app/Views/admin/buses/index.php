<div class="admin-header">
    <div class="admin-title">
        <h1>Kelola Bus</h1>
        <p>Kelola daftar bus perusahaan Anda</p>
    </div>
</div>

<div class="admin-body">
    <div class="section">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2>Daftar Bus</h2>
            <a href="<?php echo BASEURL; ?>admin/buses/create" class="btn btn-primary">+ Tambah Bus</a>
        </div>

        <?php if (!empty($buses)): ?>
            <div style="overflow-x: auto;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Plat Nomor</th>
                            <th>Kelas Bus</th>
                            <th>Total Kursi</th>
                            <th>Layout</th>
                            <th>Status</th>
                            <th style="width: 220px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($buses as $bus): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($bus['id']); ?></td>
                                <td><strong><?php echo htmlspecialchars($bus['plate_number']); ?></strong></td>
                                <td>
                                    <?php $cname = htmlspecialchars($bus['class_name'] ?? '-'); ?>
                                    <?php $cdesc = htmlspecialchars($bus['class_description'] ?? ''); ?>
                                    <?php $cfeat = htmlspecialchars($bus['class_facilities'] ?? ''); ?>
                                    <span class="bus-class-tooltip" tabindex="0" data-desc="<?php echo $cdesc; ?>" data-feat="<?php echo $cfeat; ?>"><?php echo $cname; ?></span>
                                </td>
                                <td><span style="background: #e0e7ff; color: #2563eb; padding: 4px 8px; border-radius: 4px; font-weight: 600;"><?php echo htmlspecialchars($bus['total_seats']); ?> Kursi</span></td>
                                <td><?php echo htmlspecialchars($bus['seat_layout']); ?></td>
                                <td>
                                    <span style="padding: 4px 8px; border-radius: 4px; font-size: 0.85rem; font-weight: 500;
                                    <?php if ($bus['status'] === 'active'): ?>
                                        background: #d1fae5; color: #065f46;
                                    <?php elseif ($bus['status'] === 'maintenance'): ?>
                                        background: #fef3c7; color: #92400e;
                                    <?php else: ?>
                                        background: #fee2e2; color: #991b1b;
                                    <?php endif; ?>
                                    "><?php echo ucfirst(htmlspecialchars($bus['status'])); ?></span>
                                </td>
                                <td style="display: flex; gap: 8px; flex-wrap: wrap;">
                                    <a href="<?php echo BASEURL; ?>admin/buses/<?php echo $bus['id']; ?>/seats" class="btn btn-outline" style="padding: 6px 10px; font-size: 0.85rem;">Kursi</a>
                                    <a href="<?php echo BASEURL; ?>admin/buses/edit/<?php echo $bus['id']; ?>" class="btn btn-primary" style="padding: 6px 10px; font-size: 0.85rem;">Edit</a>
                                    <a href="<?php echo BASEURL; ?>admin/buses/delete/<?php echo $bus['id']; ?>" class="btn btn-danger" style="padding: 6px 10px; font-size: 0.85rem;" onclick="return confirm('Anda yakin ingin menghapus bus ini?')">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div style="text-align: center; padding: 40px; background: #f9fafb; border-radius: 10px; color: #6b7280;">
                <i class="fas fa-bus" style="font-size: 2.5rem; margin-bottom: 15px; display: block; opacity: 0.5;"></i>
                <p style="font-size: 1.1rem; margin-bottom: 15px;">Belum ada data bus</p>
                <p style="margin-bottom: 20px;">Mulai dengan menambahkan bus pertama Anda</p>
                <a href="<?php echo BASEURL; ?>admin/buses/create" class="btn btn-primary">Tambah Bus Baru</a>
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
        color: #374151;
        font-weight: 600;
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

<style>
    /* Tooltip box for bus class */
    .class-tooltip-box {
        position: fixed;
        z-index: 1100;
        background: #ffffff;
        color: #111827;
        border: 1px solid #e5e7eb;
        box-shadow: 0 6px 20px rgba(2, 6, 23, 0.12);
        padding: 12px;
        border-radius: 8px;
        max-width: 320px;
        font-size: 0.95rem;
        line-height: 1.3;
    }

    .class-tooltip-box h4 {
        margin: 0 0 6px 0;
        font-size: 1rem;
    }

    .class-tooltip-box p {
        margin: 0 0 8px 0;
        color: #4b5563;
    }

    .class-tooltip-box .features {
        font-size: 0.9rem;
        color: #374151;
    }

    .bus-class-tooltip {
        cursor: help;
        text-decoration: underline dotted;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let tooltip;

        function createTooltip() {
            tooltip = document.createElement('div');
            tooltip.className = 'class-tooltip-box';
            tooltip.style.display = 'none';
            document.body.appendChild(tooltip);
        }

        function showTooltip(target) {
            if (!tooltip) createTooltip();
            const desc = target.getAttribute('data-desc') || '';
            const feat = target.getAttribute('data-feat') || '';
            let html = '';
            if (desc) html += '<p>' + escapeHtml(desc) + '</p>';
            if (feat) html += '<div class="features"><strong>Fasilitas:</strong><ul style="margin:6px 0 0 18px;padding:0;">' + escapeHtmlList(feat) + '</ul></div>';
            if (!html) html = '<p>Tidak ada deskripsi.</p>';
            tooltip.innerHTML = html;
            tooltip.style.display = 'block';
            const rect = target.getBoundingClientRect();
            // position above if there's space, otherwise below
            const top = (rect.top - tooltip.offsetHeight - 8) > 8 ? (rect.top - tooltip.offsetHeight - 8) : (rect.bottom + 8);
            let left = rect.left;
            // ensure tooltip doesn't overflow right edge
            const maxRight = window.innerWidth - 16;
            if (left + tooltip.offsetWidth > maxRight) left = maxRight - tooltip.offsetWidth;
            if (left < 8) left = 8;
            tooltip.style.top = top + 'px';
            tooltip.style.left = left + 'px';
        }

        function hideTooltip() {
            if (tooltip) tooltip.style.display = 'none';
        }

        function escapeHtml(s) {
            return s.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
        }

        function escapeHtmlList(s) {
            // assume comma-separated facilities
            return s.split(',').map(function(item) {
                return '<li>' + escapeHtml(item.trim()) + '</li>';
            }).join('');
        }

        document.querySelectorAll('.bus-class-tooltip').forEach(function(el) {
            el.addEventListener('mouseenter', function() {
                showTooltip(el);
            });
            el.addEventListener('focus', function() {
                showTooltip(el);
            });
            el.addEventListener('mouseleave', hideTooltip);
            el.addEventListener('blur', hideTooltip);
        });
        // hide on scroll or resize
        window.addEventListener('scroll', hideTooltip, true);
        window.addEventListener('resize', hideTooltip);
    });
</script>