<?php
include("../config/config.php");
include "checking_user.php";


if(!isset($_SESSION['visited'])) {
  // Set the 'visited' session variable to true
  $_SESSION['visited'] = true;

  // Get the user's name or username (adjust this part based on your database schema)
  $username = $_SESSION['username']; // Replace this with your actual method to retrieve the user's name

  // Display the personalized welcome message
  echo "<script>alert('Welcome back ,Admin $username!');</script>";
}
?>


<!DOCTYPE html>
<html>

<head>
  <title>Dashboard</title>
  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
  <link rel="icon" type="image/x-icon" href="../graphics/logo.ico">
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../bootstrap/icons/bootstrap-icons.min.css">
		
		
		<link rel="stylesheet" href="../sidebar/css/style.css">
    
  <style>
    body {
      margin: 20px;
    }

    .card-container {
      display: flex;
      flex-wrap: wrap;
      
     

    }

    .card {
      font-family: 'Roboto', sans-serif;
      width:200px;
      background-color: #fff;
      border-radius: 5px;
      padding: 10px;
      margin: 1rem;
      box-sizing: border-box;
      height: 100px;
      

    }

    .card.stall-owners {
      background-color: #ff9800;
      color: #fff;

    }

    .card.maintenance-reports {
      background-color: #03a9f4;
      color: #fff;

    }

    .card.violations {
      background-color: #e91e63;
      color: #fff;

    }

    .card.feedback {
      background-color: #9c27b0;
      color: #fff;

    }

    .card.applications {
      background-color: #4caf50;
      color: #fff;

    }

    .card.terminated {
      background-color: #f44336;
      color: #fff;

    }

    .card.closed {
      background-color: #607d8b;
      color: #fff;

    }

    .card.monthly-payment {
      background-color: #ffc107;
      color: #333;

    }

    .card.parking-rent {
      background-color: #2196f3;
      color: #fff;

    }

    .card.stall-settings {
      background-color: #9e9e9e;
      color: #fff;
    }

    .card.staff {
      background-color: #9e9e9e;
      color: #fff;

    }

    .card.admin {
      background-color: #795548;
      color: #fff;
    }

    .card.user-list {
      background-color: #795548;
      color: #000;
    }

    .card .icon {
      font-size: 10px;
      margin-bottom: 10px;
    }
    .card:hover {
            /* width: 320px; Increase the width on hover */
            height: auto;
            /* Allow the card to expand in height */
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
            /* Add a shadow on hover */
            transform: scale(1.1);
            transition: ease-in .3s;
            transition: ease-out .3s;
            z-index: 55555 !important;
    }

    @media screen and (max-width:870px) {
      .sidebar-container {
        flex-direction: column;
        margin-top: 14.5%;
      }

      .card {
        flex-direction: column;
      }

      .card.admin,
      .card.stall-owners,
      .card.maintenance-reports,
      .card.violations,
      .card.violations,
      .card.feedback,
      .card.monthly-payment,
      .card.parking-rent,
      .card.stall-settings,
      .card.staff,
      .card.admin,
      .card.user-list {
        justify-content: center;
        align-items: center;
        width: 13vw;
        height: 10vh;
        /* border: 1px solid blue; */
      }

      .card .category {
        font-size: 10px;
        font-weight: bold;
        margin-bottom: auto;
      }

      .card .count {
        font-size: 10px;
        font-weight: bold;
        color: #333;
      }
    }
  </style>
</head>

<body>
  <?php
  function plsCount($conn, $table) {
    $sql = "SELECT * FROM $table";
    $result = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($result);

    return $count;
  }

  include "sidebar/sidebar.php"
  ?>


   


  <div class="card-container">
    <a href="stall_owner.php" class="card stall-owners">
      <i class="bi bi-person-video3"></i>
      <div class="category">Stall Owners</div>
      <div class="count">
        <?php echo plsCount($conn, 'stall_owner'); ?>
      </div>
    </a>

    <a href="admin_maintainanceList.php" class="card maintenance-reports">
      <i class="bi bi-tools "></i>
      <div class="category">Maintenance Reports</div>
      <div class="count">
        <?php echo plsCount($conn, 'maintenance') ?>
      </div>
    </a>

    <a href="violation.php" class="card violations">
      <i class="bi bi-exclamation-circle "></i>
      <div class="category">Violations</div>
      <div class="count">
        <?php echo plsCount($conn, 'violation') ?>
      </div>
    </a>

    <a href="feedback.php" class="card feedback">
      <i class="bi bi-chat-square"></i>
      <div class="category">Feedback</div>
      <div class="count">
        <?php echo plsCount($conn, 'feedback') ?>
      </div>
    </a>



    <a href="monthly-payment.php" class="card monthly-payment">
      <i>&#8369;</i>
      <div class="category">Online Payment</div>
      
    </a>

    <a href="park_rent.php" class="card parking-rent">
      <i class="bi bi-car-front"></i>
      <div class="category">Parking Rent</div>
      <div class="count">
        <?php plsCount($conn, 'park_rent') ?>
      </div>
    </a>

    <?php
    $sql = "SELECT COUNT(*) AS count FROM available_stall where status = 'available' ";

    // Execute the query
    $result = $conn->query($sql);

    if($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $availableCount = $row['count'];
    } else {
      $availableCount = 0;
    }
    ?>
    <a href="setting-stall.php" class="card stall-settings">
      <i class="bi bi-shop"></i>
      <div class="category">Available Stall</div>
      <div class="count">
        <?php echo $availableCount ?>
      </div>
    </a>
    <?php
    $sql = "SELECT COUNT(*) AS count FROM user where roles = 'staff' ";

    // Execute the query
    $result = $conn->query($sql);

    if($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $availableCount = $row['count'];
    } else {
      $availableCount = 0;
    }
    ?>

    <a href="staff.php" class="card staff">
      <i class="bi bi-people-fill"></i>
      <div class="category">Staff</div>
      <div class="count">
        <?php echo $availableCount ?>
      </div>
    </a>
    <?php
    $sql = "SELECT COUNT(*) AS count FROM user where roles = 'admin' ";

    // Execute the query
    $result = $conn->query($sql);

    if($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $availableCount = $row['count'];
    } else {
      $availableCount = 0;
    }
    ?>
    <a href="admin_list.php" class="card admin">
      <i class="bi bi-person-fill-gear"></i>
      <div class="category">Admin</div>
      <div class="count">
        <?php echo $availableCount ?>
      </div>
    </a>

    <a href="user_management.php" class="card user-list">
      <i class="bi bi-person"></i>
      <div class="category">Users</div>
      <div class="count">
        <?php echo plsCount($conn, 'user') ?>
      </div>
    </a>

  </div>

</body>
    
    <script src="sidebar/js/jquery.min.js"></script>
    <script src="sidebar/js/popper.js"></script>
    <script src="sidebar/js/bootstrap.min.js"></script>
    <script src="sidebar/js/main.js"></script>
    
</html>