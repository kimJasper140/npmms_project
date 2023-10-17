<?php
session_start();
include "../config/config.php";

// Replace this with the correct session variable that holds the logged-in user's ID
$loggedInUserId = $_SESSION['id'];

// Retrieve the stall owner's ID based on the logged-in user's ID
$sqlStallOwner = "SELECT id FROM `stall_owner` WHERE user_id = '$loggedInUserId'";
$resultStallOwner = $conn->query($sqlStallOwner);

$rowStallOwner = $resultStallOwner->fetch_assoc();
$stallOwnerId = $rowStallOwner['id'];

if (isset($_POST["submit"])) {
    // Clean and validate the input data
    $maintenanceType = ($_POST["maintenanceType"]);
    $date = ($_POST["date"]);
    $description = ($_POST["description"]);
    $status = "pending";

    // Insert the maintenance record into the database
    $sql = "INSERT INTO maintenance (maintenance_type, date, description, status, owner_id) VALUES ('$maintenanceType', '$date', '$description', '$status', '$stallOwnerId')";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Maintenance record added successfully');</script>";
    } else {
        echo "<script>alert('Error adding maintenance record: " . mysqli_error($conn) . "');</script>";
    }

    // Close the database connection
    mysqli_close($conn);
}
?>

    
    
          
           
        
    
<!DOCTYPE html>
<html>
<head>
    <title>Maintenance Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
          
            background-color: #f2f2f2;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        .form-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 4px;
            padding: 20px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .form-container form label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }

        .form-container form input[type="text"],
        .form-container form textarea {
            width: 95%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            resize: vertical;
        }

        .form-container form button {
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            background-color: #4CAF50;
            color: #fff;
            font-weight: bold;
        }

        @media (max-width: 600px) {
        .form-container form select {
            width: 95%;
        }
    }

        /* Additional CSS styles can be added here */
    </style>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <h1>Maintenance Report</h1>

    <div class="form-container">
        <form action="" method="POST">
            <label for="maintenanceType">Maintenance Type:</label>
            <select id="maintenanceType" name="maintenanceType" required>
                <option value="" disabled selected>Select Maintenance Type</option>
                <option value="structure Maintenance">Structure Maintenance</option>
                <option value="facilities Maintenance">Facilities Maintenance</option>
                <option value="plumbing Maintenance">Plumbing Maintenance</option>
                <option value="electrical Maintenance">Electrical Maintenance</option>
                <option value="hvac Maintenance">HVAC (Heating, Ventilation, and Air Conditioning) Maintenance</option>
                <option value="grounds Maintenance">Grounds Maintenance</option>
                <option value="painting Maintenance">Painting and Finishing Maintenance</option>
                <option value="roof Maintenance">Roof Maintenance</option>
                <option value="security Maintenance">Security System Maintenance</option>
                <option value="elevators Maintenance">Elevator Maintenance</option>
                <option value="fire-safety">Fire Safety System Maintenance</option>
                <option value="janitorial Maintenance">Janitorial and Cleaning Maintenance</option>
                <option value="pest-control Maintenance">Pest Control Maintenance</option>
                <option value="Not on the List">Not on the List </option>
            </select>

            <label for="date">Date:</label>
            <input type="text" id="date" name="date" value="<?php echo date('Y-m-d H:i:s'); ?>" readonly>

            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="4" required placeholder="Include Location and describe the work order."></textarea>

            <button type="submit" name="submit">Submit Report</button>
        </form>
    </div>

    <!-- Button to view past maintenance reports -->
    <div style="text-align: center; margin-top: 20px;">
        <a href="past_maintenance_report.php"
            style="padding: 10px 20px; background-color: #007BFF; color: #fff; text-decoration: none; border-radius: 4px; font-weight: bold;">View
            Past Maintenance Reports</a>
    </div>

 
</body>
</html>
