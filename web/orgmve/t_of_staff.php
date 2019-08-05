<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;

(!isset($_POST['cln'])) ? $cln = $_GET['cln'] : $cln = $_POST['cln'];
(!isset($_POST['state'])) ? $state = 0 : $state = $_POST['state'];
(!isset($_POST['startd'])) ? $startd = "00/00/0000" : $startd = $_POST['startd'];
(!isset($_POST['endd'])) ? $endd = "00/00/0000" : $endd = $_POST['endd'];

$tytul='Time operations of ';

if($state==0)
{
echo "	<TD ALIGN=JUSTIFY VALIGN=TOP border=0>
	<table width='100%' border=0><tr><td>

<center>
<form action='$PHP_SELF' method='post' name='ed_czl'>
  <font class='FormHeaderFont'>$tytul $cln</font>
  <table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
<input name='cln' type='hidden' value='$cln'>
  
  <tr>
      <td class='DataTD' colspan='2'>";
	  $q = "SELECT `nombers`.`knownas`, `nombers`.`firstname`, `nombers`.`surname`, `nombers`.`pno` FROM `nombers`  WHERE `nombers`.`pno`='$cln' LIMIT 1";

//	$db = new CMySQL;
     if (!$db->Open()) $db->Kill();
  if ($db->Query($q)) 
  {
    while ($r=$db->Row())
    {

          echo " $r->firstname $r->surname";
    }
	} else {
echo " 
  <tr>
    <td class='DataTD'></td>
    <td class='DataTD' colspan='3'>SQL Error 1a</td>
  </tr>";
 $db->Kill();
}
echo " 
</td></tr>

    <tr>
      <td class='FieldCaptionTD'>Start date</td>
      <td class='DataTD'><input class='Input' maxlength='12' name='startd' value='$FirstOfTheMonth'>

      </td>
    </tr>
    <tr>  
      <td class='FieldCaptionTD'>End date</td>
      <td class='DataTD'><input class='Input' maxlength='12' name='endd' value='$dzis2'></td>
    </tr>

   <tr>
      <td align='right' colspan='2'>
		<input name='state' type='hidden' value='1'>
			<input class='Button' name='Update' type='submit' value='$OKBTN'>
			<input class='Button' name='datesfromlastm' onclick='this.form.startd.value=\"$FirstOfLastMonth\";this.form.endd.value=\"$LastOfLastMonth\";' type='button' value='Prev month'>
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
   if (!$db->Open()) $db->Kill();

   echo "<script language='javascript'>window.location=\"totalh2.php?cln=$cln&startd=$startd&endd=$endd\"</script>";
} //fi state=1
else
{
 echo "<BR><BR><BR>Ostrze�enie!!!!!<BR><BR><BR>",
	 "Oy! What are you doing? $REMOTE_ADDR <BR>";
} //else state
?>