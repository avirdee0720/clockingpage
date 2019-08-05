<?php
include("./config.php");
include_once("./header.php");
require("phpmailer/class.phpmailer.php");

$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$db2 = new CMySQL;
if (!$db->Open()) $db->Kill();
if (!$db2->Open()) $db2->Kill();

$tytul='Email sending to employees<br><br>';


if(!isset($state))
{

$bodytext='';
$subjecttext='';

if (!isset($_GET['eid']))
    $emailid = "";
else $emailid=$_GET['eid'];

if  ($emailid == "") $q = "SELECT * FROM `emails`  Order by datetime1 DESC, cur_timestamp DESC Limit 1";
else $q = "SELECT * FROM `emails`  Where emailid = '$emailid'";

  if ($db->Query($q)) 
  {
    while ($r=$db->Row())
    {
	   $subjecttext .= $r->subject;
          $bodytext .= $r->body;
          $group = $r->group;
    }
}

          
          
 $emaillisthtml = "<table border=0>";
 $emaillisthtml .= "<tr><td class='FieldCaptionTD'><b>Group</b></td><td class='FieldCaptionTD'><b>Time</b></td><td class='FieldCaptionTD'><b>Subject</b></td></tr>";
 
 $q = "SELECT *,DATE_FORMAT(`emails`.`datetime1`, \"%d/%m/%Y\") as dtx1 FROM `emails`  Order by datetime1 DESC, cur_timestamp DESC";


  if ($db->Query($q)) 
  {
    while ($r=$db->Row())
    {
	   
    if ('%' == $r->group ) {
          $grouptxt = "All Employees";
          }
          
     if ('point' == $r->group ) {
          $grouptxt = "Buyers - Point";
          }
       
	             
      $q = "SELECT `catozn`, `catname` FROM `emplcat`";
      
  if ($db2->Query($q)) 
  {
    while ($r2=$db2->Row())
    {
         if ($r2->catozn == $r->group ) {
          $grouptxt = $r2->catname;
          }
       }
	} else {
echo " 
  <tr>
    <td class='DataTD'></td>
    <td class='DataTD' colspan='3'>SQL Error 1a</td>
  </tr>";
 $db->Kill();
}
    
   
          
       $emaillisthtml .= "<tr><td class='DataTD'><a href='$PHP_SELF?eid=$r->emailid'>$grouptxt</a></td><td class='DataTD'>$r->dtx1</td><td class='DataTD'>$r->subject</td></tr>";    
    }
}
$emaillisthtml .= "</table>";

echo "	<TD ALIGN=JUSTIFY VALIGN=TOP border=0>
    <script type=\"text/javascript\" src=\"ckeditor/ckeditor.js\"></script>
	<script src=\"ckeditor/_samples/sample.js\" type=\"text/javascript\"></script>
	<link href=\"ckeditor/_samples/sample.css\" rel=\"stylesheet\" type=\"text/css\" />
	<table width='100%' border=0><tr><td>

<center>
<!-- BEGIN Record members -->
<form action='$PHP_SELF' method='post' name='ed_czl'>
  <font class='FormHeaderFont'>$tytul</font>
  <table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
";

echo "<tr>
<td class='FieldCaptionTD'>Who</td>
<td class='DataTD'>   <select class='Select' name='_grp'>
		<option value='%'>All Employees</option>/n";
		
		if ('%' == $group ) {
          echo "<option value='%' selected>All Employees</option>/n";}
         else {echo "<option value='%'>All Employees</option>/n";
          }
	    
      if ('point' == $group ) {
          echo "<option value='point' selected>Buyers - Point</option>/n";}
         else {echo "<option value='point'>Buyers - Point</option>/n";
          }
          
      $q = "SELECT `catozn`, `catname` FROM `emplcat`";
      
  if ($db->Query($q)) 
  {
    while ($r=$db->Row())
    {
         if ($r->catozn == $group ) {
          echo "<option value='$r->catozn' selected>$r->catname</option>/n";
          }
         else {echo "<option value='$r->catozn'>$r->catname</option>/n";} 
    }
	} else {
echo " 
  <tr>
    <td class='DataTD'></td>
    <td class='DataTD' colspan='3'>SQL Error 1a</td>
  </tr>";
 $db->Kill();
}
echo " </select>
     </td>
    </tr>
    <tr>
      <td class='FieldCaptionTD'>Subject</td>
      <td class='DataTD'><input class='Input' maxlength='60' name='_subject' size='30' value=".$subjecttext."></td>
    </tr>
     <tr>
      <td class='FieldCaptionTD'>Text</td>
      <td class='DataTD'>	<p>
			<textarea cols=\"80\" id=\"editor1\" name=\"_text\" rows=\"10\">".$bodytext."</textarea>
			<script type=\"text/javascript\">
			//<![CDATA[

				// This call can be placed at any point after the
				// <textarea>, or inside a <head><script> in a
				// window.onload event handler.

				// Replace the <textarea id=\"editor\"> with an CKEditor
				// instance, using default configurations.
				CKEDITOR.replace( 'editor1' );
            
			//]]>
			</script>
	</td>
    </tr>
     
    <tr>
      <td align='right' colspan='2'>
		
		<input name='state' type='hidden' value='1'>
      
    ";
/*
 <tr>
      <td class='FieldCaptionTD'>Attachment</td>
      <td class='DataTD'><input type=\"file\" name=\"attachment\" id=\"fileField\"/></td>
    </tr>

*/			
 
echo "
			<input class='Button' name='Update' type='submit' value='Send'>
	
	</td>
    </tr>
  </table>
  <br><b>Last emails</b><br><br>
  $emaillisthtml
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
  $DepGroup = $_POST['_grp'];
   checkzm("_subject");
  checkzm("_text");


$q = "INSERT INTO `emails` ( `emailid` , `group` , `subject` , `body` , `datetime1` , `state` , `cur_timestamp` )
VALUES (
NULL , '$DepGroup', '$_subject', '$_text', NOW(), '1', NOW()
);";

  if (!$db->Query($q)) $db->Kill();




  if (!$db->Open()) $db->Kill();

  if ($DepGroup != 'point') { 
  $q = "SELECT `staffdetails`.`email` AS email1
FROM `nombers`
LEFT JOIN `staffdetails` ON `nombers`.`pno` = `staffdetails`.`no`
WHERE `nombers`.`status` = 'OK'
AND  `nombers`.`cat` LIKE '$DepGroup'
AND `staffdetails`.`email` <> '';
";
}

 else  {
 
 $q= "
SELECT `staffdetails`.`email` AS email1
FROM `nombers`
LEFT JOIN `staffdetails` ON `nombers`.`pno` = `staffdetails`.`no`
WHERE `nombers`.`status`='OK'  AND `nombers`.`pno` <> '5' AND (LOCATE('.',`cattoname`)<>0 OR cat='c');
";

 
 }


//  AND nombers.pno = '1879'



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
 echo "<BR><BR><BR>Ostrze�enie!!!!!<BR><BR><BR>",
	 "Ktos z komputera $REMOTE_ADDR probuje sie wlamac<BR>";
} //else state


function _mail_send ($who, $subject, $body, $attachment) {

$value = false;

$mail = new PHPMailer();
$mail->IsSMTP(); // send via SMTP
//IsSMTP(); // send via SMTP
 
$mail->SMTPAuth = true; // turn on SMTP authentication
$mail->Username = "office@mgeshops.com"; // SMTP username
$mail->Password = "28w113hl"; // SMTP password
$from = "office@mgeshops.com"; //Reply to this email ID
// $email="mail@bodony.com"; // Recipients email ID
$name=""; // Recipient's name
$mail->From = $from;
$mail->FromName = "MGE Office";
$mail->AddAddress($who,$name);
//$mail->AddBcc('mail@bodony.com','Janos');
$mail->AddReplyTo($from,"MGE Office");
$mail->WordWrap = 50; // set word wrap
//$mail->AddAttachment($attachment); // attachment
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
unset($mail);  
 
return $value; 
 
 }          
 
?>