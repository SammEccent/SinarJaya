<?php

class BookingModel
{
    protected $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    /**
     * Get a specified number of recent bookings with user and route details.
     * Assumes 'bookings' table has 'created_at' column.
     */
    public function getRecentBookings($limit = 5)
    {
        $this->db->prepare('
            SELECT 
                b.id,
                b.booking_code,
                b.user_id,
                b.schedule_id,
                b.booking_status,
                b.created_at,
                u.name AS user_name,
                r.route_code
            FROM bookings b
            LEFT JOIN users u ON b.user_id = u.id
            LEFT JOIN schedules s ON b.schedule_id = s.id
            LEFT JOIN routes r ON s.route_id = r.route_id
            ORDER BY b.created_at DESC 
            LIMIT :limit
        ');
        $this->db->bind(':limit', $limit);
        return $this->db->fetchAll();
    }

    /**
     * Get all bookings with user and route details
     */
    public function getAll()
    {
        $this->db->prepare('
            SELECT 
                b.id,
                b.booking_code,
                b.user_id,
                b.schedule_id,
                b.total_passengers,
                b.total_amount,
                b.booking_status,
                b.created_at,
                b.updated_at,
                u.name AS user_name,
                u.email AS user_email,
                r.route_code,
                r.origin_city,
                r.destination_city,
                s.departure_datetime,
                s.arrival_datetime,
                bus.plate_number
            FROM bookings b
            LEFT JOIN users u ON b.user_id = u.id
            LEFT JOIN schedules s ON b.schedule_id = s.id
            LEFT JOIN routes r ON s.route_id = r.route_id
            LEFT JOIN buses bus ON s.bus_id = bus.id
            ORDER BY b.created_at DESC
        ');
        return $this->db->fetchAll();
    }

    /**
     * Create new booking
     * 
     * @param array $data Booking data
     * @return int|false Last insert ID or false on failure
     */
    public function create($data)
    {
        $this->db->prepare('
            INSERT INTO bookings 
            (booking_code, user_id, schedule_id, pickup_location_id, drop_location_id, 
             total_passengers, total_amount, booking_status, payment_expiry, notes, created_at)
            VALUES 
            (:booking_code, :user_id, :schedule_id, :pickup_location_id, :drop_location_id,
             :total_passengers, :total_amount, :booking_status, :payment_expiry, :notes, :created_at)
        ');

        $this->db->bind(':booking_code', $data['booking_code']);
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':schedule_id', $data['schedule_id']);
        $this->db->bind(':pickup_location_id', $data['pickup_location_id'] ?? null);
        $this->db->bind(':drop_location_id', $data['drop_location_id'] ?? null);
        $this->db->bind(':total_passengers', $data['total_passengers']);
        $this->db->bind(':total_amount', $data['total_amount']);
        $this->db->bind(':booking_status', $data['booking_status'] ?? 'pending');
        $this->db->bind(':payment_expiry', $data['payment_expiry'] ?? null);
        $this->db->bind(':notes', $data['notes'] ?? null);
        $this->db->bind(':created_at', date('Y-m-d H:i:s'));

        if ($this->db->execute()) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    /**
     * Find booking by ID
     * 
     * @param int $id Booking ID
     * @return array|false Booking data or false
     */
    public function findById($id)
    {
        $this->db->prepare('
            SELECT 
                b.*,
                u.name AS user_name,
                u.email AS user_email,
                u.phone AS user_phone,
                r.route_code,
                r.origin_city,
                r.destination_city,
                s.departure_datetime,
                s.arrival_datetime,
                s.base_price,
                bus.plate_number,
                bus.total_seats,
                bc.name as bus_class_name,
                bc.base_price_multiplier,
                pickup_loc.location_name AS pickup_location_name,
                pickup_loc.city AS pickup_city,
                pickup_loc.address AS pickup_address,
                drop_loc.location_name AS drop_location_name,
                drop_loc.city AS drop_city,
                drop_loc.address AS drop_address
            FROM bookings b
            LEFT JOIN users u ON b.user_id = u.id
            LEFT JOIN schedules s ON b.schedule_id = s.id
            LEFT JOIN routes r ON s.route_id = r.route_id
            LEFT JOIN buses bus ON s.bus_id = bus.id
            LEFT JOIN bus_classes bc ON bus.bus_class_id = bc.id
            LEFT JOIN location pickup_loc ON b.pickup_location_id = pickup_loc.location_id
            LEFT JOIN location drop_loc ON b.drop_location_id = drop_loc.location_id
            WHERE b.id = :id
            LIMIT 1
        ');

        $this->db->bind(':id', $id);
        return $this->db->fetch();
    }

    /**
     * Get all bookings by user ID
     * 
     * @param int $user_id User ID
     * @return array Array of bookings
     */
    public function getByUserId($user_id)
    {
        $this->db->prepare('
            SELECT 
                b.*,
                r.route_code,
                r.origin_city,
                r.destination_city,
                s.departure_datetime,
                s.arrival_datetime,
                bc.name as bus_class_name
            FROM bookings b
            LEFT JOIN schedules s ON b.schedule_id = s.id
            LEFT JOIN routes r ON s.route_id = r.route_id
            LEFT JOIN buses bus ON s.bus_id = bus.id
            LEFT JOIN bus_classes bc ON bus.bus_class_id = bc.id
            WHERE b.user_id = :user_id
            ORDER BY b.created_at DESC
        ');

        $this->db->bind(':user_id', $user_id);
        return $this->db->fetchAll();
    }

    /**
     * Get passengers for a booking
     * 
     * @param int $booking_id Booking ID
     * @return array Array of passengers
     */
    public function getPassengers($booking_id)
    {
        $this->db->prepare('
            SELECT p.*, s.seat_number, s.seat_type 
            FROM passengers p
            LEFT JOIN seats s ON p.seat_id = s.id
            WHERE p.booking_id = :booking_id 
            ORDER BY p.id ASC
        ');

        $this->db->bind(':booking_id', $booking_id);
        return $this->db->fetchAll();
    }

    /**
     * Update booking
     * 
     * @param int $id Booking ID
     * @param array $data Data to update
     * @return bool Success status
     */
    public function update($id, $data)
    {
        $fields = [];
        $allowed = ['booking_status', 'payment_expiry', 'notes'];

        foreach ($allowed as $field) {
            if (isset($data[$field])) {
                $fields[] = "$field = :$field";
            }
        }

        if (empty($fields)) {
            return false;
        }

        $sql = 'UPDATE bookings SET ' . implode(', ', $fields) . ', updated_at = :updated_at WHERE id = :id';
        $this->db->prepare($sql);

        foreach ($allowed as $field) {
            if (isset($data[$field])) {
                $this->db->bind(':' . $field, $data[$field]);
            }
        }

        $this->db->bind(':updated_at', date('Y-m-d H:i:s'));
        $this->db->bind(':id', $id);

        return $this->db->execute();
    }

    /**
     * Delete booking
     * 
     * @param int $id Booking ID
     * @return bool Success status
     */
    public function delete($id)
    {
        // First, delete associated passengers
        $passengerModel = new PassengerModel();
        $passengerModel->deleteByBooking($id);

        // Then delete the booking
        $this->db->prepare('DELETE FROM bookings WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    /**
     * Check and update expired bookings
     * Automatically update booking status to 'expired' if payment_expiry has passed
     * 
     * @return int Number of bookings updated
     */
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
}
