<?php
include("../config/config.php");
include("../tcpdf/tcpdf.php");
session_start();


if (isset($_GET["month"])){
    // Fetch data from MySQL
    $month = $_GET["month"];
    $sql = "SELECT * FROM monthly_payment_details WHERE month='$month'";
    $result = $conn->query($sql);

    // Create new PDF document
    $pdf = new TCPDF();

    // Set document information and properties
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetTitle('MySQL Data to PDF');
    $pdf->SetHeaderData('', 0, 'Monthly Report for the Month of ' . $month, '');

    // Add a page
    $pdf->AddPage();

    // Set font
    $pdf->SetFont('helvetica', '', 12);

    // Iterate through fetched data and add to PDF
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $pdf->Write(0, "ID: " . strval($row['id']) . "\n");
            $pdf->Write(0, "Monthly Rental: " . strval($row['monthly_rental']) . "\n");
            $pdf->Write(0, "Extension Rental: " . strval($row['extension_rental']) . "\n");
            $pdf->Write(0, "Stall Extension Fee: " . strval($row['stall_extension_fee']) . "\n");
            $pdf->Write(0, "Penalty: " . strval($row['penalty_25']) . "\n");
            $pdf->Write(0, "Interest: " . strval($row['interest_2']) . "\n");
            $pdf->Write(0, "OR Number: " . $row['or_no'] . "\n");
            $pdf->Write(0, "Date: " . $row['date'] . "\n");
            $pdf->Write(0, "Total Amount: " . strval($row['total_amount']) . "\n");
            $pdf->Write(0, "Remarks: " . $row['remarks'] . "\n");
            $pdf->Write(0, "Owner: " . $row['fullname'] . "\n");
            $pdf->Write(0, "Stall Number: " . $row['owner_id'] . "\n\n"); // Add additional line break
        }
    } else {
        $pdf->Write(0, 'No data found');
    }

    // Close and output PDF
    $pdf->Output('monthly_report.pdf', 'I');
    }

    
?>