<?php
include("../config/config.php");
include "checking_user.php";

$sqlimage = "SELECT * FROM `resources` WHERE `id` = 5";
$result = mysqli_query($conn, $sqlimage);
$recipientImage = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES['new_image']) && $_FILES['new_image']['error'] === UPLOAD_ERR_OK) {
        $imagePictureName = $_FILES['new_image']['name'];
        $imagePictureTmpName = $_FILES['new_image']['tmp_name'];
        $imagePictureSize = $_FILES['new_image']['size'];
        $imagePictureType = $_FILES['new_image']['type'];

        // Check if the uploaded file is an image
        $allowedExtensions = ['jpg', 'jpeg', 'png'];
        $fileExtension = strtolower(pathinfo($imagePictureName, PATHINFO_EXTENSION));
        if (in_array($fileExtension, $allowedExtensions)) {
            // Move the uploaded file to a desired directory
            $uploadDirectory = "recipient_payment/";

            // Create the directory if it doesn't exist
            if (!file_exists($uploadDirectory)) {
                mkdir($uploadDirectory, 0777, true);
            }

            // Set correct permissions
            chmod($uploadDirectory, 0777);

            $imagePicturePath =   $uploadDirectory.$imagePictureName;
            move_uploaded_file($imagePictureTmpName, $imagePicturePath);

            // Update the image picture path in the database
            $updateImagePictureSql = "UPDATE `resources` SET `content`='$imagePicturePath' WHERE `id` = 5";
            mysqli_query($conn, $updateImagePictureSql);

            echo "<script>window.location.href = '{$_SERVER['PHP_SELF']}';</script>";
        } else {
            $imagePictureError = "Invalid file format. Only JPG, JPEG, and PNG files are allowed.";
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Recipient</title>
    <link rel="icon" href="../image/logo.ico" type="image/x-icon">
    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body class="body" style="margin-bottom:5%;">
    <div class="container mt-4">
        <h4 class="text-center">Payment Recipient</h4>
        <div class="text-center">
            <!-- Use the dynamic image source -->
            <?php
            if (!empty($recipientImage['content'])) {
                echo '<img class="custom-icon" src="' . $recipientImage['content'] . '" alt="Profile Picture">';
            } else {
                echo '<img class="custom-icon" src="profile/default.jpeg" alt="Default Profile Picture">';
            }
            ?>
        </div>

        <!-- Add a form to allow changing the payment recipient image -->
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="new_image">Change Payment Recipient Image:</label>
                <input type="file" class="form-control-file" id="new_image" name="new_image">
            </div>

            <div class="text-center">
                <input type="submit" class="btn btn-primary" value="Change Image">
            </div>
        </form>
    </div>

    <!-- Add Bootstrap JS and jQuery if needed -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>
