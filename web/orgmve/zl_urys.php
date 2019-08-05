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
  <font class='FormHeaderFont'>$TYTED: $ZLRYS</font> 
<table WIDTH=700 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >";
	
$db = new CMySQL;
if (!$db->Open()) $db->Kill();
 if(isset($lp)){
 $q = "SELECT  hd_imgcad.photo_id, hd_imgcad.id_zlec, hd_imgcad.photo_alttext, hd_imgcad.zeichnungsnr, hd_imgcad.photo_src, hd_imgcad.photo_desc, hd_imgcad.photo_endesc, hd_imgcad.photo_filename, hd_imgcad.photo_filesize, hd_imgcad.photo_filetype, hd_imgcad.photo_path, hd_imgcad.photo_format, hd_imgcad.photo_link, hd_imgcad.data_wp, hd_imgcad.id_wpr, hd_imgcad.data_popr, hd_imgcad.id_popr, hd_imgcad.data, hd_users.nazwa AS USR FROM hd_imgcad INNER JOIN hd_users ON hd_imgcad.id_wpr = hd_users.lp WHERE hd_imgcad.photo_id='$lp' LIMIT 1 ";

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

  <TR>
   <TD class='FieldCaptionTD'>$ZLZNR</TD>
   <TD class='DataTD'><input class='Input' maxlength='11' name='_zeichnungsnr'  value='$row->zeichnungsnr'></TD>
  </TR>
  <TR>
   <TD class='FieldCaptionTD'>$ZLPD</TD>
   <TD class='DataTD'><TEXTAREA NAME='_photo_desc' ROWS='2' COLS='50'>$row->photo_desc</TEXTAREA></TD>
  </TR>
  <TR>
   <TD class='FieldCaptionTD'>$ZLPEND</TD>
   <TD class='DataTD'><TEXTAREA NAME='_photo_endesc' ROWS='2' COLS='50'>$row->photo_endesc</TEXTAREA></TD>
  </TR>
  <TR>
   <TD class='FieldCaptionTD'>$ZLPS</TD>
   <TD class='DataTD'>$row->photo_path<INPUT TYPE='file' NAME='_photo_path' size='20' value='Przegl±daj...'></TD>
  </TR>
	<tr>
      <td class='FieldCaptionTD'>$ZLPF</td> 
      <td class='DataTD'><input class='Input' maxlength='11' name='_photo_format' size='11' value='$row->photo_format'></td> 
    </tr>

	<tr>
      <td class='FieldCaptionTD'>&nbsp;</td> 
      <td class='DataTD'><input class='Input' maxlength='11' name='_data' size='11' value='$row->data'></td> 
    </tr>

    <tr>
      <td class='FieldCaptionTD'>$INS</td> 
      <td class='DataTD'>$row->USR - $row->data_wp<BR><B>$TYTED:</B> $popr->nazwa - $row->data_popr</td> 
    </tr>

    <tr>
      <td class='FieldCaptionTD'>$ZLUWAGI / $ZLPAT</td> 
      <td class='DataTD'><textarea class='Textarea' cols='50' name='_uwagi' rows='3'>$row->photo_alttext</textarea></td> 
    </tr>
 ";

echo "
    <tr>
      <td align='right' colspan='2'>
			<input name='state' type='hidden' value='1'>
			<input name='_id_zlec' type='hidden' value='$idzl'>
			<input name='lp' type='hidden' value='$row->photo_id'>

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
    $query =("UPDATE  mat_pom='$_mat_pom', tn_zam_z='$_tn_zam_z', uwagi='$_uwagi', data_popr='$dzis $godz:00', id_popr='$id', data='$_data', lastuse='$dzis $godz:00' WHERE lp='$lp' LIMIT 1");

    $result = mysql_query($query);
	//echo $query;
    echo "<script language='javascript'>window.location=\"zl_1zaop.php?idzl=$_id_zlec\"</script>";
//	}
} 

?>