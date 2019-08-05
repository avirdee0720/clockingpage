<?php
include_once("./config.php");
include_once("./header2.php");

uprstr($PU,90);
$dataakt = date("d/m/Y H:i:s");

list($day, $month, $year) = explode("/",$_GET['startd']);
$input_range_start = "$year-$month-$day";
list($day1, $month1, $year1) = explode("/",$_GET['endd']);
$input_range_end = "$year1-$month1-$day1";
$emp_cat = $_GET['emp_cat'];
if (array_key_exists('only_below', $_GET)) {
	$only_below = $_GET['only_below'];
} else {
	$only_below = 0;
}

$title = "Average attendance weekend days 0.75";

echo "
<div id='reportcontainer'>
	<p id='reportheader'>
	$title<br>
	$day.$month.$year - $day1.$month1.$year1
	</p>
";

$tablecode = "
	<table id='maintable'>
		<tr>
			<th>Clo no</th>
			<th>Name</th>
			<th>Started</th>
			<th>Avg starting time</th>
			<th>Avg leaving time</th>
			<th>Before 10am (%)</th>
			<th>After 8pm (%)</th>
			<th>Hours per day</th>
			<th>Hours per week</th>
			<th>Days per week</th>
			<th>Days per month</th>
		</tr>
";

$db = new CMySQL;
if (!$db->Open()) $db->Kill();
$db2 = new CMySQL;
if (!$db2->Open()) $db2->Kill();

$groupcode = "";
switch ($emp_cat)
		{
		case 'r':
		 $groupcode=" AND cat <> 'c'";
		 break;
		case 'c':
		  $groupcode=" AND cat = 'c'";
		 break;
		case 'b':
		  $groupcode=" AND cat = 'b'";
         break;
        case 'nb':
		  $groupcode=" AND cat NOT IN ('c', 'b')";
		break;
		case 'e':
		  $groupcode=" AND cat = 'e'";
		 break;
		case 'ga':
		  $groupcode=" AND (cat = 'ga' OR cat = 'm')";
		 break;
		case 'gma':
		  $groupcode=" AND cat = 'gma'";
		 break;
		case 'i':
		  $groupcode=" AND cat = 'i'";
		 break;
		default:
		$groupcode="";
		 break;
		}

$q = "
	SELECT pno,
		   knownas,
		   surname,
		   started,
		   date_range_emp_full_weeks(pno, weeks_between('$input_range_start', '$input_range_end'), DATE_ADD('$input_range_end', INTERVAL 1 DAY)) AS drefw
	FROM nombers
	WHERE `status` = 'OK'
	  AND pno NOT IN (5, 555)
	  AND cat != 'ui'
	  $groupcode
	ORDER BY knownas, surname
";

