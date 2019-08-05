<?php
//ini_set("display_errors","2");
//ERROR_REPORTING(E_ALL);

include_once("./header.php");
$tytul='Email List<BR>';
//include("./inc/uprawnienia.php");
include("./config.php");

$date1 = date("Y-m-d");

echo "	<TD ALIGN=JUSTIFY VALIGN=TOP border=0>
	<table width='100%' border=0><tr><td>

<center>
<form action='emailaddress1b.php?sort=1' method='post' name='ed_czl'>
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