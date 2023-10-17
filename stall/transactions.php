<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment History</title>
    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        
        @media (max-width: 768px) {
            body {
        margin-top:7%;
        padding-top: 10%;
            }
            
        }
    </style>
</head>
<?php
include "barpage/topba.php";
?>
<body style="margin-top:7%;">
    <div class="container">
        <?php
        // Check if the user is logged in
        if (!isset($_SESSION['id'])) {
            echo "<p class='mt-4'>Error: User not logged in.</p>";
            exit;
        }

        // Get the logged-in user's ID
        $user_id = $_SESSION['id'];

        // Include the database configuration file
        include "../config/config.php";

        // Check if the stall owner exists in the stall_owner table
        $sql_check_stall_owner = "SELECT * FROM stall_owner WHERE user_id = '$user_id'";
        $result_check_stall_owner = $conn->query($sql_check_stall_owner);
        if ($result_check_stall_owner->num_rows === 0) {
            echo "<p class='mt-4'>Error: Stall owner with ID $user_id not found.</p>";
            exit;
        }

        // Fetch the stall_owner_id from the stall_owner table
        $row_check_stall_owner = $result_check_stall_owner->fetch_assoc();
        $stall_owner_id = $row_check_stall_owner['id'];

        // Fetch payment history of the stall owner
        $sql_payment_history = "SELECT * FROM payment_details WHERE stall_owner_id = '$stall_owner_id' ORDER BY date DESC";
        $result_payment_history = $conn->query($sql_payment_history);
        echo '<h2 class="mt-4" style="margin-top:10%;">Payment History</h2>';
        echo '<a href="payment.php" class="btn btn-success" >Pay Now</a>';  
        if ($result_payment_history->num_rows > 0) {
           
            echo "<div class='table-responsive'>
                    <table class='table table-bordered table-striped'>
                        <tr>
                            <th>ID</th>
                            <th>Account Name</th>
                            <th>Transaction</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Amount</th>
                            <th>Reference Number</th>
                            <th>Action</th>
                        </tr>";

            while ($row = $result_payment_history->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row['id'] . "</td>
                        <td>" . $row['account_name'] . "</td>
                        <td>" . $row['transaction'] . "</td>
                        <td>" . $row['date'] . "</td>
                        <td>" . $row['status'] . "</td>
                        <td>" . $row['amount'] . "</td>
                        <td>" . $row['or_generated'] . "</td>
                        <td>
                            <a href='generate_receipt.php?id=" . $row['id'] . "' class='btn btn-primary'>Generate Receipt</a>
                        </td>
                    </tr>";
            }
            echo "</table>
                </div>";
        } else {
            echo "<p class='mt-4'>No payment history found for the stall owner.</p>";
        }

        // Close the database connection
        $conn->close();
        ?>
    </div>
    
    <!-- Add Bootstrap JS and jQuery if needed -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html> 
