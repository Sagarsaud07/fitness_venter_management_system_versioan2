<?php
$servername = "localhost";
$username = "root";
$password = "";

$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$databaseName = "fitness_center";
$sql = "CREATE DATABASE IF NOT EXISTS $databaseName";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully<br>";
} else {
    echo "Error creating database: " . $conn->error;
}


$conn->select_db($databaseName);

$sql = "CREATE TABLE IF NOT EXISTS memberslist (
    MemberID INT PRIMARY KEY AUTO_INCREMENT,
    FirstName VARCHAR(50),
    LastName VARCHAR(50),
    Email VARCHAR(100),
    Phone VARCHAR(20),
    Address VARCHAR(255),
    JoinDate DATE
)";
if ($conn->query($sql) === TRUE) {
    echo "Table 'memberslist' created successfully<br>";
} else {
    echo "Error creating table: " . $conn->error;
}

$sql = "CREATE TABLE IF NOT EXISTS schedule (
    ScheduleID INT PRIMARY KEY AUTO_INCREMENT,
    EventName VARCHAR(100),
    Location VARCHAR(100),
    Date DATE,
    StartTime TIME,
    EndTime TIME
)";
if ($conn->query($sql) === TRUE) {
    echo "Table 'schedule' created successfully<br>";
} else {
    echo "Error creating table: " . $conn->error;
}

$sql = "CREATE TABLE IF NOT EXISTS attendance (
    AttendanceID INT PRIMARY KEY AUTO_INCREMENT,
    MemberID INT,
    ScheduleID INT,
    AttendanceDate DATE,
    FOREIGN KEY (MemberID) REFERENCES memberslist(MemberID),
    FOREIGN KEY (ScheduleID) REFERENCES schedule(ScheduleID)
)";
if ($conn->query($sql) === TRUE) {
    echo "Table 'attendance' created successfully<br>";
} else {
    echo "Error creating table: " . $conn->error;
}
$conn->close();
?>