<?php
// add_violation.php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the form data from the POST request
    $violationType = $_POST["violationType"];
    $description = $_POST["description"];
    $appeal = $_POST["appeal"];
    $remarks = $_POST["remarks"];
    $remediation = $_POST["remediation"];

    // You may add additional validation for the form data as needed

    // Include your database connection file
    include "../config/config.php";

    // Prepare the SQL query to insert the violation data into the database
    $query = "INSERT INTO violation (violation_type, description, appeal, remarks, remediation) 
              VALUES ('$violationType', '$description', '$appeal', '$remarks', '$remediation')";

    // Execute the SQL query
    if (mysqli_query($conn, $query)) {
        // Close the database connection
        mysqli_close($conn);

        // Return a success response
        echo "success";
        exit;
    } else {
        // Failed to insert data, return an error response
        echo "error";
        exit;
    }
} else {
    // Invalid request method, return an error response
    echo "error";
    exit;
}
?>
