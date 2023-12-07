<?php

include "../config/config.php";
//include "../config/session.php";
include "barpage/sidebar.php";

if (!isset($_SESSION['username']) || $_SESSION['roles'] != 'stall_owner') {
    header("location:../index.php");
    exit();
}

$userId = $_SESSION['id'];

// Fetch stall owner information
$queryOwner = "SELECT * FROM stall_owner WHERE user_id = '$userId'";
$resultOwner = mysqli_query($conn, $queryOwner);

if (!$resultOwner) {
    die("Error fetching stall owner information: " . mysqli_error($conn));
}

$rowOwner = mysqli_fetch_assoc($resultOwner);

// Check if the stall owner information is found
if (!$rowOwner || !isset($rowOwner['stall_no'])) {
    header("location:set_up.php");
    exit();
}

// Fetch stalls owned by the stall owner
$stallNo = $rowOwner['stall_no'];
$stallowner = $rowOwner['id'];

$queryStalls = "SELECT * FROM stall WHERE stall_number = '$stallNo'";
$resultStalls = mysqli_query($conn, $queryStalls);

if (!$resultStalls) {
    die("Error fetching stall information: " . mysqli_error($conn));
}



// Fetch stall owner contract information
$queryContract = "SELECT * FROM stall_owner_contract WHERE stall_owner_id = '$stallowner'";
$resultContract = mysqli_query($conn, $queryContract);

if (!$resultContract) {
    die("Error fetching stall owner contract information: " . mysqli_error($conn));
}

$rowContract = mysqli_fetch_assoc($resultContract);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Stall Owner Profile</title>
    <style>
       

        .profile-container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 4px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .profile-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .profile-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            overflow: hidden;
            margin: 0 auto;
            border: 2px solid #007BFF;
        }

        .profile-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-info {
            text-align: center;
        }

        .profile-info h1 {
            margin: 10px 0;
        }

        .profile-info p {
            color: #666;
        }

        .profile-data {
            margin-top: 30px;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            grid-gap: 20px;
        }

        .profile-data .section {
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .profile-data h2 {
            margin-top: 0;
        }

        .profile-data table {
            width: 100%;
            border-collapse: collapse;
        }

        .profile-data th, .profile-data td {
            padding: 10px;
            border: 1px solid #ccc;
        }

        .profile-data th {
            background-color: #f2f2f2;
        }

        .profile-data .no-data {
            text-align: center;
            font-weight: bold;
        }

        .back-btn {
            text-align: center;
            margin-top: 20px;
        }

        .back-btn a {
            padding: 10px 20px;
            background-color: #007BFF;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
        }
        .profile-card {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .card {
            max-width: 400px;
            background-color: #fff;
            border-radius: 4px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            margin: 10px;
            padding: 20px;
        }

        .card h2 {
            margin-top: 0;
            border-bottom: 1px solid #ccc;
            padding-bottom: 10px;
        }

        .card p {
            color: #666;
        }

        /* Additional styles to adjust the grid */
        @media (max-width: 600px) {
            .profile-data {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <div class="profile-header">
            <div class="profile-avatar">
            <img src="<?php echo (!empty($user['profile'])) ? $user['profile'] : '../stall/profile/default.jpeg'; ?>" alt="Profile Picture" class="avatar-img rounded-circle" />
            <div class="profile-info">
                <h1><?php echo $rowOwner['name']; ?></h1>
                <p>Email: <?php echo $rowOwner['email']; ?></p>
                <p>Contact: <?php echo $rowOwner['contact']; ?></p>
            </div>
        </div>

        <div class="profile-data profile-card">
            <div class="card">
                <h2>Stall Owner Information</h2>
                <p><strong>Name:</strong> <?php echo $rowOwner['name']; ?></p>
                <p><strong>Email:</strong> <?php echo $rowOwner['email']; ?></p>
                <p><strong>Contact:</strong> <?php echo $rowOwner['contact']; ?></p>
                <p><strong>Age:</strong> <?php echo $rowOwner['age']; ?></p>
                <p><strong>Address:</strong> <?php echo $rowOwner['address']; ?></p>
                <p><strong>Status:</strong> <?php echo $rowOwner['status']; ?></p>
            </div>
            <div class="profile-data profile-card">
    <?php if (mysqli_num_rows($resultStalls) > 0) { ?>
        <?php while ($rowStall = mysqli_fetch_assoc($resultStalls)) { ?>
            <div class="card">
                <h2>Stall Information</h2>
                <p><strong>Stall Number:</strong> <?php echo $rowStall['stall_number']; ?></p>
                <p><strong>Stall Name:</strong> <?php echo $rowStall['stall_name']; ?></p>
                <p><strong>Category:</strong> <?php echo $rowStall['category']; ?></p>
                <p><strong>Status:</strong> <?php echo $rowStall['status']; ?></p>
            </div>
        <?php } ?>
    <?php } else { ?>
        <p  class="no-data"><a href="stall_information.php">Set up your Account. Click here!</a></p>

    <?php } ?>
</div>
            <div class="card">
                <h2>Stall Owner Contract Information</h2>
                <?php if ($rowContract > 0) { ?>
                    <p><strong>Contract Date:</strong> <?php echo $rowContract['contract_date']; ?></p>
                    <p><strong>Contract Start Date:</strong> <?php echo $rowContract['contract_start_date']; ?></p>
                    <p><strong>Contract End Date:</strong> <?php echo $rowContract['contract_end_date']; ?></p>
                    <p><strong>Contract Terms:</strong> <?php echo $rowContract['contract_terms']; ?></p>
                <?php } else { ?>
                    <p class="no-data">No contract information found.</p>
                <?php } ?>
            </div>
        </div>
    </div>

    <div class="back-btn">
        <a href="stall_dashboard.php">Back to Main Page</a>
    </div>
    <script src="barpage/js/jquery.min.js"></script>
    <script src="barpage/js/popper.js"></script>
    <script src="barpage/js/bootstrap.min.js"></script>
    <script src="barpage/js/main.js"></script>
</body>
</html>