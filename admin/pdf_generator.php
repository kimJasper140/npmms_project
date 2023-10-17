<?php
include "../config/config.php";
require_once('../tcpdf/tcpdf.php');

// Get the status from the request
$status = $_GET['status'];

// Retrieve stall owner data for the selected status
$query = "SELECT stall_no, name, age, address, email, contact, user_id FROM stall_owner WHERE status = '$status'";
$result = mysqli_query($conn, $query);

// Create new PDF document
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Stall Owner List - ' . ucfirst($status));
$pdf->SetSubject('Stall Owner List - ' . ucfirst($status));

// Set default header data
$pdf->SetHeaderData('', 0, '', '');

// Set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// Set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// Set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, 1, 2);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// Set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// Set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// Set font
$pdf->SetFont('helvetica', '', 10);

// Add a page
$pdf->AddPage();

// Header
$pdf->Cell(0, 10, 'Stall Owner List - ' . ucfirst($status), 0, 1, 'C');

// Table
$pdf->SetFont('helvetica', 'B', 10);
$pdf->SetFillColor(230, 230, 230);
$pdf->Cell(15, 7, 'Stall No', 1, 0, 'C', 1);
$pdf->Cell(35, 7, 'Name', 1, 0, 'C', 1);
$pdf->Cell(15, 7, 'Age', 1, 0, 'C', 1);
$pdf->Cell(40, 7, 'Address', 1, 0, 'C', 1);
$pdf->Cell(40, 7, 'Email', 1, 0, 'C', 1);
$pdf->Cell(30, 7, 'Contact', 1, 0, 'C', 1);
$pdf->Cell(15, 7, 'User ID', 1, 1, 'C', 1);

$pdf->SetFont('helvetica', '', 10);
while ($row = mysqli_fetch_assoc($result)) {
    $pdf->Cell(15, 7, $row['stall_no'], 1, 0, 'C');
    $pdf->Cell(35, 7, $row['name'], 1, 0, 'C');
    $pdf->Cell(15, 7, $row['age'], 1, 0, 'C');
    $pdf->Cell(40, 7, $row['address'], 1, 0, 'C');
    $pdf->Cell(40, 7, $row['email'], 1, 0, 'C');
    $pdf->Cell(30, 7, $row['contact'], 1, 0, 'C');
    $pdf->Cell(15, 7, $row['user_id'], 1, 1, 'C');
}

// Output the PDF
$pdf->Output('stall_owners_' . $status . '.pdf', 'I');
?>
