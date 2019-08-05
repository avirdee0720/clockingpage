<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
uprstr($PU,90);

list($day, $month, $year) = explode("/",$_GET['endd']);
$dataToday = "$year-$month-$day";
$ed=$_GET['endd'];
$prevyear = $year -1;
$dod = "$prevyear-12-01";
$ddo= "$year-12-31";
$firstDayYear= "$year-01-01";
$DateOfHYStarted = $dod;


$db = new CMySQL;
$db2 = new CMySQL;
$VoucherDB = new CMySQL;
$db1new = new CMySQL;
$db2new = new CMySQL;
$db3new = new CMySQL;
$db4new = new CMySQL;
$dataakt=date("dmY-Hi");
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=to-payslips" .$dataakt.".xls");
header("Pragma: no-cache");
header("Expires: 0");
echo "
<style type=\"text/css\">

<!--CSS content in .css file-->

</style>
";
echo "$dataToday
<table border='0' cellpadding='1' cellspacing='1'>
<tr>
    <td >Payroll no</td>
    <td >Known as</td>
    <td >Surname</td>
    <td >month</td>
    <td >Categ</td>
    <td >Unit</td>
    <td >E. in weeks</td>
    <td >E. in days</td>
    <td >Taken</td>
    <td >Left</td>
    <td >BonusType</td>
    <td >wends TD</td>
    <td >AV TD</td>
    <td >NO need</td>
    <td >AV need</td>
    <td >From</td>
    <td >To</td>
    <td >Vouchers</td>
</tr>
";

$pracujeForLessThanYear =  datediff( "d", $DateOfHYStarted, date("Y-m-d", time()), false ) ;

