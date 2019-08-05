<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
uprstr($PU,90);

list($day, $month, $year) = explode("/",$_GET['endd']);
$dataToday = "$year-$month-$day";
$ed=$_GET['endd'];
$cln=$_GET['cln'];
$prevyear = $year -1;
$dod = "$prevyear-12-01";
$ddo= "$year-12-31";
$firstDayYear= "$year-01-01";
$DateOfHYStarted = $dod;
$OtherDays = 0;
$AVToDo = 0;
$WeekendDaysNeed = 0;


$db = new CMySQL;
$db2 = new CMySQL;
$VoucherDB = new CMySQL;
$db1new = new CMySQL;
$db2new = new CMySQL;
$db3new = new CMySQL;
$db4new = new CMySQL;
$dataakt=date("dmY-Hi");

$pracujeForLessThanYear=(strtotime("$dataToday 00:00:00")-strtotime("$DateOfHYStarted 00:00:00"))/86400; 
$pracujeForLessThanYear=number_format($pracujeForLessThanYear,0,'.','');
if (!$db->Open()) $db->Kill();
$sql = "SELECT `nombers`.`pno`, `nombers`.`knownas`, `nombers`.`firstname`, `nombers`.`surname`, `nombers`.`status`, `nombers`.`regdays`, `nombers`.`started`, `nombers`.`left1` , `nombers`.`cat`, `nombers`.`from1`, `nombers`.`to1`,  `nombers`.`bonustype`, `emplcat`.`catname`, (`nombers`.`regdays` * 4) AS enti FROM `nombers`  JOIN `emplcat` ON `emplcat`.`catozn` = `nombers`.`cat`  WHERE `pno`='$cln'  ";
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
        if (!isset($RVouchers->vouchersdue))
                $Vouchers = "";
        else $Vouchers = $RVouchers->vouchersdue;
        if (!isset($RVouchers->withold))
            $WithHold = "";
        elseif ($RVouchers->withold=="y")
            $WithHold = "WHOLD";
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
                if (!isset($soboty1->wd1))
                        $SaturdaysAllToDate = 0;
                else $SaturdaysAllToDate=$soboty1->wd1;
                $db1new->Free();

	if (!$db1new->Open()) $db1new->Kill();
		$weekend2new = "SELECT COUNT(`sunday`) AS wd2, SUM( `sunday` ) AS sumawd2 FROM `totals`  WHERE `date1`>='$BonusYearStart' AND `date1`<='$dataToday' AND `no`='$clockinginno' AND `sunday`<>'0' GROUP BY `no` ORDER BY `no` ASC";
		if (!$db1new->Query($weekend2new)) $db1new->Kill();
		$niedziele1=$db1new->Row();
                if (!isset($niedziele1->wd2))
                        $SaturdaysAllToDate = 0;
                else $SundaysAllToDate=$niedziele1->wd2;
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
		{ 
  

    $noClockingINOUT=$row->pno;
    $FirsName=$row->firstname;
    $LastName=$row->surname;
    $PayMonth=$monthX;
	$TypeOfTheBonus=$row->bonustype;
echo "
<H3>$noClockingINOUT $FirsName $LastName</H3>
Vucher slip information:<BR>
<table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
<tr>
    <td>
<table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
<tr>
    <td class='FieldCaptionTD'>Month: </TD><TD>$PayMonth</td></tr><tr>
</tr>    <td class='FieldCaptionTD'>Categ: </TD><TD>$kategoria</td></tr><tr>
    <td class='FieldCaptionTD'>Unit: </TD><TD>$unit</td></tr><tr>
    <td class='FieldCaptionTD'>E. in weeks: </TD><TD>$entit1</td></tr><tr>
    <td class='FieldCaptionTD'>E. in days: </TD><TD>$entit2</td></tr><tr>
    <td class='FieldCaptionTD'>Taken: </TD><TD>$HolidayDays</td></tr><tr>
<tr>    <td class='FieldCaptionTD'>Left: </TD><TD>$left1</td></tr><tr>
</table>
</td><td>
<table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
    <tr><td class='FieldCaptionTD'>BonusType: </TD><TD>$TypeOfTheBonus</td></tr><tr>
    <td class='FieldCaptionTD'>wends TD: </TD><TD>$WeekendDaysToDate</td></tr><tr>
    <td class='FieldCaptionTD'>AV TD: </TD><TD>$AVWeekendDays</td></tr><tr>
    <td class='FieldCaptionTD'>NO need: </TD><TD>$WeekendDaysNeed</td></tr><tr>
<tr>    <td class='FieldCaptionTD'>AV need: </TD><TD>$AVToDo</td></tr><tr>
    <td class='FieldCaptionTD'>From: </TD><TD>$DataFrom</td></tr><tr>
    <td class='FieldCaptionTD'>To: </TD><TD>$DataTo</td></tr><tr>
    
</tr>
</TABLE>
</td>
</tr>
</TABLE>
	Vouchers: <B>$WithHold $Vouchers</B>";

	} elseif ($row->status == "LEAVER" && (strtotime("$year-$month-01 00:00:00")<strtotime("$row->left1 00:00:00"))) {
	 $left1 = "<td  >0</td>" ;

    $noClockingINOUT="L".$row->pno;
    $FirsName=$row->firstname;
    $LastName=$row->surname;
    $PayMonth=$monthX;
	$TypeOfTheBonus=$row->bonustype;
echo "
<H3>$noClockingINOUT $FirsName $LastName</H3>
Vucher slip information:<BR>
<table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
<tr>
    <td>
<table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
<tr>
    <td class='FieldCaptionTD'>Month: </TD><TD>$PayMonth</td></tr><tr>
</tr>    <td class='FieldCaptionTD'>Categ: </TD><TD>$kategoria</td></tr><tr>
    <td class='FieldCaptionTD'>Unit: </TD><TD>$unit</td></tr><tr>
    <td class='FieldCaptionTD'>E. in weeks: </TD><TD>$entit1</td></tr><tr>
    <td class='FieldCaptionTD'>E. in days: </TD><TD>$entit2</td></tr><tr>
    <td class='FieldCaptionTD'>Taken: </TD><TD>$HolidayDays</td></tr><tr>
<tr>    <td class='FieldCaptionTD'>Left: </TD><TD>$left1</td></tr><tr>
</table>
</td><td>
<table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
    <tr><td class='FieldCaptionTD'>BonusType: </TD><TD>$TypeOfTheBonus</td></tr><tr>
    <td class='FieldCaptionTD'>wends TD: </TD><TD>$WeekendDaysToDate</td></tr><tr>
    <td class='FieldCaptionTD'>AV TD: </TD><TD>$AVWeekendDays</td></tr><tr>
    <td class='FieldCaptionTD'>NO need: </TD><TD>$WeekendDaysNeed</td></tr><tr>
<tr>    <td class='FieldCaptionTD'>AV need: </TD><TD>$AVToDo</td></tr><tr>
    <td class='FieldCaptionTD'>From: </TD><TD>$DataFrom</td></tr><tr>
    <td class='FieldCaptionTD'>To: </TD><TD>$DataTo</td></tr><tr>
    <td class='FieldCaptionTD'>Vouchers: </TD><TD>$WithHold $Vouchers</td>
</tr>
</TABLE>
</td>
</tr>
</TABLE>";} else {$x=0;}

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

// -----------------------
$PayDB1 = new CMySQL; 
$PayDB2 = new CMySQL; 
$PayDB3 = new CMySQL; 
$PayDB4 = new CMySQL; 
$PayDB5 = new CMySQL; 
$PayDB6 = new CMySQL; 
$PuncBonusAllempDBl = new CMySQL; 
$InsertDB = new CMySQL; 
$InsertDB1 = new CMySQL; 

echo "<H3>Pay details $ed</H3>";
echo "
<table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
<tr>
<td >BasicPay</td>
<td >Bonus 5%</td>
<td >Bonus 7%</td>
<td >Bonus BHM</td>
<td >Holiday Pay</td>
<td >Punctuality Pay</td>
<td >Weekend Bonus</td>
<td >Wend LumpSum</td>
<td >Gross Pay</td>
</tr>";
$GROSSGROSS=0;
if (!$PuncBonusAllempDBl->Open()) $PuncBonusAllempDBl->Kill();
$prac1 =("SELECT `ID`, `pno`, `firstname`, `surname`, `knownas`, `status`, `left1`, `daylyrate`, `paystru` FROM `nombers` WHERE `pno`='$cln' ");
if (!$PuncBonusAllempDBl->Query($prac1)) $PuncBonusAllempDBl->Kill();
while ($emp=$PuncBonusAllempDBl->Row())
{
	$ClockingNO = $emp->pno;

	if (!$PayDB1->Open()) $PayDB1->Kill();
		$paysql1 = "SELECT `id`, `no`, `monetarytotal`, `hours`, `hourlyrate`, `sageno`, `date1` FROM `paybasic` WHERE `date1`='$dataToday' AND `no`='$ClockingNO' AND `monetarytotal`<>0";
		if (!$PayDB1->Query($paysql1)) $PayDB1->Kill();
		$paybasic=$PayDB1->Row();
		$BasicPayID = $paybasic->id;
		$BasicPay = $paybasic->monetarytotal;
	$PayDB1->Free();
 
// ----------------- bonuses 5 7 bhm 
	if (!$PayDB2->Open()) $PayDB2->Kill();
		$paysql2 = "SELECT `id`, `no`, `monetarytotal`, `hours`, `prevbasicpay`, `daysintime`, `type`, `sageno`, `date1` FROM `paybonuses` WHERE `date1`='$ddo' AND `no`='$ClockingNO' AND `monetarytotal`<>0 AND `type`='5'";
		if (!$PayDB2->Query($paysql2)) $PayDB2->Kill();
		$paybonuses=$PayDB2->Row();
                if (!isset($paybonuses->id))
                    $BonusesID = "";
                else $BonusesID = $paybonuses->id;
                if (!isset($paybonuses->monetarytotal))
                    $Bonuses5 = "";
                else $Bonuses5 = $paybonuses->monetarytotal;
                if (!isset($paybonuses->type))
                    $AddDed5 = "";
                else $AddDed5 = $paybonuses->type;
		
	$PayDB2->Free();

	if (!$PayDB2->Open()) $PayDB2->Kill();
		$paysql2 = "SELECT `id`, `no`, `monetarytotal`, `hours`, `prevbasicpay`, `daysintime`, `type`, `sageno`, `date1` FROM `paybonuses` WHERE `date1`='$ddo' AND `no`='$ClockingNO' AND `monetarytotal`<>0 AND `type`='7'";
		if (!$PayDB2->Query($paysql2)) $PayDB2->Kill();
		$paybonuses=$PayDB2->Row();
                if (!isset($paybonuses->id))
                    $BonusesID = "";
                else $BonusesID = $paybonuses->id;
                if (!isset($paybonuses->monetarytotal))
                    $Bonuses7 = "";
                else $Bonuses7 = $paybonuses->monetarytotal;
                if (!isset($paybonuses->type))
                    $AddDed7 = "";
                else $AddDed7 = $paybonuses->type;

	$PayDB2->Free();

		if (!$PayDB2->Open()) $PayDB2->Kill();
		$paysql2 = "SELECT `id`, `no`, `monetarytotal`, `hours`, `prevbasicpay`, `daysintime`, `type`, `sageno`, `date1` FROM `paybonuses` WHERE `date1`='$ddo' AND `no`='$ClockingNO' AND `monetarytotal`<>0 AND `type`='BHM'";
		if (!$PayDB2->Query($paysql2)) $PayDB2->Kill();
		$paybonuses=$PayDB2->Row();
                if (!isset($paybonuses->id))
                    $BonusesID = "";
                else $BonusesID = $paybonuses->id;
                if (!isset($paybonuses->monetarytotal))
                    $BonusesBHD = "";
                else $BonusesBHD = $paybonuses->monetarytotal;
                if (!isset($paybonuses->type))
                    $AddDedBHD = "";
                else $AddDedBHD = $paybonuses->type;
                
	$PayDB2->Free();
// ------- end bonuses

	if (!$PayDB3->Open()) $PayDB3->Kill();
		$paysql3 = "SELECT `id`, `no`, `monetarytotal`, `sumhoursgiven`, `sageno`, `date1` FROM `payholidays` WHERE `date1`='$dataToday' AND `no`='$ClockingNO' AND `monetarytotal`<>0";
		if (!$PayDB3->Query($paysql3)) $PayDB3->Kill();
		$payholidays=$PayDB3->Row();
                if (!isset($payholidays->id))
                    $HolidayPayID = "";
                else $HolidayPayID = $payholidays->id;
                if (!isset($payholidays->monetarytotal))
                    $HolidayPay = "";
                else $HolidayPay = $payholidays->monetarytotal;
                
                $PayDB3->Free();

	if (!$PayDB4->Open()) $PayDB4->Kill();
		$paysql4 = "SELECT `id`, `no`, `monetarytotal`, `punctprc`, `hours`, `days`, `daysintime`, `type`, `sageno`, `date1` FROM `paypunctuality` WHERE `date1`='$dataToday' AND `no`='$ClockingNO' AND `monetarytotal`<>0";
		if (!$PayDB4->Query($paysql4)) $PayDB4->Kill();
		$paypunctuality=$PayDB4->Row();
                if (!isset($paypunctuality->id))
                    $PunctualityID = "";
                else $PunctualityID = $paypunctuality->id;
                if (!isset($paypunctuality->monetarytotal))
                    $Punctuality = "";
                else $Punctuality = $paypunctuality->monetarytotal;
                if (!isset($paypunctuality->type))
                    $TypeOfPunct = "";
                else $TypeOfPunct = $paypunctuality->type;
		
	$PayDB4->Free();

	if (!$PayDB5->Open()) $PayDB5->Kill();
		$paysql5 = "SELECT `id`, `no`, `saturdaysalltodate`, `sundaysalltodate`, `holidaydaystodate`, `weekenddaystodate`, `stucture`, `bonusyearstarted`, `toadd`, `wendbonus`, `wrate`, `weekendhours`, `wdaysthismonth`, `sageno`, `date1` FROM `paywendbonus` WHERE `date1`='$dataToday' AND `no`='$ClockingNO' AND `wendbonus`<>0";
		if (!$PayDB5->Query($paysql5)) $PayDB5->Kill();
		$paywendbonus=$PayDB5->Row();
                if (!isset($paywendbonus->id))
                    $WendBonusID = "";
                else $WendBonusID = $paywendbonus->id;
                if (!isset($paywendbonus->wendbonus))
                    $WendBonus = "";
                else $WendBonus = $paywendbonus->wendbonus;
		
	$PayDB5->Free();

	if (!$PayDB6->Open()) $PayDB6->Kill();
		$paysql6 = "SELECT `id`, `no`, `monetarytotal`, `weekendhours`, `startdwls`, `enddwls`, `sageno`, `date1` FROM `paywendlumpsum` WHERE `date1`='$dataToday' AND `no`='$ClockingNO' AND `monetarytotal`<>0";
		if (!$PayDB6->Query($paysql6)) $PayDB6->Kill();
		$paywendlumpsum=$PayDB6->Row();
                if (!isset($paywendlumpsum->id))
                    $WendLumpSumID = "";
                else $WendLumpSumID = $paywendlumpsum->id;
                if (!isset($paywendlumpsum->monetarytotal))
                    $WendLumpSum = "";
                else $WendLumpSum = $paywendlumpsum->monetarytotal;
		
	$PayDB6->Free();


	if($TypeOfPunct == "addition") { $GrossPay = $BasicPay + $HolidayPay  + $Punctuality + $WendBonus + $WendLumpSum; }
	else { $GrossPay = $BasicPay + $HolidayPay  - $Punctuality + $WendBonus + $WendLumpSum; }
	if($GrossPay > 0.1) { 
		$GROSSGROSS=$GROSSGROSS + $GrossPay ;
		if($TypeOfPunct == "deduction") { $Punctuality="-<FONT COLOR='#FF0000'>$Punctuality</FONT>";} 
			elseif($TypeOfPunct == "addition") { $Punctuality="+<FONT COLOR='#3300CC'>$Punctuality</FONT>";} 
			else {$Punctuality="";} 
				echo "<TR>
					<TD >$BasicPay</TD>
					<TD >$Bonuses5</TD>
					<TD >$Bonuses7</TD>
					<TD >$BonusesBHD</TD>
					<TD >$HolidayPay</TD>
					<TD >$Punctuality</TD>
					<TD >$WendBonus</TD>
					<TD >$WendLumpSum</TD>
					<TD > = $GrossPay</TD>
					</TR>";
	}
 
//} // koniec dla prac
} // while employees
//echo "<TABLE><TR><TD>TOTAL</TD><TD><B>$GROSSGROSS</B></TD></TR></TABLE>";
echo "</TABLE><BR>


<BR><A HREF='#' onclick=\"window.close();\"><IMG SRC='images/end.jpg' WIDTH='22' BORDER='0' ALT='Close this window'></A>&nbsp;<A HREF='#' onclick=\"window.print();\"><IMG SRC='images/print.png' WIDTH='22' BORDER='0' ALT='Print'></A>";
?>
