<?php

class User
{
    private $db;
    private $table = 'user';

    public function __construct()
    {
        try {
            $this->db = new PDO("mysql:host=localhost;dbname=bus_ticket_db", "root", "");
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function findByUsername($username)
    {
        try {
            $query = "SELECT * FROM {$this->table} WHERE username = :username AND active = 1";
            $stmt = $this->db->prepare($query);
            $stmt->execute(['username' => $username]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database error in findByUsername: " . $e->getMessage());
            return false;
        }
    }

    public function verifyPassword($password, $hashedPassword)
    {
        return password_verify($password, $hashedPassword);
    }

    public function createUser($data)
    {
        try {
            $query = "INSERT INTO {$this->table} (username, password, email, created_at) 
                     VALUES (:username, :password, :email, NOW())";

            $stmt = $this->db->prepare($query);
            return $stmt->execute([
                'username' => $data['username'],
                'password' => password_hash($data['password'], PASSWORD_DEFAULT),
                'email' => $data['email'] ?? null
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function updateUser($userId, $data)
    {
        try {
            $query = "UPDATE {$this->table} SET ";
            $params = [];

            foreach ($data as $key => $value) {
                if ($key === 'password') {
                    $value = password_hash($value, PASSWORD_DEFAULT);
                }
                $query .= "$key = :$key, ";
                $params[$key] = $value;
            }

            $query = rtrim($query, ", ");
            $query .= " WHERE id = :id";
            $params['id'] = $userId;

            $stmt = $this->db->prepare($query);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getUserById($userId)
    {
        try {
            $query = "SELECT * FROM {$this->table} WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->execute(['id' => $userId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }
}
