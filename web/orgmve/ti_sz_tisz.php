<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;

$tytul='Operations on times, time edit';

if (!isset($_POST['state'])) $state = 0; else $state = $_POST['state'];
if (!isset($_POST['_shop'])) $_shop = ""; else $_shop = $_POST['_shop'];
if (!isset($_POST['startd'])) $startd = "00/00/0000"; else $startd = $_POST['startd'];
if (!isset($_POST['endd'])) $endd = "00/00/0000"; else $endd = $_POST['endd'];

if($state==0)
{
echo "	<TD ALIGN=JUSTIFY VALIGN=TOP border=0>
	<table width='100%' border=0><tr><td>

<center>
<form action='$PHP_SELF' method='post' name='ed_czl'>
  <font class='FormHeaderFont'>$tytul</font>
  <table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
  
  <tr>
      <td class='FieldCaptionTD'>Employee clocking in number</td>

<td class='DataTD'>   <select class='Select' name='_shop'>
		<option selected value='127.0.0.1'>LOCAL by default</option>";
		  $q = "SELECT `IP`,MIN(`namefb`) AS ipname FROM `ipaddress` GROUP BY `namefb` ORDER BY `namefb`";

//	$db = new CMySQL;
     if (!$db->Open()) $db->Kill();
  if ($db->Query($q)) 
  {
    while ($r=$db->Row())
    {

          echo "<option value='$r->ipname'> $r->ipname</option>";
    }
	} else {
echo " 
  <tr>
    <td class='DataTD'></td>
    <td class='DataTD' colspan='3'>SQL Error 1a</td>
  </tr>";
 $db->Kill();
}
echo " </select>
</td>	
</tr>

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
elseif($_POST['state']==1)
{ 
   echo "<script language='javascript'>window.location=\"totalh2sh.php?shop=$_shop&startd=$startd&endd=$endd\"</script>";
} //fi state=1
else
{
 echo "<BR><BR><BR>Ostrze�enie!!!!!<BR><BR><BR>",
	 "Oy! What are you doing? $REMOTE_ADDR <BR>";
} //else state
?>