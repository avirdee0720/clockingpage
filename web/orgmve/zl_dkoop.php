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
<form action='$PHP_SELF' method='get' name='zl_new'>
  <font class='FormHeaderFont'>$TYTED: $ZLTYTKOOP</font> 
<table WIDTH=700 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >";

$db = new CMySQL;
if (!$db->Open()) $db->Kill();
 if(isset($lp)){
 $q = "SELECT zl_koop.lp, zl_koop.id_zlec, zl_koop.kooperant, zl_koop.obr_mech, zl_koop.cynkowanie, zl_koop.arbosol, zl_koop.gumowanie, zl_koop.innepow, zl_koop.trawienie, zl_koop.konstrukcja, zl_koop.uwagi, zl_koop.data_wp, zl_koop.id_wpr, zl_koop.data_popr, zl_koop.id_popr, zl_koop.datas, zl_koop.datak, zl_koop.czygb, zl_koop.grpbud, zl_koop.lastuse, hd_users.nazwa AS USR FROM zl_koop INNER JOIN hd_users ON zl_koop.id_wpr = hd_users.lp WHERE zl_koop.lp='$lp' LIMIT 1 ";

  } else { 
  echo "<BR><BR><CENTER><H1>Cos siê zepsu³o!</H1></CENTER><BR><BR>";
  exit;
 }
if (!$db->Query($q)) $db->Kill();
$row=$db->Row();

if (!$db->Open()) $db->Kill();
 if(isset($lp)){
 $popr = "SELECT hd_users.nazwa FROM hd_users WHERE hd_users.lp='$row->id_popr' LIMIT 1 ";

  } else { 
  echo "<BR><BR><CENTER><H1>Cos siê zepsu³o! 2</H1></CENTER><BR><BR>";
  exit;
 }
if (!$db->Query($popr)) $db->Kill();
$popr=$db->Row();

echo "	
    <tr>
      <td class='FieldCaptionTD'>$ZLKPARTNER</td> 
      <td class='DataTD'><input class='Input' maxlength='100' name='_obr_mech' size='70' value='$row->kooperant'> </td> 
    </tr>
    <tr>
      <td class='FieldCaptionTD'>$ZLTOM</td> 
      <td class='DataTD'><input class='Input' maxlength='11' name='_obr_mech' size='11' value='$row->obr_mech'>&nbsp;PLN</td> 
    </tr>
    <tr>
      <td class='FieldCaptionTD'>$ZLKOOP1</td> 
      <td class='DataTD'><input class='Input' maxlength='11' name='_cynkowanie' size='11' value='$row->cynkowanie'>&nbsp;PLN</td> 
    </tr>
    <tr>
      <td class='FieldCaptionTD'>$ZLKOOP2</td> 
      <td class='DataTD'><input class='Input' maxlength='11' name='_arbosol' size='11' value='$row->arbosol'>&nbsp;PLN</td> 
    </tr>		
    <tr>
      <td class='FieldCaptionTD'>$ZLKOOP3</td> 
      <td class='DataTD'><input class='Input' maxlength='11' name='_gumowanie' size='11' value='$row->gumowanie'>&nbsp;PLN</td> 
    </tr>	
    <tr>
      <td class='FieldCaptionTD'>$ZLKOOP4</td> 
      <td class='DataTD'><input class='Input' maxlength='11' name='_innepow' size='11' value='$row->innepow'>&nbsp;PLN</td> 
    </tr>
    <tr>
      <td class='FieldCaptionTD'>$ZLKOOP5</td> 
      <td class='DataTD'><input class='Input' maxlength='11' name='_trawienie' size='11' value='$row->trawienie'>&nbsp;PLN</td> 
    </tr>
    <tr>
      <td class='FieldCaptionTD'>$ZLKOOP6</td> 
      <td class='DataTD'><input class='Input' maxlength='11' name='_konstrukcja' size='11' value='$row->konstrukcja'>&nbsp;PLN</td> 
    </tr>
	<tr>
      <td class='FieldCaptionTD'>$ZLGRPBUD</td> 
      <td class='DataTD'><input class='Input' maxlength='11' name='_grpbud' size='11' value='$row->grpbud'>&nbsp;</td> 
    </tr>
		    <tr>
      <td class='FieldCaptionTD'>$ZLCZYPO</td> 
      <td class='DataTD'><input class='Input' maxlength='11' name='_czygb' size='11' value='$row->czygb'>&nbsp;PLN</td> 
    </tr>
	<tr>
      <td class='FieldCaptionTD'>$INS</td> 
      <td class='DataTD'>$row->USR - $row->data_wp<BR><B>$TYTED:</B> $popr->nazwa - $row->data_popr</td> 
    </tr>
    <tr>
      <td class='FieldCaptionTD'>$ZLKDATAOD</td> 
      <td class='DataTD'><input class='Input' maxlength='11' name='_datas' size='11' value='$row->datas'></td> 
    </tr>
    <tr>
      <td class='FieldCaptionTD'>$ZLKDATADO</td> 
      <td class='DataTD'><input class='Input' maxlength='11' name='_datak' size='11' value='$row->datak'></td> 
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
	if (!$db->Open())$db->Kill();
    $query =("INSERT INTO hd_log ( `lp` , `tabela` , `temat` , `kiedy` , `user_id`, `infodod` ) 
				VALUES ('', 'zl_koop', 'IDZL: $idzl', '$dzis $godz:00', '$id','$_obr_mech, $_uwagi ')");

    $result = mysql_query($query);

	$dtech="DELETE FROM zl_koop WHERE lp = $lp";
    $result3 = mysql_query($dtech);

    echo "<script language='javascript'>window.location=\"zl_1koop.php?idzl=$_id_zlec\"</script>";
} 
?>