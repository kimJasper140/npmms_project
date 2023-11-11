<?php
require_once '../config/config.php';
session_start();
function getPaymentData()
{
    global $conn;
	$currentYear = date('Y');
    $sql = "SELECT * FROM transactions WHERE years = '$currentYear'";
    $result = $conn->query($sql);
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}
function verifyAdminLogin($email, $password)
{
    global $conn;
    $sql = "SELECT * FROM user WHERE email = '$email' AND roles = 'admin'";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        $adminData = $result->fetch_assoc();
        if ($password === $adminData['password']) {
            return true;
        }
    }
    return false;
}
function deleteRecords($transac_id){
    global $conn;
    $sql = "DELETE FROM transactions WHERE transaction_id = '$transac_id'";
    $result =  $conn->query($sql);
    if ($result->num_rows===1){

    }
}
$paymentData = getPaymentData();

include "../tempplate/loading_screen.php";
?>

<!DOCTYPE html>
<html lang = "en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Online Payment | Admin</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script>
            function showPage(url){
                window.location.href = url;
            }
        </script>
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
    </head>
    <body>
        <div class="container" style="margin-top:5%;">
            <h2 class="mt-4">Records of Transaction</h2>
            <button type="button" class="btn btn-success" onclick="showPage('monthly-payment.php')" >Payment History</button>
            <button type="button" class="btn btn-success" onclick="showPage('payment_reports.php')">Payment Reports</button>
            <button type="button" class="btn btn-success" onclick="showPage('payment-setting.php')">Change Recipient</button>

            <h3 class="mt-4">Transaction Log</h3>
			<select input type = "text" name = "announcement" id = "category" class = "category_dropdown" required>
				<option value="default">Filter by</option>
                <option value="default">Year</option>
                <option value="default">Month</option>
                <option value="default">Weeks</option>
			</select>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Month</th>
                            <th>Sales</th>
                            <th>Paid</th>
                            <th>Unpaid</th>
                            <th>Leased</th>
                            <th>Action</th> <!-- Add a new column for the action button -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($paymentData as $payment) : ?>
                            <tr>
                                <td><?php echo $payment['months']; ?></td>
                                <td><?php echo $payment['salesCount']; ?></td>
                                <td><?php echo $payment['paidCount']; ?></td>
                                <td><?php echo $payment['unpaidCount']; ?></td>
                                <td><?php echo $payment['stallLeased']; ?></td>
                                <td>
                                    <button type = "button" class = "btn btn-success" style = "margin: 2px;">Generate Report</button>
                                    <button type = "button" class = "btn btn-success" style = "margin: 2px;" data-toggle="modal" data-target="#adminLoginModal">Edit Record</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <button type="button" class="btn btn-success" onclick="showPage('report-overview.php')">Edit Records</button>
            </div>
        </div>

        <!-- Add Bootstrap JS and jQuery if needed -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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
        </script>

        <!-- Modal for image zoom effect -->
        <div class="modal fade" id="zoomModal" tabindex="-1" role="dialog" aria-labelledby="zoomModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <img id="zoomModalImage" src="" alt="Payment Image" class="img-fluid">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
                                <input type=hidden name="id" id="edit_id">
                                <label for="admin_email">Email: </label>
                                <input type="email" class="form-control" id="admin_email" name="admin_email" required>
                            </div>
                            <div class="form-group">
                                <label for="admin_password">Password</label>
                                <input type="password" class="form-control" id="admin_password" name="admin_password" required>
                            </div>
                            <input type="hidden" name="report_id" id="report_id">
                            <button type="submit" class="btn btn-primary" name="edit_report">Edit Report</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
