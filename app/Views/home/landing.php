<!-- Hero Section -->
<section class="hero">
    <div class="hero-content">
        <h1 class="hero-title">Pesan Tiket Bus Online Mudah & Aman</h1>
        <p class="hero-subtitle">Jelajahi perjalanan Anda dengan Sinar Jaya - Layanan bus terpercaya dengan harga terjangkau</p>
        <a href="<?php echo BASEURL; ?>booking" class="btn btn-primary btn-lg">Mulai Pemesanan</a>
    </div>
    <div class="hero-image">
        <i class="fas fa-bus"></i>
    </div>
</section>

<!-- Search Booking Section -->
<section class="search-section">
    <div class="container">
        <h2>Cari Tiket Bus</h2>
        <form action="<?php echo BASEURL; ?>booking/search" method="GET" class="search-form">
            <div class="form-group">
                <label for="origin">Dari:</label>
                <input type="text" id="origin" name="origin" placeholder="Kota asal" required>
            </div>
            <div class="form-group">
                <label for="destination">Ke:</label>
                <input type="text" id="destination" name="destination" placeholder="Kota tujuan" required>
            </div>
            <div class="form-group">
                <label for="departure">Tanggal Perjalanan:</label>
                <input type="date" id="departure" name="departure" required>
            </div>
            <div class="form-group">
                <label for="passengers">Penumpang:</label>
                <input type="number" id="passengers" name="passengers" value="1" min="1" max="8" required>
            </div>
            <button type="submit" class="btn btn-primary">Cari Tiket</button>
        </form>
    </div>
</section>

<!-- Features Section -->
<section class="features" id="fitur">
    <div class="container">
        <h2>Mengapa Memilih Sinar Jaya?</h2>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3>Aman & Terpercaya</h3>
                <p>Armada terawat dengan standar keselamatan internasional. Semua pengemudi bersertifikat dan berpengalaman.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <h3>Harga Kompetitif</h3>
                <p>Dapatkan harga tiket terbaik dengan berbagai pilihan paket dan promosi menarik setiap bulannya.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-wifi"></i>
                </div>
                <h3>Nyaman & Modern</h3>
                <p>Bus berstandar internasional dengan WiFi gratis, kursi reclining, dan AC dingin sepanjang perjalanan.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <h3>Jadwal Fleksibel</h3>
                <p>Banyak pilihan jadwal keberangkatan setiap hari untuk memenuhi kebutuhan perjalanan Anda.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-credit-card"></i>
                </div>
                <h3>Pembayaran Mudah</h3>
                <p>Berbagai metode pembayaran tersedia: transfer bank, e-wallet, dan cicilan tanpa bunga.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-headset"></i>
                </div>
                <h3>Customer Service 24/7</h3>
                <p>Tim customer service kami siap membantu Anda 24 jam sehari melalui chat, telepon, atau email.</p>
            </div>
        </div>
    </div>
</section>

<!-- Popular Routes Section -->
<section class="popular-routes">
    <div class="container">
        <h2>Rute Populer</h2>
        <div class="routes-grid">
            <div class="route-card">
                <div class="route-header">
                    <span class="route-from">Jakarta</span>
                    <i class="fas fa-arrow-right"></i>
                    <span class="route-to">Bandung</span>
                </div>
                <p class="route-info">~3 jam perjalanan</p>
                <p class="route-price">Mulai dari <strong>Rp 150.000</strong></p>
                <a href="<?php echo BASEURL; ?>booking" class="btn btn-outline">Pesan Sekarang</a>
            </div>
            <div class="route-card">
                <div class="route-header">
                    <span class="route-from">Jakarta</span>
                    <i class="fas fa-arrow-right"></i>
                    <span class="route-to">Yogyakarta</span>
                </div>
                <p class="route-info">~10 jam perjalanan</p>
                <p class="route-price">Mulai dari <strong>Rp 350.000</strong></p>
                <a href="<?php echo BASEURL; ?>booking" class="btn btn-outline">Pesan Sekarang</a>
            </div>
            <div class="route-card">
                <div class="route-header">
                    <span class="route-from">Bandung</span>
                    <i class="fas fa-arrow-right"></i>
                    <span class="route-to">Surabaya</span>
                </div>
                <p class="route-info">~8 jam perjalanan</p>
                <p class="route-price">Mulai dari <strong>Rp 300.000</strong></p>
                <a href="<?php echo BASEURL; ?>booking" class="btn btn-outline">Pesan Sekarang</a>
            </div>
            <div class="route-card">
                <div class="route-header">
                    <span class="route-from">Jakarta</span>
                    <i class="fas fa-arrow-right"></i>
                    <span class="route-to">Semarang</span>
                </div>
                <p class="route-info">~6 jam perjalanan</p>
                <p class="route-price">Mulai dari <strong>Rp 250.000</strong></p>
                <a href="<?php echo BASEURL; ?>/booking" class="btn btn-outline">Pesan Sekarang</a>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="testimonials">
    <div class="container">
        <h2>Apa Kata Pelanggan Kami?</h2>
        <div class="testimonials-grid">
            <div class="testimonial-card">
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p class="testimonial-text">"Perjalanan saya sangat nyaman! Bus bersih, sopir professional, dan tiba tepat waktu. Saya akan menggunakan Sinar Jaya lagi untuk perjalanan selanjutnya."</p>
                <div class="testimonial-author">
                    <strong>Budi Santoso</strong>
                    <span>Verified Passenger</span>
                </div>
            </div>
            <div class="testimonial-card">
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p class="testimonial-text">"Proses pemesanan online sangat mudah dan cepat. Customer service responsif menjawab pertanyaan saya. Terima kasih Sinar Jaya!"</p>
                <div class="testimonial-author">
                    <strong>Siti Nurhaliza</strong>
                    <span>Verified Passenger</span>
                </div>
            </div>
            <div class="testimonial-card">
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p class="testimonial-text">"Harga lebih murah dibanding kompetitor, tapi kualitas layanan jauh lebih baik. WiFi gratis juga sangat membantu selama perjalanan."</p>
                <div class="testimonial-author">
                    <strong>Ahmad Wijaya</strong>
                    <span>Verified Passenger</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <h2>Siap untuk Perjalanan Berikutnya?</h2>
        <p>Jangan lewatkan penawaran spesial kami. Pesan tiket sekarang dan nikmati diskon hingga 20%!</p>
        <a href="<?php echo BASEURL; ?>booking" class="btn btn-primary btn-lg">Pesan Tiket Sekarang</a>
    </div>
</section>