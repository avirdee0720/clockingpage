<?php
include_once("./header.php");
include("./languages/$LANGUAGE.php");
include_once("./inc/mlfn.inc.php");

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
	 <td class='DataTD'>1_2_SN</td>
    <td class='DataTD'><A HREF='rp_prg_sn.php'>$PRINTBTN</A></td>
    <td class='DataTD'>0</td>
	</tr>

  
  <tr>
	 <td class='DataTD'>All_prg</td>
    <td class='DataTD'><A HREF='rp_prg_all.php'>$PRINTBTN</A></td>
    <td class='DataTD'>0</td>
	</tr>
  
  <tr>

	 <td class='DataTD'>AV_Kasperski</td>
    <td class='DataTD'><A HREF='rp_prg_av.php'>$PRINTBTN</A></td>
    <td class='DataTD'>0</td>
	</tr>
  
  <tr>

	 <td class='DataTD'>CAD</td>
    <td class='DataTD'><A HREF='rp_prg_cad.php'>$PRINTBTN</A></td>
    <td class='DataTD'>0</td>
	</tr>
  
  <tr>
	 <td class='DataTD'>How_many_soft</td>

    <td class='DataTD'><A HREF='rp_prg_ile.php'>$PRINTBTN</A></td>
    <td class='DataTD'>0</td>
	</tr>
  
  <tr>
	 <td class='DataTD'>Notes</td>
    <td class='DataTD'><A HREF='rp_notes.php'>$PRINTBTN</A></td>

    <td class='DataTD'>0</td>
	</tr>
  
  <tr>
	 <td class='DataTD'>Offices</td>
    <td class='DataTD'><A HREF='rp_prg_off.php'>$PRINTBTN</A></td>
    <td class='DataTD'>0</td>

	</tr>
  
  <tr>
	 <td class='DataTD'>Operating_sys</td>
    <td class='DataTD'><A HREF='rp_prg_os.php'>$PRINTBTN</A></td>
    <td class='DataTD'>0</td>
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