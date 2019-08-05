<?php
include_once("./header.php");
$tytul = 'Holidays accrued / agreed to';
include_once("./config.php");

$db = new CMySQL;
if (!$db->Open()) $db->Kill();
$q = "
	SELECT DATE_FORMAT(date_month_start(0, NULL), '%d/%m/%Y') AS current_month_start,
           DATE_FORMAT(date_month_end(0, NULL), '%d/%m/%Y') AS current_month_end,
           DATE_FORMAT(date_month_start(-1, NULL), '%d/%m/%Y') AS last_month_start,
		   DATE_FORMAT(date_month_end(-1, NULL), '%d/%m/%Y') AS last_month_end;
";
$db->Query($q);
$row = $db->Row();
$current_month_start = $row->current_month_start;
$current_month_end = $row->current_month_end;
$last_month_start = $row->last_month_start;
$last_month_end = $row->last_month_end;

echo "
<TD ALIGN=JUSTIFY VALIGN=TOP border=0>
<table width='100%' border=0><tr><td>

<center>

<form action='/orgmve/hr_list_holiday.php' method='GET'>
	<br><font class='FormHeaderFont'>$tytul</font><br><br>
	<table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>  
    <tr>
		<td class='FieldCaptionTD'>Start date</td>
		<td class='DataTD'><input class='input' maxlength='12' name='startd' value='$current_month_start'></td>
    </tr>
    <tr>
		<td class='FieldCaptionTD'>End date</td>
		<td class='DataTD'><input class='input' maxlength='12' name='endd' value='$current_month_end'></td>
	</tr>
	<tr>
		<td align='right' colspan='2'>			
			<input class='button' name='Update' type='submit' value='$OKBTN'>
			<input class='button' name='datesfromlastm' onclick='this.form.startd.value=\"$last_month_start\";this.form.endd.value=\"$last_month_end\";' type='button' value='Last month'>
		</td>
    </tr>
  </table>
</form>

</center>

</td></tr>
</table>";
include_once("./footer.php");
?>