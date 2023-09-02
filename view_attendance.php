<!DOCTYPE html>
<html>
<head>
    <title>View Attendance</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
            border: 1px solid #ddd;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "fitness_center_management_system";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (isset($_GET['date'])) {
        $selectedDate = $_GET['date'];

        $sql = "SELECT a.memberId, m.FirstName, m.LastName, a.`TIME`, a.attendanceDate 
                FROM attendance AS a
                JOIN member AS m ON a.memberId = m.MemberID
                WHERE a.attendanceDate = '$selectedDate'
                ORDER BY a.`TIME` ASC";  // Order by time in ascending order
                
        $result = $conn->query($sql);
    }
    ?>

    <h1>View Attendance for <?php echo $selectedDate; ?></h1>

    <?php
    if ($result === false) {
        echo "Error fetching attendance data: " . $conn->error;
    } elseif ($result->num_rows > 0) {
        echo '<table>
                <tr>
                    <th>Member ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Date</th>
                    <th>Time</th>
                </tr>';

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['memberId'] . "</td>";
            echo "<td>" . $row['FirstName'] . "</td>";
            echo "<td>" . $row['LastName'] . "</td>";
            echo "<td>" . $row['attendanceDate'] . "</td>";
            echo "<td>" . $row['TIME'] . "</td>";
            echo "</tr>";
        }

        echo '</table>';
    } else {
        echo "<p>No attendance data found for $selectedDate.</p>";
    }

    $conn->close();
    ?>
</body>
</html>
