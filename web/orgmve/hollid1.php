<HTML>
<HEAD>
<?php
include("./config.php");
include("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$dataakt=date("d/m/Y H:i:s");
$dataakt2=date("d/m/Y");
$dataakt3=date("Y-m-d");
$msgdb = new CMySQL;

$razemUPL = "";
$razemPL = "";

?>
<meta HTTP-EQUIV='cache-control' CONTENT='no-cache, must-revalidate'>

<LINK REL='stylesheet' HREF='style/multipads/style.css' TYPE='text/css'>

</HEAD>

<body class=PageBODY bgcolor=#FFFFFF topmargin=0 leftmargin=0 marginwidth=0 marginheight=0 text=#000000 link=#0000FF vlink=#0000FF alink=#FF0000>
<CENTER>
<?php

// vars passed into
if (!isset($_GET['yearAct'])) $YearAct = date('Y'); else $YearAct = $_GET['yearAct'];
$ThisYear = date("Y");
$NextYear = date("Y")+1;
$ThisMonth = date("m");
$nr=$_GET['cln'];
$YearPrev = $YearAct - 1;
$rokmniej = $YearAct - 1;
$rokwiecej = $YearAct;
$startd="01/12/".$rokmniej;
$endd="30/11/".$rokwiecej;

list($day, $month, $year) = explode("/",$startd);
$dod = "$year-$month-$day";
list($day1, $month1, $year1) = explode("/",$endd);
$ddo= "$year1-$month1-$day1";

echo "<font class='FormHeaderFont'>Employee's Payrol/Clocking number: $nr<BR>Holiday Year - ".$YearAct ."</font>
<BR>
<input class='Button'  type='Button' onclick='window.location=\"hollidadd.php?skrypt=$PHP_SELF&cln=$nr&startd=$startd&endd=$endd\"' value='$ADDNEWBTN'>
<input class='Button'  type='Button' onclick='window.location=\"hollid1.php?cln=$nr&yearAct=$YearPrev\"' value='$YearPrev'>
<input class='Button'  type='Button' onclick='window.location=\"hollid1.php?cln=$nr&yearAct=$ThisYear\"' value='$ThisYear'>";
if ($ThisMonth == "12") echo "
<input class='Button'  type='Button' onclick='window.location=\"hollid1.php?cln=$nr&yearAct=$NextYear\"' value='$NextYear'>
";

echo "
<table WIDTH=500 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >
  <tr>
         <td class='FieldCaptionTD'><B>DAY</B></td>
         <td class='FieldCaptionTD'><B>Type of leave </B></td>
          <td class='FieldCaptionTD'><B>Hours given - delete</B></td>
          <td class='FieldCaptionTD'><B>Part of day</B></td>
         <td class='FieldCaptionTD'><B>Imported </B></td>
       </tr>";

$dba1 = new CMySQL;
if (!$dba1->Open()) $dba1->Kill();
$qa = "SELECT  `nombers`.`knownas`, `nombers`.`firstname`, `nombers`.`started`, DATE_FORMAT(`nombers`.`started`, \"%d/%m/%Y\") AS datestarted, `nombers`.`left1`,`nombers`.`surname`, `nombers`.`status`, `nombers`.`cat`, `nombers`.`regdays`, `emplcat`.`catname` FROM `nombers` LEFT JOIN `emplcat` ON `emplcat`.`catozn` = `nombers`.`cat` WHERE `pno` = '$nr' LIMIT 1";
$dba1->Query($qa);
$rowfIRST=$dba1->Row();
$regday=$rowfIRST->regdays;
$startedDAY=$rowfIRST->started;

		if($rowfIRST->catname <> "casual" ) {
			$kategoria =  "<FONT COLOR='#0000FF'><H3>$rowfIRST->catname</H3></FONT>" ;
			$UNIT="days";
			$casual="n";
		} else {
			$kategoria =  "<FONT COLOR='#FF0000'><H2>$rowfIRST->catname</H2></FONT>" ;
			$UNIT="days";
			$casual="y";
		}

	 list ($urlop, $procent, $iledni, $LL) = Entitlement2( $casual, $regday, $startedDAY, $startd);
     echo $procent." % of the year, days ". $iledni . ".";

$db = new CMySQL;
if (!$db->Open()) $db->Kill();

$q = "SELECT holidays.id,holidays.no, DATE_FORMAT(holidays.date1, \"%d/%m/%Y\") as d1,holidays.daypart,holidays.sortof, holidays.hourgiven, holidays.imp, nombers.knownas, nombers.firstname, nombers.surname, nombers.status, nombers.cat, nombers.regdays, emplcat.catname FROM holidays LEFT JOIN nombers ON holidays.no = nombers.pno JOIN emplcat ON emplcat.catozn = nombers.cat WHERE (((nombers.status)=\"OK\")) AND holidays.no LIKE '$nr' AND holidays.date1>='$dod' AND holidays.date1<='$ddo' ORDER BY `holidays`.`date1`";
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
		<td class='DataTD'>$row->hourgiven &nbsp;&nbsp;
		<A HREF='holidmod.php?lp=$row->id&datad=$row->d1&candelete=$candelete&skrypt=$PHP_SELF?cln=$cln&yearAct=$YearAct&startd=$startd&endd=$endd'><IMG SRC='images/edit.gif' BORDER='0' ALT='delete'></A></td>
		<td class='DataTD'>$row->daypart &nbsp;&nbsp;
		<td class='DataTD'>$row->imp </td>
  ";
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
if ($razemUPL == "") $razemUPL=0;
$leftDays=$urlop - $razemPL;
$msg="<BLOCKQUOTE><H2><B>He has taken $razemPL days paid leave , and $razemUPL unpaid.</B><BR>
Entitlement = $urlop, For this holliday year left $leftDays $UNIT</H2></BLOCKQUOTE>
<BR>$kategoria 
<FONT SIZE=+2 COLOR=#660099>($LL)</FONT>
</center>

";

echo "</table>
$msg 
<BR></td></tr>
</table>";
include_once("./footer.php");
?>
