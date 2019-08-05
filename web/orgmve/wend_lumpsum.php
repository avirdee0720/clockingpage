<?php
include_once("./header.php");
$tytul='Weekend Lump Sum, count, store, and export (display)<BR><BR>';
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

$db = new CMySQL; 
$db1 = new CMySQL; 
$db2 = new CMySQL; 
$db3 = new CMySQL; 
$db4 = new CMySQL; 
$allempl = new CMySQL; 
$db1new = new CMySQL; 
$db3new = new CMySQL; 
$InsertDB = new CMySQL; 
$InsertDB1 = new CMySQL; 

echo "<H3>Weekend Lump Sum for employee</H3>";
echo "<TABLE><TR><TD>CL NO</TD><TD>WendLumpSum</TD><TD>PAR</TD></TR>";
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
$clockinginno=$emp->pno;
 $HR=$emp->daylyrate;
if( $emp->wendbonus == 1 ) { 

		$PYBS = new StaffDates($ddo,$emp->dateforbonus); 
		$BonusYearStart = $PYBS->CurrentBonusYearStarted();
		$CurrentBonusYearEnd = $PYBS->CurrentBonusYearEnd();
		$MonthsInAVYear =  round(datediff( "d", $BonusYearStart, $ddo, false ) / 30.5);
		list ($WeekenDayTotal, $WeekendHoursTotal) = WeekendsThisMonth($clockinginno,$dod,$ddo);

	$WeekendDaysToDate = WeekendDaysToDate($clockinginno,$BonusYearStart,$ddo);
//	$CeckIfShouldGet = $WeekendDaysToDate - $WeekenDayTotal;
	$AVWeekendDays = $WeekendDaysToDate / $MonthsInAVYear;

// check if he did not get
if (!$db1->Open()) $db1->Kill();
$gotit = "SELECT * FROM `paywendlumpsum`  WHERE `startdwls`='$BonusYearStart' AND `no`='$clockinginno' Order by date1 DESC";
if (!$db1->Query($gotit)) $db1->Kill();
$lumpsumdate=$db1->Row();
if (!isset($lumpsumdate->date1)) $lumpsumdate1 = 0; else $lumpsumdate1 = $lumpsumdate->date1;

$hegotWLS=$db1->Rows();
$db1->Free();
 	//      $hegotWLS = 0;   $emp->paystru="OLD";
   if($hegotWLS == 0) {

       if($emp->paystru=="OLD")
	{
			$AllWeekendsDayThisBonusYear = AllWeekendsDays($BonusYearStart,$CurrentBonusYearEnd);
			$WeekendDaysToDate = WeekendDaysToDate($clockinginno,$BonusYearStart,$ddo);
			$AVWeekendDays = round($WeekendDaysToDate / $MonthsInAVYear , 2);
    //  $WeekendDaysToDate=47;
 	if($WeekendDaysToDate >= 45) { 
//		if($AVWeekendDays >= 3.75) {
//				if($CeckIfShouldGet < 45) {
					if (!$db1->Open()) $db1->Kill();
					$lssql = "SELECT SUM( `monetarytotal` ) AS lumpsum, SUM( `weekendhours` ) AS hours FROM `wendlumpsum`  WHERE `date1`>='$BonusYearStart' AND `date1`<'$dod' AND `no`='$clockinginno' GROUP BY `no`";
		$lssql ="				
					(
SELECT no, date1, hourgiven AS hours
FROM `holidays`
WHERE `no` =$clockinginno
AND `date1` >= '$BonusYearStart'
AND (
DATE_FORMAT( `holidays`.`date1` , \"%W\" ) = \"Saturday\"
OR DATE_FORMAT( `holidays`.`date1` , \"%W\" ) = \"Sunday\"
)
)
UNION (

SELECT no, date1, workedtime
FROM `totals`
WHERE no =$clockinginno
AND date1 >= '$BonusYearStart'
AND (
saturday <>0
OR sunday <>0
)
)
ORDER BY date1
LIMIT 0,45
            ";
          //  echo "<br> $lssql <br>";
					if (!$db1->Query($lssql)) $db1->Kill();
				//	$WeekendLS=$db1->Row();
					  $WendLumpSum1= 0;
					   $WendLumpSumHours=0;
					while ($WeekendLS=$db1->Row())
  {
 
        //$WendLumpSum1+=$WeekendLS->lumpsum;
					$WendLumpSumHours=$WendLumpSumHours+$WeekendLS->hours;
  }
  //$HR=number_format($emp->daylyrate / 8.5,'.',' ');
  $WendLumpSum1 = number_format($WendLumpSumHours*$HR/8.5/4,2,'.',' ');
					//$WendLumpSum1=$WeekendLS->lumpsum;
				//	$WendLumpSumHours=$WeekendLS->hours;
					$db1->Free();	
							echo "<TR><TD><B>$emp->pno</B></TD><TD> $WendLumpSum1</TD><TD>
							BonusYearStart - $BonusYearStart <BR> CurrentBonusYearEnd - $CurrentBonusYearEnd <BR>
							PayDay: $dod <BR>
							WendLumpSumHours: $WendLumpSumHours  <BR>
							AVWeekendDays: $AVWeekendDays <BR>
							WeekendDaysToDate: $WeekendDaysToDate 
							 <HR></TD></TR>";
   //sql1- $lssql <BR>sql2- SELECT `monetarytotal` , `weekendhours` FROM `wendlumpsum`  WHERE `date1`>='$BonusYearStart' AND `date1`<'$dod' AND `no`='$clockinginno'
//				} 
//			} else { $WendLumpSum1 = 0; echo "$clockinginno - Didnot get because: AVWeekendDays >= 3.75 ($AVWeekendDays) <BR>"; } 
		} else { $WendLumpSum1 = 0; /* echo "$clockinginno - Didnot get because: WeekendDaysToDate < 45 ($WeekendDaysToDate) From: $BonusYearStart<BR>"; */}
	   } else { $WendLumpSum1 = 0; /*echo "$clockinginno - Didnot get because: Stru=NEW <BR>";*/ }
	} else {  $WendLumpSum1 = 0; /*echo "$clockinginno - He has already got it at $lumpsumdate1 <BR>";*/ }
} else { $WendLumpSum1 = 0; /*echo "$clockinginno - Didnot get because: emp->wendbonus <> 1 <BR>";*/ } 

	if($WendLumpSum1 > 0.1) {     //0.1
		if (!$InsertDB1->Open()) $InsertDB1->Kill();
		$delsql="DELETE FROM `paywendlumpsum` WHERE `no`='$emp->pno' AND `date1`='$ddo' AND `sageno`='11'";
		if (!$InsertDB1->Query($delsql)) $InsertDB1->Free();

		if (!$InsertDB->Open()) $InsertDB->Kill();
		$inserttodb="INSERT INTO `paywendlumpsum` ( `id` , `no` , `monetarytotal` , `weekendhours` , `startdwls` , `enddwls` , `sageno` , `date1` )
		VALUES ( NULL , '$emp->pno', '$WendLumpSum1', '$WendLumpSumHours', '$BonusYearStart', '$CurrentBonusYearEnd', '11', '$ddo')";
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
	$optsql="OPTIMIZE TABLE `paywendlumpsum` ";
	if (!$InsertDB1->Query($optsql)) $InsertDB1->Error();
	$InsertDB1->Free();

} //fi state=1
else
{
 echo "<BR><BR><BR>Ostrzezenie!!!!!<BR><BR><BR>",
	 "Oy! What are you doing? $REMOTE_ADDR <BR>";
} //else state
include_once("./footer.php");
?>
