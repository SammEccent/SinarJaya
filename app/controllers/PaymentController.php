<?php

class PaymentController extends Controller
{
    private $paymentModel;
    private $bookingModel;

    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $this->paymentModel = $this->model('PaymentModel');
        $this->bookingModel = $this->model('BookingModel');
    }

    /**
     * Display payment page for a booking
     */
    public function create()
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Silakan login terlebih dahulu';
            $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
            header('Location: ' . BASEURL . 'auth/login');
            exit;
        }

        // Check and update expired bookings
        $this->bookingModel->checkAndUpdateExpiredBookings();

        // Get booking_id from GET parameter
        $booking_id = isset($_GET['booking_id']) ? intval($_GET['booking_id']) : 0;

        if ($booking_id <= 0) {
            $_SESSION['error'] = 'ID booking tidak valid';
            header('Location: ' . BASEURL . 'user/bookings');
            exit;
        }

        // Get booking details
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

        // Check if booking is expired
        if ($booking['booking_status'] === 'expired') {
            $_SESSION['error'] = 'Booking telah kedaluwarsa. Waktu pembayaran telah habis.';
            header('Location: ' . BASEURL . 'user/bookings');
            exit;
        }

        // Check if booking status allows payment
        if ($booking['booking_status'] !== 'pending') {
            $_SESSION['error'] = 'Booking ini tidak dapat dibayar';
            header('Location: ' . BASEURL . 'booking/detail/' . $booking_id);
            exit;
        }

        // Check if payment already exists
        $existingPayment = $this->paymentModel->getByBookingId($booking_id);

        if ($existingPayment) {
            // Redirect to payment detail if payment exists
            header('Location: ' . BASEURL . 'payment/show/' . $existingPayment['id']);
            exit;
        }

        // Get passengers for booking
        $passengers = $this->bookingModel->getPassengers($booking_id);

        // Payment methods
        $paymentMethods = [
            'bank_transfer' => [
                'name' => 'Transfer Bank',
                'icon' => 'fa-building-columns',
                'description' => 'Transfer melalui ATM, Mobile Banking, atau Internet Banking',
                'banks' => [
                    ['name' => 'BCA', 'account' => '1234567890', 'holder' => 'PT Sinar Jaya Trans'],
                    ['name' => 'Mandiri', 'account' => '0987654321', 'holder' => 'PT Sinar Jaya Trans'],
                    ['name' => 'BNI', 'account' => '5556667778', 'holder' => 'PT Sinar Jaya Trans'],
                ]
            ],
            'e_wallet' => [
                'name' => 'E-Wallet',
                'icon' => 'fa-wallet',
                'description' => 'Bayar menggunakan GoPay, OVO, Dana, atau LinkAja',
                'wallets' => [
                    ['name' => 'GoPay', 'number' => '081234567890'],
                    ['name' => 'OVO', 'number' => '081234567890'],
                    ['name' => 'Dana', 'number' => '081234567890'],
                ]
            ],
            'qris' => [
                'name' => 'QRIS',
                'icon' => 'fa-qrcode',
                'description' => 'Scan kode QR untuk pembayaran instan',
                'qr_image' => 'qris-code.png'
            ]
        ];

        $data = [
            'title' => 'Pembayaran',
            'booking' => $booking,
            'passengers' => $passengers,
            'paymentMethods' => $paymentMethods,
            'payment_expiry' => $booking['payment_expiry']
        ];

        $this->renderWithLayout('payment/method-selection', $data);
    }

    /**
     * Process payment method selection
     */
    public function processMethod()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASEURL);
            exit;
        }

        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Silakan login terlebih dahulu';
            header('Location: ' . BASEURL . 'auth/login');
            exit;
        }

        $booking_id = isset($_POST['booking_id']) ? intval($_POST['booking_id']) : 0;
        $payment_method = isset($_POST['payment_method']) ? $_POST['payment_method'] : '';

        // Validate inputs
        if ($booking_id <= 0 || empty($payment_method)) {
            $_SESSION['error'] = 'Data tidak lengkap';
            header('Location: ' . BASEURL . 'payment/create?booking_id=' . $booking_id);
            exit;
        }

        // Validate payment method
        $validMethods = ['bank_transfer', 'e_wallet', 'qris'];
        if (!in_array($payment_method, $validMethods)) {
            $_SESSION['error'] = 'Metode pembayaran tidak valid';
            header('Location: ' . BASEURL . 'payment/create?booking_id=' . $booking_id);
            exit;
        }

        // Check and update expired bookings first
        $this->bookingModel->checkAndUpdateExpiredBookings();

        // Get booking details
        $booking = $this->bookingModel->findById($booking_id);

        if (!$booking || $booking['user_id'] != $_SESSION['user_id']) {
            $_SESSION['error'] = 'Booking tidak ditemukan';
            header('Location: ' . BASEURL . 'user/bookings');
            exit;
        }

        // Check if booking is expired
        if ($booking['booking_status'] === 'expired') {
            $_SESSION['error'] = 'Booking telah kedaluwarsa. Waktu pembayaran telah habis.';
            header('Location: ' . BASEURL . 'user/bookings');
            exit;
        }

        // Check if booking is not pending
        if ($booking['booking_status'] !== 'pending') {
            $_SESSION['error'] = 'Booking ini tidak dapat dibayar';
            header('Location: ' . BASEURL . 'user/bookings');
            exit;
        }

        // Generate payment code
        $payment_code = $this->generatePaymentCode($payment_method);

        // Create payment record
        $paymentData = [
            'booking_id' => $booking_id,
            'payment_method' => $payment_method,
            'payment_code' => $payment_code,
            'amount' => $booking['total_amount'],
            'payment_status' => 'pending',
            'payment_details' => [
                'selected_method' => $payment_method,
                'created_by_user' => $_SESSION['user_id']
            ]
        ];

        if ($this->paymentModel->create($paymentData)) {
            // Get the newly created payment
            $payment = $this->paymentModel->getByBookingId($booking_id);

            // Redirect to payment instructions
            header('Location: ' . BASEURL . 'payment/instructions/' . $payment['id']);
            exit;
        } else {
            $_SESSION['error'] = 'Gagal membuat pembayaran';
            header('Location: ' . BASEURL . 'payment/create?booking_id=' . $booking_id);
            exit;
        }
    }

    /**
     * Show payment instructions
     */
    public function instructions($payment_id)
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Silakan login terlebih dahulu';
            header('Location: ' . BASEURL . 'auth/login');
            exit;
        }

        $payment = $this->paymentModel->findById($payment_id);

        if (!$payment) {
            $_SESSION['error'] = 'Pembayaran tidak ditemukan';
            header('Location: ' . BASEURL . 'user/bookings');
            exit;
        }

        // Check if payment belongs to current user
        if ($payment['user_id'] != $_SESSION['user_id']) {
            $_SESSION['error'] = 'Anda tidak memiliki akses ke pembayaran ini';
            header('Location: ' . BASEURL . 'user/bookings');
            exit;
        }

        // Get passengers
        $passengers = $this->bookingModel->getPassengers($payment['booking_id']);

        // Payment details based on method
        $paymentInstructions = $this->getPaymentInstructions($payment['payment_method']);

        $data = [
            'title' => 'Instruksi Pembayaran',
            'payment' => $payment,
            'passengers' => $passengers,
            'instructions' => $paymentInstructions
        ];

        $this->renderWithLayout('payment/instructions', $data);
    }

    /**
     * Show payment detail / confirmation page
     */
    public function show($payment_id)
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Silakan login terlebih dahulu';
            header('Location: ' . BASEURL . 'auth/login');
            exit;
        }

        $payment = $this->paymentModel->findById($payment_id);

        if (!$payment) {
            $_SESSION['error'] = 'Pembayaran tidak ditemukan';
            header('Location: ' . BASEURL . 'user/bookings');
            exit;
        }

        // Check if payment belongs to current user
        if ($payment['user_id'] != $_SESSION['user_id']) {
            $_SESSION['error'] = 'Anda tidak memiliki akses ke pembayaran ini';
            header('Location: ' . BASEURL . 'user/bookings');
            exit;
        }

        // Get passengers
        $passengers = $this->bookingModel->getPassengers($payment['booking_id']);

        $data = [
            'title' => 'Detail Pembayaran',
            'payment' => $payment,
            'passengers' => $passengers
        ];

        $this->renderWithLayout('payment/show', $data);
    }

    /**
     * Upload payment proof
     */
    public function uploadProof()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASEURL);
            exit;
        }

        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Silakan login terlebih dahulu';
            header('Location: ' . BASEURL . 'auth/login');
            exit;
        }

        $payment_id = isset($_POST['payment_id']) ? intval($_POST['payment_id']) : 0;

        if ($payment_id <= 0) {
            $_SESSION['error'] = 'ID pembayaran tidak valid';
            header('Location: ' . BASEURL . 'user/bookings');
            exit;
        }

        $payment = $this->paymentModel->findById($payment_id);

        if (!$payment || $payment['user_id'] != $_SESSION['user_id']) {
            $_SESSION['error'] = 'Pembayaran tidak ditemukan';
            header('Location: ' . BASEURL . 'user/bookings');
            exit;
        }

        // Check if file is uploaded
        if (!isset($_FILES['payment_proof']) || $_FILES['payment_proof']['error'] !== UPLOAD_ERR_OK) {
            $_SESSION['error'] = 'Silakan upload bukti pembayaran';
            header('Location: ' . BASEURL . 'payment/instructions/' . $payment_id);
            exit;
        }

        // Validate file
        $file = $_FILES['payment_proof'];
        $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        $maxSize = 2 * 1024 * 1024; // 2MB

        if (!in_array($file['type'], $allowedTypes)) {
            $_SESSION['error'] = 'Format file harus JPG, JPEG, atau PNG';
            header('Location: ' . BASEURL . 'payment/instructions/' . $payment_id);
            exit;
        }

        if ($file['size'] > $maxSize) {
            $_SESSION['error'] = 'Ukuran file maksimal 2MB';
            header('Location: ' . BASEURL . 'payment/instructions/' . $payment_id);
            exit;
        }

        // Upload file
        $uploadDir = 'uploads/payments/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = 'payment_' . $payment_id . '_' . time() . '.' . $extension;
        $uploadPath = $uploadDir . $filename;

        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            // Delete old proof if exists
            if ($payment['payment_proof_image'] && file_exists($payment['payment_proof_image'])) {
                unlink($payment['payment_proof_image']);
            }

            // Update payment record
            $this->paymentModel->update($payment_id, [
                'payment_proof_image' => $uploadPath
            ]);

            $_SESSION['success'] = 'Bukti pembayaran berhasil diupload. Menunggu verifikasi admin.';
            header('Location: ' . BASEURL . 'payment/show/' . $payment_id);
            exit;
        } else {
            $_SESSION['error'] = 'Gagal upload file';
            header('Location: ' . BASEURL . 'payment/instructions/' . $payment_id);
            exit;
        }
    }

    /**
     * Generate payment code
     */
    private function generatePaymentCode($method)
    {
        $prefix = '';
        switch ($method) {
            case 'bank_transfer':
                $prefix = 'TRF';
                break;
            case 'e_wallet':
                $prefix = 'EWL';
                break;
            case 'qris':
                $prefix = 'QRS';
                break;
            default:
                $prefix = 'PAY';
        }

        return 'PAY-' . $prefix . '-' . strtoupper(substr(md5(time() . rand()), 0, 8));
    }

    /**
     * Get payment instructions based on method
     */
    private function getPaymentInstructions($method)
    {
        $instructions = [
            'bank_transfer' => [
                'title' => 'Transfer Bank',
                'banks' => [
                    [
                        'name' => 'BCA',
                        'logo' => 'bca-logo.png',
                        'account' => '1234567890',
                        'holder' => 'PT Sinar Jaya Trans'
                    ],
                    [
                        'name' => 'Mandiri',
                        'logo' => 'mandiri-logo.png',
                        'account' => '0987654321',
                        'holder' => 'PT Sinar Jaya Trans'
                    ],
                    [
                        'name' => 'BNI',
                        'logo' => 'bni-logo.png',
                        'account' => '5556667778',
                        'holder' => 'PT Sinar Jaya Trans'
                    ]
                ],
                'steps' => [
                    'Pilih salah satu rekening bank di atas',
                    'Transfer sesuai dengan jumlah yang tertera',
                    'Simpan bukti transfer',
                    'Upload bukti transfer pada form di bawah',
                    'Tunggu konfirmasi dari admin (maksimal 2x24 jam)'
                ]
            ],
            'e_wallet' => [
                'title' => 'E-Wallet',
                'wallets' => [
                    ['name' => 'GoPay', 'logo' => 'gopay-logo.png', 'number' => '081234567890'],
                    ['name' => 'OVO', 'logo' => 'ovo-logo.png', 'number' => '081234567890'],
                    ['name' => 'Dana', 'logo' => 'dana-logo.png', 'number' => '081234567890'],
                    ['name' => 'LinkAja', 'logo' => 'linkaja-logo.png', 'number' => '081234567890']
                ],
                'steps' => [
                    'Buka aplikasi e-wallet pilihan Anda',
                    'Pilih menu Transfer atau Kirim Uang',
                    'Masukkan nomor tujuan sesuai dengan yang tertera',
                    'Transfer sesuai dengan jumlah yang tertera',
                    'Simpan bukti transaksi',
                    'Upload bukti transaksi pada form di bawah',
                    'Tunggu konfirmasi dari admin (maksimal 2x24 jam)'
                ]
            ],
            'qris' => [
                'title' => 'QRIS',
                'qr_code' => 'qris-sinarjaya.png',
                'steps' => [
                    'Buka aplikasi e-wallet atau mobile banking Anda',
                    'Pilih menu Scan QR atau QRIS',
                    'Scan kode QR di bawah ini',
                    'Masukkan nominal sesuai dengan jumlah yang tertera',
                    'Konfirmasi pembayaran',
                    'Simpan bukti transaksi',
                    'Upload bukti transaksi pada form di bawah',
                    'Tunggu konfirmasi dari admin (maksimal 2x24 jam)'
                ]
            ]
        ];

        return $instructions[$method] ?? [];
    }

    /**
     * Render view with layout
     */
    private function renderWithLayout($view, $data = [])
    {
        extract($data);

        // Capture the view content
        ob_start();
        require_once '../app/Views/' . $view . '.php';
        $content = ob_get_clean();

        // Load the layout with content
        require_once '../app/Views/layouts/main.php';
    }
}
