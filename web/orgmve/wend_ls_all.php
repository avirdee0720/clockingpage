<?php
include_once("./header.php");
$tytul='Weekend LUMP SUM COUT FOR ALL';
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

	echo "<H3>Counting Weekend Lump Sum</H3>";

	echo "<TABLE><TR><TD>CL NO</TD><TD>WeekendBonus</TD><TD>PayStru</TD><TD>Days</TD><TD>Hours:</TD><TD>BONUS</TD></TR>";
		$minweight=0;
	if (!$db4->Open()) $db4->Kill();
		$minwsql = "SELECT `minweight` FROM `th_cfg` LIMIT 1";
		if (!$db4->Query($minwsql)) $db4->Kill();
		$minw=$db4->Row();
		$minweight=$minw->minweight;

if (!$allempl->Open()) $allempl->Kill();
$prac1 =("SELECT `ID`, `pno`, `firstname`, `surname`, `knownas`, `status`, `started`, `left1`, `wrate` FROM `nombers` ORDER BY `pno` ASC");
if (!$allempl->Query($prac1)) $allempl->Kill();
while ($emp=$allempl->Row())
{
$clockinginno = $emp->pno;
$WeekendRate = $emp->wrate;

	unset($weekend);
	if (!$db1->Open()) $db1->Kill();
		$weekend = "SELECT SUM(`totals`.`saturday`) + SUM(`totals`.`sunday`) AS hours, (SUM(`totals`.`saturday`) + SUM(`totals`.`sunday`)) AS LUMPSUM FROM `totals` WHERE `date1`>='$dod' AND `date1`<='$ddo' AND `no`='$clockinginno' GROUP BY `no`";
		if (!$db1->Query($weekend)) $db1->Kill();
		$WorkWeekends=$db1->Row();
                if (!isset($WorkWeekends->hours)) $WorkingHours = 0; else $WorkingHours = $WorkWeekends->hours;
                if (!isset($WorkWeekends->LUMPSUM)) $WorkingWendLS = 0; else $WorkingWendLS = $WorkWeekends->LUMPSUM;
	$db1->Free();

	unset($weekend2);
	if (!$db1->Open()) $db1->Kill();
		$weekend2 = "SELECT `no`, COUNT(*) as dni FROM `totals` WHERE `date1`>='$dod' AND `date1`<='$ddo' AND `no`='$clockinginno' AND (`sunday`<>'0' OR `saturday`<>'0') group by `no`";
		if (!$db1->Query($weekend2)) $db1->Kill();
		$WorkWeekendDays=$db1->Row();
                if (!isset($WorkWeekendDays->dni)) $WorkingWDays = 0; else $WorkingWDays = $WorkWeekendDays->dni;
	$db1->Free();

	unset($holidsql);
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
			}
		$db3->Free();

	 $WeekenDayTotal = $WorkingWDays + $SundayDaysHP + $SaturdayDaysHP;
	 $WeekendHoursTotal = $WorkingHours + $SundayHoliday + $SaturdayHoliday;

// main part - counting
	if (!$WeekendHoursTotal==0) {
		$WeekendLUMPSUM = $WeekendHoursTotal * $WeekendRate;
		if(!$WeekendLUMPSUM==0) {
			echo "NO: $emp->pno, Days: $WeekenDayTotal, LUMPSUM = $WeekendLUMPSUM DAYS: $WeekendHoursTotal<BR>";

			if (!$InsertDB1->Open()) $InsertDB1->Kill();
			$delsql="DELETE FROM `wendlumpsum` WHERE `no`='$emp->pno' AND `date1`='$ddo' AND `sageno`='0'";
			if (!$InsertDB1->Query($delsql)) $InsertDB1->Free();
			if (!$InsertDB->Open()) $InsertDB->Kill();	
			$inserttodb="INSERT INTO `wendlumpsum` ( `id` , `no` , `monetarytotal` , `weekendhours` , `wrate` , `sageno` , `date1` ) VALUES (NULL , '$emp->pno', '$WeekendLUMPSUM', '$WeekendHoursTotal', '$WeekendRate', '0', '$ddo')";
			if (!$InsertDB->Query($inserttodb)) $InsertDB->Kill();

		}
	}

} // koniec dla prac
echo "</TABLE>";

	if (!$InsertDB1->Open()) $InsertDB1->Kill();
	$optsql="OPTIMIZE TABLE `wendlumpsum` ";
	if (!$InsertDB1->Query($optsql)) $InsertDB1->Error();
	$InsertDB1->Free();} //fi state=1

else
{
 echo "<BR><BR><BR>Ostrze�enie!!!!!<BR><BR><BR>",
	 "Oy! What are you doing? $REMOTE_ADDR <BR>";
} //else state
include_once("./footer.php");
?>