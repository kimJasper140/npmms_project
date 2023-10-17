<?php
// Include TCPDF library
require_once('../tcpdf/tcpdf.php');

// Check if the ID parameter is provided in the URL
if (isset($_GET['id'])) {
    $payment_id = $_GET['id'];

    // Include the database configuration file
    include "../config/config.php";

    // Fetch payment details based on the provided ID
    $sql_payment_details = "SELECT * FROM payment_details WHERE id = '$payment_id'";
    $result_payment_details = $conn->query($sql_payment_details);

    if ($result_payment_details) {
        if ($result_payment_details->num_rows > 0) {
            // Fetch payment details
            $row_payment_details = $result_payment_details->fetch_assoc();

            // Fetch stall owner information using stall_owner_id
            $stall_owner_id = $row_payment_details['stall_owner_id'];
            $sql_stall_owner = "SELECT name FROM stall_owner WHERE id = '$stall_owner_id'";
            $result_stall_owner = $conn->query($sql_stall_owner);

            if ($result_stall_owner) {
                $row_stall_owner = $result_stall_owner->fetch_assoc();
                $stall_owner_name = $row_stall_owner['name'];

                // Create a new PDF instance for 5.5 × 8.5 inches
                $pdf = new TCPDF('P', 'in', array(5.5, 8.5), true, 'UTF-8', false);
                createReceipt($pdf, $stall_owner_name, $row_payment_details);
            } else {
                echo "Error fetching stall owner information: " . $conn->error;
            }
        } else {
            echo "Payment details not found.";
        }
    } else {
        echo "Error fetching payment details: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
} else {
    echo "Payment ID not provided.";
}

// Function to create receipt content
function createReceipt($pdf, $stall_owner_name, $payment_details)
{
    // Set PDF margins
    $pdf->SetMargins(0.5, 0.5, 0.5, true);

    // Set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Your Name');
    $pdf->SetTitle('Payment Receipt');
    $pdf->SetSubject('Payment Receipt');

    // Add a page
    $pdf->AddPage();

    // Set font
    $pdf->SetFont('helvetica', '', 12);

    // Add content to the PDF
    $content = '<h2 style="text-align: center;">NAUJAN PUBLIC MARKET</h2>
                <p style="text-align: center;">NPMMS - Naujan Public Market Management System</p>
                <p style="text-align: center;">Address: Market Street, Barangay Poblacion, Naujan, Oriental Mindoro</p>
                <p style="text-align: center;">Contact: (123) 456-7890 | Email: market@npmms.com</p>
                <hr>
                <h3>Payment Receipt</h3>
                <p><strong>Stall Owner Name:</strong> ' . $stall_owner_name . '</p>
                <p><strong>Account Name:</strong> ' . $payment_details['account_name'] . '</p>
                <p><strong>Transaction:</strong> ' . $payment_details['transaction'] . '</p>
                <p><strong>Date:</strong> ' . $payment_details['date'] . '</p>
                <p><strong>Status:</strong> ' . $payment_details['status'] . '</p>
                <p><strong>Amount:</strong> ' . $payment_details['amount'] . '.00 PHP</p>
                <p><strong>Reference Number:</strong> ' . $payment_details['or_generated'] . '</p>
                
                <br>

                
                <br><b>Note</b>:<i> Receipt is computer genarated </i>';




    // Write content to PDF
    $pdf->writeHTML($content, true, false, true, false, '');

    // Output the PDF as a preview (inline)
    $pdf->Output('payment_receipt.pdf', 'I');
}
?>
