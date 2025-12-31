<?php

/**
 * Email Configuration Tester
 * This file helps test SMTP configuration before using in production
 * DELETE or PASSWORD PROTECT this file in production environment
 */

// Include configuration
require_once '../app/config/config.php';

// Set JSON response header
header('Content-Type: application/json');

// Get action
$action = $_GET['action'] ?? ($_POST['action'] ?? null);

// Only allow in development environment
if (ENVIRONMENT === 'production') {
    http_response_code(403);
    echo json_encode(['error' => 'This tool is disabled in production']);
    exit;
}

if ($action === 'check') {
    // Check configuration
    checkConfiguration();
} elseif ($action === 'test' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    // Test email sending
    testEmailSending();
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid action']);
}

/**
 * Check current configuration
 */
function checkConfiguration()
{
    $config = [
        'MAIL_HOST' => [
            'value' => MAIL_HOST,
            'status' => defined('MAIL_HOST') && MAIL_HOST ? 'configured' : 'not_configured'
        ],
        'MAIL_PORT' => [
            'value' => MAIL_PORT,
            'status' => defined('MAIL_PORT') && MAIL_PORT ? 'configured' : 'not_configured'
        ],
        'MAIL_USERNAME' => [
            'value' => defined('MAIL_USERNAME') && MAIL_USERNAME && MAIL_USERNAME !== 'your-email@gmail.com'
                ? '*' . substr(MAIL_USERNAME, -20) : 'Not configured',
            'status' => defined('MAIL_USERNAME') && MAIL_USERNAME && MAIL_USERNAME !== 'your-email@gmail.com'
                ? 'configured' : 'warning'
        ],
        'MAIL_PASSWORD' => [
            'value' => defined('MAIL_PASSWORD') && MAIL_PASSWORD && MAIL_PASSWORD !== 'your-app-password'
                ? '***' . substr(MAIL_PASSWORD, -4) : 'Not configured',
            'status' => defined('MAIL_PASSWORD') && MAIL_PASSWORD && MAIL_PASSWORD !== 'your-app-password'
                ? 'configured' : 'warning'
        ],
        'MAIL_FROM_ADDRESS' => [
            'value' => MAIL_FROM_ADDRESS,
            'status' => defined('MAIL_FROM_ADDRESS') && MAIL_FROM_ADDRESS ? 'configured' : 'not_configured'
        ],
        'MAIL_FROM_NAME' => [
            'value' => MAIL_FROM_NAME,
            'status' => defined('MAIL_FROM_NAME') && MAIL_FROM_NAME ? 'configured' : 'not_configured'
        ]
    ];

    echo json_encode(['config' => $config]);
}

/**
 * Test email sending
 */
function testEmailSending()
{
    $input = json_decode(file_get_contents('php://input'), true);

    // Validate input
    if (!$input || !isset($input['to_email'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing required fields']);
        return;
    }

    $smtpHost = $input['smtp_host'] ?? MAIL_HOST;
    $smtpPort = $input['smtp_port'] ?? MAIL_PORT;
    $smtpUser = $input['smtp_user'] ?? MAIL_USERNAME;
    $smtpPass = $input['smtp_pass'] ?? MAIL_PASSWORD;
    $fromAddress = $input['from_address'] ?? MAIL_FROM_ADDRESS;
    $fromName = $input['from_name'] ?? MAIL_FROM_NAME;
    $toEmail = $input['to_email'] ?? null;

    // Validate email
    if (!filter_var($toEmail, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['error' => 'Invalid email address']);
        return;
    }

    try {
        // Check if PHPMailer is available
        if (!file_exists('../vendor/autoload.php')) {
            throw new Exception('PHPMailer not found. Run composer install.');
        }

        require_once '../vendor/autoload.php';

        $mail = new PHPMailer\PHPMailer\PHPMailer(true);

        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host = $smtpHost;
        $mail->Port = (int)$smtpPort;
        $mail->SMTPAuth = true;
        $mail->Username = $smtpUser;
        $mail->Password = $smtpPass;
        $mail->SMTPSecure = 'tls';
        $mail->CharSet = 'UTF-8';

        // Sender and recipient
        $mail->setFrom($fromAddress, $fromName);
        $mail->addAddress($toEmail);

        // Email content
        $mail->isHTML(true);
        $mail->Subject = 'Test Email - Sinar Jaya Bus';
        $mail->Body = '
            <html>
            <head>
                <style>
                    body { font-family: Arial, sans-serif; }
                    .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                    .header { background: #2563eb; color: white; padding: 20px; border-radius: 5px; }
                    .content { padding: 20px; background: #f9fafb; }
                </style>
            </head>
            <body>
                <div class="container">
                    <div class="header">
                        <h2>✓ Email Configuration Test Successful!</h2>
                    </div>
                    <div class="content">
                        <p>Congratulations! Your email configuration is working correctly.</p>
                        <p><strong>Configuration Details:</strong></p>
                        <ul>
                            <li>SMTP Host: ' . htmlspecialchars($smtpHost) . '</li>
                            <li>SMTP Port: ' . htmlspecialchars($smtpPort) . '</li>
                            <li>From Address: ' . htmlspecialchars($fromAddress) . '</li>
                            <li>From Name: ' . htmlspecialchars($fromName) . '</li>
                        </ul>
                        <p>Your Sinar Jaya Bus application is ready to send emails.</p>
                        <p><strong>Next Steps:</strong></p>
                        <ol>
                            <li>Update your email configuration in app/config/config.php</li>
                            <li>Delete or password-protect test_email.html in production</li>
                            <li>Test user registration with email verification</li>
                        </ol>
                    </div>
                    <div style="text-align: center; margin-top: 20px; color: #6b7280; font-size: 12px;">
                        <p>© 2024 Sinar Jaya Bus | Email sent at ' . date('Y-m-d H:i:s') . '</p>
                    </div>
                </div>
            </body>
            </html>
        ';

        $mail->AltBody = "Email configuration test successful!\n\n"
            . "SMTP Host: $smtpHost\n"
            . "SMTP Port: $smtpPort\n"
            . "From: $fromAddress ($fromName)\n\n"
            . "Your Sinar Jaya Bus application is ready to send emails.";

        // Send email
        $mail->send();

        echo json_encode([
            'success' => true,
            'message' => 'Email sent successfully to ' . $toEmail
        ]);
    } catch (PHPMailer\PHPMailer\Exception $e) {
        echo json_encode([
            'success' => false,
            'error' => $e->getMessage(),
            'debug' => 'PHPMailer Error: ' . $mail->ErrorInfo
        ]);
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'error' => $e->getMessage(),
            'debug' => 'Exception: ' . $e->getMessage()
        ]);
    }
}
