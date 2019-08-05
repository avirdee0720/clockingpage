<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$tytul='Staff admin - LEAVERS';

uprstr($PU,50);

$year = $_GET["year"];

$year0= $year-1;
if (!empty($year)) {
             $when="AND `nombers`.`left1` >= '$year0-04-01' AND `nombers`.`left1` <= '$year-03-31'";            
} else {
    $when="";
}

echo "  <TD ALIGN=JUSTIFY VALIGN=TOP border=0>

<center>


<font CLASS='FormHeaderFont'>$tytul&nbsp;&nbsp;   &nbsp;&nbsp;</font>
<BR>



<table border='0' cellpadding='3' cellspacing='1' CLASS='FormTABLE'>
  <tr>
    <td CLASS='ColumnTD' nowrap>&nbsp;</td>
    <td CLASS='ColumnTD' nowrap>
                <A HREF='$PHP_SELF?sort=1&kier=$kier'>NO $kier_img[1]</a>

        </td>
    <td CLASS='ColumnTD' nowrap>
                <A HREF='$PHP_SELF?sort=2&kier=$kier'>First name $kier_img[2]</a>

        </td>
    <td CLASS='ColumnTD' nowrap>
                <A HREF='$PHP_SELF?sort=3&kier=$kier'>Surname $kier_img[3]</a>

        </td>
    <td CLASS='ColumnTD' nowrap>
                <A HREF='$PHP_SELF?sort=4&kier=$kier'>Known AS $kier_img[4]</a>

        </td>
	<td CLASS='ColumnTD' nowrap>
                <A HREF='$PHP_SELF?sort=5&kier=$kier'>Left $kier_img[5]</a>

        </td>
            <td CLASS='ColumnTD' nowrap>
                <A HREF='$PHP_SELF?sort=5&kier=$kier'>Category $kier_img[6]</a>

        </td>
        </tr>
";
if (!$db->Open()) $db->Kill();

if(!isset($sort)) $sort=1;

        switch ($sort)
                {
                case 1:
                 $sortowanie=" ORDER BY `nombers`.`pno` $kier_sql";
                 break;
                case 2:
                 $sortowanie=" ORDER BY `nombers`.`firstname` $kier_sql";
                 break;
                case 3:
                 $sortowanie=" ORDER BY `nombers`.`surname` $kier_sql";
                 break;
                case 4:
                 $sortowanie=" ORDER BY `nombers`.`knownas` $kier_sql";
                 break;
                case 5:
                 $sortowanie=" ORDER BY `nombers`.`left1` $kier_sql";
                 break;
                case 6:
                 $sortowanie=" ORDER BY `emplcat`.`catname` $kier_sql";
                 break;

                default:
                 $sortowanie=" ORDER BY `nombers`.`pno` $kier_sql ";
                 break;
                }
if(!isset($letter)) $letter='%';
else $letter=$letter.'%';

if (!$db->Open()) $db->Kill();
$q = "SELECT `nombers`.`ID`, `nombers`.`pno`, `nombers`.`firstname`, `nombers`.`surname`, `nombers`.`knownas`, `nombers`.`status`, DATE_FORMAT(`nombers`.`left1`, \"%d/%m/%Y\") as d2,`emplcat`.`catname` FROM `nombers` LEFT JOIN `emplcat` ON `nombers`.`cat`=`emplcat`.`catozn` WHERE `status`='LEAVER' $when";
$q=$q.$sortowanie;

$colour_odd = "DataTD"; 
$colour_even = "DataTDGrey"; 
$row_count=0; 

  if ($db->Query($q)) 
  {
	$ileich=$db->Rows();
    while ($row=$db->Row())
    {
	$row_count++;
	$row_color = (($row_count % 2) == 0) ? $colour_even : $colour_odd;
     echo "
  <tr>
    <td CLASS='$row_color'>   
        <a CLASS='DataLink' href='advance1.php?cln=$row->pno'><IMG SRC='images/expand_row.gif' WIDTH='16' HEIGHT='16' BORDER='0' ALT='PAYs'></a>
        <a CLASS='DataLink' href='pay01.php?cln=$row->pno'><IMG SRC='images/cons_report.gif' WIDTH='16' HEIGHT='16' BORDER='0' ALT='PAYs'></a>
        <a CLASS='DataLink' href='t_of_staff.php?cln=$row->pno'><IMG SRC='images/last1hr.gif' WIDTH='16' HEIGHT='16' BORDER='0' ALT='Clocking'></a>
        <a CLASS='DataLink' href='hollid1fired.php?cln=$row->pno'><IMG SRC='images/hollidays.gif' WIDTH='16' HEIGHT='16' BORDER='0' ALT='Holidays'></a>
        <a CLASS='DataLink' href='ed_os_k.php?lp=$row->pno'><IMG SRC='images/ipgrp.gif' WIDTH='16' HEIGHT='16' BORDER='0' ALT='Properites'></a>
        <a CLASS='DataLink' href='ed_os_s.php?lp=$row->pno'><IMG SRC='images/home.gif' WIDTH='16' HEIGHT='16' BORDER='0' ALT='EDIT SHOP'></a>
        <a CLASS='DataLink' href='ed_os.php?lp=$row->ID'><IMG SRC='images/edit.png' BORDER='0' ALT='EDIT'></a>
        <a CLASS='DataLink' href='del_os.php?cln=$row->pno'><IMG SRC='images/drop.png' BORDER='0' ALT='DELETE'></a>
        </td>
         <td CLASS='$row_color'>$row->pno</td>
    <td CLASS='$row_color'>$row->firstname</td>
    <td CLASS='$row_color'>$row->surname</td>
    <td CLASS='$row_color'>$row->knownas</td>
	<td CLASS='$row_color'>$row->d2</td>
    <td CLASS='$row_color'>$row->catname</td>
         </tr>
  ";
  } 
} else {
echo " 
  <tr>
    <td CLASS='DataTD'></td>
    <td CLASS='DataTD' colspan='3'>Brak dzialow</td>
  </tr>";
 $db->Kill();
}
echo "
  <tr>
    <td align='left' CLASS='FooterTD' nowrap> &nbsp;</td>
    <td align='middle' CLASS='FooterTD' colspan='6' nowrap>&nbsp;Total: $ileich </td>
  </tr>
</table>
<IMG SRC='images/expand_row.gif' WIDTH='16' HEIGHT='16' BORDER='0' ALT='PAYs'> ADANCES
<IMG SRC='images/cons_report.gif' WIDTH='16' HEIGHT='16' BORDER='0' ALT='PAYs'> PAY
<IMG SRC='images/last1hr.gif' WIDTH='16' HEIGHT='16' BORDER='0' ALT='Clocking'> TIME OF STAFF
<IMG SRC='images/hollidays.gif' WIDTH='16' HEIGHT='16' BORDER='0' ALT='Holidays'> HOLIADYS
<IMG SRC='images/ipgrp.gif' WIDTH='16' HEIGHT='16' BORDER='0' ALT='Properites'> EDIT PAY STRUCTURE OF TE STAFF
<IMG SRC='images/home.gif' WIDTH='16' HEIGHT='16' BORDER='0' ALT='EDIT SHOP'> EDIT SHOP FOR THE STAFF
<IMG SRC='images/edit.png' BORDER='0' ALT='EDIT'> EDIT NAME ETC.
<IMG SRC='images/drop.png' BORDER='0' ALT='DELETE'> DEL. STAFF
</center>
<BR>
</td></tr>
</table>
";
include_once("./footer.php");
?>
