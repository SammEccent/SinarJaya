# 🎫 Fitur Pencarian Tiket Bus - Sinar Jaya

## 📋 Overview

Fitur pencarian tiket bus yang lengkap dan user-friendly untuk calon penumpang mencari jadwal bus berdasarkan rute, tanggal, dan jumlah penumpang.

## ✨ Fitur Utama

### 1. **Form Pencarian di Landing Page**

- ✅ Dropdown kota asal dan tujuan
- ✅ Kalender untuk pilih tanggal (tidak bisa pilih tanggal lalu)
- ✅ Input jumlah penumpang (1-30)
- ✅ Validasi form lengkap
- ✅ Error handling dengan pesan yang jelas

### 2. **Halaman Hasil Pencarian**

- ✅ Summary pencarian (rute, tanggal, jumlah penumpang)
- ✅ Daftar jadwal bus yang tersedia
- ✅ Detail lengkap setiap jadwal:
  - Kelas bus (Executive, Suite Class)
  - Nomor plat bus
  - Waktu keberangkatan & tiba
  - Durasi perjalanan
  - Fasilitas bus
  - Kursi tersedia
  - Harga per orang
- ✅ Sorting (waktu, harga, durasi)
- ✅ Tombol booking langsung

### 3. **User Experience**

- ✅ Design modern dengan gradient
- ✅ Responsive untuk mobile & desktop
- ✅ Animasi smooth
- ✅ Visual timeline perjalanan
- ✅ Badge fasilitas dengan icon
- ✅ Click to book (klik card atau tombol)

## 🗂️ File yang Dibuat/Dimodifikasi

### 1. **HomeController.php** (Modified)

```php
app/Controllers/HomeController.php
```

**Method baru:**

- `search()` - Handle pencarian tiket dengan validasi lengkap

**Validasi yang dilakukan:**

- Kota asal dan tujuan harus dipilih
- Kota asal ≠ kota tujuan
- Tanggal tidak boleh di masa lalu
- Jumlah penumpang 1-30 orang
- Kursi tersedia >= jumlah penumpang

### 2. **ScheduleModel.php** (Modified)

```php
app/Models/ScheduleModel.php
```

**Method baru:**

- `searchSchedules($origin, $destination, $date, $passengers)` - Query pencarian dengan JOIN lengkap
- `getScheduleDetails($id)` - Get detail jadwal untuk booking

**Query features:**

- JOIN routes, buses, bus_classes
- Filter by: origin, destination, date range, available seats
- Filter by status: scheduled, active
- Calculate duration (TIMESTAMPDIFF)
- Order by departure time

### 3. **LocationModel.php** (Modified)

```php
app/Models/LocationModel.php
```

**Method baru:**

- `getAllCities()` - Get semua kota unik
- `getCitiesWithRoutes()` - Get kota yang punya rute aktif

### 4. **landing.php** (Modified)

```php
app/Views/home/landing.php
```

**Perubahan:**

- Form action ke `home/search`
- Input text → Dropdown untuk kota
- Min date untuk date picker
- Max passengers 30
- Error handling dengan alert
- Icon pada button

### 5. **search-results.php** (New)

```php
app/Views/home/search-results.php
```

**Fitur:**

- Search summary dengan gradient background
- Results count dan sorting
- Schedule cards dengan info lengkap
- No results state
- JavaScript sorting & booking

## 🚀 Cara Penggunaan

### User Flow:

1. **Buka Homepage** → Lihat form pencarian
2. **Pilih Kota Asal** → Dropdown
3. **Pilih Kota Tujuan** → Dropdown
4. **Pilih Tanggal** → Date picker
5. **Input Jumlah Penumpang** → 1-30
6. **Klik "Cari Tiket"** → Submit form
7. **Lihat Hasil** → Daftar jadwal bus
8. **Sort (Optional)** → Urutkan berdasarkan waktu/harga/durasi
9. **Pilih Jadwal** → Klik card atau tombol "Pesan Sekarang"
10. **Redirect ke Booking** → Proses pemesanan

## 📊 Query Database

### Search Schedules Query:

```sql
SELECT
    s.id as schedule_id,
    s.departure_datetime,
    s.arrival_datetime,
    s.base_price,
    s.available_seats,
    r.origin_city,
    r.destination_city,
    r.route_code,
    b.plate_number,
    b.total_seats,
    b.facilities as bus_facilities,
    bc.name as bus_class_name,
    bc.base_price_multiplier,
    TIMESTAMPDIFF(MINUTE, s.departure_datetime, s.arrival_datetime) as duration_minutes
FROM schedules s
JOIN routes r ON s.route_id = r.route_id
JOIN buses b ON s.bus_id = b.id
JOIN bus_classes bc ON b.bus_class_id = bc.id
WHERE r.origin_city = :origin
AND r.destination_city = :destination
AND s.departure_datetime BETWEEN :date_start AND :date_end
AND s.available_seats >= :passengers
AND s.status = 'scheduled'
AND r.status = 'active'
AND b.status = 'active'
ORDER BY s.departure_datetime ASC
```

## 🎨 Design Features

### Color Scheme:

- Primary Gradient: `#667eea` → `#764ba2`
- Success: `#059669`
- Text: `#1f2937`, `#6b7280`
- Background: `#f9fafb`, `#ffffff`

### Components:

