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

     <td bgcolor='#0000CC'><FONT SIZE=+1 COLOR='#33FFFF'><B>$ZLTYTTECH</B></FONT></td>
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

    <CENTER><A HREF=zl_ntech.php?idzl=$idzl&wze=$wze><IMG SRC='images/ins.png' BORDER='0' ALT='Delete/Skasuj'> $ADDNEWBTN: $ZLTYTTECH</A></CENTER>
	";	
	} 


//Zakladka TECHNOLOGIA----------------------------------------------------------------------
echo "<BR><font class='FormHeaderFont'>$ZLTYTTECH </font><BR>

<table bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white'>

<tr><td class='FieldCaptionTD'>&nbsp;</td>
	<td class='FieldCaptionTD'><B>$ZLTGZ2</B></td>
	<td class='FieldCaptionTD'><B>$ZLTGZ3</B></td>
	<td class='FieldCaptionTD'><B>$ZLTGZ4</B></td>

    <td class='FieldCaptionTD'><B>$ZLTMKO</B></td>
    <td class='FieldCaptionTD'><B>$ZLTHD</B></td>
    <td class='FieldCaptionTD'><B>$ZLTTNW</B></td>
    <td class='FieldCaptionTD'><B>$ZLTTNJ1</B></td>
    <td class='FieldCaptionTD'><B>$ZLTTCJ1</B></td>
    <td class='FieldCaptionTD'><B>$ZLUWAGI</B></td>
</tr>";

    if (!$db->Open()) $db->Kill();
	$sqlprg = ("SELECT zl_tech.lp, zl_tech.id_zlec, zl_tech.g_zad, zl_tech.g_przyg, zl_tech.g_mont, zl_tech.g_kons, zl_tech.matKO, zl_tech.T_HARDOX, zl_tech.tn_wys, zl_tech.t_m_j, zl_tech.t_c_j, zl_tech.uwagi, zl_tech.data_wp, zl_tech.id_wpr, zl_tech.data_popr, zl_tech.id_popr, zl_tech.data FROM zl_tech WHERE zl_tech.id_zlec = $idzl ORDER BY zl_tech.data_wp");

	if (!$db->Query($sqlprg)) $db->Kill();
		while ($c=$db->Row())
		{
		echo "
         <td class='DataTD'>
			<A HREF=zl_utech.php?idzl=$idzl&lp=$c->lp&wze=$wze><IMG SRC='images/edit.png' BORDER='0' ALT='Edit/Popraw'></A>
            <A HREF=zl_dtech.php?idzl=$idzl&lp=$c->lp&wze=$wze><IMG SRC='images/drop.png' BORDER='0' ALT='Delete/Skasuj'></A>
            </td>
		 <td class='DataTD'>".number_format($c->g_przyg,2,',',' ')."</td>
		 <td class='DataTD'>".number_format($c->g_mont,2,',',' ')."</td>
		 <td class='DataTD'>".number_format($c->g_kons,2,',',' ')."</td>

		 <td class='DataTD'>".number_format($c->matKO,2,',',' ')."</td>
		 <td class='DataTD'>".number_format($c->T_HARDOX,2,',',' ')."</td>
		 <td class='DataTD'>".number_format($c->tn_wys,2,',',' ')."</td>
		 <td class='DataTD'>".number_format($c->t_m_j,2,',',' ')."</td>
		 <td class='DataTD'>".number_format($c->t_c_j,2,',',' ')."</td>		
		 <td class='DataTD'>$c->uwagi</td>
		</tr>";
		}

		$stechsum="SELECT SUM(zl_tech.g_przyg) AS Sg_przyg, SUM(zl_tech.g_mont) AS Sg_mont, SUM(zl_tech.g_kons) AS Sg_kons,  SUM(zl_tech.matKO) AS SmatKO, SUM(zl_tech.T_HARDOX) AS ST_HARDOX, SUM(zl_tech.tn_wys) AS Stn_wys, SUM(zl_tech.t_m_j) AS St_m_j, SUM(zl_tech.t_c_j) AS St_c_j FROM zl_tech WHERE zl_tech.id_zlec = $idzl ORDER BY zl_tech.data_wp";
		if (!$db->Query($stechsum)) $db->Kill();
		$c2suma=$db->Row();
		echo "
         <td class='DataTD'>			
			 <A HREF=zl_rptech.php?idzl=$idzl><IMG SRC='images/print.png' BORDER='0' ALT='Print/Druk'></A>
			<A HREF=zl_zmtech.php?idzl=$idzl><IMG SRC='images/zamknij.png' BORDER='0' ALT='zamknij'></A>
		</td>
		 <td class='DataTD'><B>".number_format($c2suma->Sg_przyg,2,',',' ')."</B></td>
		 <td class='DataTD'><B>".number_format($c2suma->Sg_mont,2,',',' ')."</B></td>
		 <td class='DataTD'><B>".number_format($c2suma->Sg_kons,2,',',' ')."</B></td>

		 <td class='DataTD'><B>".number_format($c2suma->SmatKO,2,',',' ')."</B></td>
		 <td class='DataTD'><B>".number_format($c2suma->ST_HARDOX,2,',',' ')."</B></td>
		 <td class='DataTD'><B>".number_format($c2suma->Stn_wys,2,',',' ')."</B></td>
		 <td class='DataTD'><B>".number_format($c2suma->St_m_j,2,',',' ')."</B></td>
		 <td class='DataTD'><B>".number_format($c2suma->St_c_j,2,',',' ')."</B></td>		
		 <td class='DataTD'>&nbsp;</td>
		</tr>";

echo "</TABLE>
		</td></tr></table>";

include("./footer.php");
}
elseif($state==1)
{

} 

?>