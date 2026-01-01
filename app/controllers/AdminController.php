<?php

class AdminController extends Controller
{
    protected $userModel;
    protected $busModel;
    protected $seatModel;
    protected $routeModel;
    protected $locationModel;
    protected $scheduleModel;
    protected $bookingModel;
    protected $passengerModel;
    protected $paymentModel;

    public function __construct()
    {
        // Load models
        $this->userModel = $this->model('UserModel');
        $this->busModel = $this->model('BusModel');
        $this->seatModel = $this->model('SeatModel');
        $this->routeModel = $this->model('RouteModel');
        $this->locationModel = $this->model('LocationModel');
        $this->scheduleModel = $this->model('ScheduleModel');
        $this->bookingModel = $this->model('BookingModel');
        $this->passengerModel = $this->model('PassengerModel');
        $this->paymentModel = $this->model('PaymentModel');
        // Ensure session started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    // Default action for /admin
    public function index()
    {
        // If admin is logged in, show dashboard
        if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
            $data = [
                'total_buses' => $this->busModel->count(),
                'total_users' => $this->userModel->count(),
                'total_routes' => $this->routeModel->count(),
                'payment_stats' => $this->paymentModel->getStatistics(),
                'recent_bookings' => $this->bookingModel->getRecentBookings(5)
            ];
            $this->renderDashboard('admin/dashboard', $data);
            return;
        }

        // Not logged in -> redirect to auth login
        header('Location: ' . BASEURL . 'auth/login');
        exit;
    }

    // Helper to render admin pages with sidebar
    protected function renderDashboard($view, $data = [])
    {
        extract($data);

        // Check if view is dashboard - if so, include it directly (it has its own structure + CSS)
        if ($view === 'admin/dashboard') {
            // Dashboard has its own complete structure with sidebar and CSS
            echo "<!DOCTYPE html>\n<html lang=\"id\">\n<head>\n    <meta charset=\"utf-8\">\n    <meta name=\"viewport\" content=\"width=device-width,initial-scale=1\">\n    <title>Admin - Sinar Jaya</title>\n    <link href=\"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css\" rel=\"stylesheet\">\n    <link href=\"" . BASEURL . "assets/css/admin-dashboard.css\" rel=\"stylesheet\">\n</head>\n<body>\n";
            $viewPath = '../app/Views/' . $view . '.php';
            if (file_exists($viewPath)) {
                require_once $viewPath;
            } else {
                die('View does not exist: ' . $view);
            }
            echo "\n<script src=\"" . BASEURL . "assets/js/main.js\"></script>\n</body>\n</html>";
            return;
        }

        // For other admin views (buses, routes, etc), wrap with sidebar
        echo "<!DOCTYPE html>\n<html lang=\"id\">\n<head>\n    <meta charset=\"utf-8\">\n    <meta name=\"viewport\" content=\"width=device-width,initial-scale=1\">\n    <title>Admin - Sinar Jaya</title>\n    <link href=\"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css\" rel=\"stylesheet\">\n    <link href=\"" . BASEURL . "assets/css/admin-dashboard.css\" rel=\"stylesheet\">\n</head>\n<body>\n";

        // Output dashboard structure with sidebar
        echo "<div class=\"admin-dashboard\">\n";

        // Include sidebar partial
        $sidebarPath = '../app/Views/partials/admin_sidebar.php';
        if (file_exists($sidebarPath)) {
            include $sidebarPath;
        }

        // Start main content area
        echo "<div class=\"admin-content\">\n";

        // Include the requested admin view inside the content area
        $viewPath = '../app/Views/' . $view . '.php';
        if (file_exists($viewPath)) {
            include $viewPath;
        } else {
            echo "<div class=\"admin-body\"><p>View not found: " . htmlspecialchars($view) . "</p></div>";
        }

        echo "</div>\n"; // end admin-content
        echo "</div>\n"; // end admin-dashboard

        // include admin scripts
        echo "<script src=\"" . BASEURL . "assets/js/main.js\"></script>\n</body>\n</html>";
    }

    /* -------------------------
     * Bus management methods
     * URL patterns (via App routing):
     * - /admin/buses -> buses()
     * - /admin/buses/create -> busesCreate()
     * - /admin/buses/edit/{id} -> busesEdit($id)
     * - /admin/buses/delete/{id} -> busesDelete($id)
     * - /admin/buses/{id}/seats -> busesSeats($id)
     */
    public function buses()
    {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('Location: ' . BASEURL . 'auth/login');
            exit;
        }

