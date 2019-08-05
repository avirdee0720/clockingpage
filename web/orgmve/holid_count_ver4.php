<?php
include_once("./config.php");
include_once("./header.php");

$PHP_SELF = $_SERVER['PHP_SELF'];
$title = "Holidays and averages";
$dataakt = date("d/m/Y H:i:s");

if (!isset($_POST['state'])) $state = 0; else $state = $_POST['state'];
if (!isset($_POST['holid'])) $holid = array(); else $holid = $_POST['holid'];
if (!isset($_POST['no'])) $no = array(); else $no = $_POST['no'];
if (!isset($_POST['daypart'])) $daypart = array(); else $daypart = $_POST['daypart'];
if (!isset($_POST['hourgivenedit'])) $hourgivenedit = array(); else $hourgivenedit = $_POST['hourgivenedit'];
if (!isset($_POST['holidaystate'])) $holidaystate = array(); else $holidaystate = $_POST['holidaystate'];
    
/*
    for ($i=0; $i<300; $i++) 
        echo "$i. line is: daypart:$daypart[$i] hourgivenedit:$hourgivenedit[$i] holidaystate:$holidaystate[$i] holid:$holid[$i] no:$no[$i]<br>";
*/

if (!isset($_GET['startd'])) {
    if (!isset($_POST['startd'])) $startd = "00/00/0000";
    else $startd = $_POST['startd'];
}
else $startd = $_GET['startd'];

if (!isset($_GET['endd'])) {
    if (!isset($_POST['endd'])) $endd = "00/00/0000";
    else $endd = $_POST['endd'];
}
else $endd = $_GET['endd'];

list($day, $month, $year) = explode("/",$startd);
$start_date_mariadb = "$year-$month-$day";
list($day1, $month1, $year1) = explode("/",$endd);
$end_date_mariadb = "$year1-$month1-$day1";

$db = new CMySQL;
$db1 = new CMySQL;

