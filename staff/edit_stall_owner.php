<?php
// Include necessary files and configurations
include "../config/config.php";
include "checking_user.php";

// Check if the ID parameter is passed in the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Invalid stall owner ID";
    exit;
}

// Retrieve the stall owner information based on the ID
$stallOwnerId = $_GET['id'];
$sql = "SELECT * FROM stall_owner WHERE id = '$stallOwnerId'";
$result = $conn->query($sql);

if ($result->num_rows === 0) {
    echo "Stall owner not found";
    exit;
}

$row = $result->fetch_assoc();

// Handle form submission for updating stall owner information
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];

    // Update the stall owner information in the database
    $sql = "UPDATE stall_owner SET name = '$name', age = '$age', address = '$address', email = '$email', contact = '$contact' WHERE id = '$stallOwnerId'";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Stall owner updated successfully');</script>";
        echo "<script>window.location.href = 'stall_operate.php';</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Stall Owner | Admin</title>
    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<?php 
include "topbar.php";

?>
<body>
    <div class="container mt-5" >
        <h4 style="margin-top:8%;">Edit Stall Owner</h4>
        <form method="post" class="mt-3">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" class="form-control" value="<?php echo $row['name']; ?>"
                    required>
            </div>
            <div class="form-group">
                <label for="age">Age</label>
                <input type="number" id="age" name="age" class="form-control" value="<?php echo $row['age']; ?>"
                    required>
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" id="address" name="address" class="form-control"
                    value="<?php echo $row['address']; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" value="<?php echo $row['email']; ?>"
                    required>
            </div>
            <div class="form-group">
                <label for="contact">Contact</label>
                <input type="tel" id="contact" name="contact" class="form-control"
                    value="<?php echo $row['contact']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </div>

    <!-- Add Bootstrap JS and jQuery links -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
