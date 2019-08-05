<?php
include("./config.php");
include_once("./header.php");

error_reporting(E_ERROR | E_WARNING | E_PARSE);

$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
uprstr($PU,90);
$tytul='Paid leave days for status = OK';
$year = $_GET['year'];
$prevyear = $year -1;

$dod = "$prevyear-12-01";
$ddo= "$year-12-31";
$firstDayYear= "$year-01-01";
$DateOfHYStarted=$dod;

list($day, $month, $year) = explode("/",$_GET['datado']);
$dataToday = "$year-$month-$day";
 
 $db2 = new CMySQL;

//uprstr($PU,50);
echo "  <TD ALIGN=JUSTIFY VALIGN=TOP border=0>
<center>
<font CLASS='FormHeaderFont'>$tytul&nbsp;&nbsp;   &nbsp;&nbsp;
<table border='0' cellpadding='3' cellspacing='1' CLASS='FormTABLE'>
<tr>
    <td CLASS='ColumnTD' nowrap>Clocking NO</td>
    <td CLASS='ColumnTD' nowrap>First name</td>
    <td CLASS='ColumnTD' nowrap>Surname</td>
    <td CLASS='ColumnTD' nowrap>Categ</td>
    <td CLASS='ColumnTD' nowrap>Unit</td>
	<td CLASS='ColumnTD' nowrap>Entitlement</td>
    <td CLASS='ColumnTD' nowrap>Taken</td>
    <td CLASS='ColumnTD' nowrap>Left</td>
</tr>
";
$pracujeForLessThanYear =  datediff( "d", $DateOfHYStarted, date("Y-m-d", time()), false ) ;

if (!$db->Open()) $db->Kill();
$sql = "SELECT nombers.pno, nombers.knownas, nombers.firstname, nombers.surname, nombers.status, nombers.regdays, nombers.started, nombers.left1 , emplcat.catname, (nombers.regdays * 4) AS enti FROM nombers  JOIN emplcat ON emplcat.catozn = nombers.cat WHERE nombers.status LIKE \"OK\" AND nombers.started <= '$dataToday' ORDER BY nombers.pno ";
$q=$sql;

  if ($db->Query($q)) 
  {
    while ($row=$db->Row())
    {
	$pracuje=0;
	$pracuje =  datediff( "d", $row->started, date("Y-m-d", time()), false ) ;

	$HolidayDays=0;
	if (!$db2->Open()) $db2->Kill();
	$sqlHolid = "SELECT holidays.id,holidays.no, holidays.date1 FROM holidays WHERE holidays.no = '$row->pno' AND holidays.date1>=\"$dod\" AND holidays.date1<=\"$ddo\" AND holidays.sortof=\"PL\" ORDER BY holidays.date1 ";
	if (!$db2->Query($sqlHolid)) $db2->Kill();
	while ($rowHol=$db2->Row())
    {
		$HolidayDays = $HolidayDays + 1;
	}
	$heWorks = 0;

	if($row->catname <> "casual" ) { $cat="n"; }
	else { $cat="y"; }
	list ($entit, $procent, $iledni, $LL,$entit2) = Entitlement3( $cat, $row->regdays, $row->started, $DateOfHYStarted,$dataToday);

	if( $pracuje < 334 ) { 
	  if(strtotime("$DateOfHYStarted 00:00:00") < strtotime("$row->started 00:00:00")) {
	  $heWorks = $pracuje;  } else { $heWorks = $pracujeForLessThanYear; }



	  if($row->catname <> "casual" ) { 
		$kategoria =  "<td CLASS='DataTD'>$row->catname - RD: $row->regdays Started: $row->started  - Month:$iledni </td>" ; 
		$unit =  "<td CLASS='DataTD'>days</td>" ; 
		$left = $entit2 - $HolidayDays;
	  } else { 
		$kategoria =  "<td CLASS='niedziela'>$row->catname - Started: $row->started  - Month:$iledni </td>" ; 
		$unit =  "<td CLASS='DataTD'>weeks</td>" ; 
		$left = $entit2 - $HolidayDays;
	  }
	} else {
	  if($row->catname <> "casual" ) { 
		$kategoria =  "<td CLASS='DataTD'>$row->catname  - RD: $row->regdays Started: $row->started - Month:$iledni </td>" ; 
		$unit =  "<td CLASS='DataTD'>days</td>" ; 
		$left = $entit - $HolidayDays;
	  } else { 
		$kategoria =  "<td CLASS='niedziela'>$row->catname - Started: $row->started  - Month:$iledni </td>" ; 
		$unit =  "<td CLASS='DataTD'>weeks</td>" ; 
		$left = $entit - $HolidayDays;
	  }
	}
	if ( $left < 0 ) { $left1 = "<td CLASS='niedziela'>$left</td>" ;}
	else { $left1 = "<td CLASS='DataTD'>$left</td>" ; } 



     echo "
  <tr>

    <td CLASS='DataTD'><B>$row->pno</B></td>
    <td CLASS='DataTD'>$row->firstname</td>
    <td CLASS='DataTD'>$row->surname</td>
    $kategoria
	$unit
    <td CLASS='DataTD'>$entit - $entit2</td>
    <td CLASS='DataTD'>$HolidayDays</td>
    $left1
	

</tr>
  ";
unset($entit);
  } 
} else {
echo " 
  <tr>
    <td CLASS='DataTD'></td>
    <td CLASS='DataTD' colspan='3'>Brak dzialow</td>
  </tr>";
 $db->Kill();
}
echo "
  <tr>
    <td align='left' CLASS='FooterTD' nowrap> &nbsp;</td>
    <td align='middle' CLASS='FooterTD' colspan='9' nowrap>&nbsp;</td>
  </tr>
</table>

</center>
<BR>
</td></tr>
</table>
";
include_once("./footer.php");
?>
