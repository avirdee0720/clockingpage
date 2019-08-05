<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$tytul='PAYs ';

//uprstr($PU,90);

echo "	<TD ALIGN=JUSTIFY VALIGN=TOP border=0>

<center>
&nbsp;
<font class='FormHeaderFont'>$tytul</font>
<table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
  <tr>
  <td class='ColumnTD' nowrap>DATE </td>
  <td class='ColumnTD' colspan='7' nowrap>TOTAL GROSS	</td>
  </tr>
";

if (!$db->Open()) $db->Kill();
$sql = "SELECT SUM(`monetarytotal`) AS total, DATE_FORMAT( `date1`,\"%d/%m/%Y\") AS date2 FROM `paygross` GROUP BY `date1` ORDER BY `date1` DESC";

  if ($db->Query($sql)) 
  {
    while ($row=$db->Row())
    {

     echo "
	  <tr>
		<td class='DataTD'>$row->date2</td>
		<td class='DataTD'>£ <B>".number_format($row->total,2,'.',' ')."</B></td>
		<td class='DataTD'><A HREF='paydisplay.php?endd=$row->date2'>Display</A></td>
		<td class='DataTD'><A HREF='paydelete.php?endd=$row->date2' onclick='return confirm(\"ARE YOU SURE? DELETE THE PAY?\")'>Delete</A></td>
		<td class='DataTD'><A HREF='payexpded.php?endd=$row->date2'>Export deductions</A></td>
		<td class='DataTD'><A HREF='payexpadd.php?endd=$row->date2'>Export additions</A></td>
		<td class='DataTD'><A HREF='payexpslip.php?endd=$row->date2'>Export payslips</A></td>
		<td class='DataTD'><A HREF='payexpslip_csv.php?endd=$row->date2'>Export payslips /new version/</A></td>
		  </tr>  ";
  } 
} else {
echo " 
  <tr>
    <td class='DataTD'></td>
    <td class='DataTD' colspan='6'>Error</td>
  </tr>";
 $db->Kill();
}
echo "
  <tr>
    <td align='left' class='FooterTD' nowrap>&nbsp;</td>
    <td align='middle' class='FooterTD' colspan='7' nowrap>&nbsp;</td>
  </tr>
</table>
</center>
<BR>
</td></tr>
</table>";
include_once("./footer.php");
?>