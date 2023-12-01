<!DOCTYPE html>
<html>
<head>
  <title>Edit Payment</title>
  <!-- Add any necessary CSS or other scripts here -->
</head>
<body>
  <!-- Your other HTML content -->

  <!-- Button to trigger edit and send data to PHP -->
  <button type="button" name="edit" onclick="sendEditRequest()" class="edit-button btn btn-primary" data-id="1">Edit</button>

  <!-- Your other HTML content -->

  <!-- JavaScript code -->
  <script>
    function sendEditRequest() {
      var paymentId = document.querySelector('.edit-button').getAttribute('data-id'); // Get the payment ID from data-id attribute

      // AJAX request to send data to PHP
      var xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
          if (xhr.status === 200) {
            // Handle the response from PHP if needed
            console.log('Request successful:', xhr.responseText);
            // You can add logic here to handle the response from PHP
          } else {
            console.error('Error:', xhr.status);
            // Handle error responses if needed
          }
        }
      };

      xhr.open('POST', '<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>', true); // Use the same file as the PHP processing script
      xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      var params = 'payment_id=' + encodeURIComponent(paymentId); // Data to send to PHP
      xhr.send(params);
    }
  </script>

  <?php
  // PHP code for processing the AJAX request
  if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['payment_id'])) {
      // Retrieve the payment ID sent from JavaScript
      $payment_id = $_POST['payment_id'];

      // Process the payment ID as needed
      // For instance, you can perform database operations or any other required actions here

      // Example: Printing the received payment ID
      echo "Received payment ID: " . $payment_id;
  }
  ?>
</body>
</html>
