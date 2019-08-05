<?php
//if(!isset($id) && !isset($pw))
//{header("Location: index.html");exit;}

include_once("./header.php");
include("./languages/$LANGUAGE.php");
include_once("./inc/mlfn.inc.php");
$nP="$PHP_SELF";
$numrows=15;

if(!isset($state))
{
	echo "	<TD ALIGN=JUSTIFY VALIGN=TOP border=0>
	<table width='100%' border=0><TR BGCOLOR='$kolorTlaRamki'>
		</tr></table><table width='100%' border=0><tr><td>

<center>
<form action='$PHP_SELF' method='post' name='zl_new'>
  <font class='FormHeaderFont'>$DELBTN</font> 
<table WIDTH=700 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >";
	
$db = new CMySQL;
if (!$db->Open()) $db->Kill();
 if(isset($idzl)){
 $q = "SELECT zl_zlec.lp, zl_zlec.nr_zam_pl, zl_zlec.nr_zam_o, zl_zlec.nr_poz, zl_zlec.nr_kom, zl_zlec.obj, zl_zlec.nazwa, zl_zlec.w_z_e, zl_zlec.kurs, zl_zlec.w_z_p, zl_zlec.tn_zam, zl_zlec.uwagi, zl_zlec.data_wp, zl_zlec.id_wpr, zl_zlec.data_popr, zl_zlec.id_popr, zl_zlec.data, hd_users.nazwa AS USR FROM zl_zlec INNER JOIN hd_users ON zl_zlec.id_wpr = hd_users.lp WHERE zl_zlec.lp='$idzl' LIMIT 1 ";

  } else { 
  echo "<BR><BR><CENTER><H1>Cos siê zepsu³o!</H1></CENTER><BR><BR>";
  exit;
 }
if (!$db->Query($q)) $db->Kill();
$row=$db->Row();
  
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
    <tr>
      <td class='FieldCaptionTD'>$ZLUWAGI</td> 
      <td class='DataTD'><input class='Input' maxlength='150' name='_uwagi' size='70' value='$row->uwagi'></td> 
    </tr>
    <tr>
      <td class='FieldCaptionTD'>$RPNDATE</td> 
      <td class='DataTD'><input class='Input' maxlength='12' name='_data' size='12' value='$row->data'>&nbsp;(YYYY-MM-DD)</td> 
    </tr>

 ";

echo "
    <tr>
      <td align='right' colspan='2'>
			<input name='state' type='hidden' value='1'>
			<input name='idzl' type='hidden' value='$row->lp'>
			<input class='Button' name='Nowy' onclick=\"return confirm('$zlkomkas')\"  type='submit' value='$DELBTN'>
			<input class='Button' name='Cancel' type='Button' onclick='javascript:history.back()' value='$EXITBTN'>
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
	if (!$db->Open())$db->Kill();
    $query =("INSERT INTO hd_log ( `lp` , `tabela` , `temat` , `kiedy` , `user_id`, `infodod` ) 
				VALUES ('', 'ORDER_all', '$_nr_zam_pl - $_nr_zam_o - $_nr_poz', '$dzis $godz:00', '$id','KOM:$_nr_kom, $_obj, $_nazwa ')");
    $result = mysql_query($query);
	
	$dzbyt="DELETE FROM zl_zbyt WHERE id_zlec = $idzl";
	    $result1 = mysql_query($dzbyt);

	$dzzaop="DELETE FROM zl_zaop WHERE id_zlec = $idzl";
    $result2 = mysql_query($dzzaop);
	$dtech="DELETE FROM zl_tech WHERE id_zlec = $idzl";
    $result3 = mysql_query($dtech);
	$dzlec="DELETE FROM zl_zlec WHERE lp = $idzl";
    $result4 = mysql_query($dzlec);

	echo "<script language='javascript'>window.location=\"zl_lista.php\"</script>";
} 
?>