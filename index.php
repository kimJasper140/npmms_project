<?php 
include "config/config.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Naujan Public Market | Home</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <style>
    .success-message {
      color: green;
    }
    .error-message {
      color: red;
    }
  </style>


  <!-- Google Fonts -->
  <link
    href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Jost:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
    rel="stylesheet">


  <link href="assets/template/aos/aos.css" rel="stylesheet">
  <link href="assets/template/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/template/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/template/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/template/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/template/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/template/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link rel="icon" href="image/logo.ico" type="image/x-icon">

  <link href="assets/css/style.css" rel="stylesheet">

</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" style="background-color:#4CAF50; " class="fixed-top ">
    <div class="container d-flex align-items-center">

      <h1 class="logo me-auto"><a href="index.php">Naujan Public Market</a></h1>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class=" scrollto " href="#home">Home</a></li>
          <li><a class="nav-link scrollto" href="#about">About</a></li>
          <li><a class="nav-link scrollto" href="#contacts">Contacts</a></li>
          <li><a class="nav-link scrollto" href="#Feedback">Feedback</a></li>
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
      </nav>

    </div>
  </header>
  <section id="hero" style="background-color:#4CAF50; class=" d-flex align-items-center">

    <div class="container">
      <div class="row">
        <div class="col-lg-6 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-1"
          data-aos="fade-up" data-aos-delay="200">
          <?php
                                $sql = "SELECT * FROM about Where id= 19";
                                $result = mysqli_query($conn, $sql);
                                ($row = mysqli_fetch_assoc($result));
                               ?>
          <h2 style="color:white;"> <?php echo $row['description'];?></h2>
          <div class="d-flex justify-content-center justify-content-lg-start">


          </div>
        </div>
        <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-in" data-aos-delay="200">
          <img src="image/logo.png" class="img-fluid animated" alt="">
        </div>
      </div>
    </div>

  </section>

  <main id="main">


    <section id="about" class="about">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>About Us</h2>
        </div>

        <div class="row content">
          <div class="col-lg-6">
          <?php
                                $sql = "SELECT * FROM about Where id= 17";
                                $result = mysqli_query($conn, $sql);
                                ($row = mysqli_fetch_assoc($result));
                               ?>
            <p>
            <?php echo $row['description'];?>
            </p>
            <ul>
            <?php
                                $sql = "SELECT * FROM about Where id= 17";
                                $result = mysqli_query($conn, $sql);
                                ($row = mysqli_fetch_assoc($result));
                               ?>
              <h2><?php echo $row['Title'];?></h2>
              <?php echo $row['description'];?>
            </ul>
          </div>
          <div class="col-lg-6 pt-4 pt-lg-0">
            <p>
            <?php
                                $sql = "SELECT * FROM about Where id= 16";
                                $result = mysqli_query($conn, $sql);
                                ($row = mysqli_fetch_assoc($result));
                               ?>
                           
            <h2><?php echo $row['Title'];?></h2>
            <?php echo $row['description'];?>
            </p>
            <a href="#" class="btn-learn-more">Contact us</a>
          </div>
        </div>

      </div>
    </section>
    <section id="why-us" class="why-us section-bg">
      <div class="container-fluid" data-aos="fade-up">

        <div class="row">

          <div class="col-lg-7 d-flex flex-column justify-content-center align-items-stretch  order-2 order-lg-1">

            <div class="content">
              <h3> <strong>Application To Lease Market Stalls Within the naujan Compound</strong></h3>
              <p>
                To apply to lease market stalls within the Naujan compound, please follow these steps:
              </p>
            </div>

            <div class="accordion-list">
              <ul>
                <li>
                  <a data-bs-toggle="collapse" class="collapse" data-bs-target="#accordion-list-1"><span>01</span>
                    Contact Market Management: <i class="bx bx-chevron-down icon-show"></i><i
                      class="bx bx-chevron-up icon-close"></i></a>
                  <div id="accordion-list-1" class="collapse show" data-bs-parent=".accordion-list">
                    <p>
                      Reach out to the Naujan market management to express your interest in leasing a stall and inquire
                      about the application process. Obtain the necessary information and forms from them.
                    </p>
                  </div>
                </li>

                <li>
                  <a data-bs-toggle="collapse" data-bs-target="#accordion-list-2" class="collapsed"><span>02</span>
                    Submit Application and Documents <i class="bx bx-chevron-down icon-show"></i><i
                      class="bx bx-chevron-up icon-close"></i></a>
                  <div id="accordion-list-2" class="collapse" data-bs-parent=".accordion-list">
                    <p>
                      Complete the application form provided by the market management. Gather any required documents,
                      such as identification and business registration papers. Submit the application and documents to
                      the market management within the specified timeframe.
                    </p>
                  </div>
                </li>

                <li>
                  <a data-bs-toggle="collapse" data-bs-target="#accordion-list-3"
                    class="collapsed"><span>03</span>Review and Lease Agreement <i
                      class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                  <div id="accordion-list-3" class="collapse" data-bs-parent=".accordion-list">
                    <p>
                      Wait for the market management to review your application. If approved, carefully review the lease
                      agreement provided by them. Make the required payments as outlined in the agreement and adhere to
                      any additional instructions provided.
                    </p>
                  </div>
                </li>

              </ul>
            </div>

          </div>

          <div class="col-lg-5 align-items-stretch order-1 order-lg-2 img"
            style='background-image: url("image/Naujan-Banner-v1.png");' data-aos="zoom-in" data-aos-delay="150">&nbsp;
          </div>
        </div>

      </div>
    </section>


    
    <section id="contacts" class="services section-bg">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Contacts</h2>
          <p>We would love to hear from you! If you have any questions, suggestions, or feedback, please don't hesitate
            to get in touch with us.

          </p>
        </div>

        <div class="row">
          <div class="col-xl-3 col-md-6 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">
            <div class="icon-box">
              <div class="icon"><i class="bi bi-geo-alt"></i></div>
              <?php
                                $sql = "SELECT * FROM about WHERE id = 20";
                                $result = mysqli_query($conn, $sql);
                                $row = mysqli_fetch_assoc($result);
                                ?>
                                <h4>
                                    <a href=""><?php echo $row['Title']; ?></a>
                                </h4>
              <p><?php echo $row['description']; ?></p>
            </div>
          </div>

          <div class="col-xl-3 col-md-6 d-flex align-items-stretch mt-4 mt-md-0" data-aos="zoom-in"
            data-aos-delay="200">
            <div class="icon-box">
              <div class="icon"><i class="bi bi-telephone"></i></div>
              <?php
                                $sql = "SELECT * FROM about WHERE id = 21";
                                $result = mysqli_query($conn, $sql);
                                $row = mysqli_fetch_assoc($result);
                                ?>
                                <h4>
                                    <a href=""><?php echo $row['Title']; ?></a>
                                </h4>
              <p><?php echo $row['description']; ?></p>
            </div>
          </div>

          <div class="col-xl-3 col-md-6 d-flex align-items-stretch mt-4 mt-xl-0" data-aos="zoom-in"
            data-aos-delay="300">
            <div class="icon-box">
              <div class="icon"><i class="bi bi-envelope-at"></i></div>
              <?php
                                $sql = "SELECT * FROM about WHERE id = 22";
                                $result = mysqli_query($conn, $sql);
                                $row = mysqli_fetch_assoc($result);
                                ?>
                                <h4>
                                    <a href=""><?php echo $row['Title']; ?></a>
                                </h4>
              <p><?php echo $row['description']; ?></p>

            </div>

          </div>

          <div class="col-xl-3 col-md-6 d-flex align-items-stretch mt-4 mt-xl-0" data-aos="zoom-in"
            data-aos-delay="400">
            <div class="icon-box">
              <div class="icon"><i class="bx bx-layer"></i></div>
              <?php
                                $sql = "SELECT * FROM about WHERE id = 23";
                                $result = mysqli_query($conn, $sql);
                                $row = mysqli_fetch_assoc($result);
                                ?>
                                <h4>
                                    <a href=""><?php echo $row['Title']; ?></a>
                                </h4>
              <p><?php echo $row['description']; ?></p>
            </div>
          </div>

        </div>

      </div>
    </section>
  
   
    <section id="Feedback" class="team section-bg">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Feedback</h2>
          <p>We value your feedback and would love to hear from you! Please take a moment to share your thoughts,
            suggestions, or comments with us using the feedback form below. Your feedback is essential in helping us
            improve our services and better meet your needs.

            We appreciate your time and thank you for your valuable input. Please fill out the form below and click the
            "Submit" button to send us your feedback.</p>
        </div>

        <div class="row">

        <div class="container">
    <h2>Feedback Form</h2>
    <?php
    // Check if success message is set
    if (isset($_GET['success'])) {
      echo '<p class="success-message">Feedback added successfully.</p>';
    }
    // Check if error message is set
    elseif (isset($_GET['error'])) {
      echo '<p class="error-message">Error adding feedback.</p>';
    }
    ?>
    <?php
    // Check if success message is set
    if (isset($_GET['success'])) {
      echo "<script>";
      echo "if ('Notification' in window) {";
      echo "  Notification.requestPermission().then(function(permission) {";
      echo "    if (permission === 'granted') {";
      echo "      var notification = new Notification('Submitted Successfully', {";
      echo "        body: 'Your feedback had been sumbitted successfully.'";
      echo "      });";
      echo "      notification.onclick = function(event) {";
      echo "        event.preventDefault();";
      echo "        window.location.href = 'https://naujan-public-market-ms.epizy.com/';"; // Replace with the URL you want to redirect to
      echo "      };";
      echo "    }";
      echo "  });";
      echo "}";
      echo "</script>";
    }
    // Check if error message is set
    elseif (isset($_GET['error'])) {
      echo "<script>";
      echo "if ('Notification' in window) {";
      echo "  Notification.requestPermission().then(function(permission) {";
      echo "    if (permission === 'granted') {";
      echo "      var notification = new Notification('Feedback Submission Failed', {";
      echo "        body: 'Something went wrong. Please refresh the website and try again.'";
      echo "      });";
      echo "      notification.onclick = function(event) {";
      echo "        event.preventDefault();";
      echo "        window.location.href = 'https://naujan-public-market-ms.epizy.com/';"; // Replace with the URL you want to redirect to
      echo "      };";
      echo "    }";
      echo "  });";
      echo "}";
      echo "</script>";
    }
    ?>
    <form action="admin-functions/add_feedback.php" method="post">
      <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" class="form-control" id="name" name="name" required>
      </div>
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" class="form-control" id="email" name="email" required>
      </div>
      <div class="form-group">
        <label for="message">Message:</label>
        <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
      </div>
      <button type="submit" class="btn btn-success">Submit</button>
    </form>
  </div>

  <div class="dropdown position-fixed bottom-0 end-0 mb-3 me-3 bd-mode-toggle">
      <button class="btn btn-bd-primary py-2 dropdown-toggle d-flex align-items-center"
              id="bd-theme"
              type="button"
              aria-expanded="false"
              data-bs-toggle="dropdown"
              aria-label="Toggle theme (auto)">
        <svg class="bi my-1 theme-icon-active" width="1em" height="1em"><use href="#circle-half"></use></svg>
        <span class="visually-hidden" id="bd-theme-text">Toggle theme</span>
      </button>
      <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bd-theme-text">
        <li>
          <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="light" aria-pressed="false">
            <svg class="bi me-2 opacity-50 theme-icon" width="1em" height="1em"><use href="#sun-fill"></use></svg>
            Light
            <svg class="bi ms-auto d-none" width="1em" height="1em"><use href="#check2"></use></svg>
          </button>
        </li>
        <li>
          <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark" aria-pressed="false">
            <svg class="bi me-2 opacity-50 theme-icon" width="1em" height="1em"><use href="#moon-stars-fill"></use></svg>
            Dark
            <svg class="bi ms-auto d-none" width="1em" height="1em"><use href="#check2"></use></svg>
          </button>
        </li>
        <li>
          <button type="button" class="dropdown-item d-flex align-items-center active" data-bs-theme-value="auto" aria-pressed="true">
            <svg class="bi me-2 opacity-50 theme-icon" width="1em" height="1em"><use href="#circle-half"></use></svg>
            Auto
            <svg class="bi ms-auto d-none" width="1em" height="1em"><use href="#check2"></use></svg>
          </button>
        </li>
      </ul>
    </div>

    
    </section>

    <div style="background-color:#4CAF50; class=" container footer-bottom clearfix">
      <div style="color:white; class=" copyright">
        All Rights Reserved
      </div>
      <div class="credits">

      </div>
    </div>
    </footer>

    <div id="preloader"></div>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
        class="bi bi-arrow-up-short"></i></a>


    <script src="assets/template/aos/aos.js"></script>
    <script src="assets/template/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/template/glightbox/js/glightbox.min.js"></script>
    <script src="assets/template/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="assets/template/swiper/swiper-bundle.min.js"></script>
    <script src="assets/template/waypoints/noframework.waypoints.js"></script>
    <script src="assets/template/php-email-form/validate.js"></script>

    <script src="assets/js/main.js"></script>

</body>

</html>
