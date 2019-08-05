<?php
//if(!isset($id) && !isset($pw))
//{header("Location: index.html"); exit;}

//$ASN = substr("$towar->ASNAZWA",0,10);
include_once("./header.php");
$tytul='Zestawy komputerowe';
$nP="$PHP_SELF";
include_once("./inc/mlfn.inc.php");

echo "	<TD ALIGN=JUSTIFY VALIGN=TOP border=0>
<BR><BR>
<center>
  <table border='0' cellpadding='3' cellspacing='1' class='FormTABLE' bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white'>
    <tbody>
<tr>
<td class='FieldCaptionTD'><A HREF='zestawy.php?sort=9'><B>Id.</B></A></td>
<td class='FieldCaptionTD'><A HREF='zestawy.php?sort=2'><B>Uzytkownik</B></A></td>
<td class='FieldCaptionTD'><A HREF='zestawy.php?sort=3'><B>Dzial</B></A></td>
<td class='FieldCaptionTD'><A HREF='zestawy.php?sort=4'><B>Nr_ewid</B></A></td>
<td class='FieldCaptionTD'><A HREF='zestawy.php?sort=5'><B>W sieci</B></a></td>
<td class='FieldCaptionTD'><A HREF='zestawy.php?sort=1'><B>Lokalizacja</B></A></td>
<td class='FieldCaptionTD'><A HREF='zestawy.php?sort=6'><B>IP</B></A></td>
<td class='FieldCaptionTD'><A HREF='zestawy.php?sort=7'><B>Monitor</B></A></td>
<td class='FieldCaptionTD'><A HREF='zestawy.php?sort=8'><B>drukarka</B></A></td></tr>";
//$db = new CMySQL;
if (!$db->Open()) $db->Kill();

switch ($sort)
		{
		case 1:
		 $sortowanie=" ORDER BY hd_komp.Lokalizacja ASC";
		 break;
		case 2:
		 $sortowanie=" ORDER BY hd_users.nazwa ASC";
		 break;
		case 3:
		 $sortowanie=" ORDER BY hd_wydzial.dzial ASC";
		 break;
		case 4:
		 $sortowanie=" ORDER BY hd_komp.Nr_ewid ASC";
		 break;
		case 5:
		 $sortowanie=" ORDER BY hd_komp.Nazwa_sieciowa ASC";
		 break;
		case 6:
		 $sortowanie=" ORDER BY hd_komp.TCP_IP_Reczne ASC";
		 break;
		case 7:
		 $sortowanie=" ORDER BY mProd ASC";
		 break;
		case 8:
		 $sortowanie=" ORDER BY dProd ASC";
		 break;
		default:
		 $sortowanie=" ORDER BY hd_zestaw.Identyfikator ASC";
		 break;
		}

$2sn =("SELECT hd_program.id_nazwa AS idn, hd_program.Nr_seryjny AS nrs, Count(hd_program.id_nazwa) AS Liczba, hd_programyall.prg_nazwa FROM hd_program INNER JOIN hd_programyall ON hd_program.id_nazwa = hd_programyall.id_prg GROUP BY hd_program.id_nazwa, hd_program.Nr_seryjny, hd_programyall.prg_nazwa HAVING (((hd_program.id_nazwa)='$idprg') AND ((Count(hd_program.id_nazwa))>1) AND ((Count(hd_program.Nr_seryjny))>1)) ");
if (!$db->Query($2sn)) $db->Kill();

    while ($w=$db->Row())
    {   
	   $sql =("SELECT hd_zestaw.Identyfikator,  hd_users.nazwa, hd_wydzial.dzial, hd_komp.TCP_IP_Reczne, hd_komp.Lokalizacja, hd_komp.Nr_ewid, hd_komp.Model, hd_komp.Nazwa_sieciowa, hd_drukarka.Producent AS dProd, hd_drukarka.MOdel AS dModel, hd_drukarka.Nr_ewidencyjny AS dNE, hd_monitor.MOdel AS mModel, hd_monitor.Nr_ewidencyjny AS mNE, hd_monitor.Producent AS mProd, hd_monitor.Rok_prod AS mRok_prod FROM ((hd_komp INNER JOIN (hd_monitor INNER JOIN (hd_drukarka INNER JOIN hd_zestaw ON hd_drukarka.id_dr = hd_zestaw.id_dr) ON hd_monitor.id_mon = hd_zestaw.id_mon) ON hd_komp.lp = hd_zestaw.id_komp) INNER JOIN hd_users ON hd_komp.Uzytkownik = hd_users.lp) INNER JOIN hd_wydzial ON hd_komp.Dzial = hd_wydzial.lp WHERE ");

	$q=$sql.$sortowanie;

  if (!$db->Query($sql)) $db->Kill();

    while ($row=$db->Row())
    {

    echo "<tr>
        <td class='DataTD'><A HREF='zestaw1.php?idzest=$row->Identyfikator'><B>$row->Identyfikator</B></A></td>
        <td class='DataTD'><A HREF='zestaw1.php?idzest=$row->Identyfikator'>$row->nazwa&nbsp;</A></td>
        <td class='DataTD'>$row->dzial&nbsp;</td>
        <td class='DataTD'><A HREF='zestaw1.php?idzest=$row->Identyfikator'>$row->Nr_ewid</A></td>
        <td class='DataTD'><A HREF='zestaw1.php?idzest=$row->Identyfikator'>$row->Nazwa_sieciowa </A> </td>
        <td class='DataTD'>$row->Lokalizacja</td>
        <td class='DataTD'>$row->TCP_IP_Reczne</td>	
        <td class='DataTD'>$row->mProd</td>	
        <td class='DataTD'>$row->dProd</td>			
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

</td></tr></table></form></center>
";
include_once("./footer.php");
?>