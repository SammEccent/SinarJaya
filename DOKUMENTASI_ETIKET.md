# Dokumentasi E-Ticket PDF System

## Fitur E-Ticket

E-ticket ini mencakup semua informasi penting dalam **1 lembar PDF**:

### ✅ Informasi yang Ditampilkan:

#### 🧍 Data Penumpang

- Nama lengkap setiap penumpang
- Nomor kursi yang dipesan
- Tipe kursi (Reclining Seat Premium / Sleeper Seat)
- NIK / Nomor Identitas
- Nomor telepon

#### 🚌 Informasi Perjalanan

- Nama operator: **Sinar Jaya Transport**
- Rute lengkap: Kota Asal → Kota Tujuan
- Kelas bus
- Tanggal & jam keberangkatan
- Perkiraan jam tiba
- Lokasi naik (Boarding Point)
- Lokasi turun (Drop Point)

#### 💳 Informasi Pembayaran

- Status pembayaran (Lunas/Belum Lunas)
- Metode pembayaran
- Tanggal pembayaran
- Total harga tiket

#### 🏷 Identitas Tiket

- Kode booking unik
- QR Code untuk verifikasi
- Tanggal cetak

## Cara Menggunakan

### 1. **Download E-Ticket**

Setelah booking terkonfirmasi (status: **confirmed**):

**Dari Halaman Daftar Booking:**

- Klik tombol **"Download E-Ticket"** pada booking yang sudah dikonfirmasi

**Dari Halaman Detail Booking:**

- Klik tombol **"Download E-Ticket PDF"**

### 2. **URL untuk Download**

```
{BASEURL}/booking/downloadTicket/{booking_id}
```

Contoh:

```
http://localhost/SinarJaya/booking/downloadTicket/5
```

### 3. **Keamanan**

- Hanya user yang memiliki booking dapat download e-ticket nya
- E-ticket hanya tersedia untuk booking dengan status **confirmed**
- System otomatis validasi kepemilikan booking

## File Structure

```
app/
├── Helpers/
│   └── TicketHelper.php          # Class untuk generate PDF
├── Controllers/
│   └── BookingController.php     # Method downloadTicket()
└── Views/
    └── user/
        ├── bookings.php          # Tombol download di list
        └── booking-detail.php    # Tombol download di detail

public/
└── uploads/
    └── tickets/                  # Folder penyimpanan PDF
        └── TICKET_*.pdf

vendor/
└── tecnickcom/tcpdf/            # Library PDF
```

## Technical Details

### Library yang Digunakan

- **TCPDF 6.10.1** - Library untuk generate PDF

### Format Nama File

```
TICKET_{BOOKING_CODE}_{TIMESTAMP}.pdf
```

Contoh:

```
TICKET_SJ-202512317717_20251231235959.pdf
```

### QR Code Content

QR Code berisi informasi:

```
BOOKING:{booking_code}
TOTAL:{total_passengers}
ROUTE:{origin_city}-{destination_city}
DATE:{departure_date}
```

### PDF Specifications

- **Size:** A4
- **Orientation:** Portrait
- **Margins:** 15mm (all sides)
- **Font:** Helvetica
- **Auto Page Break:** Yes

## Desain E-Ticket

E-ticket menggunakan desain profesional dengan:

- ✅ Border berwarna (brand color: #667eea)
- ✅ Section yang jelas dan terstruktur
- ✅ QR Code di pojok kanan atas
- ✅ Kode booking highlighted dengan background kuning
- ✅ Route display yang prominent
- ✅ Box untuk setiap penumpang
- ✅ Color-coded untuk status pembayaran
- ✅ Footer dengan informasi penting dan contact

## Testing

Untuk testing e-ticket generation:

1. Buat booking baru
2. Proses pembayaran hingga confirmed
3. Akses URL download atau klik tombol
4. PDF akan otomatis terdownload

## Notes

- PDF disimpan di `public/uploads/tickets/`
- File tidak otomatis dihapus setelah download (opsional bisa diaktifkan)
- Pastikan folder `public/uploads/tickets/` writable (chmod 755)
- QR Code dapat di-scan untuk verifikasi

## Support

Untuk pertanyaan atau issue, hubungi developer atau buka issue di repository.
