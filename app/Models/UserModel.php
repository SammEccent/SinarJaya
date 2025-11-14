<?php

class UserModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // Find user by email
    public function findUserByEmail($email)
    {
        $this->db->prepare("SELECT * FROM user WHERE email = :email");
        $this->db->bind(':email', $email);
        $this->db->execute();
        return $this->db->fetch();
    }

    // Create new user
    public function createUser($data)
    {
        // Cek: Pastikan $data adalah array
        if (!is_array($data)) {
            throw new InvalidArgumentException("Data must be an array.");
        }

        $this->db->prepare("INSERT INTO user (fullname, email, nik, tanggal_lahir, password) VALUES (:fullname, :email, :nik, :tanggal_lahir, :password)");
        $this->db->bind(':fullname', $data['fullname']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':nik', $data['nik']);
        $this->db->bind(':tanggal_lahir', $data['tanggal_lahir']);
        $this->db->bind(':password', $data['password']);
        return $this->db->execute();
    }

    // Find user by ID
    public function findUserById($id)
    {
        $this->db->prepare("SELECT * FROM user WHERE id = :id");
        $this->db->bind(':id', $id);
        $this->db->execute();
        return $this->db->fetch();
    }

    // Update user data
    public function updateUser($data)
    {
        $this->db->prepare("UPDATE user SET fullname = :fullname, nik = :nik, tanggal_lahir = :tanggal_lahir WHERE id = :id");
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':fullname', $data['fullname']);
        $this->db->bind(':nik', $data['nik']);
        $this->db->bind(':tanggal_lahir', $data['tanggal_lahir']);
        return $this->db->execute();
    }

    // Update user password
    public function updatePassword($id, $password)
    {
        $this->db->prepare("UPDATE user SET password = :password WHERE id = :id");
        $this->db->bind(':id', $id);
        $this->db->bind(':password', $password);
        return $this->db->execute();
    }

    // Save password reset token
    public function savePasswordResetToken($email, $token)
    {
        $this->db->prepare("UPDATE user SET reset_token = :token, reset_token_expires_at = DATE_ADD(NOW(), INTERVAL 15 MINUTE) WHERE email = :email");
        $this->db->bind(':token', $token);
        $this->db->bind(':email', $email);
        $result = $this->db->execute();
        error_log("UserModel: savePasswordResetToken result: " . ($result ? 'true' : 'false'));
        return $result;
    }

    // Find user by reset token
    public function findUserByResetToken($token)
    {
        // Tambahkan pengecekan untuk memastikan token tidak kosong sebelum melakukan kueri
        if (empty($token)) {
            error_log("UserModel: findUserByResetToken was called with an empty token.");
            return false;
        }

        $this->db->prepare("SELECT * FROM user WHERE reset_token = :token");
        $this->db->bind(':token', $token);
        $this->db->execute();
        $user = $this->db->fetch();
        error_log("UserModel: findUserByResetToken result: " . ($user ? 'User found' : 'No user found'));
        return $user;
    }

    // Clear password reset token by the token itself
    public function clearPasswordResetToken($token)
    {
        if (empty($token)) {
            return false;
        }
        $this->db->prepare("UPDATE user SET reset_token = NULL, reset_token_expires_at = NULL WHERE reset_token = :token");
        $this->db->bind(':token', $token);
        return $this->db->execute();
    }
}
