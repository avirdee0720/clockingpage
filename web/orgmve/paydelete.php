<?php
include_once("./header.php");
include("./config.php");
include("./languages/$LANGUAGE.php");

list($day1, $month1, $year1) = explode("/",$_GET['endd']);
$ddo= "$year1-$month1-$day1";
$ed=$_GET['endd'];

$PayDB = new CMySQL; 
$PayDB2 = new CMySQL; 
$PayDB3 = new CMySQL; 
$PayDB4 = new CMySQL; 
$PayDB5 = new CMySQL; 
$PayDB6 = new CMySQL; 
$PayDB7 = new CMySQL; 
$PayDB8 = new CMySQL; 
$PayDB9 = new CMySQL; 
$allempl = new CMySQL; 

echo "<TABLE>";

	if (!$PayDB3->Open()) $PayDB3->Kill();
		$paysql3 = "DELETE FROM `paybasic` WHERE `date1`='$ddo'";
		if (!$PayDB3->Query($paysql3)) $PayDB3->Kill();
		echo "<tr><td>Basic Pay deleted. </td></tr>"; 

	if (!$PayDB2->Open()) $PayDB2->Kill();
		$paysql2 = "DELETE FROM `paybasicgross` WHERE `date1`='$ddo'";
		if (!$PayDB2->Query($paysql2)) $PayDB2->Kill();
		echo "<tr><td>Basic Gross Pay deleted.</td></tr>"; 

	if (!$PayDB->Open()) $PayDB->Kill();
		$paysql = "DELETE FROM `paybonuses` WHERE `date1`='$ddo'";
		if (!$PayDB->Query($paysql)) $PayDB->Kill();
		echo "<tr><td>Bonuses deleted.</td></tr>"; 

	if (!$PayDB4->Open()) $PayDB4->Kill();
		$paysql4 = "DELETE FROM `payholidays` WHERE `date1`='$ddo'";
		if (!$PayDB4->Query($paysql4)) $PayDB4->Kill();
		echo "<tr><td>Paid Holiday Sums deleted.</td></tr>"; 

	if (!$PayDB5->Open()) $PayDB5->Kill();
		$paysql5 = "DELETE FROM `paypunctuality` WHERE `date1`='$ddo'";
		if (!$PayDB5->Query($paysql5)) $PayDB5->Kill();
		echo "<tr><td>Punctuality Bonuses Pay deleted.</td></tr>"; 

	if (!$PayDB6->Open()) $PayDB6->Kill();
		$paysql6 = "DELETE FROM `paywendbonus` WHERE `date1`='$ddo'";
		if (!$PayDB6->Query($paysql6)) $PayDB6->Kill();
		echo "<tr><td>Wend Bonus deleted.</td></tr>"; 

	if (!$PayDB7->Open()) $PayDB7->Kill();
		$paysql7 = "DELETE FROM `paywendlumpsum` WHERE `date1`='$ddo'";
		if (!$PayDB7->Query($paysql7)) $PayDB7->Kill();
		echo "<tr><td>Wend Lump Sum deleted.</td></tr>"; 

	if (!$PayDB8->Open()) $PayDB8->Kill();
		$paysql8 = "DELETE FROM `paygross` WHERE `date1`='$ddo'";
		if (!$PayDB8->Query($paysql8)) $PayDB8->Kill();
		echo "<tr><td>Wend Lump Sum deleted.</td></tr>";  
  
	if (!$PayDB9->Open()) $PayDB9->Kill();
		$paysql9 = "OPTIMIZE TABLE `paybasic` , `paybasicgross` , `paybonuses` , `paygross` , `payholidays` , `paypunctuality` , `paywendbonus` , `paywendlumpsum`";
		if (!$PayDB9->Query($paysql9)) $PayDB9->Kill();
		echo "<tr><td>TABLES ARE OPTIMIZED</td></tr>";

echo "</TABLE>";

?>