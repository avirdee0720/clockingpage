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
  <font class='FormHeaderFont'>$ADDNEWBTN: $ZLTYTZBYT</font> 
<table WIDTH=700 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >";
	
$db = new CMySQL;
//if (!$db->Open()) $db->Kill();
  
echo "	


    <tr>
      <td class='FieldCaptionTD'>$ZLZWS</td> 
      <td class='DataTD'><input class='Input' maxlength='11' name='_wart_sprz' size='11' value=''>&nbsp;PLN</td> 
    </tr>
 
    <tr>
      <td class='FieldCaptionTD'>$ZLZGODZ</td> 
      <td class='DataTD'><input class='Input' maxlength='11' name='_godziny' size='11' value=''>&nbsp;H</td> 
    </tr>
	<tr>
      <td class='FieldCaptionTD'>$ZLZRNJ</td> 
      <td class='DataTD'><input class='Input' maxlength='11' name='_r_m_j' size='11' value=''>&nbsp;H/T</td> 
    </tr>
   </tr>
    <tr>
      <td class='FieldCaptionTD'>$ZLZRCJ</td> 
      <td class='DataTD'><input class='Input' maxlength='11' name='_r_c_j' size='11' value=''>&nbsp;&euro;/KG</td> 
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
//if(isset($Nowy) and $Nowy=='$SAVEBTN')
//    {  

	if (!$db->Open())$db->Kill();
    $query =("INSERT INTO zl_zbyt (  lp, id_zlec, wart_sprz, godziny, r_m_j, r_c_j, uwagi, data_wp, id_wpr, data, lastuse ) VALUES (NULL, '$_id_zlec', '$_wart_sprz', '$_godziny', '$_r_m_j', '$_r_c_j',  '$_uwagi', '$dzis $godz:00', '$id', '$_data', '$dzis $godz:00')");

    $result = mysql_query($query);
	//echo $query;
    echo "<script language='javascript'>window.location=\"zl_1zbyt.php?idzl=$_id_zlec\"</script>";
//	}
} 
?>