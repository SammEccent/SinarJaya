# Functional Testing Checklist - Sinar Jaya Bus Booking System

## 1. Authentication & User Management

### 1.1 Register

- [ ] User dapat mengakses halaman register
- [ ] Form validasi bekerja (required fields, email format, password match)
- [ ] User baru berhasil terdaftar ke database
- [ ] Email verifikasi terkirim ke user
- [ ] Error message muncul jika email sudah terdaftar
- [ ] Password ter-hash dengan benar di database

### 1.2 Email Verification

- [ ] User menerima email verifikasi setelah register
- [ ] Link verifikasi dapat diklik dan bekerja
- [ ] Status `email_verified_at` terupdate setelah verifikasi
- [ ] User mendapat notifikasi sukses setelah verifikasi
- [ ] Link verifikasi expired setelah digunakan
- [ ] Fitur resend verification email bekerja

### 1.3 Login

- [ ] User dapat mengakses halaman login
- [ ] Login berhasil dengan kredensial yang benar
- [ ] Error message muncul dengan kredensial salah
- [ ] Session tersimpan setelah login
- [ ] Redirect ke halaman sesuai role (admin/user)
- [ ] User yang belum verifikasi email tidak bisa login

### 1.4 Logout

- [ ] User dapat logout
- [ ] Session terhapus setelah logout
- [ ] Redirect ke halaman home setelah logout
- [ ] User tidak bisa akses halaman yang memerlukan login setelah logout

### 1.5 User Profile

- [ ] User dapat melihat profil mereka
- [ ] User dapat edit profil (nama, telepon, email)
- [ ] Validasi form bekerja dengan benar
- [ ] Data terupdate di database
- [ ] Error message muncul jika email sudah digunakan user lain

---

## 2. Public Pages

### 2.1 Landing Page

- [ ] Halaman landing dapat diakses tanpa login
- [ ] Hero section tampil dengan benar
- [ ] Form pencarian tiket tampil dan dapat digunakan
- [ ] Rute populer tampil (max 2) dengan data real dari database
- [ ] Harga pada rute populer sudah menggunakan base_price_multiplier
- [ ] Tidak ada duplicate rute (forward/return pair)
- [ ] Session error messages tidak muncul di landing page
- [ ] Tombol "Mulai Pemesanan" scroll ke #search-section

### 2.2 About Page

- [ ] Halaman tentang kami dapat diakses
- [ ] Menampilkan 2 bus class (Executive dan Suite Class)
- [ ] Layout 2 kolom rata tengah
- [ ] Tidak menampilkan Statistics section
- [ ] Tidak menampilkan Contact CTA section
- [ ] Konten tampil dengan benar

### 2.3 Navbar

- [ ] Link "Beranda" mengarah ke home
- [ ] Link "Pesan Tiket" mengarah ke #search-section di landing page
- [ ] Link "Tentang Kami" berfungsi
- [ ] Link "Kontak" scroll ke footer
- [ ] Dropdown "Akun" muncul jika user sudah login
- [ ] Menu "Admin Panel" hanya muncul untuk admin
- [ ] Button Login/Register muncul jika belum login
- [ ] Hamburger menu berfungsi di mobile

---

## 3. Booking Flow (User Side)

### 3.1 Search Tiket

- [ ] Form pencarian dapat diisi (origin, destination, date, passengers)
- [ ] Validasi form bekerja (required fields, date validation)
- [ ] Hasil pencarian tampil sesuai kriteria
- [ ] Menampilkan detail jadwal (bus class, jam, harga, kursi tersedia)
- [ ] Harga sudah dikalikan base_price_multiplier
- [ ] Tombol "Pilih Kursi" hanya muncul jika login
- [ ] Redirect ke login jika belum login
- [ ] Error message muncul jika tidak ada jadwal tersedia
- [ ] Filter/sort hasil pencarian bekerja (jika ada)

### 3.2 Seat Selection

