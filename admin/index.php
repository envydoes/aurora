<?php
session_start();

// Check if user is logged in and is admin
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["role"] !== "admin") {
    header("location: login.php");
    exit;
}

require_once '../includes/config.php';

// Fetch recent bookings
$sql = "SELECT u.email, s.name as service_name, 
        MIN(b.booking_date) as check_in, 
        MAX(b.booking_date) as check_out,
        COUNT(*) as nights,
        b.status,
        GROUP_CONCAT(b.id) as booking_ids
        FROM bookings b 
        JOIN users u ON b.user_id = u.id 
        JOIN services s ON b.service_id = s.id 
        GROUP BY u.email, s.name, b.status
        ORDER BY check_in DESC 
        LIMIT 10";
$recent_bookings = mysqli_query($conn, $sql);

// Fetch total bookings count
$sql = "SELECT COUNT(DISTINCT CONCAT(u.email, s.name, b.status)) as total 
        FROM bookings b 
        JOIN users u ON b.user_id = u.id 
        JOIN services s ON b.service_id = s.id";
$total_bookings = mysqli_fetch_assoc(mysqli_query($conn, $sql))['total'];

// Fetch pending bookings count
$sql = "SELECT COUNT(DISTINCT CONCAT(u.email, s.name, b.status)) as pending 
        FROM bookings b 
        JOIN users u ON b.user_id = u.id 
        JOIN services s ON b.service_id = s.id 
        WHERE b.status = 'pending'";
$pending_bookings = mysqli_fetch_assoc(mysqli_query($conn, $sql))['pending'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Dingalan Aurora</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f9fa;
        }
        .sidebar {
            min-height: 100vh;
            background: #343a40;
            color: white;
            padding: 20px;
        }
        .sidebar .logo {
            text-align: center;
            margin-bottom: 30px;
            padding: 20px 0;
        }
        .sidebar .logo img {
            max-width: 150px;
            height: auto;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            display: block;
            border-radius: 5px;
            margin-bottom: 5px;
            transition: all 0.3s ease;
        }
        .sidebar a:hover, .sidebar a.active {
            background: rgba(255,255,255,0.1);
            color: #fff;
        }
        .sidebar a i {
            margin-right: 10px;
        }
        .main-content {
            padding: 30px;
        }
        .stat-card {
            background: white;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 0 20px rgba(0,0,0,0.05);
            transition: transform 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
        .stat-card h3 {
            font-size: 2rem;
            font-weight: 600;
            color: #007bff;
            margin-bottom: 10px;
        }
        .stat-card p {
            color: #6c757d;
            margin: 0;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.05);
        }
        .card-header {
            background: white;
            border-bottom: 1px solid #eee;
            padding: 20px;
        }
        .card-header h5 {
            margin: 0;
            font-weight: 600;
        }
        .table {
            margin: 0;
        }
        .table th {
            font-weight: 600;
            border-top: none;
        }
        .badge {
            padding: 8px 12px;
            border-radius: 5px;
        }
        .btn-sm {
            padding: 5px 15px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar">
                <div class="logo">
                    <img src="../images/logo.png" alt="Dingalan Aurora Logo">
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item"><a href="index.php" class="active"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
                    <li class="nav-item"><a href="bookings.php"><i class="bi bi-calendar-check"></i> Bookings</a></li>
                    <li class="nav-item"><a href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
                </ul>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 main-content">
                <h2 class="mb-4">Dashboard</h2>
                
                <!-- Stats Cards -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="stat-card">
                            <h3><?php echo $total_bookings; ?></h3>
                            <p class="text-muted">Total Bookings</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-card">
                            <h3><?php echo $pending_bookings; ?></h3>
                            <p class="text-muted">Pending Bookings</p>
                        </div>
                    </div>
                </div>

                <!-- Recent Bookings -->
                <div class="card mt-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Recent Bookings</h5>
                        <a href="bookings.php" class="btn btn-primary btn-sm">View All</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Email</th>
                                        <th>Room Type</th>
                                        <th>Check-in</th>
                                        <th>Check-out</th>
                                        <th>Nights</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while($booking = mysqli_fetch_assoc($recent_bookings)) { ?>
                                    <tr>
                                        <td><?php echo $booking['email']; ?></td>
                                        <td><?php echo $booking['service_name']; ?></td>
                                        <td><?php echo $booking['check_in']; ?></td>
                                        <td><?php echo date('Y-m-d', strtotime($booking['check_out'] . ' +1 day')); ?></td>
                                        <td><?php echo $booking['nights']; ?></td>
                                        <td>
                                            <span class="badge bg-<?php 
                                                echo $booking['status'] == 'confirmed' ? 'success' : 
                                                    ($booking['status'] == 'pending' ? 'warning' : 'danger'); 
                                            ?>">
                                                <?php echo ucfirst($booking['status']); ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 