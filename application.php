<?php
session_start();
include "config/config.php";
?>
<!DOCTYPE html>
<html>

<head>
    <title>Lease Application Form</title>
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

        option {
            text-decoration: underline;
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
                margin: 20px !important;
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
        /* Styling for the modal container */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 50%;
            top: 50%;
            background-color: rgba(0,0,0,0.7);
            width: 200px;
            padding: 200px;
            text-align: center;
            border-radius: 5px;
        }

        /* Styling for the modal content */
        .modal-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        /* Close button styling */
        .close {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
        }
    </style>
</head>
<?php
include "header-home.php";
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

        <?php
        include "config/config.php";
        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\Exception;
        use PHPMailer\PHPMailer\SMTP;

        require __DIR__ . '/phpmailer/src/Exception.php';
        require __DIR__ . '/phpmailer/src/PHPMailer.php';
        require __DIR__ . '/phpmailer/src/SMTP.php';

        function isValidName($name_) {
            return preg_match("/^[A-Za-z\-\'\s]+$/", $name_);
        }
        function isValidAge($age_){
            if(!is_numeric($age_)){
                return false;
            }
            else if(intval($age_) < 18){
                return false;
            }
            return true;
        }
        function isValidEmail($email_){
            if(!filter_var($email_, FILTER_VALIDATE_EMAIL)){
                return false;
            }
            return true;
        }
        function existingCredentrials($checksql){
            include "config/config.php";
            $result = $conn->query($checksql);
            if($result->num_rows == 0){
                return false;
            }
            return true;
        }
        function validateEmail($insertedEmail, $target_name){
            $mail = new PHPMailer(true);
            $code = rand(100000,999999);
            $_SESSION['v_code'] = $code;

            try {
                // Server settings
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';          // Gmail SMTP server
                $mail->SMTPAuth = true;
                $mail->Username = 'publicmarketnaujan@gmail.com'; // Your Gmail email address
                $mail->Password = 'lwtywoqkuzatemxx';       // Your Gmail password
                $mail->SMTPSecure = "ssl"; // Enable SSL encryption
                $mail->Port = 465;                        // TCP port to connect to

                // Recipients
                $mail->setFrom('publicmarketnaujan@gmail.com', 'Naujan Public Market'); // Sender's email address and name
                $mail->addAddress($insertedEmail, $target_name); // Recipient's email address and name

                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Verification Code';
                $mail->Body = "This is your verification code: $code";

                $mail->send();
                return true;
            } catch (Exception $e) {
                echo " ";
                return false;
            }
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $stallNo = $_POST["stall_no"]; $_SESSION['stall'] = $stallNo;
            $name = $_POST["name"]; $_SESSION['_name'] = $name;
            $age = $_POST["age"]; $_SESSION['_age'] = $age;
            $address = $_POST["applicant_address"];$_SESSION['_address'] = $address;
            $applicantName = $_POST["applicant_name"]; $_SESSION['appName'] = $applicantName;
            $stallNo2 = $_POST["stall_no2"]; $_SESSION['stall2'] = $stallNo2;
            $applicantAge = $_POST["applicant_age"]; $_SESSION['appAge'] = $applicantAge;
            $applicantAddress = $_POST["applicant_address"]; $_SESSION['appAdd'] = $applicantAddress;
            $taxCertificateIssuedLocation = $_POST["tax_certificate_issued_location"]; $_SESSION['tcil'] = $taxCertificateIssuedLocation;
            $taxCertificateIssuedDate = $_POST["tax_certificate_issued_date"]; $_SESSION['tcid'] = $taxCertificateIssuedDate;
            $email = $_POST["email"]; $_SESSION['_email'] = $email;
            $Contact = $_POST["Contact"]; $_SESSION['_contact'] = $Contact;
            $status = "pending"; $_SESSION['Stats'] = $status;
            $my_sql = "SELECT * FROM applications WHERE email = '$email'";


            // Validate form inputs
            if (
                empty($stallNo) ||
                empty($name) ||
                empty($age) ||
                empty($applicantName) ||
                empty($stallNo2) ||
                empty($applicantAge) ||
                empty($applicantAddress) ||
                empty($taxCertificateIssuedLocation) ||
                empty($taxCertificateIssuedDate)
            ) {
                echo "<p class style='color:red'>Please fill in all the required fields.)</p>";
            } else if(!isValidName($name)){
                echo "<p class style='color:red'>Invalid name format.</p>";
            } else if(!isValidAge($age)){
                echo "<p class style='color:red'>Entered age is not valid for application.</p>";
            } else if(!isValidEmail($email)){
                echo "<p class style='color:red'>Invalid email address.</p>";
            } else if(existingCredentrials($my_sql)) {
                echo "<p class style='color:red'>It seems that you already file an application.</p>";
            } else if(!validateEmail($email, $name)){
                echo "<p class style='color:red'>Unable to send code. Please contact the administrator.</p>";
            } else {
                echo "<script>window.onload = function() { openModal(); }</script>";
            }
        }

        // Close database connection
        $conn->close();
        ?>

        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="dropdown">
    <label for="stall_no" #000>Stall/Table Space No:</label><br>
    <select class="form-select" style="max-width:200px;" id="stall_no" name="stall_no"  required>
        <option value="" selected disabled>Select Stall/Table Space No</option>
        <?php
        // Database connection
        include "config/config.php";

        // Query available stalls
        $availableQuery = "SELECT * FROM available_stall WHERE status = 'available' ORDER BY section, stall_no";
        $availableResult = mysqli_query($conn, $availableQuery);

        // Display available stalls as dropdown options
        while ($row = mysqli_fetch_assoc($availableResult)) {
            echo '<option value="' . $row['stall_no'] . '">Stall Number: ' . $row['stall_no'] . '</option>';
        }

        // Close database connection
        mysqli_close($conn);
        ?>
    </select>
