<?php
include("../config/config.php");

if (isset($_GET['id'])) {
  $id = $_GET['id'];

  // Fetch product details from the srp table
  $sql = "SELECT * FROM srp WHERE id = $id";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $product_details = array(
      'product_name' => $row['product_name'],
      'price' => $row['price'],
      'image' => $row['image']
    );
    echo json_encode($product_details);
  }
}


// Close the database connection
$conn->close();

?>
