<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$title="Add banking";
$dataakt=date("d/m/Y H:i:s");
$msgdb = new CMySQL;
uprstr($PU,90);

/*$nr=$_GET['cln'];
list($day, $month, $year) = explode("/",$_GET['startd']);
$dod = "$year-$month-$day";
list($day1, $month1, $year1) = explode("/",$_GET['endd']);
$ddo= "$year1-$month1-$day1";
$sd=$_GET['startd'];
$ed=$_GET['endd'];
*/

if(!isset($state))
{
echo "<font class='FormHeaderFont'>$title</font>
	<form action='$PHP_SELF' method='post' name='ed_godz'>
	<table WIDTH=500 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >
		 <tr>
		    <td class='FieldCaptionTD'><B>Day</B></td>
		     <td class='DataTD'><INPUT TYPE='text' NAME='date1' VALUE='$dzis2'></td>
			</tr>
		</TABLE>
	<table WIDTH=500 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >
		 <tr>
		    <td class='FieldCaptionTD'><B>Shop</B></td>
		     <td class='FieldCaptionTD'><B>Banking</B></td>
		</tr>";
		$licz=0;
		if (!$db->Open()) $db->Kill();
		$q = "SELECT `ssdepartments`.`dep_id`, `ssdepartments`.`name` FROM `ssdepartments` WHERE `ssdepartments`. `show`='y' ORDER BY `ssdepartments`.`name`";
		if ($db->Query($q)) 
		{
			while ($row=$db->Row())
			{
				$licz++;
				echo " <tr>
				<td class='DataTD'>$row->name ($row->dep_id) <input type='Hidden' maxlength='8' name='_id[$licz]' size='6' value='$row->dep_id'></td>
				<td class='DataTD'><INPUT TYPE='checkbox' NAME='ins[$licz]'></td>
						


				</TR>";
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
list($day, $month, $year) = explode("/",$_POST['date1']);
$date1 = "$year-$month-$day";

$db = new CMySQL;

	 for ($i = 0; $i <= $licznik+1; $i++) {
		if(isset($ins[$i])) {
		if($ins[$i]=="on"){
			echo "$_id[$i] , $ins[$i] ";
			if (!$db->Open())$db->Kill();
			$ins[$i] = "INSERT INTO `ssbankingday` ( `id` , `date1` , `shop` , `banking` )
					VALUES (NULL , '$date1', '$_id[$i]', 'y');";
			if (!$db->Query($ins[$i])) $db->Kill();

			loguj("ssbankingday", "new bankings", "ss_nbank");
		}
		}
     }

 echo "<script language='javascript'>window.location=\"ss_dayb.php\"</script>";
}
?>