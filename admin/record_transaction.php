<?php
include '../config/config.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $id = $_POST['id'];

    $sql = "SELECT * FROM payment_details WHERE id = $id";
    $result = $conn->query($sql);
    if($result){
        while($row = $result->fetch_assoc()){
            $name = $row['account_name'];
            $description = $row[]
        }
    }
}

?>
