<?php
require_once 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $check_in = $_POST['check-in'] ?? '';
    $check_out = $_POST['check-out'] ?? '';
    $accommodation = $_POST['accommodation'] ?? '';
    $guest_email = $_POST['email'] ?? '';

    // Calculate number of nights
    $start = strtotime($check_in);
    $end = strtotime($check_out);
    $nights = ($end - $start) / 86400;
    if ($nights < 1) $nights = 1;
    $price_per_night = 0;
    if ($accommodation === '1 Bed Room') $price_per_night = 1000;
    else if ($accommodation === '2 Bed Room') $price_per_night = 1500;
    else if ($accommodation === '3 Bed Room') $price_per_night = 1999;
    $total_price = $nights * $price_per_night;

    // Use guest email as username for uniqueness
    $guest_username = $guest_email;
    $guest_password = password_hash('guest', PASSWORD_DEFAULT);
    $sql = "INSERT IGNORE INTO users (username, password, email, role) VALUES (?, ?, ?, 'user')";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sss", $guest_username, $guest_password, $guest_email);
    mysqli_stmt_execute($stmt);
    $user_id = mysqli_insert_id($conn);
    if ($user_id == 0) {
        // User already exists, get the id
        $result = mysqli_query($conn, "SELECT id FROM users WHERE username = '" . mysqli_real_escape_string($conn, $guest_username) . "'");
        $row = mysqli_fetch_assoc($result);
        $user_id = $row['id'];
    }

    // Find or create the service (room type)
    $sql = "SELECT id FROM services WHERE name = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $accommodation);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($result)) {
        $service_id = $row['id'];
    } else {
        $sql = "INSERT INTO services (name, description, price, duration) VALUES (?, '', ?, 0)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sid", $accommodation, $price_per_night, $zero=0);
        mysqli_stmt_execute($stmt);
        $service_id = mysqli_insert_id($conn);
    }

    // Check for double booking
    $conflict = false;
    $conflict_dates = [];
    for ($date = $start; $date < $end; $date += 86400) {
        $booking_date = date('Y-m-d', $date);
        $sql = "SELECT id FROM bookings WHERE service_id = ? AND booking_date = ? AND status IN ('pending','confirmed','checkedin')";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "is", $service_id, $booking_date);
        mysqli_stmt_execute($stmt);
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $conflict = true;
            $conflict_dates[] = $booking_date;
        }
    }
    if ($conflict) {
        $_SESSION['booking_error'] = 'Sorry, the selected room is already booked for these dates: ' . implode(', ', $conflict_dates) . '. Please choose different dates.';
        header('Location: ../index.php#booking');
        exit;
    }

    // Save booking for each day between check-in and check-out
    $booking_dates = [];
    for ($date = $start; $date < $end; $date += 86400) {
        $booking_date = date('Y-m-d', $date);
        $sql = "INSERT INTO bookings (user_id, service_id, booking_date, booking_time, status) VALUES (?, ?, ?, '12:00:00', 'pending')";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "iis", $user_id, $service_id, $booking_date);
        mysqli_stmt_execute($stmt);
        $booking_dates[] = $booking_date;
    }

    // Send email to admin
    $to = 'dingalantravels@gmail.com';
    $subject = 'New Booking Request';
    $message = "A new booking has been made.\n\n" .
        "Email: $guest_email\n" .
        "Room Type: $accommodation\n" .
        "Check-in: $check_in\n" .
        "Check-out: $check_out\n" .
        "Number of Nights: $nights\n" .
        "Total Price: PHP $total_price\n" .
        "Booked Dates: " . implode(', ', $booking_dates) . "\n\n" .
        "Please log in to the admin dashboard to confirm or manage this booking.";
    $headers = 'From: Dingalan Aurora <dingalantravels@gmail.com>' . "\r\n" .
               'Reply-To: ' . $guest_email . "\r\n" .
               'X-Mailer: PHP/' . phpversion();
    mail($to, $subject, $message, $headers);

    // Send confirmation to guest
    $guest_subject = 'Your Booking Confirmation - Dingalan Aurora';
    $guest_message = "
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: #1a5f7a; color: white; padding: 20px; text-align: center; }
                .content { padding: 20px; background: #f9f9f9; }
                .details { margin: 20px 0; }
                .details p { margin: 10px 0; }
                .footer { text-align: center; padding: 20px; font-size: 0.9em; color: #666; }
                .important { background: #fff3cd; padding: 15px; border-left: 4px solid #ffc107; margin: 20px 0; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h2>Booking Confirmation</h2>
                </div>
                <div class='content'>
                    <p>Dear Guest,</p>
                    <p>Thank you for choosing Dingalan Aurora for your stay. Your booking has been received and is pending confirmation.</p>
                    
                    <div class='details'>
                        <h3>Booking Details:</h3>
                        <p><strong>Room Type:</strong> $accommodation</p>
                        <p><strong>Check-in Date:</strong> $check_in</p>
                        <p><strong>Check-out Date:</strong> $check_out</p>
                        <p><strong>Number of Nights:</strong> $nights</p>
                        <p><strong>Price per Night:</strong> PHP " . number_format($price_per_night, 2) . "</p>
                        <p><strong>Total Price:</strong> PHP " . number_format($total_price, 2) . "</p>
                    </div>

                    <div class='important'>
                        <h4>Important Information:</h4>
                        <ul>
                            <li>Check-in time: 2:00 PM</li>
                            <li>Check-out time: 12:00 PM</li>
                            <li>Payment is due upon arrival</li>
                            <li>Please present this email confirmation upon check-in</li>
                        </ul>
                    </div>

                    <p>We will send you another email once your booking is confirmed.</p>
                    
                    <p>If you have any questions or need to make changes to your booking, please contact us at:</p>
                    <p>Phone: 09288103008<br>
                    Email: dingalantravels@gmail.com</p>
                </div>
                <div class='footer'>
                    <p>Best regards,<br>The Dingalan Aurora Team</p>
                </div>
            </div>
        </body>
        </html>
    ";
    $guest_headers = 'From: Dingalan Aurora <dingalantravels@gmail.com>' . "\r\n" .
                     'Reply-To: dingalantravels@gmail.com' . "\r\n" .
                     'MIME-Version: 1.0' . "\r\n" .
                     'Content-Type: text/html; charset=UTF-8' . "\r\n" .
                     'X-Mailer: PHP/' . phpversion();
    mail($guest_email, $guest_subject, $guest_message, $guest_headers);

    // Redirect to thank you page with details
    $_SESSION['booking_confirmation'] = [
        'email' => $guest_email,
        'room' => $accommodation,
        'check_in' => $check_in,
        'check_out' => $check_out,
        'nights' => $nights,
        'total_price' => $total_price
    ];
    header('Location: ../thankyou.php');
    exit;
} else {
    header('Location: ../index.php');
    exit;
}
?> 