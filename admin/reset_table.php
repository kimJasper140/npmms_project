<?php
include "../config/config.php";

// SQL query to delete all entries from the park_rent table
$sql = "DELETE FROM park_rent";

if (mysqli_query($conn, $sql)) {
    echo "success"; // Send a success response back to the JavaScript function
} else {
    echo "error";
}

// Close the database connection
mysqli_close($conn);
?>
