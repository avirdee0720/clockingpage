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

$db = new CMySQL; 
$db1 = new CMySQL; 
$db2 = new CMySQL; 
$db3 = new CMySQL; 
$db4 = new CMySQL; 
 $allempl = new CMySQL; 

$db1new = new CMySQL; 
$db3new = new CMySQL; 
/*
header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=times" .$dataakt.".xls");
	header("Pragma: no-cache");
	header("Expires: 0");
*/

//echo "<tr><td>CL no</td><td>bonus year started</td><td>TIME WORKED</td><td>WEEKEND TIME</td><td>TOTAL DAYS</td><td>WEEKEND DAYS</td><td>Punct %</td></tr></td><td>Punct Bonus</td>";
	echo "<TABLE><TR><TD>CL NO</TD><TD>WeekendBonus</TD><TD>PayStru</TD><TD>Days</TD><TD>Hours:</TD><TD>BONUS</TD></TR>";
		$minweight=0;
	if (!$db4->Open()) $db4->Kill();
		$minwsql = "SELECT `minweight` FROM `th_cfg` LIMIT 1";
		if (!$db4->Query($minwsql)) $db4->Kill();
		$minw=$db4->Row();
		$minweight=$minw->minweight;

if (!$allempl->Open()) $allempl->Kill();
$prac1 =("SELECT `ID`, `pno`, `firstname`, `surname`, `knownas`, `status`, `wendbonus`, `daylyrate`, `paystru`, `started`, `left1`, `bonusrate`, `wrate`, `addtowrate` FROM `nombers` ORDER BY `pno` ASC");
if (!$allempl->Query($prac1)) $allempl->Kill();
while ($emp=$allempl->Row())
{
# start count punctuality bonus
# if OLD / NEW scale
$clockinginno=$emp->pno;
if( $emp->wendbonus == 1 ) { 
// year for bonus started
	$avyear = $starteddday ;
	list($y1, $m1, $d1 ) = explode("-",$emp->started);
	$dod34 = "$y1-$m1-$d1";
	$BonusYearStart = date("Y-m-d",mktime(0, 0, 0, $m1+1, 01,  date("Y")-1));
	//$today=date("Y-m-d");

	if (!$db1->Open()) $db1->Kill();
		$weekend = "SELECT COUNT(`saturday`) AS wd1, SUM(`saturday`) AS sumawd1 FROM `totals`  WHERE `date1`>='$dod' AND `date1`<='$ddo' AND `no`='$clockinginno' AND `saturday`<>'0' GROUP BY `no` ORDER BY `no` ASC";
		if (!$db1->Query($weekend)) $db1->Kill();
		$soboty=$db1->Row();
		$saturdays=$soboty->wd1;
		$saturdayhours=$soboty->sumawd1;
	$db1->Free();
	if (!$db1->Open()) $db1->Kill();
		$weekend2 = "SELECT COUNT(`sunday`) AS wd2, SUM( `sunday` ) AS sumawd2 FROM `totals`  WHERE `date1`>='$dod' AND `date1`<='$ddo' AND `no`='$clockinginno' AND `sunday`<>'0' GROUP BY `no` ORDER BY `no` ASC";
		if (!$db1->Query($weekend2)) $db1->Kill();
		$niedziele=$db1->Row();
		$sundays=$niedziele->wd2;
		$sundayhours=$niedziele->sumawd2;
	$db1->Free();

	if (!$db3->Open()) $db3->Kill();
		$holidsql = "SELECT `no` , `date1`, `hourgiven` AS hoursg FROM `holidays` WHERE `holidays`.`no` ='$clockinginno' AND `holidays`.`date1` >='$dod' AND `holidays`.`date1` <='$ddo' ORDER BY `no` ASC";
		//echo $holidsql;
		if (!$db3->Query($holidsql)) $db3->Kill();
		$SundayHoliday=0;
		$SaturdayHoliday=0;
		$SundayDaysHP = 0;
		$SaturdayDaysHP = 0;
		while ($holidays=$db3->Row())
			{
			if(date("w", strtotime("$holidays->date1"))==0) {
				$SundayHoliday=$SundayHoliday+$holidays->hoursg; 
				$SundayDaysHP = $SundayDaysHP + 1; }
			elseif(date("w", strtotime("$holidays->date1"))==6) { 
				$SaturdayHoliday=$SaturdayHoliday+$holidays->hoursg; 
				$SaturdayDaysHP= $SaturdayDaysHP +1; }
			else { echo ""; }
			//$hoursgiven=$holidays->hoursg;
			}
		$db3->Free();

	 //$WeekenDayTotal = $saturdays + $sundays + $SundayDaysHP + $SaturdayDaysHP;
	 //$WeekendHoursTotal = $saturdayhours + $sundayhours + $SundayHoliday + $SaturdayHoliday;

	 $WeekenDayTotal = $saturdays + $sundays ;
	 $WeekendHoursTotal = $saturdayhours + $sundayhours ;


if($emp->paystru=="OLD")
	{
	//$WeekendAdd = $WeekenDayTotal * $emp->addtowrate;
	$WendBonus = $WeekendHoursTotal * $emp->wrate;
	$WendBonus = number_format($WendBonus,2,'.',' ');
	}
	elseif($emp->paystru=="NEW")
	{ 
	$SundaysAllToDate = 0;
	$SaturdaysAllToDate = 0;
	$HolidayDaysToDate = 0;
	if (!$db1new->Open()) $db1new->Kill();
		$weekenddb1new = "SELECT COUNT(`saturday`) AS wd1, SUM(`saturday`) AS sumawd1 FROM `totals`  WHERE `date1`>='$BonusYearStart' AND `date1`<='$ddo' AND `no`='$clockinginno' AND `saturday`<>'0' GROUP BY `no` ORDER BY `no` ASC";
		if (!$db1new->Query($weekenddb1new)) $db1new->Kill();
		$soboty1=$db1new->Row();
		$SaturdaysAllToDate=$soboty1->wd1;
		$db1new->Free();

	if (!$db1new->Open()) $db1new->Kill();
		$weekend2new = "SELECT COUNT(`sunday`) AS wd2, SUM( `sunday` ) AS sumawd2 FROM `totals`  WHERE `date1`>='$BonusYearStart' AND `date1`<='$ddo' AND `no`='$clockinginno' AND `sunday`<>'0' GROUP BY `no` ORDER BY `no` ASC";
		if (!$db1new->Query($weekend2new)) $db1new->Kill();
		$niedziele1=$db1new->Row();
		$SundaysAllToDate=$niedziele1->wd2;
		$db1new->Free();

	if (!$db3new->Open()) $db3new->Kill();
		$holidNewsql = "SELECT `no` , `date1` AS hoursg FROM `holidays` WHERE `holidays`.`no` ='$clockinginno' AND `holidays`.`sortof`=\"PL\" AND `holidays`.`date1` >='$BonusYearStart' AND `holidays`.`date1` <='$ddo' ORDER BY `no` ASC";
		if (!$db3new->Query($holidNewsql)) $db3new->Kill();
		while ($holidaysDTD=$db3new->Row())
			{
			if(date("w", strtotime("$holidays->date1"))==0) {
				$HolidayDaysToDate = $HolidayDaysToDate + 1; }
			elseif(date("w", strtotime("$holidays->date1"))==6) { 
				$HolidayDaysToDate = $HolidayDaysToDate +1; }
			else { echo ""; }
			}
		$db3new->Free();
	$HolidayDaysToDate = $HolidayDaysToDate + $SaturdaysAllToDate + $SundaysAllToDate;
	if($HolidayDaysToDate > 44) { 
		$WeekendAdd = $WeekenDayTotal * $emp->addtowrate;
		$WendBonus = ($WeekendHoursTotal * $emp->wrate) + $WeekendAdd; 
		}
	else { 	
		$WendBonus = $WeekendHoursTotal * 0; 
		}
	$WendBonus = number_format($WendBonus,2,'.',' ');
 	}
	else { 
		echo "error in pay structure"; 

	$WendBonus =0;
		}

} else { $WendBonus = "0";} 

	if($WendBonus > 0.1) {
		echo "<TR><TD>$emp->pno</TD><TD>$emp->wendbonus</TD><TD>$emp->paystru </TD><TD>  $WeekenDayTotal </TD><TD> $WeekendHoursTotal </TD><TD> £ $WendBonus to add: $WeekendAdd</TD></TR>";
		} 

	unset($emp->started);
	unset($dod34);
	unset($nextmonth1);
	unset($BonusYearStart);
	unset($WeekendAdd);
} // koniec dla prac
echo "</TABLE>";
	//echo "<H1>TEST</H1>";


//echo $data; 
} //fi state=1
else
{
 echo "<BR><BR><BR>Ostrze¿enie!!!!!<BR><BR><BR>",
	 "Oy! What are you doing? $REMOTE_ADDR <BR>";
} //else state
include_once("./footer.php");
?>