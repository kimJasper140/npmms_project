<?php
include "../config/config.php";
include "../config/session.php";

if (!isset($_SESSION['username']) || $_SESSION['roles'] != 'stall_owner') {
    header("location:../index.php");
    exit();
}

$userId = $_SESSION['id'];

// Fetch stall owner information
$queryOwner = "SELECT * FROM stall_owner WHERE user_id = '$userId'";
$resultOwner = mysqli_query($conn, $queryOwner);

if (!$resultOwner) {
    die("Error fetching stall owner information: " . mysqli_error($conn));
}

$rowOwner = mysqli_fetch_assoc($resultOwner);

// Check if the stall owner information is found
if (!$rowOwner || !isset($rowOwner['stall_no'])) {
    die("Stall owner information not found.");
}

// Fetch notifications for the stall owner based on their stall number
$stallNo = $rowOwner['id'];
$queryNotifications = "SELECT * FROM stall_notifications WHERE stall_owner_id = '$stallNo' ORDER BY notification_timestamp DESC";
$resultNotifications = mysqli_query($conn, $queryNotifications);
print_r($updateQuery = "UPDATE stall_notifications SET notification_sent = true WHERE stall_owner_id = '$stallNo'");
$updateResult = mysqli_query($conn, $updateQuery);

if (!$resultNotifications) {
    die("Error fetching notifications: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $rowOwner['name']; ?>'s Notification Page</title>
    <!-- Add Bootstrap CSS link here -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Your additional CSS styles here */
        .notification-list {
            margin-top: 20px;
        }
        .notification {
            margin-bottom: 20px;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 4px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }
        .notification h4 {
            margin-top: 0;
        }
        .notification p {
            color: #666;
        }
        .back-btn {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <?php include "barpage/topbar.php"; ?>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h3 class="text-center"><?php echo $rowOwner['name']; ?>'s Notifications</h3>
                <hr>
                <?php if (mysqli_num_rows($resultNotifications) > 0) { ?>
                    <div class="notification-list">
                        <?php while ($rowNotification = mysqli_fetch_assoc($resultNotifications)) { ?>
                            <div class="notification">
                                <h4><?php echo $rowNotification['subject']; ?></h4>
                                <p><?php echo $rowNotification['message']; ?></p>
                                <p><?php echo $rowNotification['notification_timestamp']; ?></p>
                            </div>
                        <?php } ?>
                    </div>
                <?php } else { ?>
                    <p class="text-center">No notifications found.</p>
                <?php } ?>
                <div class="back-btn">
                    <a href="stall_dashboard.php" class="btn btn-primary">Back to Stall Dashboard</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Bootstrap JS scripts here -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function () {
            $(".mark-as-read-btn").click(function () {
                const notificationId = $(this).data("notification-id");

                // Send an AJAX request to mark the notification as read
                $.ajax({
                    url: "mark_notification_as_read.php", // Update the URL to the correct file path
                    type: "POST",
                    data: { notificationId: notificationId }, // Pass the notification ID
                    success: function (response) {
                        if (response === "success") {
                            // Remove the notification from the UI
                            $(this).closest(".notification").remove();
                        }
                    },
                    error: function (xhr, status, error) {
                        console.log(error);
                    }
                });
            });
        });
    </script>
</body>
</html>
