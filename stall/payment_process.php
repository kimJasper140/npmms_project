<?php
// Start the session
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../phpmailer/src/Exception.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';

// Check if the form is submitted
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the image file is uploaded successfully
    if(isset($_FILES['image']['tmp_name']) && !empty($_FILES['image']['tmp_name'])) {

        include "../config/config.php";
        if(isset($_SESSION['id'])) {
            $user_id = $_SESSION['id'];

            // Check if the stall owner exists in the stall_owner table
            $sql_check_stall_owner = "SELECT * FROM stall_owner WHERE user_id = '$user_id'";
            $result_check_stall_owner = $conn->query($sql_check_stall_owner);
            if($result_check_stall_owner->num_rows === 0) {
                echo "Error: Stall owner with ID $user_id not found.";
                exit;
            }
            // Fetch the stall_owner_id from the stall_owner table
            $row_check_stall_owner = $result_check_stall_owner->fetch_assoc();
            $stall_owner_id = $row_check_stall_owner['id'];

            // Get form data
            $account_name = $_POST['account_name'];
            $transaction = $_POST['transaction'];
            $amount = $_POST['amount'];
            $sql = "SELECT * FROM stall_owner WHERE id = '$stall_owner_id'";
            $result = $conn->query($sql);

            if($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $email = $row['email'];
                $name = $row['name'];
            }

            // Generate a reference number for "or_generated" (you can modify this as per your system's logic)
            $or_generated = generateReferenceNumber();

            // Get the current date
            $date = date("Y-m-d");

            // Handle image upload
            $image = $_FILES['image']['name'];
            $target_dir = "../images/"; // Specify the directory where you want to store the images
            $target_file = $target_dir.basename($image);

            // Check if the image file is an actual image or a fake image
            $check = getimagesize($_FILES['image']['tmp_name']);
            if($check === false) {
                die("Invalid image file.");
            }

            // Upload the image to the server
            if(move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                // Set the default status as 'Pending' (you can modify this as per your requirement)
                $status = 'Pending';

                // Insert data into the database
                $sql = "INSERT INTO payment_details (`account_name`, `transaction`, `date`, `status`, `amount`, `image`, `or_generated`, `stall_owner_id`) VALUES ('$account_name', '$transaction', '$date', '$status', '$amount', '$image', '$or_generated', '$stall_owner_id')";

                if($conn->query($sql) === TRUE) {
                    // Payment inserted successfully, now fetch the stall owner's email
                    $mail = new PHPMailer();

                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'publicmarketnaujan@gmail.com';
                    $mail->Password = 'lwtywoqkuzatemxx';
                    $mail->SMTPSecure = 'ssl';
                    $mail->Port = 465;

                    $mail->setFrom('publicmarketnaujan@gmail.com', 'Naujan Public Market');
                    $mail->addAddress($email, $name);
                    $mail->isHTML(true);
                    $mail->Subject = 'Payment Details';
                    $mail->Body = 'Account Name:'.$account_name.'<br>
                    Transaction:'.$transaction.'<br>
                        Date:'.$date.'<br>
                        Amount:'.$amount.' PHP<br>
                        Status:'.$status.'<br>
                        Reference Number:'.$or_generated.'<br><br><hr>
                        Note : Wait for the Admin to Verify the Payment';




                    if(!$mail->send()) {
                        echo 'Mailer Error: '.$mail->ErrorInfo;
                    } else {
                        $notification_message = "Payment received from ".$name." for the amount of ".$amount." PHP. Reference Number: ".$or_generated;
                        $notification_created_at = date("Y-m-d H:i:s");

                        $sql_notification = "INSERT INTO notifications (`message`, `read_status`, `created_at`) VALUES ('$notification_message', 0, '$notification_created_at')";
                        if($conn->query($sql_notification) === TRUE) {
                            // Notification inserted successfully
                            echo "<script>window.location.href = 'transactions.php';</script>";
                        } else {
                            echo "Error creating notification: ".$conn->error;
                        }
                    }
                } else {
                    echo "Error: ".$sql."<br>".$conn->error;
                }
            } else {
                echo "Error uploading image.";
            }
        } else {
            echo "Error: Stall owner ID not found in session.";
        }
    } else {
        echo "Please select an image.";
    }

    // Close the database connection
    $conn->close();
} else {
    echo "Please submit the form.";
}

// Function to generate a random reference number
function generateReferenceNumber() {
    // Your logic to generate a reference number (e.g., using random strings, timestamps, etc.)
    // Replace this with your actual logic to generate the reference number.
    return "REF".substr(md5(uniqid()), 0, 8);
}
?>