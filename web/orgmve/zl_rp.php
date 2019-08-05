<?php

include_once("./header.php");
echo "

<BR><font class='FormHeaderFont'>$BTNWYDR</font><BR>

<center>
<table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
  <tr>
    <td class='ColumnTD' nowrap>$DSNAZWA</td>
    <td class='ColumnTD' nowrap>&nbsp;</td>
    <td class='ColumnTD' nowrap>$RPNOPIS</td>
</tr>

  <tr>
	 <td class='DataTD'>$ZLRP1</td>
    <td class='DataTD'><A HREF='analiza1.php?aktywne=n'>$PRINTBTN</A></td>
    <td class='DataTD'>$ZLRP1o</td>
	</tr>
  <tr>
	 <td class='DataTD'>$ZLRP2</td>
    <td class='DataTD'><A HREF=javascript:display(\"zlrp_htp.php\",800,600)>$PRINTBTN</A></td>
    <td class='DataTD'>$ZLRP2o</td>
	</tr>
   <tr>
	 <td class='DataTD'>$ZLHTPEXCEL1</td>
    <td class='DataTD'><A HREF=javascript:display(\"zl_htpexcel.php\",600,600)>$PRINTBTN</A></td>
    <td class='DataTD'>$ZLHTPEXCELo</td>
   </tr> 
   <tr>
	 <td class='DataTD'>$ZLRPTECH1</td>
    <td class='DataTD'><A HREF=javascript:display(\"zl_rptech.php\",600,600)>$PRINTBTN</A></td>
    <td class='DataTD'>$ZLRPTECH1o</td>
   </tr> 
   <tr>
	 <td class='DataTD'>$ZLRPB1</td>
    <td class='DataTD'><A HREF='analiza1.php?aktywne=t'>$PRINTBTN</A></td>
    <td class='DataTD'>$ZLRPB1o</td>
   </tr> 
   <tr>
	 <td class='DataTD'>$ZLRPA1</td>
    <td class='DataTD'><A HREF='analiza1.php?aktywne=n'>$PRINTBTN</A></td>
    <td class='DataTD'>$ZLRPA1o</td>
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