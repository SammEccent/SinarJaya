<?php

class UserModel
{
    protected $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // Find a user by email
    public function findByEmail($email)
    {
        $this->db->prepare('SELECT * FROM users WHERE email = :email LIMIT 1');
        $this->db->bind(':email', $email);
        return $this->db->fetch();
    }

    // Verify password (plain password + hashed from DB)
    public function verifyPassword($plainPassword, $hashedPassword)
    {
        return password_verify($plainPassword, $hashedPassword);
    }
}
