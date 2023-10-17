<?php
include("../config/config.php");
include "checking_user.php";

// Handle password change form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['password_submit'])) {
  // Retrieve form data
  $currentPassword = $_POST['current_password'];
  $newPassword = $_POST['new_password'];
  $confirmPassword = $_POST['confirm_password'];
  $user_id = $_SESSION['id'];

  // Retrieve the user's current password from the database
  $selectUserSql = "SELECT password FROM `user` WHERE `user_id` = $user_id";
  $result = mysqli_query($conn, $selectUserSql);
  $user = mysqli_fetch_assoc($result);
  $currentPasswordDB = $user['password'];

  // Verify the current password
  if ($currentPasswordDB === $currentPassword) { // Compare the entered current password with the one stored in the database
    // Check if the new password and confirm password match
    if ($newPassword === $confirmPassword) {
      // Update the user's password in the database
      $updatePasswordSql = "UPDATE `user` SET password = '$newPassword' WHERE user_id = $user_id";
      mysqli_query($conn, $updatePasswordSql);
      $passwordMessage = "Password changed successfully.";
    } else {
      $passwordError = "New password and confirm password do not match.";
    }
  } else {
    $passwordError = "Current password is incorrect.";
  }
}

// Handle profile update form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['profile_submit'])) {
  // Update the user's profile information in the database
  $Name = $_POST['name'];
  $email = $_POST['email'];
  $address = $_POST['address'];
  $user_id = $_SESSION['id'];

  // Update the profile picture if it's uploaded
  if (isset($_FILES['profile']) && $_FILES['profile']['error'] === UPLOAD_ERR_OK) {
    $profilePictureName = $_FILES['profile']['name'];
    $profilePictureTmpName = $_FILES['profile']['tmp_name'];
    $profilePictureSize = $_FILES['profile']['size'];
    $profilePictureType = $_FILES['profile']['type'];

    // Check if the uploaded file is an image
    $allowedExtensions = ['jpg', 'jpeg', 'png'];
    $fileExtension = strtolower(pathinfo($profilePictureName, PATHINFO_EXTENSION));
    if (in_array($fileExtension, $allowedExtensions)) {
      // Move the uploaded file to a desired directory
      $uploadDirectory = "profile/";
      $profilePicturePath = $uploadDirectory . $profilePictureName;
      move_uploaded_file($profilePictureTmpName, $profilePicturePath);

      // Update the profile picture path in the database
      $updateProfilePictureSql = "UPDATE `user` SET profile = '$profilePicturePath' WHERE user_id = $user_id";
      mysqli_query($conn, $updateProfilePictureSql);
    } else {
      $profilePictureError = "Invalid file format. Only JPG, JPEG, and PNG files are allowed.";
    }
  }

  $updateProfileSql = "UPDATE `user` SET Name = '$Name', email = '$email', address = '$address' WHERE user_id = $user_id";
  mysqli_query($conn, $updateProfileSql);
  $profileMessage = "Profile updated successfully.";

  // Fetch the updated user's information from the database
  $selectUserSql = "SELECT * FROM `user` WHERE `user_id` = $user_id";
  $result = mysqli_query($conn, $selectUserSql);
  $user = mysqli_fetch_assoc($result);
}

// Fetch the user's information from the database based on their user_id
$user_id = $_SESSION['id'];
$selectUserSql = "SELECT * FROM `user` WHERE `user_id` = $user_id";
$result = mysqli_query($conn, $selectUserSql);
$user = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html>
<head>
  <title>Account Settings</title>
  <link rel="icon" href="../image/logo.ico" type="image/x-icon">
  <link rel="stylesheet" type="text/css" href="../template/side-bar.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <style>
    /* CSS styles for the settings page */
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      background-color: #f1f1f1;
    }

    h1 {
      font-size: 24px;
      margin-bottom: 20px;
    }

    form {
      background-color: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    label {
      display: block;
      margin-bottom: 10px;
      font-weight: bold;
    }

    input[type="password"],
    input[type="text"],
    input[type="email"] {
      width: 100%;
      padding: 10px;
      border-radius: 4px;
      border: 1px solid #ccc;
      margin-bottom: 20px;
    }

    input[type="file"] {
      margin-bottom: 20px;
    }

    input[type="submit"] {
      background-color: #4CAF50;
      color: #fff;
      padding: 10px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    .success-message {
      color: green;
      margin-bottom: 20px;
    }

    .error-message {
      color: red;
      margin-bottom: 20px;
    }
    .custom-icon{
      width: 150px;
      height: 150px;
      border-radius: 80px;
    }
  </style>
</head>
<?php include "sidebar-admin.php"; ?>

<body style="margin-top:5%;">

  <div class="content">
    <h1>Account Settings</h1>

   
    <?php
    // Display success message for profile update
    if (isset($profileMessage)) {
      echo '<div class="success-message">' . $profileMessage . '</div>';
    }
    ?>

    <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>" enctype="multipart/form-data">
      <h2>Update Profile</h2>
      <label for="profile">Profile Picture:</label>
<?php
// Display the profile picture
if (!empty($user['profile'])) {
  echo '<img class="custom-icon" src="../admin/' . $user['profile'] . '" alt="Profile Picture">';
} else {
  echo '<img class="custom-icon" src="profile/default.jpeg" alt="Default Profile Picture">';
}
?><br>
<input style="margin-left: 10%;" type="file" name="profile" id="profile">


      <?php
      // Display error message for profile picture upload
      if (isset($profilePictureError)) {
        echo '<div class="error-message">' . $profilePictureError . '</div>';
      }
      ?>
      <br>
      <label for="name">Name:</label>
      <input type="text" name="name" id="name" value="<?php echo isset($user) ? $user['name'] : ''; ?>" required><br>
      <label for="email">Email:</label>
      <input type="email" name="email" id="email" value="<?php echo isset($user) ? $user['email'] : ''; ?>" required><br>
      <label for="address">Address:</label>
      <input type="text" name="address" id="address" value="<?php echo isset($user) ? $user['address'] : ''; ?>" required><br>
     
      <input type="submit" name="profile_submit" value="Update Profile">
    </form>

    <?php
    // Display success or error messages for password change
    if (isset($passwordMessage)) {
      echo '<div class="success-message">' . $passwordMessage . '</div>';
    } elseif (isset($passwordError)) {
      echo '<div class="error-message">' . $passwordError . '</div>';
    }
    ?>
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
    <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
      <h2>Change Password</h2>
      <label for="current_password">Current Password:</label>
      <input type="password" name="current_password" id="current_password" required><br>
      <label for="new_password">New Password:</label>
      <input type="password" name="new_password"id="new_password" required><br>
      <label for="confirm_password">Confirm Password:</label>
      <input type="password" name="confirm_password" id="confirm_password" required><br>
      <input type="submit" name="password_submit" value="Change Password">
    </form>

  </div>
  
</body>
</html>
