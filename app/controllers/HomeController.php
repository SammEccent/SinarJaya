<?php

class HomeController extends Controller
{
    // Constructor
    public function __construct()
    {
        // You can initialize anything here
    }

    /**
     * Display the landing page
     */
    public function index()
    {
        // Clear any previous search errors
        unset($_SESSION['search_errors']);
        unset($_SESSION['old']);

        // Get popular routes
        $routeModel = $this->model('RouteModel');
        $popularRoutes = $routeModel->getPopularRoutes(2);

        // Get data for the landing page
        $data = [
            'title' => 'Beranda',
            'popularRoutes' => $popularRoutes
        ];

        // Render the layout with landing page content
        $this->renderWithLayout('home/landing', $data);
    }

    /**
     * Display the about page
     */
    public function about()
    {
        // Get data for the about page
        $data = [
            'title' => 'Tentang Kami'
        ];

        // Render the layout with about page content
        $this->renderWithLayout('home/about', $data);
    }

    /**
     * Display the privacy policy page
     */
    public function privacy()
    {
        // Get data for the privacy page
        $data = [
            'title' => 'Kebijakan Privasi'
        ];

        // Render the layout with privacy page content
        $this->renderWithLayout('home/privacy', $data);
    }

    /**
     * Display the terms and conditions page
     */
    public function terms()
    {
        // Get data for the terms page
        $data = [
            'title' => 'Syarat & Ketentuan'
        ];

        // Render the layout with terms page content
        $this->renderWithLayout('home/terms', $data);
    }

    /**
     * Search for available tickets
     */
    public function search()
    {
        // Get search parameters
        $origin = isset($_GET['origin']) ? trim($_GET['origin']) : '';
        $destination = isset($_GET['destination']) ? trim($_GET['destination']) : '';
        $departure = isset($_GET['departure']) ? trim($_GET['departure']) : '';
        $passengers = isset($_GET['passengers']) ? intval($_GET['passengers']) : 1;

        // Validate inputs
        $errors = [];
        if (empty($origin)) {
            $errors[] = 'Kota asal harus dipilih';
        }
        if (empty($destination)) {
            $errors[] = 'Kota tujuan harus dipilih';
        }
        if ($origin === $destination) {
            $errors[] = 'Kota asal dan tujuan tidak boleh sama';
        }
        if (empty($departure)) {
            $errors[] = 'Tanggal keberangkatan harus dipilih';
        } else {
            // Validate date format and not in the past
            $departureDate = strtotime($departure);
            $today = strtotime(date('Y-m-d'));
            if ($departureDate < $today) {
                $errors[] = 'Tanggal keberangkatan tidak boleh di masa lalu';
            }
        }
        if ($passengers < 1 || $passengers > 30) {
            $errors[] = 'Jumlah penumpang harus antara 1-30';
        }

        // If there are errors, redirect back with errors
        if (!empty($errors)) {
            $_SESSION['search_errors'] = $errors;
            $_SESSION['old'] = $_GET;
            header('Location: ' . BASEURL);
            exit;
        }

        // Load models
        $scheduleModel = $this->model('ScheduleModel');
        $routeModel = $this->model('RouteModel');
        $busModel = $this->model('BusModel');

        // Search for schedules
        $schedules = $scheduleModel->searchSchedules($origin, $destination, $departure, $passengers);

        // Prepare data for view
        $data = [
            'title' => 'Hasil Pencarian Tiket',
            'schedules' => $schedules,
            'origin' => $origin,
            'destination' => $destination,
            'departure' => $departure,
            'passengers' => $passengers,
            'search_date' => date('d F Y', strtotime($departure))
        ];

        // Render search results page
        $this->renderWithLayout('home/search-results', $data);
    }
}
