<?php
//if(!isset($id) && !isset($pw))
//{header("Location: index.html");exit;}

include_once("./header.php");
$tytul=$TYTPRGZ;

if(!isset($state))
{

// wybor komputera -----------------------------------------------------------------------------
    if (!$db->Open())$db->Kill();
    $q =("SELECT hd_zestaw.Identyfikator, hd_komp.lp, hd_komp.Klawiatura, hd_komp.Mysz, hd_komp.Dzial, hd_komp.Lokalizacja, hd_komp.Uzytkownik, hd_komp.Nr_ewid, hd_komp.Nr_seryjny, hd_komp.Rok_prod, hd_komp.Data_gw_do, hd_komp.Dostawca, hd_komp.Model, hd_komp.TCP_IP_DHCP, hd_komp.TCP_IP_Reczne, hd_komp.Nazwa_sieciowa, hd_komp.Procesor, hd_komp.MB_RAM, hd_komp.muzyka, hd_komp.HDD0, hd_komp.HDD1, hd_komp.HDD2, hd_komp.HDD3, hd_drukarka.id_dr, hd_drukarka.Producent AS dProd, hd_drukarka.MOdel AS dModel, hd_drukarka.Nr_ewidencyjny AS dNE, hd_drukarka.Nr_seryjny AS dNS, hd_drukarka.Rok_prod AS dRok_prod, hd_monitor.id_mon, hd_monitor.Nr_seryjny AS mNS, hd_monitor.MOdel AS mModel, hd_monitor.Nr_ewidencyjny AS mNE, hd_monitor.Producent AS mProd, hd_monitor.Rok_prod AS mRok_prod, hd_users.nazwa
	FROM hd_komp
	INNER JOIN (hd_monitor
	INNER JOIN (hd_drukarka
	INNER JOIN hd_zestaw ON hd_drukarka.id_dr = hd_zestaw.id_dr
	) ON hd_monitor.id_mon = hd_zestaw.id_mon
	) ON hd_komp.lp = hd_zestaw.id_komp
	INNER JOIN hd_users ON hd_komp.Uzytkownik = hd_users.lp
	WHERE (
	(
	(
	hd_zestaw.Identyfikator
	) = $idzest
	)
	)");

  if ($db->Query($q)) 
  {
    while ($row=$db->Row())
    {
	$idz1=$row->Identyfikator;
	echo "
	<table border='0' cellpadding='3' cellspacing='1'>
     <tr>
     <td class='FieldCaptionTD'><FONT SIZE=3 COLOR='#FF0000'>$SETCAP:</FONT></td>
     <td class='DataTD'><FONT SIZE=3 COLOR='#FF0000'><B>$row->Identyfikator</B>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; $USERFULL <B>$row->nazwa</B></FONT>
     </td>
     </tr>
	
	<tr>
	<form action=$PHP_SELF method=POST>
     <td class='FieldCaptionTD'>$FNCAP:</td>
     <td class='DataTD'>
     <input type='hidden' name='state' value='1'>
     <input type='hidden' name='idz' value='$idzest'>
     <INPUT class='Button' TYPE=SUBMIT name='zmk' value='$BACKBTN'>
	</td>
	</form>
    </tr>
	
	<tr>
     <td class='FieldCaptionTD'>$MUCAP</td>
     <td class='DataTD'>$row->Dzial, $row->Lokalizacja, $row->Uzytkownik, $row->Nr_ewid, $row->Nr_seryjny, $row->Rok_prod, $row->Dostawca, $row->Model, $row->TCP_IP_Reczne, $row->Nazwa_sieciowa, $row->Procesor, $row->MB_RAM,$row->HDD0, $row->HDD1, $row->HDD2, $row->HDD3
     </td>
     </tr><tr>
     <td class='FieldCaptionTD'>$PRNBTN:</td>
     <td class='DataTD'>$row->dProd, $row->dModel, NE: $row->dNE, SN: $row->dNS, Rok: $row->dRok_prod, 
     </td>
     </tr><tr>
     <td class='FieldCaptionTD'>$MONBTN:</td>
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


// Nowy rekord program

echo "<font class='FormHeaderFont'>$TYTPRGZ0 $idzest</font>
<table border='0' cellpadding='3' cellspacing='1'><form action=$PHP_SELF method=POST>";
echo "<tr>";

$db = new CMySQL;
if (!$db->Open()) $db->Kill();
  $w = "SELECT id_prg, prg_nazwa, prg_ver FROM hd_programyall ORDER BY  prg_nazwa ASC";
if (!$db->Query($w)) $db->Kill();
    print("<td class='FieldCaptionTD'>Program:<SELECT  name=prg>");
    while($dz=$db->Row()){
    print("<OPTION value=$dz->id_prg>$dz->prg_nazwa </OPTION>");
    };
print(" </SELECT>");
echo "<td class='FieldCaptionTD'>WER:<INPUT type='TEXT' NAME='wer' VALUE='' SIZE='20' MAXLENGTH='50' ALIGN='Center'></td>";
echo "<td class='FieldCaptionTD'>SN:<INPUT type='TEXT' NAME='sn' VALUE='' SIZE='40' MAXLENGTH='50' ALIGN='Center'></td>";

print("  <TD class='FieldCaptionTD' valign=top >
     <input type='hidden' name='state' value=1>
     <input type='hidden' name='who' value=$id>
	 <input type='hidden' name='idz' value=$idz1>
     <INPUT class='Button'  TYPE=SUBMIT name=new value='$ADDNEWBTN'>
</td>
</tr>
</FORM>
</TABLE>
<font class='FormHeaderFont'>$tytul $idzest</font>");


$sqlprg = ("SELECT hd_program.id_prog, hd_programyall.prg_nazwa, hd_program.Nr_seryjny, hd_program.id_nazwa, hd_program.Wersja, hd_program.Typ, hd_program.id_zest FROM hd_program LEFT JOIN hd_programyall ON hd_program.id_nazwa = hd_programyall.id_prg WHERE (((hd_program.id_zest)='$idzest')) ORDER BY hd_programyall.prg_nazwa");

if (!$db->Query($sqlprg)) $db->Kill();

print("<CENTER><table WIDTH=670 border='0' cellpadding='3' cellspacing='1'>
	<COL WIDTH=100>
	<COL WIDTH=100>
	<COL WIDTH=150>
	<COL WIDTH=200>
	<COL WIDTH=100>
		<tbody>
<tr colspan='6'>
<td><B>Lp.</B></td><td><B>Nazwa</B></td><td><B>Wersja</B></td>
<td><B>SN</B></td><td><B>&nbsp;</B></td>
</tr>");



while ($c=$db->Row())
{
echo "<form action=$PHP_SELF method=get target='_self'>";
echo "     
      <tr><td class='FieldCaptionTD'>$c->id_prog &nbsp;&nbsp;&nbsp;</td>";
print(" <td class='DataTD'><SELECT  name=program> ");
print("<OPTION value=$c->id_nazwa selected>$c->prg_nazwa</OPTION>");	
$idprg=$c->id_prog;
$baza = new CMySQL;
if (!$baza->Open()) $db->Kill();
$wydz = ("SELECT id_prg, prg_nazwa, prg_ver FROM hd_programyall ORDER BY  prg_nazwa DESC");
if (!$baza->Query($wydz))  $baza->Kill();
		while($wp=$baza->Row())
			{
			   echo "<OPTION value=$wp->id_prg>$wp->prg_nazwa</OPTION>";
		    }
	   echo "</SELECT></td>";

echo " <td class='DataTD'><INPUT type='TEXT' NAME='prgver' VALUE='$c->Wersja' SIZE='20' MAXLENGTH='50' ALIGN='Center'></td>";
echo " <td class='DataTD'><INPUT type='TEXT' NAME='prgserial' VALUE='$c->Nr_seryjny' SIZE='40' MAXLENGTH='50' ALIGN='Center'></td>";


print("   <td class='DataTD' valign=top >
	 <input type='hidden' name='lp' value=$idprg>
	 <input type='hidden' name='idz' value=$idz1>
     <input type='hidden' name='state' value=1>
     <INPUT TYPE=SUBMIT name=zm value='$SAVEBTN'
     style='border:0 solid;
     font-family: Arial, Helvetica,sans-sherif;
     font-size: 11px; color: #000000'>
	 <INPUT TYPE=SUBMIT name=kasuj value='$DELBTN'
     style='border:0 solid;
     font-family: Arial, Helvetica,sans-sherif;
     font-size: 11px; color: #000000'>
</td>
</tr>
</FORM>");
}

include_once("./footer.php");
}
elseif($state==1)
{

$baza = new CMySQL;
if (!$baza->Open()) $db->Kill();

if(isset($zm))
{ $query = ("UPDATE hd_program SET Nr_seryjny='$prgserial', id_nazwa='$program', Wersja='$prgver' WHERE id_prog='$lp' LIMIT 1") ;
  $result = mysql_query($query);
}

elseif(isset($kasuj))
 { $query = ("DELETE FROM hd_program WHERE id_prog=$lp") ;
   $result = mysql_query($query);
}

elseif(isset($new))
 { $query = ("INSERT INTO hd_program (id_prog, Nr_seryjny, id_nazwa, Wersja, id_zest)VALUES (NULL,'$sn','$prg','$wer','$idz')") ;
   $result = mysql_query($query);
}

if(isset($zmk))
{ echo "<script language='javascript'>window.location=\"zestaw1.php?idzest=$idz\"</script>";
}

echo "<script language='javascript'>window.location=\"programy.php?idzest=$idz\"</script>";

} 
?>