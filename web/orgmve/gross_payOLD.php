<?php
include_once("./header.php");
$tytul='Basic Pay count, store, and export (display)<BR><BR>';
//include("./inc/uprawnienia.php");
include("./config.php");
include("./languages/$LANGUAGE.php");

$PHP_SELF = $_SERVER['PHP_SELF'];

if (!isset($_POST['state'])) $state = 0; else $state = $_POST['state'];

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
list($day, $month, $year) = explode("/",$_POST['startd']);
$dod = "$year-$month-$day";
list($day1, $month1, $year1) = explode("/",$_POST['endd']);
$ddo= "$year1-$month1-$day1";

$PuncBonusDB1 = new CMySQL; 
$PuncBonusDB2 = new CMySQL; 
$PuncBonusDB3 = new CMySQL; 
$PuncBonusAllempDBl = new CMySQL; 
$InsertDB = new CMySQL; 
$InsertDB1 = new CMySQL;

echo "<H3>Counting Basic Pay & Gross Basic Pay</H3>";
echo "<TABLE><tr><td>CL no</td><td>TOTAL TIME WORKED</td></td><td>Gross Pay</td>";

if (!$PuncBonusAllempDBl->Open()) $PuncBonusAllempDBl->Kill();
$prac1 =("SELECT `ID`, `pno`, `firstname`, `surname`, `knownas`, `status`, `left1`, `daylyrate`, `paystru` FROM `nombers` ORDER BY `pno` ASC");
if (!$PuncBonusAllempDBl->Query($prac1)) $PuncBonusAllempDBl->Kill();
while ($emp=$PuncBonusAllempDBl->Row())
{
$PuncBonusDB1->Free(); 

$ClockinNO = $emp->pno;

	//HOURSGIVN LEAVER
	$HGL=0;
	if (!$PuncBonusDB2->Open()) $PuncBonusDB2->Kill();
		$holidLsql = ("SELECT (`hg_leavers`.`daysleft` * `hg_leavers`.`hourgiven`) AS HGL0 FROM `hg_leavers` WHERE `hg_leavers`.`no` ='$ClockinNO' AND `hg_leavers`.`date1` >='$dod' AND `hg_leavers`.`date1` <='$ddo'");
		if (!$PuncBonusDB2->Query($holidLsql)) $InsertDB->Free();
		$holidaysLeavers=$PuncBonusDB2->Row();
		$HGL = $holidaysLeavers->HGL0;

	$hoursgiven=0;
	if (!$PuncBonusDB3->Open()) $PuncBonusDB3->Kill();
		$holidsql = "SELECT SUM(`hourgiven`) AS hoursg FROM `holidays` WHERE `holidays`.`no` ='$ClockinNO' AND `holidays`.`date1` >='$dod' AND `holidays`.`date1` <='$ddo' GROUP BY `no`";
		if (!$PuncBonusDB3->Query($holidsql)) $PuncBonusDB3->Kill();
		$holidaysX=$PuncBonusDB3->Row();
		$hoursgiven = $holidaysX->hoursg;

	if (!$PuncBonusDB1->Open()) $PuncBonusDB1->Kill();
		$dnisql = "SELECT SUM(`workedtime`) AS wd FROM `totals`  WHERE `date1`>='$dod' AND `date1`<='$ddo' AND `no`='$ClockinNO' GROUP BY `no`";
		if (!$PuncBonusDB1->Query($dnisql)) $PuncBonusDB1->Kill();
		$AllWorkedDays=$PuncBonusDB1->Row();
                echo "$dnisql<br>";
		$HoursWorked = $AllWorkedDays->wd;
		$HoursTogether = $hoursgiven + $HoursWorked + $HGL;
		$HolidayHours = $hoursgiven + $HGL;
		$HourlyRate = number_format($emp->daylyrate / 8.5,2,'.',' ');
		$GrossPay = $HoursTogether * $HourlyRate;
		$BasicPay = $HoursWorked * $HourlyRate;
		$HolidayPay = $HolidayHours * $HourlyRate;
		$GROSS = number_format($GrossPay,2,'.',' ');
                echo "$ClockinNO --> $HoursWorked -- $HoursTogether -- $HolidayHours -- $HourlyRate -- $GrossPay -- $BasicPay -- $HolidayPay -- $GROSS<br>";
                

if($GROSS > 0.1) { echo "<tr><td>$emp->pno</td><td>$HoursTogether = $hoursgiven + $AllWorkedDays->wd + $HGL (Leavers)</td><td>$GROSS Basic: $BasicPay | Hourly rate: <B>$HourlyRate</B>, Dayly rate: $emp->daylyrate</td></tr>";  
	if (!$InsertDB1->Open()) $InsertDB1->Kill();
	$delsql="DELETE FROM `paybasic` WHERE `no`='$emp->pno' AND `date1`='$ddo' AND `sageno`='2'";
	if (!$InsertDB1->Query($delsql)) $InsertDB1->Free();
	if (!$InsertDB->Open()) $InsertDB->Kill();
	$inserttodb="INSERT INTO `paybasic` ( `id` , `no` , `monetarytotal` , `hours`, `hourlyrate` , `sageno` , `date1` ) VALUES (NULL , '$emp->pno', '$BasicPay','$HoursWorked', '$HourlyRate','2', '$ddo')";
	if ($InsertDB->Query($inserttodb)) $InsertDB->Free();

	if($GROSS > 0.1) {
		if (!$InsertDB1->Open()) $InsertDB1->Kill();
		$delsql="DELETE FROM `payholidays` WHERE `no`='$emp->pno' AND `date1`='$ddo' AND `sageno`='4'";
		if (!$InsertDB1->Query($delsql)) $InsertDB1->Free();
		if (!$InsertDB->Open()) $InsertDB->Kill();
		$inserttodb="INSERT INTO `payholidays` ( `id` , `no` , `monetarytotal` , `sumhoursgiven` , `sageno` , `date1` ) VALUES (NULL , '$emp->pno', '$HolidayPay','$HolidayHours', '4', '$ddo')";
		if ($InsertDB->Query($inserttodb)) $InsertDB->Free();
	}
	if (!$InsertDB1->Open()) $InsertDB1->Kill();
	$delsql="DELETE FROM `paybasicgross` WHERE `no`='$emp->pno' AND `date1`='$ddo' AND `sageno`='0'";
	if (!$InsertDB1->Query($delsql)) $InsertDB1->Free();
	if (!$InsertDB->Open()) $InsertDB->Kill();
	$inserttodb="INSERT INTO `paybasicgross` ( `id` , `no` , `monetarytotal` , `hours` , `hourspl`, `hourlyrate`, `sageno` , `date1` )VALUES (NULL , '$emp->pno', '$GrossPay', '$HoursWorked', '$hoursgiven', '$HourlyRate', '0', '$ddo');";
	if ($InsertDB->Query($inserttodb))	$InsertDB->Free();
}
} // koniec dla prac

echo "</TABLE>";
	if (!$InsertDB1->Open()) $InsertDB1->Kill();
	$optsql="OPTIMIZE TABLE `paybasic` , `paybasicgross`";
	if (!$InsertDB1->Query($optsql)) $InsertDB1->Error();
	$InsertDB1->Free();


} //fi state=1
else {  echo "<BR><BR><BR>Ostrze�enie!!!!!<BR><BR><BR>", "Oy! What are you doing? $REMOTE_ADDR <BR>";
} //else state
include_once("./footer.php");
?>