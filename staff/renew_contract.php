<?php
// Include necessary files and configurations
require '../config/config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['renew_contract']) && isset($_POST['stall_owner_id'])) {
    $stall_owner_id = $_POST['stall_owner_id'];

    // Fetch the latest contract for the selected stall owner
    $sql_latest_contract = "SELECT id, contract_end_date, contract_terms 
                           FROM stall_owner_contract 
                           WHERE stall_owner_id = '$stall_owner_id' 
                           ORDER BY contract_end_date DESC 
                           LIMIT 1";
    $result_latest_contract = $conn->query($sql_latest_contract);
    $latest_contract = $result_latest_contract->fetch_assoc();

    // Get the current contract details
    $current_contract_id = $latest_contract['id'];
    $current_contract_end_date = $latest_contract['contract_end_date'];
    $current_contract_terms = $latest_contract['contract_terms'];

    // Calculate the new contract end date (e.g., extend it by 1 year)
    $new_contract_end_date = date('Y-m-d', strtotime('+1 year', strtotime($current_contract_end_date)));

    // Prepare the update query to renew the contract
    $sql_renew_contract = "UPDATE stall_owner_contract 
                           SET contract_start_date = '$current_contract_end_date',
                               contract_end_date = '$new_contract_end_date',
                               contract_terms = '$current_contract_terms' 
                           WHERE id = '$current_contract_id'";

    // Execute the update query
    if ($conn->query($sql_renew_contract) === TRUE) {
        echo '<script>alert("Contract has been renewed successfully");</script>';
    } else {
        echo "Error renewing contract: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Renew Contract</title>
    <style>
        /* Add your CSS styles for the page content here */
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            background-color: #fff;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            border-radius: 4px;
            padding: 20px;
        }

        h1 {
            text-align: center;
        }

        /* Add any additional CSS styles as needed */
    </style>
</head>

<body>
    <div class="container">
        <h1>Contract Renewal</h1>
        <p>Clicking the "Renew Contract" button will extend the contract by 1 year.</p>
        <form method="post">
            <input type="hidden" name="stall_owner_id" value="<?php echo $stall_owner_id; ?>">
            <button type="submit" name="renew_contract">Renew Contract</button>
        </form>
    </div>
</body>

</html>
