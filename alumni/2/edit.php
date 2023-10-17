<?php
	include("session.php");
	include("config/config.php");
	$id = $_GET['id'];
?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/mystyle1.css" /> 
  
</head>
<title>edit | Account Management</title>
<body>
<?php
	include "template/header.php" ;
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<h2>Update</h2>
<hr/>

<form action="update.php" method="POST">
  <div class="container">
  <?php
	$result = mysqli_query($mysqli,"SELECT * FROM user WHERE username ='$id'");
	while($row = mysqli_fetch_array($result))
	{
	echo"<input type='text' name='username' value='{$row['user_id']}' disabled>";
    echo"<input type='text' name='name' value='{$row['name']}' required>";
    echo"<input type='text' name=role' value='{$row['roles']}' disabled>";
    echo"<input type='text'  name='username' value='{$row['username']}' required>";
    echo"<input type='text'  name='password' value='{$row['password']}' required>";
    echo"<input type='password' placeholder='New Password' name='password' value='{$row['password']}' required>";
    echo"<div class='clearfix'>";
    echo"<button type='submit' class='signupbtn'>Update</button>";
	echo"</div>";
	}?>
  </div>
</form>