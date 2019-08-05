<?php
include_once("./header.php");
include("./config.php");
include("./languages/$LANGUAGE.php");

list($day1, $month1, $year1) = explode("/",$_GET['endd']);
$ddo= "$year1-$month1-$day1";
$ed=$_GET['endd'];

$PayDB1 = new CMySQL; 
$PayDB2 = new CMySQL; 
$PayDB3 = new CMySQL; 
$PayDB4 = new CMySQL; 
$PayDB5 = new CMySQL; 
$PayDB6 = new CMySQL; 
$PayDB7 = new CMySQL; 
$allempl = new CMySQL; 

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=additions" .$ddo.".xls");
header("Pragma: no-cache");
header("Expires: 0");
	echo "<TABLE><tr><td>Employee Reference</td><td>Payment Reference</td><td>Hours</td></tr>";
			
	if (!$PayDB1->Open()) $PayDB1->Kill();
		$paysql1= "SELECT `id`, `no`, `monetarytotal`, `hours`, `hourlyrate`, `sageno`, `date1` FROM `paybasic` WHERE `date1`='$ddo' AND `monetarytotal`<>0";
		if (!$PayDB1->Query($paysql1)) $PayDB1->Kill();
		while($paybasic=$PayDB1->Row())
		{
			$ClockingNO = $paybasic->no;
			$BonusesID = $paybasic->id;
			$Bonuses = $paybasic->hours;
			$BonusesREF = $paybasic->sageno;
				
			if($Bonuses > 0.1) {
				echo "<tr><td>$ClockingNO</td><td>$BonusesREF</td><td>$Bonuses</td><td>&nbsp; </td></tr>"; 
			}
		}
		$PayDB1->Free();

	if (!$PayDB2->Open()) $PayDB2->Kill();
		$paysql2 = "SELECT `id`, `no`, `monetarytotal`, `punctprc`, `hours`, `days`, `daysintime`, `type`, `sageno`, `date1` FROM `paypunctuality` WHERE `date1`='$ddo' AND `type` LIKE 'addition'  AND `monetarytotal`<>0";
		if (!$PayDB2->Query($paysql2)) $PayDB2->Kill();
		while( $paypunctuality = $PayDB2->Row() )
		{	
			$ClockingNO = $paypunctuality->no;
			$BonusesID = $paypunctuality->id;
			$Bonuses = $paypunctuality->monetarytotal;
			$BonusesREF = $paypunctuality->sageno;
			echo "<tr><td>$ClockingNO</td><td>$BonusesREF</td><td>$Bonuses</td></tr>"; 
		}
		$PayDB2->Free();

	if (!$PayDB3->Open()) $PayDB3->Kill();
		$paysql3 = "SELECT `id`, `no`, `monetarytotal`, `sumhoursgiven`, `sageno`, `date1` FROM `payholidays` WHERE `date1`='$ddo' AND `monetarytotal`<>0";
		if (!$PayDB3->Query($paysql3)) $PayDB3->Kill();
		while( $payholidays = $PayDB3->Row() )
		{	
			$ClockingNO = $payholidays->no;
			$BonusesID = $payholidays->id;
			$Bonuses = $payholidays->monetarytotal;
			$BonusesREF = $payholidays->sageno;
			echo "<tr><td>$ClockingNO</td><td>$BonusesREF</td><td>$Bonuses</td></tr>"; 
		}
		$PayDB3->Free();

	if (!$PayDB4->Open()) $PayDB4->Kill();
		$paysql4 = "SELECT `id`, `no`, `saturdaysalltodate`, `sundaysalltodate`, `holidaydaystodate`, `weekenddaystodate`, `stucture`, `bonusyearstarted`, `toadd`, `wendbonus`, `wrate`, `weekendhours`, `wdaysthismonth`, `sageno`, `date1` FROM `paywendbonus` WHERE `date1`='$ddo' AND `wendbonus`<>0";
		if (!$PayDB4->Query($paysql4)) $PayDB4->Kill();
		while( $paywendbonus = $PayDB4->Row() )
		{	
			$ClockingNO = $paywendbonus->no;
			$BonusesID = $paywendbonus->id;
			$Bonuses = $paywendbonus->wendbonus;
			$BonusesREF = $paywendbonus->sageno;
			echo "<tr><td>$ClockingNO</td><td>$BonusesREF</td><td>$Bonuses</td></tr>"; 
		}
		$PayDB4->Free();

	if (!$PayDB5->Open()) $PayDB5->Kill();
		$paysql5 = "SELECT `id`, `no`, `monetarytotal`, `weekendhours`, `startdwls`, `enddwls`, `sageno`, `date1` FROM `paywendlumpsum` WHERE `date1`='$ddo' AND `monetarytotal`<>0";
		if (!$PayDB5->Query($paysql5)) $PayDB5->Kill();
		while( $paywendlumpsum = $PayDB5->Row() )
		{	
			$ClockingNO = $paywendlumpsum->no;
			$BonusesID = $paywendlumpsum->id;
			$Bonuses = $paywendlumpsum->monetarytotal;
			$BonusesREF = $paywendlumpsum->sageno;
			echo "<tr><td>$ClockingNO</td><td>$BonusesREF</td><td>$Bonuses</td></tr>"; 
		}
		$PayDB5->Free();

	if (!$PayDB6->Open()) $PayDB6->Kill();
		$paysql6 = "SELECT `id`, `no`, `taxablevouchers`, `tvsagepay`, `date1` FROM `payvoucher` WHERE `date1`='$ddo' AND `withold`<>'y'";
		if (!$PayDB6->Query($paysql6)) $PayDB6->Kill();
		while( $payvouchers = $PayDB6->Row() )
		{	
			$ClockingNO = $payvouchers->no;
			$BonusesID = $payvouchers->id;
			$Bonuses = $payvouchers->taxablevouchers;
			$BonusesREF = $payvouchers->tvsagepay;
			echo "<tr><td>$ClockingNO</td><td>$BonusesREF</td><td>$Bonuses</td></tr>"; 
		}
		$PayDB6->Free();
                
        if (!$PayDB7->Open()) $PayDB7->Kill();
		$paysql7 = "SELECT `id`, `no`, `monetarytotal`, `hours`, `prevbasicpay`, `daysintime`, `type`, `sageno`, `date1` FROM `paybonuses` WHERE `date1`='$ddo' AND `monetarytotal`<>0";
		if (!$PayDB7->Query($paysql7)) $PayDB7->Kill();
		while( $paybonuses = $PayDB7->Row() )
		{	
			$ClockingNO = $paybonuses->no;
			$BonusesREF = $paybonuses->sageno;
			if($BonusesREF==20) { $Bonuses = ""; $Rate = $paybonuses->hours;}
			else { $Bonuses = $paybonuses->monetarytotal; $Rate = 1; }		
//pay atention
			echo "<tr><td>$ClockingNO</td><td>$BonusesREF</td><td>$Rate</td><td>$Bonuses</td></tr>"; 
		}
		$PayDB7->Free();                
echo "</TABLE>";

?>