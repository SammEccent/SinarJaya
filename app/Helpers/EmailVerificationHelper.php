<?php

/**
 * Email Verification Helper
 * Helper untuk menangani proses verifikasi email user
 */
class EmailVerificationHelper
{
    /**
     * Generate verification token
     * 
     * @return string 64-character random token
     */
    public static function generateToken()
    {
        return bin2hex(random_bytes(32));
    }

    /**
     * Send verification email to user
     * 
     * @param string $email User email address
     * @param string $token Verification token
     * @param string $name User name
     * @return array ['success' => bool, 'message' => string]
     */
    public static function sendVerificationEmail($email, $token, $name)
    {
        try {
            // Validate email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return [
                    'success' => false,
                    'message' => 'Email tidak valid'
                ];
            }

            // Validate required fields
            if (empty($token) || empty($name)) {
                return [
                    'success' => false,
                    'message' => 'Token dan nama harus diisi'
                ];
            }

            // Load PHPMailer
            if (!file_exists(__DIR__ . '/../../vendor/autoload.php')) {
                throw new Exception('PHPMailer tidak ditemukan. Jalankan composer install.');
            }

            require_once __DIR__ . '/../../vendor/autoload.php';

            $mail = new \PHPMailer\PHPMailer\PHPMailer(true);

            // SMTP Configuration
            $mail->isSMTP();
            $mail->Host = MAIL_HOST;
            $mail->SMTPAuth = true;
            $mail->Username = MAIL_USERNAME;
            $mail->Password = MAIL_PASSWORD;
            $mail->SMTPSecure = MAIL_ENCRYPTION;
            $mail->Port = MAIL_PORT;
            $mail->CharSet = 'UTF-8';

            // Sender and recipient
            $mail->setFrom(MAIL_FROM_ADDRESS, MAIL_FROM_NAME);
            $mail->addAddress($email, $name);

            // Build verification URL
            $verificationUrl = BASEURL . 'auth/verify?token=' . urlencode($token);

            // Email content
            $mail->isHTML(true);
            $mail->Subject = 'Verifikasi Email - Sinar Jaya Bus';
            $mail->Body = self::getEmailTemplate($name, $verificationUrl);
            $mail->AltBody = self::getEmailTextVersion($name, $verificationUrl);

