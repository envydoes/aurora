<?php
require_once 'config.php';
$room = $_GET['room'] ?? '';
$year = isset($_GET['year']) ? intval($_GET['year']) : date('Y');
$month = isset($_GET['month']) ? intval($_GET['month']) : date('m');

if (!$room || !$year || !$month) {
    echo '<div style="color:red;">Invalid request.</div>';
    exit;
}

// Room name centered
echo '<h3 style="text-align:center;margin-bottom:0.5rem;">' . htmlspecialchars($room) . '</h3>';

$sql = "SELECT s.name as room_type, b.booking_date FROM bookings b JOIN services s ON b.service_id = s.id WHERE s.name = ? AND b.status IN ('pending','confirmed','checkedin') AND YEAR(b.booking_date) = ? AND MONTH(b.booking_date) = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "sii", $room, $year, $month);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$booked_dates = [];
while ($row = mysqli_fetch_assoc($result)) {
    $booked_dates[] = $row['booking_date'];
}
$days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
$first_day = date('w', strtotime("$year-$month-01"));
$day = 1;
echo '<table class="calendar-table">';
echo '<tr><th>Sun</th><th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th></tr>';
echo '<tr>';
for ($i = 0; $i < $first_day; $i++) echo '<td></td>';
for ($i = $first_day; $i < 7; $i++) {
    $date_str = sprintf('%04d-%02d-%02d', $year, $month, $day);
    $is_booked = in_array($date_str, $booked_dates);
    echo '<td class="' . ($is_booked ? 'booked' : 'available') . '">' . $day . '</td>';
    $day++;
}
echo '</tr>';
while ($day <= $days_in_month) {
    echo '<tr>';
    for ($i = 0; $i < 7 && $day <= $days_in_month; $i++) {
        $date_str = sprintf('%04d-%02d-%02d', $year, $month, $day);
        $is_booked = in_array($date_str, $booked_dates);
        echo '<td class="' . ($is_booked ? 'booked' : 'available') . '">' . $day . '</td>';
        $day++;
    }
    while ($i < 7) { echo '<td></td>'; $i++; }
    echo '</tr>';
}
echo '</table>'; 