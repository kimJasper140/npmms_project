<?php
include "config/config.php";
?><!DOCTYPE html>
<html>
<head>
    <title>Announcements</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="image/logo.ico" type="image/x-icon">
        <style>
    /* Global Styles */
    body {
            font-family: Arial, sans-serif;
            background-color: #F2F2F2;
            margin: 0;
        }

        h1 {
            color: #006400;
            text-align: center;
            margin-bottom: 20px;
        }

        .announcement {
            background-color: #FFF;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .announcement h2 {
            color: #006400;
            margin-top: 0;
        }

        .announcement p {
            color: #333;
        }

        .announcement img {
            max-width: 80%;
            height: auto;
            margin-top: 10px;
            margin-left: 10%;
        }

        .announcement .action-btns {
            display: flex;
            justify-content: flex-end;
            margin-top: 10px;
        }

        .announcement .action-btns button {
            background-color: transparent;
            border: none;
            color: #006400;
            cursor: pointer;
            margin-left: 10px;
        }

        .announcement .action-btns button i {
            margin-right: 5px;
        }

        .form-container {
            background-color: #FFF;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .form-container label {
            display: block;
            margin-bottom: 10px;
            color: #333;
        }

        .form-container input[type="text"],
        .form-container textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #CCC;
            border-radius: 5px;
        }

        .form-container input[type="submit"] {
            background-color: #006400;
            color: #FFF;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    /* Responsive Styles */
    @media (max-width: 768px) {
    body {
        margin: 0;
        padding-top: 18%;
    }
    .content {
        padding: 10px;
     
    }
    .announcement {
        padding: 10px;
    }
   
}


    </style>
</head>
<?php
include "header-home.php";

    ?>
<body style="margin:5%;margin-top:-3%">
 
 
        <h1 style="margin-top:10%;">Announcements</h1>
        <label for="category">Preview Filter: </label>
        <select input type = "text" name = "announcement" id = "category" style="border-bottom: 1px solid #000;" required>
            <option value="default">Select a Category</option>
            <option value="category1">Category 1</option>
            <option value="category2">Category 2</option>
            <option value="category3">Category 3</option>
            <option value="category4">Category 4</option>
        </select>
 
        <?php
        // Retrieve announcement details from the database in descending order
        $query = "SELECT * FROM announcements ORDER BY id DESC";
        $result = $conn->query($query);

        // Loop through each announcement
        while ($row = $result->fetch_assoc()) {
            $title = $row['title'];
            $content = $row['content'];
            $postDate = $row['post_date'];
            $image = $row['image'];

            // Display the announcement details
            echo "<div class='announcement'>";
            echo "<h2>$title</h2>";
            echo "<p>$content</p>";
            echo "<p>Posted on: $postDate</p>";

            // Check if an image is provided
            if (!empty($image)) {
                echo "<img src='images/$image' alt='Announcement Image'>";
            }

            echo "</div>";
        }
        ?>
    </div>
</body>
</html>
