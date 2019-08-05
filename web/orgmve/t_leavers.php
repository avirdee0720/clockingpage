<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$tytul='Leavers - choose tax year';

uprstr($PU,90);

if (!isset($_POST['state'])) $state = 0;
else $state = $_POST['state'];
if (!isset($_POST['year'])) $year = 0;
else $year = $_POST['year'];

if($state==0)
{
$TaxYearsSelectHtml = TaxYearsSelect();


//&cln=$nr&startd=$sd&endd=$ed
echo "
<font class='FormHeaderFont'>$tytul</font>
<BR>

<form action='$PHP_SELF' method='post' name='taxyearleavers'>
<table WIDTH=500 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >
<tr>
         <td class='FieldCaptionTD'><B>Year</B></td>
         <td class='FieldCaptionTD'>  
         <select class='Select' name='year'>
               $TaxYearsSelectHtml 
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

echo "<script language='javascript'>window.location=\"t_leavers2.php?year=$year\"</script>";
}


include_once("./footer.php");
?>
