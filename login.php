<?php
session_start();
if (isset($_SESSION['roles'])) {
  $role = $_SESSION['roles'];
  if ($role == 'admin' || $role == 'Admin'){
  header("Location: admin/dashboard-admin.php");
 }else if($role == 'staff' || $role == 'Staff'){
  header("Location: staff/dashboard-staff.php");
 }else if($role == 'stall_owner' || $role == 'Stall_owner'){
  header("Location: stall/Stall_dashboard.php");
 }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | NPMMS</title>
  <link rel="icon" href="image/logo.ico" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
    crossorigin="anonymous"></script>
  <link rel="stylesheet" href="style.css">
</head>
<style>
  /* General styles */
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

  body {
    font-family: Arial, Helvetica, sans-serif;
    background-color: #f5f5f5;
  }

  .container {
    display: flex;
    flex-direction: row;
    justify-content: center;
    align-items: center;
    height: 100vh;
  }

  /* Header styles */
  .header {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
  }

  .header img {
    width: 50px;
    margin-bottom: 10px;
  }

  .header h1 {
    font-size: 24px;
  }

  /* Form styles */
  .form-container {
    flex: 1;
    max-width: 400px;
    padding: 20px;
    background-color: #fff;
    border-radius: 5px;
  }

  .form-container form {
    display: flex;
    flex-direction: column;
    text-align: center;
    margin: 10px;
  }

  .form-container label {
    font-size: 18px;
    margin-bottom: 5px;
  }

  .form-container input {
    padding: 10px;
    border: none;
    border-bottom: 2px solid #ccc;
    margin-bottom: 30px;
    font-size: 18px;
  }

  .form-container button {
    padding: 10px;
    border: none;
    background-color: #4CAF50;
    color: #fff;
    font-size: 18px;
    cursor: pointer;
  }

  .form-container button:hover {
    background-color: #3e8e41;
  }

  .form-container input:focus {
    outline: none;
    border-color: #4CAF50;
  }

  /* Image styles */
  .image-container {
    flex: 1;
  }

  .image-container img {
    max-width: 100%;
    height: auto;
  }

  .image {
    margin: 20px;
  }

  /* Responsive styles */
  @media screen and (max-width: 768px) {
    .container {
      flex-direction: column;
    }
  }
</style>
<?php 
    include "tempplate/loading_screen.php";
?>

<body>
  <div class="container">
    <div class="header">
      <!-- Header content here -->
    </div>
    <div class="form-container">
      <form action="validate.php" method="POST">
        <div class="input-container">
        <?php if (isset($_GET['error'])) { ?>
          <div class="alert alert-danger" role="alert" style="width:100%;height:50px;margin-bottom:10px;">
            <p style="color:red;">
              <?php echo $_GET['error']; ?>
            </p>
          <?php } ?>
        </div>
          <div class="image">
            <img src="image/logo.png" alt="Logo" width="80px" height="80px" style="text-align: center;"><br>
          </div>
          <div class="input-container">
          
          <input type="text" id="email" name="email"placeholder="Email" required>
        </div>
        <div class="input-container">
         
          <input type="password" id="password" name="password" placeholder="Password"required>
        </div>
        <div class="input-container">
          <label for="remember">Remember me:</label>
          <input type="checkbox" id="remember" name="remember">
        </div>
        <div class="forgot-password">
        <a href="#" data-bs-toggle="modal" data-bs-target="#forgotPasswordModal">Forgot Password?</a>
      </div>
        <button style="width:100%;" type="submit">Login</button>

       

      </form>
      
    </div>
  </div>

  <!-- Forgot Password Modal -->
  <div class="modal" id="forgotPasswordModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Forgot Password</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="reset_password.php" method="POST">
            <div class="mb-3">
              <label for="email" class="form-label">Email:</label>
              <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <button type="submit" class="btn btn-success" onclick="resetPassword()">Reset Password</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
    crossorigin="anonymous"></script>







</body>

</html>
