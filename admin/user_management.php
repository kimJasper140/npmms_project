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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    </head>
    
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
    <body>

    <?php
    function isValidName($name_) {
        return preg_match("/^[A-Za-z\-\'\s]+$/", $name_);
    }
    function isValidPassword($password_){
        if (strlen($password_) < 8) {
            return false;
        }
        if (!preg_match('/[A-Z]/', $password_)) {
            return false;
        }
        if (!preg_match('/[a-z]/', $password_)) {
            return false;
        }

        if (!preg_match('/\d/', $password_)) {
            return false;
        }
        if (!preg_match('/[^A-Za-z0-9]/', $password_)) {
            return false;
        }
        return true;
    }

    include "../config/config.php";
    //include "../admin/sidebar-admin.php";

    $sql = "SELECT * FROM user where status = 'active'";
    $result = $conn->query($sql);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['addUser'])) {
            // Handle form submission for adding a user
            $name = $_POST['name'];
            $email = $_POST['email'];
            $address = $_POST['address'];
            $username = $_POST['username'];
            $password = $_POST['password'];
            $role = $_POST['role'];
            $designation = $_POST['designation'];
            $status = 'active';
            $dateCreated = date('Y-m-d H:i:s');

            if (isValidName($name)){
                if(isValidPassword($password)){
                    $email_sql = "SELECT * FROM user WHERE email = '$email'";
                    $result = $conn->query($email_sql);
                    if($result->num_rows == 0){
                        $uname_sql = "SELECT * FROM user WHERE username = '$username'";
                        $uname_res = $conn->query($uname_sql);
                        if($uname_res->num_rows == 0){
                            $sql = "INSERT INTO user (name, email, address, username, password, roles, designation, status, dateCreated)
                            VALUES ('$name', '$email', '$address', '$username', '$password', '$role', '$designation', '$status', '$dateCreated')";
                            if ($conn->query($sql) === TRUE){
                                echo "<script>alert('User added successfully');</script>";
                                echo "<script>window.location.href = '{$_SERVER['PHP_SELF']}';</script>";
                            }else {
                                echo "<script>alert('Error: ' . $conn->error);</script>";
                            }
                        }else {
                            echo "<script>alert('Username had been already taken. Please use another username.');</script>";
                            echo "<script>window.location.href = '{$_SERVER['PHP_SELF']}';</script>";
                        }

                    } else {
                        echo "<script>alert('Email already exists');</script>";
                        echo "<script>window.location.href = '{$_SERVER['PHP_SELF']}';</script>";
                    }
                }else {
                    echo "<script>alert('Invalid Password Format');</script>";
                    echo "<script>window.location.href = '{$_SERVER['PHP_SELF']}';</script>";
                }
            } else {
                echo "<script>alert('Invalid name format');</script>;";
                echo "<script>window.location.href = '{$_SERVER['PHP_SELF']}';</script>";
            }
        } elseif (isset($_POST['deactivateUser'])) {
            // Handle form submission for deactivating a user
            $userId = $_POST['userId'];
            $status = 'inactive';

            $sql = "UPDATE user SET status='$status' WHERE user_id='$userId'";

            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('User deactivated successfully');</script>";
                echo "<script>window.location.href = '{$_SERVER['PHP_SELF']}';</script>";
            } else {
                echo "<script>alert('Error: ' . $conn->error);</script>";
            }
        } elseif (isset($_POST['editUser'])) {
            // Handle form submission for editing a user
            $userId = $_POST['userId'];
            $name = $_POST['name'];
            $email = $_POST['email'];
            $address = $_POST['address'];
            $username = $_POST['username'];
            $role = $_POST['role'];
            $designation = $_POST['designation'];

            $sql = "UPDATE user SET name='$name', email='$email', address='$address', username='$username', roles='$role', designation='$designation' WHERE user_id='$userId'";

            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('User updated successfully');</script>";
                echo "<script>window.location.href = '{$_SERVER['PHP_SELF']}';</script>";
            } else {
                echo "<script>alert('Error: ' . $conn->error);</script>";
            }
        }
    }
    ?>

        <div class="container mt-5"">
            <h2 style="margin-left:10%;">User Management</h2>
            <div class="text-right mb-3">
                <div class="text-right mb-3">
                   
                </div>

                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addUserModal">
                    <i class="fas fa-plus"></i> Create Account
                </button>

            </div>
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
                        <th>Status</th>
                        <th class="action-column">Action</th>
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
                                    <i class="fas fa-circle status-inactive success"></i>
                                    <?php echo $row['status']; ?>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-action" data-toggle="modal"
                                        data-target="#editUserModal<?php echo $row['user_id']; ?>">
                                        <i class="fas fa-edit fa-xs"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-action" data-toggle="modal"
                                        data-target="#deactivateUserModal<?php echo $row['user_id']; ?>">
                                        <i class="fas fa-times fa-xs"></i>
                                    </button>
                                </td>
                            </tr>

                           
                           <!-- Edit User Modal -->
<div id="editUserModal<?php echo $row['user_id']; ?>" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post">
                <div class="modal-header">
                    <h4 class="modal-title">Edit User</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" value="<?php echo $row['name']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" value="<?php echo $row['email']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <input type="text" class="form-control" name="address" value="<?php echo $row['address']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" class="form-control" name="username" value="<?php echo $row['username']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Role</label>
                        <select class="form-control" name="role" disabled>
                            <option value="">Select Role</option>
                            <option value="Admin" <?php if ($row['roles'] == 'admin') echo 'selected'; ?>>Admin</option>
<option value="Staff" <?php if ($row['roles'] == 'Staff' || $row['roles'] == 'staff') echo 'selected'; ?>>Staff</option>
<option value="Stall Owner" <?php if ($row['roles'] == 'stall_owner' || $row['roles'] == 'Stall_Owner') echo 'selected'; ?>>Stall Owner</option>

                        </select>
                    </div>
                    <div class="form-group">
                        <label>Designation</label>
                        <input type="text" class="form-control" name="designation" value="<?php echo $row['designation']; ?>" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="userId" value="<?php echo $row['user_id']; ?>">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" name="editUser" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>


                            <!-- Deactivate User Modal -->
                            <div id="deactivateUserModal<?php echo $row['user_id']; ?>" class="modal fade">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form method="post">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Deactivate User</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-hidden="true">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Are you sure you want to deactivate this user?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <input type="hidden" name="userId" value="<?php echo $row['user_id']; ?>">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                <button type="submit" name="deactivateUser"
                                                    class="btn btn-danger ">Deactivate</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <?php
                            $count++;
                        }
                    } else {
                        echo '<tr><td colspan="9">No users found</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Add User Modal -->
        <div id="addUserModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="post">
                        <div class="modal-header">
                            <h4 class="modal-title">Add New User</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" id ="name_" class="form-control" name="name" required>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" id = "email_" class="form-control" name="email" required>
                            </div>
                            <div class="form-group">
                                <label>Address</label>
                                <input type="text" class="form-control" name="address" required>
                            </div>
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" class="form-control" name="username" required>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" id="pass_" class="form-control" name="password" required>
                            </div>
                            <div class="form-group">
                                <label>Role</label>
                                <select class="form-control" name="role" required>
                                    <option value="">Select Role</option>
                                    <option value="Admin">Admin</option>
                                    <option value="staff">Staff</option>
                                    <option value="stall_owner">Stall Owner</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Designation</label>
                                <input type="text" class="form-control" name="designation" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" name="addUser" class="btn btn-primary">Add User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet" />
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

 


    </body>

    </html>
