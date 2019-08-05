<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$db1 = new CMySQL;

uprstr($PU,50);
$month=$_GET['month'];
$year=$_GET['year'];

$sareport=$_GET['sareport'];

$PayDB1 = new CMySQL; 
$PayDB2 = new CMySQL; 
$PayDB3 = new CMySQL; 
$PayDB4 = new CMySQL; 
$PayDB5 = new CMySQL; 
$PayDB6 = new CMySQL; 
$PuncBonusAllempDBl = new CMySQL; 
$InsertDB = new CMySQL; 
$InsertDB1 = new CMySQL; 

if (!$db->Open()) $db->Kill();
if (!$db1->Open()) $db1->Kill();
  
    $sql = "SELECT LAST_DAY('$year-$month-05') As lastday";
    
    if (!$db->Query($sql)) $db->Kill();
    $row=$db->Row();
    
    $lastday=$row->lastday;
    $ddo = $lastday;
    
 if ($sareport!= "1") {$sareport = "0";};
$q2 = "UPDATE `defaultvalues` SET `value` = '$sareport' WHERE `code` ='smallaccomodationreport' LIMIT 1";
    
 if (!$db1->Query($q2)) $db1->Kill();
		$row2=$db1->Row();    


    $q="SELECT value As hourrate FROM `defaultvalues` Where `code`=\"hourrate\"";
    $db->Query($q);
    $r=$db->Row();
    $min_wage=$r->hourrate;
    
    $acc_full_offset = 32.27*52/12;
    $acc_full_offset = 139.84;    

echo "<H3>Accomodation offset report: $month/$year</H3>";

if ($sareport == "1") {
  echo "
<TABLE border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
<tr>
<td class='ColumnTD'>Accomodation offset, pcm: </td>
<td class='ColumnTD'>$acc_full_offset</td>
<td class='ColumnTD'>Min wage:</td>
<td class='ColumnTD'>$min_wage</td>
</tr>
<tr>
<td class='ColumnTD'>Known as</td>
<td class='ColumnTD'>Actual hourly rate</td>
<td class='ColumnTD' colspan='2'>accommodation offset rate</td>
</tr>";

}
else {
echo "
<TABLE border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
<tr>
<td class='ColumnTD'>Accomodation offset, pcm: </td>
<td class='ColumnTD'>$acc_full_offset</td>
<td class='ColumnTD'>Min wage:</td>
<td class='ColumnTD'  colspan='9'>$min_wage</td>
</tr>
<tr>
<td class='ColumnTD'>Known as</td>
<td class='ColumnTD'>Actual hourly rate</td>
<td class='ColumnTD'>accommodation offset rate</td>
<td class='ColumnTD'>Rate of pay to be considered</td>
<td class='ColumnTD'>rent overcharge/bonus</td>
<td class='ColumnTD'>total hours worked</td>
<td class='ColumnTD'>rent pcm</td>
<td class='ColumnTD'>total gross pay</td>
<td class='ColumnTD'>pay - rent</td>
<td class='ColumnTD'>pay - rent + accomodation offs</td>
<td class='ColumnTD'>real hourly rate</td>
<td class='ColumnTD'>adjust</td>
</tr>";
}
$GROSSGROSS=0;
$colour_odd = "DataTD"; 
$colour_even = "DataTDGrey"; 
$row_count=0;

if (!$PuncBonusAllempDBl->Open()) $PuncBonusAllempDBl->Kill();
$prac1 ="SELECT `ID`, `pno`, `firstname`, `surname`, `knownas`, `status`, `left1`, `daylyrate`, `paystru`,rent,daylyrate FROM `nombers` Where `nombers`.`rent`<>'0' AND (`nombers`.`status`='OK' or (`nombers`.`left1`>='$year-$month-01' && `nombers`.`left1`<='$ddo')) ORDER BY `knownas` ASC";

