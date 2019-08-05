<?php
//this file made by Greg from adm_prod.php
include("./config.php");
include_once("./header.php");

$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;

if (!isset($_GET['sort'])) $sort = 0; else $sort = $_GET['sort'];

echo "<TD ALIGN=JUSTIFY VALIGN=TOP border=0>

<center>
<font class='FormHeaderFont'>MGE Computer list</font>
<br><br>
<table border='0' cellpadding='3' cellspacing='1' class='FormTABLE' bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white'>
<tbody>
<tr>
<td class='FieldCaptionTD'><B>No.</B></td>
<td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=1&kier=$kier'><B>Computer name</B>$kier_img[1]</A></td>
<td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=2&kier=$kier'><B>IP Address</B>$kier_img[2]</A></td>
<td class='FieldCaptionTD'><B>MAC</B></td>
<td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=3&kier=$kier'><B>Clocking name</B>$kier_img[3]</A></td>
<td class='FieldCaptionTD'><B>Show trial</B></td>
<td class='FieldCaptionTD'><B>Delete</B></td>
</tr>";

switch ($sort) {
    case 1:
        $sortowanie=" ORDER BY `name` $kier_sql";
	break;
    case 2:
        $sortowanie=" ORDER BY `IP` $kier_sql";
        break;
    case 3:
        $sortowanie=" ORDER BY `namefb` $kier_sql";
        break;
    default:
        $sortowanie=" ORDER BY `ID` $kier_sql";
        break;
}


$sql =("SELECT `ID`, `name`, `IP`, `mac`, `namefb`, `showtrial_fl`
        FROM `ipaddress`");
$query = $sql.$sortowanie;

if (!$db->Open()) $db->Kill();
if (!$db->Query($query)) $db->Kill();
$licz=1;

while ($row=$db->Row()) {
    if ($row->showtrial_fl == 1) {
        $trialtext = "<img border=\"0\" src=\"./images/tickgreen.jpg\"></img>";     
    }
    else $trialtext = ""; 
    
    echo "<tr>
        <td class='DataTD'><B>$licz</B></td>
	<td class='DataTD'><A HREF='ed_ipadd.php?ipid=$row->ID'><B>$row->name</B></A></td>
        <td class='DataTD'><A HREF='ed_ipadd.php?ipid=$row->ID'><B>$row->IP</B></A></td>
        <td class='DataTD'>$row->mac</td>
        <td class='DataTD'>$row->namefb</td>
        <td class='DataTD'>$trialtext</td>
        <td class='DataTD'><CENTER><A HREF='del_ipadd.php?ipid=$row->ID'><IMG SRC='images/down.gif' BORDER='0' title='Delete IP address'></A></CENTER></td>
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