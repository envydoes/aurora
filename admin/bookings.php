<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["role"] !== "admin") {
    header("location: login.php");
    exit;
}
require_once '../includes/config.php';

// Handle actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id'] ?? 0);
    if (isset($_POST['action'])) {
        // Get booking group info
        $info = mysqli_fetch_assoc(mysqli_query($conn, "SELECT user_id, service_id, status, booking_date FROM bookings WHERE id=$id"));
        $user_id = $info['user_id'];
        $service_id = $info['service_id'];
        $status = $info['status'];
        $booking_date = $info['booking_date'];
        // Find contiguous date range for this group
        $dates = [];
        $result = mysqli_query($conn, "SELECT booking_date FROM bookings WHERE user_id=$user_id AND service_id=$service_id AND status='$status' ORDER BY booking_date");
        while ($row = mysqli_fetch_assoc($result)) $dates[] = $row['booking_date'];
        $start = $dates[0];
        $end = $dates[count($dates)-1];
        if ($_POST['action'] === 'confirm' || $_POST['action'] === 'checkin' || $_POST['action'] === 'status') {
            $new_status = isset($_POST['status']) ? strtolower(mysqli_real_escape_string($conn, $_POST['status'])) : ($_POST['action'] === 'checkin' ? 'checkedin' : 'confirmed');
            mysqli_query($conn, "UPDATE bookings SET status='$new_status' WHERE user_id=$user_id AND service_id=$service_id AND booking_date >= '$start' AND booking_date <= '$end'");
        } elseif ($_POST['action'] === 'reject') {
            mysqli_query($conn, "UPDATE bookings SET status='cancelled' WHERE user_id=$user_id AND service_id=$service_id AND booking_date >= '$start' AND booking_date <= '$end'");
        } elseif ($_POST['action'] === 'delete') {
            mysqli_query($conn, "DELETE FROM bookings WHERE user_id=$user_id AND service_id=$service_id AND booking_date >= '$start' AND booking_date <= '$end'");
        } elseif ($_POST['action'] === 'edit' && isset($_POST['booking_date'], $_POST['room_type'], $_POST['email'])) {
            // Update booking details
            $booking_date = mysqli_real_escape_string($conn, $_POST['booking_date']);
            $room_type = mysqli_real_escape_string($conn, $_POST['room_type']);
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            // Update service (room type)
            $service_id = 0;
            $service_q = mysqli_query($conn, "SELECT id FROM services WHERE name='$room_type'");
            if ($row = mysqli_fetch_assoc($service_q)) {
                $service_id = $row['id'];
            }
            // Update user email
            $user_id = 0;
            $user_q = mysqli_query($conn, "SELECT user_id FROM bookings WHERE id=$id");
            if ($row = mysqli_fetch_assoc($user_q)) {
                $user_id = $row['user_id'];
                mysqli_query($conn, "UPDATE users SET email='$email', username='$email' WHERE id=$user_id");
            }
            // Update booking
            mysqli_query($conn, "UPDATE bookings SET booking_date='$booking_date', service_id=$service_id WHERE id=$id");
        }
    }
}

