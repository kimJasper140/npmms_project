<?php
include 'config/database.php';

$id = $_POST['stall_number'];

$a = new database();
$a->delete('stall', "stall_number='$id'");
?>