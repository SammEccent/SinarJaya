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
        $this->db->prepare('SELECT s.*, b.plate_number, r.route_code, r.origin_city, r.destination_city FROM schedules s JOIN buses b ON s.bus_id = b.id JOIN routes r ON s.route_id = r.route_id ORDER BY s.departure_datetime DESC');
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

        $this->db->prepare('INSERT INTO schedules (bus_id, route_id, departure_datetime, arrival_datetime, base_price, available_seats, status, notes, created_at) VALUES (:bus_id, :route_id, :departure, :arrival, :base_price, :available_seats, :status, :notes, :created_at)');
        $this->db->bind(':bus_id', $bus_id);
        $this->db->bind(':route_id', $data['route_id']);
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

        $this->db->prepare('UPDATE schedules SET bus_id = :bus_id, route_id = :route_id, departure_datetime = :departure, arrival_datetime = :arrival, base_price = :base_price, available_seats = :available_seats, status = :status, notes = :notes WHERE id = :id');
        $this->db->bind(':bus_id', $bus_id);
        $this->db->bind(':route_id', $data['route_id']);
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
}
