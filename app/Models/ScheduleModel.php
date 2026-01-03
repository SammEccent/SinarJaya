<?php

class ScheduleModel
{
    protected $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getBusTotalSeats($bus_id)
    {
        $this->db->prepare('SELECT total_seats FROM buses WHERE id = :id LIMIT 1');
        $this->db->bind(':id', $bus_id);
        $row = $this->db->fetch();
        if ($row && isset($row['total_seats'])) {
            return intval($row['total_seats']);
        }
        return 0;
    }

    public function getAll()
    {
        $this->db->prepare('SELECT s.*, b.plate_number, bc.base_price_multiplier, r.route_code, r.origin_city, r.destination_city, (s.base_price * bc.base_price_multiplier) as final_price FROM schedules s JOIN buses b ON s.bus_id = b.id JOIN bus_classes bc ON b.bus_class_id = bc.id JOIN routes r ON s.route_id = r.route_id ORDER BY s.departure_datetime DESC');
        return $this->db->fetchAll();
    }

    public function findById($id)
    {
        $this->db->prepare('SELECT s.*, b.plate_number, r.route_code, r.origin_city, r.destination_city FROM schedules s JOIN buses b ON s.bus_id = b.id JOIN routes r ON s.route_id = r.route_id WHERE s.id = :id LIMIT 1');
        $this->db->bind(':id', $id);
        return $this->db->fetch();
    }

    public function create($data)
    {
        // Ensure available_seats is derived from bus total_seats when not provided or invalid
        $bus_id = $data['bus_id'];
        $available = isset($data['available_seats']) ? intval($data['available_seats']) : 0;
        $total_seats = $this->getBusTotalSeats($bus_id);
        if ($available <= 0 || $available > $total_seats) {
            $available = $total_seats;
        }

        $this->db->prepare('INSERT INTO schedules (bus_id, route_id, route_type, departure_datetime, arrival_datetime, base_price, available_seats, status, notes, created_at) VALUES (:bus_id, :route_id, :route_type, :departure, :arrival, :base_price, :available_seats, :status, :notes, :created_at)');
        $this->db->bind(':bus_id', $bus_id);
        $this->db->bind(':route_id', $data['route_id']);
        $this->db->bind(':route_type', $data['route_type'] ?? 'forward');
        $this->db->bind(':departure', $data['departure_datetime']);
        $this->db->bind(':arrival', $data['arrival_datetime']);
        $this->db->bind(':base_price', $data['base_price']);
        $this->db->bind(':available_seats', $available);
        $this->db->bind(':status', $data['status'] ?? 'scheduled');
        $this->db->bind(':notes', $data['notes'] ?? null);
        $this->db->bind(':created_at', date('Y-m-d H:i:s'));
        return $this->db->execute();
    }

