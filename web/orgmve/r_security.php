<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$db1 = new CMySQL;
$db2 = new CMySQL;
$db3 = new CMySQL;
$tytul='Security guards - monthly<BR>';
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
<A HREF='r_security.php?month=01'>1</a>
<A HREF='r_security.php?month=02'>2</a>
<A HREF='r_security.php?month=03'>3</a>
<A HREF='r_security.php?month=04'>4</a>
<A HREF='r_security.php?month=05'>5</a>
<A HREF='r_security.php?month=06'>6</a>
<A HREF='r_security.php?month=07'>7</a>
<A HREF='r_security.php?month=08'>8</a>
<A HREF='r_security.php?month=09'>9</a>
<A HREF='r_security.php?month=10'>10</a>
<A HREF='r_security.php?month=11'>11</a>
<A HREF='r_security.php?month=12'>12</a>

</font>&nbsp;&nbsp;&nbsp;&nbsp;

<BR>


<table border='0' cellpadding='3' cellspacing='1' CLASS='FormTABLE'>
";

if (!$db->Open()) $db->Kill();
$q = "SELECT DATE_FORMAT(`ssdays`.`date1`, \"%d \") as d1, DATE_FORMAT(`ssdays`.`date1`, \"%W \") as d2 FROM `ssdays` WHERE `date1` LIKE '$Year-$month-%'";
echo " <tr><td CLASS='DataTD10'>&nbsp;</td>";
  if ($db->Query($q)) 
  {
    while ($row=$db->Row())
    {
     if ($row->d2 == "Sunday") { echo "<td class='niedziela'>$row->d1 ".substr($row->d2,0,3)."</td>"; }
	 elseif ($row->d2 == "Saturday") { echo "<td class='sobota'>$row->d1 ".substr($row->d2,0,3)."</td>"; }
	 else { echo "<td class='DataTD10'>$row->d1 ".substr($row->d2,0,3)."</td>"; }   

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
		$q1 = "SELECT `ID`, `pno`, `firstname`, `surname`, `knownas`, `status` FROM `nombers` WHERE `status` LIKE 'OK' AND `secutitybonus` <> 0 ORDER BY `knownas`";
		echo " <tr>";
		if ($db1->Query($q1)) 
		{
			while ($row1=$db1->Row())
			{
				echo "<td CLASS='DataTD10'>$row1->knownas $row1->surname</td>";
				$CLNNO=$row1->pno;

				if (!$db3->Open()) $db3->Kill();
				$sqlx = "SELECT `ssdays`.`date1` FROM `ssdays` WHERE `date1` LIKE '$Year-$month-%' ORDER BY `date1`";
				if (!$db3->Query($sqlx)) $db3->Kill();
				while ($rowX=$db3->Row())
				{
					$dataIN=$rowX->date1;

				     if (!$db2->Open()) $db2->Kill();
				     $q2 = "SELECT MIN(`intime`) AS t FROM `inout` WHERE `date1` ='$dataIN' AND `no`='$CLNNO' GROUP BY `date1`";
				     //echo " ";
				     if (!$db2->Query($q2))  $db2->Kill();
					 $row2=$db2->Row();
					 if(isset($row2->t))	$pokaz="<td CLASS='DataTD10'>".substr($row2->t,0,5)."</td>";
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
