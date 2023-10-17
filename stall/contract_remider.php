<?php
// Step 1: Include necessary files and configurations
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../phpmailer/src/Exception.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';
require '../config/config.php';

// Step 2: Define a function to send reminder emails
function sendReminderEmail($email, $contractEnd) {
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'publicmarketnaujan@gmail.com'; // Replace with your Gmail or Google Workspace email
    $mail->Password = 'lwtywoqkuzatemxx'; // Replace with your Gmail or Google Workspace password
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    $mail->setFrom('publicmarketnaujan@gmail.com', 'Naujan Public Market');
    $mail->addAddress($email); // The recipient's email address
    $mail->isHTML(true);
    $mail->Subject = 'Contract Expiration Reminder';
    $mail->Body = 'Hello,<br><br>Your contract is about to expire on ' . $contractEnd . '. Please renew your contract as soon as possible.<br><br>
    Thank you!<br>
    <i><b>Note:</b> Please Contact Naujan Public Market For further assistance.</i>';
 

    if (!$mail->send()) {
      
        return false;
        
    }
   
    return true; // Email sent successfully
    
}

// Step 3: Fetch contracts about to end
$today = date("Y-m-d");
$endPeriod = date("Y-m-d", strtotime("+7 days")); // Adjust this value as needed

$sql = "SELECT id, stall_owner_id, contract_end_date FROM stall_owner_contract WHERE contract_end_date BETWEEN '$today' AND '$endPeriod'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $contractId = $row['id'];
        $stallOwnerId = $row['stall_owner_id'];
        $contractEnd = $row['contract_end_date'];

        // Step 4: Retrieve the stall owner's email address from the "stall_owner" table using the stall owner ID
        $emailSql = "SELECT email FROM stall_owner WHERE id = '$stallOwnerId'";
        $emailResult = $conn->query($emailSql);
        $emailRow = $emailResult->fetch_assoc();
        $email = $emailRow['email'];

        // Step 5: Send reminder email
        $sent = sendReminderEmail($email, $contractEnd);

        // Step 6: Log the reminder status in the "reminder_log" table if needed
        if ($sent) {
            // Email sent successfully, do something if needed
            // ...

            // For example, you can log the reminder status in a database table
            $logSql = "INSERT INTO reminder_log (contract_id, reminder_date, email_sent) VALUES ('$contractId', NOW(), '$sent')";
            $conn->query($logSql);
        }
    }
}

// End of script
