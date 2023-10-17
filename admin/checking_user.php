<?php
include "../config/session.php";
if (!isset($_SESSION['username']) && $_SESSION['roles'] != 'admin'){
    header("location:../index.php");
    session_destroy();

}
?>