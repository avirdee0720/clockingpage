<?php
include("../inc/mysql.inc.php");
$stopka='hdstopka.php';
$data=date("Y-m-d");
$teraz=date("H:i");
//$adres  = 'root@szpital.walbrzych.pl';
$baza = new CMySQL;

if(!isset($state))
{
echo "<CENTER>
      <table border=0 cellspacing=0 cellpadding=2  style='background:#EFEFEF' width=95%>
	  <TR>
	  <td><B>KTO</B></td>
      <td><B>Kategoria</B></td>
      <td><B>data, czas</B> </td>
      <td><B>waga</B></td>
	  <td><B>opis</B></td>
      <td><B>Lokalizacja</B></td>
	  <td><B>Stan</B></td>
	  </TR>";

 if (!$baza->Open()) $baza->Kill();
         $pyt = "SELECT user.ID_JEDNOSTKI, user.ID_USER, user.LOGIN, user.stanowisko, pacjent.Nazwisko, dane_personalne.Imie, pracownie_personel.ID_PRAC, s_komorki.NAZWA_KOM, s_komorki.KOD_MZ, s_grupy_prac.PRACOWNIK_NAZWA, jednostka.NAZWA_JEDNOSTKI
FROM ((((((pacjent INNER JOIN dane_personalne ON pacjent.ID_OSOBY = dane_personalne.ID_OSOBY) INNER JOIN user ON pacjent.ID_PACJENT = user.ID_PACJENT) INNER JOIN pracownie_personel ON user.ID_PERSONEL = pracownie_personel.ID_PERSONEL) INNER JOIN pracownie ON pracownie_personel.ID_PRAC = pracownie.ID_PRAC) INNER JOIN s_komorki ON pracownie.ID_PRACOWNI = s_komorki.ID_PRACOWNI) INNER JOIN s_grupy_prac ON pracownie_personel.ID_GRUPY_PRAC = s_grupy_prac.ID_GRUPY_PRAC) INNER JOIN jednostka ON user.ID_JEDNOSTKI = jednostka.ID_JEDNOSTKI WHERE (((user.ID_USER)=$ID_USER));";
 if (!$baza->Query($pyt)) $baza->Kill();
  while($w=$baza->Row())
 {
	$UID=$w->ID_USER;
	//echo "ID_PRAC: $w->ID_PRAC";
    $pyt2 ="SELECT hd_zgloszenie.lp, hd_zgloszenie.kto, hd_zgloszenie.kategoria, hd_zgloszenie.data, hd_zgloszenie.czas, hd_zgloszenie.waga, hd_zgloszenie.stan, hd_status.stopis, hd_zgloszenie.opis, hd_zgloszenie.lokalizacja, hd_zgloszenie.ID_ODDZIAL, hd_zgloszenie.ID_JEDNOSTKI
    FROM hd_status RIGHT JOIN hd_zgloszenie ON hd_status.lp = hd_zgloszenie.stan WHERE hd_zgloszenie.ID_ODDZIAL='$w->ID_PRAC' AND hd_zgloszenie.anulowal='0' ORDER BY hd_zgloszenie.data DESC";
 }
  if (!$baza->Query($pyt2))  $baza->Kill();
 while($wiersz=$baza->Row())
 {
   print(" <tr> <FORM METHOD=post ACTION='hdzgllist1.php'>
      <td>$wiersz->kto</td>
      <td>$wiersz->kategoria</td>
      <td>$wiersz->data, $wiersz->czas</td>
      <td>$wiersz->waga</td>
	  <td>$wiersz->opis</td>
      <td>$wiersz->lokalizacja</td>
	  <td>$wiersz->stopis</td>
      <td>");
	  if( $wiersz->kategoria == 0 ){
	  print("<input type='hidden' name='UID' value=$UID>
		     <input type='hidden' name='lp' value=$wiersz->lp>
		     <INPUT NAME='state' SIZE='1' TYPE='hidden' VALUE='1'>
             <INPUT TYPE='submit' value='Anuluj'> ");
	 } else { print("&nbsp;"); }
   print("</td></FORM></tr>");
 }
echo "</TABLE></CENTER>";
} //fi

elseif($state==1)

{      
 //     $baza = new CMySQL;
	   if (!$baza->Open()) $baza->Kill();
       $da=$data.", ".$teraz;
//	echo "LP= $lp, $da, $UID";   	
       $anuluj = "UPDATE hd_zgloszenie SET anulowal='$UID', dataanul='$da' WHERE lp='$lp' LIMIT 1";
       if (!$baza->Query($anuluj)) $baza->Kill();
   $an ="SELECT hd_zgloszenie.lp, hd_zgloszenie.kto, hd_zgloszenie.kategoria, hd_zgloszenie.data, hd_zgloszenie.czas, hd_zgloszenie.waga, hd_zgloszenie.stan, hd_status.stopis, hd_zgloszenie.opis, hd_zgloszenie.lokalizacja, hd_zgloszenie.ID_ODDZIAL, hd_zgloszenie.ID_JEDNOSTKI FROM hd_status RIGHT JOIN hd_zgloszenie ON hd_status.lp = hd_zgloszenie.stan WHERE hd_zgloszenie.lp='$lp' LIMIT 1";
    if (!$baza->Query($an))  $baza->Kill();
     while($w=$baza->Row())
     {
      $eTemat = "Anulowanie zlecenia HD- kategoria: $w->kategoria, z: $w->lokalizacja";
      $trescListu  = "\n Zg³oszenie od: ";
      $trescListu .= $w->kto;
      $trescListu .= " ";
      $trescListu .= "z dnia: ";
      $trescListu .= $w->data;
      $trescListu .= ", ";
      $trescListu .= $w->czas;
      $trescListu .= "<BR> Tre¶æ zg³oszenia: ";
      $trescListu .= $w->opis;
      mail($adres, $eTemat, $trescListu);

    echo "<p><FONT SIZE=\"4\" COLOR=\"#FF0000\"><B>$eTemat</B></FONT><br>
		<table border=0>
    <tr>
		<Td valign=top>Nazwisko i imie: </Td>
		<Td><B>$w->kto</B><br></td></Tr>
    <tr>
		<Td valign=top>Treœæ zg³oszenia: </Td>
	    <Td><B>$trescListu</B><br></td></Tr>
    <tr>
		<Td valign=top>&nbsp;</Td>
	    <Td>&nbsp;</td>
	</Tr>
	<tr>
		<Td valign=top>&nbsp;</Td>
	    <Td valign=top>Zlecenie Help Desk zosta³o ANULOWANE!</td>
	</Tr>
    </TABLE>
      </CENTER>
    </td>
    </tr>
    </table>
 ";

  } //while

} //elseif 
?>