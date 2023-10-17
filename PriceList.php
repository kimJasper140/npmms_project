<?php
include "config/config.php";

// Define variables for search
$searchProductName = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $searchProductName = $_POST["search_product_name"];
    // Modify the SQL query to include the search condition
    $sql = "SELECT * FROM srp WHERE product_name LIKE '%$searchProductName%'";
} else {
    // Default SQL query to fetch all data
    $sql = "SELECT * FROM srp";
}

// Fetch data from the srp table
$result = $conn->query($sql);
?>



<title>Naujan Public Market | Price List    </title>
<link rel="icon" href="image/logo.ico" type="image/x-icon">
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Jost:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
<link href="assets/vendor/aos/aos.css" rel="stylesheet">
<link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
<link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
<link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
<link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
<link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
<link href="assets/css/style.css" rel="stylesheet">
</head>
<script src="assets/vendor/aos/aos.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
<script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
<script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
<script src="assets/vendor/waypoints/noframework.waypoints.js"></script>
<script src="assets/vendor/php-email-form/validate.js"></script>
<script src="assets/js/main.js"></script>
<?php include "header-home.php" ?>
<style>
    /* Add CSS for responsiveness */
    img {
      max-width: 50px;
      height: auto;
      display: block;
      margin: 0 auto;
    
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      background-color: #fff;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
  
    th,
    td {
      padding: 12px 15px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }
  
    th {
      background-color: #f9f9f9;
      font-weight: 600;
    }
  
    body{
      margin:10%;
    }
    @media screen and (max-width: 480px) {
            /* Adjust styles for smaller screens */
            body {
                margin: 5%;
                padding-top: 30%;
            }

            table {
                margin-top: 10px;
            }
        }
    
  </style>
   <div class="section-title">
          <h2>Suggested Retail price </h2>
          <p>Ang tamang presyo at tamang kalidad ng produkto ay mahalaga upang maibigay ang pinakamahusay na halaga sa
            mga mamimili. Ito ay nagpapahiwatig ng patas na transaksyon kung saan ang halaga ng pera ng mamimili ay
            tugma sa kalidad ng binili nilang produkto. Sa pamamagitan nito, nagkakaroon ng tiwala at kasiyahan ang mga
            mamimili at nagpapanatili ng magandang reputasyon para sa negosyo.</p>
        </div>
        <div class="container">
        <h4>Product Search</h4>
        <form method="POST" class="form-inline mb-4" style="width:50%;">
            <input type="text" name="search_product_name" class="form-control mr-2" placeholder="Search by Product Name" value="<?php echo $searchProductName; ?>">
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
        <?php
        // Display data in the table
        if ($result->num_rows > 0) {
            echo '<div class="table-responsive">';
            echo '<table class="table table-bordered">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Product Name</th>';
            echo '<th>Price</th>';
            echo '<th>Date</th>';
            echo '<th>Image</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row['product_name'] . '</td>';
                echo '<td>' . $row['price'] . '</td>';
                echo '<td>' . $row['date'] . '</td>';
                echo '<td><img src="image/' . $row['image'] . '" height="50"></td>';
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';
            echo '</div>';
        } else {
            echo "No products found.";
        }
        ?>
    </div>
