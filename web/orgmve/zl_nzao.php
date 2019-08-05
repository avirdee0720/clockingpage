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
  <font class='FormHeaderFont'>$ADDNEWBTN: $ZLTYTZAO</font> 
<table WIDTH=700 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >";
	
$db = new CMySQL;
//if (!$db->Open()) $db->Kill();
  
echo "	
    <tr>
      <td class='FieldCaptionTD'>$ZLMKO</td> 
      <td class='DataTD'><input class='Input' maxlength='11' name='_MB_mat_KO' size='11' value=''>&nbsp;PLN</td> 
    </tr>

    <tr>
      <td class='FieldCaptionTD'>$ZLMHARDOX</td> 
      <td class='DataTD'><input class='Input' maxlength='11' name='_MB_HARDOX' size='11' value=''>&nbsp;PLN</td> 
    </tr>
    <tr>
     <td class='FieldCaptionTD'>$ZLMC</td> 
     <td class='DataTD' colspan='3'><input class='Input' maxlength='11' name='_MB_mat_c' size='11' value=''>&nbsp;PLN</td>
    </td>
	<tr>
      <td class='FieldCaptionTD'>$ZLFARBY</td> 
      <td class='DataTD'><input class='Input' maxlength='11' name='_farby' size='11' value=''>&nbsp;PLN</td> 
    </tr>
	<tr>
      <td class='FieldCaptionTD'>$ZLMZL1</td> 
      <td class='DataTD'><input class='Input' maxlength='11' name='_matzl' size='11' value=''>&nbsp;PLN</td> 
    </tr>
	<tr>
      <td class='FieldCaptionTD'>$ZLINNE</td> 
      <td class='DataTD'><input class='Input' maxlength='11' name='_inne' size='11' value=''>&nbsp;PLN</td> 
    </tr>
	<tr>
      <td class='FieldCaptionTD'>$ZLTNZ</td> 
      <td class='DataTD'><input class='Input' maxlength='11' name='_tn_zam_z' size='11' value=''>&nbsp;KG</td> 
    </tr>

	<tr>
      <td class='FieldCaptionTD'>&nbsp;</td> 
      <td class='DataTD'><input class='Input' maxlength='11' name='_data' size='11' value='$dzis'></td> 
    </tr>
    <tr>
      <td class='FieldCaptionTD'>$ZLUWAGI</td> 
      <td class='DataTD'><textarea class='Textarea' cols='50' name='_uwagi' rows='3'></textarea></td> 
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
	if (!$db->Open())$db->Kill();
    $query =("INSERT INTO zl_zaop (  lp, id_zlec, MB_mat_c, MB_mat_KO, MB_HARDOX, farby,  matzl,  inne, tn_zam_z, uwagi, data_wp, id_wpr, data, lastuse ) VALUES (NULL, '$_id_zlec', '$_MB_mat_c', '$_MB_mat_KO', '$_MB_HARDOX', '$_farby',  '$_matzl',  '$_inne', '$_tn_zam_z',  '$_uwagi', '$dzis $godz:00', '$id', '$_data', '$dzis $godz:00')");
    $result = mysql_query($query);
    echo "<script language='javascript'>window.location=\"zl_1zaop.php?idzl=$_id_zlec\"</script>";
} 

?>