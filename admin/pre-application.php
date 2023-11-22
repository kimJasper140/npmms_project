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
        echo "<script>";
        echo "if ('Notification' in window) {";
        echo "  Notification.requestPermission().then(function(permission) {";
        echo "    if (permission === 'granted') {";
        echo "      var notification = new Notification('Pre-Application Approved', {";
        echo "        body: 'The pre-application of $applicantName had been approved.'";
        echo "      });";
        echo "      notification.onclick = function(event) {";
        echo "        event.preventDefault();";
        echo "        window.location.href = 'https://naujan-public-market-ms.epizy.com/';"; // Replace with the URL you want to redirect to
        echo "      };";
        echo "    }";
        echo "  });";
        echo "}";
        echo "</script>";
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
        echo "<script>";
        echo "if ('Notification' in window) {";
        echo "  Notification.requestPermission().then(function(permission) {";
        echo "    if (permission === 'granted') {";
        echo "      var notification = new Notification('Pre-Application Declined', {";
        echo "        body: 'The pre-application of $applicantName had been declined.'";
        echo "      });";
        echo "      notification.onclick = function(event) {";
        echo "        event.preventDefault();";
        echo "        window.location.href = 'https://naujan-public-market-ms.epizy.com/';"; // Replace with the URL you want to redirect to
        echo "      };";
        echo "    }";
        echo "  });";
        echo "}";
        echo "</script>";
    }
}


// Retrieve records for the current page
$query = "SELECT * FROM applications WHERE status = 'pending'";
$applicationsResult = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Other-->
    

    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.3/datatables.min.css" rel="stylesheet" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.3/datatables.min.js"></script>
    
    <title>Pre-Application</title>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg bg-light rounded my-2 py-2">
                <h2 class="text-center text-success pt-2"><b>Pre-Application</b></h2>
                <hr>
                
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                    <tr>
                    <th>Name</th>
                    <th>Stall No</th>
                    <th>Age</th>
                    <th>Address</th>
                    <th>Email</th>
                    <th>Contact</th>
                    <th>Status</th>
                    <th style="width: 220px;text-align: center;">Action</th>
                </tr>
                    </thead>

                    <tbody>
                     <?php if (mysqli_num_rows($applicationsResult) > 0) { ?>
                        
                        
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
                                <button type="button" class="btn btn-success" onclick="showModal('approveModal', <?php echo $row['id']; ?>)">Approve</button>
                                <button type="button" class="btn btn-danger" onclick="showModal('declineModal', <?php echo $row['id']; ?>)">Decline</button>
                                <button type="submit" class="btn btn-primary" formaction="application-form.php?id=<?php echo $row['id']; ?>" formtarget="_blank">View</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        <?php
     }?>
                    </tbody>
                    <div id="approveModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Approve Application</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
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
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger" name="declineConfirm">Confirm</button>
                </div>
                </form>
            </div>
        </div>
    </div>
                </table>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $('table').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf'
                ],
                searching: true,
                ordering: false,
                paging: true,
                length:true,

            })

        })
    </script>
    

  
    <script>
        // Function to show modal
        function showModal(modalId, appId) {
            var modal = document.getElementById(modalId);
            var appIdInput = document.getElementById(modalId + "AppId");
            $(modal).modal('show');
            appIdInput.value = appId;
        }
    </script>

    <script src="notification.js">
</body>

</html>

