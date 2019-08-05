<?php
ini_set("display_errors","2");
//ERROR_REPORTING(E_ALL);

include_once("./header.php");
$tytul='Payslips - Voucher Mail List<BR>';
//include("./inc/uprawnienia.php");
include("./config.php");

 $db = new CMySQL;
 if (!$db->Open()) $db->Kill();
 
 $no=$_GET['cln'];
     
if(!isset($state))
{

     $q="SELECT `payslips_vouchers`.id,`payslips_vouchers_no`.pvno, DATE_FORMAT(`payslips_vouchers_no`.`date1`, \"%d/%m/%Y\") As date1  FROM `payslips_vouchers_no`
     INNER JOIN  `payslips_vouchers` ON `payslips_vouchers_no`.pvno=`payslips_vouchers`.pvno
     Where no='$no'
    Order by date1 DESC";
   
   
   $payslipscode = "<select class='Select' name='_id'>\n";
   
  if ($db->Query($q)) 
  {
    while ($r=$db->Row())
    {

           $payslipscode .="<option value='$r->id'>$r->date1 </option>\n";
    }
	} else {
echo " 
  <tr>
    <td class='DataTD'></td>
    <td class='DataTD' colspan='3'>SQL Error 1a</td>
  </tr>";
 $db->Kill();
}

      $payslipscode .= "</select>\n";
  


echo "	<TD ALIGN=JUSTIFY VALIGN=TOP border=0>
	<table width='100%' border=0><tr><td>

<center>
<form action='$PHP_SELF' method='post' name='ed_czl'>
  <font class='FormHeaderFont'>$tytul</font>
  <table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
  <tr>
      <td class='FieldCaptionTD'></td>
        $payslipscode

</td></tr>
     
   <tr>
      <td align='right' colspan='2'>
		<input name='state' type='hidden' value='1'>

			<input class='Button' name='Update' type='submit' value='$OKBTN'>
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

   echo "<script language='javascript'>window.location=\"payslips_emp1b.php?id=$_id&cid=$id\"</script>";
} //fi state=1
else
{
 echo "<BR><BR><BR>Ostrze¿enie!!!!!<BR><BR><BR>",
	 "Oy! What are you doing? $REMOTE_ADDR <BR>";
} //else state
?>