</div>


<label for="name">Full Name:</label><br>
            <input type="text" id="name" name="name" onkeyup="checkNameValidity()" required> <span id="nameValidity"></span><br>

            <label for="age">Age:</label><br>
            <input type="text" id="age" name="age" onkeyup="validateAge()" required><span id="ageError" class="text-danger"></span><br>
            
            <label for="Contact">Contact:</label><br>
            <input type="number" id="Contact" name="Contact" oninput="validateContact()" required>
            <span id="contactError" style="color: red;"></span><br>
                    

            <label for="email">Email:</label><br>
            <input type="text" id="email" name="email" required><br>

            <br>
            <br>
            <br>
            <br>
            <p>
                I, <input type="text" name="applicant_name" required>,
                hereby apply under the following contract for lease of stall and/or table space no <input type="text"
                    name="stall_no2" required>
                of the Naujan Public Market. I am <input type="text" name="applicant_age" required>
                years of age, a citizen of the Philippines and residing at
                <select input type="text" name="applicant_address" style="border-bottom: 1px solid #000;" required>
                    <option value="">Select Location</option>
                    <option value="Poblacion I , Naujan">Poblacion I</option>
                    <option value="Poblacion II">Poblacion II</option>
                    <option value="Poblacion III">Poblacion III</option>
                    <option value="Adrialuna">Adrialuna</option>
                    <option value="Andres Ylagan">Andres Ylagan</option>
                    <option value="Antipolo">Antipolo</option>
                    <option value="Apitong">Apitong</option>
                    <option value="Arangin">Arangin</option>
                    <option value="Aurora">Aurora</option>
                    <option value="Bacungan">Bacungan</option>
                    <option value="Bagong Buhay">Bagong Buhay</option>
                    <option value="Balite">Balite</option>
                    <option value="Bancuro">Bancuro</option>
                    <option value="Banuton">Banuton</option>
                    <option value="Barcenaga">Barcenaga</option>
                    <option value="Bayani">Bayani</option>
                    <option value="Buhangin">Buhangin</option>
                    <option value="Caburo">Caburo</option>
                    <option value="Concepcion">Concepcion</option>
                    <option value="Dao">Dao</option>
                    <option value="Del Pilar">Del Pilar</option>
                    <option value="Estrella">Estrella</option>
                    <option value="Evangelista">Evangelista</option>
                    <option value="Gamao">Gamao</option>
                    <option value="General Esco">General Esco</option>
                    <option value="Herrera">Herrera</option>
                    <option value="Inarawan">Inarawan</option>
                    <option value="Kalinisan">Kalinisan</option>
                    <option value="Laguna">Laguna</option>
                    <option value="Mabini">Mabini</option>
                    <option value="Magtibay">Magtibay</option>
                    <option value="Mahabang Parang">Mahabang Parang</option>
                    <option value="Malaya">Malaya</option>
                    <option value="Malinao">Malinao</option>
                    <option value="Malvar">Malvar</option>
                    <option value="Masagana">Masagana</option>
                    <option value="Masaguing">Masaguing</option>
                    <option value="Melgar A">Melgar A</option>
                    <option value="Melgar B">Melgar B</option>
                    <option value="Metolza">Metolza</option>
                    <option value="Montelago">Montelago</option>
                    <option value="Montemayor">Montemayor</option>
                    <option value="Motoderazo">Motoderazo</option>
                    <option value="Mulawin">Mulawin</option>
                    <option value="Nag-Iba 1">Nag-Iba 1</option>
                    <option value="Nag-Iba 2">Nag-Iba 2</option>
                    <option value="Pagkakaisa">Pagkakaisa</option>
                    <option value="Paitan">Paitan</option>
                    <option value="Paniquian">Paniquian</option>
                    <option value="Pinagsabangan 1">Pinagsabangan 1</option>
                    <option value="Pinagsabangan 2">Pinagsabangan 2</option>
                    <option value="Piñahan">Piñahan</option>
                    <option value="Sampaguita">Sampaguita</option>
                    <option value="San Agustin 1">San Agustin 1</option>
                    <option value="San Agustin 2">San Agustin 2</option>
                    <option value="San Andres">San Andres</option>
                    <option value="San Antonio">San Antonio</option>
                    <option value="San Carlos">San Carlos</option>
                    <option value="San Isidro">San Isidro</option>
                    <option value="San Jose">San Jose</option>
                    <option value="San Luis">San Luis</option>
                    <option value="San Nicolas">San Nicolas</option>
                    <option value="San Pedro">San Pedro</option>
                    <option value="Santa Cruz">Santa Cruz</option>
                    <option value="Santa Isabel">Santa Isabel</option>
                    <option value="Santa Maria">Santa Maria</option>
                    <option value="Santiago">Santiago</option>
                    <option value="Sto. Niño">Sto. Niño</option>
                    <option value="Tagumpay">Tagumpay</option>
                    <option value="Tigkan">Tigkan</option>
                </select>
                ,Naujan Oriental Mindoro.
            </p>
            <br> <br>
            <ol>
                <li>That while I am occupying or having this stall/table space leased under my name, I shall at all
                    times
                    have my picture conveniently framed and hung up conspicuously in the stall.</li>
                <li>I shall keep the stall/table at all times in good sanitary condition and comply strictly with all
                    the
                    sanitary and market rules and regulations now existing or which may hereafter be promulgated.</li>
                <li>I shall pay the corresponding rental fee for the stall/table space in the manner prescribed by
                    existing
                    ordinance as reflected in the Contract of Lease or those that may be promulgated from time to time
                    by
                    the Municipality of Naujan thru the Sangguniang Bayan <a href="contract.php">(Refer to Attached
                        contract).</a> </li>
                <li>The business to be conducted in the stall/table space shall belong exclusively to me.</li>
                <li>In case I engage a helper, I shall nevertheless personally conduct my business and be present at the
                    stall.</li>
                <li>I shall not use pathways bordering my stall for purposes of displaying any merchandise.</li>
                <li>That I shall not use the stall/table space leased merely as bodegas or storage rooms.</li>
                <li>I shall not sell or transfer lease my privilege of the stall/table space, neither permit another
                    person
                    to conduct business thereon.</li>
                <li>Any violation on my part of the foregoing conditions and those provided with the Contract of Lease
                    hereby attached shall be sufficient cause for the recession of the mentioned contract.</li>
                <li>That these conditions with the promises and/or conditions stated herein shall form an integral part
                    of
                    the contract hereby attached.</li>
            </ol>

            <p>
                I <input type="text" name="applicant_name2">
                hereby state that I am the person who signed the foregoing application, that I have read the same, and
                that
                the contents thereof are true to the best of my knowledge and belief.
            </p>

            <p>
                <input type="text" name="applicant_signature">
                <br>
                APPLICANT
            </p>

            <p>
                SUBSCRIBED AND SWORN to before this
                day of <input type="text" name="sworn_date">
                2023 in the Municipality of Naujan, Oriental Mindoro, application/affiant exhibiting to me his/her
                Community
                Tax Certificate No.
                issued at <select input type="text" name="tax_certificate_issued_location" style="border-bottom: 1px solid #000;" required>
                    <option value="">Select Location</option>
                    <option value="Poblacion I">Poblacion I</option>
                    <option value="Poblacion II">Poblacion II</option>
                    <option value="Poblacion III">Poblacion III</option>
                    <option value="Adrialuna">Adrialuna</option>
                    <option value="Andres Ylagan">Andres Ylagan</option>
                    <option value="Antipolo">Antipolo</option>
                    <option value="Apitong">Apitong</option>
                    <option value="Arangin">Arangin</option>
                    <option value="Aurora">Aurora</option>
                    <option value="Bacungan">Bacungan</option>
                    <option value="Bagong Buhay">Bagong Buhay</option>
                    <option value="Balite">Balite</option>
                    <option value="Bancuro">Bancuro</option>
                    <option value="Banuton">Banuton</option>
                    <option value="Barcenaga">Barcenaga</option>
                    <option value="Bayani">Bayani</option>
                    <option value="Buhangin">Buhangin</option>
                    <option value="Caburo">Caburo</option>
                    <option value="Concepcion">Concepcion</option>
                    <option value="Dao">Dao</option>
                    <option value="Del Pilar">Del Pilar</option>
                    <option value="Estrella">Estrella</option>
                    <option value="Evangelista">Evangelista</option>
                    <option value="Gamao">Gamao</option>
                    <option value="General Esco">General Esco</option>
                    <option value="Herrera">Herrera</option>
                    <option value="Inarawan">Inarawan</option>
                    <option value="Kalinisan">Kalinisan</option>
                    <option value="Laguna">Laguna</option>
                    <option value="Mabini">Mabini</option>
                    <option value="Magtibay">Magtibay</option>
                    <option value="Mahabang Parang">Mahabang Parang</option>
                    <option value="Malaya">Malaya</option>
                    <option value="Malinao">Malinao</option>
                    <option value="Malvar">Malvar</option>
                    <option value="Masagana">Masagana</option>
                    <option value="Masaguing">Masaguing</option>
                    <option value="Melgar A">Melgar A</option>
                    <option value="Melgar B">Melgar B</option>
                    <option value="Metolza">Metolza</option>
                    <option value="Montelago">Montelago</option>
                    <option value="Montemayor">Montemayor</option>
                    <option value="Motoderazo">Motoderazo</option>
                    <option value="Mulawin">Mulawin</option>
                    <option value="Nag-Iba 1">Nag-Iba 1</option>
                    <option value="Nag-Iba 2">Nag-Iba 2</option>
                    <option value="Pagkakaisa">Pagkakaisa</option>
                    <option value="Paitan">Paitan</option>
                    <option value="Paniquian">Paniquian</option>
                    <option value="Pinagsabangan 1">Pinagsabangan 1</option>
                    <option value="Pinagsabangan 2">Pinagsabangan 2</option>
                    <option value="Piñahan">Piñahan</option>
                    <option value="Sampaguita">Sampaguita</option>
                    <option value="San Agustin 1">San Agustin 1</option>
                    <option value="San Agustin 2">San Agustin 2</option>
                    <option value="San Andres">San Andres</option>
                    <option value="San Antonio">San Antonio</option>
                    <option value="San Carlos">San Carlos</option>
                    <option value="San Isidro">San Isidro</option>
                    <option value="San Jose">San Jose</option>
                    <option value="San Luis">San Luis</option>
                    <option value="San Nicolas">San Nicolas</option>
                    <option value="San Pedro">San Pedro</option>
                    <option value="Santa Cruz">Santa Cruz</option>
                    <option value="Santa Isabel">Santa Isabel</option>
                    <option value="Santa Maria">Santa Maria</option>
                    <option value="Santiago">Santiago</option>
                    <option value="Sto. Niño">Sto. Niño</option>
                    <option value="Tagumpay">Tagumpay</option>
                    <option value="Tigkan">Tigkan</option>
                </select>
                NAUJAN, ORIENTAL MINDORO on
                <input type="date" name="tax_certificate_issued_date" placeholder="Y-M-D" required>
            </p>

            <p>
                <BR>
                <?php
                include "config/config.php";
                $sql = "SELECT * FROM resources Where id=1";
                $result = mysqli_query($conn, $sql);
                ($row = mysqli_fetch_assoc($result));
                echo $row['content'];
                ?>
                <br>
                Municipal Mayor
            </p>
            <br>
            <div class="checkbox-container">
                <label>
                    <input type="checkbox" name="agree_terms" required>
                    I agree to the terms and conditions
                </label>
            </div>
            <input type="submit" value="Submit Application" style=" display: block;margin: auto;">
        </form>
    </div>

    <!--Email Confirmation Modal--->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <form action="app_verification.php" method = "POST">
                <h2>Email Confirmation</h2>
                <p>Please check your email and enter the verification code below: </p>
                <input type="input" name="inputCode" placeholder="Code">
                <input type="submit">
            </form>
        </div>
    </div>

    <script>
        // Function to open the modal
        function openModal() {
            var modal = document.getElementById("myModal");
            modal.style.display = "block";
            setTimeout(function() {
                // Open Gmail in a new window
                window.open('https://mail.google.com/', '_blank');
            }, 3000);
        }

        // Function to close the modal
        function closeModal() {
            var modal = document.getElementById("myModal");
            modal.style.display = "none";
        }

        function handleError(err) {
            err_msg.style.display = "block";

            // Create a new AJAX request
            var xhr = new XMLHttpRequest();
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

            // Define a callback function to handle the server's response
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Handle the server's response
                    var response = xhr.responseText;
                }
            };

            // Send the data to the server
            xhr.open("POST", "error_handler.php", true);
            xhr.send("data=" + err);
        }
        function checkNameValidity() {
            var name = document.getElementById("name").value;
            var nameMessage = document.getElementById("nameValidity");

            // Reset the message
            nameMessage.innerHTML = '';

            // Define the regular expression for name validation
            var nameRegex = /^[A-Za-z\-\'\s]+$/;

            // Check the condition and update the message
            if (!name.match(nameRegex)) {
                nameMessage.innerHTML = 'Invalid name format. Please use letters, hyphens, apostrophes, and spaces only.';
                nameMessage.style.color = 'red';
            }
        }
        function validateAge() {
        var age = document.getElementById('age').value;

        if (isNaN(age) || age < 18 ) {
            document.getElementById('ageError').innerHTML = 'Age must be  18 Above.';
            return false;
        }
        if (age > 100){
            document.getElementById('ageError').innerHTML = 'Invalid Age';
            return false;
        }

        // Clear any previous error message
        document.getElementById('ageError').innerHTML = '';

        return true;
    }
    
    function validateContact() {
        var contact = document.getElementById("Contact").value;
        var contactError = document.getElementById("contactError");

        // Check if contact length is 11 or 12
        if (contact.length !== 11 && contact.length !== 12) {
            contactError.innerHTML = 'Contact must be 11 or 12 digits.';
        } else {
            contactError.innerHTML = '';
        }
    }

        


</script>


</body>

</html>
