<?php
// edit_violation.php

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["violationId"])) {
    // Get the violation ID from the POST data
    $violationId = $_POST["violationId"];

    // Validate and sanitize the violation ID (you may add additional validation as needed)
    if (!filter_var($violationId, FILTER_VALIDATE_INT) || $violationId <= 0) {
        // Invalid violation ID, return an error response
        echo json_encode(["error" => "Invalid violation ID"]);
        exit;
    }

    // Include your database connection file
    include "../config/config.php";

    // Fetch the violation data from the database for the given violation ID
    $query = "SELECT * FROM violation WHERE violation_id = $violationId";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        // Fetch the violation data as an associative array
        $violationData = mysqli_fetch_assoc($result);

        // Close the database connection
        mysqli_close($conn);

        // Return the violation data as JSON response
        echo json_encode($violationData);
        exit;
    } else {
        // Violation not found, return an error response
        echo json_encode(["error" => "Violation not found"]);
        exit;
    }
} else {
    // Invalid request method or missing violationId, return an error response
    echo json_encode(["error" => "Invalid request"]);
    exit;
}
?>
