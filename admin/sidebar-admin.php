<?php
include "../config/config.php";

// Retrieve the count of unread notifications
$countQuery = "SELECT COUNT(*) AS unread_count FROM notifications WHERE read_status = 0";
$countResult = mysqli_query($conn, $countQuery);
$countRow = mysqli_fetch_assoc($countResult);
$unreadCount = $countRow['unread_count'];


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

    <style>
        .badge{
        top: 0;
        right: 0;
        background-color: red;
        color: white;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        font-size: 12px;
        display: flex;
        justify-content: center;
        align-items: center;

        }
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

        .dropdown-menu {
            background-color: dimgray;
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
        }

        /* Close button */
        .close-btn {
            display: none;
            /* Hide the close button by default */
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

            /* Fix for modal issues on mobile */
            .modal {
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
            }
        }
    </style>
</head>

<body>
    <?php 
    include "../tempplate/loading_screen.php";
    ?>
    <div class="topbar">
        <div class="logo">
            <img src="../image/logo.png" alt="Logo">
            <h2 class="title">NPMMS</h2>
        </div>
        <h5 style="margin-top:5px; margin-left: 80%;">
            <?php echo $_SESSION['username']; ?>
        </h5>
        <a href="../admin/admin-setting.php" style="margin-left:-45px;">
            <?php

            // Display the profile picture
            if (!empty($user['profile'])) {
                echo '<img class="profile-pic" src="../admin/' . $user['profile'] . '" alt="Profile Picture">';
            } else {
                echo '<img class="profile-pic" src="profile/default.jpeg" alt="Default Profile Picture">';
            }
            ?>
        </a>
    </div>

    <div class="sidebar" id="sidebar">
        <ul>
            <li><a href="dashboard-admin.php"><i class="fas fa-chart-pie"></i>Dashboard</a></li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" id="userDropdownMenuLink">
                    <i class="fas fa-user"></i>User
                </a>
                <ul class="dropdown-menu" id="userDropdownMenu">
                    <li><a href="../admin/user_management.php" class="fas fa-user">Add | View</a></li>
                    <li><a href="../admin/inactive_account.php" class="fas fa-user">Inactive Account</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" id="applicationsDropdownMenuLink">
                    <i class="fas fa-store"></i>Applications
                </a>
                <ul class="dropdown-menu" id="applicationsDropdownMenu">
                    <li><a href="pre-application.php" class="fas fa-users">Pre-application</a></li>
                    
                    <li><a href="approved.php" class="fas fa-users">Approved</a></li>
                    <li><a href="declined.php" class="fas fa-users">Disapproved</a></li>
                    <li><a href="cancelled.php" class="fas fa-users">Cancelled</a></li>
                </ul>
            </li>
            <li><a href="../admin/stall_operate.php"><i class="fas fa-store"></i>Stall</a></li>
            <li><a href="../admin/annoucement.php"><i class="fas fa-bullhorn"></i>Announcement</a></li>
            <li><a href="../admin/srp-list.php"><i class="fas fa-tags"></i>SRP</a></li>
            <li>
            <a href="notification_page.php" id="notification-link" onclick="markNotificationsAsRead()">
        <i class="fas fa-bell"></i>Notification
        <span class="badge" id="notification-badge"><?php echo ($unreadCount > 0) ? $unreadCount : ''; ?></span>
    </a>
            </li>
            <li><a href="about.php"><i class="fas fa-info-circle"></i>About</a></li>
            <li><a href="admin-setting.php"><i class="fas fa-cog"></i>Settings</a></li>
            <li>
                <button style="background-color: transparent; border: none;" id="logout-btn" onclick="logout()">
                    <a href="#">
                        <i class="fas fa-sign-out-alt"></i>Logout
                    </a>
                </button>
            </li>
        </ul>
    </div>

    <i style="margin-left:80%;" class="fas fa-bars" id="sidebar-toggle"></i>

    <script>
        var sidebar = document.getElementById("sidebar");
        var sidebarToggle = document.getElementById("sidebar-toggle");

        sidebarToggle.addEventListener("click", function () {
            sidebar.classList.toggle("sidebar-active");
        });

        var userDropdownToggle = document.getElementById("userDropdownMenuLink");
        var userDropdownMenu = document.getElementById("userDropdownMenu");
        var isUserDropdownOpen = false;

        userDropdownToggle.addEventListener("click", function (event) {
            event.preventDefault();
            isUserDropdownOpen = !isUserDropdownOpen;
            userDropdownMenu.style.display = isUserDropdownOpen ? "block" : "none";
        });

        var applicationsDropdownToggle = document.getElementById("applicationsDropdownMenuLink");
        var applicationsDropdownMenu = document.getElementById("applicationsDropdownMenu");
        var isApplicationsDropdownOpen = false;

        applicationsDropdownToggle.addEventListener("click", function (event) {
            event.preventDefault();
            isApplicationsDropdownOpen = !isApplicationsDropdownOpen;
            applicationsDropdownMenu.style.display = isApplicationsDropdownOpen ? "block" : "none";
        });

        var stallDropdownToggle = document.getElementById("stallDropdownMenuLink");
        var stallDropdownMenu = document.getElementById("stallDropdownMenu");
        var isStallDropdownOpen = false;

        stallDropdownToggle.addEventListener("click", function (event) {
            event.preventDefault();
            isStallDropdownOpen = !isStallDropdownOpen;
            stallDropdownMenu.style.display = isStallDropdownOpen ? "block" : "none";
        });

        // Close dropdown menus when clicking outside
        window.addEventListener("click", function (event) {
            if (!userDropdownToggle.contains(event.target) && !userDropdownMenu.contains(event.target)) {
                userDropdownMenu.style.display = "none";
                isUserDropdownOpen = false;
            }
            if (!applicationsDropdownToggle.contains(event.target) && !applicationsDropdownMenu.contains(event.target)) {
                applicationsDropdownMenu.style.display = "none";
                isApplicationsDropdownOpen = false;
            }
            if (!stallDropdownToggle.contains(event.target) && !stallDropdownMenu.contains(event.target)) {
                stallDropdownMenu.style.display = "none";
                isStallDropdownOpen = false;
            }
        });

        // Close dropdown menus on window resize
        window.addEventListener("resize", function () {
            if (window.innerWidth >= 768) {
                userDropdownMenu.style.display = "none";
                isUserDropdownOpen = false;
                applicationsDropdownMenu.style.display = "none";
                isApplicationsDropdownOpen = false;
                stallDropdownMenu.style.display = "none";
                isStallDropdownOpen = false;
            }
        });
    </script>


     
     <script>
    function markNotificationsAsRead() {
        // Send an AJAX request to update the read_status
        $.ajax({
            url: "update_notification_status.php",
            type: "POST",
            data: { readStatus: 1 }, // Set the read_status value to 1
            success: function (response) {
                // Update the badge count
                $("#notification-badge").text("");
                // Update the unreadCount variable
                <?php $unreadCount = 0; ?>;
                // Redirect to the notification page
                window.location.href = "notification_page.php";
            },
            error: function (xhr, status, error) {
                console.log(error);
            }
        });
    }

    </script>
</body>

</html>
