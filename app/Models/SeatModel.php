<?php

class SeatModel
{
    protected $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getByBus($bus_id)
    {
        $this->db->prepare('
            SELECT 
                s.id,
                s.bus_id,
                s.seat_number,
                s.seat_type,
                CASE 
                    WHEN s.status = "maintenance" THEN "maintenance"
                    WHEN EXISTS (
                        SELECT 1 FROM passengers p
                        JOIN bookings b ON p.booking_id = b.id
                        WHERE p.seat_id = s.id
                        AND b.booking_status IN ("pending", "confirmed")
                        AND (b.payment_expiry IS NULL OR b.payment_expiry > NOW())
                    ) THEN "booked"
                    ELSE "available"
                END as status
            FROM seats s
            WHERE s.bus_id = :bus_id 
            ORDER BY s.id ASC
        ');
        $this->db->bind(':bus_id', $bus_id);
        return $this->db->fetchAll();
    }

    public function findById($id)
    {
        $this->db->prepare('SELECT * FROM seats WHERE id = :id LIMIT 1');
        $this->db->bind(':id', $id);
        return $this->db->fetch();
    }

    public function create($bus_id, $seat_number, $type = 'regular')
    {
        $this->db->prepare('INSERT INTO seats (bus_id, seat_number, seat_type, status) VALUES (:bus_id, :seat_number, :seat_type, :status)');
        $this->db->bind(':bus_id', $bus_id);
        $this->db->bind(':seat_number', $seat_number);
        $this->db->bind(':seat_type', $type);
        $this->db->bind(':status', 'available');
        return $this->db->execute();
    }

    public function toggleStatus($id)
    {
        $seat = $this->findById($id);
        if (!$seat) return false;
        $new = ($seat['status'] === 'available') ? 'maintenance' : 'available';
        $this->db->prepare('UPDATE seats SET status = :status WHERE id = :id');
        $this->db->bind(':status', $new);
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function delete($id)
    {
        $this->db->prepare('DELETE FROM seats WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    /**
     * Get available seats for a specific schedule
     * Returns seats that are not booked for this schedule
     * 
     * @param int $schedule_id Schedule ID
     * @param int $bus_id Bus ID
     * @return array Array of seats with booking status
     */
    public function getAvailableSeatsForSchedule($schedule_id, $bus_id)
    {
        $this->db->prepare('
            SELECT 
                s.id,
                s.bus_id,
                s.seat_number,
                s.seat_type,
                s.status as seat_status,
                CASE 
                    -- Check if seat is in maintenance
                    WHEN s.status = "maintenance" THEN "maintenance"
                    -- Check if seat is booked via passengers table for this schedule
                    WHEN p.id IS NOT NULL THEN "booked"
                    -- Check if seat status is manually set to booked (legacy)
                    WHEN s.status = "booked" THEN "booked"
                    -- Otherwise available
                    ELSE "available"
                END as booking_status
            FROM seats s
            LEFT JOIN passengers p ON s.id = p.seat_id 
                AND p.booking_id IN (
                    SELECT id FROM bookings 
                    WHERE schedule_id = :schedule_id 
                    AND booking_status IN ("pending", "confirmed")
                    AND (payment_expiry IS NULL OR payment_expiry > NOW())
                )
            WHERE s.bus_id = :bus_id
            ORDER BY s.seat_number ASC
        ');

        $this->db->bind(':schedule_id', $schedule_id);
        $this->db->bind(':bus_id', $bus_id);

        return $this->db->fetchAll();
    }

    /**
     * Check if seats are available for booking
     * 
     * @param array $seat_ids Array of seat IDs
     * @param int $schedule_id Schedule ID
     * @return bool True if all seats are available
     */
    public function checkSeatsAvailability($seat_ids, $schedule_id)
    {
        if (empty($seat_ids)) {
            return false;
        }

        $placeholders = implode(',', array_fill(0, count($seat_ids), '?'));

        $this->db->prepare("
            SELECT COUNT(*) as booked_count
            FROM passengers p
            JOIN bookings b ON p.booking_id = b.id
            WHERE p.seat_id IN ($placeholders)
            AND b.schedule_id = ?
            AND b.booking_status IN ('pending', 'confirmed')
            AND (b.payment_expiry IS NULL OR b.payment_expiry > NOW())
        ");

        // Bind seat IDs
        $paramIndex = 1;
        foreach ($seat_ids as $seat_id) {
            $this->db->bind($paramIndex, $seat_id);
            $paramIndex++;
        }

        // Bind schedule_id
        $this->db->bind($paramIndex, $schedule_id);

        $result = $this->db->fetch();

        // Return true if no seats are booked (all available)
        return ($result['booked_count'] == 0);
    }

    /**
     * Update seat status
     * 
     * @param int $seat_id Seat ID
     * @param string $status New status (available|booked|maintenance)
     * @return bool Success status
     */
    public function updateStatus($seat_id, $status)
    {
        $this->db->prepare('UPDATE seats SET status = :status WHERE id = :id');
        $this->db->bind(':status', $status);
        $this->db->bind(':id', $seat_id);
        return $this->db->execute();
    }

    /**
     * Update multiple seats status
     * 
     * @param array $seat_ids Array of seat IDs
     * @param string $status New status (available|booked|maintenance)
     * @return bool Success status
     */
    public function updateMultipleStatus($seat_ids, $status)
    {
        if (empty($seat_ids)) {
            return false;
        }

        $placeholders = implode(',', array_fill(0, count($seat_ids), '?'));
        $this->db->prepare("UPDATE seats SET status = ? WHERE id IN ($placeholders)");

        $this->db->bind(1, $status);
        foreach ($seat_ids as $index => $seat_id) {
            $this->db->bind($index + 2, $seat_id);
        }

        return $this->db->execute();
    }
}