// state 0 - display report; state 1 - update holidays table with new amount of holiday hours given
if ($state == 0)
{
	$htmlcode = "";
	$colour_odd = "DataTD2"; 
	$colour_even = "DataTDGrey2"; 
	$row_count = 0;
	$last_casual_no = 0; // current casual
	$casual_acc_hours = 0; // current casual's accumulated holiday hours

	// get Overwrite? select box options
	$selectoptions = array();
	$q = "SELECT holidaystateid, holidaystatetxt FROM holidaystatelist";
	if (!$db1->Open()) $db1->Kill();
	if (!$db1->Query($q)) $db1->Kill();
	while ($r = $db1->Row()) {
		$selectoptions[$r->holidaystateid] = $r->holidaystatetxt;
	}

	// get all employees who have taken holiday days in the period, with all the holiday days separately
	$sql = "
	SELECT n.pno,
		   n.firstname,
		   n.surname,
		   n.cat,
		   h.`id` AS holid,
		   h.date1,
		   h.hourgiven,
		   h.daypart,
		   h.holidaystateid
	FROM nombers n
	INNER JOIN holidays h ON n.pno = h.`no`
	WHERE h.date1 >= '$start_date_mariadb'
	  AND h.date1 <= '$end_date_mariadb'
	  AND (n.`status` = 'OK' OR (n.`status` = 'LEAVER' AND left1 >= '$start_date_mariadb'))
	ORDER BY n.pno, h.date1 ASC
	";
	if (!$db->Open()) $db->Kill();
	if (!$db->Query($sql)) $db->Kill();

	while ($row = $db->Row()) {
		$no =  $row->pno;
		$name = EscapeSpaceAndDashes($row->firstname." ".$row->surname);
		$cat = $row->cat;
		
		$holid = $row->holid;
		$holiday = $row->date1;
		$hourgiven = $row->hourgiven;
		$daypart = $row->daypart;
		$holidaystateid = $row->holidaystateid;

		$row_count++;
		$row_color = (($row_count % 2) == 0) ? $colour_even : $colour_odd;
		
		if (!$db1->Open()) $db1->Kill();
        $q = "SELECT total_hours_worked_with_holiday($no, '$holiday') AS th;";
		if (!$db1->Query($q)) $db1->Kill();
		$r = $db1->Row();
		$th_tok = explode(';', $r->th);
		$th_today = DateTime::createFromFormat('Y-m-d', $th_tok[0])->format('d.m.Y');
		$th_regular = $th_tok[1];        		
		$th_range_start = DateTime::createFromFormat('Y-m-d', $th_tok[2])->format('d.m.Y');
		$th_range_end = DateTime::createFromFormat('Y-m-d', $th_tok[3])->format('d.m.Y');
		$th_weeks = $th_tok[4];
        $th_total_hours = round($th_tok[5], 2);
        /*
        // if casual then remember calculated avg hours from previous row
		if (!$th_regular) {
			if ($no == $last_casual_no) {
				$casual_acc_hours = $th_avg_hours;
			} else {
				$last_casual_no = $no;
				$casual_acc_hours = 0;
			}
		}*/
		$th_avg_hours = round($th_tok[6], 2);
		/*// if casual and has no holiday hours saved in the holiday table then add calculated avg hours from previous row
		if ((!$th_regular) && ($hourgiven <= 0)) {
			$th_total_hours = round($th_total_hours + $casual_acc_hours, 2);
			$th_avg_hours = round($th_total_hours / 12, 2);
		}*/		
		$th_avg_hours = round($th_avg_hours * $daypart, 2);

		$selecttxt = "<select class='select' name='holidaystate[]'>";
		reset($selectoptions);
		while ($optionname = current($selectoptions)) {
			$selecttxt .= "<option value='".key($selectoptions)."'".($holidaystateid == key($selectoptions) ? " selected" : "").">$optionname</option>";
			next($selectoptions);
		}
		$selecttxt .=  "</select>";

		$htmlcode .= "
		<tr>
		<td class='$row_color'><input name='holid[]' type='hidden' value='$holid'><input name='no[]' type='hidden' value='$no'>$no</td>
		<td class='$row_color'>$name</td>
		<td class='$row_color'>$cat</td>
		<td class='$row_color'><b>$th_today</b></td>
		<td class='$row_color'>$th_range_start</td>
		<td class='$row_color'>$th_range_end</td>
		<td class='$row_color'>$th_weeks</td>
		<td class='$row_color'>$th_total_hours</td>		
		<td class='$row_color'><input class='input' size='5' maxlength='6' name='daypart[]' value='$daypart'></td>
		<td class='$row_color'><b>$hourgiven</b></td>
		<td class='$row_color'><input class='input' size='5' maxlength='6' name='hourgivenedit[]' value=\"$th_avg_hours\"></td>
		<td class='$row_color'>$selecttxt</td>
		</tr>";
	}
	$htmlcode = "
	<br><b>Holidays from $startd to $endd</b><br>
  <TD ALIGN=JUSTIFY VALIGN=TOP border=0>
	<table width='100%' border=0><tr><td>
 <center>
 <form action='$PHP_SELF' method='post' name='ed_czl'>
  <table>
  <tr>
	<td class='ColumnTD2'>Clo number</td>
	<td class='ColumnTD2'>Name</td>
	<td class='ColumnTD2'>Cat</td>
	<td class='ColumnTD2'>Holiday</td>
	<td class='ColumnTD2'>From</td>
	<td class='ColumnTD2'>To</td>
	<td class='ColumnTD2'>Weeks</td>
	<td class='ColumnTD2'>Hours</td>
	<td class='ColumnTD2'>Part&nbsp;time</td>
	<td class='ColumnTD2'>Stored</td>
	<td class='ColumnTD2'>Calculated</td>
	<td class='ColumnTD2'>Overwrite?</td>
	</tr>
	".$htmlcode."</table>
	<table border='0' cellpadding='3' cellspacing='1' >
		<tr><td align='right' colspan='2'>
		<input name='state' type='hidden' value='1'>
		<input name='startd' type='hidden' value='$startd'>
		<input name='endd' type='hidden' value='$endd'> 
		<input class='button' name='Update' type='submit' value='$SAVEBTN'>			
		</td></tr>
	</table>
	</form>
	</center>
	<BR>
	</td></tr>
	";
	echo $htmlcode;
	include_once("./footer.php");
}
// update holidays table
elseif ($state == 1) {
	foreach ($no as  $key => $cln) {
		if ($holidaystate[$key] == '1' ) {
			$sql = "UPDATE holidays SET hourgiven = '".$hourgivenedit[$key]."',
										daypart = '".$daypart[$key]."',
										holidaystateid = '1'
					WHERE no = '$cln'
					  AND id = '".$holid[$key]."'
					LIMIT 1";
			if (!$db1->Open()) $db1->Kill();
			if (!$db1->Query($sql)) $db1->Kill();
	    }
		else {
			$sql = "UPDATE holidays SET `holidaystateid`= '2'
					WHERE no = '$cln'
					  AND id = '".$holid[$key]."'
					LIMIT 1";
			if (!$db1->Open()) $db1->Kill();
			if (!$db1->Query($sql)) $db1->Kill();
		}
	}
	echo "<script language='javascript'>window.location=\"holid_count_ver4.php?startd=$startd&endd=$endd\"</script>";
}
?>