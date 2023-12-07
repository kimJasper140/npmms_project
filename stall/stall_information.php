<?php
include "../config/config.php";
//include "../config/session.php";
include "barpage/sidebar.php";

if (!isset($_SESSION['username']) || $_SESSION['roles'] != 'stall_owner') {
    header("location:../index.php");
    exit();
}

$userId = $_SESSION['id'];

// Check if the stall owner information exists
$queryOwner = "SELECT * FROM stall_owner WHERE user_id = '$userId'";
$resultOwner = mysqli_query($conn, $queryOwner);
$rowOwner = mysqli_fetch_assoc($resultOwner);
$stallNo = $rowOwner['stall_no'];

$queryAvailableStall = "SELECT * FROM available_stall WHERE stall_no = '$stallNo'";
$resultAvailableStall = mysqli_query($conn, $queryAvailableStall);




$stallNo = $rowOwner['stall_no'];
$ownerId = $rowOwner['id']; // Fetch the owner_id from the stall_owner table

if (!$resultAvailableStall) {
    die("Error fetching available stall information: " . mysqli_error($conn));
}

$rowAvailableStall = mysqli_fetch_assoc($resultAvailableStall);

// Display the section from the available stall
$selectedSection = $rowAvailableStall['section'];
if (!$resultOwner) {
    die("Error fetching stall owner information: " . mysqli_error($conn));
}

$rowOwner = mysqli_fetch_assoc($resultOwner);

// If form is submitted, process the data
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $stallNumber = mysqli_real_escape_string($conn, $_POST['stall_number']);
    $stallName = mysqli_real_escape_string($conn, $_POST['stall_name']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $ownerId = mysqli_real_escape_string($conn, $_POST['owner_id']);


    // Insert stall information into the database
    $insertQuery = "INSERT INTO stall (stall_number, stall_name, category, status, owner_id)
                    VALUES ('$stallNumber', '$stallName', '$category', '$status', '$ownerId')";
    $insertResult = mysqli_query($conn, $insertQuery);

    if ($insertResult) {
        // Stall information added successfully, redirect to profile page
        exit(header("Location:profile.php"));
        
        

    } else {
        die("Error adding stall information: " . mysqli_error($conn));
    }
    
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Stall Information</title>
    <!-- Add Bootstrap CSS link -->
    
    <style>
       

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 4px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            display: grid;
            grid-template-columns: 1fr;
            grid-gap: 20px;
        }

        .form-group label {
            font-weight: bold;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .form-group button {
            padding: 10px 20px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-weight: bold;
            cursor: pointer;
        }

        .form-group button:hover {
            background-color: #0056b3;
        }

        .form-group input[readonly] {
            background-color: #f2f2f2;
        }

        .form-header {
            margin-bottom: 20px;
            text-align: center;
            font-size: 24px;
        }

        .form-footer {
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="form-header">Stall Information</div>
        <form class="form-group" method="POST">
            <label for="stall_number" class="form-label">Stall Number:</label>
            <input type="text" class="form-control" name="stall_number" value="<?php echo $stallNo; ?>" readonly>

            <label for="stall_name" class="form-label">Stall Name:</label>
            <input type="text" class="form-control" name="stall_name" value="<?php echo $rowOwner['name'] ?? ''; ?>" required>

            <div class="mb-3">
    <label for="category" class="form-label">Section:</label>
    <select class="form-control" name="category"  >
        <option value="">Select Stall Type</option>
        <option value="Corner Stall Dry Goods/Grocery" <?php echo ($selectedSection === 'Corner Stall Dry Goods/Grocery') ? 'selected' : ''; ?>>Corner Stall Dry Goods/Grocery</option>
        <option value="Other Stall in Dry Goods, Grocery and Grains Section" <?php echo ($selectedSection === 'Other Stall in Dry Goods, Grocery and Grains Section') ? 'selected' : ''; ?>>Other Stall in Dry Goods, Grocery and Grains Section</option>
        <option value="Corner Stall in Grains Section" <?php echo ($selectedSection === 'Corner Stall in Grains Section') ? 'selected' : ''; ?>>Corner Stall in Grains Section</option>
        <option value="Restaurant/Fast Food Section" <?php echo ($selectedSection === 'Restaurant/Fast Food Section') ? 'selected' : ''; ?>>Restaurant/Fast Food Section</option>
        <option value="Fruits and Vegetables Section" <?php echo ($selectedSection === 'Fruits and Vegetables Section') ? 'selected' : ''; ?>>Fruits and Vegetables Section</option>
        <option value="Fish Section" <?php echo ($selectedSection === 'Fish Section') ? 'selected' : ''; ?>>Fish Section</option>
        <option value="Meat Section" <?php echo ($selectedSection === 'Meat Section') ? 'selected' : ''; ?>>Meat Section</option>
    </select>
</div>

            <label for="status" class="form-label">Status:</label>
            <input type="text" class="form-control" name="status" value="active" readonly>
            <input type="text" name="owner_id" value="<?php echo $ownerId; ?>" hidden>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        <div class="form-footer">Fill in the form to complete your stall information.</div>
    </div>

   
   
</body>
</html>
