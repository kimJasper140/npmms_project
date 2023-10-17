<?php
// Database configuration
include '../config/config.php';

// Check if form data is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Retrieve the submitted form data
  $title = $_POST['title'];
  $description = $_POST['description'];

  // Insert the new about information into the database
  $sql = "INSERT INTO about (title, description) VALUES ('$title', '$description')";

  if ($conn->query($sql) === TRUE) {
    // Redirect back to the about page
    header("Location: ../admin/about.php");
    exit();
  } else {
    echo "Error adding record: ";
  }

  // Close the database connection
  $conn->close();
}
?>
