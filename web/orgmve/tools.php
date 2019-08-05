<?php
include("./config.php");
include_once("./header.php");
echo "

<BR><font class='FormHeaderFont'>Better watch out... </font><BR>

<center>
<table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
<tr>
    <td class='ColumnTD' nowrap>$DSNAZWA</td>
    <td class='ColumnTD' nowrap>&nbsp;</td>
</tr>
 <tr>
	 <td class='DataTD'>Unlock computers in 28PR Office</td>
    <td class='DataTD'><A HREF='unlockcomp.php'>$VIEWBTN</A></td>
</tr>
 <tr>
	 <td class='DataTD'>Copy database to test database</td>
    <td class='DataTD'><A HREF='copydb.php'>$VIEWBTN</A></td>
</tr>
 <tr>
	 <td class='DataTD'>DELETE COUTED MONTCH !!!</td>
    <td class='DataTD'><A HREF='deletemonth1.php'>$VIEWBTN</A> Better do not use this!!!</td>
</tr>
<tr>
    <td align='left' class='FooterTD' nowrap> &nbsp;</td>
    <td align='middle' class='FooterTD' colspan='3' nowrap>&nbsp;</td>
  </tr>
</table>

</center>
<BR>
</td></tr>
</table>";

?>