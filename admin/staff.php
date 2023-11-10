<?php
include "checking_user.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

  
    <title>staff User List</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
    .user-profile-image {
            max-width: 100px;
            max-height: 100px;
            border-radius: 50px;
        }

        .no-image {
            color: red;
            font-style: italic;
        }
    </style>
</head>
<body>
    <?php
include "topbar.php";
    ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg bg-light rounded my-2 py-2">
                <h2 class="text-center text-success pt-2"><b>Staff List User</b></h2>
                <hr>
              
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr class="text-center">
                          
                            <th>User ID</th>
            <th>Profile</th>
            <th>Name</th>
            <th>Email</th>
            <th>Address</th>
            <th>Username</th>
            
            <th>Roles</th>
            <th>Designation</th>
            <th>Status</th>
                            </th>
                        </tr>
                    </thead>
                    
                    <tbody>
                    <?php
         Include "../config/config.php";// to connect to the database

        // Fetch staff user data from the database with 'roles' set to 'staff'
        $sql = "SELECT * FROM user WHERE roles = 'staff'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['user_id'] . "</td>";
                if ($row['profile']) {
                    echo "<td><img src='" . $row['profile'] . "' alt='Profile Image' style='max-width: 100px; max-height: 100px;'></td>";
                } else {
                    echo "<td class='text-center'>No Image</td>";
                }
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['address'] . "</td>";
                echo "<td>" . $row['username'] . "</td>";
              
                echo "<td>" . $row['roles'] . "</td>";
                echo "<td>" . $row['designation'] . "</td>";
                echo "<td>" . $row['status'] . "</td>";
               
                echo "</tr>";
            }
        }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
      <!-- Other-->
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