<?php
include("../config/config.php");
include "check_user.php";
// After verifying credentials
$userId = $_SESSION['id'];
$queryOwner = "SELECT * FROM stall_owner WHERE user_id = '$userId'";
$resultOwner = mysqli_query($conn, $queryOwner);

if(!$resultOwner) {
  die("Error fetching stall owner information: ".mysqli_error($conn));
}

$rowOwner = mysqli_fetch_assoc($resultOwner);

// Fetch stall owner information

$stallNo = $rowOwner['id'];




$countQuery = "SELECT COUNT(*) AS unread_count FROM stall_notifications WHERE stall_owner_id = '$stallNo' AND notification_sent = 0";
$countResult = mysqli_query($conn, $countQuery);
$countRow = mysqli_fetch_assoc($countResult);
$unreadCount = $countRow['unread_count'];



?>

<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<link rel="stylesheet" href="../stall/barpage/css/style.css">
<style>
  .notification-circle {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 20px;
            height: 20px;
            background-color: red;
            color: white;
            font-size: 12px;
            border-radius: 50%;
            text-align: center;
            line-height: 20px;
        }.badge{
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
</style>
</head>


<div class="wrapper d-flex align-items-stretch">
  
  <nav id="sidebar" style="color:darkgreen;">
    <div class="custom-menu">
      <button type="button" id="sidebarCollapse" color:green; class="btn btn-success">
        <i class="fa fa-bars"></i>
        <div class="sr-only">Toggle Menu</div>
      </button>
    </div>
    <div class="p-4">
      <h1><a href="index.html" class="logo">NPMMS <span style="color:white;">
            <p>Welcome,
              <?php echo $_SESSION['username']; ?>!
            </p>
          </span></a></h1>
      <ul class="list-unstyled components mb-5">
        <li class="active">
          <a href="profile.php">
            <div class="fa fa-user mr-3"></div> Profile
          </a>
        </li>
        <li>
          <a href="transactions.php">
            <div class="fa fa-briefcase mr-3"></div> Transaction
          </a>
        </li>
        <li>
          <a href="violation.php">
            <div class="fa fa-exclamation-triangle mr-3 "></div> Violations
          </a>
        </li>
        <li>
          <a href="notification.php">
            <div class="fa fa-bell mr-3" id="notification-link" onclick="clearNotificationBadge()"></div> Notification<span class="badge" id="notification-badge"><?php echo ($unreadCount > 0) ? $unreadCount : ''; ?></span>
          </a>
        </li>
        <li>
          <a href="maintainance.php">
            <div class="fa fa-suitcase mr-3"></div> Maintainance
          </a>
        </li>
        <li>
          <a href="feedback.php">
            <div class="fa fa-file-text-o mr-3"></div> Feedback
          </a>
        </li>
        <li>
          <a href="profile-setting.php">
            <div class="fa fa-cogs mr-3"></div> Setting
          </a>
        </li>
        <li>
          <a href="../logout.php">
            <div class="fa fa-arrow-circle-left mr-3"></div> Logout
          </a>
        </li>
      </ul>

      <div class="mb-5">
        <h3 class="h6 mb-3"></h3>

      </div>

      <div class="footer">

      </div>

    </div>
  </nav>
  
  <!-- Page Content  -->
  <div id="content" class="p-4 p-md-5 pt-5">
    <div id="paymentReminder" class="alert alert-danger" style="color: red; display: none;">
      Monthly payment reminder: Please make the payment before the 20th of this month.

    </div>
    <script>
      // Function to check if it's three days before the 20th of the month
      function isThreeDaysBefore20th() {
        const currentDate = new Date();
        const currentDay = currentDate.getDate();

        // Check if it's between the 17th and 19th day of the month (three days before the 20th)
        return currentDay >= 17 && currentDay <= 19;
      }

      // Function to show or hide the reminder based on the date
      function showOrHideReminder() {
        const reminderDiv = document.getElementById("paymentReminder");
        if (isThreeDaysBefore20th()) {
          reminderDiv.style.display = "block";
        } else {
          reminderDiv.style.display = "none";
        }
      }

      // Call the function initially to check and display the reminder if needed
      showOrHideReminder();

      // Check and update the reminder every 10 seconds for testing purposes
      setInterval(showOrHideReminder, 1); // 10000 milliseconds = 10 seconds



      $(document).ready(function () {
        $("#notification-link").click(function (event) {
          event.preventDefault();

          console.log("Clicked notification link"); // Check if this message appears in the console

          // Send an AJAX request to update the read_status
          $.ajax({
            url: "update_notification_status.php",
            type: "POST",
            data: { readStatus: 1 },
            success: function (response) {
              console.log("AJAX response:", response); // Check the response in the console
              if (response === "success") {
                // Update the badge count
                $("#notification-badge").text("");
              }
            },
            error: function (xhr, status, error) {
              console.log("AJAX error:", error); // Check for AJAX errors in the console
            }
          });
        });
      });

    </script>



  