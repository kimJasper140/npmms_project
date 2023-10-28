<?php
include("../config/config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $id = $_POST['id'];
  $product_name = $_POST['product_name'];
  $price = $_POST['price'];
  $fileInfo = $_FILES['image'];
  $image = $fileInfo['name'];
  move_uploaded_file($_FILES['image']['tmp_name'], "../image/" . $image);

  // Update the product in the srp table
  $sql = "UPDATE srp SET product_name = '$product_name', price = $price, image = '$image' WHERE id = $id;";
  if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Product updated successfully');</script>";
    echo "<script>window.location.href='srp-list.php';</script>"; // Redirect to the index page after successful update
  } else {
    echo "Error: " . $sql . "<br>";
  }
}

// Close the database connection
$conn->close();
?>
