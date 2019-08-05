<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
uprstr($PU,90);

echo "	<TD ALIGN=JUSTIFY VALIGN=TOP border=0>

<center>

<font class='FormHeaderFont'>$TYTULADMUSER</font>
<table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
  <tr>
	<td class='ColumnTD' nowrap>
		<a class='SorterLink' href='{Sort_URL}'>$USERFULL</a>

	</td>
    <td class='ColumnTD' nowrap>
		<a class='SorterLink' href='{Sort_URL}'>$LOGNAME0</a>

	</td>
    <td class='ColumnTD' nowrap>
		<a class='SorterLink' href='{Sort_URL}'>$TELEFON0</a>

	</td>
	<td class='ColumnTD' nowrap>
		<a class='SorterLink' href='{Sort_URL}'>$UPR</a>

	</td>
    <td class='ColumnTD' nowrap>
		<a class='SorterLink' href='{Sort_URL}'>$DEPART</a>

	</td>
      <td class='ColumnTD' nowrap>
		STATUS<BR>Active<BR>Inactive

	</td>
      <td class='ColumnTD' nowrap>
		Edit

	</td>
      <td class='ColumnTD' nowrap>
		Password<BR>reset

	</td>
      <td class='ColumnTD' nowrap>
		Deactivate

	</td>
	</tr>
";

if (!$db->Open()) $db->Kill();
$q = "SELECT hd_users.lp, hd_users.login, hd_wydzial.dzial, hd_users.nazwa, hd_users.wydzial, hd_users.adm, hd_users.passwd, hd_users.PU, hd_users.miasto, hd_users.woj, hd_users.kraj, hd_users.tel1, hd_users.tel2 FROM (hd_users INNER JOIN hd_wydzial ON hd_users.wydzial = hd_wydzial.lp) ORDER BY hd_users.nazwa ASC";


  if ($db->Query($q)) 
  {
    while ($row=$db->Row())
    {
	if ( $row->PU == 0 ) { 
		$activeimg = "<IMG SRC='./images/down.gif' BORDER='0'>"; 
		$editlnk = "<a class='DataLink' href='ed_czl.php?lp=$row->lp'><IMG SRC='./images/edit.gif' BORDER='0'></a>";
		$passwdrestlnk = "&nbsp;";
		$deactivate = "&nbsp;";
		}
	else { 
		$activeimg = "<IMG SRC='./images/up.gif' BORDER='0'>"; 
		$editlnk = "<a class='DataLink' href='ed_czl.php?lp=$row->lp'><IMG SRC='./images/edit.gif' BORDER='0'></a>";
		$passwdrestlnk = "<a class='DataLink' onclick=\"return confirm('Confirm you want to password reset to proced')\" href='ed_pw.php?lp=$row->lp'><IMG SRC='./images/password.gif' BORDER='0'></a>";
		$deactivate = "<A class='DataLink' onclick=\"return confirm('Confirm you want to deactivate user to proced')\"  HREF='userdel.php?lp=$row->lp'><IMG SRC='./images/down.gif' BORDER='0'></A>";
		} 

echo "  <tr>

    <td class='DataTD'>$row->nazwa</td>
    <td class='DataTD'>$row->login</td>
    <td class='DataTD'>$row->tel1</td>
    <td class='DataTD'>$row->PU</td>
    <td class='DataTD'>$row->dzial</td>
	<td class='DataTD'>$activeimg </td>
	<td class='DataTD'>$editlnk</td>
    <td class='DataTD'>$passwdrestlnk</td>
    <td class='DataTD'>$deactivate</td>
	</tr>
  ";
  } 
} else {
echo " 
  <tr>
    <td class='DataTD'></td>
    <td class='DataTD' colspan='9'>Brak artykulow</td>
  </tr>";
 $db->Kill();
}
echo "
  <tr>
    <td align='left' class='FooterTD'  colspan='4' nowrap><a class='DataLink' href='n_czl.php'><b>Add $NEWBTN user</b></a></td>
    <td align='middle' class='FooterTD' colspan='5' nowrap>&nbsp;</td>
  </tr>
</table>
<!-- END Grid members -->
</center>
<BR>
</td></tr>
</table>";
include_once("./footer.php");
?>