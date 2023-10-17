<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connect to the database (update with your database credentials)
    include "../config/config.php";

    // Function to escape user inputs
    function clean_input($input)
    {
        global $conn;
        return mysqli_real_escape_string($conn, trim($input));
    }

    // Function to validate datetime-local input
    function validate_datetime($input)
    {
        $datetime = DateTime::createFromFormat('Y-m-d\TH:i', $input);
        return $datetime && $datetime->format('Y-m-d\TH:i') === $input;
    }

    // Function to validate amount input
    function validate_amount($input)
    {
        return is_numeric($input) && $input >= 0;
    }

    // Process adding a new entry
    if (isset($_POST["name"]) && isset($_POST["plate_no"]) && isset($_POST["time_in"]) && isset($_POST["time_out"]) && isset($_POST["amount"])) {
        $name = clean_input($_POST["name"]);
        $plate_no = clean_input($_POST["plate_no"]);
        $time_in = clean_input($_POST["time_in"]);
        $time_out = clean_input($_POST["time_out"]);
        $amount = clean_input($_POST["amount"]);
        $remarks = isset($_POST["remarks"]) ? clean_input($_POST["remarks"]) : "";

       
        

        // Insert the new entry into the database
        $sql = "INSERT INTO park_rent (name, plate_no, time_in, time_out, amount, remarks, date) VALUES ('$name', '$plate_no', '$time_in', '$time_out', '$amount', '$remarks', NOW())";
        if (mysqli_query($conn, $sql)) {
            echo json_encode(array("success" => true, "message" => "New entry added successfully"));
        } else {
            echo json_encode(array("success" => false, "message" => "Error adding new entry: " . mysqli_error($conn)));
        }
    }

    // Process editing an existing entry
    elseif (isset($_POST["editEntryId"]) && isset($_POST["editName"]) && isset($_POST["editPlateNo"]) && isset($_POST["editTimeIn"]) && isset($_POST["editTimeOut"]) && isset($_POST["editAmount"])) {
        $entry_id = clean_input($_POST["editEntryId"]);
        $name = clean_input($_POST["editName"]);
        $plate_no = clean_input($_POST["editPlateNo"]);
        $time_in = clean_input($_POST["editTimeIn"]);
        $time_out = clean_input($_POST["editTimeOut"]);
        $amount = clean_input($_POST["editAmount"]);
        $remarks = isset($_POST["editRemarks"]) ? clean_input($_POST["editRemarks"]) : "";

        // Validate the inputs
        if (empty($name) || empty($plate_no) || !validate_datetime($time_in) || !validate_datetime($time_out) || !validate_amount($amount)) {
            echo json_encode(array("success" => false, "message" => "Invalid input data"));
            exit;
        }

        // Update the existing entry in the database
        $sql = "UPDATE park_rent SET name='$name', plate_no='$plate_no', time_in='$time_in', time_out='$time_out', amount='$amount', remarks='$remarks' WHERE id='$entry_id'";
        if (mysqli_query($conn, $sql)) {
            echo json_encode(array("success" => true, "message" => "Entry updated successfully"));
        } else {
            echo json_encode(array("success" => false, "message" => "Error updating entry: " . mysqli_error($conn)));
        }
    } else {
        echo json_encode(array("success" => false, "message" => "Invalid request"));
    }

    // Close the database connection
    mysqli_close($conn);
} else {
    echo json_encode(array("success" => false, "message" => "Invalid request"));
}
?>
