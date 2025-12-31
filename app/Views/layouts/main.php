<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? htmlspecialchars($title) . ' - ' : ''; ?>Sinar Jaya Bus</title>
    <link rel="stylesheet" href="<?php echo BASEURL; ?>assets/css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="container">
            <div class="navbar-brand">
                <a href="<?php echo BASEURL; ?>" class="logo">
                    <i class="fas fa-bus"></i> Sinar Jaya
                </a>
            </div>
            <ul class="nav-menu">
                <li><a href="<?php echo BASEURL; ?>" class="nav-link">Beranda</a></li>
                <li><a href="<?php echo BASEURL; ?>home/search" class="nav-link">Pesan Tiket</a></li>
                <li><a href="<?php echo BASEURL; ?>home/about" class="nav-link">Tentang Kami</a></li>
                <li><a href="#footer-kontak" class="nav-link">Kontak</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="dropdown">
                        <a href="#" class="nav-link">Akun <i class="fas fa-chevron-down"></i></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo BASEURL; ?>/user/profile">Profil</a></li>
                            <li><a href="<?php echo BASEURL; ?>/user/bookings">Pemesanan Saya</a></li>
                            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                                <li><a href="<?php echo BASEURL; ?>/admin/dashboard">Admin Panel</a></li>
                            <?php endif; ?>
                            <li><a href="<?php echo BASEURL; ?>/auth/logout">Logout</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li><a href="<?php echo BASEURL; ?>auth/register" class="nav-link btn-register">Register</a></li>
                    <li><a href="<?php echo BASEURL; ?>auth/login" class="nav-link btn-login">Login</a></li>
                <?php endif; ?>
            </ul>
            <div class="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <?php echo $content; ?>
    </main>

    <!-- Footer -->
    <footer class="footer" id="footer-kontak">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Sinar Jaya Bus</h3>
                    <p>Layanan transportasi bus terpercaya dengan standar kenyamanan tertinggi.</p>
                    <div class="social-links">
                        <a href="#" title="Facebook"><i class="fab fa-facebook"></i></a>
                        <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="#" title="Twitter"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
                <div class="footer-section">
                    <h4>Layanan</h4>
                    <ul>
                        <li><a href="#">Pesan Tiket</a></li>
                        <li><a href="#">Cek Jadwal</a></li>
                        <li><a href="#">Lacak Pesanan</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Informasi</h4>
                    <ul>
                        <li><a href="#">Tentang Kami</a></li>
                        <li><a href="#">Kebijakan Privasi</a></li>
                        <li><a href="#">Syarat & Ketentuan</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Hubungi Kami</h4>
                    <p><i class="fas fa-phone"></i> +62 812-3456-7890</p>
                    <p><i class="fas fa-envelope"></i> info@sinarja.com</p>
                    <p><i class="fas fa-map-marker-alt"></i> Jakarta, Indonesia</p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 Sinar Jaya Bus. Semua hak dilindungi.</p>
            </div>
        </div>
    </footer>

    <script src="<?php echo BASEURL; ?>assets/js/main.js"></script>
</body>

</html>