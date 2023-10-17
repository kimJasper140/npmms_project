<?php
include "../config/session.php";
if (!isset($_SESSION['username']) && $_SESSION['roles'] =! 'stall_owner') {
	header("location:../index.php");
	session_destroy();
}
?>