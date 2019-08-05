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
$dir = $_GET['dir'];
$title = "Average 0.75 weekend days per week required: non-qualifiers below 0.75";

$tablecode = "";

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
			<th>Weekend days</th>
		</tr>
";

$db = new CMySQL;
$db1 = new CMySQL;

if (!$db->Open()) $db->Kill();
if (!$db1->Open()) $db1->Kill();

$filter = "";
switch ($DepGroup)
{
	case 0:
		$filter = "AND  `emplcat`.catname_staff Like '%'";
		break;
	case 1:
		$filter = " AND DATEDIFF( now( ) , `nombers`.`started` ) < 365 ";
		break;
	case 2:
		$filter = " AND DATEDIFF( now( ) , `nombers`.`started` ) >= 365 ";
		break;
	case 3:
		$filter = "AND  `emplcat`.catname_staff Like 'GA'";
		break;
	case 4:
		$filter = "AND  `emplcat`.catname_staff Like 'GMA'";
		break;
	case 5:
		$filter = "AND  (`emplcat`.catname_staff Like 'GA' OR `emplcat`.catname_staff Like 'GMA')";
		break;
	case 6:
		$filter=" AND  `emplcat`.catname_staff Like 'SA'";
		break;
	case 7:
		$filter=" AND  (`emplcat`.catname_staff Like 'GA' OR `emplcat`.catname_staff Like 'GMA'  OR `emplcat`.catname_staff Like 'buyer')";
		break;
	default:
		$filter = "AND  `emplcat`.catname_staff Like '%'";
		break;
}
                
if ($dir != "1") {$dir = "0";};
$weekendfilter = "weekendrequired='$dir'";  
$q2 = "UPDATE `defaultvalues` SET `value` = '$dir' WHERE `code` ='weekendrequired' LIMIT 1";
  
if (!$db1->Query($q2)) $db1->Kill();
  
$q = "
SELECT DISTINCT `nombers`.`pno` , `nombers`.`surname` , `nombers`.`firstname` , `nombers`.`knownas` , `nombers`.`cat` ,started, `nombers`.`textperson` ,`nombers`.`sign` ,DATE_FORMAT( `nombers`.`started` , \"%d/%m/%Y\" ) AS d1,`nombers`.`dateforattendence`, DATE_FORMAT( `nombers`.`dateforattendence` , \"%d/%m/%Y\" ) AS dateforattendence2, `emplcat`.catname,  `emplcat`.catname_staff,`nombers`.`started`>='$dod' As s,`nombers`.`dateforattendence`>='$dod' As a FROM (`nombers` CROSS JOIN  `staffdetails` ON `nombers`.`pno` = `staffdetails`.`no`) INNER JOIN `emplcat` ON `nombers`.`cat`= `emplcat`.catozn WHERE `nombers`.`status` = 'OK'
AND  `nombers`.`pno` <> '5'
AND  `nombers`.`pno` <> '555'
$filter
AND (
`staffdetails`.`decision` <> '4'
AND `staffdetails`.`decision` <> '3'
OR `staffdetails`.`decision` IS NULL
)
AND `nombers`.`cat`<>'c'
AND $weekendfilter 
AND (LOCATE('.',`cattoname`)<>0)
ORDER BY `nombers`.`knownas` ASC, `nombers`.`surname` ASC
";

if ($db->Query($q)) {
	while ($row=$db->Row()) {
		$dod2 = $dod; 
		$ddo2 = $ddo;

		if ($row->s == "1") {$dod2 = $row->started;}
		if ($row->a == "1") {$dod2 = $row->dateforattendence;}

		$q2 = "
		SELECT COUNT(*) AS weekendnumber
		FROM (SELECT DISTINCT WEEK(`date1`, 3)
			  FROM `inout`
			  WHERE `no` = '$row->pno' AND `date1` >= '$dod2' AND `date1` <= '$ddo2') AS x";

		if (!$db1->Query($q2)) $db1->Kill();
		$row3 = $db1->Row();
		$wn = $row3->weekendnumber;
		
		$q2 = "
		SELECT COUNT(*) AS wn2,
			   (COUNT(*) / ($wn)) AS wenddaynumberweek,
		       SUM(sts) / COUNT(*) / 3600 AS avgtime2
		FROM (
			SELECT 1 AS b,
			       SUM(TIME_TO_SEC(TIMEDIFF(`outtime`, `intime`))) AS sts
			FROM `inout` AS `inout`
			WHERE `no` = '$row->pno'
			  AND (`date1` >= '$dod2'
			  AND `date1` <= '$ddo2'
			  AND (WEEKDAY(`date1`) = 5 OR WEEKDAY(`date1`) = 6))
			GROUP BY `date1`) AS x
		GROUP BY b";

		if (!$db1->Query($q2)) $db1->Kill();
		$row2=$db1->Row();

		if(!isset($row2->wn2))
			$wn2 = 0;
		else
			$wn2 = $row2->wn2;
		if(!isset($row2->wenddaynumberweek))
			$row2wenddaynumberweek = 0;
		else
			$row2wenddaynumberweek = $row2->wenddaynumberweek;

		if (round($row2wenddaynumberweek,2) < 0.75) {
			$name = $row->knownas."&nbsp;".str_replace("-", "&#8209;", $row->surname);
			$tablecode .= "
			<tr>
				<td>$row->pno</td>
				<td>$name</td>
				<td>".round($row2wenddaynumberweek,2)."</td>
			</tr>";
		}
	}
	unset($WorkedDays);
	unset($WorkedMonths);
}
$creationDate = date("D, d M Y H:i:s");
echo "
$tableheader $tablecode</table>

<div id='reportcreationdate'>
	Report created at $creationDate
</div>
</div> <!-- reportcontainer -->
";
?>