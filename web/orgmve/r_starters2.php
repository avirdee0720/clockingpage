<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;

uprstr($PU,50);
$month=$_GET['month'];
$year=$_GET['year'];

echo "
<font class='FormHeaderFont'>Started in $month/$year</font>
<BR>
<table WIDTH=500 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >";

if (!$db->Open()) $db->Kill();
$q = "SELECT `nombers`.`ID`, `nombers`.`pno`, `nombers`.`firstname`, `nombers`.`surname`, `nombers`.`knownas`, `nombers`.`status`, DATE_FORMAT(`nombers`.`started`, \"%d/%m/%Y\") as d1, `emplcat`.`catname` FROM `nombers` LEFT JOIN `emplcat` ON `nombers`.`cat`=`emplcat`.`catozn` WHERE `status`<>'LEAVER' AND `nombers`.`started` LIKE '$year-$month-%'";

$razem=0;
if ($db->Query($q)) 
  {
    while ($row=$db->Row())
    {
	echo "  <tr>
    <td CLASS='DataTD'>$row->pno</td>
    <td CLASS='DataTD'>$row->firstname</td>
    <td CLASS='DataTD'>$row->surname</td>
    <td CLASS='DataTD'>$row->knownas</td>
    <td CLASS='DataTD'>$row->catname</td>
    <td CLASS='DataTD'>$row->d1</td>
         </tr>";
	}

} else {
echo " 
  <tr>
    <td class='DataTD'></td>
    <td class='DataTD' colspan='5'>SQL Error:".mysql_error()."</td>
  </tr>";
 $db->Kill();
}

echo "
</table>

</td></tr>
</table>";
include_once("./footer.php");

?>
