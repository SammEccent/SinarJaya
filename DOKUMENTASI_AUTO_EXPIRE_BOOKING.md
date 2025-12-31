# Dokumentasi: Auto Expire Booking

## Deskripsi

Implementasi fitur untuk otomatis mengubah status booking menjadi "expired" ketika waktu pembayaran habis.

## Perubahan yang Dilakukan

### 1. BookingModel.php

**File:** [app/Models/BookingModel.php](app/Models/BookingModel.php)

Menambahkan method baru `checkAndUpdateExpiredBookings()`:

```php
public function checkAndUpdateExpiredBookings()
{
    $this->db->prepare('
        UPDATE bookings
        SET booking_status = "expired", updated_at = :updated_at
        WHERE booking_status = "pending"
        AND payment_expiry IS NOT NULL
        AND payment_expiry < :current_time
    ');

    $currentTime = date('Y-m-d H:i:s');
    $this->db->bind(':updated_at', $currentTime);
    $this->db->bind(':current_time', $currentTime);

    if ($this->db->execute()) {
        return $this->db->rowCount();
    }

    return 0;
}
```

**Fungsi:** Mengecek semua booking dengan status "pending" yang `payment_expiry`-nya sudah lewat, kemudian mengubah statusnya menjadi "expired".

### 2. PaymentController.php

**File:** [app/Controllers/PaymentController.php](app/Controllers/PaymentController.php)

#### a. Method `create()` - Halaman Pembayaran

- Menambahkan `$this->bookingModel->checkAndUpdateExpiredBookings()` di awal method
- Menambahkan validasi untuk mengecek apakah booking sudah expired sebelum menampilkan halaman pembayaran

```php
// Check and update expired bookings
$this->bookingModel->checkAndUpdateExpiredBookings();

// Check if booking is expired
if ($booking['booking_status'] === 'expired') {
    $_SESSION['error'] = 'Booking telah kedaluwarsa. Waktu pembayaran telah habis.';
    header('Location: ' . BASEURL . 'user/bookings');
    exit;
}
```

#### b. Method `processMethod()` - Proses Pembayaran

- Menambahkan `$this->bookingModel->checkAndUpdateExpiredBookings()` di awal method
- Menambahkan validasi untuk mencegah pembayaran jika booking sudah expired

```php
// Check and update expired bookings first
$this->bookingModel->checkAndUpdateExpiredBookings();

// Check if booking is expired
if ($booking['booking_status'] === 'expired') {
    $_SESSION['error'] = 'Booking telah kedaluwarsa. Waktu pembayaran telah habis.';
    header('Location: ' . BASEURL . 'user/bookings');
    exit;
}
```

### 3. UserController.php

**File:** [app/Controllers/UserController.php](app/Controllers/UserController.php)

#### Method `bookings()` - Halaman Daftar Booking

- Menambahkan `$this->bookingModel->checkAndUpdateExpiredBookings()` sebelum mengambil data booking user

```php
// Check and update expired bookings
$this->bookingModel->checkAndUpdateExpiredBookings();
```

**Fungsi:** Memastikan status booking selalu up-to-date ketika user mengakses halaman daftar booking.

### 4. method-selection.php

**File:** [app/Views/payment/method-selection.php](app/Views/payment/method-selection.php)

Menambahkan auto-redirect di JavaScript countdown timer:

```javascript
if (distance < 0) {
  document.querySelector(".expiry-time").innerHTML =
    '<i class="fas fa-times-circle"></i> Waktu pembayaran habis';
  document.querySelector(".payment-expiry").style.background = "#fee2e2";
  document.querySelector(".payment-expiry").style.borderColor = "#fca5a5";
  submitBtn.disabled = true;

  // Redirect to bookings page after 2 seconds
  setTimeout(function () {
    window.location.href = "<?php echo BASEURL; ?>user/bookings";
  }, 2000);
}
```

**Fungsi:** Setelah countdown habis, user akan otomatis di-redirect ke halaman daftar booking dalam 2 detik.

## Cara Kerja

1. **Trigger Otomatis:**

   - Method `checkAndUpdateExpiredBookings()` dipanggil di beberapa titik kritis:
     - Saat user membuka halaman pembayaran
     - Saat user memproses metode pembayaran
     - Saat user melihat daftar booking

2. **Update Database:**

   - Query SQL mengecek semua booking dengan:
     - Status = "pending"
     - `payment_expiry` tidak NULL
     - `payment_expiry` < waktu sekarang
   - Booking yang memenuhi kriteria diubah statusnya menjadi "expired"

3. **Validasi:**

   - Sebelum menampilkan halaman pembayaran atau memproses pembayaran
   - Sistem mengecek status booking
   - Jika expired, user akan ditolak dengan pesan error

4. **Frontend:**
   - JavaScript countdown menampilkan pesan "Waktu pembayaran habis"
   - Tombol submit di-disable
   - Auto-redirect ke halaman booking setelah 2 detik

## Flow Diagram

```
User Akses Halaman
       ↓
checkAndUpdateExpiredBookings() ← Update booking yang expired
       ↓
Cek Status Booking
       ↓
    [Expired?]
    ↙     ↘
  Yes      No
   ↓        ↓
 Error   Lanjut
   ↓        ↓
Redirect  Show Page
```

## Testing

Untuk testing fitur ini:

1. Buat booking baru
2. Tunggu sampai `payment_expiry` terlewat, atau ubah manual di database:
   ```sql
   UPDATE bookings
   SET payment_expiry = DATE_SUB(NOW(), INTERVAL 5 MINUTE)
   WHERE id = [booking_id];
   ```
3. Akses halaman pembayaran atau daftar booking
4. Booking akan otomatis berubah status menjadi "expired"
5. Coba akses pembayaran → akan ditolak dengan error

## Catatan

- Fitur ini tidak menggunakan cron job, melainkan triggered saat user akses halaman
- Jika ingin implementasi cron job untuk pengecekan berkala, bisa buat file PHP terpisah yang menjalankan `checkAndUpdateExpiredBookings()` dan jalankan via cron/task scheduler
- Expired booking tidak menghapus data, hanya mengubah status
