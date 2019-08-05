<?php
if(!isset($id) && !isset($pw))
{header("Location: index.html");exit;}

include('./header.php');
$nP="$PHP_SELF";
include_once("./inc/mlfn.inc.php");
include("./languages/$LANGUAGE.php");


echo "	<TD ALIGN=JUSTIFY VALIGN=TOP border=0>
<table width='100%' border=0><tr><td>
	
<center>
<!-- BEGIN Search -->
<form action='$PHP_SELF' method='post' name='szukaj'>
  <font class='FormHeaderFont'>$TYTULADMDZ</font>
  <table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
  ";


echo "
    <tr>
      <td class='FieldCaptionTD'>$DSNAZWA</td>
      <td class='DataTD'><input class='Input' maxlength='100' name='Nazwa' size='30' value=''></td>
      <td class='FieldCaptionTD'>$DSMIASTO</td>
      <td class='DataTD'><input class='Input' maxlength='100' name='Miasto' size='30' value=''></td>
	  <td class='FieldCaptionTD'>$DSNIP</td>
      <td class='DataTD'><input class='Input' maxlength='100' name='NIP' size='30' value=''></td>
	  <td class='FieldCaptionTD'>$DSULICA</td>
      <td class='DataTD'><input class='Input' maxlength='100' name='Ulica' size='30' value=''>
        
      </td>
    </tr>
    <tr>
      <td align='right' colspan='4'>
        <input class='Button' name='search' type='submit' value='Szukaj'></td>
    </tr>
  </table>
</form>
  <!-- END Search -->


<table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
  <tr>
    <td class='ColumnTD' nowrap>&nbsp;</td>
    <td class='ColumnTD' nowrap>
      <a class='SorterLink' href='$PHP_SELF?sort=temat ASC'>$DSKOD</a>
	</td>
    <td class='ColumnTD' nowrap>
      <a class='SorterLink' href='javascript:window.location=$PHP_SELF?sort=katopis ASC'>$DSNAZWA</a>

	</td>
    <td class='ColumnTD' nowrap>
      <a class='SorterLink' href='$PHP_SELF?sort=dataogl ASC'>$DSMIASTO</a>

	</td>
	  <td class='ColumnTD' nowrap>
      <a class='SorterLink' href='$PHP_SELF?sort=dataend ASC'>$DSULICA</a>

	</td>

	  <td class='ColumnTD' nowrap>
      <a class='SorterLink' href='$PHP_SELF?sort=lang_id ASC'>$DSKOD</a>

	</td>
		  <td class='ColumnTD' nowrap>
      <a class='SorterLink' href='$PHP_SELF?sort=lang_id ASC'>$DSTEL</a>

	</td>
		  <td class='ColumnTD' nowrap>
      <a class='SorterLink' href='$PHP_SELF?sort=lang_id ASC'>$DSBANK</a>

	</td>
		  <td class='ColumnTD' nowrap>
      <a class='SorterLink' href='$PHP_SELF?sort=lang_id ASC'>$DSNIP</a>

	</td>


  </tr>";

 if(isset($sort)){
  $q = "SELECT hd_dostawcy.ID, hd_dostawcy.DSKOD, hd_dostawcy.DSNAZWA, hd_dostawcy.DSMIASTO, hd_dostawcy.DSULICA, hd_dostawcy.DSNRDOMU, hd_dostawcy.DSKODPOCZT, hd_dostawcy.DSTEL, hd_dostawcy.DSFAX, hd_dostawcy.DSTELEX, hd_dostawcy.DSSALDO, hd_dostawcy.DSDLUG, hd_dostawcy.DSBANK, hd_dostawcy.DSKONTO, hd_dostawcy.DSRABAT, hd_dostawcy.DSNRIDENT, hd_dostawcy.DSUWAGI, hd_dostawcy.DSPRACOW, hd_dostawcy.DSNAZSKR, hd_dostawcy.DSKONTOFK FROM hd_dostawcy ORDER BY DSNAZWA ";

  } else { 
  $q = "SELECT hd_dostawcy.ID, hd_dostawcy.DSKOD, hd_dostawcy.DSNAZWA, hd_dostawcy.DSMIASTO, hd_dostawcy.DSULICA, hd_dostawcy.DSNRDOMU, hd_dostawcy.DSKODPOCZT, hd_dostawcy.DSTEL, hd_dostawcy.DSFAX, hd_dostawcy.DSTELEX, hd_dostawcy.DSSALDO, hd_dostawcy.DSDLUG, hd_dostawcy.DSBANK, hd_dostawcy.DSKONTO, hd_dostawcy.DSRABAT, hd_dostawcy.DSNRIDENT, hd_dostawcy.DSUWAGI, hd_dostawcy.DSPRACOW, hd_dostawcy.DSNAZSKR, hd_dostawcy.DSKONTOFK FROM hd_dostawcy ORDER BY DSNAZWA ";
 }

 /*if(isset($katid) and isset($title)){
  $q = "SELECT artykul.lp, kategorie.katopis, artykul.lpkategoria, artykul.dataogl, artykul.temat, artykul.naglowek, artykul.body, artykul.url, artykul.kto, artykul.dataend, artykul.datamod, lang.lang_desc FROM (artykul INNER JOIN kategorie ON artykul.lpkategoria = kategorie.lp) INNER JOIN lang ON artykul.lang_id = lang.lang_id WHERE artykul.temat LIKE '%$title%' AND artykul.lpkategoria LIKE '%$katid%'  AND artykul.lang_id LIKE '%$lang%' ORDER BY artykul.temat ASC,datamod ASC ";
  } else { 
  $q = "SELECT artykul.lp, kategorie.katopis, artykul.lpkategoria, artykul.dataogl, artykul.temat, artykul.naglowek, artykul.body, artykul.url, artykul.kto, artykul.dataend, artykul.datamod, lang.lang_desc FROM (artykul INNER JOIN kategorie ON artykul.lpkategoria = kategorie.lp) INNER JOIN lang ON artykul.lang_id = lang.lang_id ORDER BY datamod ASC";
 }
*/
if (!$db->Open()) $db->Kill();
$db->Query($q);
$numrows=$db->Rows();

