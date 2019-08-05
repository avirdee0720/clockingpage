<?php
include("./config.php");
//include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$cln=$_GET['cln'];

/* if (!$db->Open()) $db->Kill();
$zapytanie2="insert into `hd_users_logins` (`lp`, `DATA_IN`, `SES_ID`, `host`) values ('$id', NOW(), '$PHPSESSID','$REMOTE_ADDR')";
if (!$db->Query($zapytanie2))  $db->Kill();
*/
echo "
<HTML>
<HEAD>
<LINK REL='stylesheet' HREF='style/multipads/style.css' TYPE='text/css'>
<title>:: MVE ::</TITLE>

<FRAMESET name=ramka border=0 frameBorder=0 frameSpacing=0 rows=40%,*>
	<FRAME name=MENU border=0  scrolling=no src=\"pay01.php\">
	<FRAME name=GLOWNA border=0  scrolling=yes src=\"supps.php\">
</FRAMESET>
";

?>
<body bgcolor=\"#6699FF\"></body>
</HTML>