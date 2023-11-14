<?php
// Replace the database connection details with your actual credentials
include "../config/config.php";
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cancelled Applications</title>
    
   
</head>
<body>

    <div class="container mt-4" >
        <h2>Cancelled Applications</h2>
        <hr>
        <br>
        <?php
        // SQL query to retrieve all applications with the status "cancelled"
        $sql = "SELECT id, stall_no, name, age, address, applicant_name, stall_no2, applicant_age, applicant_address, 
                       tax_certificate_issued_location, tax_certificate_issued_date, sworn_at, email, contact, status, 
                       remarks, user_id, owner_id 
                FROM applications 
                WHERE status = 'cancel'";
        // Execute the query
        $result = $conn->query($sql);
       ?>
        <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr class="text-center">
                               <td>Application ID</td>
                               <td>Name</td>
                               <td>Stall No</td>
                               <td>Status</td>
                               <td>Remark</td>

                            </th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {?>
                    <td>
                                    <?php echo $row['id']; ?>
                                </td>
                                <td>
                                    <?php echo $row['name']; ?>
                                </td>
                                <td>
                                    <?php echo $row['stall_no']; ?>
                                </td>
                                <td>
                                    <?php echo $row['status']; ?>
                                </td>
                                <td>
                                    <?php echo $row['remarks']; ?>
                                </td>
                               <?php }}?>

                    </tbody>
                </table>
    </div>

   
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
                ordering: true,
                paging: true,
                "order": [
                    [1, "desc"]
                ],

            })

        })
    </script>

</body>
</html>
