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
    $sql_check = "SELECT * FROM transactions WHERE transaction_id = $transac_id";
    $result_check = $conn->query($sql_check);

    if ($result_check->num_rows > 0) {
        // Data exists, perform delete query
        $sql_delete = "DELETE FROM transactions WHERE transaction_id = $transac_id";

        if ($conn->query($sql_delete) === TRUE) {
            echo "<script>alert('Records had been successfully deleted')</script>";
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    } else {
        // No data found
        echo "No data to be found";
    }
}

function generateReport(){
    global $conn;
    $sql = "SELECT * FROM monthly_payment_details";
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

        body{
            margin: 5px;
        }
    </style>
    </head>
    <body>
        <button type="button" class="btn btn-success" onclick="showPage('dashboard-admin.php')">Back</button>
        <div class="container" style="margin-top:5%;">
            <h2 class="mt-4">Records of Transaction</h2>
            <button type="button" class="btn btn-success" onclick="showPage('monthly-payment.php')" >Payment History</button>
            <button type="button" class="btn btn-success" onclick="showPage('payment_reports.php')">Payment Reports</button>
            <button type="button" class="btn btn-success" onclick="showPage('payment-setting.php')">Change Recipient</button>

            <h3 class="mt-4">Transaction Log</h3>
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
                    <?php foreach ($paymentData as $index => $payment) : ?>
                        <tr>
                            <td><?php echo $payment['months']; ?></td>
                            <td><?php echo $payment['salesCount']; ?></td>
                            <td><?php echo $payment['paidCount']; ?></td>
                            <td><?php echo $payment['unpaidCount']; ?></td>
                            <td><?php echo $payment['stallLeased']; ?></td>
                            <td>
                                <button type="button" style="margin: 2px;" class="generateReportBtn btn btn-success" data-id="<?php echo $payment['months'];?>">Generate Report</button>
                                <button type="button" class="editReportBtn btn btn-success" style="margin: 2px;" data-id="<?php echo $payment['months'];?>">Edit Record</button>
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
                        <form method="post" >
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
        <script>
            function generateReport() {
                // Make an AJAX request to a PHP script that fetches data from the database
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        var data = JSON.parse(xhr.responseText);
                        generateTables(data);
                    }
                };
                xhr.open("GET", "fetch_data.php", true);
                xhr.send();
            }

            function generateTables(data) {
                // Remove existing tables if any
                var existingTables = document.querySelectorAll('table');
                existingTables.forEach(function(table) {
                    table.parentNode.removeChild(table);
                });

                // Generate tables based on the data
                data.forEach(function(tableData) {
                    var table = document.createElement('table');
                    table.border = '1';

                    // Add table headers
                    var thead = table.createTHead();
                    var headerRow = thead.insertRow();
                    for (var key in tableData[0]) {
                        var th = document.createElement('th');
                        th.appendChild(document.createTextNode(key));
                        headerRow.appendChild(th);
                    }

                    // Add table body
                    var tbody = table.createTBody();
                    tableData.forEach(function(rowData) {
                        var row = tbody.insertRow();
                        for (var key in rowData) {
                            var cell = row.insertCell();
                            cell.appendChild(document.createTextNode(rowData[key]));
                        }
                    });

                    // Append the new table to the body
                    document.body.appendChild(table);
                });
            }

            var generateButtons = document.getElementsByClassName('generateReportBtn');

            // Attach click event to each button
            for (var i = 0; i < generateButtons.length; i++) {
                generateButtons[i].addEventListener('click', function() {
                    var monthValue = this.getAttribute('data-id'); // Get the 'data-id' attribute value

                    // Construct the URL with the dynamic ID value
                    var url = 'generate_report.php?month=' + monthValue;

                    // Redirect to the generated URL
                    window.location.href = url;
                });
            }

            var editButtons = document.getElementsByClassName('editReportBtn');

            // Attach click event to each button
            for (var i = 0; i < editButtons.length; i++) {
                editButtons[i].addEventListener('click', function() {
                    var monthValue = this.getAttribute('data-id'); // Get the 'data-id' attribute value

                    // Construct the URL with the dynamic ID value
                    var url = 'report-overview.php?month=' + monthValue;

                    // Redirect to the generated URL
                    window.location.href = url;
                });
            }
        </script>
    </body>
</html>
