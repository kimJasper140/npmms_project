

    
<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
<link rel="icon" type="image/x-icon" href="../admin/profile/logo.ico">
<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="../bootstrap/icons/bootstrap-icons.min.css">
<link rel="stylesheet" href="../admin/sidebar/css/style.css">


		
		<div class="wrapper d-flex align-items-stretch">
			<nav id="sidebar" class="bg-success;">
				<div class="p-4 pt-5">
        <a href="#" class="img logo rounded-circle mb-1 " style="background-image: url('<?php 

    echo '../admin/profile/logo.png';
   ?>');">
  
</a>

	        <ul class="list-unstyled components mb-5">
	          
	          <li>
	              <a href="dashboard-admin.php">Dashboard</a>
	          </li>
            <li class="">
	            <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">User</a>
	            <ul class="collapse list-unstyled" id="homeSubmenu">
                <li>
                    <a href="user_management.php">Active</a>
                </li>
                <li>
                    <a href="#">InActive</a>
                </li>
               
	            </ul>
	          </li>
	          <li>
              <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Application</a>
              <ul class="collapse list-unstyled" id="pageSubmenu">
                <li>
                    <a href="#">Pending Application</a>
                </li>
                <li>
                    <a href="#">Approved Application</a>
                </li>
                <li>
                    <a href="#">Cancelled</a>
                </li>
                <li>
                    <a href="#">Declined</a>
                </li>
              </ul>
	          </li>
	          <li>
              <a href="#">SRP</a>
	          </li>
	          <li>
              <a href="#">About</a>
	          </li>
            <li>
              <a href="#">Setting</a>
	          </li>
            

	        <div class="footer">
          <li>
              <a href="#">Logout</a>
	          </li>
	        </div>

	      </div>
    	</nav>
      <div id="content" class="p-4 p-md-5">

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <div class="container-fluid">

            <button type="button" id="sidebarCollapse" class="btn btn-primary">
              <i class="bi bi-list"></i>
              <span class="sr-only">Toggle Menu</span>
            </button>
            <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="bi bi-list"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="nav navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../admin/annoucement.php">Announcement</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Stall</a>
                <li class="nav-item">
                    <a class="nav-link bi bi-bell" href="#" ></a>
                </li>
              </ul>
            </div>
          </div>
        </nav>


 

