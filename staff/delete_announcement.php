<?php
include "../config/config.php";
include "../config/session.php";

// Check if the user is logged in as an staff
if (isset($_SESSION['username']) && $_SESSION['roles'] == 'admin') {
    // Check if the announcement ID is provided in the URL
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Delete the announcement from the database
        $query = "DELETE FROM announcements WHERE id = $id";
        if ($conn->query($query)) {
            // Redirect to the announcements page after successful deletion
            header("location: ../staff/annoucement.php");
        } else {
            // Display an error message if deletion fails
            echo "Error deleting announcement: ";
        }
    } else {
        // Announcement ID not provided
        echo "Invalid request.";
    }
} else {
    // Redirect to the login page if not logged in as an staff
    echo "<script>alert('Unauthorized Access'); window.location.href = 'annoucement.php';</script>";
}
?>
