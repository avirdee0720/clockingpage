<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;

if (!isset($_GET['order'])) $order = '0'; else $order = $_GET['order'];

if (!$db->Open()) $db->Kill();
    $query =("UPDATE OrdersTbl SET StatusID=5 WHERE OrderID=$order LIMIT 1");
$db->Query($query);

echo "<script language='javascript'>window.location=\"order1.php?order=$order\"</script>";
?>