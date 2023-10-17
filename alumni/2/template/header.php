<? 
include("config/config.php");
include("session.php");
session_start();



?>



<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <link href="template/headerStyle.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</head>
<script>
    function logout() {
  // Prompt the user to confirm logout
  var confirmed = confirm("Are you sure you want to log out?");

  if (confirmed) {
    // If the user confirms, redirect to the logout page
    window.location.href = "logout.php";
  } else {
    // If the user cancels, do nothing
    return;
  }
}

</script>
<body>
<div class="container" style="margin-left:-20px;margin-top:-15px;">
        <div class="topbar" >
            <div class="logo" style="margin-left:25px;">
            <h2><img src="images/logo.PNG" alt="User" class="user" width="10px" height="10px" style="border-radius:50px;">NPMMS </h2>
            
  </div>
  </div>
        <div class="sidebar">welcome,
     <?php // echo (isset($_SESSION['user']));?>
            <ul>
             <li>
                    <a href="Home.php">
                    <i class="bi bi-speedometer2"></i>
                        <div>Dashboard</div>
                    </a>
                </li>
                <li>
                    <a href="About.php">
                    <i class="bi bi-question-circle-fill"></i>
                        <div>About</div>
                    </a>
                </li>
                <li>
                    <a href="#">
                    <i class="bi bi-shop"></i>
                        <div>Stall List</div>
                    </a>
                </li>
                <li>
                    <a href="#">
                    <i class="bi bi-newspaper"></i>
                        <div>News</div>
                    </a>
                </li>
                <li>
                    <a href="#">
                    <i class="bi bi-calendar-event"></i>
                        <div>Events</div>
                    </a>
                </li>
                <li>
                    <a href="#">
                    <i class="bi bi-bell"></i>
                        <div>Notification</div>
                    </a>
                </li>
                <li>
                    <a href="annoucement.php">
                    <i class="bi bi-megaphone"></i>
                        <div>Annoucement</div>
                    </a>
                </li>
                <li>
                    <a href="">
                    <i class="bi bi-gear-fill"></i>
                        <div>Setting</div>
                    </a>
                </li>
                </li>
                <li>
                    <a href="#">
                    <i class="bi bi-box-arrow-left"></i>
                    <button  style="background-color: transparent;border:none; margin-left:-90px;" id="logout-button" onclick="logout()">Logout</button>

                    </a>
                </li>
                
            </ul>
        </div>
  
        