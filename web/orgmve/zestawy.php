<?php
//if(!isset($id) && !isset($pw))
//{header("Location: index.html"); exit;}
//$ASN = substr("$towar->ASNAZWA",0,10);

include_once("./header.php");
include("./languages/$LANGUAGE.php");
include_once("./inc/mlfn.inc.php");
$db = new CMySQL;
$nP="$PHP_SELF";
$numrows=15;

echo "	<TD ALIGN=JUSTIFY VALIGN=TOP border=0>

<center>
<table border='0' cellpadding='3' cellspacing='1' class='FormTABLE' bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white'>
<tbody>
<tr>
<td class='FieldCaptionTD'><B>LP</B></td>
<td class='FieldCaptionTD'><A HREF='zestawy.php?sort=9&kier=$kier'><B>$LP</B>$kier_img[9]</A></td>
<td class='FieldCaptionTD'><A HREF='zestawy.php?sort=2&kier=$kier'><B>$USERFULL</B>$kier_img[2]</A></td>
<td class='FieldCaptionTD'><A HREF='zestawy.php?sort=3&kier=$kier'><B>$DEPART</B>$kier_img[3]</A></td>
<td class='FieldCaptionTD'><A HREF='zestawy.php?sort=4&kier=$kier'><B>$NOCOMP</B>$kier_img[4]</A></td>
<td class='FieldCaptionTD'><A HREF='zestawy.php?sort=5&kier=$kier'><B>$NETNAME1</B>$kier_img[5]</a></td>
<td class='FieldCaptionTD'><A HREF='zestawy.php?sort=1&kier=$kier'><B>$LOCAL</B>$kier_img[1]</A></td>
<td class='FieldCaptionTD'><A HREF='zestawy.php?sort=6&kier=$kier'><B>$tc</B>$kier_img[6]</A></td>
<td class='FieldCaptionTD'><A HREF='zestawy.php?sort=7&kier=$kier'><B>$MONITORNAME0</B>$kier_img[7]</A></td>
<td class='FieldCaptionTD'><A HREF='zestawy.php?sort=8&kier=$kier'><B>$PRINTERNAME0</B>$kier_img[8]</A></td>
</tr>";
if (!$db->Open()) $db->Kill();

if(isset($sort))
{
	switch ($sort)
		{
		case 1:
		 $sortowanie=" ORDER BY `hd_komp`.`Lokalizacja` $kier_sql";
		 break;
		case 2:
		 $sortowanie=" ORDER BY `hd_users`.`nazwa` $kier_sql";
		 break;
		case 3:
		 $sortowanie=" ORDER BY `hd_wydzial`.`dzial` $kier_sql";
		 break;
		case 4:
		 $sortowanie=" ORDER BY `hd_komp`.`Nr_ewid` $kier_sql";
		 break;
		case 5:
		 $sortowanie=" ORDER BY `hd_komp`.`Nazwa_sieciowa` $kier_sql";
		 break;
		case 6:
		 $sortowanie=" ORDER BY `hd_komp`.`TCP_IP_Reczne` $kier_sql";
		 break;
		case 7:
		 $sortowanie=" ORDER BY mProd $kier_sql";
		 break;
		case 8:
		 $sortowanie=" ORDER BY dProd $kier_sql";
		 break;
		default:
		 $sortowanie=" ORDER BY `hd_zestaw`.`Identyfikator` $kier_sql";
		 break;
		}
	} else {
		$sortowanie=" ORDER BY `hd_komp`.`Lokalizacja` $kier_sql";
	}

    $sql =("SELECT `hd_zestaw`.`Identyfikator`,  `hd_users`.`nazwa`, `hd_wydzial`.`dzial`, `hd_komp`.`TCP_IP_Reczne`, `hd_komp`.`Lokalizacja`, `hd_komp`.`Nr_ewid`, `hd_komp`.`Model`, `hd_komp`.`Nazwa_sieciowa`, `hd_drukarka`.`Producent` AS dProd, `hd_drukarka`.`MOdel` AS dModel, `hd_drukarka`.`Nr_ewidencyjny` AS dNE, `hd_monitor`.`MOdel` AS mModel, `hd_monitor`.`Nr_ewidencyjny` AS mNE, `hd_monitor`.`Producent` AS mProd, `hd_monitor`.`Rok_prod` AS mRok_prod FROM ((`hd_komp` INNER JOIN (`hd_monitor` INNER JOIN (`hd_drukarka` INNER JOIN `hd_zestaw` ON `hd_drukarka`.`id_dr` = `hd_zestaw`.`id_dr`) ON `hd_monitor`.`id_mon` = `hd_zestaw`.`id_mon`) ON `hd_komp`.`lp` = `hd_zestaw`.`id_komp`) INNER JOIN `hd_users` ON `hd_komp`.`Uzytkownik` = `hd_users`.`lp`) INNER JOIN `hd_wydzial` ON `hd_komp`.`Dzial` = `hd_wydzial`.`lp`");

	$q=$sql.$sortowanie;

  if (!$db->Query($q)) $db->Kill();
$licz=1;
    while ($row=$db->Row())
    {
    
    echo "<tr>
        <td class='DataTD'><B>$licz</B></td>
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
     $licz++;			
   } // koniec pentli


/*  echo "<tr>
    <td align='middle' class='FooterTD' colspan='10' nowrap>
	<table><tr> 
	<td>".first($start,$numrows,$rown,$nP)."</td> 
	<td>".previous($start,$numrows,$rown,$nP)."</td> 
	<td>".next1($start,$numrows,$rown,$nP)."</td> 
	<td>".last($start,$numrows,$rown,$nP)."</td> 
</tr>
*/
echo "</table>
</td></tr>
</table> 

</td></tr></table></form></center>
";
include_once("./footer.php");
?>