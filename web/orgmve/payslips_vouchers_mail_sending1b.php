<HTML>
<HEAD>
<?php
include("./config.php");

include_once("./header.php");
require('./tcpdf/tcpdf.php');
require("phpmailer/class.phpmailer.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$db1 = new CMySQL;
$db2 = new CMySQL;

if (!$db->Open()) $db->Kill();
if (!$db1->Open()) $db1->Kill();
if (!$db2->Open()) $db1->Kill();

uprstr($PU,90);
$dataakt=date("d/m/Y H:i:s");
$dataakt=date("d/m/Y");
$msgdb = new CMySQL;

//list($day, $month, $year) = explode("/",$_GET['startd']);

$output = "";
$mail_sent = false;

$date1 = date("Ymd");

$pvno=$_GET['pvno'];
$cid=$_GET['cid'];

?>
<meta HTTP-EQUIV='cache-control' CONTENT='no-cache, must-revalidate'>
<link rel=stylesheet type=text/css href="hs.css">
<LINK REL='stylesheet' HREF='style/multipads/style.css' TYPE='text/css'>

</HEAD>

<body class=PageBODY bgcolor=#FFFFFF topmargin=0 leftmargin=0 marginwidth=0 marginheight=0 text=#000000 link=#0000FF vlink=#0000FF alink=#FF0000>
<CENTER>

<?php


$title="Payslips - Vouchers";

echo "<br><b>Welcome to Payslips mail sender page!</b><br><br>";

  $q= "SELECT pvfolder FROM `payslips_vouchers_no` WHERE `pvno`='$pvno' Limit 1";
     if (!$db2->Query($q)) $db2->Kill();  
     $row2=$db2->Row();
     
     $pvfolder=$row2->pvfolder;

$q = "SELECT payslips_vouchers_no.pvno, payslips_vouchers_no.date1,payslips_vouchers_no.pvfolder,
payslips_vouchers.id, payslips_vouchers.no,nombers.knownas,payslips_vouchers.payslipsno,payslips_vouchers.vouchersno,payslips_vouchers.text,payslips_vouchers.payslips_filename,payslips_vouchers.vouchers_filename, 
payslips_vouchers.payslips_file,payslips_vouchers.vouchers_file,payslips_vouchers.vouchers_state,email,`nombers`.cat
FROM  payslips_vouchers_no INNER JOIN payslips_vouchers ON payslips_vouchers_no.pvno=payslips_vouchers.pvno
INNER JOIN `staffdetails` ON `staffdetails`.no=payslips_vouchers.no
INNER JOIN `nombers` ON `staffdetails`.no=nombers.pno
Where payslips_vouchers_no.pvno='$pvno'
and (nombers.pno<>2037)
and (nombers.pno<>570)
and (nombers.pno>=2384)
";

// and (nombers.pno<=2000);
//  and (nombers.pno='1879') 2414
//  and (nombers.pno<2055)
// and (nombers.pno in (2373,2374)

if ($db->Query($q)) 
  {
  

// Folders
  
    while ($row=$db->Row())
    {
    $no=$row->no;
    $knownas=$row->knownas;
    $id=$row->id;
    $payslipsno=$row->payslipsno;
    $vouchersno=$row->vouchersno;
    $payslips_filename=$row->payslips_filename;
    $vouchers_filename=$row->vouchers_filename;
    $vouchers_state=$row->vouchers_state;
    $_text=$row->text;
    $payslipsattachment =  $row->payslips_file;
    $vouchersattachment =  $row->vouchers_file;
    $cat =  $row->cat;

    //$_text = 'Please find attached your payslip for November 2011.';
    
    $email=$row->email;

       $myFile_payslips = $payslips_filename;
       $myFile_vouchers = $vouchers_filename;
   
   if ($vouchers_state != "2" && $vouchers_state != "3") {
     $myFile_vouchers = 'NONE';
     }
     
  $mail_sent = false;
  $_text = $db->Fix($_text); 
    // mail sending 
  if ($email!="") {
  
  $mit = array("\\");
  $mire = array('');

  $_text2 = str_replace($mit, $mire,   $_text);

  $mail_sent=_mail_send ($email,"Wages - May 2012 /$no/", $_text2,$pvfolder,$payslipsattachment,$myFile_payslips,$vouchersattachment,$myFile_vouchers);
  
  echo "MAIL ".$mail_sent." - ".$no." - ".$knownas." <br>";
  }
  
  if ($mail_sent) {
  
        if ($vouchers_state == '2') {
               $upd = "UPDATE `payslips_vouchers` SET payslips_state='3',vouchers_state='3',text='$_text' WHERE `id`='$id' Limit 1";
              if (!$db2->Query($upd)) $db2->Kill();
        }
        else {
         $upd = "UPDATE `payslips_vouchers` SET payslips_state='3',text='$_text' WHERE `id`='$id' Limit 1";
              if (!$db2->Query($upd)) $db2->Kill();
        }
  
  }
  else  {
  
   
  $mit = array("\\");
  $mire = array('');

  $_text2 = str_replace($mit, $mire,   $_text);

  
  
  $mail_sent=_mail_send ('payroll@mgeshops.com',"Wages - Unsent - May 2012  /$no/", $_text2,$pvfolder,$payslipsattachment,$myFile_payslips,$voucherssattachment,$myFile_vouchers);
        
  }
      
  }  
       

   }
   
echo "
</table>
</center>
<BR>

</td></tr>
</table>";
include_once("./footer.php");

function _mail_send ($who,$subject, $body,$pvfolder, $payslipsattachment,$payslips_filename,$voucherattachment ,$vouchers_filename) {

$value = false;
$mail = new PHPMailer();
$mail->IsSMTP(); // send via SMTP
//IsSMTP(); // send via SMTP

$mail->SMTPAuth = true; // turn on SMTP authentication
//$mail->Username = "applicationform@mgeshops.com"; // SMTP username
//$mail->Password = "2010abcde"; // SMTP password
//$mail->Username = "janos@mgeshops.com"; // SMTP username
//$mail->Password = "Jani1972"; // SMTP password
$mail->Username = "payroll@mgeshops.com"; // SMTP username
$mail->Password = "r3tr0payr0ll"; // SMTP password
$from = "payroll@mgeshops.com"; //Reply to this email ID
// $email="mail@bodony.com"; // Recipients email ID
$name=""; // Recipient's name
$mail->From = $from;
$mail->FromName = "MGE Payroll";
$mail->AddAddress($who,"");
//$mail->AddAddress("janos@mgeshops.com","Janos");
$mail->AddAddress("anna@mgeshops.com","Anna");
//$mail->AddAddress("duarte@mgeshops.com","Duarte");
//$mail->AddAddress("ruthwolf66@hotmail.com","Ruth Abrams");

$mail->AddReplyTo($from,"MGE Payroll");
$mail->WordWrap = 50; // set word wrap
//$mail->AddAttachment($attachment); // attachment
//$mail->AddAttachment("/home2/www/html/orgmve/$pvfolder/$attachment", "$attachment"); // attachment
$mail->AddStringAttachment($payslipsattachment,$payslips_filename);
if ($vouchers_filename != 'NONE') {
$mail->AddStringAttachment($voucherattachment,$vouchers_filename);
// $mail->AddAttachment("/home2/www/html/orgmve/$pvfolder/$voucherattachment", "$voucherattachment");
}
$mail->IsHTML(true); // send as HTML
$mail->Subject = $subject;
$mail->Body = $body; //HTML Body
$mail->AltBody = $body; //Text Body


if(!$mail->Send())
{
echo "Mailer Error: " . $mail->ErrorInfo . "<br>";
}
else
{
echo "Message has been sent.<br>";
$value = true;
}


unset($mail);
//$value = true;
 
return $value; 
}

function  _mail_send2x ($who,$subject, $body,$pvfolder, $payslipsattachment,$payslips_filename,$voucherattachment ,$vouchers_filename){

    $from = "janos@mgeshops.com"; //Reply to this email ID
    $from_name = "Janos"; //Reply to this email ID
    $to="janos@mgeshops.com";
   $body = "SSS";
$subject = "DDD";

	global $error;
	$mail = new PHPMailer();  // create a new object
	$mail->IsSMTP(); // enable SMTP
	$mail->SMTPDebug = 1;  // debugging: 1 = errors and messages, 2 = messages only
	$mail->SMTPAuth = true;  // authentication enabled
	$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
	$mail->Host = 'smtp.gmail.com';
	$mail->Port = 465; 
	$mail->Username = "janos@mgeshops.com";  
	$mail->Password = "jani1972";           
	$mail->SetFrom($from, $from_name);
	$mail->Subject = $subject;
	$mail->Body = $body;
	$mail->AddAddress("janos@mgeshops.com");
	if(!$mail->Send()) {
		$error = 'Mail error: '.$mail->ErrorInfo; 
		return false;
	} else {
		$error = 'Message sent!';
		return true;
	}
}

 
 ?>