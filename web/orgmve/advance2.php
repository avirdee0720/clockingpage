<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$dataakt=date("d/m/Y H:i:s");
$msgdb = new CMySQL;
uprstr($PU,90);
$title="Advance ";

$no=$_POST['no'];
$firstname=$_POST['firstname'];
$surname=$_POST['surname'];
$date1a=$_POST['date1'];
$amount=$_POST['amount'];
$motnhs=$_POST['motnhs'];

$hours=$_POST['hours'];
$gross=$_POST['gross'];
$tax_code=$_POST['tax_code'];
$tax_amount=$_POST['tax_amount'];
$ni_amount=$_POST['ni_amount'];
$loan=$_POST['loan'];

$voucher_entitlement=$_POST['voucher_entitlement'];
$voucher_fix=$_POST['voucher_fix'];
$clearing_day=$_POST['clearing_day'];


list($day, $month, $year) = explode("/",$_POST['date1']);
$dod = "$year-$month-$day";
$dateday=$_POST['date1'];

if($motnhs==0 || $motnhs=="")
{
echo "<font class='FormHeaderFont'>$title</font>";


	$db = new CMySQL;
	if (!$db->Open()) $db->Kill();
	$sql = "INSERT INTO `advances_get` (`id`, `no`, `date1`, `amount`, `gvienby`, `hours`, `gross`, `tax_code`, `tax_amount`, `ni`, `rent`, `loan`, `vouchers_entitlement`, `vouchers_fix`, `clearing_date`,`dateg`) 
			VALUES (NULL, '$no', '$dod', '$amount', '$id', '$hours', '$gross', '$tax_code', '$tax_amount', '$ni_amount', '$rent', '$loan', '$voucher_entitlement','$voucher_fix',STR_TO_DATE( '$clearing_day', '%d/%m/%Y'), '$dzis $godz:00');";
	if ($db->Query($sql)) 
	{
	$idadv=mysql_insert_id();
	echo "<table>
    <tr>
      <td class='FieldCaptionTD'>Clocking in number</td><td class='DataTD'><FONT COLOR='#000099'><B>$no</B></FONT></td>
	  <td class='FieldCaptionTD'>&nbsp;</td><td class='DataTD'>&nbsp;</td>
    </tr>
    <tr>
      <td class='FieldCaptionTD'>First name</td><td class='DataTD'>$firstname</td>
      <td class='FieldCaptionTD'>Surname</td><td class='DataTD'>$surname</td>
    </tr>
	<TR>
	<TD>Date</TD>
	<TD>$date1a</TD>
	</TR>
	<TR>
	<TD>Amount</TD>
	<TD>&pound; $amount</TD>
	</TR>
	<TR>
	<TD>ADDED BY</TD>
	<TD>$nazwa</TD>
	</TR>
</TABLE>";
//add to monthly payment
	$db2 = new CMySQL;
	if (!$db2->Open()) $db2->Kill();
	$sql2 = "INSERT INTO `advances` ( `id` , `no` , `month` , `topay` , `idadv`, `year` ) VALUES (NULL , '$no', '$month', '$amount', '$idadv', '$year')";
	if (!$db2->Query($sql2)) $db2->Kill();

	} else {
		echo " 
		 <tr><td class='DataTD'></td><td class='DataTD' colspan='5'>SQL Error:".mysql_error()."</td></tr>";
		$db->Kill();
	}

	echo "
	</table>
			<BR><A HREF='t_lista.php'><input class='Button' name='Update' type='submit' value='$SAVEBTN'></A>
	</center>
	</td></tr>
	</table>";
  echo "<script language='javascript'>window.location=\"t_lista.php\"</script>";

include_once("./footer.php");
}
elseif($motnhs<>0)
{
	echo "<font class='FormHeaderFont'>$title - add months</font>";

	echo "<table>
    <tr>
      <td class='FieldCaptionTD'>Clocking in number</td><td class='DataTD'><FONT COLOR='#000099'><B>$no</B></FONT></td>
	  <td class='FieldCaptionTD'>&nbsp;</td><td class='DataTD'>&nbsp;</td>
    </tr>
    <tr>
      <td class='FieldCaptionTD'>First name</td><td class='DataTD'>$firstname</td>
      <td class='FieldCaptionTD'>Surname</td><td class='DataTD'>$surname</td>
    </tr>
	<TR>
	<TD>Date</TD>
	<TD>$date1a</TD>
	</TR>
	<TR>
	<TD>Amount</TD>
	<TD>&pound; $amount</TD>
	</TR>
	<TR>
	<TD>ADDED BY</TD>
	<TD>$nazwa</TD>
	</TR>
</TABLE>";

$small=round($amount/$motnhs,2);

$month=$month-1;
	echo "<FORM METHOD=POST ACTION='advance3.php'>
	
	<INPUT TYPE='hidden' NAME='firstname' VALUE='$firstname'>
	<INPUT TYPE='hidden' NAME='surname' VALUE='$surname'>
	<INPUT TYPE='hidden' NAME='no' VALUE='$no'>
	<INPUT TYPE='hidden' NAME='date1' VALUE='$date1a'>
	<INPUT TYPE='hidden' NAME='amount' VALUE='$amount'>

	<table>";
	for ($i = 0; $i <= $motnhs-1; $i++) {
		$m[$i]=$month+1; 
		echo "<TR><TD>Month <INPUT TYPE='text' NAME='mm[$i]' SIZE='2' VALUE='$m[$i]'></TD><TD> <INPUT TYPE='text' NAME='year[$i]' SIZE='5' VALUE='$year'></TD><TD>&pound; <INPUT TYPE='text' NAME='mamount[$i]' SIZE='5' VALUE='$small'></TD></TR>";
		$month=$month+1;
     }
	 	
	echo "</TABLE>
	<INPUT TYPE='hidden' NAME='licz' VALUE='$i'>
	<input class='Button' name='Update' type='submit' value='$SAVEBTN'>
</FORM>	";
//echo "<script language='javascript'>window.location=\"t-lista.php"</script>";

}
  
   
?>