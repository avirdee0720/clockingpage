<?php
include_once("./config.php");
include_once("./header2.php");

uprstr($PU,90);
$dataakt=date("d/m/Y H:i:s");

list($day, $month, $year) = explode("/",$_GET['startd']);
$dod = "$year-$month-$day";
list($day1, $month1, $year1) = explode("/",$_GET['endd']);
$ddo = "$year1-$month1-$day1";

$DepGroup = $_GET['_grp'];
$DepGroupUpper = strtoupper($_GET['_grp']);
$showall = $_GET['showall'];
$title = "Average attendance all days (Mon-Sun)";

$tablecode = "";
$rownumber = 0;
$pagenumber = 0;

echo "
<div id='reportcontainer'>
	<p id='reportheader'>
	$title<br>
	$day.$month.$year - $day1.$month1.$year1
	</p>
";

$tableheader = "
	<table id='maintable'>
		<tr>
			<th>ClNo</th>
			<th>Name</th>
			<th>Started</th>
			<th>Starting time</th>
			<th>Leaving time</th>
			<th>Before 10am (%)</th>
			<th>After 8pm (%)</th>
			<th>Hours per day</th>
			<th>Hours per week</th>
			<th>Days per week</th>
			<th>Days per month</th>
		</tr>
";

if(!isset($sort)) $sort=1;

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
if(!isset($showall)) $showall="off";

$db = new CMySQL;
$db1 = new CMySQL;
if (!$db->Open()) $db->Kill();
if (!$db1->Open()) $db1->Kill();

$groupcode="";

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
        case 'b':
		  $groupcode=" AND `nombers`.`cat` NOT IN ('c', 'b')";
		break;
		case 'gma':
		  $groupcode=" AND `nombers`.`cat`='gma'";
		 break;
		case 'e':
		  $groupcode=" AND `nombers`.`cat`='e'";
		 break;
		case 'ga':
		  $groupcode=" AND (`nombers`.`cat`='ga' OR `nombers`.`cat`='m')";
		 break;
		case 'i':
		  $groupcode=" AND `nombers`.`cat`='i'";
		 break;
		default:
		$groupcode="";
		 break;
		}

