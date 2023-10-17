<?php
include "../config/config.php";
require_once('../tcpdf/tcpdf.php');
$sql = "SELECT * FROM resources Where id=1";
$result = mysqli_query($conn, $sql);
($row = mysqli_fetch_assoc($result));
if (isset($_GET['id'])) {
    $appId = $_GET['id'];

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
    $tax_certificate_issued_date = $application['tax_certificate_issued_date'];
    $email = $application['email'];
    $Contact = $application['contact'];
    $sworndate = $application['sworn_at'];

    // Handle PDF conversion
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['convertToPdf'])) {
        // Create a new TCPDF instance
        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8');

        // Set document information
        $pdf->SetCreator('Your Name');
        $pdf->SetAuthor('Your Name');
        $pdf->SetTitle('Application Form');
        $pdf->SetSubject('Application Form');

        // Add a page
        $pdf->AddPage();

        // Set font
        $pdf->SetFont('helvetica', '', 12);

        // Write content to the PDF
        $content = '<h2 style="text-align:center;">APPLICATION TO LEASE MARKET STALLS<br>
                                        WITHIN THE NAUJAN MARKET COMPOUND</h2>
                                        <br>
                    <div style="font-size:11px;">
                        The Municipal Mayor<br>
                        Municipality of Naujan<br>
                        Province of Oriental Mindoro
                    </p>
                    <br>
                    <p style="font-size:11px;">
                        I, ' . $name . ', hereby apply under the following contract for lease of stall and/or table space no ' . $stallNo . ' of the Naujan Public Market. I am ' . $age . ' years of age, a citizen of the Philippines and residing at ' . $address . ' Naujan Oriental Mindoro.
                    </p>
                    <br> <br>
                    <ol style="font-size:11px;">
                        <li>That while I am occupying or having this stall/table space leased under my name, I shall at all times have my picture conveniently framed and hung up conspicuously in the stall.</li>
                        <li>I shall keep the stall/table at all times in good sanitary condition and comply strictly with all the sanitary and market rules and regulations now existing or which may hereafter be promulgated.</li>
                        <li>I shall pay the corresponding rental fee for the stall/table space in the manner prescribed by existing ordinance as reflected in the Contract of Lease or those that may be promulgated from time to time by the Municipality of Naujan thru the Sangguniang Bayan <a href="contract.php">(Refer to Attached contract).</a></li>
                        <li>The business to be conducted in the stall/table space shall belong exclusively to me.</li>
                        <li>In case I engage a helper, I shall nevertheless personally conduct my business and be present at the stall.</li>
                        <li>I shall not use pathways bordering my stall for purposes of displaying any merchandise.</li>
                        <li>That I shall not use the stall/table space leased merely as bodegas or storage rooms.</li>
                        <li>I shall not sell or transfer lease my privilege of the stall/table space, neither permit another person to conduct business thereon.</li>
                        <li>Any violation on my part of the foregoing conditions and those provided with the Contract of Lease hereby attached shall be sufficient cause for the recession of the mentioned contract.</li>
                        <li>That these conditions with the promises and/or conditions stated herein shall form an integral part of the contract hereby attached.</li>
                    </ol>
                    < style="font-size:11px;">
                        I ' . $name . ' hereby state that I am the person who signed the foregoing application, that I have read the same, and that the contents thereof are true to the best of my knowledge and belief.
                    </p>
                    <br>
                    <br>
                    <p style="font-size:11px;">
                        ' . $name . '<br>
                        APPLICANT
                    </p>
                    <p style="font-size:11px;">
                        SUBSCRIBED AND SWORN to before this day of ' . $sworndate . ' 2023 in the Municipality of Naujan, Oriental Mindoro, application/affiant exhibiting to me his/her Community Tax Certificate No. issued at ' .$taxCertificateIssuedLocation . ' NAUJAN, ORIENTAL MINDORO on ' .$tax_certificate_issued_date. ' (Y/M/D)
                    </p>
                    <br>
                    <br>
                    <p style="font-size:11px;">

                        ' . $row['content'] . '<br>
                        Municipal Mayor
                        </div>
                    </p>'
                    ;
                
        $pdf->writeHTML($content, true, false, true, false, '');

        // Output the PDF as a file
        $pdf->Output($applicantName.' Application.pdf', 'I');
        exit();
    }
}
?>
    <!DOCTYPE html>
    <html>

    <head>
        <title> Application Form</title>
        
    

        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 50px;
                margin-left: 2%;
                margin-top: 10%;
            }

            h2,
            h3 {
                text-align: center;
            }

            label {
                display: block;
                font-weight: bold;
                margin-top: 10px;
            }

            input[type="text"],
            textarea {
                width: 200px;
                padding: 5px;
                border: none;
                border-bottom: 1px solid #000;
            }

            textarea {
                height: 100px;
            }

            input[type="submit"] {
                padding: 10px 20px;
                background-color: #4CAF50;
                color: white;
                border: none;
                cursor: pointer;
            }

            .checkbox-container {
                text-align: center;
            }

            .checkbox-container label {
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .checkbox-container input[type="checkbox"] {
                margin-right: 5px;
            }
            
    /* Responsive Styles */
    @media screen and (max-width: 768px) {
        body {
            margin: 20px!important;
            padding-top: 25% !important;
        }

        form {
            margin-top: 10px;
        }

        h2,
        h3 {
            text-align: left;
            margin-left: 10px;
            margin-top: 10%;
        }

        label {
            margin-top: 5px;
        }

        input[type="text"],
        textarea {
            width: 50%;
            box-sizing: border-box;
        }
    }


        </style>
    </head>
    <?php 
    //include "header-home.php";
    ?>
    <body>
        <div style="margin-left:5%;margin-top:8%;margin-bottom:5%;">
        <h2>APPLICATION TO LEASE MARKET STALLS</h2>
        <h3>WITHIN THE NAUJAN MARKET COMPOUND</h3>
        <p>
            The Municipal Mayor<br>
            Municipality of Naujan<br>
            Province of Oriental Mindoro
        </p>


    
            <br>
            <br>
            <p>
                I, <input type="text"  value="<?php echo $name; ?>"readonly>,
                hereby apply under the following contract for lease of stall and/or table space no <input type="text"
                value="<?php echo $stallNo; ?>" readonly>
                of the Naujan Public Market. I am <input type="text" value="<?php echo $age; ?>">
                years of age, a citizen of the Philippines and residing at <input type="text" value="<?php echo $address; ?>">
                Naujan Oriental Mindoro.
            </p>
            <br> <br>
            <ol>
                <li>That while I am occupying or having this stall/table space leased under my name, I shall at all times
                    have my picture conveniently framed and hung up conspicuously in the stall.</li>
                <li>I shall keep the stall/table at all times in good sanitary condition and comply strictly with all the
                    sanitary and market rules and regulations now existing or which may hereafter be promulgated.</li>
                <li>I shall pay the corresponding rental fee for the stall/table space in the manner prescribed by existing
                    ordinance as reflected in the Contract of Lease or those that may be promulgated from time to time by
                    the Municipality of Naujan thru the Sangguniang Bayan  <a href="contract.php">(Refer to Attached contract).</a> </li>
                <li>The business to be conducted in the stall/table space shall belong exclusively to me.</li>
                <li>In case I engage a helper, I shall nevertheless personally conduct my business and be present at the
                    stall.</li>
                <li>I shall not use pathways bordering my stall for purposes of displaying any merchandise.</li>
                <li>That I shall not use the stall/table space leased merely as bodegas or storage rooms.</li>
                <li>I shall not sell or transfer lease my privilege of the stall/table space, neither permit another person
                    to conduct business thereon.</li>
                <li>Any violation on my part of the foregoing conditions and those provided with the Contract of Lease
                    hereby attached shall be sufficient cause for the recession of the mentioned contract.</li>
                <li>That these conditions with the promises and/or conditions stated herein shall form an integral part of
                    the contract hereby attached.</li>
            </ol>

            <p>
                I <input type="text" value="<?php echo $name; ?>">
                hereby state that I am the person who signed the foregoing application, that I have read the same, and that
                the contents thereof are true to the best of my knowledge and belief.
            </p>

            <p>
                <input type="text" value="<?php echo $name; ?>">
                <br>
                APPLICANT
            </p>

            <p>
                SUBSCRIBED AND SWORN to before this
                day of <input type="text" value="<?php echo $sworndate ; ?>" >
                 in the Municipality of Naujan, Oriental Mindoro, application/affiant exhibiting to me his/her Community
                Tax Certificate No.
                issued at <input type="text" value="<?php echo $taxCertificateIssuedLocation ; ?>" readonly>
                NAUJAN, ORIENTAL MINDORO on
                <input type="text" value="<?php echo $tax_certificate_issued_date; ?>" placeholder="Y/M/D" readonly>

            </p>

            <p>
                <BR>
                <?php
                echo $row['content'];
                ?>
                <br>
                Municipal Mayor
            </p>
            <br>
        
            </div>
        
        

            <form action="" method="POST" style="display: inline-block; margin-left:45%;">
    <input type="hidden" name="appId" value="<?php echo $row['id']; ?>">
    <input type="hidden" name="action" value="convertToPdf">
    <button type="submit" name="convertToPdf" style="padding: 10px 20px; background-color: #4CAF50; color: white; border: none; cursor: pointer; font-size: 16px; border-radius: 4px;">
        Generate Copy
    </button>
</form>

    </body>

    </html>
