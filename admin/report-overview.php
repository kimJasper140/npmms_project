<?php 
require_once '../config/config.php';
session_start();
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
                        <?php 
                        if (isset($_GET['month'])) {
                            // Get the 'id' parameter value from the URL
                            $id = $_GET['month'];
                            $sql = "SELECT * FROM monthly_payment_details WHERE month='$id'";       
                            $_SESSION["sql"] = $sql;
                        }

                        if(isset($_SESSION['sql'])) {
                            $sql = $_SESSION['sql'];
                            $dataResult = mysqli_query($conn, $sql);
                            while ($payment = mysqli_fetch_assoc($dataResult)){   
                                echo "<tr>";
                                echo "<td>".$payment['fullname']."</td>";
                                echo "<td>".$payment['monthly_rental']."</td>";
                                echo "<td>".$payment['extension_rental']."</td>";
                                echo "<td>".$payment['stall_extension_fee']."</td>";
                                echo "<td>".$payment['penalty_25'] . "</td>";
                                echo "<td>".$payment['interest_2']."</td>";
                                echo "<td>".$payment['or_no']."</td>";
                                echo "<td>".$payment['date']."</td>";
                                echo "<td>".$payment['total_amount']."</td>";
                                echo "<td>".$payment['remarks']."</td>";
                                echo "<td>".$payment['status']."</td>";
                                echo "<td>".$payment['owner_id']."</td>";
                                echo "<td>";
                                echo "<button type='button' onclick='' class='edit-button btn btn-success' data-id=". $payment['id'] .">Print</button>";
                                echo "<button type='button' onclick='openModal(this)' class='edit-button btn btn-warning' data-id=". $payment['id'] .">Edit</button>";
                                echo "<button type='button' onclick='deleteData(this)' class='btn btn-danger' data-id=". $payment['id'] .">Delete</button>";  
                                echo "</td>";
                                echo "</tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Report Editing Modal -->
        <div class="modal scroll" id="myModal" tabindex="-1" role="dialog" aria-labelledby="reportEditModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="reportEditModalLabel">Information Editor</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" onclick="closeModal()">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="paymentDetailsContent">
                        <!--This is where the modal contents will appear from get_payment_data.php-->
                    </div>
                </div>
            </div>
        </div>

        <!-- Report Deletion Modal -->
        <div class="modal" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="reportDeleteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="reportDeleteModalLabel">Information Editor</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" onclick="closeModal()">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="edit-handler.php" method="post">
                            <input type="hidden" name="paymentId" id="payment_id">
                            <h6>Deleting this data will be permanent and non-recoverable. Are you sure you want to delete it?</h6>
                            <input type="submit" class='btn btn-danger' name="delete">
                            <button type="button" class='btn btn-success' onclick="closeModal()">Cancel</button>
                        </form>
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
            var _modal = document.getElementById("deleteModal");

            // Function to open the modal
            function openModal(button) {
                sendEditRequest(button);
                modal.style.display = "block";
            }

            // Function to close the modal
            function closeModal() {
                modal.style.display = "none";
                _modal.style.display = "none";
            }

            function deleteData(button){
                _modal.style.display = "block";
                var paymentId = button.getAttribute('data-id'); // Get the payment ID from data-id attribute
                document.getElementById("payment_id").value = paymentId;
            }

            // Close modal if user clicks outside the modal content
            window.onclick = function(event) {
                if (event.target == modal) {
                modal.style.display = "none";
                }
            }

            function sendEditRequest(button) {
                var paymentId = button.getAttribute('data-id'); // Get the payment ID from data-id attribute

                // AJAX request to send data to PHP
                $.ajax({
                        type: 'POST',
                        url: 'get_payment_data.php', // Replace with your PHP file to retrieve payment details
                        data: { payment_id: paymentId }, // Replace 'your_payment_id' with the actual payment ID
                        success: function(response) {
                            // Inject the retrieved form content into the modal body
                            $('#paymentDetailsContent').html(response);
                        },
                        error: function() {
                            alert('Error occurred while fetching payment details.');
                        }
                    });
            }
        </script>
    </body>
</html>
