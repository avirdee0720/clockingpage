<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$db1 = new CMySQL;

uprstr($PU,50);

if (empty($_GET["letter"])) {
    $letter="A";
} else {
    $letter=$_GET["letter"];
}

$currentyear = date("Y");
$currentmonth = date("n");
// Leave year starts on 1st of Dec and ends on 30th of Nov
if ($currentmonth == 12) {
	$history_start = $currentyear - 1;
	$history_end = $currentyear;
	$current_leave_year_start = $currentyear;
	$current_leave_year_end = $currentyear + 1;
} else {
	$history_start = $currentyear - 2;
	$history_end = $currentyear - 1;
	$current_leave_year_start = $currentyear - 1;
	$current_leave_year_end = $currentyear;
}

echo "  <TD ALIGN=JUSTIFY VALIGN=TOP border=0>

<center>

<br>
<font CLASS='FormHeaderFont'>Active staff paid leave entitlement</font>
<br><br>
Paid leave entitlement calculation: <i>Total hours</i> * <i>Paid leave %</i> / 100 * 12.07 / 100 / <i>Average hours per day</i>
 (which is <i>Total hours</i> / <i>Total days</i>)
<table border='0' cellpadding='3' cellspacing='1' CLASS='FormTABLE'>
  <tr>
    <td CLASS='ColumnTD' nowrap><A HREF='$PHP_SELF?sort=1'>NO</a></td>
    <td CLASS='ColumnTD' nowrap><A HREF='$PHP_SELF?sort=2'>Known as</a></td>
	<td CLASS='ColumnTD' nowrap><A HREF='$PHP_SELF?sort=5'>First name</a></td>
    <td CLASS='ColumnTD' nowrap><A HREF='$PHP_SELF?sort=3'>Surname</a></td>
    <td CLASS='ColumnTD' nowrap><A HREF='$PHP_SELF?sort=4'>Category</a></td>
	<td CLASS='ColumnTD' nowrap><A HREF='$PHP_SELF?sort=6'>Started</a>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td CLASS='ColumnTD' nowrap>Total hours<br>$history_start Dec - $history_end Nov</td>
	<td CLASS='ColumnTD' nowrap>Total days<br>$history_start Dec - $history_end Nov</td>
	<td CLASS='ColumnTD' nowrap>Average hours per day</td>
    <td CLASS='ColumnTD' nowrap>Paid leave %</td>
	<td CLASS='ColumnTD' nowrap>Paid leave entitlement</td>
  </tr>
";

if (!$db->Open()) $db->Kill();

if(!isset($sort)) $sort=1;

        switch ($sort)
                {
                case 1:
                 $sortowanie=" ORDER BY `pno` DESC";
                 break;
                case 2:
                 $sortowanie=" ORDER BY `knownas` ASC";
                 break;
                case 3:
                 $sortowanie=" ORDER BY `surname` ASC";
                 break;
                case 4:
                 $sortowanie=" ORDER BY `cat` ASC";
                 break;
				case 5:
                 $sortowanie=" ORDER BY `firstname` ASC";
                 break;
				case 6:
                 $sortowanie=" ORDER BY `started` ASC";
                 break;

                default:
                 $sortowanie=" ORDER BY nombers.pno DESC ";
                 break;
                }
if(!isset($letter)) $letter='%';
else $letter=$letter.'%';


if (!$db->Open()) $db->Kill();
$months = 12; // start of the period how many full months ago
$q = "SELECT n.ID, n.pno, n.firstname, n.surname, n.knownas, n.started, DATE_FORMAT(n.started, \"%d/%m/%Y\") AS started2, cat.catname,
       total_hours_worked(n.pno, $months) AS total_hours,
       total_days_worked(n.pno, $months) AS total_days,	   
       n.leave_entitl_percent,
       current_paid_leave_entitlement(n.pno, $months) AS current_paid_leave
  FROM nombers n LEFT JOIN emplcat cat ON n.cat = cat.catozn
 WHERE `status` = 'OK' ";
$q .= $sortowanie;

$colour_odd = "DataTD"; 
$colour_even = "DataTDGrey"; 
$row_count=0;
if ($db->Query($q)) {
	$ileich=$db->Rows();
    while ($row=$db->Row()) {
		$clocking = $row->pno;
		$row_count++;
		$row_color = (($row_count % 2) == 0) ? $colour_even : $colour_odd;
		if (($row->total_days == null) || ($row->total_days == 0)) {
			$avg_hours_per_day = 0;			
		} else {
			$avg_hours_per_day = round($row->total_hours / $row->total_days, 1);
		}
		echo "<tr>
		<td CLASS='$row_color'><a CLASS='DataLink' href='hr_data.php?cln=$clocking'><B>$row->pno</B></a></td>
		<td CLASS='$row_color'>$row->knownas</td>
		<td CLASS='$row_color'>$row->firstname</td>
		<td CLASS='$row_color'>$row->surname</td>
		<td CLASS='$row_color'>$row->catname</td>
		<td CLASS='$row_color'>$row->started2</td>
		<td CLASS='$row_color' valign='right'>$row->total_hours</td>
		<td CLASS='$row_color'>$row->total_days</td>
		<td CLASS='$row_color'>$avg_hours_per_day</td>
		<td CLASS='$row_color'>$row->leave_entitl_percent</td>
		<td CLASS='$row_color'>$row->current_paid_leave</td>
		</tr>";
	}
	echo "
	  <tr>
		<td align='left' CLASS='FooterTD' colspan='6' nowrap>Total: $ileich </td>
	  </tr>";
} else {
	echo " 
	  <tr>
		<td CLASS='DataTD'></td>
		<td CLASS='DataTD' colspan='3'>No employees to display</td>
	  </tr>";
 $db->Kill();
}

echo "</table></center>";

include_once("./footer.php");
?>
