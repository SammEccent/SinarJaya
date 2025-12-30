<?php

class RouteModel
{
    protected $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAll()
    {
        $this->db->prepare('SELECT * FROM routes ORDER BY route_id DESC');
        return $this->db->fetchAll();
    }

    public function findById($id)
    {
        $this->db->prepare('SELECT * FROM routes WHERE route_id = :id LIMIT 1');
        $this->db->bind(':id', $id);
        return $this->db->fetch();
    }

    public function getRouteLocations($route_id)
    {
        $this->db->prepare('
            SELECT rl.route_location_id, rl.route_id, rl.location_id, rl.fungsi, rl.sequence,
                   l.location_name, l.city, l.type, l.address
            FROM route_location rl
            JOIN location l ON rl.location_id = l.location_id
            WHERE rl.route_id = :route_id
            ORDER BY rl.sequence ASC
        ');
        $this->db->bind(':route_id', $route_id);
        return $this->db->fetchAll();
    }

    public function create($data)
    {
        $this->db->prepare('INSERT INTO routes (origin_city, destination_city, route_code, status, created_at) VALUES (:origin, :destination, :code, :status, :created_at)');
        $this->db->bind(':origin', $data['origin_city']);
        $this->db->bind(':destination', $data['destination_city']);
        $this->db->bind(':code', $data['route_code']);
        $this->db->bind(':status', $data['status'] ?? 'active');
        $this->db->bind(':created_at', date('Y-m-d H:i:s'));
        return $this->db->execute();
    }

    public function update($id, $data)
    {
        $this->db->prepare('UPDATE routes SET origin_city = :origin, destination_city = :destination, route_code = :code, status = :status WHERE route_id = :id');
        $this->db->bind(':origin', $data['origin_city']);
        $this->db->bind(':destination', $data['destination_city']);
        $this->db->bind(':code', $data['route_code']);
        $this->db->bind(':status', $data['status'] ?? 'active');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function delete($id)
    {
        // Delete route locations first (cascade)
        $this->db->prepare('DELETE FROM route_location WHERE route_id = :id');
        $this->db->bind(':id', $id);
        $this->db->execute();

        // Delete the route
        $this->db->prepare('DELETE FROM routes WHERE route_id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    // Route Location management
    public function addRouteLocation($route_id, $location_id, $fungsi, $sequence)
    {
        $this->db->prepare('INSERT INTO route_location (route_id, location_id, fungsi, sequence) VALUES (:route_id, :location_id, :fungsi, :sequence)');
        $this->db->bind(':route_id', $route_id);
        $this->db->bind(':location_id', $location_id);
        $this->db->bind(':fungsi', $fungsi);
        $this->db->bind(':sequence', $sequence);
        return $this->db->execute();
    }

    public function removeRouteLocation($route_location_id)
    {
        $this->db->prepare('DELETE FROM route_location WHERE route_location_id = :id');
        $this->db->bind(':id', $route_location_id);
        return $this->db->execute();
    }

    public function updateRouteLocation($route_location_id, $fungsi, $sequence)
    {
        $this->db->prepare('UPDATE route_location SET fungsi = :fungsi, sequence = :sequence WHERE route_location_id = :id');
        $this->db->bind(':fungsi', $fungsi);
        $this->db->bind(':sequence', $sequence);
        $this->db->bind(':id', $route_location_id);
        return $this->db->execute();
    }
}
