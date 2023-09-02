<!DOCTYPE html>
<html>
<head>
    <title>Evening Shift Members</title>
    <style>
        /* Your CSS styles here */
        table {
            border-collapse: collapse;
            width: 100%;
            border: 2px solid #ddd;
        }

        th, td {
            text-align: left;
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        input[type="number"] {
            width: 50px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        a {
            color: blue;
        }
    </style>
</head>
<body>
    <h1>Evening Shift Members</h1>

    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "fitness_center_management_system";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Add members to Evening Shift
        if (isset($_POST['markAttendance']) && isset($_POST['selectedMembers']) && is_array($_POST['selectedMembers'])) {
            $selectedMembers = $_POST['selectedMembers'];
            $durationDays = $_POST['durationDays'];

            foreach ($selectedMembers as $memberID) {
                $membershipExpiryDate = date("Y-m-d", strtotime("+ $durationDays days"));
                $insertQuery = "INSERT INTO evening_shift (MemberID, MembershipDurationDays, MembershipExpiryDate, MembershipStatus) VALUES ('$memberID', '$durationDays', '$membershipExpiryDate', 'Active')";
                $conn->query($insertQuery);
            }

            echo "Members added to evening shift successfully.";
        }

        // Remove members from Evening Shift
        if (isset($_POST['removeFromEveningShift']) && isset($_POST['removeMembers']) && is_array($_POST['removeMembers'])) {
            $removeMembers = $_POST['removeMembers'];

            foreach ($removeMembers as $memberID) {
                $removeQuery = "DELETE FROM evening_shift WHERE MemberID = '$memberID'";
                $conn->query($removeQuery);
            }

            echo "Members removed from evening shift successfully.";
        }
    }

    $notInEveningShiftSql = "SELECT member.MemberID, member.FirstName, member.LastName FROM member LEFT JOIN evening_shift ON member.MemberID = evening_shift.MemberID WHERE evening_shift.MemberID IS NULL";
    $notInEveningShiftResult = $conn->query($notInEveningShiftSql);

    $inEveningShiftSql = "SELECT member.MemberID, member.FirstName, member.LastName, evening_shift.MembershipDurationDays, evening_shift.MembershipExpiryDate FROM member INNER JOIN evening_shift ON member.MemberID = evening_shift.MemberID";
    $inEveningShiftResult = $conn->query($inEveningShiftSql);
    ?>

    <h2>Add Members to Evening Shift</h2>
    <form action="" method="post">
        <table>
            <tr>
                <th>Member ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Membership Duration (Days)</th>
                <th>Add to Evening Shift</th>
            </tr>

            <?php
            if ($notInEveningShiftResult && $notInEveningShiftResult->num_rows > 0) {
                while ($row = $notInEveningShiftResult->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['MemberID']}</td>
                            <td>{$row['FirstName']}</td>
                            <td>{$row['LastName']}</td>
                            <td><input type='number' name='durationDays' value='30'></td>
                            <td><input type='checkbox' name='selectedMembers[]' value='" . $row['MemberID'] . "'></td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>All members are already in the evening shift.</td></tr>";
            }
            ?>

        </table>
        <input type="submit" name="markAttendance" value="Add to Evening Shift">
    </form>

    <h2>Remove Members from Evening Shift</h2>
    <form action="" method="post">
        <table>
            <tr>
                <th>Member ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Membership Duration (Days)</th>
                <th>Membership Status</th>
                <th>Remove</th>
            </tr>

            <?php
            if ($inEveningShiftResult && $inEveningShiftResult->num_rows > 0) {
                while ($row = $inEveningShiftResult->fetch_assoc()) {
                    $membershipStatus = ($row['MembershipDurationDays'] > 0) ? 'Active' : 'Expired';
                    echo "<tr>
                            <td>{$row['MemberID']}</td>
                            <td>{$row['FirstName']}</td>
                            <td>{$row['LastName']}</td>
                            <td>{$row['MembershipDurationDays']}</td>
                            <td>{$membershipStatus}</td>
                            <td><input type='checkbox' name='removeMembers[]' value='" . $row['MemberID'] . "'></td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No member data found.</td></tr>";
            }
            ?>

        </table>
        <input type="submit" name="removeFromEveningShift" value="Remove from Evening Shift">
    </form>

    <a href="dashboard.html">Go back to Dashboard</a>
</body>
</html>
