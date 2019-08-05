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
  <font class='FormHeaderFont'>$TYTULRPN</font>
  <table WIDTH=700 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >
	<COL WIDTH=100>
	<COL WIDTH=300>
	<COL WIDTH=150>
	<COL WIDTH=300>
	<COL WIDTH=150>
  ";


echo "
    <tr>
      <td class='FieldCaptionTD'>$RPNDATAOD</td>
      <td class='DataTD'><input class='Input' maxlength='12' name='dataod' size='12' value='$dzis'></td>
      <td class='FieldCaptionTD'>$RPNDATADO</td>
      <td class='DataTD'><input class='Input' maxlength='12' name='datado' size='12' value='$dzis'></td>
    </tr>
    <tr>
      <td align='right' colspan='4'>
        <input class='Button' name='search' type='submit' value='$SEARCHBTN'></td>
    </tr>
  </table>
</form>
  <!-- END Search -->


  <table WIDTH=700 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >
	<COL WIDTH=70>
	<COL WIDTH=250>
	<COL WIDTH=130>
	<COL WIDTH=150>
	<COL WIDTH=100>
  <tr>
    <td class='ColumnTD' nowrap>
      <a class='SorterLink' href='$PHP_SELF?sort=1'>$RPNDATE</a>
	</td>
    <td class='ColumnTD' nowrap>
      <a class='SorterLink' href='$PHP_SELF?sort=2'>$RPNOPIS</a>

	</td>
    <td class='ColumnTD' nowrap>
      <a class='SorterLink' href='$PHP_SELF?sort=3'>$RPNCEN</a>

	</td>
	  <td class='ColumnTD' nowrap>
      <a class='SorterLink' href='$PHP_SELF?sort=4'>$DSNAZWA</a>

	</td>

	  <td class='ColumnTD' nowrap>
      <a class='SorterLink' href='$PHP_SELF?sort=5'>$RPNUSER</a>

	</td>

  </tr>";

switch ($sort)
		{
		case 1:
		 $sortowanie=" ORDER BY hd_notatki.not_data ASC";
		 break;
		case 2:
		 $sortowanie=" ORDER BY hd_notatki.not_opis ASC";
		 break;
		case 3:
		 $sortowanie=" ORDER BY hd_notatki.not_firma_cena ASC";
		 break;
		case 4:
		 $sortowanie=" ORDER BY hd_dostawcy.DSNAZWA ASC";
		 break;
		case 5:
		 $sortowanie=" ORDER BY hd_users.nazwa ASC";
		 break;
		default:
		 $sortowanie=" ORDER BY hd_notatki.not_data";
		 break;
		}
		
// if(isset($sort)){ }
// else {$sort=""}
if(isset($dataod) && isset($datado) && $dataod!="" && $datado!=""){
  $q = "SELECT hd_notatki.not_id, hd_notatki.not_data, hd_notatki.not_opis, hd_notatki.not_firma_cena, hd_notatki.id_zest, hd_dostawcy.DSNAZWA, hd_users.nazwa, hd_komp.Nazwa_sieciowa FROM (((hd_notatki INNER JOIN hd_dostawcy ON hd_notatki.firma_id = hd_dostawcy.ID) INNER JOIN hd_zestaw ON hd_notatki.id_zest = hd_zestaw.Identyfikator) INNER JOIN hd_komp ON hd_zestaw.id_komp = hd_komp.lp) INNER JOIN hd_users ON hd_komp.Uzytkownik = hd_users.lp WHERE hd_notatki.not_data > '$dataod' AND hd_notatki.not_data < '$datado'";
}
elseif(isset($dataod) && $dataod!=""){
  $q = "SELECT hd_notatki.not_id, hd_notatki.not_data, hd_notatki.not_opis, hd_notatki.not_firma_cena, hd_notatki.id_zest, hd_dostawcy.DSNAZWA, hd_users.nazwa, hd_komp.Nazwa_sieciowa FROM (((hd_notatki INNER JOIN hd_dostawcy ON hd_notatki.firma_id = hd_dostawcy.ID) INNER JOIN hd_zestaw ON hd_notatki.id_zest = hd_zestaw.Identyfikator) INNER JOIN hd_komp ON hd_zestaw.id_komp = hd_komp.lp) INNER JOIN hd_users ON hd_komp.Uzytkownik = hd_users.lp WHERE hd_notatki.not_data > '$datado'";
}
elseif(isset($dataod) && $dataod!=""){
  $q = "SELECT hd_notatki.not_id, hd_notatki.not_data, hd_notatki.not_opis, hd_notatki.not_firma_cena, hd_notatki.id_zest, hd_dostawcy.DSNAZWA, hd_users.nazwa, hd_komp.Nazwa_sieciowa FROM (((hd_notatki INNER JOIN hd_dostawcy ON hd_notatki.firma_id = hd_dostawcy.ID) INNER JOIN hd_zestaw ON hd_notatki.id_zest = hd_zestaw.Identyfikator) INNER JOIN hd_komp ON hd_zestaw.id_komp = hd_komp.lp) INNER JOIN hd_users ON hd_komp.Uzytkownik = hd_users.lp WHERE hd_notatki.not_data < '$dataod'";
}
else{
  $q = "SELECT hd_notatki.not_id, hd_notatki.not_data, hd_notatki.not_opis, hd_notatki.not_firma_cena, hd_notatki.id_zest, hd_dostawcy.DSNAZWA, hd_users.nazwa, hd_komp.Nazwa_sieciowa FROM (((hd_notatki INNER JOIN hd_dostawcy ON hd_notatki.firma_id = hd_dostawcy.ID) INNER JOIN hd_zestaw ON hd_notatki.id_zest = hd_zestaw.Identyfikator) INNER JOIN hd_komp ON hd_zestaw.id_komp = hd_komp.lp) INNER JOIN hd_users ON hd_komp.Uzytkownik = hd_users.lp";
}

$q=$q.$sortowanie;
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
	    <td class='DataTD'>$row->not_data </td>
	    <td class='DataTD'>$row->not_opis &nbsp;</td>
	    <td class='DataTD'>$row->not_firma_cena &nbsp;</td>
	    <td class='DataTD'>$row->DSNAZWA &nbsp;</td>
		<td class='DataTD'><a class='DataLink' href='zestaw1.php?idzest=$row->id_zest'> $row->nazwa &nbsp;/ $row->Nazwa_sieciowa</a></td>
	  </tr>";

  } 
} else {
echo " 
  <tr>
    <td class='DataTD'></td>
    <td class='DataTD' colspan='13'>SQL Error</td>
  </tr>";
 $db->Kill();
}
echo "
  <tr>
    <td align='middle' class='FooterTD' nowrap>&nbsp;</td>
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