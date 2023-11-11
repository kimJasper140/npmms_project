<?php
include "../config/config.php"; // Include your database connection script

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['userId'])) {
        $userId = $_POST['userId'];

        // Update the user's status to "inactive" in the database
        $sql = "UPDATE user SET status = 'inactive' WHERE user_id = '$userId'";

        if ($conn->query($sql) === TRUE) {
            echo "User deactivated successfully";
            // You can handle any additional logic here if needed.
        } else {
            echo "Error deactivating user: " . $conn->error;
        }
    } else {
        echo "User ID not provided";
    }
} else {
    echo "Invalid request method";
}

// Close the database connection if needed
$conn->close();
?>
