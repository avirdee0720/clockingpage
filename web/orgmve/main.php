<?php
include_once("./config.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
if (!$db->Open()) $db->Kill();
$q = "INSERT INTO `hd_users_logins` (`lp`, `DATA_IN`, `SES_ID`, `host`) VALUES ('$id', NOW(), '$PHPSESSID','$REMOTE_ADDR')";
if (!$db->Query($q)) $db->Kill();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN"
   "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
	<meta charset="utf-8">	
	<title>:: MVE ::</title>
	<frameset border="0" frameBorder="0" frameSpacing="0" rows="40,*">
		<frame name="MENU" border="0" scrolling="no" src="opcje.php">
		<frame name="GLOWNA" border="0" scrolling="yes" src="supps.php">
	</frameset>
</html>