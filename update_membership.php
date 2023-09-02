<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "fitness_center_management_system";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$updateQuery = "UPDATE morning_shift SET MembershipDurationDays = MembershipDurationDays - 1 WHERE MembershipStatus = 'Active'";
$conn->query($updateQuery);
$conn->close();
?>
