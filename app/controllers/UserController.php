<?php

class UserController extends Controller
{
    protected $bookingModel;
    protected $paymentModel;

    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $this->bookingModel = $this->model('BookingModel');
        $this->paymentModel = $this->model('PaymentModel');
    }

    /**
     * Show user dashboard
     */
    public function index()
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Silakan login terlebih dahulu';
            header('Location: ' . BASEURL . 'auth/login');
            exit;
        }

        $this->bookings();
    }

    /**
     * Show user bookings list
     */
    public function bookings()
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Silakan login terlebih dahulu';
            header('Location: ' . BASEURL . 'auth/login');
            exit;
        }

        // Check and update expired bookings
        $this->bookingModel->checkAndUpdateExpiredBookings();

        // Get user bookings
        $bookings = $this->bookingModel->getByUserId($_SESSION['user_id']);

        $data = [
            'title' => 'Pesanan Saya',
            'bookings' => $bookings
        ];

        $this->renderWithLayout('user/bookings', $data);
    }

    /**
     * Show booking detail
     */
    public function booking($booking_id)
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Silakan login terlebih dahulu';
            header('Location: ' . BASEURL . 'auth/login');
            exit;
        }

        $booking_id = (int)$booking_id;
        $booking = $this->bookingModel->findById($booking_id);

        if (!$booking) {
            $_SESSION['error'] = 'Booking tidak ditemukan';
            header('Location: ' . BASEURL . 'user/bookings');
            exit;
        }

        // Check if booking belongs to current user
        if ($booking['user_id'] != $_SESSION['user_id']) {
            $_SESSION['error'] = 'Anda tidak memiliki akses ke booking ini';
            header('Location: ' . BASEURL . 'user/bookings');
            exit;
        }

        // Get passengers
        $passengers = $this->bookingModel->getPassengers($booking_id);

        // Get payment if exists
        $payment = $this->paymentModel->getByBookingId($booking_id);

        $data = [
            'title' => 'Detail Pesanan',
            'booking' => $booking,
            'passengers' => $passengers,
            'payment' => $payment
        ];

        $this->renderWithLayout('user/booking-detail', $data);
    }

    /**
     * Show user profile
     */
    public function profile()
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Silakan login terlebih dahulu';
            header('Location: ' . BASEURL . 'auth/login');
            exit;
        }

        // Get user model
        $userModel = $this->model('UserModel');
        $user = $userModel->findById($_SESSION['user_id']);

        if (!$user) {
            $_SESSION['error'] = 'User tidak ditemukan';
            header('Location: ' . BASEURL);
            exit;
        }

        $data = [
            'title' => 'Profil Saya',
            'user' => $user
        ];

        $this->renderWithLayout('user/profile', $data);
    }

    /**
     * Update user profile
     */
    public function updateProfile()
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Silakan login terlebih dahulu';
            header('Location: ' . BASEURL . 'auth/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASEURL . 'user/profile');
            exit;
        }

        $userModel = $this->model('UserModel');

        // Validate input
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');

        $errors = [];

        if (empty($name)) {
            $errors[] = 'Nama harus diisi';
        }

        if (empty($email)) {
            $errors[] = 'Email harus diisi';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Format email tidak valid';
        } else {
            // Check if email already used by other user
            $existingUser = $userModel->findByEmail($email);
            if ($existingUser && $existingUser['id'] != $_SESSION['user_id']) {
                $errors[] = 'Email sudah digunakan oleh user lain';
            }
        }

        if (empty($phone)) {
            $errors[] = 'No HP harus diisi';
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;
            header('Location: ' . BASEURL . 'user/profile');
            exit;
        }

        // Update profile
        $updateData = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone
        ];

        $result = $userModel->update($_SESSION['user_id'], $updateData);

        if ($result) {
            // Update session data
            $_SESSION['user_name'] = $name;
            $_SESSION['user_email'] = $email;

            $_SESSION['success'] = 'Profil berhasil diperbarui';
        } else {
            $_SESSION['error'] = 'Gagal memperbarui profil';
        }

        header('Location: ' . BASEURL . 'user/profile');
        exit;
    }

    /**
     * Change password
     */
    public function changePassword()
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Silakan login terlebih dahulu';
            header('Location: ' . BASEURL . 'auth/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASEURL . 'user/profile');
            exit;
        }

        $userModel = $this->model('UserModel');
        $user = $userModel->findById($_SESSION['user_id']);

        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        $errors = [];

        if (empty($currentPassword)) {
            $errors[] = 'Password saat ini harus diisi';
        } elseif (!password_verify($currentPassword, $user['password'])) {
            $errors[] = 'Password saat ini tidak sesuai';
        }

        if (empty($newPassword)) {
            $errors[] = 'Password baru harus diisi';
        } elseif (strlen($newPassword) < 6) {
            $errors[] = 'Password baru minimal 6 karakter';
        }

        if ($newPassword !== $confirmPassword) {
            $errors[] = 'Konfirmasi password tidak sesuai';
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header('Location: ' . BASEURL . 'user/profile');
            exit;
        }

        // Update password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $result = $userModel->update($_SESSION['user_id'], ['password' => $hashedPassword]);

        if ($result) {
            $_SESSION['success'] = 'Password berhasil diubah';
        } else {
            $_SESSION['error'] = 'Gagal mengubah password';
        }

        header('Location: ' . BASEURL . 'user/profile');
        exit;
    }

    /**
     * Render view with layout
     */
    private function renderWithLayout($view, $data = [])
    {
        extract($data);
        ob_start();
        require_once '../app/Views/' . $view . '.php';
        $content = ob_get_clean();
        require_once '../app/Views/layouts/main.php';
    }
}
