<?php
include "../config/config.php";
include "checking_user.php";

// Check if the admin has viewed the notifications
if (isset($_SESSION['admin_viewed_notifications'])) {
    // Mark the notifications as read
    $markReadQuery = "UPDATE notifications SET read_status = 1";
    mysqli_query($conn, $markReadQuery);

    // Reset the session variable
    unset($_SESSION['admin_viewed_notifications']);
}

// Retrieve the count of unread notifications
$countQuery = "SELECT COUNT(*) AS unread_count FROM notifications WHERE read_status = 0";
$countResult = mysqli_query($conn, $countQuery);
$countRow = mysqli_fetch_assoc($countResult);
$unreadCount = $countRow['unread_count'];

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Notification Page</title>
    <!-- CSS styling -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }
        
        .notification {
            background-color: #fff;
            border: 1px solid #dddfe2;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }
        
        .notification h2 {
            margin-top: 0;
            margin-bottom: 5px;
            font-size: 16px;
            font-weight: bold;
        }
        
        .notification p {
            margin: 0;
            font-size: 14px;
            color: #666;
        }
        
        .notification .timestamp {
            font-size: 12px;
            color: #999;
            margin-top: 5px;
        }
        
        .notification.unread {
            background-color: #e9eff4;
        }
        
  
        
        .custom-container {
            padding-left: 25%;
            margin-right: 10%;
            margin-top: 5%;
        }
    </style>
    <script>
    function logout() {
      // Display a confirmation message
      var confirmed = confirm('Are you sure you want to log out?');

      // If the user confirms, redirect to the logout page
      if (confirmed) {
        window.location.href = '../logout.php';
      }
      else {
        //
      }
    }



  </script>
<body>
    <?php 
    include "sidebar-admin.php";
    ?>
    <div class="custom-container">
        <h1>Notification Page</h1>
        
        <div id="notification-container">
            <?php
            include "../config/config.php";

            // Retrieve and display the notifications from the database, grouped by date
            $sql = 'SELECT DATE(created_at) AS date, COUNT(*) AS count FROM notifications GROUP BY DATE(created_at) ORDER BY created_at DESC';
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $date = $row['date'];
                    $count = $row['count'];

                    echo '<h2>' . $date . '</h2>';

                    // Retrieve and display the notifications for the current date
                    $notificationsQuery = 'SELECT * FROM notifications WHERE DATE(created_at) = "' . $date . '" ORDER BY created_at DESC';
                    $notificationsResult = $conn->query($notificationsQuery);

                    if ($notificationsResult->num_rows > 0) {
                        while ($notification = $notificationsResult->fetch_assoc()) {
                            $readStatusClass = $notification['read_status'] == 0 ? 'unread' : '';
                            echo '<div class="notification ' . $readStatusClass . '">';
                            echo '<div>';
                            echo '<h2>' . $notification['message'] . '</h2>';
                            echo '<p class="timestamp">' . $notification['created_at'] . '</p>';
                            echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        echo '<p>No notifications for this date.</p>';
                    }
                }
            } else {
                echo '<p>No new notifications.</p>';
            }

            // Close the database connection
            $conn->close();
            ?>
        </div>
    </div>

</body>
</html>
