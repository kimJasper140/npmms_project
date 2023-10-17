<?php
// Include necessary files and configurations
include "../config/config.php";
include "checking_user.php";

// Check if the stall owner ID is provided in the URL
if (isset($_GET['stall_owner_id'])) {
    $stall_owner_id = $_GET['stall_owner_id'];

    // Fetch the stall owner details
    $sql_stall_owner = "SELECT id, name, stall_no FROM stall_owner WHERE id = '$stall_owner_id'";
    $result_stall_owner = $conn->query($sql_stall_owner);

    // Check if the stall owner exists
    if ($result_stall_owner->num_rows > 0) {
        $stall_owner = $result_stall_owner->fetch_assoc();

        // Fetch all violations associated with the stall owner
        $sql_violations = "SELECT * FROM violation WHERE stall_owner_id = '$stall_owner_id' ORDER BY violation_date DESC";
        $result_violations = $conn->query($sql_violations);
    } else {
        // Stall owner not found with the provided ID
        $stall_owner = null;
    }
}

// Handle form submission for adding a new violation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_violation'])) {
    $violation_type = $_POST['violation_type'];
    $description = $_POST['description'];
    $violation_date = $_POST['violation_date'];
    $remarks = $_POST['remarks'];
    $remediation = $_POST['remediation'];

    // Insert the new violation into the database
    $sql_add_violation = "INSERT INTO violation (stall_owner_id, violation_type, description, violation_date, remarks, remediation) VALUES ('$stall_owner_id', '$violation_type', '$description', '$violation_date', '$remarks', '$remediation')";
    $conn->query($sql_add_violation);


    $stall_owner_id = $_GET['stall_owner_id'];
    $notificationMessage = "Your Stall Has a Violation<br>Violation: " . $violation_type . "<br>Description: " . $description;
    $notificationTimestamp = date("Y-m-d H:i:s");
    $notificationDate = date("Y-m-d");
    $notificationSent = 0; // Notification is not sent immediately

    $sql_add_notification = "INSERT INTO stall_notifications (stall_owner_id, subject, message, notification_timestamp, notification_date, notification_sent) VALUES ('$stall_owner_id', '$notificationMessage', '$notificationMessage', '$notificationTimestamp', '$notificationDate', '$notificationSent')";
    $conn->query($sql_add_notification);
    // Refresh the page to show the updated violations
    header("Location: view_violations.php?stall_owner_id=$stall_owner_id");
    exit();
}

// Handle form submission for editing an existing violation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_violation'])) {
    $violation_id = $_POST['violation_id'];
    $violation_type = $_POST['violation_type'];
    $description = $_POST['description'];
    $violation_date = $_POST['violation_date'];
    $remarks = $_POST['remarks'];
    $remediation = $_POST['remediation'];

    // Update the existing violation in the database
    $sql_edit_violation = "UPDATE violation SET violation_type = '$violation_type', description = '$description', violation_date = '$violation_date', remarks = '$remarks', remediation = '$remediation' WHERE violation_id = '$violation_id'";
    $conn->query($sql_edit_violation);


    // Refresh the page to show the updated violations
    header("Location: view_violations.php?stall_owner_id=$stall_owner_id");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stall Owner Management | Admin</title>
    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Add your CSS and JavaScript includes here -->

    <style>
        /* Add your custom CSS styles here */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f2f2f2;
        }

    

        /* Additional custom styles for modals */
        .modal {
            font-family: Arial, sans-serif;
        }
    </style>
</head>

