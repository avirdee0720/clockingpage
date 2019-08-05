<?php
include_once("./header.php");
$tytul='Adding all values together to build up the gross pay<BR><BR>';
//include("./inc/uprawnienia.php");
include("./config.php");
include("./languages/$LANGUAGE.php");

if (!isset($_POST['state'])) $state = 0; else $state = $_POST['state'];
if (!isset($_POST['endd'])) $endd = "00/00/0000"; else $endd = $_POST['endd'];

if($state==0)
{

echo "	<TD ALIGN=JUSTIFY VALIGN=TOP border=0>
	<table width='100%' border=0><tr><td>

<center>
<form action='$PHP_SELF' method='post' name='ed_czl'>
  <font class='FormHeaderFont'>$tytul</font>
  <table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
  
    <tr>  
      <td class='FieldCaptionTD'>End date of pay motnh </td>
      <td class='DataTD'><input class='Input' maxlength='12' name='endd' value='$yesterday1'></td>
    </tr>

      <tr>
      <td align='right' colspan='2'>
		<input name='state' type='hidden' value='1'>

			<input class='Button' name='Update' type='submit' value='$OKBTN'>
			<input class='Button' name='datesfromlastm' onclick='this.form.endd.value=\"$LastOfLastMonth\";' type='button' value='Prev month'>
	</td>
    </tr>
  </table>
</form>
</center>
<BR>
</td></tr>
</table>";
include_once("./footer.php");
}
elseif($state==1)
{
$dataakt=date("dmY-Hi");
list($day1, $month1, $year1) = explode("/",$endd);
$ddo= "$year1-$month1-$day1";

$PayDB1 = new CMySQL; 
$PayDB2 = new CMySQL; 
$PayDB3 = new CMySQL; 
$PayDB4 = new CMySQL; 
$PayDB5 = new CMySQL; 
$PayDB6 = new CMySQL; 
$PuncBonusAllempDBl = new CMySQL; 
$InsertDB = new CMySQL; 
$InsertDB1 = new CMySQL; 

echo "<H3>Adding all values together to build up the gross pay</H3>";
echo "<TABLE><tr>
<td>CL no</td>
<td>BasicPay</td>
<td>Bonus 5%/7%/BHM</td>
<td>Holiday Pay</td>
<td>Punctuality Pay</td>
<td>Weekend Bonus</td>
<td>Wend LumpSum</td>
<td>Gross Pay</td>
</tr>";
$GROSSGROSS=0;
if (!$PuncBonusAllempDBl->Open()) $PuncBonusAllempDBl->Kill();
$prac1 =("SELECT `ID`, `pno`, `firstname`, `surname`, `knownas`, `status`, `left1`, `daylyrate`, `paystru` FROM `nombers` ORDER BY `pno` ASC");
if (!$PuncBonusAllempDBl->Query($prac1)) $PuncBonusAllempDBl->Kill();
while ($emp=$PuncBonusAllempDBl->Row())
{
	$ClockingNO = $emp->pno;

	if (!$PayDB1->Open()) $PayDB1->Kill();
		$paysql1 = "SELECT `id`, `no`, `monetarytotal`, `hours`, `hourlyrate`, `sageno`, `date1` FROM `paybasic` WHERE `date1`='$ddo' AND `no`='$ClockingNO' AND `monetarytotal`<>0";
		if (!$PayDB1->Query($paysql1)) $PayDB1->Kill();
		$paybasic=$PayDB1->Row();
                if (!isset($paybasic->id)) $BasicPayID = 0; else $BasicPayID = $paybasic->id;
                if (!isset($paybasic->monetarytotal)) $BasicPay = 0; else $BasicPay = $paybasic->monetarytotal;
	$PayDB1->Free();

	if (!$PayDB2->Open()) $PayDB2->Kill();
		$paysql2 = "SELECT `id`, `no`, `monetarytotal`, `hours`, `prevbasicpay`, `daysintime`, `type`, `sageno`, `date1` FROM `paybonuses` WHERE `date1`='$ddo' AND `no`='$ClockingNO' AND `monetarytotal`<>0";
		if (!$PayDB2->Query($paysql2)) $PayDB2->Kill();
		$paybonuses=$PayDB2->Row();
                if (!isset($paybonuses->id)) $BonusesID = 0; else $BonusesID = $paybonuses->id;
                if (!isset($paybonuses->monetarytotal)) $Bonuses = 0; else $Bonuses = $paybonuses->monetarytotal;
                if (!isset($paybonuses->type)) $AddDed = ""; else $AddDed = $paybonuses->type;
	$PayDB2->Free();

	if (!$PayDB3->Open()) $PayDB3->Kill();
		$paysql3 = "SELECT `id`, `no`, `monetarytotal`, `sumhoursgiven`, `sageno`, `date1` FROM `payholidays` WHERE `date1`='$ddo' AND `no`='$ClockingNO' AND `monetarytotal`<>0";
		if (!$PayDB3->Query($paysql3)) $PayDB3->Kill();
		$payholidays=$PayDB3->Row();
                if (!isset($payholidays->id)) $HolidayPayID = 0; else $HolidayPayID = $payholidays->id;
                if (!isset($payholidays->monetarytotal)) $HolidayPay = 0; else $HolidayPay = $payholidays->monetarytotal;
	$PayDB3->Free();

	if (!$PayDB4->Open()) $PayDB4->Kill();
		$paysql4 = "SELECT `id`, `no`, `monetarytotal`, `punctprc`, `hours`, `days`, `daysintime`, `type`, `sageno`, `date1` FROM `paypunctuality` WHERE `date1`='$ddo' AND `no`='$ClockingNO' AND `monetarytotal`<>0";
		if (!$PayDB4->Query($paysql4)) $PayDB4->Kill();
		$paypunctuality=$PayDB4->Row();
                if (!isset($paypunctuality->id)) $PunctualityID = 0; else $PunctualityID = $paypunctuality->id;
                if (!isset($paypunctuality->monetarytotal)) $Punctuality = 0; else $Punctuality = $paypunctuality->monetarytotal;
                if (!isset($paypunctuality->type)) $TypeOfPunct = ""; else $TypeOfPunct = $paypunctuality->type;
	$PayDB4->Free();

	if (!$PayDB5->Open()) $PayDB5->Kill();
		$paysql5 = "SELECT `id`, `no`, `saturdaysalltodate`, `sundaysalltodate`, `holidaydaystodate`, `weekenddaystodate`, `stucture`, `bonusyearstarted`, `toadd`, `wendbonus`, `wrate`, `weekendhours`, `wdaysthismonth`, `sageno`, `date1` FROM `paywendbonus` WHERE `date1`='$ddo' AND `no`='$ClockingNO' AND `wendbonus`<>0";
		if (!$PayDB5->Query($paysql5)) $PayDB5->Kill();
		$paywendbonus=$PayDB5->Row();
                if (!isset($paywendbonus->id)) $WendBonusID = 0; else $WendBonusID = $paywendbonus->id;
                if (!isset($paywendbonus->wendbonus)) $WendBonus = 0; else $WendBonus = $paywendbonus->wendbonus;
	$PayDB5->Free();

	if (!$PayDB6->Open()) $PayDB6->Kill();
		$paysql6 = "SELECT `id`, `no`, `monetarytotal`, `weekendhours`, `startdwls`, `enddwls`, `sageno`, `date1` FROM `paywendlumpsum` WHERE `date1`='$ddo' AND `no`='$ClockingNO' AND `monetarytotal`<>0";
		if (!$PayDB6->Query($paysql6)) $PayDB6->Kill();
		$paywendlumpsum=$PayDB6->Row();
                if (!isset($paywendlumpsum->id)) $WendLumpSumID = 0; else $WendLumpSumID = $paywendlumpsum->id;
                if (!isset($paywendlumpsum->monetarytotal)) $WendLumpSum = 0; else $WendLumpSum = $paywendlumpsum->monetarytotal;
	$PayDB6->Free();


	if($TypeOfPunct == "addition") { $GrossPay = $BasicPay + $Bonuses + $HolidayPay  + $Punctuality + $WendBonus + $WendLumpSum; }
	else { $GrossPay = $BasicPay + $Bonuses + $HolidayPay  - $Punctuality + $WendBonus + $WendLumpSum; }
	if($GrossPay > 0.1) { 
		$GROSSGROSS=$GROSSGROSS + $GrossPay ;
		echo "<TR><TD>$emp->pno</TD><TD>$BasicPay</TD><TD>$Bonuses</TD><TD>$HolidayPay</TD><TD>($TypeOfPunct) $Punctuality</TD><TD>$WendBonus</TD><TD>$WendLumpSum</TD><TD> = $GrossPay</TD></TR>"; 

		if (!$InsertDB1->Open()) $InsertDB1->Kill();
		$delsql="DELETE FROM `paygross` WHERE `no`='$emp->pno' AND `date1`='$ddo'";
		if (!$InsertDB1->Query($delsql)) $InsertDB1->Error();
		$InsertDB1->Free();

		if (!$InsertDB->Open()) $InsertDB->Kill();
		$inserttodb="INSERT INTO `paygross` ( `id` , `no` , `monetarytotal` , `idbasic` , `idpunctuality` , `idbonuses` , `idholidays` , `idwendbonus` , `idwendlumpsum` , `date1` )VALUES (NULL , '$emp->pno', '$GrossPay', '$BasicPayID', '$BonusesID', '$HolidayPayID', '$PunctualityID', '$WendBonusID', '$WendLumpSumID', '$ddo')";
		if (!$InsertDB->Query($inserttodb)) $InsertDB->Kill();
	}

//} // koniec dla prac
} // while employees
echo "<TABLE><TR><TD>TOTAL</TD><TD><B>$GROSSGROSS</B></TD></TR></TABLE>";

	if (!$InsertDB1->Open()) $InsertDB1->Kill();
	$optsql="OPTIMIZE TABLE `paygross` ";
	if (!$InsertDB1->Query($optsql)) $InsertDB1->Error();
	$InsertDB1->Free();

} //fi state=1
else {  echo ""; } //else state
include_once("./footer.php");
?>