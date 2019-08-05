<?php
include_once("./header.php");
$tytul='Voucher payment, count & store (display)<BR><BR>';
//include("./inc/uprawnienia.php");
include("./config.php");
include("./languages/$LANGUAGE.php");

if (!isset($_POST['state'])) $state = 0; else $state = $_POST['state'];
if (!isset($_POST['startd'])) $startd = "00/00/0000"; else $startd = $_POST['startd'];
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
      <td class='FieldCaptionTD'>Start date</td>
      <td class='DataTD'><input class='Input' maxlength='12' name='startd' value='$FirstOfTheMonth'>

      </td>
    </tr>
    <tr>  
      <td class='FieldCaptionTD'>End date</td>
      <td class='DataTD'><input class='Input' maxlength='12' name='endd' value='$yesterday1'></td>
    </tr>

      <tr>
      <td align='right' colspan='2'>
		<input name='state' type='hidden' value='1'>

			<input class='Button' name='Update' type='submit' value='$OKBTN'>
			<input class='Button' name='datesfromlastm' onclick='this.form.startd.value=\"$FirstOfLastMonth\";this.form.endd.value=\"$LastOfLastMonth\";' type='button' value='Prev month'>
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
$today=date("Y-m-d");
list($day, $month, $year) = explode("/",$startd);
$dod = "$year-$month-$day";
list($day1, $month1, $year1) = explode("/",$endd);
$ddo= "$year1-$month1-$day1";
$DateToCheckStart= "$year1-$month1-01";

$db = new CMySQL; 
$db1 = new CMySQL; 
$db2 = new CMySQL; 
$db3 = new CMySQL; 
$db4 = new CMySQL; 
$allempl = new CMySQL; 
$db1new = new CMySQL; 
$db3new = new CMySQL; 
$db4new = new CMySQL; 
$InsertDB = new CMySQL; 
$InsertDB1 = new CMySQL; 
$PuncBonusDB2 = new CMySQL; 
$PayDB3 = new CMySQL; 
$PayDB3 = new CMySQL; 

echo "<H3>Voucher payment</H3>";
echo "<TABLE><TR><TD>CL NO</TD><TD>Vouchers due(VoucherPayment)</TD><TD>taxable vouchers(TaxebleVouchers)</TD><TD>&pound; to count(TaxebleDue)</TD><TD>BasicGross(BasicGrossPay)</TD><TD>Gross PAY(GrossPay)</TD></TR>";
		$minweight=0;
	if (!$db4->Open()) $db4->Kill();
		$minwsql = "SELECT `minweight` FROM `th_cfg` LIMIT 1";
		if (!$db4->Query($minwsql)) $db4->Kill();
		$minw=$db4->Row();
		$minweight=$minw->minweight;