<body>

    <?php include "topbar.php"; ?>

    <div class="container">

        <?php if (isset($stall_owner)) : ?>
            <h2 style="margin-top:7%;">Stall Owner Information</h2>
            <p><strong>ID:</strong> <?php echo $stall_owner['id']; ?></p>
            <p><strong>Name:</strong> <?php echo $stall_owner['name']; ?></p>
            <p><strong>Stall Number:</strong> <?php echo $stall_owner['stall_no']; ?></p>

            <h2>Violations</h2>
               <!-- Button to add a new violation -->
               <button type="button" class="btn btn-success" style="float:right;" data-toggle="modal" data-target="#addViolationModal">Add Violation</button>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Violation Type</th>
                        <th>Description</th>
                        <th>Violation Date</th>
                        <th>Remarks</th>
                        <th>Remediation</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result_violations->num_rows > 0) {
                        while ($row_violation = $result_violations->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row_violation['violation_type'] . "</td>";
                            echo "<td>" . $row_violation['description'] . "</td>";
                            echo "<td>" . $row_violation['violation_date'] . "</td>";
                            echo "<td>" . $row_violation['remarks'] . "</td>";
                            echo "<td>" . $row_violation['remediation'] . "</td>";
                            echo "<td>";
                            echo "<button type='button' class='btn btn-primary btn-sm' data-toggle='modal' data-target='#editViolationModal' data-vio-id='" . $row_violation['violation_id'] . "' data-vio-type='" . $row_violation['violation_type'] . "' data-desc='" . $row_violation['description'] . "' data-vio-date='" . $row_violation['violation_date'] . "' data-remarks='" . $row_violation['remarks'] . "' data-remediation='" . $row_violation['remediation'] . "'>Edit</button>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No violations found for this stall owner</td></tr>";
                    }
                    ?>
                </tbody>
            </table>

         

            <!-- Form to add a new violation -->
            <div class="modal fade" id="addViolationModal" tabindex="-1" role="dialog" aria-labelledby="addViolationModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addViolationModalLabel">Add Violation</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST">
                                <input type="hidden" name="stall_owner_id" value="<?php echo $stall_owner_id; ?>">
                                <div class="form-group">
                                    <label for="violation_type">Violation Type</label>
                                    <input type="text" name="violation_type" id="violation_type" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="description" class="form-control" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="violation_date">Violation Date</label>
                                    <input type="date" name="violation_date" id="violation_date" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="remarks">Remarks</label>
                                    <textarea name="remarks" id="remarks" class="form-control" ></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="remediation">Remediation</label>
                                    <textarea name="remediation" id="remediation" class="form-control" ></textarea>
                                </div>
                                <button type="submit" name="add_violation" class="btn btn-primary">Add Violation</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Violation Modal -->
            <div class="modal fade" id="editViolationModal" tabindex="-1" role="dialog" aria-labelledby="editViolationModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editViolationModalLabel">Edit Violation</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST">
                                <input type="hidden" name="stall_owner_id" value="<?php echo $stall_owner_id; ?>">
                                <div class="form-group">
                                    <label for="violation_id">Violation ID</label>
                                    <input type="text" name="violation_id" id="violation_id" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="violation_type">Violation Type</label>
                                    <input type="text" name="violation_type" id="violation_type_edit" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="description_edit" class="form-control" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="violation_date">Violation Date</label>
                                    <input type="date" name="violation_date" id="violation_date_edit" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="remarks">Remarks</label>
                                    <textarea name="remarks" id="remarks_edit" class="form-control" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="remediation">Remediation</label>
                                    <textarea name="remediation" id="remediation_edit" class="form-control" required></textarea>
                                </div>
                                <button type="submit" name="edit_violation" class="btn btn-primary">Save Changes</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        <?php else : ?>
            <p>No stall owner ID provided. Please go back to the previous page.</p>
        <?php endif; ?>
    </div>

    <!-- Add Bootstrap JS links -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        // JavaScript function to open the edit modal and populate form fields with violation data
        $(document).ready(function () {
            $('#editViolationModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var violationId = button.data('vio-id');
                var violationType = button.data('vio-type');
                var description = button.data('desc');
                var violationDate = button.data('vio-date');
                var remarks = button.data('remarks');
                var remediation = button.data('remediation');

                var modal = $(this);
                modal.find('#violation_id').val(violationId);
                modal.find('#violation_type_edit').val(violationType);
                modal.find('#description_edit').val(description);
                modal.find('#violation_date_edit').val(violationDate);
                modal.find('#remarks_edit').val(remarks);
                modal.find('#remediation_edit').val(remediation);
            });
        });
    </script>
</body>

</html>
