<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

// Path to the template file
$templateFilePath = '../vendor/template.html';

// Check if the template file exists
if (!file_exists($templateFilePath)) {
    die("Template file not found.");
}

// Load HTML content from the template file
$htmlContent = file_get_contents($templateFilePath);

$mail = new PHPMailer(true);

$vendorEmail = $_POST['email'];
// Print the received data
echo "Received Vendor Email: " . $vendorEmail;

try {
    // $mail->SMTPDebug = 2;
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'deeyelcart@gmail.com';
    $mail->Password   = 'defu uanr qoxf fqbu';
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    $mail->setFrom('deeyelcart@gmail.com', 'Deeyel Cart Services');
    $mail->addAddress($vendorEmail);
    // $mail->addReplyTo('gurusamyindirajith@gmail.com', 'Information');

    $mail->isHTML(true);
    $mail->Subject = 'Activate Your Deeyel Account';
    $mail->Body    = $htmlContent;

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
