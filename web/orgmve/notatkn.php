<?php
if(!isset($id) && !isset($pw))
{header("Location: index.html");exit;}

include_once("./header.php");
$tytul='Programy do zestawu: ';

if(!isset($state))
{

// wybor komputera -----------------------------------------------------------------------------
    if (!$db->Open())$db->Kill();
    $q =("SELECT hd_zestaw.Identyfikator, hd_komp.Klawiatura, hd_komp.Mysz, hd_komp.Dzial, hd_komp.Lokalizacja, hd_komp.Uzytkownik, hd_komp.Nr_ewid, hd_komp.Nr_seryjny, hd_komp.Rok_prod, hd_komp.Data_gw_do, hd_komp.Dostawca, hd_komp.Model, hd_komp.TCP_IP_DHCP, hd_komp.TCP_IP_Reczne, hd_komp.Nazwa_sieciowa, hd_komp.Procesor, hd_komp.MB_RAM, hd_komp.muzyka, hd_komp.HDD0, hd_komp.HDD1, hd_komp.HDD2, hd_komp.HDD3, hd_drukarka.Producent AS dProd, hd_drukarka.MOdel AS dModel, hd_drukarka.Nr_ewidencyjny AS dNE, hd_drukarka.Nr_seryjny AS dNS, hd_drukarka.Rok_prod AS dRok_prod, hd_monitor.Nr_seryjny AS mNS, hd_monitor.MOdel AS mModel, hd_monitor.Nr_ewidencyjny AS mNE, hd_monitor.Producent AS mProd, hd_monitor.Rok_prod AS mRok_prod FROM hd_komp INNER JOIN (hd_monitor INNER JOIN (hd_drukarka INNER JOIN hd_zestaw ON hd_drukarka.id_dr = hd_zestaw.id_dr) ON hd_monitor.id_mon = hd_zestaw.id_mon) ON hd_komp.lp = hd_zestaw.id_komp WHERE (((hd_zestaw.Identyfikator)=$idzest)) ");

  if ($db->Query($q)) 
  {
    while ($row=$db->Row())
    {
	$idz1=$row->Identyfikator;
	echo "
	<table border='0' cellpadding='3' cellspacing='1'>
     <tr>
     <td class='FieldCaptionTD'><FONT SIZE=3 COLOR='#FF0000'>Zestaw nr:</FONT></td>
     <td class='DataTD'><FONT SIZE=3 COLOR='#FF0000'><B>$row->Identyfikator</B> </FONT>
     </td>
     </tr>
		
		<tr>
	<form action=$PHP_SELF method=POST>
     <td class='FieldCaptionTD'>Funkcje:</td>
     <td class='DataTD'>
     <input type='hidden' name='state' value='1'>
     <input type='hidden' name='idz' value='$idzest'>
     <INPUT class='Button' TYPE=SUBMIT name='zmk' value=' Wracaj '>
	</td>
	</form>
    </tr>
	
	<tr>
     <td class='FieldCaptionTD'>Jednostka centralna:</td>
     <td class='DataTD'>$row->Dzial, $row->Lokalizacja, $row->Uzytkownik, $row->Nr_ewid, $row->Nr_seryjny, $row->Rok_prod, $row->Dostawca, $row->Model, $row->TCP_IP_Reczne, $row->Nazwa_sieciowa, $row->Procesor, $row->MB_RAM,$row->HDD0, $row->HDD1, $row->HDD2, $row->HDD3
     </td>
     </tr><tr>
     <td class='FieldCaptionTD'>Drukarka:</td>
     <td class='DataTD'>$row->dProd, $row->dModel, NE: $row->dNE, SN: $row->dNS, Rok: $row->dRok_prod, 
     </td>
     </tr><tr>
     <td class='FieldCaptionTD'>Monitor:</td>
     <td class='DataTD'>$row->mProd,  $row->mModel, NE: $row->mNE, SN: $row->mNS, Rok: $row->mRok_prod
     </td>
     </tr>
     </table>
	";
	} 
} else {
echo " 
  <tr>
    <td class='DataTD'></td>
    <td class='DataTD' colspan='5'>Brak artykulow</td>
  </tr>";
 $db->Kill();
}
// koniec sekcji komputer ----------------------------


echo "<BR><font class='FormHeaderFont'>Dodaj now± notatkê do zestawu nr: $idzest</font>
<table border='0' cellpadding='3' cellspacing='1'>
<form action=$PHP_SELF method=POST >";
echo "<tr>";

$db = new CMySQL;
if (!$db->Open()) $db->Kill();
  $w = "SELECT ID, DSKOD, DSNAZWA, DSMIASTO  FROM hd_dostawcy ORDER BY  DSNAZWA ASC";
if (!$db->Query($w)) $db->Kill();
    print("<td class='FieldCaptionTD'>Firma:<SELECT  name=\"firma\">");
	print("<OPTION value='1'>BRAK</OPTION>");

    while($dz=$db->Row()){
       print("<OPTION value='$dz->ID'>$dz->DSNAZWA </OPTION>");
    };
echo " </SELECT>
</tr><TR><td class='FieldCaptionTD'>Data<INPUT type='TEXT' NAME='_not_data' VALUE='$dzis' SIZE='10' MAXLENGTH='10' ALIGN='Center'></td>
	
</tr><TR><td class='FieldCaptionTD'>Opis:&nbsp;<TEXTAREA NAME='_not_opis' ROWS='4' COLS='60'></TEXTAREA></td>


</tr><TR><td class='FieldCaptionTD'>firma/rachunek/cena:<INPUT type='TEXT' NAME='_not_firma_cena' VALUE='' SIZE='40' MAXLENGTH='50' ALIGN='Center'></td>";

print("  </tr><TR><TD class='FieldCaptionTD' valign=top >
     <CENTER><input type='hidden' name='state' value=1>
     <input type='hidden' name='who' value=$id>
	 <input type='hidden' name='idz' value=$idzest>
     <INPUT class='Button' TYPE=SUBMIT name=new value=' Zapisz '>
		 </CENTER>
</td>
</tr>
</FORM>
</TABLE>
<BR><BR>");

include_once("./footer.php");
}
elseif($state==1)
{

if(isset($zmk))
{ echo "<script language='javascript'>window.location=\"zestaw1.php?idzest=$idz\"</script>";
}

$baza = new CMySQL;
if (!$baza->Open()) $db->Kill();
$query = ("INSERT INTO hd_notatki (not_id, not_data, not_opis, not_firma_cena, id_zest, firma_id) VALUES (NULL,'$_not_data','$_not_opis','$_not_firma_cena', '$idz', '$firma')") ;
   $result = mysql_query($query);
   echo "<script language='javascript'>window.location=\"notatki.php?idzest=$idz\"</script>";

} 
?>