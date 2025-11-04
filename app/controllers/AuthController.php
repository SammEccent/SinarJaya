<?php
require_once __DIR__ . '/../models/User.php';

class AuthController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function login()
    {
        // Start session at the beginning
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $this->sanitizeInput($_POST['username']);
            $password = $_POST['password'];

            // Validate input
            if (empty($username) || empty($password)) {
                $_SESSION['error'] = "Username and password are required";
                header('Location: /auth/login');
                exit();
            }

            // Query the database using User model
            $user = $this->userModel->findByUsername($username);

            // Verify password
            if ($user && $this->userModel->verifyPassword($password, $user['password'])) {
                // Start session and store user data
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];

                // Redirect to main page
                header('Location: /main');
                exit();
            } else {
                $_SESSION['error'] = "Invalid username or password";
                header('Location: /auth/login');
                exit();
            }
        } else {
            // Show login form for GET requests
            require_once __DIR__ . '/../views/auth/login.php';
        }
    }

    public function logout()
    {
        // Destroy session and redirect to login
        session_start();
        session_destroy();
        header('Location: /auth/login');
        exit();
    }

    private function sanitizeInput($input)
    {
        return htmlspecialchars(strip_tags(trim($input)));
    }
}
