<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;

if (!isset($_GET['cid'])) $cid = '0'; else $cid = $_GET['cid'];

if (!$db->Open()) $db->Kill();
    $delsql="UPDATE `ContactsTbl` SET `Valid` = '0'
             WHERE `ConttactID` = '$cid'";
$db->Query($delsql);

echo "<script language='javascript'>window.location=\"contacts.php\"</script>";

?>