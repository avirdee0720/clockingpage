<?php
include_once("./header.php");
$tytul='Averages 1<BR><BR>';
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
list($day, $month, $year) = explode("/",$_POST['startd']);
$dod = "$year-$month-$day";
list($day1, $month1, $year1) = explode("/",$_POST['endd']);
$ddo= "$year1-$month1-$day1";
$sd=$_POST['startd'];
$ed=$_POST['endd'];

$db1 = new CMySQL; 
$db2 = new CMySQL; 

echo "<H3>Punctuality in period: ".$sd." to ".$ed."</H3>";
echo "<TABLE><tr><td>CL no</td><td>IN</td><td>OUT</td><td>TOTAL DAYS</td><td>WEEKEND DAYS</td><td>Punct %</td></td><td> &nbsp;</td></tr>";


if (!$db1->Open()) $db1->Kill();
$prac1 =("SELECT `ID`, `pno`, `firstname`, `surname`, `knownas`, `status`, `puncbonus`, `daylyrate`, `paystru`, `left1` FROM `nombers` ORDER BY `pno` ASC");
if (!$db1->Query($prac1)) $db1->Kill();
while ($emp=$db1->Row())
{
    if (!$db2->Open()) $db2->Kill();
	$TimesInDay =("SELECT MIN(`intime`) AS inti, MAX(`outtime`) AS outti, `date1` 
	FROM `inout`  WHERE `inout`.`date1`>='$dod' 
	AND `inout`.`date1`<='$ddo' AND  `no`='$emp->pno' 
	GROUP BY `date1`");
	if (!$db2->Query($TimesInDay)) $db2->Kill();	
	$AllDays = $db2->Rows();
	$Counter=0;
	while ($TID=$db2->Row())
	{
		$HourIn = $TID->inti ;
		$MinIn = $TID->inti ;
		$HourOut = $TID->outti ;
		$MinOut = $TID->outti ;
		$Counter++;
	}
	$inTime="";
	$outTime="";
	echo "<tr><td>$emp->pno</td><td>$itTime</td><td>$outTime</td><td>$alldayst</td><td>$wdt</td><td>$punctualpercent % </td><td>&nbsp;</td></tr>";
} // end procesing an employee
//---- end of database data
echo "</TABLE>";
} //fi state=1
else
{
 echo "<BR><BR><BR>Ostrze¿enie!!!!!<BR><BR><BR>",
	 "Oy! What are you doing? $REMOTE_ADDR <BR>";
} //else state
include_once("./footer.php");
?>