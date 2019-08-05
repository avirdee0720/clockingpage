<HTML>
<HEAD>
<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
uprstr($PU,90);
$dataakt=date("d/m/Y H:i:s");
$msgdb = new CMySQL;

?>
<meta HTTP-EQUIV='cache-control' CONTENT='no-cache, must-revalidate'>
<link rel=stylesheet type=text/css href="hs.css">
<LINK REL='stylesheet' HREF='style/multipads/style.css' TYPE='text/css'>

</HEAD>

<body class=PageBODY bgcolor=#FFFFFF topmargin=0 leftmargin=0 marginwidth=0 marginheight=0 text=#000000 link=#0000FF vlink=#0000FF alink=#FF0000>
<CENTER>

<?php
list($day, $month, $year) = explode("/",$_GET['startd']);
$dod = "$year-$month-$day";
list($day1, $month1, $year1) = explode("/",$_GET['endd']);
$ddo= "$year1-$month1-$day1";
$sd=$_GET['startd'];
$ed=$_GET['endd'];
$DepGroup=$_GET['_grp'];
$DepGroupUpper=strtoupper($_GET['_grp']);
$title="Average attendance Weekend days (Sat-Sun) Transitional<br/>Do not use after: 03/06/2018";
$showall=$_GET['showall'];

$tablecode = "";
$rownumber = 0;
$pagenumber = 0;
$start_date='2017-06-05';
$db4 = new CMySQL; //other
if (!$db4->Open()) $db4->Kill();

        $q2 = "SELECT dayname('$dod') AS startdow, dayname('$ddo') as enddow";    
        //echo "Q3:$q2<br>";
        if (!$db4->Query($q2)) $db4->Kill();
                $row2=$db4->Row();
                if (!isset($row2->startdow)) $startdow = '';
                else $startdow = $row2->startdow;
                if (!isset($row2->enddow)) $enddow = '';
                else $enddow = $row2->enddow;

// TO DO: count how many months to work out hours per month
echo "

<font class='FormHeaderFont'>$title <BR>Dates: $startdow $sd until $enddow $ed inclusive<br></font>
<table WIDTH=70% bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >

";


$tableheader = "
  <table WIDTH=70% bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >
  <tr>
     <td class='FieldCaptionTD'><B>ClNo.</B></td>
     <td class='FieldCaptionTD'><B>&nbsp;Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</B></td>
     <td class='FieldCaptionTD' align=\"center\"><B>Started</B></td>
     <td class='FieldCaptionTD' align=\"center\"><B>Start time</B></td>
     <td class='FieldCaptionTD' align=\"center\"><B>Leaving time</B></td>
     <td class='FieldCaptionTD' align=\"center\"><B>Before 10am (%)</B></td>
     <td class='FieldCaptionTD' align=\"center\"><B>After 8pm (%)</B></td>
     <td class='FieldCaptionTD' align=\"center\"><B>Hours per day</B></td>
     <td class='FieldCaptionTD' align=\"center\"><B>Hours per week</B></td>
     <td class='FieldCaptionTD' align=\"center\"><B>Days per week</B></td>
     <td class='FieldCaptionTD' align=\"center\"><B>Days per month</B></td>
  </tr>";

if(!isset($sort)) $sort=1;
if(!isset($showall)) $showall="off";

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


$db1 = new CMySQL; //instance of the object to inside the loop
$db2 = new CMySQL; //saturdays
$db3 = new CMySQL; //sundays

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

