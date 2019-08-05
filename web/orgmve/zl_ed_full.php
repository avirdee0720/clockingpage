<?php
//if(!isset($id) && !isset($pw))
//{header("Location: index.html");exit;}

include_once("./header.php");
include("./languages/$LANGUAGE.php");
include_once("./inc/mlfn.inc.php");
$nP="$PHP_SELF";
$numrows=15;

uprstr($PU,70);

if(!isset($state))
{
	echo "	<TD ALIGN=JUSTIFY VALIGN=TOP border=0>
	<table width='100%' border=0><TR BGCOLOR='$kolorTlaRamki'>
		</tr></table><table width='100%' border=0><tr><td>

<center>
<form action='$PHP_SELF' method='post' name='zl_new'>
  <font class='FormHeaderFont'>$zl - $TYTED</font> 
<table WIDTH=700 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >";
	
$db = new CMySQL;
if (!$db->Open()) $db->Kill();
 if(isset($idzl)){
 $q = "SELECT zl_zlec.lp, zl_zlec.nr_zam_pl, zl_zlec.nr_zam_o, zl_zlec.nr_poz, zl_zlec.nr_kom, zl_zlec.obj, zl_zlec.nazwa, zl_zlec.w_z_e, zl_zlec.kurs, zl_zlec.w_z_p, zl_zlec.tn_zam, zl_zlec.uwagi, zl_zlec.data_wp, zl_zlec.id_wpr, zl_zlec.data_popr, zl_zlec.id_popr, zl_zlec.data, zl_zlec.pspelem, zl_zlec.teileno, zl_zlec.id_zam, zl_zlec.data_zam, zl_zlec.id_otw, zl_zlec.data_otw, zl_zlec.zakt, zl_zlec.dostMD, zl_zlec.konserwacja, zl_zlec.TP, zl_zlec.ktermin, zl_zlec.kpartner, zl_zlec.kdata, hd_users.nazwa AS USR FROM zl_zlec INNER JOIN hd_users ON zl_zlec.id_wpr = hd_users.lp WHERE zl_zlec.lp='$idzl' LIMIT 1 ";

  } else { 
  echo "<BR><BR><CENTER><H1>Cos siê zepsu³o!</H1></CENTER><BR><BR>";
  exit;
 }
if (!$db->Query($q)) $db->Kill();
$row=$db->Row();
  
    if (!$db->Open()) $db->Kill();
  $popr = "SELECT hd_users.nazwa FROM hd_users WHERE hd_users.lp='$row->id_popr' LIMIT 1 ";
  if (!$db->Query($popr)) $db->Kill();
  $popr=$db->Row();

echo "	
    <tr>
     <td class='FieldCaptionTD'>$ZLNRZAMPL</td> 
     <td class='DataTD' colspan='3'><input class='Input' maxlength='11' name='_nr_zam_pl' size='11' value='$row->nr_zam_pl'></td>
    </td>
   </tr>

    <tr>
      <td class='FieldCaptionTD'>$ZLNRZAMDE</td> 
      <td class='DataTD'><input class='Input' maxlength='15' name='_nr_zam_o' size='15' value='$row->nr_zam_o'></td> 
    </tr>
 
    <tr>
      <td class='FieldCaptionTD'>$ZLNRPOZ</td> 
      <td class='DataTD'><input class='Input' maxlength='100' name='_nr_poz' size='11' value='$row->nr_poz'></td> 
    </tr>
 
    <tr>
      <td class='FieldCaptionTD'>$ZLNRK</td> 
      <td class='DataTD'><input class='Input' maxlength='50' name='_nr_kom' size='50' value='$row->nr_kom'></td> 
    </tr>
    <tr>
      <td class='FieldCaptionTD'>$ZLOBJ</td> 
      <td class='DataTD'><input class='Input' maxlength='70' name='_obj' size='70' value='$row->obj'></td> 
    </tr>
	<tr>
      <td class='FieldCaptionTD'>$ZLNAZWA</td> 
      <td class='DataTD'><input class='Input' maxlength='70' name='_nazwa' size='70' value='$row->nazwa'></td> 
    </tr>
    <tr>
      <td class='FieldCaptionTD'>$ZLWE</td> 
      <td class='DataTD'><input class='Input' onChange=\"this.form._w_z_p.value=this.form._w_z_e.value*this.form._kurs.value\" maxlength='13' name='_w_z_e' size='13' value='$row->w_z_e'>&nbsp;&euro;</td> 
    </tr>
    <tr>
      <td class='FieldCaptionTD'>$ZLK</td> 
      <td class='DataTD'><input class='Input' onChange=\"this.form._w_z_p.value=this.form._w_z_e.value*this.form._kurs.value\" maxlength='13' name='_kurs' size='13' value='$row->kurs'>&nbsp;PLN</td> 
    </tr>
    <tr>
      <td class='FieldCaptionTD'>$ZLWZ</td> 
      <td class='DataTD'><input class='Input' maxlength='13' name='_w_z_p' size='13' value='$row->w_z_p'>&nbsp;PLN </td> 
    </tr>
    <tr>
      <td class='FieldCaptionTD'>$ZLTNZ</td> 
      <td class='DataTD'><input class='Input' maxlength='13' name='_tn_zam' size='13' value='$row->tn_zam'>&nbsp;KG</td> 
    </tr>
	<!--  2005-06-14 -->
	<tr>
     <td class='FieldCaptionTD'>$ZLPSP:</td>
     <td class='DataTD'><input class='Input' maxlength='24' name='_pspelem' size='24' value='$row->pspelem'>(22char)</td>
     </tr><tr>
	 <td class='FieldCaptionTD'>$ZLTEILENO:</td>
     <td class='DataTD'><input class='Input' maxlength='8' name='_teileno' size='8' value='$row->teileno'>(8 int)</td>
     </tr><tr>
	 <td class='FieldCaptionTD'>$ZLDOSTMD:</td>
     <td class='DataTD'><input class='Input' maxlength='50' name='_dostMD' size='50' value='$row->dostMD'>(50char)</td>
     </tr>
	<tr>
     <td class='FieldCaptionTD'>$ZLKONS:</td>
     <td class='DataTD'><input class='Input' maxlength='50' name='_konserwacja' size='50' value='$row->konserwacja'>(50char)</td>
     </tr><tr>
	 <td class='FieldCaptionTD'>$ZLTP1:</td>
     <td class='DataTD'><input class='Input' maxlength='40' name='_TP' size='40' value='$row->TP'>(40char)</td>
     </tr><tr>
     <td class='FieldCaptionTD'>$ZLKTERM:</td>
     <td class='DataTD'><input class='Input' maxlength='10' name='_ktermin' size='10' value='$row->ktermin'>(Date)</td>
     </tr><tr>
	 <td class='FieldCaptionTD'>$ZLKPARTNER:</td>
     <td class='DataTD'><input class='Input' maxlength='50' name='_kpartner' size='50' value='$row->kpartner'>(50char)</td>
     </tr><tr>
     <td class='FieldCaptionTD'>$ZLKDATAOD:</td>
     <td class='DataTD'><input class='Input' maxlength='10' name='_kdata' size='10' value='$row->kdata'>(Date)</td>
     </tr>





    <tr>
      <td class='FieldCaptionTD'>$ZLUWAGI</td> 
      <td class='DataTD'><input class='Input' maxlength='150' name='_uwagi' size='70' value='$row->uwagi'></td> 
    </tr>
    <tr>
      <td class='FieldCaptionTD'>$RPNDATE</td> 
      <td class='DataTD'><input class='Input' maxlength='12' name='_data' size='12' value='$row->data'>&nbsp;(YYYY-MM-DD)</td> 
    </tr>
		    <tr>
      <td class='FieldCaptionTD'>$INS</td> 
      <td class='DataTD'>$row->USR - $row->data_wp<BR><B>$TYTED:</B> $popr->nazwa - $row->data_popr</td> 
    </tr>

 ";

echo "
    <tr>
      <td align='right' colspan='2'>
			<input name='state' type='hidden' value='1'>
			<input name='idzl' type='hidden' value='$row->lp'>
			<input class='Button' name='Nowy' type='submit' value='$SAVEBTN'>
			<input class='Button' name='Cancel' type='Button' value='$EXITBTN'>
			<input class='Button'  type='Button' onclick='javascript:history.back()' value='$BACKBTN'>
	</td> 
    </tr>
 
  </table>
</form>

</center>
<BR>
</td></tr>
</table>";
include_once("./footer.php");
}
elseif($state==1)
{
//if(isset($Nowy) and $Nowy=='$SAVEBTN')
//    {  

	if (!$db->Open())$db->Kill();
    $query =("UPDATE zl_zlec SET nr_zam_pl='$_nr_zam_pl', nr_zam_o='$_nr_zam_o', nr_poz='$_nr_poz', nr_kom='$_nr_kom', obj='$_obj', nazwa='$_nazwa', w_z_e='$_w_z_e', kurs='$_kurs', w_z_p='$_w_z_p', tn_zam='$_tn_zam', uwagi='$_uwagi', data='$_data', data_popr='$dzis $godz:00', id_popr='$id', pspelem='$_pspelem', teileno='$_teileno', dostMD='$_dostMD', konserwacja='$_konserwacja', TP='$_TP', ktermin='$_ktermin', kpartner='$_kpartner', kdata='$_kdata' WHERE lp=$idzl LIMIT 1");

    $result = mysql_query($query);
	//echo $query;
    echo "<script language='javascript'>window.location=\"zl_ed_zl.php?idzl=$idzl\"</script>";
//	}
} 
?>