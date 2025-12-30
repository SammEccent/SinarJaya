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
        $this->db->prepare('SELECT * FROM seats WHERE bus_id = :bus_id ORDER BY id ASC');
        $this->db->bind(':bus_id', $bus_id);
        return $this->db->fetchAll();
    }

    public function findById($id)
    {
        $this->db->prepare('SELECT * FROM seats WHERE id = :id LIMIT 1');
        $this->db->bind(':id', $id);
        return $this->db->fetch();
    }

    public function create($bus_id, $seat_number, $type = 'regular', $price_adjustment = 0)
    {
        $this->db->prepare('INSERT INTO seats (bus_id, seat_number, seat_type, price_adjustment, status) VALUES (:bus_id, :seat_number, :seat_type, :price_adjustment, :status)');
        $this->db->bind(':bus_id', $bus_id);
        $this->db->bind(':seat_number', $seat_number);
        $this->db->bind(':seat_type', $type);
        $this->db->bind(':price_adjustment', $price_adjustment);
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
}
