<?php
ini_set("display_errors","2");
ERROR_REPORTING(E_ALL);

include_once("./header.php");
$tytul='All Staff with picture<BR>';
//include("./inc/uprawnienia.php");
include("./config.php");
$PHP_SELF = $_SERVER['PHP_SELF'];

if (!isset($_POST['state'])) $state = 0; else $state = $_POST['state'];
if (!isset($_POST['_grp'])) $_grp = 0; else $_grp = $_POST['_grp'];

if($state==0)
{
echo "	<TD ALIGN=JUSTIFY VALIGN=TOP border=0>
	<table width='100%' border=0><tr><td>

<center>
<form action='$PHP_SELF' method='post' name='ed_czl'>
  <font class='FormHeaderFont'>$tytul</font>
  <table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
  
  <tr>
      <td class='FieldCaptionTD'>Employee category</td>

<td class='DataTD'>   <select class='Select' name='_grp'>
		<option selected value='0'>All</option>
    <option value='1'>Regular pre 2 years</option>\n
    <option value='2'>Regular post 2 years</option>\n
    <option value='3'>GA+Builders</option>\n
    <option value='4'>GMA</option>\n
    <option value='5'>GA+GMA</option>\n
    <option value='6'>SA</option>\n
    <option value='7'>GA+GMA+SA</option>\n
    <option value='8'>Shop staff</option>\n
    <option value='9'>Intern</option>\n
    <option value='10'>Trial Day</option>\n
    <option value='11'>Accounts</option>\n
    <option value='12'>Buyers</option>\n
    <option value='13'>Casuals</option>\n
    <option value='14'>IT</option>\n
    ";
		
		/*
		  $q = "SELECT DISTINCT  `catname_staff` FROM `emplcat` where `catname_staff`<>'casual'  Order by `catname_staff`";

	$db = new CMySQL;
     if (!$db->Open()) $db->Kill();
  if ($db->Query($q)) 
  {
    while ($r=$db->Row())
    {

          echo "<option value='$r->catname_staff'>$r->catname_staff</option>\n";
    }
	} else {
echo " 
  <tr>
    <td class='DataTD'></td>
    <td class='DataTD' colspan='3'>SQL Error 1a</td>
  </tr>";
 $db->Kill();
}
*/

echo " </select>
</td></tr>
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
include_once("./footer.php");
}
elseif($state==1)
{

   echo "<script language='javascript'>window.location=\"hrpicturelist.php?_grp=$_grp\"</script>";
} //fi state=1
else
{
 echo "<BR><BR><BR>Warning!!!!!<BR><BR><BR>",
	 "Oy! What are you doing? $REMOTE_ADDR <BR>";
} //else state
?>