- [ ] Halaman seat selection tampil dengan layout bus yang benar
- [ ] Executive class (2-2): toilet di bottom-left (baris terakhir posisi A)
- [ ] Suite class (1-1): toilet setelah row 6
- [ ] Kursi 8C dan 8D (Executive) memiliki ukuran yang sama dengan kursi lain
- [ ] Posisi B di baris terakhir kosong (seat-empty) untuk Executive
- [ ] Kursi available dapat diklik dan berubah status jadi selected
- [ ] Kursi booked tidak dapat diklik
- [ ] Jumlah kursi terpilih dan total harga terupdate real-time
- [ ] Summary pemilihan kursi tampil di sidebar
- [ ] Tombol "Lanjut ke Form Pemesanan" disabled jika belum pilih kursi
- [ ] Driver icon tampil di bagian atas layout
- [ ] Legend (Tersedia, Dipilih, Sudah Dipesan) tampil dengan benar

### 3.3 Booking Form (Passenger Details)

- [ ] Form penumpang tampil sesuai jumlah kursi yang dipilih
- [ ] Validasi form bekerja (nama, NIK, telepon, email)
- [ ] Data pickup dan drop location dapat dipilih
- [ ] Summary booking tampil dengan benar
- [ ] Tombol "Lanjut ke Pembayaran" dapat diklik
- [ ] Data booking tersimpan ke database
- [ ] Status kursi berubah dari available ke booked
- [ ] Booking ID ter-generate dengan benar

### 3.4 Payment Method Selection

- [ ] Halaman pilih metode pembayaran tampil
- [ ] Menampilkan metode pembayaran yang tersedia (Transfer Bank, E-wallet)
- [ ] User dapat memilih metode pembayaran
- [ ] Redirect ke halaman instruksi pembayaran

### 3.5 Payment Instructions & Upload Bukti

- [ ] Instruksi pembayaran tampil sesuai metode yang dipilih
- [ ] Detail pembayaran tampil (total, nomor rekening, nama rekening)
- [ ] User dapat upload bukti pembayaran
- [ ] Validasi file upload bekerja (format gambar, ukuran)
- [ ] File tersimpan di folder public/uploads/payments/
- [ ] Status payment berubah ke "pending" setelah upload
- [ ] Redirect ke halaman payment detail

### 3.6 Payment Detail

- [ ] Halaman payment detail tampil dengan informasi lengkap
- [ ] Menampilkan bukti pembayaran yang diupload
- [ ] Status pembayaran tampil (pending, approved, rejected)
- [ ] Tombol "Pesanan Saya" mengarah ke halaman user/bookings
- [ ] Tombol upload bukti muncul jika status pending dan belum ada bukti

---

## 4. User Dashboard

### 4.1 My Bookings

- [ ] Menampilkan daftar semua booking user
- [ ] Filter berdasarkan status bekerja (Semua, Pending, Confirmed, Cancelled)
- [ ] Detail booking tampil (tanggal, rute, kursi, status, total)
- [ ] Tombol "Lihat Detail" mengarah ke booking detail
- [ ] Tombol "Upload Bukti" muncul untuk pembayaran pending
- [ ] Menampilkan status pembayaran dengan benar

### 4.2 Booking Detail

- [ ] Detail lengkap booking tampil
- [ ] Informasi jadwal, rute, bus tampil
- [ ] Daftar penumpang tampil
- [ ] Informasi pembayaran tampil
- [ ] Tombol download e-ticket tampil jika pembayaran approved
- [ ] E-ticket PDF dapat didownload

---

## 5. Admin Panel

### 5.1 Admin Login & Dashboard

- [ ] Admin dapat login dengan akun admin
- [ ] Redirect ke admin/dashboard setelah login
- [ ] Dashboard menampilkan statistik (total booking, revenue, dll)
- [ ] Sidebar menu tampil dengan benar
- [ ] Admin tidak bisa diakses oleh user biasa

