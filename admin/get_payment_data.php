<?php 
require_once '../config/config.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="POST">   
        <?php
            if(isset($_POST['payment_id'])){
                $payment_id = $_POST['payment_id'];
                $sql = "SELECT * FROM monthly_payment_details WHERE id='$payment_id'";
                $paymentResult = mysqli_query($conn, $sql);
                $paymentRow = mysqli_fetch_assoc($paymentResult);
                // Store paymentRow data in the session
                $_SESSION['paymentRow'] = $paymentRow; 
        ?>
        <div class="form-group">
            <label for="flname">Full Name: </label>
            <input id= "flname" class="form-control" value="<?php echo $paymentRow['fullname']; ?>" readonly>
        </div>
        <div class="form-group">
            <label for="monrent">Monthly Rental: </label>
            <input id= "monrent" class="form-control" name="monthly_rental">
        </div>
        <div class="form-group">
            <label for="extrent">Extension Rental: </label>
            <input id= "extrent" class="form-control" name="extension_rental">
        </div>
        <div class="form-group">
            <label for="stall-fee">Stall Extension Fee: </label>
            <input id= "stall-fee" class="form-control" name="stall_extension_fee">
        </div>
        <div class="form-group">
            <label for="penalty">Penalty: </label>
            <input id= "penalty" class="form-control" name="penalty">
        </div>
        <div class="form-group">
            <label for="interest">Interest: </label>
            <input id= "interest" class="form-control" name="interest">
        </div>
        <div class="form-group">
            <label for="or_num">OR Number: </label>
            <input id= "or_num" class="form-control" value="<?php echo $paymentRow['or_no']; ?>" readonly>
        </div>
        <div class="form-group">
            <label for="date">Date: </label>
            <input id= "date" class="form-control" value="<?php echo $paymentRow['date']; ?>" readonly>
        </div>
        <div class="form-group">
            <label for="total-amount">Total Amount: </label>
            <input id= "total-amount" class="form-control" value="<?php echo $paymentRow['total_amount']; ?>" readonly>
        </div>
        <div class="form-group">
            <label for="remarks">Remarks: </label><br>
            <textarea type="textarea" class="remarks" id= "remarks" placeholder="Insert a Remarks"></textarea>
        </div>
        <div class="form-group">
            <label for="status">Status: </label>
            <input id= "status" class="form-control" value="<?php echo $paymentRow['status']; ?>" readonly>
        </div>
        <div class="form-group">
            <label for="stall-number">Stall Number: </label>
            <input id= "stall-number" class="form-control" value="<?php echo $paymentRow['owner_id']; ?>" readonly>
        </div>
        <button type="submit" class="btn btn-primary" name="save_changes">Save Changes</button>
    </form>
    <?php
        }
    ?>
</body>
</html>