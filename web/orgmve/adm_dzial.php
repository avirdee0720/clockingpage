<?php
if(!isset($id))
{header("Location: index.html");exit;}

include_once("./header.php");
//$tytul='Administracja u¿ytkownikammi';
include_once("./inc/uprawnienia.php");
uprstr($PU,50);

echo "	<TD ALIGN=JUSTIFY VALIGN=TOP border=0>

<center>

<table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
  <tr>
    <td class='ColumnTD' nowrap>&nbsp;</td>
    <td class='ColumnTD' nowrap>
		<a class='SorterLink' href='{Sort_URL}'>Departament</a>

	</td>
    <td class='ColumnTD' nowrap>
		<a class='SorterLink' href='{Sort_URL}'>Where</a>

	</td>
  </tr>
";

if (!$db->Open()) $db->Kill();
$q = "SELECT hd_wydzial.lp, hd_wydzial.dzial, hd_wydzial.lokalizacja FROM hd_wydzial ORDER BY hd_wydzial.dzial ASC";


  if ($db->Query($q)) 
  {
    while ($row=$db->Row())
    {

     echo "
  <tr>
    <td class='DataTD'><a class='DataLink' href='ed_dz.php?lp=$row->lp'>Edit</a></td>
    <td class='DataTD'>$row->dzial</td>
    <td class='DataTD'>$row->lokalizacja</td>
  </tr>
  ";
  } 
} else {
echo " 
  <tr>
    <td class='DataTD'></td>
    <td class='DataTD' colspan='3'>no departaments</td>
  </tr>";
 $db->Kill();
}
echo "
  <tr>
    <td align='left' class='FooterTD' nowrap><a class='DataLink' href='brak.php'><b>New</b></a></td>
    <td align='middle' class='FooterTD' colspan='4' nowrap>&nbsp;</td>
  </tr>
</table>
<!-- END Grid members -->
</center>
<BR>
</td></tr>
</table>";
include_once("./footer.php");
?>