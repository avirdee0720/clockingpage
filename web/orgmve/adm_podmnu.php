<?php
//if(!isset($id) && !isset($pw))
//{header("Location: index.html"); exit;}

//include("./inc/uprawnienia.php");
include_once("./header.php");
$tytul='Administracja Podmenu';

//uprstr($PU,50);

echo "	<TD ALIGN=JUSTIFY VALIGN=TOP border=0>

<center>


<font class='FormHeaderFont'>$tytul</font>
<table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
  <tr>
    <td class='ColumnTD' nowrap>&nbsp;</td>
    <td class='ColumnTD' nowrap>
		<a class='SorterLink' href='{Sort_URL}'>Nazwa</a>

	</td>
    <td class='ColumnTD' nowrap>
		<a class='SorterLink' href='{Sort_URL}'>Plik</a>

	</td>
    <td class='ColumnTD' nowrap>
		<a class='SorterLink' href='{Sort_URL}'>Kolej.</a>

	</td>
</tr>
";

if (!$db->Open()) $db->Kill();
$q = "SELECT lp,mnu_nazwa,mnu_nr,mnu_plik, kol FROM hd_menu1 WHERE mnu_nr=$lp ORDER BY mnu_nazwa ASC";

  if ($db->Query($q)) 
  {
    while ($row=$db->Row())
    {

     echo "
  <tr>
    <td class='DataTD'><a class='DataLink' href='ed_podmnu.php?lp=$row->lp'>Edycja</a></td>
	 <td class='DataTD'>$row->mnu_nazwa</td>
    <td class='DataTD'>$row->mnu_plik</td>
    <td class='DataTD'>$row->kol</td>
	</tr>
  ";
  } 
} else {
echo " 
  <tr>
    <td class='DataTD'></td>
    <td class='DataTD' colspan='3'>Brak dzialow</td>
  </tr>";
 $db->Kill();
}
echo "
  <tr>
    <td align='left' class='FooterTD' nowrap> &nbsp;</td>
    <td align='middle' class='FooterTD' colspan='5' nowrap>&nbsp;</td>
  </tr>
</table>

</center>
<BR>
</td></tr>
</table>
<input class='Button'  type='Button' onclick='javascript:history.back()' value='Wracaj'>
<input class='Button'  type='Button' onclick='window.location=\"n_podmnu.php\"' value='Nowa opcja'>
";
include_once("./footer.php");
?>