<?php
session_start();
$booking = $_SESSION['booking_confirmation'] ?? null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation - Dingalan Aurora</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f5f9fa; }
        .confirmation-container {
            max-width: 500px;
            margin: 60px auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.08);
            padding: 40px 30px;
            text-align: center;
        }
        .confirmation-container h2 {
            color: #007bff;
            margin-bottom: 20px;
        }
        .confirmation-details {
            text-align: left;
            margin: 30px 0;
        }
        .confirmation-details strong {
            color: #333;
        }
        .confirmation-details p {
            margin: 8px 0;
        }
        .total-price {
            font-size: 1.3em;
            color: #007bff;
            font-weight: 600;
            margin-top: 20px;
        }
        .back-btn {
            margin-top: 30px;
            display: inline-block;
            background: #007bff;
            color: #fff;
            padding: 12px 30px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 500;
            transition: background 0.2s;
        }
        .back-btn:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <!-- write a hello world below -->

    
    <div class="confirmation-container">
        <h2>Thank You for Booking!</h2>
        <?php if ($booking): ?>
        <p>Your booking has been received. Please check your email for confirmation and payment instructions.</p>
        <div class="confirmation-details">
            <p><strong>Email:</strong> <?php echo htmlspecialchars($booking['email']); ?></p>
            <p><strong>Room Type:</strong> <?php echo htmlspecialchars($booking['room']); ?></p>
            <p><strong>Check-in:</strong> <?php echo htmlspecialchars($booking['check_in']); ?></p>
            <p><strong>Check-out:</strong> <?php echo htmlspecialchars($booking['check_out']); ?></p>
            <p><strong>Number of Nights:</strong> <?php echo htmlspecialchars($booking['nights']); ?></p>
            <p class="total-price"><strong>Total Price:</strong> PHP <?php echo number_format($booking['total_price'], 2); ?></p>
        </div>
        <p>Please show this page or your confirmation email when you check in. Payment is due upon arrival.</p>
        <?php else: ?>
        <p>No booking information found. Please make a booking first.</p>
        <?php endif; ?>
        <a href="index.php" class="back-btn">Back to Home</a>
    </div>
</body>
</html> 