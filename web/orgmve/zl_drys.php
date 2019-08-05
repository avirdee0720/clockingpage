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
  <font class='FormHeaderFont'>$DELBTN: $ZLRYS</font> 
<table WIDTH=700 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >";
	
$db = new CMySQL;
if (!$db->Open()) $db->Kill();
 if(isset($lp)){
 $q = "SELECT  hd_imgcad.photo_id, hd_imgcad.id_zlec, hd_imgcad.photo_alttext, hd_imgcad.zeichnungsnr, hd_imgcad.photo_src, hd_imgcad.photo_desc, hd_imgcad.photo_endesc, hd_imgcad.photo_filename, hd_imgcad.photo_filesize, hd_imgcad.photo_filetype, hd_imgcad.photo_path, hd_imgcad.photo_format, hd_imgcad.photo_link, hd_imgcad.data_wp, hd_imgcad.id_wpr, hd_imgcad.data_popr, hd_imgcad.id_popr, hd_imgcad.data, hd_users.nazwa AS USR FROM hd_imgcad INNER JOIN hd_users ON hd_imgcad.id_wpr = hd_users.lp WHERE hd_imgcad.photo_id='$lp' LIMIT 1 ";

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
   <TR>
   <TD class='FieldCaptionTD'>$ZLZNR</TD>
   <TD class='DataTD'>$row->zeichnungsnr</TD>
  </TR>
  <TR>
   <TD class='FieldCaptionTD'>$ZLPD</TD>
   <TD class='DataTD'>$row->photo_desc</TD>
  </TR>
  <TR>
   <TD class='FieldCaptionTD'>$ZLPEND</TD>
   <TD class='DataTD'>$row->photo_endesc</TD>
  </TR>
  <TR>
   <TD class='FieldCaptionTD'>$ZLPS</TD>
   <TD class='DataTD'>$row->photo_path</TD>
  </TR>
	<tr>
      <td class='FieldCaptionTD'>$ZLPF</td> 
      <td class='DataTD'>$row->photo_format</td> 
    </tr>

	<tr>
      <td class='FieldCaptionTD'>&nbsp;</td> 
      <td class='DataTD'>$row->data</td> 
    </tr>

    <tr>
      <td class='FieldCaptionTD'>$INS</td> 
      <td class='DataTD'>$row->USR - $row->data_wp<BR><B>$TYTED:</B> $popr->nazwa - $row->data_popr</td> 
    </tr>

    <tr>
      <td class='FieldCaptionTD'>$ZLUWAGI / $ZLPAT</td> 
      <td class='DataTD'>$row->photo_alttext</td> 
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
/*	if (!$db->Open())$db->Kill();
    $query =("INSERT INTO hd_log ( `lp` , `tabela` , `temat` , `kiedy` , `user_id`, `infodod` ) 
				VALUES ('', 'zl_zaop', 'IDZL: $idzl', '$dzis $godz:00', '$id','$_MB_HARDOX, $_tn_zam_z - $_uwagi ')");

    $result = mysql_query($query);

	$dzzaop="DELETE FROM zl_zaop WHERE lp = $lp";
    $result2 = mysql_query($dzzaop);

    echo "<script language='javascript'>window.location=\"zl_1.php?idzl=$idzl\"</script>";
*/
} 

?>