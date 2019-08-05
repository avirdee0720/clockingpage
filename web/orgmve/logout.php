<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE>koniec </TITLE>
</HEAD>

<BODY>
<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
if (!$db->Open()) $db->Kill();

if(!isset($id)) { echo "Log in please!"; exit; }
else $i = $_GET['id'];

$end=("UPDATE `hd_users_logins` SET `DATA_OUT`=NOW(),SES_ID=NULL WHERE `lp`='$id' and `SES_ID`='$PHPSESSID'");

if (!$db->Query($end)) $db->Kill();
   		unset($id);
		unset($pw);
		unset($PU);
		unset($LANGUAGE);
		unset($nazwa);
		setcookie("id", $i, time() - 3600);
		setcookie("pw", "", time() - 3600);
		setcookie("PU", "", time() - 3600);
		setcookie('LANGUAGE', "", time()- 3600);
		setcookie('nazwa', "", time()- 3600);

echo "	<TD width='100%' ALIGN=JUSTIFY VALIGN=TOP border=0>

	<center>
<BR><BR><BR>
<b>See you soon!</b> <BR><BR>
     <I></I><BR><BR><BR>
<IMG SRC='images/debil.gif' BORDER='0' ALT=''>
	 <BR><BR>
";

echo "</center>
<BR>
</td></tr>
</table>
<script language='javascript'>window.close();</script>";
?>

<script language='javascript'>window.location="./index.html"</script>
</BODY>
</HTML>