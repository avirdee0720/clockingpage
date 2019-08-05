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
  <font class='FormHeaderFont'>$DELBTN: $ZLTYTTECH</font> 
<table WIDTH=700 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >";

	if(!isset($wze)) {echo "Error: No order price!"; exit;}
	else { echo "<INPUT TYPE='hidden' name='wze' value='$wze'>";}

$db = new CMySQL;
if (!$db->Open()) $db->Kill();
 if(isset($lp)){
 $q = "SELECT zl_tech.lp, zl_tech.id_zlec, zl_tech.g_zad, zl_tech.matKO, zl_tech.T_HARDOX, zl_tech.tn_wys, zl_tech.t_m_j, zl_tech.t_c_j, zl_tech.uwagi, zl_tech.data_wp, zl_tech.id_wpr, zl_tech.data_popr, zl_tech.id_popr, zl_tech.data, hd_users.nazwa AS USR FROM zl_tech INNER JOIN hd_users ON zl_tech.id_wpr = hd_users.lp WHERE zl_tech.lp='$lp' LIMIT 1 ";

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
     <td class='DataTD' colspan='3'>$row->g_zad&nbsp;H</td>
    </td>
 
    <tr>
      <td class='FieldCaptionTD'>$ZLTMKO</td> 
      <td class='DataTD'>$row->matKO&nbsp;KG</td> 
    </tr>
   </tr>
    <tr>
      <td class='FieldCaptionTD'>$ZLTHD</td> 
      <td class='DataTD'>$row->T_HARDOX&nbsp;KG</td> 
    </tr>
	<tr>
      <td class='FieldCaptionTD'>$ZLTTNW</td> 
      <td class='DataTD'>$row->tn_wys&nbsp;KG</td> 
    </tr>
    <tr>
      <td class='FieldCaptionTD'>$ZLTTNJ</td> 
      <td class='DataTD'>$row->t_m_j&nbsp;H/T</td> 
    </tr>
    <tr>
      <td class='FieldCaptionTD'>$ZLTTCJ</td> 
      <td class='DataTD'>$row->t_c_j&nbsp;&euro;/KG</td> 
    </tr>
	<tr>
      <td class='FieldCaptionTD'>$INS</td> 
      <td class='DataTD'>$row->USR - $row->data_wp<BR><B>$TYTED:</B> $popr->nazwa - $row->data_popr</td> 
    </tr>
       <tr>
      <td class='FieldCaptionTD'>&nbsp;</td> 
      <td class='DataTD'>$row->data</td> 
    </tr>
    <tr>
      <td class='FieldCaptionTD'>$ZLUWAGI</td> 
      <td class='DataTD'>$row->uwagi</td> 
    </tr>
 ";

echo "
    <tr>
      <td align='right' colspan='2'>
			<input name='state' type='hidden' value='1'>
			<input name='idzl' type='hidden' value='$idzl'>
			<input name='lp' type='hidden' value='$row->lp'>
			<input class='Button' name='kasuj' onclick=\"return confirm('$zlkomkas')\"  type='submit' value='$DELBTN'>
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
    $query =("INSERT INTO hd_log ( `lp` , `tabela` , `temat` , `kiedy` , `user_id`, `infodod` ) 
				VALUES ('', 'zl_tech', 'IDZL: $idzl', '$dzis $godz:00', '$id','$_obr_mech, $_g_zad - $_uwagi ')");

    $result = mysql_query($query);

	$dtech="DELETE FROM zl_tech WHERE lp = $lp";
    $result3 = mysql_query($dtech);

    echo "<script language='javascript'>window.location=\"zl_1tech.php?idzl=$idzl\"</script>";
} 
?>