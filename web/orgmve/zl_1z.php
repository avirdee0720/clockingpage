<?php
//if(!isset($id) && !isset($pw))
//{header("Location: index.html");exit;}

include("./header.php");
//$tytul='Zlecenie komputerowy numer ';

if(!isset($state))
{
	echo "<form action='$PHP_SELF' method='post' name='zest1'>
		<CENTER>

</CENTER>
	";

   if (!$db->Open()) $db->Kill();

    $q =("SELECT zl_zlec.lp, zl_zlec.nr_zam_pl, zl_zlec.nr_zam_o, zl_zlec.nr_poz, zl_zlec.nr_kom, zl_zlec.obj, zl_zlec.nazwa, zl_zlec.w_z_e, zl_zlec.kurs, zl_zlec.w_z_p, zl_zlec.tn_zam, zl_zlec.uwagi, zl_zlec.data_wp, zl_zlec.id_wpr, zl_zlec.data_popr, zl_zlec.id_popr, zl_zlec.data, hd_users.nazwa AS USR FROM zl_zlec
	INNER JOIN hd_users ON zl_zlec.id_wpr = hd_users.lp
	WHERE zl_zlec.lp = $idzl LIMIT 1 ");

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
     </tr><tr>
     <td class='FieldCaptionTD'>$ZLWE:</td>
     <td class='DataTD'>".number_format($row->w_z_e,2,',',' ')."</td>

     <td class='FieldCaptionTD'>$ZLK:</td>
     <td class='DataTD'>".number_format($row->kurs,2,',',' ')."</td>
     </tr><tr>
     <td class='FieldCaptionTD'>$ZLWZ:</td>
     <td class='DataTD'>".number_format($row->w_z_p,2,',',' ')."</td>

	 <td class='FieldCaptionTD'>$ZLTNZ:</td>
     <td class='DataTD'>".number_format($row->tn_zam,2,',',' ')."</td>
     </tr>
     </table>
<table WIDTH=700 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >	 

     <tr>
     <td class='FieldCaptionTD'>$USERFULL:</td>
     <td class='DataTD'>
		 <SMALL>$USERFULL <B>$row->USR</B>&nbsp;$row->data&nbsp;$row->data_wp,
		 <BR>$TYTED: <B>$popr->nazwa</B>, $row->data_popr  </td>
	     </SMALL>
	<td class='DataTD'>
		 <A HREF=zl_prn_zl.php?idzl=$idzl><IMG SRC='images/print.png' BORDER='0' ALT='Print/Druk'></A>
	</tr>
	<tr>
     <td class='FieldCaptionTD'>$ZLUWAGI:</td>
     <td class='DataTD'>$row->uwagi </td>
     <td class='DataTD'>
		 <A HREF=zl_zam_zl.php?idzl=$idzl><IMG SRC='images/zamknij.png' BORDER='0' ALT='Open???'></A>
     </tr>
     </table>";	
	} 

// zlecenia: Zaopatrzenie----------------------------------------------------------------------

	echo "<BR><font class='FormHeaderFont'>$ZLTYTZAO</font><BR>

<table bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white'>

<tr>
	<td class='FieldCaptionTD'><B>$ZLMC</B></td>
    <td class='FieldCaptionTD'><B>$ZLMKO</B></td>
    <td class='FieldCaptionTD'><B>$ZLMHARDOX</B></td>
    <td class='FieldCaptionTD'><B>$ZLMPOM</B></td>
    <td class='FieldCaptionTD'><B>$ZLUWAGI</B></td>
</tr>";

    if (!$db->Open()) $db->Kill();
	$sqlprg = ("SELECT  zl_zaop.lp, zl_zaop.id_zlec, zl_zaop.MB_mat_c, zl_zaop.MB_mat_KO, zl_zaop.MB_HARDOX, zl_zaop.mat_pom, zl_zaop.tn_zam_z, zl_zaop.uwagi, zl_zaop.data_wp, zl_zaop.id_wpr, zl_zaop.data_popr, zl_zaop.id_popr, zl_zaop.data FROM zl_zaop WHERE zl_zaop.id_zlec = $idzl ORDER BY zl_zaop.data_wp");

	if (!$db->Query($sqlprg)) $db->Kill();
		while ($c=$db->Row())
		{
		echo "
		<tr>
		 <td class='DataTD'>".number_format($c->MB_mat_c,2,',',' ')."</td>
		 <td class='DataTD'>".number_format($c->MB_mat_KO,2,',',' ')."</td>
		 <td class='DataTD'>".number_format($c->MB_HARDOX,2,',',' ')."</td>
		 <td class='DataTD'>".number_format($c->mat_pom,2,',',' ')."</td>
		 <td class='DataTD'>$c->uwagi</td>
		</tr>
		";
		}
		$szaosum="SELECT  SUM(zl_zaop.MB_mat_c) AS SMB_mat_c, SUM(zl_zaop.MB_mat_KO) AS SMB_mat_KO, SUM(zl_zaop.MB_HARDOX) AS SMB_HARDOX, SUM(zl_zaop.mat_pom) AS Smat_pom, SUM(zl_zaop.tn_zam_z) AS Stn_zam_z FROM zl_zaop WHERE zl_zaop.id_zlec =$idzl ORDER BY zl_zaop.data_wp";
		if (!$db->Query($szaosum)) $db->Kill();
		$csuma=$db->Row();
		echo "<tr>
		 <td class='DataTD'><B>".number_format($csuma->SMB_mat_c,2,',',' ')."</B></td>
		 <td class='DataTD'><B>".number_format($csuma->SMB_mat_KO,2,',',' ')."</B></td>
		 <td class='DataTD'><B>".number_format($csuma->SMB_HARDOX,2,',',' ')."</B></td>
		 <td class='DataTD'><B>".number_format($csuma->Smat_pom,2,',',' ')."</B></td>
		 <td class='DataTD'>$c->uwagi</td>

		</tr>";

echo "</TABLE>";
//----------------------------------------------------------------------$ZLTYTZBYT
echo "<BR><font class='FormHeaderFont'>$ZLTYTTECH </font><BR>

<table bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white'>

<tr>
	<td class='FieldCaptionTD'><B>$ZLTGZ1</B></td>
    <td class='FieldCaptionTD'><B>$ZLTOM1</B></td>
    <td class='FieldCaptionTD'><B>$ZLTP</B></td>
    <td class='FieldCaptionTD'><B>$ZLTMKO</B></td>
    <td class='FieldCaptionTD'><B>$ZLTHD</B></td>
    <td class='FieldCaptionTD'><B>$ZLTTNW</B></td>
    <td class='FieldCaptionTD'><B>$ZLTTNJ1</B></td>
    <td class='FieldCaptionTD'><B>$ZLTTCJ1</B></td>
    <td class='FieldCaptionTD'><B>$ZLUWAGI</B></td>
</tr>";

    if (!$db->Open()) $db->Kill();
	$sqlprg = ("SELECT zl_tech.lp, zl_tech.id_zlec, zl_tech.g_zad, zl_tech.obr_mech, zl_tech.powloki, zl_tech.matKO, zl_tech.T_HARDOX, zl_tech.tn_wys, zl_tech.t_m_j, zl_tech.t_c_j, zl_tech.uwagi, zl_tech.data_wp, zl_tech.id_wpr, zl_tech.data_popr, zl_tech.id_popr, zl_tech.data FROM zl_tech WHERE zl_tech.id_zlec = $idzl ORDER BY zl_tech.data_wp");

	if (!$db->Query($sqlprg)) $db->Kill();
		while ($c=$db->Row())
		{
		echo "
		 <td class='DataTD'>".number_format($c->g_zad,2,',',' ')."</td>
		 <td class='DataTD'>".number_format($c->obr_mech,2,',',' ')."</td>
		 <td class='DataTD'>".number_format($c->powloki,2,',',' ')."</td>
		 <td class='DataTD'>".number_format($c->matKO,2,',',' ')."</td>
		 <td class='DataTD'>".number_format($c->T_HARDOX,2,',',' ')."</td>
		 <td class='DataTD'>".number_format($c->tn_wys,2,',',' ')."</td>
		 <td class='DataTD'>".number_format($c->t_m_j,2,',',' ')."</td>
		 <td class='DataTD'>".number_format($c->t_c_j,2,',',' ')."</td>		
		 <td class='DataTD'>$c->uwagi</td>
		</tr>";
		}

		$stechsum="SELECT SUM(zl_tech.g_zad) AS Sg_zad, SUM(zl_tech.obr_mech) AS Sobr_mech, SUM(zl_tech.powloki) AS Spowloki, SUM(zl_tech.matKO) AS SmatKO, SUM(zl_tech.T_HARDOX) AS ST_HARDOX, SUM(zl_tech.tn_wys) AS Stn_wys, SUM(zl_tech.t_m_j) AS St_m_j, SUM(zl_tech.t_c_j) AS St_c_j FROM zl_tech WHERE zl_tech.id_zlec = $idzl ORDER BY zl_tech.data_wp";
		if (!$db->Query($stechsum)) $db->Kill();
		$c2suma=$db->Row();
		echo "
		 <td class='DataTD'><B>".number_format($c2suma->Sg_zad,2,',',' ')."</B></td>
		 <td class='DataTD'><B>".number_format($c2suma->Sobr_mech,2,',',' ')."</B></td>
		 <td class='DataTD'><B>".number_format($c2suma->Spowloki,2,',',' ')."</B></td>
		 <td class='DataTD'><B>".number_format($c2suma->SmatKO,2,',',' ')."</B></td>
		 <td class='DataTD'><B>".number_format($c2suma->ST_HARDOX,2,',',' ')."</B></td>
		 <td class='DataTD'><B>".number_format($c2suma->Stn_wys,2,',',' ')."</B></td>
		 <td class='DataTD'><B>".number_format($c2suma->St_m_j,2,',',' ')."</B></td>
		 <td class='DataTD'><B>".number_format($c2suma->St_c_j,2,',',' ')."</B></td>		
		 <td class='DataTD'>&nbsp;</td>
		</tr>";

echo "</TABLE>";
//----------------------------------------------------------------------$
echo "<BR><font class='FormHeaderFont'>$ZLTYTZBYT</font><BR>
<table WIDTH=700 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >
<tr>
    <td class='FieldCaptionTD'><B>$ZLZTR</B></td>
    <td class='FieldCaptionTD'><B>$ZLZWS</B></td>
    <td class='FieldCaptionTD'><B>$ZLZGODZ</B></td>
    <td class='FieldCaptionTD'><B>$ZLZRNJ1</B></td>
    <td class='FieldCaptionTD'><B>$ZLZRCJ1</B></td>
    <td class='FieldCaptionTD'><B>$ZLUWAGI</B></td>
</tr>";

    if (!$db->Open()) $db->Kill();
	$sqlprg = ("SELECT zl_zbyt.lp, zl_zbyt.id_zlec, zl_zbyt.transport, zl_zbyt.wart_sprz, zl_zbyt.godziny, zl_zbyt.r_m_j, zl_zbyt.r_c_j, zl_zbyt.uwagi, zl_zbyt.data_wp, zl_zbyt.id_wpr, zl_zbyt.data_popr, zl_zbyt.id_popr, zl_zbyt.data FROM zl_zbyt WHERE zl_zbyt.id_zlec = $idzl ORDER BY zl_zbyt.data_wp");

// ALTER TABLE `zl_zbyt` DROP PRIMARY KEY ,
// ADD PRIMARY KEY ( `lp` ) 

	if (!$db->Query($sqlprg)) $db->Kill();
		while ($c=$db->Row())
		{
		echo "
		 <td class='DataTD'>".number_format($c->transport,2,',',' ')."</td>
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

		 <td class='DataTD'><B>".number_format($c3suma->Stransport,2,',',' ')."</B></td>
		 <td class='DataTD'><B>".number_format($c3suma->Swart_sprz,2,',',' ')."</B></td>
		 <td class='DataTD'><B>".number_format($c3suma->Sgodziny,2,',',' ')."</B></td>
		 <td class='DataTD'><B>".number_format($c3suma->Sr_m_j,2,',',' ')."</B></td>
		 <td class='DataTD'><B>".number_format($c3suma->Sr_c_j,2,',',' ')."</B></td>
		 <td class='DataTD'>&nbsp;</td>
		</tr>";

echo "</TABLE>";

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