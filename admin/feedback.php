<?php
include("../config/config.php");
include "../config/session.php";
if (isset($_SESSION['username']) && $_SESSION['roles'] == 'admin') {
?>
<!DOCTYPE html>
<html>
<head>
    <title>Feedback</title>
    <link rel="icon" href="../image/logo.ico" type="image/x-icon">
    <style>
    /* Custom CSS */
        .custom-container {
            margin-top: 5%!important;
            margin-left: 15%!important;;  
            background-color: #fff;
            box-sadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 4px;
        }
        
        .custom-container h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        
        .custom-container h2 {
            font-size: 20px;
            margin-bottom: 10px;
        }
        
        .custom-container ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }
        
        .custom-container li {
            margin-bottom: 15px;
            padding: 20px;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }
        
        .custom-container strong {
            font-weight: bold;
        }
        
        .custom-container label {
            display: block;
            margin-bottom: 10px;
        }
        
        .custom-container select {
            margin-bottom: 10px;
            padding: 5px;
            border-radius: 4px;
        }
        
        .custom-container button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
            border-radius: 4px;
        }
        
        .custom-container button:hover {
            background-color: #45a049;
        }
        
        .custom-container .pagination {
            margin-top: 20px;
        }
        
        .custom-container .pagination a {
            display: inline-block;
            padding: 8px 16px;
            text-decoration: none;
            color: #000;
            background-color: #f1f1f1;
            border-radius: 5px;
        }
        
        .custom-container .pagination a.active {
            background-color: #4CAF50;
            color: white;
        }
        
        .custom-container .pagination a:hover:not(.active) {
            background-color: #ddd;
        }
        
        /* Override sidebar styles */
        .sidebar {
            position: initial;
            top: initial;
            left: initial;
            transform: initial;
        }
        
        .sidebar ul {
            flex-direction: column;
        }
        
        .sidebar li {
            margin: 10px 0;
        }
    </style>

</head>
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

<?php 
    include "sidebar-admin.php";
    ?>
<body>
   <div class="custom-container" style="padding-left:15%;">
    <h1>Feedback</h1>

    <?php
    

    // Function to get the number of feedback entries
    function getFeedbackCount()
    {
        global $conn;
        $sql = "SELECT COUNT(*) as count FROM feedback";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['count'];
        }

        return 0;
    }

    // Function to get the feedback entries for a specific month
    function getFeedbackByMonth($selectedMonth, $offset, $limit)
    {
        global $conn;
        $sql = "SELECT * FROM feedback WHERE DATE_FORMAT(created_at, '%Y-%m') = '$selectedMonth' ORDER BY created_at DESC LIMIT $offset, $limit";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            return $result;
        }

        return false;
    }

    // Get the total number of feedback entries
    $feedbackCount = getFeedbackCount();

    // Pagination variables
    $limit = 10;
    $totalPages = ceil($feedbackCount / $limit);
    $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
    $offset = ($currentPage - 1) * $limit;

    // Fetch feedback data from the database for the selected month or all months
    $selectedMonth = isset($_POST['month']) ? $_POST['month'] : '';
    $feedbackData = $selectedMonth ? getFeedbackByMonth($selectedMonth, $offset, $limit) : $conn->query("SELECT * FROM feedback ORDER BY created_at DESC LIMIT $offset, $limit");

    if ($feedbackData && $feedbackData->num_rows > 0) {
        echo "<h2>Feedback</h2>";
        echo "<ul>";

        while ($row = $feedbackData->fetch_assoc()) {
            echo "<li>";
            echo "<strong>Name:</strong> " . $row['name'] . "<br>";
            echo "<strong>Email:</strong> " . $row['email'] . "<br>";
            echo "<strong>Message:</strong> " . $row['message'] . "<br>";
            echo "<strong>Month:</strong> " . date('F Y', strtotime($row['created_at'])) . "<br>";
            echo "</li>";
        }

        echo "</ul>";

        // Pagination links
        echo "<div class='pagination'>";
        for ($page = 1; $page <= $totalPages; $page++) {
            $activeClass = ($currentPage == $page) ? 'active' : '';
            echo "<a href='?page=$page' class='$activeClass'>$page</a>";
        }
        echo "</div>";
    } else {
        echo "<h2>No feedback entries found.</h2>";
    }

    // Close the database connection
    $conn->close();
    ?>

    <form method="post" action="feedback_generate_report.php">
        <label for="month">Select Month:</label>
        <select name="month" id="month">
            <option value="">-- Select Month --</option>
            <?php
            // Generate options for the years dynamically
            $currentYear = date('Y');
            $startYear = 2023; // Specify the start year as needed
            for ($year = $currentYear; $year >= $startYear; $year--) {
                for ($month = 12; $month >= 1; $month--) {
                    $optionValue = sprintf("%04d-%02d", $year, $month);
                    $optionLabel = date('F Y', strtotime($optionValue));
                    echo "<option value=\"$optionValue\">$optionLabel</option>";
                }
            }
            ?>
        </select>
        <button type="submit">Generate Monthly Report</button>
    </form>
    </div>
</body>
</html>
<?php
} else {
    header("location:../index.php");
    session_destroy();
}
?>
