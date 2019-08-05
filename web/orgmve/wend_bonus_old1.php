<?php
include_once("./header.php");
$tytul='Weekend bonus, count, store, and export (display)<BR><BR>';
//include("./inc/uprawnienia.php");
include("./config.php");
include("./languages/$LANGUAGE.php");

if(!isset($state))
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
list($day, $month, $year) = explode("/",$_POST['startd']);
$dod = "$year-$month-$day";
list($day1, $month1, $year1) = explode("/",$_POST['endd']);
$ddo= "$year1-$month1-$day1";
$sd=$_GET['startd'];
$ed=$_GET['endd'];

 $db4 = new CMySQL; 
 $allempl = new CMySQL; 
 $InsertDB = new CMySQL; 
 $InsertDB1 = new CMySQL; 

echo "<H3>Weekend Bonus</H3>";
echo "<TABLE><TR><TD>CL NO</TD><TD>WeekendBonus</TD><TD>PayStru</TD><TD>Days</TD><TD>Hours:</TD><TD>BONUS</TD></TR>";
		$minweight=0;
	if (!$db4->Open()) $db4->Kill();
		$minwsql = "SELECT `minweight` FROM `th_cfg` LIMIT 1";
		if (!$db4->Query($minwsql)) $db4->Kill();
		$minw=$db4->Row();
		$minweight=$minw->minweight;
 
if (!$allempl->Open()) $allempl->Kill();
$prac1 =("SELECT `ID`, `pno`, `firstname`, `surname`, `knownas`, `status`, `wendbonus`, `daylyrate`, `paystru`, `started`, `left1`, `bonusrate`, `wrate`, `addtowrate`, `dateforbonus`, `from1`, `to1` FROM `nombers` WHERE `status` LIKE 'OK' ORDER BY `pno` ASC");
if (!$allempl->Query($prac1)) $allempl->Kill();
while ($emp=$allempl->Row())
{
  $clockinginno = $emp->pno;
  $cln = $clockinginno;

if( $emp->wendbonus == 1 ) { 

		$PYBS = new StaffDates($ddo,$emp->dateforbonus); 
		$BonusYearStart = $PYBS->CurrentBonusYearStarted();
		$CurrentBonusYearEnd = $PYBS->CurrentBonusYearEnd();
		$MonthsInAVYear =  round(datediff( "d", $BonusYearStart, $ddo, false ) / 30.5);

		list ($WeekenDayTotal, $WeekendHoursTotal) = WeekendsThisMonth($cln,$dod,$ddo);

	if($emp->paystru=="OLD")
	{
			$AllWeekendsDayThisBonusYear = AllWeekendsDays($BonusYearStart,$CurrentBonusYearEnd);
			$WeekendDaysToDate = WeekendDaysToDate($clockinginno,$BonusYearStart,$ddo);
			$AVWeekendDays = round($WeekendDaysToDate / $MonthsInAVYear , 2);

			if($WeekendDaysToDate >= 45) { 
	
					if($AVWeekendDays >= 3.75) {
					$WendBonus = $WeekendHoursTotal * $emp->wrate;
					$WendBonus = number_format($WendBonus,2,'.',' ');
					//if weekends days are smaler than 45 after minus this month -> LumpSum
					}
			}
			else { $WendBonus = 0; }
	}
	elseif($emp->paystru == "NEW")
	{ 

			$WeekendDaysToDate = WeekendDaysToDate($clockinginno,$BonusYearStart,$ddo);

			if($WeekendDaysToDate >= 45) { 
				$WeekendAdd = $WeekenDayTotal * $emp->addtowrate;
				$WendBonus = ($WeekendHoursTotal * $emp->wrate) + $WeekendAdd; 
			} else { 	
				$WendBonus = $WeekendHoursTotal * 0; 
			}
			$WendBonus = number_format($WendBonus,2,'.',' ');
 	} else {  
		echo "error in pay structure"; 
		$WendBonus = 0;
	}

} else { $WendBonus = "0";} 
	if($WendBonus > 0.1) {
		echo "<TR><TD>$emp->pno</TD><TD>$emp->wendbonus</TD><TD>$emp->paystru </TD><TD>  $WeekenDayTotal </TD><TD> $WeekendHoursTotal </TD><TD> £ $WendBonus to add: $WeekendAdd </TD><TD>
		BonusYearStart:$BonusYearStart<BR>
		WeekenDayTotal - $WeekenDayTotal, WeekendHoursTotal - $WeekendHoursTotal, AVWeekendDays - $AVWeekendDays<BR>
		WeekendDaysToDate - $WeekendDaysToDate  <BR> 
		AllWeekendsDayThisBonusYear - $AllWeekendsDayThisBonusYear <BR>
		MonthsInAVYear - $MonthsInAVYear <BR> 
		CurrentBonusYearEnd - $CurrentBonusYearEnd <HR>
		</TD></TR>";

		if (!$InsertDB1->Open()) $InsertDB1->Kill();
		$delsql="DELETE FROM `paywendbonus` WHERE `no`='$emp->pno' AND `date1`='$ddo' AND `sageno`='10'";
		if (!$InsertDB1->Query($delsql)) $InsertDB1->Free();

		if (!$InsertDB->Open()) $InsertDB->Kill();
		$inserttodb="INSERT INTO `paywendbonus` ( `id` , `no` , `weekenddaystodate` , `stucture` , `bonusyearstarted` , `toadd` , `wendbonus`, `wrate`, `weekendhours` , `wdaysthismonth`,  `sageno` , `date1` ) VALUES (  NULL , '$emp->pno', '$WeekendDaysToDate', '$emp->paystru', '', '$WeekendAdd', '$WendBonus', '$emp->wrate', '$WeekendHoursTotal', '$WeekenDayTotal',  '10', '$ddo')";
		if (!$InsertDB->Query($inserttodb)) $InsertDB->Kill();
	} 

unset($emp->started);
unset($dod34);
unset($nextmonth1);
unset($BonusYearStart);
unset($WeekendAdd);
unset($weekenddb1new);
unset($weekend2new);
unset($holidNewsql);
unset($HolidayDaysToDate);

} // koniec dla prac

echo "</TABLE>";

	if (!$InsertDB1->Open()) $InsertDB1->Kill();
	$optsql="OPTIMIZE TABLE `paypunctuality` ";
	if (!$InsertDB1->Query($optsql)) $InsertDB1->Error();
	$InsertDB1->Free();} //fi state=1

else
{
 echo "<BR><BR><BR>Ostrze¿enie!!!!!<BR><BR><BR>",
	 "Oy! What are you doing? $REMOTE_ADDR <BR>";
} //else state
include_once("./footer.php");
?>