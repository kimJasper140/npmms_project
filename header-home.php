<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Naujan Public Market | Home</title>
  <link rel="icon" href="image/logo.ico" type="image/x-icon">
  <meta content="" name="description">
  <meta content="" name="keywords">


  <!-- Google Fonts -->
  <link
    href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Jost:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
    rel="stylesheet">

  <link rel="icon" href="../image/logo.png" type="image/x-icon">
  <link href="assets/template/aos/aos.css" rel="stylesheet">
  <link href="assets/template/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/template/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/template/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/template/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/template/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/template/swiper/swiper-bundle.min.css" rel="stylesheet">


  <link href="assets/css/style.css" rel="stylesheet">

</head>
<script>
  // Toggle mobile navigation
  const mobileNavToggle = document.getElementById('mobile-nav-toggle');
  const navbar = document.getElementById('navbar');

  mobileNavToggle.addEventListener('click', () => {
    navbar.classList.toggle('nav-active');
  });
</script>
<?php
include "tempplate/loading_screen.php";
?>

<body>

  <!-- ======= Header ======= -->
  <header id="header" style="background-color:#4CAF50; " class="fixed-top ">
    <div class="container d-flex align-items-center">

      <h1 class="logo me-auto"><a href="index.php">Naujan Public Market</a></h1>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class=" scrollto " href="index.php">Home</a></li>
          <li><a class="nav-link scrollto" href="index.php">About</a></li>
          <li><a class="nav-link scrollto" href="index.php">Contacts</a></li>
          <li><a class="nav-link scrollto" href="index.php">Feedback</a></li>
          <li class="dropdown"><a href="#"><span>More</span> <i class="bi bi-chevron-down"></i></a>
            <ul>

              <li class="dropdown"><a href="#"><span>Inquire for Stall</span> <i class="bi bi-chevron-right"></i></a>
                <ul>
                  <li><a href="contract-citizen-charter.php">how to apply?</a></li>
                  <li><a href="contract.php">Terms for Contract</a></li>
                  <li><a href="application.php">Pre-application form</a></li>
                  <li><a href="stall.php">Vacant Stall</a></li>

                </ul>
              </li>
              <li class="dropdown"><a href="#"><span>Citizen's Charter</span> <i class="bi bi-chevron-right"></i></a>
                <ul>
                  <li><a href="citizen-charter.php">Payment of Monthly Stall Fee </a></li>
                  <li><a href="contract-citizen-charter.php">Securing Contract to Lease</a></li>

                </ul>
              </li>
              <li><a href="PriceList.php">Suggested Retail Price</a></li>



            </ul>
          </li>
          <li><a class="nav-link scrollto" href="annoucement-section.php">Announcement</a></li>
          <li><a class="getstarted scrollto" href="login.php">Log in</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->
  <script src="assets/template/aos/aos.js"></script>
  <script src="assets/template/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/template/glightbox/js/glightbox.min.js"></script>
  <script src="assets/template/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/template/swiper/swiper-bundle.min.js"></script>
  <script src="assets/template/waypoints/noframework.waypoints.js"></script>
  <script src="assets/template/php-email-form/validate.js"></script>

  <script src="assets/js/main.js"></script>