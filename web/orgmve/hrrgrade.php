<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$tytul='Regular Staff';

uprstr($PU,90);

echo "  <TD ALIGN=JUSTIFY VALIGN=TOP border=0>

<center>

$ileich
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
                <A HREF='$PHP_SELF?sort=5&kier=$kier'>Category $kier_img[5]</a></td>
        </td>
            <td CLASS='ColumnTD' nowrap>
YES</td>
				        </td>
            <td CLASS='ColumnTD' nowrap>
NO</td>
				        </td>
            <td CLASS='ColumnTD' nowrap>
D.K.</td>
				
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
$q = "SELECT `nombers`.`pno`, `nombers`.`surname`, `nombers`.`firstname`, `nombers`.`knownas`, `nombers`.`cat`, DATE_FORMAT(`nombers`.`started`, \"%d/%m/%Y\") as d1, `staffdetails`.`comment1` , `staffdetails`.`comment2` , `staffdetails`.`comment3`  FROM `nombers` CROSS JOIN  `staffdetails` ON `nombers`.`pno` = `staffdetails`.`no` WHERE `nombers`.`status` = 'OK' ";
$q=$q.$sortowanie;

$colour_odd = "DataTD"; 
$colour_even = "DataTDGrey"; 
$row_count=0;

  if ($db->Query($q)) 
  {
	$ileich=$db->Rows();
    while ($row=$db->Row())
    {
	$clocking = $row->pno;
	$row_count++;
	$row_color = (($row_count % 2) == 0) ? $colour_even : $colour_odd;
unset($yes);
unset($no);
unset($dk);		
			$yess = explode(",", $row->comment1);
			if( $yess[0] <> "") { $yes = count($yess); } else { $yes = 0; }
			$nos = explode(",", $row->comment2);
			if( $nos[0] <> "") { $no = sizeof($nos); } else { $no = 0; }
			$dks = explode(",", $row->comment3);
			if( $dks[0] <> "") { $dk = sizeof($dks); } else { $dk = 0; }
if ($yes + $no + $dk <> 0) {	

	if ($yes > $no && $yes > $dk ) { $row_color1 = "DataTDin"; } else { 	
		if ($no > $yes && $no > $dk ) { $row_color1 = "niedziela"; } 
		else { if ($dk > $no && $dk > $yes ) { $row_color1 = "DataTDGrey"; } 
		else { $row_color1 = $row_color; } } }

	echo "<tr>
		<td CLASS='$row_color'><a CLASS='DataLink' href='hr_data.php?cln=$clocking'><B>$row->pno</B></a></td>
		<td CLASS='$row_color'><B>$row->pno</B></td>
		<td CLASS='$row_color'>$row->firstname</td>
		<td CLASS='$row_color'>$row->surname</td>
		<td CLASS='$row_color'>$row->knownas</td>
		<td CLASS='$row_color'>$row->status</td>
		<td CLASS='$row_color1'>$yes</td>
		<td CLASS='$row_color1'>$no</td>
		<td CLASS='$row_color1'>$dk</td>

		</tr>"; }
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
