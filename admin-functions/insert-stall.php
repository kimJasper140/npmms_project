<?php
include 'config/database.php';
if (isset($_POST['insertdata'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];




    $a = new database();
    $a->insert('user', ['name' => $name, 'email' => $email, 'phone' => $phone, 'subject' => $subject, 'message' => $message, 'created' => $date, 'updated' => $date]);
    if ($a == true) {
        header('location:index.php');
    }
}


?>