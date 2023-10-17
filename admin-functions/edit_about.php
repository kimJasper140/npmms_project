<?php
// Database configuration
include '../config/config.php';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Get the about information from the form
  $id = $_POST['edit-id'];
  $title = $_POST['edit-title'];
  $description = $_POST['edit-description'];

  // Create a database connection
 include '../config/config.php';

  // Update the about information in the database
  $sql = "UPDATE about SET title='$title', description='$description' WHERE id=$id";

  if ($conn->query($sql) === TRUE) {
    // Redirect back to the about page after successful update
    header("Location: ../admin/about.php");
    exit();
  } else {
    echo "Error updating record: " . $conn->error;
  }

  // Close the database connection
  $conn->close();
}
?>
