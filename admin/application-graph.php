<?php
include "../config/config.php";

// Fetch violation data from the database
$query = "SELECT MONTH(violation_date) AS month, COUNT(*) AS total_violations FROM violation GROUP BY MONTH(violation_date)";
$result = mysqli_query($conn, $query);

// Prepare the data arrays for the line graph
$labels = [];
$data = [];

while ($row = mysqli_fetch_assoc($result)) {
    $labels[] = $row['month'];
    $data[] = $row['total_violations'];
}

// Convert the data arrays to JSON format
$labelsJSON = json_encode($labels);
$dataJSON = json_encode($data);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Monthly Violation Data</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        canvas {
            max-width: 80%;
            max-height;:: 80%;
            margin-left:20%;
            margin-right:5%;
            margin-top:10%;
            
        }

    </style>
</head>
<body>
    <canvas id="lineChart"></canvas>

    <script>
        // Get the canvas element
        var canvas = document.getElementById('lineChart');
        var ctx = canvas.getContext('2d');

        // Data for the line graph (retrieved from the database)
        var monthlyData = {
            labels: <?php echo $labelsJSON; ?>,
            datasets: [{
                label: 'Violations',
                data: <?php echo $dataJSON; ?>,
                borderColor: 'red',
                backgroundColor: 'transparent',
                tension: 0.4,
                fill: true
            }]
        };

        // Create the line chart
        var lineChart = new Chart(ctx, {
            type: 'line',
            data: monthlyData,
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
