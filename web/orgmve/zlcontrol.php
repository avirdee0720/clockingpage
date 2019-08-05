<?php
//if(!isset($id) && !isset($pw))
//{header("Location: index.html");exit;}

include("./header.php");

if(!isset($state))
{
	echo "<form action='$PHP_SELF' method='post' name='zest1'>
	";

   if (!$db->Open()) $db->Kill();
   
    $q11 =("SELECT zl_zlec.lp, zl_zlec.nr_zam_pl FROM zl_zlec	WHERE zl_zlec.nr_zam_pl = $nrzlpl LIMIT 1 ");

    if (!$db->Query($q11)) $db->Kill();
     $nr = $db->Row();
     $idzl = $nr->lp;

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
     <td bgcolor='#0000CC'><FONT SIZE=+1 COLOR='#33FFFF'><B>$zl</B></FONT></td>
     <td><A HREF='zl_1zaop.php?idzl=$idzl'><B>$ZLTYTZAO</B></A></td>

     <td><A HREF='zl_1tech.php?idzl=$idzl'><B>$ZLTYTTECH</B></A></td>
     <td><A HREF='zl_1zbyt.php?idzl=$idzl'><B>$ZLTYTZBYT</B></A></td>
	 <td><A HREF='zl_1kons.php?idzl=$idzl'><B>$ZLTYTKONS</B></A></td>
	 <td>&nbsp;</td>
</tr><tr><td colspan=6>

		
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
<!--  2005-06-14 -->
	<tr>
     <td class='FieldCaptionTD'>$ZLPSP:</td>
     <td class='DataTD'>$row->pspelem</td>

	 <td class='FieldCaptionTD'>$ZLTEILENO:</td>
     <td class='DataTD'>$row->teileno</td>
     </tr>
	<tr>
     <td class='FieldCaptionTD'>$ZLDATAZAM:</td>
     <td class='DataTD'>$row->data_zam</td>

	 <td class='FieldCaptionTD'>$ZLDATAOTW:</td>
     <td class='DataTD'>$row->data_otw</td>
     </tr>
		<tr>
     <td class='FieldCaptionTD'>$ZLZAKT:</td>
     <td class='DataTD'>$row->zakt</td>

	 <td class='FieldCaptionTD'>$ZLDOSTMD:</td>
     <td class='DataTD'>$row->dostMD</td>
     </tr>
	<tr>
     <td class='FieldCaptionTD'>$ZLKONS:</td>
     <td class='DataTD'>$row->konserwacja</td>

	 <td class='FieldCaptionTD'>$ZLTP1:</td>
     <td class='DataTD'>$row->TP</td>
     </tr>
	<tr>
     <td class='FieldCaptionTD'>$ZLKTERM:</td>
     <td class='DataTD'>$row->ktermin</td>

	 <td class='FieldCaptionTD'>$ZLKPARTNER:</td>
     <td class='DataTD'>$row->kpartner</td>
     </tr>
	<tr>
     <td class='FieldCaptionTD'>$ZLKDATAOD:</td>
     <td class='DataTD'>$row->kdata</td>

	 <td class='DataTD'>&nbsp;</td>
     <td class='DataTD'>&nbsp;</td>
     </tr>

</table>
<BR>
<table WIDTH=700 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >	 

     <tr>
     <td class='FieldCaptionTD'>$USERFULL:</td>
     <td class='DataTD'>
		 <SMALL>$USERFULL <B>$row->USR</B>&nbsp;$row->data&nbsp;$row->data_wp,
		 <BR>$TYTED: <B>$popr->nazwa</B>, $row->data_popr  </td>
	     </SMALL>
	<td class='DataTD'>
		  <A HREF=zl_ed_zl2.php?idzl=$row->lp><IMG SRC='images/edit.png' BORDER='0' ALT='Edit/Popraw'></A></td>
	</tr>
	<tr>
     <td class='FieldCaptionTD'>$ZLUWAGI:</td>
     <td class='DataTD'>$row->uwagi </td>
     <td class='DataTD'>
		<A HREF=zl_del_zl.php?idzl=$idzl><IMG SRC='images/drop.png' BORDER='0' ALT='Delete/Skasuj'></A></td>
     </tr>
	<tr>
     <td class='FieldCaptionTD'>$ADDNEWBTN:</td>
     <td class='DataTD'>
	<A HREF=zl_nzao.php?idzl=$idzl><IMG SRC='images/ins.png' BORDER='0' ALT='Delete/Skasuj'>$ZLTYTZAO</A>
    <A HREF=zl_ntech.php?idzl=$idzl&wze=$wze><IMG SRC='images/ins.png' BORDER='0' ALT='Delete/Skasuj'>$ZLTYTTECH</A>
	<A HREF=zl_nzbyt.php?idzl=$idzl><IMG SRC='images/ins.png' BORDER='0' ALT='Delete/Skasuj'>$ZLTYTZBYT</A></td>
	<td class='DataTD'>
		 <A HREF=zl_prn_zl.php?idzl=$idzl><IMG SRC='images/print.png' BORDER='0' ALT='Print/Druk'></A>
		 <A HREF=zl_zmtech.php?idzl=$idzl><IMG SRC='images/zamknij.png' BORDER='0' ALT='zamknij'></A>
		 </td>
     </tr>
     </table>";	
	} 



