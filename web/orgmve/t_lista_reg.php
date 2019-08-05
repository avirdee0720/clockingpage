<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$tytul='Regular Staff';

uprstr($PU,90);

//init $kier_img by Greg
for ($index = 0; $index <= 5; $index++ ) {
    if (!isset($kier_img[$index]))
        $kier_img[$index] = "";
}

echo "  <TD ALIGN=JUSTIFY VALIGN=TOP border=0>

<center>

<font CLASS='FormHeaderFont'>$tytul&nbsp;&nbsp;   &nbsp;&nbsp;
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
                <A HREF='$PHP_SELF?sort=5&kier=$kier'>Category $kier_img[5]</a>

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
                 $sortowanie=" ORDER BY `emplcat`.`catname` $kier_sql";
                 break;

                default:
                 $sortowanie=" ORDER BY `nombers`.`pno` $kier_sql ";
                 break;
                }
if(!isset($letter)) $letter='%';
else $letter=$letter.'%';

if (!$db->Open()) $db->Kill();
$q = "SELECT `nombers`.`ID`, `nombers`.`pno`, `nombers`.`firstname`, `nombers`.`surname`, `nombers`.`knownas`, `nombers`.`status`, `emplcat`.`catname` FROM `nombers` RIGHT JOIN `emplcat` ON `nombers`.`cat`=`emplcat`.`catozn` WHERE `cat` <>'c' AND `status`='OK' ";
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
    $menuP = ToolPMenu($row->pno ,1);
	echo "<tr>
		<td CLASS='$row_color'> $menuP </td>
		<td CLASS='$row_color'><B>$row->pno</B></td>
		<td CLASS='$row_color'>$row->firstname</td>
		<td CLASS='$row_color'>$row->surname</td>
		<td CLASS='$row_color'>$row->knownas</td>
		<td CLASS='$row_color'>$row->status</td>
	</tr>";
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
    <td align='middle' CLASS='FooterTD' colspan='5' nowrap>Total: $ileich members</td>
  </tr>
</table>

</center>
<BR>
</td></tr>
</table>
";
include_once("./footer.php");
?>
