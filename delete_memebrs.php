<!DOCTYPE html>
<html>
<head>
    <title>Delete Members</title>
</head>
<body>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deleteSelected'])) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "fitness_center_management_system";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (isset($_POST['selectedMembers']) && is_array($_POST['selectedMembers'])) {
        $selectedMembers = $_POST['selectedMembers'];
        $memberIds = implode(",", $selectedMembers);

        $sql = "DELETE FROM member WHERE MemberID IN ($memberIds)";

        if ($conn->query($sql) === TRUE) {
            echo "Selected members deleted successfully.";
        } else {
            echo "Error deleting members: " . $conn->error;
        }
    } else {
        echo "No members selected for deletion.";
    }

    $conn->close();
}
?>

<p><a href="member_list.php">Back to Member List</a></p>

</body>
</html>
