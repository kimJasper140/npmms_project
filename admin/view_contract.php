<?php
// Include necessary files and configurations
require '../phpmailer/src/Exception.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include "../config/config.php";
session_start();
// Check if the stall owner ID is provided in the URL
if (!isset($_GET['stall_owner_id'])) {
    header("stall_operate.php");
    exit();
}

// Get the stall owner ID from the URL
$stall_owner_id = $_GET['stall_owner_id'];

// Fetch the contract details for the selected stall owner
$sql = "SELECT id, stall_owner_id, contract_date, contract_start_date, contract_end_date, contract_terms 
        FROM stall_owner_contract WHERE stall_owner_id = '$stall_owner_id'";
$result = $conn->query($sql);

// Fetch the stall owner's details
$sql_owner = "SELECT name, stall_no, email FROM stall_owner WHERE id = '$stall_owner_id'";
$result_owner = $conn->query($sql_owner);
$owner_data = $result_owner->fetch_assoc();
$owner_name = $owner_data['name'];
$stall_no = $owner_data['stall_no'];
$email = $owner_data['email'];

// Initialize the variable
$is_near_end = false;

// Handle form submission for adding a new contract
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['contract_terms'])) {
    $contract_start_date = $_POST['contract_start_date'];
    $contract_end_date = $_POST['contract_end_date'];
    $contract_terms = $_POST['contract_terms'];

    // Insert the new contract into the database
    $sql_insert = "INSERT INTO stall_owner_contract (stall_owner_id, contract_date, contract_start_date, contract_end_date, contract_terms) 
                VALUES ('$stall_owner_id', NOW(), '$contract_start_date', '$contract_end_date', '$contract_terms')";

    if ($conn->query($sql_insert) === TRUE) {

        // Send email notification
        $mail = new PHPMailer();

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'publicmarketnaujan@gmail.com'; // Replace with your Gmail or Google Workspace email
        $mail->Password = 'lwtywoqkuzatemxx'; // Replace with your Gmail or Google Workspace password
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom('publicmarketnaujan@gmail.com', 'Naujan Public Market');
        $mail->addAddress($email, $owner_name);
        $mail->isHTML(true);
        $mail->Subject = 'Contract details';
        $mail->Body = 'Dear ' . $owner_name .  ',<br> Transaction has been added.
        <br>
        <br>Contract start:' .$contract_start_date .'
        <br>Contract end:' .$contract_end_date .'<br><br>
        Term: '. $contract_terms .'<br>


        <br>
        <b>note: </b> <i>if you have any concern and inquiries please contact Naujan public market </i> <br>

        thank you
        ';

     
        $notificationMessage = "Hi Stall Owner " .$owner_name  . 
        "Your Contract details is here :<br>:".
        "Contract Start: ".$contract_start_date. '<br>Contract end date: '.$contract_end_date. '<br>Contract terms: '.$contract_terms;
        $notificationTimestamp = date("Y-m-d H:i:s");
        $notificationDate = date("Y-m-d");
        $notificationSent = 0; // Notification is not sent immediately
    
        $sql_add_notification = "INSERT INTO stall_notifications (stall_owner_id, subject, message, notification_timestamp, notification_date, notification_sent) VALUES ('$stall_owner_id', '$notificationMessage', '$notificationMessage', '$notificationTimestamp', '$notificationDate', '$notificationSent')";
        $conn->query($sql_add_notification);


        

        if (!$mail->send()) {
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo '<script>alert("Contract has been saved");</script>';
            header("Location: stall_operate.php");
            exit();
        }
    } else {
        echo "Error adding contract: ";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Contract | <?php echo $owner_name; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
           
            background-color: #fff;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            border-radius: 4px;
            padding: 20px;
            margin-top: 50px;
        }

        h1 {
            text-align: center;
        }

        /* Add some spacing between the form elements */
        form {
            margin-top: 20px;
        }

        form label {
            display: block;
            margin-bottom: 5px;
        }

        form input[type="date"],
        form textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        form button {
            background-color: green; /* Green color for the button */
            color: #fff; /* White text color for the button */
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        /* Style the button on hover */
        form button:hover {
            background-color: goldenrod; /* Darker green on hover */
        }

        .contract-details {
            margin-top: 20px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .contract-details h2 {
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
<?php include "topbar.php"; ?>
    <div class="container">
        <h3>Contract Details for Stall Owner <?php echo $owner_name; ?></h3>
        <?php if ($result->num_rows > 0) { ?>
            <?php
            $latest_contract = $result->fetch_assoc();
            ?>
  <div class="contract-details">
          <h2>Contract ID: <?php echo $latest_contract['id']; ?></h2>
          <p><strong>Stall Owner ID:</strong> <?php echo $latest_contract['stall_owner_id']; ?></p>
          <p><strong>Contract Date:</strong> <?php echo $latest_contract['contract_date']; ?></p>
            This contract amendment serves to shorten the original contract's duration,
             resulting in a revised start date of <b><?php echo $latest_contract['contract_start_date']; ?></b> and a revised end date of
             <b><?php echo $latest_contract['contract_end_date']; ?></b>
              All other terms and conditions of the original contract shall remain in effect.
                <p><strong>Contract Terms:</strong> <?php echo $latest_contract['contract_terms']; ?></p>
                <a href="edi_contract.php?contract_id=<?php echo $latest_contract['id']; ?>" class="btn btn-primary"> Contract</a>
            </div>
        <?php } else { ?>
            <p>No contract found for this stall owner.</p>
        <?php } ?>

        <?php if ($result->num_rows == 0) { ?>
            <!-- Contract Form for Admin -->
            <h2>Create Contract</h2>
            <form method="post">
                <label for="contract_start_date">Contract Start Date:</label>
                <input type="date" name="contract_start_date" required>
                <br>
                <label for="contract_end_date">Contract End Date:</label>
                <input type="date" name="contract_end_date" required>
                <br>
                <label for="contract_terms">Contract Terms:</label>
                <textarea name="contract_terms" rows="5" cols="50" required></textarea>
                <br>
                <button type="submit">Add Contract</button>
            </form>
        <?php } ?>

        <?php if ($result->num_rows > 0 && $is_near_end) { ?>
            <form action="renew_contract.php" method="post">
                <input type="hidden" name="stall_owner_id" value="<?php echo $stall_owner_id; ?>">
                <button type="submit" name="renew_contract">Renew Contract</button>
            </form>
        <?php } ?>
    </div>

    <style>
    .custom-body {
      font-family: Arial, sans-serif;
   margin-left:5%;
      margin-top: 8%;
    }

    h1 {
      text-align: center;
      margin-bottom: 20px;
    }

    p {
      margin-bottom: 10px;
    }

    .section-heading {
      font-weight: bold;
      text-decoration: underline;
      margin-bottom: 10px;
    }

    .contract-section {
      margin-bottom: 20px;
    }

    .contract-section p {
      margin-left: 20px;
    }

    .signature-section {
      margin-top: 40px;
    }

    .signature-line {
      display: inline-block;
      width: 250px;
      border-bottom: 1px solid #000;
      margin-bottom: 10px;
    }

    .signature {
      font-weight: bold;
    }
  </style>
</head>


  <h1>Contract of Lease</h1>
  <p class="contract-section">
    <div style="margin:5%";>
    <span class="section-heading">On the Stall Constructed by the Municipality</span>
    <br><br>
    KNOW ALL MEN BY THESE PRESENTS:
    <br><br>
    Considering favorably the contest of the hereto attached application for lease of the stall/table space within the Market Compound Wet Section, this CONTRACT OF LEASE is made and executed on this day of <span class="year"></span> at Naujan, Oriental Mindoro, by and between the Municipality of Naujan, represented by its Municipal Mayor, hereinafter called the LESSOR; and <span class="lessee-name"></span> of legal age, married/widow/widower/single, Filipino citizen and resident of Naujan, Oriental Mindoro, hereinafter called the LESSEE.
  </p>
  <p class="contract-section">
    WITNESSETH:
    <br><br>
    That the LESSOR hereby lets the leases unto the LESSEE stall/table No. <span class="stall-no"></span> in the Naujan Market Compound Wet Section for commercial and business purposes.
    <br><br>
    To have hold the same for a period of one (1) year, which can be extended or renewed upon agreement of both the LESSOR and the LESSEE at the end of each term; Provided that such extension or renewal shall not be for more than one (1) year.
    <br>
    <ul>
      <li>The Lessee has to pay P2,000 (Two Thousand Pesos) as advance rental payment.</li>
      <li>To pay the monthly rental fee in the amount of P225.00 (Two Hundred Twenty Five Pesos);</li>
    </ul>
    The said monthly rental shall be paid on or before the end of each month to the Office of the Municipal Treasure.
    <br><br>
    If the LESSEE fails to pay the monthly rental fee within the prescribed period, he/she shall be subjected to pay a surcharge of Twenty Five (25%) percent of the total rental due. Failure to pay the rental fee for three (3) consecutive months shall cause the automatic cancellation of the contract of lease of the stall without produce of suing the LESSEE for the unpaid rents at the expense of the LESSEE. The stall shall also be declared vacant and subject to adjudication. Provided however, that the LESSOR may, while the default shall continue and notwithstanding any waiver of any prior Breach of Condition without notice or demand, enter and remove the LESSEE from the premises, dispose the LESSEE'S goods and effects in accordance with the existing ordinance and regulation relative to the matter, until the process satisfy the amount of the LESSEE'S unpaid rents.
    <br><br>
    <ul>
      <li>Not to make any unlawful, improper, or offensive use of the premises, nor use the same other than as herein specified.</li>
      <li>Not to enter into business partnership with any party acquiring the right to lease.</li>
      <li>Not to assign this lease or to sublease the whole or any part of the premises for any purpose whatsoever.</li>
      <li>To notify the LESSOR within thirty (30) days of any intentions to discontinue business and declare vacancy of stall before the expiration of the lease.</li>
      <li>At the end of the said term, to deliver peacefully to the LESSOR the leased premises, vacant and unencumbered.</li>
      <li>That the conditions enumerated in the accompanying application for lease shall form part of this Contract.</li>
    </ul>
  </p>
  <p class="contract-section">
    The LESSOR hereby covenants with the LESSEE follows;
    <br><br>
    The LESSEE shall peaceably hold and enjoy the leased premises during all time of this Contract of Lease.
  </p>
  <div class="signature-section">
    <p>
      IN WITNESS WHEREOF, the parties hereto have hereunto signed their names at the place above written on this day of <span class="day"></span>, <span class="year"></span>.
    </p>
    <p>
      Municipality of Naujan<br>
      (Lessor)
    </p>
    
    <p class="signature">   <?php
            include "../config/config.php";
                            $sql = "SELECT * FROM resources Where id=2";
                            $result = mysqli_query($conn, $sql);
                            ($row = mysqli_fetch_assoc($result));
                            echo $row['content']; 
                           ?><div class="signature-line"></div></p>
    <p>
      (LESSEE)
    </p>
    <strong><?php echo strtoupper($owner_name); ?></strong><br>

    <div class="signature-line"></div>
    
    <p class="signature">LESSEE NAME</p>
    <p>
      SIGNED IN THE PRESENCE OF:
    </p>
    <p>
      JAY MARK Y. BACAY<br>
      LHOTA L. MASILANG
    </p>
  </div>

  <script>
    // Update current year dynamically
    const yearElements = document.getElementsByClassName('year');
    for (let i = 0; i < yearElements.length; i++) {
      yearElements[i].textContent = new Date().getFullYear();
    }

    // Update current day dynamically
    const dayElement = document.getElementsByClassName('day')[0];
    const currentDate = new Date();
    const day = currentDate.getDate();
    dayElement.textContent = day < 10 ? '0' + day : day;

    // Update lessee name dynamically
    const lesseeNameElement = document.getElementsByClassName('lessee-name')[0];
    lesseeNameElement.textContent = 'LESSEE NAME';

    // Update stall number dynamically
    const stallNoElement = document.getElementsByClassName('stall-no')[0];
    stallNoElement.textContent = 'STALL NO';
  </script>


</body>

</html>
 