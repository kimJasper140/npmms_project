<?php
// Database connection and configuration
include "../config/config.php";

// Get section and search parameters
$section = $_POST['section'];
$search = $_POST['search'];
$tab = $_POST['tab'];

// Prepare the SQL query based on the section and search parameters
$sql = "SELECT * FROM stall";
if ($tab === 'occupied-stalls') {
    $sql .= " WHERE status = 'occupied'";
} else {
    $sql .= " WHERE status = 'available'";
}
if ($section !== 'all') {
    $sql .= " AND category = '$section'";
}
if ($search !== '') {
    $sql .= " AND stall_name LIKE '%$search%'";
}

// Execute the query
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch all stalls
    $stalls = array();
    while ($row = $result->fetch_assoc()) {
        $stalls[] = $row;
    }

    // Fetch counts for each section
    $counts = array();
    $sectionQuery = "SELECT category, COUNT(*) AS count FROM stall WHERE status = 'available' GROUP BY category";
    $sectionResult = $conn->query($sectionQuery);
    while ($row = $sectionResult->fetch_assoc()) {
        $counts[$row['category']] = $row['count'];
    }

    $response = array('success' => true, 'stalls' => $stalls, 'counts' => $counts);
} else {
    $response = array('success' => false);
}

// Return the response as JSON
header('Content-Type: application/json');
echo json_encode($response);

$conn->close();
?>
