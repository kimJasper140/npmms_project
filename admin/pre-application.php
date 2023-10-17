<?php


session_start();
include "../config/config.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../phpmailer/src/Exception.php';
require __DIR__ . '/../phpmailer/src/PHPMailer.php';
require __DIR__ . '/../phpmailer/src/SMTP.php';

if (!isset($_SESSION['username']) && $_SESSION['roles'] != 'admin') {
    header("location:../index.php");
    session_destroy();
}

if (isset($_POST['approveConfirm'])) {
    $appId = $_POST['appId'];
    $status = 'approved';
    $remarks = $_POST['approveModalRemarks'];

    $updateQuery = "UPDATE applications SET status = '$status', remarks = '$remarks' WHERE id = '$appId'";
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
    $mail->Body = 'Dear ' . $applicantName .  ',<br><br>'
    . 'We are writing to inform you that your Pre-application has been approved for Naujan Public Market. We appreciate your interest in becoming a part of our market community.<br><br>'
    . 'Remarks:<br>'
    . nl2br($remarks) . '<br><br>'
    . 'If you have any further questions or require assistance, please do not hesitate to reach out to us. We look forward to your active participation in Naujan Public Market.<br><br>'
    . 'Thank you for choosing to be a part of our market. We look forward to a mutually beneficial partnership.<br><br>'
    . 'Best regards,<br>'
    . 'The Naujan Public Market Team';


    if (!$mail->send()) {
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo '<script>alert("Email sent!");</script>';
    }
}

if (isset($_POST['declineConfirm'])) {
    $appId = $_POST['appId'];
    $status = 'declined';
    $remarks = $_POST['declineModalRemarks'];

    $updateQuery = "UPDATE applications SET status = '$status', remarks = '$remarks' WHERE id = '$appId'";
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
    $mail->Subject = 'Pre-Application Declined';
    $mail->Body = 'Dear ' . $applicantName .  ',<br>Sorry, but your Pre-application was declined.<br>Remarks: ' . nl2br($remarks);

    if (!$mail->send()) {
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo '<script>alert("Email sent!");</script>';
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
$applicationsResult = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pending Applications</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
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

        /* Modal Styles */
        .modal-dialog {
            max-width: 500px;
        }

        .modal-content {
            border-radius: 0;
        }

        .modal-header {
            background-color: #5cb85c;
            color: #fff;
        }

        .modal-title {
            font-weight: bold;
        }

        .modal-body {
            padding: 20px;
        }

        .modal-footer {
            text-align: center;
        }

        .modal-footer button {
            margin-right: 10px;
        }
    </style>
</head>
<?php 
include "sidebar-admin.php";
?>
<body>
    <div class="custom-css">
        <h1>Pending Pre-applications</h1>

        <form action="" method="POST">
            <input type="text" name="search" placeholder="Search by name" value="<?php echo $search; ?>">
            <button type="submit">Search</button>
        </form>

        <?php if (mysqli_num_rows($applicationsResult) > 0) { ?>
            <table>
                <tr>
                    <th>Name</th>
                    <th>Stall No</th>
                    <th>Age</th>
                    <th>Address</th>
                    <th>Email</th>
                    <th>Contact</th>
                    <th>Status</th>
                    <th style="width: 200px;text-align: center;">Action</th>
                </tr>

                <?php while ($row = mysqli_fetch_assoc($applicationsResult)) { ?>
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
                                <button type="button" onclick="showModal('approveModal', <?php echo $row['id']; ?>)">Approve</button>
                                <button type="button" onclick="showModal('declineModal', <?php echo $row['id']; ?>)">Decline</button>
                                <button type="submit" formaction="application-form.php?id=<?php echo $row['id']; ?>" formtarget="_blank">View</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        <?php } else { ?>
            <p style="text-align: center; color: red; margin-top: 20%;">No records found.</p>
        <?php } ?>

        <div class="pagination">
            <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                <a href="?page=<?php echo $i; ?>" <?php if ($page == $i) echo 'class="active"'; ?>><?php echo $i; ?></a>
            <?php } ?>
        </div>
    </div>

    <!-- Approve Modal -->
    <div id="approveModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Approve Application</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST">
                        <input type="hidden" id="approveModalAppId" name="appId">
                        <div class="form-group">
                            <label for="approveModalRemarks">Remarks:</label>
                            <textarea id="approveModalRemarks" name="approveModalRemarks" rows="5" class="form-control"></textarea>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success" name="approveConfirm">Confirm</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Decline Modal -->
    <div id="declineModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Decline Application</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST">
                        <input type="hidden" id="declineModalAppId" name="appId">
                        <div class="form-group">
                            <label for="declineModalRemarks">Remarks:</label>
                            <textarea id="declineModalRemarks" name="declineModalRemarks" rows="5" class="form-control"></textarea>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger" name="declineConfirm">Confirm</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>
    <script>
        // Function to show modal
        function showModal(modalId, appId) {
            var modal = document.getElementById(modalId);
            var appIdInput = document.getElementById(modalId + "AppId");
            $(modal).modal('show');
            appIdInput.value = appId;
        }

        // Function to close modal
        function closeModal(modalId) {
            var modal = document.getElementById(modalId);
            $(modal).modal('hide');
        }
    </script>
</body>
</html>
