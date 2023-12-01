<?php 
require_once '../config/config.php';
session_start();

$paymentDetails = [];
$received_id = null;

function generateModalData($received_id) {
    global $conn;

    // Sanitize the received ID (for example, using mysqli_real_escape_string)
    $sanitized_id = intval($received_id);
    $sql = "SELECT * FROM monthly_payment_details WHERE id='$sanitized_id'";
    $query_result = $conn->query($sql);
    $query_data = array();
    while ($row = $query_result->fetch_assoc()) {
        $query_data[] = $row;
    }
    
    return $query_data;
}  


function getPaymentData()
{
    global $conn;
    $sql = "SELECT * FROM monthly_payment_details";
    $result = $conn->query($sql);
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}         


if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id'])) {
    global $received_id;
    $receivedId = $_POST['id'];

    $received_id = $receivedId;
    
}


$paymentData = getPaymentData();
$paymentDetails = generateModalData($received_id);
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

        button{
            margin: 5px;
        }

        .scroll{
            overflow-y: scroll;
        }

        .remarks{
            height: 150px;
            border-radius: 10px;
            width: 100%
        }
    </style>
    </head>
    <body>
        <button type="button" class="btn btn-success" onclick="BackPage('payment_reports.php')">Back</button>
        <div class="container" style="margin-top:5%;">
            <h2 class="mt-4">Edit Report</h2>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <!--<table border='1'>--->
                            <th>ID</th>
                            <th>Fullname</th>
                            <th>Monthly Rental</th>
                            <th>Extension Rental</th>
                            <th>Stall Extension Fee</th>
                            <th>Penalty</th>
                            <th>Interest</th>
                            <th>OR Number</th>
                            <th>Date</th>
                            <th>Total Amount</th>
                            <th>Remarks</th>
                            <th>Status</th>
                            <th>Stall Number</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($paymentData as $payment) : ?>
                        <?php 
                            require_once '../config/config.php';
                            if (isset($_GET['month'])) {
                                // Get the 'id' parameter value from the URL
                                $id = $_GET['month'];
                                $sql = "SELECT * FROM monthly_payment_details WHERE month='$id'";
                                $result = mysqli_query($conn, $sql);
                            }
                        ?>
                            <tr>
                                <td><?php echo $payment['id']; ?></td>
                                <td><?php echo $payment['fullname']; ?></td>
                                <td><?php echo $payment['monthly_rental']; ?></td>
                                <td><?php echo $payment['extension_rental']; ?></td>
                                <td><?php echo $payment['stall_extension_fee']; ?></td>
                                <td><?php echo $payment['penalty_25']; ?></td>
                                <td><?php echo $payment['interest_2']; ?></td>
                                <td><?php echo $payment['or_no']; ?></td>
                                <td><?php echo $payment['date']; ?></td>
                                <td><?php echo $payment['total_amount']; ?></td>
                                <td><?php echo $payment['remarks']; ?></td>
                                <td><?php echo $payment['status']; ?></td>
                                <td><?php echo $payment['owner_id']; ?></td>
                                <td>
                                    <button onclick="openModal()" class="edit-button btn btn-primary" data-value="<?php echo $payment['id']; ?>">Edit</button>                   
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal scroll" id="myModal" tabindex="-1" role="dialog" aria-labelledby="adminLoginModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="adminLoginModalLabel">Information Editor</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" onclick="closeModal()">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php foreach ($paymentDetails as $payment) : ?>
                            <form method="POST">
                                <div class="form-group">
                                    <label for="flname">Full Name: </label>
                                    <input id= "flname" class="form-control" value="<?php echo $payment['fullname']; ?>" readonly>
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
                                    <input id= "or_num" class="form-control" value="<?php echo $payment['or_no']; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="date">Date: </label>
                                    <input id= "date" class="form-control" value="<?php echo $payment['date']; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="total-amount">Total Amount: </label>
                                    <input id= "total-amount" class="form-control" value="<?php echo $payment['total_amount']; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="remarks">Remarks: </label><br>
                                    <textarea type="textarea" class="remarks" id= "remarks" placeholder="Insert a Remarks"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="status">Status: </label>
                                    <input id= "status" class="form-control" value="<?php echo $payment['status']; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="stall-number">Stall Number: </label>
                                    <input id= "stall-number" class="form-control" value="<?php echo $payment['owner_id']; ?>" readonly>
                                </div>
                                <button type="submit" class="btn btn-primary" name="save_changes">Save Changes</button>
                            </form>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script>
            function BackPage(url){
                window.location.href=url;
            }
            // Get the modal
            var modal = document.getElementById("myModal");

            // Function to open the modal
            function openModal(id) {
                modal.style.display = "block";
            }

            // Function to close the modal
            function closeModal() {
                modal.style.display = "none";
            }

            // Close modal if user clicks outside the modal content
            window.onclick = function(event) {
                if (event.target == modal) {
                modal.style.display = "none";
                }
            }

            document.addEventListener('DOMContentLoaded', function() {
                var buttons = document.querySelectorAll('.edit-button');

                buttons.forEach(function(button) {
                    button.addEventListener('click', function() {
                        var idValue = this.getAttribute('data-value');
                        
                        // AJAX request to send the 'idValue' to a PHP script
                        $.ajax({
                            type: "POST",
                            url: "report-overview.php",
                            data: { id: idValue }, // Send the 'idValue' as 'id' in POST data
                            success: function(response) {
                                console.log("Data sent successfully to PHP.");
                                // Handle the response from PHP if needed
                                // console.log("PHP Response: ", response);
                            },
                            error: function(xhr, status, error) {
                                console.error("Error sending data to PHP:", error);
                            }
                        });
                    });
                });
            });
        </script>
    </body>
</html>
