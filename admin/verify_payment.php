<?php 
	include '../config/config.php';
	session_start();
	
	$id = $_POST['payment_id'];
	
	$sql = "SELECT * FROM payment_details WHERE id = '$id'";
	
	
?>