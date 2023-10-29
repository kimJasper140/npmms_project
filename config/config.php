<?php
$mysqli = new mysqli('localhost', 'root', 'legendaryCodeGodz24', 'NPMMS');
?>
<?php
$servername = 'localhost';
$username = 'root';
$password = 'legendaryCodeGodz24';
$dbname = 'NPMMS';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}
?>
