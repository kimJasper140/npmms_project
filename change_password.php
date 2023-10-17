<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .container {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            padding-right: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-group input {
            width: 90%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .btn-container {
            text-align: center;
        }

        .btn {
            padding: 10px 20px;
            background-color: #4caf50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #45a049;
        }

        .alert {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
            color: #fff;
        }

        .alert-success {
            background-color: #4caf50;
        }

        .alert-danger {
            background-color: #f44336;
        }
    </style>
</head>
<body>
    <?php
    session_start();
    include "config/config.php";

    // Check if the code, email, and password are provided
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['code']) && isset($_POST['email']) && isset($_POST['password'])) {
            $code = $_POST['code'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Check if the code matches the one stored in the session
            if ($code === $_SESSION['reset_code']) {
                // Check if the code is still valid (within 5 minutes)
                $currentTime = time();
                $resetTime = $_SESSION['reset_time'];
                $validityPeriod = 5 * 60; // 5 minutes in seconds

                if (($currentTime - $resetTime) <= $validityPeriod) {
                    // Code is valid, perform the password update

                    // Get the user ID based on the email
                    $selectQuery = "SELECT user_id FROM user WHERE email = ?";
                    $stmt = $conn->prepare($selectQuery);
                    $stmt->bind_param("s", $email);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        // Fetch the user ID
                        $row = $result->fetch_assoc();
                        $userID = $row['user_id'];

                        // Hash the password
                        $Pass = $password;

                        // Prepare the update query
                        $updateQuery = "UPDATE user SET password = ? WHERE user_id = ?";
                        $stmt = $conn->prepare($updateQuery);
                        $stmt->bind_param("si",  $Pass, $userID);
                        $stmt->execute();

                        if ($stmt->affected_rows > 0) {
                            // Password update successful

                            // Reset the session variables
                            unset($_SESSION['reset_code']);
                            unset($_SESSION['reset_time']);

                            // Close the database connection
                            $stmt->close();
                            $conn->close();

                            // Redirect to a success page or login page
                            echo '<div class="alert alert-success">Password changed successfully!</div>';
                            echo '<script>window.location.href = "login.php";</script>';
                            exit();
                        } else {
                            echo '<div class="alert alert-danger">Failed to update password.</div>';
                        }
                    } else {
                        echo '<div class="alert alert-danger">User not found.</div>';
                    }
                } else {
                    // Code is expired
                    echo '<div class="alert alert-danger">The code has expired.</div>';
                }
            } else {
                // Invalid code
                echo '<div class="alert alert-danger">Invalid code.</div>';
            }
        } else {
            // Display an error message if the code, email, or password is not provided
            echo '<div class="alert alert-danger">Code, email, and password are required.</div>';
        }
    }
    ?>

    <div class="container">
        <h1>Change Password</h1>

        <form action="change_password.php" method="POST">
            <div class="form-group">
                <label for="code">Code:</label>
                <input type="text" id="code" name="code" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $_SESSION['reset_email']; ?>" readonly required>
            </div>
            <div class="form-group">
                <label for="password">New Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="btn-container">
                <button type="submit" class="btn">Reset Password</button>
            </div>
        </form>
    </div>
</body>
</html>
