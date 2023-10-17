<?php

include "../config/config.php";

// Set the destination directory
$targetDirectory = '../images/';

// Get the uploaded file details
$fileName = $_FILES['image']['name'];
$fileTmpName = $_FILES['image']['tmp_name'];
$fileSize = $_FILES['image']['size'];
$fileError = $_FILES['image']['error'];

// Generate a unique file name to avoid conflicts
$uniqueFileName = uniqid() . '_' . $fileName;

// Check if the file was uploaded successfully
if ($fileError === UPLOAD_ERR_OK) {
    // Move the uploaded file to the destination directory
    if (move_uploaded_file($fileTmpName, $targetDirectory . $uniqueFileName)) {
        // File was moved successfully, now insert the file path into the database

        // Establish a database connection
        include "../config/config.php";

        // Prepare the SQL statement
        $sql = "INSERT INTO announcements (title, content, post_date, image) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        // Bind the parameters and execute the statement
        $currentTimestamp = time();
        $title = $_POST['title'];
        $content = $_POST['content'];
        $postDate =date('Y-m-d H:i:s', $currentTimestamp);;
        $imagePath = $targetDirectory . $uniqueFileName;
        $stmt->bind_param("ssss", $title, $content, $postDate, $imagePath);
        $stmt->execute();

       
        // Close the statement and database connection
        $stmt->close();
        $conn->close();

        header("Location: ../admin/annoucement.php");

    } else {
        echo "Failed to move the uploaded file.";
    }
} else {
    header("Location: ../admin-pages/annoucement.php");

}
?>