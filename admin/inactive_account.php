<?php
include "../config/config.php";
include "checking_user.php";

    ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management | Admin</title>
    <link rel="icon" href="../image/logo.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

</head>
<style>
    

    .table {
        margin-bottom: 0;
        width: 60%;
        margin-left:13% ;
    }

    .modal-dialog {
        max-width: 400px;
    }

    .modal-content {
        padding: 20px;
    }

    body {
        color: #566787;
        background: #f5f5f5;
        font-family: 'Varela Round', sans-serif;
        font-size: 10px;
    }

    .table-responsive {
        margin: 30px 0;
    }

    .table-wrapper {
        min-width: 1000px;
        background: #fff;
        padding: 20px 25px;
        border-radius: 3px;
        box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
    }

    .table-title {
        padding-bottom: 15px;
        background: #299be4;
        color: #fff;
        padding: 16px 30px;
        margin: -20px -25px 10px;
        border-radius: 3px 3px 0 0;
    }

    .table-title h2 {
        margin: 5px 0 0;
        font-size: 24px;
    }

    .table-title .btn {
        color: #566787;
        float: right;
        font-size: 13px;
        background: #fff;
        border: none;
        min-width: 50px;
        border-radius: 2px;
        border: none;
        outline: none !important;
        margin-left: 10px;
    }

    .table-title .btn:hover,
    .table-title .btn:focus {
        color: #566787;
        background: #f2f2f2;
    }

    .table-title .btn i {
        float: left;
        font-size: 21px;
        margin-right: 5px;
    }

    .table-title .btn span {
        float: left;
        margin-top: 2px;
    }

    table.table tr th,
    table.table tr td {
        border-color: #e9e9e9;
        padding: 10px 15px;
        vertical-align: middle;
    }

    table.table tr th:first-child {
        width: 60px;
    }

    table.table tr th:last-child {
        width: 100px;
    }

    table.table-striped tbody tr:nth-of-type(odd) {
        background-color: #fcfcfc;
    }

    table.table-striped.table-hover tbody tr:hover {
        background: #f5f5f5;
    }

    table.table th i {
        font-size: 13px;
        margin: 0 5px;
        cursor: pointer;
    }

    table.table td:last-child i {
        opacity: 0.9;
        font-size: 22px;
        margin: 0 5px;
    }

    table.table td a {
        font-weight: bold;
        color: #566787;
        display: inline-block;
        text-decoration: none;
    }

    table.table td a:hover {
        color: #2196F3;
    }

    table.table td a.settings {
        color: #2196F3;
    }

    table.table td a.delete {
        color: #F44336;
    }

    table.table td i {
        font-size: 19px;
    }

    table.table .avatar {
        border-radius: 50%;
        vertical-align: middle;
        margin-right: 10px;
    }

    .status {
        font-size: 30px;
        margin: 2px 2px 0 0;
        display: inline-block;
        vertical-align: middle;
        line-height: 10px;
    }

    .text-success {
        color: #10c469;
    }

    .text-info {
        color: #62c9e8;
    }

    .text-warning {
        color: #FFC107;
    }

    .text-danger {
        color: #ff5b5b;
    }

    .pagination {
        float: right;
        margin: 0 0 5px;
    }

    .pagination li a {
        border: none;
        font-size: 13px;
        min-width: 30px;
        min-height: 30px;
        color: #999;
        margin: 0 2px;
        line-height: 30px;
        border-radius: 2px !important;
        text-align: center;
        padding: 0 6px;
    }

    .hint-text {
        float: left;
        margin-top: 10px;
        font-size: 13px;
    }
    @media (max-width: 767px) {
            /* Styles for small screens */
            .table {
                width: 100%;
                margin-left: 0;
            }
        }

        @media (max-width: 576px) {
            /* Styles for extra small screens */
            .table-title .btn {
                font-size: 10px;
            }

            /* Adjust other styles as needed */
        }
        .status-active {
            color: green;
        }
        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.2);
            }

            100% {
                transform: scale(1);
            }
        }
</style>

<body>
    
    <?php
    include "../config/config.php";
   include "../admin/sidebar-admin.php";
    // Retrieve users from the database based on search query
    $search = isset($_GET['search']) ? $_GET['search'] : '';
    $sql = "SELECT * FROM user WHERE status = 'inactive' AND (name LIKE '%$search%'  LIKE '%$search%' OR email LIKE '%$search%' OR address LIKE '%$search%' OR username LIKE '%$search%' OR roles LIKE '%$search%' OR designation LIKE '%$search%')";
    $result = $conn->query($sql);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

            if (isset($_POST['deactivateUser'])) {
            // Handle form submission for deactivating a user
            $userId = $_POST['userId'];
            $status = 'active';

            $sql = "UPDATE user SET status='$status' WHERE user_id='$userId'";

            if ($conn->query($sql) === TRUE) {
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
        <h2 class="text-center" style="margin-top:5%;margin-left:-50%;">Inactive Account</h2>
        <div class="text-right mb-3">
            <div class="text-right mb-3">
                <form method="GET" action="">
                    <div class="input-group" style="float:left;">
                        <input type="text" style="margin-left:80%;"class="form-control" name="search" placeholder="Search users...">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                    </div>
                </form>
            </div>

           

        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Designation</th>
                    <th>Status</th>
                    <th style="padding-letf:10px;;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    $count = 1;
                    while ($row = $result->fetch_assoc()) {
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
                            <i class="fas fa-times-circle"></i>
                            </td>
                            <td>
                           
    <button type="button" class="fas fa-check-circle" data-toggle="modal" data-target="#deactivateUserModal<?php echo $row['user_id']; ?>">
        
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
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
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
                } else {
                    echo '<tr><td colspan="9">No Inactive users</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script>
    function logout() {
      // Display a confirmation message
      var confirmed = confirm('Are you sure you want to log out?');

      // If the user confirms, redirect to the logout page
      if (confirmed) {
        window.location.href = '../logout.php';
      }
      else {
        //
      }
    }



  </script>

</body>

</html>
