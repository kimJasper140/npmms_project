<?php
// Database configuration
include '../config/config.php';

// Check if ID is provided
if (isset($_GET['id'])) {
  // Get the ID from the URL parameter
  $id = $_GET['id'];

  // Create a database connection
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Delete the about entry from the database
  $sql = "DELETE FROM about WHERE id=$id";

  if ($conn->query($sql) === TRUE) {
    // Redirect back to the about page after successful deletion
    header("Location: ../admin/about.php");
    exit();
  } else {
    echo "Error deleting record: " . $conn->error;
  }

  // Close the database connection
  $conn->close();
}
?>
