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

        /* Styling for modal */
        .modal {
        display: none; /* Hide modal by default */
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0,0,0,0.5); /* Semi-transparent background */
        }
        .modal-content {
        background-color: #fff;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
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
        <button type="button" class="btn btn-success" onclick="BackPage('payment_reports.php')">Back</button>
        <div class="container" style="margin-top:5%;">
            <h2 class="mt-4">Edit Report</h2>
            <?php
                require_once '../config/config.php';
                session_start();

                if (isset($_GET['month'])) {
                    // Get the 'id' parameter value from the URL
                    $id = $_GET['month'];
                    
                    $sql = "SELECT * FROM monthly_payment_details WHERE month='$id'";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        // Output data of each row
                        echo "<table border='1'>";
                        echo "<tr><th>ID</th>";
                        echo "<th>Fullname</th>";
                        echo "<th>Monthly Rental</th>";
                        echo "<th>Extension Rental</th>";
                        echo "<th>Stall Extension Fee</th>";
                        echo "<th>Penalty</th>";
                        echo "<th>Interest</th>";
                        echo "<th>OR Number</th>";
                        echo "<th>Date</th>";
                        echo "<th>Total Amount</th>";
                        echo "<th>Remarks</th>";
                        echo "<th>Status</th>";
                        echo "<th>Stall Number</th>";
                        echo "<th>Action</th></tr>";
                    
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr><td>" . $row["id"] . "</td>";
                            echo "<td>". $row["fullname"] . "</td>";
                            echo "<td>". $row["monthly_rental"] . "</td>";
                            echo "<td>". $row["extension_rental"] . "</td>";
                            echo "<td>". $row["stall_extension_fee"] . "</td>";
                            echo "<td>". $row["penalty_25"] . "</td>";
                            echo "<td>". $row["interest_2"] . "</td>";
                            echo "<td>" . $row["or_no"] . "</td>";
                            echo "<td>" . $row["date"] . "</td>";
                            echo "<td>" . $row["total_amount"] . "</td>";
                            echo "<td>" . $row["remarks"] . "</td>";
                            echo "<td>" . $row["status"] . "</td>";
                            echo "<td>" . $row["owner_id"] . "</td>";
                            echo "<td>" . "<button class= 'btn btn-success' onclick=openModal(" . $row["id"] .")>Edit</button>" . "<button class= 'btn btn-success'>Delete</button>" ."</td></tr>";
                        }
                    
                        echo "</table>";
                    } else {
                        echo "<h2>No Table Found</h2>";
                    }
                } else {
                    echo "ID parameter is missing.";
                }
            ?>
        </div>
        <div id="myModal" class="modal">
            <!-- Modal content -->
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <div id="modalContent">
                    <form method="POST">
                        <label for="flname">Fullname: </label>
                        <input id= "flname" readonly><br>
                        <label for="monrent">Monthly Rental: </label>
                        <input id= "monrent"><br>
                        <label for="extrent">Extension Rental: </label>
                        <input id= "extrent" ><br>
                        <label for="stall-fee">Stall Extension Fee: </label>
                        <input id= "stall-fee" ><br>
                        <label for="penalty">Penalty: </label>
                        <input id= "penalty" ><br>
                        <label for="rental">Rental: </label>
                        <input id= "rental" ><br>
                    </form>
                </div>
            </div>
        </div>

        <script>
            function BackPage(url){
                window.location.href=url;
            }
            // Get the modal
            var modal = document.getElementById("myModal");

            // Function to open the modal
            function openModal(id) {
                modal.style.display = "block";
                // You can use AJAX with PHP to fetch dynamic content here
                // For simplicity, it's empty in this example
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
        </script>
    </body>
</html>
