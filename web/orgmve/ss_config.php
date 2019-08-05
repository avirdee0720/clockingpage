<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
uprstr($PU,90);

echo "

<BR><font class='FormHeaderFont'>SS CONFIG</font><BR>

<center>
<table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
<tr>
    <td class='ColumnTD' nowrap>$DSNAZWA</td>
    <td class='ColumnTD' nowrap>&nbsp;</td>
    <td class='ColumnTD' nowrap>$RPNOPIS</td>
</tr>
 <tr>
	 <td class='DataTD'>Daily banking </td>
    <td class='DataTD'><A HREF='ss_day_cnf.php'>RUN</A></td>
    <td class='DataTD'>MVE security consolidation/delivery scenario debriefing sheet (banking) CONFIGURATION</td>
</tr>
<tr>
    <td align='left' class='FooterTD' nowrap> &nbsp;</td>
    <td align='middle' class='FooterTD' colspan='4' nowrap>&nbsp;</td>
  </tr>
</table>

</center>
<BR>
</td></tr>
</table>
";

?>