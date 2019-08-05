<?php
echo "sss";

require("phpmailer/class.phpmailer.php");
$mail = new PHPMailer();
echo "sdd";
$mail->IsSMTP(); // send via SMTP
echo "BB";
//IsSMTP(); // send via SMTP
echo "AA <br>";
$mail->SMTPAuth = true; // turn on SMTP authentication
$mail->Username = "janos@mgeshops.com"; // SMTP username
$mail->Password = "jani1972"; // SMTP password
$from = "janos@mgeshops.com"; //Reply to this email ID
$email="mail@bodony.com"; // Recipients email ID
$name="Janos Bodony"; // Recipient's name
$mail->From = $from;
$mail->FromName = "MGE Office";
$mail->AddAddress($email,$name);
$mail->AddAddress("jbodony@freemail.hu","Jani2");
$mail->AddAddress("mail@bodony.com","Jani");
$mail->AddReplyTo($from,"MGE Office");
$mail->WordWrap = 50; // set word wrap
//$mail->AddAttachment("/var/tmp/file.tar.gz"); // attachment
//$mail->AddAttachment("/tmp/image.jpg", "new.jpg"); // attachment
$mail->IsHTML(true); // send as HTML
$mail->Subject = "This is the subject";
$mail->Body = "Hi,
This is the HTML BODY - Ah, yes4 "; //HTML Body
$mail->AltBody = "This is the body when user views in plain text format"; //Text Body
if(!$mail->Send())
{
echo "Mailer Error: " . $mail->ErrorInfo;
}
else
{
echo "Message has been sent";
}


?>
