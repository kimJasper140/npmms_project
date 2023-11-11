<?php
require_once('../tcpdf/tcpdf.php');

include "../config/config.php";

if (isset($_POST['action']) && $_POST['action'] === 'convertToPdf') {
    $appId = $_POST['id'];

    // Fetch the application details from the database
    $fetchQuery = "SELECT * FROM applications WHERE id = '$appId'";
    $fetchResult = mysqli_query($conn, $fetchQuery);
    $application = mysqli_fetch_assoc($fetchResult);

    // Assign the fetched values to variables
    $stallNo = $application['stall_no'];
    $name = $application['name'];
    $age = $application['age'];
    $address = $application['address'];
    $applicantName = $application['applicant_name'];
    $stallNo2 = $application['stall_no2'];
    $applicantAge = $application['applicant_age'];
    $applicantAddress = $application['applicant_address'];
    $taxCertificateIssuedLocation = $application['tax_certificate_issued_location'];
    $taxCertificateIssuedDate = $application['tax_certificate_issued_date'];
    $email = $application['email'];
    $Contact = $application['contact'];
    $sworndate = $application['sworn_at'];
}

// Create a new TCPDF object
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8');

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Lease Application Form');
$pdf->SetSubject('Lease Application Form');
$pdf->SetKeywords('Lease, Application, Form');

// Remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// Add a page
$pdf->AddPage();

// Set font
$pdf->SetFont('helvetica', '', 12);

// Write the form content

$pdf->Write(10, 'APPLICATION TO LEASE MARKET STALLS');
$pdf->Ln();
$pdf->Write(10, 'WITHIN THE NAUJAN MARKET COMPOUND');
$pdf->Ln();
$pdf->Ln();


$pdf->Write(10, 'I, ' . $name . ', hereby apply under the following contract for lease of stall and/or table space no ' . $stallNo . ' of the Naujan Public Market.');
$pdf->Ln();
$pdf->Write(10, 'I am ' . $age . ' years of age, a citizen of the Philippines, and residing at ' . $address . ', Naujan Oriental Mindoro.');
$pdf->Ln();
$pdf->Ln();

$pdf->Write(10, 'Terms and Conditions:');
$pdf->Ln();
$pdf->SetLeftMargin(20);
$pdf->SetFont('helvetica', '', 10);
$pdf->Write(10, '1. That while I am occupying or having this stall/table space leased under my name, I shall at all times have my picture conveniently framed and hung up conspicuously in the stall.');
$pdf->Ln();
$pdf->Write(10, '2. I shall keep the stall/table at all times in good sanitary condition and comply strictly with all the sanitary and market rules and regulations now existing or which may hereafter be promulgated.');
$pdf->Ln();
$pdf->Write(10, '3. I shall pay the corresponding rental fee for the stall/table space in the manner prescribed by existing ordinance as reflected in the Contract of Lease or those that may be promulgated from time to time by the Municipality of Naujan thru the Sangguniang Bayan (Refer to Attached contract).');
$pdf->Ln();
$pdf->Write(10, '4. The business to be conducted in the stall/table space shall belong exclusively to me.');
$pdf->Ln();
$pdf->Write(10, '5. In case I engage a helper, I shall nevertheless personally conduct my business and be present at the stall.');
$pdf->Ln();
$pdf->Write(10, '6. I shall not use pathways bordering my stall for purposes of displaying any merchandise.');
$pdf->Ln();
$pdf->Write(10, '7. That I shall not use the stall/table space leased merely as bodegas or storage rooms.');
$pdf->Ln();
$pdf->Write(10, '8. I shall not sell or transfer lease my privilege of the stall/table space, neither permit another person to conduct business thereon.');
$pdf->Ln();
$pdf->Write(10, '9. Any violation on my part of the foregoing conditions and those provided with the Contract of Lease hereby attached shall be sufficient cause for the recession of the mentioned contract.');
$pdf->Ln();
$pdf->Write(10, '10. That these conditions with the promises and/or conditions stated herein shall form an integral part of the contract hereby attached.');
$pdf->Ln();
$pdf->Ln();

$pdf->SetFont('helvetica', '', 12);
$pdf->Write(10, 'I, ' . $name . ', hereby state that I am the person who signed the foregoing application, that I have read the same, and that the contents thereof are true to the best of my knowledge and belief.');
$pdf->Ln();
$pdf->Ln();
$pdf->Write(10, 'Applicant Signature: ' . $name);
$pdf->Ln();
$pdf->Ln();
$pdf->Write(10, 'SUBSCRIBED AND SWORN to before this day of ' . $sworndate . ' in the Municipality of Naujan, Oriental Mindoro, application/affiant exhibiting to me his/her Community Tax Certificate No. issued at ' . $taxCertificateIssuedLocation . ', Naujan, Oriental Mindoro on ' . $taxCertificateIssuedDate . '.');
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('helvetica', '', 10);
$pdf->Write(10, 'Municipal Mayor');
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('helvetica', '', 12);
$pdf->Write(10, 'Please see the attached contract for more details.');

// Output the PDF as a file named 'application_form.pdf'
$pdf->Output('application_form.pdf', 'D');
exit;
?>
