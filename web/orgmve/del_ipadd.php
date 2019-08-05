<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;

if (!isset($_GET['ipid'])) $ipid = '0'; else $ipid = $_GET['ipid'];

if (!$db->Open()) $db->Kill();
    $delsql="DELETE FROM `ipaddress` WHERE `ID` = '$ipid'";
$db->Query($delsql);

echo "<script language='javascript'>window.location=\"ipinfo.php\"</script>";

?>