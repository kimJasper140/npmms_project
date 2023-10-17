<?php
include "../config/config.php";
session_start();

// Check if the contract ID is provided in the URL
if (!isset($_GET['contract_id'])) {
    header("Location: stall_operate.php");
    exit();
}

// Get the contract ID from the URL
$contract_id = $_GET['contract_id'];

// Fetch the contract details from the database
$sql = "SELECT * FROM stall_owner_contract WHERE id = '$contract_id'";
$result = $conn->query($sql);

// Check if the contract exists
if ($result->num_rows === 0) {
    echo "<p class='mt-4'>Error: Contract with ID $contract_id not found.</p>";
    exit();
}

// Initialize variables to store contract details
$contract_data = $result->fetch_assoc();
$contract_start_date = $contract_data['contract_start_date'];
$contract_end_date = $contract_data['contract_end_date'];
$contract_terms = $contract_data['contract_terms'];

// Handle form submission for updating contract
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['contract_terms'])) {
    $contract_terms = $_POST['contract_terms'];

    // Update the contract terms in the database
    $sql_update = "UPDATE stall_owner_contract SET contract_terms = '$contract_terms' WHERE id = '$contract_id'";
    
    if ($conn->query($sql_update) === TRUE) {
        echo '<script>alert("Contract has been updated successfully.");</script>';
    } else {
        echo "Error updating contract: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Contract | Stall Owner</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            background-color: #fff;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            border-radius: 4px;
            padding: 20px;
            margin-top: 50px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        /* Add some spacing between the form elements */
        form {
            margin-top: 20px;
        }

        form label {
            display: block;
            margin-bottom: 5px;
        }

        form input[type="date"],
        form textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        form button {
            background-color: green; /* Green color for the button */
            color: #fff; /* White text color for the button */
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        /* Style the button on hover */
        form button:hover {
            background-color: goldenrod; /* Darker green on hover */
        }
    </style>
</head>

<body>
    <?php include "topbar.php"; ?>
    <div class="container">
        <h2>Renew Contract for Stall Owner</h2>
        <form method="post">
            <label for="contract_start_date">Contract Start Date:</label>
            <input type="date" name="contract_start_date" value="<?php echo $contract_start_date; ?>" disabled>
            <br>
            <label for="contract_end_date">Contract End Date:</label>
            <input type="date" name="contract_end_date" value="<?php echo $contract_end_date; ?>" disabled>
            <br>
            <label for="contract_terms">Contract Terms:</label>
            <textarea name="contract_terms" rows="5" cols="50" required><?php echo $contract_terms; ?></textarea>
            <br>
            <button type="submit">Renew Contract</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
