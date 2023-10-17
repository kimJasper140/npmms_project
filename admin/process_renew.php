<!-- process_renew.php -->

<?php
include "../config/config.php";

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the form data
    $stall_owner_id = $_POST['stall_owner_id'];
    $new_contract_start_date = $_POST['new_contract_start_date'];
    $new_contract_end_date = $_POST['new_contract_end_date'];
    $new_contract_terms = $_POST['new_contract_terms'];

    // Perform any necessary validation on the form data
    // (e.g., check if dates are in the correct format, contract end date is after start date, etc.)

    // Update the contract details in the database
    $sql = "UPDATE `stall_owner_contract` SET 
                `contract_start_date` = '$new_contract_start_date', 
                `contract_end_date` = '$new_contract_end_date', 
                `contract_terms` = '$new_contract_terms' 
            WHERE `stall_owner_id` = $stall_owner_id";

    if ($conn->query($sql) === TRUE) {
        echo "Contract renewed successfully!";
    } else {
        echo "Error updating contract: " . $conn->error;
    }
}

$conn->close();
?>
