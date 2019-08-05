<?php
include_once("./inc/orgfunc.inc.php");
include_once("./header2.php");

$db = new CMySQL;
if (!$db->Open()) $db->Kill();
$q = "SELECT curdate() AS today, month(curdate()) AS month, year(curdate()) AS year";
if (!$db->Query($q)) $db->Kill();
$row = $db->Row();
$today_time = strtotime($row->today);
$today_for_display = date("d.m.Y", $today_time);
$month = $row->month;
$year = $row->year;
if ($month == 12) {
    $current_leave_year_start = $year."-12-01";
    $current_leave_year_end = ($year + 1)."-11-30";
    $current_leave_year_start_year = $year;
    $current_leave_year_end_year = $year + 1;
    $previous_leave_year_start = ($year - 1)."-12-01";
    $previous_leave_year_end = $year."-11-30";
} else {
    $current_leave_year_start = ($year - 1)."-12-01";
    $current_leave_year_end = $year."-11-30";
    $current_leave_year_start_year = $year - 1;
    $current_leave_year_end_year = $year;
    $previous_leave_year_start = ($year - 2)."-12-01";
    $previous_leave_year_end = ($year - 1)."-11-30";
}
$tytul = 'Holidays accrued or agreed to as of '.$today_for_display;

echo "
<div id='reportcontainer'>
	<p id='reportheader'>
	$tytul<br>
	</p>
";

$tablecode = "
	<table id='maintable'>
		<tr>
			<th>Clo no</th>
			<th>Name</th>
			<th>Cat</th>
			<th>Total h last leave year</th>
			<th>Total h this leave year</th>
			<th>12.07% of this leave year</th>
            <th>Avg daily h last year</th>
            <th>Paid leave days estimate</th>
			<th>Paid leave days actual</th>
			<th>Days taken</th>
			<th>Days remaining</th>
		</tr>
";

$q = "
    SELECT n.pno,
           n.surname,
           n.knownas,
           n.cat,
           total_hours_worked(pno, '$previous_leave_year_start', '$previous_leave_year_end') AS thw_last,
           total_days_worked(pno, '$previous_leave_year_start', '$previous_leave_year_end') AS tdw_last,
           CASE WHEN n.paid_leave_agreed_to = 1 THEN n.paid_leave_estimate
                ELSE total_hours_worked(pno, '$current_leave_year_start', '$current_leave_year_end')
           END AS thw_current,
           CASE WHEN n.paid_leave_agreed_to = 1 THEN 0
                ELSE total_days_worked(pno, '$current_leave_year_start', '$current_leave_year_end')
           END AS tdw_current,
           IFNULL(vs.EinDays, '-') AS paid_leave_days_actual,
           IFNULL(vs.taken, '-') AS taken,
           IFNULL(vs.`left`, '-') AS `left`
    FROM nombers n LEFT JOIN voucherslips vs
      ON n.pno = vs.`no`
    WHERE n.`status` = 'OK'
      AND n.pno NOT IN ('5', '555')
      AND n.cat NOT IN ('c', 'ui')
      AND ((vs.`id` = (SELECT MAX(vs1.`id`) FROM voucherslips vs1 WHERE vs1.`no` = n.pno)) OR
	       ((SELECT MAX(vs1.`id`) FROM voucherslips vs1 WHERE vs1.`no` = n.pno) IS NULL))
    ORDER BY n.knownas, n.surname
";
if (!$db->Query($q)) $db->Kill();
while ($row = $db->Row()) {
    $name = EscapeSpaceAndDashes($row->knownas." ".$row->surname);
    $thw_last = (float)$row->thw_last;
    $thw_current = (float)$row->thw_current;
    $thw_current_12perc = round($thw_current * 0.1207, 2);
    $avg_daily_h_this_year = "";
    if ($row->tdw_last > 0) {
        $avg_daily_h = round($thw_last / $row->tdw_last, 2);
    } else {
        if ($row->tdw_current > 0) {
            $avg_daily_h = round($thw_current / $row->tdw_current, 2);
            $avg_daily_h_this_year = " (this year)";
        } else {
            $avg_daily_h = 0;
        }
    }
    if ($avg_daily_h > 0) {
        $paid_leave_days_pred = round($thw_current_12perc / $avg_daily_h, 2);
    } else {
        $paid_leave_days_pred = 0;
    }

    $tablecode.= "
        <tr>
            <td>$row->pno</td>
            <td>$name</td>
            <td>$row->cat</td>
            <td>$thw_last</td>
            <td>$thw_current</td>
            <td>$thw_current_12perc</td>
            <td>$avg_daily_h".($avg_daily_h_this_year = ''?'':$avg_daily_h_this_year)."</td>
            <td title='Total h this leave year $thw_current * 0.1207 / Avg daily h last year $avg_daily_h'>$paid_leave_days_pred</td>
            <td>$row->paid_leave_days_actual</td>
            <td>$row->taken</td>
            <td>$row->left</td>
        </tr>";
}

$creationDate = date("D, d M Y H:i");
echo "
$tablecode</table>

<div id='reportcreationdate'>
	Report created at $creationDate
</div>

</div> <!-- reportcontainer -->
";
?>