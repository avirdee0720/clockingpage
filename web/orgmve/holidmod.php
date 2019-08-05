<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];

$tytul = "Holiday modification<br>";

if (!isset($_POST['state'])) $state = 0; else $state = $_POST['state'];
if (!isset($_GET['startd'])) $startd = "00/00/0000"; else $startd = $_GET['startd'];
if (!isset($_GET['endd'])) $endd = "00/00/0000"; else $endd = $_GET['endd'];

if($state==0)
{
$db = new CMySQL;
$db2 = new CMySQL;

if (!isset($_GET['yearAct'])) $yearAct = date('Y'); else $yearAct = $_GET['yearAct'];
$candelete=$_GET['candelete'];
$idr=$_GET['lp'];
$datad=$_GET['datad'];
$lp=$_GET['lp'];

//echo $id;
$d1 = strtotime("$datad");
$d2 = strtotime("$FirstOfTheMonth");

echo "	<TD ALIGN=JUSTIFY VALIGN=TOP border=0>
	<table width='100%' border=0><tr><td>

<center>
<!-- BEGIN Record members -->
<form action='$PHP_SELF' method='post' name='ed_czl'>
  <font class='FormHeaderFont'>$tytul</font>
  <table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
";

 if (!$db->Open()) $db->Kill();
 if(isset($lp)){
  $q = "SELECT `holidays`.`id`, `holidays`.`no`, DATE_FORMAT(`holidays`.`date1`, \"%d/%m/%Y\") as d1,`holidays`.daypart,`holidays`.`sortof`, `holidays`.`hourgiven`,`holidays`.`hourgiven2`,`holidays`.`message`, `holidays`.`imp`,`holidays`.`holidaystateid`, `nombers`.`firstname`, `nombers`.`surname`, `nombers`.`knownas` FROM `holidays` JOIN `nombers` ON `holidays`.`no` = `nombers`.`pno` WHERE `holidays`.`id`='$idr' LIMIT 1";
  } else { 
  echo "<BR><BR><CENTER><H1>Error in $PHP_SELF</H1></CENTER><BR><BR>";
  exit;
 }
  if (!$db->Query($q)) $db->Kill();
  
    while ($row=$db->Row())
    {
  echo "
 
  <tr>
      <td class='FieldCaptionTD'>Clocking in number</td>
      <td class='DataTD'><B>$row->no</B></td>
    </tr>
    <tr>
      <td class='FieldCaptionTD'>First name</td>
      <td class='DataTD'>$row->firstname    </td>
    </tr>
    <tr>  
      <td class='FieldCaptionTD'>Surname</td>
      <td class='DataTD'>$row->surname</td>
    </tr>

    <tr>
      <td class='FieldCaptionTD'>Known as</td>
      <td class='DataTD'>$row->knownas</td>
    </tr>
    <tr>
      <td class='FieldCaptionTD'>Horus Given by computer</td>
      <td class='DataTD'>$row->hourgiven2</td>
    </tr>
        <tr>
      <td class='FieldCaptionTD'>Hours Given</td>
      <td class='DataTD'><input class='Input' maxlength='5' name='_hourgiven' size='5' value='$row->hourgiven'></td>
    </tr>
   <tr>
      <td class='FieldCaptionTD'>Part of day</td>
      <td class='DataTD'><input class='Input' maxlength='5' name='_daypart' size='5' value='$row->daypart'></td>
    </tr>
   <tr>
      <td class='FieldCaptionTD'>Message</td>
        <td class='DataTD'><input class='Input' maxlength='250' name='_message' size='60' value='$row->message'></td>
    </tr>
    <tr>
      <td class='FieldCaptionTD'>State</td>
     <td class='DataTD'>";
     $selecttxt = "<select class='Select' name='holidaystate'>";

  $q = "SELECT holidaystateid,holidaystatetxt FROM holidaystatelist ";
  $holidaystateid = $row->holidaystateid;
//	$db = new CMySQL;
  if (!$db2->Open()) $db2->Kill();
  if ($db2->Query($q))
  {
    while ($r=$db2->Row())
    {
		if ($holidaystateid == $r->holidaystateid) 
			$selecttxt .= "<option value='$r->holidaystateid' selected>$r->holidaystatetxt</option>";
		else 
		        $selecttxt .="<option value='$r->holidaystateid'>$r->holidaystatetxt</option>";
    }
	} 
$selecttxt .=  "</select>";

echo " $selecttxt    
     </td>
    </tr>
    <tr>
      <td class='FieldCaptionTD'>Delete?</td>
     <td class='DataTD'><input name='holdel' type='checkbox' id='checkbox' value='1' /></td>
    </tr>
    <tr>
      <td align='right' colspan='2'>
      	<input name='no' type='hidden' value='$row->no'>
		<input name='recid' type='hidden' value='$row->id'>
		<input name='state' type='hidden' value='1'>

<input name='yearAct' type='hidden' value='$yearAct'>
<input name='candelete' type='hidden' value='$candelete'>
<input name='idr' type='hidden' value='$idr'>
<input name='datad' type='hidden' value='$datad'>
";			


} 
echo "
			<input class='Button' name='Update' type='submit' value='$SAVEBTN'>
			<input class='Button'  type='Button' onclick='window.location=\"t_lista.php\"' value='$LISTBTN'></td>
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
if(!isset($_POST['_hourgiven']))$_hourgiven = 0; else $_hourgiven = $_POST['_hourgiven'];
if(!isset($_POST['_daypart']))$_daypart = 0; else $_daypart = $_POST['_daypart'];
if(!isset($_POST['_message']))$_message = ""; else $_message = $_POST['_message'];
if(!isset($_POST['yearAct'])) $yearAct = date('Y'); else $yearAct = $_POST['yearAct'];
if(!isset($_POST['candelete'])) $candelete = ""; else $candelete = $_POST['candelete'];
if(!isset($_POST['idr'])) $idr = 0; else $idr = $_POST['idr'];
if(!isset($_POST['holidaystate'])) $holidaystate = 0; else $holidaystate = $_POST['holidaystate'];
if(!isset($_POST['datad'])) $datad = ""; else $datad = $_POST['datad'];
if(!isset($_POST['holdel'])) $holdel = 0; else $holdel = $_POST['holdel'];
if(!isset($_POST['no'])) $cln = 0; else $cln = $_POST['no'];
    
$d1 = strtotime("$datad");
$d2 = strtotime("$FirstOfTheMonth");

$db = new CMySQL;
	if (!$db->Open()) $db->Kill();
if ($holdel == "1" ) {
$dh ="DELETE FROM `holidays` WHERE `holidays`.`id` = $idr LIMIT 1";
	
		if (!$db->Query($dh)) $db->Kill();
		
		else {
		echo "<script language='javascript'>window.location=\"hollid1.php?cln=$cln&yearAct=$yearAct&startd=$startd&endd=$endd\"</script>";
		
    exit;
    } 
    }
elseif(isset($datad)) 
{
	//if($candelete=="YES") 
	//{
	   if ($_daypart <= 356) {
		if (!$db->Open()) $db->Kill();
		$dh ="UPDATE `holidays` SET `hourgiven` = '$_hourgiven', `daypart`='$_daypart',  `message`='$_message', holidaystateid='$holidaystate' WHERE `id`='$idr' LIMIT 1";
	
		if (!$db->Query($dh)) $db->Kill();
		}
		else {
		echo "<script language='javascript'>window.location=\"holidmod.php?message=1&lp=$idr&datad=$datad&candelete=$candelete&skrypt=hollid1.php?cln=$cln&yearAct=$yearAct&startd=$startd&endd=$endd\"</script>";
    exit;
    }
 
	//} else {
	//echo "<BR>You can not EDIT this record !"; exit;}
} else {
echo "<BR>You can not edit ! DATAD NOT SET ??"; exit;
}
echo "<script language='javascript'>window.location=\"hollid1.php?cln=$cln&yearAct=$yearAct\"</script>";

} //end of the sec ond loop
?>
