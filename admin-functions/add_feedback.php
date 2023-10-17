<?php
include "../config/config.php";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Retrieve form data
  $name = $_POST['name'];
  $email = $_POST['email'];
  $message = $_POST['message'];
  // Validate details
  $pattern = '/^[A-Za-z\'\- ]+$/';

  if(preg_match($pattern, $name)){
      // Insert the feedback into the database
      $sql = "INSERT INTO feedback (name, email, message) VALUES ('$name', '$email', '$message')";

      if ($conn->query($sql) === TRUE) {
        // Feedback added successfully
        header("Location: ../index.php?success");
        $notificationMessage = "New Feedback from ". $name ."<br> Message : ". $message;
        $insertQuery = "INSERT INTO notifications (message, read_status) VALUES ('$notificationMessage', 0)";
        mysqli_query($conn, $insertQuery);
        exit();
      }else {
        header("Location: ../index.php?error");
        exit();
      }
  }else {
        header("Location: ../index.php?error");
        exit();
      }
}

// Close the database connection
$conn->close();
?>