### 5.2 Kelola Routes (CRUD)

- [ ] Admin dapat melihat daftar routes
- [ ] Admin dapat menambah route baru
- [ ] Admin dapat edit route
- [ ] Admin dapat delete route
- [ ] Validasi form bekerja
- [ ] Route locations dapat dikelola
- [ ] Status route (active/inactive) dapat diubah

### 5.3 Kelola Schedules (CRUD)

- [ ] Admin dapat melihat daftar schedules
- [ ] Admin dapat menambah schedule baru
- [ ] Admin dapat edit schedule
- [ ] Admin dapat delete schedule
- [ ] Dropdown route_type (Berangkat/Pulang) tampil
- [ ] Validasi bus scheduling bekerja (3 level checks)
- [ ] Error muncul jika bus sudah dijadwalkan di waktu yang sama
- [ ] Error muncul jika route_type tidak sesuai (harus selang-seling)
- [ ] Error muncul jika route consistency tidak valid (pulang harus dari destinasi berangkat)
- [ ] Validasi datetime bekerja (departure < arrival)
- [ ] Status schedule dapat diubah (scheduled, departed, arrived, cancelled)
- [ ] Auto-update departed schedules bekerja saat halaman diakses

### 5.4 Kelola Buses (CRUD)

- [ ] Admin dapat melihat daftar buses
- [ ] Admin dapat menambah bus baru
- [ ] Admin dapat edit bus
- [ ] Admin dapat delete bus
- [ ] Bus class dapat dipilih
- [ ] Seat layout dapat dipilih
- [ ] Generate seats otomatis setelah bus dibuat
- [ ] Jumlah seats sesuai dengan layout yang dipilih

### 5.5 Kelola Payments

- [ ] Admin dapat melihat daftar payments
- [ ] Filter berdasarkan status payment bekerja
- [ ] Admin dapat melihat detail payment
- [ ] Admin dapat melihat bukti pembayaran
- [ ] Admin dapat approve payment
- [ ] Admin dapat reject payment dengan alasan
- [ ] Status payment terupdate setelah approve/reject
- [ ] Booking status terupdate setelah payment approved
- [ ] Email notifikasi terkirim ke user setelah approve/reject (jika ada)

### 5.6 Kelola Users

- [ ] Admin dapat melihat daftar users
- [ ] Admin dapat melihat detail user
- [ ] Admin dapat ubah role user (admin/customer)
- [ ] Admin dapat block/unblock user (jika ada fitur)

### 5.7 Kelola Bookings (Admin View)

- [ ] Admin dapat melihat semua bookings
- [ ] Filter berdasarkan status bekerja
- [ ] Admin dapat melihat detail booking
- [ ] Admin dapat cancel booking (jika ada fitur)
- [ ] Admin dapat export data booking (jika ada)

---

## 6. Auto-Expire & Status Updates

### 6.1 Auto-Update Departed Schedules

- [ ] Schedule status berubah dari "scheduled" ke "departed" otomatis saat departure_datetime terlewat
- [ ] Update terjadi saat admin mengakses halaman schedules
- [ ] Hanya schedule dengan status "scheduled" yang diupdate

### 6.2 Auto-Expire Booking (Jika Implementasi)

- [ ] Booking expired otomatis jika pembayaran tidak dilakukan dalam waktu tertentu
- [ ] Status booking berubah ke "expired"
- [ ] Kursi kembali available setelah booking expired

---

## 7. Edge Cases & Security

### 7.1 Security

- [ ] Halaman admin tidak bisa diakses tanpa login
- [ ] Halaman admin tidak bisa diakses oleh user biasa
- [ ] User hanya bisa melihat booking mereka sendiri
- [ ] SQL injection prevention bekerja
- [ ] XSS prevention bekerja (htmlspecialchars)
- [ ] CSRF protection (jika ada)
- [ ] Password di-hash dengan benar (bcrypt/password_hash)

### 7.2 Data Validation

