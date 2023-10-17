<?php
include "../config/config.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Get the read_status value from the AJAX request
  $readStatus = $_POST['readStatus'];

  // Update the read_status in the database
  $updateQuery = "UPDATE notifications SET read_status = true";
  $updateResult = mysqli_query($conn, $updateQuery);

  if ($updateResult) {
    echo "success";
  } else {
    echo "error";
  }
} else {
  echo "Invalid request";
}

// Close the database connection
mysqli_close($conn);
?>
<script>
    $(document).ready(function () {
        $("#notification-link").click(function (event) {
            event.preventDefault();

            // Send an AJAX request to update the read_status
            $.ajax({
                url: "update_notification_status.php", // Update the URL to the correct file path
                type: "POST",
                data: { readStatus: 1 }, // Set the read_status value to 1
                success: function (response) {
                    // Update the badge count
                    $("#notification-badge").text("");
                },
                error: function (xhr, status, error) {
                    console.log(error);
                }
            });
        });
    });
</script>

