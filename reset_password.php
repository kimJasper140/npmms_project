<?php

session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';


// Function to check if the code has expired
function isCodeExpired($resetTime) {
    $currentTime = time();
    $expireTime = strtotime('+5 minutes', $resetTime);
    return ($currentTime > $expireTime);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the email is provided
    if (isset($_POST['email'])) {
        $email = $_POST['email'];

        // Generate a unique token for password reset
        $token = generateUniqueToken();

        // Store the token, associated email, and reset time in the session
        $_SESSION['reset_token'] = $token;
        $_SESSION['reset_email'] = $email;
        $_SESSION['reset_time'] = time(); // Store the reset time

        // Generate a random code
        $code = generateRandomCode(6);

        // Store the code in the session
        $_SESSION['reset_code'] = $code;

        // Send the code to the user's email
        $mail = new PHPMailer(true);

        try {
            // Configure the PHPMailer instance with your email settings

            // Enable verbose debugging
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;

            // Set mailer to use SMTP
            $mail->isSMTP();

            // SMTP settings
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'publicmarketnaujan@gmail.com'; // Replace with your Gmail or Google Workspace email
            $mail->Password = 'lwtywoqkuzatemxx'; // Replace with your Gmail or Google Workspace password
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;

            // Sender and recipient
            $mail->setFrom('publicmarketnaujan@gmail.com', 'Naujan Public Market');
            $mail->addAddress($email); // Recipient email

            // Email content
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject = 'Password Reset Code';
            $mail->Body = 'Your password reset code is: ' . $code;

            $mail->send();

            // Redirect to the password reset page
            echo '<script>alert("6 Digit Verification Code Sent in your Email");</script>';
            echo '<script>window.location.href = "change_password.php";</script>';
            exit();
        } catch (Exception $e) {
            echo 'Unable to send the code. Please try again. Error: ' . $mail->ErrorInfo;
        }
    } else {
        // Display an error message if the email is not provided
        echo 'Email is required.';
    }
}

function generateUniqueToken() {
    // Generate a unique token for password reset
    $length = 32;
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $token = '';

    for ($i = 0; $i < $length; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $token .= $characters[$index];
    }

    return $token;
}

function generateRandomCode($length) {
    // Generate a random code
    $characters = '0123456789';
    $code = '';

    for ($i = 0; $i < $length; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $code .= $characters[$index];
    }

    return $code;
}

// Check if the token is provided in the URL
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['token'])) {
    $token = $_GET['token'];

    // Check if the token matches the one stored in the session
    if ($token === $_SESSION['reset_token']) {
        // Check if the code has expired
        if (!isset($_SESSION['reset_time']) || isCodeExpired($_SESSION['reset_time'])) {
            echo 'The code has expired.';
            exit();
        }

        // Token is valid and code has not expired, proceed to the password reset page
        header('Location: change_password.php');
        exit();
    } else {
        // Invalid token
        echo 'Invalid token.';
    }
}

?>
