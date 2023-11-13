<?php
require_once '../config/config.php';
session_start();
// Function to fetch payment data from the database
function getPaymentData()
{
    global $conn;
    $sql = "SELECT * FROM payment_details";
    $result = $conn->query($sql);
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}


// Function to update the payment status in the database
function updatePaymentStatus($paymentId)
{
    global $conn;
	$currentMonth = date('F');
	$paidCount = 0;
    $sql = "UPDATE payment_details SET status = 'Paid' WHERE id = $paymentId";
	$paidCount += 1;
	$obtainSql = "SELECT paidCount FROM transactions WHERE months='$currentMonth'";
    
	
	$result = mysqli_query($conn, $obtainSql);

	if ($result) {
		while ($row = mysqli_fetch_assoc($result)) {
			$value = $row['paidCount'];
			$value += 1;
			$updateCount = "UPDATE transactions SET paidCount = '$value', salesCount = '$value', stallLeased = '$value' WHERE months = '$currentMonth'";
			$conn->query($updateCount);
		}
	} else {
		echo "Error: " . mysqli_error($conn);
	}
	
	return $conn->query($sql);
}

// Function to verify the admin login without hashing passwords (not recommended for production)
function verifyAdminLogin($email, $password)
{
    global $conn;
    $sql = "SELECT * FROM user WHERE email = '$email' AND roles = 'admin'";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        $adminData = $result->fetch_assoc();
        // Simple password comparison
        if ($password === $adminData['password']) {
            return true;
        }
    }
    return false;
}

// Handle form submission for updating payment status
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['verify_payment'])) {
        $paymentId = $_POST['payment_id'];
        $adminEmail = $_POST['admin_email'];
        $adminPassword = $_POST['admin_password'];

        // Verify the admin login before updating payment status
        if (verifyAdminLogin($adminEmail, $adminPassword)) {
            updatePaymentStatus($paymentId);
            $sql = "SELECT stall_owner_id FROM payment_details WHERE id = '$paymentId'";
            $soi = $conn->query($sql);

            // Insert notification
            while ($row = $soi->fetch_assoc()) {
                $stall_owner_id =  $row['stall_owner_id'];// Get the stall_owner_id of the verified payment
            }
            $notificationMessage = "Your payment has been verified and processed.";
            $notificationTimestamp = date("Y-m-d H:i:s");
            $notificationDate = date("Y-m-d");
            $notificationSent = 1; // Assuming you want to mark the notification as sent immediately

            $query = "INSERT INTO stall_notifications (stall_owner_id, subject, message, notification_timestamp, notification_date, notification_sent) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("issssi", $stall_owner_id, $notificationMessage, $notificationMessage, $notificationTimestamp, $notificationDate, $notificationSent);
            $stmt->execute();


            if ($stmt->affected_rows > 0) {
                $mysqli->commit();
                echo "Data inserted successfully.";
            } else {
                $mysqli->rollback(); // Rollback if any query fails
                echo "Data insertion failed.";
            }
            $stmt->close();

            // Redirect to the same page to refresh the data
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        } else {
            // Show an error message or take appropriate action
            echo "Invalid admin credentials. Payment not verified.";
        }
    }
}

// Fetch payment data
$paymentData = getPaymentData();

