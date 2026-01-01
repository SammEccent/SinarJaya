-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 01 Jan 2026 pada 13.58
-- Versi server: 8.0.30
-- Versi PHP: 8.4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Basis data: `sinarjaya_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `action` varchar(100) NOT NULL,
  `table_name` varchar(50) DEFAULT NULL,
  `record_id` int DEFAULT NULL,
  `old_values` json DEFAULT NULL,
  `new_values` json DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `bookings`
--

CREATE TABLE `bookings` (
  `id` int NOT NULL,
  `booking_code` varchar(20) NOT NULL,
  `user_id` int NOT NULL,
  `schedule_id` int NOT NULL,
  `pickup_location_id` int DEFAULT NULL,
  `drop_location_id` int DEFAULT NULL,
  `total_passengers` int NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `booking_status` enum('pending','confirmed','cancelled','expired') DEFAULT 'pending',
  `payment_expiry` datetime DEFAULT NULL,
  `notes` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `bookings`
--

INSERT INTO `bookings` (`id`, `booking_code`, `user_id`, `schedule_id`, `pickup_location_id`, `drop_location_id`, `total_passengers`, `total_amount`, `booking_status`, `payment_expiry`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'SJ-20260105001', 2, 1, NULL, NULL, 1, 250000.00, 'confirmed', '2026-01-05 15:00:00', '', '2025-12-29 11:36:05', '2025-12-30 07:59:21'),
(14, 'SJ-202512317717', 8, 1, 1, 8, 1, 300000.00, 'expired', '2025-12-31 21:19:23', '', '2025-12-31 13:59:23', '2025-12-31 14:24:52'),
(15, 'SJ-202512312293', 8, 1, 1, 8, 1, 300000.00, 'confirmed', '2025-12-31 21:52:36', '', '2025-12-31 14:32:36', '2025-12-31 14:35:16'),
(16, 'SJ-202512318781', 8, 3, 1, 7, 1, 560000.00, 'confirmed', '2025-12-31 22:23:16', '', '2025-12-31 15:03:16', '2025-12-31 15:08:32');

-- --------------------------------------------------------

--
-- Struktur dari tabel `buses`
--

CREATE TABLE `buses` (
  `id` int NOT NULL,
  `plate_number` varchar(20) NOT NULL,
  `bus_class_id` int NOT NULL,
  `operator_id` int DEFAULT NULL,
  `total_seats` int NOT NULL,
  `seat_layout` varchar(10) DEFAULT '2-2',
  `facilities` text,
  `status` enum('active','maintenance','inactive') DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `buses`
--

INSERT INTO `buses` (`id`, `plate_number`, `bus_class_id`, `operator_id`, `total_seats`, `seat_layout`, `facilities`, `status`, `created_at`) VALUES
(1, 'AB 1234 SJA', 1, 1, 30, '2-2', 'AC, Leg Rest, Toilet, Snack', 'active', '2025-12-29 11:35:31'),
(2, 'AB 5678 SJI', 2, 1, 13, '1-1', 'Full Flat Bed, AVOD, Meal, Wi-Fi', 'active', '2025-12-29 11:35:31'),
(3, 'AB 9101 JAS', 2, 1, 30, '1-1', 'Full Flat Bed, AVOD, Meal, Wi-Fi', 'active', '2025-12-29 11:35:31'),
(4, 'AB 7001 AAV', 1, 1, 30, '2-2', 'AC, Toilet, Leg Rest, Snack', 'active', '2025-12-30 11:59:34'),
(5, 'AB 7002 ABY', 1, 1, 30, '2-2', 'AC, Toilet, Leg Rest, Snack', 'active', '2025-12-30 11:59:34'),
(6, 'AB 7003 ACG', 1, 1, 30, '2-2', 'AC, Toilet, Leg Rest, Snack', 'active', '2025-12-30 11:59:34'),
(7, 'AB 7004 ADK', 1, 1, 30, '2-2', 'AC, Toilet, Leg Rest, Snack', 'active', '2025-12-30 11:59:34'),
(8, 'AB 7005 AEW', 1, 1, 30, '2-2', 'AC, Toilet, Leg Rest, Snack', 'active', '2025-12-30 11:59:34'),
(9, 'AB 7006 AFA', 1, 1, 30, '2-2', 'AC, Toilet, Leg Rest, Snack', 'active', '2025-12-30 11:59:34'),
(10, 'AB 7007 AGJ', 1, 1, 30, '2-2', 'AC, Toilet, Leg Rest, Snack', 'active', '2025-12-30 11:59:34'),
(11, 'AB 7008 AHA', 1, 1, 30, '2-2', 'AC, Toilet, Leg Rest, Snack', 'active', '2025-12-30 11:59:34'),
(12, 'AB 7009 AIZ', 1, 1, 30, '2-2', 'AC, Toilet, Leg Rest, Snack', 'active', '2025-12-30 11:59:34'),
(13, 'AB 7010 AJP', 1, 1, 30, '2-2', 'AC, Toilet, Leg Rest, Snack', 'active', '2025-12-30 11:59:34'),
(14, 'AB 7011 AKE', 1, 1, 30, '2-2', 'AC, Toilet, Leg Rest, Snack', 'active', '2025-12-30 11:59:34'),
(15, 'AB 9001 ZAX', 2, 1, 11, '1-1', 'Full Flat Bed, AVOD, Meal, Wi-Fi', 'active', '2025-12-30 11:59:34'),
(16, 'AB 9002 ZBI', 2, 1, 13, '1-1', 'Full Flat Bed, AVOD, Meal, Wi-Fi', 'active', '2025-12-30 11:59:34'),
(17, 'AB 9003 ZCB', 2, 1, 13, '1-1', 'Full Flat Bed, AVOD, Meal, Wi-Fi', 'active', '2025-12-30 11:59:34'),
(18, 'AB 9004 ZDT', 2, 1, 13, '1-1', 'Full Flat Bed, AVOD, Meal, Wi-Fi', 'active', '2025-12-30 11:59:34'),
(19, 'AB 9005 ZEW', 2, 1, 13, '1-1', 'Full Flat Bed, AVOD, Meal, Wi-Fi', 'active', '2025-12-30 11:59:34'),
(20, 'AB 9006 ZFO', 2, 1, 13, '1-1', 'Full Flat Bed, AVOD, Meal, Wi-Fi', 'active', '2025-12-30 11:59:34'),
(21, 'AB 9007 ZGD', 2, 1, 13, '1-1', 'Full Flat Bed, AVOD, Meal, Wi-Fi', 'active', '2025-12-30 11:59:34'),
(22, 'AB 9008 ZHQ', 2, 1, 13, '1-1', 'Full Flat Bed, AVOD, Meal, Wi-Fi', 'active', '2025-12-30 11:59:34'),
(23, 'AB 9009 ZIL', 2, 1, 13, '1-1', 'Full Flat Bed, AVOD, Meal, Wi-Fi', 'active', '2025-12-30 11:59:34'),
(24, 'AB 9010 ZJJ', 2, 1, 13, '1-1', 'Full Flat Bed, AVOD, Meal, Wi-Fi', 'active', '2025-12-30 11:59:34');

-- --------------------------------------------------------

--
-- Struktur dari tabel `bus_classes`
--

CREATE TABLE `bus_classes` (
  `id` int NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text,
  `facilities` text,
  `base_price_multiplier` decimal(3,2) DEFAULT '1.00',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `bus_classes`
--

INSERT INTO `bus_classes` (`id`, `name`, `description`, `facilities`, `base_price_multiplier`, `created_at`) VALUES
(1, 'Executive', 'Kursi lebar dengan leg rest dan jumlah kursi lebih sedikit per baris', 'AC, Leg Rest, Toilet, Snack', 2.00, '2025-12-29 11:34:42'),
(2, 'Suite Class', 'Kelas termewah, konfigurasi 1-1, kursi bisa direbahkan jadi tempat tidur', 'Full Flat Bed, AVOD, Meal, Wi-Fi', 3.50, '2025-12-29 11:34:42');

-- --------------------------------------------------------

--
-- Struktur dari tabel `location`
--

CREATE TABLE `location` (
  `location_id` int NOT NULL,
  `location_name` varchar(150) NOT NULL,
  `city` varchar(100) NOT NULL,
  `type` enum('POOL','TERMINAL','AGEN','REST_AREA') NOT NULL,
  `address` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `location`
--

INSERT INTO `location` (`location_id`, `location_name`, `city`, `type`, `address`, `created_at`) VALUES
(1, 'Pool PO Yogyakarta', 'Yogyakarta', 'POOL', NULL, '2025-12-30 07:33:26'),
(2, 'Terminal Giwangan', 'Yogyakarta', 'TERMINAL', NULL, '2025-12-30 07:33:26'),
(3, 'Terminal Jombor', 'Yogyakarta', 'TERMINAL', NULL, '2025-12-30 07:33:26'),
(4, 'Agen Jalan Magelang', 'Yogyakarta', 'AGEN', NULL, '2025-12-30 07:33:26'),
(5, 'Rest Area KM 57 Karawang', 'Karawang', 'REST_AREA', NULL, '2025-12-30 07:33:26'),
(6, 'Terminal Kalideres', 'Jakarta Barat', 'TERMINAL', NULL, '2025-12-30 07:33:26'),
(7, 'BSD / Alam Sutera', 'Tangerang Selatan', 'AGEN', NULL, '2025-12-30 07:33:26'),
(8, 'Pool PO Tangerang', 'Tangerang', 'POOL', NULL, '2025-12-30 07:33:26'),
(9, 'Rest Area KM 102 Tol Cipali', 'Subang', 'REST_AREA', NULL, '2025-12-30 13:10:46'),
(10, 'Terminal Leuwipanjang', 'Bandung', 'TERMINAL', NULL, '2025-12-30 13:10:46'),
(11, 'Agen Pasteur', 'Bandung', 'AGEN', NULL, '2025-12-30 13:10:46'),
(12, 'Pool PO Bandung', 'Bandung', 'POOL', NULL, '2025-12-30 13:10:46'),
(13, 'Agen Jalan Solo', 'Yogyakarta', 'AGEN', NULL, '2025-12-30 13:13:35'),
(14, 'Rest Area Tol Ngawi (KM 575)', 'Ngawi', 'REST_AREA', NULL, '2025-12-30 13:13:35'),
(15, 'Terminal Purabaya (Bungurasih)', 'Sidoarjo', 'TERMINAL', NULL, '2025-12-30 13:13:35'),
(16, 'Agen Waru / Rungkut', 'Surabaya', 'AGEN', NULL, '2025-12-30 13:13:35'),
(17, 'Pool PO Surabaya', 'Surabaya', 'POOL', NULL, '2025-12-30 13:13:35'),
(18, 'Pelabuhan Ketapang', 'Banyuwangi', 'TERMINAL', NULL, '2025-12-30 13:17:10'),
(19, 'Pelabuhan Gilimanuk', 'Jembrana (Bali)', 'TERMINAL', NULL, '2025-12-30 13:17:10'),
(20, 'Agen Mengwi', 'Badung', 'AGEN', NULL, '2025-12-30 13:17:10'),
(21, 'Pool PO Denpasar', 'Denpasar', 'POOL', NULL, '2025-12-30 13:17:10');

-- --------------------------------------------------------

--
-- Struktur dari tabel `passengers`
--

CREATE TABLE `passengers` (
  `id` int NOT NULL,
  `booking_id` int NOT NULL,
  `seat_id` int DEFAULT NULL,
  `full_name` varchar(100) NOT NULL,
  `id_card_type` enum('ktp','sim','passport') DEFAULT 'ktp',
  `id_card_number` varchar(50) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `passengers`
--

INSERT INTO `passengers` (`id`, `booking_id`, `seat_id`, `full_name`, `id_card_type`, `id_card_number`, `phone`, `created_at`) VALUES
(1, 1, 1, 'Budi Santoso', 'ktp', '3201234567890001', '085712345678', '2025-12-29 11:36:05'),
(14, 14, 2, 'Samirudin Annas Alfattah', 'ktp', '3205124501850002', '081227230956', '2025-12-31 13:59:23'),
(15, 15, 25, 'Samirudin Annas Alfattah', 'ktp', '3205124501850002', '081227230956', '2025-12-31 14:32:36'),
(16, 16, 5, 'Yoga', 'ktp', '3205124501450001', '081227230945', '2025-12-31 15:03:16');

-- --------------------------------------------------------

--
-- Struktur dari tabel `payments`
--

CREATE TABLE `payments` (
  `id` int NOT NULL,
  `booking_id` int NOT NULL,
  `payment_method` enum('bank_transfer','credit_card','e_wallet','qris') NOT NULL,
  `payment_code` varchar(50) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_status` enum('pending','paid','failed','refunded') DEFAULT 'pending',
  `payment_proof_image` varchar(255) DEFAULT NULL,
  `paid_at` datetime DEFAULT NULL,
  `payment_details` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `payments`
