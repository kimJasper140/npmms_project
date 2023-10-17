<?php
	include("config/config.php");

  ?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="css/mystyle.css" /> 
<title>Dashboard | NPMMS</title>
</head>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script>
    <script src="chart1.js"></script>
    <script src="chart2.js"></script>
<body>
<?php 
include "template/header.php";?>

<div class="main">
            <div class="cards">
                <div class="card">
                    <div class="card-content">
                        <div class="number"> <?php  
        include "config/config.php";
           // Check connection
           if (mysqli_connect_errno())
             {
             echo "Failed to connect to MySQL: " . mysqli_connect_error();
             }
           
           $sql="SELECT * FROM stall";
           if ($result=mysqli_query($mysqli,$sql))
             {
             // Return the number of rows in result set
             $rowcount=mysqli_num_rows($result);
             mysqli_free_result($result);
             
             echo $rowcount;
             }
           
           mysqli_close($mysqli);
           ?></div>
                        <div class="card-name">Stalls</div>
                    </div>
                    <div class="icon-box">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-shop" viewBox="0 0 16 16">
  <path d="M2.97 1.35A1 1 0 0 1 3.73 1h8.54a1 1 0 0 1 .76.35l2.609 3.044A1.5 1.5 0 0 1 16 5.37v.255a2.375 2.375 0 0 1-4.25 1.458A2.371 2.371 0 0 1 9.875 8 2.37 2.37 0 0 1 8 7.083 2.37 2.37 0 0 1 6.125 8a2.37 2.37 0 0 1-1.875-.917A2.375 2.375 0 0 1 0 5.625V5.37a1.5 1.5 0 0 1 .361-.976l2.61-3.045zm1.78 4.275a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 1 0 2.75 0V5.37a.5.5 0 0 0-.12-.325L12.27 2H3.73L1.12 5.045A.5.5 0 0 0 1 5.37v.255a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0zM1.5 8.5A.5.5 0 0 1 2 9v6h1v-5a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v5h6V9a.5.5 0 0 1 1 0v6h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1V9a.5.5 0 0 1 .5-.5zM4 15h3v-5H4v5zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-3zm3 0h-2v3h2v-3z"/>
</svg>
                    </div>
                </div>
                <div class="card">
                    <div class="card-content">
                        <div class="number"> <?php  
        include "config/config.php";
           // Check connection
           if (mysqli_connect_errno())
             {
             echo "Failed to connect to MySQL: " . mysqli_connect_error();
             }
           
           $sql="SELECT * FROM violation";
           if ($result=mysqli_query($mysqli,$sql))
             {
             // Return the number of rows in result set
             $rowcount=mysqli_num_rows($result);
             mysqli_free_result($result);
             
             echo $rowcount;
             }
           
           mysqli_close($mysqli);
           ?></div>
                        <div class="card-name">Violations</div>
                    </div>
                    <div class="icon-box">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill" viewBox="0 0 16 16">
  <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
</svg>
                    </div>
                </div>
                <div class="card">
                    <div class="card-content">
                        <div class="number">
                        <?php  
        include "config/config.php";
           // Check connection
           if (mysqli_connect_errno())
             {
             echo "Failed to connect to MySQL: " . mysqli_connect_error();
             }
           
           $sql="SELECT * FROM user";
           if ($result=mysqli_query($mysqli,$sql))
             {
             // Return the number of rows in result set
             $rowcount=mysqli_num_rows($result);
             mysqli_free_result($result);
             
             echo $rowcount;
             }
           
           mysqli_close($mysqli);
           ?>
                        </div>
                        <div class="card-name">Account</div>
                    </div>
                    <div class="icon-box">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-people" viewBox="0 0 16 16">
  <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8Zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022ZM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816ZM4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0Zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4Z"/>
</svg>
                    </div>
                </div>
                <div class="card">
                    <div class="card-content">
                        <div class="number"><?php  
        include "config/config.php";
           // Check connection
           if (mysqli_connect_errno())
             {
             echo "Failed to connect to MySQL: " . mysqli_connect_error();
             }
           
           $sql="SELECT * FROM feedback";
           if ($result=mysqli_query($mysqli,$sql))
             {
             // Return the number of rows in result set
             $rowcount=mysqli_num_rows($result);
             mysqli_free_result($result);
             
             echo $rowcount;
             }
           
           mysqli_close($mysqli);
           ?></div>
                        <div class="card-name">Feedback</div>
                    </div>
                    <div class="icon-box">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-card-text" viewBox="0 0 16 16">
  <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z"/>
  <path d="M3 5.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM3 8a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 8zm0 2.5a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5z"/>
</svg>
                    </div>
                </div>
            </div>
            <div class="charts">
                <div class="chart">
                    <h2>Recent Update</h2>
                    <div>
                        <canvas id="lineChart"></canvas>
                    </div>
                </div>
                <div class="chart doughnut-chart">
                    <h2> Upcoming Events</h2>
                    <div>
                        <canvas id="doughnut"></canvas>
                    </div>
                </div>
            </div>
        </div>
        
    </div>

 
    