if (!$db->Open()) $db->Kill();
$sql = "SELECT `nombers`.`pno`, `nombers`.`knownas`, `nombers`.`firstname`, `nombers`.`surname`, `nombers`.`status`, `nombers`.`regdays`, `nombers`.`started`, `nombers`.`left1` , `nombers`.`dateforbonus`, `nombers`.`cat`, `nombers`.`from1`, `nombers`.`to1`,  `nombers`.`bonustype`, `emplcat`.`catname_account`, (`nombers`.`regdays` * 4) AS enti FROM `nombers`  JOIN `emplcat` ON `emplcat`.`catozn` = `nombers`.`cat`  ORDER BY `nombers`.`pno` ";
$q=$sql;

  if ($db->Query($q)) 
  {
    while ($row=$db->Row())
    {
	$clockinginno = $row->pno;
	$monthX=date("M-y", strtotime($dataToday));

		$PYBS = new StaffDates($dataToday,$row->dateforbonus); 
		$BonusYearStart = $PYBS->CurrentBonusYearStarted();
		$BonusYearEnd = $PYBS->CurrentBonusYearEnd();
		$dateforbonus = $row->dateforbonus;
//		echo "$clockinginno - $dataToday -".$row->dateforbonus."- BYS : $BonusYearStart BYEND $BonusYearEnd<br>";
	
	$DataFrom = date("M",strtotime("$BonusYearStart"));
	$DataTo = date("M",strtotime("$BonusYearEnd"));

	$pracuje=0;
	$pracuje =  datediff( "d", $row->started, date("Y-m-d", time()), false ) ;

	$Vouchers=0;
	if (!$VoucherDB->Open()) $VoucherDB->Kill();
	$VouchersSQL = "SELECT `vouchersdue`, `withold` FROM `payvoucher` WHERE `no` ='$row->pno' AND `date1` = '$dataToday'";
	if (!$VoucherDB->Query($VouchersSQL)) $VoucherDB->Kill();
	$RVouchers = $VoucherDB->Row();
	$Vouchers = $RVouchers->vouchersdue;
	if($RVouchers->withold=="y") $WithHold = "WHOLD";
	else $WithHold = "";



	$HolidayDays=0;
	if (!$db2->Open()) $db2->Kill();
	$sqlHolid = "SELECT holidays.id,holidays.no, holidays.date1 FROM holidays WHERE holidays.no = '$row->pno' AND holidays.date1>=\"$dod\" AND holidays.date1<=\"$ddo\" AND holidays.sortof=\"PL\" ORDER BY holidays.date1 ";
	if (!$db2->Query($sqlHolid)) $db2->Kill();
	while ($rowHol=$db2->Row())
    {
		$HolidayDays = $HolidayDays + 1;
	}
	$heWorks = 0;

	if($row->catname <> "casual" ) { $cat="n"; } else { $cat="y"; }
	list ($entit, $procent, $iledni) = Entitlement( $cat, $row->regdays, $row->started, $DateOfHYStarted);

	if( $pracuje < 334 ) { 
	  if(strtotime("$DateOfHYStarted 00:00:00") < strtotime("$row->started 00:00:00")) {
	  $heWorks = $pracuje;  } else { $heWorks = $pracujeForLessThanYear; }



	  if($row->catname <> "casual" ) { 
		$kategoria =  "<td >$row->catname_account</td>" ; 
		$unit =  "<td >days</td>" ; 
		$left = $entit - $HolidayDays;
		$entit2 = $entit ;
	  } else { 
		$kategoria =  "<td >$row->catname_account</td>" ; 
		$unit =  "<td >weeks</td>" ; 
		$left = $entit - $HolidayDays;
		$entit1 = $entit ;

	  }
	} else {
	  if($row->catname <> "casual" ) { 
		$kategoria =  "<td >$row->catname_account</td>" ; 
		$unit =  "<td >days</td>" ; 
		$left = $entit - $HolidayDays;
		$entit2 = $entit ;
	  } else { 
		$kategoria =  "<td >$row->catname_account</td>" ; 
		$unit =  "<td >weeks</td>" ; 
		$left = $entit - $HolidayDays;
		$entit1 = $entit ;
	  }
	}
	if ( $left < 0 ) { $left1 = "<td >$left</td>" ;}
	else { $left1 = "<td >$left</td>" ; } 

	if($row->bonustype=="WEND") {
		$BT="W/end";
	
		$WeekendDaysToDate = WeekendDaysToDate($clockinginno,$BonusYearStart,$dataToday);
		$MonthsInAVYear =  round(datediff( "d", $BonusYearStart, $dataToday, false ) / 30.5);
		$AVWeekendDays = round($WeekendDaysToDate / $MonthsInAVYear , 2);

		$AVWeekendDays = number_format($WeekendDaysToDate / $MonthsInAVYear,2,'.',' ');
		$WeekendDaysNeed = 45 - $WeekendDaysToDate;
		if($WeekendDaysNeed < 0) { $WeekendDaysNeed=0; }
		else {
			$MonthsLeft = 12 - $MonthsInAVYear;
			$AVToDo = number_format((45 - $WeekendDaysToDate)/$MonthsLeft,2,'.',' ');
		}
	} else { $WeekendDaysToDate = ""; $AVWeekendDays="";}
	
	  	if($WeekendDaysNeed == 0) { $AVToDo="0.00"; }
	
	if(!isset($BT)) $BT=$row->bonustype;
     if ($row->status == "OK")
		{ 
  
    echo "
  <tr>

    <td ><B>$row->pno</B></td>
    <td >$row->knownas</td>
    <td >$row->surname</td>
    <td >$monthX</td>
    $kategoria
	$unit
    <td >$entit1</td>
    <td >$entit2</td>
	<td >$HolidayDays</td>
    $left1
	<td >$BT</td>
	<td >$WeekendDaysToDate</td>
    <td >$AVWeekendDays</td>
    <td >$WeekendDaysNeed</td>
    <td style=\"mso-number-format:Fixed;\">$AVToDo</td>
    <td >$DataFrom</td>
    <td >$DataTo</td>
    <td >$WithHold $Vouchers</td>

</tr>"; 
} elseif ($row->status == "LEAVER" && (strtotime("$year-$month-01 00:00:00")<strtotime("$row->left1 00:00:00"))) {
	 $left1 = "<td  >0</td>" ;
	 /*
	 echo "
  <tr>

    <td ><B>$row->pno</B></td>
    <td >$row->firstname</td>
    <td >$row->surname</td>
    <td >$monthX</td>
    $kategoria
	$unit
    <td >$entit1</td>
    <td >$entit2</td>
	<td >$HolidayDays</td>
    $left1
	<td >$BT</td>
    <td >$WeekendDaysToDate m-$MonthsInAVYear</td>
    <td >$AVWeekendDays</td>
    <td >$WeekendDaysNeed</td>
    <td >$AVToDo</td>
    <td >$DataFrom</td>
    <td >$DataTo</td>
    <td >$WithHold $Vouchers</td>

</tr>"; 

---------------------
	 
	 
	 
	 echo "<tr>

    <td ><B>L$row->pno</B></td>
    <td >$row->firstname</td>
    <td >$row->surname</td>
    <td >$monthX</td>
    $kategoria
	$unit
    <td >$entit1</td>
    <td >$entit2</td>
	<td >$HolidayDays</td>
    $left1
	<td >$BT</td>
    <td >$WeekendDaysToDate m-$MonthsInAVYear</td>
    <td >$AVWeekendDays</td>
    <td >$WeekendDaysNeed</td>
    <td >$AVToDo</td>
    <td >$DataFrom</td>
    <td >$DataTo</td>
    <td >$Vouchers</td>

</tr>
  "; 
  */
	 
echo "<tr>

    <td ><B>L$row->pno</B></td>
    <td >$row->knownas</td>
    <td >$row->surname</td>
    <td >$monthX</td>
    $kategoria
	$unit
    <td >$entit1</td>
    <td >$entit2</td>
	<td >$HolidayDays</td>
    $left1
	<td >$BT</td>
    <td >$WeekendDaysToDate</td>
    <td >$AVWeekendDays</td>
    <td >$WeekendDaysNeed</td>
    <td >$AVToDo</td>
    <td >$DataFrom</td>
    <td >$DataTo</td>
    <td >$Vouchers</td>

</tr>
  "; 
		} else {$x=0;}

unset($monthX);
unset($kategoria);
unset($unit);
unset($entit1);
unset($entit2);
unset($HolidayDays);
unset($left1);
unset($BT);
unset($WeekendDaysToDate);
unset($AVWeekendDays);
unset($WeekendDaysNeed);
unset($DataFrom);
unset($DataTo);
unset($Vouchers);


unset($AVToDo);

  } 
} else {
echo " 
  <tr>
    <td ></td>
    <td  colspan='3'>Brak dzialow</td>
  </tr>";
 $db->Kill();
}
echo "
</table>
";
include_once("./footer.php");
?>
