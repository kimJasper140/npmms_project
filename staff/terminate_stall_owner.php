<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../phpmailer/src/Exception.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';

include "../config/config.php";
include "../config/session.php";

// Function to send email notification
function sendEmailNotification($stallOwnerId, $subject, $message)
{
    // Retrieve stall owner email
    global $conn;
    $sql = "SELECT email FROM stall_owner WHERE id = '$stallOwnerId'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $toEmail = $row['email'];

        // Send email notification
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'publicmarketnaujan@gmail.com'; 
        $mail->Password = 'lwtywoqkuzatemxx'; 
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom('publicmarketnaujan@gmail.com', 'Naujan Public Market');
        $mail->addAddress($toEmail);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;

        if (!$mail->send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        }
    }
}
$stallOwnerId = $_GET['id'];
$sql = "SELECT * FROM stall_owner WHERE id = '$stallOwnerId'";
$result = $conn->query($sql);

if ($result->num_rows === 0) {
    echo "Stall owner not found";
    exit;
}

$row = $result->fetch_assoc();
// Handle form submission for terminating stall owner status
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the admin's remarks for termination cause
    $remarks = $_POST['remarks'];

    // Update the stall owner status in the database
    $status = 'terminate';
    $sql = "UPDATE stall_owner SET status = '$status' WHERE id = '$stallOwnerId'";
    if ($conn->query($sql) === TRUE) {
        // Send email notification
        $subject = "Stall Owner Termination Notification";
        $message = "Dear Stall Owner, your stall ownership has been terminated.<br> Reason: $remarks";
        sendEmailNotification($stallOwnerId, $subject, $message);

        // Insert termination notification into stall_notifications table
        $sql = "INSERT INTO stall_notifications (stall_owner_id, subject, message) VALUES ('$stallOwnerId', '$subject', '$message')";
        $conn->query($sql);

        // Update the stall status to 'terminate'
        $sql = "UPDATE stall SET status = '$status' WHERE owner_id = '$stallOwnerId'";
        $conn->query($sql);

        // Delete stall owner contracts if the status is 'terminate'
        if ($status === 'terminate') {
            $sql = "DELETE FROM stall_owner_contract WHERE stall_owner_id = '$stallOwnerId'";
            $conn->query($sql);
        }

        // Update the user status to 'terminate'
        $userId = $row['user_id'];
        $sql = "UPDATE user SET status = '$status' WHERE user_id = '$userId'";
        $conn->query($sql);

        echo "<script>alert('Stall owner terminated successfully');</script>";
        echo "<script>window.location.href = 'stall_operate.php';</script>";
    }
} 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terminate Stall Owner | Admin</title>
    <style>
        /* Add your CSS styles for the page content here */
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            margin-top: 30px;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            border-radius: 4px;
            margin-top: 30px;
        }

        form label {
            display: block;
            margin-bottom: 5px;
        }

        form input[type="text"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        form button {
            padding: 10px 20px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
        }

        form button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <h1>Terminate Stall Owner</h1>
    <p>Are you sure you want to terminate the status of the following stall owner?</p>
    <p>Name: <?php echo $row['name']; ?></p>
    <p>Stall Number: <?php echo $row['stall_no']; ?></p>
    <form method="post">
        <label>Remarks (Cause of Termination)</label>
        <input type="text" name="remarks" required>
        <br>
        <button type="submit">Terminate</button>
    </form>
</body>

</html>
