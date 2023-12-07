<?php
    session_start();
    include "config/config.php";
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;

    require __DIR__ . '/phpmailer/src/Exception.php';
    require __DIR__ . '/phpmailer/src/PHPMailer.php';
    require __DIR__ . '/phpmailer/src/SMTP.php';

    $generatedCode = $_SESSION['v_code'];
    $insertedCode = $_POST['inputCode'];
    if($insertedCode == $generatedCode){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $stallNo = $_SESSION['stall'];
            $name = $_SESSION['_name'];
            $age = $_SESSION['_age'];
            $address = $_SESSION['_address'];
            $applicantName = $_SESSION['appName'];
            $stallNo2 = $_SESSION['stall2'];
            $applicantAge = $_SESSION['appAge'];
            $applicantAddress = $_SESSION['appAdd'];
            $taxCertificateIssuedLocation = $_SESSION['tcil'];
            $taxCertificateIssuedDate = $_SESSION['tcid'];
            $email = $_SESSION['_email'];
            $Contact = $_SESSION['_contact'];
            $status = $_SESSION['Stats'];
            $my_sql = "SELECT * FROM applications WHERE name = '$name' OR email = '$email'";

            $stmt = $conn->prepare(
                "INSERT INTO applications (stall_no, name, age, address, applicant_name, stall_no2, applicant_age, applicant_address, tax_certificate_issued_location, tax_certificate_issued_date, sworn_at, email, contact, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?, ?, ?)"
            );

            $stmt->bind_param(
                "ssissssssssss",
                $stallNo,
                $name,
                $age,
                $address,
                $applicantName,
                $stallNo2,
                $applicantAge,
                $applicantAddress,
                $taxCertificateIssuedLocation,
                $taxCertificateIssuedDate,
                $email,
                $Contact,
                $status
            );
            // Execute the statement
            if ($stmt->execute() === TRUE) {
                // Display success messages
                echo '<script>alert("Pre-application Submitted Naujan Public Market Will Call You for further Requirements!");</script>';
                // Insert notification details
                $notificationMessage = "New Pre-application submitted by. " . $applicantName;
                $insertQuery = "INSERT INTO notifications (message, read_status) VALUES ('$notificationMessage', 0)";
                mysqli_query($conn, $insertQuery);
            }
            // Close statement
            $stmt->close();
        }
    } else {
        echo "<script>alert('Verification code did not match. Please try again.')</script>";
    }

    // Set your notification message
    $_SESSION['notification'] = '$notificationMessage';

    // Close database connection
    $conn->close();
    echo "<script>window.location.href='index.php';</script>";
?>
