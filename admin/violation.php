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
    

</head>

<body>
    <?php
    
    include "topbar.php";
    ?>
    <div class="container mt-5">
        <h1 style="margin-top:7%;">Violation Report</h1>
        <hr>
        <table class="table table-bordered table-striped table-hover">
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
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.3/datatables.min.css" rel="stylesheet" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.3/datatables.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('table').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf'
                ],
                searching: true,
                ordering: false,
                paging: true,

            })

        })
    </script>
    
</body>

</html>
