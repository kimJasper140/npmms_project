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
        <style>
        /* Adjust the size of the image container as per your preference */
        .image-zoom-container {
            width: 200px;
            height: 150px;
            overflow: hidden;
        }

        /* Adjust the size of the image to fit the container */
        .zoomable-image {
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        /* Add CSS for the zoom effect */
        .zoomed {
            width: 400px;
            height: auto;
        }
    </style>
    </head>
    <body>
        <button type="button" class="btn btn-success" onclick="showPage('payment_reports.php')">Back</button>
        <div class="container" style="margin-top:5%;">
            <h2 class="mt-4">Report Overview</h2>
    
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Stall No</th>
                            <th>Stall Owner</th>
                            <th>Monthly Rental</th>
                            <th>Stall Extension</th>
                            <th>Payment Monthly Rental</th>
                            <th>Stall Extension Fee</th>
                            <th>Penalty</th>
                            <th>Interest</th>
                            <th>OR Number</th>
                            <th>Data</th>
                            <th>Total Amount</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>
