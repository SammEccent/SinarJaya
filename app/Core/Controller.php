<?php

class Controller
{
    public function view($view, $data = [])
    {
        // Extract the data array to make variables available in the view
        // For example, if $data contains ['pageTitle' => 'Home'],
        // then $pageTitle will be available in the view.
        extract($data);

        // Check if the view file exists
        if (file_exists('../app/Views/' . $view . '.php')) {
            // If it exists, require the view file
            require_once '../app/Views/' . $view . '.php';
        } else {
            // If it does not exist, log and show user-friendly error
            error_log('View does not exist: ' . $view);
            http_response_code(500);
            die('Terjadi kesalahan sistem. Silakan hubungi administrator.');
        }
    }

    public function model($model)
    {
        // Check if the model file exists
        if (file_exists('../app/Models/' . $model . '.php')) {
            // If it exists, require the model file
            require_once '../app/Models/' . $model . '.php';
            // Create an instance of the model and return it
            return new $model;
        } else {
            // If it does not exist, log and show user-friendly error
            error_log('Model does not exist: ' . $model);
            http_response_code(500);
            die('Terjadi kesalahan sistem. Silakan hubungi administrator.');
        }
    }

    /**
     * Render view with layout
     * Menggabungkan view dengan layout main.php
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
            error_log('View does not exist: ' . $view);
            http_response_code(500);
            die('Terjadi kesalahan sistem. Silakan hubungi administrator.');
        }

        // Get the view content
        $content = ob_get_clean();

        // Now require the layout and pass the content
        if (file_exists('../app/Views/layouts/main.php')) {
            require_once '../app/Views/layouts/main.php';
        } else {
            error_log('Layout does not exist');
            http_response_code(500);
            die('Terjadi kesalahan sistem. Silakan hubungi administrator.');
        }
    }
}
