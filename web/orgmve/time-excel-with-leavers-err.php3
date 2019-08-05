<?php
include_once("./header.php");
$tytul='Enter start date and end date for exporting data<BR><BR>';
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
//include("./config.php");
//include("./languages/$LANGUAGE.php");
$dataakt=date("dmY-Hi");
list($day, $month, $year) = explode("/",$_POST['startd']);
$dod = "$year-$month-$day";
list($day1, $month1, $year1) = explode("/",$_POST['endd']);
$ddo= "$year1-$month1-$day1";
$sd=$_GET['startd'];
$ed=$_GET['endd'];

$db = new CMySQL; 
$db1 = new CMySQL; 
$db2 = new CMySQL; 
 $allempl = new CMySQL; 
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=times" .$dataakt.".xls");
	header("Pragma: no-cache");
	header("Expires: 0");
	echo "<TABLE><tr><td>CL no</td><td>TIME WORKED</td><td>WEEKEND TIME</td><td>TOTAL DAYS</td><td>WEEKEND DAYS</td><td>Punct %</td></tr>";

if (!$allempl->Open()) $allempl->Kill();
$prac1 =("SELECT `ID`, `pno`, `firstname`, `surname`, `knownas`, `status` FROM `nombers` ORDER BY `pno` ASC");
if (!$allempl->Query($prac1)) $allempl->Kill();
while ($emp=$allempl->Row())
{
  if (!$db->Open()) $db->Kill();
	$export = "SELECT `no` , SUM( `workedtime` ) AS worked, SUM( `saturday` ) + SUM( `sunday` ) AS weekends, COUNT( `no` ) AS alldays, COUNT(`sunday`<>0) AS wd FROM `totals`  WHERE `date1`>='$dod' AND `date1`<='$ddo' AND `no`='$emp->pno' GROUP BY `no` ORDER BY `no` ASC";

	if (!$db->Query($export)) $db->Kill();
	//$line = "";
    while ($row=$db->Row())
    {
	$workedt=0;
	$weekendst=0;
	$alldayst=0;
	$wdt=0;
	$punctualpercent=0;
	if (!$db1->Open()) $db1->Kill();
		$weekend = "SELECT COUNT(`saturday`)+COUNT(`sunday`) AS wd FROM `totals`  WHERE `date1`>='$dod' AND `date1`<='$ddo' AND `no`='$row->no' AND `saturday`<>'0' AND `sunday`='0' GROUP BY `no` ORDER BY `no` ASC";
		if (!$db1->Query($weekend)) $db1->Kill();
		$wd=$db1->Row();

		if (!$db2->Open()) $db2->Kill();
			$percent0 = "SELECT `intime` FROM `totals` WHERE `date1`>='$dod' AND `date1`<='$ddo' AND `no`='$row->no' ORDER BY `intime` ASC";
		if (!$db2->Query($percent0)) $db1->Kill();
		$punctualpercent=0;
		$przedczasem=0;
		$poczasie=0;
	    while ($percent=$db2->Row())
		    {
			if(strtotime("$percent->intime") < strtotime("10:01:00"))
				{ $przedczasem++; }
			else { $poczasie++; }
			} // calkiem wew petla end number_format($h2,2,'.',' ');
	    $punctualpercent = number_format($przedczasem / $row->alldays,2,'.',' ')*100;
	 //$data = $data.$line; 
	$workedt=$row->worked;
	$weekendst=$row->weekends;
	$alldayst=$row->alldays;
	$wdt=$wd->wd;
	//$punctualpercent
	}
	echo "<tr><td>$emp->pno</td><td>$workedt</td><td>$weekendst</td><td>$alldayst</td><td>$wdt</td><td>$punctualpercent%</td></tr>";

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