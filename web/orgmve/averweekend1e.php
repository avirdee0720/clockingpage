<?php
ini_set("display_errors","2");
ERROR_REPORTING(E_ALL);

include_once("./header.php");
$tytul='Average attendance Weekend days (Sat-Sun)<BR>Transitional';
//include("./inc/uprawnienia.php");
include("./config.php");
$PHP_SELF = $_SERVER['PHP_SELF'];

if (!isset($_POST['state'])) $state = 0; else $state = $_POST['state'];
if (!isset($_POST['_grp'])) $_grp = 0; else $_grp = $_POST['_grp'];
if (!isset($_POST['startd'])) $startd = "00/00/0000"; else $startd = $_POST['startd'];
if (!isset($_POST['endd'])) $endd = "00/00/0000"; else $endd = $_POST['endd'];
if (!isset($_POST['showall'])) $showall = "off"; else $showall = $_POST['showall'];

$db = new CMySQL;
if (!$db->Open()) $db->Kill();


if($state==0)

{

$q = "SELECT DATE_FORMAT(DATE_SUB( DATE_SUB( CURDATE( ) , INTERVAL 1 YEAR ) , INTERVAL DAYOFWEEK( CURDATE( ) ) -3
DAY ) , \"%d/%m/%Y\") as startdate,DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL DAYOFWEEK(CURDATE()-1)  DAY), \"%d/%m/%Y\") AS enddate;";

    /*$q = "SELECT
          DATE_FORMAT(DATE_SUB(DATE_SUB(NOW(), INTERVAL 1 YEAR), INTERVAL DAYOFWEEK( CURDATE( ) ) -3
DAY ), \"%d/%m/%Y\") AS startdate,
            DATE_FORMAT(NOW(), \"%d/%m/%Y\") AS enddate";*/
    
     $db->Query($q);
     $r=$db->Row();
     $FirstOfTheMonth=$r->startdate;
     $dzis2=$r->enddate;

echo "	<TD ALIGN=JUSTIFY VALIGN=TOP border=0>
	<table width='100%' border=0><tr><td>

<center>
<form action='$PHP_SELF' method='post' name='ed_czl'>
  <font class='FormHeaderFont'>$tytul</font>
  <table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
  
  <tr>
      <td class='FieldCaptionTD'>Employee category</td>

<td class='DataTD'>   <select class='Select' name='_grp'>
		<option selected value='r'>Regular</option>
    <option value='c'>Casual</option>
    <option value='b'>Buyers</option>
    <option value='nb'>Non-buyers</option>
    <option value='e'>Accounts</option>
    <option value='ga'>GA+Builders</option>
    <option value='gma'>GMA</option>
    <option value='i'>IT</option>
    <option value='a'>All</option>
		   </select>
</td></tr>
  <tr>
      <td class='FieldCaptionTD'>Include not attending</td>

<td class='DataTD'>   <input type='checkbox' name='showall' checked=true/>
</td></tr>

    <tr>
      <td class='FieldCaptionTD'>Start date</td>
      <td class='DataTD'><input class='Input' maxlength='12' name='startd' value='$FirstOfTheMonth'>

      </td>
    </tr>
    <tr>  
      <td class='FieldCaptionTD'>End date</td>
      <td class='DataTD'><input class='Input' maxlength='12' name='endd' value='$dzis2'></td>
    </tr>

   <tr>
      <td align='right' colspan='2'>
		<input name='state' type='hidden' value='1'>

			<input class='Button' name='Update' type='submit' value='$OKBTN'>
			<input class='Button' name='datesfromlastm' onclick='this.form.startd.value=\"$FirstOfLastMonth\";this.form.endd.value=\"$LastOfLastMonth\";' type='button' value='Prev month'>
	</td>
    </tr>
  </table>
</form>
</center>
<BR>
</td></tr>
</table>";
include_once("./footer.php");
}
elseif($state==1)
{

   echo "<script language='javascript'>window.location=\"averweekend1f.php?startd=$startd&endd=$endd&_grp=$_grp&showall=$showall\"</script>";
} //fi state=1
else
{
 echo "<BR><BR><BR>Warning!!!!!<BR><BR><BR>",
	 "Oy! What are you doing? $REMOTE_ADDR <BR>";
} //else state
?>