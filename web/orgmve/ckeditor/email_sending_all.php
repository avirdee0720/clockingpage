<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$tytul='Email sending to employees<br><br>';


if(!isset($state))
{

echo "	<TD ALIGN=JUSTIFY VALIGN=TOP border=0>
	<table width='100%' border=0><tr><td>

<center>
<!-- BEGIN Record members -->
<form action='$PHP_SELF' method='post' name='ed_czl'>
  <font class='FormHeaderFont'>$tytul</font>
  <table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
";


 
  echo "
  
    <tr>
      <td class='FieldCaptionTD'>Subject</td>
      <td class='DataTD'><input class='Input' maxlength='60' name='_subject' size='30'></td>
    </tr>
     <tr>
      <td class='FieldCaptionTD'>Text</td>
      <td class='DataTD'><textarea name=\"_text\" cols=\"80\" rows=\"20\"></textarea></td>
    </tr>
      <tr>
      <td class='FieldCaptionTD'>Attachment</td>
      <td class='DataTD'><input type=\"file\" name=\"attachment\" id=\"fileField\"/></td>
    </tr>
    <tr>
      <td align='right' colspan='2'>
		
		<input name='state' type='hidden' value='1'>
    
    <script type=\"text/javascript\" src=\"ckeditor/ckeditor.js\"></script>
	<script src=\"sample.js\" type=\"text/javascript\"></script>
	<link href=\"sample.css\" rel=\"stylesheet\" type=\"text/css\" />

   <h1>
		CKEditor Sample
	</h1>
	<!-- This <div> holds alert messages to be display in the sample page. -->
	<div id=\"alerts\">
		<noscript>
			<p>
				<strong>CKEditor requires JavaScript to run</strong>. In a browser with no JavaScript
				support, like yours, you should still see the contents (HTML data) and you should
				be able to edit it normally, without a rich editor interface.
			</p>
		</noscript>
	</div>
	<form action=\"sample_posteddata.php\" method=\"post\">

		<p>
			<label for=\"editor1\">
				Editor 1:</label><br />
			<textarea class=\"ckeditor\" cols=\"80\" id=\"editor1\" name=\"editor1\" rows=\"10\">&lt;p&gt;This is some &lt;strong&gt;sample text&lt;/strong&gt;. You are using &lt;a href=\"http://ckeditor.com/\"&gt;CKEditor&lt;/a&gt;.&lt;/p&gt;</textarea>
		</p>
		<p>
			<input type=\"submit\" value=\"Submit\" />
		</p>

	</form>
 
    
    
    ";
			
 
echo "
			<input class='Button' name='Update' type='submit' value='$SAVEBTN'>
	
	</td>
    </tr>
  </table>
</form>
</center>
<BR>
</td></tr>
</table>";
include_once("./footer.php");
}
elseif($state==1)
{
  
  $attachment=$_POST['attachment'];

   checkzm("_subject");
  checkzm("_text");

  if (!$db->Open()) $db->Kill();

  $q = "SELECT `nombers`.`pno`, `nombers`.`surname`, `nombers`.`firstname`, `nombers`.`knownas`, `nombers`.`cat`, `nombers`.`cattoname`,DATE_FORMAT(`nombers`.`started`, \"%d/%m/%Y\") as d1, `nombers`.`daylyrate`, `nombers`.`regdays`, `nombers`.`displ`, `staffdetails`.`homephone` , `staffdetails`.`mobilephone` ,`staffdetails`.`email` As email1 FROM `nombers` LEFT JOIN  `staffdetails` ON `nombers`.`pno` = `staffdetails`.`no` WHERE `nombers`.`status`='OK' AND
   `nombers`.`pno` = '1879' LIMIT 1";
 
  if (!$db->Query($q)) $db->Kill();
    echo "Mail to all employees<br><br>";
    while ($row=$db->Row())
    {
   $email1=$row->email1;
   if ($email1!= "") {
  if (_mail_send ($email1, $_subject,$_text,$attachment)) {echo "The mail to $email1 has been sent.<br>"; }
   else    {echo "Error: Mail to $email1 has not been sent.<br>"; }                
                      }
                        }
//if(isset($Insert) and $Insert=='$NEWBTN')
// { echo "<script language='javascript'>window.location=\"n_os.php\"</script>";   }

} //fi state=1
else
{
 echo "<BR><BR><BR>Ostrze¿enie!!!!!<BR><BR><BR>",
	 "Ktos z komputera $REMOTE_ADDR probuje sie wlamac<BR>";
} //else state


function _mail_send ($who, $subject, $body, $attachment) {

$value = false;
 
require("phpmailer/class.phpmailer.php");
$mail = new PHPMailer();
$mail->IsSMTP(); // send via SMTP
//IsSMTP(); // send via SMTP

$mail->SMTPAuth = true; // turn on SMTP authentication
$mail->Username = "applicationform@mgeshops.com"; // SMTP username
$mail->Password = "2010abcde"; // SMTP password
$from = "applicationform@mgeshops.com"; //Reply to this email ID
// $email="mail@bodony.com"; // Recipients email ID
$name=""; // Recipient's name
$mail->From = $from;
$mail->FromName = "MGE Office";
$mail->AddAddress($who,$name);
$mail->AddAddress("jbodony@freemail.hu","Jani2");
$mail->AddAddress("mail@bodony.com","Jani");
$mail->AddReplyTo($from,"MGE Office");
$mail->WordWrap = 50; // set word wrap
$mail->AddAttachment($attachment); // attachment
//$mail->AddAttachment("/tmp/image.jpg", "new.jpg"); // attachment
$mail->IsHTML(true); // send as HTML
$mail->Subject = $subject;
$mail->Body = $body; //HTML Body
$mail->AltBody = $body; //Text Body
if(!$mail->Send())
{
echo "Mailer Error: " . $mail->ErrorInfo;
}
else
{
$value = true;
}

 
return $value; 
 
 }          
 
?>