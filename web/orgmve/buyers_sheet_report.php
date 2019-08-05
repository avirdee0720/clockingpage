<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$db2 = new CMySQL;

if (!$db->Open()) $db->Kill();
if (!$db2->Open()) $db->Kill();


$tytul="Buyer's sheet";
$dataakt=date("d/m/Y");
$dataakt2=date("d/m/Y H:i:s");
$date1= date("Y-m-d");

$ipx=$_SERVER['REMOTE_ADDR']; 
$state=$_GET['d1'];

if(!isset($state))
{



$namehtml = "";
 $q = "SELECT  DISTINCT DATE_FORMAT(`buyers_sheet`.`date1`, \"%Y-%m-%d\") as d2,DATE_FORMAT(`buyers_sheet`.`date1`, \"%d/%m/%Y\") as d1
  FROM  buyers_sheet
ORDER BY `buyers_sheet`.`date1` DESC";
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
          $namehtml.= " <tr><td  class='FieldCaptionTD'></td><td class='DataTD'><a href='$PHP_SELF?d1=$r->d2'>$r->d1</a></td>\n";
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
  
      <td class='FieldCaptionTD'>Date</td>

<td class='DataTD'>";
if ($sheetnumber != 0) {
echo "
      $namehtml
    ";
    }
else echo "There is no Buyer's sheet-";    
echo "    
</td></tr>
   ";

    echo "
  </table>
</form>
</center>
<BR>
</td></tr>
</table>";
include_once("./footer.php");
}
elseif($state!="")
{
  echo "ss".$state;

  $q = "SELECT * FROM `buyers_sheet` INNER JOIN `seller` ON  `buyers_sheet`.`sellerdbid`=`seller`.`sellerdbid` WHERE `buyers_sheet`.`date1`='$state'
Limit 1";

  if ($db->Query($q)) 
  {
     $row=$db->Row();
  }
  

 // echo "<script language='javascript'>window.location=\"buyers_sheet_edit.php?bs=$_bsid&todo=$todo\"</script>";
} //fi state=1
else
{
 echo "<BR><BR><BR>Ostrze¿enie!!!!!<BR><BR><BR>",
	 "Oy! What are you doing? $REMOTE_ADDR <BR>";
} //else state
?>