<?php
ini_set("display_errors","2");
ERROR_REPORTING(E_ALL);

include_once("./header.php");
$tytul='Pre One Year Staff<BR>';
//include("./inc/uprawnienia.php");
include("./config.php");
$PHP_SELF = $_SERVER['PHP_SELF'];

$date1 = date("Y-m-d");

$db = new CMySQL;
if (!$db->Open()) $db->Kill();
 

$do=$_GET['do'];
if (!isset($_POST['state'])) $state = 0; else $state = $_POST['state'];

if ($do == "new") {

if($state==0)
{
echo "	<TD ALIGN=JUSTIFY VALIGN=TOP border=0>
	<table width='100%' border=0><tr><td>

<center>
<form action='$PHP_SELF?do=new' method='post' name='ed_czl'>
  <font class='FormHeaderFont'>$tytul New report</font>
  <table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
  
  <tr>
      <td class='FieldCaptionTD'>New Report name</td>

<td class='DataTD'>   <input class='Input' size='50' maxlength='255' name='_newreportname'>
</td></tr>
<tr>
      <td align='right' colspan='2'>
		<input name='state' type='hidden' value='1'>
			<input class='Button' name='Update' type='submit' value='$OKBTN'>
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

$newreportname=$_POST['_newreportname'];
$newreportname= $db->Fix($newreportname);
  
$sql = "INSERT INTO staffreport 
				(`title`,`date1`,`state`) 
				VALUES 
				('$newreportname','$date1','1')";
if (!$db->Query($sql))  $db->Kill();
echo "<script language='javascript'>window.location=\"hr_extra_report.php\"</script>";
}  

} /// End report  name
elseif ($do == "edit") {

if($state==0)
{

echo "	<TD ALIGN=JUSTIFY VALIGN=TOP border=0>
	<table width='100%' border=0><tr><td>

<center>
<form action='$PHP_SELF?do=edit' method='post' name='ed_czl'>
  <font class='FormHeaderFont'>$tytul Change name of reports</font>
  <table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>   

 <tr> 
      <td class='FieldCaptionTD'>Report:</td>
<td class='DataTD'>   <select class='Select' name='_report'>
<option value='edit'>Choose one report</option>\n";

		  $q = "SELECT DISTINCT  `id`,`title`,`state` FROM `staffreport` Where `state`='1' Order by `date1`";

	
  if ($db->Query($q)) 
  {
    while ($r=$db->Row())
    {

          echo "<option value='$r->id'>$r->title</option>\n";
    }
	} else {
echo " 
  <tr>
    <td class='DataTD'></td>
    <td class='DataTD' colspan='3'>SQL Error 1a</td>
  </tr>";
 $db->Kill();
}
echo " </select>
</td></tr>";

  
echo "
 <tr> 
      <td class='FieldCaptionTD'>New name</td>
<td class='DataTD'>   <input class='Input' size='50' maxlength='255' name='_newname'>
</td></tr>

<tr>
      <td align='right' colspan='2'>
		<input name='state' type='hidden' value='1'>
			<input class='Button' name='Update' type='submit' value='$OKBTN'>
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

$reportid=$_POST['_report'];
$newname=$db->Fix($_POST['_newname']);
if ($reportid!="edit" &&  $newname!="") {
$sql ="UPDATE `staffreport` SET `staffreport`.`title`= '$newname' 
       Where `id`='$reportid'
        LIMIT 1";
if (!$db->Query($sql))  $db->Kill();
echo "<script language='javascript'>window.location=\"hr_extra_report.php\"</script>";
}  
else   echo "<script language='javascript'>window.location=\"hr_extra_report.php\"</script>";

}


}   // end edit report

elseif ($do == "del") {

if($state==0)
{

echo "	<TD ALIGN=JUSTIFY VALIGN=TOP border=0>
	<table width='100%' border=0><tr><td>

<center>
<form action='$PHP_SELF?do=del' method='post' name='ed_czl'>
  <font class='FormHeaderFont'>$tytul Delete report</font>
  <table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>   

 <tr> 
      <td class='FieldCaptionTD'>Report:</td>
<td class='DataTD'>   <select class='Select' name='_report'>
<option value='edit'>Choose one report</option>\n";

		  $q = "SELECT DISTINCT  `id`,`title`,`state` FROM `staffreport` Where `state`='1' Order by `date1`";

	
  if ($db->Query($q)) 
  {
    while ($r=$db->Row())
    {

          echo "<option value='$r->id'>$r->title</option>\n";
    }
	} else {
echo " 
  <tr>
    <td class='DataTD'></td>
    <td class='DataTD' colspan='3'>SQL Error 1a</td>
  </tr>";
 $db->Kill();
}
echo " </select>
</td></tr>";

  
echo "
 
<tr>
      <td align='right' colspan='2'>
		<input name='state' type='hidden' value='1'>
			<input class='Button' name='Update' type='submit' value='$OKBTN'>
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

$reportid=$_POST['_report'];

if ($reportid!="edit") {

$sql ="DELETE FROM `staffreport` 
       Where `id`='$reportid'
       Limit 1";
if (!$db->Query($sql))  $db->Kill();

$sql ="DELETE FROM `staffreport_text` 
       Where `staffreportid`='$reportid'";
if (!$db->Query($sql))  $db->Kill();

$sql ="OPTIMIZE TABLE `staffreport`";
if (!$db->Query($sql))  $db->Kill();
$sql ="OPTIMIZE TABLE `staffreport_text`";
if (!$db->Query($sql))  $db->Kill();

echo "<script language='javascript'>window.location=\"hr_extra_report.php\"</script>";

}  

}





}   // end delete report


     

?>