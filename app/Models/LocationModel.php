<?php

class LocationModel
{
    protected $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAll()
    {
        $this->db->prepare('SELECT * FROM location ORDER BY location_id DESC');
        return $this->db->fetchAll();
    }

    public function findById($id)
    {
        $this->db->prepare('SELECT * FROM location WHERE location_id = :id LIMIT 1');
        $this->db->bind(':id', $id);
        return $this->db->fetch();
    }

    public function getByCity($city)
    {
        $this->db->prepare('SELECT * FROM location WHERE city = :city ORDER BY location_name ASC');
        $this->db->bind(':city', $city);
        return $this->db->fetchAll();
    }

    public function getByType($type)
    {
        $this->db->prepare('SELECT * FROM location WHERE type = :type ORDER BY location_name ASC');
        $this->db->bind(':type', $type);
        return $this->db->fetchAll();
    }

    public function create($data)
    {
        $this->db->prepare('INSERT INTO location (location_name, city, type, address, created_at) VALUES (:name, :city, :type, :address, :created_at)');
        $this->db->bind(':name', $data['location_name']);
        $this->db->bind(':city', $data['city']);
        $this->db->bind(':type', $data['type']);
        $this->db->bind(':address', $data['address'] ?? null);
        $this->db->bind(':created_at', date('Y-m-d H:i:s'));
        return $this->db->execute();
    }

    public function update($id, $data)
    {
        $this->db->prepare('UPDATE location SET location_name = :name, city = :city, type = :type, address = :address WHERE location_id = :id');
        $this->db->bind(':name', $data['location_name']);
        $this->db->bind(':city', $data['city']);
        $this->db->bind(':type', $data['type']);
        $this->db->bind(':address', $data['address'] ?? null);
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function delete($id)
    {
        $this->db->prepare('DELETE FROM location WHERE location_id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
