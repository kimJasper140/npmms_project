<?php
// update_payment_status.php

require_once '../config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['paymentId'])) {
        $paymentId = $_POST['paymentId'];

        // Update the payment status in the database
        $sql = "UPDATE payment_details SET status = 'Paid' WHERE id = $paymentId";
        if ($conn->query($sql) === TRUE) {
            echo "success";
        } else {
            echo "error";
        }
    }
}
?>
