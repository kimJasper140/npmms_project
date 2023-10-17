<?php
include("../config/config.php");
include "checking_user.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .card-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            max-width: 70%;
            margin-left: 25%;
            margin-top: 5%;
        }

        .card {
            width: calc(33.33% - 20px);
            background-color: #f2f2f2;
            border-radius: 4px;
            padding: 20px;
            margin-bottom: 20px;
            box-sizing: border-box;
        }

        .card .category {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .card .count {
            font-size: 36px;
            font-weight: bold;
            color: #333;
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

        .card.staff {
            background-color: #9e9e9e;
            color: #fff;
        }

        .card.admin {
            background-color: #795548;
            color: #fff;
        }

        .card .icon {
            font-size: 48px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <?php
    include "sidebar-admin.php";
    ?>
         <?php
          $sql = "SELECT COUNT(*) AS count FROM stall_owner ";

          // Execute the query
          $result = $conn->query($sql);

          if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $availableCount = $row['count'];
          } else {
            $availableCount = 0;
          }
?>
    <div class="card-container">
        <a href="stall_owner.php" class="card stall-owners">
            <i class="fas fa-store icon"></i>
            <div class="category">Stall Owners</div>
            <div class="count"><?php echo $availableCount ?></div>
        </a>
        <a href="maintenance-reports.php" class="card maintenance-reports">
            <i class="fas fa-tools icon"></i>
            <div class="category">Maintenance Reports</div>
            <div class="count">25</div>
        </a>
        <a href="violations.php" class="card violations">
            <i class="fas fa-exclamation-circle icon"></i>
            <div class="category">Violations</div>
            <div class="count">10</div>
        </a>
        <?php
          $sql = "SELECT COUNT(*) AS count FROM feedback ";

          // Execute the query
          $result = $conn->query($sql);

          if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $availableCount = $row['count'];
          } else {
            $availableCount = 0;
          }
?>
        <a href="feedback.php" class="card feedback">
            <i class="fas fa-comment-alt icon"></i>
            <div class="category">Feedback</div>
            <div class="count"><?php echo $availableCount?></div>
        </a>
        <a href="applications.php" class="card applications">
            <i class="fas fa-file-alt icon"></i>
            <div class="category">Applications</div>
            <div class="count">75</div>
        </a>
    
        <a href="monthly-payment.php" class="card monthly-payment">
            <i class="fas fa-dollar-sign icon"></i>
            <div class="category">Stall Monthly Payment</div>
            <div class="count">$5000</div>
        </a>
        <a href="parking-rent.php" class="card parking-rent">
            <i class="fas fa-car icon"></i>
            <div class="category">Parking Rent</div>
            <div class="count">$500</div>
        </a>
        <a href="staff.php" class="card staff">
            <i class="fas fa-users icon"></i>
            <div class="category">Staff</div>
            <div class="count">20</div>
        </a>
        <a href="admin.php" class="card admin">
            <i class="fas fa-user-cog icon"></i>
            <div class="category">Admin</div>
            <div class="count">5</div>
        </a>
        <a href="admin.php" class="card admin">
    <i class="fas fa-user icon"></i>
    <div class="category">Users</div>
    <div class="count">5</div>
</a>

    </div>

    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>
