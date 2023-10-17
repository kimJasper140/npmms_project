<?php
include "../config/config.php";
include "../config/session.php";
if (!isset($_SESSION['username']) && $_SESSION['roles'] != 'staff'){
    header("location:../index.php");
    session_destroy();

}
// Pagination variables
$limit = 10; // Number of records per page
$page = isset($_GET['page']) ? $_GET['page'] : 1; // Current page number
$start = ($page - 1) * $limit; // Starting index for records

$search = isset($_POST['search']) ? $_POST['search'] : '';

// Count total records
$countQuery = "SELECT COUNT(*) AS total FROM applications WHERE status = 'declined' AND applicant_name LIKE '%$search%'";
$countResult = mysqli_query($conn, $countQuery);
$countRow = mysqli_fetch_assoc($countResult);
$totalRecords = $countRow['total'];

// Calculate total pages
$totalPages = ceil($totalRecords / $limit);

// Retrieve records for the current page
$query = "SELECT * FROM applications WHERE status = 'declined' AND applicant_name LIKE '%$search%' LIMIT $start, $limit";
$applicationsResult = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Declined Applications</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1 {
            text-align: center;
        }

        table {
            width: 95%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ccc;
        }

        th {
            background-color: #f2f2f2;
        }

        input[type="text"] {
            padding: 6px 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            padding: 6px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button[name="approve"] {
            background-color: #5cb85c;
            color: #fff;
        }

        button[name="decline"] {
            background-color: #d9534f;
            color: #fff;
        }

        form {
            display: inline-block;
            margin-bottom: 0;
        }

        .custom-css {
            margin-left: 320px;
            margin-top: 50px;
        }

        .pagination {
            margin-top: 20px;
            text-align: center;
        }

        .pagination a {
            display: inline-block;
            padding: 8px 16px;
            text-decoration: none;
            border: 1px solid #ccc;
            margin: 0 4px;
            border-radius: 4px;
        }

        .pagination a.active {
            background-color: #4CAF50;
            color: white;
            border: 1px solid #4CAF50;
        }
    </style>
</head>
<body>
<?php 
 include "sidebar-staff.php";
   ?>
    
<div class="custom-css">
    <h1>Declined Applications</h1>
    
    <form action="" method="POST">
        <input type="text" name="search" placeholder="Search by name" value="<?php echo $search; ?>">
        <button type="submit">Search</button>
    </form>
    
    <?php if (mysqli_num_rows($applicationsResult) > 0) { ?>
    <table>
        <tr>
    
                <th>Name</th>
                <th>Stall No</th>
                <th>Age</th>
                <th>Address</th>
                <th>Email</th>
                <th>Contact</th>
                <th>Status</th>
                <th>Remarks</th>

        </tr>

        <?php while ($row = mysqli_fetch_assoc($applicationsResult)) { ?>
            <tr>
                
                <td><?php echo $row['applicant_name']; ?></td>
                <td><?php echo $row['stall_no2']; ?></td>
                <td><?php echo $row['applicant_age']; ?></td>
                <td><?php echo $row['applicant_address']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['contact']; ?></td>
                <td><?php echo $row['status']; ?></td>
                <td><?php echo $row['remarks']; ?></td>
               
            </tr>
        <?php } ?>
    </table>
    <?php } else { ?>
    <p>No declined applications found.</p>
    <?php } ?>

    <div class="pagination">
        <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
            <a href="?page=<?php echo $i; ?>" <?php if ($page == $i) echo 'class="active"'; ?>><?php echo $i; ?></a>
        <?php } ?>
    </div>
        </div>
</body>
</html>
