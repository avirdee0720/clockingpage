<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$db2 = new CMySQL;
$title="Edit banking";
$dataakt=date("d/m/Y H:i:s");
$msgdb = new CMySQL;
uprstr($PU,90);

$datab=$_GET['data'];
list($year1, $month1, $day1) = explode("-",$_GET['data']);
$DayOfBanking = "$day1/$month1/$year1";
unset($day1);
unset($month1);
unset($year1);

if(!isset($state))
{
echo "<font class='FormHeaderFont'>$title - $DayOfBanking</font><BR>
	<form action='$PHP_SELF' method='post' name='ed_godz'>
<INPUT TYPE='hidden' NAME='date1' VALUE='$datab'>
	<table WIDTH=500 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >
		 <tr>
		    <td class='FieldCaptionTD'><B>Shop</B></td>
		     <td class='FieldCaptionTD'><B>Banking</B></td>
		</tr>";
		$licz=0;
		if (!$db->Open()) $db->Kill();
		$q = "SELECT `ssdepartments`.`dep_id`, `ssdepartments`.`name` FROM `ssdepartments` WHERE `ssdepartments`.`show`='y' ORDER BY `ssdepartments`.`name`";
		
		
		if ($db->Query($q)) 
		{
			while ($row=$db->Row())
			{
				if (!$db2->Open()) $db2->Kill();
				$q2 = "SELECT `ssbankingday`.`id`, `ssbankingday`.`date1`, `ssbankingday`.`shop` FROM `ssbankingday` WHERE `ssbankingday`.`shop`='$row->dep_id' AND `ssbankingday`.`date1`='$datab'";
				if (!$db2->Query($q2)) $db2->Kill();

				if($db2->Rows() > 0) { $cojest="checked"; }
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
$DeleteInDay = "DELETE FROM `ssbankingday` WHERE `date1`= '$date1'";
if (!$db->Query($DeleteInDay)) $db->Kill();

	 for ($i = 0; $i <= $licznik+1; $i++) {
		if(isset($ins[$i])) {
		if($ins[$i]=="on"){
			echo "$_id[$i] , $ins[$i] ";
			if (!$db->Open()) $db->Kill();
			$ins[$i] = "INSERT INTO `ssbankingday` ( `id` , `date1` , `shop` , `banking` )
					VALUES (NULL , '$date1', '$_id[$i]', 'y');";
			if (!$db->Query($ins[$i])) $db->Kill();

			loguj("ssbankingday", "edit bankings - on:$_id[$i] / $date1  ", "ss_ebank");
		}
		}
     }

 echo "<script language='javascript'>window.location=\"ss_dayb.php\"</script>";
}
?>