<?php
// fetch_payment_data.php

require_once '../config/config.php';

// Function to fetch payment data from the database
function getPaymentData()
{
    global $conn;
    $sql = "SELECT * FROM payment_details";
    $result = $conn->query($sql);
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}

// Fetch payment data
$paymentData = getPaymentData();

// Output payment data in JSON format
header('Content-Type: application/json');
echo json_encode($paymentData);
?>
