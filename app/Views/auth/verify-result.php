<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $data['title'] ?? 'Verifikasi Email'; ?> - Sinar Jaya Bus</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .container {
            max-width: 600px;
            width: 100%;
        }
        
        .card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }
        
        .card-body {
            padding: 60px 40px;
            text-align: center;
        }
        
        .icon-box {
            font-size: 80px;
            margin-bottom: 30px;
            animation: scaleIn 0.5s ease-out;
        }
        
        .icon-success {
            color: #10b981;
        }
        
        .icon-error {
            color: #ef4444;
        }
        
        h2 {
            font-size: 32px;
            margin-bottom: 20px;
            font-weight: 700;
        }
        
        .title-success {
            color: #10b981;
        }
        
        .title-error {
            color: #ef4444;
        }
        
        .message {
            color: #6b7280;
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 35px;
        }
        
        .btn {
            display: inline-block;
            padding: 14px 32px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
            margin: 5px;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.4);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.5);
        }
        
        .btn-secondary {
            background: #6b7280;
            color: white;
            box-shadow: 0 4px 15px rgba(107, 114, 128, 0.3);
        }
        
        .btn-secondary:hover {
            background: #4b5563;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(107, 114, 128, 0.4);
        }
        
        .footer-text {
            text-align: center;
            color: white;
            margin-top: 30px;
            font-size: 14px;
            opacity: 0.9;
        }
        
        .footer-text a {
            color: white;
            text-decoration: underline;
        }
        
        @keyframes scaleIn {
            from {
                transform: scale(0);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }
        
        @media (max-width: 576px) {
            .card-body {
                padding: 40px 25px;
            }
            
            h2 {
                font-size: 24px;
            }
            
            .icon-box {
                font-size: 60px;
            }
            
            .btn {
                display: block;
                width: 100%;
                margin: 10px 0;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <?php if (isset($data['success_message'])): ?>
                    <!-- Success State -->
                    <div class="icon-box icon-success">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h2 class="title-success">✓ Verifikasi Berhasil!</h2>
                    <p class="message">
                        <?php echo htmlspecialchars($data['success_message']); ?>
                    </p>
                    <a href="<?php echo htmlspecialchars($data['redirect_url'] ?? BASEURL . 'auth/login'); ?>" class="btn btn-primary">
                        <i class="fas fa-sign-in-alt"></i> Login Sekarang
                    </a>
                    
                <?php else: ?>
                    <!-- Error State -->
                    <div class="icon-box icon-error">
                        <i class="fas fa-times-circle"></i>
                    </div>
                    <h2 class="title-error">✗ Verifikasi Gagal</h2>
                    <p class="message">
                        <?php echo htmlspecialchars($data['error_message'] ?? 'Terjadi kesalahan saat memverifikasi email.'); ?>
                    </p>
                    <div>
                        <a href="<?php echo BASEURL; ?>auth/login" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali ke Login
                        </a>
                        <a href="<?php echo BASEURL; ?>auth/register" class="btn btn-primary">
                            <i class="fas fa-user-plus"></i> Daftar Ulang
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <p class="footer-text">
            © <?php echo date('Y'); ?> Sinar Jaya Bus. All rights reserved. | 
            <a href="<?php echo BASEURL; ?>">Kembali ke Beranda</a>
        </p>
    </div>
</body>
</html>
