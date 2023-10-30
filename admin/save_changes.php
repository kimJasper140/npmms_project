<?php
// Check if the form is submitted and the image file is uploaded
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['stallImage']) && is_uploaded_file($_FILES['stallImage']['tmp_name'])) {
    // Database connection (include "config/config.php" if needed)
    include "../config/config.php";

    // Get the stall number and section from the form data
    $stallNo = mysqli_real_escape_string($conn, $_POST['availableStallNo']);
    $section = mysqli_real_escape_string($conn, $_POST['stallSection']);
	$size = mysqli_real_escape_string($conn, $_POST['stallSize']);

    // Image upload and move it to a designated folder
    $targetDir = 'Stall_image/'; // Replace with your desired upload directory
    $targetFile = $targetDir . basename($_FILES['stallImage']['name']);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif');

    if (in_array($imageFileType, $allowedExtensions)) {
        if (move_uploaded_file($_FILES['stallImage']['tmp_name'], $targetFile)) {
            // Update the image path and other details in the database
            $updateQuery = "UPDATE available_stall SET image = '$targetFile', section = '$section', size = '$size' WHERE stall_no = '$stallNo'";
            if (mysqli_query($conn, $updateQuery)) {
                echo "<script>alert('Image added Success');</script>";
                echo "<script>window.location.href = 'setting-stall.php';</script>";// Send success response back to the client
            } else {
                echo 'error';
            }
        } else {
            echo 'error';
        }
    } else {
        echo 'invalid';
    }

    // Close database connection
    mysqli_close($conn);
} else {
    echo 'error';
}
?>
