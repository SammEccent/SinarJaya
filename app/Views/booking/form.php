<style>
    .booking-container {
        max-width: 1000px;
        margin: 40px auto;
        padding: 0 20px;
    }

    .booking-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 30px;
        border-radius: 16px 16px 0 0;
        margin-bottom: 0;
    }

    .booking-header h1 {
        margin: 0 0 10px 0;
        font-size: 28px;
        font-weight: 700;
    }

    .booking-header p {
        margin: 0;
        opacity: 0.9;
        font-size: 15px;
    }

    .booking-content {
        background: white;
        border: 2px solid #e5e7eb;
        border-top: none;
        border-radius: 0 0 16px 16px;
        padding: 35px;
    }

    .schedule-info {
        background: #f9fafb;
        padding: 25px;
        border-radius: 12px;
        margin-bottom: 30px;
        border-left: 4px solid #667eea;
    }

    .schedule-info h3 {
        margin: 0 0 15px 0;
        color: #1f2937;
        font-size: 18px;
        font-weight: 700;
    }

    .schedule-details {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
    }

    .schedule-item {
        display: flex;
        align-items: start;
        gap: 10px;
    }

    .schedule-item i {
        color: #667eea;
        font-size: 18px;
        margin-top: 2px;
    }

    .schedule-item-content {
        flex: 1;
    }

    .schedule-item-label {
        font-size: 12px;
        color: #6b7280;
        text-transform: uppercase;
        margin-bottom: 3px;
    }

    .schedule-item-value {
        font-size: 15px;
        color: #1f2937;
        font-weight: 600;
    }

    .form-section {
        margin-bottom: 35px;
    }

    .form-section-title {
        font-size: 18px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #e5e7eb;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .form-section-title i {
        color: #667eea;
    }

    .form-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 20px;
    }

    .form-group {
        margin-bottom: 0;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        color: #374151;
        font-weight: 600;
        font-size: 14px;
    }

    .form-group label .required {
        color: #ef4444;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        font-size: 15px;
        transition: all 0.3s ease;
        background: #f9fafb;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        border-color: #667eea;
        background: white;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        outline: none;
    }

    .form-group textarea {
        resize: vertical;
        min-height: 80px;
    }

    .passenger-card {
        background: #f9fafb;
        padding: 20px;
        border-radius: 12px;
        margin-bottom: 20px;
        border: 2px solid #e5e7eb;
    }

    .passenger-card-header {
        font-size: 16px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .passenger-number {
        background: #667eea;
        color: white;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        font-weight: 700;
    }

    .price-summary {
        background: linear-gradient(135deg, #f0f4ff 0%, #e8eeff 100%);
        padding: 25px;
        border-radius: 12px;
        margin-top: 30px;
        border: 2px solid #c7d2fe;
    }

    .price-summary h3 {
        margin: 0 0 20px 0;
        color: #1f2937;
        font-size: 18px;
        font-weight: 700;
    }

    .price-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
        font-size: 15px;
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
        background: #c7d2fe;
        margin: 15px 0;
    }

    .price-total {
        font-size: 18px;
    }

    .price-total .price-label {
        color: #1f2937;
        font-weight: 700;
    }

    .price-total .price-value {
        color: #667eea;
        font-size: 24px;
        font-weight: 700;
    }

    .btn-submit {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        padding: 16px 40px;
        border-radius: 10px;
        border: none;
        font-weight: 700;
        font-size: 16px;
        cursor: pointer;
        width: 100%;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
    }

    .btn-submit:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }

    .alert {
        padding: 15px 20px;
        border-radius: 10px;
        margin-bottom: 25px;
        font-size: 14px;
    }

    .alert-danger {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }

    .alert-danger ul {
        margin: 10px 0 0 20px;
        padding: 0;
    }

    .alert-danger li {
        margin: 5px 0;
    }

    .location-info {
        font-size: 13px;
        color: #6b7280;
        margin-top: 5px;
        font-style: italic;
    }

    @media (max-width: 768px) {
        .booking-content {
            padding: 20px;
        }

        .schedule-details {
            grid-template-columns: 1fr;
        }

        .form-row {
            grid-template-columns: 1fr;
        }

        .passenger-card {
            padding: 15px;
        }
    }
</style>

