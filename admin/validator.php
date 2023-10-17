<?php
function isValidName($name) {
    // Using a regular expression to check if the name contains only letters and spaces
    return preg_match("/^[a-zA-Z ]+$/", $name);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];

    if (isValidName($name)) {
        // Name is valid - process the form
        // You can redirect or do further processing here
    } else {
        // Name is invalid - display an error message
        echo "Invalid name. Please enter a valid name (letters and spaces only).";
    }
}
?>
