<?php
// add_stall.php

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    include "config/config.php";

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
    $targetDir = "images/";
    $targetFile = $targetDir . basename($_FILES["newStallImage"]["name"]);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    $uploadOk = 1;

    // Check if the image file is a actual image or fake image
    $check = getimagesize($_FILES["newStallImage"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

 
    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        // Try to move the uploaded file to the target directory
        if (move_uploaded_file($_FILES["newStallImage"]["tmp_name"], $targetFile)) {
            // File was uploaded successfully, now insert the stall data into the database
            $insertQuery = "INSERT INTO available_stall (stall_no, section, image, status) VALUES ('$stallNo', '$section', '$targetFile', 'available')";
            if (mysqli_query($conn, $insertQuery)) {
                echo "New stall added successfully.";
            } else {
                echo "Error: " . $insertQuery . "<br>" . mysqli_error($conn);
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
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
