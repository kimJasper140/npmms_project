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
       
        

    </head>
   
  <script>

    function checkNameValidity() {
            var name = document.getElementById("name_").value;
            var nameMessage = document.getElementById("nameValidity");

            // Reset the message
            nameMessage.innerHTML = '';

            // Define the regular expression for name validation
            var nameRegex = /^[A-Za-z\-\'\s]+$/;

            // Check the condition and update the message
            if (!name.match(nameRegex)) {
                nameMessage.innerHTML = 'Invalid name format. Please use letters, hyphens, apostrophes, and spaces only.';
                nameMessage.style.color = 'red';
            }
        }
    
        function checkPasswordStrength() {
            var password = document.getElementById("pass_").value;
            var strengthMessage = document.getElementById("passwordStrength");

            // Reset the message
            strengthMessage.innerHTML = '';

            // Define the regular expressions for password strength
            var upperCaseRegex = /[A-Z]/g;
            var lowerCaseRegex = /[a-z]/g;
            var digitRegex = /\d/g;
            var specialCharRegex = /[^A-Za-z0-9]/g;

            // Check conditions and update the message
            if (password.length < 8) {
                strengthMessage.innerHTML += 'Password must be at least 8 characters. ';
            }
            if (!password.match(upperCaseRegex)) {
                strengthMessage.innerHTML += 'Uppercase letter is required. ';
            }
            if (!password.match(lowerCaseRegex)) {
                strengthMessage.innerHTML += 'Lowercase letter is required. ';
            }
            if (!password.match(digitRegex)) {
                strengthMessage.innerHTML += 'Digit is required. ';
            }
            if (!password.match(specialCharRegex)) {
                strengthMessage.innerHTML += 'Special character is required. ';
            }

            // Display the message with appropriate styling
            if (strengthMessage.innerHTML !== '') {
                strengthMessage.style.color = 'red';
            } else {
                strengthMessage.innerHTML = 'Password strength is good.';
                strengthMessage.style.color = 'green';
            }
        }
  </script>
    <body>
    
    <?php
    include "../admin/sidebar/sidebar.php";
    ?>
    
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
                            echo "<script>alert('Username had been already taken. Please use another username And Try Again');</script>";
                            echo "<script>window.location.href = '{$_SERVER['PHP_SELF']}';</script>";
                        }

                    } else {
                        echo "<script>alert('Email already exists please Try Another Email ');</script>";
                        echo "<script>window.location.href = '{$_SERVER['PHP_SELF']}';</script>";
                    }
                }else {
                   
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

        
            <h2>User Management</h2>
            <div class="text-right mb-3">
                <div class="text-right mb-3">
                   
                </div>

                <button type="button"  class="btn btn-secondary" data-toggle="modal" data-target="#addUserModal">
                    <i class="bi bi-plus"></i> Create Account
                </button>

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
                                    <button type="button" class="btn btn-secondary btn-action" data-toggle="modal"
                                        data-target="#editUserModal<?php echo $row['user_id']; ?>">
                                        <i class="bi bi-edit fa-xs"></i>
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
                    <button type="submit" name="editUser" class="btn btn-success">Save Changes</button>
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
                                <input type="text" id ="name_" class="form-control" name="name" onkeyup="checkNameValidity()" required>
                                <span id="nameValidity"></span>
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
                                <input type="password" id="pass_" class="form-control" name="password" required onkeyup="checkPasswordStrength()">
                                <span id="passwordStrength"></span>
                            </div>
                            <div class="form-group">
                                <label>Role</label>
                                <select class="form-control" name="role" required>
                                    <option value="">Select Role</option>
                                    <option value="Admin">Admin</option>
                                    <option value="staff">Staff</option>
                                    
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Designation</label>
                                <input type="text" class="form-control" name="designation" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" name="addUser" class="btn btn-secondary">Add User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

 
    
<link href="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.3/datatables.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.3/datatables.min.js"></script>
    <script src="sidebar/js/popper.js"></script>
    <script src="sidebar/js/bootstrap.min.js"></script>
    <script src="sidebar/js/main.js"></script>
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