$q="SELECT DISTINCT `nombers`.`pno`,
                `nombers`.`knownas`,
                `nombers`.`firstname`,
                `nombers`.`surname`,
                DATE_FORMAT(`nombers`.`started`, \"%d/%m/%y\") AS started,
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
//echo "Q1:$q<br>";

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
                    AND (WEEKDAY(`date1`) = 5 OR WEEKDAY(`date1`) = 6)
                GROUP BY `date1`) AS x";    
        //echo "Q2:$q2<br>";
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
                AND (   WEEKDAY(`date1`) = 5
                  OR WEEKDAY(`date1`) = 6)
                GROUP BY `date1`) AS daynum";    
        //echo "Q3:$q2<br>";
        if (!$db1->Query($q2)) $db1->Kill();
                $row2=$db1->Row();
                if (!isset($row2->daynum)) $daynumber = 0;
                else $daynumber = $row2->daynum;
	//calcutating total days in selected range
        $q2 = "SELECT COUNT(*) AS daynum FROM (SELECT DISTINCT DATE_FORMAT(`inout`.`date1`, \"%Y-%m-%d\") AS day
                FROM `inout`
                WHERE (`date1` >= '$dod2' AND `date1` <= '$ddo2')
                AND (   WEEKDAY(`date1`) = 5
                  OR WEEKDAY(`date1`) = 6)
                GROUP BY `date1`) AS daynum";    
        //echo "Q3:$q2<br>";
        if (!$db1->Query($q2)) $db1->Kill();
                $row2=$db1->Row();
                if (!isset($row2->daynum)) $totaldaynumber = 0;
                else $totaldaynumber = $row2->daynum;

        $q2 = "SELECT SUM(sts) AS totalsec
          FROM (SELECT `date1` AS workedday,
                       SUM(TIME_TO_SEC(TIMEDIFF(`outtime`, `intime`))) AS sts
                  FROM `inout` AS `inout`
                 WHERE `no` = '$row->pno'
                       AND (`date1` >= '$dod2' AND `date1` <= '$ddo2')
                       AND (   WEEKDAY(`date1`) = 5
                            OR WEEKDAY(`date1`) = 6)
                GROUP BY `date1`) AS x";
        //echo "Q4:$q2<br>";
        if (!$db1->Query($q2)) $db1->Kill();
		$row2=$db1->Row();
                if (!isset($row2->totalsec)) $totalsec = 0;
                else $totalsec = $row2->totalsec;
                $totalhour = round($totalsec / 3600, 2);
                if ($daynumber > 0)
                    $hoursperday=round($totalsec / $daynumber / 3600, 2);
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
                               AND ( WEEKDAY(`date1`) = 5
                                    OR WEEKDAY(`date1`) = 6)
                        GROUP BY `date1`) AS x";
        //echo "Q5:$q2<br>";
        if (!$db1->Query($q2)) $db1->Kill();
        $row2=$db1->Row();
        if ($daynumber > 0) {
            $bef10p=round($row2->bef10 / $daynumber * 100, 2);
            $aft8p=round($row2->aft8 / $daynumber * 100, 2);
        }
        else {
            $bef10p = "-";
            $aft8p = "-";
        }
                
        //AVERAGE HOURS / WEEK TIME
        //calculating week number
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
                $hoursperweek=round($totalsec / $weeknumber / 3600, 2);

        //calculating total week number in range
        $q2 = "SELECT COUNT(*) AS weeknum
               FROM (SELECT DISTINCT DATE_FORMAT(`inout`.`date1`, \"%Y/%u\") AS weekno
                      FROM `inout`
                     WHERE  (`date1` >= '$dod2' AND `date1` <= '$ddo2')
                    GROUP BY `date1`) AS weekno;";    
        //echo "Q6:$q2<br>";

        if (!$db1->Query($q2)) $db1->Kill();
                $row2=$db1->Row();
                if (!isset($row2->weeknum)) $totalweeknumber = 0;
                else $totalweeknumber = $row2->weeknum;
                $hoursperweek=round($totalsec / $weeknumber / 3600, 2);
                
        //AVERAGE DAYS / WEEK
    	    //old one
	    $daysperweek = round($daynumber / $totalweeknumber, 2);
	        //new one
        $q2 = "SELECT COUNT(*) AS remainderw
               FROM (SELECT DISTINCT DATE_FORMAT(`inout`.`date1`, \"%Y/%u\") AS remainderw
                      FROM `inout`
                     WHERE  (`date1` >= '$start_date' and `date1`<='$ddo2')
                    GROUP BY `date1`) AS remainderw";    
        //echo "Q6:$q2<br>";

        if (!$db1->Query($q2)) $db1->Kill();
                $row2=$db1->Row();
                if (!isset($row2->remainderw)) $remainderw = 0;
                else $remainderw = $row2->remainderw;
	$remainderw = max($remainderw, '0');
	if ($remainderw > '0'&& $remainderw<='52')
	    {

        $q2 = "SELECT date_add('$start_date',interval -52 week) AS startold;
		";    
        if (!$db1->Query($q2)) $db1->Kill();
                $row2=$db1->Row();
                if (!isset($row2->startold)) $startold = 0;
                else $startold = $row2->startold;
        //echo "Q6:$q2<br>";
	
        $q2 = "SELECT COUNT(*) AS daynum FROM (SELECT DISTINCT DATE_FORMAT(`inout`.`date1`, \"%Y-%m-%d\") AS day
                FROM `inout`
                WHERE `no` = '$row->pno'
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
                     WHERE `no` = '$row->pno' and 
			    (`date1` >= '$startold' AND `date1` < '$start_date')
                    GROUP BY `date1`) AS weekno;";    
        //echo "Q6:$q2<br>";

        if (!$db1->Query($q2)) $db1->Kill();
                $row2=$db1->Row();
                if (!isset($row2->weeknum)) $weekold = 0;
                else $weekold = $row2->weeknum;

        $q2 = "SELECT COUNT(*) AS daynum FROM (SELECT DISTINCT DATE_FORMAT(`inout`.`date1`, \"%Y-%m-%d\") AS day
                FROM `inout`
                WHERE `no` = '$row->pno'
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
	echo "<!--weekold $weekold daynumberold $daynumberold start_date $start_date startold $startold ddo2 $ddo2 dod2 $dod2 remainder $remainderw daynumbernew $daynumbernew weeknew $weeknew totalweek $totalweeknumber formula (($daynumberold/$weekold)*(($weeknumber-$remainderw)/$weeknumber))+(($daynumbernew/$weeknew)*($remainderw/$weeknumber)) pno $row->pno <br/>-->";
	    }    



    
        //AVERAGE DAYS / MONTH
        //calculating month number
        $q2 = "SELECT COUNT(*) AS monthnum
  FROM (SELECT DISTINCT DATE_FORMAT(`inout`.`date1`, \"%Y/%m\") AS monthno
          FROM `inout`
         WHERE   (`date1` >= '$dod2' AND `date1` <= '$ddo2')
        GROUP BY `date1`) AS monthno";    
        //echo "Q7:$q2<br>";
        if (!$db1->Query($q2)) $db1->Kill();
                $row2=$db1->Row();
                if (!isset($row2->monthnum)) $monthnumber = 0;
                else $monthnumber = $row2->monthnum;
                $dayspermonth=round($daynumber / $monthnumber, 2);
                
        if ($rownumber == $pagenumber*64+1) {
            if ($rownumber !=1) $tablecode.="</table>\n"; 
            $pagenumber++;
            $tablecode.= $tableheader;
        }
        
        if (($totalsec != 0)||($showall=="on")) {	
                if ($rownumber%2 == 0) {
                    $tablecode.= "<TR>
                    <td class='DataTD'>$row->pno</td>            
                    <td class='DataTD'>$row->knownas $row->surname</td>
                    <td class='DataTD'><B>$row->started</B></td>
                    <td class='DataTD'><B>$avin</B></td>
                    <td class='DataTD'><B>$avout</B></td>
                    <td class='DataTD'><B>$bef10p</B></td>
                    <td class='DataTD'><B>$aft8p</B></td>         
                    <!-- <td class='DataTD'><B>$totalhour/$daynumber=$hoursperday</B></td>
                    <td class='DataTD'><B>$totalhour/$weeknumber=$hoursperweek</B></td>
                    <td class='DataTD'><B>$daynumber/$weeknumber=$daysperweek</B></td>
                    <td class='DataTD'><B>$daynumber/$monthnumber=$dayspermonth</B></td> -->
                    <td class='DataTD'><B title='$totalhour hour(s) / $daynumber day(s)'>$hoursperday</B></td>
                    <td class='DataTD'><B title='$totalhour hour(s) / $weeknumber week(s)'>$hoursperweek</B></td>
                    <td class='DataTD'><B>$daysperweek</B></td>
                    <td class='DataTD'><B title='$daynumber day(s) / $monthnumber month(s)'>$dayspermonth</B></td>
                    </TR>";
                }
                else {
                    $tablecode.= "<TR>
                    <td class='DataTDGrey'>$row->pno</td>            
                    <td class='DataTDGrey'>$row->knownas $row->surname</td>
                    <td class='DataTDGrey'><B>$row->started</B></td>
                    <td class='DataTDGrey'><B>$avin</B></td>
                    <td class='DataTDGrey'><B>$avout</B></td>
                    <td class='DataTDGrey'><B>$bef10p</B></td>
                    <td class='DataTDGrey'><B>$aft8p</B></td>         
                    <!-- <td class='DataTDGrey'><B>$totalhour/$daynumber=$hoursperday</B></td>
                    <td class='DataTDGrey'><B>$totalhour/$weeknumber=$hoursperweek</B></td>
                    <td class='DataTDGrey'><B>$daynumber/$weeknumber=$daysperweek</B></td>
                    <td class='DataTDGrey'><B>$daynumber/$monthnumber=$dayspermonth</B></td> -->
                    <td class='DataTDGrey'><B title='$totalhour hour(s) / $daynumber day(s)'>$hoursperday</B></td>
                    <td class='DataTDGrey'><B title='$totalhour hour(s) / $weeknumber week(s)'>$hoursperweek</B></td>
                    <td class='DataTDGrey'><B>$daysperweek</B></td>
                    <td class='DataTDGrey'><B title='$daynumber day(s) / $monthnumber month(s)'>$dayspermonth</B></td>
                    </TR>";              
                }              
        }
        else {
            $rownumber--;
        }

	unset($WorkedDays);
	unset($WorkedMonths);

    } 
}

