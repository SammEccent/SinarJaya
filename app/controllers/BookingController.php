<?php

class BookingController extends Controller
{
    protected $bookingModel;
    protected $scheduleModel;
    protected $seatModel;

    public function __construct()
    {
        $this->bookingModel = $this->model('BookingModel');
        $this->scheduleModel = $this->model('ScheduleModel');
        $this->seatModel = $this->model('SeatModel');
    }

    /**
     * Show seat selection page
     */
    public function selectSeats()
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['redirect_after_login'] = BASEURL . 'booking/selectSeats?' . http_build_query($_GET);
            $_SESSION['error'] = 'Silakan login terlebih dahulu untuk melanjutkan pemesanan';
            header('Location: ' . BASEURL . 'auth/login');
            exit;
        }

        // Get parameters from search
        $schedule_id = isset($_GET['schedule_id']) ? (int)$_GET['schedule_id'] : 0;
        $passengers = isset($_GET['passengers']) ? (int)$_GET['passengers'] : 1;

        if ($schedule_id <= 0 || $passengers <= 0 || $passengers > 30) {
            $_SESSION['error'] = 'Data pemesanan tidak valid';
            header('Location: ' . BASEURL);
            exit;
        }

        // Get schedule details
        $scheduleModel = $this->model('ScheduleModel');
        $schedule = $scheduleModel->getScheduleDetails($schedule_id);

        if (!$schedule) {
            $_SESSION['error'] = 'Jadwal tidak ditemukan';
            header('Location: ' . BASEURL);
            exit;
        }

        // Check available seats
        if ($schedule['available_seats'] < $passengers) {
            $_SESSION['error'] = 'Kursi yang tersedia tidak mencukupi. Tersedia: ' . $schedule['available_seats'] . ' kursi';
            header('Location: ' . BASEURL . 'home/search?' . http_build_query($_SESSION['last_search'] ?? []));
            exit;
        }

        // Get bus seats with booking status
        $seatModel = $this->model('SeatModel');
        $seats = $seatModel->getAvailableSeatsForSchedule($schedule_id, $schedule['bus_id']);

        // Get bus info for layout
        $busModel = $this->model('BusModel');
        $bus = $busModel->findById($schedule['bus_id']);

        $data = [
            'title' => 'Pilih Kursi',
            'schedule' => $schedule,
            'passengers' => $passengers,
            'seats' => $seats,
            'bus' => $bus
        ];

        $this->renderWithLayout('booking/seat-selection', $data);
    }

    /**
     * Show booking form with schedule details
     */
    public function create()
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['redirect_after_login'] = BASEURL . 'booking/create?' . http_build_query($_POST);
            $_SESSION['error'] = 'Silakan login terlebih dahulu untuk melanjutkan pemesanan';
            header('Location: ' . BASEURL . 'auth/login');
            exit;
        }

        // Validate POST data from seat selection
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error'] = 'Invalid request method';
            header('Location: ' . BASEURL);
            exit;
        }

        $schedule_id = isset($_POST['schedule_id']) ? (int)$_POST['schedule_id'] : 0;
        $selected_seats = isset($_POST['selected_seats']) ? $_POST['selected_seats'] : '';

        // Parse selected seat IDs
        $seat_ids = array_filter(array_map('intval', explode(',', $selected_seats)));
        $passengers = count($seat_ids);

        if ($schedule_id <= 0 || $passengers <= 0) {
            $_SESSION['error'] = 'Silakan pilih kursi terlebih dahulu';
            header('Location: ' . BASEURL . 'booking/selectSeats?schedule_id=' . $schedule_id . '&passengers=1');
            exit;
        }

        // Get schedule details with full info
        $scheduleModel = $this->model('ScheduleModel');
        $schedule = $scheduleModel->getScheduleDetails($schedule_id);

        if (!$schedule) {
            $_SESSION['error'] = 'Jadwal tidak ditemukan';
            header('Location: ' . BASEURL);
            exit;
        }

        // Verify seat availability
        $seatModel = $this->model('SeatModel');
        if (!$seatModel->checkSeatsAvailability($seat_ids, $schedule_id)) {
            $_SESSION['error'] = 'Beberapa kursi yang Anda pilih sudah dipesan. Silakan pilih kursi lain';
            header('Location: ' . BASEURL . 'booking/selectSeats?schedule_id=' . $schedule_id . '&passengers=' . $passengers);
            exit;
        }

        // Get boarding points (BOARDING or BOTH)
        $routeModel = $this->model('RouteModel');
        $boardingPoints = $routeModel->getBoardingPoints($schedule['route_id']);
        $dropPoints = $routeModel->getDropPoints($schedule['route_id']);

        // Get selected seat details
        $selectedSeatsDetails = [];
        foreach ($seat_ids as $seat_id) {
            $seat = $seatModel->findById($seat_id);
            if ($seat) {
                $selectedSeatsDetails[] = $seat;
            }
        }

        // Calculate price
        $finalPrice = $schedule['base_price'] * $schedule['base_price_multiplier'];
        $totalPrice = $finalPrice * $passengers;

        $data = [
            'title' => 'Form Pemesanan Tiket',
            'schedule' => $schedule,
            'passengers' => $passengers,
            'selected_seats' => $selectedSeatsDetails,
            'selected_seat_ids' => $seat_ids,
            'boarding_points' => $boardingPoints,
            'drop_points' => $dropPoints,
            'price_per_person' => $finalPrice,
            'total_price' => $totalPrice
        ];

        $this->renderWithLayout('booking/form', $data);
    }

    /**
     * Store booking in database
     */
    public function store()
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Silakan login terlebih dahulu';
            header('Location: ' . BASEURL . 'auth/login');
            exit;
        }

        // Validate POST method
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error'] = 'Invalid request method';
            header('Location: ' . BASEURL);
            exit;
        }

        // Get and validate POST data
        $schedule_id = isset($_POST['schedule_id']) ? (int)$_POST['schedule_id'] : 0;
        $passengers_count = isset($_POST['passengers_count']) ? (int)$_POST['passengers_count'] : 0;
        $pickup_location_id = isset($_POST['pickup_location_id']) ? (int)$_POST['pickup_location_id'] : 0;
        $drop_location_id = isset($_POST['drop_location_id']) ? (int)$_POST['drop_location_id'] : 0;
        $total_amount = isset($_POST['total_amount']) ? (float)$_POST['total_amount'] : 0;

        // Get seat IDs
        $seat_ids = isset($_POST['seat_ids']) ? $_POST['seat_ids'] : [];
        if (is_string($seat_ids)) {
            $seat_ids = array_filter(array_map('intval', explode(',', $seat_ids)));
        }

        // Get passenger data
        $passenger_names = isset($_POST['passenger_name']) ? $_POST['passenger_name'] : [];
        $passenger_phones = isset($_POST['passenger_phone']) ? $_POST['passenger_phone'] : [];
        $passenger_id_types = isset($_POST['passenger_id_type']) ? $_POST['passenger_id_type'] : [];
        $passenger_id_numbers = isset($_POST['passenger_id_number']) ? $_POST['passenger_id_number'] : [];

        // Validate inputs
        $errors = [];

        if ($schedule_id <= 0) {
            $errors[] = 'Jadwal tidak valid';
        }
        if ($passengers_count <= 0 || $passengers_count > 30) {
            $errors[] = 'Jumlah penumpang tidak valid';
        }
        if ($pickup_location_id <= 0) {
            $errors[] = 'Titik naik harus dipilih';
        }
        if ($drop_location_id <= 0) {
            $errors[] = 'Titik turun harus dipilih';
        }
        if ($pickup_location_id === $drop_location_id) {
            $errors[] = 'Titik naik dan turun tidak boleh sama';
        }
        if ($total_amount <= 0) {
            $errors[] = 'Total harga tidak valid';
        }
        if (count($passenger_names) !== $passengers_count) {
            $errors[] = 'Data penumpang tidak lengkap';
        }

        // Validate each passenger
        for ($i = 0; $i < $passengers_count; $i++) {
            if (empty($passenger_names[$i])) {
                $errors[] = 'Nama penumpang ' . ($i + 1) . ' harus diisi';
            }
            if (empty($passenger_phones[$i])) {
                $errors[] = 'No HP penumpang ' . ($i + 1) . ' harus diisi';
            }
            if (empty($passenger_id_types[$i])) {
                $errors[] = 'Jenis identitas penumpang ' . ($i + 1) . ' harus dipilih';
            }
            if (empty($passenger_id_numbers[$i])) {
                $errors[] = 'Nomor identitas penumpang ' . ($i + 1) . ' harus diisi';
            }
        }

        if (!empty($errors)) {
            $_SESSION['booking_errors'] = $errors;
            $_SESSION['old'] = $_POST;
            header('Location: ' . BASEURL . 'booking/create?schedule_id=' . $schedule_id . '&passengers=' . $passengers_count);
            exit;
        }

        // Get schedule
        $scheduleModel = $this->model('ScheduleModel');
        $schedule = $scheduleModel->getScheduleDetails($schedule_id);

        if (!$schedule) {
            $_SESSION['error'] = 'Jadwal tidak ditemukan';
            header('Location: ' . BASEURL);
            exit;
        }

        // IMPORTANT: Check if selected seats are still available
        // This prevents race condition where multiple users book the same seat
        if (!empty($seat_ids)) {
            $seatModel = $this->model('SeatModel');
            if (!$seatModel->checkSeatsAvailability($seat_ids, $schedule_id)) {
                $_SESSION['error'] = 'Maaf, salah satu atau lebih kursi yang Anda pilih sudah dipesan oleh penumpang lain. Silakan pilih kursi lain.';
                header('Location: ' . BASEURL . 'booking/selectSeats?schedule_id=' . $schedule_id . '&passengers=' . $passengers_count);
                exit;
            }
        }

        // Verify available seats
        if ($schedule['available_seats'] < $passengers_count) {
            $_SESSION['error'] = 'Kursi yang tersedia tidak mencukupi';
            header('Location: ' . BASEURL . 'booking/create?schedule_id=' . $schedule_id . '&passengers=' . $passengers_count);
            exit;
        }

        // Generate booking code
        $booking_code = $this->generateBookingCode();

        // Create booking data
        $booking_data = [
            'booking_code' => $booking_code,
            'user_id' => $_SESSION['user_id'],
            'schedule_id' => $schedule_id,
            'pickup_location_id' => $pickup_location_id,
            'drop_location_id' => $drop_location_id,
            'total_passengers' => $passengers_count,
            'total_amount' => $total_amount,
            'booking_status' => 'pending',
            'payment_expiry' => date('Y-m-d H:i:s', strtotime('+20 minutes')),
            'notes' => isset($_POST['notes']) ? $_POST['notes'] : null
        ];

        // Create booking
        $booking_id = $this->bookingModel->create($booking_data);

        if (!$booking_id) {
            $_SESSION['error'] = 'Gagal membuat booking. Silakan coba lagi';
            header('Location: ' . BASEURL . 'booking/create?schedule_id=' . $schedule_id . '&passengers=' . $passengers_count);
            exit;
        }

        // Create passenger records
        $passengerModel = $this->model('PassengerModel');

        for ($i = 0; $i < $passengers_count; $i++) {
            $passenger_data = [
                'booking_id' => $booking_id,
                'seat_id' => isset($seat_ids[$i]) ? $seat_ids[$i] : null,
                'full_name' => $passenger_names[$i],
                'phone' => $passenger_phones[$i],
                'id_card_type' => $passenger_id_types[$i],
                'id_card_number' => $passenger_id_numbers[$i]
            ];

            $passengerModel->create($passenger_data);
        }

        // Note: Seat status is tracked through passengers table relationship
        // No need to update seats.status column as getAvailableSeatsForSchedule() 
        // checks the passengers-bookings relationship for real-time status

        // Update available seats
        $new_available_seats = $schedule['available_seats'] - $passengers_count;
        $scheduleModel->updateAvailableSeats($schedule_id, $new_available_seats);

        // Store booking info in session
        $_SESSION['booking_id'] = $booking_id;
        $_SESSION['booking_code'] = $booking_code;
        $_SESSION['success'] = 'Booking berhasil dibuat! Kode booking: ' . $booking_code;

        // Redirect to payment page
        header('Location: ' . BASEURL . 'payment/create?booking_id=' . $booking_id);
        exit;
    }

    /**
     * Display booking confirmation
     */
    public function confirm($booking_id)
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /auth/login');
            exit;
        }

        $booking_id = (int)$booking_id;
        $booking = $this->bookingModel->findById($booking_id);

        if (!$booking || $booking['user_id'] != $_SESSION['user_id']) {
            $this->renderWithLayout('errors/404', [
                'title' => 'Booking Tidak Ditemukan',
                'message' => 'Booking yang Anda cari tidak ada'
            ]);
            return;
        }

        $schedule = $this->scheduleModel->findById($booking['schedule_id']);
        $passengers = $this->bookingModel->getPassengers($booking_id);

        $data = [
            'title' => 'Konfirmasi Booking',
            'booking' => $booking,
            'schedule' => $schedule,
            'passengers' => $passengers
        ];

        $this->renderWithLayout('user/booking-confirmation', $data);
    }

    /**
     * View booking details
     */
    public function detail($booking_id)
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /auth/login');
            exit;
        }

        $booking_id = (int)$booking_id;
        $booking = $this->bookingModel->findById($booking_id);

        if (!$booking || $booking['user_id'] != $_SESSION['user_id']) {
            $this->renderWithLayout('errors/404', [
                'title' => 'Booking Tidak Ditemukan',
                'message' => 'Booking yang Anda cari tidak ada'
            ]);
            return;
        }

        $schedule = $this->scheduleModel->findById($booking['schedule_id']);
        $passengers = $this->bookingModel->getPassengers($booking_id);
        $seats = $this->bookingModel->getSeats($booking_id);

        $data = [
            'title' => 'Detail Booking',
            'booking' => $booking,
            'schedule' => $schedule,
            'passengers' => $passengers,
            'seats' => $seats
        ];

        $this->renderWithLayout('user/booking-detail', $data);
    }

    /**
     * Cancel booking
     */
    public function cancel($booking_id)
    {
        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'User tidak login']);
            return;
        }

        $booking_id = (int)$booking_id;
        $booking = $this->bookingModel->findById($booking_id);

        if (!$booking || $booking['user_id'] != $_SESSION['user_id']) {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Booking tidak ditemukan']);
            return;
        }

        // Only allow cancel if not confirmed or payment expired
        if ($booking['booking_status'] === 'confirmed') {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Tidak bisa membatalkan booking yang sudah terkonfirmasi']);
            return;
        }

        // Cancel booking
        $result = $this->bookingModel->update($booking_id, [
            'booking_status' => 'cancelled'
        ]);

        if ($result) {
            // Release booked seats back to available
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

            // Restore available seats
            $schedule = $this->scheduleModel->findById($booking['schedule_id']);
            $new_available = $schedule['available_seats'] + $booking['total_passengers'];
            $this->scheduleModel->update($booking['schedule_id'], array_merge($schedule, ['available_seats' => $new_available]));

            $_SESSION['success'] = 'Booking berhasil dibatalkan';
            echo json_encode(['success' => true, 'message' => 'Booking berhasil dibatalkan']);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Gagal membatalkan booking']);
        }
    }

    /**
     * Generate unique booking code
     */
    private function generateBookingCode()
    {
        // Format: SJ-{YYYYMMDD}{4 random digits}
        $date_part = date('Ymd');
        $random_part = str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        return 'SJ-' . $date_part . $random_part;
    }

    /**
     * Generate and download e-ticket PDF
     */
    public function downloadTicket($booking_id)
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Silakan login terlebih dahulu';
            header('Location: ' . BASEURL . 'auth/login');
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

        // Check if booking is confirmed
        if ($booking['booking_status'] !== 'confirmed') {
            $_SESSION['error'] = 'E-ticket hanya tersedia untuk booking yang sudah dikonfirmasi';
            header('Location: ' . BASEURL . 'booking/detail/' . $booking_id);
            exit;
        }

        // Get passengers
        $passengers = $this->bookingModel->getPassengers($booking_id);

        // Get payment info
        $paymentModel = $this->model('PaymentModel');
        $payment = $paymentModel->getByBookingId($booking_id);

        // Load TicketHelper
        require_once __DIR__ . '/../Helpers/TicketHelper.php';

        try {
            // Generate PDF
            $filename = TicketHelper::generateTicketPDF($booking, $passengers, $payment);
            $filepath = TicketHelper::getTicketPath($filename);

            // Check if file exists
            if (!file_exists($filepath)) {
                throw new Exception('Failed to generate ticket file');
            }

            // Set headers for download
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Content-Length: ' . filesize($filepath));
            header('Cache-Control: private, max-age=0, must-revalidate');
            header('Pragma: public');

            // Clear output buffer
            ob_clean();
            flush();

            // Read and output file
            readfile($filepath);

            // Optional: Delete file after download (uncomment if you want to delete)
            // unlink($filepath);

            exit;
        } catch (Exception $e) {
            $_SESSION['error'] = 'Gagal membuat e-ticket: ' . $e->getMessage();
            header('Location: ' . BASEURL . 'booking/detail/' . $booking_id);
            exit;
        }
    }
}
