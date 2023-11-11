<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Other-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.3/datatables.min.css" rel="stylesheet" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.3/datatables.min.js"></script>
    
    <title>Stall Owner Management</title>
</head>
<?php 
  // Include necessary files and configurations
  include "../config/config.php";
  include "checking_user.php";

  $sql = "SELECT id, stall_no, name, age, address, email, contact, status, user_id FROM stall_owner WHERE status = 'operate'";
  $result = $conn->query($sql);

?>
<body>
<?php 
include "topbar.php";
?>
    <div class="container" style="margin-top:50px;">
        <div class="row justify-content-center">
            <div class="col-lg bg-light rounded my-2 py-2">
                <h2 class="text-center text-success pt-2"><b>Stall Owner Management</b></h2>
                <hr>
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                    <tr>
        <th>ID</th>
        <th>Stall Number</th>
        <th>Name</th>
        <th>Age</th>
        <th>Address</th>
        <th>Email</th>
        <th>Contact</th>
        <th>Status</th>
        <th>User ID</th>
        <th>Action</th>
    </tr>
                    </thead>

                    <tbody>
                    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['stall_no'] . "</td>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['age'] . "</td>";
            echo "<td>" . $row['address'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
            echo "<td>" . $row['contact'] . "</td>";
            echo "<td>" . $row['status'] . "</td>";
            echo "<td>" . $row['user_id'] . "</td>";
            echo "<td>";
            echo "<a class='btn btn-primary' href='edit_stall_owner.php?id=" . $row['id'] . "'>Edit</a>  ";
            echo "<a class='btn btn-warning' href='terminate_stall_owner.php?id=" . $row['id'] . "'>Terminate</a>  ";
            echo "<a class='btn btn-danger' href='view_violations.php?stall_owner_id=". $row['id']."'>Violations</a> "; // Add this line for View 
            echo "<a class='btn btn-success' href='view_contract.php?stall_owner_id=" . $row['id'] . "'>Contract</a>   "; // Add this line for View 
            echo "<a class='btn btn-info' href='close_stall.php?id=" . $row['id'] . "'>Close</a>   "; // Add this line for View 
            
            
            echo "</td>";
            echo "</tr>";
        }
    } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

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
               

            })

        })
    </script>
</body>

</html>