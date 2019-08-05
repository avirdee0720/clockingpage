<?php


//include_once("./header.php");

$to=$_GET['to']; 
   
//$to      = 'jbodony@hotmail.com';
$subject = 'the subject';
$message = 'hello';
$headers = 'From: janos@mveshops.co.uk' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

if (mail($to, $subject, $message, $headers)==1)
 { echo "The mail has been sent.";}
 else 
 echo "There is problem with the mail sending ";  
 

//include_once("./footer.php");
?>