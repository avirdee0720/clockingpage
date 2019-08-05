<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;

$tytul="Buyer's sheet";
$dataakt=date("d/m/Y");
$dataakt2=date("d/m/Y H:i:s");
$date1= date("Y-m-d");

$ipx=$_SERVER['REMOTE_ADDR'];

if(!isset($state))
{



$namehtml = "";
 $q = "SELECT `nombers`.`knownas`, `nombers`.`firstname`, `nombers`.`surname`, `nombers`.`pno`, `buyers_sheet`.id, `buyers_sheet`.title,description FROM `nombers` LEFT JOIN `inout` ON `inout`.`no`=`nombers`.`pno`
INNER JOIN `buyers_sheet` ON buyers_sheet.no= nombers.pno 
WHERE `nombers`.`status`=\"OK\" AND inout.date1='$date1' 
AND DATE(`buyers_sheet`.`date1`)='$date1'
ORDER BY `nombers`.`pno` ASC";
  // GROUP BY `nombers`.`pno` 
  
  // echo $q;
//	$db = new CMySQL;
     if (!$db->Open()) $db->Kill();
  if ($db->Query($q)) 
  {
  $sheetnumber = $db->Rows();
    while ($r=$db->Row())
    {
       if ($sheetnumber > 0) {
          $namehtml.= "<option value='$r->id'>$r->pno: $r->firstname $r->surname - $r->title - $r->description</option>\n";
          }
            
    }
	} else {
echo " 
  <tr>
    <td class='DataTD'></td>
    <td class='DataTD' colspan='3'>SQL Error 1a</td>
  </tr>";
 $db->Kill();
}


/*
$buyers_sheethtml = "";

  $q = "SELECT * FROM `buyers_sheet` INNER JOIN seller ON buyers_sheet.sellerdbid= seller.sellerdbid
  Where DATE(`date1`)='$date1'
  ";

//	$db = new CMySQL;
     if (!$db->Open()) $db->Kill();
  if ($db->Query($q)) 
  {
    while ($r=$db->Row())
    {
          $buyers_sheethtml.= "<option value='$r->id'>$r->title - $r->description</option>\n";
    }
	} else {
echo " 
  <tr>
    <td class='DataTD'></td>
    <td class='DataTD' colspan='3'>SQL Error 1a</td>
  </tr>";
 $db->Kill();
}

*/

echo "	<TD ALIGN=JUSTIFY VALIGN=TOP border=0>
	<table width='100%' border=0><tr><td>

<center>
<form action='$PHP_SELF' method='post' name='ed_czl'>
  <font class='FormHeaderFont'>$tytul</font>
  <table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
  
  <tr>
      <td class='FieldCaptionTD'>New Sheet</td>
      <td class='DataTD'> <input CLASS='Button'  type='Button' onclick='window.location=\"buyers_sheet_edit.php?bs=new\"' value=\"New Buyer's Sheet\"></td>
    </tr>
    <tr>
      <td class='FieldCaptionTD'>Edit of old Buyer's sheet</td>
      <td class='DataTD'>&nbsp;</td>
    </tr>
  <tr>
      <td class='FieldCaptionTD'>Buyer</td>

<td class='DataTD'>";
if ($sheetnumber != 0) {
echo "
   <select class='Select' name='_bsid'>
      $namehtml
    </select>";
    }
else echo "There is no Buyer's sheet today.";    
echo "    
</td></tr>
    <tr>
      <td class='FieldCaptionTD'>Date</td>
      <td class='DataTD'>$dataakt</td>
    </tr>
    <tr>  
      <td class='FieldCaptionTD'>What would you like to do?</td>
      <td class='DataTD'><select class='Select' name='todo'>
    <option value='1'>edit</option>
    <option value='2'>print</option>
    <option value='3'>close</option>
      </select></td>
    </tr> ";
if ($sheetnumber != 0) {    
   echo " 
   <tr>
      <td align='right' colspan='2'>
		<input name='state' type='hidden' value='1'>
	<input class='Button' name='Update' type='submit' value='$OKBTN'>
	</td>
    </tr>";
    }
    echo "
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


  echo "<script language='javascript'>window.location=\"buyers_sheet_edit.php?bs=$_bsid&todo=$todo\"</script>";
} //fi state=1
else
{
 echo "<BR><BR><BR>Ostrze¿enie!!!!!<BR><BR><BR>",
	 "Oy! What are you doing? $REMOTE_ADDR <BR>";
} //else state
?>