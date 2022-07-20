<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require("Exception.php");
require("PHPMailer.php");
require("SMTP.php");

$mail = new PHPMailer();
$mail->IsSMTP();
$mail->Mailer = "smtp";
$mail->Host = "mail.smtp2go.com";
$mail->Port = "2525"; // 8025, 587 and 25 can also be used. Use Port 465 for SSL.
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'tls';
$mail->Username = "kokujp0505@gmail.com";
$mail->Password = "Quoc737602";

$mail->From = "kokujp0505@gmail.com";
$mail->FromName = "Susan Sender";
$mail->AddAddress("kokujp0505@gmail.com", "Rachel Recipient");
$mail->AddReplyTo("Your Reply-to Address", "Sender's Name");

$mail->Subject = "Hi!";
$mail->Body = "Hi! How are you?";
$mail->WordWrap = 50;

if(!$mail->Send()) {
echo 'Message was not sent.';
echo 'Mailer error: ' . $mail->ErrorInfo;
exit;
} else {
echo 'Message has been sent.';
}
?>