// Fetch all bookings grouped by user, room type, contiguous date range, and status
$sql = "SELECT u.email, s.name as room_type, MIN(b.booking_date) as check_in, MAX(b.booking_date) as check_out, COUNT(*) as nights, b.status, GROUP_CONCAT(b.id) as booking_ids
FROM (
    SELECT b.*, 
        @grp := IF(@prev_uid = user_id AND @prev_sid = service_id AND @prev_status = status AND DATEDIFF(booking_date, @prev_date) = 1, @grp, @grp + 1) AS grp,
        @prev_uid := user_id, @prev_sid := service_id, @prev_status := status, @prev_date := booking_date
    FROM bookings b, (SELECT @grp := 0, @prev_uid := NULL, @prev_sid := NULL, @prev_status := NULL, @prev_date := NULL) vars
    ORDER BY user_id, service_id, status, booking_date
) b
JOIN users u ON b.user_id = u.id
JOIN services s ON b.service_id = s.id
GROUP BY u.email, s.name, b.status, b.grp
ORDER BY check_in DESC";
$bookings = mysqli_query($conn, $sql);
$statuses = ['pending', 'confirmed', 'checkedin', 'checkedout', 'cancelled'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Bookings - Dingalan Aurora</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f5f9fa; }
        .sidebar { min-height: 100vh; background: #343a40; color: white; padding: 20px; }
        .sidebar .logo { text-align: center; margin-bottom: 30px; padding: 20px 0; }
        .sidebar .logo img { max-width: 150px; height: auto; }
        .sidebar a { color: white; text-decoration: none; padding: 10px 15px; display: block; border-radius: 5px; margin-bottom: 5px; transition: all 0.3s ease; }
        .sidebar a:hover, .sidebar a.active { background: rgba(255,255,255,0.1); color: #fff; }
        .sidebar a i { margin-right: 10px; }
        .main-content { padding: 30px; }
        .card { border: none; border-radius: 10px; box-shadow: 0 0 20px rgba(0,0,0,0.05); }
        .table-responsive { overflow-x: auto; }
        .table { min-width: 600px; font-size: 0.98em; }
        @media (max-width: 900px) { .main-content { padding: 10px; } .table { font-size: 0.93em; } }
        .table th, .table td { padding: 8px 6px; }
        .badge { padding: 8px 12px; border-radius: 5px; }
        .btn-sm { padding: 5px 10px; border-radius: 5px; font-size: 0.95em; }
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
                <li class="nav-item"><a href="index.php"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
                <li class="nav-item"><a href="bookings.php" class="active"><i class="bi bi-calendar-check"></i> Bookings</a></li>
                <li class="nav-item"><a href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
            </ul>
        </div>
        <!-- Main Content -->
        <div class="col-md-9 col-lg-10 main-content">
            <h2 class="mb-4">Manage Bookings</h2>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Email</th>
                                    <th>Room Type</th>
                                    <th>Check-in</th>
                                    <th>Check-out</th>
                                    <th>Nights</th>
                                    <th>Total Price</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php while($b = mysqli_fetch_assoc($bookings)) { ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($b['email']); ?></td>
                                    <td><?php echo htmlspecialchars($b['room_type']); ?></td>
                                    <td><?php echo htmlspecialchars($b['check_in']); ?></td>
                                    <td><?php echo date('Y-m-d', strtotime($b['check_out'] . ' +1 day')); ?></td>
                                    <td><?php echo $b['nights']; ?></td>
                                    <td>PHP <?php 
                                        $price = 0;
                                        if ($b['room_type'] === '1 Bed Room') $price = 1000;
                                        else if ($b['room_type'] === '2 Bed Room') $price = 1500;
                                        else if ($b['room_type'] === '3 Bed Room') $price = 1999;
                                        echo number_format($b['nights'] * $price, 2);
                                    ?></td>
                                    <td>
                                        <form method="post" style="margin-bottom:0;display:inline-block;">
                                            <input type="hidden" name="id" value="<?php echo explode(',', $b['booking_ids'])[0]; ?>">
                                            <select name="status">
                                                <?php foreach ($statuses as $s): ?>
                                                    <option value="<?php echo strtolower($s); ?>" <?php if (strtolower($b['status']) == strtolower($s)) echo 'selected'; ?>><?php echo ucfirst($s); ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <button name="action" value="status" class="btn btn-primary btn-sm">Update</button>
                                        </form>
                                    </td>
                                    <td>
                                        <form method="post" style="display:inline-block;">
                                            <input type="hidden" name="id" value="<?php echo explode(',', $b['booking_ids'])[0]; ?>">
                                            <button name="action" value="delete" class="btn btn-secondary btn-sm" onclick="return confirm('Delete this booking?')">Delete</button>
                                        </form>
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