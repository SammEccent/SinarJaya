# QUICK START - KELOLA PEMBAYARAN

## Setup (One-time)

### 1. Buat Folder Upload

```bash
mkdir public/uploads/payments
chmod 777 public/uploads/payments
```

### 2. Update Rekening Bank (Opsional)

Edit file: `app/Controllers/PaymentController.php` line ~85

```php
'banks' => [
    ['name' => 'BCA', 'account' => 'NOMOR_REKENING_BCA', 'holder' => 'NAMA_PEMILIK'],
    ['name' => 'Mandiri', 'account' => 'NOMOR_REKENING_MANDIRI', 'holder' => 'NAMA_PEMILIK'],
    // ... tambahkan bank lain
]
```

### 3. Update Nomor E-Wallet (Opsional)

Edit file: `app/Controllers/PaymentController.php` line ~95

```php
'wallets' => [
    ['name' => 'GoPay', 'number' => 'NOMOR_GOPAY'],
    ['name' => 'OVO', 'number' => 'NOMOR_OVO'],
    // ... tambahkan wallet lain
]
```

## Flow User

### 1. User Selesai Booking

Setelah booking berhasil, user otomatis redirect ke:

```
/payment/create?booking_id={id}
```

### 2. Pilih Metode Pembayaran

- User melihat ringkasan booking
- User pilih metode: Transfer Bank / E-Wallet / QRIS
- Klik "Lanjut ke Instruksi Pembayaran"

### 3. Lihat Instruksi & Upload Bukti

- User melihat instruksi pembayaran
- User transfer sesuai nominal
- User upload bukti pembayaran (JPG/PNG, max 2MB)
- Klik "Upload Bukti Pembayaran"

### 4. Menunggu Verifikasi

- Status: "Menunggu Verifikasi Admin"
- User bisa lihat detail di `/payment/show/{id}`
- Admin verifikasi di `/admin/payments`

### 5. Pembayaran Dikonfirmasi

- Admin approve payment
- Status berubah: "Pembayaran Berhasil"
- Booking status: "Confirmed"
- User dapat notifikasi (jika email setup)

## Flow Admin

### 1. Lihat Daftar Pembayaran

URL: `/admin/payments`

- Lihat semua pembayaran dengan status
- Filter: Pending / Paid / Failed

### 2. Verifikasi Pembayaran

- Klik payment dengan status "Pending"
- Lihat bukti pembayaran yang diupload
- Cek apakah transfer sudah masuk
- Approve atau Reject

### 3. Approve Payment

- Klik "Approve"
- Payment status → "Paid"
- Booking status → "Confirmed"
- User bisa boarding

### 4. Reject Payment

- Klik "Reject"
- Payment status → "Failed"
- User bisa upload ulang bukti baru

## Test Flow

### Test Payment Process

1. Login sebagai user: `user@gmail.com` / `user123`
2. Cari tiket: Origin = Jakarta, Destination = Surabaya
3. Pilih jadwal yang tersedia
4. Pilih kursi (2 kursi)
5. Isi data penumpang
6. Submit booking → Redirect ke payment
7. Pilih "Transfer Bank"
8. Upload gambar dummy sebagai bukti
9. Check status di `/payment/show/{id}`

### Test Admin Verification

1. Login sebagai admin: `admin@sinarjaya.com` / `admin123`
2. Go to `/admin/payments`
3. Find payment dengan status "Pending"
4. Klik untuk lihat detail
5. Klik "Approve Payment"
6. Verify status berubah ke "Paid"

## File Locations

```
app/
├── Controllers/
│   └── PaymentController.php          ← Controller utama
├── Models/
│   └── PaymentModel.php                ← Database operations
└── Views/
    └── payment/
        ├── method-selection.php        ← Pilih metode
        ├── instructions.php            ← Instruksi & upload
        └── show.php                    ← Detail pembayaran
```

## Common URLs

### User

- Pilih metode: `/payment/create?booking_id={id}`
- Instruksi: `/payment/instructions/{payment_id}`
- Detail: `/payment/show/{payment_id}`

### Admin

- List payments: `/admin/payments`
- Detail payment: `/admin/payments/{id}`

## Troubleshooting

### Upload Gagal

```bash
# Cek permission folder
ls -la public/uploads/payments
# Harus: drwxrwxrwx

# Jika tidak, jalankan:
chmod 777 public/uploads/payments
```

### Payment Tidak Muncul

- Cek database table `payments`
- Cek foreign key `booking_id` valid
- Cek log error PHP

### File Tidak Tersimpan

- Cek `upload_max_filesize` di php.ini (min 2M)
- Cek `post_max_size` di php.ini (min 3M)
- Restart web server setelah edit php.ini

## Quick Reference

### Payment Status

- `pending` = Menunggu pembayaran
- `paid` = Sudah dibayar (approved)
- `failed` = Gagal / ditolak
- `refunded` = Dikembalikan

### Payment Methods

- `bank_transfer` = Transfer Bank
- `e_wallet` = E-Wallet (GoPay, OVO, Dana)
- `qris` = QRIS Scan
- `credit_card` = Kartu Kredit (future)

### File Upload Rules

- Format: JPG, JPEG, PNG
- Max size: 2MB
- Saved to: `public/uploads/payments/`
- Filename: `payment_{id}_{timestamp}.{ext}`

---

**Ready to use!** 🚀
Sistem pembayaran sudah lengkap dan siap digunakan.
