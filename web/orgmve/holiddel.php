<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;

$YearAct = $_GET['yearAct'];
$candelete=$_GET['candelete'];
$idr=$_GET['lp'];
$datad=$_GET['datad'];
echo $id;
$d1 = strtotime("$datad");
$d2 = strtotime("$FirstOfTheMonth");
$db = new CMySQL;

if(isset($datad)) 
{
	if($candelete=="YES") 
	{
		if (!$db->Open()) $db->Kill();
		//$dh =("DELETE FROM `holidays` WHERE `id`='$idr' LIMIT 1");
		if (!$db->Query($dh)) $db->Kill();
	} else {
	echo "<BR>You can not delete !"; exit;}
} else {
echo "<BR>You can not delete ! DATAD NOT SET ??"; exit;
}
echo "<script language='javascript'>window.location=\"$skrypt&yearAct=$YearAct&startd=$startd&endd=$endd\"</script>";
?>