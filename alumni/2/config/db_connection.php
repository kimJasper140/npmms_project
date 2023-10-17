<?php 
$sname = "localhost";
$unmae ="root";
$password = "";
$db_name = "npmms";

$conn =new mysqli($sname,$unmae,$password,$db_name);

if($conn->connect_error){
    echo $conn->connect_error;

}else{
    echo "connected";
}
// $sql = "SELECT * FROM user";
// $result = mysqli_query($sql) or die($conn->error);
// $row = $result->fetch_assoc();
// prinr_r($row);
?>