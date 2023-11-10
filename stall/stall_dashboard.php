<?php
include("../config/config.php");
include "check_user.php";
// After verifying credentials
$userId = $_SESSION['id'];
$queryOwner = "SELECT * FROM stall_owner WHERE user_id = '$userId'";
$resultOwner = mysqli_query($conn, $queryOwner);

if (!$resultOwner) {
    die("Error fetching stall owner information: " . mysqli_error($conn));
}

$rowOwner = mysqli_fetch_assoc($resultOwner);

// Fetch stall owner information
$stallNo = $rowOwner['id'];

$countQuery = "SELECT COUNT(*) AS unread_count FROM stall_notifications WHERE stall_owner_id = '$stallNo' AND notification_sent = 0";
$countResult = mysqli_query($conn, $countQuery);
$countRow = mysqli_fetch_assoc($countResult);
$unreadCount = $countRow['unread_count'];



?>

<!DOCTYPE html>
<html>
<head>
    <title>Stall Owner Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .custom-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f2f2f2;
        }

        .dashboard {
            width: 400px;
            padding: 20px;
            border-radius: 4px;
            background-color: #fff;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }

        h2 {
            margin: 0 0 20px;
            text-align: center;
            font-size: 24px;
        }

        p {
            margin: 0 0 20px;
            text-align: center;
            font-size: 16px;
        }

        .customA{
            display: block;
            margin-bottom: 10px;
            padding: 10px;
            text-decoration: none;
            text-align: center;
            color: #333;
            background-color: #f2f2f2;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

      .customA:hover {
            background-color: #e0e0e0;
        }
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
        @media (max-width: 768px) {
            .custom-container{
                
            }


        }
    </style>
</head>
<?php
include "barpage/topbar.php";
include "contract_remider.php";
?>
<body>
    <div class="custom-container">


        <div class="dashboard">
            <!-- Place this inside the <body> tag -->
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
setInterval(showOrHideReminder, 0); // 10000 milliseconds = 10 seconds



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

            <p>Welcome, <?php echo $_SESSION['username']; ?>!</p>
            <a class="customA" href="profile.php">Profile</a></li>
            <a class="customA" href="transactions.php">Transaction</a></li>
                <a class="customA" href="violation.php">Stall Violation</a></li>
                <a class="customA" href="notification.php" id="notification-link" onclick="clearNotificationBadge()">
    <i class=""></i>Notification
    <span class="badge" id="notification-badge"><?php echo ($unreadCount > 0) ? $unreadCount : ''; ?></span>
</a>

                <a class="customA" href="maintainance.php">Maintenance Reports</a></li>
                <a class="customA" href="feedback.php">Feedback</a></li>
                <a class="customA" href="profile-setting.php">Account Settings</a></li>
                <a class="customA" href="../logout.php">Logout</a></li>
        </div>
    </div>
</body>
<script>
function clearNotificationBadge() {
    // Find the notification badge element
    var badge = document.getElementById("notification-badge");

    // Check if there's a new notification (you can set this value from your PHP logic)
    var isNewNotification = <?php echo ($unreadCount > 0) ? 'true' : 'false'; ?>;

    if (isNewNotification) {
        // Clear the badge content (remove the number) and set it back to red
        badge.textContent = '';
        badge.style.backgroundColor = 'red';
        badge.style.color = 'white';
    } else {
        // If there's no new notification, clear the badge content and make it transparent
        badge.textContent = '';
        badge.style.backgroundColor = 'transparent';
        badge.style.color = 'black';
    }
}
</script>
</html>

