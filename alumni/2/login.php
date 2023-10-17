<!DOCTYPE html>
<html>
<head>
	<title>Login | NPMMS</title>
	<link rel="stylesheet" type="text/css" href="css/mystyle.css" /> 
</head>
<body style="background-color:lightblue;">
<form action="validate.php" method="POST">
  <div class="imgcontainer" style="margin-top:50px;">
    <img src="images/logo.PNG" alt="User" class="user" width="100px" height="100px" style="border-radius:50px;">
  </div>

  <div class="container">
    <label><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="username" required>

    <label><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="password" required>
    <?php if (isset($_GET['error'])) { ?>
      
  <p style="color:red;"><?php echo $_GET['error']; ?></p>
  <?php } ?>
    <button type="submit" name="submit">Login</button>
    <input type="checkbox" checked="checked"> Remember me
  </div>

  <div class="container" style="background-color:#f1f1f1">
    <button type="reset" class="cancelbtn">Cancel</button>
    <span class="psw">Forgot <a href="#">password?</a></span>
  </div>
</form>

</body>
</html>