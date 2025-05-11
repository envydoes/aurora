<?php
// Run this script once to update the bookings table ENUM for status
require_once '../includes/config.php';

$sql = "ALTER TABLE bookings MODIFY status ENUM('pending', 'confirmed', 'checkedin', 'checkedout', 'cancelled') DEFAULT 'pending'";
if (mysqli_query($conn, $sql)) {
    echo "Success: bookings.status ENUM updated.";
} else {
    echo "Error: " . mysqli_error($conn);
} 