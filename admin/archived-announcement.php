<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archived Announcements</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <style>
       .crossed-out {
            text-decoration: line-through;
        }
        .announcement {
            border: 1px solid #ccc;
            padding: 10px;
            margin: 10px;
            transition: background-color 0.3s;
        }

        .announcement:hover {
            background-color: #f0f0f0; /* Change the background color on hover */
        }

        .announcement h2 {
            color: #333;
        }

        .announcement img {
            max-width: 50%;
            height: auto;
            margin-top: 10px;
        }
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f8f8;
            margin: 0;
            padding: 0;
            color: #333;
        }

     
        .announcement {
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border: 1px solid #ddd;
            padding: 20px;
            margin: 20px;
            transition: background-color 0.3s, transform 0.3s;
        }

        .announcement:hover {
            background-color: #f0f0f0;
            transform: scale(1.02); /* Add a subtle scaling effect on hover */
        }

    
        .announcement p {
            color: #555;
        }

        .announcement img {
            max-width: 100%;
            height: auto;
            margin-top: 15px;
        }
    </style>
</head>
<body>

    <h1 style="text-align:center;">Archived Announcements</h1>
    <button class="btn btn-secondary" onclick="window.location.href='../admin/annoucement.php'">Back</button>
    <br>
    <br>
    <hr>
    <div class="crossed-out">
    <?php
    
    
include "../config/config.php";
include "checking_user.php";

    // Fetch and display archived announcements
    $sql = "SELECT * FROM announcements WHERE status = 'hidden' ORDER BY id DESC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='announcement'>";
            echo "<h2>" . $row['title'] . "</h2>";
            echo "<p>" . $row['content'] . "</p>";
            echo "<p>" . $row['post_date']. "</p>";;
            echo "<img src='../images/" . $row['image'] . "' alt='Announcement Image'>";

            echo "</div>";
        }
    } else {
        echo "<p>No archived announcements found.</p>";
    }

    // Close the database connection
    $conn->close();
    ?>
    </div>
</body>
</html>
