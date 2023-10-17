<?php
include("../config/config.php");
include "check_user.php";

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
  $name = $_POST['name'];
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

  $updateProfileSql = "UPDATE `user` SET name = '$name', email = '$email', address = '$address' WHERE user_id = $user_id";
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Bootstrap CSS link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
       body{
    color: #8e9194;
    background-color: #f4f6f9;
}
.avatar-xl img {
    width: 110px;
}
.rounded-circle {
    border-radius: 50% !important;
}
img {
    vertical-align: middle;
    border-style: none;
}
.text-muted {
    color: #aeb0b4 !important;
}
.text-muted {
    font-weight: 300;
}
.form-control {
    display: block;
    width: 100%;
    height: calc(1.5em + 0.75rem + 2px);
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
    font-weight: 400;
    line-height: 1.5;
    color: #4d5154;
    background-color: #ffffff;
    background-clip: padding-box;
    border: 1px solid #eef0f3;
    border-radius: 0.25rem;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}
    </style>
</head>

<body>
    <?php
    include "barpage/topbar.php";
    include "barpage/sidebar.php";

  
    ?>
    <header>
        
    </header>
    <div class="content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-10 col-xl-8 mx-auto">
                    <h2 class="h3 mb-4 page-title">Settings</h2>
                    <div class="my-4">
                        <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="false">Profile</a>
                            </li>
                        </ul>
                        <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>" enctype="multipart/form-data">
                            <div class="row mt-5 align-items-center">
                                <div class="col-md-3 text-center mb-5">
                                    <div class="avatar avatar-xl">
                                        <img src="<?php echo (!empty($user['profile'])) ? $user['profile'] : '../stall/profile/default.jpeg'; ?>" alt="Profile Picture" class="avatar-img rounded-circle" />
                                    </div>
                                    <label for="profile">Profile Picture:</label>
                                    <input style="margin-left: 10%;" type="file" name="profile" id="profile">
                                    <?php if (isset($profilePictureError)) { ?>
                                        <div class="error-message"><?php echo $profilePictureError; ?></div>
                                    <?php } ?>
                                </div>
                                <div class="col">
                                    <div class="row align-items-center">
                                        <div class="col-md-7">
                                            <h4 class="mb-1"><?php echo isset($user['name']) ? $user['name'] : ''; ?></h4>
                                            <p class="small mb-3"><span class="badge badge-dark"><?php echo isset($user['address']) ? $user['address'] : ''; ?></span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="my-4" />
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="name">Name:</label>
                                    <input type="text" name="name" id="name" class="form-control" value="<?php echo isset($user['name']) ? $user['name'] : ''; ?>" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="email">Email:</label>
                                    <input type="email" name="email" id="email" class="form-control" value="<?php echo isset($user['email']) ? $user['email'] : ''; ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="address">Address:</label>
                                <input type="text" name="address" id="address" class="form-control" value="<?php echo isset($user['address']) ? $user['address'] : ''; ?>" required>
                            </div>
                            <input type="submit" name="profile_submit" value="Update Profile" class="btn btn-primary">
                        </form>
                    </div>
                    <div class="my-4">
                        <h2 class="h3 mb-4 page-title">Change Password</h2>
                        <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                            <div class="form-group">
                                <label for="current_password">Current Password:</label>
                                <input type="password" name="current_password" id="current_password" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="new_password">New Password:</label>
                                <input type="password" name="new_password" id="new_password" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="confirm_password">Confirm Password:</label>
                                <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
                                <div class="col-md-6">
                        <p class="mb-2">Password requirements</p>
                        <p class="small text-muted mb-2">To create a new password, you have to meet all of the following requirements:</p>
                        <ul class="small text-muted pl-4 mb-0">
                            <li>Minimum 8 character</li>
                            <li>At least one special character</li>
                            <li>At least one number</li>
                            <li>Can’t be the same as a previous password</li>
                        </ul>
                    </div>
                            </div>
                            
                            <input type="submit" name="password_submit" value="Change Password" class="btn btn-primary">
                            <?php
                            if (isset($passwordMessage)) {
                                echo '<div class="success-message">' . $passwordMessage . '</div>';
                            } elseif (isset($passwordError)) {
                                echo '<div class="error-message">' . $passwordError . '</div>';
                            }
                            ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
