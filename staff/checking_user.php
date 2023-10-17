<?php
include "../config/session.php";
if (!isset($_SESSION['username']) && $_SESSION['roles'] != 'staff'){
    header("location:../index.php");
    session_destroy();

}
?>