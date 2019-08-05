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
  <font class='FormHeaderFont'>$TYTED: $ZLTYTTECH</font> 
<table WIDTH=700 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >";

	if(!isset($wze)) {echo "Error: No order price!"; exit;}
	else { echo "<INPUT TYPE='hidden' name='wze' value='$wze'>";}

$db = new CMySQL;
if (!$db->Open()) $db->Kill();
 if(isset($lp)){
 $q = "SELECT zl_tech.lp, zl_tech.id_zlec, zl_tech.g_zad, zl_tech.g_przyg, zl_tech.g_mont, zl_tech.g_kons, zl_tech.matKO, zl_tech.T_HARDOX, zl_tech.tn_wys, zl_tech.t_m_j, zl_tech.t_c_j, zl_tech.uwagi, zl_tech.data_wp, zl_tech.id_wpr, zl_tech.data_popr, zl_tech.id_popr, zl_tech.data, hd_users.nazwa AS USR FROM zl_tech INNER JOIN hd_users ON zl_tech.id_wpr = hd_users.lp WHERE zl_tech.lp='$lp' LIMIT 1 ";

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
     <td class='FieldCaptionTD'>$ZLTGZ</td> 
     <td class='DataTD' colspan='3'><input class='Input' onChange=\"this.form._t_m_j.value=this.form._g_zad.value / this.form._tn_wys.value * 1000\" maxlength='11' name='_g_zad' size='11' value='$row->g_zad'>&nbsp;H
				
	</td>
    </tr>
    <tr>
     <td class='FieldCaptionTD'>$ZLTGZ2</td> 
     <td class='DataTD' colspan='3'><input class='Input' maxlength='11' name='_g_przyg' size='11' onChange=\"przelicz()\" value='$row->g_przyg'>&nbsp;H</td>
    </tr>
     <td class='FieldCaptionTD'>$ZLTGZ3</td> 
     <td class='DataTD' colspan='3'><input class='Input' maxlength='11' name='_g_mont' size='11' value='$row->g_mont' onChange=\"przelicz()\">&nbsp;H</td>
    </tr>
     <td class='FieldCaptionTD'>$ZLTGZ4</td> 
     <td class='DataTD' colspan='3'><input class='Input' maxlength='11' name='_g_kons' size='11' value='$row->g_kons' onChange=\"przelicz()\">&nbsp;H</td>
    </tr>
 
    <tr>
      <td class='FieldCaptionTD'>$ZLTMKO</td> 
      <td class='DataTD'><input class='Input' maxlength='11' name='_matKO' size='11' value='$row->matKO'>&nbsp;KG</td> 
    </tr>
   </tr>
    <tr>
      <td class='FieldCaptionTD'>$ZLTHD</td> 
      <td class='DataTD'><input class='Input' maxlength='11' name='_T_HARDOX' size='11' value='$row->T_HARDOX'>&nbsp;KG</td> 
    </tr>
	<tr>
      <td class='FieldCaptionTD'>$ZLTTNW</td> 
      <td class='DataTD'><input class='Input' 
	onChange=\"this.form._t_m_j.value=(this.form._g_zad.value / this.form._tn_wys.value) * 1000;
				this.form._t_c_j.value=this.form.wze.value / this.form._tn_wys.value\" 
					maxlength='11' name='_tn_wys' size='11' value='$row->tn_wys'>&nbsp;KG</td> 
    </tr>
    <tr>
      <td class='FieldCaptionTD'>$ZLTTNJ</td> 
      <td class='DataTD'><input class='Input' maxlength='11' name='_t_m_j' size='11' value='$row->t_m_j'>&nbsp;H/T</td> 
    </tr>
    <tr>
      <td class='FieldCaptionTD'>$ZLTTCJ</td> 
      <td class='DataTD'><input class='Input' maxlength='11' name='_t_c_j' size='11' value='$row->t_c_j'>&nbsp;&euro;/KG</td> 
    </tr>

	<tr>
      <td class='FieldCaptionTD'>$INS</td> 
      <td class='DataTD'>$row->USR - $row->data_wp<BR><B>$TYTED:</B> $popr->nazwa - $row->data_popr</td> 
    </tr>
       <tr>
      <td class='FieldCaptionTD'>&nbsp;</td> 
      <td class='DataTD'><input class='Input' maxlength='11' name='_data' size='11' value='$row->data'></td> 
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
/*if(isset($Nowy) and $Nowy=='$SAVEBTN')
    {  
$query =("UPDATE zl_tech SET g_zad='".number_format($_g_zad,2,'.','')."', g_przyg='".number_format($_g_przyg,2,'.','')."',g_mech='".number_format($_g_mech,2,'.','')."',g_kons='".number_format($_g_kons,2,'.','')."', obr_mech='".number_format($_obr_mech,2,'.','')."', powloki='".number_format($_powloki,2,'.','')."',
	matKO='".number_format($_matKO,2,'.','')."', T_HARDOX='".number_format($_T_HARDOX,2,'.','')."', tn_wys='".number_format($_tn_wys,2,'.','')."', t_m_j='".number_format($_t_m_j,2,'.','')."', 
	t_c_j='".number_format($_t_c_j,2,'.','')."', data_popr='$dzis $godz:00', id_popr='$id', data='$_data', uwagi='$_uwagi', grpbud='$_grpbud', czygb='$_czybud', lastuse='$dzis $godz:00'  WHERE zl_tech.lp='$lp' LIMIT 1");
*/
	if (!$db->Open())$db->Kill();
    $query =("UPDATE zl_tech SET g_zad='$_g_zad', g_przyg='$_g_przyg',g_mont='$_g_mont',g_kons='$_g_kons', matKO='$_matKO', T_HARDOX='$_T_HARDOX', tn_wys='$_tn_wys', t_m_j='$_t_m_j', t_c_j='$_t_c_j', data_popr='$dzis $godz:00', id_popr='$id', data='$_data', uwagi='$_uwagi', lastuse='$dzis $godz:00'  WHERE zl_tech.lp='$lp' LIMIT 1");

    $result = mysql_query($query);
    echo "<script language='javascript'>window.location=\"zl_1tech.php?idzl=$_id_zlec\"</script>";
//	}
} 
?>