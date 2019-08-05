<?php
if(!isset($id) && !isset($pw) && $PU>70)
{header("Location: index.html");exit;}

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
  <font class='FormHeaderFont'>$ZLTYTZBYT</font> 
<table WIDTH=700 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >";
	
$db = new CMySQL;
if (!$db->Open()) $db->Kill();
 if( $PU > 70 ){
 $q = "SELECT th_cfg.lp, th_cfg.lastkurs, th_cfg.stawka_g, th_cfg.procko, th_cfg.id_popr, th_cfg.data_popr, th_cfg.data FROM th_cfg WHERE th_cfg.lp=1 LIMIT 1 ";
  } else { 
  echo "<BR><BR><CENTER><H1>$UPRMALE</H1></CENTER><BR><BR>";
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
      <td class='FieldCaptionTD'>$ZLCFG1</td> 
      <td class='DataTD'><input class='Input' maxlength='11' name='_stawka_g' size='11' value='$row->stawka_g'>&nbsp;PLN</td> 
    </tr>

    <tr>
      <td class='FieldCaptionTD'>$ZLCFG2</td> 
      <td class='DataTD'><input class='Input' maxlength='11' name='_procko' size='11' value='$row->procko'>&nbsp;(np. 0.2357)</td> 
    </tr>
    <tr>
     <td class='FieldCaptionTD'>$ZLK</td> 
     <td class='DataTD' colspan='3'><input class='Input' maxlength='11' name='_lastkurs' size='11' value='$row->lastkurs'>&nbsp;</td>
    </td>
	<tr>
      <td class='FieldCaptionTD'>$ZLCFG3</td> 
      <td class='DataTD'><input class='Input' maxlength='11' name='_zlecenie' size='11' value=''>&nbsp;</td> 
    </tr>

	<tr>
      <td class='FieldCaptionTD'>Data zmiany</td> 
      <td class='DataTD'><input class='Input' maxlength='11' name='_data' size='11' value='$dzis'></td> 
    </tr>
    <tr>
      <td class='FieldCaptionTD'>$ZLUWAGI</td> 
      <td class='DataTD'><textarea class='Textarea' cols='50' name='_uwagi' rows='3'>to moze byc pole na notatki</textarea></td> 
    </tr>
	<tr>
      <td class='FieldCaptionTD'><B>$TYTED:</B></td> 
      <td class='DataTD'> $popr->nazwa - $row->data_popr</td> 
    </tr>
 ";

echo "
    <tr>
      <td align='right' colspan='2'>
			<input name='state' type='hidden' value='1'>
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

if(isset($_zlecenie) and $_zlecenie > 0)
   {  
    echo "<script language='javascript'>window.location=\"zlcontrol.php?nrzlpl=$_zlecenie\"</script>";
   }
else
  {  
     if (!$db->Open())$db->Kill();
     $query =("UPDATE th_cfg SET lastkurs='$_lastkurs', stawka_g='$_stawka_g', procko='$_procko', id_popr='$id', data_popr='$dzis $godz:00', data='$_data' WHERE th_cfg.lp=1 LIMIT 1");
     $result = mysql_query($query);
     echo "<script language='javascript'>window.location=\"zl_cont.php\"</script>";
  }

} 

?>