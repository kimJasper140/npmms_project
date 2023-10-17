<?php
include "config/config.php";
include "config/session.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Data</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f2f2f2;
        }

        h1 {
            text-align: center;
        }

        .table-container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 4px;
            padding: 20px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <h1>View Data</h1>

    <div class="table-container">
        <h2>Stall Information</h2>
        <table id="stallTable" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>Stall ID</th>
                    <th>Stall Number</th>
                    <th>Stall Name</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Owner ID</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $queryStall = "SELECT stall_id, stall_number, stall_name, category, status, owner_id FROM stall";
                $resultStall = mysqli_query($conn, $queryStall);

                if ($resultStall && mysqli_num_rows($resultStall) > 0) {
                    while ($rowStall = mysqli_fetch_assoc($resultStall)) {
                        echo "<tr>";
                        echo "<td>{$rowStall['stall_id']}</td>";
                        echo "<td>{$rowStall['stall_number']}</td>";
                        echo "<td>{$rowStall['stall_name']}</td>";
                        echo "<td>{$rowStall['category']}</td>";
                        echo "<td>{$rowStall['status']}</td>";
                        echo "<td>{$rowStall['owner_id']}</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No stall information found.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <h2>Stall Owner Information</h2>
        <table id="stallOwnerTable" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>Stall No</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Address</th>
                    <th>Email</th>
                    <th>Contact</th>
                    <th>Status</th>
                    <th>User ID</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $queryStallOwner = "SELECT stall_no, name, age, address, email, contact, status, user_id FROM stall_owner";
                $resultStallOwner = mysqli_query($conn, $queryStallOwner);

                if ($resultStallOwner && mysqli_num_rows($resultStallOwner) > 0) {
                    while ($rowStallOwner = mysqli_fetch_assoc($resultStallOwner)) {
                        echo "<tr>";
                        echo "<td>{$rowStallOwner['stall_no']}</td>";
                        echo "<td>{$rowStallOwner['name']}</td>";
                        echo "<td>{$rowStallOwner['age']}</td>";
                        echo "<td>{$rowStallOwner['address']}</td>";
                        echo "<td>{$rowStallOwner['email']}</td>";
                        echo "<td>{$rowStallOwner['contact']}</td>";
                        echo "<td>{$rowStallOwner['status']}</td>";
                        echo "<td>{$rowStallOwner['user_id']}</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No stall owner information found.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <h2>Stall Owner Contract Information</h2>
        <table id="contractTable" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>Stall Owner ID</th>
                    <th>Contract Date</th>
                    <th>Contract Start Date</th>
                    <th>Contract End Date</th>
                    <th>Contract Terms</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $queryContract = "SELECT stall_owner_id, contract_date, contract_start_date, contract_end_date, contract_terms FROM stall_owner_contract";
                $resultContract = mysqli_query($conn, $queryContract);

                if ($resultContract && mysqli_num_rows($resultContract) > 0) {
                    while ($rowContract = mysqli_fetch_assoc($resultContract)) {
                        echo "<tr>";
                        echo "<td>{$rowContract['stall_owner_id']}</td>";
                        echo "<td>{$rowContract['contract_date']}</td>";
                        echo "<td>{$rowContract['contract_start_date']}</td>";
                        echo "<td>{$rowContract['contract_end_date']}</td>";
                        echo "<td>{$rowContract['contract_terms']}</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No stall owner contract information found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            $('#stallTable, #stallOwnerTable, #contractTable').DataTable();
        });
    </script>
</body>
</html>
