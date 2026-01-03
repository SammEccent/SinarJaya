<?php

require_once __DIR__ . '/../Helpers/EmailVerificationHelper.php';

class AuthController extends Controller
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = $this->model('UserModel');
    }

    // Default to login form
    public function index()
    {
        $this->loginForm();
    }

    // Show login form
    public function loginForm()
    {
        $data = ['title' => 'Login'];
        $this->renderWithLayout('admin/login', $data);
    }

    // Handle admin login POST
    public function adminLogin()
    {
        // If request is not POST, show the login form
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->loginForm();
            return;
        }

        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';

        $errors = [];

        if (empty($email)) {
            $errors[] = 'Email harus diisi.';
        }
        if (empty($password)) {
            $errors[] = 'Password harus diisi.';
        }

        if (!empty($errors)) {
            $data = ['title' => 'Login Admin', 'errors' => $errors, 'old' => ['email' => htmlspecialchars($email)]];
            $this->renderWithLayout('admin/login', $data);
            return;
        }

        $user = $this->userModel->findByEmail($email);

        if (!$user) {
            $errors[] = 'Email atau password salah.';
            $data = ['title' => 'Login Admin', 'errors' => $errors, 'old' => ['email' => htmlspecialchars($email)]];
            $this->renderWithLayout('admin/login', $data);
            return;
        }

        // Only allow admin role for admin login
        if (!isset($user['role']) || $user['role'] !== 'admin') {
            $errors[] = 'Akses ditolak. Halaman ini hanya untuk admin.';
            $data = ['title' => 'Login Admin', 'errors' => $errors, 'old' => ['email' => htmlspecialchars($email)]];
            $this->renderWithLayout('admin/login', $data);
            return;
        }

        if (!$this->userModel->verifyPassword($password, $user['password'])) {
            $errors[] = 'Email atau password salah.';
            $data = ['title' => 'Login Admin', 'errors' => $errors, 'old' => ['email' => htmlspecialchars($email)]];
            $this->renderWithLayout('admin/login', $data);
            return;
        }

        // success
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['role'] = $user['role'];

        header('Location: ' . BASEURL . 'admin');
        exit;
    }

    // Handle user login POST
    public function login()
    {
        // If request is not POST, show the user login form
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->userLoginForm();
            return;
        }

        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';

        $errors = [];

        if (empty($email)) {
            $errors[] = 'Email harus diisi.';
        }
        if (empty($password)) {
            $errors[] = 'Password harus diisi.';
        }

        if (!empty($errors)) {
            $data = ['title' => 'Login', 'errors' => $errors, 'old' => ['email' => htmlspecialchars($email)]];
            $this->renderWithLayout('auth/login', $data);
            return;
        }

        $user = $this->userModel->findByEmail($email);

        if (!$user) {
            $errors[] = 'Email atau password salah.';
            $data = ['title' => 'Login', 'errors' => $errors, 'old' => ['email' => htmlspecialchars($email)]];
            $this->renderWithLayout('auth/login', $data);
            return;
        }

        // Check if email is verified
        if (isset($user['is_verified']) && $user['is_verified'] == 0) {
            $errors[] = 'Email Anda belum diverifikasi. Silakan cek email Anda atau <a href="' . BASEURL . 'auth/resendVerificationForm">kirim ulang email verifikasi</a>.';
            $data = ['title' => 'Login', 'errors' => $errors, 'old' => ['email' => htmlspecialchars($email)]];
            $this->renderWithLayout('auth/login', $data);
            return;
        }

        if (!$this->userModel->verifyPassword($password, $user['password'])) {
            $errors[] = 'Email atau password salah.';
            $data = ['title' => 'Login', 'errors' => $errors, 'old' => ['email' => htmlspecialchars($email)]];
            $this->renderWithLayout('auth/login', $data);
            return;
        }

        // success
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['role'] = $user['role'] ?? 'user';

        // Redirect based on role
        if (isset($user['role']) && $user['role'] === 'admin') {
            header('Location: ' . BASEURL . 'admin');
        } else {
            header('Location: ' . BASEURL);
        }
        exit;
    }

    // Show user login form
    public function userLoginForm()
    {
        $data = ['title' => 'Login'];
        $this->renderWithLayout('auth/login', $data);
    }

    // Show registration form
    public function registerForm()
    {
        $data = ['title' => 'Register'];
        $this->renderWithLayout('auth/register', $data);
    }

    // Handle registration POST
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->registerForm();
            return;
        }

        $name = isset($_POST['name']) ? trim($_POST['name']) : '';
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $confirmPassword = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';

        $errors = [];

        if (empty($name)) {
            $errors[] = 'Nama lengkap harus diisi.';
        }
        if (empty($email)) {
            $errors[] = 'Email harus diisi.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Format email tidak valid.';
        } else {
            // Check if email already exists
            if ($this->userModel->findByEmail($email)) {
                $errors[] = 'Email ini sudah terdaftar.';
            }
        }
        if (empty($phone)) {
            $errors[] = 'Nomor telepon harus diisi.';
        }
        if (empty($password)) {
            $errors[] = 'Password harus diisi.';
        } elseif (strlen($password) < 6) {
            $errors[] = 'Password minimal 6 karakter.';
        }
        if ($password !== $confirmPassword) {
            $errors[] = 'Konfirmasi password tidak cocok.';
        }

        if (!empty($errors)) {
            $data = [
                'title' => 'Register',
                'errors' => $errors,
                'old' => [
                    'name' => htmlspecialchars($name),
                    'email' => htmlspecialchars($email),
                    'phone' => htmlspecialchars($phone),
                ]
            ];
            $this->renderWithLayout('auth/register', $data);
            return;
        }

        $userData = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'password' => $password,
            'role' => 'user',
            'is_verified' => 0,
            'verification_token' => EmailVerificationHelper::generateToken()
        ];

        if ($this->userModel->create($userData)) {
            // Send verification email using helper
            $emailResult = EmailVerificationHelper::sendVerificationEmail($email, $userData['verification_token'], $name);

            $data = [
                'title' => 'Register',
                'success_message' => 'Registrasi berhasil! Silakan periksa email Anda untuk memverifikasi akun.'
            ];
            $this->renderWithLayout('auth/register', $data);
        } else {
            $errors[] = 'Terjadi kesalahan saat registrasi. Mohon coba lagi.';
            $data = [
                'title' => 'Register',
                'errors' => $errors,
                'old' => [
                    'name' => htmlspecialchars($name),
                    'email' => htmlspecialchars($email),
                    'phone' => htmlspecialchars($phone),
                ]
            ];
            $this->renderWithLayout('auth/register', $data);
        }
    }

    public function logout()
    {
        unset($_SESSION['user_id'], $_SESSION['user_email'], $_SESSION['role']);
        session_destroy();

        header('Location: ' . BASEURL . 'auth/login');
        exit;
    }

    /**
     * Send verification email to user
     */
    private function sendVerificationEmail($email, $token, $name)
    {
        // PHPMailer already loaded via vendor/autoload.php in app/init.php
        $mail = new \PHPMailer\PHPMailer\PHPMailer();
        try {
            // SMTP configuration
            $mail->isSMTP();
            $mail->Host = MAIL_HOST;
            $mail->SMTPAuth = true;
            $mail->Username = MAIL_USERNAME;
            $mail->Password = MAIL_PASSWORD;
            $mail->SMTPSecure = MAIL_ENCRYPTION;
            $mail->Port = MAIL_PORT;

            // Email content
            $mail->setFrom(MAIL_FROM_ADDRESS, MAIL_FROM_NAME);
            $mail->addAddress($email, $name);

            $verificationUrl = BASEURL . 'auth/verify?token=' . urlencode($token);

            $mail->isHTML(true);
            $mail->Subject = 'Verifikasi Email - Sinar Jaya Bus';
            $mail->Body = "
                <html>
                <head>
                    <style>
                        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                        .header { background-color: #2563eb; color: white; padding: 20px; border-radius: 5px 5px 0 0; text-align: center; }
                        .content { background-color: #f9fafb; padding: 20px; border: 1px solid #e5e7eb; }
                        .button { display: inline-block; padding: 12px 30px; background-color: #2563eb; color: white; text-decoration: none; border-radius: 5px; margin: 20px 0; }
                        .footer { text-align: center; font-size: 12px; color: #6b7280; margin-top: 20px; }
                    </style>
                </head>
                <body>
                    <div class='container'>
                        <div class='header'>
                            <h2>Selamat Datang di Sinar Jaya Bus!</h2>
                        </div>
                        <div class='content'>
                            <p>Hi <strong>{$name}</strong>,</p>
                            <p>Terima kasih telah mendaftar. Silakan verifikasi email Anda dengan mengklik tombol di bawah:</p>
                            <div style='text-align: center;'>
                                <a href='{$verificationUrl}' class='button'>Verifikasi Email</a>
                            </div>
                            <p style='color: #6b7280; font-size: 12px;'>Atau copy link berikut ke browser Anda:</p>
                            <p style='color: #2563eb; word-break: break-all; background-color: white; padding: 10px; border-radius: 3px;'>{$verificationUrl}</p>
                            <p style='color: #ef4444; font-size: 12px;'><strong>Link ini akan berlaku selama 24 jam.</strong></p>
                            <p>Jika Anda tidak mendaftar, abaikan email ini.</p>
                        </div>
                        <div class='footer'>
                            <p>© 2024 Sinar Jaya Bus. All rights reserved.</p>
                            <p>Jangan balas email ini. Hubungi support jika ada pertanyaan.</p>
                        </div>
                    </div>
                </body>
                </html>
            ";

            // Alternative text version
            $mail->AltBody = "Verifikasi Email Sinar Jaya Bus\n\n"
                . "Hi {$name},\n\n"
                . "Silakan klik link di bawah untuk memverifikasi email Anda:\n"
                . "{$verificationUrl}\n\n"
                . "Link ini akan berlaku selama 24 jam.\n"
                . "Jika Anda tidak mendaftar, abaikan email ini.\n\n"
                . "Regards,\n"
                . "Tim Sinar Jaya Bus";

            if ($mail->send()) {
                return true;
            } else {
                error_log('Email verification failed: ' . $mail->ErrorInfo);
                return false;
            }
        } catch (\Exception $e) {
            error_log('Email exception: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Verify user email
     */
    public function verify()
    {
        if (!isset($_GET['token']) || empty($_GET['token'])) {
            $data = [
                'title' => 'Verifikasi Email',
                'error_message' => 'Token verifikasi tidak valid.'
            ];
            require_once '../app/Views/auth/verify-result.php';
            return;
        }

        $token = trim($_GET['token']);

        // Verify token using helper
        $verification = EmailVerificationHelper::verifyToken($token, $this->userModel);

        if (!$verification['valid']) {
            $data = [
                'title' => 'Verifikasi Email',
                'error_message' => $verification['message']
            ];
            require_once '../app/Views/auth/verify-result.php';
            return;
        }

        // Mark as verified using helper
        $result = EmailVerificationHelper::markAsVerified($token, $this->userModel);

        if ($result['success']) {
            $data = [
                'title' => 'Verifikasi Email',
                'success_message' => 'Email berhasil diverifikasi! Anda sekarang dapat login.',
                'redirect_url' => BASEURL . 'auth/login'
            ];
            require_once '../app/Views/auth/verify-result.php';
        } else {
            $data = [
                'title' => 'Verifikasi Email',
                'error_message' => 'Terjadi kesalahan saat memverifikasi email. Mohon coba lagi.'
            ];
            require_once '../app/Views/auth/verify-result.php';
        }
    }

    /**
     * Show resend verification form
     */
    public function resendVerificationForm()
    {
        $data = ['title' => 'Kirim Ulang Verifikasi Email'];
        $this->renderWithLayout('auth/resend-verification', $data);
    }

    /**
     * Resend verification email
     */
    public function resendVerification()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->resendVerificationForm();
            return;
        }

        $email = isset($_POST['email']) ? trim($_POST['email']) : '';

        if (empty($email)) {
            $_SESSION['error'] = 'Email harus diisi';
            header('Location: ' . BASEURL . 'auth/login');
            exit;
        }

        // Resend using helper
        $result = EmailVerificationHelper::resendVerificationEmail($email, $this->userModel);

        if ($result['success']) {
            $_SESSION['success'] = $result['message'];
        } else {
            $_SESSION['error'] = $result['message'];
        }

        header('Location: ' . BASEURL . 'auth/login');
        exit;
    }
}
