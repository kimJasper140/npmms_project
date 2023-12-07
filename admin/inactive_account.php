<?php
include "../config/config.php";
include "checking_user.php";
include "../admin/sidebar/sidebar.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management | Admin</title>
    <link rel="icon" href="../image/logo.ico" type="image/x-icon">
    <style>
        @media (max-width: 776px) {
            .table {}
        }
    </style>
</head>

<body>

    <?php
    include "../config/config.php";
    //include "../admin/sidebar-admin.php";
    // Retrieve users from the database based on search query
    $sql = "SELECT * FROM user WHERE status = 'inactive'";
    $result = $conn->query($sql);

    if($_SERVER["REQUEST_METHOD"] == "POST") {

        if(isset($_POST['deactivateUser'])) {
            // Handle form submission for deactivating a user
            $userId = $_POST['userId'];
            $status = 'active';

            $sql = "UPDATE user SET status='$status' WHERE user_id='$userId'";

            if($conn->query($sql) === TRUE) {
                echo "<script>alert('User Activated successfully');</script>";
                echo "<script>window.location.href = '{$_SERVER['PHP_SELF']}';</script>";
            } else {
                echo "<script>alert('Error: ');</script>";
            }

        } else {
            echo "<script>alert('Error:');</script>";
        }
    }



    ?>

    <div class="container">
        <h2 class="text-center">Inactive Account</h2>
        <div class="text-right mb-3">




        </div>
        <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Designation</th>

                        <th style="padding-letf:10px;;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if($result->num_rows > 0) {
                        $count = 1;
                        while($row = $result->fetch_assoc()) {
                            ?>
                            <tr>
                                <td>
                                    <?php echo $count; ?>
                                </td>
                                <td>
                                    <?php echo $row['name']; ?>
                                </td>
                                <td>
                                    <?php echo $row['email']; ?>
                                </td>
                                <td>
                                    <?php echo $row['address']; ?>
                                </td>
                                <td>
                                    <?php echo $row['username']; ?>
                                </td>
                                <td>
                                    <?php echo $row['roles']; ?>
                                </td>
                                <td>
                                    <?php echo $row['designation']; ?>
                                </td>
                                <td>

                                    <button type="button" class="fas fa-check-circle" data-toggle="modal"
                                        data-target="#deactivateUserModal<?php echo $row['user_id']; ?>">
                                        Activate
                                    </button>
                                </td>
                            </tr>



                            <!-- Deactivate User Modal -->
                            <div id="deactivateUserModal<?php echo $row['user_id']; ?>" class="modal fade">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form method="post">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Activate User</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-hidden="true">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Are you sure you want to Activate this user?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <input type="hidden" name="userId" value="<?php echo $row['user_id']; ?>">
                                                <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">Cancel</button>
                                                <button type="submit" name="deactivateUser"
                                                    class="btn btn-danger">Activate</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <?php
                            $count++;
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <link href="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.3/datatables.min.css" rel="stylesheet" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.3/datatables.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('table').DataTable({
                dom: 'Bfrtip',

                searching: true,
                ordering: false,
                paging: true,


            })

        })
    </script>




    <script src="sidebar/js/popper.js"></script>
    <script src="sidebar/js/bootstrap.min.js"></script>
    <script src="sidebar/js/main.js"></script>


</body>

</html>