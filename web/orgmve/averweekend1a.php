<?php
include_once("./header.php");
$tytul = 'Average attendance Weekend days (Sat-Sun)<br>';
include_once("./config.php");

$db = new CMySQL;
if (!$db->Open()) $db->Kill();
$q = "
	SELECT DATE_FORMAT(date_week_start(-52, NULL), '%d/%m/%Y') AS period_start,
		   DATE_FORMAT(date_week_end(-1, NULL), '%d/%m/%Y') AS period_end;
";
$db->Query($q);
$row = $db->Row();
$start_52w = $row->period_start;
$end_52w = $row->period_end;

$q = "
	SELECT DATE_FORMAT(date_month_start(-1, NULL), '%d/%m/%Y') AS period_start,
		   DATE_FORMAT(date_month_end(-1, NULL), '%d/%m/%Y') AS period_end;
";
$db->Query($q);
$row = $db->Row();
$last_month_start = $row->period_start;
$last_month_end = $row->period_end;

echo "
<TD ALIGN=JUSTIFY VALIGN=TOP border=0>
<table width='100%' border=0><tr><td>

<center>

<form action='/orgmve/averweekend1b.php' method='get' name='ed_czl'>
	<br><font class='FormHeaderFont'>$tytul</font><br>
	<table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
		<tr>
			<td class='FieldCaptionTD'>Employee category</td>
			<td class='DataTD'>
				<select class='Select' name='_grp'>
					<option selected value='r'>Regular</option>
					<option value='c'>Casual</option>
					<option value='b'>Buyers</option>
					<option value='e'>Accounts</option>
					<option value='ga'>GA+Builders</option>
					<option value='gma'>GMA</option>
					<option value='i'>IT</option>
					<option value='a'>All</option>
				</select>
			</td>
		</tr>
		<tr>
			<td class='FieldCaptionTD'>Include not attending</td>
			<td class='DataTD'><input type='checkbox' name='showall' checked=true /></td>
		</tr>
		<tr>
			<td class='FieldCaptionTD'>Start date</td>
			<td class='DataTD'><input class='Input' maxlength='12' name='startd' value='$start_52w'></td>
		</tr>
		<tr>  
			<td class='FieldCaptionTD'>End date</td>
			<td class='DataTD'><input class='Input' maxlength='12' name='endd' value='$end_52w'></td>
		</tr>
		<tr>
			<td align='right' colspan='2'>
				<input class='Button' name='Update' type='submit' value='$OKBTN'>
				<input class='Button' name='datesfromlastm' onclick='this.form.startd.value=\"$last_month_start\";this.form.endd.value=\"$last_month_end\";' type='button' value='Prev month'>
			</td>
		</tr>
	</table>
</form>

</center>

</td></tr>
</table>";
include_once("./footer.php");
?>