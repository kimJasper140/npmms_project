<?php
include "../config/config.php";
include "barpage/sidebar.php";

// Retrieve the stall owner's information
$userId = $_SESSION['id'];
$queryOwner = "SELECT name, email FROM stall_owner WHERE user_id = '$userId'";
$resultOwner = mysqli_query($conn, $queryOwner);
$rowOwner = mysqli_fetch_assoc($resultOwner);
$ownerName = $rowOwner['name'];
$ownerEmail = $rowOwner['email'];

// Insert feedback into the database
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    $createdAt = date('Y-m-d H:i:s');

    $insertQuery = "INSERT INTO feedback (name, email, message, created_at) VALUES ('$name', '$email', '$message', '$createdAt')";
    mysqli_query($conn, $insertQuery);

    echo '<script>alert("Feedback submitted successfully!");</script>';
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Stall Feedback</title>
    <style>
        /* body {
            font-family: Arial, sans-serif;
            margin-bottom: 0;
            
            
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            padding-top:5%;
        } */

        .form-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 4px;
            padding: 20px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            
        }

        .form-container form label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }

        .form-container form input[type="text"],
        .form-container form textarea {
            width: 90%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            resize: vertical;
        }

        .form-container form button {
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            background-color: #4CAF50;
            color: #fff;
            font-weight: bold;
        }

        @media (max-width: 600px) {
            .form-container {
                padding: 10px;
                margin-top:8% ;
            }
          
        }
    </style>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
  
   

    <div class="form-container">
    <h1>Feedback Form</h1>
        <form action="" method="POST">
            <!-- Prefilling Name and Email fields -->
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required value="<?php echo $ownerName; ?>" readonly>

            <label for="email">Email:</label>
            <input type="text" id="email" name="email" required value="<?php echo $ownerEmail; ?>" readonly>

            <label for="message">Message:</label>
            <textarea id="message" name="message" rows="4" required></textarea>

            <button type="submit" name="submit">Submit Feedback</button>
        </form>
    </div>

    <!-- Button to view past feedback -->
    <div style="text-align: center; margin-top: 20px;">
        <a href="view_feedback.php" style="padding: 10px 20px; background-color: #007BFF; color: #fff; text-decoration: none; border-radius: 4px; font-weight: bold;">View Past Feedback</a>
    </div>
</body>
<script src="barpage/js/jquery.min.js"></script>
    <script src="barpage/js/popper.js"></script>
    <script src="barpage/js/bootstrap.min.js"></script>
    <script src="barpage/js/main.js"></script>
</html>
