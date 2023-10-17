<?php
include("config/config.php");
?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/mystyle1.css" /> 
</head>
<title>Add Account | Account Management</title>
<body>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<h2>Sign Up</h2>

<hr/>
<form action="register.php" method="POST">
  <div class="container">
	<input type="text" placeholder="user id" name="id" required>
    <input type="text" placeholder="name" name="name" required>
    <select name="role" ul class="dropdown-menu">
<option value="admin">admin</option>
<option value="stall_owner">stall owner</option>
<option value="staff">staff</option>
    </select>
    <input type="text" placeholder="Username" name="username" required>
    <input type="password" placeholder="New Password" name="password" required>
    <input type="password" placeholder="Repeat Password" name="psw-repeat" required>
    <div class="clearfix">
      <button type="submit" class="signupbtn">Sign Up</button>
      <a class="cancelbtn" href="Home.php">Cancel</a>
    </div>
  </div>
</form>