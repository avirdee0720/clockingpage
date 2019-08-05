<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;

uprstr($PU,50);
$month=$_GET['month'];
$year=$_GET['year'];

echo "
<font class='FormHeaderFont'>Advances: $month/$year</font>
<BR>
<table WIDTH=500 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >";
$TotalAdvances=0;
if (!$db->Open()) $db->Kill();
$q = "SELECT `advances`.`no`, SUM(`advances`.`topay`) AS totaltopay, `nombers`.`firstname`, `nombers`.`surname`, `nombers`.`knownas`  FROM `advances` LEFT JOIN `nombers` ON `advances`.`no`=`nombers`.`pno` WHERE `year`='$year' AND `month`='$month' GROUP BY `no` ORDER BY `no`";
$razem=0;
if ($db->Query($q)) 
  {
    while ($row=$db->Row())
    {
	echo "  <tr>
    <td CLASS='DataTD'>$row->no</td>
    <td CLASS='DataTD'>$row->firstname</td>
    <td CLASS='DataTD'>$row->surname</td>
    <td CLASS='DataTD'>$row->knownas</td>
    <td CLASS='DataTD'>£ $row->totaltopay</td>
         </tr>";
	$TotalAdvances=$TotalAdvances + $row->totaltopay;
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
<tr>
<td colspan=4 CLASS='DataTD'><B>TOTAL</B></td>
<td CLASS='DataTD'><B>£ $TotalAdvances</B></td>
         </tr>
</table>

</td></tr>
</table>";
include_once("./footer.php");

?>
