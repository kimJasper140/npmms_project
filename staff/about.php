<?php
include("../config/config.php");
include "checking_user.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_POST['id'];
        $description = $_POST['description'];

        // Update the About information in the database
        $sql = "UPDATE about SET description='$description' WHERE id='$id'";
        if (mysqli_query($conn, $sql)) {
            // Redirect to the about page
            header("Location: about.php");
            exit();
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
    }
    ?>

    <!DOCTYPE html>
    <html>

    <head>
        <title>About Page - Admin</title>
        <link rel="icon" href="../image/logo.ico" type="image/x-icon">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        <link href="assets/vendor/aos/aos.css" rel="stylesheet">
        <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
        <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
        <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
        <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
        <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
        <link rel="icon" href="image/logo.ico" type="image/x-icon">

        <link href="../assets/css/style.css" rel="stylesheet">
        <style>
            .edit-form textarea {
                width: 100%;
                height: 150px;
                padding: 10px;
                border: 1px solid #ccc;
                resize: vertical;
            }

            .edit-form button {
                padding: 10px 20px;
                background-color: #007bff;
                border: none;
                color: #fff;
                cursor: pointer;
            }

            @media screen and (max-width: 768px) {
                .edit-form textarea {
                    width: 100% !important;
                    height: 150px;
                    padding: 10px;
                    border: 1px solid #ccc;
                    resize: vertical;
                }

                .edit-form button {
                    padding: 10px 20px;
                    background-color: #007bff;
                    border: none;
                    color: #fff;
                    cursor: pointer;
                }

                /* Custom styles for responsiveness */
                body {
                    overflow-x: hidden;
                    /* Hide horizontal scrollbars */
                }

                #main {

                    margin-left: -5% !important;
                    ;
                }

                .section-title {
                    text-align: center;
                    margin-bottom: 40px;
                }

                .row.content {
                    flex-direction: column;
                    align-items: center;
                    text-align: center;
                }

                .col-lg-6,
                .col-lg-6 .edit-form {
                    max-width: 100%;
                }

                .col-lg-6 p {
                    text-align: justify;
                }
            }
        </style>
        <script>
            function logout() {
                // Display a confirmation message
                var confirmed = confirm('Are you sure you want to log out?');

                // If the user confirms, redirect to the logout page
                if (confirmed) {
                    window.location.href = '../logout.php';
                } else {
                    //
                }
            }
        </script>

    </head>

    <body>
        <?php include '../admin/sidebar-admin.php'; ?>

        <main style="margin-left:20%;" id="main">
            <section id="about" class="about">
                <div class="container" data-aos="fade-up">

                    <div class="section-title">
                        <h2>About Us</h2>
                    </div>
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
                                    <h2 style="color:white;">
                                        <div class="edit-form">
                                            <?php if (isset($_GET['edit4'])): ?>
                                                <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                    <textarea name="description"><?php echo $row['description']; ?></textarea>
                                                    <br>
                                                    <button type="submit">Update</button>
                                                </form>
                                            <?php else: ?>
                                                <p>
                                                    <?php echo $row['description']; ?>
                                                </p>
                                                <a href="<?php echo $_SERVER['PHP_SELF'] . '?edit4=1'; ?>">Edit</a>
                                            <?php endif; ?>
                                        </div>
                                    </h2>
                                    <div class="d-flex justify-content-center justify-content-lg-start">


                                    </div>
                                </div>
                                <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-in" data-aos-delay="200">
                                    <img src="../image/logo.png" class="img-fluid animated" alt="">
                                </div>
                            </div>
                        </div>

                    </section>
                    <div class="row content">
                        <div class="col-lg-6">
                            <p>
                                <?php
                                $sql = "SELECT * FROM about WHERE id = 18";
                                $result = mysqli_query($conn, $sql);
                                $row = mysqli_fetch_assoc($result);
                                ?>
                            <div class="edit-form">
                                <?php if (isset($_GET['edit1'])): ?>
                                    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                        <textarea name="description"><?php echo $row['description']; ?></textarea>
                                        <br>
                                        <button type="submit">Update</button>
                                    </form>
                                <?php else: ?>
                                    <p>
                                        <?php echo $row['description']; ?>
                                    </p>
                                    <a href="<?php echo $_SERVER['PHP_SELF'] . '?edit1=1'; ?>">Edit</a>
                                <?php endif; ?>
                            </div>
                            </p>
                            <ul>

                                <?php
                                $sql = "SELECT * FROM about WHERE id = 17";
                                $result = mysqli_query($conn, $sql);
                                $row = mysqli_fetch_assoc($result);
                                ?>
                                <h2>
                                    <?php echo $row['Title']; ?>
                                </h2>
                                <div class="edit-form">
                                    <?php if (isset($_GET['edit2'])): ?>
                                        <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                            <textarea name="description"><?php echo $row['description']; ?></textarea>
                                            <br>
                                            <button type="submit">Update</button>
                                        </form>
                                    <?php else: ?>
                                        <p>
                                            <?php echo $row['description']; ?>
                                        </p>
                                        <a href="<?php echo $_SERVER['PHP_SELF'] . '?edit2=1'; ?>">Edit</a>
                                    <?php endif; ?>
                                </div>
                                </h2>
                            </ul>
                        </div>
                        <div class="col-lg-6 pt-4 pt-lg-0">

                            <?php
                            $sql = "SELECT * FROM about WHERE id = 16";
                            $result = mysqli_query($conn, $sql);
                            $row = mysqli_fetch_assoc($result);
                            ?>
                            <h2>
                                <?php echo $row['Title']; ?>
                            </h2>
                            <div class="edit-form">
                                <?php if (isset($_GET['edit3'])): ?>
                                    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                        <textarea name="description"><?php echo $row['description']; ?></textarea>
                                        <br>
                                        <button type="submit">Update</button>
                                    </form>
                                <?php else: ?>
                                    <p>
                                        <?php echo $row['description']; ?>
                                    </p>
                                    <a href="<?php echo $_SERVER['PHP_SELF'] . '?edit3=1'; ?>">Edit</a>
                                <?php endif; ?>
                            </div>
                            </h2>
                        </div>
                    </div>

                </div>
            </section><!-- End About Us Section -->
            <!-- ======= Services Section ======= -->
            <section id="services" class="services section-bg">
                <div class="container" data-aos="fade-up">

                    <div class="section-title">
                        <h2>Contacts</h2>
                        <p>We would love to hear from you! If you have any questions, suggestions, or feedback, please don't
                            hesitate
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
                                <h2>
                                    <?php echo $row['Title']; ?>
                                </h2>
                                <div class="edit-form">
                                    <?php if (isset($_GET['edit5'])): ?>
                                        <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                            <textarea name="description"><?php echo $row['description']; ?></textarea>
                                            <br>
                                            <button type="submit">Update</button>
                                        </form>
                                    <?php else: ?>
                                        <p>
                                            <?php echo $row['description']; ?>
                                        </p>
                                        <a href="<?php echo $_SERVER['PHP_SELF'] . '?edit5=1'; ?>">Edit</a>
                                    <?php endif; ?>
                                </div>
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
                                <h2>
                                    <?php echo $row['Title']; ?>
                                </h2>
                                <div class="edit-form">
                                    <?php if (isset($_GET['edit6'])): ?>
                                        <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                            <textarea name="description"><?php echo $row['description']; ?></textarea>
                                            <br>
                                            <button type="submit">Update</button>
                                        </form>
                                    <?php else: ?>
                                        <p>
                                            <?php echo $row['description']; ?>
                                        </p>
                                        <a href="<?php echo $_SERVER['PHP_SELF'] . '?edit6=1'; ?>">Edit</a>
                                    <?php endif; ?>
                                </div>
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
                                <h2>
                                    <?php echo $row['Title']; ?>
                                </h2>
                                <div class="edit-form">
                                    <?php if (isset($_GET['edit8'])): ?>
                                        <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                            <textarea name="description"><?php echo $row['description']; ?></textarea>
                                            <br>
                                            <button type="submit">Update</button>
                                        </form>
                                    <?php else: ?>
                                        <p>
                                            <?php echo $row['description']; ?>
                                        </p>
                                        <a href="<?php echo $_SERVER['PHP_SELF'] . '?edit8=1'; ?>">Edit</a>
                                    <?php endif; ?>
                                </div>

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
                                <h2>
                                    <?php echo $row['Title']; ?>
                                </h2>
                                <div class="edit-form">
                                    <?php if (isset($_GET['edit7'])): ?>
                                        <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                            <textarea name="description"><?php echo $row['description']; ?></textarea>
                                            <br>
                                            <button type="submit">Update</button>
                                        </form>
                                    <?php else: ?>
                                        <p>
                                            <?php echo $row['description']; ?>
                                        </p>
                                        <a href="<?php echo $_SERVER['PHP_SELF'] . '?edit7=1'; ?>">Edit</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </section><!-- End Services Section -->

        </main>

        <script>
            <?php if (isset($_GET['edit1'])): ?>
                window.onload = function () {
                    var editForm1 = document.querySelector('.edit-form:nth-of-type(1)');
                    var textarea1 = editForm1.querySelector('textarea');
                    textarea1.removeAttribute('readonly');
                }
            <?php endif; ?>

            <?php if (isset($_GET['edit2'])): ?>
                window.onload = function () {
                    var editForm2 = document.querySelector('.edit-form:nth-of-type(2)');
                    var textarea2 = editForm2.querySelector('textarea');
                    textarea2.removeAttribute('readonly');
                }
            <?php endif; ?>

            <?php if (isset($_GET['edit3'])): ?>
                window.onload = function () {
                    var editForm3 = document.querySelector('.edit-form:nth-of-type(3)');
                    var textarea3 = editForm3.querySelector('textarea');
                    textarea3.removeAttribute('readonly');
                }
            <?php endif; ?>
        </script>

        <script src="assets/vendor/aos/aos.js"></script>
        <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
        <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
        <script src="assets/vendor/php-email-form/validate.js"></script>
        <script src="assets/vendor/purecounter/purecounter.js"></script>
        <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

    </body>

    </html>
