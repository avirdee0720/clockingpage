<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.0 Transitional//EN'>
<HTML>
<HEAD>
<?php
if(!isset($id) && !isset($pw))
{header("Location: index.html");exit;}
include("./inc/mysql.inc.php");
$db = new CMySQL;
$db->PHPSESSID_tmp=$PHPSESSID;
include("./config.php");
?>
<META HTTP-EQUIV="Content-type" CONTENT="text/html; charset=ISO-8859-2">
<META HTTP-EQUIV='Content-Language' CONTENT='pl'>
<META HTTP-EQUIV='Pragma' CONTENT='no-cache'>
<meta HTTP-EQUIV='cache-control' CONTENT='no-cache, must-revalidate'>
<meta name=description content=magazyn>
<meta name=keywords content=magazyn>
<META NAME='Robots' CONTENT='INDEX, FOLLOW'>
<LINK REL='stylesheet' HREF='style/dupa.css' TYPE='text/css'>
<LINK REL='stylesheet' HREF='style/facet/style.css' TYPE='text/css'>
<title>:: KARTA KOMPUTERA by PZ ::</TITLE>

<?php


$tytul='Zestaw komputerowy numer ';

	echo "
	<FONT COLOR=#000000><H3>$tytul $idzest</H3>
	<TABLE WIDTH=606 BORDER=1 BORDERCOLOR='#000000' CELLPADDING=2 CELLSPACING=0 RULES=GROUPS>
	<COL WIDTH=173>
	<COL WIDTH=81>
	<COL WIDTH=247>
	<TBODY>
		<TR VALIGN=TOP>
			<TD WIDTH=173 BGCOLOR='#000000'>
				<P LANG='' CLASS='tytu?-tabeli-western' STYLE='font-style: normal'>
				<FONT COLOR='#ffffff'><FONT FACE='Arial, sans-serif'><FONT SIZE=2>NAZWA</FONT></FONT></FONT></P>
			</TD>
			<TD WIDTH=81 BGCOLOR='#000000'>
				<P LANG='' CLASS='tytu?-tabeli-western' STYLE='font-style: normal'>
				<FONT COLOR='#ffffff'><FONT FACE='Arial, sans-serif'><FONT SIZE=2>WERSJA</FONT></FONT></FONT></P>
			</TD>
			<TD WIDTH=247 BGCOLOR='#000000'>
				<P LANG='' CLASS='tytu?-tabeli-western' STYLE='font-style: normal'>
				<FONT COLOR='#ffffff'><FONT FACE='Arial, sans-serif'><FONT SIZE=2>NUMER
				SERYJNY</FONT></FONT></FONT></P>
			</TD>
		</TR>";

    if (!$db->Open()) $db->Kill();
	$sqlprg = ("SELECT hd_program.id_prog, hd_programyall.prg_nazwa, hd_program.Nr_seryjny, hd_program.id_nazwa, hd_program.Wersja, hd_program.Typ, hd_program.id_zest FROM hd_program LEFT JOIN hd_programyall ON hd_program.id_nazwa = hd_programyall.id_prg WHERE (((hd_program.id_zest)='$idzest')) ORDER BY hd_programyall.prg_nazwa");

	if (!$db->Query($sqlprg)) $db->Kill();
		while ($c=$db->Row())
		{
		echo "
		<TR VALIGN=TOP>
			<TD WIDTH=173>
				<P LANG='' CLASS='zawarto??-tabeli-western'><FONT FACE='Arial, sans-serif'>$c->prg_nazwa</FONT>
				</P>
			</TD>
			<TD WIDTH=81>
				<P LANG='' CLASS='zawarto??-tabeli-western'><FONT FACE='Arial, sans-serif'>$c->Wersja</FONT>
				</P>
			</TD>
			<TD WIDTH=247>
				<P LANG='' CLASS='zawarto??-tabeli-western'><FONT FACE='Arial, sans-serif'>$c->Nr_seryjny</FONT>
				</P>
			</TD>
		</TR>";
		}
