<?php

include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$db1 = new CMySQL;
$dbase = new CMySQL;

list($day, $month, $year) = explode("/",$_GET['startd']);
$dod = "$year-$month-$day";
list($day1, $month1, $year1) = explode("/",$_GET['endd']);
$ddo= "$year1-$month1-$day1";

echo "<font class='FormHeaderFont'>$title</font><BR>
	  <table WIDTH=500 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >";
if (!$dbase->Open()) $dbase->Kill();
$q = "UPDATE `holidays` SET `hourgiven` = '0' WHERE `date1` LIKE '$year-$month-%'";
if (!$dbase->Query($q)) $dbase->Kill();
echo "Holidays hours set to 0 / $year-$month-* <BR>";

if (!$db->Open()) $db->Kill();
$q1 = "DELETE FROM `sumofweek` WHERE `year` = '$year'";
if (!$db->Query($q1)) $db->Kill();
echo "The data has been deleted! - Sumofweek - $year <BR>";

if (!$db1->Open()) $db1->Kill();
$q2 = "OPTIMIZE TABLE `holidays` , `sumofweek` ";
if (!$db1->Query($q2)) $db1->Kill();
echo "Tables are indexed.";

?>