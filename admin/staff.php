<?php
include "checking_user.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>staff User List</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
    .user-profile-image {
            max-width: 100px;
            max-height: 100px;
            border-radius: 50px;
        }

        .no-image {
            color: #888;
            font-style: italic;
        }
    </style>
</head>
<body>
    <?php
include "topbar.php";
    ?>
    <div class="container mt-5" >
        <h1 class="text-center" style="margin-top:7%;">Staff User List</h1>
        <table class="table table-bordered mt-3">
            <thead class="thead-light">
                <tr>
            <th>User ID</th>
            <th>Profile</th>
            <th>Name</th>
            <th>Email</th>
            <th>Address</th>
            <th>Username</th>
            
            <th>Roles</th>
            <th>Designation</th>
            <th>Status</th>
           
        </tr>
        <?php
         Include "../config/config.php";// to connect to the database

        // Fetch staff user data from the database with 'roles' set to 'staff'
        $sql = "SELECT * FROM user WHERE roles = 'staff'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['user_id'] . "</td>";
                if ($row['profile']) {
                    echo "<td><img src='" . $row['profile'] . "' alt='Profile Image' style='max-width: 100px; max-height: 100px;'></td>";
                } else {
                    echo "<td class='text-center'>No Image</td>";
                }
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['address'] . "</td>";
                echo "<td>" . $row['username'] . "</td>";
              
                echo "<td>" . $row['roles'] . "</td>";
                echo "<td>" . $row['designation'] . "</td>";
                echo "<td>" . $row['status'] . "</td>";
               
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='11'>No staff users found.</td></tr>";
        }

        // Close the database connection
        mysqli_close($conn);
        ?>
    </table>
    
    <!-- Add Bootstrap JS and jQuery (required for Bootstrap) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.9/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
