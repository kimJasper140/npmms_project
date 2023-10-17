<?php
include("../config/config.php");
include "check_user.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the readStatus value from the AJAX request
    $readStatus = $_POST['readStatus'];

    // Update the notification_sent value in the database
    $userId = $_SESSION['id'];
    $sql_check_stall_owner = "SELECT * FROM stall_owner WHERE user_id = '$userId'";
    $result_check_stall_owner = $conn->query($sql_check_stall_owner);
    if ($result_check_stall_owner->num_rows === 0) {
        echo "<p class='mt-4'>Error: Stall owner with ID $user_id not found.</p>";
        exit;
    }

    // Fetch the stall_owner_id from the stall_owner table
    $row_check_stall_owner = $result_check_stall_owner->fetch_assoc();
    $stall_owner_id = $row_check_stall_owner['id'];

    print_r($updateQuery = "UPDATE stall_notifications SET notification_sent = true WHERE stall_owner_id = '$stall_owner_id'");
    $updateResult = mysqli_query($conn, $updateQuery);

    if ($updateResult) {
        echo "success";
    } else {
        echo "error";
    }
} else {
    echo "Invalid request";
}

// Close the database connection
mysqli_close($conn);
?>
