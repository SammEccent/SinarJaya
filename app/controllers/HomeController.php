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
        // Get data for the landing page
        $data = [
            'title' => 'Beranda'
        ];

        // Render the layout with landing page content
        $this->renderWithLayout('home/landing', $data);
    }

    /**
     * Render view with main layout
     * 
     * @param string $view The view file to render
     * @param array $data Data to pass to the view
     */
    protected function renderWithLayout($view, $data = [])
    {
        // Extract data to make variables available in views
        extract($data);

        // Start output buffering to capture the view content
        ob_start();

        // Require the view file
        if (file_exists('../app/Views/' . $view . '.php')) {
            require_once '../app/Views/' . $view . '.php';
        } else {
            die('View does not exist: ' . $view);
        }

        // Get the view content
        $content = ob_get_clean();

        // Now require the layout and pass the content
        if (file_exists('../app/Views/layouts/main.php')) {
            require_once '../app/Views/layouts/main.php';
        } else {
            die('Layout does not exist');
        }
    }
}
