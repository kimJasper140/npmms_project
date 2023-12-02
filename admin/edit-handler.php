<?php 
require_once '../config/config.php';
session_start();

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save_changes'])){
    $id = $_POST["id-container"];
    $monthly_rental = $_POST["monthly_rental"];
    $extension_rental = $_POST["extension_rental"];
    $stall_extension_rental = $_POST["stall_extension_fee"];
    $penalty = $_POST["penalty"];
    $interest = $_POST["interest"];
    $remarks = $_POST["remarks"];

    $updateSql = "UPDATE monthly_payment_details SET monthly_rental='$monthly_rental', extension_rental='$extension_rental', stall_extension_fee='$stall_extension_rental' ,penalty_25='$penalty', interest_2='$interest', remarks='$remarks' WHERE id='$id'";
    if ($conn->query($updateSql) === TRUE) {
        header("Location: report-overview.php");
    } else {
        echo "Error updating record: " . $conn->error;
    }

    #header("Location: report-overview.php");
}