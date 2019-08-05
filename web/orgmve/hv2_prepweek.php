<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$WeekNo = $_GET['week'];

$dataod = substr($_GET['od'],0,10);
$datado =substr($_GET['do'],0,10);
$rok = substr($_GET['do'],0,4);

function RecountLastWeek ($rok, $dataod, $datado) {
$db = new CMySQL;
$db1 = new CMySQL;
$db2 = new CMySQL;
$db3 = new CMySQL;
$db4 = new CMySQL;
$db6 = new CMySQL;
echo "<font class='FormHeaderFont'>Recounting previous week in progres.....<BR></font>";
// petla dla kazdego pracownika !!!!!!!!!!!!!!!!!!!!!!---------------------------------------------------
if (!$db->Open()) $db->Kill();
$prac1 =("SELECT `ID`, `pno`, `firstname`, `surname`, `knownas`, `status` FROM `nombers` ORDER BY `pno`");
if ($db->Query($prac1)){
while ($emploee=$db->Row())
{
$nr=$emploee->pno;

// kasowanie tabeli ------------???--------------------------------------------------------------------------
if (!$db1->Open()) $db1->Kill();
$sql0 ="DELETE FROM `sumofweek` WHERE `sumofweek`.`no`='$nr' AND `sumofweek`.`year` = '$rok' ";
if (!$db1->Query($sql0)) $db1->Kill(); 

// wybranie danych do przeniesienia do tabeli ------------------------------------------------------------
if (!$db2->Open()) $db2->Kill();
$sql1 ="SELECT `dataod`, `datado`, `weekno`  FROM `weeksno` WHERE `dataod`>='$dataod' AND `dataod`<='$datado' ";
if (!$db2->Query($sql1)) $db2->Kill();
while ($row1=$db2->Row())
{
	$weekNomber=$row1->weekno;
	$daysInTheWeek=0;
	$sumFromaWeek=0;
	if (!$db3->Open()) $db3->Kill();
	$sql4 ="SELECT  COUNT(`no`) AS ile, SUM(`workedtime`) AS wd FROM `totals` WHERE `no`='$nr' AND `date1`>='$row1->dataod' AND `date1`<='$row1->datado'  ";
	if (!$db3->Query($sql4)) $db3->Kill();
	while ($row4=$db3->Row())
		{
		//	echo "	<TR><TD>$no</TD><TD>$weekNomber</TD><TD>$row4->ile</TD><TD>$row4->wd</TD></TR>";
		$sumFromaWeek = $sumFromaWeek + $row4->wd;
		$daysInTheWeek = $daysInTheWeek + $row4->ile;
		$DaysWorked=$row4->ile;
		} 

	if (!$db6->Open()) $db6->Kill();
	$hol ="SELECT  COUNT(`no`) AS ile, SUM(`hourgiven`) AS wd FROM `holidays` WHERE `no`='$nr' AND `hourgiven`<>0 AND `sortof`='PL' AND `date1`>='$row1->dataod' AND `date1`<='$row1->datado'  ";
	if (!$db6->Query($hol)) $db6->Kill();
	while ($row6=$db6->Row())
		{
		//	echo "	<TR><TD>$no</TD><TD>$weekNomber</TD><TD>$row6->ile</TD><TD>$row6->wd</TD></TR>";
		$sumFromaWeek = $sumFromaWeek + $row6->wd;
		$daysInTheWeek = $daysInTheWeek + $row6->ile;
		$DaysPL=$row6->ile;
		} 

	if( $sumFromaWeek == 0 ) { //echo "0";
	}
	else { 
		if (!$db4->Open()) $db4->Kill();				
		$zapytanie="INSERT INTO `sumofweek` ( `id` , `week` , `days` , `sumhour` , `Wkd`, `PL`, `no` , `year` )VALUES (NULL , '$weekNomber', '$daysInTheWeek', '$sumFromaWeek',  '$DaysWorked', '$DaysPL', '$nr', '$rok');";
	if (!$db4->Query($zapytanie)) $db4->Kill();
	$db4->Free();
	}
} 

} // koniec while dla kazdego prac _____________________
} // koniec petli dla kazdego pracownika -------------------------------------------------------------------
} //end of the function

RecountLastWeek ($rok, $dataod, $datado);

echo "<script language='javascript'>window.location=\"end.php?startd=$dataod&endd=$datado\"</script>";

?>