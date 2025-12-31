<style>
    .search-results-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 20px;
    }

    .search-summary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 30px;
        border-radius: 16px;
        margin-bottom: 30px;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    }

    .search-summary h1 {
        margin: 0 0 15px 0;
        font-size: 28px;
        font-weight: 700;
    }

    .search-info {
        display: flex;
        flex-wrap: wrap;
        gap: 25px;
        font-size: 15px;
    }

    .search-info-item {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .search-info-item i {
        font-size: 18px;
        opacity: 0.9;
    }

    .modify-search {
        margin-top: 20px;
    }

    .modify-search a {
        color: white;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .modify-search a:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: translateY(-2px);
    }

    .results-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 2px solid #e5e7eb;
    }

    .results-count {
        font-size: 18px;
        color: #374151;
        font-weight: 600;
    }

    .sort-filter {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .sort-filter select {
        padding: 8px 15px;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .sort-filter select:focus {
        border-color: #667eea;
        outline: none;
    }

    .schedule-card {
        background: white;
        border: 2px solid #e5e7eb;
        border-radius: 16px;
        padding: 25px;
        margin-bottom: 20px;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .schedule-card:hover {
        border-color: #667eea;
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.15);
        transform: translateY(-3px);
    }

    .schedule-header {
        display: flex;
        justify-content: space-between;
        align-items: start;
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 1px solid #f3f4f6;
    }

    .bus-info {
        flex: 1;
    }

    .bus-class {
        display: inline-block;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .bus-name {
        font-size: 18px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 5px;
    }

    .bus-plate {
        color: #6b7280;
        font-size: 14px;
    }

    .schedule-time {
        display: flex;
        align-items: center;
        gap: 20px;
        margin-bottom: 20px;
    }

    .time-block {
        text-align: center;
    }

    .time-label {
        color: #6b7280;
        font-size: 12px;
        text-transform: uppercase;
        margin-bottom: 5px;
    }

    .time-value {
        font-size: 24px;
        font-weight: 700;
        color: #1f2937;
    }

    .date-value {
        font-size: 13px;
        color: #6b7280;
        margin-top: 3px;
    }

    .route-visual {
        display: flex;
        align-items: center;
        gap: 15px;
        flex: 1;
        padding: 0 20px;
    }

    .route-line {
        flex: 1;
        height: 2px;
        background: linear-gradient(90deg, #667eea, #764ba2);
        position: relative;
    }

    .route-line::after {
        content: '';
        position: absolute;
        right: -8px;
        top: 50%;
        transform: translateY(-50%);
        width: 0;
        height: 0;
        border-left: 8px solid #764ba2;
        border-top: 5px solid transparent;
        border-bottom: 5px solid transparent;
    }

    .duration-badge {
        background: #f3f4f6;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 13px;
        color: #6b7280;
        font-weight: 600;
    }

    .schedule-details {
        display: flex;
        justify-content: space-between;
        align-items: end;
    }

    .facilities {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .facility-tag {
        background: #f0f4ff;
        color: #667eea;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .facility-tag i {
        font-size: 13px;
    }

    .seats-info {
        text-align: center;
        margin: 0 20px;
    }

    .seats-available {
        font-size: 14px;
        color: #059669;
        font-weight: 600;
        margin-bottom: 5px;
    }

    .seats-total {
        font-size: 12px;
        color: #6b7280;
    }

    .price-booking {
        text-align: right;
    }

    .price-label {
        font-size: 13px;
        color: #6b7280;
        margin-bottom: 5px;
    }

    .price-value {
        font-size: 32px;
        font-weight: 700;
        color: #667eea;
        margin-bottom: 10px;
    }

    .price-value small {
        font-size: 14px;
        font-weight: 500;
        color: #6b7280;
    }

    .btn-book {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        padding: 12px 30px;
        border-radius: 10px;
        border: none;
        font-weight: 600;
        font-size: 15px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-book:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
    }

    .no-results {
        text-align: center;
        padding: 60px 20px;
        background: white;
        border-radius: 16px;
        border: 2px dashed #e5e7eb;
    }

    .no-results i {
        font-size: 80px;
        color: #d1d5db;
        margin-bottom: 20px;
    }

    .no-results h3 {
        font-size: 24px;
        color: #374151;
        margin-bottom: 10px;
    }

    .no-results p {
        color: #6b7280;
        margin-bottom: 25px;
    }

    /* Loading state */
    .loading {
        text-align: center;
        padding: 40px;
    }

    .loading i {
        font-size: 40px;
        color: #667eea;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        100% {
            transform: rotate(360deg);
        }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .search-info {
            flex-direction: column;
            gap: 12px;
        }

        .schedule-header {
            flex-direction: column;
        }

        .schedule-time {
            flex-direction: column;
            gap: 15px;
        }

        .route-visual {
            flex-direction: column;
            padding: 15px 0;
        }

        .route-line {
            width: 2px;
            height: 40px;
            background: linear-gradient(180deg, #667eea, #764ba2);
        }

        .route-line::after {
            right: 50%;
            top: auto;
            bottom: -8px;
            transform: translateX(50%) rotate(90deg);
        }

        .schedule-details {
            flex-direction: column;
            align-items: stretch;
            gap: 20px;
        }

        .facilities {
            justify-content: center;
        }

        .price-booking {
            text-align: center;
        }

        .seats-info {
            margin: 20px 0;
        }
    }
</style>

<div class="search-results-container">
    <!-- Search Summary -->
    <div class="search-summary">
        <h1><i class="fas fa-search"></i> Hasil Pencarian Tiket Bus</h1>
        <div class="search-info">
            <div class="search-info-item">
                <i class="fas fa-map-marker-alt"></i>
                <span><strong><?php echo htmlspecialchars($origin); ?></strong> → <strong><?php echo htmlspecialchars($destination); ?></strong></span>
            </div>
            <div class="search-info-item">
                <i class="fas fa-calendar"></i>
                <span><?php echo htmlspecialchars($search_date); ?></span>
            </div>
            <div class="search-info-item">
                <i class="fas fa-users"></i>
                <span><?php echo $passengers; ?> Penumpang</span>
            </div>
        </div>
        <div class="modify-search">
            <a href="<?php echo BASEURL; ?>">
                <i class="fas fa-edit"></i> Ubah Pencarian
            </a>
        </div>
    </div>

    <!-- Results Header -->
    <?php if (!empty($schedules)): ?>
        <div class="results-header">
            <div class="results-count">
                <i class="fas fa-bus"></i> <?php echo count($schedules); ?> jadwal tersedia
            </div>
            <div class="sort-filter">
                <label for="sort-by" style="font-size: 14px; color: #6b7280;">Urutkan:</label>
                <select id="sort-by" onchange="sortSchedules(this.value)">
                    <option value="time-asc">Waktu Keberangkatan (Awal)</option>
                    <option value="time-desc">Waktu Keberangkatan (Akhir)</option>
                    <option value="price-asc">Harga (Termurah)</option>
                    <option value="price-desc">Harga (Termahal)</option>
                    <option value="duration-asc">Durasi (Tercepat)</option>
                </select>
            </div>
        </div>

        <!-- Schedule Cards -->
        <div id="schedule-list">
            <?php foreach ($schedules as $schedule):
                $finalPrice = $schedule['base_price'] * $schedule['base_price_multiplier'];
                $departureTime = date('H:i', strtotime($schedule['departure_datetime']));
                $arrivalTime = date('H:i', strtotime($schedule['arrival_datetime']));
                $departureDate = date('d M Y', strtotime($schedule['departure_datetime']));
                $arrivalDate = date('d M Y', strtotime($schedule['arrival_datetime']));
                $durationHours = floor($schedule['duration_minutes'] / 60);
                $durationMins = $schedule['duration_minutes'] % 60;
                $facilities = !empty($schedule['bus_facilities']) ? explode(', ', $schedule['bus_facilities']) : [];
            ?>
                <div class="schedule-card"
                    data-schedule-id="<?php echo $schedule['schedule_id']; ?>"
                    data-price="<?php echo $finalPrice; ?>"
                    data-time="<?php echo strtotime($schedule['departure_datetime']); ?>"
                    data-duration="<?php echo $schedule['duration_minutes']; ?>">

                    <div class="schedule-header">
                        <div class="bus-info">
                            <span class="bus-class"><?php echo htmlspecialchars($schedule['bus_class_name']); ?></span>
                            <div class="bus-name"><?php echo htmlspecialchars($schedule['plate_number']); ?></div>
                            <div class="bus-plate">Kode: <?php echo htmlspecialchars($schedule['route_code']); ?></div>
                        </div>
                    </div>

                    <div class="schedule-time">
                        <div class="time-block">
                            <div class="time-label">Berangkat</div>
                            <div class="time-value"><?php echo $departureTime; ?></div>
                            <div class="date-value"><?php echo $departureDate; ?></div>
                        </div>

                        <div class="route-visual">
                            <div class="route-line"></div>
                            <div class="duration-badge">
                                <i class="fas fa-clock"></i>
                                <?php echo $durationHours; ?>j <?php echo $durationMins; ?>m
                            </div>
                        </div>

                        <div class="time-block">
                            <div class="time-label">Tiba</div>
                            <div class="time-value"><?php echo $arrivalTime; ?></div>
                            <div class="date-value"><?php echo $arrivalDate; ?></div>
                        </div>
                    </div>

                    <div class="schedule-details">
                        <div class="facilities">
                            <?php foreach ($facilities as $facility): ?>
                                <span class="facility-tag">
                                    <i class="fas fa-check-circle"></i>
                                    <?php echo htmlspecialchars(trim($facility)); ?>
                                </span>
                            <?php endforeach; ?>
                        </div>

                        <div class="seats-info">
                            <div class="seats-available">
                                <i class="fas fa-chair"></i> <?php echo $schedule['available_seats']; ?> kursi tersedia
                            </div>
                            <div class="seats-total">
                                dari <?php echo $schedule['total_seats']; ?> kursi
                            </div>
                        </div>

                        <div class="price-booking">
                            <div class="price-label">Harga per orang</div>
                            <div class="price-value">
                                Rp <?php echo number_format($finalPrice, 0, ',', '.'); ?>
                            </div>
                            <button class="btn-book" onclick="bookSchedule(<?php echo $schedule['schedule_id']; ?>)">
                                <i class="fas fa-ticket-alt"></i> Pesan Sekarang
                            </button>
                        </div>
                    </div>

                    <?php if (!empty($schedule['notes'])): ?>
                        <div style="margin-top: 15px; padding: 12px; background: #fef3c7; border-radius: 8px; font-size: 13px; color: #92400e;">
                            <i class="fas fa-info-circle"></i> <strong>Info:</strong> <?php echo htmlspecialchars($schedule['notes']); ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>

    <?php else: ?>
        <!-- No Results -->
        <div class="no-results">
            <i class="fas fa-bus-alt"></i>
            <h3>Tidak Ada Jadwal Tersedia</h3>
            <p>Maaf, tidak ada jadwal bus yang tersedia untuk rute dan tanggal yang Anda pilih.</p>
            <p style="color: #9ca3af; font-size: 14px;">Coba ubah tanggal keberangkatan atau pilih rute lain.</p>
            <a href="<?php echo BASEURL; ?>" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i> Kembali ke Pencarian
            </a>
        </div>
    <?php endif; ?>
</div>

<script>
    // Sort schedules
    function sortSchedules(sortBy) {
        const scheduleList = document.getElementById('schedule-list');
        const schedules = Array.from(scheduleList.querySelectorAll('.schedule-card'));

        schedules.sort((a, b) => {
            switch (sortBy) {
                case 'time-asc':
                    return parseInt(a.dataset.time) - parseInt(b.dataset.time);
                case 'time-desc':
                    return parseInt(b.dataset.time) - parseInt(a.dataset.time);
                case 'price-asc':
                    return parseFloat(a.dataset.price) - parseFloat(b.dataset.price);
                case 'price-desc':
                    return parseFloat(b.dataset.price) - parseFloat(a.dataset.price);
                case 'duration-asc':
                    return parseInt(a.dataset.duration) - parseInt(b.dataset.duration);
                default:
                    return 0;
            }
        });

        schedules.forEach(schedule => scheduleList.appendChild(schedule));
    }

    // Book schedule
    function bookSchedule(scheduleId) {
        const passengers = <?php echo $passengers; ?>;
        window.location.href = `<?php echo BASEURL; ?>booking/selectSeats?schedule_id=${scheduleId}&passengers=${passengers}`;
    }

    // Add click event to cards
    document.querySelectorAll('.schedule-card').forEach(card => {
        card.addEventListener('click', function(e) {
            if (!e.target.closest('.btn-book')) {
                const scheduleId = this.dataset.scheduleId;
                bookSchedule(scheduleId);
            }
        });
    });
</script>