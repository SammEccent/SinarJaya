<?php
defined('BASEURL') or exit('No direct script access allowed');
require_once __DIR__ . '/../templates/header.php';
?>

<main>
    <section class="hero-section">
        <div class="hero-background">
            <img src="/img/premium-bus-night.png" alt="Sinar Jaya Premium Bus" class="hero-image">
            <div class="hero-overlay"></div>
        </div>

        <div class="hero-content">
            <h1 class="hero-title">Luxury Travel Experience</h1>
            <p class="hero-subtitle">Experience premium comfort and exceptional service</p>

            <div class="search-card glass">
                <form class="search-form">
                    <div class="form-group">
                        <label for="asal">Kota Asal</label>
                        <div class="input-wrapper">
                            <svg class="icon" viewBox="0 0 24 24" fill="none">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z" stroke="currentColor" stroke-width="2" />
                                <circle cx="12" cy="9" r="2.5" stroke="currentColor" stroke-width="2" />
                            </svg>
                            <input type="text" id="asal" name="asal" placeholder="Pilih kota keberangkatan" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="tujuan">Kota Tujuan</label>
                        <div class="input-wrapper">
                            <svg class="icon" viewBox="0 0 24 24" fill="none">
                                <path d="M12 22c-1.1 0-2-.9-2-2h4c0 1.1-.9 2-2 2zm6-6l2 2v1H4v-1l2-2v-5c0-3.07 1.64-5.64 4.5-6.32V4c0-.83.67-1.5 1.5-1.5s1.5.67 1.5 1.5v.68C16.36 5.36 18 7.92 18 11v5z" stroke="currentColor" stroke-width="2" />
                            </svg>
                            <input type="text" id="tujuan" name="tujuan" placeholder="Pilih kota tujuan" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="tanggal">Tanggal Keberangkatan</label>
                        <div class="input-wrapper">
                            <svg class="icon" viewBox="0 0 24 24" fill="none">
                                <rect x="3" y="4" width="18" height="18" rx="2" stroke="currentColor" stroke-width="2" />
                                <path d="M3 10h18M8 2v4M16 2v4" stroke="currentColor" stroke-width="2" />
                            </svg>
                            <input type="date" id="tanggal" name="tanggal" required>
                        </div>
                    </div>

                    <button type="submit" class="search-btn">
                        Cari Tiket Sekarang
                        <svg class="btn-icon" viewBox="0 0 24 24" fill="none">
                            <path d="M5 12h14M12 5l7 7-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </section>

    <section class="benefits-section">
        <h2 class="section-title">Premium Member Benefits</h2>
        <div class="benefits-grid">
            <div class="benefit-card glass">
                <div class="benefit-icon">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke="currentColor" stroke-width="2" />
                    </svg>
                </div>
                <h3>Fast Booking</h3>
                <p>Quick and seamless ticket reservation process</p>
            </div>

            <div class="benefit-card glass">
                <div class="benefit-icon">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" stroke="currentColor" stroke-width="2" />
                    </svg>
                </div>
                <h3>Reward Points</h3>
                <p>Earn points with every booking</p>
            </div>

            <div class="benefit-card glass">
                <div class="benefit-icon">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M7 10l5 5 5-5M12 15V3" stroke="currentColor" stroke-width="2" />
                    </svg>
                </div>
                <h3>Special Discounts</h3>
                <p>Exclusive deals for premium members</p>
            </div>

            <div class="benefit-card glass">
                <div class="benefit-icon">
                    <svg viewBox="0 0 24 24" fill="none">
                        <circle cx="12" cy="12" r="8" stroke="currentColor" stroke-width="2" />
                        <path d="M12 8v4M12 16h.01" stroke="currentColor" stroke-width="2" />
                    </svg>
                </div>
                <h3>Priority Support</h3>
                <p>24/7 dedicated customer service</p>
            </div>
        </div>
    </section>
</main>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>