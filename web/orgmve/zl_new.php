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
  <font class='FormHeaderFont'>$TYTNZL</font> 
<table WIDTH=700 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >";
	
$db = new CMySQL;
if (!$db->Open()) $db->Kill();
 if(isset($nr_zam_o)){
 $q = "SELECT `zl_object`.`nr_zam_o`, `zl_object`.`obj`,`zl_object`.`OPIS` FROM `zl_object` WHERE nr_zam_o='$nr_zam_o'";

  } else { 
  echo "<BR><BR><CENTER><H1>Cos siê zepsu³o!</H1></CENTER><BR><BR>";
  exit;
 }

if (!$db->Query($q)) $db->Kill();
$row=$db->Row();
  
echo "	
    <tr>
     <td class='FieldCaptionTD'>$ZLNRZAMPL</td> 
     <td class='DataTD' colspan='3'><input class='Input' maxlength='11' name='_nr_zam_pl' size='11' value=''></td>
    </td>
   </tr>

    <tr>
      <td class='FieldCaptionTD'>$ZLNRZAMDE</td> 
      <td class='DataTD'><input class='Input' maxlength='15' name='_nr_zam_o' value='$row->nr_zam_o' size='15' value=''></td> 
    </tr>
 
    <tr>
      <td class='FieldCaptionTD'>$ZLNRPOZ</td> 
      <td class='DataTD'><input class='Input' maxlength='100' name='_nr_poz' size='11' value=''></td> 
    </tr>
 
    <tr>
      <td class='FieldCaptionTD'>$ZLNRK</td> 
      <td class='DataTD'><input class='Input' maxlength='50' name='_nr_kom' size='50' value=''></td> 
    </tr>
 
    <tr>
      <td class='FieldCaptionTD'>$ZLOBJ</td> 
      <td class='DataTD'><input class='Input' maxlength='70' name='_obj' value='$row->obj' size='70' value=''></td> 
    </tr>
	<tr>
      <td class='FieldCaptionTD'>$ZLNAZWA</td> 
      <td class='DataTD'><input class='Input' maxlength='70' name='_nazwa' size='70' value=''></td> 
    </tr>
    <tr>
      <td class='FieldCaptionTD'>$ZLWE</td> 
      <td class='DataTD'><input class='Input' onChange=\"this.form._w_z_p.value=this.form._w_z_e.value*this.form._kurs.value\" maxlength='13' name='_w_z_e' size='13' value=''>&nbsp;&euro;</td> 
    </tr>
";

	if (!$db->Open())$db->Kill();
    $query =("SELECT lastkurs FROM th_cfg LIMIT 1");
    if (!$db->Query($query)) $db->Kill();
    $row=$db->Row();

echo "    <tr>
      <td class='FieldCaptionTD'>$ZLK</td> 
      <td class='DataTD'><input class='Input' maxlength='13' name='_kurs' size='13' onChange=\"this.form._w_z_p.value=this.form._w_z_e.value * this.form._kurs.value\" value='$row->lastkurs'>&nbsp;PLN</td> 
    </tr>
    <tr>
      <td class='FieldCaptionTD'>$ZLWZ</td> 
      <td class='DataTD'><input class='Input' onInput=\"this.form._w_z_p.value=this.form._w_z_e.value*this.form._kurs.value\" maxlength='13' name='_w_z_p' size='13' value=''>&nbsp;PLN</td> 
    </tr>
	<!--  2005-06-14 -->
	<tr>
     <td class='FieldCaptionTD'>$ZLPSP:</td>
     <td class='DataTD'><input class='Input' maxlength='24' name='_pspelem' size='24' value=''>(22char)</td>
     </tr><tr>
	 <td class='FieldCaptionTD'>$ZLTEILENO:</td>
     <td class='DataTD'><input class='Input' maxlength='8' name='_teileno' size='8' value=''>(8 int)</td>
     </tr><tr>
	 <td class='FieldCaptionTD'>$ZLDOSTMD:</td>
     <td class='DataTD'><input class='Input' maxlength='50' name='_dostMD' size='50' value=''>(50char)</td>
     </tr>
	<tr>
     <td class='FieldCaptionTD'>$ZLKONS:</td>
     <td class='DataTD'><input class='Input' maxlength='50' name='_konserwacja' size='50' value=''>(50char)</td>
     </tr><tr>
	 <td class='FieldCaptionTD'>$ZLTP1:</td>
     <td class='DataTD'><input class='Input' maxlength='40' name='_TP' size='40' value=''>(40char)</td>
     </tr><tr>
     <td class='FieldCaptionTD'>$ZLKTERM:</td>
     <td class='DataTD'><input class='Input' maxlength='10' name='_ktermin' size='10' value=''>(Date)</td>
     </tr><tr>
	 <td class='FieldCaptionTD'>$ZLKPARTNER:</td>
     <td class='DataTD'><input class='Input' maxlength='50' name='_kpartner' size='50' value=''>(50char)</td>
     </tr><tr>
     <td class='FieldCaptionTD'>$ZLKDATAOD:</td>
     <td class='DataTD'><input class='Input' maxlength='10' name='_kdata' size='10' value=''>(Date)</td>
     </tr>


    <tr>
      <td class='FieldCaptionTD'>$ZLTNZ</td> 
      <td class='DataTD'><input class='Input' maxlength='13' name='_tn_zam' size='13' value=''>&nbsp;KG</td> 
    </tr>
    <tr>
      <td class='FieldCaptionTD'>$ZLUWAGI</td> 
      <td class='DataTD'><input class='Input' maxlength='150' name='_uwagi' size='70' value=''></td> 
    </tr>
    <tr>
      <td class='FieldCaptionTD'>$RPNDATE</td> 
      <td class='DataTD'><input class='Input' maxlength='100' name='_data' size='50' value='$dzis'></td> 
    </tr>

 ";

echo "
    <tr>
      <td align='right' colspan='2'>
			<input name='state' type='hidden' value='1'>
			<input class='Button' name='Nowy' onclick=\"return confirm('$zlkom1')\" type='submit' value='$SAVEBTN'>
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
    $kurs =("UPDATE `th_cfg` SET `lastkurs`='$_kurs' WHERE lp=1 LIMIT 1");
    $result = mysql_query($kurs);

	if (!$db->Open())$db->Kill();
    $query =("INSERT INTO zl_zlec ( lp, nr_zam_pl, nr_zam_o, nr_poz, nr_kom, obj, nazwa, w_z_e, kurs, w_z_p, tn_zam, uwagi, data_wp, id_wpr, data, zak, pspelem, teileno, dostMD, konserwacja, TP, ktermin, kpartner, kdata ) VALUES (NULL, '$_nr_zam_pl', '$_nr_zam_o', '$_nr_poz', '$_nr_kom', '$_obj', '$_nazwa', '$_w_z_e', '$_kurs', '$_w_z_p', '$_tn_zam', '$_uwagi', '$dzis $godz:00', '$id', '$_data', 'n', '$_pspelem', '$_teileno', '$_dostMD', '$_konserwacja', '$_TP', '$_ktermin', '$_kpartner', '$_kdata')");

    $result = mysql_query($query);
	//echo $query;
    echo "<script language='javascript'>window.location=\"zl_lista.php\"</script>";
//	}
} 
?>