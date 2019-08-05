<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;

echo "	<TD width='100%' ALIGN=JUSTIFY VALIGN=TOP border=0>
	<table width='100%' border=0><tr><td>
	<center>
 <BR><BR><BR><BR>
 <FONT SIZE=\"+3\" COLOR=\"#FF0000\"><H2><b>$UPRMALE</b></H2></FONT>
 <BR><BR><BR>

";


echo "</center>
<BR>
</td></tr>
</table>";
include_once("./footer.php");
?>