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
  <font class='FormHeaderFont'>$TYTED: $ZLTYTZBYT</font> 
<table WIDTH=700 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >";
	
$db = new CMySQL;
if (!$db->Open()) $db->Kill();
 if(isset($lp)){
 $q = "SELECT zl_zbyt.lp, zl_zbyt.id_zlec, zl_zbyt.wart_sprz, zl_zbyt.godziny, zl_zbyt.r_m_j, zl_zbyt.r_c_j, zl_zbyt.uwagi, zl_zbyt.data_wp, zl_zbyt.id_wpr,zl_zbyt.data_popr, zl_zbyt.id_popr, zl_zbyt.data, hd_users.nazwa AS USR FROM zl_zbyt INNER JOIN hd_users ON zl_zbyt.id_wpr = hd_users.lp WHERE zl_zbyt.lp='$lp' LIMIT 1 ";

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
      <td class='FieldCaptionTD'>$ZLZWS</td> 
      <td class='DataTD'><input class='Input' maxlength='11' name='_wart_sprz' size='11' value='$row->wart_sprz'>&nbsp;PLN</td> 
    </tr>
 
    <tr>
      <td class='FieldCaptionTD'>$ZLZGODZ</td> 
      <td class='DataTD'><input class='Input' maxlength='11' name='_godziny' size='11' value='$row->godziny'>&nbsp;H</td> 
    </tr>
	<tr>
      <td class='FieldCaptionTD'>$ZLZRNJ</td> 
      <td class='DataTD'><input class='Input' maxlength='11' name='_r_m_j' size='11' value='$row->r_m_j'>&nbsp;H/T</td> 
    </tr>
   </tr>
    <tr>
      <td class='FieldCaptionTD'>$ZLZRCJ</td> 
      <td class='DataTD'><input class='Input' maxlength='11' name='_r_c_j' size='11' value='$row->r_c_j'>&nbsp;&euro;/KG</td> 
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
      <td class='FieldCaptionTD'>$ZLUWAGI</td> 
      <td class='DataTD'><textarea class='Textarea' cols='50' name='_uwagi' rows='3'>$row->uwagi</textarea></td> 
    </tr>
 ";

echo "
    <tr>
      <td align='right' colspan='2'>
			<input name='state' type='hidden' value='1'>
			<input name='_id_zlec' type='hidden' value='$idzl'>
			<input name='lp' type='hidden' value='$row->lp'>
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
    $query =("UPDATE zl_zbyt SET wart_sprz='$_wart_sprz', godziny='$_godziny', r_m_j='$_r_m_j', r_c_j='$_r_c_j', uwagi='$_uwagi', data_popr='$dzis $godz:00', id_popr='$id', data='$_data', '$dzis $godz:00' WHERE lp='$lp' LIMIT 1");
    $result = mysql_query($query);
    echo "<script language='javascript'>window.location=\"zl_1zbyt.php?idzl=$_id_zlec\"</script>";
//	}
} 
?>