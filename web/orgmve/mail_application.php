<?php

ini_set("include_path", ".:./inc/:./languages/:/usr/share/php/DB:/usr/share/php/PEAR:/usr/share/php/Smarty");
include("./inc/mysql.inc.php");
include("./inc/person.inc.php");
include("./inc/uprawnienia.php");
include("./inc/orgfunc.inc.php");

//include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
if (!$db->Open()) $db->Kill();


$q ="SELECT  WEEKDAY(curdate()) As wd, DAYOFMONTH(curdate())>24 as endmonth";

if (!$db->Query($q)) $db->Kill();
$row=$db->Row();

if ($row->wd=="3" || $row->endmonth=="1") {



$q ="SELECT nombers.pno, app_state, title, code, firstname, surname, knownas, email, DATE_FORMAT( `dateofbirth` ,\"%d/%m/%Y\" ) AS dateofbirth, nationality, ninumber, homephone, mobilephone, address1, address2, address3, postcode, em_name, em_tel, em_mobile, em_address1, em_address2, em_address3, em_postcode, bankid, bank, bankaccname, sortc, acno, criminal_convictions, presentcircumtances1, presentcircumtances2, `education1_date_from` , `education1_date_to` , education1_name_address, education1_subject, `education2_date_from` , `education2_date_to` , education2_name_address, education2_subject, otherqualifications, `employment1_date_from` , `employment1_date_to` , employment1_name_address, employment1_jobtitle, employment1_reason_for_leaving, employment1_reason_for_leaving_other, `employment2_date_from` , `employment2_date_to` , employment2_name_address, employment2_jobtitle, employment2_reason_for_leaving, employment2_reason_for_leaving_other, `employment3_date_from` , `employment3_date_to` , employment3_name_address, employment3_jobtitle, employment3_reason_for_leaving, employment3_reason_for_leaving_other, `gaps1_date_from` , `gaps1_date_to` , gaps1_doing, `gaps2_date_from` , `gaps2_date_to` , gaps2_doing, re1_name, re1_email, re1_occupation, re1_tel, re1_mobile, re1_address1, re1_address2, re1_address3, re1_postcode, re1_relationship, re2_name, re2_email, re2_occupation, re2_tel, re2_mobile, re2_address1, re2_address2, re2_address3, re2_postcode, re2_relationship,declaration,`mandatory_mail_sent` , mandatory_mail_sent < DATE_SUB( curdate() , INTERVAL 2
DAY ) As oldmail
FROM nombers
LEFT JOIN staffdetails ON nombers.pno = staffdetails.no
LEFT JOIN bankdetails ON nombers.pno = bankdetails.no
WHERE (app_state ='0' Or app_state ='2')
AND email<>\"\"
AND  mandatory_mail_sent < DATE_SUB( curdate() , INTERVAL 2
DAY )
Limit 1; ";

if (!$db->Query($q)) $db->Kill();

 while ($row=$db->Row())
    {
 
 // mandatory check
echo  $row->pno."<br>A ";
$c=0;   
 if ($row->dateofbirth == "") {$c++; $output .= "Date of birth field is missing.";  }
 if ($row->nationality == "") {$c++; $output .= "The nationality field is missing.<br>\n";  }
 if ($row->ninumber == "") { $c++;$output .= "The N.I. number field is missing.<br>\n";  }
 if ($row->mobilephone == "") {$c++; $output .= "The mobile number field is missing.<br>\n";  }
 if ($row->address1 == "" || $row->postcode == "") { $c++;$output .= "The address fields are  missing.<br>\n";  }
 
 if ($row->bank == "" && $row->bankid=="9999") { $c++;$output .= "The bank field is missing.<br>\n";  }
 if ($row->bankaccname == "") { $c++;$output .= "The name of account holder field is missing.<br>\n";  }
 if ($row->sortc == "") { $c++;$output .= "The sort code field is missing.<br>\n";  }
 if ($row->acno == "") { $c++;$output .= "The account number  field is missing.<br>\n";  }

 if ($row->presentcircumtances1 == "") { $c++;$output .= "The Present circumtances (first job) field is missing.<br>\n";  }
 
   
   
if ($c > 0) {

if ($c==1) $t0= "There is a missing mandatory field in your application form.<br>";
else $t0 =  "There are some missing mandatory fields in your application form.<br>";
$knownas =$row->knownas;
$code = $row->code;
$no =$row->pno; 
$email = $row->email;

$output =  "

Dear  $knownas,<br>\n<br>\n

$t0 <br>

The Link of editable form: 

<a href=\"http://www.mveshops.co.uk/?q=mve_application/form/$no\">http://www.mveshops.co.uk/?q=mve_application/form/$no</a><br>\n<br>\n<br>\n

Code = $code<br> <br> <br>
".$output;
}  

 
 // if yes, mail send  

 $t= _mail_send ($email, $output);


if ($t) {echo "The mail has been sent to $knownas ($no). <br>\n"; 

// update
$date1  = date("Y-m-d");
$query = ("UPDATE `staffdetails` SET mandatory_mail_sent='$date1' Where no='$pno' Limit 1") ; 
 //  $result = mysql_query($query);

}
else   echo "Error:  The mail has not been sent to $knownas ($no).  <bry\n";
    
    }
    


}
else echo " Today is not Monday and day of month is less then 25.";


function _mail_send ($who, $body) {

$value = false;
 
require("phpmailer/class.phpmailer.php");

$mail = new PHPMailer();
$mail->IsSMTP(); // send via SMTP
//IsSMTP(); // send via SMTP

$mail->SMTPAuth = true; // turn on SMTP authentication
$mail->Username = "applicationform@mgeshops.com"; // SMTP username
$mail->Password = "28w113hl"; // SMTP password
$from = "applicationform@mgeshops.com"; //Reply to this email ID
// $email="mail@bodony.com"; // Recipients email ID
$name=""; // Recipient's name
$mail->From = $from;
$mail->FromName = "MGE Office";
//$mail->AddAddress($who,$name);
$mail->AddAddress("jbodony@freemail.hu","Jani2");
$mail->AddAddress("mail@bodony.com","Jani");
$mail->AddReplyTo($from,"MGE Office");
$mail->WordWrap = 50; // set word wrap
//$mail->AddAttachment("/var/tmp/file.tar.gz"); // attachment
//$mail->AddAttachment("/tmp/image.jpg", "new.jpg"); // attachment
$mail->IsHTML(true); // send as HTML
$mail->Subject = "MGE Application form data";
$mail->Body = $body; //HTML Body
$mail->AltBody = $body; //Text Body


if(!$mail->Send())
{
echo "Mailer Error: " . $mail->ErrorInfo."<br>";
}
else
{
$value = true;
}


unset($mail);  
 
return $value; 
 
 }          

?>