include "../tempplate/loading_screen.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Payment | Admin</title>
    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    

    <!-- Add custom CSS for image zoom -->
    <style>
        /* Adjust the size of the image container as per your preference */
        .image-zoom-container {
            width: 200px;
            height: 150px;
            overflow: hidden;
        }

        /* Adjust the size of the image to fit the container */
        .zoomable-image {
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        /* Add CSS for the zoom effect */
        .zoomed {
            width: 400px;
            height: auto;
        }
    </style>
    <script>
            function showPage(url){
                window.location.href = url;
            }
    </script>
</head>
<body>

    <div class="container" style="margin-top:5%;">
        <h2 class="mt-4">Payment Section</h2>
        <h3 class="mt-4">Payment Details</h3>
        <hr>
        <button type="button" class="btn btn-success" onclick="showPage('monthly-payment.php')">Payment History</button>
        <button type="button" class="btn btn-success" onclick="showPage('payment_reports.php')">Payment Reports</button>
        <button type="button" class="btn btn-success" onclick="showPage('payment-setting.php')">Change Recipient</button>
        
        

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                <tr class="text-center">
                        <th>ID</th>
                        <th>Account Name</th>
                        <th>Transaction</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Amount</th>
                        <th>Image</th>
                        <th>Remarks</th>
                        <th>OR Number</th>
                        <th>Action</th> 
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($paymentData as $payment) : ?>
					<?php 
						require_once '../config/config.php';
						$query = "SELECT COUNT(*) AS rowCount FROM payment_details WHERE status = 'Pending'";
						$result = mysqli_query($conn, $query);
						$currentMonth = date('F');
						if ($result) {
							$row = mysqli_fetch_assoc($result);
							$rowCount = $row['rowCount'];
							$updateQuery = "UPDATE transactions SET unpaidCount = '$rowCount' WHERE months = '$currentMonth'";
							$conn->query($updateQuery);
						}
					?>
                        <tr>
                            <td><?php echo $payment['id']; ?></td>
                            <td><?php echo $payment['account_name']; ?></td>
                            <td><?php echo $payment['transaction']; ?></td>
                            <td><?php echo $payment['date']; ?></td>
                            <td><?php echo $payment['status']; ?></td>
                            <td><?php echo $payment['amount']; ?></td>
                            <td>
                                <div class="image-zoom-container">
                                    <img class="zoomable-image" src="../images/<?php echo $payment['image']; ?>" alt="Payment Image">
                                </div>
                            </td>
                            <td><?php echo $payment['remarks']; ?></td>
                            <td><?php echo $payment['or_generated']; ?></td>
                            <td style="vertical-align:middle;">
                                <?php if ($payment['status'] === 'Pending') : ?>
                                    <button class="btn btn-primary verify-btn btn-sm"  data-payment-id="<?php echo $payment['id']; ?>" data-toggle="modal" data-target="#adminLoginModal">Verify Payment</button>
                                <?php else : ?>
                                    <span class="text-success">Paid</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add Bootstrap JS and jQuery if needed -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.3/datatables.min.css" rel="stylesheet" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.3/datatables.min.js"></script>
    <script>
        $(document).ready(function () {
            // Function to handle the click event on the image
            $('.zoomable-image').on('click', function () {
                var src = $(this).attr('src');
                $('#zoomModalImage').attr('src', src);
                $('#zoomModal').modal('show');
            });

            // Function to set the payment ID in the modal before form submission
            $('.verify-btn').on('click', function () {
                var paymentId = $(this).data('payment-id');
                $('#payment_id').val(paymentId);
            });
        });

        $(document).ready(function() {
            $('table').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf'
                ],
                searching: true,
                ordering: true,
                paging: true,
                "order": [
                    [1, "desc"]
                ],

            })

        })
    </script>

    <!-- Modal for image zoom effect -->
    <div class="modal fade" id="zoomModal" tabindex="-1" role="dialog" aria-labelledby="zoomModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <img id="zoomModalImage" src="" alt="Payment Image" class="img-fluid">
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for admin login -->
    <div class="modal fade" id="adminLoginModal" tabindex="-1" role="dialog" aria-labelledby="adminLoginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="adminLoginModalLabel">Admin Login</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post">
                        <div class="form-group">
                            <label for="admin_email">Email: </label>
                            <input type="email" class="form-control" id="admin_email" name="admin_email" required>
                        </div>
                        <div class="form-group">
                            <label for="admin_password">Password</label>
                            <input type="password" class="form-control" id="admin_password" name="admin_password" required>
                        </div>
                        <input type="hidden" name="payment_id" id="payment_id">
                        <button type="submit" class="btn btn-primary btn-sm" name="verify_payment" >Verify Payment</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