if(!isset($start) or $start=="") $start=0;
$q="$q limit $start,$rown";

  if ($db->Query($q)) 
  {
    while ($row=$db->Row())
    {

     echo "
      <tr>
	    <td class='DataTD'><a class='DataLink' href='ed_dost.php?lp=$row->ID'>Edycja</a></td>
	    <td class='DataTD'>$row->DSKOD &nbsp;</td>
	    <td class='DataTD'>$row->DSNAZWA &nbsp;</td>
	    <td class='DataTD'>$row->DSMIASTO &nbsp;</td>
	    <td class='DataTD'>$row->DSULICA &nbsp;$row->DSNRDOMU</td>
		<td class='DataTD'>$row->DSKODPOCZT &nbsp;</td>
		<td class='DataTD'>$row->DSTEL &nbsp;</td>
		<td class='DataTD'>$row->DSBANK &nbsp;</td>
		<td class='DataTD'>$row->DSNRIDENT &nbsp;</td>
	  </tr>";

  } 
} else {
echo " 
  <tr>
    <td class='DataTD'></td>
    <td class='DataTD' colspan='13'>Brak artykulow</td>
  </tr>";
 $db->Kill();
}
echo "
  <tr>
    <td align='middle' class='FooterTD' nowrap><a class='DataLink' href='n_dost.php'><b>$NEWBTN</b></a></td>
    <td align='middle' class='FooterTD' colspan='13' nowrap><table><tr> 
	<td>".first($start,$numrows,$rown,$nP)."</td> 
	<td>".previous($start,$numrows,$rown,$nP)."</td> 
	<td>".next1($start,$numrows,$rown,$nP)."</td> 
	<td>".last($start,$numrows,$rown,$nP)."</td> 
	</tr>
</table></td>
  </tr>
</table>
<!-- END Grid articles1 -->

</center>
<BR>
</td></tr>
</table>";
include_once('./footer.php');
?>