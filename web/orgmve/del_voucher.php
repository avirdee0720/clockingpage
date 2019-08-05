<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;

if (!isset($_GET['vlid'])) $vlid = '0'; else $vlid = $_GET['vlid'];

if (!$db->Open()) $db->Kill();
    $delsql="DELETE FROM `voucherslips` WHERE `load_id` = '$vlid'";
$db->Query($delsql);

echo "<script language='javascript'>window.location=\"vouchers_modif.php\"</script>";

?>