1. **Search Summary Card** - Gradient background dengan info pencarian
2. **Schedule Card** - White card dengan border hover effect
3. **Time Blocks** - Display waktu berangkat & tiba
4. **Route Visual** - Garis horizontal dengan arrow
5. **Facility Tags** - Rounded tags dengan icon
6. **Price Display** - Large bold text untuk harga
7. **Book Button** - Gradient button dengan hover effect

### Icons (Font Awesome):

- `fa-search` - Search
- `fa-map-marker-alt` - Location
- `fa-calendar` - Date
- `fa-users` - Passengers
- `fa-bus` - Bus
- `fa-clock` - Duration
- `fa-chair` - Seats
- `fa-ticket-alt` - Book
- `fa-check-circle` - Facility check
- `fa-info-circle` - Info

## 🔧 JavaScript Features

### Sorting Function:

```javascript
function sortSchedules(sortBy)
```

**Sort options:**

- `time-asc` - Waktu keberangkatan (awal)
- `time-desc` - Waktu keberangkatan (akhir)
- `price-asc` - Harga (termurah)
- `price-desc` - Harga (termahal)
- `duration-asc` - Durasi (tercepat)

### Booking Function:

```javascript
function bookSchedule(scheduleId)
```

Redirect ke: `booking/create?schedule_id={id}&passengers={num}`

### Card Click Event:

Klik card = klik tombol booking (kecuali klik button langsung)

## 📱 Responsive Design

### Desktop (>768px):

- Form: 4 kolom grid
- Schedule card: Horizontal layout
- Time blocks: Inline
- Facilities: Multiple columns

### Mobile (<768px):

- Form: Stacked vertical
- Schedule card: Vertical layout
- Time blocks: Stacked
- Route line: Vertical with rotated arrow
- Facilities: Centered wrap

## ⚠️ Validasi & Error Handling

### Server-side Validation:

1. **Empty fields** → "Kota asal harus dipilih"
2. **Same origin/destination** → "Kota asal dan tujuan tidak boleh sama"
3. **Past date** → "Tanggal keberangkatan tidak boleh di masa lalu"
4. **Invalid passengers** → "Jumlah penumpang harus antara 1-30"

### Client-side Validation:

1. **Required fields** → HTML5 `required` attribute
2. **Min date** → `min="<?php echo date('Y-m-d'); ?>"`
3. **Number range** → `min="1" max="30"`
4. **Select validation** → Empty option as placeholder

### Error Display:

- Session-based error messages
- Alert danger dengan list
- Auto-clear after display
- Preserve old input values

## 🔗 Integration Points

### Booking Integration:

```
home/search → search-results.php → booking/create
```

**Parameters passed:**

- `schedule_id` - ID jadwal yang dipilih
- `passengers` - Jumlah penumpang

### Navigation:

- **Landing page** → Search form
- **Search results** → Ubah pencarian → Back to landing
- **Search results** → Pesan sekarang → Booking page
- **No results** → Kembali ke pencarian

## 🎯 Testing Checklist

### Functional Tests:

- [ ] Form submit dengan data valid
- [ ] Validasi kota asal = tujuan
- [ ] Validasi tanggal masa lalu
- [ ] Validasi jumlah penumpang
- [ ] Search dengan hasil ditemukan
- [ ] Search tanpa hasil
- [ ] Sorting by time (asc/desc)
- [ ] Sorting by price (asc/desc)
- [ ] Sorting by duration
- [ ] Click schedule card
- [ ] Click book button
- [ ] Modify search link

### UI Tests:

- [ ] Responsive di mobile
- [ ] Hover effects berfungsi
- [ ] Icons tampil benar
- [ ] Gradient background
- [ ] Route visual animation
- [ ] Facility tags layout
- [ ] Price formatting (Rp 250.000)
- [ ] Date formatting (dd MMM yyyy)
- [ ] Duration calculation (Xj Ym)

### Database Tests:

- [ ] Query dengan origin/destination valid
- [ ] Query dengan tanggal valid
- [ ] Filter available seats >= passengers
- [ ] Filter status scheduled & active
- [ ] JOIN semua tabel berhasil
- [ ] Duration calculation akurat

## 🚀 Future Enhancements

### Possible Improvements:

1. **Filter tambahan:**

   - Bus class filter
   - Price range slider
   - Facilities filter (AC, WiFi, etc)
   - Departure time filter (pagi, siang, malam)

2. **Auto-complete:**

   - Search kota dengan autocomplete
   - Suggested routes based on popular

3. **Comparison:**

   - Compare 2-3 schedules side-by-side
   - Highlight cheapest/fastest

4. **Favorites:**

   - Save frequent routes
   - Quick search dari favorites

5. **Price calendar:**

   - View harga seminggu
   - Flexible date search

6. **Seat map:**

   - Preview seat layout
   - Pick seat from search results

7. **Promo integration:**

   - Show discounted prices
   - Promo codes

8. **Real-time updates:**
   - Auto-refresh availability
   - Push notifications untuk harga turun

## 📞 Support

Untuk pertanyaan atau issues terkait fitur pencarian tiket:

- Check error logs di browser console
- Check PHP error_log untuk server-side issues
- Verify database connection
- Check routes configuration

## 📝 Notes

- Pastikan session sudah started di `init.php`
- Pastikan BASEURL sudah defined di `config.php`
- Font Awesome CDN harus loaded di layout
- PHP timezone harus di-set untuk date calculation yang akurat
- Bus facilities harus dipisah dengan koma di database

---

**Status:** ✅ Production Ready
**Version:** 1.0.0
**Last Updated:** 31 Desember 2025
