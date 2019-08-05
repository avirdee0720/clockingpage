<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$cln=$_GET['cln'];
$title="Edit Regular days of NO <B>$cln</B>";
uprstr($PU,90);

(!isset($_GET["state"])) ? $state = "0" : $state = $_GET["state"];
(!isset($_GET["mon"])) ? $mon = 0 : $mon = $_GET["mon"];
(!isset($_GET["MondayShop"])) ? $MondayShop = "" : $MondayShop = $_GET["MondayShop"];
(!isset($_GET["tue"])) ? $tue = 0 : $tue = $_GET["tue"];
(!isset($_GET["TuesdayShop"])) ? $TuesdayShop = "" : $TuesdayShop = $_GET["TuesdayShop"];
(!isset($_GET["wed"])) ? $wed = 0 : $wed = $_GET["wed"];
(!isset($_GET["WednesdayShop"])) ? $WednesdayShop = "" : $WednesdayShop = $_GET["WednesdayShop"];
(!isset($_GET["thu"])) ? $thu = 0 : $thu = $_GET["thu"];
(!isset($_GET["ThursdayShop"])) ? $ThursdayShop = "" : $ThursdayShop = $_GET["ThursdayShop"];
(!isset($_GET["fri"])) ? $fri = 0 : $fri = $_GET["fri"];
(!isset($_GET["FridayShop"])) ? $FridayShop = "" : $FridayShop = $_GET["FridayShop"];
(!isset($_GET["sat"])) ? $sat = 0 : $sat = $_GET["sat"];
(!isset($_GET["SaturdayShop"])) ? $SaturdayShop = "" : $SaturdayShop = $_GET["SaturdayShop"];
(!isset($_GET["sun"])) ? $sun = 0 : $sun = $_GET["sun"];
(!isset($_GET["SundayShop"])) ? $SundayShop = "" : $SundayShop = $_GET["SundayShop"];
(!isset($_GET["date1"])) ? $date1 = "" : $date1 = $_GET["date1"];
if (!isset($DeleteInDay)) $DeleteInDay = "";
if (!isset($ins)) $ins = "";

function DisplShop() {
	$dbShop = new CMySQL;
	$ShopSQL = "SELECT `IP`,MIN(`namefb`) AS ipname FROM `ipaddress` GROUP BY `namefb` ORDER BY `namefb`";
	$ShopList = "<option value='0'> NOT SET </option>";
     if (!$dbShop->Open()) $dbShop->Kill();
	if ($dbShop->Query($ShopSQL)) 
	{
		while ($ShopRecord=$dbShop->Row())
		{

          $ShopList =  $ShopList."<option value='$ShopRecord->IP'> $ShopRecord->ipname</option>";
		}
	} else {
		echo "error in shops!";  $dbShop->Kill(); 
	}
return $ShopList;

}

if ($state == 0)
{
echo "<font class='FormHeaderFont'>$title</font><BR>
        <form action='$PHP_SELF' method='get' name='ed_godz'>
	<table bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >
		 <tr>
		    <td class='FieldCaptionTD'><B>Day</B></td>
		     <td class='FieldCaptionTD'><B>Shop</B></td>
		</tr>
		 <tr>
		    <td class='DataTD'><INPUT TYPE='checkbox' NAME='mon'>Monday</td>
		     <td class='DataTD'><select class='Select' name='MondayShop'>".DisplShop()." </select></td>
		</tr>
		 <tr>
		    <td class='DataTD'><INPUT TYPE='checkbox' NAME='tue'>Tuesday</td>
		     <td class='DataTD'><select class='Select' name='TuesdayShop'>".DisplShop()." </select></td>
		</tr>
			 <tr>
		    <td class='DataTD'><INPUT TYPE='checkbox' NAME='wed'>Wednesday</td>
		     <td class='DataTD'><select class='Select' name='WednesdayShop'>".DisplShop()." </select></td>
		</tr>
		 <tr>
		    <td class='DataTD'><INPUT TYPE='checkbox' NAME='thu'>Thursday</td>
		     <td class='DataTD'><select class='Select' name='ThursdayShop'>".DisplShop()." </select></td>
		</tr>

		 <tr>
		    <td class='DataTD'><INPUT TYPE='checkbox' NAME='fri'>Friday</td>
		     <td class='DataTD'><select class='Select' name='FridayShop'>".DisplShop()." </select></td>
		</tr>

		 <tr>
		    <td class='DataTD'><INPUT TYPE='checkbox' NAME='sat'>Saturday</td>
		     <td class='DataTD'><select class='Select' name='SaturdayShop'>".DisplShop()." </select></td>
		</tr>
		 <tr>
		    <td class='DataTD'><INPUT TYPE='checkbox' NAME='sun'>Sunday</td>
		     <td class='DataTD'><select class='Select' name='SundayShop'>".DisplShop()." </select></td>
		</tr>
		 <tr>
		    <td class='DataTD'>Date from:&nbsp;<INPUT TYPE='text' NAME='date1' VALUE='$dzis'></td>
		     <td class='DataTD'>&nbsp;</td>
		</tr>		

		 </table>
			<input name='cln' type='hidden' value='$cln'>
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

$db = new CMySQL;

if( $mon !== 0 ) $mon = 1;
if( $tue !== 0 ) $tue = 1;
if( $wed !== 0 ) $wed = 1;
if( $thu !== 0 ) $thu = 1;
if( $fri !== 0 ) $fri = 1;
if( $sat !== 0 ) $sat = 1;
if( $sun !== 0 ) $sun = 1;


if (!$db->Open()) $db->Kill();
$DeleteInDay = "UPDATE `regdays` SET `active` = 'n' WHERE `no`= '$cln'";
if (!$db->Query($DeleteInDay)) $db->Kill();

if (!$db->Open()) $db->Kill();
$ins = "INSERT INTO `regdays` (`id` , `no` , `mon` , `shopmon` , `tue` , `shoptue` , `wed` , `shopwed` , `thu` , `shopthu` , `fri` , `shopfri` , `sat` , `shopsat` , `sun` , `shopsun`,`datechange` )VALUES (null, '$cln', '$mon', '$MondayShop', '$tue', '$TuesdayShop', '$wed', '$WednesdayShop', '$thu', '$ThursdayShop', '$fri', '$FridayShop', '$sat', '$SaturdayShop', '$sun', '$SundayShop', '$date1' )";
if (!$db->Query($ins)) $db->Kill();

			//loguj("ssbankingday", "edit bankings - on:$_id[$i] / $date1  ", "ss_ebank");

  echo "<script language='javascript'>window.location=\"hr_data.php?cln=$cln\"</script>";


}
?>