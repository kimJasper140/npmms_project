<?php
require_once "../config/config.php";
require_once "../tcpdf/tcpdf.php"; // Replace with the path to TCPDF library
session_start();

// Fetch violation data and stall owner name from the database using a JOIN
$sql = "SELECT v.violation_id, v.violation_type, v.description, v.stall_owner_id, so.name AS stall_owner_name, 
               v.violation_date, v.stall_number, v.appeal, v.remarks, v.remediation
        FROM violation v
        JOIN stall_owner so ON v.stall_owner_id = so.id";

$result = $conn->query($sql);

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Violation Report</title>
    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Add necessary CSS and JS libraries for DataTables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
</head>

<body>
    <?php
    
    include "topbar.php";
    ?>
    <div class="container mt-5">
        <h1 style="margin-top:7%;">Violation Report</h1>
        <table id="violationTable" class="table table-bordered">
            <thead>
                <tr>
                    <th>Violation ID</th>
                    <th>Owner Name</th>
                    <th>Violation Type</th>
                    <th>Description</th>
                    <th>Stall Owner ID</th>
                    <th>Violation Date</th>
                    
                    <th>Appeal</th>
                    <th>Remarks</th>
                    <th>Remediation</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['violation_id'] . "</td>";
                        echo "<td>" . $row['stall_owner_name'] . "</td>";
                        echo "<td>" . $row['violation_type'] . "</td>";
                        echo "<td>" . $row['description'] . "</td>";
                        echo "<td>" . $row['stall_owner_id'] . "</td>";
                        echo "<td>" . $row['violation_date'] . "</td>";
                        
                        echo "<td>" . $row['appeal'] . "</td>";
                        echo "<td>" . $row['remarks'] . "</td>";
                        echo "<td>" . $row['remediation'] . "</td>";
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>
        </table>

        <!-- Button to generate PDF -->
        <form method="post" action="generate_pdf.php">
            <input type="hidden" name="data" value='<?php echo json_encode($result->fetch_all(MYSQLI_ASSOC)); ?>' />
            <button class="btn btn-primary" type="submit">Generate PDF</button>
        </form>
    </div>

    <!-- Add Bootstrap JS link -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
