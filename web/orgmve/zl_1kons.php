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
     <td><A HREF='zl_1.php?idzl=$idzl'><B>$zl</B></A></td>
     <td><A HREF='zl_1zaop.php?idzl=$idzl'><B>$ZLTYTZAO</B></A></td>
     <td><A HREF='zl_1tech.php?idzl=$idzl'><B>$ZLTYTTECH</B></A></td>
     <td><A HREF='zl_1zbyt.php?idzl=$idzl'><B>$ZLTYTZBYT</B></A></td>
	 <td><A HREF='zl_1koop.php?idzl=$idzl'><B>$ZLTYTKOOP</B></A></td>
	 <td bgcolor='#0000CC'><FONT SIZE=+1 COLOR='#33FFFF'><A HREF='zl_1kons.php?idzl=$idzl'><B>$ZLTYTKONS</B></A></FONT></td>
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
	<CENTER><A HREF=zl_nrys.php?idzl=$idzl><IMG SRC='images/ins.png' BORDER='0' ALT='Delete/Skasuj'> $NEWBTN: $ZLRYS</A></CENTER>
";	
} 



// Zakladka: Zaopatrzenie----------------------------------------------------------------------

	echo "<BR><font class='FormHeaderFont'>$ZLTYTKONS</font><BR>

<table bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white'>

<tr><td class='FieldCaptionTD'>&nbsp;</td>
	<td class='FieldCaptionTD'><B>$ZLPAT</B></td>
    <td class='FieldCaptionTD'><B>$ZLZNR</B></td>
    <td class='FieldCaptionTD'><B>$ZLPS</B></td>
    <td class='FieldCaptionTD'><B>$ZLPD</B></td>
    <td class='FieldCaptionTD'><B>$ZLPEND</B></td>
    <td class='FieldCaptionTD'><B>$ZLPFN</B></td>
    <td class='FieldCaptionTD'><B>$ZLPFS</B></td>
    <td class='FieldCaptionTD'><B>$ZLPFT</B></td>
    <td class='FieldCaptionTD'><B>$ZLPP</B></td>
    <td class='FieldCaptionTD'><B>$ZLPF</B></td>
    <td class='FieldCaptionTD'><B>$ZLPLINK</B></td>
    <td class='FieldCaptionTD'><B>$RPNDATE</B></td>
</tr>";

    if (!$db->Open()) $db->Kill();
	$sqlprg = ("SELECT  photo_id, id_zlec, photo_alttext, zeichnungsnr, photo_src, photo_desc, photo_endesc, photo_filename, photo_filesize, photo_filetype, photo_path, photo_format, photo_link, data_wp, id_wpr, data_popr, id_popr, data FROM hd_imgcad WHERE hd_imgcad.id_zlec = $idzl ORDER BY hd_imgcad.data_wp");

	if (!$db->Query($sqlprg)) $db->Kill();
		while ($c=$db->Row())
		{
		echo "
		<tr>
         <td class='DataTD'>
			<A HREF=zl_urys.php?idzl=$idzl&lp=$c->photo_id><IMG SRC='images/edit.png' BORDER='0' ALT='Edit/Popraw'></A>
            <A HREF=zl_drys.php?idzl=$idzl&lp=$c->photo_id><IMG SRC='images/drop.png' BORDER='0' ALT='Delete/Skasuj'></A>
			<A HREF=javascript:display(\"werk1.php?idzl=$idzl&lp=$c->photo_id\",600,600)>$PRINTBTN</A>
            </td>
		 <td class='DataTD'>$c->photo_alttext </td>
		 <td class='DataTD'>$c->zeichnungsnr </td>
		 <td class='DataTD'>$c->photo_src </td>
		 <td class='DataTD'>$c->photo_desc </td>
		 <td class='DataTD'>$c->photo_endesc </td>
		 <td class='DataTD'>$c->photo_filename </td>
		 <td class='DataTD'>$c->photo_filesize </td>
		 <td class='DataTD'>$c->photo_filetype </td>
		 <td class='DataTD'>$c->photo_path </td>
		 <td class='DataTD'>$c->photo_format </td>
		 <td class='DataTD'>$c->photo_link </td>
		 <td class='DataTD'>$c->data </td>

		</tr>
		";
		}


echo "</TABLE>";

echo "	</td></tr></table>";

include("./footer.php");
}
elseif($state==1)
{


} 

?>