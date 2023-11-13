<?php
include "../config/config.php";
include "../config/session.php";
if (!isset($_SESSION['username']) && $_SESSION['roles'] != 'admin'){
    header("location:../index.php");
    session_destroy();

}


// Retrieve records for the current page
$query = "SELECT * FROM applications WHERE status = 'declined'";
$applicationsResult = mysqli_query($conn, $query);
?>
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
    
    <title>Declined Application</title>
</head>

<body>
    
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg bg-light rounded my-2 py-2">
                <h2 class="text-center text-success pt-2"><b>Declined Applications</b></h2>
                <hr>
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                    <?php if (mysqli_num_rows($applicationsResult) > 0) { ?>
                        <tr class="text-center">
                        <th>Name</th>
                <th>Stall No</th>
                <th>Age</th>
                <th>Address</th>
                <th>Email</th>
                <th>Contact</th>
                <th>Status</th>
                <th>Remarks</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php while ($row = mysqli_fetch_assoc($applicationsResult)) { ?>
            <tr>
                
                <td><?php echo $row['applicant_name']; ?></td>
                <td><?php echo $row['stall_no2']; ?></td>
                <td><?php echo $row['applicant_age']; ?></td>
                <td><?php echo $row['applicant_address']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['contact']; ?></td>
                <td><?php echo $row['status']; ?></td>
                <td><?php echo $row['remarks']; ?></td>
               
            </tr>
        <?php } } else {
                    echo "No data available";
        }
            ?>
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
                ordering: false,
                paging: true,

            })

        })
    </script>
</body>

</html>