<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../phpmailer/src/Exception.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';

include "../config/config.php";
include "../config/session.php";

if (!isset($_SESSION['username']) && $_SESSION['roles'] != 'admin') {
    header("location:../index.php");
    session_destroy();
}
function generateRandomPassword($length = 12) {
    $charset = 'abcdefghijklmnopqrstuvwxyz0123456789';
    $password = '';
    
    for ($i = 0; $i < $length; $i++) {
        $randomIndex = random_int(0, strlen($charset) - 1);
        $password .= $charset[$randomIndex];
    }
    
    return $password;
}
if (isset($_POST['operate'])) {
    $appId = $_POST['appId'];

    // Retrieve applicant information
    $applicantQuery = "SELECT * FROM applications WHERE id = '$appId'";
    $applicantResult = mysqli_query($conn, $applicantQuery);
    $applicantRow = mysqli_fetch_assoc($applicantResult);

   
    
    // Example: Generate a random password with a default length of 12 characters
    $randomPassword = generateRandomPassword();

    // Pre-fill the modal form with applicant data
    $name = $applicantRow['name'];
    $email = $applicantRow['email'];
    $address = $applicantRow['address'];
    $username = $applicantRow['name'];
    $password =   $randomPassword;
    $roles = "stall_owner";
    $designation = "Stall Owner";
    
    // Display the modal form
    echo '<script>
        window.onload = function() {
            document.getElementById("name").value = "' . $name . '";
            document.getElementById("email").value = "' . $email . '";
            document.getElementById("address").value = "' . $address . '";
            document.getElementById("username").value = "' . $username . '";
            document.getElementById("password").value = "' . $password . '";
            document.getElementById("roles").value = "' . $roles . '";
            document.getElementById("designation").value = "' . $designation . '";
            document.getElementById("appId").value = "' . $appId . '";
            document.getElementById("myModal").style.display = "block";
        }
    </script>';
}

if (isset($_POST['register'])) {
    $appId = $_POST['appId'];
    $applicantQuery = "SELECT * FROM applications WHERE id = '$appId'";
    $applicantResult = mysqli_query($conn, $applicantQuery);
    $applicantRow = mysqli_fetch_assoc($applicantResult);
    
    $updateQuery = "UPDATE applications SET status = 'operated' WHERE id = '$appId'";
    mysqli_query($conn, $updateQuery);
    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $roles = $_POST['roles'];
    $designation = $_POST['designation'];
    $status = 'active';
    $dateCreated = date('Y-m-d H:i:s');
    $stallNo = $applicantRow['stall_no'];
	
	$age_contact_query = "SELECT contact, age FROM applications WHERE email='$email'";
	$query_exe = $conn->query($age_contact_query);
	$age_contact_array = $query_exe->fetch_assoc();
	$age = $age_contact_array['age'];
	$contact = $age_contact_array['contact'];
    // Insert the user data into the user table
    $insertQuery = "INSERT INTO `user` (`name`, `email`, `address`, `username`, `password`, `roles`, `designation`, `status`, `dateCreated`)
                    VALUES ('$name', '$email', '$address', '$username', '$password', '$roles', '$designation', '$status', '$dateCreated')";
	mysqli_query($conn, $insertQuery);
	
	$getUID = "SELECT user_id FROM user WHERE name = '$name'";
	$result = $conn->query($getUID);
	while($row = $result->fetch_assoc()){
		$UID = $row['user_id'];
		$insertQuery2 = "INSERT INTO `stall_owner` (`stall_no`, `name`, `age`, `address`, `email`, `contact`, `status`, `user_id`) VALUES ('$stallNo', '$name',
						'$age', '$address', '$email', '$contact', 'operate', '$UID')";
		mysqli_query($conn, $insertQuery2);
	}
    
    // Update the status of the stall in the available_stall table to "unavailable"
    $updateStallQuery = "UPDATE available_stall SET status = 'unavailable' WHERE stall_no = '$stallNo'";
    mysqli_query($conn, $updateStallQuery);


    
    // Update the status of the stall in the available_stall table to "unavailable"
    $updateStallQuery = "UPDATE available_stall SET status = 'unavailable' WHERE stall_no = '$stallNo'";
    mysqli_query($conn, $updateStallQuery);


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
    $mail->addAddress($email, $name);
    $mail->isHTML(true);
    $mail->Subject = 'Account Registration Confirmation';
    $mail->Body = 'Dear ' . $name . ',<br><br>'
    . 'We are pleased to inform you that your account registration at Naujan Public Market has been successfully completed. Below are the details you provided during registration:<br><br>'
    . '<strong>Name:</strong> ' . $name . '<br>'
    . '<strong>Email:</strong> ' . $email . '<br>'
    . '<strong>Address:</strong> ' . $address . '<br>'
    . '<strong>Username:</strong> ' . $username . '<br>'
    . '<strong>Password:</strong> ' . $password . '<br>'
    . '<strong>Roles:</strong> ' . $roles . '<br>'
    . '<strong>Designation:</strong> ' . $designation . '<br><br>'
    . 'We appreciate your interest in being a part of Naujan Public Market. Your registration enables 
    you to access your information with us. If you have any questions or require assistance, 
    feel free to reach out to us. Thank you you may set up your account using the Data Above.';


    if (!$mail->send()) {
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo '<script>alert("Account Info Sent on Gmail!");</script>';

    }
}

