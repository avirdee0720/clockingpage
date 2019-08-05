<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;

$tytul='Would you like to delete this  regural days?';

(!isset($_POST['state'])) ? $state = 0 : $state = $_POST['state'];
(!isset($_POST['cln'])) ? $cln = $_GET['cln'] : $cln = $_POST['cln'];
(!isset($_POST['id'])) ? $id = $_GET['id'] : $id = $_POST['id'];

if($state==0)
{
echo "	<TD ALIGN=JUSTIFY VALIGN=TOP border=0>
	<table width='100%' border=0><tr><td>

<center>
<form action='$PHP_SELF' method='post' name='ed_czl'>
  <font class='FormHeaderFont'>$tytul /$cln/</font>
  <table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
<input name='cln' type='hidden' value='$cln'>
<input name='id' type='hidden' value='$id'>
  
  <tr>
      <td class='DataTD' colspan='2'>";
	$sql = "SELECT `id`, `no`,DATE_FORMAT(`datechange`, \"%d/%m/%Y\") as datechange  FROM `regdayshistory` WHERE `id`='$id' LIMIT 1";


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
      <td class='FieldCaptionTD'>Clocking number</td>
       <td class='FieldCaptionTD'>Date</td>
       </tr>
       <tr>
       <td class='FieldCaptionTD'>$r->no</td>
      <td class='FieldCaptionTD'>$r->datechange</td>

      </td>
    </tr>

   <tr>
      <td align='right' colspan='2'>
		<input name='state' type='hidden' value='1'>
			<input class='Button' name='Update' type='submit' value='$OKBTN'>

	</td>
    </tr>
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
if (!$db->Open()) $db->Kill();

    $sql1 =("DELETE FROM `regdayshistory` WHERE `id`='$id' and `no`='$cln' LIMIT 1");

  if (!$db->Query($sql1)) $db->Kill();
  
  
  //$sql1 =("OPTIMIZE TABLE `regdayshistory` ");

  //if (!$db->Query($sql1)) $db->Kill();
  

echo "<script language='javascript'>window.location=\"regdayslist.php?cln=$cln\"</script>";
} //if state=1
else
{
 echo "<BR><BR><BR>Ostrze�enie!!!!!<BR><BR><BR>",
	 "Oy! What are you doing? $REMOTE_ADDR <BR>";
} //else state
?>