
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stall Owner Management | staff</title>
    <link rel="icon" href="../image/logo.ico" type="image/x-icon">
    <!-- Add your CSS and JavaScript includes here -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f2f2f2;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        input[type="text"] {
            padding: 10px;
            margin-right: 10px;
        }

        button {
            padding: 10px 15px;
            background-color: #299be4;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        table {
            width:95%;
            border-collapse: collapse;
            border: 1px solid #ccc;
            margin-left: 2%;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ccc;
        }

        th {
            background-color: green;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        td a {
            text-decoration: none;
            color: #299be4;
        }

        td a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <?php
    // Include necessary files and configurations
    include "../config/config.php";
    include "checking_user.php";

    // Handle form submissions if any
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Handle form submission for search
        $search = $_POST['search'];
        $sql = "SELECT id, stall_no, name, age, address, email, contact, status, user_id FROM stall_owner WHERE status = 'operate' AND 
                (id LIKE '%$search%' OR stall_no LIKE '%$search%' OR name LIKE '%$search%' OR age LIKE '%$search%' OR address LIKE '%$search%' OR 
                email LIKE '%$search%' OR contact LIKE '%$search%')";
        $result = $conn->query($sql);
    } else {
        // Display all active stall owners on initial load
        $sql = "SELECT id, stall_no, name, age, address, email, contact, status, user_id FROM stall_owner WHERE status = 'operate'";
        $result = $conn->query($sql);
    }


   
    ?>
<?php 
include "topbar.php";
?>
    <h3 style="margin-top:5%;">Stall List</h3>

    <!-- Search Form -->
    <form method="post">
        <input type="text" name="search" placeholder="Search stall owners...">
        <button type="submit">Search</button>
    </form>

    <!-- Display Table -->
    <table>
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
       
    </tr>
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
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='10'>No stall owners found</td></tr>";
    }
    ?>
</table>
</body>

</html>
<?php 
 include "contract_remider.php";
?>