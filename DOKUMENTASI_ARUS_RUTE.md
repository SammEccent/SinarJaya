# Dokumentasi: Sistem Penjadwalan Bus dengan Arus Berangkat & Balik (V2 - Improved)

## 🎯 Perubahan dari Versi Sebelumnya

**Versi Lama**: `route_type` disimpan di tabel `routes`

- ❌ Setiap rute harus dibuat 2x (forward & return)
- ❌ Tidak fleksibel

**Versi Baru (V2)**: `route_type` disimpan di tabel `schedules`

- ✅ Rute hanya perlu dibuat 1x
- ✅ Jenis arus ditentukan per jadwal
- ✅ Validasi lebih akurat berdasarkan origin-destination

---

## Ringkasan

Sistem memvalidasi penjadwalan bus dengan aturan:

1. **Waktu**: Jadwal baru harus setelah waktu tiba jadwal yang sedang berjalan
2. **Jenis Arus**: Jadwal baru harus berlawanan (forward ↔ return)
3. **Konsistensi Rute**: Untuk arus balik, rute harus dari destination ke origin jadwal sebelumnya

---

## Instalasi

### 1. Jalankan Migrasi

```bash
cd c:\laragon\www\SinarJaya
php migrate_route_type_v2.php
```

Script ini akan:

- Menghapus kolom `route_type` dari tabel `routes` (jika ada)
- Menambahkan kolom `route_type` ke tabel `schedules`
- Set semua jadwal existing sebagai 'forward' (default)

**⚠️ Penting**: Setelah migrasi, cek jadwal yang seharusnya "Arus Balik" dan edit jenisnya di admin panel.

---

## Cara Kerja

### A. Status Jadwal Otomatis

```
scheduled → departed (otomatis saat waktu keberangkatan lewat)
```

### B. Validasi Penjadwalan (3 Cek)

#### ✅ Cek 1: Waktu Bus Tersedia

```
Jadwal Saat Ini (Departed):
- Bus: AB 1234 SJ
- Rute: Yogyakarta → Tangerang
- Tiba: 2026-01-05 14:00

Jadwal Baru:
✓ VALID jika berangkat >= 14:00
✗ TIDAK VALID jika berangkat < 14:00
```

#### ✅ Cek 2: Jenis Arus Berlawanan

```
Jadwal Saat Ini:
- Arus: Berangkat (forward)

Jadwal Baru:
✓ VALID jika arus: Balik (return)
✗ TIDAK VALID jika arus: Berangkat (forward)
```

#### ✅ Cek 3: Konsistensi Rute (Untuk Arus Balik)

```
Jadwal Saat Ini:
- Rute: Yogyakarta → Tangerang
- Destination: Tangerang

Jadwal Baru (Arus Balik):
✓ VALID jika rute berangkat dari: Tangerang
✗ TIDAK VALID jika rute berangkat dari: Jakarta (salah tempat!)
```

---

## Contoh Skenario

### ✅ Skenario 1: Penjadwalan Berhasil

```
Jadwal Existing:
┌─────────────────────────────────┐
│ Bus: AB 1234 SJ                 │
│ Rute: Yogyakarta → Tangerang    │
│ Arus: Berangkat (forward)       │
│ Berangkat: 05/01/2026 08:00     │
│ Tiba: 05/01/2026 14:00          │
│ Status: departed                │
└─────────────────────────────────┘

Jadwal Baru (VALID):
┌─────────────────────────────────┐
│ Bus: AB 1234 SJ                 │
│ Rute: Tangerang → Yogyakarta    │ ✓ (balik ke origin)
│ Arus: Balik (return)            │ ✓ (berlawanan)
│ Berangkat: 05/01/2026 15:00     │ ✓ (setelah 14:00)
│ Status: scheduled               │
└─────────────────────────────────┘

✅ Penjadwalan BERHASIL!
```

### ❌ Skenario 2: Error - Waktu Terlalu Cepat

```
Jadwal Existing:
│ Tiba: 05/01/2026 14:00

Jadwal Baru:
│ Berangkat: 05/01/2026 13:00 ✗

❌ Error: "Bus masih dalam perjalanan. Keberangkatan jadwal baru
harus setelah jam tiba 05/01/2026 14:00"
```

### ❌ Skenario 3: Error - Arus Salah

```
Jadwal Existing:
│ Arus: Berangkat (forward)

Jadwal Baru:
│ Arus: Berangkat (forward) ✗

❌ Error: "Bus sedang beroperasi pada arus berangkat. Jadwal
selanjutnya harus menggunakan Arus Balik"
```

### ❌ Skenario 4: Error - Rute Tidak Konsisten

```
Jadwal Existing:
│ Rute: Yogyakarta → Tangerang
│ Destination: Tangerang

Jadwal Baru (Arus Balik):
│ Rute: Jakarta → Bandung ✗
│ Origin: Jakarta (harusnya Tangerang!)

❌ Error: "Untuk arus balik, rute harus berangkat dari Tangerang
(tujuan jadwal sebelumnya). Rute yang dipilih berangkat dari Jakarta"
```

---

## Perubahan File

### Database

