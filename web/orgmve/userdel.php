<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$lp = $_GET['lp'];

		if (!$db->Open()) $db->Kill();
		$dh =("UPDATE `hd_users` SET `PU` = 0 WHERE `lp`='$lp' LIMIT 1");
		if (!$db->Query($dh)) $db->Kill();

echo "<script language='javascript'>window.location=\"adm_czl.php\"</script>";
?>