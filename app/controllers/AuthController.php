<?php

class AuthController extends Controller
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = $this->model('UserModel');
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    // Default to login form
    public function index()
    {
        $this->loginForm();
    }

    // Show login form
    public function loginForm()
    {
        $data = ['title' => 'Login'];
        $this->renderWithLayout('admin/login', $data);
    }

    // Handle login POST
    public function login()
    {
        // If request is not POST, show the login form (avoid redirect loop)
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->loginForm();
            return;
        }

        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';

        $errors = [];

        if (empty($email)) {
            $errors[] = 'Email harus diisi.';
        }
        if (empty($password)) {
            $errors[] = 'Password harus diisi.';
        }

        if (!empty($errors)) {
            $data = ['title' => 'Login', 'errors' => $errors, 'old' => ['email' => htmlspecialchars($email)]];
            $this->renderWithLayout('admin/login', $data);
            return;
        }

        $user = $this->userModel->findByEmail($email);

        if (!$user) {
            $errors[] = 'Email atau password salah.';
            $data = ['title' => 'Login', 'errors' => $errors, 'old' => ['email' => htmlspecialchars($email)]];
            $this->renderWithLayout('admin/login', $data);
            return;
        }

        // Only allow admin role for admin login
        if (!isset($user['role']) || $user['role'] !== 'admin') {
            $errors[] = 'Akses ditolak.';
            $data = ['title' => 'Login', 'errors' => $errors, 'old' => ['email' => htmlspecialchars($email)]];
            $this->renderWithLayout('admin/login', $data);
            return;
        }

        if (!$this->userModel->verifyPassword($password, $user['password'])) {
            $errors[] = 'Email atau password salah.';
            $data = ['title' => 'Login', 'errors' => $errors, 'old' => ['email' => htmlspecialchars($email)]];
            $this->renderWithLayout('admin/login', $data);
            return;
        }

        // success
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['role'] = $user['role'];

        // Render dashboard directly without header/footer
        if (file_exists('../app/Views/admin/dashboard.php')) {
            require_once '../app/Views/admin/dashboard.php';
        } else {
            die('Dashboard view not found');
        }
    }

    public function logout()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        unset($_SESSION['user_id'], $_SESSION['user_email'], $_SESSION['role']);
        session_destroy();

        header('Location: ' . BASEURL . 'auth/login');
        exit;
    }

    // Render helper (same pattern as other controllers)
    protected function renderWithLayout($view, $data = [])
    {
        extract($data);
        ob_start();
        if (file_exists('../app/Views/' . $view . '.php')) {
            require_once '../app/Views/' . $view . '.php';
        } else {
            die('View does not exist: ' . $view);
        }
        $content = ob_get_clean();
        if (file_exists('../app/Views/layouts/main.php')) {
            require_once '../app/Views/layouts/main.php';
        } else {
            die('Layout does not exist');
        }
    }
}
