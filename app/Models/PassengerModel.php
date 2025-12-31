<?php

class PassengerModel
{
    protected $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getByBooking($booking_id)
    {
        $this->db->prepare('SELECT p.*, s.seat_number, s.seat_type FROM passengers p LEFT JOIN seats s ON p.seat_id = s.id WHERE p.booking_id = :bid ORDER BY p.id ASC');
        $this->db->bind(':bid', $booking_id);
        return $this->db->fetchAll();
    }

    public function findById($id)
    {
        $this->db->prepare('SELECT * FROM passengers WHERE id = :id LIMIT 1');
        $this->db->bind(':id', $id);
        return $this->db->fetch();
    }

    public function create($data)
    {
        $this->db->prepare('INSERT INTO passengers (booking_id, seat_id, full_name, id_card_type, id_card_number, phone, created_at) VALUES (:booking_id, :seat_id, :full_name, :id_card_type, :id_card_number, :phone, :created_at)');
        $this->db->bind(':booking_id', $data['booking_id']);
        $this->db->bind(':seat_id', $data['seat_id'] ?? null);
        $this->db->bind(':full_name', $data['full_name']);
        $this->db->bind(':id_card_type', $data['id_card_type'] ?? 'ktp');
        $this->db->bind(':id_card_number', $data['id_card_number'] ?? null);
        $this->db->bind(':phone', $data['phone'] ?? null);
        $this->db->bind(':created_at', date('Y-m-d H:i:s'));
        return $this->db->execute();
    }

    public function delete($id)
    {
        $this->db->prepare('DELETE FROM passengers WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function deleteByBooking($booking_id)
    {
        $this->db->prepare('DELETE FROM passengers WHERE booking_id = :bid');
        $this->db->bind(':bid', $booking_id);
        return $this->db->execute();
    }
}