if (!$PuncBonusAllempDBl->Query($prac1)) $PuncBonusAllempDBl->Kill();
while ($emp=$PuncBonusAllempDBl->Row())
{

  $ClockingNO = $emp->pno;
  
  $rent = $emp->rent;
  $rate = round(($emp->daylyrate)/8.5,2);



  $q2 = "SELECT sum(sts) / 3600 AS sumhour
  FROM (SELECT 1 AS b, SUM(TIME_TO_SEC(TIMEDIFF(`outtime`, `intime`))) AS sts
        FROM `inout` AS `inout`
        WHERE  `no` = '$ClockingNO'
        AND (`date1` >= '$year-$month-01' AND `date1` <= '$ddo')
        GROUP BY `date1`) AS x
GROUP BY b";
//echo $q2."<br>";
    if (!$db1->Query($q2)) $db1->Kill();
		$row2=$db1->Row();
	  $hours=$row2->sumhour;
  
	if (!$PayDB1->Open()) $PayDB1->Kill();
		$paysql1 = "SELECT `id`, `no`, `monetarytotal`, `hours`, `hourlyrate`, `sageno`, `date1` FROM `paybasic` WHERE `date1`='$ddo' AND `no`='$ClockingNO' AND `monetarytotal`<>0";
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
		$BonusesID = $paybonuses->id;
		$Bonuses5 = $paybonuses->monetarytotal;
		$AddDed5 = $paybonuses->type;
	$PayDB2->Free();
           
	if (!$PayDB2->Open()) $PayDB2->Kill();
		$paysql2 = "SELECT `id`, `no`, `monetarytotal`, `hours`, `prevbasicpay`, `daysintime`, `type`, `sageno`, `date1` FROM `paybonuses` WHERE `date1`='$ddo' AND `no`='$ClockingNO' AND `monetarytotal`<>0 AND `type`='7'";
		if (!$PayDB2->Query($paysql2)) $PayDB2->Kill();
		$paybonuses=$PayDB2->Row();
		$BonusesID = $paybonuses->id;
		$Bonuses7 = $paybonuses->monetarytotal;
		$AddDed7 = $paybonuses->type;
	$PayDB2->Free();

		if (!$PayDB2->Open()) $PayDB2->Kill();
		$paysql2 = "SELECT `id`, `no`, `monetarytotal`, `hours`, `prevbasicpay`, `daysintime`, `type`, `sageno`, `date1` FROM `paybonuses` WHERE `date1`='$ddo' AND `no`='$ClockingNO' AND `monetarytotal`<>0 AND `type`='BHM'";
		if (!$PayDB2->Query($paysql2)) $PayDB2->Kill();
		$paybonuses=$PayDB2->Row();
		$BonusesID = $paybonuses->id;
		$BonusesBHM = $paybonuses->monetarytotal;
		$AddDedBHM = $paybonuses->type;
	$PayDB2->Free();
// ------- end bonuses
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

$row_count++;
$GrossPay = $GrossPay - $HolidayPay;

$row_color = (($row_count % 2) == 0) ? $colour_even : $colour_odd;


$c1 =$rent - $acc_full_offset;
$c2 = $GrossPay - $rent;
$c3 = $c2 + $acc_full_offset;
$c4 = round($c3 / $hours,2);
$c5 = $min_wage-$c4;
$c6 =  $rate+$c5;
$acc_offset_rate = round($c6,2);

if ($acc_offset_rate>$rate) $rate_considered = "adjusted";
    else  $rate_considered = "actual";

   if ($sareport == "1") {
  echo "
<TR
		<TD class='$row_color'>$emp->knownas</TD>
			<TD class='$row_color'>$rate</TD>
		<TD class='$row_color' colspan='2'>";
      printf ("%6.2f",$acc_offset_rate);
      echo "</TD>";

}
else {

		echo "<TR>
		<TD class='$row_color'>$emp->knownas</TD>
			<TD class='$row_color'>$rate</TD>
			<TD class='$row_color'>";
      printf ("%6.2f",$acc_offset_rate);
      echo "</TD>
			<TD class='$row_color'>$rate_considered</TD>
			<TD class='$row_color'>$c1</TD>
			<TD class='$row_color'>$hours</TD>
			<TD class='$row_color'>$rent</TD>
			<TD class='$row_color'>$GrossPay</TD>
			<TD class='$row_color'>$c2</TD>
			<TD class='$row_color'>$c3</TD>
			<TD class='$row_color'>$c4</TD>
			<TD class='$row_color'>$c5</TD>          
		</TR>";
    }
    
     
	}

/*

<td class='ColumnTD'>No</td>
<td class='ColumnTD'>Known as</td>
<td class='ColumnTD'>Accomodation offset, pcm</td>
<td class='ColumnTD'>$min_wage=5.93;</td>
<td class='ColumnTD'>Actual hourly rate</td>
<td class='ColumnTD'>accommodation offset rate</td>
<td class='ColumnTD'>Rate of pay to be considered</td>
<td class='ColumnTD'>rent overcharge/bonus</td>
<td class='ColumnTD'>total hours worked</td>
<td class='ColumnTD'>rent pcm</td>
<td class='ColumnTD'>Last  month</td>
<td class='ColumnTD'>total gross pay</td>
<td class='ColumnTD'>pay - rent</td>
<td class='ColumnTD'>pay - rent + accomodation offs</td>
<td class='ColumnTD'>real hourly rate</td>
<td class='ColumnTD'>adjust</td>

*/

} // while employees



//$q = "SELECT `nombers`.`ID`, `nombers`.`pno`, `nombers`.`firstname`, `nombers`.`surname`, `nombers`.`knownas`, `nombers`.`status`, DATE_FORMAT(`nombers`.`started`, \"%d/%m/%Y\") as d1, `emplcat`.`catname`, rent,daylyrate FROM `nombers` LEFT JOIN `emplcat` ON `nombers`.`cat`=`emplcat`.`catozn` WHERE `status`='OK' AND `nombers`.`rent`<>'' AND `nombers`.`rent`<>'0'";


echo "
</table>

</td></tr>
</table>";
include_once("./footer.php");

/*

actual hourly rate

accommodation offset rate, Feb 2011

Rate of pay to be considered

rent overcharge/bonus
Avg weekly hours last 12mnths (Nov2010)

total hours worked, Feb 2011

rent pcm
Last  month
total gross pay
pay - rent
pay - rent + accomodation offs
real hourly rate

adjust




*/


?>
