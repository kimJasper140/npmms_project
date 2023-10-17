<?php
require_once('../tcpdf/tcpdf.php');
include "../config/config.php";

// Check if a month is selected
if (isset($_POST['month'])) {
    $selectedMonth = $_POST['month'];

    // Fetch feedback data from the database for the selected month
    $sql = "SELECT * FROM feedback WHERE DATE_FORMAT(created_at, '%Y-%m') = '$selectedMonth' ORDER BY created_at DESC";
    $result = $conn->query($sql);

    // Check if there are feedback entries for the selected month
    if ($result->num_rows > 0) {
        // Create a new PDF instance
        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8');

        // Set the document information
        $pdf->SetCreator('Feedback Report');
        $pdf->SetAuthor('Your Name');
        $pdf->SetTitle('Feedback Report on the month of - ' . $selectedMonth);

        // Set margins
        $pdf->SetMargins(15, 15, 15);

        // Add a page
        $pdf->AddPage();

        // Set font
        $pdf->SetFont('helvetica', '', 12);

        // Output the month as title
        $pdf->Cell(0, 10, 'Feedback Report based on the month of - ' . $selectedMonth, 0, 1, 'C');
        $pdf->Ln(); // Add a line break

        // Create the table header
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(40, 10, 'Name', 1, 0, 'C');
        $pdf->Cell(110, 10, 'Message', 1, 0, 'C');
        $pdf->Cell(40, 10, 'Created At', 1, 1, 'C');

        // Set font back to regular
        $pdf->SetFont('helvetica', '', 10);

        while ($row = $result->fetch_assoc()) {
            // Output feedback data as table rows
            $pdf->Cell(40, 10, $row['name'], 1, 0, 'L');
            $pdf->Cell(110, 10, $row['message'], 1, 0, 'L');
            $pdf->Cell(40, 10, $row['created_at'], 1, 1, 'L');
        }

        // Generate the PDF content as a string
        ob_start();
        $pdf->Output('feedback_report_' . date('Y-m-d') . '.pdf', 'I');
        $pdfContent = ob_get_clean();

        // Display the PDF in the browser
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="feedback_report_' . date('Y-m-d') . '.pdf"');
        header('Cache-Control: private, max-age=0, must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . strlen($pdfContent));
        ob_clean();
        flush();
        echo $pdfContent;
        exit;
    } else {

        echo "<script>alert('No feedback entries found for the selected month.'); window.location.href = 'feedback.php';</script>";
        exit; // Stop executing the rest of the PHP code
}
}
?>
