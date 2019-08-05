#<?php

require("phpmailer/class.phpmailer.php");

$msg = 'This is an email from MGE shops.   

http://192.168.40.19/orgmve/testmail.php
xxx

';
$subj = 'test mail message';
$to = 'mail@bodony.com';
$from = 'janos@mgeshops.com';
$name = 'Jani';
 
if (smtpmailer($to, $from, $name, $subj, $msg)) {
	echo 'The message was sent sucessfully. However, a large 
number of electrons were severely inconvenienced in the process xx';
} else {
	if (!smtpmailer($to, $from, $name, $subj, $msg, false)) {
		if (!empty($error)) echo $error;
	} else {
		echo 'Yep, the message is send (after hard working)';
	}
}

function smtpmailer($to, $from, $from_name, $subject, $body, $is_gmail = true) { 
	global $error;
	$mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->SMTPAuth = true; 
	if ($is_gmail) {
		$mail->SMTPSecure = 'ssl'; 
		$mail->Host = 'smtp.gmail.com';
		$mail->Port = 465;  
		$mail->Username = 'janos@mgeshops.com';  
		$mail->Password = 'Jani1972';
                $mail->SMTPKeepAlive = true;  
                $mail->Mailer = "smtp"; 
                $mail->IsSMTP();  
                $mail->SMTPAuth   = true;     
                $mail->SMTPDebug  = 1;   
	} else {
		$mail->Host = SMTPSERVER;
		$mail->Username = SMTPUSER;  
		$mail->Password = SMTPPWD;
	}        
	$mail->SetFrom($from, $from_name);
	$mail->Subject = $subject;
	$mail->Body = $body;
	$mail->AddAddress('janos@mgeshops.com');
	$mail->AddAddress('info@aardvarkmastering.co.uk');
	$mail->AddAddress('tobiasjone@gmail.com');
	if(!$mail->Send()) {
		$error = 'Mail error: '.$mail->ErrorInfo;
		return false;
	} else {
		$error = 'Message sent!';
		return true;
	}
}



?>
