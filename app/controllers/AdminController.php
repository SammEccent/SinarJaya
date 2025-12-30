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
            $this->renderDashboard('admin/dashboard');
            return;
        }

        // Not logged in -> redirect to auth login
        header('Location: ' . BASEURL . 'auth/login');
        exit;
    }

    // Helper to render with layout (reuse from HomeController if needed)
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

    // Render dashboard without header/footer
    protected function renderDashboard($view, $data = [])
    {
        extract($data);

        // Check if view is dashboard - if so, include it directly (it has its own structure + CSS)
        if ($view === 'admin/dashboard') {
            // Dashboard has its own complete structure with sidebar and CSS
            echo "<!DOCTYPE html>\n<html lang=\"id\">\n<head>\n    <meta charset=\"utf-8\">\n    <meta name=\"viewport\" content=\"width=device-width,initial-scale=1\">\n    <title>Admin - Sinar Jaya</title>\n    <link href=\"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css\" rel=\"stylesheet\">\n</head>\n<body>\n";
            $viewPath = '../app/Views/' . $view . '.php';
            if (file_exists($viewPath)) {
                require_once $viewPath;
            } else {
                die('View does not exist: ' . $view);
            }
            echo "\n<script src=\"" . BASEURL . "assets/js/main.js\"></script>\n</body>\n</html>";
            return;
        }

        // For other admin views (buses, routes, etc), wrap with sidebar and dashboard CSS from dashboard.php
        echo "<!DOCTYPE html>\n<html lang=\"id\">\n<head>\n    <meta charset=\"utf-8\">\n    <meta name=\"viewport\" content=\"width=device-width,initial-scale=1\">\n    <title>Admin - Sinar Jaya</title>\n    <link href=\"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css\" rel=\"stylesheet\">\n</head>\n<body>\n";

        // Output complete dashboard structure with CSS from dashboard.php
        $dashboardPath = '../app/Views/admin/dashboard.php';
        if (!file_exists($dashboardPath)) {
            die('Dashboard template not found');
        }

        // Start capturing dashboard output (contains sidebar + CSS)
        ob_start();
        require_once $dashboardPath;
        $dashboardHtml = ob_get_clean();

        // Extract the opening <div class="admin-dashboard"> and CSS from dashboard.php
        // Find where <style> starts and ends, extract everything up to </style>
        $cssMatch = preg_match('/<style>(.*?)<\/style>/is', $dashboardHtml, $matches);
        if ($cssMatch) {
            $adminCss = $matches[1];
        } else {
            $adminCss = '';
        }

        // Echo the CSS
        if (!empty($adminCss)) {
            echo "<style>\n" . $adminCss . "\n</style>\n";
        }

        // Output sidebar structure from dashboard
        echo "<div class=\"admin-dashboard\">";
        echo "<div class=\"admin-sidebar\">";
        echo "<div class=\"admin-sidebar-header\"><h2>Sinar Jaya</h2><p>Admin Panel</p></div>";
        echo "<nav class=\"admin-nav\"><ul>";
        echo "<li><a href=\"" . BASEURL . "admin\" class=\"" . (strpos($_SERVER['REQUEST_URI'], '/admin') !== false && strpos($_SERVER['REQUEST_URI'], '/admin/buses') === false && strpos($_SERVER['REQUEST_URI'], '/admin/routes') === false ? 'active' : '') . "\"><i class=\"fas fa-chart-line\"></i> Dashboard</a></li>";
        echo "<li><a href=\"" . BASEURL . "admin/buses\" class=\"" . (strpos($_SERVER['REQUEST_URI'], '/admin/buses') !== false ? 'active' : '') . "\"><i class=\"fas fa-bus\"></i> Kelola Bus</a></li>";
        echo "<li><a href=\"" . BASEURL . "admin/routes\" class=\"" . (strpos($_SERVER['REQUEST_URI'], '/admin/routes') !== false ? 'active' : '') . "\"><i class=\"fas fa-road\"></i> Kelola Rute</a></li>";
        echo "<li><a href=\"" . BASEURL . "admin/schedules\"><i class=\"fas fa-calendar\"></i> Jadwal</a></li>";
        echo "<li><a href=\"" . BASEURL . "admin/bookings\"><i class=\"fas fa-ticket-alt\"></i> Pemesanan</a></li>";
        echo "<li><a href=\"" . BASEURL . "admin/payments\"><i class=\"fas fa-credit-card\"></i> Pembayaran</a></li>";
        echo "<li><a href=\"" . BASEURL . "admin/users\"><i class=\"fas fa-users\"></i> Pengguna</a></li>";
        echo "</ul></nav>";
        echo "<div class=\"admin-sidebar-footer\"><a href=\"" . BASEURL . "auth/logout\" class=\"btn-logout\"><i class=\"fas fa-sign-out-alt\"></i> Logout</a></div>";
        echo "</div>"; // end sidebar

        // Start main content area
        echo "<div class=\"admin-content\">";

        // Include the requested admin view inside the content area
        $viewPath = '../app/Views/' . $view . '.php';
        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            die('View does not exist: ' . $view);
        }

        echo "</div>"; // end admin-content
        echo "</div>"; // end admin-dashboard

        // include admin scripts
        echo "\n<script src=\"" . BASEURL . "assets/js/main.js\"></script>\n</body>\n</html>";
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
            $price_adjustment = floatval($_POST['price_adjustment'] ?? 0);

            if ($seat_number !== '') {
                $this->seatModel->create($bus_id, $seat_number, $seat_type, $price_adjustment);
            }
            header('Location: ' . BASEURL . 'admin/buses/' . $bus_id . '/seats');
            exit;
        }

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

        $schedules = $this->scheduleModel->getAll();
        $data = ['schedules' => $schedules];
        $this->renderDashboard('admin/schedules/index', $data);
    }

    public function schedulesCreate()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $bus_id = intval($_POST['bus_id'] ?? 0);
            $route_id = intval($_POST['route_id'] ?? 0);
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

            if (!empty($errors)) {
                $buses = $this->busModel->getAll();
                $routes = $this->routeModel->getAll();
                $data = ['errors' => $errors, 'old' => compact('bus_id', 'route_id', 'departure_datetime', 'arrival_datetime', 'base_price', 'available_seats', 'status', 'notes'), 'buses' => $buses, 'routes' => $routes];
                $this->renderDashboard('admin/schedules/form', $data);
                return;
            }

            $this->scheduleModel->create(compact('bus_id', 'route_id', 'departure_datetime', 'arrival_datetime', 'base_price', 'available_seats', 'status', 'notes'));
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
            $departure_datetime = trim($_POST['departure_datetime'] ?? '');
            $arrival_datetime = trim($_POST['arrival_datetime'] ?? '');
            $base_price = floatval($_POST['base_price'] ?? 0);
            $available_seats = intval($_POST['available_seats'] ?? 0);
            $status = $_POST['status'] ?? 'scheduled';
            $notes = trim($_POST['notes'] ?? '');

            $this->scheduleModel->update($id, compact('bus_id', 'route_id', 'departure_datetime', 'arrival_datetime', 'base_price', 'available_seats', 'status', 'notes'));
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
            $this->bookingModel->delete($id);
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
}
