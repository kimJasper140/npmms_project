<?php 
include "../config/config.php";
include "checking_user.php"
?>

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
    </style>
</head>
<?php
include "topbar.php";

?>
<body style="margin-top:5%;">


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
    <button style="margin-left:88%;" type="button" class="btn btn-primary" id="addNewStallButton">Add New Stall</button>

    <div class="tab-content">
        
        <div class="tab-pane fade show active" id="available" role="tabpanel" aria-labelledby="available-tab">
            <div class="section-container">
                <?php
                // Database connection
                include "../config/config.php";
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
                        echo '<img src="' . htmlspecialchars($row['image']) . '" class="stall-image">';
                        echo '<div class="stall-no">Stall Number: ' . htmlspecialchars($row['stall_no']) . '</div>';
                        echo '<div>Status: ' . ucfirst(htmlspecialchars($row['status'])) . '</div>';
						echo '<div>Size: ' . htmlspecialchars($row['size']). '</div>';
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
                include "../config/config.php";
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
                        echo '<img src="' . htmlspecialchars($row['image']) . '" class="stall-image">';
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
<!-- Modal for adding new stall -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Add New Stall</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addForm" enctype="multipart/form-data" method="post" action="add_stall.php">
                    <div class="mb-3">
                        <label for="newStallImage" class="form-label">Stall Image</label>
                        <input type="file" class="form-control" id="newStallImage" name="newStallImage" required>
                    </div>
                    <div class="mb-3">
                        <label for="newStallNo" class="form-label">Stall Number</label>
                        <input type="text" class="form-control" id="newStallNo" name="newStallNo" required>
                    </div>
					<div class="mb-3">
						<label for="newStallSize" class="form-label">Stall Size</label>
						<input type="text" class="form-control" id = "newStallSize" name = "newStallSize">
					</div>
                    <div class="mb-3">
                        <label for="newStallSection" class="form-label">Section</label>
                        <select class="form-control" id="newStallSection" name="newStallSection" required>
                            <option value="" disabled selected>Select a section</option>
                            <?php
                            // Populate the dropdown list with the sections, including the "include" option
                            
                            foreach ($sections as $section) {
                                echo '<option value="' . htmlspecialchars($section) . '">' . htmlspecialchars($section) . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="addNewStall()">Add Stall</button>
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
						<label for="stallSize" class="form-label">Stall Size</label>
						<input type="text" class="form-control" id = "stallSize" name = "stallSize">
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
    // Function to switch between available and unavailable stalls tabs
    $('#stallTabs a').on('click', function (event) {
        event.preventDefault();
        $(this).tab('show');
    });


    

    // Variable to keep track of the currently active card
    let activeCard = null;

    // Function to open the modal for editing stall data
    function openEditModal(cardId) {
        const card = document.getElementById(cardId);
        const stallData = JSON.parse(card.getAttribute('data-stall'));
        if (activeCard !== null) {
            activeCard.classList.remove('active');
        }
        activeCard = card.parentElement;
        activeCard.classList.add('active');
        document.getElementById('stallImage').value = '';
        document.getElementById('availableStallNo').value = stallData.stall_no;
        document.getElementById('stallSection').value = stallData.section;
        document.getElementById('stallId').value = stallData.stall_id; // Set the stall ID for form submission
        $('#editModal').modal('show');
    }

    // Function to save the changes
    function saveChanges() {
        if (activeCard === null) {
            alert('Please select a stall to edit.');
            return;
        }

        const card = activeCard.querySelector('.stall-card');
        const cardId = card.id;
        const uploadedImage = document.getElementById('stallImage').files[0];
        const stallNo = document.getElementById('availableStallNo').value;
        const section = document.getElementById('stallSection').value;

        if (!uploadedImage || !stallNo || !section) {
            alert('Please fill in all fields.');
            return;
        }

        document.getElementById('editForm').submit();
    }
	
	function addNewStall() {
		var new_image = document.getElementById('newStallImage').value;
		var new_num = document.getElementById('newStallNo').value;
		var new_size = document.getElementById('newStallSize').value;
		
		if (!new_image || !new_num || !new_size) {
            alert('Please fill in all fields.');
            return;
        }
		
		const form = document.getElementById('addForm');
		const formData = new FormData(form);
		formData.get("newStallImage");
		formData.get("newStallNo");
		formData.get("newStallSize");
		

		fetch("add_stall.php", {
			method: "POST",
			body: formData,
		})
		.then((response) => response.json())
		.then((data) => {
			if (data.success) {
				alert("Data inserted successfully");
		  } else {
				alert("Error: " + data.message);
		  }
		})
		.catch((error) => {
		  console.error("Error:", error);
		});

        document.getElementById('addForm').submit();
    }

    // Event delegation for dynamically added stall cards
    $(document).on('click', '.stall-card', function () {
        const cardId = $(this).attr('id');
        openEditModal(cardId);
    });
    $('#addNewStallButton').on('click', function () {
        $('#addModal').modal('show');
    });
    
</script>

</body>
</html>
