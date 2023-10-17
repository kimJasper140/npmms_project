<?php
include("config/config.php");
include("session.php");



$userid = $_POST['id'];
$name = $_POST['name'];
$role = $_POST['role'];
$username = $_POST['username'];
$password = $_POST['password'];





$sql = "INSERT INTO user(user_id,name, roles,username, password,status) 
VALUES('$userid', '$name', '$role', '$username','$password','active')";
if(mysqli_query($mysqli, $sql)){
    echo '<script language="javascript">';
	echo 'alert("New user was added!");';
	echo 'window.location="home.php";';
	echo '</script>';
	
} else {
	echo '<script language="javascript">';
	echo 'alert("Duplicate user!");';
	echo 'window.location="registration.php";';
	echo '</script>';
}
?>