echo "</TBODY></TABLE>";

   if (!$db->Open()) $db->Kill();
    $q =("SELECT hd_zestaw.Identyfikator, hd_komp.lp, hd_komp.Klawiatura, hd_komp.Mysz, hd_komp.Dzial, hd_komp.Lokalizacja, hd_komp.Uzytkownik, hd_komp.Nr_ewid, hd_komp.Nr_seryjny, hd_komp.Rok_prod, hd_komp.Data_gw_do, hd_komp.Dostawca, hd_komp.Model, hd_komp.TCP_IP_DHCP, hd_komp.TCP_IP_Reczne, hd_komp.Nazwa_sieciowa, hd_komp.Procesor, hd_komp.MB_RAM, hd_komp.muzyka, hd_komp.HDD0, hd_komp.HDD1, hd_komp.HDD2, hd_komp.HDD3, hd_drukarka.id_dr, hd_drukarka.Producent AS dProd, hd_drukarka.MOdel AS dModel, hd_drukarka.Nr_ewidencyjny AS dNE, hd_drukarka.Nr_seryjny AS dNS, hd_drukarka.Rok_prod AS dRok_prod, hd_monitor.id_mon, hd_monitor.Nr_seryjny AS mNS, hd_monitor.MOdel AS mModel, hd_monitor.Nr_ewidencyjny AS mNE, hd_monitor.Producent AS mProd, hd_monitor.Rok_prod AS mRok_prod, hd_users.nazwa, hd_wydzial.dzial FROM (hd_komp INNER JOIN (hd_monitor INNER JOIN (hd_drukarka INNER JOIN hd_zestaw ON hd_drukarka.id_dr = hd_zestaw.id_dr) ON hd_monitor.id_mon = hd_zestaw.id_mon) ON hd_komp.lp = hd_zestaw.id_komp) INNER JOIN (hd_users INNER JOIN hd_wydzial ON hd_users.wydzial = hd_wydzial.lp) ON (hd_komp.Uzytkownik = hd_users.lp) AND (hd_komp.Dzial = hd_wydzial.lp) WHERE (((hd_zestaw.Identyfikator)=$idzest)) LIMIT 1");



  if (!$db->Query($q)) $db->Kill();
    while ($row=$db->Row())
    {




echo "
<left>
Oddział/Dział: <B>$row->dzial</B> &nbsp;&nbsp;&nbsp;Użytkownik: <B>$row->nazwa</B>
<BR>
Lokalizacja: <B>$row->Lokalizacja</B>
<BR>
Dostawca/Producent:	<B>$row->Dostawca</B>, Model: <B>$row->Model</B>
<BR>
Procesor: <B>$row->Procesor</B> , RAM <B>$row->MB_RAM</B>&nbsp;MB , 

Hd1: <B>$row->HDD0</B>&nbsp;MB, Hd2: <B>$row->HDD1</B>&nbsp;MB, Hd3: <B>$row->HDD2</B>&nbsp;MB, Hd4: <B>$row->HDD3</B>&nbsp;MB,
<BR>";

if($row->Klawiatura==0)	{ echo "<INPUT TYPE=CHECKBOX NAME='klaw' VALUE=''> Klawiatura,&nbsp;"; }
else { echo "<INPUT TYPE=CHECKBOX NAME='klaw'  CHECKED>	Klawiatura,&nbsp;"; }
	
if($row->Mysz==0) { echo "<INPUT TYPE=CHECKBOX NAME='mmm' VALUE=''> Mysz, &nbsp;"; }
else { echo "<INPUT TYPE=CHECKBOX NAME='mmm'  CHECKED>	Mysz,&nbsp;"; } 

if($row->muzyka==0) { echo "<INPUT TYPE=CHECKBOX NAME='mmm' VALUE=''> muzyka, &nbsp;"; }
else { echo "<INPUT TYPE=CHECKBOX NAME='mmm'  CHECKED>	muzyka,&nbsp;"; } 

if($row->TCP_IP_DHCP==0) { echo "TCP/IP:  <B>$row->TCP_IP_Reczne</B> (ręczne)"; }
else { echo "TCP/IP: <B>$row->TCP_IP_DHCP</B> (DHCP)"; } 

echo "
,&nbsp;Nazwa w sieci: <B>$row->Nazwa_sieciowa</B>
<BR>

Numer ewidencyjny: <B>$row->Nr_ewid</B> Nr seryjny / fabryczny: <B>$row->Nr_seryjny</B>
<BR>
Rok	produkcji: <B>$row->Rok_prod</B>, Data gw. do: <B>$row->Data_gw_do</B> ";

if($row->mProd!="BRAK" && $row->mProd!="") { 
	echo "<BR><BR>
          <B>MONITOR:</B>
          <BR>
          Producent: <B>$row->mProd </B>  Model: <B>$row->mModel</B> Rok produkcji: <B>$row->mRok_prod</B>
          <BR>
          Numer seryjny: <B>$row->mNS</B> Numer ewidencyjny: <B>$row->mNE</B> "; 
  } else { echo "<BR><BR><B>MONITOR: BRAK!</B>"; 
} 

if($row->dProd!="BRAK" && $row->dProd!="") { 
	echo "<BR><BR>
         <B>DRUKARKA:</B>
         <BR>
         Producent: <B>$row->dProd</B> Model: <B>$row->dModel</B> Rok produkcji: <B>$row->dRok_prod</B>
         <BR>
         Numer seryjny: <B>$row->dNS</B> Numer ewidencyjny:  <B>$row->dNE</B>  "; 
  } else { echo "<BR><BR><B>DRUKARKA: BRAK!</B>"; 
} 


echo "</FONT></left>";

} 

?>