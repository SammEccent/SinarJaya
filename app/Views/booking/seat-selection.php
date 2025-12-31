<style>
    .seat-selection-container {
        max-width: 1200px;
        margin: 40px auto;
        padding: 0 20px;
    }

    .selection-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 30px;
        border-radius: 16px;
        margin-bottom: 30px;
    }

    .selection-header h1 {
        margin: 0 0 15px 0;
        font-size: 28px;
        font-weight: 700;
    }

    .trip-info {
        display: flex;
        flex-wrap: wrap;
        gap: 25px;
        font-size: 15px;
        margin-top: 15px;
    }

    .trip-info-item {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .selection-content {
        display: grid;
        grid-template-columns: 1fr 350px;
        gap: 30px;
    }

    .seat-map-section {
        background: white;
        border: 2px solid #e5e7eb;
        border-radius: 16px;
        padding: 30px;
    }

    .seat-map-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 2px solid #e5e7eb;
    }

    .seat-map-title {
        font-size: 20px;
        font-weight: 700;
        color: #1f2937;
    }

    .seats-selected-count {
        background: #667eea;
        color: white;
        padding: 8px 16px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 14px;
    }

    .bus-layout {
        background: #f9fafb;
        padding: 30px 20px;
        border-radius: 12px;
        border: 2px dashed #d1d5db;
    }

    .driver-section {
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 2px solid #e5e7eb;
    }

    .driver-row {
        display: grid;
        grid-template-columns: 1fr 1fr 20px 1fr 1fr;
        gap: 10px;
        max-width: 380px;
        margin: 0 auto;
    }

    .driver-empty {
        background: transparent;
    }

    .driver-icon {
        background: #374151;
        color: white;
        border-radius: 8px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        padding: 15px;
        font-weight: 600;
        aspect-ratio: 1;
    }

    .driver-icon i {
        font-size: 20px;
        margin-bottom: 5px;
    }

    .seats-grid {
        display: flex;
        flex-direction: column;
        gap: 10px;
        max-width: 380px;
        margin: 0 auto;
    }

    .seat-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 10px;
    }

    .seat-row.with-aisle {
        grid-template-columns: 1fr 1fr 20px 1fr 1fr;
        gap: 10px;
    }

    .seat {
        aspect-ratio: 1;
        border: 2px solid #d1d5db;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        background: white;
    }

    .seat:hover:not(.booked):not(.maintenance) {
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .seat.available {
        border-color: #10b981;
        color: #059669;
        background: #ecfdf5;
    }

    .seat.available:hover {
        background: #d1fae5;
        border-color: #059669;
    }

    .seat.selected {
        background: linear-gradient(135deg, #667eea, #764ba2);
        border-color: #667eea;
        color: white;
    }

    .seat.booked {
        background: #f3f4f6;
        border-color: #d1d5db;
        color: #9ca3af;
        cursor: not-allowed;
    }

    .seat.maintenance {
        background: #fef3c7;
        border-color: #fbbf24;
        color: #92400e;
        cursor: not-allowed;
    }

    .seat i {
        font-size: 20px;
    }

    .seat-number {
        position: absolute;
        top: 2px;
        right: 4px;
        font-size: 10px;
        font-weight: 600;
        opacity: 0.7;
    }

    .aisle {
        background: transparent;
        border: none;
        pointer-events: none;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .toilet-section {
        display: grid;
        grid-template-columns: 1fr 1fr 20px 1fr 1fr;
        gap: 10px;
        margin: 10px 0;
    }

    .toilet-box {
        background: #fef3c7;
        border: 2px solid #fbbf24;
        border-radius: 8px;
        padding: 15px;
        text-align: center;
        color: #92400e;
        font-weight: 600;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 5px;
        aspect-ratio: 1;
    }

    .toilet-box i {
        font-size: 20px;
    }

    .toilet-box span {
        font-size: 11px;
    }

    .legend {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: center;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 2px solid #e5e7eb;
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: #6b7280;
    }

    .legend-box {
        width: 30px;
        height: 30px;
        border-radius: 6px;
        border: 2px solid;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .legend-box.available {
        border-color: #10b981;
        background: #ecfdf5;
        color: #059669;
    }

    .legend-box.selected {
        background: linear-gradient(135deg, #667eea, #764ba2);
        border-color: #667eea;
        color: white;
    }

    .legend-box.booked {
        background: #f3f4f6;
        border-color: #d1d5db;
        color: #9ca3af;
    }

    .booking-summary {
        background: white;
        border: 2px solid #e5e7eb;
        border-radius: 16px;
        padding: 25px;
        height: fit-content;
        position: sticky;
        top: 20px;
    }

    .summary-title {
        font-size: 18px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .selected-seats-list {
        margin-bottom: 20px;
    }

    .selected-seat-item {
        background: #f9fafb;
        padding: 12px 15px;
        border-radius: 8px;
        margin-bottom: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .seat-item-info {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .seat-item-icon {
        background: #667eea;
        color: white;
        width: 35px;
        height: 35px;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        font-weight: 700;
    }

    .seat-item-details {
        font-size: 14px;
    }

    .seat-item-number {
        font-weight: 700;
        color: #1f2937;
    }

    .seat-item-type {
        font-size: 12px;
        color: #6b7280;
    }

    .remove-seat-btn {
        background: #fee2e2;
        color: #991b1b;
        border: none;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .remove-seat-btn:hover {
        background: #fecaca;
    }

    .empty-seats-message {
        text-align: center;
        padding: 30px;
        color: #9ca3af;
        font-size: 14px;
    }

    .price-breakdown {
        background: #f9fafb;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .price-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        font-size: 14px;
    }

    .price-label {
        color: #6b7280;
    }

    .price-value {
        font-weight: 600;
        color: #1f2937;
    }

    .price-divider {
        height: 1px;
        background: #e5e7eb;
        margin: 12px 0;
    }

    .price-total {
        font-size: 16px;
    }

    .price-total .price-label {
        color: #1f2937;
        font-weight: 700;
    }

    .price-total .price-value {
        color: #667eea;
        font-size: 20px;
        font-weight: 700;
    }

    .continue-btn {
        width: 100%;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        padding: 16px;
        border-radius: 10px;
        border: none;
        font-weight: 700;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .continue-btn:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
    }

    .continue-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .alert {
        padding: 15px 20px;
        border-radius: 10px;
        margin-bottom: 25px;
        font-size: 14px;
    }

    .alert-info {
        background: #dbeafe;
        color: #1e40af;
        border: 1px solid #93c5fd;
    }

    @media (max-width: 992px) {
        .selection-content {
            grid-template-columns: 1fr;
        }

        .booking-summary {
            position: static;
        }

        .seats-grid {
            gap: 10px;
        }
    }
</style>

<div class="seat-selection-container">
    <div class="selection-header">
        <h1><i class="fas fa-chair"></i> Pilih Kursi</h1>
        <p>Silakan pilih <?php echo $passengers; ?> kursi untuk perjalanan Anda</p>
        <div class="trip-info">
            <div class="trip-info-item">
                <i class="fas fa-route"></i>
                <span><?php echo htmlspecialchars($schedule['origin_city']); ?> → <?php echo htmlspecialchars($schedule['destination_city']); ?></span>
            </div>
            <div class="trip-info-item">
                <i class="fas fa-calendar"></i>
                <span><?php echo date('d F Y', strtotime($schedule['departure_datetime'])); ?></span>
            </div>
            <div class="trip-info-item">
                <i class="fas fa-clock"></i>
                <span><?php echo date('H:i', strtotime($schedule['departure_datetime'])); ?> WIB</span>
            </div>
            <div class="trip-info-item">
                <i class="fas fa-star"></i>
                <span><?php echo htmlspecialchars($schedule['bus_class_name']); ?></span>
            </div>
        </div>
    </div>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle"></i> <?php echo $_SESSION['error'];
                                                        unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <div class="selection-content">
        <!-- Seat Map Section -->
        <div class="seat-map-section">
            <div class="seat-map-header">
                <div class="seat-map-title">Pilih Kursi Anda</div>
                <div class="seats-selected-count">
                    <span id="selectedCount">0</span> / <?php echo $passengers; ?> kursi dipilih
                </div>
            </div>

            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> Klik kursi untuk memilih. Anda perlu memilih <?php echo $passengers; ?> kursi.
            </div>

            <div class="bus-layout">
                <div class="driver-section">
                    <div class="driver-row">
                        <div class="driver-empty"></div>
                        <div class="driver-empty"></div>
                        <div class="aisle"></div>
                        <div class="driver-icon">
                            <i class="fas fa-steering-wheel"></i>
                            <span>SOPIR</span>
                        </div>
                        <div class="driver-empty"></div>
                    </div>
                </div>

                <div class="seats-grid">
                    <?php
                    // Detect if this is suite class (only A and B seats)
                    $isSuiteClass = true;
                    foreach ($seats as $seat) {
                        if (preg_match('/^(\d+)([CD])$/', $seat['seat_number'])) {
                            $isSuiteClass = false;
                            break;
                        }
                    }

                    // Group seats by row number
                    $seatsByRow = [];
                    foreach ($seats as $seat) {
                        preg_match('/^(\d+)([A-D])$/', $seat['seat_number'], $matches);
                        if ($matches) {
                            $rowNum = (int)$matches[1];
                            $position = $matches[2];
                            if (!isset($seatsByRow[$rowNum])) {
                                $seatsByRow[$rowNum] = [];
                            }
                            $seatsByRow[$rowNum][$position] = $seat;
                        }
                    }
                    ksort($seatsByRow);

                    // Render each row
                    foreach ($seatsByRow as $rowNum => $rowSeats):
                        if ($isSuiteClass):
                            // Skip row 7 for suite class (will be rendered with toilet)
                            if ($rowNum == 7) continue;

                            // Suite Class: 1-1 layout
                            // Show toilet after row 6 (after 6A)
                            $showToiletAfter = ($rowNum == 6);
                    ?>
                            <!-- Suite layout: A on left, B on right -->
                            <div class="seat-row with-aisle">
                                <?php
                                // Seat A (left side)
                                if (isset($rowSeats['A'])):
                                    $seat = $rowSeats['A'];
                                    $statusClass = $seat['booking_status'];
                                    $disabled = ($statusClass !== 'available') ? 'disabled' : '';
                                ?>
                                    <div class="seat <?php echo $statusClass; ?>"
                                        data-seat-id="<?php echo $seat['id']; ?>"
                                        data-seat-number="<?php echo htmlspecialchars($seat['seat_number']); ?>"
                                        data-seat-type="<?php echo htmlspecialchars($seat['seat_type']); ?>"
                                        <?php echo $disabled; ?>>
                                        <i class="fas fa-chair"></i>
                                        <span class="seat-number"><?php echo htmlspecialchars($seat['seat_number']); ?></span>
                                    </div>
                                <?php else: ?>
                                    <div class="driver-empty"></div>
                                <?php endif; ?>

                                <div class="driver-empty"></div>
                                <div class="aisle"></div>

                                <?php
                                // Seat B (right side)
                                if (isset($rowSeats['B'])):
                                    $seat = $rowSeats['B'];
                                    $statusClass = $seat['booking_status'];
                                    $disabled = ($statusClass !== 'available') ? 'disabled' : '';
                                ?>
                                    <div class="seat <?php echo $statusClass; ?>"
                                        data-seat-id="<?php echo $seat['id']; ?>"
                                        data-seat-number="<?php echo htmlspecialchars($seat['seat_number']); ?>"
                                        data-seat-type="<?php echo htmlspecialchars($seat['seat_type']); ?>"
                                        <?php echo $disabled; ?>>
                                        <i class="fas fa-chair"></i>
                                        <span class="seat-number"><?php echo htmlspecialchars($seat['seat_number']); ?></span>
                                    </div>
                                <?php else: ?>
                                    <div class="driver-empty"></div>
                                <?php endif; ?>

                                <div class="driver-empty"></div>
                            </div>

                            <?php if ($showToiletAfter): ?>
                                <!-- Row 7: Toilet on left, 7B on right -->
                                <div class="seat-row with-aisle">
                                    <div class="toilet-box">
                                        <i class="fas fa-restroom"></i>
                                        <span>Toilet</span>
                                    </div>
                                    <div class="driver-empty"></div>
                                    <div class="aisle"></div>
                                    <?php
                                    // Show 7B here if exists
                                    if (isset($seatsByRow[7]['B'])):
                                        $seat = $seatsByRow[7]['B'];
                                        $statusClass = $seat['booking_status'];
                                        $disabled = ($statusClass !== 'available') ? 'disabled' : '';
                                    ?>
                                        <div class="seat <?php echo $statusClass; ?>"
                                            data-seat-id="<?php echo $seat['id']; ?>"
                                            data-seat-number="<?php echo htmlspecialchars($seat['seat_number']); ?>"
                                            data-seat-type="<?php echo htmlspecialchars($seat['seat_type']); ?>"
                                            <?php echo $disabled; ?>>
                                            <i class="fas fa-chair"></i>
                                            <span class="seat-number"><?php echo htmlspecialchars($seat['seat_number']); ?></span>
                                        </div>
                                    <?php else: ?>
                                        <div class="driver-empty"></div>
                                    <?php endif; ?>
                                    <div class="driver-empty"></div>
                                </div>
                            <?php endif; ?>

                        <?php else:
                            // Regular layout: 2-2
                            // Check if this is row 8 (special layout with toilet)
                            $isRow8 = ($rowNum == 8);
                        ?>
                            <?php if ($isRow8): ?>
                                <!-- Row 8: Toilet on left, seats 8C and 8D on right -->
                                <div class="toilet-section">
                                    <div class="toilet-box">
                                        <i class="fas fa-restroom"></i>
                                        <span>Toilet</span>
                                    </div>
                                    <div class="aisle"></div>
                                    <?php
                                    // Render only seats C and D for row 8
                                    foreach (['C', 'D'] as $pos):
                                        if (isset($rowSeats[$pos])):
                                            $seat = $rowSeats[$pos];
                                            $statusClass = $seat['booking_status'];
                                            $disabled = ($statusClass !== 'available') ? 'disabled' : '';
                                    ?>
                                            <div class="seat <?php echo $statusClass; ?>"
                                                data-seat-id="<?php echo $seat['id']; ?>"
                                                data-seat-number="<?php echo htmlspecialchars($seat['seat_number']); ?>"
                                                data-seat-type="<?php echo htmlspecialchars($seat['seat_type']); ?>"
                                                <?php echo $disabled; ?>>
                                                <i class="fas fa-chair"></i>
                                                <span class="seat-number"><?php echo htmlspecialchars($seat['seat_number']); ?></span>
                                            </div>
                                    <?php
                                        endif;
                                    endforeach;
                                    ?>
                                </div>
                            <?php else: ?>
                                <!-- Regular row: 2 seats on left, aisle, 2 seats on right -->
                                <div class="seat-row with-aisle">
                                    <?php
                                    // Render seats A and B (left side)
                                    foreach (['A', 'B'] as $pos):
                                        if (isset($rowSeats[$pos])):
                                            $seat = $rowSeats[$pos];
                                            $statusClass = $seat['booking_status'];
                                            $disabled = ($statusClass !== 'available') ? 'disabled' : '';
                                    ?>
                                            <div class="seat <?php echo $statusClass; ?>"
                                                data-seat-id="<?php echo $seat['id']; ?>"
                                                data-seat-number="<?php echo htmlspecialchars($seat['seat_number']); ?>"
                                                data-seat-type="<?php echo htmlspecialchars($seat['seat_type']); ?>"
                                                <?php echo $disabled; ?>>
                                                <i class="fas fa-chair"></i>
                                                <span class="seat-number"><?php echo htmlspecialchars($seat['seat_number']); ?></span>
                                            </div>
                                    <?php
                                        endif;
                                    endforeach;
                                    ?>

                                    <!-- Aisle -->
                                    <div class="aisle"></div>

                                    <?php
                                    // Render seats C and D (right side)
                                    foreach (['C', 'D'] as $pos):
                                        if (isset($rowSeats[$pos])):
                                            $seat = $rowSeats[$pos];
                                            $statusClass = $seat['booking_status'];
                                            $disabled = ($statusClass !== 'available') ? 'disabled' : '';
                                    ?>
                                            <div class="seat <?php echo $statusClass; ?>"
                                                data-seat-id="<?php echo $seat['id']; ?>"
                                                data-seat-number="<?php echo htmlspecialchars($seat['seat_number']); ?>"
                                                data-seat-type="<?php echo htmlspecialchars($seat['seat_type']); ?>"
                                                <?php echo $disabled; ?>>
                                                <i class="fas fa-chair"></i>
                                                <span class="seat-number"><?php echo htmlspecialchars($seat['seat_number']); ?></span>
                                            </div>
                                    <?php
                                        endif;
                                    endforeach;
                                    ?>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="legend">
                <div class="legend-item">
                    <div class="legend-box available"><i class="fas fa-chair"></i></div>
                    <span>Tersedia</span>
                </div>
                <div class="legend-item">
                    <div class="legend-box selected"><i class="fas fa-chair"></i></div>
                    <span>Dipilih</span>
                </div>
                <div class="legend-item">
                    <div class="legend-box booked"><i class="fas fa-chair"></i></div>
                    <span>Sudah Dipesan</span>
                </div>
            </div>
        </div>

        <!-- Booking Summary -->
        <div class="booking-summary">
            <div class="summary-title">
                <i class="fas fa-list-check"></i>
                Ringkasan Pemilihan
            </div>

            <div class="selected-seats-list" id="selectedSeatsList">
                <div class="empty-seats-message">
                    <i class="fas fa-hand-pointer" style="font-size: 40px; color: #d1d5db; margin-bottom: 10px;"></i>
                    <div>Silakan pilih kursi</div>
                </div>
            </div>

            <div class="price-breakdown">
                <div class="price-row">
                    <span class="price-label">Harga per kursi</span>
                    <span class="price-value">Rp <?php echo number_format($schedule['base_price'] * $schedule['base_price_multiplier'], 0, ',', '.'); ?></span>
                </div>
                <div class="price-row">
                    <span class="price-label">Jumlah kursi</span>
                    <span class="price-value"><span id="seatCount">0</span> kursi</span>
                </div>
                <div class="price-divider"></div>
                <div class="price-row price-total">
                    <span class="price-label">Total</span>
                    <span class="price-value">Rp <span id="totalPrice">0</span></span>
                </div>
            </div>

            <form action="<?php echo BASEURL; ?>booking/create" method="POST" id="seatForm">
                <input type="hidden" name="schedule_id" value="<?php echo $schedule['id']; ?>">
                <input type="hidden" name="selected_seats" id="selectedSeatsInput" value="">

                <button type="submit" class="continue-btn" id="continueBtn" disabled>
                    <i class="fas fa-arrow-right"></i>
                    Lanjut ke Form Pemesanan
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    const maxSeats = <?php echo $passengers; ?>;
    const basePrice = <?php echo $schedule['base_price'] * $schedule['base_price_multiplier']; ?>;
    let selectedSeats = [];

    // Seat click handler
    document.querySelectorAll('.seat.available').forEach(seat => {
        seat.addEventListener('click', function() {
            const seatId = parseInt(this.dataset.seatId);
            const seatNumber = this.dataset.seatNumber;
            const seatType = this.dataset.seatType;

            if (this.classList.contains('selected')) {
                // Deselect
                this.classList.remove('selected');
                selectedSeats = selectedSeats.filter(s => s.id !== seatId);
            } else {
                // Select
                if (selectedSeats.length >= maxSeats) {
                    alert(`Anda hanya dapat memilih maksimal ${maxSeats} kursi`);
                    return;
                }
                this.classList.add('selected');
                selectedSeats.push({
                    id: seatId,
                    number: seatNumber,
                    type: seatType
                });
            }

            updateSummary();
        });
    });

    function updateSummary() {
        const selectedCount = selectedSeats.length;
        document.getElementById('selectedCount').textContent = selectedCount;
        document.getElementById('seatCount').textContent = selectedCount;

        // Update selected seats list
        const listContainer = document.getElementById('selectedSeatsList');
        if (selectedCount === 0) {
            listContainer.innerHTML = `
                <div class="empty-seats-message">
                    <i class="fas fa-hand-pointer" style="font-size: 40px; color: #d1d5db; margin-bottom: 10px;"></i>
                    <div>Silakan pilih kursi</div>
                </div>
            `;
        } else {
            listContainer.innerHTML = selectedSeats.map((seat, index) => `
                <div class="selected-seat-item">
                    <div class="seat-item-info">
                        <div class="seat-item-icon">${seat.number}</div>
                        <div class="seat-item-details">
                            <div class="seat-item-number">Kursi ${seat.number}</div>
                            <div class="seat-item-type">${seat.type}</div>
                        </div>
                    </div>
                    <button type="button" class="remove-seat-btn" onclick="removeSeat(${seat.id})">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `).join('');
        }

        // Update price
        const total = basePrice * selectedCount;
        document.getElementById('totalPrice').textContent = total.toLocaleString('id-ID');

        // Update hidden input
        document.getElementById('selectedSeatsInput').value = selectedSeats.map(s => s.id).join(',');

        // Enable/disable continue button
        const continueBtn = document.getElementById('continueBtn');
        continueBtn.disabled = (selectedCount !== maxSeats);
    }

    function removeSeat(seatId) {
        const seatElement = document.querySelector(`.seat[data-seat-id="${seatId}"]`);
        if (seatElement) {
            seatElement.classList.remove('selected');
            selectedSeats = selectedSeats.filter(s => s.id !== seatId);
            updateSummary();
        }
    }

    // Form validation
    document.getElementById('seatForm').addEventListener('submit', function(e) {
        if (selectedSeats.length !== maxSeats) {
            e.preventDefault();
            alert(`Anda harus memilih ${maxSeats} kursi`);
            return false;
        }
    });
</script>