<?php
session_start();

// Check if user is logged in and is admin
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["role"] !== "admin") {
    header("location: login.php");
    exit;
}

require_once '../includes/config.php';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action'])) {
        if ($_POST['action'] == 'add') {
            $name = trim($_POST['name']);
            $description = trim($_POST['description']);
            $price = floatval($_POST['price']);
            $duration = intval($_POST['duration']);
            
            $sql = "INSERT INTO services (name, description, price, duration) VALUES (?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ssdi", $name, $description, $price, $duration);
            mysqli_stmt_execute($stmt);
        }
        elseif ($_POST['action'] == 'delete' && isset($_POST['id'])) {
            $id = intval($_POST['id']);
            $sql = "DELETE FROM services WHERE id = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);
        }
    }
}

// Fetch all services
$sql = "SELECT * FROM services ORDER BY name";
$services = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Management - Dingalan Aurora</title>
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
        .table {
            margin: 0;
        }
        .table th {
            font-weight: 600;
            border-top: none;
        }
        .btn-sm {
            padding: 5px 15px;
            border-radius: 5px;
        }
        .modal-content {
            border-radius: 10px;
            border: none;
        }
        .modal-header {
            border-bottom: 1px solid #eee;
            padding: 20px;
        }
        .modal-footer {
            border-top: 1px solid #eee;
            padding: 20px;
        }
        .form-control {
            border-radius: 5px;
            padding: 10px;
            border: 1px solid #ddd;
        }
        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
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
                    <li class="nav-item"><a href="index.php"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
                    <li class="nav-item"><a href="bookings.php"><i class="bi bi-calendar-check"></i> Bookings</a></li>
                    <li class="nav-item"><a href="services.php" class="active"><i class="bi bi-gear"></i> Management</a></li>
                    <li class="nav-item"><a href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
                </ul>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 main-content">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>Management</h2>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addServiceModal">
                        <i class="bi bi-plus-lg"></i> Add New Service
                    </button>
                </div>

                <!-- Services Table -->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Price</th>
                                        <th>Duration (min)</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while($service = mysqli_fetch_assoc($services)) { ?>
                                    <tr>
                                        <td><?php echo $service['id']; ?></td>
                                        <td><?php echo htmlspecialchars($service['name']); ?></td>
                                        <td><?php echo htmlspecialchars($service['description']); ?></td>
                                        <td>$<?php echo number_format($service['price'], 2); ?></td>
                                        <td><?php echo $service['duration']; ?></td>
                                        <td>
                                            <button class="btn btn-sm btn-primary" 
                                                    onclick="editService(<?php echo htmlspecialchars(json_encode($service)); ?>)">
                                                <i class="bi bi-pencil"></i> Edit
                                            </button>
                                            <form method="post" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this service?');">
                                                <input type="hidden" name="action" value="delete">
                                                <input type="hidden" name="id" value="<?php echo $service['id']; ?>">
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="bi bi-trash"></i> Delete
                                                </button>
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

    <!-- Add Service Modal -->
    <div class="modal fade" id="addServiceModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Service</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="post">
                    <div class="modal-body">
                        <input type="hidden" name="action" value="add">
                        <div class="mb-3">
                            <label for="name" class="form-label">Service Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Price ($)</label>
                            <input type="number" class="form-control" id="price" name="price" step="0.01" required>
                        </div>
                        <div class="mb-3">
                            <label for="duration" class="form-label">Duration (minutes)</label>
                            <input type="number" class="form-control" id="duration" name="duration" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Service</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function editService(service) {
            // Implement edit functionality
            console.log('Edit service:', service);
        }
    </script>
</body>
</html> 