        $buses = $this->busModel->getAll();
        // Render view without main layout
        $data = ['buses' => $buses];
        $this->renderDashboard('admin/buses/index', $data);
    }

    public function busesCreate()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $plate_number = trim($_POST['plate_number'] ?? '');
            $total_seats = intval($_POST['total_seats'] ?? 0);
            $bus_class_id = intval($_POST['bus_class_id'] ?? 1);
            $operator_id = intval($_POST['operator_id'] ?? 0) ?: null;
            $seat_layout = trim($_POST['seat_layout'] ?? '2-2');
            $facilities = trim($_POST['facilities'] ?? '');
            $status = $_POST['status'] ?? 'active';

            $errors = [];
            if ($plate_number === '') $errors[] = 'Plat nomor wajib diisi.';
            if ($total_seats <= 0) $errors[] = 'Total kursi harus lebih dari 0.';

            if (!empty($errors)) {
                $data = ['errors' => $errors, 'old' => compact('plate_number', 'total_seats', 'bus_class_id', 'operator_id', 'seat_layout', 'facilities', 'status')];
                $this->renderDashboard('admin/buses/form', $data);
                return;
            }

            $this->busModel->create(compact('plate_number', 'total_seats', 'bus_class_id', 'operator_id', 'seat_layout', 'facilities', 'status'));
            header('Location: ' . BASEURL . 'admin/buses');
            exit;
        }

        $this->renderDashboard('admin/buses/form');
    }

    public function busesEdit($id = null)
    {
        if (!$id) {
            header('Location: ' . BASEURL . 'admin/buses');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $plate_number = trim($_POST['plate_number'] ?? '');
            $total_seats = intval($_POST['total_seats'] ?? 0);
            $bus_class_id = intval($_POST['bus_class_id'] ?? 1);
            $operator_id = intval($_POST['operator_id'] ?? 0) ?: null;
            $seat_layout = trim($_POST['seat_layout'] ?? '2-2');
            $facilities = trim($_POST['facilities'] ?? '');
            $status = $_POST['status'] ?? 'active';

            $this->busModel->update($id, compact('plate_number', 'total_seats', 'bus_class_id', 'operator_id', 'seat_layout', 'facilities', 'status'));
            header('Location: ' . BASEURL . 'admin/buses');
            exit;
        }

        $bus = $this->busModel->findById($id);
        if (!$bus) {
            header('Location: ' . BASEURL . 'admin/buses');
            exit;
        }
        $data = ['bus' => $bus];
        $this->renderDashboard('admin/buses/form', $data);
    }

    public function busesDelete($id = null)
    {
        if ($id) {
            $this->busModel->delete($id);
        }
        header('Location: ' . BASEURL . 'admin/buses');
        exit;
    }

    public function busesSeats($bus_id = null)
    {
        if (!$bus_id) {
            header('Location: ' . BASEURL . 'admin/buses');
            exit;
        }

        $bus = $this->busModel->findById($bus_id);
        if (!$bus) {
            header('Location: ' . BASEURL . 'admin/buses');
            exit;
        }

        // handle adding seat
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['seat_number'])) {
            $seat_number = trim($_POST['seat_number']);
            $seat_type = trim($_POST['seat_type'] ?? 'regular');

            if ($seat_number !== '') {
                $this->seatModel->create($bus_id, $seat_number, $seat_type);
            }
            header('Location: ' . BASEURL . 'admin/buses/' . $bus_id . '/seats');
            exit;
        }

        // Check and update expired bookings
        $this->bookingModel->checkAndUpdateExpiredBookings();

        $seats = $this->seatModel->getByBus($bus_id);
        $data = ['bus' => $bus, 'seats' => $seats];
        $this->renderDashboard('admin/buses/seats', $data);
    }

    public function seatToggle($seat_id = null)
    {
        if ($seat_id) $this->seatModel->toggleStatus($seat_id);
        // Try to redirect back
        header('Location: ' . $_SERVER['HTTP_REFERER'] ?? BASEURL . 'admin/buses');
        exit;
    }

    public function seatDelete($seat_id = null)
    {
        if ($seat_id) $this->seatModel->delete($seat_id);
        header('Location: ' . $_SERVER['HTTP_REFERER'] ?? BASEURL . 'admin/buses');
        exit;
    }

    /* -------------------------
     * Route management methods
     * URL patterns (via App routing):
     * - /admin/routes -> routes()
     * - /admin/routes/create -> routesCreate()
     * - /admin/routes/edit/{id} -> routesEdit($id)
     * - /admin/routes/delete/{id} -> routesDelete($id)
     * - /admin/routes/{id}/locations -> routesLocations($id)
     */
    public function routes()
    {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('Location: ' . BASEURL . 'auth/login');
            exit;
        }

        $routes = $this->routeModel->getAll();
        $data = ['routes' => $routes];
        $this->renderDashboard('admin/routes/index', $data);
    }

    public function routesCreate()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $origin_city = trim($_POST['origin_city'] ?? '');
            $destination_city = trim($_POST['destination_city'] ?? '');
            $route_code = trim($_POST['route_code'] ?? '');
            $status = $_POST['status'] ?? 'active';

            $errors = [];
            if ($origin_city === '') $errors[] = 'Kota asal wajib diisi.';
            if ($destination_city === '') $errors[] = 'Kota tujuan wajib diisi.';
            if ($route_code === '') $errors[] = 'Kode rute wajib diisi.';

            if (!empty($errors)) {
                $data = ['errors' => $errors, 'old' => compact('origin_city', 'destination_city', 'route_code', 'status')];
                $this->renderDashboard('admin/routes/form', $data);
                return;
            }

            $this->routeModel->create(compact('origin_city', 'destination_city', 'route_code', 'status'));
            header('Location: ' . BASEURL . 'admin/routes');
            exit;
        }

        $this->renderDashboard('admin/routes/form');
    }

    public function routesEdit($id = null)
    {
        if (!$id) {
            header('Location: ' . BASEURL . 'admin/routes');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $origin_city = trim($_POST['origin_city'] ?? '');
            $destination_city = trim($_POST['destination_city'] ?? '');
            $route_code = trim($_POST['route_code'] ?? '');
            $status = $_POST['status'] ?? 'active';

            $this->routeModel->update($id, compact('origin_city', 'destination_city', 'route_code', 'status'));
            header('Location: ' . BASEURL . 'admin/routes');
            exit;
        }

        $route = $this->routeModel->findById($id);
        if (!$route) {
            header('Location: ' . BASEURL . 'admin/routes');
            exit;
        }
        $data = ['route' => $route];
        $this->renderDashboard('admin/routes/form', $data);
    }

    public function routesDelete($id = null)
    {
        if ($id) {
            $this->routeModel->delete($id);
        }
        header('Location: ' . BASEURL . 'admin/routes');
        exit;
    }

    public function routesLocations($route_id = null)
    {
        if (!$route_id) {
            header('Location: ' . BASEURL . 'admin/routes');
            exit;
        }

        $route = $this->routeModel->findById($route_id);
        if (!$route) {
            header('Location: ' . BASEURL . 'admin/routes');
            exit;
        }

        // Handle adding route location
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['location_id'])) {
            $location_id = intval($_POST['location_id']);
            $fungsi = $_POST['fungsi'] ?? 'BOTH';
            $sequence = intval($_POST['sequence'] ?? 1);

            if ($location_id > 0) {
                $this->routeModel->addRouteLocation($route_id, $location_id, $fungsi, $sequence);
            }
            header('Location: ' . BASEURL . 'admin/routes/' . $route_id . '/locations');
            exit;
        }

        $route_locations = $this->routeModel->getRouteLocations($route_id);
        $all_locations = $this->locationModel->getAll();
        $data = ['route' => $route, 'route_locations' => $route_locations, 'all_locations' => $all_locations];
        $this->renderDashboard('admin/routes/locations', $data);
    }

    public function routeLocationDelete($route_location_id = null)
    {
        if ($route_location_id) {
            // Get route locations to find the route_id
            $db = new Database();
            $db->prepare('SELECT route_id FROM route_location WHERE route_location_id = :id LIMIT 1');
            $db->bind(':id', $route_location_id);
            $location = $db->fetch();
            $route_id = $location['route_id'] ?? null;

            $this->routeModel->removeRouteLocation($route_location_id);
            if ($route_id) {
                header('Location: ' . BASEURL . 'admin/routes/' . $route_id . '/locations');
                exit;
            }
        }
        header('Location: ' . BASEURL . 'admin/routes');
        exit;
    }

    /* -------------------------
     * Schedule management methods
     * URL patterns (via App routing):
     * - /admin/schedules -> schedules()
     * - /admin/schedules/create -> schedulesCreate()
     * - /admin/schedules/edit/{id} -> schedulesEdit($id)
     * - /admin/schedules/delete/{id} -> schedulesDelete($id)
     */
    public function schedules()
    {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('Location: ' . BASEURL . 'auth/login');
            exit;
        }

        // Auto-update status jadwal yang sudah berangkat
        $this->scheduleModel->updateDepartedSchedules();

        $schedules = $this->scheduleModel->getAll();
        $data = ['schedules' => $schedules];
        $this->renderDashboard('admin/schedules/index', $data);
    }

    public function schedulesCreate()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $bus_id = intval($_POST['bus_id'] ?? 0);
            $route_id = intval($_POST['route_id'] ?? 0);
            $route_type = $_POST['route_type'] ?? 'forward';
            $departure_datetime = trim($_POST['departure_datetime'] ?? '');
            $arrival_datetime = trim($_POST['arrival_datetime'] ?? '');
            $base_price = floatval($_POST['base_price'] ?? 0);
            $available_seats = intval($_POST['available_seats'] ?? 0);
            $status = $_POST['status'] ?? 'scheduled';
            $notes = trim($_POST['notes'] ?? '');

            $errors = [];
            if ($bus_id <= 0) $errors[] = 'Pilih bus.';
            if ($route_id <= 0) $errors[] = 'Pilih rute.';
            if ($departure_datetime === '') $errors[] = 'Tanggal/waktu berangkat wajib diisi.';
            if ($arrival_datetime === '') $errors[] = 'Tanggal/waktu tiba wajib diisi.';
            if ($base_price <= 0) $errors[] = 'Harga dasar harus lebih dari 0.';
            if ($available_seats <= 0) $errors[] = 'Jumlah kursi tersedia harus lebih dari 0.';

            // Validate bus schedule and route type
            if (empty($errors)) {
                $validation = $this->scheduleModel->validateBusSchedule(
                    $bus_id,
                    $route_id,
                    $departure_datetime,
                    $route_type
                );

                if (!$validation['valid']) {
                    $errors[] = $validation['message'];
                }
            }

            if (!empty($errors)) {
                $buses = $this->busModel->getAll();
                $routes = $this->routeModel->getAll();
                $data = ['errors' => $errors, 'old' => compact('bus_id', 'route_id', 'route_type', 'departure_datetime', 'arrival_datetime', 'base_price', 'available_seats', 'status', 'notes'), 'buses' => $buses, 'routes' => $routes];
                $this->renderDashboard('admin/schedules/form', $data);
                return;
            }

            $this->scheduleModel->create(compact('bus_id', 'route_id', 'route_type', 'departure_datetime', 'arrival_datetime', 'base_price', 'available_seats', 'status', 'notes'));
            header('Location: ' . BASEURL . 'admin/schedules');
            exit;
        }

        $buses = $this->busModel->getAll();
        $routes = $this->routeModel->getAll();
        $old = [];
        if (!empty($buses)) {
            // default available seats = bus total_seats of first bus
            $old['available_seats'] = $buses[0]['total_seats'];
        }
        $this->renderDashboard('admin/schedules/form', ['buses' => $buses, 'routes' => $routes, 'old' => $old]);
    }

    public function schedulesEdit($id = null)
    {
        if (!$id) {
            header('Location: ' . BASEURL . 'admin/schedules');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $bus_id = intval($_POST['bus_id'] ?? 0);
            $route_id = intval($_POST['route_id'] ?? 0);
            $route_type = $_POST['route_type'] ?? 'forward';
            $departure_datetime = trim($_POST['departure_datetime'] ?? '');
            $arrival_datetime = trim($_POST['arrival_datetime'] ?? '');
            $base_price = floatval($_POST['base_price'] ?? 0);
            $available_seats = intval($_POST['available_seats'] ?? 0);
            $status = $_POST['status'] ?? 'scheduled';
            $notes = trim($_POST['notes'] ?? '');

            // Validate bus schedule and route type (exclude current schedule from check)
            $errors = [];
            $validation = $this->scheduleModel->validateBusSchedule(
                $bus_id,
                $route_id,
                $departure_datetime,
                $route_type,
                $id  // exclude current schedule
            );

            if (!$validation['valid']) {
                $errors[] = $validation['message'];
            }

            if (!empty($errors)) {
                $schedule = $this->scheduleModel->findById($id);
                $buses = $this->busModel->getAll();
                $routes = $this->routeModel->getAll();
                $data = ['errors' => $errors, 'schedule' => $schedule, 'buses' => $buses, 'routes' => $routes];
                $this->renderDashboard('admin/schedules/form', $data);
                return;
            }

            $this->scheduleModel->update($id, compact('bus_id', 'route_id', 'route_type', 'departure_datetime', 'arrival_datetime', 'base_price', 'available_seats', 'status', 'notes'));
            header('Location: ' . BASEURL . 'admin/schedules');
            exit;
        }

        $schedule = $this->scheduleModel->findById($id);
        if (!$schedule) {
            header('Location: ' . BASEURL . 'admin/schedules');
            exit;
        }

        $buses = $this->busModel->getAll();
        $routes = $this->routeModel->getAll();
        $data = ['schedule' => $schedule, 'buses' => $buses, 'routes' => $routes];
        $this->renderDashboard('admin/schedules/form', $data);
    }

    public function schedulesDelete($id = null)
    {
        if ($id) {
            $this->scheduleModel->delete($id);
        }
        header('Location: ' . BASEURL . 'admin/schedules');
        exit;
    }

    /**
     * Fix available_seats for all schedules
     * Recalculates based on actual seat bookings
     */
    public function schedulesFixSeats()
    {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('Location: ' . BASEURL . 'auth/login');
            exit;
        }

        // Release orphaned seats
        $db = new Database();
        $db->prepare('
            SELECT s.id FROM seats s
            LEFT JOIN passengers p ON s.id = p.seat_id
            WHERE s.status = "booked" AND p.id IS NULL
        ');
        $orphaned_seats = $db->fetchAll();

        foreach ($orphaned_seats as $seat) {
            $this->seatModel->updateStatus($seat['id'], 'available');
        }

        // Fix all schedules
        $fixed_ids = $this->scheduleModel->fixAllSchedulesAvailableSeats();

        $_SESSION['success'] = 'Berhasil memperbaiki ' . count($fixed_ids) . ' jadwal dan melepas ' . count($orphaned_seats) . ' kursi yang tidak terpakai.';
        header('Location: ' . BASEURL . 'admin/schedules');
        exit;
    }

    /* -------------------------
     * Booking management methods
     * - /admin/bookings -> bookings()
     * - /admin/bookings/view/{id} -> bookingsView($id)
     * - /admin/bookings/delete/{id} -> bookingsDelete($id)
     */
    public function bookings()
    {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('Location: ' . BASEURL . 'auth/login');
            exit;
        }

        $bookings = $this->bookingModel->getAll();
        $this->renderDashboard('admin/bookings/index', ['bookings' => $bookings]);
    }

    public function bookingsView($id = null)
    {
        if (!$id) {
            header('Location: ' . BASEURL . 'admin/bookings');
            exit;
        }

        $booking = $this->bookingModel->findById($id);
        if (!$booking) {
            header('Location: ' . BASEURL . 'admin/bookings');
            exit;
        }

        $this->renderDashboard('admin/bookings/show', ['booking' => $booking]);
    }

    public function bookingsDelete($id = null)
    {
        if ($id) {
            // Get booking before delete
            $booking = $this->bookingModel->findById($id);

            if ($booking) {
                // Release booked seats back to available
                $passengers = $this->bookingModel->getPassengers($id);
                $seat_ids = [];
                foreach ($passengers as $passenger) {
                    if (!empty($passenger['seat_id'])) {
                        $seat_ids[] = $passenger['seat_id'];
                    }
                }
                if (!empty($seat_ids)) {
                    $this->seatModel->updateMultipleStatus($seat_ids, 'available');
                }

                // Restore available seats count
                $schedule = $this->scheduleModel->findById($booking['schedule_id']);
                if ($schedule) {
                    $new_available = $schedule['available_seats'] + $booking['total_passengers'];
                    $this->scheduleModel->update($booking['schedule_id'], array_merge($schedule, ['available_seats' => $new_available]));
                }

                // Delete booking (and passengers via cascade)
                $this->bookingModel->delete($id);
            }
        }
        header('Location: ' . BASEURL . 'admin/bookings');
        exit;
    }

    public function bookingsEdit($id = null)
    {
        if (!$id) {
            header('Location: ' . BASEURL . 'admin/bookings');
            exit;
        }

        // POST -> update booking status/notes
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $status = $_POST['booking_status'] ?? 'pending';
            $notes = $_POST['notes'] ?? null;
            $this->bookingModel->update($id, ['booking_status' => $status, 'notes' => $notes]);
            header('Location: ' . BASEURL . 'admin/bookings/view/' . $id);
            exit;
        }

        $booking = $this->bookingModel->findById($id);
        if (!$booking) {
            header('Location: ' . BASEURL . 'admin/bookings');
            exit;
        }

        $passengers = $this->passengerModel->getByBooking($id);
        $data = ['booking' => $booking, 'passengers' => $passengers];
        $this->renderDashboard('admin/bookings/edit', $data);
    }

    // URL: /admin/bookings/addpassenger/{booking_id}
    public function bookingsAddpassenger($booking_id = null)
    {
        if (!$booking_id) {
            header('Location: ' . BASEURL . 'admin/bookings');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'booking_id' => $booking_id,
                'seat_id' => $_POST['seat_id'] ?? null,
                'full_name' => trim($_POST['full_name'] ?? ''),
                'id_card_type' => $_POST['id_card_type'] ?? 'ktp',
                'id_card_number' => $_POST['id_card_number'] ?? null,
                'phone' => $_POST['phone'] ?? null,
                'special_request' => $_POST['special_request'] ?? null,
            ];

            if ($data['full_name'] !== '') {
                $this->passengerModel->create($data);
            }
        }

        header('Location: ' . BASEURL . 'admin/bookings/edit/' . $booking_id);
        exit;
    }

    // URL: /admin/bookings/deletepassenger/{passenger_id}
    public function bookingsDeletepassenger($passenger_id = null)
    {
        if ($passenger_id) {
            $p = $this->passengerModel->findById($passenger_id);
            $booking_id = $p['booking_id'] ?? null;
            $this->passengerModel->delete($passenger_id);
            if ($booking_id) {
                header('Location: ' . BASEURL . 'admin/bookings/edit/' . $booking_id);
                exit;
            }
        }
        header('Location: ' . BASEURL . 'admin/bookings');
        exit;
    }

    // ========================================
    // Payment Management Methods
    // ========================================
    // URL: /admin/payments
    public function payments($page = 1)
    {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('Location: ' . BASEURL . 'auth/login');
            exit;
        }

        $page = max(1, intval($page));
        $perPage = 10;
        $offset = ($page - 1) * $perPage;

        // Handle search
        $search = trim($_GET['search'] ?? '');

        if ($search) {
            $payments = $this->paymentModel->search($search);
            $total = count($payments);
            $payments = array_slice($payments, $offset, $perPage);
        } else {
            $total = $this->paymentModel->count();
            $payments = $this->paymentModel->getAll($perPage, $offset);
        }

        $totalPages = ceil($total / $perPage);
        $statistics = $this->paymentModel->getStatistics();

        $data = [
            'payments' => $payments,
            'page' => $page,
            'totalPages' => $totalPages,
            'total' => $total,
            'search' => $search,
            'statistics' => $statistics
        ];

        $this->renderDashboard('admin/payments/index', $data);
    }

    // URL: /admin/payments/{id}
    public function paymentsView($id = null)
    {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('Location: ' . BASEURL . 'auth/login');
            exit;
        }

        if (!$id) {
            header('Location: ' . BASEURL . 'admin/payments');
            exit;
        }

        $payment = $this->paymentModel->findById($id);
        if (!$payment) {
            header('Location: ' . BASEURL . 'admin/payments');
            exit;
        }

        // Handle approval/rejection/refund
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
            $action = $_POST['action'];

            if ($action === 'approve') {
                $this->paymentModel->approvePayment($id);
                if ($payment['booking_id']) {
                    $this->bookingModel->update($payment['booking_id'], ['booking_status' => 'confirmed']);
                }
                header('Location: ' . BASEURL . 'admin/payments/' . $id);
                exit;
            } elseif ($action === 'reject') {
                $reason = trim($_POST['reason'] ?? 'Pembayaran ditolak');
                $this->paymentModel->rejectPayment($id, $reason);

                // Release booked seats back to available
                if ($payment['booking_id']) {
                    $passengers = $this->bookingModel->getPassengers($payment['booking_id']);
                    $seat_ids = [];
                    foreach ($passengers as $passenger) {
                        if (!empty($passenger['seat_id'])) {
                            $seat_ids[] = $passenger['seat_id'];
                        }
                    }
                    if (!empty($seat_ids)) {
                        $this->seatModel->updateMultipleStatus($seat_ids, 'available');
                    }
                }

                header('Location: ' . BASEURL . 'admin/payments/' . $id);
                exit;
            } elseif ($action === 'refund') {
                $reason = trim($_POST['refund_reason'] ?? 'Pengembalian dana');
                $this->paymentModel->refundPayment($id, $reason);
                if ($payment['booking_id']) {
                    $this->bookingModel->update($payment['booking_id'], ['booking_status' => 'cancelled']);

                    // Release booked seats back to available
                    $passengers = $this->bookingModel->getPassengers($payment['booking_id']);
                    $seat_ids = [];
                    foreach ($passengers as $passenger) {
                        if (!empty($passenger['seat_id'])) {
                            $seat_ids[] = $passenger['seat_id'];
                        }
                    }
                    if (!empty($seat_ids)) {
                        $this->seatModel->updateMultipleStatus($seat_ids, 'available');
                    }
                }
                header('Location: ' . BASEURL . 'admin/payments/' . $id);
                exit;
            }
        }

        $data = ['payment' => $payment];
        $this->renderDashboard('admin/payments/show', $data);
    }

    // URL: /admin/payments/create
    public function paymentsCreate()
    {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('Location: ' . BASEURL . 'auth/login');
            exit;
        }

        $bookings = $this->bookingModel->getAllPending();
        $data = ['bookings' => $bookings];
        $this->renderDashboard('admin/payments/form', $data);
    }

    // URL: /admin/payments/store
    public function paymentsStore()
    {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('Location: ' . BASEURL . 'auth/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASEURL . 'admin/payments/create');
            exit;
        }

        $booking_id = intval($_POST['booking_id'] ?? 0);
        $payment_method = trim($_POST['payment_method'] ?? '');
        $payment_code = trim($_POST['payment_code'] ?? '');
        $amount = floatval($_POST['amount'] ?? 0);

        if (!$booking_id || !$payment_method || !$amount) {
            $_SESSION['error'] = 'Semua field harus diisi';
            header('Location: ' . BASEURL . 'admin/payments/create');
            exit;
        }

        $booking = $this->bookingModel->findById($booking_id);
        if (!$booking) {
            $_SESSION['error'] = 'Booking tidak ditemukan';
            header('Location: ' . BASEURL . 'admin/payments/create');
            exit;
        }

        $paymentData = compact('booking_id', 'payment_method', 'payment_code', 'amount');
        $paymentData['payment_status'] = 'pending';

        if ($this->paymentModel->create($paymentData)) {
            $_SESSION['success'] = 'Pembayaran berhasil dibuat';
            header('Location: ' . BASEURL . 'admin/payments');
        } else {
            $_SESSION['error'] = 'Gagal membuat pembayaran';
            header('Location: ' . BASEURL . 'admin/payments/create');
        }
        exit;
    }

    // URL: /admin/payments/{id}/edit
    public function paymentsEdit($id = null)
    {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('Location: ' . BASEURL . 'auth/login');
            exit;
        }

        if (!$id) {
            header('Location: ' . BASEURL . 'admin/payments');
            exit;
        }

        $payment = $this->paymentModel->findById($id);
        if (!$payment) {
            header('Location: ' . BASEURL . 'admin/payments');
            exit;
        }

        $data = ['payment' => $payment];
        $this->renderDashboard('admin/payments/form', $data);
    }

    // URL: /admin/payments/{id}/update
    public function paymentsUpdate($id = null)
    {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('Location: ' . BASEURL . 'auth/login');
            exit;
        }

        if (!$id) {
            header('Location: ' . BASEURL . 'admin/payments');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASEURL . 'admin/payments/' . $id);
            exit;
        }

        $payment_method = trim($_POST['payment_method'] ?? '');
        $payment_code = trim($_POST['payment_code'] ?? '');
        $amount = floatval($_POST['amount'] ?? 0);

        if (!$payment_method || !$amount) {
            $_SESSION['error'] = 'Semua field harus diisi';
            header('Location: ' . BASEURL . 'admin/payments/' . $id . '/edit');
            exit;
        }

        $paymentData = compact('payment_method', 'payment_code', 'amount');

        if ($this->paymentModel->update($id, $paymentData)) {
            $_SESSION['success'] = 'Pembayaran berhasil diperbarui';
            header('Location: ' . BASEURL . 'admin/payments/' . $id);
        } else {
            $_SESSION['error'] = 'Gagal memperbarui pembayaran';
            header('Location: ' . BASEURL . 'admin/payments/' . $id . '/edit');
        }
        exit;
    }

    // URL: /admin/payments/{id}/delete
    public function paymentsDelete($id = null)
    {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('Location: ' . BASEURL . 'auth/login');
            exit;
        }

        if ($id) {
            $this->paymentModel->delete($id);
            $_SESSION['success'] = 'Pembayaran berhasil dihapus';
        }

        header('Location: ' . BASEURL . 'admin/payments');
        exit;
    }

    /* -------------------------
     * User management methods
     * URL patterns (via App routing):
     * - /admin/users -> users()
     * - /admin/users/create -> usersCreate()
     * - /admin/users/edit/{id} -> usersEdit($id)
     * - /admin/users/delete/{id} -> usersDelete($id)
     */
    public function users()
    {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('Location: ' . BASEURL . 'auth/login');
            exit;
        }

        $search = $_GET['search'] ?? '';
        if (!empty($search)) {
            $users = $this->userModel->getFilteredVerifiedUsers($search);
        } else {
            $users = $this->userModel->getVerifiedUsers();
        }

        $data = [
            'users' => $users,
            'search' => $search
        ];
        $this->renderDashboard('admin/users/index', $data);
    }

    public function usersCreate()
    {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('Location: ' . BASEURL . 'auth/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => trim($_POST['name'] ?? ''),
                'email' => trim($_POST['email'] ?? ''),
                'phone' => trim($_POST['phone'] ?? ''),
                'password' => $_POST['password'] ?? '',
                'role' => $_POST['role'] ?? 'user',
                'is_verified' => isset($_POST['is_verified']) ? 1 : 0,
            ];

            // Basic validation
            if (empty($data['name']) || empty($data['email']) || empty($data['password'])) {
                // Handle error - maybe pass error message to view
                $this->renderDashboard('admin/users/form', ['errors' => ['All fields except phone are required.'], 'old' => $data]);
                return;
            }

            if ($this->userModel->create($data)) {
                header('Location: ' . BASEURL . 'admin/users');
                exit;
            } else {
                // Handle error
                $this->renderDashboard('admin/users/form', ['errors' => ['Failed to create user.'], 'old' => $data]);
                return;
            }
        }

        $this->renderDashboard('admin/users/form');
    }

    public function usersEdit($id = null)
    {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin' || !$id) {
            header('Location: ' . BASEURL . 'auth/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => trim($_POST['name'] ?? ''),
                'email' => trim($_POST['email'] ?? ''),
                'phone' => trim($_POST['phone'] ?? ''),
                'password' => $_POST['password'] ?? '', // Password is optional on update
                'role' => $_POST['role'] ?? 'user',
                'is_verified' => isset($_POST['is_verified']) ? 1 : 0,
            ];

            if (empty($data['name']) || empty($data['email'])) {
                $user = $this->userModel->findById($id);
                $this->renderDashboard('admin/users/form', ['errors' => ['Name and Email are required.'], 'user' => $user]);
                return;
            }

            if ($this->userModel->update($id, $data)) {
                header('Location: ' . BASEURL . 'admin/users');
                exit;
            } else {
                // Handle error
                $user = $this->userModel->findById($id);
                $this->renderDashboard('admin/users/form', ['errors' => ['Failed to update user.'], 'user' => $user]);
                return;
            }
        }

        $user = $this->userModel->findById($id);
        if (!$user) {
            header('Location: ' . BASEURL . 'admin/users');
            exit;
        }

        $this->renderDashboard('admin/users/form', ['user' => $user]);
    }

    public function usersDelete($id = null)
    {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin' || !$id) {
            header('Location: ' . BASEURL . 'auth/login');
            exit;
        }

        // to prevent admin from deleting themselves
        if (isset($_SESSION['user_id']) && $id == $_SESSION['user_id']) {
            // Cannot delete self, maybe set a flash message
            header('Location: ' . BASEURL . 'admin/users');
            exit;
        }


        $this->userModel->delete($id);
        header('Location: ' . BASEURL . 'admin/users');
        exit;
    }
}
