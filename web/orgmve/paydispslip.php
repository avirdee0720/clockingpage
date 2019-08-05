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

echo "$dataToday
<table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
<tr>
    <td class='FieldCaptionTD'>Payroll no</td>
    <td class='FieldCaptionTD'>First name</td>
    <td class='FieldCaptionTD'>Surname</td>
    <td class='FieldCaptionTD'>month</td>
    <td class='FieldCaptionTD'>Categ</td>
    <td class='FieldCaptionTD'>Unit</td>
    <td class='FieldCaptionTD'>E. in weeks</td>
    <td class='FieldCaptionTD'>E. in days</td>
    <td class='FieldCaptionTD'>Taken</td>
    <td class='FieldCaptionTD'>Left</td>
    <td class='FieldCaptionTD'>BonusType</td>
    <td class='FieldCaptionTD'>wends TD</td>
    <td class='FieldCaptionTD'>AV TD</td>
    <td class='FieldCaptionTD'>NO need</td>
    <td class='FieldCaptionTD'>AV need</td>
    <td class='FieldCaptionTD'>From</td>
    <td class='FieldCaptionTD'>To</td>
    <td class='FieldCaptionTD'>Vouchers</td>
</tr>
";
$pracujeForLessThanYear=(strtotime("$dataToday 00:00:00")-strtotime("$DateOfHYStarted 00:00:00"))/86400; 
$pracujeForLessThanYear=number_format($pracujeForLessThanYear,0,'.','');
if (!$db->Open()) $db->Kill();
$sql = "SELECT `nombers`.`pno`, `nombers`.`knownas`, `nombers`.`firstname`, `nombers`.`surname`, `nombers`.`status`, `nombers`.`regdays`, `nombers`.`started`, `nombers`.`left1` , `nombers`.`cat`, `nombers`.`from1`, `nombers`.`to1`,  `nombers`.`bonustype`, `emplcat`.`catname`, (`nombers`.`regdays` * 4) AS enti FROM `nombers`  JOIN `emplcat` ON `emplcat`.`catozn` = `nombers`.`cat`  ORDER BY `nombers`.`pno` ";
$q=$sql;

  if ($db->Query($q)) 
  {
    while ($row=$db->Row())
    {
	$clockinginno = $row->pno;
	$monthX=date("M-y", strtotime($dataToday));
	$DataFrom = date("M",strtotime("$year-$row->from1-01"));
	$DataTo = date("M",strtotime("$year-$row->to1-01"));
//	$DataFrom ="$year-$row->from1-01";
//	$DataTo = "$year-$row->to1-01";

	$pracuje=0;
	$pracuje=(strtotime("$dataToday 00:00:00")-strtotime("$row->started 00:00:00"))/86400; 
	$pracuje=number_format($pracuje,0,'.','');

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
	if( $pracuje < 334 ) { 
	  if(strtotime("$DateOfHYStarted 00:00:00") < strtotime("$row->started 00:00:00")) {
	  $heWorks = $pracuje;  } else { $heWorks = $pracujeForLessThanYear; }

	  if($row->catname <> "casual" ) { 
		$kategoria =  "<td >$row->cat</td>" ; 
		$unit =  "<td >days</td>" ; 
		$entit2 = ( $heWorks / 365 ) * $row->enti;
		$entit2 = number_format($entit2,0,'.','');
		$left = $entit2 - $HolidayDays;
		$entit1="";
	  } else { 
		$kategoria =  "<td  >$row->cat</td>" ; 
		$unit =  "<td >weeks</td>" ; 
		$entit1 = ( $heWorks / 365 ) * 4;
		$entit1 = number_format($entit1,0,'.','');
		$left = $entit1 - $HolidayDays;
		$entit2="";
	  }
	} else {
	  if($row->catname <> "casual" ) { 
		$kategoria =  "<td >$row->cat</td>" ; 
		$unit =  "<td >days</td>" ; 
		$entit2 = $row->enti;
		$left = $entit2 - $HolidayDays;
		$entit1="";
	  } else { 
		$kategoria =  "<td  >$row->cat</td>" ; 
		$unit =  "<td >weeks</td>" ; 
		$entit1 = 4;
		$left = $entit1 - $HolidayDays;
		$entit2="";
	  }
	}
	if ( $left < 0 ) { $left1 = "<td  >$left</td>" ;}
	else { $left1 = "<td >$left</td>" ; } 
// averages weekend days
	$BonusYearStart = date("Y-m-d",mktime(0, 0, 0, $row->from1, 02,  date("Y")-1));
	$BonusYearEnd = date("Y-m-d",mktime(0, 0, 0, $row->to1, 02,  date("Y")+1));

	$AllWeekendsDayInAVYearSoFar = 0;
	if (!$db4new->Open()) $db4new->Kill();
		$weekendaysfroman = "SELECT `date1` FROM `year` WHERE `year`.`date1` >='$BonusYearStart' AND `year`.`date1` <='$ddo'";
		if (!$db4new->Query($weekendaysfroman)) $db4new->Kill();
		while ($value=$db4new->Row())
			{
			if(date("w", strtotime("$value->date1"))==0) { $AllWeekendsDayInAVYearSoFar = $AllWeekendsDayInAVYearSoFar + 1; }
			elseif(date("w", strtotime("$value->date1"))==6) { $AllWeekendsDayInAVYearSoFar = $AllWeekendsDayInAVYearSoFar +1; }
			else { $OtherDays=$OtherDays + 1; }
			}
	$db4new->Free();

	$SundaysAllToDate = 0;
	$SaturdaysAllToDate = 0;
	$HolidayDaysToDate = 0;
	if (!$db1new->Open()) $db1new->Kill();
		$weekenddb1new = "SELECT COUNT(`saturday`) AS wd1, SUM(`saturday`) AS sumawd1 FROM `totals`  WHERE `date1`>='$BonusYearStart' AND `date1`<='$dataToday' AND `no`='$clockinginno' AND `saturday`<>'0' GROUP BY `no` ORDER BY `no` ASC";
		if (!$db1new->Query($weekenddb1new)) $db1new->Kill();
		$soboty1=$db1new->Row();
		$SaturdaysAllToDate=$soboty1->wd1;
		$db1new->Free();

	if (!$db1new->Open()) $db1new->Kill();
		$weekend2new = "SELECT COUNT(`sunday`) AS wd2, SUM( `sunday` ) AS sumawd2 FROM `totals`  WHERE `date1`>='$BonusYearStart' AND `date1`<='$dataToday' AND `no`='$clockinginno' AND `sunday`<>'0' GROUP BY `no` ORDER BY `no` ASC";
		if (!$db1new->Query($weekend2new)) $db1new->Kill();
		$niedziele1=$db1new->Row();
		$SundaysAllToDate=$niedziele1->wd2;
		$db1new->Free();

	if (!$db3new->Open()) $db3new->Kill();
		$holidNewsql = "SELECT `no` , `date1` FROM `holidays` WHERE `holidays`.`no` ='$clockinginno' AND `holidays`.`sortof`=\"PL\" AND `holidays`.`date1` >='$BonusYearStart' AND `holidays`.`date1` <='$dataToday' ORDER BY `no` ASC";
		if (!$db3new->Query($holidNewsql)) $db3new->Kill();
		while ($holidaysDTD=$db3new->Row())
			{
			if(date("w", strtotime("$holidaysDTD->date1"))==0) { $HolidayDaysToDate = $HolidayDaysToDate + 1; }
			elseif(date("w", strtotime("$holidaysDTD->date1"))==6) { $HolidayDaysToDate = $HolidayDaysToDate +1; }
			else { $OtherDays=$OtherDays + 1; }
			}
		$db3new->Free();

	$MonthsInAVYear = ( strtotime("$dataToday")-strtotime("$BonusYearStart"))/2419200;
	$idDot = strpos($MonthsInAVYear, '.');
	$MonthsInAVYear = substr($MonthsInAVYear,0,$idDot);

	if($row->bonustype=="WEND") {
		$WeekendDaysToDate = $HolidayDaysToDate + $SaturdaysAllToDate + $SundaysAllToDate;
		$AVWeekendDays = number_format($WeekendDaysToDate / $MonthsInAVYear,2,'.',' ');
		$WeekendDaysNeed = 45 - $WeekendDaysToDate;
		if($WeekendDaysNeed < 0) { $WeekendDaysNeed=0; }
		else {
			$MonthsLeft = 12 -$MonthsInAVYear;
			$AVToDo = number_format((45 - $WeekendDaysToDate)/$MonthsLeft,2,'.',' ');
		}
	} else { $WeekendDaysToDate = ""; $AVWeekendDays="";}
	
	//$month= $month."-".$year;
     if ($row->status == "OK")
		{ echo "
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
	<td >$row->bonustype</td>
    <td >$WeekendDaysToDate</td>
    <td >$AVWeekendDays</td>
    <td >$WeekendDaysNeed</td>
    <td >$AVToDo</td>
    <td >$DataFrom</td>
    <td >$DataTo</td>
    <td >$WithHold $Vouchers</td>

</tr>
  "; } elseif ($row->status == "LEAVER" && (strtotime("$year-$month-01 00:00:00")<strtotime("$row->left1 00:00:00"))) {
	 $left1 = "<td  >0</td>" ;
echo "
  <tr>

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
	<td >$row->bonustype</td>
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
unset($row->bonustype);
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
