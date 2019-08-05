<?php
require("./inc/securitycheck.inc.php");

/* optional input: startd and endd
   if not definded: query for the current month
    ../localhost/cl/totalhuser.php?cln=2432&startd=01/04/2012&endd=10/04/2012
*/

require_once("./inc/mysql.inc.php");

$dataakt=date("d/m/Y H:i:s");
$db = new CMySQL;
$db1 = new CMySQL;
$db2 = new CMySQL;
$dbvou1 = new CMySQL;
$dbvou2 = new CMySQL;
$dbvou3 = new CMySQL;
$msgdb = new CMySQL;
$dbs = new CMySQL;
$dbt = new CMySQL;

$start_date='2017-06-05';

function convert_datetime($datetime) {
  //example: 2008/02/07 12:19:32
  $values = explode(" ", $datetime);

  $dates = explode("/", $values[0]);
  $times = explode(":", $values[1]);

  $newtimestamp = mktime($times[0], $times[1], $times[2], $dates[1], $dates[2], $dates[0]);

  return $newtimestamp;
}

function valid_date1($date) {
  //example in: 07/02/2008 -> out: 2008-02-07
  $dates = explode("/", $date);
  
  if ( !isset($dates[0]) or $dates[0] > 31 )
      return 0;
  elseif ( !isset($dates[1]) or $dates[1] > 12 )
      return 0;
  elseif ( !isset($dates[2]) or $dates[2] < 2000 )
      return 0;
  
  else return "$dates[2]-$dates[1]-$dates[0]";
}

function valid_date2($date) {
  //example in: 2008-02-07 -> out: 07/02/2008
  $dates = explode("-", $date);
  
  if ( !isset($dates[0]) or $dates[0] < 2000 )
      return 0;
  elseif ( !isset($dates[1]) or $dates[1] > 12 )
      return 0;
  elseif ( !isset($dates[2]) or $dates[2] > 31 )
      return 0;
  
  else return "$dates[2]/$dates[1]/$dates[0]";
}


if(!isset($_GET['cln']))
    $nr=$_POST['cln'];
else $nr=$_GET['cln'];

if(!isset($_POST['vsha1']))
    $vsha1 = 0;
else $vsha1 = $_POST['vsha1'];

if(!isset($_POST['state']))
    $state = 0;
else $state = $_POST['state'];

if(!isset($_GET['startd']))
    $dod = "0";
elseif (valid_date1($_GET['startd']) != 0)
    $dod = valid_date1($_GET['startd']);
else $dod = "0";

if(!isset($_GET['endd']))
    $ddo = "0";
elseif (valid_date1($_GET['endd']) != 0)
    $ddo = valid_date1($_GET['endd']);
else $ddo = "0";

//if no input date
if (!$db->Open()) $db->Kill();
$q = "SELECT 
DATE_FORMAT(DATE_SUB(CURDATE(),INTERVAL (DAY(CURDATE())-1) DAY),'%Y-%m-%d') AS datefrom,
DATE_FORMAT(CURDATE(),'%Y-%m-%d') AS dateto";
     $db->Query($q);
     $r=$db->Row();
if ($dod == "0") $dod=$r->datefrom;
if ($ddo == "0") $ddo=$r->dateto;

$startd =  valid_date2($dod);
$endd =  valid_date2($ddo);

?>
    
<HEAD>
<meta HTTP-EQUIV='cache-control' CONTENT='no-cache, must-revalidate'>
<title>Clocking info</title>
<LINK REL='stylesheet' HREF='style.css' TYPE='text/css'>
</HEAD>
<body class=info>
<CENTER>  
<?php
if (!$db->Open()) $db->Kill();
$q = "
	SELECT firstname,
		   surname,
           knownas,
           paid_leave_agreed_to
	FROM nombers
	WHERE pno = $nr;
";
if (!$db->Query($q)) $db->Kill();
$row = $db->Row();
echo "<br>Clocking information for<br><br>";
echo "<font class='infoHeaderFont'>";
echo "$row->firstname $row->surname, known as $row->knownas</font><br><br>";
echo "<font size='2'><b>Payroll / clocking no $nr<br>";
echo "$startd - $endd</b></font>";
$paid_leave_agreed_to = $row->paid_leave_agreed_to;
?>
<br>
<br>
<table class='info'>
  <tr>
     <td class='FieldCaptionTD'><B>Day</B></td>
     <td class='FieldCaptionTD'><B>IN</B></td>
	 <td class='FieldCaptionTD'><B>OUT</B></td>
	 <td class='FieldCaptionTD'><B>Where</B></td>
	 <td class='FieldCaptionTD'><B>Total</B></td>
	 <td class='FieldCaptionTD'><B>Message</B></td>
	 <td class='FieldCaptionTD'><B>Checked</B></td>
	 <td class='FieldCaptionTD'><B>Difference</B></td>
	</tr>

<?php
// Punctuality calculation from $bonus start date;

$bonusstartdate = "";

$q = "select STR_TO_DATE(concat(year(now()),',',DATE_FORMAT(`dateforbonus`+INTERVAL 1 MONTH, '%m'),',01'),'%Y,%m,%d') As startyear1, STR_TO_DATE(concat(year(now()),',',DATE_FORMAT(`dateforbonus`+INTERVAL 1 MONTH, '%m'),',01'),'%Y,%m,%d')>NOW() As startyearcheck,STR_TO_DATE(concat(year(now())-1,',',DATE_FORMAT(`dateforbonus`+INTERVAL 1 MONTH, '%m'),',01'),'%Y,%m,%d') As startyear0 FROM `nombers` WHERE pno=$nr";

	  
     $db->Query($q);
     $r=$db->Row();
     $startyear1 = $r->startyear1;
	 $startyear0 = $r->startyear0;
	 $startyearcheck = $r->startyearcheck;
     
	 if ($startyearcheck == "1") {$bonusstartdate = $startyear0;} else {$bonusstartdate = $startyear1;}

