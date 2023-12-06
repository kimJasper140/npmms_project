<?php
include("../config/config.php");
session_start();


if (isset($_GET["month"])){  
    // SQL query to retrieve data from the database
    $month = $_GET["month"];
    $sql = "SELECT * FROM monthly_payment_details WHERE month='$month'";
    $result = $conn->query($sql);

    // Create a new file pointer
    $file = fopen('data.csv', 'w');

    // Set custom header
    $header = ["ID","Monthly Rental","Extension rental","Stall Extension Fee","Penalty","Interest","OR Number","Date","Total Amount","Remarks","Status","Stall Number","Month", "Fullname"];
    // Customize this array with your desired header names
    fputcsv($file, $header);

    // Write data rows
    while ($row = $result->fetch_assoc()) {
        fputcsv($file, $row);
    }

    // Close the database connection
    $conn->close();

    // Close the file pointer
    fclose($file);

    // Set headers to force download the CSV file
    header('Content-Type: application/csv');
    header('Content-Disposition: attachment; filename="data.csv"');
    header('Content-Length: ' . filesize('data.csv'));

    // Output the file to the browser
    readfile('data.csv');

    // Delete the file after download
    unlink('data.csv');
    }
?>