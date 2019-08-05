<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$db1 = new CMySQL;
$db2 = new CMySQL;
$db3 = new CMySQL;
$tytul='MVE daily banking<BR>';
error_reporting(E_ALL);

uprstr($PU,50);

if (empty($_GET["month"])) {
    $month=date("m");
} else {
    $month=$_GET["month"];
}

echo "  <TD ALIGN=JUSTIFY VALIGN=TOP border=0>

<center>


<font CLASS='FormHeaderFont'>$tytul&nbsp;&nbsp;   &nbsp;&nbsp;
<font size='+2' colour='#0000FF'>Month:<big><b> <u>$month / $Year</u></b> </big></font>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<A HREF='ss_b_browse.php?month=01'>1</a>
<A HREF='ss_b_browse.php?month=02'>2</a>
<A HREF='ss_b_browse.php?month=03'>3</a>
<A HREF='ss_b_browse.php?month=04'>4</a>
<A HREF='ss_b_browse.php?month=05'>5</a>
<A HREF='ss_b_browse.php?month=06'>6</a>
<A HREF='ss_b_browse.php?month=07'>7</a>
<A HREF='ss_b_browse.php?month=08'>8</a>
<A HREF='ss_b_browse.php?month=09'>9</a>
<A HREF='ss_b_browse.php?month=10'>10</a>
<A HREF='ss_b_browse.php?month=11'>11</a>
<A HREF='ss_b_browse.php?month=12'>12</a>

</font>&nbsp;&nbsp;&nbsp;&nbsp;
<input CLASS='Button'  type='Button' onclick='window.location=\"ss_nbank1.php\"' value='New banking'>
<BR>


<table border='0' cellpadding='3' cellspacing='1' CLASS='FormTABLE'>
";

if (!$db->Open()) $db->Kill();
$q = "SELECT DATE_FORMAT(`ssdays`.`date1`, \"%d \") as d1 FROM `ssdays` WHERE `date1` LIKE '$Year-$month-%'";
echo " <tr><td CLASS='DataTD10'>&nbsp;</td>";
  if ($db->Query($q)) 
  {
    while ($row=$db->Row())
    {
     echo "<td CLASS='DataTD10'>$row->d1</td>";
    

	} 
} else {
echo " 
  <tr>
    <td CLASS='DataTD'></td>
    <td CLASS='DataTD' colspan='3'>Brak dzialow</td>
  </tr>";
 $db->Kill();
}
echo "</tr>";

		if (!$db1->Open()) $db1->Kill();
		$q1 = "SELECT `ssdepartments`.`dep_id`, `ssdepartments`.`name` FROM `ssdepartments` WHERE `ssdepartments`.`show`='y' ORDER BY `ssdepartments`.`name`";
		echo " <tr>";
		if ($db1->Query($q1)) 
		{
			while ($row1=$db1->Row())
			{
				echo "<td CLASS='DataTD10'>$row1->name ($row1->dep_id)</td>";
				$Depatrtament=$row1->dep_id;
				if (!$db3->Open()) $db3->Kill();
				$sqlx = "SELECT `ssdays`.`date1` FROM `ssdays` WHERE `date1` LIKE '$Year-$month-%' ORDER BY `date1`";
				if (!$db3->Query($sqlx)) $db3->Kill();
				while ($rowX=$db3->Row())
				{
					$dataIN=$rowX->date1;
				     if (!$db2->Open()) $db2->Kill();
				     $q2 = "SELECT `ssbankingday`.`date1`, `ssbankingday`.`shop`, `ssbankingday`.`banking`  FROM `ssbankingday` WHERE `ssbankingday`.`date1`='$dataIN' AND `ssbankingday`.`shop`='$Depatrtament'";
				     //echo " ";
				     if (!$db2->Query($q2))  $db2->Kill();
					 $row2=$db2->Row();
					 if(isset($row2->banking))	$pokaz="<td CLASS='DataTD10'><IMG SRC='./images/tickgreen.jpg'  BORDER='0' ALT=''></td>";
					 else $pokaz="<td CLASS='DataTD10'>&nbsp;</td>";
					 echo $pokaz;
    
					

				} // petla db3
				echo "</TR>";
			} //while 1
			
		} //wewnetrzna petla

echo "</table>

</center>
<BR>
</td></tr>
</table>
";
include_once("./footer.php");
?>
