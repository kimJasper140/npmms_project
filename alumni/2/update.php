<?php
include("config/config.php");
include("session.php");


$id = $_POST['username'];
$name = $_POST['name'];

$username = $_POST['username'];
$password = $_POST['password'];





print_r($sql="UPDATE `user` SET `name`='$name',`username`='$username',
`password`='$password',`status`='active' WHERE `username`='$username'");
if(mysqli_query($mysqli, $sql)){
    echo '<script language="javascript">';
	echo 'alert("Record successfully updated!");';
	echo 'window.location="users.php";';
	echo '</script>';
	
} else {
	echo '<script language="javascript">';
	echo 'alert("Error Updating!");';
	echo 'window.location="users.php";';
	echo '</script>';
}
?>