<?php
	include("session.php");
	
	if(isset($_POST['search']))
	{
		$valueToSearh = $_POST['valueToSearh']; 
		$query = "SELECT * FROM user WHERE name LIKE '%".$valueToSearh."%' OR user_id LIKE '%".$valueToSearh."%'";
		$result = filterRecord($query);
	}
	else
	{
		$query = "SELECT * FROM user";
		$result = filterRecord($query);
		
	}
	
	function filterRecord($query)
	{
		include("config/config.php");
		$filter_result = mysqli_query($mysqli, $query);
		return $filter_result;
	}
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="css/mystyle1.css" /> 

</head>
<title>Users | Account Management</title>
<body>
	<?php
// include "template/header.php";
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<hr/>

<div class="container">
<div style="margin-left:70%;">
<form action="" method="POST">
<input type="search" name="valueToSearh" placeholder="Search">
<button type="submit" class="signupbtn" style="background-color:darkblue;border-radius:25px;" name="search" >Search</button>
</div>
<div style="margin-left:80%;">
<a href="registration.php" class="btn btn-primary" style="width:60px;height: 40px;font-size:10px;align-text:center;">Add User<i class="fa fa-registered"></i></a>
<a href="print_all.php"  class="btn btn-primary " style="width:60px;height: 40px;font-size:10px;align-text:center;">Download<i class="fa fa-print"></i></a>
</div>

</form>

<br />	
<?php


echo "<table border='1'>
<tr>
<th>ID</th>
<th> Name</th>
<th>Roles</th>
<th>user name</th>
<th>password</th>
<th>status</th>

<th>Update</th>
<th>Delete</th>
<th>Print</th>
</tr>";

while($row = mysqli_fetch_array($result))
{
echo "<tr>";
echo "<td>" . $row['user_id'] . "</td>";
echo "<td>" . $row['name'] . "</td>";
echo "<td>" . $row['roles'] . "</td>";
echo "<td>" . $row['username'] . "</td>";
echo "<td>" . $row['password'] . "</td>";
echo "<td>" . $row['status'] . "</td>";
echo "<td><a href='edit.php?id=".$row['username']."'><img src='./images/icons8-Edit-32.png' alt='Edit'></a></td>";
echo "<td><a href='delete.php?id=".$row['username']."'><img src='./images/icons8-Trash-32.png' alt='Delete'></a></td>";
echo "<td><a href='print.php?id=".$row['username']."'><img src='./images/icons8-Print-32.png' alt='Print'></a></td>";
echo "</tr>";
}
echo "</table>";

?>

</body>
</html> 