<?php
require_once '../config/config.php';
session_start();

if (isset($_GET['id'])) {
    // Get the 'id' parameter value from the URL
    $id = $_GET['id'];
    
    $sql = "SELECT * FROM monthly_payment_details WHERE id=$id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // Output data of each row
        echo "<table border='1'>";
        echo "<tr><th>ID</th>";
        echo "<th>Fullname</th>";
        echo "<th>Monthly Rental</th>";
        echo "<th>Extension Rental</th>";
        echo "<th>Paid</th>";
        echo "<th>Stall Extension Fee</th>";
        echo "<th>Penalty</th>";
        echo "<th>Interest</th>";
        echo "<th>OR Number</th>";
        echo "<th>Date</th>";
        echo "<th>Total Amount</th>";
        echo "<th>Remarks</th>";
        echo "<th>Status</th>";
        echo "<th>Owner ID</th></tr>";
    
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["id"] . "</td>";
            echo "<td>". $row["fullname"] . "</td>";
            echo "<td>". $row["monthly_rental"] . "</td>";
            echo "<td>". $row["extension_rental"] . "</td>";
            echo "<td>". $row["paid"] . "</td>";
            echo "<td>". $row["stall_extension_fee"] . "</td>";
            echo "<td>". $row["penalty_25"] . "</td>";
            echo "<td>". $row["interest_2"] . "</td>";
            echo "<td>" . $row["or_no"] . "</td>";
            echo "<td>" . $row["date"] . "</td>";
            echo "<td>" . $row["total_amount"] . "</td>";
            echo "<td>" . $row["remarks"] . "</td>";
            echo "<td>" . $row["status"] . "</td>";
            echo "<td>" . $row["owner_id"] . "</td></tr>";
        }
    
        echo "</table>";
    } else {
        echo "0 results";
    }
    

} else {
    echo "ID parameter is missing.";
}

?>