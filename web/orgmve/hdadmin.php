<?php
//include("./inc/mysql.inc.php");
$stopka='hdstopka.php'; 
$data=date("Y-m-d");
$teraz=date("H:i");
include("./header.php");
$baza = new CMySQL;

echo "<HTML>
<HEAD>
<LINK REL=stylesheet HREF=styl.css TYPE='text/css'>
<meta http-equiv=\"refresh\" content=\"9;URL=hdadmin.php?id=$id\",\"GLOWNA\">
</HEAD>
<BODY>";

if(!isset($state))
{
echo "<CENTER>
  <table border='0' cellpadding='3' cellspacing='1' class='FormTABLE' bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white'>
    <tbody>
	  <TR>
	  <td class='FieldCaptionTD'><B>$HDZL</B></td>
      <td class='FieldCaptionTD'><B>$HDKAT</B></td>
      <td class='FieldCaptionTD'><B>$HDDAT</B> </td>
      <td class='FieldCaptionTD'><B>$HDWAG</B></td>
	  <td class='FieldCaptionTD'><B>$HDOP</B></td>
      <td class='FieldCaptionTD'><B>$HDLOK</B></td>
	  <td class='FieldCaptionTD'><B>$HDSTAN</B></td>
	  </TR>";


 if (!$baza->Open()) $baza->Kill();
        $pyt = "SELECT lp, login, nazwa, wydzial, adm, passwd, email, miasto, woj, kraj, tel1, tel2, security_level_id, PU FROM hd_users WHERE hd_users.lp='$id'";
 if (!$baza->Query($pyt)) $baza->Kill();
  while($w=$baza->Row())
 {
    $pyt2 ="SELECT hd_zgloszenie.lp, hd_zgloszenie.kto, hd_zgloszenie.kategoria, hd_zgloszenie.data, hd_zgloszenie.czas, hd_zgloszenie.waga, hd_zgloszenie.stan, hd_status.stopis, hd_zgloszenie.opis, hd_zgloszenie.lokalizacja, hd_zgloszenie.ID_ODDZIAL, hd_zgloszenie.ID_JEDNOSTKI
    FROM hd_status RIGHT JOIN hd_zgloszenie ON hd_status.lp = hd_zgloszenie.stan ORDER BY hd_zgloszenie.stan ASC, hd_zgloszenie.data DESC";
 }
 if (!$baza->Query($pyt2))  $baza->Kill();
 while($wiersz=$baza->Row())
 {
	  if($wiersz->stan==0){echo "<tr bgcolor=#FF3333> <FORM METHOD=post ACTION='hdadmin.php'>";}
	  elseif($wiersz->stan==2){echo "<tr bgcolor=#FFFFFF> <FORM METHOD=post ACTION='hdadmin.php'>";}
	  elseif(($wiersz->stan==1)||($wiersz->stan==5)){echo "<tr bgcolor=#33CCFF> <FORM METHOD=post ACTION='hdadmin.php'>";}
      else {echo "<tr > <FORM METHOD=post ACTION='$PHP_SELF'>";}
   print("
  
      <td class='DataTD'><FONT COLOR=\"#000099\">$wiersz->kto</FONT></td>
      <td class='DataTD'><FONT COLOR=\"#000099\">$wiersz->kategoria</FONT></td>
      <td class='DataTD'><FONT COLOR=\"#000099\">$wiersz->data,<BR> $wiersz->czas</FONT></td>
      <td class='DataTD'>$wiersz->waga</td>
	  <td class='DataTD'>$wiersz->opis</td>
      <td class='DataTD'>$wiersz->lokalizacja</td>");
print("<td class='DataTD'><SELECT style='WIDTH: 135px' name=st1> ");
print("<OPTION value=n selected>$wiersz->stopis</OPTION>");	

$b = new CMySQL;
if (!$b->Open()) $b->Kill();
$st=("SELECT lp, stopis FROM hd_status ORDER BY lp DESC");
if (!$b->Query($st)) $b->Kill();
		while($w1=$b->Row())
			{
			   echo "<OPTION value=$w1->lp>$w1->stopis</OPTION>";
		    }
	   echo "</SELECT></td>";

   print("
      <td class='DataTD'>
		  <input type='hidden' name='lp' value=$wiersz->lp>
		  <INpUT NAME='state' SIZE='1' TYPE='hidden' VALUE='1'>
          <INPUT TYPE='submit' value='Zapisz'> </td>
   </FORM></tr>");
 }
echo "</TABLE></CENTER>";
} //fi

elseif($state==1)

{      
      $baza = new CMySQL;
	   if (!$baza->Open()) $baza->Kill();
       $da=$data.", ".$teraz;
       $anuluj = "UPDATE hd_zgloszenie SET stan='$st1', obsluzyl='$id' ,dataobsl='$da' WHERE lp='$lp' LIMIT 1";
       if (!$baza->Query($anuluj)) $baza->Kill();
   $an ="SELECT hd_zgloszenie.lp, hd_zgloszenie.kto, hd_zgloszenie.kategoria, hd_zgloszenie.data, hd_zgloszenie.czas, hd_zgloszenie.waga, hd_zgloszenie.stan, hd_status.stopis, hd_zgloszenie.opis, hd_zgloszenie.lokalizacja, hd_zgloszenie.ID_ODDZIAL, hd_zgloszenie.ID_JEDNOSTKI FROM hd_status RIGHT JOIN hd_zgloszenie ON hd_status.lp = hd_zgloszenie.stan WHERE hd_zgloszenie.lp='$lp' LIMIT 1";
    if (!$baza->Query($an))  $baza->Kill();
     while($w=$baza->Row())
     {
      $eTemat = "Zmiana statusu HD- kategoria: $w->kategoria, z: $w->lokalizacja";
      $trescListu  = "\n Zg3oszenie od: ";
      $trescListu .= $w->kto;
      $trescListu .= " ";
      $trescListu .= "z dnia: ";
      $trescListu .= $w->data;
      $trescListu .= ", ";
      $trescListu .= $w->czas;
      $trescListu .= "<BR> Tre?a zg3oszenia: ";
      $trescListu .= $w->opis;
      mail($adres, $eTemat, $trescListu);

    echo "      <CENTER><FONT SIZE=\"4\" COLOR=\"#FF0000\"><B>$eTemat</B></FONT><br>
		<table border=0>
    <tr>
		<Td valign=top>Nazwisko i imie: </Td>
		<Td><B>$w->kto</B><br></td></Tr>
    <tr>
		<Td valign=top>Treoa zg3oszenia: </Td>
	    <Td><B>$trescListu</B><br></td></Tr>
    <tr>
		<Td valign=top>&nbsp;</Td>
	    <Td>&nbsp;</td>
	</Tr>
	<tr>
		<Td valign=top>&nbsp;</Td>
	    <Td valign=top><B>Zlecenie Help Desk zmieni3o status!</B></td>
	</Tr>
    </TABLE>
      </CENTER>
    </td>
    </tr>
    </TBODY></table>
 ";

  } //while

} //elseif 
echo "
</BODY>
</HTML>";
?>