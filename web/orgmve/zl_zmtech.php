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
  <font class='FormHeaderFont'>$BTNZAMKNIJ $ZLZL</font> 
<table WIDTH=700 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >";
	
$db = new CMySQL;
if (!$db->Open()) $db->Kill();
 if(isset($idzl)){
 $q = "SELECT zl_zlec.lp, zl_zlec.nr_zam_pl, zl_zlec.nr_zam_o, zl_zlec.nr_poz, zl_zlec.nr_kom, zl_zlec.obj, zl_zlec.nazwa, zl_zlec.w_z_e, zl_zlec.kurs, zl_zlec.w_z_p, zl_zlec.tn_zam, zl_zlec.uwagi, zl_zlec.data_wp, zl_zlec.id_wpr, zl_zlec.data_popr, zl_zlec.id_popr, zl_zlec.data, hd_users.nazwa AS USR FROM zl_zlec INNER JOIN hd_users ON zl_zlec.id_wpr = hd_users.lp WHERE zl_zlec.lp='$idzl' LIMIT 1 ";

  } else { 
  echo "<BR><BR><CENTER><H1>Cos siê zepsu³o!</H1></CENTER><BR><BR>";
  exit;
 }
if (!$db->Query($q)) $db->Kill();
$row=$db->Row();
  
echo "	
    <tr>
     <td class='FieldCaptionTD'>$ZLNRZAMPL</td> 
     <td class='DataTD' colspan='3'>$row->nr_zam_pl<INPUT TYPE='hidden' name='zampl' value='$row->nr_zam_pl'></td>
    </td>
   </tr>

    <tr>
      <td class='FieldCaptionTD'>$ZLNRZAMDE</td> 
      <td class='DataTD'>$row->nr_zam_o<INPUT TYPE='hidden' name='zamde' value='$row->nr_zam_o'></td> 
    </tr>
 
    <tr>
      <td class='FieldCaptionTD'>$ZLNRPOZ</td> 
      <td class='DataTD'>$row->nr_poz</td> 
    </tr>
 
    <tr>
      <td class='FieldCaptionTD'>$ZLNRK</td> 
      <td class='DataTD'>$row->nr_kom</td> 
    </tr>
    <tr>
      <td class='FieldCaptionTD'>$ZLOBJ</td> 
      <td class='DataTD'>$row->obj</td> 
    </tr>
	<tr>
      <td class='FieldCaptionTD'>$ZLNAZWA</td> 
      <td class='DataTD'>$row->nazwa</td> 
    </tr>
    <tr>
      <td class='FieldCaptionTD'>$ZLWE</td> 
      <td class='DataTD'>$row->w_z_e&nbsp;&euro;</td> 
    </tr>
    <tr>
      <td class='FieldCaptionTD'>$ZLK</td> 
      <td class='DataTD'>$row->kurs&nbsp;PLN</td> 
    </tr>
    <tr>
      <td class='FieldCaptionTD'>$ZLWZ</td> 
      <td class='DataTD'>$row->w_z_p&nbsp;PLN </td> 
    </tr>
    <tr>
      <td class='FieldCaptionTD'>$ZLTNZ</td> 
      <td class='DataTD'>$row->tn_zam &nbsp;KG</td> 
    </tr>
    <tr>
      <td class='FieldCaptionTD'>$ZLUWAGI</td> 
      <td class='DataTD'>$row->uwagi</td> 
    </tr>
    <tr>
      <td class='FieldCaptionTD'>$RPNDATE</td> 
      <td class='DataTD'>$row->data</td> 
    </tr>

 ";

echo "
    <tr>
      <td align='right' colspan='2'>
			<input name='state' type='hidden' value='1'>
			<input name='idzl' type='hidden' value='$row->lp'>
			<input class='Button' name='Nowy' onclick=\"return confirm('$zlkomzam?')\"  type='submit' value='$BTNZAMKNIJ'>
			<input class='Button' name='Cancel' type='Button' onclick='javascript:history.back()' value='$EXITBTN'>
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
				VALUES ('', 'CLOSED', '$zampl - $zamde', '$dzis $godz:00', '$id','KOM:$_nr_kom, $_obj, $_nazwa ')");
    $result = mysql_query($query);
	
	$zamzlec="UPDATE zl_zlec SET  zak='t', id_zam='$id', data_zam='$dzis $godz:00' WHERE lp='$idzl' LIMIT 1";
	    $result1 = mysql_query($zamzlec);

	echo "<script language='javascript'>window.location=\"zl_lista.php\"</script>";
} 
?>