<!DOCTYPE html>
<html>
<head>
    <title>Available and Unavailable Stalls</title>
    <!-- Add Bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Add your custom styles here */
        .section-title {
            font-size: 24px;
            font-weight: bold;
            margin-top: 20px;
        }

        .stall-list {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .stall-card {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
            cursor: pointer;
            width: calc(33.33% - 20px); /* Adjust the width based on your requirements */
            box-sizing: border-box;
        }

        .stall-image {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 0 auto;
        }

        .stall-no {
            font-weight: bold;
        }

        .available {
            background-color: #c6efce;
        }

        .unavailable {
            background-color: #f5b9b0;
        }
        @media (max-width: 768px) {
            body{
                padding-top: 15%;
                padding-bottom: 5%;
            }
        }
    </style>
</head>
<?php 
include "header-home.php";
?>
<body style="margin-top:10%;">


<div class="container">
    <h1 class="my-4 text-center">Available and Unavailable Stalls</h1>
    <ul class="nav nav-tabs" id="stallTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="available-tab" data-bs-toggle="tab" href="#available" role="tab"
               aria-controls="available" aria-selected="true">Available</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="unavailable-tab" data-bs-toggle="tab" href="#unavailable" role="tab"
               aria-controls="unavailable" aria-selected="false">Unavailable</a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane fade show active" id="available" role="tabpanel" aria-labelledby="available-tab">
            <div class="section-container">
                <?php
                // Database connection
                include "config/config.php";
                // Function to fetch unique sections from the available_stall table
                function getUniqueSections($conn) {
                    $sectionsQuery = "SELECT DISTINCT section FROM available_stall ORDER BY section";
                    $sectionsResult = mysqli_query($conn, $sectionsQuery);
                    $sections = [];
                    while ($sectionRow = mysqli_fetch_assoc($sectionsResult)) {
                        $sections[] = $sectionRow['section'];
                    }
                    return $sections;
                }

                // Function to display stalls for a given section
                function displayStalls($conn, $section, $status) {
                    $stallsQuery = "SELECT * FROM available_stall WHERE section = '$section' AND status = '$status' ORDER BY stall_no";
                    $stallsResult = mysqli_query($conn, $stallsQuery);
                    echo '<div class="section-title">' . $section . '</div>';
                    echo '<div class="stall-list">';
                    while ($row = mysqli_fetch_assoc($stallsResult)) {
                        // Generate a unique identifier for each stall card
                        $cardId = 'stall_' . (isset($row['stall_id']) ? $row['stall_id'] : uniqid());
                        // Store the stall data in the data-stall attribute
                        echo '<div id="' . $cardId . '" class="stall-card ' . $status . '" data-stall=\'' . json_encode($row) . '\' onclick="openEditModal(\'' . $cardId . '\')">';
                        echo '<img src="admin/'. htmlspecialchars($row['image']) . '" class="stall-image">';
                        echo '<div class="stall-no">Stall Number: ' . htmlspecialchars($row['stall_no']) . '</div>';
                        echo '<div>Status: ' . ucfirst(htmlspecialchars($row['status'])) . '</div>';
						echo '<div>Description: ' . ucfirst(htmlspecialchars($row['size'])) . '</div>';
                        echo '</div>';
                    }
                    echo '</div>';
                }

                // Fetch unique sections
                $sections = getUniqueSections($conn);

                // Display stalls for each section
                foreach ($sections as $section) {
                    displayStalls($conn, $section, 'available');
                }

                // Close database connection
                mysqli_close($conn);
                ?>
            </div>
        </div>
        <div class="tab-pane fade" id="unavailable" role="tabpanel" aria-labelledby="unavailable-tab">
            <div class="section-container">
                <?php
                include "config/config.php";
                // Function to display unavailable stalls for a given section
                function displayUnavailableStalls($conn, $section, $status) {
                    $unavailableQuery = "SELECT * FROM available_stall WHERE section = '$section' AND status = '$status' ORDER BY stall_no";
                    $unavailableResult = mysqli_query($conn, $unavailableQuery);
                    echo '<div class="section-title">' . $section . '</div>';
                    echo '<div class="stall-list">';
                    while ($row = mysqli_fetch_assoc($unavailableResult)) {
                        // Generate a unique identifier for each stall card
                        $cardId = 'stall_' . (isset($row['stall_id']) ? $row['stall_id'] : uniqid());
                        // Store the stall data in the data-stall attribute
                        echo '<div id="' . $cardId . '" class="stall-card ' . $status . '" data-stall=\'' . json_encode($row) . '\' onclick="openEditModal(\'' . $cardId . '\')">';
                        echo '<img src="admin/' .($row['image']) . '" class="stall-image">';
                        echo '<div class="stall-no">Stall Number: ' . htmlspecialchars($row['stall_no']) . '</div>';
                        echo '<div>Status: ' . ucfirst(htmlspecialchars($row['status'])) . '</div>';
                        echo '</div>';
                    }
                    echo '</div>';
                }

                // Display unavailable stalls for each section
                foreach ($sections as $section) {
                    displayUnavailableStalls($conn, $section, 'unavailable');
                }

                // Close database connection
                mysqli_close($conn);
                ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal for editing stall information -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Stall Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editForm" enctype="multipart/form-data" method="post" action="save_changes.php">
                    <div class="mb-3">
                        <label for="stallImage" class="form-label">Stall Image</label>
                        <input type="file" class="form-control" id="stallImage" name="stallImage">
                    </div>
                    <div class="mb-3">
                        <label for="availableStallNo" class="form-label">Stall Number</label>
                        <input type="text" class="form-control" id="availableStallNo" name="availableStallNo">
                    </div>
                    <div class="mb-3">
                        <label for="stallSection" class="form-label">Section</label>
                        <select class="form-control" id="stallSection" name="stallSection">
                            <?php
                            // Populate the dropdown list with the sections
                            foreach ($sections as $section) {
                                echo '<option value="' . htmlspecialchars($section) . '">' . htmlspecialchars($section) . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <input type="hidden" id="stallId" name="stallId">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="saveChanges()">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Add Bootstrap JS and jQuery links -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  
</script>

</body>
</html>