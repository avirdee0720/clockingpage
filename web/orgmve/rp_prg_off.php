<?php
//if(!isset($id) && !isset($pw))
//{header("Location: index.html"); exit;}

//$ASN = substr("$towar->ASNAZWA",0,10);
include_once("./header.php");
$tytul='Lista programów typu Office (Word, Excel,...)';
$nP="$PHP_SELF";
include_once("./inc/mlfn.inc.php");

echo "	<TD ALIGN=JUSTIFY VALIGN=TOP border=0>

<center>
<H3>$tytul</H3>
  <table border='0' cellpadding='3' cellspacing='1' class='FormTABLE' bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white'>
    <tbody>
<tr>
<td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=1'><B>Prgogram nazwa</B></A></td>
<td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=2'><B>Wersja</B></A></td>
<td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=3'><B>Nr_seryjny</B></A></td>
<td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=4'><B>Nazwa_sieciowa</B></A></td>
<td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=5'><B>Uzytk.</B></a></td>
<td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=6'><B>Dzia³</B></A></td>
</tr>";
//$db = new CMySQL;
if (!$db->Open()) $db->Kill();

switch ($sort)
		{
		case 1:
		 $sortowanie=" ORDER BY hd_programyall.prg_nazwa ASC";
		 break;
		case 2:
		 $sortowanie=" ORDER BY hd_program.Wersja ASC";
		 break;
		case 3:
		 $sortowanie=" ORDER BY hd_program.Nr_seryjny ASC";
		 break;
		case 4:
		 $sortowanie=" ORDER BY hd_komp.Nazwa_sieciowa ASC";
		 break;
		case 5:
		 $sortowanie=" ORDER BY hd_users.nazwa ASC";
		 break;
		case 6:
		 $sortowanie=" ORDER BY hd_wydzial.dzial ASC";
		 break;
		default:
		 $sortowanie=" ORDER BY hd_program.Wersja, hd_program.id_zest, hd_users.nazwa, hd_wydzial.dzial";
		 break;
		}

    $sql =("SELECT hd_programyall.prg_nazwa, hd_program.Wersja, hd_program.Nr_seryjny, hd_program.id_zest, hd_zestaw.id_komp, hd_komp.Nazwa_sieciowa, hd_users.nazwa, hd_wydzial.dzial, hd_zestaw.Identyfikator FROM (((hd_zestaw INNER JOIN (hd_programyall INNER JOIN hd_program ON hd_programyall.id_prg = hd_program.id_nazwa) ON hd_zestaw.Identyfikator = hd_program.id_zest) INNER JOIN hd_komp ON hd_zestaw.id_komp = hd_komp.lp) INNER JOIN hd_users ON hd_komp.Uzytkownik = hd_users.lp) INNER JOIN hd_wydzial ON hd_users.wydzial = hd_wydzial.lp WHERE (((hd_programyall.prg_nazwa) Like \"%off%\")) ");

	$q=$sql.$sortowanie;

  if (!$db->Query($q)) $db->Kill();
  $ile=$db->Rows();

    while ($row=$db->Row())
    {

    echo "<tr>
        <td class='DataTD'><A HREF='zestaw1.php?idzest=$row->id_zest'><B>$row->prg_nazwa</B></A></td>
        <td class='DataTD'><A HREF='zestaw1.php?idzest=$row->id_zest'>$row->Wersja</A></td>
        <td class='DataTD'>$row->Nr_seryjny</td>
        <td class='DataTD'><A HREF='zestaw1.php?idzest=$row->id_zest'>$row->Nazwa_sieciowa</A></td>
        <td class='DataTD'><A HREF='zestaw1.php?idzest=$row->id_zest'>$row->nazwa </A> </td>
        <td class='DataTD'>$row->dzial</td>
      </tr>
    <input name='zest' type='hidden' value='$row->Identyfikator'>";
			
   } // koniec pentli z zamowieniem

  echo "<tr>
    <td align='middle' class='FooterTD' colspan='9' nowrap>
	<table><tr> 
	<td>".first($start,$numrows,$rown,$nP)."</td> 
	<td>".previous($start,$numrows,$rown,$nP)."</td> 
	<td>".next1($start,$numrows,$rown,$nP)."</td> 
	<td>".last($start,$numrows,$rown,$nP)."</td> 
</tr></table>
</td></tr>
</table> 
Razem <B>$ile</B> sztuk.
</td></tr></table></form></center>
";
include_once("./footer.php");
?>