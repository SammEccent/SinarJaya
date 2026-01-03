<div class="admin-header">
    <div class="admin-title">
        <h1><?php echo isset($schedule) ? 'Edit Jadwal' : 'Tambah Jadwal'; ?></h1>
        <p><?php echo isset($schedule) ? 'Perbarui informasi jadwal' : 'Buat jadwal keberangkatan baru'; ?></p>
    </div>
</div>

<div class="admin-body">
    <div class="section" style="max-width: 800px;">
        <?php if (!empty($errors) && is_array($errors)): ?>
            <div style="background: #fee2e2; color: #991b1b; padding: 15px; border-radius: 6px; margin-bottom: 20px; border-left: 4px solid #ef4444;">
                <strong>Kesalahan:</strong>
                <ul style="margin: 10px 0 0 20px; padding: 0;">
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
            <div>
                <label for="bus_id" style="display:block; margin-bottom:8px; font-weight:500; color:#374151;">Pilih Bus <span style="color:#ef4444;">*</span></label>
                <select id="bus_id" name="bus_id" required style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:6px;">
                    <option value="">-- Pilih Bus --</option>
                    <?php foreach ($buses as $b): ?>
                        <option value="<?php echo $b['id']; ?>" <?php echo (isset($schedule) && $schedule['bus_id'] == $b['id']) || (isset($old['bus_id']) && $old['bus_id'] == $b['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($b['plate_number'] . ' - ' . ($b['class_name'] ?? '')); ?></option>
                    <?php endforeach; ?>
                </select>
                <div id="bus-info" style="margin-top: 10px; padding: 10px; background: #f3f4f6; border-radius: 6px; display: none;">
                    <div style="font-size: 0.875rem; color: #374151;">
                        <strong>Status Bus:</strong>
                        <div id="bus-status-content" style="margin-top: 5px;"></div>
                    </div>
                </div>
            </div>

            <div>
                <label for="route_id" style="display:block; margin-bottom:8px; font-weight:500; color:#374151;">Pilih Rute <span style="color:#ef4444;">*</span></label>
                <select id="route_id" name="route_id" required style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:6px;">
                    <option value="">-- Pilih Rute --</option>
                    <?php foreach ($routes as $r): ?>
                        <option value="<?php echo $r['route_id']; ?>" <?php echo (isset($schedule) && $schedule['route_id'] == $r['route_id']) || (isset($old['route_id']) && $old['route_id'] == $r['route_id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($r['route_code'] . ' - ' . $r['origin_city'] . ' → ' . $r['destination_city']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label for="route_type" style="display:block; margin-bottom:8px; font-weight:500; color:#374151;">Jenis Arus <span style="color:#ef4444;">*</span></label>
                <select id="route_type" name="route_type" required style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:6px;">
                    <option value="forward" <?php echo (isset($schedule) && ($schedule['route_type'] ?? 'forward') === 'forward') || (!isset($schedule) && (!isset($old['route_type']) || $old['route_type'] === 'forward')) ? 'selected' : ''; ?>>Arus Berangkat</option>
                    <option value="return" <?php echo (isset($schedule) && ($schedule['route_type'] ?? 'forward') === 'return') || (isset($old['route_type']) && $old['route_type'] === 'return') ? 'selected' : ''; ?>>Arus Balik</option>
                </select>
                <small style="color: #6b7280; margin-top: 4px; display: block;">Bus yang sedang berangkat hanya bisa dijadwalkan dengan arus balik</small>
            </div>

            <div>
                <label for="departure_datetime" style="display:block; margin-bottom:8px; font-weight:500; color:#374151;">Waktu Berangkat <span style="color:#ef4444;">*</span></label>
                <input type="datetime-local" id="departure_datetime" name="departure_datetime" required value="<?php echo isset($schedule) ? date('Y-m-d\TH:i', strtotime($schedule['departure_datetime'])) : (isset($old['departure_datetime']) ? htmlspecialchars($old['departure_datetime']) : ''); ?>" style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:6px;">
            </div>

            <div>
                <label for="arrival_datetime" style="display:block; margin-bottom:8px; font-weight:500; color:#374151;">Waktu Tiba <span style="color:#ef4444;">*</span></label>
                <input type="datetime-local" id="arrival_datetime" name="arrival_datetime" required value="<?php echo isset($schedule) ? date('Y-m-d\TH:i', strtotime($schedule['arrival_datetime'])) : (isset($old['arrival_datetime']) ? htmlspecialchars($old['arrival_datetime']) : ''); ?>" style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:6px;">
            </div>

            <div>
                <label for="base_price" style="display:block; margin-bottom:8px; font-weight:500; color:#374151;">Harga Dasar (Rp) <span style="color:#ef4444;">*</span></label>
                <input type="number" id="base_price" name="base_price" required value="<?php echo isset($schedule) ? htmlspecialchars($schedule['base_price']) : (isset($old['base_price']) ? htmlspecialchars($old['base_price']) : ''); ?>" style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:6px;">
            </div>

            <div>
                <label for="available_seats" style="display:block; margin-bottom:8px; font-weight:500; color:#374151;">Kursi Tersedia <span style="color:#ef4444;">*</span></label>
                <input type="number" id="available_seats" name="available_seats" required value="<?php echo isset($schedule) ? htmlspecialchars($schedule['available_seats']) : (isset($old['available_seats']) ? htmlspecialchars($old['available_seats']) : ''); ?>" style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:6px;">
            </div>

            <div>
                <label for="status" style="display:block; margin-bottom:8px; font-weight:500; color:#374151;">Status</label>
                <select id="status" name="status" style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:6px;">
                    <option value="scheduled" <?php echo (isset($schedule) && $schedule['status'] === 'scheduled') || (isset($old['status']) && $old['status'] === 'scheduled') ? 'selected' : ''; ?>>Scheduled</option>
                    <option value="departed" <?php echo (isset($schedule) && $schedule['status'] === 'departed') || (isset($old['status']) && $old['status'] === 'departed') ? 'selected' : ''; ?>>Departed</option>
                    <option value="cancelled" <?php echo (isset($schedule) && $schedule['status'] === 'cancelled') || (isset($old['status']) && $old['status'] === 'cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                </select>
            </div>

            <div style="grid-column: 1 / -1;">
                <label for="notes" style="display:block; margin-bottom:8px; font-weight:500; color:#374151;">Catatan</label>
                <textarea id="notes" name="notes" rows="4" style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:6px;"><?php echo isset($schedule) ? htmlspecialchars($schedule['notes'] ?? '') : (isset($old['notes']) ? htmlspecialchars($old['notes'] ?? '') : ''); ?></textarea>
            </div>

            <div style="grid-column: 1 / -1; display:flex; gap:10px;">
                <button type="submit" class="btn btn-primary" style="flex:1;"><?php echo isset($schedule) ? 'Update Jadwal' : 'Buat Jadwal'; ?></button>
                <a href="<?php echo BASEURL; ?>admin/schedules" class="btn btn-outline" style="flex:1; text-align:center;">Batal</a>
            </div>
        </form>
    </div>
</div>

<style>
    .section {
        background-color: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .btn {
        padding: 10px 16px;
        border-radius: 6px;
        font-weight: 500;
        text-decoration: none;
        display: inline-block;
    }

    .btn-primary {
        background-color: #3b82f6;
        color: white;
    }

    .btn-outline {
        background-color: white;
        color: #3b82f6;
        border: 1px solid #3b82f6;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const busSelect = document.getElementById('bus_id');
        const busInfo = document.getElementById('bus-info');
        const busStatusContent = document.getElementById('bus-status-content');
        const routeTypeSelect = document.getElementById('route_type');
        const routeSelect = document.getElementById('route_id');
        const departureInput = document.getElementById('departure_datetime');

        // When bus is selected, fetch its latest schedule
        busSelect.addEventListener('change', function() {
            const busId = this.value;

            if (!busId) {
                busInfo.style.display = 'none';
                return;
            }

            // Fetch latest schedule for this bus
            fetch('<?php echo BASEURL; ?>admin/schedules/get-bus-latest-schedule/' + busId)
                .then(response => response.json())
                .then(data => {
                    if (data.has_schedule) {
                        const schedule = data.schedule;
                        const routeTypeText = schedule.route_type === 'forward' ? 'Arus Berangkat' : 'Arus Balik';
                        const nextRouteType = schedule.route_type === 'forward' ? 'return' : 'forward';
                        const nextRouteTypeText = nextRouteType === 'return' ? 'Arus Balik' : 'Arus Berangkat';

                        let html = `
                        <div style="padding: 8px; background: #dbeafe; border-left: 3px solid #3b82f6; margin-bottom: 8px;">
                            <strong>Jadwal Terakhir:</strong><br>
                            ${routeTypeText}: ${schedule.origin_city} → ${schedule.destination_city}<br>
                            Tiba: ${schedule.arrival_datetime}
                        </div>
                        <div style="padding: 8px; background: #fef3c7; border-left: 3px solid #f59e0b;">
                            <strong>⚠️ Jadwal Berikutnya Harus:</strong><br>
                            • Jenis Arus: <strong>${nextRouteTypeText}</strong><br>
                            • Titik Keberangkatan: <strong>${schedule.destination_city}</strong><br>
                            • Waktu Berangkat: <strong>LEBIH DARI</strong> ${schedule.arrival_datetime}<br>
                            <small style="color: #92400e;">⚠️ Tidak boleh sama atau lebih cepat dari waktu tiba</small>
                        </div>
                    `;

                        busStatusContent.innerHTML = html;
                        busInfo.style.display = 'block';

                        // Auto-set the route type
                        routeTypeSelect.value = nextRouteType;

                        // Filter routes that start from destination city
                        filterRoutesByOrigin(schedule.destination_city);
                    } else {
                        busStatusContent.innerHTML = '<div style="padding: 8px; background: #d1fae5; border-left: 3px solid #10b981;">✓ Bus bebas, dapat dijadwalkan dengan rute dan arus apapun</div>';
                        busInfo.style.display = 'block';

                        // Reset route filter
                        filterRoutesByOrigin(null);
                    }
                })
                .catch(error => {
                    console.error('Error fetching bus schedule:', error);
                    busInfo.style.display = 'none';
                });
        });

        function filterRoutesByOrigin(requiredOrigin) {
            const options = routeSelect.querySelectorAll('option');

            options.forEach(option => {
                if (option.value === '') return; // Skip empty option

                if (!requiredOrigin) {
                    // No filter, show all
                    option.style.display = '';
                    option.disabled = false;
                } else {
                    // Extract origin city from option text (format: "CODE - Origin → Destination")
                    const text = option.textContent;
                    const match = text.match(/- (.+?) → /);

                    if (match) {
                        const originCity = match[1].trim();

                        if (originCity === requiredOrigin) {
                            option.style.display = '';
                            option.disabled = false;
                        } else {
                            option.style.display = 'none';
                            option.disabled = true;
                        }
                    }
                }
            });

            // Reset selection if current selection is now hidden
            const currentOption = routeSelect.options[routeSelect.selectedIndex];
            if (currentOption && currentOption.disabled) {
                routeSelect.value = '';
            }
        }

        // Trigger on page load if bus is already selected
        if (busSelect.value) {
            busSelect.dispatchEvent(new Event('change'));
        }
    });
</script>