<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];

$db = new CMySQL;
$dba1 = new CMySQL;

$dataakt=date("d/m/Y H:i:s");
$dataakt2=date("d/m/Y");
$nr=$_GET['cln'];
//list($d1, $m1, $y1) = explode("/",$_POST['dateleft']);
$leftON=$_GET['dateleft'];
//echo "$leftON";
$rokmniej=date("Y")-1;
$rokwiecej=date("Y")+1;
$liczdate=date("Y-m");
$LastThisMonth=$liczdate."-31";
$startd="01/12/".$rokmniej;
$endd="30/11/".$rokwiecej;

list($day, $month, $year) = explode("/",$startd);
$dod = "$year-$month-$day";
list($day1, $month1, $year1) = explode("/",$endd);
$ddo= "$year1-$month1-$day1";


function dateDiff2($dformat, $endDate, $beginDate)
{
$date_parts1=explode($dformat, $beginDate);
$date_parts2=explode($dformat, $endDate);
$start_date=gregoriantojd($date_parts1[1], $date_parts1[0], $date_parts1[2]);
$end_date=gregoriantojd($date_parts2[1], $date_parts2[0],  $date_parts2[2]);
return $end_date - $start_date;
}



if (!$dba1->Open()) $dba1->Kill();
$qa = "SELECT  `nombers`.`knownas`, `nombers`.`firstname`, DATE_FORMAT(`nombers`.`started`, \"%d/%m/%Y\") AS datestarted, `nombers`.`left1`, `nombers`.`surname`, `nombers`.`status`, `nombers`.`cat`, `nombers`.`regdays`, `emplcat`.`catname` FROM `nombers` LEFT JOIN `emplcat` ON `emplcat`.`catozn` = `nombers`.`cat` WHERE `pno` = '$nr' LIMIT 1";
$dba1->Query($qa);
$rowfIRST=$dba1->Row();
$regday=$rowfIRST->regdays;
$started=$rowfIRST->datestarted;
$cat=$rowfIRST->cat;

		if($rowfIRST->catname <> "casual" ) {
		$kategoria =  "<FONT COLOR='#0000FF'><H3>$rowfIRST->catname</H3></FONT>" ;
		$UNIT="days";
		$casual="n";
		} else {
		$kategoria =  "<FONT COLOR='#FF0000'><H2>$rowfIRST->catname</H2></FONT>" ;
		$casual="y";
		$UNIT="days";
		}

	$iledni =  dateDiff2("/", date("d/m/Y", time()), $startd);
	if($iledni<365) {
		$procent = ($iledni / 365) * 100;
		$procent = round($procent);
		$prc = "0.".$procent;
		$urlop = (4 * $regday) * $prc;
		$urlop = round($urlop);
		echo " $procent% of the year";
		} 

if (!$db->Open()) $db->Kill();
$q = "SELECT COUNT(`hourgiven`) as dayspaid FROM `holidays`  WHERE `holidays`.`sortof` LIKE \"PL\" AND `holidays`.`no`=$nr AND `holidays`.`date1`>='$dod' AND `holidays`.`date1`<='$LastThisMonth' GROUP BY `holidays`.`no`";
$razem=0;
if (!$db->Query($q))  $db->Kill();
while ($row=$db->Row())
{
//echo "Zaplacono: $row->dayspaid XXX";
    if (!isset($row->dayspaid))
            $razemPL=0;
    else $razemPL=$row->dayspaid;
}
if(($db->Row())== NULL)
    $razemPL=0;        

$leftDays = $urlop - $razemPL;
echo " $leftDays = $urlop - $razemPL";
$dbX = new CMySQL;
if (!$dbX->Open()) $dbX->Kill();
$xx = ("INSERT INTO `hg_leavers` ( `id` , `no` , `date1` , `sortof` , `hourgiven` , `unit`, `daysleft`, `pos` ) VALUES (NULL , '$nr', '$leftON', 'PL', '0', '$UNIT', '$leftDays', '$cat' )");
$dbX->Query($xx);
echo "<script language='javascript'>window.location=\"t_lista.php\"</script>";

?>