if ($db->Query($q)) {
    while ($row = $db->Row()) {
        $hours_worked = 0;
		$days_worked = 0;
		$months_worked = 0;
		$avg_in = 0;
		$avg_out = 0;
		$before_10am = 0;
		$before_10am_percent = 0;
		$after_8pm = 0;
		$after_8pm_percent = 0;
		$hours_per_day = 0;
		$hours_per_week = 0;
		$days_per_week = 0;
		$days_per_month = 0;
			
		$drefw_tok = explode(';', $row->drefw);
		$date_range_start = $drefw_tok[0];
        $date_range_end = $drefw_tok[1];
		$weeks = $drefw_tok[2];
    
		$clockin_no = $row->pno;
		$name = $row->knownas." ".$row->surname;
		$name = EscapeSpaceAndDashes($name);	
		$started = DateTime::createFromFormat('Y-m-d', $row->started)->format('d.m.Y');
	
		// total number of weekend days worked in the period
        $q2 = "
			SELECT COUNT(DISTINCT date1) AS days_worked
			FROM `inout`
			WHERE `no` = $clockin_no
			  AND date1 BETWEEN '$date_range_start' AND '$date_range_end'
			  AND WEEKDAY(date1) IN (5, 6)";    

        if (!$db2->Query($q2)) $db2->Kill();
		$row2 = $db2->Row();
		if (isset($row2->days_worked))
			$days_worked = $row2->days_worked;
		else
			$days_worked = 0;

		if (($weeks > 0) && ($days_worked > 0)) {
			// average starting and leaving time
			$q2 = "
				SELECT SEC_TO_TIME(avg(TIME_TO_SEC(min_in))) AS avg_in,
					   SEC_TO_TIME(avg(TIME_TO_SEC(max_out))) AS avg_out
				FROM (
					SELECT min(intime) AS min_in, max(outtime) AS max_out
					FROM `inout`
					WHERE `no` = $clockin_no
					  AND date1 BETWEEN '$date_range_start' AND '$date_range_end'
					  AND WEEKDAY(date1) IN (5, 6)
					GROUP BY date1) AS x";

			if (!$db2->Query($q2)) $db2->Kill();
			$row2 = $db2->Row();
			$avg_in = substr($row2->avg_in, 0, 5); //DateTime::createFromFormat('HH:ii:ss', $row2->avg_in)->format('HH:ii');
			$avg_out = substr($row2->avg_out, 0, 5); //DateTime::createFromFormat('HH:ii:ss', $row2->avg_out)->format('HH:ii');
			
			// percent of worked days in before 10am and out after 8pm
			$q2 = "
				SELECT SUM(bef) AS before_10am, SUM(aft) AS after_8pm
				FROM (
					SELECT date1,
						   CASE WHEN MIN(`intime`) <= '10:00:00' THEN 1 ELSE 0 END AS bef,
						   CASE WHEN MAX(`outtime`) >= '20:00:00' THEN 1 ELSE 0 END AS aft
					FROM `inout`
					WHERE `no` = $clockin_no
					  AND date1 BETWEEN '$date_range_start' AND '$date_range_end'
					  AND WEEKDAY(date1) IN (5, 6)
					GROUP BY `date1`
				) AS x
				";

			if (!$db2->Query($q2)) $db2->Kill();
			$row2 = $db2->Row();
			$before_10am = $row2->before_10am;
			$before_10am_percent = round($before_10am / $days_worked * 100, 2);
			$after_8pm = $row2->after_8pm;
			$after_8pm_percent = round($after_8pm / $days_worked * 100, 2);
			
			// average hours per day
			$q2 = "
				SELECT IFNULL(SUM(TIME_TO_SEC(TIMEDIFF(outtime, intime))) / 3600, 0) AS hours_worked
				FROM `inout`
				WHERE `no` = $clockin_no
				  AND date1 BETWEEN '$date_range_start' AND '$date_range_end'
				  AND WEEKDAY(date1) IN (5, 6)
				  AND outtime <> '00:00:00'
			";

			if (!$db2->Query($q2)) $db2->Kill();
			$row2 = $db2->Row();
			if (isset($row2->hours_worked))
				$hours_worked = round($row2->hours_worked, 2);
			else 
				$hours_worked = 0;
			$hours_per_day = round($hours_worked / $days_worked, 2);
			
			// hours per week
			$hours_per_week = round($hours_worked / $weeks, 2);

			// days per week
			$days_per_week = round($days_worked / $weeks, 2);
				
			// days per month
			$q2 = "
				SELECT COUNT(*) AS months_worked
				FROM (
					SELECT DISTINCT DATE_FORMAT(date1, '%Y/%m')
					FROM `inout`
					WHERE `no` = $clockin_no
					  AND date1 BETWEEN '$date_range_start' AND '$date_range_end'
					  AND WEEKDAY(date1) IN (5, 6)
				) AS x
			";

			if (!$db2->Query($q2)) $db2->Kill();
			$row2 = $db2->Row();
			if (isset($row2->months_worked))
				$months_worked = $row2->months_worked;
			else
				$months_worked = 0;
			if ($months_worked > 0)
				$days_per_month = round($days_worked / $months_worked, 2);
			else
				$days_per_month = '-';
		} else {
			$hours_worked = '-';
			$days_worked = '-';
			$months_worked = '-';
			$avg_in = '-';
			$avg_out = '-';
			$before_10am = '-';
			$before_10am_percent = '-';
			$after_8pm = '-';
			$after_8pm_percent = '-';
			$hours_per_day = '-';
			$hours_per_week = '-';
			$days_per_week = '-';
			$days_per_month = '-';
		}
		if ((!$only_below) || (($only_below) && ($days_per_week < 0.75))) {
			$tablecode.= "
				<tr>
					<td>$clockin_no</td>
					<td>$name</td>
					<td>$started</td>
					<td>$avg_in</td>
					<td>$avg_out</td>
					<td title='$before_10am / $days_worked'>$before_10am_percent</td>
					<td title='$after_8pm / $days_worked'>$after_8pm_percent</td>
					<td title='$hours_worked hour(s) / $days_worked day(s)'>$hours_per_day</td>
					<td title='$hours_worked hour(s) / $weeks week(s)'>$hours_per_week</td>
					<td title='$days_worked day(s) / $weeks week(s)'>$days_per_week</td>
					<td title='$days_worked day(s) / $months_worked month(s)'>$days_per_month</td>
				</tr>";
		}
    } 
}

$creationDate = date("D, d M Y H:i");
echo "
$tablecode</table>

<div id='reportcreationdate'>
	Report created at $creationDate
</div>
<div id='reportexplanation'>
	Hours per day = Amount of hours worked during the period / Number of days worked during the period<br>
	Hours per week = Amount of hours worked during the period / Number of weeks in the period.<br>
	Days per week = Number of days worked during the period / Number of weeks in the period.<br>
	Days per month = Number of days worked during the period / Number of months worked during the period.
	A month is not counted if the employee worked for 0 hours on that month.<br>
</div>

</div> <!-- reportcontainer -->
";
?>