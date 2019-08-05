<?php
//if(!isset($id) && !isset($pw))
//{header("Location: index.html");exit;}

include_once("./header.php");
include("./languages/$LANGUAGE.php");
$db1 = new CMySQL;
$db2 = new CMySQL;
$db3 = new CMySQL;
$db4 = new CMySQL;
$db5 = new CMySQL;
$db6 = new CMySQL;

echo "<TD ALIGN=JUSTIFY VALIGN=TOP border=0>

<table border='0' cellpadding='3' cellspacing='1' class='FormTABLE' bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white'>
<tbody>
		<TR>
			<td class='FieldCaptionTD'><A HREF='analiza1.php?aktywne=$aktywne&sort=1'><B>$ZLNRZAMPL1</B></A></TD>
			<td class='FieldCaptionTD'><A HREF='analiza1.php?aktywne=$aktywne&sort=2'><B>$ZLNRZAMDE1</B></A></TD>
			<td class='FieldCaptionTD'><A HREF='analiza1.php?aktywne=$aktywne&sort=3'><B>$ZLOBJ</B></A></TD>
			<td class='FieldCaptionTD'>$BUDGET <BR>$ZLZGODZ</TD>
			<td class='FieldCaptionTD'>$BUDGET <BR>$MATERIAL</TD>
			<td class='FieldCaptionTD'>$BUDGET <BR>$ZLMPOM</TD>
			<td class='FieldCaptionTD'>$BUDGET <BR>$ZLGRPBUD</TD>
			<td class='FieldCaptionTD'>$BUDGET <BR>$USPPRD</TD>
			<td class='FieldCaptionTD'>$BUDGET <BR>$ZLZTR</TD>
			<td class='FieldCaptionTD'>$BUDGET KTR</TD>
			<td class='FieldCaptionTD'>$BUDGET <BR>$KOSZTR</TD>
			<td class='FieldCaptionTD'>$BUDGET TKW</TD>
			<td class='FieldCaptionTD'>$BUDGET <BR>$KOSZTO</TD>
			<td class='FieldCaptionTD'>$BUDGET <BR>$KOSZTA</TD>
			<td class='FieldCaptionTD'>$zl</TD>
			<td class='FieldCaptionTD'><B><FONT COLOR='#FF0000'>$WYNIK</FONT></B></TD>
		</TR>
	</TBODY>
	<TBODY>";

