-- Migration: Pindahkan route_type dari routes ke schedules
-- Purpose: route_type ditentukan per jadwal, bukan per rute

-- 1. Hapus kolom route_type dari routes
ALTER TABLE routes 
DROP COLUMN route_type;

-- 2. Tambahkan kolom route_type ke schedules
ALTER TABLE schedules 
ADD COLUMN route_type ENUM('forward', 'return') NOT NULL DEFAULT 'forward' 
AFTER route_id;

-- Set all existing schedules as 'forward' by default
-- Admin dapat mengubahnya sesuai kebutuhan