- **migrations/004_move_route_type_to_schedules.sql**: Migration SQL
- **migrate_route_type_v2.php**: Script migrasi
- **Tabel schedules**: Ditambah kolom `route_type`
- **Tabel routes**: Dihapus kolom `route_type`

### Models

- **app/Models/ScheduleModel.php**:

  - `create()` & `update()`: Support `route_type`
  - `validateBusSchedule()`: Validasi 3 level (waktu, arus, konsistensi rute)
  - `getAll()` & `findById()`: Tidak ambil `route_type` dari routes

- **app/Models/RouteModel.php**:
  - `create()` & `update()`: Hapus field `route_type`

### Controllers

- **app/Controllers/AdminController.php**:
  - `schedulesCreate()`: Handle `route_type` dari POST, call validasi
  - `schedulesEdit()`: Handle `route_type` dari POST, call validasi dengan exclude

### Views

- **app/Views/admin/schedules/form.php**: Dropdown "Jenis Arus"
- **app/Views/admin/schedules/index.php**: Kolom "Jenis Arus"
- **app/Views/admin/routes/form.php**: Hapus field `route_type`
- **app/Views/admin/routes/index.php**: Hapus kolom "Jenis"

---

## Penggunaan

### 1. Buat Jadwal dengan Arus Berangkat

**Admin Panel → Kelola Jadwal → Tambah Jadwal**

```
Bus: AB 1234 SJ
Rute: Yogyakarta → Tangerang
Jenis Arus: Arus Berangkat ←
Berangkat: 05/01/2026 08:00
Tiba: 05/01/2026 14:00
```

### 2. Set Status Departed (Manual atau Otomatis)

Status akan otomatis berubah saat waktu keberangkatan lewat dan admin buka halaman jadwal.

### 3. Buat Jadwal Arus Balik

**Kelola Jadwal → Tambah Jadwal**

```
Bus: AB 1234 SJ (sama)
Rute: Tangerang → Yogyakarta (ke arah balik)
Jenis Arus: Arus Balik ←
Berangkat: 05/01/2026 15:00 (setelah tiba di Tangerang)
Tiba: 05/01/2026 21:00
```

✅ Sistem akan memvalidasi dan menerima jika semua aturan terpenuhi!

---

## Testing

### Test 1: Validasi Waktu

```bash
1. Buat jadwal departed: Bus A, tiba 14:00
2. Coba jadwal baru: Bus A, arus balik, berangkat 13:00
   → ❌ Error waktu
3. Coba jadwal baru: Bus A, arus balik, berangkat 15:00
   → ✅ Lolos cek waktu
```

### Test 2: Validasi Arus

```bash
1. Buat jadwal departed: Bus A, arus berangkat
2. Coba jadwal baru: Bus A, arus berangkat
   → ❌ Error arus harus berlawanan
3. Coba jadwal baru: Bus A, arus balik
   → ✅ Lolos cek arus
```

### Test 3: Validasi Konsistensi Rute

```bash
1. Buat jadwal departed: Bus A, Yogya → Tangerang
2. Coba jadwal baru: Bus A, arus balik, rute Jakarta → Bandung
   → ❌ Error rute harus dari Tangerang
3. Coba jadwal baru: Bus A, arus balik, rute Tangerang → Yogya
   → ✅ Lolos semua validasi!
```

---

## Keuntungan Sistem Baru

| Aspek             | Versi Lama                           | Versi Baru                                       |
| ----------------- | ------------------------------------ | ------------------------------------------------ |
| **Data Rute**     | Harus buat 2 rute (forward & return) | Cukup 1 rute                                     |
| **Fleksibilitas** | Rute fixed sebagai forward/return    | Rute netral, arus di jadwal                      |
| **Validasi**      | Cek route_type di routes             | Cek route_type di schedules + origin-destination |
| **Maintenance**   | Harus update 2 rute                  | Update 1 rute saja                               |
| **Konsistensi**   | Tidak cek origin-destination         | Cek apakah bus kembali ke tempat yang benar      |

---

## Troubleshooting

### Error: "Unknown column 'route_type' in 'field list'" (di routes)

**Solusi**: Migrasi v2 sudah menghapus kolom ini dari routes ✓

### Error: "Unknown column 'schedules.route_type'"

**Penyebab**: Migrasi belum dijalankan  
**Solusi**: `php migrate_route_type_v2.php`

### Semua jadwal existing jadi "Arus Berangkat"

**Normal**: Default setelah migrasi  
**Solusi**: Edit jadwal yang seharusnya "Arus Balik" di admin panel

### Validasi tidak berjalan

**Solusi**: Restart web server atau clear opcache

---

## Rollback (Jika Diperlukan)

```sql
-- Hapus route_type dari schedules
ALTER TABLE schedules DROP COLUMN route_type;

-- Kembalikan route_type ke routes
ALTER TABLE routes
ADD COLUMN route_type ENUM('forward', 'return') NOT NULL DEFAULT 'forward'
AFTER destination_city;
```

---

## Kesimpulan

✅ **Sistem V2 Lebih Baik Karena**:

- Rute tidak perlu diduplikasi
- Validasi lebih akurat dengan 3 level pengecekan
- Maintenance lebih mudah
- Logika bisnis lebih natural (arus ditentukan saat jadwal dibuat)

Untuk pertanyaan, hubungi tim development.