// Cancel Application
if (isset($_POST['cancel'])) {
    $appId = $_POST['appId'];
    $remarks = $_POST['remarks'];

    $updateQuery = "UPDATE applications SET status = 'cancel', remarks = '$remarks' WHERE id = '$appId'";
    mysqli_query($conn, $updateQuery);

    // Retrieve applicant information
    $applicantQuery = "SELECT * FROM applications WHERE id = '$appId'";
    $applicantResult = mysqli_query($conn, $applicantQuery);
    $applicantRow = mysqli_fetch_assoc($applicantResult);

    $email = $applicantRow['email'];
    $name = $applicantRow['name'];

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
    $mail->addAddress($email, $name);
    $mail->isHTML(true);
    $mail->Subject = 'Pre-application Cancelled';
    $mail->Body = 'Dear ' . $name . ',<br><br>Your Application has been Cancelled<br><br>' .
        'Remarks: ' . $remarks . '<br>';

    if (!$mail->send()) {
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo '<script>alert("Email sent!");</script>';
    }
}



// Retrieve records for the current page
$query = "SELECT * FROM applications WHERE status = 'approved'";
$applicationsResult = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Approved Applications</title>
    <style>
         body {
            font-family: Arial, sans-serif;
            margin: 50px;
        }

        h1 {
            text-align: center;
        }


       
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 120%;
            height: 50px;
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

        button[name="operate"] {
            background-color: #5cb85c;
            color: #fff;
        }

        button[name="cancel"] {
            background-color: #dc3545;
            color: #fff;
        }

        form {
            display: inline-block;
            margin-bottom: 0;
        }

        

        /* Modal Styles */
        .custom-modals {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0, 0, 0); /* Fallback color */
            background-color: rgba(0, 0, 0, 0.4); /* Black w/ opacity */
        }

        .custom-modal-content {
            background-color: #fefefe;
            margin: 5% auto; /* 10% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 35%; /* Could be more or less, depending on screen size */
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }   
    </style>
</head>
<body>
    <?php 
//include "sidebar-admin.php";
    ?>
    <div class="custom-css">
        <h1>Approved Applications</h1>

       

        
        <table class="table table-bordered table-striped table-hover" >
        <thead>
                <tr>
                    <th>Name</th>
                    <th>Stall No</th>
                    <th>Age</th>
                    <th>Address</th>
                    <th>Email</th>
                    <th>Contact</th>
                    <th>Remarks</th>
                    <th style="width: 200px;text-align: center;">Action</th>
                </tr>
    </thead>
                <?php if (mysqli_num_rows($applicationsResult) > 0) { ?>
                <?php while ($row = mysqli_fetch_assoc($applicationsResult)) { ?>
                    <tbody>
                    <tr>
                        <td><?php echo $row['applicant_name']; ?></td>
                        <td><?php echo $row['stall_no']; ?></td>
                        <td><?php echo $row['applicant_age']; ?></td>
                        <td><?php echo $row['applicant_address']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['contact']; ?></td>
                        <td><?php echo $row['remarks']; ?></td>
                        <td>
                            <form action="" method="POST">
                                <input type="hidden" name="appId" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="operate">Register</button>
                                <button type="submit" formaction="application-form.php?id=<?php echo $row['id']; ?>" formtarget="_blank">View</button>
                                <button type="button" name="cancel" onclick="showRemarkForm(<?php echo $row['id']; ?>)">Cancel</button>
                            </form>
                        </td>
                    </tr>
                </tbody>
                <?php } ?>
            </table>
        <?php }  ?>

        <!-- Modal Form -->
        <div id="myModal" class="custom-modals">
            <div class="custom-modal-content">
                <span class="close">&times;</span>
                <h2>Registration Form</h2>
                <form action="" method="POST">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" readonly><br><br>
                    <label for="address">Address:</label>
                    <input type="text" id="address" name="address" readonly><br><br>
                    <label for="roles">Roles:</label>
                    <input type="text" id="roles" name="roles" readonly><br><br>
                    <label for="designation">Designation:</label>
                    <input type="text" id="designation" name="designation" readonly><br><br>
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required><br><br>
                   <h1> Account information</h1><br>
                     <label for="email">Email:</label>
                    <input type="email" id="email" name="email" readonly><br><br>
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" readonly><br><br>
                    <input type="hidden" id="appId" name="appId">
                    <button type="submit" name="register">Register</button>
                </form>
            </div>
        </div>

        <!-- Remark Form -->
        <div id="remarkModal" class="custom-modals">
            <div class="custom-modal-content">
                <span class="close" onclick="hideRemarkForm()">&times;</span>
                <h2>Cancel Application</h2>
                <form action="" method="POST">
                    <input type="hidden" id="cancelAppId" name="appId">
                    <label for="remarks">Remarks:</label>
                    <input type="text" id="remarks" name="remarks" required><br><br>
                    <button type="submit" name="cancel">Cancel Application</button>
                </form>
            </div>
        </div>

       
    <script>
        // Close the modal form when the close button is clicked
        document.getElementsByClassName("close")[0].addEventListener("click", function() {
            document.getElementById("myModal").style.display = "none";
        });

        // Close the modal form when the user clicks outside of it
        window.addEventListener("click", function(event) {
            if (event.target == document.getElementById("myModal")) {
                document.getElementById("myModal").style.display = "none";
            }
        });

        // Show the remark form
        function showRemarkForm(appId) {
            document.getElementById("cancelAppId").value = appId;
            document.getElementById("remarks").value = "";
            document.getElementById("remarkModal").style.display = "block";
        }

        // Hide the remark form
        function hideRemarkForm() {
            document.getElementById("remarkModal").style.display = "none";
        }
    </script>
      <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.3/datatables.min.css" rel="stylesheet" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.3/datatables.min.js"></script>
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

            })

        })
    </script>
</body>
</html>
