<?php

class UserController extends Controller
{
    protected $bookingModel;
    protected $paymentModel;
    protected $seatModel;
    protected $scheduleModel;

    public function __construct()
    {
        $this->bookingModel = $this->model('BookingModel');
        $this->paymentModel = $this->model('PaymentModel');
        $this->seatModel = $this->model('SeatModel');
        $this->scheduleModel = $this->model('ScheduleModel');
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

        // Update password (send plain password, model will hash it)
        $result = $userModel->update($_SESSION['user_id'], ['password' => $newPassword]);

        if ($result) {
            $_SESSION['success'] = 'Password berhasil diubah';
        } else {
            $_SESSION['error'] = 'Gagal mengubah password';
        }

        header('Location: ' . BASEURL . 'user/profile');
        exit;
    }

    /**
     * Cancel booking
     * User can cancel their own booking
     */
    public function cancel($booking_id)
    {
        // Set JSON header
        header('Content-Type: application/json');

        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            echo json_encode([
                'success' => false,
                'message' => 'Silakan login terlebih dahulu'
            ]);
            exit;
        }

        // Validate booking_id
        $booking_id = (int)$booking_id;
        if ($booking_id <= 0) {
            echo json_encode([
                'success' => false,
                'message' => 'ID booking tidak valid'
            ]);
            exit;
        }

        // Get booking
        $booking = $this->bookingModel->findById($booking_id);

        if (!$booking) {
            echo json_encode([
                'success' => false,
                'message' => 'Booking tidak ditemukan'
            ]);
            exit;
        }

        // Check if booking belongs to current user
        if ($booking['user_id'] != $_SESSION['user_id']) {
            echo json_encode([
                'success' => false,
                'message' => 'Anda tidak memiliki akses ke booking ini'
            ]);
            exit;
        }

        // Check if booking can be cancelled
        if ($booking['booking_status'] !== 'pending' && $booking['booking_status'] !== 'confirmed') {
            echo json_encode([
                'success' => false,
                'message' => 'Booking ini tidak dapat dibatalkan'
            ]);
            exit;
        }

        // Check if already cancelled
        if ($booking['booking_status'] === 'cancelled') {
            echo json_encode([
                'success' => false,
                'message' => 'Booking sudah dibatalkan sebelumnya'
            ]);
            exit;
        }

        // Get payment info
        $payment = $this->paymentModel->getByBookingId($booking_id);

        // Check if payment is already paid
        $isPaid = ($payment && $payment['payment_status'] === 'paid');

        // Update booking status to cancelled
        $result = $this->bookingModel->update($booking_id, [
            'booking_status' => 'cancelled'
        ]);

        if (!$result) {
            echo json_encode([
                'success' => false,
                'message' => 'Gagal membatalkan booking'
            ]);
            exit;
        }

        // Release seats back to available
        $passengers = $this->bookingModel->getPassengers($booking_id);
        $seat_ids = [];
        foreach ($passengers as $passenger) {
            if (!empty($passenger['seat_id'])) {
                $seat_ids[] = $passenger['seat_id'];
            }
        }

        if (!empty($seat_ids)) {
            $this->seatModel->updateMultipleStatus($seat_ids, 'available');
        }

        // Update available seats in schedule
        $schedule = $this->scheduleModel->findById($booking['schedule_id']);
        if ($schedule) {
            $new_available = $schedule['available_seats'] + $booking['total_passengers'];
            $this->scheduleModel->updateAvailableSeats($booking['schedule_id'], $new_available);
        }

        // Prepare response message
        $message = 'Booking berhasil dibatalkan';

        if ($isPaid) {
            $message .= '. Pembayaran Anda sudah diterima dan akan diproses untuk pengembalian dana (refund) oleh admin dalam waktu 2x24 jam.';
        }

        echo json_encode([
            'success' => true,
            'message' => $message,
            'refund_needed' => $isPaid
        ]);
        exit;
    }
}
