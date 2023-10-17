<?php
include "../config/config.php";
$user_id = $_SESSION['id'];
$selectUserSql = "SELECT * FROM `user` WHERE `user_id` = $user_id";
$UserResult = mysqli_query($conn, $selectUserSql);
$user = mysqli_fetch_assoc($UserResult);
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="../tempplate/side-bar.css">
    <link rel="icon" href="../image/logo.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>


    <?php 
    include "../tempplate/loading_screen.php";
    ?>
    <div class="topbar" style="position:fixed;">
        <div class="logo">
            <img src="../image/logo.png" alt="Logo">
            <h2 class="title">NPMMS</h2>
        </div>
        <h5 style="margin-top:5px; margin-left: 80%;">
            <?php echo $_SESSION['username']; ?>
        </h5>
        <a href="../staff/staff-setting.php" style="margin-left:-45px;">
            <?php

            // Display the profile picture
            if (!empty($user['profile'])) {
                echo '<img class="profile-pic" src="../staff/' . $user['profile'] . '" alt="Profile Picture">';
            } else {
                echo '<img class="profile-pic" src="profile/default.jpeg" alt="Default Profile Picture">';
            }
            ?>
        </a>
    </div>
 