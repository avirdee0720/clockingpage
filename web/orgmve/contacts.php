<?php
//this file made by Greg from adm_prod.php
include("./config.php");
include_once("./header.php");

$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;

if (!isset($_GET['sort'])) $sort = 0; else $sort = $_GET['sort'];

echo "<TD ALIGN=JUSTIFY VALIGN=TOP border=0>

<center>
<font class='FormHeaderFont'>Contact list</font>
<br><br>
<table border='0' cellpadding='3' cellspacing='1' class='FormTABLE' bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white'>
<tbody>
<tr>
<td class='FieldCaptionTD'><B>No.</B></td>
<td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=1&kier=$kier'><B>Name</B>$kier_img[1]</A></td>
<td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=2&kier=$kier'><B>Company name</B>$kier_img[2]</A></td>
<td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=3&kier=$kier'><B>Phone</B>$kier_img[3]</A></td>
<td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=4&kier=$kier'><B>Mobile</B>$kier_img[4]</a></td>
<td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=5&kier=$kier'><B>Email</B>$kier_img[5]</A></td>
<td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=6&kier=$kier'><B>Link</B>$kier_img[6]</A></td>
<td class='FieldCaptionTD'><B>Web</B></td>
<td class='FieldCaptionTD'><B>Delete</B></td>
</tr>";

switch ($sort) {
    case 1:
        $sortowanie=" ORDER BY `FirstName` $kier_sql, `LastName` $kier_sql";
	break;
    case 2:
        $sortowanie=" ORDER BY `CompanyName` $kier_sql";
        break;
    case 3:
        $sortowanie=" ORDER BY `Phone` $kier_sql";
        break;
    case 4:
        $sortowanie=" ORDER BY `Mobile` $kier_sql";
        break;
    case 5:
        $sortowanie=" ORDER BY `Email` $kier_sql";
        break;
    case 6:
        $sortowanie=" ORDER BY `www` $kier_sql";
        break;
    
    default:
        $sortowanie=" ORDER BY `ConttactID` $kier_sql";
        break;
}


$sql =("SELECT `ConttactID`, `FirstName`, `LastName`, `CompanyName`, `Phone`, `Mobile`, `Email`, `www`
        FROM `ContactsTbl`
        WHERE `Valid` = '1'");
$query = $sql.$sortowanie;

if (!$db->Open()) $db->Kill();
if (!$db->Query($query)) $db->Kill();
$licz=1;

while ($row=$db->Row()) {
    echo "<tr>
        <td class='DataTD'><B>$licz</B></td>
	<td class='DataTD'><A HREF='ed_con.php?cid=$row->ConttactID'><B>$row->FirstName $row->LastName</B></A></td>
        <td class='DataTD'><A HREF='ed_con.php?cid=$row->ConttactID'><B>$row->CompanyName</B></A></td>
        <td class='DataTD'>$row->Phone</td>
        <td class='DataTD'>$row->Mobile</td>
        <td class='DataTD'><A HREF=\"mailto:$row->Email\">$row->Email</A></td>
        <td class='DataTD'>$row->www</td>
        <td class='DataTD'><CENTER><A HREF='http://$row->www' target='_Blank'><IMG SRC='images/adminlinks_icon.gif' BORDER='0' title='Open URL'></A></CENTER></td>
        <td class='DataTD'><CENTER><A HREF='del_con.php?cid=$row->ConttactID'><IMG SRC='images/down.gif' BORDER='0' title='Delete contact'></A></CENTER></td>
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