if (!$allempl->Open()) $allempl->Kill();
$prac1 =("SELECT `ID`, `pno`, `firstname`, `surname`, `knownas`, `status`, `wendbonus`, `daylyrate`, `paystru`, `started`, `left1`, `bonusrate`, `tocheck`, `addtowrate`, `dateforbonus`, `from1`, `to1`, `VCond3`, `VCond375`, `VCond70`, `VE`, `VFV` FROM `nombers` ORDER BY `pno` ASC");
if (!$allempl->Query($prac1)) $allempl->Kill();
while ($emp=$allempl->Row())
{

$clockinginno=$emp->pno;
$VCond3 = $emp->VCond3;
$VCond375 = $emp->VCond375;
$VCond70 = $emp->VCond70;
$VoucherEntit = $emp->VE;
$VoucherFixed = $emp->VFV;
$DaysTOCheck = $emp->tocheck;

	$PYBS = new StaffDates($ddo,$emp->dateforbonus); 
	$BonusYearStart = $PYBS->CurrentBonusYearStarted();
	$CurrentBonusYearEnd = $PYBS->CurrentBonusYearEnd();

	list ($WeekenDayTotal, $WeekendHoursTotal) = WeekendsThisMonth($clockinginno,$dod,$ddo);

		if (!$PuncBonusDB2->Open()) $PuncBonusDB2->Kill();
		$percent0 = "SELECT `intime` FROM `totals` WHERE `date1`>='$dod' AND `date1`<='$ddo' AND `no`='$clockinginno' ORDER BY `intime` ASC";
		if (!$PuncBonusDB2->Query($percent0)) $PuncBonusDB1->Kill();
		$punctualpercent=0;
		$punctualpercent2=0;
		$przedczasem=0;
		$poczasie=0;
		$alldaysINOUT=$PuncBonusDB2->Rows();
	    while ($percent=$PuncBonusDB2->Row())
		    {
			if(strtotime("$percent->intime") < strtotime("10:01:00"))
				{ $przedczasem++; }
			else { $poczasie++; }
			} 
            if ($alldaysINOUT == 0) $punctualpercent = 0; else {
                $punctualpercent = number_format($przedczasem / $alldaysINOUT,2,'.',' ')*100;
            }
            if ($alldaysINOUT == 0) $punctualpercent2 = 0; else {
                $punctualpercent2 = $przedczasem / $alldaysINOUT;
            }

//list ($punctualpercent, $punctualpercent2) = Punctuality($clockinginno,$dod,$ddo);

	$AllWeekendsDayInAVYearSoFar = AllWeekendsDays($BonusYearStart,$ddo);

	$WeekendDaysToDate = WeekendDaysToDate($clockinginno,$BonusYearStart,$ddo);

	if (!$PayDB3->Open()) $PayDB3->Kill();
		$paysql3 = "SELECT `id`, `no`, `monetarytotal`, `hours`, `hourspl`, `hourlyrate`, `sageno`, `date1` FROM `paybasicgross` WHERE `date1`='$ddo' AND `monetarytotal`<>0  AND `no`='$clockinginno'";
		if (!$PayDB3->Query($paysql3)) $PayDB3->Kill();
		$paybasic=$PayDB3->Row();
                if (!isset($paybasic->monetarytotal)) $BasicGrossPay = 0; else $BasicGrossPay = $paybasic->monetarytotal;
		$PayDB3->Free();

	if (!$PayDB3->Open()) $PayDB3->Kill();
		$paysql2 = "SELECT `id` , `no` , `monetarytotal` , `idbasic` , `idpunctuality` , `idbonuses` , `idholidays` , `idwendbonus` , `idwendlumpsum` , `date1` FROM `paygross` WHERE `date1`='$ddo' AND `monetarytotal`<>0 AND `no`='$clockinginno'";
		if (!$PayDB3->Query($paysql2)) $PayDB3->Kill();
		$paygross=$PayDB3->Row();
                if (!isset($paygross->monetarytotal)) $GrossPay = 0; else $GrossPay = $paygross->monetarytotal;
		$PayDB3->Free();

	$MonthsInAVYear =  round(datediff( "d", $BonusYearStart, $ddo, false ) / 30.5);
		$AVWeekendDays = round($WeekendDaysToDate / $MonthsInAVYear , 2);

		//$AVWeekendDays = number_format($WeekendDaysToDate / $MonthsInAVYear,2,'.',' ');

	$StartedMoreThanMonthAgo = ( strtotime("$FirstOfLastMonth")>strtotime("$emp->started"));

	//$AVWeekendDays = $WeekenDayTotal; // my mistake

			if($emp->paystru=="OLD") {
					$Vouchers = "Vouchers to count OLD";
					
					if (!$PayDB3->Open()) $PayDB3->Kill();
		$paysql2 = "SELECT `wendbonus` FROM `paywendbonus` WHERE `date1`='$ddo' AND `no`='$clockinginno'";
		if (!$PayDB3->Query($paysql2)) $PayDB3->Kill();
		$wb=$PayDB3->Row();
                if (!isset($wb->wendbonus)) $weendbonus = 0; else $weendbonus = $wb->wendbonus;
	
		$paysql2 = "SELECT `monetarytotal`  FROM `paywendlumpsum` WHERE `date1`='$ddo' AND `monetarytotal`<>0 AND `no`='$clockinginno'";
		if (!$PayDB3->Query($paysql2)) $PayDB3->Kill();
		$lsum=$PayDB3->Row();
                if (!isset($lsum->monetarytotal)) $lumbsum = 0; else $lumbsum = $lsum->monetarytotal;
		$PayDB3->Free();
		$BasicGrossPay += $lumbsum + 	$weendbonus;
					if (!isset($VoucherFixed) || $VoucherFixed==0) { $VoucherDue = $BasicGrossPay * $VoucherEntit; }
					//else { $VoucherDue = $VoucherFixed; }
					if ($VoucherFixed > 0) { $VoucherDue = $VoucherFixed / 2 ; }
					$VoucherDue = number_format($VoucherDue,2,'.',' ');
					$VoucherPayment = number_format($VoucherDue,0,'.',' ');
					$TaxebleVouchers = $VoucherPayment;
					$VoucherDue = 0;
						if($VCond3 == 1 && $AVWeekendDays < 3) { 
							$VoucherDueWH = $VoucherDue; 
							$TaxebleVouchersWH = $TaxebleVouchers;
							$VoucherPaymentWH = $VoucherPayment;
						}
				} else {
					if(strtotime("$DateToCheckStart 00:00:00")>=strtotime("$emp->started 00:00:00")) {
					$Vouchers = "Vouchers to count NEW";
					if (!isset($VoucherFixed) || $VoucherFixed==0) { $VoucherDue = $GrossPay * $VoucherEntit; }
					//else { $VoucherDue = $VoucherFixed; }
					if ($VoucherFixed > 0) { $VoucherDue = $VoucherFixed / 2; }
					$VoucherDue = number_format($VoucherDue,2,'.',' ');
					$VoucherPayment = number_format($VoucherDue * 2,0,'.',' ');
					$TaxebleVouchers = $VoucherPayment;
					$VoucherDue = $VoucherPayment / 2;
						if($VCond70 == 1  && $punctualpercent < 69 ) { 
							$VoucherDueWH = $VoucherDue; 
							$TaxebleVouchersWH = $TaxebleVouchers;	
							$VoucherPaymentWH = $VoucherPayment;
						}
						if( $VCond375 == 1 && $AVWeekendDays < 3.75 ) { 
							$VoucherDueWH = $VoucherDue; 
							$TaxebleVouchersWH = $TaxebleVouchers;	
							$VoucherPaymentWH = $VoucherPayment;
						}
						if( isset($DaysTOCheck) && $DaysTOCheck > $alldaysINOUT ) { 
							$VoucherDueWH = $VoucherDue; 
							$TaxebleVouchersWH = $TaxebleVouchers;	
							$VoucherPaymentWH = $VoucherPayment;
						}
				}
			} 
			
  
if( $VoucherPayment <> $VoucherPaymentWH && $VoucherPayment > 0.1 ) {
		echo "<TR><TD>$emp->pno / $punctualpercent</TD><TD>V <B>$VoucherPayment</B> </TD><TD>$TaxebleVouchers</TD><TD> $VoucherDue</TD><TD>$BasicGrossPay</TD><TD>$GrossPay | $VoucherFixed</TD></TR>";

	if (!$InsertDB1->Open()) $InsertDB1->Kill();
	$delsql="DELETE FROM `payvoucher` WHERE `no`='$emp->pno' AND `date1`='$ddo'";
	if (!$InsertDB1->Query($delsql)) $InsertDB1->Free();
	if (!$InsertDB->Open()) $InsertDB->Kill();
		$inserttodb="INSERT INTO `payvoucher` ( `id` , `no` , `vouchersdue` , `taxablevouchers` , `voucherpayment` , `basicgros` , `gross` , `tvsageded` , `tvsagepay` , `vpsageded` , `withold`, `date1` ) VALUES (NULL , '$emp->pno', '$VoucherPayment', '$TaxebleVouchers', '$VoucherDue', '$BasicGrossPay', '$GrossPay', '6', '16', '10', 'n', '$ddo')";
	if (!$InsertDB->Query($inserttodb)) $InsertDB->Kill();} 

if( $VoucherPaymentWH == $VoucherPayment && $VoucherPaymentWH > 0.1) {
	echo "<TR><TD>WH $emp->pno / $punctualpercent</TD><TD>V <B>$VoucherPaymentWH</B> </TD><TD>$TaxebleVouchersWH</TD><TD> $VoucherDueWH</TD><TD>$BasicGrossPay</TD><TD>$GrossPay | $VoucherFixed</TD></TR>";

	if (!$InsertDB1->Open()) $InsertDB1->Kill();
	$delsql="DELETE FROM `payvoucher` WHERE `no`='$emp->pno' AND `date1`='$ddo'";
	if (!$InsertDB1->Query($delsql)) $InsertDB1->Free();
	if (!$InsertDB->Open()) $InsertDB->Kill();
	$inserttodb="INSERT INTO `payvoucher` ( `id` , `no` , `vouchersdue` , `taxablevouchers` , `voucherpayment` , `basicgros` , `gross` , `tvsageded` , `tvsagepay` , `vpsageded` , `withold`, `date1` ) VALUES (NULL , '$emp->pno', '$VoucherPaymentWH', '$TaxebleVouchersWH', '$VoucherDueWH', '$BasicGrossPay', '$GrossPay', '6', '16', '10', 'y', '$ddo')";
	if (!$InsertDB->Query($inserttodb)) $InsertDB->Kill();
} 

	unset($emp->started);
	unset($Vouchers);
	unset($VoucherDue);
	unset($TaxebleVouchers);
	unset($punctualpercent);
	unset($VoucherPayment);
	unset($VoucherDueWH);
	unset($TaxebleVouchersWH);
	unset($punctualpercentWH);
	unset($VoucherPaymentWH);
	unset($inserttodb);
	unset($VoucherFixed);	
	unset($BonusYearStart);
	unset($WeekendAdd);
	unset($weekenddb1new);
	unset($weekend2new);
	unset($holidNewsql);
	unset($HolidayDaysToDate);
} // koniec dla prac
echo "</TABLE>";

	if (!$InsertDB1->Open()) $InsertDB1->Kill();
	$optsql="OPTIMIZE TABLE `payvoucher` ";
	if (!$InsertDB1->Query($optsql)) $InsertDB1->Error();
	$InsertDB1->Free();} //fi state=1

else
{
 echo "<BR><BR><BR>Ostrze�enie!!!!!<BR><BR><BR>",
	 "Oy! What are you doing? $REMOTE_ADDR <BR>";
} //else state
include_once("./footer.php");
?>