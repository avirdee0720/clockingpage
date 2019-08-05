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
<FORM METHOD='post' ACTION='$PHP_SELF' ENCTYPE='multipart/form-data'>
  <font class='FormHeaderFont'>$ADDNEWBTN: $ZLRYS</font> 
<table WIDTH=700 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >";
	
//$db = new CMySQL;
//if (!$db->Open()) $db->Kill();
  
echo "	
  <TR>
   <TD class='FieldCaptionTD'>$ZLZNR</TD>
   <TD class='DataTD'><input class='Input' maxlength='11' name='_zeichnungsnr'  value=''></TD>
  </TR>
  <TR>
   <TD class='FieldCaptionTD'>$ZLPD</TD>
   <TD class='DataTD'><TEXTAREA NAME='_photo_desc' ROWS='2' COLS='50'></TEXTAREA></TD>
  </TR>
  <TR>
   <TD class='FieldCaptionTD'>$ZLPEND</TD>
   <TD class='DataTD'><TEXTAREA NAME='_photo_endesc' ROWS='2' COLS='50'></TEXTAREA></TD>
  </TR>
  <TR>
   <TD class='FieldCaptionTD'>$ZLPS</TD>
   <TD class='DataTD'><INPUT TYPE='file' NAME='_photo_path' size='50' value='Przegl±daj...'></TD>
  </TR>
	<tr>
      <td class='FieldCaptionTD'>$ZLPF</td> 
      <td class='DataTD'><input class='Input' maxlength='11' name='_photo_format' size='11' value='A'></td> 
    </tr>

	<tr>
      <td class='FieldCaptionTD'>&nbsp;</td> 
      <td class='DataTD'><input class='Input' maxlength='11' name='_data' size='11' value='$dzis'></td> 
    </tr>

    <tr>
      <td class='FieldCaptionTD'>$ZLUWAGI / $ZLPAT</td> 
      <td class='DataTD'><textarea class='Textarea' cols='50' name='_photo_alttext' rows='3'></textarea></td> 
    </tr>
 ";

echo "
    <tr>
      <td align='right' colspan='2'>
			<input name='state' type='hidden' value='1'>
			<input name='_id_zlec' type='hidden' value='$idzl'>
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
 
    $rozmiar=filesize($_photo_path);
//    $data = addslashes(fread(fopen($_photo_path, 'r'), filesize($_photo_path)));
	$sciezka=$_photo_path;

	if (!$db->Open())$db->Kill();
    $query =("INSERT INTO  hd_imgcad ( photo_id, id_zlec, photo_alttext, zeichnungsnr, photo_src, photo_desc, photo_endesc, photo_filename, photo_filesize, photo_filetype, photo_path, photo_format, photo_link, id_zest, data_wp, id_wpr, data) VALUES (NULL, '$_id_zlec', '$_photo_alttext', '$_zeichnungsnr', '$_photo_src', '$_photo_desc', '$_photo_endesc', '$_photo_filename', '$rozmiar', '$_photo_filetype', '$sciezka', '$_photo_format', '$_photo_link', '$_id_zest', '$dzis $godz:00', '$id', '$_data')");

    $result = mysql_query($query);
echo "<script language='javascript'>window.location=\"zl_1zaop.php?idzl=$_id_zlec\"</script>";
} 

?>