- [ ] Tidak bisa book kursi yang sudah di-book
- [ ] Tidak bisa book jadwal yang sudah departed
- [ ] Tidak bisa book dengan jumlah penumpang melebihi kursi tersedia
- [ ] Tanggal pencarian tidak bisa di masa lalu
- [ ] Input sanitization bekerja dengan benar

### 7.3 Error Handling

- [ ] Error messages tampil dengan jelas dan user-friendly
- [ ] 404 page tampil untuk URL yang tidak valid
- [ ] Database error ditangani dengan baik
- [ ] File upload error ditangani (ukuran, format)

### 7.4 Edge Cases

- [ ] Concurrent booking (2 user book kursi sama bersamaan)
- [ ] Bus tidak bisa dijadwalkan 2x di waktu yang sama
- [ ] Route type validation untuk arus balik
- [ ] Minimum passenger validation
- [ ] Maximum seats validation

---

## 8. Performance & UX

### 8.1 Performance

- [ ] Halaman load dengan cepat (<3 detik)
- [ ] Query database optimized (tidak ada N+1 query)
- [ ] Image optimization untuk bukti pembayaran
- [ ] No memory leaks

### 8.2 Responsive Design

- [ ] Layout responsive di mobile (320px - 480px)
- [ ] Layout responsive di tablet (768px - 1024px)
- [ ] Layout responsive di desktop (>1024px)
- [ ] Seat selection bekerja di mobile
- [ ] Navigation menu bekerja di mobile

### 8.3 User Experience

- [ ] Loading indicator muncul saat proses berlangsung
- [ ] Success messages muncul setelah aksi berhasil
- [ ] Confirmation dialog muncul sebelum delete
- [ ] Breadcrumb navigation (jika ada)
- [ ] Back button bekerja dengan benar
- [ ] Form tidak hilang saat validation error

---

## 9. Integration Testing

### 9.1 Email Service

- [ ] Email verifikasi terkirim
- [ ] Email payment approval terkirim (jika ada)
- [ ] Email payment rejection terkirim (jika ada)
- [ ] Email format sesuai template
- [ ] Email deliverability (tidak masuk spam)

### 9.2 File Storage

- [ ] Upload bukti pembayaran berhasil
- [ ] File tersimpan di path yang benar
- [ ] File dapat diakses melalui URL
- [ ] File permissions benar

### 9.3 PDF Generation

- [ ] E-ticket PDF dapat di-generate
- [ ] Format PDF sesuai template
- [ ] QR code tampil di ticket (jika ada)
- [ ] Download PDF bekerja

---

## 10. Browser Compatibility

- [ ] Chrome (latest)
- [ ] Firefox (latest)
- [ ] Safari (latest)
- [ ] Edge (latest)
- [ ] Mobile browsers (Chrome, Safari)

---

## Notes untuk Testing

1. **Database State**: Reset database sebelum testing atau gunakan database testing terpisah
2. **Test Data**: Siapkan data dummy untuk routes, schedules, buses, users
3. **Environment**: Test di environment yang mirip dengan production
4. **Logging**: Enable error logging untuk troubleshooting
5. **Screenshots**: Ambil screenshot untuk bug yang ditemukan
6. **Priority**: Test critical path terlebih dahulu (booking flow, payment, admin)

---

## Bug Report Template

```
Title: [Judul Bug]
Severity: [Critical/High/Medium/Low]
Environment: [Browser, OS]
Steps to Reproduce:
1.
2.
3.
Expected Result:
Actual Result:
Screenshots: [Attach]
Additional Notes:
```

---

## Test Completion Summary

- Total Test Cases: \_\_\_
- Passed: \_\_\_
- Failed: \_\_\_
- Blocked: \_\_\_
- Not Tested: \_\_\_
- Pass Rate: \_\_\_%

**Tested By**: ******\_\_\_******
**Date**: ******\_\_\_******
**Sign Off**: ******\_\_\_******