if(isset($sort))
{
	switch ($sort)
		{
		case 1:
		 $sortowanie=" ORDER BY zl_zlec.nr_zam_pl ASC";
		 break;
		case 2:
		 $sortowanie=" ORDER BY zl_zlec.nr_zam_o ASC";
		 break;
		case 3:
		 $sortowanie=" ORDER BY zl_zlec.obj ASC";
		 break;
		default:
		 $sortowanie=" ORDER BY zl_zlec.nr_zam_pl ASC";
		 break;
		}
	} else {
		$sortowanie=" ORDER BY nr_zam_pl ASC";
	}
   if (!$db->Open()) $db->Kill();

   if ( $aktywne == 't' ) { $sql1 =("SELECT zl_zlec.lp, zl_zlec.nr_zam_pl, zl_zlec.nr_zam_o, zl_zlec.nr_poz, zl_zlec.nr_kom, zl_zlec.obj, zl_zlec.nazwa, zl_zlec.w_z_e, zl_zlec.kurs, zl_zlec.w_z_p, zl_zlec.tn_zam, zl_zlec.uwagi, zl_zlec.data_wp, zl_zlec.id_wpr, zl_zlec.data_popr, zl_zlec.id_popr, zl_zlec.data, zl_zlec.pspelem, zl_zlec.teileno, zl_zlec.id_zam, zl_zlec.data_zam, zl_zlec.id_otw, zl_zlec.data_otw, zl_zlec.zakt, zl_zlec.dostMD, zl_zlec.konserwacja, zl_zlec.TP, zl_zlec.ktermin, zl_zlec.kpartner, zl_zlec.kdata FROM zl_zlec WHERE zak='t' "); }
   else 
    { $sql1 =("SELECT zl_zlec.lp, zl_zlec.nr_zam_pl, zl_zlec.nr_zam_o, zl_zlec.nr_poz, zl_zlec.nr_kom, zl_zlec.obj, zl_zlec.nazwa, zl_zlec.w_z_e, zl_zlec.kurs, zl_zlec.w_z_p, zl_zlec.tn_zam, zl_zlec.uwagi, zl_zlec.data_wp, zl_zlec.id_wpr, zl_zlec.data_popr, zl_zlec.id_popr, zl_zlec.data, zl_zlec.pspelem, zl_zlec.teileno, zl_zlec.id_zam, zl_zlec.data_zam, zl_zlec.id_otw, zl_zlec.data_otw, zl_zlec.zakt, zl_zlec.dostMD, zl_zlec.konserwacja, zl_zlec.TP, zl_zlec.ktermin, zl_zlec.kpartner, zl_zlec.kdata FROM zl_zlec WHERE zak<>'t' "); }

	$q=$sql1.$sortowanie;
    
	if (!$db->Query($q)) $db->Kill();
    while ($row=$db->Row())
    {
     $wze = $row->w_z_e;
	 $idzl=$row->lp;

 //Controling----------------------------------------------------------------------
   if (!$db1->Open()) $db1->Kill();
		$sconsum="SELECT SUM(zl_zbyt.transport) AS Stransport, SUM(zl_zbyt.wart_sprz) AS Swart_sprz, SUM(zl_zbyt.godziny) AS Sgodziny, SUM(zl_zbyt.r_m_j) AS Sr_m_j, SUM(zl_zbyt.r_c_j) AS Sr_c_j FROM zl_zbyt WHERE zl_zbyt.id_zlec = $idzl";
		if (!$db1->Query($sconsum)) $db1->Kill();
		$c3suma=$db1->Row();
				
// Analiza zlecenia: Zakladka tabela_techniczna rekord nr 1 -----------------------------------------------------------------
    if (!$db2->Open()) $db2->Kill();
	$sqlcfg = ("SELECT th_cfg.lp, th_cfg.lastkurs, th_cfg.stawka_g, th_cfg.procko FROM th_cfg WHERE th_cfg.lp=1 LIMIT 1");
	if (!$db2->Query($sqlcfg)) $db2->Kill();
	$cfg=$db2->Row();

// Zaopatrzenie sumy---------------------------------------------------------------
    if (!$db3->Open()) $db3->Kill();
		$szaosum="SELECT  SUM(zl_zaop.MB_mat_c) AS SMB_mat_c, SUM(zl_zaop.MB_mat_KO) AS SMB_mat_KO, SUM(zl_zaop.MB_HARDOX) AS SMB_HARDOX, SUM(zl_zaop.mat_pom) AS Smat_pom, SUM(zl_zaop.tn_zam_z) AS Stn_zam_z FROM zl_zaop WHERE zl_zaop.id_zlec =$idzl ORDER BY zl_zaop.data_wp";
		if (!$db3->Query($szaosum)) $db3->Kill();
		$csuma=$db3->Row();
		$BMaterial=$csuma->SMB_mat_c + $csuma->SMB_mat_KO + $csuma->SMB_HARDOX;
		$BMatPom=$csuma->Smat_pom;


// TECHNOLOGIA sumy-----------------------------------------------------------------
    if (!$db4->Open()) $db4->Kill();
		$stechsum="SELECT SUM(zl_tech.g_przyg) AS Sg_przyg, SUM(zl_tech.g_mont) AS Sg_mont, SUM(zl_tech.g_kons) AS Sg_kons, SUM(zl_tech.obr_mech) AS Sobr_mech, SUM(zl_tech.powloki) AS Spowloki, SUM(zl_tech.matKO) AS SmatKO, SUM(zl_tech.T_HARDOX) AS ST_HARDOX, SUM(zl_tech.tn_wys) AS Stn_wys, SUM(zl_tech.grpbud) AS Sgrpbud, SUM(zl_tech.t_m_j) AS St_m_j, SUM(zl_tech.t_c_j) AS St_c_j FROM zl_tech WHERE zl_tech.id_zlec = $idzl ORDER BY zl_tech.data_wp";
		if (!$db4->Query($stechsum)) $db4->Kill();
		$c2suma=$db4->Row();
		$godzinyz=$c2suma->Sg_przyg + $c2suma->Sg_mont + $c2suma->Sg_kons;

// kooperacja----------------------------------------------------------------------
    if (!$db5->Open()) $db5->Kill();
		$szaosum="SELECT  SUM(zl_koop.obr_mech) AS Sobr_mech, SUM(zl_koop.cynkowanie) AS Scynkowanie, SUM(zl_koop.arbosol) AS Sarbosol, SUM(zl_koop.gumowanie) AS Sgumowanie, SUM(zl_koop.innepow) AS Sinnepow, SUM(zl_koop.trawienie) AS Strawienie, SUM(zl_koop.konstrukcja) AS Skonstrukcja, SUM(zl_koop.czygb) AS Sczygb, SUM(zl_koop.grpbud) AS Sgrpbud FROM zl_koop WHERE zl_koop.id_zlec =$idzl ORDER BY zl_koop.data_wp";
		if (!$db5->Query($szaosum)) $db5->Kill();
		$csuma=$db5->Row();
		$Btran=$csuma->Sczygb;
		$Bgrpbud=$csuma->Sgrpbud;
		$Buslprd = $csuma->Sobr_mech + $csuma->Scynkowanie + $csuma->Sarbosol + $csuma->Sgumowanie + $csuma->Sinnepow + $csuma->Strawienie + $csuma->Skonstrukcja;

//Zakladka: Controling sumy-------------------------------------------------------------------$
    if (!$db6->Open()) $db6->Kill();
		$sconsum="SELECT SUM(zl_zbyt.transport) AS Stransport, SUM(zl_zbyt.wart_sprz) AS Swart_sprz, SUM(zl_zbyt.godziny) AS Sgodziny, SUM(zl_zbyt.r_m_j) AS Sr_m_j, SUM(zl_zbyt.r_c_j) AS Sr_c_j FROM zl_zbyt WHERE zl_zbyt.id_zlec = $idzl";
		if (!$db6->Query($sconsum)) $db6->Kill();
		$c3suma=$db6->Row();

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
		<TR>
			<td class='DataTD8'><A HREF='zl_1.php?idzl=$row->lp'><B>$row->nr_zam_pl</B></A></TD>
			<td class='DataTD8'><B>$row->nr_zam_o</B></TD>
			<td class='DataTD8'><B>$row->obj</B></TD>
			<td class='DataTD8'><B>".number_format($godzinyz,2,',','.')."</B></TD>
			<td class='DataTD8'><B>".number_format($BMaterial,2,',','.')."</B></TD>
			<td class='DataTD8'><B>".number_format($BMatPom,2,',','.')."</B></TD>
			<td class='DataTD8'><B>".number_format($Bgrpbud,2,',','.')."</B></TD>
			<td class='DataTD8'><B>".number_format($Buslprd,2,',','.')."</B></TD>
			<td class='DataTD8'><B>".number_format($Btran,2,',','.')."</B></TD>
			<td class='DataTD8'><B>".number_format($BKTR,2,',','.')."</B></TD>
			<td class='DataTD8'><B>".number_format($Bkosztrob,2,',','.')."</B></TD>
			<td class='DataTD8'><B>".number_format($BTKW,2,',','.')."</B></TD>
			<td class='DataTD8'><B>".number_format($BKO,2,',','.')."</B></TD>
			<td class='DataTD8'><B>".number_format($BKOSZT,2,',','.')."</B></TD>
			<td class='DataTD8'><B>".number_format($BZLPLN,2,',','.')."</B></TD>";

            if ( $BWYNIK < 0 ) { echo "<td class='DataTD8'><FONT COLOR='#FF0000'><B>".number_format($BWYNIK,2,',','.')."</B></FONT></TD>"; }
			else {
			echo "<td class='DataTD8'><FONT COLOR='#6633FF'><B>".number_format($BWYNIK,2,',','.')."</B></FONT></TD>"; }

		echo "</TR>";

} // koniec petli calosci while

echo "
	</TBODY>
	
</TABLE>";
include("./footer.php");
?>