<?php
include "../config/config.php";

// Fetching data from the database
$sql = "SELECT COUNT(*) AS count, violation_date 
FROM violation
WHERE stall_owner_id = 42
GROUP BY violation_date
ORDER BY violation_date;";
$result = $conn->query($sql);

$data = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Close connection
$conn->close();

// Return data as JSON
echo json_encode($data);
?>
