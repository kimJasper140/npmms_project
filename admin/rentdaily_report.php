<?php
// Include the PDF library (e.g., TCPDF or FPDF)
// For this example, we'll use TCPDF library

// Include the TCPDF library
require_once('../tcpdf/tcpdf.php');

// Function to fetch the daily report data from the database
function fetchDailyReportData()
{
    include "../config/config.php";

    // Query to fetch the daily report data for the current date
    $sql = "SELECT * FROM park_rent  ORDER BY time_in DESC";
    $result = mysqli_query($conn, $sql);

    $data = array();
    $totalAmount = 0; // Variable to calculate the total amount
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
            $totalAmount += (float) $row['amount']; // Add the amount to the total
        }
    }

    // Close the database connection
    mysqli_close($conn);

    return array(
        'data' => $data,
        'totalAmount' => $totalAmount
    );
}

// Create a new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$currentDate = date('Y-m-d');
// Set the document information
$pdf->SetCreator('Auto Generated report');
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Daily Report for ' . $currentDate . ' - Parking Rent List');

// Add a page to the document
$pdf->AddPage();

// Fetch the daily report data from the database
$reportData = fetchDailyReportData();
$data = $reportData['data'];
$totalAmount = $reportData['totalAmount'];

// Generate the PDF content if data is available
if (is_array($data) && count($data) > 0) {
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell(0, 10, 'Daily Report for ' . $currentDate . ' - Parking Rent List', 0, 1, 'C');
    $pdf->Ln(10);

    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(50, 10, 'Name', 1, 0, 'C');
    $pdf->Cell(30, 10, 'Plate No', 1, 0, 'C');
    $pdf->Cell(20, 10, 'Time In', 1, 0, 'C');
    $pdf->Cell(20, 10, 'Time Out', 1, 0, 'C');
    $pdf->Cell(30, 10, 'Amount', 1, 0, 'C');
    $pdf->Cell(40, 10, 'Remarks', 1, 1, 'C');

    $pdf->SetFont('helvetica', '', 10);
    foreach ($data as $entry) {
        $pdf->Cell(50, 10, $entry['name'], 1, 0, 'C');
        $pdf->Cell(30, 10, $entry['plate_no'], 1, 0, 'C');
        $pdf->Cell(20, 10, $entry['time_in'], 1, 0, 'C');
        $pdf->Cell(20, 10, $entry['time_out'], 1, 0, 'C');
        $pdf->Cell(30, 10, $entry['amount'], 1, 0, 'C');
        $pdf->Cell(40, 10, $entry['remarks'], 1, 1, 'C');
    }

    // Display the total amount
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(150, 10, 'Total Amount', 1, 0, 'R');
    $pdf->Cell(40, 10, number_format($totalAmount, 2), 1, 1, 'C');
} else {
    // Display a message if there are no entries found
    $pdf->SetFont('helvetica', '', 14);
    $pdf->Cell(0, 10, 'No entries found for the daily report.', 0, 1, 'C');
}

// Get the PDF content as a string
$pdfContent = $pdf->Output('', 'S');

// Output the HTML with the PDF preview
?>
<!DOCTYPE html>
<html>
<head>
    <title>Daily Report Preview</title>
    <style>
        /* Your existing CSS styles here */
        .pdf-preview {
            width: 100%;
            height: 100vh;
            border: none;
        }

        .download-button {
            margin-top: 20px;
            text-align: center;
        }

        .download-button button {
            padding: 5px 10px;
        }
    </style>
</head>
<body>
    <?php if (is_array($data) && count($data) > 0) : ?>
        <!-- PDF Preview -->
        <iframe class="pdf-preview" src="data:application/pdf;base64,<?php echo base64_encode($pdfContent); ?>"></iframe>

        <!-- Add button for downloading the PDF -->
        <div class="download-button">
            <button onclick="downloadPDF()">Download PDF</button>
        </div>
    <?php else : ?>
        <div class="pdf-preview">
            <p>No entries found for the daily report.</p>
        </div>
    <?php endif; ?>

    <script>
        function downloadPDF() {
            var a = document.createElement('a');
            a.href = "data:application/pdf;base64,<?php echo base64_encode($pdfContent); ?>";
            a.download = 'daily_report.pdf';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        }
    </script>
</body>
</html>
