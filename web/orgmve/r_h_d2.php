<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
uprstr($PU,90);
$dataakt=date("d/m/Y H:i:s");
$msgdb = new CMySQL;

if (!isset($_GET['month'])) $month = 0; else $month = $_GET['month'];
if (!isset($_GET['year'])) $year = 0; else $year = $_GET['year'];

$dod = "$year-$month-01";
$ddo= "$year-$month-31";
$firstDayYear= "$year-01-01";

echo "
<font class='FormHeaderFont'>Holliday</font>
<BR>
<table WIDTH=500 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >
 
";

$db = new CMySQL;
$db2 = new CMySQL;
$db3 = new CMySQL;
$db4 = new CMySQL;
$db5 = new CMySQL;

if (!$db->Open()) $db->Kill();
$q = "SELECT SUM(`daypart`) AS w, no
      FROM `holidays`
      WHERE `holidays`.`date1` >= '$dod' AND `holidays`.`date1` <= '$ddo'
      GROUP BY `holidays`.`no`";

$razem=0;
if ($db->Query($q)) 
  {
    while ($row=$db->Row())
    {
		if (!$db2->Open()) $db2->Kill();
		$q2 = "SELECT * FROM `holidays` WHERE `holidays`.`date1`>='$dod' AND `holidays`.`date1`<='$ddo' AND `no`='$row->no' ORDER BY `holidays`.`date1`";
		if (!$db2->Query($q2)) $db2->Kill();
$cln = $row->no;
		if (!$db3->Open()) $db3->Kill();
		$q3 = "SELECT `firstname`,`surname`,`cat` FROM `nombers` WHERE `pno`='$row->no' ";
		if (!$db3->Query($q3)) $db3->Kill();
		$row3=$db3->Row();
		if($row3->cat == "c" ) { $colour='#FF0000'; $dupa="(CASUAL)"; }
		else  { $colour=''; $dupa="";  }
                $taken = round($row->w, 1);
echo "<table WIDTH=500 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >
			<tr>    <td class='FieldCaptionTD' colspan='4'><FONT COLOR=$colour>
			<A HREF='hollid1.php?cln=$row->no'><B>$row->no</B></A>	
			
				
			&nbsp;$row3->firstname $row3->surname has taken <B>$taken</B> days off $dupa</FONT></td>
			  </tr>   ";
			// counting is going to be here ! 

		
     		while ($row2=$db2->Row())
			{
			$FreeDay = $row2->date1;
			$LeaveType = $row2->sortof;
			$HourGiv = $row2->hourgiven;
			
			//$DateHP=date("w", $row2->date1);
			//$DateHP=date("w",strtotime($row2->date1));	
			//$DateHP1=date("W",strtotime($row2->date1));	
			//$PrevWeek=$DateHP1-1;


			echo " <tr>	
			 <td class='DataTD'>&nbsp;&nbsp;</td>
			 <td class='DataTD'><B>$FreeDay</B></td>
			 <td class='DataTD'>$LeaveType</td>
			<td class='DataTD'>$HourGiv </td> ";
			

			}

  echo "</TABLE>";
 if($row->sortof = "PL") $razemPL++;
 else $razemUPL++;
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
