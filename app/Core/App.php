<?php

class App
{
    protected $controller = 'HomeController';
    protected $method = 'index';
    protected $params = [];

    public function __construct()
    {
        $url = $this->parseUrl();

        // mencari controller
        // Menggunakan ucfirst untuk memastikan huruf pertama controller kapital (e.g., auth -> Auth)
        $controllerIndex = 0;
        if (isset($url[0]) && file_exists('../app/Controllers/' . ucfirst($url[0]) . 'Controller.php')) {
            $this->controller = ucfirst($url[0]) . 'Controller';
            $controllerIndex = 1; // Start looking for method from index 1
        }

        require_once '../app/Controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        // mencari method - support multi-part method names like buses/create -> busesCreate()
        if (isset($url[$controllerIndex])) {
            // Support pattern: resource/{id}/action -> resourceAction(id)
            if (isset($url[$controllerIndex + 2]) && is_numeric($url[$controllerIndex + 1]) && method_exists($this->controller, $url[$controllerIndex] . ucfirst($url[$controllerIndex + 2]))) {
                $this->method = $url[$controllerIndex] . ucfirst($url[$controllerIndex + 2]);
                // leave the id as the single param
                $this->params = [$url[$controllerIndex + 1]];
                // we handled routing, so skip the usual param extraction below by setting controllerIndex beyond
                $controllerIndex += 3;
            }
            // Try compound method first (e.g., buses + create -> busesCreate)
            elseif (isset($url[$controllerIndex + 1]) && method_exists($this->controller, $url[$controllerIndex] . ucfirst($url[$controllerIndex + 1]))) {
                $this->method = $url[$controllerIndex] . ucfirst($url[$controllerIndex + 1]);
                $controllerIndex += 2;
            }
            // Try direct method
            elseif (method_exists($this->controller, $url[$controllerIndex])) {
                $this->method = $url[$controllerIndex];
                $controllerIndex += 1;
            }
        }

        // mendapatkan parameter - extract remaining URL parts (only if not set earlier)
        if (empty($this->params)) {
            $this->params = array_slice($url, $controllerIndex);
        }

        // menjalankan controller & method dengan parameter
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function parseUrl()
    {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
        return [];
    }
}
