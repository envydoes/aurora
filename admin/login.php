<?php
session_start();
require_once '../includes/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];
    
    $sql = "SELECT id, username, password, role FROM users WHERE username = ? AND role = 'admin'";
    
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $username);
        
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_store_result($stmt);
            
            if (mysqli_stmt_num_rows($stmt) == 1) {
                mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password, $role);
                if (mysqli_stmt_fetch($stmt)) {
                    if (password_verify($password, $hashed_password)) {
                        $_SESSION["loggedin"] = true;
                        $_SESSION["id"] = $id;
                        $_SESSION["username"] = $username;
                        $_SESSION["role"] = $role;
                        
                        header("location: index.php");
                    } else {
                        $login_err = "Invalid username or password.";
                    }
                }
            } else {
                $login_err = "Invalid username or password.";
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Dingalan Aurora</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #e3f2fd;
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-container {
            max-width: 400px;
            margin: 0 auto;
            padding: 30px;
            background: #1976d2;
            color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .logo {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo img {
            max-width: 200px;
            height: auto;
        }
        .form-control {
            border-radius: 5px;
            padding: 12px;
            border: 1px solid #ddd;
            background: #e3f2fd;
            color: #333;
        }
        .form-control:focus {
            border-color: #1565c0;
            box-shadow: 0 0 0 0.2rem rgba(21,101,192,0.25);
        }
        .btn-primary {
            background-color: #1565c0;
            border: none;
            padding: 12px;
            border-radius: 5px;
            font-weight: 500;
            width: 100%;
        }
        .btn-primary:hover {
            background-color: #0d47a1;
        }
        .form-label {
            font-weight: 500;
            color: #fff;
        }
        h2.text-center {
            color: #fff;
        }
        .alert-danger {
            background: #ff5252;
            color: #fff;
            border: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <div class="logo">
                <img src="../images/logo.png" alt="Dingalan Aurora Logo">
            </div>
            <h2 class="text-center mb-4">Admin Login</h2>
            
            <?php 
            if (!empty($login_err)) {
                echo '<div class="alert alert-danger">' . $login_err . '</div>';
            }        
            ?>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" required>
                </div>    
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html> 