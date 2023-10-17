<?php
// Include the database configuration
include('../config/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the user data from the POST request
    $userId = $_POST['userId'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $designation = $_POST['designation'];

    // Prepare the UPDATE statement
    $stmt = $conn->prepare("UPDATE user SET firstName=?, lastName=?, address=?, email=?, roles=?, designation=? WHERE id=?");
    $stmt->bind_param("ssssssi", $firstName, $lastName, $address, $email, $role, $designation, $userId);

    // Execute the UPDATE statement
    if ($stmt->execute()) {
        // User updated successfully
        echo "User updated successfully";
    } else {
        // Error occurred during user update
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>