            // Send email
            if ($mail->send()) {
                return [
                    'success' => true,
                    'message' => 'Email verifikasi berhasil dikirim'
                ];
            } else {
                error_log('Email verification failed: ' . $mail->ErrorInfo);
                return [
                    'success' => false,
                    'message' => 'Gagal mengirim email: ' . $mail->ErrorInfo
                ];
            }
        } catch (\PHPMailer\PHPMailer\Exception $e) {
            error_log('PHPMailer Exception: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error PHPMailer: ' . $e->getMessage()
            ];
        } catch (Exception $e) {
            error_log('Email Exception: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Get HTML email template
     * 
     * @param string $name User name
     * @param string $verificationUrl Verification URL
     * @return string HTML template
     */
    private static function getEmailTemplate($name, $verificationUrl)
    {
        return "
            <html>
            <head>
                <style>
                    body { 
                        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
                        line-height: 1.6; 
                        color: #333; 
                        background-color: #f4f4f4;
                        margin: 0;
                        padding: 0;
                    }
                    .email-container { 
                        max-width: 600px; 
                        margin: 20px auto; 
                        background-color: #ffffff;
                        border-radius: 8px;
                        overflow: hidden;
                        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
                    }
                    .header { 
                        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
                        color: white; 
                        padding: 30px 20px; 
                        text-align: center; 
                    }
                    .header h2 {
                        margin: 0;
                        font-size: 24px;
                        font-weight: 600;
                    }
                    .content { 
                        padding: 30px 20px; 
                        background-color: #ffffff;
                    }
                    .content p {
                        margin-bottom: 15px;
                        color: #374151;
                    }
                    .button-container {
                        text-align: center;
                        margin: 30px 0;
                    }
                    .button { 
                        display: inline-block; 
                        padding: 14px 40px; 
                        background-color: #2563eb; 
                        color: white !important; 
                        text-decoration: none; 
                        border-radius: 6px; 
                        font-weight: 600;
                        font-size: 16px;
                        transition: background-color 0.3s;
                    }
                    .button:hover {
                        background-color: #1d4ed8;
                    }
                    .link-box {
                        background-color: #f9fafb;
                        padding: 15px;
                        border-radius: 6px;
                        border: 1px solid #e5e7eb;
                        margin: 20px 0;
                        word-break: break-all;
                    }
                    .link-box p {
                        margin: 0;
                        font-size: 12px;
                        color: #6b7280;
                    }
                    .link-box a {
                        color: #2563eb;
                        text-decoration: none;
                        font-size: 13px;
                    }
                    .warning {
                        background-color: #fef3c7;
                        border-left: 4px solid #f59e0b;
                        padding: 15px;
                        margin: 20px 0;
                        border-radius: 4px;
                    }
                    .warning p {
                        margin: 0;
                        color: #92400e;
                        font-size: 13px;
                    }
                    .footer { 
                        text-align: center; 
                        padding: 20px; 
                        background-color: #f9fafb;
                        border-top: 1px solid #e5e7eb;
                    }
                    .footer p {
                        margin: 5px 0;
                        font-size: 12px; 
                        color: #6b7280;
                    }
                    .footer a {
                        color: #2563eb;
                        text-decoration: none;
                    }
                </style>
            </head>
            <body>
                <div class='email-container'>
                    <div class='header'>
                        <h2>🚌 Selamat Datang di Sinar Jaya Bus!</h2>
                    </div>
                    <div class='content'>
                        <p>Hi <strong>" . htmlspecialchars($name) . "</strong>,</p>
                        <p>Terima kasih telah mendaftar di Sinar Jaya Bus. Untuk melanjutkan, silakan verifikasi alamat email Anda dengan mengklik tombol di bawah ini:</p>
                        
                        <div class='button-container'>
                            <a href='" . htmlspecialchars($verificationUrl) . "' class='button'>✓ Verifikasi Email Saya</a>
                        </div>
                        
                        <div class='link-box'>
                            <p>Atau copy dan paste link berikut ke browser Anda:</p>
                            <a href='" . htmlspecialchars($verificationUrl) . "'>" . htmlspecialchars($verificationUrl) . "</a>
                        </div>
                        
                        <div class='warning'>
                            <p><strong>⚠️ Penting:</strong> Link verifikasi ini akan berlaku selama 24 jam. Setelah itu, Anda perlu meminta link verifikasi baru.</p>
                        </div>
                        
                        <p>Setelah verifikasi berhasil, Anda dapat login dan menikmati layanan kami:</p>
                        <ul style='color: #374151; line-height: 1.8;'>
                            <li>Pemesanan tiket bus online</li>
                            <li>Pilihan rute dan jadwal lengkap</li>
                            <li>Pembayaran mudah dan aman</li>
                            <li>Riwayat pemesanan</li>
                        </ul>
                        
                        <p style='color: #6b7280; font-size: 13px; margin-top: 20px;'>Jika Anda tidak mendaftar di Sinar Jaya Bus, abaikan email ini dan akun tidak akan diaktifkan.</p>
                    </div>
                    <div class='footer'>
                        <p><strong>© 2024 Sinar Jaya Bus</strong></p>
                        <p>Layanan Premium Bus Travel Indonesia</p>
                        <p style='margin-top: 10px;'>
                            <a href='" . BASEURL . "'>Kunjungi Website</a> | 
                            <a href='mailto:" . MAIL_FROM_ADDRESS . "'>Hubungi Kami</a>
                        </p>
                        <p style='color: #9ca3af; font-size: 11px; margin-top: 10px;'>
                            Email ini dikirim secara otomatis. Mohon jangan membalas email ini.
                        </p>
                    </div>
                </div>
            </body>
            </html>
        ";
    }

    /**
     * Get plain text email version
     * 
     * @param string $name User name
     * @param string $verificationUrl Verification URL
     * @return string Plain text email
     */
    private static function getEmailTextVersion($name, $verificationUrl)
    {
        return "
Selamat Datang di Sinar Jaya Bus!

Hi {$name},

Terima kasih telah mendaftar di Sinar Jaya Bus. Untuk melanjutkan, silakan verifikasi alamat email Anda dengan mengklik link di bawah ini:

{$verificationUrl}

Link verifikasi ini akan berlaku selama 24 jam.

Setelah verifikasi berhasil, Anda dapat login dan menikmati layanan kami:
- Pemesanan tiket bus online
- Pilihan rute dan jadwal lengkap
- Pembayaran mudah dan aman
- Riwayat pemesanan

Jika Anda tidak mendaftar di Sinar Jaya Bus, abaikan email ini.

---
© 2024 Sinar Jaya Bus
Layanan Premium Bus Travel Indonesia
Website: " . BASEURL . "
Email: " . MAIL_FROM_ADDRESS . "

Email ini dikirim secara otomatis. Mohon jangan membalas email ini.
        ";
    }

    /**
     * Verify token validity
     * 
     * @param string $token Verification token
     * @param UserModel $userModel User model instance
     * @return array ['valid' => bool, 'user' => array|null, 'message' => string]
     */
    public static function verifyToken($token, $userModel)
    {
        try {
            // Validate token format
            if (empty($token) || strlen($token) !== 64) {
                return [
                    'valid' => false,
                    'user' => null,
                    'message' => 'Format token tidak valid'
                ];
            }

            // Find user by token
            $user = $userModel->findByVerificationToken($token);

            if (!$user) {
                return [
                    'valid' => false,
                    'user' => null,
                    'message' => 'Token tidak ditemukan atau sudah digunakan'
                ];
            }

            // Check if user already verified
            if ($user['is_verified'] == 1) {
                return [
                    'valid' => false,
                    'user' => $user,
                    'message' => 'Email sudah diverifikasi sebelumnya'
                ];
            }

            return [
                'valid' => true,
                'user' => $user,
                'message' => 'Token valid'
            ];
        } catch (Exception $e) {
            error_log('Token verification error: ' . $e->getMessage());
            return [
                'valid' => false,
                'user' => null,
                'message' => 'Error saat memverifikasi token'
            ];
        }
    }

    /**
     * Mark user as verified
     * 
     * @param string $token Verification token
     * @param UserModel $userModel User model instance
     * @return array ['success' => bool, 'message' => string]
     */
    public static function markAsVerified($token, $userModel)
    {
        try {
            if ($userModel->verifyByToken($token)) {
                return [
                    'success' => true,
                    'message' => 'Email berhasil diverifikasi'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Gagal memverifikasi email'
                ];
            }
        } catch (Exception $e) {
            error_log('Mark as verified error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error saat memverifikasi: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Resend verification email
     * 
     * @param string $email User email
     * @param UserModel $userModel User model instance
     * @return array ['success' => bool, 'message' => string]
     */
    public static function resendVerificationEmail($email, $userModel)
    {
        try {
            // Find user by email
            $user = $userModel->findByEmail($email);

            if (!$user) {
                return [
                    'success' => false,
                    'message' => 'Email tidak terdaftar'
                ];
            }

            // Check if already verified
            if ($user['is_verified'] == 1) {
                return [
                    'success' => false,
                    'message' => 'Email sudah diverifikasi'
                ];
            }

            // Generate new token if not exists
            $token = $user['verification_token'];
            if (empty($token)) {
                $token = self::generateToken();
                // Update token in database
                $userModel->updateVerificationToken($user['id'], $token);
            }

            // Send verification email
            $result = self::sendVerificationEmail($email, $token, $user['name']);

            return $result;
        } catch (Exception $e) {
            error_log('Resend verification error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Check if email verification is properly configured
     * 
     * @return array ['configured' => bool, 'issues' => array]
     */
    public static function checkConfiguration()
    {
        $issues = [];

        // Check required constants
        if (!defined('MAIL_HOST') || empty(MAIL_HOST)) {
            $issues[] = 'MAIL_HOST tidak dikonfigurasi';
        }

        if (!defined('MAIL_PORT') || empty(MAIL_PORT)) {
            $issues[] = 'MAIL_PORT tidak dikonfigurasi';
        }

        if (!defined('MAIL_USERNAME') || empty(MAIL_USERNAME) || MAIL_USERNAME === 'your-email@gmail.com') {
            $issues[] = 'MAIL_USERNAME tidak dikonfigurasi';
        }

        if (!defined('MAIL_PASSWORD') || empty(MAIL_PASSWORD) || MAIL_PASSWORD === 'your-app-password') {
            $issues[] = 'MAIL_PASSWORD tidak dikonfigurasi';
        }

        if (!defined('MAIL_FROM_ADDRESS') || empty(MAIL_FROM_ADDRESS)) {
            $issues[] = 'MAIL_FROM_ADDRESS tidak dikonfigurasi';
        }

        if (!defined('MAIL_FROM_NAME') || empty(MAIL_FROM_NAME)) {
            $issues[] = 'MAIL_FROM_NAME tidak dikonfigurasi';
        }

        // Check PHPMailer
        if (!file_exists(__DIR__ . '/../../vendor/autoload.php')) {
            $issues[] = 'PHPMailer tidak terinstal';
        }

        return [
            'configured' => count($issues) === 0,
            'issues' => $issues
        ];
    }

    /**
     * Get verification link
     * 
     * @param string $token Verification token
     * @return string Verification URL
     */
    public static function getVerificationLink($token)
    {
        return BASEURL . 'auth/verify?token=' . urlencode($token);
    }

    /**
     * Validate email format
     * 
     * @param string $email Email address
     * @return bool True if valid
     */
    public static function isValidEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
}
