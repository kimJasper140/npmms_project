<?php
require_once '../config/config.php';
session_start();
?>

<!DOCTYPE html>
<html lang = "en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Online Payment | Admin</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script>
            function showPage(url){
                window.location.href = url;
            }
        </script>
    </head>
    <body>
        <div class="container" style="margin-top: 5%">
            <h2 class="mt-4">Transaction Information</h2>
            <button type="button" class="btn btn-success" onclick="showPage('monthly-payment.php')" >Payment History</button>
            <button type="button" class="btn btn-success" onclick="showPage('payment_reports.php')">Payment Reports</button>
            <h3 class="mt-4">Payment Reports</h3>
        <div>
    </body>
</html>
