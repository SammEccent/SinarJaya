# DOKUMENTASI KELOLA PEMBAYARAN

## Overview

Sistem pembayaran lengkap untuk menyelesaikan transaksi booking tiket bus. Mendukung berbagai metode pembayaran dengan upload bukti transfer dan verifikasi admin.

## Fitur Utama

### 1. Pemilihan Metode Pembayaran

- **Transfer Bank** (BCA, Mandiri, BNI)
- **E-Wallet** (GoPay, OVO, Dana, LinkAja)
- **QRIS** (Scan kode QR)
- Tampilan kartu metode pembayaran yang interaktif
- Detail rekening/nomor untuk setiap metode

### 2. Instruksi Pembayaran

- Instruksi step-by-step untuk setiap metode
- Copy rekening/nominal dengan satu klik
- QR Code untuk pembayaran QRIS
- Countdown timer batas waktu pembayaran
- Upload bukti pembayaran (JPG, JPEG, PNG, max 2MB)

### 3. Tracking Pembayaran

- Status pembayaran real-time
- Detail lengkap transaksi
- Histori pembayaran
- Notifikasi verifikasi admin

## Struktur File

```
app/
├── Controllers/
│   └── PaymentController.php          # Controller untuk pembayaran user
├── Models/
│   └── PaymentModel.php                # Model database pembayaran
└── Views/
    └── payment/
        ├── method-selection.php        # Halaman pilih metode
        ├── instructions.php            # Halaman instruksi & upload
        └── show.php                    # Halaman detail pembayaran

public/
└── uploads/
    └── payments/                       # Folder upload bukti pembayaran
```

## Database Schema

### Table: `payments`

```sql
CREATE TABLE `payments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `booking_id` int NOT NULL,
  `payment_method` enum('bank_transfer','credit_card','e_wallet','qris') NOT NULL,
  `payment_code` varchar(50) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_status` enum('pending','paid','failed','refunded') DEFAULT 'pending',
  `payment_proof_image` varchar(255) DEFAULT NULL,
  `paid_at` datetime DEFAULT NULL,
  `payment_details` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `booking_id` (`booking_id`),
  CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

## Flow Pembayaran

```
1. Booking selesai
   ↓
2. Redirect ke /payment/create?booking_id={id}
   ↓
3. User pilih metode pembayaran
   ↓
4. POST ke /payment/processMethod
   ↓
5. Create payment record (status: pending)
   ↓
6. Redirect ke /payment/instructions/{payment_id}
   ↓
7. Tampilkan instruksi + form upload bukti
   ↓
8. User upload bukti pembayaran
   ↓
9. POST ke /payment/uploadProof
   ↓
10. Update payment_proof_image
    ↓
11. Redirect ke /payment/show/{payment_id}
    ↓
12. Admin verifikasi pembayaran (di admin panel)
    ↓
13. Update status: pending → paid
    ↓
