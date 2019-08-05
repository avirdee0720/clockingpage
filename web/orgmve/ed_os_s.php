<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$tytul='Update emploees SHOP';
uprstr($PU,90);

(!isset($_POST['state'])) ? $state = 0 : $state = $_POST['state'];
(!isset($_POST['lp'])) ? $lp = $_GET['lp'] : $lp = $_POST['lp'];
(!isset($_POST['ipadrreal'])) ? $ipadrreal = "0.0.0.0" : $ipadrreal = $_POST['ipadrreal'];

if($state==0)
{
echo "	<TD ALIGN=JUSTIFY VALIGN=TOP border=0>
	<table width='100%' border=0><tr><td>
<center>
<form action='$PHP_SELF' method='post' name='ed_czl'>
  <font class='FormHeaderFont'>$tytul</font>
  <table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>";


// if (!$db->Open()) $db->Kill();
//  $q = "SELECT MAX(pno) AS pnox FROM nombers";
// if (!$db->Query($q)) $db->Kill();
//  $no=$db->Row();

 if (!$db->Open()) $db->Kill();
 if(isset($lp)){
  $q = "SELECT `nombers`.`ID`, `nombers`.`pno`, `nombers`.`surname`, `nombers`.`firstname`, `nombers`.`knownas`, `nombers`.`ipadr`,  `ipaddress`.`namefb` FROM `nombers` LEFT JOIN `ipaddress` ON `nombers`.`ipadr`=`ipaddress`.`IP` WHERE `nombers`.`pno`='$lp' LIMIT 1";  
  } else { 
  echo "<BR><BR><CENTER><H1>Error in $PHP_SELF</H1></CENTER><BR><BR>";
  exit;
 }
  if (!$db->Query($q)) $db->Kill();
  
    while ($row=$db->Row())
    {
    echo "
    <tr>
      <td class='FieldCaptionTD'>Clocking in number</td><td class='DataTD'><FONT COLOR='#000099'><B>$row->pno</B></FONT></td>
	  <td class='FieldCaptionTD'>Known as</td><td class='DataTD'>$row->knownas</td>
    </tr>
    <tr>
      <td class='FieldCaptionTD'>First name</td><td class='DataTD'>$row->firstname</td>
      <td class='FieldCaptionTD'>Surname</td><td class='DataTD'>$row->surname</td>
    </tr>   
   </table><BR>";
 // header ends here----------------------------------------------------------------------edit starts

echo "
<table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
    <tr >
      <td class='FieldCaptionTD'>SHOP is now</td>
	  <td class='DataTD'><input class='Input' size='12' maxlength='12' name='ipadr' value='$row->namefb'></td>

<td class='FieldCaptionTD'>will be</td>
	  <td class='DataTD'><select class='Select' name='ipadrreal'>
		<option selected value='$row->ipadr'>$row->namefb</option>";
		  $q = "SELECT `IP`,MIN(`namefb`) AS ipname FROM `ipaddress` GROUP BY `namefb` ORDER BY `namefb`";

     if (!$db->Open()) $db->Kill();
  if ($db->Query($q)) 
  {
    while ($r=$db->Row())
    {

          echo "<option value='$r->IP'> $r->ipname</option>";
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


<input name='lp' type='hidden' value='$row->ID'>";

  }

// przyciski i stopka ------------------------------------------------------------------------------
echo "  <table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
            <tr> <td align='right' colspan='2'>
		    
		    <input name='state' type='hidden' value='1'>
			<input class='Button' name='Update' type='submit' value='$SAVEBTN'>
			<input class='Button'  type='Button' onclick='window.location=\"t_lista.php\"' value='$LISTBTN'></td>
	        </td>  </tr>
 
</form>
</center>
<BR>
</td></tr>
</table>";
include_once("./footer.php");
}
elseif($state==1)
{
	if (!$db->Open()) $db->Kill();
	$query = ("UPDATE `nombers` SET `ipadr`='$ipadrreal' WHERE `ID` = '$lp' LIMIT 1") ;
    if (!$db->Query($query)) $db->Kill();
    echo "<script language='javascript'>window.location=\"t_lista.php\"</script>";
} //fi state=1
else
{
 echo "Error1";
} //else state
?>