<div class="booking-container">
    <div class="booking-header">
        <h1><i class="fas fa-ticket-alt"></i> Form Pemesanan Tiket</h1>
        <p>Lengkapi data di bawah untuk menyelesaikan pemesanan</p>
    </div>

    <div class="booking-content">
        <?php if (isset($_SESSION['booking_errors'])): ?>
            <div class="alert alert-danger">
                <strong><i class="fas fa-exclamation-circle"></i> Terdapat kesalahan:</strong>
                <ul>
                    <?php foreach ($_SESSION['booking_errors'] as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php unset($_SESSION['booking_errors']); ?>
        <?php endif; ?>

        <!-- Schedule Information -->
        <div class="schedule-info">
            <h3><i class="fas fa-bus"></i> Informasi Jadwal</h3>
            <div class="schedule-details">
                <div class="schedule-item">
                    <i class="fas fa-route"></i>
                    <div class="schedule-item-content">
                        <div class="schedule-item-label">Rute</div>
                        <div class="schedule-item-value">
                            <?php echo htmlspecialchars($schedule['origin_city']); ?> →
                            <?php echo htmlspecialchars($schedule['destination_city']); ?>
                        </div>
                    </div>
                </div>
                <div class="schedule-item">
                    <i class="fas fa-calendar"></i>
                    <div class="schedule-item-content">
                        <div class="schedule-item-label">Tanggal Keberangkatan</div>
                        <div class="schedule-item-value">
                            <?php echo date('d F Y', strtotime($schedule['departure_datetime'])); ?>
                        </div>
                    </div>
                </div>
                <div class="schedule-item">
                    <i class="fas fa-clock"></i>
                    <div class="schedule-item-content">
                        <div class="schedule-item-label">Jam</div>
                        <div class="schedule-item-value">
                            <?php echo date('H:i', strtotime($schedule['departure_datetime'])); ?> WIB
                        </div>
                    </div>
                </div>
                <div class="schedule-item">
                    <i class="fas fa-star"></i>
                    <div class="schedule-item-content">
                        <div class="schedule-item-label">Kelas</div>
                        <div class="schedule-item-value">
                            <?php echo htmlspecialchars($schedule['bus_class_name']); ?>
                        </div>
                    </div>
                </div>
                <div class="schedule-item">
                    <i class="fas fa-users"></i>
                    <div class="schedule-item-content">
                        <div class="schedule-item-label">Jumlah Penumpang</div>
                        <div class="schedule-item-value">
                            <?php echo $passengers; ?> Orang
                        </div>
                    </div>
                </div>
                <div class="schedule-item">
                    <i class="fas fa-chair"></i>
                    <div class="schedule-item-content">
                        <div class="schedule-item-label">Kursi Tersedia</div>
                        <div class="schedule-item-value">
                            <?php echo $schedule['available_seats']; ?> Kursi
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Booking Form -->
        <form action="<?php echo BASEURL; ?>booking/store" method="POST" id="bookingForm">
            <input type="hidden" name="schedule_id" value="<?php echo $schedule['id']; ?>">
            <input type="hidden" name="passengers_count" value="<?php echo $passengers; ?>">
            <input type="hidden" name="total_amount" value="<?php echo $total_price; ?>">

            <!-- Send seat IDs for each passenger -->
            <?php foreach ($selected_seat_ids as $index => $seat_id): ?>
                <input type="hidden" name="seat_ids[]" value="<?php echo $seat_id; ?>">
            <?php endforeach; ?>

            <!-- Pickup & Drop Location Section -->
            <div class="form-section">
                <h3 class="form-section-title">
                    <i class="fas fa-map-marker-alt"></i>
                    Titik Naik & Turun
                </h3>

                <div class="form-row">
                    <div class="form-group">
                        <label for="pickup_location_id">
                            Titik Naik (Boarding Point) <span class="required">*</span>
                        </label>
                        <select name="pickup_location_id" id="pickup_location_id" required>
                            <option value="">-- Pilih Titik Naik --</option>
                            <?php foreach ($boarding_points as $point): ?>
                                <option value="<?php echo $point['location_id']; ?>">
                                    <?php echo htmlspecialchars($point['location_name']); ?> -
                                    <?php echo htmlspecialchars($point['city']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="location-info">
                            <i class="fas fa-info-circle"></i> Pilih lokasi keberangkatan Anda
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="drop_location_id">
                            Titik Turun (Drop Point) <span class="required">*</span>
                        </label>
                        <select name="drop_location_id" id="drop_location_id" required>
                            <option value="">-- Pilih Titik Turun --</option>
                            <?php foreach ($drop_points as $point): ?>
                                <option value="<?php echo $point['location_id']; ?>">
                                    <?php echo htmlspecialchars($point['location_name']); ?> -
                                    <?php echo htmlspecialchars($point['city']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="location-info">
                            <i class="fas fa-info-circle"></i> Pilih lokasi tujuan Anda
                        </div>
                    </div>
                </div>
            </div>

            <!-- Passenger Data Section -->
            <div class="form-section">
                <h3 class="form-section-title">
                    <i class="fas fa-user-friends"></i>
                    Data Penumpang
                </h3>

                <?php for ($i = 0; $i < $passengers; $i++): ?>
                    <div class="passenger-card">
                        <div class="passenger-card-header">
                            <span class="passenger-number"><?php echo $i + 1; ?></span>
                            Penumpang <?php echo $i + 1; ?>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="passenger_name_<?php echo $i; ?>">
                                    Nama Lengkap <span class="required">*</span>
                                </label>
                                <input
                                    type="text"
                                    name="passenger_name[]"
                                    id="passenger_name_<?php echo $i; ?>"
                                    placeholder="Sesuai KTP/Paspor"
                                    required>
                            </div>

                            <div class="form-group">
                                <label for="passenger_phone_<?php echo $i; ?>">
                                    No. HP <span class="required">*</span>
                                </label>
                                <input
                                    type="tel"
                                    name="passenger_phone[]"
                                    id="passenger_phone_<?php echo $i; ?>"
                                    placeholder="08xxxxxxxxxx"
                                    required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="passenger_id_type_<?php echo $i; ?>">
                                    Jenis Identitas <span class="required">*</span>
                                </label>
                                <select
                                    name="passenger_id_type[]"
                                    id="passenger_id_type_<?php echo $i; ?>"
                                    required>
                                    <option value="">-- Pilih --</option>
                                    <option value="ktp">KTP</option>
                                    <option value="sim">SIM</option>
                                    <option value="passport">Paspor</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="passenger_id_number_<?php echo $i; ?>">
                                    Nomor Identitas <span class="required">*</span>
                                </label>
                                <input
                                    type="text"
                                    name="passenger_id_number[]"
                                    id="passenger_id_number_<?php echo $i; ?>"
                                    placeholder="Nomor KTP/SIM/Paspor"
                                    required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="passenger_special_request_<?php echo $i; ?>">
                                Permintaan Khusus (Opsional)
                            </label>
                            <textarea
                                name="passenger_special_request[]"
                                id="passenger_special_request_<?php echo $i; ?>"
                                placeholder="Contoh: Alergi makanan, butuh kursi roda, dll"
                                rows="2"></textarea>
                        </div>
                    </div>
                <?php endfor; ?>
            </div>

            <!-- Additional Notes -->
            <div class="form-section">
                <h3 class="form-section-title">
                    <i class="fas fa-sticky-note"></i>
                    Catatan Tambahan (Opsional)
                </h3>

                <div class="form-group">
                    <textarea
                        name="notes"
                        id="notes"
                        placeholder="Catatan tambahan untuk booking ini..."
                        rows="3"></textarea>
                </div>
            </div>

            <!-- Price Summary -->
            <div class="price-summary">
                <h3><i class="fas fa-receipt"></i> Ringkasan Pembayaran</h3>

                <div class="price-row">
                    <span class="price-label">Harga per orang</span>
                    <span class="price-value">Rp <?php echo number_format($price_per_person, 0, ',', '.'); ?></span>
                </div>

                <div class="price-row">
                    <span class="price-label">Jumlah penumpang</span>
                    <span class="price-value"><?php echo $passengers; ?> orang</span>
                </div>

                <div class="price-divider"></div>

                <div class="price-row price-total">
                    <span class="price-label">Total Pembayaran</span>
                    <span class="price-value">Rp <?php echo number_format($total_price, 0, ',', '.'); ?></span>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn-submit" id="submitBtn">
                <i class="fas fa-check-circle"></i>
                Lanjutkan ke Pembayaran
            </button>
        </form>
    </div>
</div>

<script>
    // Form validation
    document.getElementById('bookingForm').addEventListener('submit', function(e) {
        const pickupId = document.getElementById('pickup_location_id').value;
        const dropId = document.getElementById('drop_location_id').value;

        if (pickupId === dropId && pickupId !== '') {
            e.preventDefault();
            alert('Titik naik dan titik turun tidak boleh sama!');
            return false;
        }

        // Disable submit button to prevent double submission
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
    });

    // Phone number validation
    const phoneInputs = document.querySelectorAll('input[type="tel"]');
    phoneInputs.forEach(input => {
        input.addEventListener('input', function(e) {
            // Remove non-numeric characters
            this.value = this.value.replace(/[^0-9]/g, '');

            // Limit to 15 characters
            if (this.value.length > 15) {
                this.value = this.value.slice(0, 15);
            }
        });
    });

    // ID number validation
    const idInputs = document.querySelectorAll('input[name="passenger_id_number[]"]');
    idInputs.forEach(input => {
        input.addEventListener('input', function(e) {
            // Remove special characters
            this.value = this.value.replace(/[^a-zA-Z0-9]/g, '').toUpperCase();
        });
    });
</script>