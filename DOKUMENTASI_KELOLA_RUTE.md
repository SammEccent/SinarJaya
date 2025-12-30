# Dokumentasi Fitur Kelola Rute - Sinar Jaya Bus Booking

## 📋 Ringkasan

Fitur Kelola Rute memungkinkan admin untuk mengelola rute perjalanan bus, termasuk:

- Membuat, mengedit, dan menghapus rute
- Mengelola lokasi penjemputan dan pemberhentian
- Mengatur urutan lokasi dalam sebuah rute
- Menentukan fungsi lokasi (penjemputan, pemberhentian, atau keduanya)

---

## 📁 File yang Dibuat

### 1. **Model**

#### `app/Models/LocationModel.php`

Model untuk mengelola tabel `location` dengan methods:

- `getAll()` - Ambil semua lokasi
- `findById($id)` - Cari lokasi berdasarkan ID
- `getByCity($city)` - Cari lokasi berdasarkan kota
- `getByType($type)` - Cari lokasi berdasarkan tipe
- `create($data)` - Buat lokasi baru
- `update($id, $data)` - Update lokasi
- `delete($id)` - Hapus lokasi

#### `app/Models/RouteModel.php`

Model untuk mengelola tabel `routes` dan `route_location` dengan methods:

- `getAll()` - Ambil semua rute
- `findById($id)` - Cari rute berdasarkan ID
- `getRouteLocations($route_id)` - Ambil semua lokasi dalam rute
- `create($data)` - Buat rute baru
- `update($id, $data)` - Update rute
- `delete($id)` - Hapus rute dan lokasi terkait
- `addRouteLocation($route_id, $location_id, $fungsi, $sequence)` - Tambah lokasi ke rute
- `removeRouteLocation($route_location_id)` - Hapus lokasi dari rute
- `updateRouteLocation($route_location_id, $fungsi, $sequence)` - Update lokasi dalam rute

---

### 2. **Controller**

#### `app/Controllers/AdminController.php`

Methods baru untuk route management:

| Method                       | URL                                | Deskripsi                          |
| ---------------------------- | ---------------------------------- | ---------------------------------- |
| `routes()`                   | `/admin/routes`                    | Tampilkan daftar semua rute        |
| `routesCreate()`             | `/admin/routes/create`             | Form buat rute baru / process POST |
| `routesEdit($id)`            | `/admin/routes/edit/{id}`          | Form edit rute / process POST      |
| `routesDelete($id)`          | `/admin/routes/delete/{id}`        | Hapus rute                         |
| `routesLocations($route_id)` | `/admin/routes/{id}/locations`     | Kelola lokasi dalam rute           |
| `routeLocationDelete($id)`   | `/admin/routelocation/delete/{id}` | Hapus lokasi dari rute             |

---

### 3. **Views**

#### `app/Views/admin/routes/index.php`

- Menampilkan daftar semua rute dalam tabel
- Tombol aksi: Edit, Kelola Lokasi, Hapus
- Tombol tambah rute baru
- Empty state jika tidak ada rute

#### `app/Views/admin/routes/form.php`

- Form untuk membuat rute baru atau edit rute
- Fields:
  - Kota Asal (required)
  - Kota Tujuan (required)
  - Kode Rute (required)
  - Status (active/inactive)
- Validasi error messages

#### `app/Views/admin/routes/locations.php`

- Tampilkan semua lokasi dalam rute
- Tabel menampilkan: No, Lokasi, Kota, Tipe, Fungsi, Urutan, Aksi
- Form untuk tambah lokasi baru dengan fields:
  - Pilih Lokasi (dropdown)
  - Fungsi (BOTH/BOARDING/DROP)
  - Urutan (sequence)
- Hapus lokasi dari rute

---

## 🗄️ Schema Database

### Tabel Routes

```sql
CREATE TABLE `routes` (
  `route_id` int PRIMARY KEY AUTO_INCREMENT,
  `origin_city` varchar(100) NOT NULL,
  `destination_city` varchar(100) NOT NULL,
  `route_code` varchar(20) NOT NULL UNIQUE,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP
)
```

### Tabel Location

