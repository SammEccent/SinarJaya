<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Sinar Jaya Bus Ticket Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap');

        body,
        html {
            height: 100%;
            margin: 0;
            font-family: 'Inter', Arial, sans-serif;
            background: #f5f7fa;
        }

        .container {
            display: flex;
            height: 100vh;
        }

        .left {
            flex: 1;
            background: url('https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=900&q=80') center center/cover no-repeat;
            position: relative;
        }

        .left::after {
            content: '';
            position: absolute;
            inset: 0;
            backdrop-filter: blur(8px);
            background: rgba(30, 41, 59, 0.25);
        }

        .right {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fff;
        }

        .login-card {
            width: 100%;
            max-width: 370px;
            padding: 2.5rem 2rem;
            border-radius: 18px;
            box-shadow: 0 8px 32px rgba(30, 41, 59, 0.10);
            background: #fff;
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        .logo {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 1rem;
        }

        .logo img {
            height: 38px;
            opacity: 0.85;
        }

        .login-title {
            text-align: center;
            font-size: 1.45rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 0.5rem;
            letter-spacing: 0.01em;
        }

        .login-form {
            display: flex;
            flex-direction: column;
            gap: 1.2rem;
        }

        .login-form input {
            padding: 0.85rem 1rem;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            font-size: 1rem;
            background: #f8fafc;
            transition: border-color 0.2s, box-shadow 0.2s;
            outline: none;
        }

        .login-form input:focus,
        .login-form input:hover {
            border-color: #2563eb;
            box-shadow: 0 0 0 2px #2563eb22;
            background: #fff;
        }

        .login-btn {
            padding: 0.95rem 0;
            border: none;
            border-radius: 12px;
            font-size: 1.08rem;
            font-weight: 600;
            color: #fff;
            background: linear-gradient(90deg, #2563eb 0%, #1e40af 100%);
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(37, 99, 235, 0.10);
            transition: background 0.2s, box-shadow 0.2s;
        }

        .login-btn:hover {
            background: linear-gradient(90deg, #1e40af 0%, #2563eb 100%);
            box-shadow: 0 4px 16px rgba(37, 99, 235, 0.15);
        }

        @media (max-width: 900px) {
            .container {
                flex-direction: column;
            }

            .left,
            .right {
                flex: none;
                height: 45vh;
            }

            .right {
                height: 55vh;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="left"></div>
        <div class="right">
            <div class="login-card">
                <div class="logo">
                    <!-- Simple Sinar Jaya logo SVG -->
                    <img src="https://i.imgur.com/6QKQh6B.png" alt="Sinar Jaya Logo">
                </div>
                <div class="login-title">Login to Sinar Jaya</div>
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="error-message">
                        <?php
                        echo htmlspecialchars($_SESSION['error']);
                        unset($_SESSION['error']);
                        ?>
                    </div>
                <?php endif; ?>
                <form class="login-form" method="post" action="/auth/login">
                    <input type="text" name="username" placeholder="Username" required autocomplete="username">
                    <input type="password" name="password" placeholder="Password" required autocomplete="current-password">
                    <button type="submit" class="login-btn">Login</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>