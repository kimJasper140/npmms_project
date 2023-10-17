<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

include "config/config.php";
include "config/session.php";

    

if (isset($_POST['approve'])) {
    $appId = $_POST['appId'];
    $status = 'approved';

    $updateQuery = "UPDATE applications SET status = '$status' WHERE id = '$appId'";
    mysqli_query($conn, $updateQuery);

    // Retrieve applicant email for sending
    $emailQuery = "SELECT email, applicant_name FROM applications WHERE id = '$appId'";
    $emailResult = mysqli_query($conn, $emailQuery);
    $row = mysqli_fetch_assoc($emailResult);
    $applicantEmail = $row['email'];
    $applicantName = $row['applicant_name'];

    // Email sending
    $mail = new PHPMailer();

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'publicmarketnaujan@gmail.com'; // Replace with your Gmail or Google Workspace email
    $mail->Password = 'lwtywoqkuzatemxx'; // Replace with your Gmail or Google Workspace password
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    $mail->setFrom('publicmarketnaujan@gmail.com', 'Naujan Public Market');
    $mail->addAddress($applicantEmail, $applicantName);
    $mail->isHTML(true);
    $mail->Subject = 'Pre-Application Approved';
    $mail->Body = 'Dear ' . $applicantName . ', Please be inform That you Pre-application Approved, Please Visit us for Further instruction and Documents will be needed. ' . $status;

    if (!$mail->send()) {
        echo 'Mailer Error: ' . $mail->ErrorInfo;
      

    } else {
        echo '<script>alert("Email sent!");</script>';
    }
}

if (isset($_POST['decline'])) {
    $appId = $_POST['appId'];
    $status = 'declined';

    $updateQuery = "UPDATE applications SET status = '$status' WHERE id = '$appId'";
    mysqli_query($conn, $updateQuery);

    // Retrieve applicant email for sending
    $emailQuery = "SELECT email, applicant_name FROM applications WHERE id = '$appId'";
    $emailResult = mysqli_query($conn, $emailQuery);
    $row = mysqli_fetch_assoc($emailResult);
    $applicantEmail = $row['email'];
    $applicantName = $row['applicant_name'];

    // Email sending
    $mail = new PHPMailer();

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'publicmarketnaujan@gmail.com'; // Replace with your Gmail or Google Workspace email
    $mail->Password = 'Naujan@12'; // Replace with your Gmail or Google Workspace password
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('publicmarketnaujan@gmail.com', 'Your Name');
    $mail->addAddress($applicantEmail, $applicantName);

    $mail->Subject = 'Pre-Application Declined';
    $mail->Body = 'Dear ' . $applicantName . ', You Pre-application Declined Please contact us for further details - ' . $status;

    if (!$mail->send()) {
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo 'Email sent!';
    }
}

// Pagination variables
$limit = 10; // Number of records per page
$page = isset($_GET['page']) ? $_GET['page'] : 1; // Current page number
$start = ($page - 1) * $limit; // Starting index for records

$search = isset($_POST['search']) ? $_POST['search'] : '';

// Count total records
$countQuery = "SELECT COUNT(*) AS total FROM applications WHERE status = 'pending' AND applicant_name LIKE '%$search%'";
$countResult = mysqli_query($conn, $countQuery);
$countRow = mysqli_fetch_assoc($countResult);
$totalRecords = $countRow['total'];

// Calculate total pages
$totalPages = ceil($totalRecords / $limit);

// Retrieve records for the current page
$query = "SELECT * FROM applications WHERE status = 'pending' AND applicant_name LIKE '%$search%' LIMIT $start, $limit";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pending Applications</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1 {
            text-align: center;
        }

        table {
            width: 95%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ccc;
        }

        th {
            background-color: #f2f2f2;
        }

        input[type="text"] {
            padding: 6px 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            padding: 6px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button[name="approve"] {
            background-color: #5cb85c;
            color: #fff;
        }

        button[name="decline"] {
            background-color: #d9534f;
            color: #fff;
        }

        form {
            display: inline-block;
            margin-bottom: 0;
        }

        .custom-css {
            margin-left: 320px;
            margin-top: 50px;
        }

        .pagination {
            margin-top: 20px;
            text-align: center;
        }

        .pagination a {
            display: inline-block;
            padding: 8px 16px;
            text-decoration: none;
            border: 1px solid #ccc;
            margin: 0 4px;
            border-radius: 4px;
        }

        .pagination a.active {
            background-color: #4CAF50;
            color: white;
            border: 1px solid #4CAF50;
        }
    </style>
</head>
<body>
   <?php 
 // include "sidebar-admin.php";
   ?>
    
    <div class="custom-css">
        <h1>Pending Pre-applications</h1>
    
        <form action="" method="POST">
            <input type="text" name="search" placeholder="Search by name" value="<?php echo $search; ?>">
            <button type="submit">Search</button>
        </form>
        
        <?php if (mysqli_num_rows($result) > 0) { ?>
        <table>
            <tr>
                <th>Name</th>
                <th>Stall No</th>
                <th>Age</th>
                <th>Address</th>
                <th>Email</th>
                <th>Contact</th>
                <th>Status</th>
                <th>Action</th>
            </tr>

            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['applicant_name']; ?></td>
                    <td><?php echo $row['stall_no2']; ?></td>
                    <td><?php echo $row['applicant_age']; ?></td>
                    <td><?php echo $row['applicant_address']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['contact']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                    <td>
                        <form action="" method="POST">
                            <input type="hidden" name="appId" value="<?php echo $row['id']; ?>">
                            <button type="submit" name="approve">Approve</button>
                            <button type="submit" name="decline">Decline</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>
        <?php } else { ?>
        <p style="text-align:center;color:red;margin-top:20%;">No records found.</p>
        <?php } ?>

        <div class="pagination">
            <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                <a href="?page=<?php echo $i; ?>" <?php if ($page == $i) echo 'class="active"'; ?>><?php echo $i; ?></a>
            <?php } ?>
        </div>
    </div>
</body>
</html>
