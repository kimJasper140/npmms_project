<?php
// Include the JPGraph library
require_once ('jpgraph/src/jpgraph.php');
require_once ('jpgraph/src/jpgraph_line.php');

// Sample data
$data = array(12, 15, 7, 2, 18, 9, 21, 10, 6, 21);

// Create a new graph
$graph = new Graph(400, 300);
$graph->SetScale('intlin');
$graph->title->Set('Monthly violation report');

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