--

INSERT INTO `payments` (`id`, `booking_id`, `payment_method`, `payment_code`, `amount`, `payment_status`, `payment_proof_image`, `paid_at`, `payment_details`, `created_at`, `updated_at`) VALUES
(1, 1, 'qris', 'PAY-QRIS-9921', 250000.00, 'paid', NULL, '2025-12-30 14:30:00', NULL, '2025-12-29 11:36:05', '2025-12-30 15:17:33'),
(2, 15, 'e_wallet', 'PAY-EWL-49A13F09', 300000.00, 'paid', 'uploads/payments/payment_2_1767191679.png', '2025-12-31 21:35:16', '{\"created_by_user\": 8, \"selected_method\": \"e_wallet\"}', '2025-12-31 14:33:12', '2025-12-31 14:35:16'),
(3, 16, 'bank_transfer', 'PAY-TRF-E3AAC072', 560000.00, 'paid', 'uploads/payments/payment_3_1767193448.png', '2025-12-31 22:08:32', '{\"created_by_user\": 8, \"selected_method\": \"bank_transfer\"}', '2025-12-31 15:03:48', '2025-12-31 15:08:32');

-- --------------------------------------------------------

--
-- Struktur dari tabel `routes`
--

CREATE TABLE `routes` (
  `route_id` int NOT NULL,
  `origin_city` varchar(100) NOT NULL,
  `destination_city` varchar(100) NOT NULL,
  `route_code` varchar(20) NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `routes`
--

INSERT INTO `routes` (`route_id`, `origin_city`, `destination_city`, `route_code`, `status`, `created_at`) VALUES
(1, 'Yogyakarta', 'Tangerang', 'YK-TGR', 'active', '2025-12-29 11:34:42'),
(2, 'Tangerang', 'Yogyakarta', 'TGR-YK', 'active', '2025-12-29 11:34:42'),
(3, 'Yogyakarta', 'Bandung', 'YK-BDG', 'active', '2025-12-29 11:34:42'),
(4, 'Bandung', 'Yogyakarta', 'BDG-YK', 'active', '2025-12-30 05:58:13'),
(5, 'Yogyakarta', 'Surabaya', 'YK-SBY', 'active', '2025-12-30 05:58:48'),
(6, 'Surabaya', 'Yogyakarta', 'SBY-YK', 'active', '2025-12-30 05:59:05'),
(7, 'Yogyakarta', 'Denpasar', 'YK-DPS', 'active', '2025-12-30 06:00:03'),
(8, 'Denpasar', 'Yogyakarta', 'DPS-YK', 'active', '2025-12-30 06:00:19');

-- --------------------------------------------------------

--
-- Struktur dari tabel `route_location`
--

CREATE TABLE `route_location` (
  `route_location_id` int NOT NULL,
  `route_id` int NOT NULL,
  `location_id` int NOT NULL,
  `fungsi` enum('BOARDING','DROP','BOTH') NOT NULL,
  `sequence` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `route_location`
--

INSERT INTO `route_location` (`route_location_id`, `route_id`, `location_id`, `fungsi`, `sequence`) VALUES
(1, 1, 1, 'BOARDING', 1),
(2, 1, 2, 'BOARDING', 2),
(3, 1, 3, 'BOARDING', 3),
(4, 1, 4, 'BOARDING', 4),
(5, 1, 5, 'BOTH', 5),
(6, 1, 6, 'DROP', 6),
(7, 1, 7, 'DROP', 7),
(8, 1, 8, 'DROP', 8),
(9, 2, 8, 'BOARDING', 1),
(10, 2, 7, 'BOARDING', 2),
(11, 2, 6, 'BOARDING', 3),
(12, 2, 5, 'BOTH', 4),
(13, 2, 4, 'DROP', 5),
(14, 2, 3, 'DROP', 6),
(15, 2, 2, 'DROP', 7),
(16, 2, 1, 'DROP', 8);

-- --------------------------------------------------------

--
-- Struktur dari tabel `schedules`
--

CREATE TABLE `schedules` (
  `id` int NOT NULL,
  `bus_id` int NOT NULL,
  `route_id` int NOT NULL,
  `route_type` enum('forward','return') NOT NULL DEFAULT 'forward',
  `departure_datetime` datetime NOT NULL,
  `arrival_datetime` datetime NOT NULL,
  `base_price` decimal(10,2) NOT NULL,
  `available_seats` int NOT NULL,
  `status` enum('scheduled','departed','cancelled','completed') DEFAULT 'scheduled',
  `notes` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `schedules`
--

INSERT INTO `schedules` (`id`, `bus_id`, `route_id`, `route_type`, `departure_datetime`, `arrival_datetime`, `base_price`, `available_seats`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'forward', '2026-01-05 06:00:00', '2026-01-05 18:00:00', 150000.00, 27, 'scheduled', NULL, '2025-12-29 11:35:54', '2025-12-31 14:32:36'),
(2, 4, 2, 'forward', '2026-01-05 06:00:00', '2026-01-05 18:00:00', 150000.00, 30, 'scheduled', NULL, '2025-12-29 11:35:54', '2025-12-31 13:58:24'),
(3, 2, 1, 'forward', '2026-01-05 15:00:00', '2026-01-06 04:00:00', 160000.00, 12, 'scheduled', '', '2025-12-29 11:35:54', '2026-01-01 12:13:49'),
(8, 24, 1, 'forward', '2026-01-01 20:21:00', '2026-01-02 12:49:00', 160000.00, 13, 'departed', '', '2026-01-01 12:49:58', '2026-01-01 13:21:16'),
(12, 10, 3, 'forward', '2026-01-05 06:00:00', '2026-01-05 18:41:00', 150000.00, 30, 'scheduled', '', '2026-01-01 13:42:16', '2026-01-01 13:42:16');

-- --------------------------------------------------------

--
-- Struktur dari tabel `seats`
--

CREATE TABLE `seats` (
  `id` int NOT NULL,
  `bus_id` int NOT NULL,
  `seat_number` varchar(10) NOT NULL,
  `seat_type` enum('Reclining seat premium','Sleeper seat') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'Reclining seat premium',
  `status` enum('available','booked','maintenance') DEFAULT 'available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `seats`
--

INSERT INTO `seats` (`id`, `bus_id`, `seat_number`, `seat_type`, `status`) VALUES
(1, 1, '1A', 'Reclining seat premium', 'available'),
(2, 1, '1B', 'Reclining seat premium', 'available'),
(3, 1, '1C', 'Reclining seat premium', 'available'),
(4, 1, '1D', 'Reclining seat premium', 'available'),
(5, 2, '1A', 'Sleeper seat', 'booked'),
(6, 1, '2A', 'Reclining seat premium', 'available'),
(7, 1, '2B', 'Reclining seat premium', 'available'),
(8, 1, '2C', 'Reclining seat premium', 'available'),
(9, 1, '2D', 'Reclining seat premium', 'available'),
(10, 1, '3A', 'Reclining seat premium', 'available'),
(11, 1, '3B', 'Reclining seat premium', 'available'),
(12, 1, '3C', 'Reclining seat premium', 'available'),
(13, 1, '3D', 'Reclining seat premium', 'available'),
(14, 1, '4A', 'Reclining seat premium', 'available'),
(15, 1, '4B', 'Reclining seat premium', 'available'),
(16, 1, '4C', 'Reclining seat premium', 'available'),
(17, 1, '4D', 'Reclining seat premium', 'available'),
(18, 1, '5A', 'Reclining seat premium', 'available'),
(19, 1, '5B', 'Reclining seat premium', 'available'),
(20, 1, '5C', 'Reclining seat premium', 'available'),
(21, 1, '5D', 'Reclining seat premium', 'available'),
(22, 1, '6A', 'Reclining seat premium', 'available'),
(23, 1, '6B', 'Reclining seat premium', 'available'),
(24, 1, '6C', 'Reclining seat premium', 'available'),
(25, 1, '6D', 'Reclining seat premium', 'booked'),
(26, 1, '7A', 'Reclining seat premium', 'available'),
(27, 1, '7B', 'Reclining seat premium', 'available'),
(28, 1, '7C', 'Reclining seat premium', 'available'),
(29, 1, '7D', 'Reclining seat premium', 'available'),
(30, 1, '8C', 'Reclining seat premium', 'available'),
(31, 1, '8D', 'Reclining seat premium', 'available'),
(32, 4, '1A', 'Reclining seat premium', 'available'),
(33, 4, '1B', 'Reclining seat premium', 'available'),
(34, 4, '1C', 'Reclining seat premium', 'available'),
(35, 4, '1D', 'Reclining seat premium', 'available'),
(36, 4, '2A', 'Reclining seat premium', 'available'),
(37, 4, '2B', 'Reclining seat premium', 'available'),
(38, 4, '2C', 'Reclining seat premium', 'available'),
(39, 4, '2D', 'Reclining seat premium', 'available'),
(40, 4, '3A', 'Reclining seat premium', 'available'),
(41, 4, '3B', 'Reclining seat premium', 'available'),
(42, 4, '3C', 'Reclining seat premium', 'available'),
(43, 4, '3D', 'Reclining seat premium', 'available'),
(44, 4, '4A', 'Reclining seat premium', 'available'),
(45, 4, '4B', 'Reclining seat premium', 'available'),
(46, 4, '4C', 'Reclining seat premium', 'available'),
(47, 4, '4D', 'Reclining seat premium', 'available'),
(48, 4, '5A', 'Reclining seat premium', 'available'),
(49, 4, '5B', 'Reclining seat premium', 'available'),
(50, 4, '5C', 'Reclining seat premium', 'available'),
(51, 4, '5D', 'Reclining seat premium', 'available'),
(52, 4, '6A', 'Reclining seat premium', 'available'),
(53, 4, '6B', 'Reclining seat premium', 'available'),
(54, 4, '6C', 'Reclining seat premium', 'available'),
(55, 4, '6D', 'Reclining seat premium', 'available'),
(56, 4, '7A', 'Reclining seat premium', 'available'),
(57, 4, '7B', 'Reclining seat premium', 'available'),
(58, 4, '7C', 'Reclining seat premium', 'available'),
(59, 4, '7D', 'Reclining seat premium', 'available'),
(60, 4, '8C', 'Reclining seat premium', 'available'),
(61, 4, '8D', 'Reclining seat premium', 'available'),
(62, 5, '1A', 'Reclining seat premium', 'available'),
(63, 5, '1B', 'Reclining seat premium', 'available'),
(64, 5, '1C', 'Reclining seat premium', 'available'),
(65, 5, '1D', 'Reclining seat premium', 'available'),
(66, 5, '2A', 'Reclining seat premium', 'available'),
(67, 5, '2B', 'Reclining seat premium', 'available'),
(68, 5, '2C', 'Reclining seat premium', 'available'),
(69, 5, '2D', 'Reclining seat premium', 'available'),
(70, 5, '3A', 'Reclining seat premium', 'available'),
(71, 5, '3B', 'Reclining seat premium', 'available'),
(72, 5, '3C', 'Reclining seat premium', 'available'),
(73, 5, '3D', 'Reclining seat premium', 'available'),
(74, 5, '4A', 'Reclining seat premium', 'available'),
(75, 5, '4B', 'Reclining seat premium', 'available'),
(76, 5, '4C', 'Reclining seat premium', 'available'),
(77, 5, '4D', 'Reclining seat premium', 'available'),
(78, 5, '5A', 'Reclining seat premium', 'available'),
(79, 5, '5B', 'Reclining seat premium', 'available'),
(80, 5, '5C', 'Reclining seat premium', 'available'),
(81, 5, '5D', 'Reclining seat premium', 'available'),
(82, 5, '6A', 'Reclining seat premium', 'available'),
(83, 5, '6B', 'Reclining seat premium', 'available'),
(84, 5, '6C', 'Reclining seat premium', 'available'),
(85, 5, '6D', 'Reclining seat premium', 'available'),
(86, 5, '7A', 'Reclining seat premium', 'available'),
(87, 5, '7B', 'Reclining seat premium', 'available'),
(88, 5, '7C', 'Reclining seat premium', 'available'),
(89, 5, '7D', 'Reclining seat premium', 'available'),
(90, 5, '8C', 'Reclining seat premium', 'available'),
(91, 5, '8D', 'Reclining seat premium', 'available'),
(92, 6, '1A', 'Reclining seat premium', 'available'),
(93, 6, '1B', 'Reclining seat premium', 'available'),
(94, 6, '1C', 'Reclining seat premium', 'available'),
(95, 6, '1D', 'Reclining seat premium', 'available'),
(96, 6, '2A', 'Reclining seat premium', 'available'),
(97, 6, '2B', 'Reclining seat premium', 'available'),
(98, 6, '2C', 'Reclining seat premium', 'available'),
(99, 6, '2D', 'Reclining seat premium', 'available'),
(100, 6, '3A', 'Reclining seat premium', 'available'),
(101, 6, '3B', 'Reclining seat premium', 'available'),
(102, 6, '3C', 'Reclining seat premium', 'available'),
(103, 6, '3D', 'Reclining seat premium', 'available'),
(104, 6, '4A', 'Reclining seat premium', 'available'),
(105, 6, '4B', 'Reclining seat premium', 'available'),
(106, 6, '4C', 'Reclining seat premium', 'available'),
(107, 6, '4D', 'Reclining seat premium', 'available'),
(108, 6, '5A', 'Reclining seat premium', 'available'),
(109, 6, '5B', 'Reclining seat premium', 'available'),
(110, 6, '5C', 'Reclining seat premium', 'available'),
(111, 6, '5D', 'Reclining seat premium', 'available'),
(112, 6, '6A', 'Reclining seat premium', 'available'),
(113, 6, '6B', 'Reclining seat premium', 'available'),
(114, 6, '6C', 'Reclining seat premium', 'available'),
(115, 6, '6D', 'Reclining seat premium', 'available'),
(116, 6, '7A', 'Reclining seat premium', 'available'),
(117, 6, '7B', 'Reclining seat premium', 'available'),
(118, 6, '7C', 'Reclining seat premium', 'available'),
(119, 6, '7D', 'Reclining seat premium', 'available'),
(120, 6, '8C', 'Reclining seat premium', 'available'),
(121, 6, '8D', 'Reclining seat premium', 'available'),
(122, 7, '1A', 'Reclining seat premium', 'available'),
(123, 7, '1B', 'Reclining seat premium', 'available'),
(124, 7, '1C', 'Reclining seat premium', 'available'),
(125, 7, '1D', 'Reclining seat premium', 'available'),
(126, 7, '2A', 'Reclining seat premium', 'available'),
(127, 7, '2B', 'Reclining seat premium', 'available'),
(128, 7, '2C', 'Reclining seat premium', 'available'),
(129, 7, '2D', 'Reclining seat premium', 'available'),
(130, 7, '3A', 'Reclining seat premium', 'available'),
(131, 7, '3B', 'Reclining seat premium', 'available'),
(132, 7, '3C', 'Reclining seat premium', 'available'),
(133, 7, '3D', 'Reclining seat premium', 'available'),
(134, 7, '4A', 'Reclining seat premium', 'available'),
(135, 7, '4B', 'Reclining seat premium', 'available'),
(136, 7, '4C', 'Reclining seat premium', 'available'),
(137, 7, '4D', 'Reclining seat premium', 'available'),
(138, 7, '5A', 'Reclining seat premium', 'available'),
(139, 7, '5B', 'Reclining seat premium', 'available'),
(140, 7, '5C', 'Reclining seat premium', 'available'),
(141, 7, '5D', 'Reclining seat premium', 'available'),
(142, 7, '6A', 'Reclining seat premium', 'available'),
(143, 7, '6B', 'Reclining seat premium', 'available'),
(144, 7, '6C', 'Reclining seat premium', 'available'),
(145, 7, '6D', 'Reclining seat premium', 'available'),
(146, 7, '7A', 'Reclining seat premium', 'available'),
(147, 7, '7B', 'Reclining seat premium', 'available'),
(148, 7, '7C', 'Reclining seat premium', 'available'),
(149, 7, '7D', 'Reclining seat premium', 'available'),
(150, 7, '8C', 'Reclining seat premium', 'available'),
(151, 7, '8D', 'Reclining seat premium', 'available'),
(152, 8, '1A', 'Reclining seat premium', 'available'),
(153, 8, '1B', 'Reclining seat premium', 'available'),
(154, 8, '1C', 'Reclining seat premium', 'available'),
(155, 8, '1D', 'Reclining seat premium', 'available'),
(156, 8, '2A', 'Reclining seat premium', 'available'),
(157, 8, '2B', 'Reclining seat premium', 'available'),
(158, 8, '2C', 'Reclining seat premium', 'available'),
(159, 8, '2D', 'Reclining seat premium', 'available'),
(160, 8, '3A', 'Reclining seat premium', 'available'),
(161, 8, '3B', 'Reclining seat premium', 'available'),
(162, 8, '3C', 'Reclining seat premium', 'available'),
(163, 8, '3D', 'Reclining seat premium', 'available'),
(164, 8, '4A', 'Reclining seat premium', 'available'),
(165, 8, '4B', 'Reclining seat premium', 'available'),
(166, 8, '4C', 'Reclining seat premium', 'available'),
(167, 8, '4D', 'Reclining seat premium', 'available'),
(168, 8, '5A', 'Reclining seat premium', 'available'),
(169, 8, '5B', 'Reclining seat premium', 'available'),
(170, 8, '5C', 'Reclining seat premium', 'available'),
(171, 8, '5D', 'Reclining seat premium', 'available'),
(172, 8, '6A', 'Reclining seat premium', 'available'),
(173, 8, '6B', 'Reclining seat premium', 'available'),
(174, 8, '6C', 'Reclining seat premium', 'available'),
(175, 8, '6D', 'Reclining seat premium', 'available'),
(176, 8, '7A', 'Reclining seat premium', 'available'),
(177, 8, '7B', 'Reclining seat premium', 'available'),
(178, 8, '7C', 'Reclining seat premium', 'available'),
(179, 8, '7D', 'Reclining seat premium', 'available'),
(180, 8, '8C', 'Reclining seat premium', 'available'),
(181, 8, '8D', 'Reclining seat premium', 'available'),
(182, 9, '1A', 'Reclining seat premium', 'available'),
(183, 9, '1B', 'Reclining seat premium', 'available'),
(184, 9, '1C', 'Reclining seat premium', 'available'),
(185, 9, '1D', 'Reclining seat premium', 'available'),
(186, 9, '2A', 'Reclining seat premium', 'available'),
(187, 9, '2B', 'Reclining seat premium', 'available'),
(188, 9, '2C', 'Reclining seat premium', 'available'),
(189, 9, '2D', 'Reclining seat premium', 'available'),
(190, 9, '3A', 'Reclining seat premium', 'available'),
(191, 9, '3B', 'Reclining seat premium', 'available'),
(192, 9, '3C', 'Reclining seat premium', 'available'),
(193, 9, '3D', 'Reclining seat premium', 'available'),
(194, 9, '4A', 'Reclining seat premium', 'available'),
(195, 9, '4B', 'Reclining seat premium', 'available'),
(196, 9, '4C', 'Reclining seat premium', 'available'),
(197, 9, '4D', 'Reclining seat premium', 'available'),
(198, 9, '5A', 'Reclining seat premium', 'available'),
(199, 9, '5B', 'Reclining seat premium', 'available'),
(200, 9, '5C', 'Reclining seat premium', 'available'),
(201, 9, '5D', 'Reclining seat premium', 'available'),
(202, 9, '6A', 'Reclining seat premium', 'available'),
(203, 9, '6B', 'Reclining seat premium', 'available'),
(204, 9, '6C', 'Reclining seat premium', 'available'),
(205, 9, '6D', 'Reclining seat premium', 'available'),
(206, 9, '7A', 'Reclining seat premium', 'available'),
(207, 9, '7B', 'Reclining seat premium', 'available'),
(208, 9, '7C', 'Reclining seat premium', 'available'),
(209, 9, '7D', 'Reclining seat premium', 'available'),
(210, 9, '8C', 'Reclining seat premium', 'available'),
(211, 9, '8D', 'Reclining seat premium', 'available'),
(212, 10, '1A', 'Reclining seat premium', 'available'),
(213, 10, '1B', 'Reclining seat premium', 'available'),
(214, 10, '1C', 'Reclining seat premium', 'available'),
(215, 10, '1D', 'Reclining seat premium', 'available'),
(216, 10, '2A', 'Reclining seat premium', 'available'),
(217, 10, '2B', 'Reclining seat premium', 'available'),
(218, 10, '2C', 'Reclining seat premium', 'available'),
(219, 10, '2D', 'Reclining seat premium', 'available'),
(220, 10, '3A', 'Reclining seat premium', 'available'),
(221, 10, '3B', 'Reclining seat premium', 'available'),
(222, 10, '3C', 'Reclining seat premium', 'available'),
(223, 10, '3D', 'Reclining seat premium', 'available'),
(224, 10, '4A', 'Reclining seat premium', 'available'),
(225, 10, '4B', 'Reclining seat premium', 'available'),
(226, 10, '4C', 'Reclining seat premium', 'available'),
(227, 10, '4D', 'Reclining seat premium', 'available'),
(228, 10, '5A', 'Reclining seat premium', 'available'),
(229, 10, '5B', 'Reclining seat premium', 'available'),
(230, 10, '5C', 'Reclining seat premium', 'available'),
(231, 10, '5D', 'Reclining seat premium', 'available'),
(232, 10, '6A', 'Reclining seat premium', 'available'),
(233, 10, '6B', 'Reclining seat premium', 'available'),
(234, 10, '6C', 'Reclining seat premium', 'available'),
(235, 10, '6D', 'Reclining seat premium', 'available'),
(236, 10, '7A', 'Reclining seat premium', 'available'),
(237, 10, '7B', 'Reclining seat premium', 'available'),
(238, 10, '7C', 'Reclining seat premium', 'available'),
(239, 10, '7D', 'Reclining seat premium', 'available'),
(240, 10, '8C', 'Reclining seat premium', 'available'),
(241, 10, '8D', 'Reclining seat premium', 'available'),
(242, 11, '1A', 'Reclining seat premium', 'available'),
(243, 11, '1B', 'Reclining seat premium', 'available'),
(244, 11, '1C', 'Reclining seat premium', 'available'),
(245, 11, '1D', 'Reclining seat premium', 'available'),
(246, 11, '2A', 'Reclining seat premium', 'available'),
(247, 11, '2B', 'Reclining seat premium', 'available'),
(248, 11, '2C', 'Reclining seat premium', 'available'),
(249, 11, '2D', 'Reclining seat premium', 'available'),
(250, 11, '3A', 'Reclining seat premium', 'available'),
(251, 11, '3B', 'Reclining seat premium', 'available'),
(252, 11, '3C', 'Reclining seat premium', 'available'),
(253, 11, '3D', 'Reclining seat premium', 'available'),
(254, 11, '4A', 'Reclining seat premium', 'available'),
(255, 11, '4B', 'Reclining seat premium', 'available'),
(256, 11, '4C', 'Reclining seat premium', 'available'),
(257, 11, '4D', 'Reclining seat premium', 'available'),
(258, 11, '5A', 'Reclining seat premium', 'available'),
(259, 11, '5B', 'Reclining seat premium', 'available'),
(260, 11, '5C', 'Reclining seat premium', 'available'),
(261, 11, '5D', 'Reclining seat premium', 'available'),
(262, 11, '6A', 'Reclining seat premium', 'available'),
(263, 11, '6B', 'Reclining seat premium', 'available'),
(264, 11, '6C', 'Reclining seat premium', 'available'),
(265, 11, '6D', 'Reclining seat premium', 'available'),
(266, 11, '7A', 'Reclining seat premium', 'available'),
(267, 11, '7B', 'Reclining seat premium', 'available'),
(268, 11, '7C', 'Reclining seat premium', 'available'),
(269, 11, '7D', 'Reclining seat premium', 'available'),
(270, 11, '8C', 'Reclining seat premium', 'available'),
(271, 11, '8D', 'Reclining seat premium', 'available'),
(272, 12, '1A', 'Reclining seat premium', 'available'),
(273, 12, '1B', 'Reclining seat premium', 'available'),
(274, 12, '1C', 'Reclining seat premium', 'available'),
(275, 12, '1D', 'Reclining seat premium', 'available'),
(276, 12, '2A', 'Reclining seat premium', 'available'),
(277, 12, '2B', 'Reclining seat premium', 'available'),
(278, 12, '2C', 'Reclining seat premium', 'available'),
(279, 12, '2D', 'Reclining seat premium', 'available'),
(280, 12, '3A', 'Reclining seat premium', 'available'),
(281, 12, '3B', 'Reclining seat premium', 'available'),
(282, 12, '3C', 'Reclining seat premium', 'available'),
(283, 12, '3D', 'Reclining seat premium', 'available'),
(284, 12, '4A', 'Reclining seat premium', 'available'),
(285, 12, '4B', 'Reclining seat premium', 'available'),
(286, 12, '4C', 'Reclining seat premium', 'available'),
(287, 12, '4D', 'Reclining seat premium', 'available'),
(288, 12, '5A', 'Reclining seat premium', 'available'),
(289, 12, '5B', 'Reclining seat premium', 'available'),
(290, 12, '5C', 'Reclining seat premium', 'available'),
(291, 12, '5D', 'Reclining seat premium', 'available'),
(292, 12, '6A', 'Reclining seat premium', 'available'),
(293, 12, '6B', 'Reclining seat premium', 'available'),
(294, 12, '6C', 'Reclining seat premium', 'available'),
(295, 12, '6D', 'Reclining seat premium', 'available'),
(296, 12, '7A', 'Reclining seat premium', 'available'),
(297, 12, '7B', 'Reclining seat premium', 'available'),
(298, 12, '7C', 'Reclining seat premium', 'available'),
(299, 12, '7D', 'Reclining seat premium', 'available'),
(300, 12, '8C', 'Reclining seat premium', 'available'),
(301, 12, '8D', 'Reclining seat premium', 'available'),
(302, 13, '1A', 'Reclining seat premium', 'available'),
(303, 13, '1B', 'Reclining seat premium', 'available'),
(304, 13, '1C', 'Reclining seat premium', 'available'),
(305, 13, '1D', 'Reclining seat premium', 'available'),
(306, 13, '2A', 'Reclining seat premium', 'available'),
(307, 13, '2B', 'Reclining seat premium', 'available'),
(308, 13, '2C', 'Reclining seat premium', 'available'),
(309, 13, '2D', 'Reclining seat premium', 'available'),
(310, 13, '3A', 'Reclining seat premium', 'available'),
(311, 13, '3B', 'Reclining seat premium', 'available'),
(312, 13, '3C', 'Reclining seat premium', 'available'),
(313, 13, '3D', 'Reclining seat premium', 'available'),
(314, 13, '4A', 'Reclining seat premium', 'available'),
(315, 13, '4B', 'Reclining seat premium', 'available'),
(316, 13, '4C', 'Reclining seat premium', 'available'),
(317, 13, '4D', 'Reclining seat premium', 'available'),
(318, 13, '5A', 'Reclining seat premium', 'available'),
(319, 13, '5B', 'Reclining seat premium', 'available'),
(320, 13, '5C', 'Reclining seat premium', 'available'),
(321, 13, '5D', 'Reclining seat premium', 'available'),
(322, 13, '6A', 'Reclining seat premium', 'available'),
(323, 13, '6B', 'Reclining seat premium', 'available'),
(324, 13, '6C', 'Reclining seat premium', 'available'),
(325, 13, '6D', 'Reclining seat premium', 'available'),
(326, 13, '7A', 'Reclining seat premium', 'available'),
(327, 13, '7B', 'Reclining seat premium', 'available'),
(328, 13, '7C', 'Reclining seat premium', 'available'),
(329, 13, '7D', 'Reclining seat premium', 'available'),
(330, 13, '8C', 'Reclining seat premium', 'available'),
(331, 13, '8D', 'Reclining seat premium', 'available'),
(332, 14, '1A', 'Reclining seat premium', 'available'),
(333, 14, '1B', 'Reclining seat premium', 'available'),
(334, 14, '1C', 'Reclining seat premium', 'available'),
(335, 14, '1D', 'Reclining seat premium', 'available'),
(336, 14, '2A', 'Reclining seat premium', 'available'),
(337, 14, '2B', 'Reclining seat premium', 'available'),
(338, 14, '2C', 'Reclining seat premium', 'available'),
(339, 14, '2D', 'Reclining seat premium', 'available'),
(340, 14, '3A', 'Reclining seat premium', 'available'),
(341, 14, '3B', 'Reclining seat premium', 'available'),
(342, 14, '3C', 'Reclining seat premium', 'available'),
(343, 14, '3D', 'Reclining seat premium', 'available'),
(344, 14, '4A', 'Reclining seat premium', 'available'),
(345, 14, '4B', 'Reclining seat premium', 'available'),
(346, 14, '4C', 'Reclining seat premium', 'available'),
(347, 14, '4D', 'Reclining seat premium', 'available'),
(348, 14, '5A', 'Reclining seat premium', 'available'),
(349, 14, '5B', 'Reclining seat premium', 'available'),
(350, 14, '5C', 'Reclining seat premium', 'available'),
(351, 14, '5D', 'Reclining seat premium', 'available'),
(352, 14, '6A', 'Reclining seat premium', 'available'),
(353, 14, '6B', 'Reclining seat premium', 'available'),
(354, 14, '6C', 'Reclining seat premium', 'available'),
(355, 14, '6D', 'Reclining seat premium', 'available'),
(356, 14, '7A', 'Reclining seat premium', 'available'),
(357, 14, '7B', 'Reclining seat premium', 'available'),
(358, 14, '7C', 'Reclining seat premium', 'available'),
(359, 14, '7D', 'Reclining seat premium', 'available'),
(360, 14, '8C', 'Reclining seat premium', 'available'),
(361, 14, '8D', 'Reclining seat premium', 'available'),
(362, 2, '1B', 'Sleeper seat', 'available'),
(363, 2, '2A', 'Sleeper seat', 'available'),
(364, 2, '2B', 'Sleeper seat', 'available'),
(365, 2, '3A', 'Sleeper seat', 'available'),
(366, 2, '3B', 'Sleeper seat', 'available'),
(367, 2, '4A', 'Sleeper seat', 'available'),
(368, 2, '4B', 'Sleeper seat', 'available'),
(369, 2, '5A', 'Sleeper seat', 'available'),
(370, 2, '5B', 'Sleeper seat', 'available'),
(371, 2, '6A', 'Sleeper seat', 'available'),
(372, 2, '6B', 'Sleeper seat', 'available'),
(373, 2, '7B', 'Sleeper seat', 'available'),
(374, 3, '1A', 'Sleeper seat', 'available'),
(375, 3, '1B', 'Sleeper seat', 'available'),
(376, 3, '2A', 'Sleeper seat', 'available'),
(377, 3, '2B', 'Sleeper seat', 'available'),
(378, 3, '3A', 'Sleeper seat', 'available'),
(379, 3, '3B', 'Sleeper seat', 'available'),
(380, 3, '4A', 'Sleeper seat', 'available'),
(381, 3, '4B', 'Sleeper seat', 'available'),
(382, 3, '5A', 'Sleeper seat', 'available'),
(383, 3, '5B', 'Sleeper seat', 'available'),
(384, 3, '6A', 'Sleeper seat', 'available'),
(385, 3, '6B', 'Sleeper seat', 'available'),
(386, 3, '7B', 'Sleeper seat', 'available'),
(387, 15, '1A', 'Sleeper seat', 'available'),
(388, 15, '1B', 'Sleeper seat', 'available'),
(389, 15, '2A', 'Sleeper seat', 'available'),
(390, 15, '2B', 'Sleeper seat', 'available'),
(391, 15, '3A', 'Sleeper seat', 'available'),
(392, 15, '3B', 'Sleeper seat', 'available'),
(393, 15, '4A', 'Sleeper seat', 'available'),
(394, 15, '4B', 'Sleeper seat', 'available'),
(395, 15, '5A', 'Sleeper seat', 'available'),
(396, 15, '5B', 'Sleeper seat', 'available'),
(397, 15, '6A', 'Sleeper seat', 'available'),
(398, 15, '6B', 'Sleeper seat', 'available'),
(399, 15, '7B', 'Sleeper seat', 'available'),
(400, 16, '1A', 'Sleeper seat', 'available'),
(401, 16, '1B', 'Sleeper seat', 'available'),
(402, 16, '2A', 'Sleeper seat', 'available'),
(403, 16, '2B', 'Sleeper seat', 'available'),
(404, 16, '3A', 'Sleeper seat', 'available'),
(405, 16, '3B', 'Sleeper seat', 'available'),
(406, 16, '4A', 'Sleeper seat', 'available'),
(407, 16, '4B', 'Sleeper seat', 'available'),
(408, 16, '5A', 'Sleeper seat', 'available'),
(409, 16, '5B', 'Sleeper seat', 'available'),
(410, 16, '6A', 'Sleeper seat', 'available'),
(411, 16, '6B', 'Sleeper seat', 'available'),
(412, 16, '7B', 'Sleeper seat', 'available'),
(413, 17, '1A', 'Sleeper seat', 'available'),
(414, 17, '1B', 'Sleeper seat', 'available'),
(415, 17, '2A', 'Sleeper seat', 'available'),
(416, 17, '2B', 'Sleeper seat', 'available'),
(417, 17, '3A', 'Sleeper seat', 'available'),
(418, 17, '3B', 'Sleeper seat', 'available'),
(419, 17, '4A', 'Sleeper seat', 'available'),
(420, 17, '4B', 'Sleeper seat', 'available'),
(421, 17, '5A', 'Sleeper seat', 'available'),
(422, 17, '5B', 'Sleeper seat', 'available'),
(423, 17, '6A', 'Sleeper seat', 'available'),
(424, 17, '6B', 'Sleeper seat', 'available'),
(425, 17, '7B', 'Sleeper seat', 'available'),
(426, 18, '1A', 'Sleeper seat', 'available'),
(427, 18, '1B', 'Sleeper seat', 'available'),
(428, 18, '2A', 'Sleeper seat', 'available'),
(429, 18, '2B', 'Sleeper seat', 'available'),
(430, 18, '3A', 'Sleeper seat', 'available'),
(431, 18, '3B', 'Sleeper seat', 'available'),
(432, 18, '4A', 'Sleeper seat', 'available'),
(433, 18, '4B', 'Sleeper seat', 'available'),
(434, 18, '5A', 'Sleeper seat', 'available'),
(435, 18, '5B', 'Sleeper seat', 'available'),
(436, 18, '6A', 'Sleeper seat', 'available'),
(437, 18, '6B', 'Sleeper seat', 'available'),
(438, 18, '7B', 'Sleeper seat', 'available'),
(439, 19, '1A', 'Sleeper seat', 'available'),
(440, 19, '1B', 'Sleeper seat', 'available'),
(441, 19, '2A', 'Sleeper seat', 'available'),
(442, 19, '2B', 'Sleeper seat', 'available'),
(443, 19, '3A', 'Sleeper seat', 'available'),
(444, 19, '3B', 'Sleeper seat', 'available'),
(445, 19, '4A', 'Sleeper seat', 'available'),
(446, 19, '4B', 'Sleeper seat', 'available'),
(447, 19, '5A', 'Sleeper seat', 'available'),
(448, 19, '5B', 'Sleeper seat', 'available'),
(449, 19, '6A', 'Sleeper seat', 'available'),
(450, 19, '6B', 'Sleeper seat', 'available'),
(451, 19, '7B', 'Sleeper seat', 'available'),
(452, 20, '1A', 'Sleeper seat', 'available'),
(453, 20, '1B', 'Sleeper seat', 'available'),
(454, 20, '2A', 'Sleeper seat', 'available'),
(455, 20, '2B', 'Sleeper seat', 'available'),
(456, 20, '3A', 'Sleeper seat', 'available'),
(457, 20, '3B', 'Sleeper seat', 'available'),
(458, 20, '4A', 'Sleeper seat', 'available'),
(459, 20, '4B', 'Sleeper seat', 'available'),
(460, 20, '5A', 'Sleeper seat', 'available'),
(461, 20, '5B', 'Sleeper seat', 'available'),
(462, 20, '6A', 'Sleeper seat', 'available'),
(463, 20, '6B', 'Sleeper seat', 'available'),
(464, 20, '7B', 'Sleeper seat', 'available'),
(465, 21, '1A', 'Sleeper seat', 'available'),
(466, 21, '1B', 'Sleeper seat', 'available'),
(467, 21, '2A', 'Sleeper seat', 'available'),
(468, 21, '2B', 'Sleeper seat', 'available'),
(469, 21, '3A', 'Sleeper seat', 'available'),
(470, 21, '3B', 'Sleeper seat', 'available'),
(471, 21, '4A', 'Sleeper seat', 'available'),
(472, 21, '4B', 'Sleeper seat', 'available'),
(473, 21, '5A', 'Sleeper seat', 'available'),
(474, 21, '5B', 'Sleeper seat', 'available'),
(475, 21, '6A', 'Sleeper seat', 'available'),
(476, 21, '6B', 'Sleeper seat', 'available'),
(477, 21, '7B', 'Sleeper seat', 'available'),
(478, 22, '1A', 'Sleeper seat', 'available'),
(479, 22, '1B', 'Sleeper seat', 'available'),
(480, 22, '2A', 'Sleeper seat', 'available'),
(481, 22, '2B', 'Sleeper seat', 'available'),
(482, 22, '3A', 'Sleeper seat', 'available'),
(483, 22, '3B', 'Sleeper seat', 'available'),
(484, 22, '4A', 'Sleeper seat', 'available'),
(485, 22, '4B', 'Sleeper seat', 'available'),
(486, 22, '5A', 'Sleeper seat', 'available'),
(487, 22, '5B', 'Sleeper seat', 'available'),
(488, 22, '6A', 'Sleeper seat', 'available'),
(489, 22, '6B', 'Sleeper seat', 'available'),
(490, 22, '7B', 'Sleeper seat', 'available'),
(491, 23, '1A', 'Sleeper seat', 'available'),
(492, 23, '1B', 'Sleeper seat', 'available'),
(493, 23, '2A', 'Sleeper seat', 'available'),
(494, 23, '2B', 'Sleeper seat', 'available'),
(495, 23, '3A', 'Sleeper seat', 'available'),
(496, 23, '3B', 'Sleeper seat', 'available'),
(497, 23, '4A', 'Sleeper seat', 'available'),
(498, 23, '4B', 'Sleeper seat', 'available'),
(499, 23, '5A', 'Sleeper seat', 'available'),
(500, 23, '5B', 'Sleeper seat', 'available'),
(501, 23, '6A', 'Sleeper seat', 'available'),
(502, 23, '6B', 'Sleeper seat', 'available'),
(503, 23, '7B', 'Sleeper seat', 'available'),
(504, 24, '1A', 'Sleeper seat', 'available'),
(505, 24, '1B', 'Sleeper seat', 'available'),
(506, 24, '2A', 'Sleeper seat', 'available'),
(507, 24, '2B', 'Sleeper seat', 'available'),
(508, 24, '3A', 'Sleeper seat', 'available'),
(509, 24, '3B', 'Sleeper seat', 'available'),
(510, 24, '4A', 'Sleeper seat', 'available'),
(511, 24, '4B', 'Sleeper seat', 'available'),
(512, 24, '5A', 'Sleeper seat', 'available'),
(513, 24, '5B', 'Sleeper seat', 'available'),
(514, 24, '6A', 'Sleeper seat', 'available'),
(515, 24, '6B', 'Sleeper seat', 'available'),
(516, 24, '7B', 'Sleeper seat', 'available');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'user',
  `is_verified` tinyint(1) DEFAULT '0',
  `verification_token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `password`, `role`, `is_verified`, `verification_token`, `created_at`, `updated_at`) VALUES
(1, 'admin1', 'admin1@gmail.com', '081227230956', '$2a$12$oeUGvcEBn25Yr5tdt6F5O.T0bT5.5oBodkjUtgFrlfQxr90TPrX06', 'admin', 1, NULL, '2025-12-29 05:27:58', '2026-01-01 13:40:01'),
(2, 'User1', 'samir20160464@gmail.com', '081227230956', '$2a$12$htG4kjSWH6X2dMNhUAmi0OfUEKkXGN1vsWS3AvkWGw4Cu09oQNIzy', 'user', 1, NULL, '2025-12-30 14:07:36', '2025-12-31 06:37:58'),
(8, 'Samirudin Annas Alfattah', 'annas20160464@gmail.com', '081227230952', '$2a$12$Rdf9D76PkZ9tcHYR4DQctO2zPKfKWGy.2lFAa/cq.AYBHufmzvaba', 'user', 1, NULL, '2025-12-31 07:00:25', '2026-01-01 13:35:25');

--
-- Indeks untuk tabel yang dibuang
--

--
-- Indeks untuk tabel `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `booking_code` (`booking_code`),
  ADD KEY `schedule_id` (`schedule_id`),
  ADD KEY `idx_booking_code` (`booking_code`),
  ADD KEY `idx_user_status` (`user_id`,`booking_status`),
  ADD KEY `idx_pickup_location` (`pickup_location_id`),
  ADD KEY `idx_drop_location` (`drop_location_id`);

--
-- Indeks untuk tabel `buses`
--
ALTER TABLE `buses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `plate_number` (`plate_number`),
  ADD KEY `bus_class_id` (`bus_class_id`),
  ADD KEY `operator_id` (`operator_id`);

--
-- Indeks untuk tabel `bus_classes`
--
ALTER TABLE `bus_classes`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`location_id`);

--
-- Indeks untuk tabel `passengers`
--
ALTER TABLE `passengers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_seat_booking` (`seat_id`,`booking_id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indeks untuk tabel `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_payment_status` (`payment_status`),
  ADD KEY `idx_booking_payment` (`booking_id`,`payment_status`);

--
-- Indeks untuk tabel `routes`
--
ALTER TABLE `routes`
  ADD PRIMARY KEY (`route_id`);

--
-- Indeks untuk tabel `route_location`
--
ALTER TABLE `route_location`
  ADD PRIMARY KEY (`route_location_id`),
  ADD UNIQUE KEY `uq_sequence_route` (`route_id`,`sequence`),
  ADD KEY `fk_location` (`location_id`);

--
-- Indeks untuk tabel `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bus_id` (`bus_id`),
  ADD KEY `idx_departure` (`departure_datetime`),
  ADD KEY `idx_route_departure` (`route_id`,`departure_datetime`);

--
-- Indeks untuk tabel `seats`
--
ALTER TABLE `seats`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_bus_seat` (`bus_id`,`seat_number`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_verification_token` (`verification_token`),
  ADD KEY `idx_is_verified` (`is_verified`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `buses`
--
ALTER TABLE `buses`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT untuk tabel `bus_classes`
--
ALTER TABLE `bus_classes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `location`
--
ALTER TABLE `location`
  MODIFY `location_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT untuk tabel `passengers`
--
ALTER TABLE `passengers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `routes`
--
ALTER TABLE `routes`
  MODIFY `route_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `route_location`
--
ALTER TABLE `route_location`
  MODIFY `route_location_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `seats`
--
ALTER TABLE `seats`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=519;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD CONSTRAINT `audit_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`schedule_id`) REFERENCES `schedules` (`id`),
  ADD CONSTRAINT `fk_booking_drop` FOREIGN KEY (`drop_location_id`) REFERENCES `location` (`location_id`),
  ADD CONSTRAINT `fk_booking_pickup` FOREIGN KEY (`pickup_location_id`) REFERENCES `location` (`location_id`);

--
-- Ketidakleluasaan untuk tabel `buses`
--
ALTER TABLE `buses`
  ADD CONSTRAINT `buses_ibfk_1` FOREIGN KEY (`bus_class_id`) REFERENCES `bus_classes` (`id`),
  ADD CONSTRAINT `buses_ibfk_2` FOREIGN KEY (`operator_id`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `passengers`
--
ALTER TABLE `passengers`
  ADD CONSTRAINT `passengers_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `passengers_ibfk_2` FOREIGN KEY (`seat_id`) REFERENCES `seats` (`id`);

--
-- Ketidakleluasaan untuk tabel `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`);

--
-- Ketidakleluasaan untuk tabel `route_location`
--
ALTER TABLE `route_location`
  ADD CONSTRAINT `fk_location` FOREIGN KEY (`location_id`) REFERENCES `location` (`location_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_routes` FOREIGN KEY (`route_id`) REFERENCES `routes` (`route_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `schedules`
--
ALTER TABLE `schedules`
  ADD CONSTRAINT `schedules_ibfk_1` FOREIGN KEY (`bus_id`) REFERENCES `buses` (`id`),
  ADD CONSTRAINT `schedules_ibfk_2` FOREIGN KEY (`route_id`) REFERENCES `routes` (`route_id`);

--
-- Ketidakleluasaan untuk tabel `seats`
--
ALTER TABLE `seats`
  ADD CONSTRAINT `seats_ibfk_1` FOREIGN KEY (`bus_id`) REFERENCES `buses` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
