<?php

class UserModel
{
    protected $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    /**
     * Get all users
     */
    public function getAll()
    {
        $this->db->prepare('SELECT * FROM users ORDER BY created_at DESC');
        return $this->db->fetchAll();
    }

    /**
     * Get all verified users
     */
    public function getVerifiedUsers()
    {
        $this->db->prepare('SELECT * FROM users WHERE is_verified = 1 ORDER BY created_at DESC');
        return $this->db->fetchAll();
    }

    /**
     * Get filtered verified users
     */
    public function getFilteredVerifiedUsers($searchTerm)
    {
        $this->db->prepare('SELECT * FROM users WHERE is_verified = 1 AND (name LIKE :searchTerm OR email LIKE :searchTerm) ORDER BY created_at DESC');
        $this->db->bind(':searchTerm', '%' . $searchTerm . '%');
        return $this->db->fetchAll();
    }

    /**
     * Get a single user by ID
     */
    public function findById($id)
    {
        $this->db->prepare('SELECT * FROM users WHERE id = :id LIMIT 1');
        $this->db->bind(':id', $id);
        return $this->db->fetch();
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

    /**
     * Create a new user
     */
    public function create($data)
    {
        $this->db->prepare('
            INSERT INTO users (name, email, phone, password, role, is_verified, verification_token) 
            VALUES (:name, :email, :phone, :password, :role, :is_verified, :verification_token)
        ');
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':phone', $data['phone']);
        $this->db->bind(':password', password_hash($data['password'], PASSWORD_DEFAULT));
        $this->db->bind(':role', $data['role'] ?? 'user');
        $this->db->bind(':is_verified', $data['is_verified'] ?? 0);
        $this->db->bind(':verification_token', $data['verification_token'] ?? null);

        return $this->db->execute();
    }

    /**
     * Find user by verification token
     */
    public function findByVerificationToken($token)
    {
        $this->db->prepare('SELECT * FROM users WHERE verification_token = :token AND is_verified = 0 LIMIT 1');
        $this->db->bind(':token', $token);
        return $this->db->fetch();
    }

    /**
     * Verify user by token
     */
    public function verifyByToken($token)
    {
        $this->db->prepare('UPDATE users SET is_verified = 1, verification_token = NULL WHERE verification_token = :token');
        $this->db->bind(':token', $token);
        return $this->db->execute();
    }

    /**
     * Update verification token for a user
     */
    public function updateVerificationToken($userId, $token)
    {
        $this->db->prepare('UPDATE users SET verification_token = :token WHERE id = :id');
        $this->db->bind(':id', $userId);
        $this->db->bind(':token', $token);
        return $this->db->execute();
    }

    /**
     * Update an existing user
     */
    public function update($id, $data)
    {
        // Build dynamic SET clause based on provided data
        $setClause = [];
        $allowedFields = ['name', 'email', 'phone', 'role', 'is_verified', 'password'];

        foreach ($data as $key => $value) {
            if (in_array($key, $allowedFields)) {
                $setClause[] = "$key = :$key";
            }
        }

        if (empty($setClause)) {
            return false; // No valid fields to update
        }

        $sql = 'UPDATE users SET ' . implode(', ', $setClause) . ' WHERE id = :id';
        $this->db->prepare($sql);

        $this->db->bind(':id', $id);

        foreach ($data as $key => $value) {
            if (in_array($key, $allowedFields)) {
                if ($key === 'password') {
                    $this->db->bind(':password', password_hash($value, PASSWORD_DEFAULT));
                } else {
                    $this->db->bind(":$key", $value);
                }
            }
        }

        return $this->db->execute();
    }

    /**
     * Delete a user
     */
    public function delete($id)
    {
        $this->db->prepare('DELETE FROM users WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function count()
    {
        $this->db->prepare('SELECT COUNT(*) as total FROM users');
        $result = $this->db->fetch();
        return $result['total'] ?? 0;
    }
}
