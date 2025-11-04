<?php

class AuthController extends Controller
{
    public function index()
    {
        // Redirect ke halaman login
        header('Location: ' . BASEURL . 'auth/login');
        exit;
    }

    public function login()
    {
        // Tampilkan halaman login
        $this->view('auth/login');
    }

    public function authenticate()
    {
        // Proses login akan ditambahkan di sini
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // TODO: Implementasi logika autentikasi
        }
    }
}
