<?php
include_once("./header.php");
include("./config.php");

$dataakt=date("dmY-Hi");
list($day1, $month1, $year1) = explode("/",$_GET['endd']);
$ddo= "$year1-$month1-$day1";
$ed=$_GET['endd'];
$cln=$_GET['cln'];

$PayDB1 = new CMySQL; 
$PayDB2 = new CMySQL; 
$PayDB3 = new CMySQL; 
$PayDB4 = new CMySQL; 
$PayDB5 = new CMySQL; 
$PayDB6 = new CMySQL; 
$PuncBonusAllempDBl = new CMySQL; 
$InsertDB = new CMySQL; 
$InsertDB1 = new CMySQL; 

echo "<H3>Pay details from $ed</H3>";
echo "
<TABLE width=100% border='0' cellpadding='3' cellspacing='1' class='FormTABLE'><tr>
<td  class='ColumnTD>Employee</td>
<td class='ColumnTD>BasicPay</td>
<td class='ColumnTD>Bonus 5%/7%/BHM</td>
<td class='ColumnTD>Holiday Pay</td>
<td class='ColumnTD>Punctuality Pay</td>
<td class='ColumnTD>Weekend Bonus</td>
<td class='ColumnTD>Wend LumpSum</td>
<td class='ColumnTD>Gross Pay</td>
</tr>";
$GROSSGROSS=0;
if (!$PuncBonusAllempDBl->Open()) $PuncBonusAllempDBl->Kill();
$prac1 =("SELECT `ID`, `pno`, `firstname`, `surname`, `knownas`, `status`, `left1`, `daylyrate`, `paystru` FROM `nombers` WHERE `pno`='$cln' ");
if (!$PuncBonusAllempDBl->Query($prac1)) $PuncBonusAllempDBl->Kill();
while ($emp=$PuncBonusAllempDBl->Row())
{
	$ClockingNO = $emp->pno;

	if (!$PayDB1->Open()) $PayDB1->Kill();
		$paysql1 = "SELECT `id`, `no`, `monetarytotal`, `hours`, `hourlyrate`, `sageno`, `date1` FROM `paybasic` WHERE `date1`='$ddo' AND `no`='$ClockingNO' AND `monetarytotal`<>0";
		if (!$PayDB1->Query($paysql1)) $PayDB1->Kill();
		$paybasic=$PayDB1->Row();
		$BasicPayID = $paybasic->id;
		$BasicPay = $paybasic->monetarytotal;
	$PayDB1->Free();
 
	if (!$PayDB2->Open()) $PayDB2->Kill();
		$paysql2 = "SELECT `id`, `no`, `monetarytotal`, `hours`, `prevbasicpay`, `daysintime`, `type`, `sageno`, `date1` FROM `paybonuses` WHERE `date1`='$ddo' AND `no`='$ClockingNO' AND `monetarytotal`<>0";
		if (!$PayDB2->Query($paysql2)) $PayDB2->Kill();
		$paybonuses=$PayDB2->Row();
		$BonusesID = $paybonuses->id;
		$Bonuses = $paybonuses->monetarytotal;
		$AddDed = $paybonuses->type;
	$PayDB2->Free();

	if (!$PayDB3->Open()) $PayDB3->Kill();
		$paysql3 = "SELECT `id`, `no`, `monetarytotal`, `sumhoursgiven`, `sageno`, `date1` FROM `payholidays` WHERE `date1`='$ddo' AND `no`='$ClockingNO' AND `monetarytotal`<>0";
		if (!$PayDB3->Query($paysql3)) $PayDB3->Kill();
		$payholidays=$PayDB3->Row();
		$HolidayPayID = $payholidays->id;
		$HolidayPay = $payholidays->monetarytotal;
	$PayDB3->Free();

	if (!$PayDB4->Open()) $PayDB4->Kill();
		$paysql4 = "SELECT `id`, `no`, `monetarytotal`, `punctprc`, `hours`, `days`, `daysintime`, `type`, `sageno`, `date1` FROM `paypunctuality` WHERE `date1`='$ddo' AND `no`='$ClockingNO' AND `monetarytotal`<>0";
		if (!$PayDB4->Query($paysql4)) $PayDB4->Kill();
		$paypunctuality=$PayDB4->Row();
		$PunctualityID = $paypunctuality->id;
		$Punctuality = $paypunctuality->monetarytotal;
		$TypeOfPunct = $paypunctuality->type;
	$PayDB4->Free();

	if (!$PayDB5->Open()) $PayDB5->Kill();
		$paysql5 = "SELECT `id`, `no`, `saturdaysalltodate`, `sundaysalltodate`, `holidaydaystodate`, `weekenddaystodate`, `stucture`, `bonusyearstarted`, `toadd`, `wendbonus`, `wrate`, `weekendhours`, `wdaysthismonth`, `sageno`, `date1` FROM `paywendbonus` WHERE `date1`='$ddo' AND `no`='$ClockingNO' AND `wendbonus`<>0";
		if (!$PayDB5->Query($paysql5)) $PayDB5->Kill();
		$paywendbonus=$PayDB5->Row();
		$WendBonusID = $paywendbonus->id;
		$WendBonus = $paywendbonus->wendbonus;
	$PayDB5->Free();

	if (!$PayDB6->Open()) $PayDB6->Kill();
		$paysql6 = "SELECT `id`, `no`, `monetarytotal`, `weekendhours`, `startdwls`, `enddwls`, `sageno`, `date1` FROM `paywendlumpsum` WHERE `date1`='$ddo' AND `no`='$ClockingNO' AND `monetarytotal`<>0";
		if (!$PayDB6->Query($paysql6)) $PayDB6->Kill();
		$paywendlumpsum=$PayDB6->Row();
		$WendLumpSumID = $paywendlumpsum->id;
		$WendLumpSum = $paywendlumpsum->monetarytotal;
	$PayDB6->Free();


	if($TypeOfPunct == "addition") { $GrossPay = $BasicPay + $Bonuses + $HolidayPay  + $Punctuality + $WendBonus + $WendLumpSum; }
	else { $GrossPay = $BasicPay + $Bonuses + $HolidayPay  - $Punctuality + $WendBonus + $WendLumpSum; }
	if($GrossPay > 0.1) { 
		$GROSSGROSS=$GROSSGROSS + $GrossPay ;
		if($TypeOfPunct == "deduction") {$Punctuality="-<FONT COLOR='#FF0000'>$Punctuality</FONT>";} 
			elseif($TypeOfPunct == "addition") {$Punctuality="+<FONT COLOR='#3300CC'>$Punctuality</FONT>";} 
			else {$Punctuality="";} 
		echo "<TR><TD class='DataTD'>$emp->pno</TD>
		<TD class='DataTD'>$BasicPay</TD>
			<TD class='DataTD'>$Bonuses</TD>
			<TD class='DataTD'>$HolidayPay</TD>
			<TD class='DataTD'> $Punctuality</TD>
			<TD class='DataTD'>$WendBonus</TD>
			<TD class='DataTD'>$WendLumpSum</TD>
			<TD class='DataTD'> = $GrossPay</TD>
		</TR>"; 
	}
//} // koniec dla prac
} // while employees
echo "<TABLE><TR><TD>TOTAL</TD><TD><B>$GROSSGROSS</B></TD></TR></TABLE>";


include_once("./disp_pay.php?cln=$cln&endd=$row->date2");

?>