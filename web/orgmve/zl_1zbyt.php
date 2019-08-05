<?php
//if(!isset($id) && !isset($pw))
//{header("Location: index.html");exit;}

include("./header.php");

if(!isset($state))
{
	echo "<form action='$PHP_SELF' method='post' name='zest1'>	";

   if (!$db->Open()) $db->Kill();

    $q =("SELECT zl_zlec.lp, zl_zlec.nr_zam_pl, zl_zlec.nr_zam_o, zl_zlec.nr_poz, zl_zlec.nr_kom, zl_zlec.obj, zl_zlec.nazwa, zl_zlec.w_z_e, zl_zlec.kurs, zl_zlec.w_z_p, zl_zlec.tn_zam, zl_zlec.uwagi, zl_zlec.data_wp, zl_zlec.id_wpr, zl_zlec.data_popr, zl_zlec.id_popr, zl_zlec.data, zl_zlec.pspelem, zl_zlec.teileno, zl_zlec.id_zam, zl_zlec.data_zam, zl_zlec.id_otw, zl_zlec.data_otw, zl_zlec.zakt, zl_zlec.dostMD, zl_zlec.konserwacja, zl_zlec.TP, zl_zlec.ktermin, zl_zlec.kpartner, zl_zlec.kdata, hd_users.nazwa AS USR FROM zl_zlec	INNER JOIN hd_users ON zl_zlec.id_wpr = hd_users.lp WHERE zl_zlec.lp = $idzl LIMIT 1 ");

    if (!$db->Query($q)) $db->Kill();
    while ($row=$db->Row())
    {
     $wze = $row->w_z_e;

  if (!$db->Open()) $db->Kill();
  $popr = "SELECT hd_users.nazwa FROM hd_users WHERE hd_users.lp='$row->id_popr' LIMIT 1 ";
  if (!$db->Query($popr)) $db->Kill();
  $popr=$db->Row();

	echo "
<input type='hidden' name='idz1' value='$row->lp'>

<table WIDTH=100% border='0'>
	<COL WIDTH=11%>
	<COL WIDTH=11%>
	<COL WIDTH=11%>
	<COL WIDTH=15%>
	<COL WIDTH=11%>
	<COL WIDTH=41%>
<tr>
     <td><A HREF='zl_1.php?idzl=$idzl'><B>$zl</B></A></td>
     <td><A HREF='zl_1zaop.php?idzl=$idzl'><B>$ZLTYTZAO</B></A></td>
     <td><A HREF='zl_1tech.php?idzl=$idzl'><B>$ZLTYTTECH</B></A></td>
     <td bgcolor='#0000CC'><FONT SIZE=+1 COLOR='#33FFFF'><B>$ZLTYTZBYT</B></FONT></td>
	 <td><A HREF='zl_1koop.php?idzl=$idzl'><B>$ZLTYTKOOP</B></A></td>
	<td><A HREF='zl_1kons.php?idzl=$idzl'><B>$ZLTYTKONS</B></A></td>
	 <td>&nbsp;</td>
</tr><tr><td colspan=7>

		
<BR>
<table WIDTH=700 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >

<tr>
     <td class='FieldCaptionTD'>$ZLNRZAMPL:</td>
     <td class='DataTD'>$row->nr_zam_pl</td>

     <td class='FieldCaptionTD'>$ZLNRZAMDE:</td>
     <td class='DataTD'>$row->nr_zam_o</td>
     </tr><tr>
     <td class='FieldCaptionTD'>$ZLNRK:</td>
     <td class='DataTD'>$row->nr_kom </td>
     
	 <td class='FieldCaptionTD'>$ZLNRPOZ:</td>
     <td class='DataTD'>$row->nr_poz </td>
     </tr><tr>
     <td class='FieldCaptionTD'>$ZLOBJ:</td>
     <td class='DataTD'>$row->obj </td>

     <td class='FieldCaptionTD'>$ZLNAZWA:</td>
     <td class='DataTD'>$row->nazwa </td>
     </tr>

</table>
<BR>

	<CENTER><A HREF=zl_nzbyt.php?idzl=$idzl><IMG SRC='images/ins.png' BORDER='0' ALT='Delete/Skasuj'> $ADDNEWBTN: $ZLTYTZBYT</A></CENTER>";	
} 




//Zakladka: Controling----------------------------------------------------------------------$
echo "<BR><font class='FormHeaderFont'>$ZLTYTZBYT</font><BR>
<table WIDTH=700 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >
	<COL WIDTH=60>
	<COL WIDTH=60>
	<COL WIDTH=50>
	<COL WIDTH=50>
	<COL WIDTH=50>
	<COL WIDTH=50>
	<COL WIDTH=50>
	<COL WIDTH=150>
<tr><td class='FieldCaptionTD'>&nbsp;</td>
    <td class='FieldCaptionTD'><B>$ZLZWS</B></td>
    <td class='FieldCaptionTD'><B>$ZLZGODZ</B></td>
    <td class='FieldCaptionTD'><B>$ZLZRNJ1</B></td>
    <td class='FieldCaptionTD'><B>$ZLZRCJ1</B></td>
    <td class='FieldCaptionTD'><B>$ZLUWAGI</B></td>
</tr>";

    if (!$db->Open()) $db->Kill();
	$sqlprg = ("SELECT zl_zbyt.lp, zl_zbyt.id_zlec, zl_zbyt.transport, zl_zbyt.wart_sprz, zl_zbyt.godziny, zl_zbyt.r_m_j, zl_zbyt.r_c_j, zl_zbyt.uwagi, zl_zbyt.data_wp, zl_zbyt.id_wpr, zl_zbyt.data_popr, zl_zbyt.id_popr, zl_zbyt.data FROM zl_zbyt WHERE zl_zbyt.id_zlec = $idzl ORDER BY zl_zbyt.data_wp");


	if (!$db->Query($sqlprg)) $db->Kill();
		while ($c=$db->Row())
		{
		echo "
		 <td class='DataTD'>
			<A HREF=zl_uzbyt.php?idzl=$idzl&lp=$c->lp><IMG SRC='images/edit.png' BORDER='0' ALT='Edit/Popraw'></A>
            <A HREF=zl_dzbyt.php?idzl=$idzl&lp=$c->lp><IMG SRC='images/drop.png' BORDER='0' ALT='Delete/Skasuj'></A>
            </td>
		 <td class='DataTD'>".number_format($c->wart_sprz,2,',',' ')."</td>
		 <td class='DataTD'>".number_format($c->godziny,2,',',' ')."</td>
		 <td class='DataTD'>".number_format($c->r_m_j,2,',',' ')."</td>
		 <td class='DataTD'>".number_format($c->r_c_j,2,',',' ')."</td>
		 <td class='DataTD'>$c->uwagi</td>
		</tr>";
		}
		$sconsum="SELECT SUM(zl_zbyt.transport) AS Stransport, SUM(zl_zbyt.wart_sprz) AS Swart_sprz, SUM(zl_zbyt.godziny) AS Sgodziny, SUM(zl_zbyt.r_m_j) AS Sr_m_j, SUM(zl_zbyt.r_c_j) AS Sr_c_j FROM zl_zbyt WHERE zl_zbyt.id_zlec = $idzl";
		if (!$db->Query($sconsum)) $db->Kill();
		$c3suma=$db->Row();
				echo "
		 <td class='DataTD'>
			 <A HREF=zl_pzbyt.php?idzl=$idzl&lp=$c->lp><IMG SRC='images/print.png' BORDER='0' ALT='Print/Druk'></A>
		</td>

		 <td class='DataTD'><B>".number_format($c3suma->Swart_sprz,2,',',' ')."</B></td>
		 <td class='DataTD'><B>".number_format($c3suma->Sgodziny,2,',',' ')."</B></td>
		 <td class='DataTD'><B>".number_format($c3suma->Sr_m_j,2,',',' ')."</B></td>
		 <td class='DataTD'><B>".number_format($c3suma->Sr_c_j,2,',',' ')."</B></td>
		 <td class='DataTD'>&nbsp;</td>
		</tr>";

echo "</TABLE>	";

// Analiza zlecenia: _________________
//Zakladka tabela_techniczna rekord nr 1-----------------------------------------------------------------
echo "<BR>
<table bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white'>

<tr>
	<td class='FieldCaptionTD'><B>$ZLK</B></td>
    <td class='FieldCaptionTD'><B>$ZLCFG1</B></td>
    <td class='FieldCaptionTD'><B>$ZLCFG2</B></td>
</tr>";

    if (!$db->Open()) $db->Kill();
	$sqlcfg = ("SELECT th_cfg.lp, th_cfg.lastkurs, th_cfg.stawka_g, th_cfg.procko FROM th_cfg WHERE th_cfg.lp=1 LIMIT 1");

	if (!$db->Query($sqlcfg)) $db->Kill();

		$cfg=$db->Row();

		echo "<tr>
		 <td class='DataTD'><B>".number_format($cfg->lastkurs,2,',',' ')."</B></td>
		 <td class='DataTD'><B>".number_format($cfg->stawka_g,2,',',' ')."</B></td>
		 <td class='DataTD'><B>".number_format($cfg->procko,4,',',' ')."</B></td>
		</tr>";
echo "</TABLE>";


// Zakladka: Zaopatrzenie sumy---------------------------------------------------------------

    if (!$db->Open()) $db->Kill();
		$szaosum="SELECT  SUM(zl_zaop.MB_mat_c) AS SMB_mat_c, SUM(zl_zaop.MB_mat_KO) AS SMB_mat_KO, SUM(zl_zaop.MB_HARDOX) AS SMB_HARDOX, SUM(zl_zaop.mat_pom) AS Smat_pom, SUM(zl_zaop.tn_zam_z) AS Stn_zam_z FROM zl_zaop WHERE zl_zaop.id_zlec =$idzl ORDER BY zl_zaop.data_wp";
		if (!$db->Query($szaosum)) $db->Kill();
		$csuma=$db->Row();
		$BMaterial=$csuma->SMB_mat_c + $csuma->SMB_mat_KO + $csuma->SMB_HARDOX;
		$BMatPom=$csuma->Smat_pom;

//Zakladka TECHNOLOGIA sumy-----------------------------------------------------------------

    if (!$db->Open()) $db->Kill();
	$sqlprg = ("SELECT zl_tech.lp, zl_tech.id_zlec, zl_tech.g_zad, zl_tech.obr_mech, zl_tech.powloki, zl_tech.matKO, zl_tech.T_HARDOX, zl_tech.tn_wys, zl_tech.t_m_j, zl_tech.t_c_j, zl_tech.uwagi, zl_tech.data_wp, zl_tech.id_wpr, zl_tech.data_popr, zl_tech.id_popr, zl_tech.data FROM zl_tech WHERE zl_tech.id_zlec = $idzl ORDER BY zl_tech.data_wp");

	if (!$db->Query($sqlprg)) $db->Kill();

		$stechsum="SELECT SUM(zl_tech.g_przyg) AS Sg_przyg, SUM(zl_tech.g_mont) AS Sg_mont, SUM(zl_tech.g_kons) AS Sg_kons, SUM(zl_tech.obr_mech) AS Sobr_mech, SUM(zl_tech.powloki) AS Spowloki, SUM(zl_tech.matKO) AS SmatKO, SUM(zl_tech.T_HARDOX) AS ST_HARDOX, SUM(zl_tech.tn_wys) AS Stn_wys, SUM(zl_tech.grpbud) AS Sgrpbud, SUM(zl_tech.t_m_j) AS St_m_j, SUM(zl_tech.t_c_j) AS St_c_j FROM zl_tech WHERE zl_tech.id_zlec = $idzl ORDER BY zl_tech.data_wp";
		if (!$db->Query($stechsum)) $db->Kill();
		$c2suma=$db->Row();
		$godzinyz=$c2suma->Sg_przyg + $c2suma->Sg_mont + $c2suma->Sg_kons;

// Zakladka: kooperacja----------------------------------------------------------------------


    if (!$db->Open()) $db->Kill();


		$szaosum="SELECT  SUM(zl_koop.obr_mech) AS Sobr_mech, SUM(zl_koop.cynkowanie) AS Scynkowanie, SUM(zl_koop.arbosol) AS Sarbosol, SUM(zl_koop.gumowanie) AS Sgumowanie, SUM(zl_koop.innepow) AS Sinnepow, SUM(zl_koop.trawienie) AS Strawienie, SUM(zl_koop.konstrukcja) AS Skonstrukcja, SUM(zl_koop.czygb) AS Sczygb, SUM(zl_koop.grpbud) AS Sgrpbud FROM zl_koop WHERE zl_koop.id_zlec =$idzl ORDER BY zl_koop.data_wp";
		if (!$db->Query($szaosum)) $db->Kill();
		$csuma=$db->Row();

$Btran=$csuma->Sczygb;
$Bgrpbud=$csuma->Sgrpbud;
$Buslprd = $csuma->Sobr_mech + $csuma->Scynkowanie + $csuma->Sarbosol + $csuma->Sgumowanie + $csuma->Sinnepow + $csuma->Strawienie + $csuma->Skonstrukcja;

//Zakladka: Controling sumy-------------------------------------------------------------------$
    if (!$db->Open()) $db->Kill();
		$sconsum="SELECT SUM(zl_zbyt.transport) AS Stransport, SUM(zl_zbyt.wart_sprz) AS Swart_sprz, SUM(zl_zbyt.godziny) AS Sgodziny, SUM(zl_zbyt.r_m_j) AS Sr_m_j, SUM(zl_zbyt.r_c_j) AS Sr_c_j FROM zl_zbyt WHERE zl_zbyt.id_zlec = $idzl";
		if (!$db->Query($sconsum)) $db->Kill();
		$c3suma=$db->Row();

		//$Btran=$c3suma->Stransport;
$BKTR = $BMaterial + $BMatPom + $Bgrpbud + $Buslprd + $Btran;
$Bkosztrob = $godzinyz * $cfg->stawka_g;
$BTKW = $BKTR + $Bkosztrob;
$BKO = $BTKW * $cfg->procko;
$BKOSZT = $BKO + $BTKW;
$BZLPLN = $wze * $cfg->lastkurs;
//$BZLPLN = $row->w_z_e * $row->kurs;
$BWYNIK = $BZLPLN - $BKOSZT;
echo "

<table width=250px border='0' cellpadding='3' cellspacing='1'   border='border' style='border-collapse: collapse; background-color: black'>
<tbody>
		<TR><td class='FieldCaptionTD'>$BUDGET $ZLZGODZ</TD><td class='DataTD'><B>".number_format($godzinyz,2,',',' ')."</B></TD></TR>
			<TR><td width=150px class='FieldCaptionTD'>$BUDGET $MATERIAL</TD><td class='DataTD'><B>".number_format($BMaterial,2,',',' ')."</B></TD></TR>
			<TR><td width=150px class='FieldCaptionTD'>$BUDGET $ZLMPOM</TD><td class='DataTD'><B>".number_format($BMatPom,2,',',' ')."</B></TD></TR>
			<TR><td width=150px class='FieldCaptionTD'>$BUDGET $ZLGRPBUD</TD><td class='DataTD'><B>".number_format($Bgrpbud,2,',',' ')."</B></TD></TR>
			<TR><td width=150px class='FieldCaptionTD'>$BUDGET $USPPRD</TD><td class='DataTD'><B>".number_format($Buslprd,2,',',' ')."</B></TD></TR>
			<TR><td width=150px class='FieldCaptionTD'>$BUDGET $ZLZTR</TD><td class='DataTD'><B>".number_format($Btran,2,',',' ')."</B></TD></TR>
	</TBODY>
</TABLE>
<table width=250px border='0' cellpadding='3' cellspacing='1'   border='border' style='border-collapse: collapse; background-color: black'>
<tbody>
			<TR><td width=150px class='FieldCaptionTD'>$BUDGET KTR</TD><td class='DataTD'><B>".number_format($BKTR,2,',',' ')."</B></TD></TR>
			<TR><td width=150px class='FieldCaptionTD'>$BUDGET $KOSZTR</TD><td class='DataTD'><B>".number_format($Bkosztrob,2,',',' ')."</B></TD></TR>
	</TBODY>
</TABLE>
<table width=250px border='0' cellpadding='3' cellspacing='1'   border='border' style='border-collapse: collapse; background-color: black'>
<tbody>
			<TR><td width=150px class='FieldCaptionTD'>$BUDGET TKW</TD><td class='DataTD'><B>".number_format($BTKW,2,',',' ')."</B></TD></TR>
			<TR><td width=150px class='FieldCaptionTD'>$BUDGET $KOSZTO</TD><td class='DataTD'><B>".number_format($BKO,2,',',' ')."</B></TD></TR>
			<TR><td width=150px class='FieldCaptionTD'>$BUDGET $KOSZTA</TD><td class='DataTD'><B>".number_format($BKOSZT,2,',',' ')."</B></TD></TR>
	</TBODY>
</TABLE>
<table width=250px border='0' cellpadding='3' cellspacing='1'   border='border' style='border-collapse: collapse; background-color: black'>
<tbody>
			<TR><td width=150px class='FieldCaptionTD'>$zl</TD><td class='DataTD'><FONT COLOR='#006600'><B>".number_format($BZLPLN,2,',',' ')."</B></FONT></TD></TR>
			<TR><td width=150px class='FieldCaptionTD'><B><FONT COLOR='#0000FF'>$WYNIK</FONT></B></TD><td class='DataTD'>";
							
				if ( $BWYNIK < 0 ) { echo "<FONT COLOR='#FF0000'><B>".number_format($BWYNIK,2,',','.')."</B></FONT>"; }
			    else { echo "<FONT COLOR='#6633FF'><B>".number_format($BWYNIK,2,',','.')."</B></FONT>"; }
			echo "
				</TD></TR>
	</TBODY>
</TABLE>
</td></tr></table>";

include("./footer.php");
}
elseif($state==1)
{


} 

?>