```sql
CREATE TABLE `location` (
  `location_id` int PRIMARY KEY AUTO_INCREMENT,
  `location_name` varchar(150) NOT NULL,
  `city` varchar(100) NOT NULL,
  `type` enum('POOL','TERMINAL','AGEN','REST_AREA') NOT NULL,
  `address` text,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP
)
```

### Tabel Route_Location

```sql
CREATE TABLE `route_location` (
  `route_location_id` int PRIMARY KEY AUTO_INCREMENT,
  `route_id` int NOT NULL,
  `location_id` int NOT NULL,
  `fungsi` enum('BOARDING','DROP','BOTH') NOT NULL,
  `sequence` int NOT NULL,
  FOREIGN KEY (`route_id`) REFERENCES `routes`(`route_id`),
  FOREIGN KEY (`location_id`) REFERENCES `location`(`location_id`)
)
```

---

## 🚀 Cara Menggunakan

### 1. Akses Kelola Rute

- Buka Admin Panel → Klik "Kelola Rute" di menu sidebar
- URL: `/admin/routes`

### 2. Membuat Rute Baru

1. Klik tombol "+ Tambah Rute"
2. Isi form:
   - Kota Asal (misal: Yogyakarta)
   - Kota Tujuan (misal: Tangerang)
   - Kode Rute (misal: YK-TGR)
   - Status (pilih Active atau Inactive)
3. Klik "Buat Rute"

### 3. Mengelola Lokasi dalam Rute

1. Di daftar rute, klik tombol "Lokasi" pada rute yang ingin dikelola
2. Tambah lokasi:
   - Pilih lokasi dari dropdown
   - Pilih fungsi (BOTH = penjemputan & pemberhentian, BOARDING = hanya penjemputan, DROP = hanya pemberhentian)
   - Atur urutan perjalanan
   - Klik "Tambah"
3. Hapus lokasi dengan klik tombol "Hapus"

### 4. Edit atau Hapus Rute

- Klik tombol "Edit" untuk mengubah informasi rute
- Klik tombol "Hapus" untuk menghapus rute (akan menghapus semua lokasi terkait)

---

## 🎨 UI/UX Features

1. **Status Badge** - Warna berbeda untuk status aktif/tidak aktif
2. **Type Badge** - Warna berbeda untuk tipe lokasi (Pool, Terminal, Agen, Rest Area)
3. **Function Badge** - Warna berbeda untuk fungsi lokasi (Boarding, Drop, Both)
4. **Empty State** - Tampilan ramah ketika tidak ada data
5. **Responsive Design** - Grid form responsive untuk mobile
6. **Confirmation Dialog** - Konfirmasi sebelum menghapus data
7. **Error Validation** - Pesan error yang jelas untuk form validation

---

## 🔒 Keamanan

- ✅ Check session role (hanya admin yang bisa akses)
- ✅ Input sanitization dengan `htmlspecialchars()`
- ✅ Prepared statements untuk mencegah SQL injection
- ✅ CSRF protection ready (integrated dengan framework)

---

## 📊 Integration dengan Module Lain

Routes terhubung dengan:

- **Schedules** - Setiap jadwal bus menggunakan satu rute
- **Locations** - Rute terdiri dari kumpulan lokasi dengan urutan tertentu

---

## 💡 Tips Penggunaan

1. **Tentukan urutan lokasi dengan benar** - Urutan menentukan rute perjalanan bus
2. **Gunakan kode rute yang deskriptif** - Misal: YK-TGR untuk Yogyakarta-Tangerang
3. **Tandai fungsi lokasi dengan akurat** - BOTH jika bisa naik dan turun, BOARDING hanya naik, DROP hanya turun
4. **Kelola lokasi sebelum membuat jadwal** - Rute harus lengkap sebelum membuat jadwal bus

---

## 🆘 Troubleshooting

**Q: Tidak bisa menambah lokasi ke rute?**
A: Pastikan sudah ada lokasi yang dibuat terlebih dahulu di tabel location

**Q: Rute tidak muncul di dropdown saat membuat jadwal?**
A: Pastikan rute status = "active"

**Q: Tidak bisa menghapus rute?**
A: Cek apakah ada jadwal (schedule) yang menggunakan rute tersebut

---

Generated: 30 Desember 2025
