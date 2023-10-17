<?php
// Include necessary files and configurations
include "../config/config.php";
include "checking_user.php";

// Define the is_admin_authenticated function
function is_admin_authenticated() {
    // Replace this with your authentication logic to check if the admin is authenticated
    if (isset($_SESSION['email'])) {
        global $conn;
        $email = $_SESSION['email'];
        $sql = "SELECT roles FROM user WHERE email = '$email'";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['roles'] === 'admin';
        }
    }
    return false;
}

// Handle AJAX login request
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['login_email']) && isset($_POST['login_password'])) {
    $email = $_POST['login_email'];
    $password = $_POST['login_password'];

    // Check if the provided credentials match the user credentials
    $sql = "SELECT email FROM user WHERE email = '$email' AND password = '$password' AND roles = 'admin'";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        // Set admin authentication in the session
        $_SESSION['email'] = $email;
        // Send success response
        echo json_encode(['success' => true]);
        exit();
    } else {
        // Send error response
        echo json_encode(['success' => false, 'message' => 'Invalid credentials']);
        exit();
    }
}

// Fetch transactions based on stall ID (Please replace 'YOUR_TABLE_NAME' with the actual table name)
if (isset($_GET['id'])) {
    $stallId = $_GET['id'];
    $sql = "SELECT transaction_id, transaction_type, description, user_id, stall_id, transaction_date 
            FROM `transaction` WHERE stall_id = '$stallId' ORDER BY transaction_date DESC";
    $result = $conn->query($sql);
}

// Handle form submission for adding transactions
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['transaction_type']) && isset($_POST['description'])) {
    // Here, you can implement the logic to add transactions if authenticated.

    // Example code for adding transactions (Replace this with your authentication logic):
    if (is_admin_authenticated()) {
        $transaction_type = $_POST['transaction_type'];
        $description = $_POST['description'];
        $user_id = $_SESSION['id']; // Assuming you have a user session in the "checking_user.php" file

        // Add the transaction to the database
        $sql = "INSERT INTO `transaction` (transaction_type, description, user_id, stall_id, transaction_date) 
                VALUES ('$transaction_type', '$description', '$user_id', '$stallId', NOW())";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Transaction added successfully');</script>";
            echo "<script>window.location.href = 'stall_transaction.php?id=$stallId';</script>";
        } else {
            echo "<script>alert('Error adding transaction');</script>";
        }
    } else {
        echo "<script>alert('You need to log in to add transactions.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Transactions | Admin</title>
    <style>
        /* Add your CSS styles for the page content here */
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            margin-top: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            border-radius: 4px;
            margin-top: 30px;
        }

        .add-transaction {
            margin-top: 20px;
            text-align: center;
        }

        .add-transaction button {
            padding: 10px 20px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
        }

        .add-transaction button:hover {
            background-color: #0056b3;
        }

        .error-message {
            color: red;
            margin-top: 10px;
        }

        /* Add your CSS styles for the login form here */
        .login-container {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 4px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            display: none; /* Hidden by default */
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .login-container label {
            display: block;
            margin-bottom: 5px;
        }

        .login-container input[type="email"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .login-container button {
            padding: 10px 20px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
        }

        .login-container button:hover {
            background-color: #0056b3;
        }

    </style>
</head>
<body>
<div class="container">
    <h1>View Transactions</h1>

    <!-- Add Transaction Button -->
    <?php
    // Check if the user is authenticated (Replace this with your authentication logic)
    if (is_admin_authenticated()) {
        ?>
        <div class="add-transaction">
            <button onclick="showAddTransactionForm()">Add Transaction</button>
        </div>
        <?php
    } else {
        echo "<p class='error-message'>You need to log in to add transactions.</p>";
    }
    ?>

    <!-- Display Transactions Table -->
    <table>
        <tr>
            <th>Transaction ID</th>
            <th>Transaction Type</th>
            <th>Description</th>
            <th>User ID</th>
            <th>Transaction Date</th>
        </tr>
        <?php
        if (isset($result) && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['transaction_id'] . "</td>";
                echo "<td>" . $row['transaction_type'] . "</td>";
                echo "<td>" . $row['description'] . "</td>";
                echo "<td>" . $row['user_id'] . "</td>";
                echo "<td>" . $row['transaction_date'] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No transactions found</td></tr>";
        }
        ?>
    </table>

    <!-- Add Transaction Form (Hidden by default) -->
    <div id="addTransactionForm" class="login-container">
        <h2>Add Transaction</h2>
        <form method="post" action="">
            <label for="transaction_type">Transaction Type:</label>
            <input type="text" name="transaction_type" required>
            <br>
            <label for="description">Description:</label>
            <input type="text" name="description" required>
            <br>
            <button type="submit">Add Transaction</button>
        </form>
    </div>
</div>

<!-- JavaScript for the login form -->
<script>
    function showModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.style.display = 'block';
    }

    function hideModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.style.display = 'none';
    }

    // Check if the login form needs to be shown (if the admin is not authenticated)
    window.onload = function () {
        <?php if (!is_admin_authenticated()) { ?>
        showModal('loginModal');
        <?php } ?>
    };

    // Function to show the add transaction form
    function showAddTransactionForm() {
        showModal('addTransactionForm');
    }

    // Function to submit the login form using AJAX
    document.getElementById('loginForm').addEventListener('submit', function (event) {
        event.preventDefault();

        const email = document.getElementById('login_email').value;
        const password = document.getElementById('login_password').value;

        // Send the login request to the server using AJAX
        fetch('stall_transaction.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `login_email=${encodeURIComponent(email)}&login_password=${encodeURIComponent(password)}`,
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Admin login successful, hide the login modal and reload the page
                    hideModal('loginModal');
                    window.location.reload();
                } else {
                    // Admin login failed, show the error message
                    document.getElementById('loginError').style.display = 'block';
                }
            })
            .catch(error => {
                console.error('Login error:', error);
            });
    });
</script>
</body>
</html>
