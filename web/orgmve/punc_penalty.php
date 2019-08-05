<?php
include_once("./header.php");
$tytul='Punctuality PENALTY NEW Scale, count, store, and export (display)<BR><BR>';
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
list($day, $month, $year) = explode("/",$startd);
$dod = "$year-$month-$day";
list($day1, $month1, $year1) = explode("/",$endd);
$ddo= "$year1-$month1-$day1";

$PuncBonusDB = new CMySQL; 
$PuncBonusDB1 = new CMySQL; 
$PuncBonusDB2 = new CMySQL; 
$PuncBonusDB3 = new CMySQL; 
$PuncBonusDB4 = new CMySQL; 
$InsertDB = new CMySQL; 
$InsertDB1 = new CMySQL; 
$PuncBonusAllempDBl = new CMySQL; 
echo "<TABLE><tr><td>CL no</td><td>TIME WORKED</td><td>WEEKEND TIME</td><td>TOTAL DAYS</td><td>WEEKEND DAYS</td><td>Punct %</td></td><td>Punct Deduct</td></tr>";

		$minweight=0;
	if (!$PuncBonusDB4->Open()) $PuncBonusDB4->Kill();
		$minwsql = "SELECT `minweight` FROM `th_cfg` LIMIT 1";
		if (!$PuncBonusDB4->Query($minwsql)) $PuncBonusDB4->Kill();
		$minw=$PuncBonusDB4->Row();
		$minweight=$minw->minweight;

