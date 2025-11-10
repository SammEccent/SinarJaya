<?php

// app/config/mail.php

// Konfigurasi untuk PHPMailer
// Ganti dengan detail server SMTP Anda.
// Contoh menggunakan Gmail. Pastikan Anda mengaktifkan "Akses aplikasi yang kurang aman"
// atau menggunakan "Sandi Aplikasi" jika 2FA (Verifikasi 2 Langkah) aktif di akun Google Anda.

return [
    'host'       => 'smtp.gmail.com', // Server SMTP, contoh: smtp.gmail.com
    'username'   => 'samirudin20160464@gmail.com', // Alamat email Anda untuk mengirim
    'password'   => 'yymf dssy hnwf mnsi', // Sandi aplikasi atau password email Anda
    'port'       => 587, // Port SMTP (587 untuk TLS, 465 untuk SSL)
    'encryption' => 'tls', // Gunakan 'tls' atau 'ssl'
    'from_email' => 'no-reply@sinarjaya.com',
    'from_name'  => 'Sinar Jaya Support'
];
