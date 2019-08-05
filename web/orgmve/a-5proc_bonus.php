<?php
include_once("./header.php");
include("./config.php");
include("./languages/$LANGUAGE.php");

$dataakt=date("dmY-Hi");
$today=date("Y-m-d");
list($day, $month, $year) = explode("/",$_POST['startd']);
$dod = "$year-$month-$day";
list($day1, $month1, $year1) = explode("/",$_POST['endd']);
$ddo= "$year1-$month1-$day1";
$sd=$_GET['startd'];
$ed=$_GET['endd'];

	list($y1, $m1, $d1 ) = explode("-",$dod);
	$dod34 = "$y1-$m1-$d1";
	$LastM = date("Y-m",mktime(0, 0, 0, $m1-1, 01,  $y1));

// ------------- new DB class declare
$bonus5db1 = new CMySQL; 
$bonus5db4 = new CMySQL; 
$bonus5allempl = new CMySQL; 
$InsertDB = new CMySQL; 
$InsertDB1 = new CMySQL; 

	echo "<H3>5% bonus, count $sd to $ed</H3> ";
	echo "<TABLE><TR><TD>CL NO</TD><TD>Firstname</TD><TD>Surname</TD><TD>Last gross Pay</TD><TD>BONUS</TD></TR>";
		$minweight=0;
	if (!$bonus5db4->Open()) $bonus5db4->Kill();
		$minwsql = "SELECT `minweight` FROM `th_cfg` LIMIT 1";
		if (!$bonus5db4->Query($minwsql)) $bonus5db4->Kill();
		$minw=$bonus5db4->Row();
		$minweight=$minw->minweight;

if (!$bonus5allempl->Open()) $bonus5allempl->Kill();
$prac1 =("SELECT `ID`, `pno`, `firstname`, `surname`, `knownas`, `status`,  `bonus5`, `bonus7` FROM `nombers` ORDER BY `pno` ASC");
if (!$bonus5allempl->Query($prac1)) $bonus5allempl->Kill();
while ($emp=$bonus5allempl->Row())
{
$clockinginno=$emp->pno;
if( $emp->bonus5 == 1 ) { 

	if (!$bonus5db1->Open()) $bonus5db1->Kill();
		$grossP = "SELECT  `monetarytotal` FROM `paybasicgross` WHERE `no` ='$clockinginno' AND `date1` LIKE '$LastM%'";
		if (!$bonus5db1->Query($grossP)) $bonus5db1->Kill();
		$Gross=$bonus5db1->Row();
		$LastGrossPay=$Gross->monetarytotal;
	$bonus5db1->Free();
		$ProcBonus = number_format($LastGrossPay * 0.05,2,'.','');

} else { $ProcBonus = "0";} 

	if($ProcBonus > 0.1) { echo "<TR><TD>$emp->pno</TD><TD>$emp->firstname</TD><TD>$emp->surname </TD> <TD> $LastGrossPay </TD><TD> £ $ProcBonus</TD></TR>"; 
	
		if (!$InsertDB1->Open()) $InsertDB1->Kill();
			$delsql="DELETE FROM `paybonuses` WHERE `no`='$emp->pno' AND `date1`='$ddo' AND `sageno`='12'";
			if (!$InsertDB1->Query($delsql)) $InsertDB1->Free();
			if (!$InsertDB->Open()) $InsertDB->Kill();	
			$inserttodb="INSERT INTO `paybonuses` ( `id` , `no` , `monetarytotal` , `hours` , `prevbasicpay` , `daysintime` , `type` , `sageno` , `date1` ) VALUES (NULL , '$emp->pno', '$ProcBonus','0', '$LastGrossPay', '0', '5', '12', '$ddo')";
			if (!$InsertDB->Query($inserttodb)) $InsertDB->Kill();
		}

	unset($emp->bonus5);
	unset($LastGrossPay);
	unset($ProcBonus);
	unset($BonusYearStart);

} // koniec dla prac
echo "</TABLE>";
	if (!$InsertDB1->Open()) $InsertDB1->Kill();
	$optsql="OPTIMIZE TABLE `paypunctuality` ";
	if (!$InsertDB1->Query($optsql)) $InsertDB1->Error();
	$InsertDB1->Free();

?>