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
     <td ><A HREF='zl_1zaop.php?idzl=$idzl'><B>$ZLTYTZAO</B></A></td>

     <td><A HREF='zl_1tech.php?idzl=$idzl'><B>$ZLTYTTECH</B></A></td>
     <td><A HREF='zl_1zbyt.php?idzl=$idzl'><B>$ZLTYTZBYT</B></A></td>
	 <td bgcolor='#0000CC'><FONT SIZE=+1 COLOR='#33FFFF'><B>$ZLTYTKOOP</B></FONT></td>
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
	<CENTER><A HREF=zl_nkoop.php?idzl=$idzl><IMG SRC='images/ins.png' BORDER='0' ALT='Delete/Skasuj'> $NEWBTN: $ZLTYTKOOP</A></CENTER>
";	
} 



// Zakladka: kooperacja----------------------------------------------------------------------

	echo "<BR><font class='FormHeaderFont'>$ZLTYTKOOP</font><BR>

<table bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white'>

<tr><td class='FieldCaptionTD'>&nbsp;</td>
	<td class='FieldCaptionTD'><B>$ZLTOM</B></td>
    <td class='FieldCaptionTD'><B>$ZLKOOP1</B></td>
    <td class='FieldCaptionTD'><B>$ZLKOOP2</B></td>
    <td class='FieldCaptionTD'><B>$ZLKOOP3</B></td>
    <td class='FieldCaptionTD'><B>$ZLKOOP4</B></td>
    <td class='FieldCaptionTD'><B>$ZLKOOP5</B></td>
    <td class='FieldCaptionTD'><B>$ZLKOOP6</B></td>
    <td class='FieldCaptionTD'><B>$ZLGRPBUD</B></td>
    <td class='FieldCaptionTD'><B>$ZLCZYPO</B></td>

    <td class='FieldCaptionTD'><B>$ZLKDATAOD</B></td>
    <td class='FieldCaptionTD'><B>$ZLKDATADO</B></td>
<td class='FieldCaptionTD'><B>$ZLKPARTNER</B></td>
<td class='FieldCaptionTD'><B>$ZLPD</B></td>
</tr>";

    if (!$db->Open()) $db->Kill();
	$sqlprg = ("SELECT zl_koop.lp, zl_koop.id_zlec, zl_koop.kooperant, zl_koop.opis_op, zl_koop.obr_mech, zl_koop.cynkowanie, zl_koop.arbosol, zl_koop.gumowanie, zl_koop.innepow, zl_koop.trawienie, zl_koop.konstrukcja, zl_koop.uwagi, zl_koop.data_wp, zl_koop.id_wpr, zl_koop.data_popr, zl_koop.id_popr, zl_koop.datas, zl_koop.datak, zl_koop.czygb, zl_koop.grpbud, zl_koop.lastuse FROM zl_koop WHERE zl_koop.id_zlec = $idzl ORDER BY zl_koop.data_wp");

	if (!$db->Query($sqlprg)) $db->Kill();
		while ($c=$db->Row())
		{
		echo "
		<tr>
         <td class='DataTD'>
			<A HREF=zl_ukoop.php?idzl=$idzl&lp=$c->lp><IMG SRC='images/edit.png' BORDER='0' ALT='Edit/Popraw'></A>
            <A HREF=zl_dkoop.php?idzl=$idzl&lp=$c->lp><IMG SRC='images/drop.png' BORDER='0' ALT='Delete/Skasuj'></A>
            </td>
		 <td class='DataTD'>".number_format($c->obr_mech,2,',',' ')."</td>
		 <td class='DataTD'>".number_format($c->cynkowanie,2,',',' ')."</td>
		 <td class='DataTD'>".number_format($c->arbosol,2,',',' ')."</td>
		 <td class='DataTD'>".number_format($c->gumowanie,2,',',' ')."</td>
		 <td class='DataTD'>".number_format($c->innepow,2,',',' ')."</td>
		 <td class='DataTD'>".number_format($c->trawienie,2,',',' ')."</td>
		 <td class='DataTD'>".number_format($c->konstrukcja,2,',',' ')."</td>
		 <td class='DataTD'>".number_format($c->grpbud,2,',',' ')."</td>
		 <td class='DataTD'>".number_format($c->czygb,2,',',' ')."</td>
	     <td class='DataTD8'>$c->datas</td>
		 <td class='DataTD8'>$c->datak</td>
		<td class='DataTD8'>$c->kooperant</td>
		<td class='DataTD8'>$c->opis_op</td>
		</tr>
		";
		}
		$szaosum="SELECT  SUM(zl_koop.obr_mech) AS Sobr_mech, SUM(zl_koop.cynkowanie) AS Scynkowanie, SUM(zl_koop.arbosol) AS Sarbosol, SUM(zl_koop.gumowanie) AS Sgumowanie, SUM(zl_koop.innepow) AS Sinnepow, SUM(zl_koop.trawienie) AS Strawienie, SUM(zl_koop.konstrukcja) AS Skonstrukcja, SUM(zl_koop.czygb) AS Sczygb, SUM(zl_koop.grpbud) AS Sgrpbud FROM zl_koop WHERE zl_koop.id_zlec =$idzl ORDER BY zl_koop.data_wp";
		if (!$db->Query($szaosum)) $db->Kill();
		$csuma=$db->Row();
		echo "<tr>
         <td class='DataTD'><A HREF=zl_pzao.php?idzl=$idzl&lp=$c->lp><IMG SRC='images/print.png' BORDER='0' ALT='Print/Druk'></A>
</td>
		 <td class='DataTD'><B>".number_format($csuma->Sobr_mech,2,',',' ')."</B></td>
		 <td class='DataTD'><B>".number_format($csuma->Scynkowanie,2,',',' ')."</B></td>
		 <td class='DataTD'><B>".number_format($csuma->Sarbosol,2,',',' ')."</B></td>
		 <td class='DataTD'><B>".number_format($csuma->Sgumowanie,2,',',' ')."</B></td>
		 <td class='DataTD'><B>".number_format($csuma->Sinnepow,2,',',' ')."</B></td>
		 <td class='DataTD'><B>".number_format($csuma->Strawienie,2,',',' ')."</B></td>
		 <td class='DataTD'><B>".number_format($csuma->Skonstrukcja,2,',',' ')."</B></td>
		 <td class='DataTD'><B>".number_format($csuma->Sgrpbud,2,',',' ')."</B></td>
		 <td class='DataTD'><B>".number_format($csuma->Sczygb,2,',',' ')."</B></td>
		 <td class='DataTD8'>&nbsp;</td>
		 <td class='DataTD8'>&nbsp;</td>
		 <td class='DataTD8'>&nbsp;</td>
		 <td class='DataTD8'>&nbsp;</td>

		</tr>";

echo "</TABLE>";

echo "	</td></tr></table>";

include("./footer.php");
}
elseif($state==1)
{


} 

?>