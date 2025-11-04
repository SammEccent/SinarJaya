<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: /auth/login');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sinar Jaya Bus - Dashboard</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f5f7fa;
        }

        .container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 250px;
            background-color: #1e293b;
            color: #fff;
            padding: 1.5rem;
        }

        .logo {
            display: flex;
            align-items: center;
            margin-bottom: 2rem;
            padding: 0.5rem;
        }

        .logo img {
            height: 32px;
            margin-right: 0.75rem;
        }

        .logo span {
            font-size: 1.25rem;
            font-weight: 600;
        }

        .menu {
            list-style: none;
        }

        .menu li {
            margin-bottom: 0.5rem;
        }

        .menu a {
            color: #cbd5e1;
            text-decoration: none;
            padding: 0.75rem 1rem;
            display: block;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }

        .menu a:hover {
            background-color: #2c3e50;
            color: #fff;
        }

        /* Main Content Styles */
        .main-content {
            flex: 1;
            padding: 2rem;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding: 1rem;
            background-color: #fff;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .welcome-text {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1e293b;
        }

        .user-nav {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-info {
            text-align: right;
        }

        .username {
            font-weight: 500;
            color: #1e293b;
        }

        .role {
            font-size: 0.875rem;
            color: #64748b;
        }

        .logout-btn {
            padding: 0.5rem 1rem;
            background-color: #ef4444;
            color: #fff;
            border: none;
            border-radius: 0.375rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .logout-btn:hover {
            background-color: #dc2626;
        }

        /* Dashboard Cards */
        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .card {
            background-color: #fff;
            padding: 1.5rem;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .card-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 1rem;
        }

        .card-content {
            font-size: 2rem;
            font-weight: 600;
            color: #2563eb;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="sidebar">
            <div class="logo">
                <img src="https://i.imgur.com/6QKQh6B.png" alt="Sinar Jaya Logo">
                <span>Sinar Jaya</span>
            </div>
            <ul class="menu">
                <li><a href="/dashboard">Dashboard</a></li>
                <li><a href="/tickets">Tickets</a></li>
                <li><a href="/schedules">Schedules</a></li>
                <li><a href="/bookings">Bookings</a></li>
                <li><a href="/profile">Profile</a></li>
            </ul>
        </div>
        <div class="main-content">
            <div class="header">
                <div class="welcome-text">
                    Welcome back, <?php echo htmlspecialchars($_SESSION['username']); ?>!
                </div>
                <div class="user-nav">
                    <div class="user-info">
                        <div class="username"><?php echo htmlspecialchars($_SESSION['username']); ?></div>
                        <div class="role">User</div>
                    </div>
                    <form action="/auth/logout" method="post" style="display: inline;">
                        <button type="submit" class="logout-btn">Logout</button>
                    </form>
                </div>
            </div>
            <div class="dashboard-cards">
                <div class="card">
                    <div class="card-title">Available Buses</div>
                    <div class="card-content">15</div>
                </div>
                <div class="card">
                    <div class="card-title">Today's Bookings</div>
                    <div class="card-content">24</div>
                </div>
                <div class="card">
                    <div class="card-title">Active Routes</div>
                    <div class="card-content">8</div>
                </div>
            </div>
            <!-- Add more dashboard content here -->
        </div>
    </div>
</body>

</html>