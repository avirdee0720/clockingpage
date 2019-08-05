<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;

$tytul='Would you like to delete this advance?';

(!isset($_GET['cln'])) ? $cln = 0 : $cln = $_GET['cln'];
(!isset($_GET['advanceid'])) ? $advanceid = 0 : $advanceid = $_GET['advanceid'];
(!isset($_POST['state'])) ? $state = 0 : $state = $_POST['state'];

if($state==0)
{
echo "	<TD ALIGN=JUSTIFY VALIGN=TOP border=0>
	<table width='100%' border=0><tr><td>

<center>
<form action='$PHP_SELF' method='post' name='ed_czl'>
  <font class='FormHeaderFont'>$tytul /$cln/</font>
  <table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
<input name='cln' type='hidden' value='$cln'>
  
  <tr>
      <td class='DataTD' colspan='2'>";
	$sql = "SELECT `id`, `no`,DATE_FORMAT(`date1`, \"%d/%m/%Y\") as d2, `amount`, `gvienby`, `dateg`  FROM `advances_get` WHERE `id`='$advanceid' LIMIT 1";


     if (!$db->Open()) $db->Kill();
  if (!$db->Query($sql)) 
  {
  echo " 
  <tr>
    <td class='DataTD'></td>
    <td class='DataTD' colspan='3'>SQL Error 1a</td>
  </tr>";
 $db->Kill();
   
	} else {


$r=$db->Row();

echo " 
</td></tr>

    <tr>
      <td class='FieldCaptionTD'>Advance /amount, day/</td>
      <td class='FieldCaptionTD'>$r->amount</td>
      <td class='FieldCaptionTD'>$r->d2</td>

      </td>
    </tr>

   <tr>
      <td align='right' colspan='2'>
		<input name='state' type='hidden' value='1'>
			<input class='Button' name='Update' type='submit' value='$OKBTN'>

	</td>
    </tr>
    <input name='advanceid' type='hidden' value='$advanceid'>
  </table>
</form>
</center>
<BR>
</td></tr>
</table>";
}
include_once("./footer.php");
}
elseif($state==1)
{
$cln =  $_POST['cln'];
$advanceid =  $_POST['advanceid'];
if (!$db->Open()) $db->Kill();

  $sql1 =("DELETE FROM `advances_get` WHERE `id`='$advanceid'  LIMIT 1");

  if (!$db->Query($sql1)) $db->Kill();
  
  $sql1 =("DELETE FROM `advances` WHERE `idadv` = '$advanceid'   LIMIT 1");

  if (!$db->Query($sql1)) $db->Kill();
  
  //$sql1 =("OPTIMIZE TABLE `advances_get` ");

  //if (!$db->Query($sql1)) $db->Kill();
  
  //$sql1 =("OPTIMIZE TABLE `advances` ");

  //if (!$db->Query($sql1)) $db->Kill();
  

echo "<script language='javascript'>window.location=\"advance1.php?cln=$cln\"</script>";
} //fi state=1
else
{
 echo "<BR><BR><BR>Ostrze�enie!!!!!<BR><BR><BR>",
	 "Oy! What are you doing? $REMOTE_ADDR <BR>";
} //else state
?>