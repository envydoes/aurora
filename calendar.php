<?php
require_once 'includes/config.php';
// Fetch all bookings grouped by room type and date
$sql = "SELECT s.name as room_type, b.booking_date, COUNT(*) as booked_count
        FROM bookings b
        JOIN services s ON b.service_id = s.id
        WHERE b.status IN ('pending','confirmed','checkedin')
        GROUP BY s.name, b.booking_date";
$result = mysqli_query($conn, $sql);
$booked = [];
while ($row = mysqli_fetch_assoc($result)) {
    $booked[$row['room_type']][] = $row['booking_date'];
}
$room_types = ['1 Bed Room', '2 Bed Room', '3 Bed Room', '4 Bed Room'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Availability Calendar - Dingalan Aurora</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f5f9fa; }
        .calendar-container { max-width: 1000px; margin: 60px auto; background: #fff; border-radius: 12px; box-shadow: 0 0 20px rgba(0,0,0,0.08); padding: 40px 30px; }
        .calendar-title { text-align: center; color: #1a5f7a; margin-bottom: 30px; }
        .calendar-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 2rem; }
        .room-calendar { background: #f5f9fa; border-radius: 10px; padding: 20px; box-shadow: 0 2px 8px rgba(44,62,80,0.06); }
        .room-calendar h3 { color: #2e8b57; margin-bottom: 10px; }
        .calendar-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .calendar-table th, .calendar-table td { text-align: center; padding: 8px; border: 1px solid #e6b17a; }
        .calendar-table th { background: #e6b17a; color: #fff; }
        .calendar-table td.booked { background: #ff7f50; color: #fff; border-radius: 4px; }
        .calendar-table td.available { background: #eaf6fb; color: #2c3e50; }
        @media (max-width: 900px) { .calendar-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <div class="calendar-container">
        <h2 class="calendar-title">Room Availability Calendar</h2>
        <div class="calendar-grid">
            <?php foreach ($room_types as $room): ?>
            <div class="room-calendar">
                <h3><?php echo $room; ?></h3>
                <?php
                // Show current month
                $year = date('Y');
                $month = date('m');
                $days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                $first_day = date('w', strtotime("$year-$month-01"));
                $booked_dates = $booked[$room] ?? [];
                ?>
                <table class="calendar-table">
                    <tr>
                        <th>Sun</th><th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th>
                    </tr>
                    <tr>
                    <?php
                    $day = 1;
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
                    ?>
                </table>
                <div style="margin-top:10px; font-size:0.95em;">
                    <span style="display:inline-block;width:16px;height:16px;background:#ff7f50;border-radius:3px;margin-right:5px;"></span> Booked
                    <span style="display:inline-block;width:16px;height:16px;background:#eaf6fb;border-radius:3px;margin:0 5px 0 15px;"></span> Available
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html> 