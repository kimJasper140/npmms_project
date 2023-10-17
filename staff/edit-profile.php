<!DOCTYPE html>
<html>

<head>
    <title>Edit Profile</title>
    <!-- Include your CSS and other head elements -->
    <style>
        /* Your custom styles for the edit profile page */
    </style>
</head>

<body>
    <?php
    // Start the session
    include "../config/config.php";
    include "checking_user.php";

    // Retrieve the user's current profile data from the database
    $userId = $_SESSION['id'];
    $query = "SELECT * FROM `user` WHERE `user_id` = $userId";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    // Close the database connection
    mysqli_close($conn);
    ?>

    <h1>Edit Profile</h1>

    <form method="POST" enctype="multipart/form-data">
        <label for="profile">Profile Picture:</label>
        <input type="file" name="profile" id="profile">

        <label for="firstName">First Name:</label>
        <input type="text" name="firstName" id="firstName" value="<?php echo $row['firstName']; ?>">

        <label for="lastName">Last Name:</label>
        <input type="text" name="lastName" id="lastName" value="<?php echo $row['lastName']; ?>">

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?php echo $row['email']; ?>">

        <label for="address">Address:</label>
        <input type="text" name="address" id="address" value="<?php echo $row['address']; ?>">

        <input type="submit" value="Save">
    </form>
</body>

</html>
