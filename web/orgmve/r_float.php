<?php

//include("./inc/mysql.inc.php");
include("./config.php");
include_once("./header.php");
//require './float/smarty/libs/Smarty.class.php';

$PHP_SELF = $_SERVER['PHP_SELF'];

$db = new CMySQL;
//$smarty = new Smarty;

if (!$db->Open()) $db->Kill();

$dataakt=date("d/m/Y H:i:s");
$dataakt2=date("d/m/Y");
$daytext=date("l");
$fslisthtml ="";
uprstr($PU,90);

$q = "SELECT fs_float.floatsheetid,  DATE_FORMAT(`date`,\"%d/%m/%Y\") AS fsdate,fs_float.shopid, fs_shops.name
FROM fs_float INNER JOIN fs_shops ON fs_float.shopid = fs_shops.id
order by name ASC, date desc;
";

  if (!$db->Query($q)) $db->Kill(); 


while ($row=$db->Row())
    {
    $fslist[] = array("floatsheetid" => $row->floatsheetid,
                      "fsdate" => $row->fsdate,
                      "shopid" => $row->shopid,
                      "fs_shops.name" => $row->name,
                      );
                      
      $fslisthtml .=  "<option value='$row->floatsheetid'>$row->name - $row->fsdate</option>";
    }
/*
$smarty->assign("department",$department);
$smarty->assign("floatsheetid",$floatsheetid);


$smarty->display('r_float.html');
*/

echo "

<BR><font class='FormHeaderFont'>Reports - Float Sheets Module</font><BR><BR>

<center>
<TABLE><TR><TD>

<table width=100% border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
<tr>
    <td class='ColumnTD' nowrap>Float Sheet of a day</td>
    <td class='ColumnTD' nowrap>&nbsp;</td>
    <td class='ColumnTD' nowrap><font class='FormHeaderFont'>Description</font></td>
</tr>
<tr>
	 <td class='DataTD'>Old Float sheets </td>
    <td class='DataTD'>
    <form action='./float/float_sheet.php' method='post' target='_parent'>
       <select name='floatsheetid' id='shopid'>
           $fslisthtml 
          </select>
          <input type='submit' name='fsreport' id='fsreport' value='ok' />
    </form>
    </td>
    <td class='DataTD'></td>
</tr>
<tr>
	 <td class='DataTD'>Brian's report</td>
    <td class='DataTD'><A HREF=''>$OKBTN</A></td>
    <td class='DataTD'></td>
</tr>
<tr>
	 <td class='DataTD'>Peter's report</td>
    <td class='DataTD'><A HREF=''>$OKBTN</A></td>
    <td class='DataTD'></td>
</tr>
<tr>
	 <td class='DataTD'>Brian's report</td>
    <td class='DataTD'><A HREF=''>$OKBTN</A></td>
    <td class='DataTD'></td>
</tr>
<tr>
	 <td class='DataTD'>Banking</td>
    <td class='DataTD'><A HREF='ss_b_browse.php'>$OKBTN</A></td>
    <td class='DataTD'></td>
</tr>
<tr>
	 <td class='DataTD'>Securicor</td>
    <td class='DataTD'><A HREF='brak.php'>$OKBTN</A></td>
    <td class='DataTD'></td>
</tr>
<tr>
	 <td class='DataTD'>Daily Banking</td>
    <td class='DataTD'><A HREF='ss_dayb.php' target='_Blank'>$OKBTN</A></td>
    <td class='DataTD'>$SRP04o</td>
</tr>

</table>
</TD></TR></TABLE>

</center>
<BR>

";

?>