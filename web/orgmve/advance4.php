<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
uprstr($PU,90);

$advanceid=$_GET['advanceid'];
$cln=$_GET['cln'];
$tytul='Advance';
$db1 = new CMySQL;
$db = new CMySQL;

if (!$db1->Open()) $db1->Kill();
$prac1 =("SELECT `ID`, `pno`, `firstname`, `surname`, `knownas`, `status` FROM `nombers` WHERE `pno`='$cln' LIMIT 1;");
if (!$db1->Query($prac1)) $db1->Kill();
   while ($row1=$db1->Row())
    {
    echo "
	<font class='FormHeaderFont'>$tytul</font> 
		<TABLE><TR><TD>
		<div id='name'>

		<table>
		    <tr>
		      <td class='FieldCaptionTD'>Clocking in number</td><td class='DataTD'><FONT COLOR='#000099'><B>$row1->pno</B></FONT></td>
			  <td class='FieldCaptionTD'>Known as</td><td class='DataTD'>$row1->knownas</td>
		   </tr>
		   <tr>
		     <td class='FieldCaptionTD'>First name</td><td class='DataTD'>$row1->firstname</td>
		     <td class='FieldCaptionTD'>Surname</td><td class='DataTD'>$row1->surname</td>
		   </tr>   
		</table>";
		$no=$row1->pno;
		$firstname=$row1->firstname;
		$surname=$row1->surname;
	}

echo "<table border='0' cellpadding='3' cellspacing='1' >
  <tr>
  <td class='ColumnTD' nowrap>DATE </td>
  <td class='ColumnTD' colspan='12' nowrap>TOTAL ADVANCE</td>
  </tr>
  <tr>
  <td class='ColumnTD' nowrap>DATE </td>
  <td class='ColumnTD' nowrap>Amount</td>
  	<td class='DataTD'>Hours</td>
		<td class='DataTD'>Gross</td>
		<td class='DataTD'>Tax_code</td>
		<td class='DataTD'>Tax_amount</td>
		<td class='DataTD'>NI</td>
		<td class='DataTD'>Rent</td>
		<td class='DataTD'>Loan</td>
		<td class='DataTD'>Vouchers entitlement</td>
		<td class='DataTD'>Vouchers fix</td>
		<td class='DataTD'>Clearing date</td>
  </tr>
  ";

if (!$db->Open()) $db->Kill();
$sql = "SELECT `id`, `no`,DATE_FORMAT(`date1`, \"%d/%m/%Y\") as d2, `amount`, `gvienby`, `hours`, `gross`, `tax_code`, `tax_amount`, `ni`, `rent`, `loan`, `vouchers_entitlement`, `vouchers_fix`, DATE_FORMAT(`clearing_date`, \"%d/%m/%Y\") as clearing_date,`dateg`  FROM `advances_get` WHERE `id`='$advanceid' LIMIT 1";

  if ($db->Query($sql)) 
  {
    while ($row=$db->Row())
    {
     echo "<tr>
		<td class='DataTD'>$row->d2</td>
		<td class='DataTD'>&pound; <B>".number_format($row->amount,2,'.',' ')."</B></td>
		<td class='DataTD'>$row->hours</td>
		<td class='DataTD'>$row->gross</td>
		<td class='DataTD'>$row->tax_code</td>
		<td class='DataTD'>$row->tax_amount</td>
		<td class='DataTD'>$row->ni</td>
		<td class='DataTD'>$row->rent</td>
		<td class='DataTD'>$row->loan</td>
		<td class='DataTD'>$row->vouchers_entitlement</td>
		<td class='DataTD'>$row->vouchers_fix</td>
		<td class='DataTD'>$row->clearing_date</td>
	  </tr>  ";
  } 
} else {
echo " 
  <tr>
    <td class='DataTD'></td>
    <td class='DataTD' colspan='5'>Error</td>
  </tr>";
 $db->Kill();
}
echo "
  <tr>
    <td align='left' class='FooterTD' nowrap>&nbsp;</td>
    <td align='middle' class='FooterTD' colspan='5' nowrap>&nbsp;</td>
  </tr>
</table>
Details of the advance:<BR>
<table border='0' cellpadding='3' cellspacing='1' >
  <tr>
  <td class='ColumnTD' nowrap>MONTH </td>
  <td class='ColumnTD' colspan='5' nowrap>TO PAY</td>
  </tr>";

if (!$db->Open()) $db->Kill();
$sql = "SELECT `id`,`no`, `month`, `topay`, `idadv`, `year`  FROM `advances` WHERE `idadv`='$advanceid';";

  if ($db->Query($sql)) 
  {
    while ($row=$db->Row())
    {
     echo "<tr>
		<td class='DataTD'>$row->month/$row->year</td>
		<td class='DataTD'>&pound; <B>".number_format($row->topay,2,'.',' ')."</B></td>
	  </tr>  ";
  } 
} else {
echo " 
  <tr>
    <td class='DataTD'></td>
    <td class='DataTD' colspan='5'>Error</td>
  </tr>";
 $db->Kill();
}
echo "
  <tr>
    <td align='left' class='FooterTD' nowrap>&nbsp;</td>
    <td align='middle' class='FooterTD' colspan='5' nowrap>&nbsp;</td>
  </tr>
</table>



</TABLE><BR>
<BR><A HREF='#' onclick=\"window.close();\"><IMG SRC='images/end.jpg' WIDTH='22' BORDER='0' ALT='Close this window'></A>&nbsp;<A HREF='#' onclick=\"window.print();\"><IMG SRC='images/print.png' WIDTH='22' BORDER='0' ALT='Print'></A>";
?>
