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
	<SCRIPT LANGUAGE=\"JavaScript\">
<!--

function przelicz(){
document.zl_new._g_zad.value=((document.zl_new._g_mont.value*1)+(document.zl_new._g_kons.value*1)+(document.zl_new._g_przyg.value*1))
}

//-->
</SCRIPT>
	<table width='100%' border=0><TR BGCOLOR='$kolorTlaRamki'>
		</tr></table><table width='100%' border=0><tr><td>

<center>
<form action='$PHP_SELF' method='get' name='zl_new'>
  <font class='FormHeaderFont'>$ADDNEWBTN: $ZLTYTTECH</font> 
<table WIDTH=700 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >";
	
$db = new CMySQL;
//if (!$db->Open()) $db->Kill();

	if(!isset($wze)) {echo "Error: No order price!"; exit;}
	else { echo "<INPUT TYPE='hidden' name='wze' value='$wze'>";}  

echo "	
    <tr>
     <td class='FieldCaptionTD'>$ZLTGZ</td> 
     <td class='DataTD' colspan='3'>
		<input class='Input' onChange=\"this.form._t_m_j.value=this.form._g_zad.value / this.form._tn_wys.value\" maxlength='11' name='_g_zad' size='11' value=''>&nbsp;H
	    </td>
    <tr>
     <td class='FieldCaptionTD'>$ZLTGZ2</td> 
     <td class='DataTD' colspan='3'><input class='Input' maxlength='11' name='_g_przyg' size='11' onChange=\"przelicz()\" value=''>&nbsp;H</td>
    </td>
    <tr>
     <td class='FieldCaptionTD'>$ZLTGZ3</td> 
     <td class='DataTD' colspan='3'><input class='Input' maxlength='11' name='_g_mont' size='11' onChange=\"przelicz()\" value=''>&nbsp;H</td>
    </td>
    <tr>
     <td class='FieldCaptionTD'>$ZLTGZ4</td> 
     <td class='DataTD' colspan='3'><input class='Input' maxlength='11' name='_g_kons' size='11' onChange=\"przelicz()\" value=''>&nbsp;H</td>
    </td>


 
    <tr>
      <td class='FieldCaptionTD'>$ZLTMKO</td> 
      <td class='DataTD'><input class='Input' maxlength='11' name='_matKO' size='11' value=''>&nbsp;KG</td> 
    </tr>
    <tr>
      <td class='FieldCaptionTD'>$ZLTHD</td> 
      <td class='DataTD'><input class='Input' maxlength='11' name='_T_HARDOX' size='11' value=''>&nbsp;KG</td> 
    </tr>
	<tr>
      <td class='FieldCaptionTD'>$ZLTTNW</td> 
      <td class='DataTD'><input class='Input' onChange=\"this.form._t_m_j.value=(this.form._g_zad.value / this.form._tn_wys.value) * 1000; this.form._t_c_j.value=(this.form.wze.value / this.form._tn_wys.value)\"  maxlength='11' name='_tn_wys' size='11' value=''>&nbsp;KG</td> 
    </tr>
    <tr>
      <td class='FieldCaptionTD'>$ZLTTNJ</td> 
      <td class='DataTD'><input class='Input'  maxlength='11' name='_t_m_j' size='11' value=''>&nbsp;H/T</td> 
    </tr>
    <tr>
      <td class='FieldCaptionTD'>$ZLTTCJ</td> 
      <td class='DataTD'><input class='Input' maxlength='11' name='_t_c_j' size='11' value=''>&nbsp;&euro;/KG</td> 
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
    $query =("INSERT INTO zl_tech (  lp, id_zlec, g_zad, g_przyg, g_mont, g_kons, matKO, T_HARDOX, tn_wys, t_m_j, t_c_j, uwagi, data_wp, id_wpr, data, lastuse ) VALUES (NULL, '$_id_zlec', '$_g_zad', '$_g_przyg', '$_g_mont', '$_g_kons', '$_matKO', '$_T_HARDOX', '$_tn_wys', '$_t_m_j', '$_t_c_j', '$_uwagi', '$dzis $godz:00', '$id', '$_data', '$dzis $godz:00')");

    $result = mysql_query($query);
	// echo $query;
    echo "<script language='javascript'>window.location=\"zl_1tech.php?idzl=$_id_zlec\"</script>";
//	}
} 
?>