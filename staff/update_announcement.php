<?php
include "../config/config.php";
include "../config/session.php";

if (isset($_SESSION['username']) && $_SESSION['roles'] == 'admin') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $id = $_POST['id'];

        $query = "UPDATE announcements SET title = '$title', content = '$content' WHERE id = $id";
        $result = mysqli_query($conn, $query);

        if ($result) {
            echo "Announcement updated successfully";
        } else {
            echo "Failed to update announcement";
        }
    } else {
        echo "Invalid request method";
    }
} else {
    echo "Unauthorized access";
}
?>
