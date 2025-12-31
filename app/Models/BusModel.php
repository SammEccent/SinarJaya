<?php

class BusModel
{
    protected $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAll()
    {
        $this->db->prepare('SELECT buses.*, bus_classes.name AS class_name, bus_classes.description AS class_description, bus_classes.facilities AS class_facilities FROM buses JOIN bus_classes ON buses.bus_class_id = bus_classes.id ORDER BY buses.id DESC');
        return $this->db->fetchAll();
    }

    public function findById($id)
    {
        $this->db->prepare('SELECT buses.*, bus_classes.name AS class_name, bus_classes.description AS class_description, bus_classes.facilities AS class_facilities FROM buses JOIN bus_classes ON buses.bus_class_id = bus_classes.id WHERE buses.id = :id LIMIT 1');
        $this->db->bind(':id', $id);
        return $this->db->fetch();
    }

    public function create($data)
    {
        $this->db->prepare('INSERT INTO buses (plate_number, bus_class_id, operator_id, total_seats, seat_layout, facilities, status, created_at) VALUES (:plate, :bus_class_id, :operator_id, :total_seats, :seat_layout, :facilities, :status, :created_at)');
        $this->db->bind(':plate', $data['plate_number']);
        $this->db->bind(':bus_class_id', $data['bus_class_id'] ?? 1);
        $this->db->bind(':operator_id', $data['operator_id'] ?? null);
        $this->db->bind(':total_seats', $data['total_seats']);
        $this->db->bind(':seat_layout', $data['seat_layout'] ?? '2-2');
        $this->db->bind(':facilities', $data['facilities'] ?? '');
        $this->db->bind(':status', $data['status'] ?? 'active');
        $this->db->bind(':created_at', date('Y-m-d H:i:s'));
        return $this->db->execute();
    }

    public function update($id, $data)
    {
        $this->db->prepare('UPDATE buses SET plate_number = :plate, bus_class_id = :bus_class_id, operator_id = :operator_id, total_seats = :total_seats, seat_layout = :seat_layout, facilities = :facilities, status = :status WHERE id = :id');
        $this->db->bind(':plate', $data['plate_number']);
        $this->db->bind(':bus_class_id', $data['bus_class_id'] ?? 1);
        $this->db->bind(':operator_id', $data['operator_id'] ?? null);
        $this->db->bind(':total_seats', $data['total_seats']);
        $this->db->bind(':seat_layout', $data['seat_layout'] ?? '2-2');
        $this->db->bind(':facilities', $data['facilities'] ?? '');
        $this->db->bind(':status', $data['status'] ?? 'active');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function delete($id)
    {
        $this->db->prepare('DELETE FROM buses WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function count()
    {
        $this->db->prepare('SELECT COUNT(*) as total FROM buses');
        $result = $this->db->fetch();
        return $result['total'] ?? 0;
    }
}
