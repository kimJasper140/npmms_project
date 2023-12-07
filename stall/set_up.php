<?php
include "../config/config.php";
include "../config/session.php";
include "barpage/sidebar.php";

if (!isset($_SESSION['username']) || $_SESSION['roles'] != 'stall_owner') {
    header("location:../index.php");
    exit();
}

$userId = $_SESSION['id'];

// Fetch the application details based on the email address
$userEmail = mysqli_real_escape_string($conn, $_SESSION['email']);
$queryApplication = "SELECT * FROM applications WHERE email = '$userEmail'";
$resultApplication = mysqli_query($conn, $queryApplication);



if (!$resultApplication) {
    die("Error fetching application details: " . mysqli_error($conn));
}

$rowApplication = mysqli_fetch_assoc($resultApplication);

// Display the stall number from the application
$stallNoFromApplication = $rowApplication['stall_no'];
// Function to insert user account data into the database
function insertUserAccount($conn, $userId) {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $stallNo = mysqli_real_escape_string($conn, $_POST['stall_no']);
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $age = mysqli_real_escape_string($conn, $_POST['age']);
        $address = mysqli_real_escape_string($conn, $_POST['address']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $contact = mysqli_real_escape_string($conn, $_POST['contact']);

        // Insert stall owner information into the database
        $insertQuery = "INSERT INTO stall_owner (stall_no, name, age, address, email, contact, status, user_id)
                        VALUES ('$stallNo', '$name', '$age', '$address', '$email', '$contact', 'operate', '$userId')";
        $insertResult = mysqli_query($conn, $insertQuery);

        if ($insertResult) {
            // Stall owner information added successfully, redirect to stall information form
            header("location: stall_information.php");
            exit();
        } else {
            die("Error adding stall owner information: " . mysqli_error($conn));
        }
    }
}

// Function to insert stall information data into the database


// Fetch stall owner information
$queryOwner = "SELECT * FROM stall_owner WHERE user_id = '$userId'";
$resultOwner = mysqli_query($conn, $queryOwner);

if (!$resultOwner) {
    die("Error fetching stall owner information: " . mysqli_error($conn));
}

$rowOwner = mysqli_fetch_assoc($resultOwner);

// Check if the stall owner information is found
if (!$rowOwner || !isset($rowOwner['stall_no'])) {


   
    // Handle user account setup form submission
    insertUserAccount($conn, $userId);

    // Fetch user table data to prefill the form
    $queryUser = "SELECT * FROM user WHERE user_id = '$userId'";
    $resultUser = mysqli_query($conn, $queryUser);

    if (!$resultUser) {
        die("Error fetching user information: " . mysqli_error($conn));
    }

    $rowUser = mysqli_fetch_assoc($resultUser);
} else {
    // Stall owner information found, so fetch the related stall information
    $stallNo = $rowOwner['stall_no'];

    $queryStalls = "SELECT * FROM stall WHERE owner_id = '$stallNo'";
    $resultStalls = mysqli_query($conn, $queryStalls);

    if (!$resultStalls) {
        die("Error fetching stall information: " . mysqli_error($conn));
    }

}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Stall Owner Profile Setup</title>
    <!-- Add Bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f2f2f2;
        }

        .setup-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 4px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .setup-form label {
            font-weight: bold;
        }

        .setup-form input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .setup-form button {
            padding: 10px 20px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-weight: bold;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="setup-container p-4">
            <h2 class="mb-4">Stall Owner Profile Setup</h2>
            <form class="setup-form" method="POST">
                <div class="mb-3">
                    <label for="stall_no" class="form-label">Stall Number:</label>
                    <input type="text" class="form-control" name="stall_no" value="<?php echo $stallNoFromApplication; ?>" readonly>
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Name:</label>
                    <input type="text" class="form-control" name="name" value="<?php echo $rowUser['name'] ?? ''; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="age" class="form-label">Age:</label>
                    <input type="number" class="form-control" name="age" value="<?php echo $rowUser['age'] ?? ''; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Address:</label>
                    <input type="text" class="form-control" name="address" value="<?php echo $rowUser['address'] ?? ''; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" class="form-control" name="email" value="<?php echo $rowUser['email'] ?? ''; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="contact" class="form-label">Contact:</label>
                    <input type="text" class="form-control" name="contact" value="<?php echo $rowUser['contact'] ?? ''; ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Submit User Account Information</button>
            </form>
        </div>
    </div>

    <!-- Add Bootstrap JS and jQuery links -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