    public function update($id, $data)
    {
        // Clamp available_seats to bus total_seats
        $bus_id = $data['bus_id'];
        $available = isset($data['available_seats']) ? intval($data['available_seats']) : 0;
        $total_seats = $this->getBusTotalSeats($bus_id);
        if ($available <= 0 || $available > $total_seats) {
            $available = $total_seats;
        }

        $this->db->prepare('UPDATE schedules SET bus_id = :bus_id, route_id = :route_id, route_type = :route_type, departure_datetime = :departure, arrival_datetime = :arrival, base_price = :base_price, available_seats = :available_seats, status = :status, notes = :notes WHERE id = :id');
        $this->db->bind(':bus_id', $bus_id);
        $this->db->bind(':route_id', $data['route_id']);
        $this->db->bind(':route_type', $data['route_type'] ?? 'forward');
        $this->db->bind(':departure', $data['departure_datetime']);
        $this->db->bind(':arrival', $data['arrival_datetime']);
        $this->db->bind(':base_price', $data['base_price']);
        $this->db->bind(':available_seats', $available);
        $this->db->bind(':status', $data['status'] ?? 'scheduled');
        $this->db->bind(':notes', $data['notes'] ?? null);
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function delete($id)
    {
        $this->db->prepare('DELETE FROM schedules WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    /**
     * Search schedules based on route and date
     * 
     * @param string $origin Origin city
     * @param string $destination Destination city
     * @param string $date Departure date (Y-m-d format)
     * @param int $passengers Number of passengers
     * @return array Array of schedules with full details
     */
    public function searchSchedules($origin, $destination, $date, $passengers = 1)
    {
        // Convert date to datetime range for search
        $dateStart = $date . ' 00:00:00';
        $dateEnd = $date . ' 23:59:59';

        // Get current datetime
        $currentDatetime = date('Y-m-d H:i:s');

        $this->db->prepare('
            SELECT 
                s.id as schedule_id,
                s.departure_datetime,
                s.arrival_datetime,
                s.base_price,
                s.available_seats,
                s.status as schedule_status,
                s.notes,
                r.route_id,
                r.origin_city,
                r.destination_city,
                r.route_code,
                r.status as route_status,
                b.id as bus_id,
                b.plate_number,
                b.total_seats,
                b.seat_layout,
                b.facilities as bus_facilities,
                b.status as bus_status,
                bc.id as bus_class_id,
                bc.name as bus_class_name,
                bc.description as bus_class_description,
                bc.facilities as class_facilities,
                bc.base_price_multiplier,
                TIMESTAMPDIFF(MINUTE, s.departure_datetime, s.arrival_datetime) as duration_minutes
            FROM schedules s
            JOIN routes r ON s.route_id = r.route_id
            JOIN buses b ON s.bus_id = b.id
            JOIN bus_classes bc ON b.bus_class_id = bc.id
            WHERE r.origin_city = :origin
            AND r.destination_city = :destination
            AND s.departure_datetime BETWEEN :date_start AND :date_end
            AND s.departure_datetime >= :current_datetime
            AND s.available_seats >= :passengers
            AND s.status = "scheduled"
            AND r.status = "active"
            AND b.status = "active"
            ORDER BY s.departure_datetime ASC
        ');

        $this->db->bind(':origin', $origin);
        $this->db->bind(':destination', $destination);
        $this->db->bind(':date_start', $dateStart);
        $this->db->bind(':date_end', $dateEnd);
        $this->db->bind(':current_datetime', $currentDatetime);
        $this->db->bind(':passengers', $passengers);

        return $this->db->fetchAll();
    }

    /**
     * Get schedule with full details by ID
     * 
     * @param int $id Schedule ID
     * @return array|false Schedule data with full details or false
     */
    public function getScheduleDetails($id)
    {
        $this->db->prepare('
            SELECT 
                s.*,
                r.route_id,
                r.origin_city,
                r.destination_city,
                r.route_code,
                b.plate_number,
                b.total_seats,
                b.seat_layout,
                b.facilities as bus_facilities,
                bc.name as bus_class_name,
                bc.description as bus_class_description,
                bc.facilities as class_facilities,
                bc.base_price_multiplier
            FROM schedules s
            JOIN routes r ON s.route_id = r.route_id
            JOIN buses b ON s.bus_id = b.id
            JOIN bus_classes bc ON b.bus_class_id = bc.id
            WHERE s.id = :id
            LIMIT 1
        ');

        $this->db->bind(':id', $id);
        return $this->db->fetch();
    }

    /**
     * Update only available seats for a schedule
     * 
     * @param int $id Schedule ID
     * @param int $available_seats New available seats count
     * @return bool Success status
     */
    public function updateAvailableSeats($id, $available_seats)
    {
        $this->db->prepare('UPDATE schedules SET available_seats = :available_seats, updated_at = :updated_at WHERE id = :id');
        $this->db->bind(':available_seats', $available_seats);
        $this->db->bind(':updated_at', date('Y-m-d H:i:s'));
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    /**
     * Recalculate and fix available_seats for a schedule based on actual seat data
     * This method counts booked seats for this schedule and calculates available seats
     * 
     * @param int $schedule_id Schedule ID
     * @return bool Success status
     */
    public function recalculateAvailableSeats($schedule_id)
    {
        // Get schedule info including bus_id
        $schedule = $this->findById($schedule_id);
        if (!$schedule) {
            return false;
        }

        $bus_id = $schedule['bus_id'];

        // Count total seats in the bus
        $this->db->prepare('SELECT COUNT(*) as total FROM seats WHERE bus_id = :bus_id');
        $this->db->bind(':bus_id', $bus_id);
        $result = $this->db->fetch();
        $total_seats = $result['total'] ?? 0;

        // Count booked seats for this specific schedule
        // A seat is considered booked for a schedule if:
        // 1. The seat status is 'booked'
        // 2. There's a passenger record linking to a booking for this schedule
        $this->db->prepare('
            SELECT COUNT(DISTINCT s.id) as booked
            FROM seats s
            INNER JOIN passengers p ON s.id = p.seat_id
            INNER JOIN bookings b ON p.booking_id = b.id
            WHERE s.bus_id = :bus_id 
            AND b.schedule_id = :schedule_id
            AND s.status = "booked"
            AND b.booking_status IN ("pending", "confirmed")
        ');
        $this->db->bind(':bus_id', $bus_id);
        $this->db->bind(':schedule_id', $schedule_id);
        $result = $this->db->fetch();
        $booked_seats = $result['booked'] ?? 0;

        // Calculate available seats
        $available_seats = $total_seats - $booked_seats;

        // Update the schedule
        return $this->updateAvailableSeats($schedule_id, $available_seats);
    }

    /**
     * Fix all schedules' available_seats by recalculating based on actual seat data
     * 
     * @return array Array of fixed schedule IDs
     */
    public function fixAllSchedulesAvailableSeats()
    {
        // Get all schedules
        $this->db->prepare('SELECT id FROM schedules');
        $schedules = $this->db->fetchAll();

        $fixed_ids = [];
        foreach ($schedules as $schedule) {
            if ($this->recalculateAvailableSeats($schedule['id'])) {
                $fixed_ids[] = $schedule['id'];
            }
        }

        return $fixed_ids;
    }

    /**
     * Auto-update status jadwal yang sudah berangkat
     * Update status dari 'scheduled' ke 'departed' jika waktu keberangkatan sudah lewat
     * 
     * @return int Number of schedules updated
     */
    public function updateDepartedSchedules()
    {
        $this->db->prepare("
            UPDATE schedules 
            SET status = 'departed' 
            WHERE status = 'scheduled' 
            AND departure_datetime < NOW()
        ");

        return $this->db->execute() ? $this->db->rowCount() : 0;
    }

    /**
     * Validate if a bus can be scheduled for a specific route and time
     * Logika baru:
     * 1. Cek apakah bus punya jadwal departed yang masih berjalan
     * 2. Jadwal baru harus setelah waktu tiba jadwal yang sedang berjalan
     * 3. Jadwal baru harus menggunakan route_type berlawanan (forward <-> return)
     * 4. Untuk return, route harus menuju ke origin dari jadwal sebelumnya
     * 
     * @param int $bus_id Bus ID
     * @param int $route_id Route ID untuk jadwal baru
     * @param string $departure_datetime Waktu keberangkatan jadwal baru
     * @param string $route_type Route type jadwal baru (forward/return)
     * @param int|null $exclude_schedule_id Schedule ID to exclude (untuk edit)
     * @return array ['valid' => bool, 'message' => string, 'current_schedule' => array|null]
     */
    public function validateBusSchedule($bus_id, $route_id, $departure_datetime, $route_type, $exclude_schedule_id = null)
    {
        // Get route info for new schedule
        $this->db->prepare("SELECT origin_city, destination_city FROM routes WHERE route_id = :route_id");
        $this->db->bind(':route_id', $route_id);
        $newRoute = $this->db->fetch();

        if (!$newRoute) {
            return [
                'valid' => false,
                'message' => 'Rute tidak ditemukan',
                'current_schedule' => null
            ];
        }

        // Find the most recent schedule for this bus before the new departure
        $sql = "
            SELECT s.*, s.route_type as schedule_route_type, r.origin_city, r.destination_city
            FROM schedules s
            JOIN routes r ON s.route_id = r.route_id
            WHERE s.bus_id = :bus_id
            AND s.status IN ('scheduled', 'departed')
        ";

        if ($exclude_schedule_id) {
            $sql .= " AND s.id != :exclude_id";
        }

        $sql .= " ORDER BY s.arrival_datetime DESC LIMIT 1";

        $this->db->prepare($sql);
        $this->db->bind(':bus_id', $bus_id);
        if ($exclude_schedule_id) {
            $this->db->bind(':exclude_id', $exclude_schedule_id);
        }

        $lastSchedule = $this->db->fetch();

        // No previous schedule, any route type is allowed
        if (!$lastSchedule) {
            return [
                'valid' => true,
                'message' => '',
                'current_schedule' => null
            ];
        }

        // Get times
        $lastArrivalTime = strtotime($lastSchedule['arrival_datetime']);
        $newDepartureTime = strtotime($departure_datetime);

        // New departure must be AFTER (>) previous arrival, not equal
        if ($newDepartureTime <= $lastArrivalTime) {
            $timeDiff = $lastArrivalTime - $newDepartureTime;
            $minutesDiff = round($timeDiff / 60);

            if ($newDepartureTime < $lastArrivalTime) {
                $message = 'Waktu keberangkatan harus setelah waktu tiba jadwal sebelumnya. ' .
                    'Jadwal sebelumnya tiba pada ' . date('d/m/Y H:i', $lastArrivalTime) .
                    ' (' . $lastSchedule['origin_city'] . ' → ' . $lastSchedule['destination_city'] . '). ' .
                    'Waktu keberangkatan yang Anda masukkan (' . date('d/m/Y H:i', $newDepartureTime) . ') ' .
                    'lebih cepat ' . abs($minutesDiff) . ' menit dari waktu tiba.';
            } else {
                $message = 'Waktu keberangkatan tidak boleh sama dengan waktu tiba jadwal sebelumnya. ' .
                    'Jadwal sebelumnya tiba pada ' . date('d/m/Y H:i', $lastArrivalTime) .
                    ' (' . $lastSchedule['origin_city'] . ' → ' . $lastSchedule['destination_city'] . '). ' .
                    'Berikan jeda waktu minimal 1 menit untuk transit.';
            }

            return [
                'valid' => false,
                'message' => $message,
                'current_schedule' => $lastSchedule
            ];
        }

        // Check route type logic: must alternate between forward and return
        $lastRouteType = $lastSchedule['schedule_route_type'] ?? 'forward';

        if ($lastRouteType === $route_type) {
            $expectedType = ($route_type === 'forward') ? 'return' : 'forward';
            $expectedTypeText = ($expectedType === 'return') ? 'Arus Balik' : 'Arus Berangkat';
            $currentTypeText = ($lastRouteType === 'forward') ? 'Arus Berangkat' : 'Arus Balik';

            return [
                'valid' => false,
                'message' => 'Bus terakhir dijadwalkan sebagai ' . $currentTypeText .
                    ' (' . $lastSchedule['origin_city'] . ' → ' . $lastSchedule['destination_city'] . '). ' .
                    'Jadwal berikutnya harus menggunakan ' . $expectedTypeText,
                'current_schedule' => $lastSchedule
            ];
        }

        // Check if route origin matches previous route destination
        // Bus harus berada di lokasi tujuan jadwal sebelumnya
        if ($newRoute['origin_city'] !== $lastSchedule['destination_city']) {
            return [
                'valid' => false,
                'message' => 'Titik keberangkatan rute baru harus dari ' . $lastSchedule['destination_city'] .
                    ' (lokasi tiba jadwal sebelumnya). Rute yang dipilih berangkat dari ' . $newRoute['origin_city'] .
                    '. Pilih rute yang berangkat dari ' . $lastSchedule['destination_city'],
                'current_schedule' => $lastSchedule
            ];
        }

        // All checks passed
        return [
            'valid' => true,
            'message' => '',
            'current_schedule' => $lastSchedule
        ];
    }
}
