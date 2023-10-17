<?php
session_start();

// Include your database connection
include "../config/config.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the maintenance report from the database based on the provided report ID
    $sql = "SELECT * FROM maintenance WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    // Check if the maintenance report exists
    if ($row) {
        // Update the maintenance report status if the form is submitted
        if (isset($_POST['update_status'])) {
            $new_status = $_POST['status'];
            $update_sql = "UPDATE maintenance SET status = '$new_status' WHERE id = '$id'";
            if (mysqli_query($conn, $update_sql)) {
                // Status updated successfully, redirect to the maintenance list page
                header("Location:admin_maintainanceList.php");
                exit();
            } else {
                // Error in updating status
                echo "Error updating status: " . mysqli_error($conn);
            }
        }
    } else {
        echo "<p>No maintenance report found with the provided ID.</p>";
        exit();
    }
} else {
    include "topbar.php";
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Admin Maintenance Report List</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    </head>
    <body>
    <div class="container" style="margin-top:5%;">
        <h1>Admin Maintenance Report List</h1>
        <table class="table table-bordered" style="max-width:95%;">
            <tr>
                <th>Report ID</th>
                <th>Maintenance Type</th>
                <th>Description</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php
            // Fetch all maintenance reports from the database
            $sql = "SELECT * FROM maintenance ORDER BY date DESC";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['maintenance_type'] . "</td>";
                    echo "<td>" . $row['description'] . "</td>";
                    echo "<td>" . $row['status'] . "</td>";
                    echo '<td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal_' . $row['id'] . '">Edit</button></td>';
                    echo "</tr>";
                    ?>
                   <!-- Edit Modal -->
        <div class="modal fade" id="editModal_<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Maintenance Report</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $row['id']; ?>" method="POST">
                            <div class="form-group">
                                <label for="maintenanceType">Maintenance Type:</label>
                                <input type="text" id="maintenanceType" name="maintenanceType" class="form-control" value="<?php echo $row['maintenance_type']; ?>">
                            </div>

                            <div class="form-group">
                                <label for="description">Description:</label>
                                <textarea id="description" name="description" class="form-control" rows="4"><?php echo $row['description']; ?></textarea>
                            </div>

                            <div class="form-group">
                                <label for="status">Status:</label>
                                <select id="status" name="status" class="form-control">
                                    <option value="pending" <?php if ($row['status'] === 'pending') echo 'selected'; ?>>Pending</option>
                                    <option value="in_progress" <?php if ($row['status'] === 'in_progress') echo 'selected'; ?>>In Progress</option>
                                    <option value="completed" <?php if ($row['status'] === 'completed') echo 'selected'; ?>>Completed</option>
                                </select>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" name="update_status" class="btn btn-primary">Update Status</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
} else {
    echo "<tr><td colspan='5'>No maintenance reports found.</td></tr>";
}
?>
        </table>
    </div>

    <!-- Add your Bootstrap JavaScript and jQuery scripts here -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
    </html>
    <?php
}
?>
