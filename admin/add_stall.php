<?php
// add_stall.php

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    include "../config/config.php";

    // Function to sanitize and validate input data
    function clean_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // Get the submitted form data
    $stallNo = clean_input($_POST["newStallNo"]);
    $section = clean_input($_POST["newStallSection"]);
	$size = clean_input($_POST['newStallSize']);
    $checkQuery = "SELECT * FROM available_stall WHERE stall_no = '$stallNo'";
    $checkResult = mysqli_query($conn, $checkQuery);

   
    if (mysqli_num_rows($checkResult) > 0) {
        // Stall already exists, show an alert using PHP
        echo '<script>';
        echo 'alert("Stall with Stall Number: ' . $stallNo . ' in Section: ' . $section . ' already exists.");';
        echo 'window.location.href = "setting-stall.php";'; // Redirect after the user clicks "OK" on the alert
        echo '</script>';
    
        exit();
    }
    // Handle the uploaded image
	$targetDir = 'Stall_image/'; // Replace with your desired upload directory
    $targetFile = $targetDir . basename($_FILES['newStallImage']['name']);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif');

    if (in_array($imageFileType, $allowedExtensions)) {
        if (move_uploaded_file($_FILES['newStallImage']['tmp_name'], $targetFile)) {
            $insertQuery = "INSERT INTO available_stall (stall_no, section, image, status, size) VALUES ('$stallNo', '$section', '$targetFile', 'available', '$size')";
            if (mysqli_query($conn, $insertQuery)) {
                echo "<script>alert('New stall added successfully.')</script>";
				echo "<script>window.location.href = 'setting-stall.php'</script>";
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
    // Redirect to the main page if the form is not submitted
    echo "<script>alert('Not Submitted');</script>";
    header("Location: setting-stall.php");
    exit();
}
?>
