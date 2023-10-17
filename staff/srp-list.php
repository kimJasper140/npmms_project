<?php
include("../config/config.php");
include "checking_user.php";

// Function to get product details by ID
function getProductDetails($id)
{
    global $conn;
    $sql = "SELECT * FROM srp WHERE id = $id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return null;
    }
}

if (isset($_POST['add'])) {
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $image = $_FILES['image']['name']; // Get the uploaded image file name

    // Insert the data into the srp table
    $sql = "INSERT INTO srp (product_name, price, image) VALUES ('$product_name', '$price', '$image')";
    if ($conn->query($sql) === TRUE) {
        // Upload the image file
        move_uploaded_file($_FILES['image']['tmp_name'], "../image/" . $image);
        echo "<script>alert('Product added successfully');</script>";
        echo "<script>window.location.href='srp-list.php';</script>"; // Redirect to the index page after successful insertion
    } else {
        echo "Error: " . $sql . "<br>";
    }
}

// Check if the delete parameter is set
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    // Get the product details to delete the associated image file
    $productDetails = getProductDetails($id);
    $image = $productDetails['image'];

    // Delete the product from the srp table
    $sql = "DELETE FROM srp WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        // Delete the associated image file
        if (!empty($image)) {
            unlink("../image/" . $image);
        }
        echo "<script>alert('Product deleted successfully');</script>";
        echo "<script>window.location.href='srp-list.php';</script>"; // Redirect to the index page after successful deletion
    } else {
        echo "Error: " . $sql . "<br>";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>SRP | admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="icon" href="../image/logo.ico" type="image/x-icon">
    <link rel="stylesheet" href="../template/side-bar.css">
    <style> 
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 0;
    }
    .edit-button {
    display: inline-block;
    padding: 6px 12px;
    background-color: #4CAF50;
    color: white;
    text-decoration: none;
    border-radius: 4px;
    transition: background-color 0.3s;
  }

  .edit-button:hover {
    background-color: #45a049;
  }

  .delete-button {
    display: inline-block;
    padding: 6px 12px;
    background-color: #f44336;
    color: white;
    text-decoration: none;
    border-radius: 4px;
    transition: background-color 0.3s;
  }

  .delete-button:hover {
    background-color: #d32f2f;
  }

    .container {
      max-width: 800px;
      margin: 20px auto;
      margin-left: 50px;
      padding: 20px;
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h1 {
      text-align: center;
      color: #228B22;
    }

    .add-button-container {
      text-align: center;
      margin-bottom: 20px;
    }

    .add-button {
      display: inline-block;
      padding: 8px 16px;
      background-color: #228B22;
      color: #fff;
      text-decoration: none;
      border-radius: 5px;
      transition: background-color 0.3s;
      margin-right: 50px;
    }

    .add-button:hover {
      background-color: #007B00;
    }

    table {
      border-collapse: collapse;
      width: 100%;
    }

    th, td {
      border: 1px solid #ccc;
      padding: 8px;
      text-align: left;
    }

    th {
      background-color: #f2f2f2;
    }

    /* Modal Styling */
    .modal {
                display: none;
                position: fixed;
                z-index: 1;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                overflow: auto;
                background-color: rgba(0, 0, 0, 0.5);
            }

            .modal-content {
                background-color: #fff;
                margin: 10% auto;
                padding: 20px;
                border: 1px solid #ccc;
                max-width: 600px;
            }

    .close {
      color: #aaa;
      float: right;
      font-size: 28px;
      font-weight: bold;
      cursor: pointer;
    }

    .close:hover,
    .close:focus {
      color: black;
      text-decoration: none;
      cursor: pointer;
    }

    .modal-form label {
      display: block;
      margin-top: 10px;
    }

    .modal-form input[type="text"], .modal-form input[type="file"] {
      width: 100%;
      padding: 5px;
      border-radius: 3px;
      border: 1px solid #ccc;
    }

    .modal-form input[type="submit"] {
      display: block;
      margin-top: 20px;
      padding: 8px 16px;
      background-color: #228B22;
      color: #fff;
      text-decoration: none;
      border-radius: 5px;
      transition: background-color 0.3s;
    }

    .modal-form input[type="submit"]:hover {
      background-color: #007B00;
    }

    @media screen and (max-width: 600px) {
      .container {
        max-width: 100%;
        border-radius: 0;
        box-shadow: none;
        padding: 10px;
      }
    }
  </style>
</head>
<body>
<script>
            function logout() {
                // Display a confirmation message
                var confirmed = confirm('Are you sure you want to log out?');

                // If the user confirms, redirect to the logout page
                if (confirmed) {
                    window.location.href = '../logout.php';
                }
                else {
                    //
                }
            }


</script>
    <?php include "sidebar-staff.php"; ?>
    <div class="container" style="margin-left: 20%; margin-top: 80px;">
        <h1 style="margin-left: -50%;">Suggested Retail Price</h1>
        <div class="add-button-container" style="margin-right: -80%;">
            <a class="add-button" style="color:white;" onclick="openModal()">Add Product</a>
        </div>

        <?php
        // Fetch data from the srp table
        $sql = "SELECT * FROM srp";
        $result = $conn->query($sql);

        // Display data in the table
        if ($result->num_rows > 0) {
            echo '<table>';
            echo '<tr>';
            echo '<th>Product Name</th>';
            echo '<th>Price</th>';
            echo '<th>Date</th>';
            echo '<th>Image</th>';
            echo '<th>Actions</th>';
            echo '</tr>';

            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row['product_name'] . '</td>';
                echo '<td>' . $row['price'] . '</td>';
                echo '<td>' . $row['date'] . '</td>';
                echo '<td><img src="../image/' . $row['image'] . '" height="50"></td>';
                echo '<td><a class="edit-button" href="javascript:void(0)" onclick="openEditModal(' . $row['id'] . ')">Edit</a> <a class="delete-button" href="?delete=' . $row['id'] . '">Delete</a></td>';
                echo '</tr>';
            }

            echo '</table>';
        } else {
            echo "No products found.";
        }
        ?>
    </div>

    <!-- Add Product Modal -->
    <div id="addModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Add Product</h2>
            <form action="" method="post" enctype="multipart/form-data">
                <input type="text" name="product_name" placeholder="Product Name" required><br><br>
                <input type="number" name="price" placeholder="Price" required><br><br>
                <input type="file" name="image" required><br><br>
                <input type="submit" name="add" value="Add">
            </form>
        </div>
    </div>

    <!-- Edit Product Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeEditModal()">&times;</span>
            <h2>Edit Product</h2>
            <form id="modalForm" action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" id="edit_id">
                <input type="text" name="product_name" id="edit_product_name" placeholder="Product Name" required><br><br>
                <input type="number" name="price" id="edit_price" placeholder="Price" required><br><br>
                <input type="file" name="image"><br><br>
                <input type="submit" name="edit" value="Edit">
            </form>
        </div>
    </div>

    <script>
        // Function to open the add product modal
        function openModal() {
            document.getElementById("addModal").style.display = "block";
        }

        // Function to close the add product modal
        function closeModal() {
            document.getElementById("addModal").style.display = "none";
        }

        // Function to open the edit product modal and populate the form fields
        function openEditModal(id) {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response !== null) {
                        document.getElementById("edit_id").value = response.id;
                        document.getElementById("edit_product_name").value = response.product_name;
                        document.getElementById("edit_price").value = response.price;

                        // Create and display the product image if available
                        if (response.image !== "") {
                            var img = document.createElement("img");
                            img.src = "../image/" + response.image;
                            img.height = 50;
                            document.getElementById("editModal").querySelector(".modal-content").appendChild(img);
                        }

                        document.getElementById("editModal").style.display = "block";
                    }
                }
            };
            xhr.open("GET", "get_product_details.php?id=" + id, true);
            xhr.send();
        }

        // Function to close the edit product modal
        function closeEditModal() {
            document.getElementById("editModal").style.display = "none";
            document.getElementById("editModal").querySelector(".modal-content").innerHTML = "";
        }
    </script>
</body>

</html>