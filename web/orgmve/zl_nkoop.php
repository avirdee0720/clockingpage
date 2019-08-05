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
  <font class='FormHeaderFont'>$ADDNEWBTN: $ZLTYTKOOP</font> 
<table WIDTH=700 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >";
	
$db = new CMySQL;

echo "	
    <tr>
      <td class='FieldCaptionTD'>$ZLKPARTNER</td> 
      <td class='DataTD'><input class='Input' maxlength='100' name='_kooperant' size='70' value=''> </td> 
    </tr>
    <tr>
      <td class='FieldCaptionTD'>$ZLPD</td> 
      <td class='DataTD'><textarea class='Textarea' cols='50' name='_opis_op' rows='3'></textarea> </td> 
    </tr>
    <tr>
      <td class='FieldCaptionTD'>$ZLTOM</td> 
      <td class='DataTD'><input class='Input' maxlength='11' name='_obr_mech' size='11' value=''>&nbsp;PLN</td> 
    </tr>
    <tr>
      <td class='FieldCaptionTD'>$ZLKOOP1</td> 
      <td class='DataTD'><input class='Input' maxlength='11' name='_cynkowanie' size='11' value=''>&nbsp;PLN</td> 
    </tr>
    <tr>
      <td class='FieldCaptionTD'>$ZLKOOP2</td> 
      <td class='DataTD'><input class='Input' maxlength='11' name='_arbosol' size='11' value=''>&nbsp;PLN</td> 
    </tr>		
    <tr>
      <td class='FieldCaptionTD'>$ZLKOOP3</td> 
      <td class='DataTD'><input class='Input' maxlength='11' name='_gumowanie' size='11' value=''>&nbsp;PLN</td> 
    </tr>	
    <tr>
      <td class='FieldCaptionTD'>$ZLKOOP4</td> 
      <td class='DataTD'><input class='Input' maxlength='11' name='_innepow' size='11' value=''>&nbsp;PLN</td> 
    </tr>
    <tr>
      <td class='FieldCaptionTD'>$ZLKOOP5</td> 
      <td class='DataTD'><input class='Input' maxlength='11' name='_trawienie' size='11' value=''>&nbsp;PLN</td> 
    </tr>
    <tr>
      <td class='FieldCaptionTD'>$ZLKOOP6</td> 
      <td class='DataTD'><input class='Input' maxlength='11' name='_konstrukcja' size='11' value=''>&nbsp;PLN</td> 
    </tr>
 
    <tr>
      <td class='FieldCaptionTD'>$ZLGRPBUD</td> 
      <td class='DataTD'><input class='Input' maxlength='50' name='_grpbud' size='30' value=''>&nbsp;</td> 
    </tr>
		    <tr>
      <td class='FieldCaptionTD'>$ZLCZYPO</td> 
      <td class='DataTD'><input class='Input' maxlength='11' name='_czygb' size='11' value=''>&nbsp;PLN</td> 
    </tr>
    <tr>
      <td class='FieldCaptionTD'>$ZLKDATAOD</td> 
      <td class='DataTD'><input class='Input' maxlength='11' name='_datas' size='11' value='$dzis'></td> 
    </tr>
    <tr>
      <td class='FieldCaptionTD'>$ZLKDATADO</td> 
      <td class='DataTD'><input class='Input' maxlength='11' name='_datak' size='11' value='$dzis'></td> 
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
    $query =("INSERT INTO zl_koop (lp, id_zlec, kooperant, opis_op, obr_mech, cynkowanie, arbosol, gumowanie, innepow, trawienie, konstrukcja, uwagi, data_wp, id_wpr, datas, datak, czygb, grpbud, lastuse ) 
	VALUES (NULL, '$_id_zlec', '$_kooperant', '$_opis_op', '$_obr_mech', '$_cynkowanie', '$_arbosol', '$_gumowanie', '$_innepow', '$_trawienie', '$_konstrukcja', '$_uwagi', '$dzis $godz:00', '$id', '$_datas', '$_datak', '$_grpbud', '$_czygb', '$dzis $godz:00')");
	echo "$query";
    $result = mysql_query($query);
    echo "<script language='javascript'>window.location=\"zl_1koop.php?idzl=$_id_zlec\"</script>";
} 
?>