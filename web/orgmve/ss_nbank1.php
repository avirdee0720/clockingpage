<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
uprstr($PU,90);
$dataakt=date("d/m/Y H:i:s");
$db1 = new CMySQL;
$title = "Chose shop to add banking";

if(!isset($state))
{

$rokmniej=date("Y")- 1;
$startd="01/12/".$rokmniej;
$endd="30/11/".date("Y");

list($day, $month, $year) = explode("/",$startd);
$dod = "$year-$month-$day";
list($day1, $month1, $year1) = explode("/",$endd);
$ddo= "$year1-$month1-$day1";

//&cln=$nr&startd=$sd&endd=$ed
echo "
<font class='FormHeaderFont'>$title</font>
<BR>

<form action='$PHP_SELF' method='post' name='addholliday'>
<table WIDTH=500 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >
<tr>
<td class='FieldCaptionTD'><B>SHOP</B></td>
<td class='FieldCaptionTD'>     <select class='Select' name='shop'>	";

		if (!$db1->Open()) $db1->Kill();
		$q1 = "SELECT `ssdepartments`.`dep_id`, `ssdepartments`.`name` FROM `ssdepartments` WHERE `ssdepartments`.`show`='y' ORDER BY `ssdepartments`.`name`";
		if (!$db1->Query($q1)) $db1->Kill();

			while ($row1=$db1->Row())
			{
			echo "
                <option value='$row1->dep_id'>$row1->name</option>";	

			} //while 1  

echo "
                 </select></td>
</tr>
					 
				 
				 <tr>
<td class='FieldCaptionTD'><B>Date for banking</B></td>
<td class='FieldCaptionTD'><input class='Input' maxlength='12' name='data' value='$yesterday1'> </td>
</tr>
					 
				 
				 </table>

			<input name='state' type='hidden' value='1'><BR><BR>
			<input class='Button' name='Update' type='submit' value='$NEXTBTN'>
</center>
</FORM>
</td></tr>
</table>";
include_once("./footer.php");
}
elseif($state==1)
{

echo "<script language='javascript'>window.location=\"ss_nbank2.php?shopid=$shop&data=$data\"</script>";
}

?>
