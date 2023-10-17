<!DOCTYPE html>
<html>
<head>
    <title>Past Maintenance Reports</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f2f2f2;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        .report-container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 4px;
            padding: 20px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .report-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .no-reports {
            text-align: center;
            font-weight: bold;
        }

        .report-item {
            border-bottom: 1px solid #ccc;
            padding: 10px;
            display: flex;
            justify-content: space-between;
        }

        .report-item:last-child {
            border-bottom: none;
        }

        .report-item p {
            margin: 0;
        }

        .report-item .report-info {
            flex-grow: 1;
            margin-right: 20px;
        }

        .report-item .report-date {
            font-size: 12px;
            color: #777;
        }

        @media (max-width: 768px) {
            .report-container {
                padding: 10px;
            }
        }
    </style>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<h1>Past Maintenance Reports</h1>

<div class="report-container">
    <?php
    session_start();
    include "../config/config.php";

    // Replace this with the correct session variable that holds the logged-in user's ID
    $loggedInUserId = $_SESSION['id'];

    // Retrieve the stall owner's ID based on the logged-in user's ID
    $sqlStallOwner = "SELECT id FROM `stall_owner` WHERE user_id = '$loggedInUserId'";
    $resultStallOwner = $conn->query($sqlStallOwner);

    $rowStallOwner = $resultStallOwner->fetch_assoc();
    $stallOwnerId = $rowStallOwner['id'];

    // Retrieve past maintenance reports added by the stall owner
    $sqlPastMaintenance = "SELECT * FROM maintenance WHERE owner_id = '$stallOwnerId' ORDER BY date DESC";
    $resultPastMaintenance = $conn->query($sqlPastMaintenance);

    if ($resultPastMaintenance && $resultPastMaintenance->num_rows > 0) {
        while ($row = $resultPastMaintenance->fetch_assoc()) {
            echo "<div class='report-item'>";
            echo "<div class='report-info'>";
            echo "<p><strong>Maintenance:</strong> " . $row['maintenance_type'] . "</p>";
            echo "<p><strong>Description:</strong> " . $row['description'] . "</p>";
            echo "<p><strong>Status:</strong> " . $row['status'] . "</p>";
            echo "</div>";
            echo "<div class='report-date'>";
            echo "<p>" . $row['date'] . "</p>";
            echo "</div>";
            echo "</div>";
        }
    } else {
        echo "<p class='no-reports'>No past maintenance reports found.</p>";
    }
    ?>
</div>

<!-- Button to go back to the main page -->
<div style="text-align: center; margin-top: 20px;">
    <a href="maintainance.php"
        style="padding: 10px 20px; background-color: #007BFF; color: #fff; text-decoration: none; border-radius: 4px; font-weight: bold;">Back</a>
</div>
</body>
</html>