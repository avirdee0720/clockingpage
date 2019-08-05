<?php
//if(!isset($id) && !isset($pw))
//{header("Location: index.html");exit;}

include_once("./header.php");
include("./languages/$LANGUAGE.php");
include_once("./inc/mlfn.inc.php");
include_once("./inc/uprawnienia.php");
$nP="$PHP_SELF";
$numrows=15;

// uprawnienie
uprstr($PU,70);
if(!isset($state)) $state='';
if(!isset($nowy)) $nowy='';
if(!isset($id_popr)) $id_popr='';
if(!isset($liczz))$liczz=0;
if(!isset($row))$row=0;
switch($state){
case '':

if($nowy==''){	
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
  /*
    if (!$db->Open()) $db->Kill();
  $popr = "SELECT hd_users.nazwa FROM hd_users WHERE hd_users.lp='$row->id_popr' LIMIT 1 ";
  if (!$db->Query($popr)) $db->Kill();
  $popr=$db->Row();

*/

  $state=1;
  $TYTUL=$TYTED;

}else{
	$state=2;
  $TYTUL=$NEWBTN;
}
  if($liczz>0){
	$status="<b>$row->nr_zam_o</b> 	<input name='_nr_zam_o' type='hidden' value='$row->nr_zam_o'>";
  }else{
	$status="<input class='Input'  maxlength='15' name='_nr_zam_o' size='15' value='$row->nr_zam_o'>";

  }
	echo "	<TD ALIGN=JUSTIFY VALIGN=TOP border=0>
	<table width='100%' border=0><TR BGCOLOR='$kolorTlaRamki'>
		</tr></table><table width='100%' border=0><tr><td>

<center>
<form action='$PHP_SELF' method='post' name='zl_new'>
  <font class='FormHeaderFont'>$OBJEKT - $TYTUL</font> 
<table WIDTH=700 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >

    <tr>
      <td class='FieldCaptionTD'>$ZLNRZAMDE</td> 
      <td class='DataTD'>$status</td> 
    </tr>
    <tr>
      <td class='FieldCaptionTD'>$ZLOBJ</td> 
      <td class='DataTD'><input class='Input' maxlength='70' name='_obj' size='70' value='$row->obj'></td> 
    </tr>
    <tr>
      <td class='FieldCaptionTD'>$OBJUWAGI</td> 
      <td class='DataTD'><input class='Input' maxlength='150' name='OPIS' size='70' value='$row->OPIS'></td> 
    </tr>
    <tr>
      <td align='right' colspan='2'>
			<input name='state' type='hidden' value='$state'>
	
		<input name='_nr_zam_old' type='hidden' value='$row->nr_zam_o'>
		
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

break;
case 1:

	if (!$db->Open())$db->Kill();
    $query =("UPDATE zl_object SET nr_zam_o='$_nr_zam_o',obj='$_obj',OPIS='$OPIS' WHERE nr_zam_o='$_nr_zam_old'");

    $result = mysql_query($query);

	echo "<script language='javascript'>window.location=\"zl_obiekty.php?nr_zam_o=$nr_zam_o\"</script>";
break;
case 2:

	if (!$db->Open())$db->Kill();
    $query =("insert into zl_object (`nr_zam_o`,`obj`,`OPIS`) values($_nr_zam_o,'$_obj','$OPIS')");
    $result = mysql_query($query);
    echo "<script language='javascript'>window.location=\"zl_obiekty.php?nr_zam_o=$_nr_zam_o\"</script>";

break;
} 
?>