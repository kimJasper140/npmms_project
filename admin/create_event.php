<?php
include "../config/config.php";
// Check connection
if ($conn->connect_error) {
    die(json_encode(array('success' => false)));
}

// Get the event data from the request
$data = json_decode(file_get_contents('php://input'), true);
$title = $data['title'];
$date = $data['date'];
$paymentDue = $data['paymentDue'];

// Insert the event into the database
$stmt = $conn->prepare('INSERT INTO events (title, date, payment_due) VALUES (?, ?, ?)');
$stmt->bind_param('sss', $title, $date, $paymentDue);

if ($stmt->execute()) {
    echo json_encode(array('success' => true));
} else {
    echo json_encode(array('success' => false));
}

$stmt->close();
$conn->close();
?>
