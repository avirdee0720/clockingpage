<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;

if (!isset($_GET['appid'])) $appid = '0'; else $appid = $_GET['appid'];
if (!isset($_GET['cln'])) $cln = '0'; else $cln = $_GET['cln'];

if (!$db->Open()) $db->Kill();
    $delsql="DELETE FROM `appraisal` WHERE `appraisalID` = $appid";
$db->Query($delsql);

echo "<script language='javascript'>window.location=\"dailyappraisal.php?cln=$cln\"</script>";

?>