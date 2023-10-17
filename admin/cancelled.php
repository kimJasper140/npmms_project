<?php
// Replace the database connection details with your actual credentials
include "../config/config.php";
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cancelled Applications</title>
    <!-- Add Bootstrap CSS link here -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<?php  include "sidebar-admin.php" ?>
    <div class="container mt-4" style="padding-top:5%;margin-left:25%;">
        <h2>Cancelled Applications</h2>
        <?php
        // SQL query to retrieve all applications with the status "cancelled"
        $sql = "SELECT id, stall_no, name, age, address, applicant_name, stall_no2, applicant_age, applicant_address, 
                       tax_certificate_issued_location, tax_certificate_issued_date, sworn_at, email, contact, status, 
                       remarks, user_id, owner_id 
                FROM applications 
                WHERE status = 'cancel'";

        // Execute the query
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                // Display the data using Bootstrap classes
                echo "<div class='card mb-3'>";
                echo "<div class='card-header'>Application ID: " . $row["id"] . "</div>";
                echo "<div class='card-body'>";
                echo "<h5 class='card-title'>Name: " . $row["name"] . "</h5>";
                echo "<p class='card-text'>Stall No: " . $row["stall_no"] . "</p>";
                // Add more fields to display as necessary
                echo "<p class='card-text'>Status: " . $row["status"] . "</p>";
                echo "<p class='card-text'>Remarks: " . $row["remarks"] . "</p>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<p>No cancelled applications found.</p>";
        }

        $conn->close();
        ?>
    </div>

    <!-- Add Bootstrap JS and jQuery scripts here (at the end of the body) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