// Zakladka: Zaopatrzenie sumy---------------------------------------------------------------

	echo "<BR><B>$ZLTYTZAO:</B>

<table bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white'>

<tr>
	<td class='FieldCaptionTD'><B>$ZLMC</B></td>
    <td class='FieldCaptionTD'><B>$ZLMKO</B></td>
    <td class='FieldCaptionTD'><B>$ZLMHARDOX</B></td>
    <td class='FieldCaptionTD'><B>$ZLMPOM</B></td>
</tr>";

    if (!$db->Open()) $db->Kill();
		$szaosum="SELECT  SUM(zl_zaop.MB_mat_c) AS SMB_mat_c, SUM(zl_zaop.MB_mat_KO) AS SMB_mat_KO, SUM(zl_zaop.MB_HARDOX) AS SMB_HARDOX, SUM(zl_zaop.mat_pom) AS Smat_pom, SUM(zl_zaop.tn_zam_z) AS Stn_zam_z FROM zl_zaop WHERE zl_zaop.id_zlec =$idzl ORDER BY zl_zaop.data_wp";
		if (!$db->Query($szaosum)) $db->Kill();
		$csuma=$db->Row();
		echo "<tr>
		 <td class='DataTD'><B>".number_format($csuma->SMB_mat_c,2,',',' ')."</B></td>
		 <td class='DataTD'><B>".number_format($csuma->SMB_mat_KO,2,',',' ')."</B></td>
		 <td class='DataTD'><B>".number_format($csuma->SMB_HARDOX,2,',',' ')."</B></td>
		 <td class='DataTD'><B>".number_format($csuma->Smat_pom,2,',',' ')."</B></td>
		</tr>";

echo "</TABLE>";



//Zakladka TECHNOLOGIA sumy-----------------------------------------------------------------
echo "<BR><B>$ZLTYTTECH</B>

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
</tr>";

    if (!$db->Open()) $db->Kill();
	$sqlprg = ("SELECT zl_tech.lp, zl_tech.id_zlec, zl_tech.g_zad, zl_tech.obr_mech, zl_tech.powloki, zl_tech.matKO, zl_tech.T_HARDOX, zl_tech.tn_wys, zl_tech.t_m_j, zl_tech.t_c_j, zl_tech.uwagi, zl_tech.data_wp, zl_tech.id_wpr, zl_tech.data_popr, zl_tech.id_popr, zl_tech.data FROM zl_tech WHERE zl_tech.id_zlec = $idzl ORDER BY zl_tech.data_wp");

	if (!$db->Query($sqlprg)) $db->Kill();

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

		</tr>";

echo "</TABLE>";
//Zakladka: Controling sumy-------------------------------------------------------------------$
echo "<BR><B>$ZLTYTZBYT</B>
<table WIDTH=700 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >
<tr>
    <td class='FieldCaptionTD'><B>$ZLZTR</B></td>
    <td class='FieldCaptionTD'><B>$ZLZWS</B></td>
    <td class='FieldCaptionTD'><B>$ZLZGODZ</B></td>
    <td class='FieldCaptionTD'><B>$ZLZRNJ1</B></td>
    <td class='FieldCaptionTD'><B>$ZLZRCJ1</B></td>
</tr>";

    if (!$db->Open()) $db->Kill();
		$sconsum="SELECT SUM(zl_zbyt.transport) AS Stransport, SUM(zl_zbyt.wart_sprz) AS Swart_sprz, SUM(zl_zbyt.godziny) AS Sgodziny, SUM(zl_zbyt.r_m_j) AS Sr_m_j, SUM(zl_zbyt.r_c_j) AS Sr_c_j FROM zl_zbyt WHERE zl_zbyt.id_zlec = $idzl";
		if (!$db->Query($sconsum)) $db->Kill();
		$c3suma=$db->Row();
				echo "
		 <td class='DataTD'><B>".number_format($c3suma->Stransport,2,',',' ')."</B></td>
		 <td class='DataTD'><B>".number_format($c3suma->Swart_sprz,2,',',' ')."</B></td>
		 <td class='DataTD'><B>".number_format($c3suma->Sgodziny,2,',',' ')."</B></td>
		 <td class='DataTD'><B>".number_format($c3suma->Sr_m_j,2,',',' ')."</B></td>
		 <td class='DataTD'><B>".number_format($c3suma->Sr_c_j,2,',',' ')."</B></td>
		</tr>";

echo "</TABLE>	</td></tr></table>";

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