if (!$PuncBonusAllempDBl->Open()) $PuncBonusAllempDBl->Kill();
$prac1 =("SELECT `ID`, `pno`, `firstname`, `surname`, `knownas`, `status`, `puncbonus`, `daylyrate`, `paystru`, `left1`, `newpuncbonus` FROM `nombers` ORDER BY `pno` ASC");
if (!$PuncBonusAllempDBl->Query($prac1)) $PuncBonusAllempDBl->Kill();
while ($emp=$PuncBonusAllempDBl->Row())
{
		$workedt=0;
		$weekendst=0;
		$alldayst=0; 
		$wdt=0;
		$punctualpercent=0;
		if (!$PuncBonusDB->Open()) $PuncBonusDB->Kill();
	$export = "SELECT `no` , SUM( `workedtime` ) AS worked, SUM( `saturday` ) + SUM( `sunday` ) AS weekends, COUNT( `no` ) AS alldays, COUNT(`sunday`<>0) AS wd FROM `totals`  WHERE `date1`>='$dod' AND `date1`<='$ddo' AND `no`='$emp->pno' GROUP BY `no` ORDER BY `no` ASC";

	if (!$PuncBonusDB->Query($export)) $PuncBonusDB->Kill();
	//$line = "";
    while ($row=$PuncBonusDB->Row())
    {
	$PuncBonusDB1->Free();
	$PuncBonusDB2->Free();

	if (!$PuncBonusDB1->Open()) $PuncBonusDB1->Kill();
		$weekend = "SELECT COUNT(`saturday`) AS wd FROM `totals`  WHERE `date1`>='$dod' AND `date1`<='$ddo' AND `no`='$row->no' AND `saturday`<>'0' GROUP BY `no` ORDER BY `no` ASC";
		if (!$PuncBonusDB1->Query($weekend)) $PuncBonusDB1->Kill();
		$soboty=$PuncBonusDB1->Row();

	if (!$PuncBonusDB1->Open()) $PuncBonusDB1->Kill();
		$weekend = "SELECT COUNT(`sunday`) AS wd FROM `totals`  WHERE `date1`>='$dod' AND `date1`<='$ddo' AND `no`='$row->no' AND `sunday`<>'0' GROUP BY `no` ORDER BY `no` ASC";
		if (!$PuncBonusDB1->Query($weekend)) $PuncBonusDB1->Kill();
		$niedziele=$PuncBonusDB1->Row();
	$hoursgiven=0;
	if (!$PuncBonusDB3->Open()) $PuncBonusDB3->Kill();
		$holidsql = "SELECT `no` , SUM(`hourgiven`) AS hoursg FROM `holidays` WHERE `holidays`.`no` ='$row->no' AND `holidays`.`date1` >='$dod' AND `holidays`.`date1` <='$ddo' GROUP BY `no` ORDER BY `no` ASC";
		if (!$PuncBonusDB3->Query($holidsql)) $PuncBonusDB3->Kill();
		$holidays=$PuncBonusDB3->Row();
                if (!isset($holidays->hoursg)) $hoursgiven = 0; else $hoursgiven = $holidays->hoursg;

		if (!$PuncBonusDB2->Open()) $PuncBonusDB2->Kill();
			$percent0 = "SELECT `intime` FROM `totals` WHERE `date1`>='$dod' AND `date1`<='$ddo' AND `no`='$row->no' ORDER BY `intime` ASC";
		if (!$PuncBonusDB2->Query($percent0)) $PuncBonusDB1->Kill();
		$punctualpercent=0;
		$punctualpercent2=0;
		$przedczasem=0;
		$poczasie=0;
		$alldaysINOUT=$PuncBonusDB2->Rows();
	    while ($percent=$PuncBonusDB2->Row())
		    {
			if(strtotime("$percent->intime") < strtotime("10:00:00"))
				{ $przedczasem++; }
			else { $poczasie++; }
			} // calkiem wew petla end number_format($h2,2,'.',' ');
	    $punctualpercent = number_format($przedczasem / $alldaysINOUT,2,'.',' ')*100;
	    $punctualpercent2 = $przedczasem / $alldaysINOUT;		
		$workedt=$row->worked;
		$weekendst=$row->weekends; 
		$alldayst=$row->alldays;
                if (!isset($soboty->wd)) $sobotywd = 0; else $sobotywd = $soboty->wd;
                if (!isset($niedziele->wd)) $niedzielewd = 0; else $niedzielewd = $niedziele->wd;
		$wdt=$sobotywd + $niedzielewd;
	}

# start count punctuality bonus
# if OLD / NEW scale
$PunctualityDeduction =  0 ;
if($punctualpercent < 70) { 
if($emp->puncbonus==1) { 
if($emp->paystru=="NEW")
	{
	$HourlyRateWithBonus = $emp->daylyrate / 8.5;
	$PunctDeduction = $minweight * $emp->newpuncbonus;
	$HourlyRateAfterDeduction = round($HourlyRateWithBonus - $PunctDeduction,2);
	if($HourlyRateAfterDeduction < $minweight) $HourlyRateAfterDeduction = $minweight;
	$HoursTogether = $workedt + $hoursgiven;
	$GrossPayWithBonus = $HoursTogether * $HourlyRateWithBonus;
	$GrosPayAfterDeduction = $HoursTogether * $HourlyRateAfterDeduction;
	$PunctualityDeduction = number_format($GrossPayWithBonus - $GrosPayAfterDeduction,2,'.',' ');
 	}
	else { 
		//echo "$emp->pno : error in pay structure or OLD structure <BR>"; 

		}
} else { $punctBonus = 0;} 
} else { 
	$PunctualityDeduction =  0 ;

} 
	
if($PunctualityDeduction > 0.1 && $workedt > 0) { 
echo "<tr><td>$emp->pno</td><td>$HoursTogether</td><td>$weekendst</td><td>$alldayst</td><td>$wdt</td><td>$punctualpercent% </td><td>$PunctualityDeduction	</td></tr>";
//insert value to the database

		//echo "<tr><td>$emp->pno</td><td>$HoursTogether</td><td>$weekendst</td><td>$alldayst</td><td>$wdt</td><td>$punctualpercent% </td><td>$PunctualityDeduction&nbsp;with bonus: $GrossPayWithBonus &nbsp; no bonus: $GrosPayAfterDeduction 	&nbsp;PunctDeduction=$PunctDeduction ($emp->daylyrate - $HourlyRateAfterDeduction), HourlyRateWithBonus=$HourlyRateWithBonus 	</td></tr>";

	if (!$InsertDB1->Open()) $InsertDB1->Kill();
	$delsql="DELETE FROM `paypunctuality` WHERE `no`='$emp->pno' AND `date1`='$ddo' AND `sageno`='14'";
	if (!$InsertDB1->Query($delsql)) //$InsertDB1->Error();
	$InsertDB1->Free();
	if (!$InsertDB->Open()) $InsertDB->Kill();
	$inserttodb="INSERT INTO `paypunctuality` ( `id` , `no` , `monetarytotal` , `punctprc` , `hours` , `days` , `daysintime` , `type` , `sageno`, `date1` )VALUES (NULL , '$emp->pno', '$PunctualityDeduction','$punctualpercent', '$HoursTogether',  '$alldaysINOUT', '$przedczasem', 'deduction', '14', '$ddo')";
	if (!$InsertDB->Query($inserttodb)) $InsertDB->Kill();

 }

} // koniec dla prac
echo "</TABLE>";
	if (!$InsertDB1->Open()) $InsertDB1->Kill();
	$optsql="OPTIMIZE TABLE `paypunctuality` ";
	if (!$InsertDB1->Query($optsql)) $InsertDB1->Error();
	$InsertDB1->Free();
} //fi state=1
else
{
 echo "<BR><BR><BR>Ostrze�enie!!!!!<BR><BR><BR>",
	 "Oy! What are you doing? $REMOTE_ADDR <BR>";
} //else state
include_once("./footer.php");
?>