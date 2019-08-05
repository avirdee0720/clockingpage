<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$db2 = new CMySQL;
$title='MVE security consolidation/delivery scenario debriefing sheet (banking) CFG<BR>';
$dataakt=date("d/m/Y H:i:s");
$msgdb = new CMySQL;
uprstr($PU,90);


if(!isset($state))
{
echo "<font class='FormHeaderFont'>$title </font><BR>
	<form action='$PHP_SELF' method='post' name='xx'>

	<table WIDTH=500 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >
		 <tr>
		    <td class='FieldCaptionTD'><B>Shop, till / ID dep</B></td>
		     <td class='FieldCaptionTD'><B>Show on list</B></td>
		</tr>";
		$licz=0;
		if (!$db->Open()) $db->Kill();
		$q = "SELECT `ssdepartments`.`dep_id`, `ssdepartments`.`name`, `ssdepartments`.`show` FROM `ssdepartments` ORDER BY `ssdepartments`.`name`";
		
		
		if ($db->Query($q)) 
		{
			while ($row=$db->Row())
			{


				if($row->show == "y") { $cojest="checked"; }
				else { $cojest=""; }

				$licz++;
				echo " <tr>
				<td class='DataTD'>$row->name ($row->dep_id) <input type='Hidden' maxlength='8' name='_id[$licz]' size='6' value='$row->dep_id'></td>
				<td class='DataTD'><INPUT TYPE='checkbox' NAME='ins[$licz]' $cojest> </td></TR>";
				$db2->Free();
			}
		}

echo "
</table>
			<input name='licznik' type='hidden' value='$licz'>
			<input name='state' type='hidden' value='1'>
			<input class='Button' name='Update' type='submit' value='$SAVEBTN'>
		</td>
</center>
</center>
<BR>
</FORM>
</td></tr>
</table>";


include_once("./footer.php");
}
elseif($state==1)
{
$date1=$_POST['date1'];
//list($day, $month, $year) = explode("/",$_POST['date1']);
//$date1 = "$year-$month-$day";

$db = new CMySQL;
$db0 = new CMySQL;
if (!$db->Open()) $db->Kill();
$DeleteInDay = "UPDATE `ssdepartments` SET `show`='n'";
if (!$db->Query($DeleteInDay)) $db->Kill();

	 for ($i = 0; $i <= $licznik+1; $i++) {
		if(isset($ins[$i])) {
		if($ins[$i]=="on"){
			//echo "$_id[$i] , $ins[$i] ";
			if (!$db->Open()) $db->Kill();
			$ins[$i] = "UPDATE `ssdepartments` SET `show`='y' WHERE `dep_id`='$_id[$i]' LIMIT 1";
			if (!$db->Query($ins[$i])) $db->Kill();

			loguj("SSdepartaments", "CFG DEP $_id[$i] ON", "ss_day_cnf");
		}
		}
     }

 echo "<script language='javascript'>window.location=\"ss_dayb.php\"</script>";
}
?>