<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$cln = $_GET['cln'];

if (!$db->Open()) $db->Kill();
    $query =("INSERT INTO `staffdetails` (`no`) VALUES('$cln')");
$db->Query($query);

echo "<script language='javascript'>window.location=\"hr_data.php?cln=$cln\"</script>";
?>