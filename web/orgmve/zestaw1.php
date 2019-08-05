<?php
include_once("./header.php");
include("./languages/$LANGUAGE.php");
include_once("./inc/mlfn.inc.php");
$db = new CMySQL;
$nP="$PHP_SELF";
$numrows=15;

$tytul='Zestaw komputerowy numer ';

if(!isset($state))
{
	echo "<form action='$PHP_SELF' method='post' name='zest1'>
		<CENTER>

</CENTER>
	";

   if (!$db->Open()) $db->Kill();

    $q =("SELECT `hd_zestaw`.`Identyfikator`, `hd_komp`.`lp`, `hd_komp`.`Klawiatura`, `hd_komp`.`Mysz`, `hd_komp`.`Dzial`, `hd_komp`.`Lokalizacja`, `hd_komp`.`Uzytkownik`, `hd_komp`.`Nr_ewid`, `hd_komp`.`Nr_seryjny`, `hd_komp`.`Rok_prod`, `hd_komp`.`Data_gw_do`, `hd_komp`.`Dostawca`, `hd_komp`.`Model`, `hd_komp`.`TCP_IP_DHCP`, `hd_komp`.`TCP_IP_Reczne`, `hd_komp`.`Nazwa_sieciowa`, `hd_komp`.`Procesor`, `hd_komp`.`MB_RAM`, `hd_komp`.`muzyka`, `hd_komp`.`HDD0`, `hd_komp`.`HDD1`, `hd_komp`.`HDD2`, `hd_komp`.`HDD3`, `hd_drukarka`.`id_dr`, `hd_drukarka`.`Producent` AS dProd, `hd_drukarka`.`MOdel` AS dModel, `hd_drukarka`.`Nr_ewidencyjny` AS dNE, `hd_drukarka`.`Nr_seryjny` AS dNS, `hd_drukarka`.`Rok_prod` AS dRok_prod, `hd_monitor`.`id_mon`, `hd_monitor`.`Nr_seryjny` AS mNS, `hd_monitor`.`MOdel` AS mModel, `hd_monitor`.`Nr_ewidencyjny` AS mNE, `hd_monitor`.`Producent` AS mProd, `hd_monitor`.`Rok_prod` AS mRok_prod, `hd_users`.`nazwa`
	FROM `hd_komp`
	INNER JOIN (`hd_monitor`
	INNER JOIN (`hd_drukarka`
	INNER JOIN `hd_zestaw` ON `hd_drukarka`.`id_dr` = `hd_zestaw`.`id_dr`
	) ON `hd_monitor`.`id_mon` = `hd_zestaw`.`id_mon`
	) ON `hd_komp`.`lp` = `hd_zestaw`.`id_komp`
	INNER JOIN `hd_users` ON `hd_komp`.`Uzytkownik` = `hd_users`.`lp`
	WHERE (
	(
	(
	`hd_zestaw`.`Identyfikator`
	) = $idzest
	)
	) LIMIT 1 ");

    if (!$db->Query($q)) $db->Kill();
    while ($row=$db->Row())
    {
	echo "
	<input type='hidden' name='idz1' value='$row->Identyfikator'>
	<input type='hidden' name='idk' value='$row->lp'>
	<input type='hidden' name='idm' value='$row->id_mon'>
	<input type='hidden' name='idd' value='$row->id_dr'>
	<table border='0' cellpadding='3' cellspacing='1'>
     <tr>
     <td class='FieldCaptionTD'>$SETCAP:</td>
     <td class='DataTD'><FONT SIZE=3 COLOR='#FF0000'><B>$row->Identyfikator</B> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</FONT>$USERFULL <B>$row->nazwa</B></td></tr>
<tr>
     <td class='FieldCaptionTD'>$FNCAP:</td>
     <td class='DataTD'>
    <input type='hidden' name='state' value='1'>
     <INPUT class='Button' TYPE=SUBMIT name='zmk' value='$MUNITBTN'>
	 <INPUT class='Button' TYPE=SUBMIT name='zmk' value='$MONBTN'>
	 <INPUT class='Button' TYPE=SUBMIT name='zmk' value='$PRNBTN'>
	 <INPUT class='Button' TYPE=SUBMIT name='zmk' value='$PRGBTN'>
	 <INPUT class='Button' TYPE=SUBMIT name='zmk' value='$ANBTN'>
	 <INPUT class='Button' TYPE=SUBMIT name='zmk' value='$NOTEBTN'>
	 <INPUT class='Button' TYPE=SUBMIT name='druk' value='$PRINTBTN'>

	</td>
     </tr><tr>
     <td class='FieldCaptionTD'>$MUCAP:</td>
     <td class='DataTD'>$row->Dzial, $row->Lokalizacja, $row->Nr_ewid, $row->Nr_seryjny, $row->Rok_prod, $row->Dostawca, $row->Model, $row->TCP_IP_Reczne, $row->Nazwa_sieciowa, $row->Procesor, $row->MB_RAM,$row->HDD0, $row->HDD1, $row->HDD2, $row->HDD3
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
     </table>";
	} 


//----------------------------------------------------------------------
echo "<BR><font class='FormHeaderFont'>$TYTPRGZ $idzest</font><BR>
<table bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white'>
<tr>
<td class='FieldCaptionTD'><B>$DSNAZWA</B></td><td class='FieldCaptionTD'><B>$DSVer</B></td><td class='FieldCaptionTD'><B>$SN</B></td></tr>";

    if (!$db->Open()) $db->Kill();
	$sqlprg = ("SELECT `hd_program`.`id_prog`, `hd_programyall`.`prg_nazwa`, `hd_program`.`Nr_seryjny`, `hd_program`.`id_nazwa`, `hd_program`.`Wersja`, `hd_program`.`Typ`, `hd_program`.`id_zest` FROM `hd_program` LEFT JOIN `hd_programyall` ON `hd_program`.`id_nazwa` = `hd_programyall`.`id_prg` WHERE (((`hd_program`.`id_zest`)='$idzest')) ORDER BY `hd_programyall`.`prg_nazwa`");

	if (!$db->Query($sqlprg)) $db->Kill();
		while ($c=$db->Row())
		{
		echo "
		<tr>
		 <td class='DataTD'>$c->prg_nazwa</td>
		 <td class='DataTD'>$c->Wersja</td>
		 <td class='DataTD'>$c->Nr_seryjny</td>
		</tr>
		";
		}
echo "</TABLE>";
//----------------------------------------------------------------------
echo "<BR><font class='FormHeaderFont'>$TYTNOTES $idzest</font><BR>
<table WIDTH=606 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >
	<COL WIDTH=100>
	<COL WIDTH=300>
	<COL WIDTH=150>
	<COL WIDTH=150>
<tr>
<td class='FieldCaptionTD'><B>$RPNDATE</B></td><td class='FieldCaptionTD'><B>$RPNOPIS</B></td><td class='FieldCaptionTD'><B>$RPNCEN</B></td><td class='FieldCaptionTD'><B>$RPNFIRMA</B></td></tr>";

    if (!$db->Open()) $db->Kill();
	$sqlprg = ("SELECT `hd_notatki`.`not_id`, `hd_notatki`.`not_data`, `hd_notatki`.`not_opis`, `hd_notatki`.`not_firma_cena`, `hd_notatki`.`id_zest`, `hd_notatki`.`firma_id`, `hd_dostawcy`.`DSNAZWA` FROM `hd_notatki` INNER JOIN `hd_dostawcy` ON `hd_notatki`.`firma_id` = `hd_dostawcy`.`ID` WHERE (((`hd_notatki`.`id_zest`)='$idzest')) ORDER BY `hd_notatki`.`not_data` DESC");

	if (!$db->Query($sqlprg)) $db->Kill();
		while ($n=$db->Row())
		{
		echo "
		<tr>
		 <td class='DataTD'><B>$n->not_data</B></td>
		 <td class='DataTD'>$n->not_opis</td>
		 <td class='DataTD'>$n->not_firma_cena</td>
		 <td class='DataTD'>$n->DSNAZWA</td>
		</tr>
		";
		}
echo "</TABLE>
</form>";


include("./footer.php");
}
elseif($state==1)
{

if(isset($zmk) && $zmk=="$MUNITBTN")
{ echo "<script language='javascript'>window.location=\"ed_jc.php?idkomp=$idk&idzest=$idz1\"</script>";}

if(isset($zmk) && $zmk=="$MONBTN")
{ echo "<script language='javascript'>window.location=\"ed_mon.php?idmon=$idm&idzest=$idz1\"</script>";}

if(isset($zmk) && $zmk=="$PRNBTN")
{ echo "<script language='javascript'>window.location=\"ed_dr.php?iddr=$idd&idzest=$idz1\"</script>";}

if(isset($zmk) && $zmk=="$PRGBTN")
{ echo "<script language='javascript'>window.location=\"programy.php?idzest=$idz1\"</script>";}

if(isset($zmk) && $zmk=="$NOTEBTN")
{ echo "<script language='javascript'>window.location=\"notatki.php?idzest=$idz1\"</script>";}

if(isset($zmk) && $zmk=="$ANBTN")
{ echo "<script language='javascript'>window.location=\"notatkn.php?idzest=$idz1\"</script>";}

elseif(isset($druk) && $druk=="$PRINTBTN")
{ //echo "<script language='javascript'>window.location=\"drukk1.php?idzest=$idz1\"</script>";}
echo "<script language='javascript'>window.open(\"drukk1.php?idzest=$idz1\",\"print\",\"left=0,top=0,width=640,height=600,resizable=yes,scrollbars=yes,menubar=no\")</script>";
echo "<script language='javascript'>window.location=\"zestaw1.php?idzest=$idz1\"</script>";
}
} 
?>