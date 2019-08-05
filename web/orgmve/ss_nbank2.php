<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$db1 = new CMySQL;
$title="New banking";
$dataakt=date("d/m/Y H:i:s");
$msgdb = new CMySQL;
uprstr($PU,90);

$shopid = $_GET['shopid'];

$datab=$_GET['data'];
list($year1, $month1, $day1) = explode("/",$_GET['data']);
$DayOfBanking = "$year1-$month1-$day1";
unset($day1);
unset($month1);
unset($year1);

		if (!$db1->Open()) $db1->Kill();
		$q1 = "SELECT `ssdepartments`.`dep_id`, `ssdepartments`.`name` FROM `ssdepartments` WHERE `ssdepartments`.`dep_id` = '$shopid' ORDER BY `ssdepartments`.`name` LIMIT 1";
		if (!$db1->Query($q1)) $db1->Kill();
		$row1=$db1->Row();
		$shopname = $row1->name;

if(!isset($state))
{
echo "<font class='FormHeaderFont'>$title - $datab <BR> Shop: $shopname</font><BR><BR>
	<form action='$PHP_SELF' method='post' name='ed_godz'>
<INPUT TYPE='hidden' NAME='date1' VALUE='$datab'>
	<table bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >
		 <tr>
		    <td class='FieldCaptionTD'>&nbsp;</td>
		     <td class='FieldCaptionTD'>How Many notes</td>
		     <td class='FieldCaptionTD'>Amount</td>
		</tr>
		<tr>
		    <td class='FieldCaptionTD'>CHEQUES</td>
		     <td class='FieldCaptionTD'><input tabindex=\"1\" class='Input' maxlength='10' name='CHEQUES' value='0'></td>
		</tr>
		 <tr>
		    <td class='FieldCaptionTD'>£ 50</td>
		     <td class='FieldCaptionTD'><input tabindex=\"2\" class='Input' 
				onChange=\"this.form.p50.value=(this.value * 50); this.form.cash.value=(this.value * 50) + (this.form.p20.value * 1) + (this.form.p10.value * 1) + (this.form.p5.value * 1) + (this.form.p1.value * 1);\" maxlength='3' name='1p50' value=''></td>
		     <td class='FieldCaptionTD'><input class='Input' maxlength='10' name='p50' value=''></td>
		</tr>
		<tr>
		    <td class='FieldCaptionTD'>£ 20</td>
		     <td class='FieldCaptionTD'><input tabindex=\"3\" class='Input' onChange=\"this.form.p20.value=(this.value * 20); this.form.cash.value = (this.value * 1) + (this.form.p50.value * 1) + (this.form.p10.value * 1) + (this.form.p5.value * 1) + (this.form.p1.value * 1);\" maxlength='10' name='1p20' value=''></td>
		     <td class='FieldCaptionTD'><input class='Input' maxlength='10' name='p20' value=''></td>
		</tr>
		<tr>
		    <td class='FieldCaptionTD'>£ 10</td>
		     <td class='FieldCaptionTD'><input tabindex=\"4\" class='Input' onChange=\"this.form.p10.value=(this.value * 10); this.form.cash.value = (this.form.p50.value * 1) + (this.form.p20.value * 1) + (this.value * 1) + (this.form.p5.value * 1) + (this.form.p1.value * 1);\" maxlength='10' name='1p10' value=''></td>
		     <td class='FieldCaptionTD'><input class='Input' maxlength='10' name='p10' value=''></td>
		</tr>
		<tr>
		    <td class='FieldCaptionTD'>£ 5</td>
		     <td class='FieldCaptionTD'><input tabindex=\"5\" class='Input' onChange=\"this.form.p5.value=(this.value * 5); this.form.cash.value=(this.value * 1) + (this.form.p50.value * 1) + (this.form.p20.value * 1) + (this.form.p10.value  * 1) + (this.form.p1.value * 1);\" maxlength='10' name='1p5' value=''></td>
		     <td class='FieldCaptionTD'><input class='Input' maxlength='10' name='p5' value=''></td>
		</tr>
		<tr>
		    <td class='FieldCaptionTD'>£ 1</td>
		     <td class='FieldCaptionTD'><input tabindex=\"6\" class='Input' onChange=\"this.form.p1.value=(this.value * 1); this.form.cash.value = (this.value * 1) + (this.form.p50.value * 1) + (this.form.p20.value * 1) + (this.form.p10.value * 1) + (this.form.p5.value * 1);\" maxlength='10' name='1p1' value=''></td>
		     <td class='FieldCaptionTD'><input class='Input' maxlength='10' name='p1' value=''></td>
		</tr>

		<tr>
		    <td class='FieldCaptionTD'>TOTAL £</td>
		     <td class='FieldCaptionTD'><input class='Input' maxlength='10' name='cash' value='0'></td>
		</tr>
	</table>
			<input name='licznik' type='hidden' value='$licz'>
			<input name='state' type='hidden' value='1'><BR><BR>
			<input tabindex=\"7\" class='Button' name='Update' type='submit' value='$SAVEBTN'>
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
			//$ins[$i] = "INSERT INTO `ssbankingday` ( `id` , `date1` , `shop` , `banking` )
			//		VALUES (NULL , '$date1', '$_id[$i]', 'y');";
			if (!$db->Query($ins[$i])) $db->Kill();

			loguj("ssbankingday", "edit bankings - on:$_id[$i] / $date1  ", "ss_ebank");
		}
		}
     }

 echo "<script language='javascript'>window.location=\"ss_dayb.php\"</script>";
}
?>