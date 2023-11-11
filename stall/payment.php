<?php
session_start();
include("../config/config.php");

$sqlimage = "SELECT content FROM `resources` WHERE `id` = 5";
$result = mysqli_query($conn, $sqlimage);
$recipientImage = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Form</title>
    <link rel="icon" href="../image/logo.ico" type="image/x-icon">
    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body class="body" style="margin-bottom:5%;">
    <?php include "barpage/topba.php"; ?>

    <div class="container mt-4">
        <h4 class="text-center">Pay here</h4>
        <div class="text-center">
            <?php
            if (!empty($recipientImage) && isset($recipientImage['content'])) {
                echo '<img class="custom-icon" src="../admin/' . $recipientImage['content'] . '" alt="Profile Picture">';
            } else {
                echo '<img class="custom-icon" src="profile/default.jpeg" alt="Default Profile Picture">';
            }
            ?>
        </div>
        <br>
        <div style=" text-align: inter-word;">
        <b><i><center> Tagubilin sa Pagkuha ng Litratong Resibo </b>
            <hr>


            1.Upang mapadali ang pagproseso ng iyong bayad, mangyaring sundan ang mga sumusunod na hakbang sa pagkuha ng
            litratong resibo:<br><br>

            2.Siguruhing malinaw ang litrato ng resibo. Ilagay ito sa isang maayos na ilaw at iwasan ang anumang anino o
            blur.<br><br>

            3.Tiyakin na mabasa ang lahat ng impormasyon sa resibo, lalo na ang halaga ng bayad, petsa, at iba pang
            mahahalagang detalye.<br><br>

            4.Ilagay ang pangalan na nasa resibo. Siguruhing mabasa ito nang maayos upang mapadali ang pag-verify ng iyong
            transaksyon.<br><br>

            5.Salamat sa iyong kooperasyon! Ang malinaw na litrato ay magiging tulong sa mabilis at maayos na pagproseso
            ng iyong bayad.<br><br></i></center>
        <h1 class="mt-4 text-center">Payment Form</h1>

        <form action="payment_process.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="account_name">Sender Name:</label>
                <input type="text" class="form-control" id="account_name" name="account_name" required>
            </div>

            <!-- Fixed "transaction" field to "Payment" -->
            <input type="hidden" name="transaction" value="Payment">

            <div class="form-group">
                <label for="date">Date:</label>
                <input type="date" class="form-control" id="date" name="date" value="<?php echo date('Y-m-d'); ?>"
                    readonly>
            </div>

            <div class="form-group">
                <label for="amount">Amount:</label>
                <input type="number" class="form-control" id="amount" name="amount" required>
            </div>
            <p class="text-center"><i>Screen Capture your Proof of payment (admin will verify)</i></p>
            <div class="form-group">
                <label for="image">Image:</label>
                <input type="file" class="form-control-file" id="image" name="image" required>
            </div>

            <!-- "or_generated" will be provided by the system, so no need to show it in the form -->
            <div class="text-center">
                <input type="submit" class="btn btn-primary" value="Submit Payment">
            </div>
           
        </form>

    </div>

    <!-- Add Bootstrap JS and jQuery if needed -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>