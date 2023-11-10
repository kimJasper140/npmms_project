<?php
require_once "../config/config.php";
// Replace with the path to TCPDF library
session_start();
// Include the JPGraph library
require_once ('jpgraph/src/jpgraph.php');
require_once ('jpgraph/src/jpgraph_line.php');

// Graph Data
$userId = $_SESSION['id'];
$stallquery = "SELECT stall_no FROM stall_owner WHERE user_id = '$userId'";
$stallNumber = $conn->query($stallquery);
$stall_no = $stallNumber->fetch_assoc();
$st_num = $stall_no['stall_no'];
$data = array(0);

// Create a new graph
$graph = new Graph(400, 300);
$graph->SetScale('intlin');
$graph->title->Set('Monthly violation report');

$sql_query = "SELECT COUNT(*) as count FROM violation WHERE stall_number = '$st_num'";
$result = $conn->query($sql_query);
$res = $result->fetch_assoc()['count'];
$data[] = $res;

// Create a line plot
$lineplot = new LinePlot($data);

// Add the line plot to the graph
$graph->Add($lineplot);

// Start output buffering
ob_start();

// Display the graph (captured by output buffering)
$graph->Stroke();

// Get the captured image data
$imageData = ob_get_contents();

// End and clean the output buffer
ob_end_clean();

// Set the Content-Type header for the image
header("Content-Type: image/png");

// Output the image data
echo $imageData;
?>
