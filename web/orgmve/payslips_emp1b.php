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
$msgdb = new CMySQL;

//list($day, $month, $year) = explode("/",$_GET['startd']);

$output = "";
$mail_sent = false;

$date1 = date("Ymd");

$id=$_GET['id'];

 $statustext = array ("Not uploaded","Data uploaded","Mail unsent","Mail sent"); 

?>
<meta HTTP-EQUIV='cache-control' CONTENT='no-cache, must-revalidate'>
<link rel=stylesheet type=text/css href="hs.css">
<LINK REL='stylesheet' HREF='style/multipads/style.css' TYPE='text/css'>

</HEAD>

<body class=PageBODY bgcolor=#FFFFFF topmargin=0 leftmargin=0 marginwidth=0 marginheight=0 text=#000000 link=#0000FF vlink=#0000FF alink=#FF0000>
<CENTER>

<?php


$title="Payslips - Vouchers mail list<br>";


echo "

<font class='FormHeaderFont'>$title</font>


<table bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >
  <tr>
     <td class='FieldCaptionTD'><B>&nbsp;Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</B></td>
     <td class='FieldCaptionTD'><B>Mail status</B></td>
     <td class='FieldCaptionTD'><B>Voucher status</B></td>
     <td class='FieldCaptionTD'><B>Payslips</B></td>
     <td class='FieldCaptionTD'><B>Voucher</B></td>
     
</tr>	
";
if(!isset($sort)) $sort=1;

	switch ($sort)
		{
		case 1:
		 $sortowanie=" ORDER BY `totals`.`no` ASC";
		 break;
		case 2:
		 $sortowanie=" ORDER BY `totals`.`date1` ASC ";
		 break;
		case 3:
		 $sortowanie=" ORDER BY `totals`.`intime` ASC";
		 break;
		case 4:
		 $sortowanie=" ORDER BY `totals`.`outtime` ASC";
		 break;
		case 5:
		 $sortowanie=" ORDER BY `totals`.`ILE` ASC";
		 break;
		default:
		 $sortowanie=" ORDER BY `totals`.`no`  DESC, `totals`.`workedtime` DESC";
		 break;
		}
		
  $filter = "";
  switch ($DepGroup)
                {
                 case 0:
                 $filter = "AND  `emplcat`.catname_staff Like '%'";
                 break;
                case 1:
                 $filter = " AND DATEDIFF( now( ) , `nombers`.`started` ) < 365 ";
                 break;
                case 2:
                  $filter = " AND DATEDIFF( now( ) , `nombers`.`started` ) >= 365 ";
                 break;
                case 3:
                 $filter = "AND  `emplcat`.catname_staff Like 'GA'";
                 break;
                case 4:
                 $filter = "AND  `emplcat`.catname_staff Like 'GMA'";
                 break;
                case 5:
                $filter = "AND  (`emplcat`.catname_staff Like 'GA' OR `emplcat`.catname_staff Like 'GMA')";
                 break;
                case 6:
                $filter=" AND  `emplcat`.catname_staff Like 'SA'";
                 break;
                case 7:
                $filter=" AND  (`emplcat`.catname_staff Like 'GA' OR `emplcat`.catname_staff Like 'GMA'  OR `emplcat`.catname_staff Like 'buyer')";
                 break;
                default:
                 $filter = "AND  `emplcat`.catname_staff Like '%'";
                 break;
                }
                
              
  
 $q= "SELECT pvfolder FROM `payslips_vouchers_no` WHERE `pvno`='$pvno' Limit 1";
     if (!$db2->Query($q)) $db2->Kill();  
     $row2=$db2->Row();
     
     $pvfolder=$row2->pvfolder;

$q = "SELECT payslips_vouchers_no.pvno, payslips_vouchers_no.date1,payslips_vouchers_no.pvfolder,
nombers.knownas,nombers.surname,
payslips_vouchers.id, payslips_vouchers.no,payslips_vouchers.payslipsno,payslips_vouchers.vouchersno,
payslips_vouchers.payslips_filename,payslips_vouchers.vouchers_filename,payslips_vouchers.payslips_state,
payslips_vouchers.vouchers_state,payslips_vouchers.vouchers_state,payslips_sha1code,vouchers_sha1code,
email
FROM  payslips_vouchers_no INNER JOIN payslips_vouchers ON payslips_vouchers_no.pvno=payslips_vouchers.pvno
INNER JOIN `staffdetails` ON `staffdetails`.no=payslips_vouchers.no
INNER JOIN `nombers` ON `staffdetails`.no=nombers.pno
Where payslips_vouchers.id='$id'
";

 if (!$db->Query($q)) $db->Kill();  
//$q=$q.$sortowanie;

while ($row=$db->Row())
    {
    $no=$row->no;
    $knownas=$row->knownas;
    $id=$row->id;
    $payslipsno=$row->payslipsno;
    $vouchersno=$row->vouchersno;
    $payslips_filename=$row->payslips_filename;
    $vouchers_filename=$row->vouchers_filename;
    $payslips_state=$row->payslips_state;
    $vouchers_state=$row->vouchers_state;
    $payslips_sha1=$row->payslips_sha1code;
    $vouchers_sha1=$row->vouchers_sha1code;
    
    $email=$row->email;

       $myFile_payslips = $payslips_filename;
       $myFile_vouchers = $vouchers_filename;
       
       $payslips_mail_status = $statustext[$payslips_state];
       $vouchers_mail_status = $statustext[$vouchers_state];
       if ($payslips_state=="2" || $payslips_state=="3") $payslips_mail_link = "<a href='pdfsend.php?fp=$payslips_sha1' target='_Blank'>Payslips</a>";
       else $payslips_mail_link = "There is no payslips file.";
        if ($vouchers_state=="2" || $vouchers_state=="3") $vouchers_mail_link = "<a href='pdfsend.php?fv=$vouchers_sha1' target='_Blank'>Payslips</a>";
       else $vouchers_mail_link = "There is no voucher file.";  
      
       echo " <tr>
			<td class='DataTD'>$row->knownas $row->surname</td>
    <td class='FieldCaptionTD'><B>$payslips_mail_status</B></td>
    <td class='FieldCaptionTD'><B>$vouchers_mail_status</B></td>
    <td class='FieldCaptionTD'><B>$payslips_mail_link</B></td>
    <td class='FieldCaptionTD'><B>$vouchers_mail_link</B></td>
    
			</TR>  ";
	
  		} 
       
      

echo "
</table>
</center>
<BR>

</td></tr>
</table>";
include_once("./footer.php");


 ?>