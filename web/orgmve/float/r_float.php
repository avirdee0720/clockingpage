<?php

//include("../inc/mysql.inc.php");
include("./config.php");
include_once("./header.php");
require './float/smarty/libs/Smarty.class.php';

$PHP_SELF = $_SERVER['PHP_SELF'];

$db = new CMySQL;
$smarty = new Smarty;

if (!$db->Open()) $db->Kill();

$dataakt=date("d/m/Y H:i:s");
$dataakt2=date("d/m/Y");
$daytext=date("l");

uprstr($PU,90);

$q = "SELECT fs_float.floatsheetid, fs_float.date As fsdate, fs_float.shopid, fs_shops.name
FROM fs_float INNER JOIN fs_shops ON fs_float.shopid = fs_shops.id
order by shops.name ASC, date desc;
";

  if (!$db->Query($q)) $db->Kill(); 


while ($row=$db->Row())
    {
    $fslist[] = array("floatsheetid" => $row->floatsheetid,
                      "fsdate" => $row->fsdate,
                      "shopid" => $row->shopid,
                      "fs_shops.name" => $row->fs_shops.name,
                      );
    }

$smarty->assign("department",$department);
$smarty->assign("floatsheetid",$floatsheetid);


$smarty->display('float_sheet.html');

/*
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
    <td class='DataTD'><A HREF='.\float\float_sheet.php?fs=1'>$OKBTN</A></td>
    <td class='DataTD'>First Float</td>
</tr>
<tr>
	 <td class='DataTD'>$SRP04</td>
    <td class='DataTD'><A HREF='srp04.php'>$OKBTN</A></td>
    <td class='DataTD'>$SRP04o</td>
</tr>
<tr>
	 <td class='DataTD'>Casual list</td>
    <td class='DataTD'><A HREF='hrclist.php'>$OKBTN</A></td>
    <td class='DataTD'>$SRP04o</td>
</tr>
<tr>
	 <td class='DataTD'>Regular - post one year</td>
    <td class='DataTD'><A HREF='hrrlist1yp.php'>$OKBTN</A></td>
    <td class='DataTD'></td>
</tr>
<tr>
	 <td class='DataTD'>Regular - pre one year</td>
    <td class='DataTD'><A HREF='hrrlist1ym.php'>$OKBTN</A></td>
    <td class='DataTD'></td>
</tr>
<tr>
	 <td class='DataTD'>Casual list - New window</td>
    <td class='DataTD'><A HREF='hrclist.php' target='_Blank'>$OKBTN</A></td>
    <td class='DataTD'>$SRP04o</td>
</tr>
<tr>
	 <td class='DataTD'>Regular - post one year - New window</td>
    <td class='DataTD'><A HREF='hrrlist1yp.php' target='_Blank'>$OKBTN</A></td>
    <td class='DataTD'></td>
</tr>
<tr>
	 <td class='DataTD'>Regular - pre one year - New window</td>
    <td class='DataTD'><A HREF='hrrlist1ym.php' target='_Blank'>$OKBTN</A></td>
    <td class='DataTD'></td>
</tr>
<tr>
	 <td class='DataTD'>Regular's contact details</td>
    <td class='DataTD'><A HREF='srp05.php'>$OKBTN</A></td>
    <td class='DataTD'>$SRP05o</td>
</tr>
<tr>
	 <td class='DataTD'>Casual's contact details</td>
    <td class='DataTD'><A HREF='srp06.php'>$OKBTN</A>&nbsp;</td>
    <td class='DataTD'>$SRP06o</td>
</tr>
<tr>
	 <td class='DataTD'>$ZLRP55</td>
    <td class='DataTD'><A HREF='r_security.php'>$VIEWBTN</A></td>
    <td class='DataTD'>$ZLRP55o</td>
</tr>
<tr>
	 <td class='DataTD'>$ZLRP56</td>
    <td class='DataTD'><A HREF='r_cl.php'>$VIEWBTN</A></td>
    <td class='DataTD'>$ZLRP56o</td>
</tr>
<tr>
	 <td class='DataTD'>$ZLRP57</td>
    <td class='DataTD'><A HREF='r_paystru.php'>$VIEWBTN</A></td>
    <td class='DataTD'>$ZLRP57o</td>
</tr>
<tr>
	 <td class='DataTD'>Absentees</td>
    <td class='DataTD'><A HREF='hrnoclock1m.php'>$OKBTN</A></td>
    <td class='DataTD'></td>
</tr>
</table>
</TD></TR></TABLE>

</center>
<BR>

";
*/

?>