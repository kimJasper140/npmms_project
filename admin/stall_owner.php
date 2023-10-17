<?php
include "../config/config.php";
require_once('../tcpdf/tcpdf.php');
session_start();

// Retrieve stall owner data for different sections
$operateQuery = "SELECT stall_no, name, age, address, email, contact, user_id FROM stall_owner WHERE status = 'operate'";
$operateResult = mysqli_query($conn, $operateQuery);

$closedQuery = "SELECT stall_no, name, age, address, email, contact, user_id FROM stall_owner WHERE status = 'closed'";
$closedResult = mysqli_query($conn, $closedQuery);

$terminateQuery = "SELECT stall_no, name, age, address, email, contact, user_id FROM stall_owner WHERE status = 'terminate'";
$terminateResult = mysqli_query($conn, $terminateQuery);

$renderingQuery = "SELECT stall_no, name, age, address, email, contact, user_id FROM stall_owner WHERE status = 'rendering'";
$renderingResult = mysqli_query($conn, $renderingQuery);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Stall Owner List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1 {
            text-align: center;
            background-color: #f2f2f2;
            padding: 10px;
        }

        .section {
            margin-top: 50px;
        }

        .section-title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .tab {
            overflow: hidden;
            margin-top: 20px;margin-left: 5%;
        }

        .tab button {
            background-color: #f2f2f2;
            border: none;
            outline: none;
            cursor: pointer;
            padding: 10px 20px;
            margin-right: 5px;
            font-size: 16px;
            transition: 0.3s;
            
        }

        .tab button:hover {
            background-color: #ddd;
        }

        .tab button.active {
            background-color: #007bff;
            color: #fff;
           
        }

        .tab-content {
            display: none;
            max-width: 90%;
            margin-left: 5%;
        }

        .pdf-button {
            text-align: center;
            margin-top: 20px;
        }

        .pdf-button a {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
    <script>
        function openTab(evt, tabName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tab-content");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(tabName).style.display = "block";
            evt.currentTarget.className += " active";
        }

        function generatePDF(status) {
            var tabContent = document.getElementById(status);
            var table = tabContent.querySelector("table").outerHTML;
            var title = "";

            if (status === "operated") {
                title = "Operated";
            } else if (status === "closed") {
                title = "Closed";
            } else if (status === "terminate") {
                title = "Terminate";
            } else if (status === "rendering") {
                title = "Rendering";
            }

            fetch("pdf_generator.php?status=" + status, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({
                    pdfData: table,
                    pdfTitle: title,
                }),
            })
            .then(function (response) {
                return response.blob();
            })
            .then(function (blob) {
                // Create a temporary link element to preview the PDF
                var fileURL = URL.createObjectURL(blob);
                window.open(fileURL);

                // Uncomment the following lines to download the PDF directly
                // var link = document.createElement("a");
                // link.href = URL.createObjectURL(blob);
                // link.download = "stall_owners_" + status + ".pdf";
                // link.click();
            })
            .catch(function (error) {
                console.error("Error generating PDF:", error);
            });
        }
    </script>
</head>
<body>
    <?php include "topbar.php"; ?>
    <h3 style="margin-top:5%;">Stall Owner List</h3>

    <div class="tab">
        <button class="tablinks active" onclick="openTab(event, 'operate')">Operate</button>
        <button class="tablinks" onclick="openTab(event, 'closed')">Closed</button>
        <button class="tablinks" onclick="openTab(event, 'terminate')">Terminate</button>
        <button class="tablinks" onclick="openTab(event, 'rendering')">Rendering</button>
    </div>

    <div id="operate" class="tab-content" style="display: block;">
        <div class="section">
            <h2 class="section-title">Operate</h2>
            <?php if (mysqli_num_rows($operateResult) > 0) { ?>
                <table>
                    <tr>
                        <th>Stall No</th>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Address</th>
                        <th>Email</th>
                        <th>Contact</th>
                        <th>User ID</th>
                    </tr>
                    <?php while ($row = mysqli_fetch_assoc($operateResult)) { ?>
                        <tr>
                            <td><?php echo $row['stall_no']; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['age']; ?></td>
                            <td><?php echo $row['address']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['contact']; ?></td>
                            <td><?php echo $row['user_id']; ?></td>
                        </tr>
                    <?php } ?>
                </table>
                <div class="pdf-button">
                    <a href="#" onclick="generatePDF('operate')">Generate PDF Report</a>
                </div>
            <?php } else { ?>
                <p class="message">No stall owners found in the "Operate" section.</p>
            <?php } ?>
        </div>
    </div>

    <div id="closed" class="tab-content">
        <div class="section">
            <h2 class="section-title">Closed</h2>
            <?php if (mysqli_num_rows($closedResult) > 0) { ?>
                <table>
                    <tr>
                        <th>Stall No</th>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Address</th>
                        <th>Email</th>
                        <th>Contact</th>
                        <th>User ID</th>
                    </tr>
                    <?php while ($row = mysqli_fetch_assoc($closedResult)) { ?>
                        <tr>
                            <td><?php echo $row['stall_no']; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['age']; ?></td>
                            <td><?php echo $row['address']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['contact']; ?></td>
                            <td><?php echo $row['user_id']; ?></td>
                        </tr>
                    <?php } ?>
                </table>
                <div class="pdf-button">
                    <a href="#" onclick="generatePDF('closed')">Generate PDF Report</a>
                </div>
            <?php } else { ?>
                <p class="message">No stall owners found in the "Closed" section.</p>
            <?php } ?>
        </div>
    </div>

    <div id="terminate" class="tab-content">
        <div class="section">
            <h2 class="section-title">Terminate</h2>
            <?php if (mysqli_num_rows($terminateResult) > 0) { ?>
                <table>
                    <tr>
                        <th>Stall No</th>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Address</th>
                        <th>Email</th>
                        <th>Contact</th>
                        <th>User ID</th>
                    </tr>
                    <?php while ($row = mysqli_fetch_assoc($terminateResult)) { ?>
                        <tr>
                            <td><?php echo $row['stall_no']; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['age']; ?></td>
                            <td><?php echo $row['address']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['contact']; ?></td>
                            <td><?php echo $row['user_id']; ?></td>
                        </tr>
                    <?php } ?>
                </table>
                <div class="pdf-button">
                    <a href="#" onclick="generatePDF('terminate')">Generate PDF Report</a>
                </div>
            <?php } else { ?>
                <p class="message">No stall owners found in the "Terminate" section.</p>
            <?php } ?>
        </div>
    </div>

    <div id="rendering" class="tab-content">
        <div class="section">
            <h2 class="section-title">Rendering</h2>
            <?php if (mysqli_num_rows($renderingResult) > 0) { ?>
                <table>
                    <tr>
                        <th>Stall No</th>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Address</th>
                        <th>Email</th>
                        <th>Contact</th>
                        <th>User ID</th>
                    </tr>
                    <?php while ($row = mysqli_fetch_assoc($renderingResult)) { ?>
                        <tr>
                            <td><?php echo $row['stall_no']; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['age']; ?></td>
                            <td><?php echo $row['address']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['contact']; ?></td>
                            <td><?php echo $row['user_id']; ?></td>
                        </tr>
                    <?php } ?>
                </table>
                <div class="pdf-button">
                    <a href="#" onclick="generatePDF('rendering')">Generate PDF Report</a>
                </div>
            <?php } else { ?>
                <p class="message">No stall owners found in the "Rendering" section.</p>
            <?php } ?>
        </div>
    </div>
</body>
</html>
