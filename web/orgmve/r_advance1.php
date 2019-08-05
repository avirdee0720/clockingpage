<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
uprstr($PU,90);
$dataakt=date("d/m/Y H:i:s");
$msgdb = new CMySQL;

if (!isset($_POST['state'])) $state = 0; else $state = $_POST['state'];
if (!isset($_POST['month'])) $month = 0; else $month = $_POST['month'];
if (!isset($_POST['year'])) $year = 0; else $year = $_POST['year'];

if($state==0) {

$YearsSelectHtml = Yearsselect();
$MonthsSelectHtml = Monthsselect();


//&cln=$nr&startd=$sd&endd=$ed
echo "
<font class='FormHeaderFont'>Advances for a month</font>
<BR>

<form action='$PHP_SELF' method='post' name='addholliday'>
<table WIDTH=500 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >
<tr>
         <td class='FieldCaptionTD'><B>Year</B></td>
         <td class='FieldCaptionTD'>  
         <select class='Select' name='year'>
                 $YearsSelectHtml
				</select></td>
</tr>     
<tr>
         <td class='FieldCaptionTD'><B>Month</B></td>
         <td class='FieldCaptionTD'>  
         <select class='Select' name='month'>
                $MonthsSelectHtml
                 </select></td>
</tr>
";


echo "
</table>

			<input name='state' type='hidden' value='1'>
			<input class='Button' name='Update' type='submit' value='$SAVEBTN'>
</center>
</FORM>
</td></tr>
</table>";
include_once("./footer.php");
}
elseif($state==1)
{

echo "<script language='javascript'>window.location=\"r_advance2.php?month=$month&year=$year\"</script>";
}

?>
