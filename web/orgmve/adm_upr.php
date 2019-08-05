<?php
if(!isset($id))
{header("Location: index.html");exit;}

include_once("./header.php");
$tytul='Administracja uprawnieniami';
echo "	<TD ALIGN=JUSTIFY VALIGN=TOP border=0>

<center>

<form action='$PHP_SELF' method='post' name='x'>
  <table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>

    <tr>
      <td class='FieldCaptionTD'>Tabela</td>
      <td class='DataTD'><input class='Input' maxlength='15' name='tabela' value=''>&nbsp;
		<input class='Button' name='DoSearch' type='submit' value='Szukaj'></td>
    </tr>
  </table>
</form>

<table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
  <tr>
    <td class='ColumnTD' nowrap>&nbsp;</td>
    <td class='ColumnTD' nowrap>
		<a class='SorterLink' href='{Sort_URL}'>Tabela</a>

	</td>
    <td class='ColumnTD' nowrap>
		<a class='SorterLink' href='{Sort_URL}'>Select</a>
	</td>
    <td class='ColumnTD' nowrap>
		<a class='SorterLink' href='{Sort_URL}'>Insert</a>
	</td>
	    <td class='ColumnTD' nowrap>
		<a class='SorterLink' href='{Sort_URL}'>Update</a>
	</td>
	    <td class='ColumnTD' nowrap>
		<a class='SorterLink' href='{Sort_URL}'>Description</a>
	</td>
	</tr>
";

if (!$db->Open()) $db->Kill();
$q = "SELECT hd_upr.lp, hd_upr.tabela, hd_upr.sel, hd_upr.ins, hd_upr.upt, hd_upr.opis FROM hd_upr ORDER BY hd_upr.tabela ASC";


  if ($db->Query($q)) 
  {
    while ($row=$db->Row())
    {

     echo "
  <tr>
    <td class='DataTD'><a class='DataLink' href='ed_upr.php?lp=$row->lp'>Edycja</a></td>
    <td class='DataTD'>$row->tabela</td>
    <td class='DataTD'>$row->sel</td>
    <td class='DataTD'>$row->ins</td>
    <td class='DataTD'>$row->upt</td>
    <td class='DataTD'>$row->opis</td>
 </tr>
  ";
  } 
} else {
echo " 
  <tr>
    <td class='DataTD'></td>
    <td class='DataTD' colspan='5'>SQL Error</td>
  </tr>";
 $db->Kill();
}
echo "
  <tr>
    <td align='left' class='FooterTD' nowrap><a class='DataLink' href='brak.php'><b>Nowy</b></a></td>
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