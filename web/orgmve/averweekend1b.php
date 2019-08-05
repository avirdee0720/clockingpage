<?php
include_once("./config.php");
include_once("./header2.php");

uprstr($PU,90);
$dataakt=date("d/m/Y H:i:s");

function EscapeSpaceAndDashes($str) {
	$str = str_replace(" ", "&nbsp;", $str);
	$str = str_replace("-", "&#x2011;", $str);
	return $str;
}

list($day, $month, $year) = explode("/",$_GET['startd']);
$input_range_start = "$year-$month-$day";
list($day1, $month1, $year1) = explode("/",$_GET['endd']);
$input_range_end = "$year1-$month1-$day1";

$DepGroup = $_GET['_grp'];
$DepGroupUpper = strtoupper($_GET['_grp']);
$showall = $_GET['showall'];
$title = "Average attendance weekend days (Sat-Sun)";

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

if(!isset($sort)) $sort = 1;
if(!isset($showall)) $showall = "off";

	switch ($sort)
		{
		case 1:
		 $sortowanie=" ORDER BY `nombers`.`knownas` ASC";
		 break;
		case 2:
		 $sortowanie=" ORDER BY `nombers`.`starded` ASC ";
		 break;
		case 3:
		 $sortowanie=" ORDER BY `totals`.`intime` ASC";
		 break;
		case 4:
		 $sortowanie=" ORDER BY `totals`.`outtime` ASC";
		 break;
		case 5:
		 $sortowanie=" ORDER BY `totals`.`ILE` ASC";
		 break;
		default:
		 $sortowanie=" ORDER BY `totals`.`no`  DESC, `totals`.`workedtime` DESC";
		 break;
		}

$db = new CMySQL;
if (!$db->Open()) $db->Kill();
$db2 = new CMySQL;
if (!$db2->Open()) $db2->Kill();

$groupcode = "";
switch ($DepGroup)
		{
		case 'r':
		 $groupcode=" AND `nombers`.`cat`<>'c'";
		 break;
		case 'c':
		  $groupcode=" AND `nombers`.`cat`='c'";
		 break;
		case 'b':
		  $groupcode=" AND `nombers`.`cat`='b'";
		 break;
		case 'e':
		  $groupcode=" AND `nombers`.`cat`='e'";
		 break;
		case 'ga':
		  $groupcode=" AND (`nombers`.`cat`='ga' or `nombers`.`cat`='m')";
		 break;
		case 'gma':
		  $groupcode=" AND `nombers`.`cat`='gma'";
		 break;
		case 'i':
		  $groupcode=" AND `nombers`.`cat`='i'";
		 break;
		default:
		$groupcode="";
		 break;
		}

$q = "
	SELECT pno,
		   knownas,
		   firstname,
		   surname,
		   started,
		   date_range_emp_full_weeks(pno, weeks_between('$input_range_start', '$input_range_end'), '$input_range_end') AS drefw
	FROM nombers
	WHERE `status` = 'OK'
	  AND pno NOT IN (5, 555)
	  AND cat != 'ui'
	  $groupcode
	ORDER BY firstname, surname
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
		$name = $row->firstname." ".$row->surname;
		if ($row->firstname != $row->knownas) $name .= " (".$row->knownas.")";
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
			$avg_in = $row2->avg_in; //DateTime::createFromFormat('HH:ii:ss', $row2->avg_in)->format('HH:ii');
			$avg_out = $row2->avg_out; //DateTime::createFromFormat('HH:ii:ss', $row2->avg_out)->format('HH:ii');
			
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
				$hours_worked = $row2->hours_worked;
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

$creationDate = date("D, d M Y H:i:s");
echo "
$tablecode</table>

<div id='reportcreationdate'>
	Report created at $creationDate
</div>
<div id='reportexplanation'>
	Hours per day = Amount of hours worked during the period / Number of days worked during the period<br>
	Hours per week = Amount of hours worked during the period / Number of weeks worked during the period.
	A week is not counted if the employee worked for 0 hours on that week.<br>
	Days per week = Number of days worked during the period / Number of weeks worked during the period.
	A week is not counted if the employee worked for 0 hours on that week.<br>
	Days per month = Number of days worked during the period / Number of months worked during the period.
	A month is not counted if the employee worked for 0 hours on that month.<br>
</div>

</div> <!-- reportcontainer -->
";
?>