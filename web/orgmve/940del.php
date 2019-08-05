<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$ID=$_GET['ID'];
$startd=$_GET['startd'];
$endd=$_GET['endd'];

if (!$db->Open()) $db->Kill();
$sql1 =("UPDATE `inout` SET `ino`='940' WHERE `id`='$ID' ");
if (!$db->Query($sql1)) $db->Kill();

echo "<script language='javascript'>window.location=\"940apr.php?startd=$startd&endd=$endd\"</script>";
?>