14. Update booking status: pending → confirmed
```

## URL Routes

### User Routes

- `GET  /payment/create?booking_id={id}` - Halaman pilih metode pembayaran
- `POST /payment/processMethod` - Proses pilihan metode
- `GET  /payment/instructions/{id}` - Halaman instruksi pembayaran
- `POST /payment/uploadProof` - Upload bukti pembayaran
- `GET  /payment/show/{id}` - Detail pembayaran

### Admin Routes (via AdminController)

- `GET  /admin/payments` - List semua pembayaran
- `GET  /admin/payments/{id}` - Detail pembayaran
- `POST /admin/payments/{id}/approve` - Approve pembayaran
- `POST /admin/payments/{id}/reject` - Reject pembayaran

## PaymentController Methods

### 1. `create()`

**Purpose:** Tampilkan halaman pemilihan metode pembayaran

**Parameters:**

- `GET booking_id` (required)

**Validations:**

- User harus login
- Booking harus ada
- Booking milik user yang login
- Booking status = 'pending'
- Payment belum dibuat

**Returns:** View `payment/method-selection.php`

### 2. `processMethod()`

**Purpose:** Proses pemilihan metode pembayaran

**Parameters:**

- `POST booking_id` (required)
- `POST payment_method` (required: bank_transfer|e_wallet|qris)

**Process:**

1. Validasi input
2. Generate payment code
3. Create payment record
4. Redirect ke instructions

**Payment Code Format:**

- Bank Transfer: `PAY-TRF-XXXXXXXX`
- E-Wallet: `PAY-EWL-XXXXXXXX`
- QRIS: `PAY-QRS-XXXXXXXX`

### 3. `instructions($payment_id)`

**Purpose:** Tampilkan instruksi pembayaran

**Parameters:**

- `$payment_id` (URL parameter)

**Returns:** View `payment/instructions.php` dengan:

- Payment details
- Instruksi step-by-step
- Bank accounts / wallet numbers / QR code
- Form upload bukti

### 4. `show($payment_id)`

**Purpose:** Tampilkan detail pembayaran

**Parameters:**

- `$payment_id` (URL parameter)

**Returns:** View `payment/show.php` dengan:

- Payment information
- Booking details
- Passenger list
- Payment proof (jika ada)

### 5. `uploadProof()`

**Purpose:** Upload bukti pembayaran

**Parameters:**

- `POST payment_id` (required)
- `FILE payment_proof` (required)

**Validations:**

- File type: JPG, JPEG, PNG
- Max size: 2MB

**Process:**

1. Validate file
2. Generate unique filename
3. Move file ke `uploads/payments/`
4. Update payment record
5. Redirect ke show

**Filename Format:** `payment_{id}_{timestamp}.{ext}`

## Payment Methods Configuration

### Bank Transfer

```php
'banks' => [
    ['name' => 'BCA', 'account' => '1234567890', 'holder' => 'PT Sinar Jaya Trans'],
    ['name' => 'Mandiri', 'account' => '0987654321', 'holder' => 'PT Sinar Jaya Trans'],
    ['name' => 'BNI', 'account' => '5556667778', 'holder' => 'PT Sinar Jaya Trans'],
]
```

### E-Wallet

```php
'wallets' => [
    ['name' => 'GoPay', 'number' => '081234567890'],
    ['name' => 'OVO', 'number' => '081234567890'],
    ['name' => 'Dana', 'number' => '081234567890'],
    ['name' => 'LinkAja', 'number' => '081234567890']
]
```

### QRIS

```php
'qr_code' => 'qris-sinarjaya.png' // Simpan di public/assets/images/
```

## View Components

### 1. method-selection.php

**Sections:**

- Payment header dengan kode booking
- Booking summary (rute, tanggal, penumpang, harga)
- Payment expiry countdown
- Payment method cards (radio selection)
- Submit button

**JavaScript Features:**

- Method card selection toggle
- Radio button auto-check
- Submit button enable/disable
- Countdown timer

### 2. instructions.php

**Sections:**

- Instructions header dengan payment code
- Status banner (pending/uploaded)
- Payment amount dengan copy button
- Bank accounts / wallet numbers dengan copy button
- QR code (untuk QRIS)
- Step-by-step instructions
- Upload form dengan preview

**JavaScript Features:**

- Copy to clipboard (amount & account)
- File preview before upload
- Drag & drop file upload

### 3. show.php

**Sections:**

- Payment header dengan status badge
- Payment information (kode, metode, jumlah, status)
- Booking information (kode booking, rute, tanggal)
- Passenger list
- Payment proof image
- Action buttons

**Status Badges:**

- Pending: Yellow (⏳)
- Paid: Green (✓)
- Failed: Red (✗)
- Refunded: Red (↺)

## PaymentModel Methods

### Query Methods

- `getAll($limit, $offset)` - Get all payments dengan pagination
- `findById($id)` - Get payment dengan JOIN ke bookings, users, schedules
- `getByBookingId($booking_id)` - Get payment berdasarkan booking
- `getByStatus($status, $limit, $offset)` - Filter by status
- `search($keyword)` - Search by booking code, user name, email, payment code

### Statistics

- `count()` - Total payments
- `countByStatus($status)` - Count by status
- `getStatistics()` - Aggregated stats (total revenue, avg payment, dll)

### CRUD Operations

- `create($data)` - Insert payment baru
- `update($id, $data)` - Update payment
- `delete($id)` - Delete payment

### Status Management

- `approvePayment($id, $paid_at)` - Set status = 'paid'
- `rejectPayment($id, $reason)` - Set status = 'failed'
- `refundPayment($id, $reason)` - Set status = 'refunded'

## Security

### Authentication

- Setiap method check `$_SESSION['user_id']`
- Redirect ke login jika belum login
- Save redirect URL untuk after login

### Authorization

- Verify payment milik user yang login
- Check payment['user_id'] === $\_SESSION['user_id']
- Prevent access ke payment milik user lain

### File Upload

- Validate file type (whitelist: JPG, JPEG, PNG)
- Validate file size (max 2MB)
- Generate unique filename (prevent overwrite)
- Store di folder `uploads/payments/` (bukan web-accessible root)
- Delete old proof saat upload baru

### SQL Injection Prevention

- Semua query menggunakan prepared statements
- Parameter binding dengan PDO
- No direct string concatenation

## Error Handling

### Common Errors

1. **"ID booking tidak valid"**

   - booking_id <= 0 atau tidak ada
   - Solution: Check GET parameter

2. **"Booking tidak ditemukan"**

   - Booking ID tidak exist di database
   - Solution: Redirect ke user/bookings

3. **"Booking ini tidak dapat dibayar"**

   - Booking status bukan 'pending'
   - Solution: Show appropriate message

4. **"Metode pembayaran tidak valid"**

   - Payment method tidak ada dalam whitelist
   - Solution: Return ke method selection

5. **"Format file harus JPG, JPEG, atau PNG"**

   - File type tidak sesuai
   - Solution: Upload file dengan format yang benar

6. **"Ukuran file maksimal 2MB"**
   - File terlalu besar
   - Solution: Compress atau pilih file lain

## UI/UX Features

### Responsive Design

- Desktop: 2-column layout (summary + methods)
- Tablet: 1-column layout
- Mobile: Stacked, touch-friendly buttons

### Interactive Elements

- Hover effects pada method cards
- Click to select payment method
- Auto-check radio button
- Copy button dengan feedback
- Drag & drop file upload
- Image preview before upload

### Visual Feedback

- Selected method cards (border + background)
- Countdown timer dengan warna
- Status badges dengan icon
- Success/error alerts
- Loading states pada buttons

### Accessibility

- Semantic HTML structure
- Icon + text labels
- Keyboard navigation support
- Clear error messages
- High contrast colors

## Testing Checklist

### Method Selection

- [ ] Show booking summary correctly
- [ ] Display all payment methods
- [ ] Method card click selects radio
- [ ] Submit button enables after selection
- [ ] Countdown timer works
- [ ] Expired payment blocks submission

### Payment Processing

- [ ] Create payment record dengan correct data
- [ ] Generate unique payment code
- [ ] Redirect ke instructions page
- [ ] Handle duplicate payment creation

### Instructions Page

- [ ] Show correct instructions per method
- [ ] Display bank accounts / wallet numbers
- [ ] QR code renders (or shows placeholder)
- [ ] Copy buttons work
- [ ] Upload form validates file type
- [ ] Upload form validates file size
- [ ] File preview displays correctly

### Upload Proof

- [ ] File uploads successfully
- [ ] Old proof deleted saat upload baru
- [ ] Database updated dengan filename
- [ ] Redirect ke show page
- [ ] Success message displayed

### Show Page

- [ ] Display all payment details
- [ ] Show booking information
- [ ] List all passengers
- [ ] Display proof image jika ada
- [ ] Action buttons work correctly

### Security

- [ ] Unauthenticated users redirected
- [ ] Users can't access other's payments
- [ ] File upload restricted to images
- [ ] No SQL injection vulnerabilities
- [ ] No XSS vulnerabilities

## Integration Points

### With BookingController

- `BookingController::store()` creates booking with `payment_expiry`
- Redirects to `payment/create` after successful booking
- Format: `BASEURL . 'payment/create?booking_id=' . $booking_id`

### With AdminController

- Admin can view all payments
- Admin can approve/reject payments
- Approval updates payment status dan booking status
- Rejection allows re-upload

### With Email System (Future)

- Send payment confirmation email
- Send payment reminder before expiry
- Send approval/rejection notification

## Future Enhancements

### Payment Gateway Integration

1. **Midtrans**

   - Direct payment via credit card
   - Auto-verification
   - Webhook untuk status update

2. **Xendit**

   - Virtual account auto-generate
   - Real-time payment notification

3. **QRIS Dynamic**
   - Generate unique QR per transaction
   - Auto-detect payment completion

### Features

- Payment reminder notifications
- Partial refund support
- Payment receipt PDF download
- Payment history export (CSV/Excel)
- Auto-cancel unpaid bookings after expiry
- Promo code / discount support
- Installment payment option

## Troubleshooting

### Problem: Upload folder not writable

**Solution:**

```bash
mkdir -p public/uploads/payments
chmod 777 public/uploads/payments
```

### Problem: QR code not displaying

**Solution:**

- Check file exists: `public/assets/images/qris-sinarjaya.png`
- Fallback to placeholder: `qris-placeholder.png`

### Problem: Payment not created

**Solution:**

- Check database connection
- Verify foreign key constraints
- Check error logs

### Problem: File upload fails

**Solution:**

- Check PHP upload_max_filesize (php.ini)
- Check post_max_size (php.ini)
- Verify folder permissions

## Configuration

### PHP Settings (php.ini)

```ini
upload_max_filesize = 2M
post_max_size = 3M
max_execution_time = 30
```

### Payment Expiry Time

Location: `BookingController::store()`

```php
'payment_expiry' => date('Y-m-d H:i:s', strtotime('+2 hours'))
```

Change `+2 hours` to desired duration.

### Bank Accounts / Wallet Numbers

Location: `PaymentController::create()`
Update array `$paymentMethods` dengan rekening/nomor aktual.

---

**Created:** <?php echo date('Y-m-d'); ?>
**Version:** 1.0
**Status:** Production Ready
