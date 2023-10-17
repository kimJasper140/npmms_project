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
    
    <style>

        .dropdown .dropdown-menu {
            display: none;
                   }

        .dropdown.show .dropdown-menu {
            display: block;
        }

        .dropdown:hover .dropdown-menu {
            animation: fade-in 0.2s ease-in;
            color: yellowgreen;
        }
        .dropdown-menu{
            background-color:dimgray;
        }
        @keyframes fade-in {
            0% {
                opacity: 0;
                transform: translateY(-10px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }/* Close button */
.close-btn {
    display: none; /* Hide the close button by default */
    position: absolute;
    top: 10px;
    right: 10px;
    background-color: black;
    border: none;
    color: #fff;
    font-size: 18px;
    cursor: pointer;
}




        @media only screen and (max-width: 767px) {
            .sidebar {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                z-index: 999;
                background: #299B63;
                padding-top: 60px;
                padding: 100px;
            }

            .sidebar ul {
                display: flex;
                flex-direction: column;
                align-items: flex-start;
            }

            .sidebar ul li {
                width: 100%;
                padding: 12px 24px;
                border-bottom: 1px solid #ddd;
            }

            .sidebar ul li:last-child {
                border-bottom: none;
            }

            .sidebar ul li a {
                color: #fff;
                text-decoration: none;
                display: flex;
                align-items: center;
                font-size: 15px;
                text-transform: uppercase;
                padding: 2px;
                transition: background-color 0.3s;
            }

            .sidebar ul li a i {
                margin-right: 10px;
            }

            #sidebar-toggle {
                display: block;
                position: fixed;
                top: 20px;
                left: 20px;
                font-size: 20px;
                color: #333;
                cursor: pointer;
            }

            .sidebar-active {
                display: block !important;
            }
            
        }
    </style>
</head>
<?php 
    include "../tempplate/loading_screen.php";
  ?>
<body>
    <div class="topbar">
        <div class="logo">
            <img src="../image/logo.png" alt="Logo">
            <h2 class="title">NPMMS</h2>
        </div>
        
        <h5 style=" margin-top:5px; margin-left: 75%;">
            <?php echo $_SESSION['username']; ?>
        </h5>
        <a href="../edit-profile.php" style="margin-left:-45px;">
        <?php
        if (!empty($user['profile'])) {
                echo '<img class="profile-pic" src="../stall/' . $user['profile'] . '" alt="Profile Picture">';
            } else {
                echo '<img class="profile-pic" src="profile/default.jpeg" alt="Default Profile Picture">';
            }
            ?>
        </a>
    </div>

   
</body>

</html>