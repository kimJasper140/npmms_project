<?php
$to = "recipient@gmail.com";
$subject = "Email Validation";
$validationCode = generateValidationCode();
$message = "Please click the link below to validate your email address:\n\n";
$message .= "Validation Link: http://example.com/validate.php?code=$validationCode";
$headers = "From: your_email@example.com" . "\r\n";
$headers .= "Reply-To: your_email@example.com" . "\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8" . "\r\n";
if (mail($to, $subject, $message, $headers)) {
    echo "Email sent successfully.";
} else {
    echo "Email sending failed.";
}

function generateValidationCode() {
    return rand(100000, 999999);
}
?>
