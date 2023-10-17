<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stall Violations</title>
    <style>
        
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 10px;
            padding: 0;

        }

        h1 {
            text-align: center;
            margin: 30px 0;
        }

        .announcement {
            width: 100%;
            max-width: 800px;
            margin: 30px auto;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 5px;
        }

        .violation-type {
            font-weight: bold;
            font-size: 18px;
        }

        .description {
            margin-top: 5px;
            font-size: 16px;
        }

        .violation-date {
            margin-top: 10px;
            font-size: 14px;
            color: #555;
        }

        .stall-number {
            margin-top: 10px;
            font-size: 14px;
            color: #555;
        }

        .appeal {
            margin-top: 10px;
            font-size: 16px;
        }

        .remarks {
            margin-top: 5px;
            font-size: 14px;
            color: #555;
        }

        .remediation {
            margin-top: 10px;
            font-size: 14px;
            color: #555;
        }

        @media screen and (max-width: 600px) {
            .announcement {
                max-width: 90%;
            }
            body{
                padding-top: 5%;
            }
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        .modal-close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .modal-close:hover,
        .modal-close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .appeal-form textarea {
            width: 100%;
            height: 100px;
            resize: vertical;
        }

        .appeal-form input[type="submit"] {
            margin-top: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
        }

        .appeal-form input[type="submit"]:hover {
            background-color: #45a049;
        }

        .appeal-form input[type="submit"]:focus {
            outline: none;
        }
        
    </style>
</head>

<body>

    <h1>Stall Violations</h1>

    <?php
    session_start();
    include "../config/config.php";
    include "barpage/topbar.php";
    // Replace this with the correct session variable that holds the logged-in user's ID
    $loggedInUserId = $_SESSION['id'];

    // Retrieve the stall owner's ID based on the logged-in user's ID
    $sqlStallOwner = "SELECT id FROM `stall_owner` WHERE user_id = '$loggedInUserId'";
    $resultStallOwner = $conn->query($sqlStallOwner);

    if ($resultStallOwner->num_rows > 0) {
        $rowStallOwner = $resultStallOwner->fetch_assoc();
        $stallOwnerId = $rowStallOwner['id'];

        // Check if the form is submitted
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $appeal = $_POST['appeal'];
            $violationId = $_POST['violation_id'];

            // Update the appeal in the database
            $updateSql = "UPDATE `violation` SET appeal = '$appeal' WHERE violation_id = '$violationId'";
            if ($conn->query($updateSql) === TRUE) {
                echo "<p style='color:green;'>Appeal submitted successfully.</p>";
            } else {
                echo "<p style='color:red;'>Error submitting appeal: " . "</p>";
            }
        }

        // Retrieve violations for the specific stall owner using the stall owner's ID
        $sql = "SELECT * FROM `violation` WHERE stall_owner_id = '$stallOwnerId' ORDER BY violation_date DESC";

        $result = $conn->query($sql);

        if ($result !== false && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='announcement'>";
                echo "<div  :class='violation-type'> Violation :". $row["violation_type"] . "</div>";
                echo "<div class='description'>" . $row["description"] . "</div>";
                echo "<div class='violation-date'>Violation Date: " . $row["violation_date"] . "</div>";
                echo "<div class='appeal'>";
                if ($row["appeal"]) {
                    echo "<strong>Appeal:</strong><br>" . $row["appeal"];
                } else {
                    // Display a button to open the modal for submitting the appeal
                    echo "<button onclick='openModal(\"" . $row["violation_id"] . "\")'>Submit Appeal</button>";
                }
                echo "</div>";
                echo "<div class='remarks'>Remarks: " . $row["remarks"] . "</div>";
                echo "<div class='remediation'>Remediation: " . $row["remediation"] . "</div>"; // New field
                echo "</div>";
            }
        } else {
            echo "<p style='text-align:center;color:red;'>No violations found.</p>";
        }
    } else {
        echo "<p style='text-align:center;color:red;'>Stall owner not found.</p>";
    }

    $conn->close();
    ?>

    <!-- Modal -->
    <div class="modal" id="appealModal">
        <div class="modal-content">
            <span class="modal-close" onclick="closeModal()">&times;</span>
            <h2>Submit Appeal</h2>
            <div class="appeal-form">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <input type="hidden" id="violation_id" name="violation_id">
                    <textarea name="appeal" rows="3" cols="30"></textarea>
                    <br>
                    <input type="submit" value="Submit Appeal">
                </form>
            </div>
        </div>
    </div>

    <script>
        // JavaScript functions for modal handling
        function openModal(violationId) {
            document.getElementById('violation_id').value = violationId;
            document.getElementById('appealModal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('appealModal').style.display = 'none';
        }
    </script>
</body>

</html>
