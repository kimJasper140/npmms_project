<?php
include "../config/config.php";


// Get the current date
$current_date = date("Y-m-d");

// Fetch data for the current date
$sql = "SELECT * FROM park_rent WHERE DATE(date) = '$current_date'";
$result = mysqli_query($conn, $sql);

// Generate the daily report
if (mysqli_num_rows($result) > 0) {
    echo "<h2>Daily Report for " . date("F j, Y") . "</h2>";
    echo "<table>";
    echo "<tr><th>Name</th><th>Plate No</th><th>Time In</th><th>Time Out</th><th>Amount</th><th>Remarks</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $row['plate_no'] . "</td>";
        echo "<td>" . $row['time_in'] . "</td>";
        echo "<td>" . $row['time_out'] . "</td>";
        echo "<td>" . $row['amount'] . "</td>";
        echo "<td>" . $row['remarks'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No entries found for today.";
}

// Close the database connection
mysqli_close($conn);
?>
