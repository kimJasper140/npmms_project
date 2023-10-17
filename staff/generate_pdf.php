<?php require_once "../tcpdf/tcpdf.php"; // Replace with the path to TCPDF library
require_once "../config/config.php"; // Assuming this file contains the database connection
session_start();
// Fetch violation data from the database
$sql = "SELECT v.violation_type, v.description, v.stall_owner_id, v.violation_date, v.stall_number, v.appeal, v.remarks, v.remediation, s.name 
        FROM violation v
        LEFT JOIN stall_owner s ON v.stall_owner_id = s.id"; // Use 's.id' instead of 's.stall_owner_id'
$result = $conn->query($sql);


// Close the database connection
$conn->close();

// Check if the data is available
if ($result && $result->num_rows > 0) {
    $data = $result->fetch_all(MYSQLI_ASSOC);

    // Create new TCPDF object with A4 page orientation (default is portrait)
    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

    // Set the document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Your Name');
    $pdf->SetTitle('Violation Report');
    $pdf->SetSubject('Violation Report');

    // Add a page
    $pdf->AddPage();

    // Set font
    $pdf->SetFont('helvetica', '', 10);

    // Get column headers from the first row of the data
    $columns = array(
        'name' => 'Stall Owner',
        'violation_type' => 'Violation',

        'description' => 'Description',
        
        'violation_date' => 'Date ',
        'remarks' => 'Remarks '
    );

    // Generate the PDF table
    $pdf->Ln();
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->MultiCell(0, 10, 'Violation Report', 0, 'C');
    $pdf->Ln();
    $pdf->SetFont('helvetica', '', 10);
    $pdf->SetFillColor(220, 220, 220);

    // Generate the table header
    $pdf->SetFillColor(230, 230, 230);
    $pdf->SetTextColor(0);
    $pdf->SetDrawColor(128, 128, 128);
    $pdf->SetLineWidth(0.3);
    $pdf->SetFont('', 'B');

    // Set column widths dynamically based on the number of columns
    $numColumns = count($columns);
    $colWidth = 190 / $numColumns; // Adjust the width based on the number of columns
    $w = array_fill(0, $numColumns, $colWidth);

    foreach ($columns as $columnLabel) {
        $pdf->Cell($colWidth, 7, $columnLabel, 1, 0, 'C', true);
    }
    $pdf->Ln();
    $pdf->SetFont('');
    foreach ($data as $row) {
        foreach ($columns as $column => $columnLabel) {
            $pdf->Cell($colWidth, 7, $row[$column], 1, 0, 'C');
        }
        $pdf->Ln();
    }

    // Output the PDF to the browser
    $pdf->Output('violation_report.pdf', 'I');
    exit;
} else {
    // If the data is empty or doesn't contain rows, redirect to the main page
    $username = $_SESSION['username']; // Replace this with your actual method to retrieve the user's name
  
    // Display the personalized welcome message
    echo "<script>alert('Sorry Empty Table  , $username!');</script>";
    exit;
}
