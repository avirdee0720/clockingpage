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
  <font class='FormHeaderFont'>$DELBTN: $ZLTYTZAO</font> 
<table WIDTH=700 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >";
	
$db = new CMySQL;
if (!$db->Open()) $db->Kill();
 if(isset($lp)){
 $q = "SELECT zl_zaop.lp, zl_zaop.id_zlec, zl_zaop.MB_mat_c, zl_zaop.MB_mat_KO, zl_zaop.MB_HARDOX, zl_zaop.mat_pom, zl_zaop.farby,  zl_zaop.matzl,  zl_zaop.inne, zl_zaop.tn_zam_z, zl_zaop.uwagi, zl_zaop.data_wp, zl_zaop.id_wpr, zl_zaop.data_popr, zl_zaop.id_popr, zl_zaop.data, hd_users.nazwa AS USR FROM zl_zaop INNER JOIN hd_users ON zl_zaop.id_wpr = hd_users.lp WHERE zl_zaop.lp='$lp' LIMIT 1 ";

  } else { 
  echo "<BR><BR><CENTER><H1>SQL Error!</H1></CENTER><BR><BR>";
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
     <td class='FieldCaptionTD'>$ZLMC</td> 
     <td class='DataTD' colspan='3'><input class='Input' maxlength='11' name='_MB_mat_c' size='11' value='$row->MB_mat_c'>&nbsp;PLN</td>
    </td>

    <tr>
      <td class='FieldCaptionTD'>$ZLMKO</td> 
      <td class='DataTD'><input class='Input' maxlength='11' name='_MB_mat_KO' size='11' value='$row->MB_mat_KO'>&nbsp;PLN</td> 
    </tr>
	<tr>
      <td class='FieldCaptionTD'>$ZLFARBY</td> 
      <td class='DataTD'><input class='Input' maxlength='11' name='_farby' size='11' value='$row->farby'>&nbsp;PLN</td> 
    </tr>
	<tr>
      <td class='FieldCaptionTD'>$ZLMZL1</td> 
      <td class='DataTD'><input class='Input' maxlength='11' name='_matzl' size='11' value='$row->matzl'>&nbsp;PLN</td> 
    </tr>
	<tr>
      <td class='FieldCaptionTD'>$ZLINNE</td> 
      <td class='DataTD'><input class='Input' maxlength='11' name='_inne' size='11' value='$row->inne'>&nbsp;PLN</td> 
    </tr>

    <tr>
      <td class='FieldCaptionTD'>$ZLMHARDOX</td> 
      <td class='DataTD'><input class='Input' maxlength='11' name='_MB_HARDOX' size='11' value='$row->MB_HARDOX'>&nbsp;PLN</td> 
    </tr>
	<tr>
      <td class='FieldCaptionTD'>$ZLTNZ</td> 
      <td class='DataTD'><input class='Input' maxlength='11' name='_tn_zam_z' size='11' value='$row->tn_zam_z'>&nbsp;KG</td> 
    </tr>
    <tr>
      <td class='FieldCaptionTD'>$INS</td> 
      <td class='DataTD'>$row->USR - $row->data_wp<BR><B>$TYTED:</B> $popr->nazwa - $row->data_popr</td> 
    </tr>
       <tr>
      <td class='FieldCaptionTD'>&nbsp;</td> 
      <td class='DataTD'><input class='Input' maxlength='11' name='_data' size='11' value='$row->data'></td> 
    </tr>
    <tr>
      <td class='FieldCaptionTD'>$ZLUWAGI</td> 
      <td class='DataTD'><textarea class='Textarea' cols='50' name='_uwagi' rows='3'>$row->uwagi</textarea></td> 
    </tr>
 ";

echo "
    <tr>
      <td align='right' colspan='2'>
			<input name='state' type='hidden' value='1'>
			<input name='idzl' type='hidden' value='$idzl'>
			<input name='lp' type='hidden' value='$row->lp'>

			<input class='Button' name='kasuj' onclick=\"return confirm('$$zlkomkas')\"  type='submit' value='$DELBTN'>
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
	if (!$db->Open())$db->Kill();
    $query =("INSERT INTO hd_log ( `lp` , `tabela` , `temat` , `kiedy` , `user_id`, `infodod` ) 
				VALUES ('', 'zl_zaop', 'IDZL: $idzl', '$dzis $godz:00', '$id','$_MB_HARDOX, $_tn_zam_z - $_uwagi ')");

    $result = mysql_query($query);

	$dzzaop="DELETE FROM zl_zaop WHERE lp = $lp";
    $result2 = mysql_query($dzzaop);

    echo "<script language='javascript'>window.location=\"zl_1zaop.php?idzl=$idzl\"</script>";
} 

?>