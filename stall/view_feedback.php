<?php
include "../config/config.php";
include "../config/session.php";

if (!isset($_SESSION['username']) && $_SESSION['roles'] != 'owner') {
    header("location:../index.php");
    session_destroy();
}

// Retrieve the stall owner's email
$userId = $_SESSION['id'];
$queryOwner = "SELECT email FROM stall_owner WHERE user_id = '$userId'";
$resultOwner = mysqli_query($conn, $queryOwner);
$rowOwner = mysqli_fetch_assoc($resultOwner);
$ownerEmail = $rowOwner['email'];

// Retrieve past feedback for the stall owner
$queryFeedback = "SELECT * FROM feedback WHERE email = '$ownerEmail' ORDER BY created_at DESC";
$resultFeedback = mysqli_query($conn, $queryFeedback);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Past Feedback</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;

            background-color: #f2f2f2;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        .feedback-container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 4px;
            padding: 20px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .feedback-container table {
            width: 100%;
            border-collapse: collapse;
        }

        .feedback-container th,
        .feedback-container td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
        }

        .feedback-container th {
            background-color: #f2f2f2;
        }

        .no-feedback {
            margin: 0;
            padding: 10px;
            text-align: center;
            font-weight: bold;
        }
         @media (max-width: 768px) {
            .feedback-container {
                padding: 10px;
            }

            .feedback-container table {
                font-size: 14px;
            }
            .table{
                width: 40%;
                padding-right: 15%;

            }
        }

        @media (max-width: 480px) {
            .feedback-container {
                max-width: 100%;
                border-radius: 0;
                
            }
            .table{
                width: 40%;
                padding-right: 15%;

            }
        }
    </style>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

    <h1>Past Feedback</h1>

    <div class="feedback-container">
        <?php if ($resultFeedback && mysqli_num_rows($resultFeedback) > 0) { ?>
            <table class="table">
                <tr>
                    <th>Name</th>
                    <th>Message</th>
                    <th>Date</th>
                </tr>
                <?php while ($rowFeedback = mysqli_fetch_assoc($resultFeedback)) { ?>
                    <tr>
                        <td><?php echo $rowFeedback['name']; ?></td>
                        <td><?php echo $rowFeedback['message']; ?></td>
                        <td><?php echo $rowFeedback['created_at']; ?></td>
                    </tr>
                <?php } ?>
            </table>
        <?php } else { ?>
            <p class="no-feedback">No past feedback found.</p>
        <?php } ?>
    </div>
    <!-- Button to go back to the main page -->
<div style="text-align: center; margin-top: 20px;">
    <a href="feedback.php"
        style="padding: 10px 20px; background-color: #007BFF; color: #fff; text-decoration: none; border-radius: 4px; font-weight: bold;">Back</a>
</div>
</body>
</html>
