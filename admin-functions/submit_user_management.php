<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "../config/config.php";

    if (isset($_POST['addUser'])) {
        // Handle form submission for adding a user
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $roles = $_POST['roles'];
        $designation = $_POST['designation'];

        // Perform necessary validations and sanitization of the form inputs

        // Insert the user into the database
        $sql = "INSERT INTO user (firstName, lastName, email, address, username, password, roles, designation, status)
                VALUES ('$firstName', '$lastName', '$email', '$address', '$username', '$password', '$roles', '$designation', 'active')";

        if ($conn->query($sql) === TRUE) {
            // User added successfully
            header("Location: user_management.php");
            exit();
        } else {
            // Error occurred while adding the user
            echo "Error: " . $sql . "<br>" ;
        }
    } elseif (isset($_POST['deactivateUser'])) {
        // Handle form submission for deactivating a user
        $userId = $_POST['userId'];

        // Update the user status to 'inactive'
        $sql = "UPDATE user SET status = 'inactive' WHERE id = $userId";

        if ($conn->query($sql) === TRUE) {
            // User deactivated successfully
            header("Location: user_management.php");
            exit();
        } else {
            // Error occurred while deactivating the user
            echo "Error: " . $sql . "<br>" ;
        }
    }
}
?>
