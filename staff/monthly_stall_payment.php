<?php
include "../config/session.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>List of Stall Owners</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        table, th, td {
            border: 1px solid black;
            padding: 8px;
        }
        
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>List of Stall Owners</h1>
    <table>
        <tr>
            <th>Stall Number</th>
            <th>Owner Name</th>
            <th>Monthly Rental</th>
            <th>Stall Extension</th>
            <th>Payment Monthly Rental</th>
            <th>Stall Extension Fee</th>
            <th>Penalty 25%</th>
            <th>Interest 2%</th>
            <th>OR No.</th>
            <th>Date</th>
            <th>Total Amount</th>
            <th>Remarks</th>
        </tr>
        <?php
        include "../config/config.php";

        // Function to update the stall owner's details
        function updateStallOwnerDetails($conn, $owner_id, $payment_monthly_rental, $stall_extension_fee, $remarks, $date) {
            $payment_monthly_rental = (float) $payment_monthly_rental;
            $stall_extension_fee = (float) $stall_extension_fee;

            // Calculate the total_amount
            $total_amount = $payment_monthly_rental + $stall_extension_fee;

            // Update the payment_monthly_rental, stall_extension_fee, total_amount, remarks, and date in the database
            $sql = "UPDATE stall_owner SET payment_monthly_rental = $payment_monthly_rental, stall_extension_fee = $stall_extension_fee, total_amount = $total_amount, remarks = '$remarks', date = '$date' WHERE owner_id = $owner_id";

            if ($conn->query($sql) === TRUE) {
                return true;
            } else {
                return false;
            }
        }

        // Fetch and display the list of stall owners with stall numbers
        $sql = "SELECT so.*, s.stall_number
                FROM stall_owner so
                INNER JOIN stall s ON so.owner_id = s.owner_id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['stall_number'] . "</td>";
                echo "<td>" . $row['owner_name'] . "</td>";
                echo "<td>" . $row['monthly_rental'] . "</td>";
                echo "<td>" . $row['stall_extension'] . "</td>";
                echo "<td><input type='number' name='payment_monthly_rental[]' value='" . (isset($row['payment_monthly_rental']) ? $row['payment_monthly_rental'] : "") . "'></td>";
                echo "<td><input type='number' name='stall_extension_fee[]' value='" . (isset($row['stall_extension_fee']) ? $row['stall_extension_fee'] : "") . "'></td>";
                echo "<td>" . $row['penalty_25%'] . "</td>";
                echo "<td>" . $row['interest_2%'] . "</td>";
                echo "<td>" . (isset($row['or_no']) ? $row['or_no'] : "") . "</td>";
                echo "<td><input type='date' name='date[]' value='" . $row['date'] . "'></td>";

                // Calculate the total_amount
                $total_amount = (isset($row['payment_monthly_rental']) ? $row['payment_monthly_rental'] : 0) + (isset($row['stall_extension_fee']) ? $row['stall_extension_fee'] : 0);
                echo "<td>" . $total_amount . "</td>";

                echo "<td><input type='text' name='remarks[]' value='" . $row['remarks'] . "'></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='12'>No stall owners found.</td></tr>";
        }

        // Handle form submission and update the stall owner's details
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $owner_ids = $_POST['owner_id'];
            $payment_monthly_rentals = $_POST['payment_monthly_rental'];
            $stall_extension_fees = $_POST['stall_extension_fee'];
            $remarks = $_POST['remarks'];
            $dates = $_POST['date'];

            // Loop through the submitted data and update each stall owner's details
            foreach ($owner_ids as $key => $owner_id) {
                $payment_monthly_rental = isset($payment_monthly_rentals[$key]) ? $payment_monthly_rentals[$key] : "";
                $stall_extension_fee = isset($stall_extension_fees[$key]) ? $stall_extension_fees[$key] : "";
                $remark = isset($remarks[$key]) ? $remarks[$key] : "";
                $date = isset($dates[$key]) ? $dates[$key] : "";

                if (updateStallOwnerDetails($conn, $owner_id, $payment_monthly_rental, $stall_extension_fee, $remark, $date)) {
                    echo "<script>alert('Stall owner details updated successfully.');</script>";
                    echo "<script>window.location.href = 'list_of_stall_owners.php';</script>";
                } else {
                    echo "<script>alert('Failed to update stall owner details.');</script>";
                }
            }
        }
        ?>
    </table>

    <!-- Form to handle updating stall owner's details -->
    <form method="POST">
        <?php
        // Re-fetch the list of stall owners to populate the hidden input fields
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<input type='hidden' name='owner_id[]' value='" . $row['owner_id'] . "'>";
            }
        }
        ?>
        <input type="submit" value="Update">
    </form>
</body>
</html>
