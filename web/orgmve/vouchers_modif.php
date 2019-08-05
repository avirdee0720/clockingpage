<?php
//this file made by Greg from adm_prod.php
include("./config.php");
include_once("./header.php");

$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;

if (!isset($_GET['sort'])) $sort = 0; else $sort = $_GET['sort'];

echo "<TD ALIGN=JUSTIFY VALIGN=TOP border=0>

<center>
<font class='FormHeaderFont'>Modify uploaded voucher files</font>
<br><br>
<table border='0' cellpadding='3' cellspacing='1' class='FormTABLE' bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white'>
<tbody>
<tr>
<td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=1&kier=$kier'><B>No.</B>$kier_img[1]</A></td>
<td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=2&kier=$kier'><B>Month ID</B>$kier_img[2]</A></td>
<td colspan=\"2\" class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=3&kier=$kier'><B>Upload date and time</B>$kier_img[3]</A></td>
<td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=4&kier=$kier'><B>Voucher generated</B>$kier_img[4]</a></td>
<td class='FieldCaptionTD'><B>Delete</B></td>
</tr>";

switch ($sort) {
    case 1:
        $sortowanie=" ORDER BY `load_id` $kier_sql";
	break;
    case 2:
        $sortowanie=" ORDER BY `month_id` $kier_sql";
	break;
    case 3:
        $sortowanie=" ORDER BY `cur_timestamp` $kier_sql";
        break;
    case 4:
        $sortowanie=" ORDER BY `vouchgenerated` $kier_sql, `load_id` $kier_sql";
        break;
    
    default:
        $sortowanie=" ORDER BY `load_id` $kier_sql";
        break;
}

$sql =("SELECT `month_id`,
MIN(`cur_timestamp`) as cur_timestamp,
DATE_FORMAT(MIN(`cur_timestamp`), '%d %M %Y') AS uploaddate,
DATE_FORMAT(MIN(`cur_timestamp`), '%H:%i:%s') AS uploadtime,
CASE WHEN SUM(`vouchers_state`) = 0 THEN 0 ELSE 1 END AS vouchgenerated, `load_id`
FROM `voucherslips` GROUP BY `month_id`");
$query = $sql.$sortowanie;

if (!$db->Open()) $db->Kill();
if (!$db->Query($query)) $db->Kill();
$licz=1;

while ($row=$db->Row()) {
    if ($row->vouchgenerated == 0) $vouchgenerated = "<font color=\"red\">No</font>"; else $vouchgenerated = "Yes";
    echo "<tr>
        <td class='DataTD'><CENTER><B>$licz</B></CENTER></td>
        <td class='DataTD'><CENTER><B>$row->month_id</B></CENTER></td>
        <td class='DataTD'><B>$row->uploaddate</B></td>
        <td class='DataTD'><B>$row->uploadtime</B></td>
        <td class='DataTD'><CENTER><B>$vouchgenerated</B></CENTER></td>
        <td class='DataTD'><CENTER><A HREF='del_voucher.php?vlid=$row->load_id'><IMG SRC='images/down.gif' BORDER='0' title='Delete voucher'></A></CENTER></td>
      </tr>";
    $licz++;			
} //end while


echo "</table>
</td></tr>
</table> 

</td></tr></table></form></center>
";
include_once("./footer.php");
?>