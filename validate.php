<?php
include "config/config.php";

session_start();

if (isset($_POST['email']) && isset($_POST['password'])) {

    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $email =$_POST['email'];
    $pass =$_POST['password'];

    if (empty($email)) {
        header("Location: login.php?error=User Name is required");
        exit();
    } elseif (empty($pass)) {
        header("Location: login.php?error=Password is required");
        exit();
    } else {
        $sql = "SELECT * FROM `user` WHERE email='$email' AND password='$pass'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);

            if ($row['email'] == $email && $row['password'] == $pass) {
          

                // Store user information in session
                $_SESSION['email'] = $row['email'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['name'] = $row['name'];
                $_SESSION['id'] = $row['user_id'];
                $_SESSION['status'] = $row['status'];
                $status = $row['status'];
                $_SESSION['roles'] = $row['roles'];
                $role = $row['roles'];

                // Redirect to respective dashboard
                if ($role == 'admin' ) {
                    if ($status == 'active' || $status == 'Active') {
                        header("Location: admin/dashboard-admin.php");
                    } else {
                        header("Location: login.php?error=Pending application");
                        exit();
                    }
                } elseif ($role == 'staff') {
                    if ($status == 'active' || $status == 'Active') {
                        header("Location: staff/dashboard-staff.php");
                    } else {
                        header("Location: login.php?error=Invalid Account");
                        exit();
                    }
                } elseif ($role == 'stall_owner')   {
                    if ($status == 'active' || $status == 'Active') {
                        header("Location: stall/profile.php");
                    } elseif ($status == 'terminate') {
                        header("Location: login.php?error=Account Terminated");
                    } elseif ($status == 'inactive') {
                        header("Location: login.php?error=Inactive account");
                    }
                } else {
                    header("Location: login.php?error=Closed account");
                }

                exit();
            } else {
                header("Location: login.php?error=Incorrect User name or password");
                exit();
            }
        } else {
            header("Location: login.php?error=Incorrect User name or password");
            exit();
        }
    }
} else {
    header("Location:login.php");
    exit();
}
?>
