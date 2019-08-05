<HTML>
<HEAD>
<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$dataakt=date("d/m/Y H:i:s");
$dataakt2=date("d/m/Y");

$dbleaver = new CMySQL;

function dateDiff2($dformat, $endDate, $beginDate)
{
$date_parts1=explode($dformat, $beginDate);
$date_parts2=explode($dformat, $endDate);
$start_date=gregoriantojd($date_parts1[1], $date_parts1[0], $date_parts1[2]);
$end_date=gregoriantojd($date_parts2[1], $date_parts2[0],  $date_parts2[2]);
return $end_date - $start_date;
}
?>
<meta HTTP-EQUIV='cache-control' CONTENT='no-cache, must-revalidate'>

<LINK REL='stylesheet' HREF='style/multipads/style.css' TYPE='text/css'>

</HEAD>

<body class=PageBODY bgcolor=#FFFFFF topmargin=0 leftmargin=0 marginwidth=0 marginheight=0 text=#000000 link=#0000FF vlink=#0000FF alink=#FF0000>
<CENTER>
<?php
// to change table with choice

$nr=$_GET['cln'];
$rokmniej=date("Y")-1;
$rokwiecej=date("Y")+1;
$startd="01/12/".$rokmniej;
$endd="30/11/".$rokwiecej;

list($day, $month, $year) = explode("/",$startd);
$dod = "$year-$month-$day";
list($day1, $month1, $year1) = explode("/",$endd);
$ddo= "$year1-$month1-$day1";

echo "
<font class='FormHeaderFont'>Employee's payrol/ClockingIN-OUT NO: $nr<BR>Pay Holiday year - 2010 - 2011</font>
<BR>
<table WIDTH=500 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >
  <tr>
         <td class='FieldCaptionTD'><B>DAY</B></td>
         <td class='FieldCaptionTD'><B>Type of leave </B></td>
          <td class='FieldCaptionTD'><B>Hours given </B></td>
  </tr>";

$dba1 = new CMySQL;
if (!$dba1->Open()) $dba1->Kill();
$qa = "SELECT  `nombers`.`knownas`, `nombers`.`firstname`, DATE_FORMAT(`nombers`.`started`, \"%d/%m/%Y\") AS datestarted, `nombers`.`left1`,
`nombers`.`surname`, `nombers`.`status`, `nombers`.`cat`, `nombers`.`regdays`, `emplcat`.`catname`
FROM `nombers` LEFT JOIN `emplcat` ON `emplcat`.`catozn` = `nombers`.`cat` WHERE `pno` = '$nr' LIMIT 1";
$dba1->Query($qa);
$rowfIRST=$dba1->Row();
$regday=$rowfIRST->regdays;
$started=$rowfIRST->datestarted;

		if($rowfIRST->catname <> "casual" ) {
		$kategoria =  "<FONT COLOR='#0000FF'><H3>$rowfIRST->catname</H3></FONT>" ;
		$UNIT="days";
		$casual="n";
		} else {
		$kategoria =  "<FONT COLOR='#FF0000'><H2>$rowfIRST->catname</H2></FONT>" ;
		$casual="y";
		$UNIT="days";
		}

	$iledni =  dateDiff2("/", date("d/m/Y", time()), $started);
	if($iledni<365) {
		$procent = ($iledni / 365) * 100;
		$procent = round($procent);
		$prc = "0.".$procent;
		$urlop = (4 * $regday) * $prc;
		$urlop = round($urlop);
		} else {
			if($casual=="n") { $urlop= 4 * $regday;
			} else { $urlop = 4 ; }
		}

if (!$db->Open()) $db->Kill();
$q = "SELECT holidays.id,holidays.no, DATE_FORMAT(holidays.date1, \"%d/%m/%Y\") as d1,holidays.sortof, holidays.hourgiven, holidays.imp, nombers.knownas, nombers.firstname, nombers.surname, nombers.status, nombers.cat, nombers.regdays, emplcat.catname FROM holidays LEFT JOIN nombers ON holidays.no = nombers.pno JOIN emplcat ON emplcat.catozn = nombers.cat WHERE holidays.no LIKE '$nr' AND holidays.date1>='$dod' AND holidays.date1<='$ddo' ORDER BY `holidays`.`date1`";
$razem=0;
if ($db->Query($q))
  {
    while ($row=$db->Row())
    {
	if($row->hourgiven < 0.01) { $candelete="YES"; }  else  { $candelete="NO"; } 
     echo "
	 <tr>
         <td class='DataTD'><B>$row->d1</B></td>
         <td class='DataTD'>$row->sortof </td>
		<td class='DataTD'>$row->hourgiven </td>
</TR> ";
 if($row->sortof = "PL") $razemPL++;
 else $razemUPL++;
  }
} else {
echo "
  <tr>
    <td class='DataTD'></td>
    <td class='DataTD' colspan='5'>SQL Error:".mysql_error()."</td>
  </tr>";
 $db->Kill();
}

$leftDays=$urlop - $razemPL;

$msg="<BLOCKQUOTE><H2><B>He has taken $razemPL days paid leave , and $razemUPL unpaid.</B><BR>
$kategoria</BLOCKQUOTE>
</center>";

echo "</table> $msg<BR></td></tr></table>";
// ----------------------------------------------------------- LEAAVER
echo "<CENTER><font class='FormHeaderFont'>Holiday entitlement for leavers</font>
<BR>
<table WIDTH=500 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >
  <tr>
         <td class='FieldCaptionTD'><B>Leaving date</B></td>
         <td class='FieldCaptionTD'><B>Leave type</B></td>
         <td class='FieldCaptionTD'><B>Hours given</B></td>
         <td class='FieldCaptionTD'><B>Remaining</B></td>
         <td class='FieldCaptionTD'><B>Unit</B></td>
         <td class='FieldCaptionTD'><B>Total</B></td>
  </tr>";
if (!$dbleaver->Open()) $dbleaver->Kill();
$sqllever = "SELECT `hg_leavers`.`id`,`hg_leavers`.`no`, DATE_FORMAT(`hg_leavers`.`date1`, \"%d/%m/%Y\") as d1,`hg_leavers`.`sortof`, `hg_leavers`.`hourgiven`, `hg_leavers`.`daysleft`, `hg_leavers`.`unit`, `hg_leavers`.`total` FROM `hg_leavers` WHERE `hg_leavers`.`no`='$nr'";
if ($dbleaver->Query($sqllever))
  {
    while ($rowl=$dbleaver->Row())
    {
     echo "	 <tr>
         <td class='DataTD'><B>$rowl->d1</B></td>
         <td class='DataTD'>$rowl->sortof </td>
		<td class='DataTD'>$rowl->hourgiven </td>
		<td class='DataTD'>$rowl->daysleft </td>
		<td class='DataTD'>$rowl->unit </td>
		<td class='DataTD'>$rowl->total </td></TR> ";
	  }
} else {
echo "
  <tr>
    <td class='DataTD'></td>
    <td class='DataTD' colspan='5'>SQL Error:".mysql_error()."</td>
  </tr>";
 $dbleaver->Kill();
}
echo "</table></CENTER>";
// ------------------------------------------------------LEAVER END
include_once("./footer.php");

?>
