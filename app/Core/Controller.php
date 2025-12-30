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
            // If it does not exist, throw an error
            die('View does not exist: ' . $view);
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
            // If it does not exist, throw an error
            die('Model does not exist: ' . $model);
        }
    }
}
