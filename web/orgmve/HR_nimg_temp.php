<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$tytul='Photo of ';
$cln=$_GET['cln'];
$dataPhoto=date("d/m/Y");
if(isset($submitted) and $src!=="") {

$data = addslashes(fread(fopen($src, 'r'), filesize($src)));
$opis = addslashes(nl2br($des));
//if($alt=="") $alt=$opis;

$del = "DELETE FROM `staffphotos` WHERE  `no`=$lp LIMIT 1";
if (!$db->Open()) $db->Kill();
if (!$db->Query($del)) $db->Kill();
$db->Free();
$del = "OPTIMIZE TABLE `staffphotos` ";
if (!$db->Open()) $db->Kill();
if (!$db->Query($del)) $db->Kill();
$db->Free();
$sql = "INSERT INTO `staffphotos` (`photo_id`, `no` , `photo_alttext`, `photo_src`, `photo_desc`, `photo_filename`, `photo_filesize`, `photo_filetype`)VALUES(NULL, '$lp', '$alt', '$data', '$opis', '$src_name', '$src_size', '$src_type')";

if (!$db->Open()) $db->Kill();
if (!$db->Query($sql)) $db->Kill(); 
            
echo "<script language='javascript'>window.location=\"hr_data.php?cln=$lp\"</script>";
exit;
}


echo "	<TD ALIGN=JUSTIFY VALIGN=TOP border=0>
	<table width='100%' border=0><TR BGCOLOR='$kolorTlaRamki'><TH><p align=left>
    <FONT COLOR='$kolorTekstu'>&nbsp;&nbsp;$tytul</FONT>
	</TH></tr></table><table width='100%' border=0><tr><td>

<center>
<FORM METHOD='post' ACTION='$PHP_SELF' ENCTYPE='multipart/form-data'>
 <INPUT TYPE='hidden' NAME='MAX_FILE_SIZE' VALUE='2000000'>
 <TABLE BORDER='0' cellspacing='0' cellpadding='0'>
  <TR>
   <TD class='FieldCaptionTD'>ALT Text: </TD>
   <TD class='DataTD'><TEXTAREA NAME='alt' ROWS='1' COLS='50'>$dataPhoto</TEXTAREA></TD>
  </TR>
  <TR>
   <TD class='FieldCaptionTD'>Description: </TD>
   <TD class='DataTD'><TEXTAREA NAME='des' ROWS='2' COLS='50'>$dataPhoto</TEXTAREA></TD>
  </TR>
  <TR>
   <TD class='FieldCaptionTD'>Photo: </TD>
   <TD class='DataTD'><INPUT TYPE='file' NAME='src' value='Browse...'></TD>
  </TR>
  <TR>
   <TD class='FieldCaptionTD' COLSPAN='2'><input class='Button'  type='Button' onclick='javascript:history.back()' value='Back'>
                   <INPUT TYPE='submit' VALUE='Save'>
	</TD>
  </TR>
 </TABLE>
 <input type=hidden name=submitted value=1>
 <input type=hidden name='lp' value=$cln>
</FORM>
<table>

";
$sql = "SELECT `photo_id`, `no`, `photo_alttext`, `photo_desc`, `photo_filename`, `photo_filesize`, `photo_filetype` FROM `staffphotos` WHERE `no`=$cln";
if (!$db->Open()) $db->Kill();

          if ($db->Query($sql)) 
            {
				 while ($r=$db->Row())
			{
				echo "
				<FORM METHOD='post' ACTION='$PHP_SELF' ENCTYPE='multipart/form-data'>
				<TR><TD class='DataTD'>
				<B>ALT:</B> $r->photo_alttext<BR> 
				
				<B>Desc: </B>$r->photo_desc<BR>
				<B>Name: </B>$r->photo_filename, <B>size:</B> $r->photo_filesize, <B>type:</B> $r->photo_filetype <BR>
					</TD><TD>
				<img src='image1.php?cln=$cln' border='0' width='150' >
					<BR>
				<INPUT type='hidden' name='photo_id' value='$r->photo_id'>
				<INPUT type='hidden' name='artykul_id' value='$r->artykul_id'>

				
				</TD></TR>
				
				</FORM>";

				}
			} else {
			echo " 
			  <tr>
			   <td class='DataTD'></td>
			    <td class='DataTD' colspan='3'>Brak Zdjec</td>
			  </tr>";
			 $db->Kill();
			}
echo "</TABLE>
<BR>
</td></tr>
</table>
</center>
";
include_once('./footer.php');
?>