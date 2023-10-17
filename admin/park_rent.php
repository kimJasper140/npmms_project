<?php 
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Parking Rent List</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1 {
            text-align: center;
        }

        table {
            max-width: 95%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0,0,0,0.5);
    }
     /* Modify the text boxes */
     .modal-content input[type="text"],
    .modal-content input[type="number"] {
        width: 80%;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
        font-size: 16px;
    }

    /* Style the "Save" button inside the modal */
    .modal-content button[type="submit"] {
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        padding: 10px 20px;
        cursor: pointer;
        font-size: 16px;
    }

    .modal-content button[type="submit"]:hover {
        background-color: #0056b3;
    }

    .modal-content {
        background-color: #fff;
        margin: 0 auto; /* Center the modal horizontally */
        max-width: 500px; /* Limit the width of the modal content */
        padding: 20px;
        border: 1px solid #888;
        border-radius: 5px; /* Add rounded corners to the modal */
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); /* Add a subtle shadow to the modal */
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

        .search-form {
            margin-top: 20px;
            text-align: center;
        }

        .search-input {
            padding: 5px;
            width: 300px;
        }

        .search-button {
            padding: 5px 15px;
        }

        .add-button {
            margin-top: 20px;
            text-align: right;
        }

        .add-button button {
            padding: 5px 10px;
        }
    </style>
</head>
<?php 
include "topbar.php";
?>
<body>
<div class="container" style="margin-top:5%;">
        <h1 class="text-left mt-3">Daily Parking Rent List</h1>
        <div class="row justify-content-center mt-3">
            <div class="col-md-6">
                <form method="post" action="" class="form-inline justify-content-center">
                    <div class="form-group">
                        <input type="text" name="search_keyword" class="form-control mr-2" placeholder="Search by name or plate no">
                    </div>
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
            </div>
        </div>
    </div>
    <div class="row mt-3">
            <div class="col-md-12">
                <div class="d-flex justify-content-end">
                    <button class="btn btn-success mr-2" onclick="display_add_modal()">Add Entry</button>
                    <button class="btn btn-secondary mr-2" onclick="generateDailyReport()">Generate Daily Report (PDF)</button>
                    <button class="btn btn-danger" onclick="resetTable()">Reset Table</button>
                </div>

