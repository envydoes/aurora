<?php
require_once 'config.php';
header('Content-Type: application/json');

$check_in = $_POST['check_in'] ?? '';
$check_out = $_POST['check_out'] ?? '';
$accommodation = $_POST['accommodation'] ?? '';

if (!$check_in || !$check_out || !$accommodation) {
    echo json_encode(['available' => false, 'error' => 'Missing data.']);
    exit;
}

$start = strtotime($check_in);
$end = strtotime($check_out);

// Find the service (room type)
$sql = "SELECT id FROM services WHERE name = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $accommodation);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
if ($row = mysqli_fetch_assoc($result)) {
    $service_id = $row['id'];
} else {
    echo json_encode(['available' => true]); // If room type not found, treat as available
    exit;
}

$conflict_dates = [];
for ($date = $start; $date < $end; $date += 86400) {
    $booking_date = date('Y-m-d', $date);
    $sql = "SELECT id FROM bookings WHERE service_id = ? AND booking_date = ? AND status IN ('pending','confirmed','checkedin')";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "is", $service_id, $booking_date);
    mysqli_stmt_execute($stmt);
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $conflict_dates[] = $booking_date;
    }
}

if (count($conflict_dates) > 0) {
    echo json_encode(['available' => false, 'conflict_dates' => $conflict_dates]);
} else {
    echo json_encode(['available' => true]);
} 