else {
echo " 
  <tr>
    <td class='DataTD'></td>
    <td class='DataTD' colspan='5'>SQL Error:".mysql_error()."</td>
  </tr>";
 $db->Kill();
}

$creationDate = date("D, d M Y H:i:s");
echo "
$tablecode</table>
<font size='2'><div aligmet='right'>Creation date: $creationDate </div></font>
<BR>
<table WIDTH=60% border='0' style='border-collapse: collapse; background-color: white' >
<tr><td height=\"25\">
<font class='FormHeaderFont'>Calculation method:</font>
</td></tr>
<font class='FormFont'><tr><td>
<b>This report calculates just weekend days (Saturdays and Sundays)!</b>
</td></tr>
<tr><td height=\"25\">
<b>Hours per day: </b>(Total worked hours of the employee for a selected period) / (Number of worked days for a selected period)
</td></tr>
<tr><td height=\"35\">
<b>Hours per week: </b>(Total worked hours of the employee for a selected period) / (Number of worked weeks for a selected period)<BR>
</td></tr>
<tr><td height=\"35\">
<b>Days per week: </b>(Number of worked days for a selected period) / (Number of working weeks for a selected period)<BR>
</td></tr>
<tr><td height=\"35\">
<b>Days per month: </b>(Number of worked days for a selected period) / (Number of working months for a selected period)<BR>
</td></tr>
</font>
</table>
</center>
<BR>

</td></tr>
</table>";
include_once("./footer.php");

?>