<div class="row mt-3">
            <div class="col-md-12">
                    <table class="table table-bordered table-hover" style="margin:3%">
                        <thead>
        <tr>
            <th>Name</th>
            <th>Plate No</th>
            <th>Time In</th>
            <th>Time Out</th>
            <th>Amount</th>
            <th>Remarks</th>
            <th>Action</th>
        </tr>
        <?php
        include "../config/config.php";
         if (isset($_POST["search_keyword"])) {
            $searchKeyword = clean_input($_POST["search_keyword"]);
    
            // Fetch parking rent entries based on the search keyword
            $sql3 = "SELECT * FROM park_rent WHERE 
                    name LIKE '%$searchKeyword%' OR 
                    plate_no LIKE '%$searchKeyword%'";
    
            $resultsearch = mysqli_query($conn, $sql3);
    
            if (mysqli_num_rows( $resultsearch) > 0) {
                while ($row = mysqli_fetch_assoc($resultsearch)) {
                    echo "<tr>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['plate_no'] . "</td>";
                    echo "<td>" . $row['time_in'] . "</td>";
                    echo "<td>" . $row['time_out'] . "</td>";
                    echo "<td>" . $row['amount'] . "</td>";
                    echo "<td>" . $row['remarks'] . "</td>";
                    echo '<td><button class="button"; onclick="display_edit_modal(' . $row['id'] . ',\'' . $row['name'] . '\',\'' . $row['plate_no'] . '\',\'' . $row['time_in'] . '\',\'' . $row['time_out'] . '\',\'' . $row['amount'] . '\',\'' . $row['remarks'] . '\')">Edit</button></td>';
                    echo "</tr>";
                    
                }
            } else {
                echo "<tr><td colspan='7'>No entries found.</td></tr>";
            }
        }
        // Function to escape user inputs
        function clean_input($input)
        {
            global $conn;
            return mysqli_real_escape_string($conn, trim($input));
        }  

        // Function to validate amount input
        function validate_amount($input)
        {
            return is_numeric($input) && $input >= 0;
        }

        // Function to display edit modal with entry data
        function display_edit_modal($entry_id, $name, $plate_no, $time_in, $time_out, $amount, $remarks)
        {
            echo '<script>';
            echo 'document.getElementById("editEntryId").value = ' . $entry_id . ';';
            echo 'document.getElementById("editName").value = "' . $name . '";';
            echo 'document.getElementById("editPlateNo").value = "' . $plate_no . '";';
            echo 'document.getElementById("editTimeIn").value = "' . $time_in . '";';
            echo 'document.getElementById("editTimeOut").value = "' . $time_out . '";';
            echo 'document.getElementById("editAmount").value = "' . $amount . '";';
            echo 'document.getElementById("editRemarks").value = "' . $remarks . '";';
            echo 'document.getElementById("myModal").style.display = "block";';
            echo '</script>';
        }
       
    
        // Process form submissions for adding and editing entries
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST["name"]) && isset($_POST["plate_no"]) && isset($_POST["time_in"]) && isset($_POST["time_out"]) && isset($_POST["amount"])) {
                $name = clean_input($_POST["name"]);
                $plate_no = clean_input($_POST["plate_no"]);
                $time_in = clean_input($_POST["time_in"]);
                $time_out = clean_input($_POST["time_out"]);
                $amount = clean_input($_POST["amount"]);
                $remarks = isset($_POST["remarks"]) ? clean_input($_POST["remarks"]) : "";
        
                // Get the current date
                $currentDate = date('Y-m-d');
        
                // Insert the new entry into the database
                $sql = "INSERT INTO park_rent (name, plate_no, time_in, time_out, amount, remarks, date) VALUES ('$name', '$plate_no', '$time_in', '$time_out', '$amount', '$remarks', '$currentDate')";
                if (mysqli_query($conn, $sql)) {
                    echo "<script>alert('Entry added successfully');</script>";
                } else {
                    echo "<script>alert('Error adding entry: " . mysqli_error($conn) . "');</script>";
                }
                    }
                }
            

            // Process editing an existing entry
            if (isset($_POST["edit_entry_id"]) && isset($_POST["edit_name"]) && isset($_POST["edit_plate_no"]) && isset($_POST["edit_time_in"]) && isset($_POST["edit_time_out"]) && isset($_POST["edit_amount"])) {
                $entry_id = clean_input($_POST["edit_entry_id"]);
                $name = clean_input($_POST["edit_name"]);
                $plate_no = clean_input($_POST["edit_plate_no"]);
                $time_in = clean_input($_POST["edit_time_in"]);
                $time_out = clean_input($_POST["edit_time_out"]);
                $amount = clean_input($_POST["edit_amount"]);
                $remarks = isset($_POST["edit_remarks"]) ? clean_input($_POST["edit_remarks"]) : "";

              
                    // Update the existing entry in the database
                    $sql = "UPDATE park_rent SET name='$name', plate_no='$plate_no', time_in='$time_in', time_out='$time_out', amount='$amount', remarks='$remarks' WHERE id=$entry_id";
                    if (mysqli_query($conn, $sql)) {
                        echo "<script>alert('Entry updated successfully');</script>";
                    } else {
                        echo "<script>alert('Error updating entry: " . mysqli_error($conn) . "');</script>";
                    }
                }
            
        

        // Fetch all parking rent entries
        $sql = "SELECT * FROM park_rent ORDER BY time_in DESC";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['plate_no'] . "</td>";
                echo "<td>" . $row['time_in'] . "</td>";
                echo "<td>" . $row['time_out'] . "</td>";
                echo "<td>" . $row['amount'] . "</td>";
                echo "<td>" . $row['remarks'] . "</td>";
                echo '<td><button onclick="display_edit_modal(' . $row['id'] . ',\'' . $row['name'] . '\',\'' . $row['plate_no'] . '\',\'' . $row['time_in'] . '\',\'' . $row['time_out'] . '\',\'' . $row['amount'] . '\',\'' . $row['remarks'] . '\')">Edit</button></td>';
                echo "</tr>";
            }
        } else {
            echo "<tr> <td colspan='7' >No entries found.</td></tr>";
        }

        // Close the database connection
        mysqli_close($conn);
        ?>
    </table>

    <!-- Modal for adding entry -->
    <div id="addModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeAddModal()">&times;</span>
            <h2>Add Entry</h2>
            <form method="post" action="">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
                <br>
                <label for="plateNo">Plate No:</label>
                <input type="text" id="plateNo" name="plate_no" required>
                <br>
                <label for="timeIn">Time In:</label>
                <input type="text" id="timeIn" name="time_in" >
                <br>
                <label for="timeOut">Time Out:</label>
                <input type="text" id="timeOut" name="time_out" >
                <br>
                <label for="amount">Amount:</label>
                <input type="number" id="amount" name="amount" min="0" step="0.01" >
                <br>
                <label for="remarks">Remarks:</label>
                <input type="text" id="remarks" name="remarks">
                <br>
                <button type="submit">Save</button>
            </form>
        </div>
    </div>

    <!-- Modal for editing entry -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Edit Entry</h2>
            <form method="post" action="">
                <input type="hidden" id="editEntryId" name="edit_entry_id">
                <label for="editName">Name:</label>
                <input type="text" id="editName" name="edit_name" required>
                <br>
                <label for="editPlateNo">Plate No:</label>
                <input type="text" id="editPlateNo" name="edit_plate_no" >
                <br>
                <label for="editTimeIn">Time In:</label>
                <input type="text" id="editTimeIn" name="edit_time_in"  >
                <br>
                <label for="editTimeOut">Time Out:</label>
                <input type="text" id="editTimeOut" name="edit_time_out"   >
                <br>
                <label for="editAmount">Amount:</label>
                <input type="number" id="editAmount" name="edit_amount" min="0" step="0.01" required>
                <br>
                <label for="editRemarks">Remarks:</label>
                <input type="text" id="editRemarks" name="edit_remarks">
                <br>
                <button type="submit">Save</button>
            </form>
        </div>
    </div>

    <script>
        // JavaScript functions for opening and closing the modal
        function display_add_modal() {
            document.getElementById("addModal").style.display = "block";
        }

        function closeAddModal() {
            document.getElementById("addModal").style.display = "none";
        }

        function display_edit_modal(entryId, name, plateNo, timeIn, timeOut, amount, remarks) {
            document.getElementById("editEntryId").value = entryId;
            document.getElementById("editName").value = name;
            document.getElementById("editPlateNo").value = plateNo;
            document.getElementById("editTimeIn").value = timeIn;
            document.getElementById("editTimeOut").value = timeOut;
            document.getElementById("editAmount").value = amount;
            document.getElementById("editRemarks").value = remarks;
            document.getElementById("myModal").style.display = "block";
        }

        function closeModal() {
            document.getElementById("myModal").style.display = "none";
        }
        function generateDailyReport() {
            // Open the "generate_report.php" script in a new window or tab
            window.open('rentdaily_report.php', '_blank');
        }
        function resetTable() {
        if (confirm("Are you sure you want to reset the table? This operation is permanent and will delete all entries.")) {
            // Send an AJAX request to reset the table
            $.ajax({
                type: "POST",
                url: "reset_table.php", // Point to the reset_table.php file
                success: function (response) {
                    if (response === "success") {
                        alert("Table reset successful!");
                        // Reload the page to show an empty table
                        location.reload();
                    } else {
                        alert("Failed to reset table. Please try again.");
                    }
                },
                error: function (xhr, status, error) {
                    console.error(error);
                    alert("An error occurred while resetting the table. Please try again later.");
                }
            });
        }
    }
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</body>
</html>
