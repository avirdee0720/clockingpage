<?php
//ini_set("display_errors","2");
//ERROR_REPORTING(E_ALL);

include_once("./header.php");
$tytul='No Email addresses<BR>';
//include("./inc/uprawnienia.php");
include("./config.php");

$date1 = date("Y-m-d");

$db = new CMySQL;
if (!$db->Open()) $db->Kill();
$db1 = new CMySQL;
if (!$db1->Open()) $db1->Kill();
$db3 = new CMySQL;
if (!$db3->Open()) $db3->Kill();

if (!isset($state) && isset($_POST['state'])) $state= $_POST['state'];
if (!isset($DepGroup) && isset($_POST['_grp'])) $DepGroup=$_POST['_grp'];
if (!isset($reportid) && isset($_POST['_report'])) $reportid=$_POST['_report'];   

if (!isset($state) && isset($_GET['state'])) $state= $_GET['state'];
if (!isset($DepGroup) && isset($_GET['_grp'])) $DepGroup=$_GET['_grp'];
if (!isset($reportid) && isset($_GET['_report'])) $reportid=$_GET['_report'];   

if (!isset($prepost) && isset($_GET['prepost'])) $prepost=$_GET['prepost'];     
  
  
     

echo "	<TD ALIGN=JUSTIFY VALIGN=TOP border=0>
	<table width='100%' border=0><tr><td>

<center>
<form action='no_emailaddress1b.php' method='post' name='ed_czl'>
  <font class='FormHeaderFont'>$tytul</font>
  <table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
  
  <tr>
      <td class='FieldCaptionTD'>Employee category</td>

<td class='DataTD'>   <select class='Select' name='_grp'>
		<option selected value='%'>All</option>\n
		<option value='c'>Casular</option>\n
		<option value='r'>Regular</option>\n
  </select>
</td></tr>";


echo "
   
  </table>
  	<input name='state' type='hidden' value='1'>
  <input class='Button' name='Update' type='submit' value='$OKBTN'>
</form>
</center>
<BR>
</td></tr>
</table>";
include_once("./footer.php");

?>