<?php
//if(!isset($id) && !isset($pw))
//{header("Location: index.html");exit;}

include("./header.php");
//$tytul='Zlecenie komputerowy numer ';

if(!isset($state))
{
	echo "<form action='$PHP_SELF' method='post' name='zest1'>
	";

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
     <td ><A HREF='zl_1.php?idzl=$idzl'><B>$zl</B></A></td>
     <td bgcolor='#0000CC'><FONT SIZE=+1 COLOR='#33FFFF'><B>$ZLTYTZAO</B></FONT></td>

     <td><A HREF='zl_1tech.php?idzl=$idzl'><B>$ZLTYTTECH</B></A></td>
     <td><A HREF='zl_1zbyt.php?idzl=$idzl'><B>$ZLTYTZBYT</B></A></td>
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
	<CENTER><A HREF=zl_nzao.php?idzl=$idzl><IMG SRC='images/ins.png' BORDER='0' ALT='Delete/Skasuj'> $NEWBTN: $ZLTYTZAO</A></CENTER>
";	
} 



// Zakladka: Zaopatrzenie----------------------------------------------------------------------

	echo "<BR><font class='FormHeaderFont'>$ZLTYTZAO</font><BR>

<table bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white'>

<tr><td class='FieldCaptionTD'>&nbsp;</td>
    <td class='FieldCaptionTD'><B>$ZLMKO</B></td>
	<td class='FieldCaptionTD'><B>$ZLMC</B></td>
    <td class='FieldCaptionTD'><B>$ZLMHARDOX</B></td>
    <td class='FieldCaptionTD'><B>$ZLFARBY</B></td>
    <td class='FieldCaptionTD'><B>$ZLMZL1</B></td>
    <td class='FieldCaptionTD'><B>$ZLINNE</B></td>
    <td class='FieldCaptionTD'><B>$ZLUWAGI</B></td>
</tr>";



    if (!$db->Open()) $db->Kill();
	$sqlprg = ("SELECT  zl_zaop.lp, zl_zaop.id_zlec, zl_zaop.MB_mat_c, zl_zaop.MB_mat_KO, zl_zaop.MB_HARDOX, zl_zaop.mat_pom,  zl_zaop.farby,  zl_zaop.matzl,  zl_zaop.inne, zl_zaop.tn_zam_z, zl_zaop.uwagi, zl_zaop.data_wp, zl_zaop.id_wpr, zl_zaop.data_popr, zl_zaop.id_popr, zl_zaop.data FROM zl_zaop WHERE zl_zaop.id_zlec = $idzl ORDER BY zl_zaop.data_wp");

	if (!$db->Query($sqlprg)) $db->Kill();
		while ($c=$db->Row())
		{
		echo "
		<tr>
         <td class='DataTD'>
			<A HREF=zl_uzao.php?idzl=$idzl&lp=$c->lp><IMG SRC='images/edit.png' BORDER='0' ALT='Edit/Popraw'></A>
            <A HREF=zl_dzao.php?idzl=$idzl&lp=$c->lp><IMG SRC='images/drop.png' BORDER='0' ALT='Delete/Skasuj'></A>
            </td>
		 <td class='DataTD'>".number_format($c->MB_mat_KO,2,',',' ')."</td>
		 <td class='DataTD'>".number_format($c->MB_mat_c,2,',',' ')."</td>
		 <td class='DataTD'>".number_format($c->MB_HARDOX,2,',',' ')."</td>
		 <td class='DataTD'>".number_format($c->farby,2,',',' ')."</td>
		 <td class='DataTD'>".number_format($c->matzl,2,',',' ')."</td>
		 <td class='DataTD'>".number_format($c->inne,2,',',' ')."</td>
		 <td class='DataTD'>$c->uwagi</td>

		</tr>
		";
		}
		$szaosum="SELECT  SUM(zl_zaop.MB_mat_c) AS SMB_mat_c, SUM(zl_zaop.MB_mat_KO) AS SMB_mat_KO, SUM(zl_zaop.MB_HARDOX) AS SMB_HARDOX, SUM(zl_zaop.farby) AS Sfarby, SUM(zl_zaop.matzl) AS Smatzl, SUM(zl_zaop.inne) AS Sinne, SUM(zl_zaop.tn_zam_z) AS Stn_zam_z FROM zl_zaop WHERE zl_zaop.id_zlec =$idzl ORDER BY zl_zaop.data_wp";
		if (!$db->Query($szaosum)) $db->Kill();
		$csuma=$db->Row();
		echo "<tr>
         <td class='DataTD'><A HREF=zl_pzao.php?idzl=$idzl&lp=$c->lp><IMG SRC='images/print.png' BORDER='0' ALT='Print/Druk'></A>
</td>
		 <td class='DataTD'><B>".number_format($csuma->SMB_mat_KO,2,',',' ')."</B></td>
		 <td class='DataTD'><B>".number_format($csuma->SMB_mat_c,2,',',' ')."</B></td>
		 <td class='DataTD'><B>".number_format($csuma->SMB_HARDOX,2,',',' ')."</B></td>
		 <td class='DataTD'><B>".number_format($csuma->Sfarby,2,',',' ')."</B></td>
		 <td class='DataTD'><B>".number_format($csuma->Smatzl,2,',',' ')."</B></td>
		 <td class='DataTD'><B>".number_format($csuma->Sinne,2,',',' ')."</B></td>
		<td class='DataTD'>$c->uwagi</td>

		</tr>";

echo "</TABLE>";

echo "	</td></tr></table>";

include("./footer.php");
}
elseif($state==1)
{


} 

?>