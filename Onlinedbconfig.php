<?php
$mysqli = new mysqli('sql205.infinityfree.com', 'epiz_34163900', 'qrjpvkFIBUZ', 'epiz_34163900_npmms');
?>
<?php
$servername = 'sql205.infinityfree.com';
$username = 'epiz_34163900';
$password = 'qrjpvkFIBUZ';
$dbname = 'epiz_34163900_npmms';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}
?>
