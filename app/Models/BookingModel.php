<?php

class BookingModel
{
    protected $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAll()
    {
        $this->db->prepare('SELECT b.*, u.name AS user_name, u.email AS user_email, s.departure_datetime, s.arrival_datetime, r.route_code FROM bookings b JOIN users u ON b.user_id = u.id JOIN schedules s ON b.schedule_id = s.id JOIN routes r ON s.route_id = r.route_id ORDER BY b.created_at DESC');
        return $this->db->fetchAll();
    }

    public function findById($id)
    {
        $this->db->prepare('SELECT b.*, u.name AS user_name, u.email AS user_email, s.departure_datetime, s.arrival_datetime, r.route_code, r.origin_city, r.destination_city FROM bookings b JOIN users u ON b.user_id = u.id JOIN schedules s ON b.schedule_id = s.id JOIN routes r ON s.route_id = r.route_id WHERE b.id = :id LIMIT 1');
        $this->db->bind(':id', $id);
        $booking = $this->db->fetch();

        if ($booking) {
            // fetch passengers
            $this->db->prepare('SELECT * FROM passengers WHERE booking_id = :bid');
            $this->db->bind(':bid', $id);
            $booking['passengers'] = $this->db->fetchAll();

            // fetch payment
            $this->db->prepare('SELECT * FROM payments WHERE booking_id = :bid ORDER BY created_at DESC LIMIT 1');
            $this->db->bind(':bid', $id);
            $booking['payment'] = $this->db->fetch();
        }

        return $booking;
    }

    public function create($data)
    {
        $this->db->prepare('INSERT INTO bookings (booking_code, user_id, schedule_id, total_passengers, total_amount, booking_status, payment_expiry, notes, created_at, updated_at) VALUES (:code, :user_id, :schedule_id, :total_passengers, :total_amount, :status, :payment_expiry, :notes, :created_at, :updated_at)');
        $this->db->bind(':code', $data['booking_code']);
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':schedule_id', $data['schedule_id']);
        $this->db->bind(':total_passengers', $data['total_passengers']);
        $this->db->bind(':total_amount', $data['total_amount']);
        $this->db->bind(':status', $data['booking_status'] ?? 'pending');
        $this->db->bind(':payment_expiry', $data['payment_expiry'] ?? null);
        $this->db->bind(':notes', $data['notes'] ?? null);
        $this->db->bind(':created_at', date('Y-m-d H:i:s'));
        $this->db->bind(':updated_at', date('Y-m-d H:i:s'));
        return $this->db->execute();
    }

    public function updateStatus($id, $status)
    {
        $this->db->prepare('UPDATE bookings SET booking_status = :status, updated_at = :updated WHERE id = :id');
        $this->db->bind(':status', $status);
        $this->db->bind(':updated', date('Y-m-d H:i:s'));
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function update($id, $data)
    {
        $this->db->prepare('UPDATE bookings SET booking_status = :status, notes = :notes, updated_at = :updated WHERE id = :id');
        $this->db->bind(':status', $data['booking_status'] ?? 'pending');
        $this->db->bind(':notes', $data['notes'] ?? null);
        $this->db->bind(':updated', date('Y-m-d H:i:s'));
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function delete($id)
    {
        // delete payments first
        $this->db->prepare('DELETE FROM payments WHERE booking_id = :id');
        $this->db->bind(':id', $id);
        $this->db->execute();

        // delete passengers
        $this->db->prepare('DELETE FROM passengers WHERE booking_id = :id');
        $this->db->bind(':id', $id);
        $this->db->execute();

        // delete booking
        $this->db->prepare('DELETE FROM bookings WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
