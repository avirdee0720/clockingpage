<?php
include_once("./header.php");
$tytul='Enter start date and end date for exporting data<BR><BR>';
//include("./inc/uprawnienia.php");
include("./config.php");
include("./languages/$LANGUAGE.php");

error_reporting(E_ERROR | E_WARNING | E_PARSE);

list($day1, $month1, $year1) = explode("/",$_GET['endd']);
$ddo= "$year1-$month1-$day1";
$ed=$_GET['endd'];

$PayDB2 = new CMySQL; 
$PayDB7 = new CMySQL; 
$PayDB8 = new CMySQL; 
$PayDB9 = new CMySQL; 
$allempl = new CMySQL; 
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=deductions" .$ddo.".xls");
	header("Pragma: no-cache");
	header("Expires: 0");
	echo "<TABLE><tr><td>Employee Reference</td><td>Deduction Reference</td><td>Hours</td><td>Rate</td></tr>";
			

if (!$allempl->Open()) $allempl->Kill();
$prac1 =("SELECT `ID`, `pno`, `firstname`, `surname`, `knownas`, `status` FROM `nombers` ORDER BY `pno` ASC");
if (!$allempl->Query($prac1)) $allempl->Kill();
while ($emp=$allempl->Row())
{
	$ClockingNO = $emp->pno;
	if (!$PayDB2->Open()) $PayDB2->Kill();
		$paysql2 = "SELECT `id`, `no`, `monetarytotal`, `punctprc`, `hours`, `days`, `daysintime`, `type`, `sageno`, `date1` FROM `paypunctuality` WHERE `date1`='$ddo' AND `no`='$ClockingNO' AND `type` LIKE 'deduction'";
		if (!$PayDB2->Query($paysql2)) $PayDB2->Kill();
		$paypunctuality=$PayDB2->Row();
		$BonusesID = $paypunctuality->id;
		$Bonuses = $paypunctuality->monetarytotal;
		$BonusesREF = $paypunctuality->sageno;
	$PayDB2->Free();

if($Bonuses > 0.1) {
	echo "<tr><td>$ClockingNO</td><td>$BonusesREF</td><td>1 </td><td>$Bonuses</td></tr>"; 
}

} // koniec dla prac

	if (!$PayDB8->Open()) $PayDB8->Kill();
		$paysql8 = "SELECT `id`, `no`, `taxablevouchers`, `tvsageded`, `date1` FROM `payvoucher` WHERE `date1`='$ddo' AND `withold`<>'y'";
		if (!$PayDB8->Query($paysql8)) $PayDB8->Kill();
		while( $payvouchers = $PayDB8->Row() )
		{	
			$CNO = $payvouchers->no;
			$VID = $payvouchers->id;
			$taxablevouchers = $payvouchers->taxablevouchers;
			$SageREF = $payvouchers->tvsageded;
			echo "<tr><td>$CNO</td><td>$SageREF</td><td>1 </td><td>$taxablevouchers</td></tr>"; 
		}
		$PayDB8->Free();

	if (!$PayDB9->Open()) $PayDB9->Kill();
		$paysql9 = "SELECT `id`, `no`, `voucherpayment`, `vpsageded`, `date1` FROM `payvoucher` WHERE `date1`='$ddo' AND `withold`<>'y'";
		if (!$PayDB9->Query($paysql9)) $PayDB9->Kill();
		while( $payvouchers = $PayDB9->Row() )
		{	
			$CNO = $payvouchers->no;
			$VID = $payvouchers->id;
			$voucherpayment = $payvouchers->voucherpayment;
			$SageREF = $payvouchers->vpsageded;
			if($voucherpayment > 0.1) {
				echo "<tr><td>$CNO</td><td>$SageREF</td><td>1 </td><td>$voucherpayment</td></tr>"; 
			}
		}
		$PayDB9->Free();

		if (!$PayDB7->Open()) $PayDB7->Kill();
		$paysql7 = "SELECT `no`, SUM(`topay`) AS totaltopay  FROM `advances` WHERE `year`='$year1' AND `month`='$month1' GROUP BY `no` ";
		if (!$PayDB7->Query($paysql7)) $PayDB7->Kill();
		while( $adv = $PayDB7->Row() )
		{	
			$CNO = $adv->no;
			$taxablevouchers = $adv->totaltopay;
			echo "<tr><td>$CNO</td><td>8</td><td>1</td><td>$taxablevouchers</td></tr>"; 
		}
		$PayDB7->Free();

echo "</TABLE>";

?>