$q="SELECT DISTINCT `nombers`.`pno`,
                `nombers`.`knownas`,
                `nombers`.`firstname`,
                `nombers`.`surname`,
                DATE_FORMAT(`nombers`.`started`, \"%d/%m/%Y\") AS started,
                CASE WHEN `nombers`.`started` > '$dod'
                THEN DATE_FORMAT(`nombers`.`started`, \"%Y-%m-%d\")
                ELSE DATE_FORMAT('$dod', \"%Y-%m-%d\")
                END AS `dateforattendence`,
                `nombers`.`regdays`
  FROM `nombers` INNER JOIN `totals` ON totals.no = nombers.pno
 WHERE     `nombers`.`status` = 'OK'
       AND `nombers`.`pno` <> '5'
       AND `nombers`.`pno` <> '555'
       AND `nombers`.`cat` != 'ui'
       $groupcode
ORDER BY `nombers`.`knownas` ASC, `nombers`.`surname` ASC
";

if ($db->Query($q)) {
    
    while ($row=$db->Row()) {
        $rownumber++;
        $dod2 = $row->dateforattendence;
        $ddo2 = $ddo;
    
        //AVERAGE IN/OUT TIME
        $q2 = "SELECT TIME_FORMAT(SEC_TO_TIME(avg(TIME_TO_SEC(it))), '%H:%i') AS avin,
               TIME_FORMAT(SEC_TO_TIME(avg(TIME_TO_SEC(ot))), '%H:%i') AS avout
          FROM (SELECT min(`intime`) AS it, max(`outtime`) AS ot
                FROM `inout` AS `inout`
                WHERE `no` = '$row->pno'
                    AND (`date1` >= '$dod2' AND `date1` <= '$ddo2')
                GROUP BY `date1`) AS x";    

        if (!$db1->Query($q2)) $db1->Kill();
                $row2=$db1->Row();
                $avin=$row2->avin;
                $avout=$row2->avout;
                
            
        //AVERAGE HOURS / DAY TIME
        //calculating day number
        $q2 = "SELECT COUNT(*) AS daynum FROM (SELECT DISTINCT DATE_FORMAT(`inout`.`date1`, \"%Y-%m-%d\") AS day
                FROM `inout`
                WHERE `no` = '$row->pno'
                    AND (`date1` >= '$dod2' AND `date1` <= '$ddo2')
                GROUP BY `date1`) AS daynum";    

        if (!$db1->Query($q2)) $db1->Kill();
                $row2=$db1->Row();
                if (!isset($row2->daynum)) $daynumber = 0;
                else $daynumber = $row2->daynum;

        $q2 = "SELECT SUM(sts) AS totalsec
          FROM (SELECT `date1` AS workedday,
                       SUM(TIME_TO_SEC(TIMEDIFF(`outtime`, `intime`))) AS sts
                  FROM `inout` AS `inout`
                 WHERE `no` = '$row->pno'
                       AND (`date1` >= '$dod2' AND `date1` <= '$ddo2')
                GROUP BY `date1`) AS x";

        if (!$db1->Query($q2)) $db1->Kill();
		$row2=$db1->Row();
                if (!isset($row2->totalsec)) $totalsec = 0;
                else $totalsec = $row2->totalsec;
                $totalhour = round($totalsec / 3600, 2);
				if ($daynumber > 0)
					$hoursperday = round($totalsec / $daynumber / 3600, 2);
				else
					$hoursperday = 0;
               
        //PERCENTAGE BEFORE 10 AFTER 8
        $q2 = "SELECT SUM(bef) AS bef10, SUM(aft) AS aft8
                  FROM (SELECT `date1`,
                               MIN(`intime`) AS min,
                               CASE WHEN MIN(`intime`) <= '10:00:00' THEN 1 ELSE 0 END AS bef,
                               MAX(`outtime`) AS max,
                               CASE WHEN MAX(`outtime`) >= '20:00:00' THEN 1 ELSE 0 END
                                  AS aft
                          FROM `inout`
                         WHERE `no` = '$row->pno'
                               AND (`date1` >= '$dod2' AND `date1` <= '$ddo2')
                        GROUP BY `date1`) AS x";

        if (!$db1->Query($q2)) $db1->Kill();
		$row2=$db1->Row();
		if ($daynumber > 0)
			$bef10p = round($row2->bef10 / $daynumber * 100, 2);
		else
			$bef10p = 0;
        if ($daynumber > 0)
			$aft8p = round($row2->aft8 / $daynumber * 100, 2);
		else
			$aft8p = 0;
                
        //AVERAGE HOURS / WEEK TIME
        //calculating week number
        $q2 = "SELECT COUNT(*) AS weeknum
               FROM (SELECT DISTINCT DATE_FORMAT(`inout`.`date1`, \"%Y/%u\") AS weekno
                      FROM `inout`
                     WHERE `no` = '$row->pno'
                           AND (`date1` >= '$dod2' AND `date1` <= '$ddo2')
                    GROUP BY `date1`) AS weekno";    

        if (!$db1->Query($q2)) $db1->Kill();
                $row2=$db1->Row();
                if (!isset($row2->weeknum))
					$weeknumber = 0;
                else
					$weeknumber = $row2->weeknum;
				if ($weeknumber > 0)
					$hoursperweek = round($totalsec / $weeknumber / 3600, 2);
				else
					$hoursperweek = 0;
                
        //AVERAGE DAYS / WEEK
		if ($weeknumber > 0)
            $daysperweek = round($daynumber / $weeknumber, 2);
		else
			$daysperweek = 0;
            
        //AVERAGE DAYS / MONTH
        //calculating month number
        $q2 = "SELECT COUNT(*) AS monthnum
		  FROM (SELECT DISTINCT DATE_FORMAT(`inout`.`date1`, \"%Y/%m\") AS monthno
          FROM `inout`
          WHERE     `no` = '$row->pno'
               AND (`date1` >= '$dod2' AND `date1` <= '$ddo2')
          GROUP BY `date1`) AS monthno";    

        if (!$db1->Query($q2)) $db1->Kill();
                $row2=$db1->Row();
                if (!isset($row2->monthnum))
					$monthnumber = 0;
                else
					$monthnumber = $row2->monthnum;
				if ($monthnumber > 0)
					$dayspermonth = round($daynumber / $monthnumber, 2);
				else
					$dayspermonth = 0;
                
        if ($rownumber == $pagenumber*64+1) {
            if ($rownumber !=1) $tablecode.="</table>\n"; 
            $pagenumber++;
            $tablecode.= $tableheader;
        }
        
        if (($totalsec != 0)||($showall=="on")) {
			$name = $row->knownas."&nbsp;".str_replace("-", "&#8209;", $row->surname);
            $tablecode.= "
			<tr>
				<td>$row->pno</td>
				<td>$name</td>
				<td>$row->started</td>
				<td>$avin</td>
				<td>$avout</td>
				<td>$bef10p</td>
				<td>$aft8p</td>         
				<td title='$totalhour hour(s) / $daynumber day(s)'>$hoursperday</td>
				<td title='$totalhour hour(s) / $weeknumber week(s)'>$hoursperweek</td>
				<td title='$daynumber day(s) / $weeknumber week(s)'>$daysperweek</td>
				<td title='$daynumber day(s) / $monthnumber month(s)'>$dayspermonth</td>
			</tr>";
        }
        else {
            $rownumber--;
        }

	unset($WorkedDays);
	unset($WorkedMonths);
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