$q = "SELECT DATE_SUB( DATE_SUB( CURDATE( ) , INTERVAL 1 YEAR ) , INTERVAL DAYOFWEEK( CURDATE( ) ) -3
DAY ) as datefrom,DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL DAYOFWEEK(CURDATE()-1)  DAY), \"%d/%m/%Y\") as dateto2
,CURDATE() as dateto";

	  
     $db->Query($q);
     $r=$db->Row();
     $dod2=$r->datefrom;
     $ddo2=$r->dateto;
     
   // $dod2 = $dod; 
   // $ddo2 = $ddo;



$sql = "
	SELECT `inout`.`id`,
		   `inout`.`ino`,
		   `inout`.`date1`,
		   `nombers`.`started`,
		   `nombers`.`started`>='$dod' AS s,
		   `nombers`.`dateforattendence`,
		   `nombers`.`dateforattendence`>='$dod' AS a,
		   DATE_FORMAT(`inout`.`date1`, \"%d/%m/%Y\") as d1,
		   DATE_FORMAT(`inout`.`intime`, \"%H:%i:%s\") as t1,
		   DATE_FORMAT(`inout`.`outtime`, \"%H:%i:%s\") as t2,
		   `inout`.`no`,
		   `inout`.`descin`,
		   `inout`.`descout`,
		   `inout`.`checked`,
		   `nombers`.`knownas`,
		   `nombers`.`firstname`,
		   `nombers`.`surname`,
		   `nombers`.`status`,
		   `ipaddress`.`name`,
		   sec_to_time(sum(time_to_sec(timediff(DATE_FORMAT(`inout`.`outtime`, '%H:%i:%s'),DATE_FORMAT(`inout`.`intime`, '%H:%i:%s'))))) AS td2
	FROM `inout` LEFT JOIN `nombers` ON `inout`.`no` = `nombers`.`pno`
	             LEFT JOIN `ipaddress` ON `inout`.`ipadr` = `ipaddress`.`IP`
	WHERE `nombers`.`status` = 'OK'
	  AND `inout`.`no` = '$nr'
	  AND `inout`.`date1` >= '$dod'
	  AND `inout`.`date1` <= '$ddo'
	  AND DATE_FORMAT(`inout`.`outtime`, '%H:%i:%s') <> '00:00:00'
	GROUP BY `inout`.`no`
	ORDER BY `inout`.`date1` ASC, `inout`.`intime` ASC, `inout`.`id` ASC";

if (!$dbt->Open()) $dbt->Kill();

if (!$dbt->Query($sql)) $dbt->Kill();
			$dbsummt=$dbt->Row();
			$dbst=$dbsummt->td2;

if (!$dbs->Open()) $dbs->Kill();

if (!$dbs->Query($sql)) $dbs->Kill();
			$dbsumm=$dbs->Row();

if ($dbsummt->s == "1") {$dod2 = $dbsummt->started;}
if ($dbsummt->a == "1") {$dod2 = $dbsummt->dateforattendence;}


$sql = "
SELECT `inout`.`id`,
       `inout`.`ino`,
	   `inout`.`date1`,
	   DATE_FORMAT(`inout`.`date1`, \"%d/%m/%Y\") as d1,
	   DATE_FORMAT(`inout`.`intime`, \"%H:%i:%s\") as t1,
	   DATE_FORMAT(`inout`.`outtime`, \"%H:%i:%s\") as t2,
	   `inout`.`no`,
	   `inout`.`descin`,
	   `inout`.`descout`,
	   `inout`.`checked`,
	   `nombers`.`knownas`,
	   `nombers`.`firstname`,
	   `nombers`.`surname`,
	   `nombers`.`status`,
	   `ipaddress`.`name`,
	   timediff(DATE_FORMAT(`inout`.`outtime`, '%H:%i:%s'), DATE_FORMAT(`inout`.`intime`, '%H:%i:%s')) AS td
FROM `inout`
	LEFT JOIN `nombers` ON `inout`.`no` = `nombers`.`pno`
	LEFT JOIN `ipaddress` ON `inout`.`ipadr` = `ipaddress`.`IP`
WHERE `nombers`.`status` = 'OK'
  AND `inout`.`no` = '$nr'
  AND `inout`.`date1` >= '$dod'
  AND `inout`.`date1` <= '$ddo'
ORDER BY `inout`.`date1` ASC, `inout`.`intime` ASC, `inout`.`id` ASC";

//changed 30/07/07
//$q=$sql;
$totalh=0;
$Sunday=0;
$Saturday=0;
$weekenddays=0;
$ActualRow = 0;
$DT1 = 0;
$DateOfPrevLoop = 0;
$RowsStyle = 0;
if ($db->Query($sql)) 
  {
$firstday=0;
$totald =0;
$totalh =0;
$date1save=0;
$tablestylenumber = 1;
$tablestyle = array ("DataTDGrey","DataTD");

    while ($row=$db->Row()) {

/// Summa of day
$datesumm = $row->date1;

if  ($datesumm !=$date1save) {
if ($firstday !=0) {
echo "
<tr>
     <td class='FieldCaptionTD'><B>Total in a Day</B></td>
	 <td class='FieldCaptionTD' colspan='4' align=\"right\"><B>$totald</B></td>
	 <td class='FieldCaptionTD' colspan='8' align=\"right\"><B>$td2</B></td>
	 </tr>";
}
$firstday=1;
$totald =0;
$date1save=$datesumm;
$tablestylenumber = 1-$tablestylenumber;
$RowsStyle=$tablestyle[$tablestylenumber];
}



$sql = "SELECT `inout`.`id`, `inout`.`ino`, `inout`.`date1`, DATE_FORMAT(`inout`.`date1`, \"%d/%m/%Y\") as d1, DATE_FORMAT(`inout`.`intime`, \"%H:%i:%s\") as t1, DATE_FORMAT(`inout`.`outtime`, \"%H:%i:%s\") as t2, `inout`.`no`, `inout`.`descin`, `inout`.`descout`, `inout`.`checked`, `nombers`.`knownas`, `nombers`.`firstname`, `nombers`.`surname`, `nombers`.`status`, `ipaddress`.`name`,sec_to_time(sum(time_to_sec(timediff(DATE_FORMAT(`inout`.`outtime`, '%H:%i:%s'),DATE_FORMAT(`inout`.`intime`, '%H:%i:%s'))))) As td2 FROM `inout` LEFT JOIN `nombers` ON `inout`.`no` = `nombers`.`pno` LEFT JOIN `ipaddress` ON `inout`.`ipadr` = `ipaddress`.`IP` WHERE (((`nombers`.`status`)=\"OK\")) AND `inout`.`no` = '$nr' AND `inout`.`date1`='$datesumm' AND DATE_FORMAT( `inout`.`outtime` , '%H:%i:%s' ) <> '00:00:00' group by date1
 ORDER BY `inout`.`date1` ASC, `inout`.`intime` ASC

";

if (!$dbs->Open()) $dbs->Kill();

if (!$dbs->Query($sql)) $dbs->Kill();
			$dbsumm=$dbs->Row();


	if($row->checked == "n") { $checked="";
	} else { $checked="Y"; }

		$DT1 = strtotime("$row->date1");
/*		if($DT1 <> $DateOfPrevLoop) { 
			if($RowsStyle == "DataTDGrey") { 
				$RowsStyle="DataTD"; 
			} else { 
				$RowsStyle="DataTDGrey"; 
			}
		} else { 
			$RowsStyle=$RowsStyle; 
		}
*/

		$RowsStyle=$tablestyle[$tablestylenumber]; 

		if (!$msgdb->Open()) $msgdb->Kill();
			$sql2ab = "SELECT `message` FROM `inoutmsg` WHERE `idinout`='$row->id'";
			if (!$msgdb->Query($sql2ab)) $msgdb->Kill();
			$messagesLeft=$msgdb->Row();
		if(isset($messagesLeft->message) && $messagesLeft->message <> "") { $wiad="<IMG SRC='img/spadaj.gif' WIDTH='16' HEIGHT='14' BORDER='0' title='$messagesLeft->message'>";} else { $wiad=""; }

	if($row->t2!=="00:00:00") {
		$h4=convert_datetime("$row->d1 $row->t2")-convert_datetime("$row->d1 $row->t1");
		$h3=$h4/3600; 
		$h2=$h3;
		$h1=number_format($h2,2,'.',' ');
		$d2=$row->t2;
		$totald +=$h1;
		$totalh=$totalh+$h3;

		//changed 30/07/07
		//if(date("w", strtotime("$row->date1"))==0) $Sunday=$Sunday+$h2; 
		//if(date("w", strtotime("$row->date1"))==6) $Saturday=$Saturday+$h2; 

		if(!isset($who)) {
			$who=$row->knownas; 
			$PN=$row->no; 
			$fname=$row->firstname; 
			$sname=$row->surname;
			
		}
	} else {
		//zero all vars
		$h1="IN";  
		$d2="";
				}

/// Difference of time
		$td=$row->td; 
/// Summ of difference of time
                if (!isset($dbsumm->td2)) $td2="";
                else $td2=$dbsumm->td2;

if(date("w", strtotime("$row->date1"))==0) {
			$Sunday=$Sunday+$h2;
			$DataDay="<td class='niedziela'><B>$row->d1</B></td>";
		} elseif(date("w", strtotime("$row->date1"))==6) {
			$Saturday=$Saturday+$h2;
			$DataDay="<td class='sobota'><B>$row->d1</B></td>"; 
		} else { $DataDay="<td class='$RowsStyle'><B>$row->d1</B></td>"; }
if ($td >= 0) {
    echo "
  <tr class='$RowsStyle'>$DataDay
   <td class='$RowsStyle'><B>$row->t1</B></td>
	 <td class='$RowsStyle'><B>$d2</B></td>
	 <td class='$RowsStyle'><B>$row->name</B></td>
	 <td class='$RowsStyle'><B>$h1</B></td>
	 <td class='$RowsStyle'>$wiad</td>
	 <td class='$RowsStyle'>$checked</td>
	 <td class='$RowsStyle' align=\"right\" ><B>$td</B></td>
	</tr>";}
else {

   echo "
  <tr class='$RowsStyle'>$DataDay
   <td class='$RowsStyle'><B>$row->t1</B></td>
	 <td class='$RowsStyle'><B>$d2</B></td>
	 <td class='$RowsStyle'><B>$row->name</B></td>
	 <td class='$RowsStyle'><B>$h1</B></td>
	 <td class='$RowsStyle'>$wiad</td>
	 <td class='$RowsStyle'>$checked</td>
	 <td class='$RowsStyle' align=\"right\" ><B></B></td>
	</tr>";

}


$newday =1;
   	$DateOfPrevLoop = strtotime("$row->date1");
	$ActualRow++;
	//changed 30/07/07
	//add unset for all variables
	/*
	$totalh=0;
	$Sunday=0;
	$Saturday=0;
	$weekenddays=0;
	$ActualRow = 0;
	$DT1 = 0;
	$DateOfPrevLoop = 0;
	$RowsStyle = 0;

	*/
  } 
} else {
echo " 
  <tr>
    <td class='DataTD'></td>
    <td class='DataTD' colspan='5'>SQL Error:".mysql_error()."</td>
  </tr>";
 $db->Kill();
}


$totalhDisp=number_format($totalh,2,'.',' ');
$sun=number_format($Sunday,2,'.',' ');
$sat=number_format($Saturday,2,'.',' ');

// AVERAGE ATTENDANCE

// Determine date period for attendance calculations. If person has been employed less than 52 weeks ago then the period start date is
// the Monday of the week of the employment start date, otherwise the period start date is the last Monday 52 weeks ago. The period end date is
// last Sunday. Number of weeks is (period end - period start) / 7.
if (!$db2->Open()) $db2->Kill();
$q = "SELECT date_range_emp_full_weeks($nr, 52, date_week_end(0, NULL)) AS drefw";
if (!$db2->Query($q)) $db2->Kill();
$row = $db2->Row();
$drefw_tok = explode(';', $row->drefw);
$period_start = $drefw_tok[0];
$period_end = $drefw_tok[1];
$number_of_weeks = $drefw_tok[2];

if (isset($number_of_weeks) && ($number_of_weeks > 0)) {

	// Total number of weekend days worked in the period
	$q = "
		SELECT COUNT(DISTINCT date1) AS days
		FROM `inout`
		WHERE `no` = '$nr'
		  AND date1 BETWEEN '$period_start' AND '$period_end'
		  AND WEEKDAY(date1) IN (5, 6);
	";
	if (!$db2->Query($q)) $db2->Kill();
	$row = $db2->Row();
	if (!isset($row->days))
		$total_weekend_days = 0;
	else
		$total_weekend_days = $row->days;

	// Total number of days worked in the period
	$q = "
		SELECT COUNT(DISTINCT date1) AS days
		FROM `inout`
		WHERE `no` = '$nr'
		  AND date1 BETWEEN '$period_start' AND '$period_end';
	";
	if (!$db2->Query($q)) $db2->Kill();
	$row = $db2->Row();
	if (!isset($row->days))
		$total_days = 0;
	else
		$total_days = $row->days;

	$total_weekend_days_ratio = round($total_weekend_days / $number_of_weeks, 2);
	$total_days_ratio = round($total_days / $number_of_weeks, 2);
} else {
	$total_weekend_days_ratio = 'N/A';
	$total_days_ratio = 'N/A';
}
// ---------------- End of Average attendance


// ----------------------------------------------- start of punctuality
if (!$db2->Open()) $db2->Kill();
$percent0 = "SELECT `inout`.`id` , `inout`.`no` , `inout`.`date1` , MIN( `inout`.`intime` ) AS w , MAX( `inout`.`outtime` ) AS z FROM `inout` WHERE `inout`.`no`='$nr' AND `inout`.`date1` >= '$dod' AND `inout`.`date1`<='$ddo' group by `inout`.`date1` ORDER BY `inout`.`date1` ASC";
if (!$db2->Query($percent0)) $db1->Kill();
$punctualpercent=0;
$przedczasem=0;
$poczasie=0;

$alldays=$db2->Rows();
while ($percent=$db2->Row())
	{
	if(strtotime("$percent->w") < strtotime("10:00:00"))
		{ $przedczasem++; }
	else { $poczasie++; }
			if(date("w", strtotime("$percent->date1"))==0) $weekenddays = $weekenddays + 1;
		if(date("w", strtotime("$percent->date1"))==6) $weekenddays = $weekenddays + 1;
	} 
 $punctualpercent = number_format($przedczasem / $alldays,2,'.',' ')*100;

// ---------------------------------------------------- end of punctuality
$totalh2=number_format($totalh,2,'.',' ');


		if (!$db1->Open()) $db1->Kill();
		
$punctualitytotal = punctuality ($db1,$nr,$dod2,$ddo);

// Weekend 

		
/*		
			$q2 = "SELECT count(*) As weekendnumber from (SELECT DISTINCT date1
from inout
Where
date1 >= '$dod2'
AND date1 <= '$ddo2'
AND (
WEEKDAY( date1 ) =5
OR WEEKDAY( date1 ) =6)) As x
";
 */
 
if (!$db1->Open()) $db1->Kill();
$q2 = "
SELECT count(*) AS fullweekendnumber FROM
(SELECT  DISTINCT WEEK(`date1`,3) FROM `inout` 
WHERE `date1` >= '$dod2' AND `date1` <= '$ddo2') AS x
";

 if (!$db1->Query($q2)) $db1->Kill();
		$row2=$db1->Row();
  $fullwn = $row2->fullweekendnumber; 


$q2 = "
SELECT count(*) AS weekendnumber FROM 
(SELECT DISTINCT WEEK(`date1`,3) FROM `inout`
WHERE `no` = '$nr' 
AND `date1` >= '$dod2' AND `date1` <= '$ddo2') AS x
";


 if (!$db1->Query($q2)) $db1->Kill();
		$row2=$db1->Row();
  $wn = $row2->weekendnumber; 
  
  if ($wn>1) $weektext="weeks";
  else $weektext="week";

$startmonth = date('Y')."-".date('m')."-01";

$q2 = "SELECT SUM(sts) / 3600 AS wendhours, WEEK(CURDATE(),1)-WEEK('$startmonth',1) AS wendnumbers
FROM (SELECT SUM(TIME_TO_SEC(TIMEDIFF(`outtime`, `intime`))) AS sts
      FROM `inout`
      WHERE `no` = '$nr'
      AND `date1` >= '$startmonth'
      AND `date1` <=  CURDATE()
      AND (WEEKDAY(`date1`) = 5 OR WEEKDAY(`date1`) = 6)
 GROUP BY `date1`) AS x";

 if (!$db1->Query($q2)) $db1->Kill();
    $row2=$db1->Row();
    $wendhours = round($row2->wendhours, 2);
    $wendnumbers = $row2->wendnumbers;
    if ($wendnumbers==0) $wendnumbers=1;
    $avghpermonth = round(($row2->wendhours/$wendnumbers)*4.33, 2);
    $avgdperweek = round($wendnumbers , 2);
 
 // Punctuality from Bonusstartdate
 
 $dod2=$bonusstartdate;
 
$q2 = "
SELECT SUM(punct) As punctnumber from 
(SELECT  1 As punct FROM `inout` Where 
no='$nr' 
AND date1>='2011-07-01' 
AND date1>='$dod2'
AND date1<='$ddo' 
AND intime<'10:01:00' 
Group by date1 Order by date1 ) As a 
";

//echo $q2;
    if (!$db1->Query($q2)) $db1->Kill();
		$row2=$db1->Row();
		$punctnumber = $row2->punctnumber; 
    
$q2 = "
SELECT SUM(daten) AS punctalldays from 
(SELECT 1 As daten
 FROM `inout` 
Where no='$nr' 
AND date1>='2011-07-01' 
AND date1>='$dod2'
AND date1<='$ddo' 
Group by date1) As x
";     


if (!$db1->Query($q2)) $db1->Kill();
		$row2=$db1->Row();
		$punctalldays = $row2->punctalldays; 
//echo "<br> A - $punctnumber -- $punctalldays";
 $punctualpercentyear = number_format($punctnumber /$punctalldays,2,'.',' ')*100;
echo "
<tr>
     <td class='FieldCaptionTD'><B>Total in a Day</B></td>
	  <td class='FieldCaptionTD' colspan='4' align=\"right\"><B>$totald</B></td>
	 <td class='FieldCaptionTD' colspan='8' align=\"right\"><B>$td2</B></td>
	 </tr>
	 <tr>
	 <td class='FieldCaptionTD'><B>Total</B></td>
	  <td class='FieldCaptionTD' colspan='4' align=\"right\"><B>$totalh2</B></td>
	 <td class='FieldCaptionTD' colspan='8' align=\"right\"><B>$dbst</B></td>
		 </tr>";

//$punctualitytotal = punctuality ($db1,$nr,$dod2,$ddo);
$q2="SELECT DISTINCT `nombers`.`pno`,
                DATE_FORMAT(`nombers`.`started`, \"%d/%m/%y\") AS started,
                CASE WHEN `nombers`.`started` > date_add(date_add(curdate(), interval -1 year), interval -(dayofweek(curdate()) -3) day)
                THEN DATE_FORMAT(`nombers`.`started`, \"%Y-%m-%d\")
                ELSE DATE_FORMAT(date_add(date_add(curdate(), interval -1 year), interval -(dayofweek(curdate()) -3) day), \"%Y-%m-%d\")
                END AS `dateforattendence`, date_add(curdate(), interval -(dayofweek(curdate()) -1) day) as enddate
  FROM `nombers` 
 WHERE     `nombers`.`pno` = '$nr'
";
//echo "Q1:$q<br>";
        if (!$db1->Query($q2)) $db1->Kill();
                $row2=$db1->Row();

        $dod2 = $row2->dateforattendence;
	$ddo2 = $row2->enddate;
    $q2 = "SELECT COUNT(*) AS remainderw
               FROM (SELECT DISTINCT DATE_FORMAT(`inout`.`date1`, \"%Y/%u\") AS remainderw
                      FROM `inout`
                     WHERE  (`date1` >= '$start_date' and `date1`<='ddo2')
                    GROUP BY `date1`) AS remainderw";    
        //echo "Q6:$q2<br>";

        if (!$db1->Query($q2)) $db1->Kill();
                $row2=$db1->Row();
                if (!isset($row2->remainderw)) $remainderw = 0;
                else $remainderw = $row2->remainderw;

    $remainderw = max($remainderw, '0');
    if ($remainderw > '0'&& $remainderw<='52')
        {
	$q2 = "SELECT COUNT(*) AS weeknum
               FROM (SELECT DISTINCT DATE_FORMAT(`inout`.`date1`, \"%Y/%u\") AS weekno
                      FROM `inout`
                     WHERE (`date1` >= '$dod2' AND `date1` <= '$ddo2')
                    GROUP BY `date1`) AS weekno";    
        //echo "Q6:$q2<br>";
        if (!$db1->Query($q2)) $db1->Kill();
                $row2=$db1->Row();
                if (!isset($row2->weeknum)) $weeknumber = 0;
                else $weeknumber = $row2->weeknum;
        $q2 = "SELECT date_add('$start_date',interval -52 week) AS startold;
	";    
        if (!$db1->Query($q2)) $db1->Kill();
                $row2=$db1->Row();
                if (!isset($row2->startold)) $startold = 0;
                else $startold = $row2->startold;
        //echo "Q6:$q2<br>";
    
        $q2 = "SELECT COUNT(*) AS daynum FROM (SELECT DISTINCT DATE_FORMAT(`inout`.`date1`, \"%Y-%m-%d\") AS day
                FROM `inout`
                WHERE `no` = '$nr'
                AND (`date1` >= '$startold' AND `date1` < '$start_date')
                AND (   WEEKDAY(`date1`) = 5
                  OR WEEKDAY(`date1`) = 6)
                GROUP BY `date1`) AS daynum;";    
        if (!$db1->Query($q2)) $db1->Kill();
                $row2=$db1->Row();
                if (!isset($row2->daynum)) $daynumberold = 0;
                else $daynumberold = $row2->daynum;
        //echo "Q6:$q2<br>";

        $q2 = "SELECT COUNT(*) AS weeknum
               FROM (SELECT DISTINCT DATE_FORMAT(`inout`.`date1`, \"%Y/%u\") AS weekno
                      FROM `inout`
                     WHERE `no` = '$nr' and 
	        (`date1` >= '$startold' AND `date1` < '$start_date')
                    GROUP BY `date1`) AS weekno;";    
        //echo "Q6:$q2<br>";

        if (!$db1->Query($q2)) $db1->Kill();
                $row2=$db1->Row();
                if (!isset($row2->weeknum)) $weekold = 0;
                else $weekold = $row2->weeknum;

        $q2 = "SELECT COUNT(*) AS daynum FROM (SELECT DISTINCT DATE_FORMAT(`inout`.`date1`, \"%Y-%m-%d\") AS day
                FROM `inout`
                WHERE `no` = '$nr'
                AND (`date1` >= '$start_date' AND `date1` <= '$ddo2')
                AND (   WEEKDAY(`date1`) = 5
                  OR WEEKDAY(`date1`) = 6)
                GROUP BY `date1`) AS daynum;";    
        //echo "Q6:$q2<br>";

        if (!$db1->Query($q2)) $db1->Kill();
                $row2=$db1->Row();
                if (!isset($row2->daynum)) $daynumbernew = 0;
                else $daynumbernew = $row2->daynum;

        $q2 = "SELECT COUNT(*) AS weeknum
               FROM (SELECT DISTINCT DATE_FORMAT(`inout`.`date1`, \"%Y/%u\") AS weekno
                      FROM `inout`
                     WHERE (`date1` >= '$start_date' AND `date1` <= '$ddo2')
                    GROUP BY `date1`) AS weekno;";    
        //echo "Q6:$q2<br>";

        if (!$db1->Query($q2)) $db1->Kill();
                $row2=$db1->Row();
                if (!isset($row2->weeknum)) $weeknew = 0;
                else $weeknew = $row2->weeknum;

    if ($weekold == '0'){
        $daynumberold=0;
        $weekold=1;
        }
    $weeknumber = max(0,$weeknumber-1);
    $daysperweek = round(1.0*(($daynumberold/$weekold)*(($weeknumber-$remainderw)/$weeknumber))+(($daynumbernew/$weeknew)*($remainderw/$weeknumber)),2);

        }    



echo "
</table>
<BLOCKQUOTE><H3><B>Total hours in the period</B></H3><FONT COLOR='#FF0000'><H1>$totalhDisp</H1></FONT>

<BR><B>Average Weekly Attendance - Weekend Days: $total_weekend_days_ratio</B>
<BR><B>Average Weekly Attendance - All Days including Days Off: $total_days_ratio</B>

<BR><B>Punctuality (for staff on old pay scale) : $punctualpercent%</B></BLOCKQUOTE>";
echo "<B>Pre 10am/Post 8pm attendance: $punctualitytotal%</B> (Minimum attendance: 100%)<br>";


$q2 = "SELECT if (started>(curdate() - interval weekday(curdate())+1 day -interval 52 week),started,curdate() - interval weekday(curdate())+1 day -interval 52 week ) as started from nombers where pno='$nr'";
if (!$db1->Query($q2)) $db1->Kill();
	$row2=$db1->Row();
	$started2 = $row2->started; 

$q2 = "SELECT sum(time_to_sec(timediff(`outtime`,`intime`))) as totalsec from `inout` where `no`='$nr' and (`date1`>=(curdate() - interval weekday(curdate())+1 day -interval 52 week) and `date1`<=(curdate()-interval weekday(curdate())+1 day))";
if (!$db1->Query($q2)) $db1->Kill();
	$row2=$db1->Row();
	$totalsec = $row2->totalsec; 

$q2 = "SELECT datediff((curdate()-interval weekday(curdate())+1 day),'$started2') as days";
if (!$db1->Query($q2)) $db1->Kill();
	$row2=$db1->Row();
	$days = $row2->days; 

$avg = round (($totalsec *7.0) / (3600*$days),2);
			
echo "</BR></BR><B>Average hours per week:</B> $avg </BR></BR>";

echo"<BR><B>*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*</B><BR><BR>";

// Get last uploaded voucher data
if (!$dbvou1->Open()) $dbvou1->Kill();
$q = "
	SELECT `month_id` AS lastuploadmonth FROM `voucherslips`
	WHERE load_id = (SELECT MAX(`load_id`) FROM `voucherslips` WHERE `no` = '$nr')
	  AND `no` = '$nr'
";
$dbvou1->Query($q);
$r = $dbvou1->Row();

if (!isset($r->lastuploadmonth)) {
    echo "<b>There is no additional information for you in the database.</b><br>";
} else {
    $lastmonth = substr("$r->lastuploadmonth", 0, 2);
    $lastyear = substr("$r->lastuploadmonth", 2, 4);

    //Setting last month text
    switch ($lastmonth) {
        case '01': $monthtxt = 'January'; break;
        case '02': $monthtxt = 'February'; break;
        case '03': $monthtxt = 'March'; break;
        case '04': $monthtxt = 'April'; break;
        case '05': $monthtxt = 'May'; break;
        case '06': $monthtxt = 'June'; break;
        case '07': $monthtxt = 'July'; break;
        case '08': $monthtxt = 'August'; break;
        case '09': $monthtxt = 'September'; break;
        case '10': $monthtxt = 'October'; break;
        case '11': $monthtxt = 'November'; break;
        case '12': $monthtxt = 'December'; break;
        default: $monthtxt = '';
    }

    if (!$dbvou2->Open()) $dbvou2->Kill();
	$q = "
		SELECT * FROM `voucherslips`
		WHERE `no` = '$nr'
		  AND `month_id` = '$r->lastuploadmonth'";
	$dbvou2->Query($q);
	$r = $dbvou2->Row();
    
    echo "<b>Payroll information last updated <FONT COLOR='#FF0000'>$monthtxt, 20$lastyear</FONT></b><br><br>";
     
    // Vouchers Entitlement     
    if ($r->vouchers != 0)
        echo "<b>Your voucher entitlement for $monthtxt is <FONT COLOR='#FF0000'>&pound; $r->vouchers.</FONT></b><br><br>";
    
    // Vouchers Entitlement to PDF download
    if (!$dbvou3->Open()) $dbvou3->Kill();
	$q = "
		SELECT `no`, `month_id`, `vouchers_sha1code` FROM `voucherslips`
		WHERE `no` = '$nr'
			AND `vouchers_state` = '1'
		ORDER BY `load_id` DESC";
	$dbvou3->Query($q);
	$rowsnumber = $dbvou3->Rows();
        
    if ($rowsnumber > 0) {
        $voucherselect = "\n<select class='Select' name='vsha1'>\n";
        
        while ($r2=$dbvou3->Row()) {
            $voucherselect .="<option value='$r2->vouchers_sha1code'>$r2->month_id</option>\n";        
        }
        $voucherselect .= "</select>\n";
        
        echo "
        <form action='' method='post' name='ed_czl'>
        <table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
            <tr>
                <td class='FieldCaptionTD'>Download your voucherslip for the following month: $voucherselect
                <input name='state' type='hidden' value='1'>
                <input name='cln' type='hidden' value='$nr'>
                <input name='startd' type='hidden' value='$startd'>
                <input name='endd' type='hidden' value='$endd'>
                <input class='Button' name='Update' type='submit' value='OK'></td>
            </tr>
        </table>
        </form>";
    }
	
	
	// PAID LEAVE
	
	$q1 = "SELECT month(curdate()) as month, year(curdate()) as year";
	if (!$db1->Query($q1)) $db1->Kill();
	$row1 = $db1->Row();
	$month = $row1->month;
	$year = $row1->year;
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

	if ($r->cat != 'Casual') {
		$paid_leave_accrued = round($r->EinDays, 1);
	} else {
		$paid_leave_accrued = round($r->EinWeeks, 1);
	}
	$paid_leave_unit = $r->unit;
    $paid_leave_taken = round($r->taken, 1);
    $paid_leave_left = round ($r->left, 1);
    $weekend_days_to_date = round($r->wendsTD);
    $weekend_days_goal = round($r->NOneed);

    // hours and days worked are summed up until yesterday, so there would be no half-workdays included
    // which might distort the numbers
	$q1 = "
		SELECT total_hours_worked($nr, '$current_leave_year_start', DATE_SUB(CURDATE(), INTERVAL 1 DAY)) AS thw,
			   total_days_worked($nr, '$current_leave_year_start', DATE_SUB(CURDATE(), INTERVAL 1 DAY)) AS tdw;
	";
	if (!$db1->Query($q1)) $db1->Kill();
	$row1 = $db1->Row();
	$current_year_hours = $row1->thw;
	$current_year_daily_avg = round($current_year_hours / $row1->tdw, 2);

	$q1 = "
		SELECT total_hours_worked($nr, '$previous_leave_year_start', '$previous_leave_year_end') AS thw,
			   total_days_worked($nr, '$previous_leave_year_start', '$previous_leave_year_end') AS tdw;
	";
	if (!$db1->Query($q1)) $db1->Kill();
	$row1 = $db1->Row();
	$previous_year_hours = $row1->thw;
	$previous_year_daily_avg = round($previous_year_hours / $row1->tdw, 2);

	echo "<font size='3'><b>Paid leave</b></font><br><br>";
	echo "<b>Current leave year: 1 December $current_leave_year_start_year - 30 November $current_leave_year_end_year</b><br><br>";

    echo "<b>Paid leave ";
    if ($paid_leave_agreed_to)
        echo "agreed to";
    else
        echo "accrued";
    echo ": <font color='#FF0000'>$paid_leave_accrued</font> $paid_leave_unit</b><br>";
	echo "<b>Paid leave taken: <font color='#FF0000'>$paid_leave_taken</font> $paid_leave_unit</b><br>";
	echo "<b>Paid leave remaining: <font color='#FF0000'>$paid_leave_left</font> $paid_leave_unit</b><br><br>";

	echo "<b>Total hours worked in current leave year: <font color='#FF0000'>$current_year_hours</font></b><br>";
	if ($r->cat != 'Casual')
		echo "<b>Average daily hours in current leave year: <font color='#FF0000'>$current_year_daily_avg</font></b><br><br>";
	echo "<b>Total hours worked in previous leave year: <font color='#FF0000'>$previous_year_hours</font></b><br>";
	if ($r->cat != 'Casual') {
		echo "<b>Average daily hours in previous leave year: <font color='#FF0000'>$previous_year_daily_avg</font></b><br><br>";	
		echo "If by the end of November you have not taken your full entitlement of paid annual leave you may, at management's discretion, be entitled to an ex-gratia payment equivalent to your pay for the extra days you have worked. This payment will be added to your $current_leave_year_end_year November pay.";
	}


	// WEEKEND BONUS

	echo "<br><br><font size='3'><b>Annual weekend bonus</b></font><br><br>";
	
	if ($r->bonustype == "NONE" || $r->bonustype == "BHM") {
		echo "You are not eligible for a weekend bonus.<br><br>";
		
		// new voucher scheme from 2018
		$q = "SELECT is_eligible_for_2018_voucher_scheme($nr) AS yes;";	
		if (!$db1->Query($q)) $db1->Kill();
		$row3 = $db1->Row();
		if ($row3->yes == 1) {		
			echo "<b>Weekend days for vouchers entitlement</b><br><br>";
			echo "<b>Your bonus year runs from $r->from to $r->to.</b><br><br>";
			echo "<b>Total weekend days to date: <FONT COLOR='#FF0000'>$weekend_days_to_date</FONT></b><br>";
			echo "<b>Punctuality from start of bonus year : <FONT COLOR='#FF0000'>$punctualpercentyear%</FONT></b><br>";
		}
	} else {
		echo "<b>Your bonus year runs from $r->from to $r->to.</b><br><br>";
		echo "<b>Total weekend days to date: <FONT COLOR='#FF0000'>$weekend_days_to_date</FONT></b><br>";
	//  echo "<b>Monthly weekend average to date: <FONT COLOR='#FF0000'>$r->AVTD</FONT></b><br>";
		echo "<b>Weekend days needed to reach: <FONT COLOR='#FF0000'>$weekend_days_goal</FONT></b><br>";
	//  echo "<b>Monthly average necessary: <FONT COLOR='#FF0000'>$r->AVneed</FONT></b><br><br>";
	
	echo "<b>Punctuality from start of bonus year : <FONT COLOR='#FF0000'>$punctualpercentyear%</FONT></b><br>";
	}
}

echo "
<BR><A HREF='#' onclick=\"window.close();\"><IMG SRC='img/end.jpg' WIDTH='22' BORDER='0' ALT='Close this window'></A>
</center>
</td><td>&nbsp;</td></tr>
</table>";

if ($state == 1) {
    echo "<script language='javascript'>window.location=\"voucherpdf.php?vsha1=$vsha1\"</script>";
}

echo "
</BODY>
</HTML>
";


function punctuality($db1,$cln,$dod2,$ddo2) {
	$q2 = "SELECT count(*) As daynumber from (SELECT DISTINCT date1
FROM `inout` 
WHERE no ='$cln'
AND 
date1 >= '$dod2'
AND date1 <= '$ddo2'
) As x
";

//echo $q2."<br>";
 if (!$db1->Query($q2)) $db1->Kill();
		$row2=$db1->Row();
 $daynumber=   $row2->daynumber;
$q2 = "
SELECT DISTINCT date1, min(intime)
FROM `inout` 
WHERE no ='$cln'
AND 
date1 >= '$dod2'
AND date1 <= '$ddo2'
AND
`intime`<'10:01:00'
 group by date1

";
//echo $q2." - ".$daynumber;
    if (!$db1->Query($q2)) $db1->Kill();
		$row2=$db1->Row();
		$rows2=$db1->Rows();
                if ($daynumber == 0) $punctuality10 = 0; else $punctuality10 = round($rows2/ $daynumber,2)*100;

$q2 = "
SELECT DISTINCT date1, max(outtime)
FROM `inout` 
WHERE no ='$cln'
AND 
date1 >= '$dod2'
AND date1 <= '$ddo2'
AND
`outtime`>'20:00:00'
 group by date1

";
//echo $q2;
    if (!$db1->Query($q2)) $db1->Kill();
		$row2=$db1->Row();
		$rows2=$db1->Rows();

    if ($daynumber == 0) $punctuality20 = 0; else $punctuality20 = round($rows2/ $daynumber,2)*100;   

/*  
if ($lv10=="1") {
if ($dir10 == "a" && $punctuality10<$limit10*100)  $punctuality10="&nbsp;"; 
if ($dir10 == "b" && $punctuality10>$limit10*100)  $punctuality10="&nbsp;"; 
}

if ($lv20=="1") {
if ($dir20 == "a" && $punctuality20<$limit20*100)  $punctuality20="&nbsp;"; 
if ($dir20 == "b" && $punctuality20>$limit20*100)  $punctuality20="&nbsp;";  
}
	    
*/

if ($punctuality10!="&nbsp;" || $punctuality20!="&nbsp;") {    
$punctualitytotal = $punctuality10 + $punctuality20;
}

return ($punctualitytotal);

}



?>