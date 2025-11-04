<?php
defined('BASEURL') or exit('No direct script access allowed');

class CityModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getDepartureCities()
    {
        $this->db->prepare('SELECT DISTINCT departure_city FROM schedules WHERE is_active = 1 ORDER BY departure_city ASC');
        return array_column($this->db->fetchAll(), 'departure_city');
    }

    public function getDestinationCities()
    {
        $this->db->prepare('SELECT DISTINCT destination_city FROM schedules WHERE is_active = 1 ORDER BY destination_city ASC');
        return array_column($this->db->fetchAll(), 'destination_city');
    }

    public function getAvailableRoutes()
    {
        $this->db->prepare('
            SELECT 
                departure_city,
                destination_city,
                MIN(price) as start_price
            FROM schedules 
            WHERE is_active = 1 
            GROUP BY departure_city, destination_city
            ORDER BY departure_city, destination_city
        ');
        return $this->db->fetchAll();
    }
}
