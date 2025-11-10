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
    public function savePasswordResetToken($email, $token, $expires)
    {
        error_log("UserModel: Saving token for email: {$email}, token: {$token}, expires: {$expires}");
        $this->db->prepare("UPDATE user SET reset_token = :token, reset_token_expires_at = :expires WHERE email = :email");
        $this->db->bind(':token', $token);
        $this->db->bind(':expires', $expires);
        $this->db->bind(':email', $email);
        $result = $this->db->execute();
        error_log("UserModel: savePasswordResetToken result: " . ($result ? 'true' : 'false'));
        return $result;
    }

    // Find user by reset token
    public function findUserByResetToken($token)
    {
        error_log("UserModel: Searching user by reset token: {$token}");
        $this->db->prepare("SELECT * FROM user WHERE reset_token = :token AND reset_token_expires_at > NOW()");
        $this->db->bind(':token', $token);
        $this->db->execute();
        $user = $this->db->fetch();
        error_log("UserModel: findUserByResetToken result: " . ($user ? 'User found' : 'No user found or token expired'));
        return $user;
    }
}
