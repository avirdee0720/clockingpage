<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$tytul="Unpaid's contact details";

uprstr($PU,90);

//init $kier_img by Greg
for ($index = 0; $index <= 6; $index++ ) {
    if (!isset($kier_img[$index]))
        $kier_img[$index] = "";
}

$tabletxt = "";

if (!$db->Open()) $db->Kill();

if(!isset($sort)) {$sort="5";$kier_sql ="ASC";}

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
                 $sortowanie=" ORDER BY `nombers`.`cat` $kier_sql";
                 break;
                case 5:
                 $sortowanie=" ORDER BY `staffdetails`.`homephone` $kier_sql";
                 break;
                case 6:
                 $sortowanie=" ORDER BY `staffdetails`.`mobilephone` $kier_sql";
                 break;
                default:
                 $sortowanie=" ORDER BY `nombers`.`started` $kier_sql ";
                 break;
                }
if(!isset($letter)) $letter='%';
else $letter=$letter.'%';


if (!$db->Open()) $db->Kill();
$q = "SELECT `nombers`.`pno` , `nombers`.`surname` , `nombers`.`firstname` , `nombers`.`knownas` , `nombers`.`cat`, `emplcat`.catname, `staffdetails`.`homephone` , `staffdetails`.`mobilephone` FROM (`nombers` CROSS JOIN  `staffdetails` ON `nombers`.`pno` = `staffdetails`.`no`) INNER JOIN `emplcat` ON `nombers`.`cat`= `emplcat`.catozn WHERE `nombers`.`status` = 'OK'  AND  (`cat`='ui' OR `cat`='ut')";
$q=$q.$sortowanie;

$colour_odd = "DataTD2"; 
$colour_even = "DataTDGrey2"; 
$row_count=0;

  if ($db->Query($q)) 
  {
	$ileich=$db->Rows();

    while ($row=$db->Row())
    {

	$clocking = $row->pno;
	$row_count++;
	$row_color = (($row_count % 2) == 0) ? $colour_even : $colour_odd;
	
	$tabletxt .= "<tr>
	<td CLASS='$row_color'><a CLASS='DataLink' href='hr_data.php?cln=$clocking'><B>$row->pno</B></a></td>
  <td CLASS='$row_color'>$row->knownas&nbsp;</td>
	<td CLASS='$row_color'>$row->surname&nbsp;</td>
  <td CLASS='$row_color'><div align=\"center\">$row->catname&nbsp;</td>
  <td CLASS='$row_color'><div align=\"right\">$row->homephone&nbsp;</td>
	<td CLASS='$row_color'><div align=\"right\">$row->mobilephone&nbsp;</td>
    </tr>"; 
  } 
} else {
	$echo=  " 
  <tr>
    <td CLASS='DataTD'></td>
    <td CLASS='DataTD' colspan='3'>Brak dzialow</td>
  </tr>";
 $db->Kill();
}
	$tabletxt .=  "
  <tr>
    <td align='middle' CLASS='FooterTD' colspan='8' nowrap>Total: $ileich</td>
  </tr>
</table>

</center>
<BR>
</td></tr>
</table>
";


$tabletxt = "  <TD ALIGN=JUSTIFY VALIGN=TOP border=0>

<center>

<font CLASS='FormHeaderFont'>$tytul&nbsp;&nbsp;</b>
<table border='0' cellpadding='3' cellspacing='1' CLASS='FormTABLE'>
  <tr>
   
     <td CLASS='ColumnTD2' nowrap><div align=\"center\">
                <A HREF='$PHP_SELF?sort=1&kier=$kier'>No $kier_img[1]</a>

       </div>  </td>
    <td CLASS='ColumnTD2' nowrap><div align=\"center\">
                <A HREF='$PHP_SELF?sort=2&kier=$kier'>Known as $kier_img[2]</a>

       </div>  </td>
    <td CLASS='ColumnTD2' nowrap><div align=\"center\">
                <A HREF='$PHP_SELF?sort=3&kier=$kier'>Surname $kier_img[3]</a>

       </div>  </td>
   <td CLASS='ColumnTD2' nowrap><div align=\"center\">
                <A HREF='$PHP_SELF?sort=4&kier=$kier'>Job title $kier_img[4]</a></td>
       </div>  </td>
        <td CLASS='ColumnTD2' nowrap><div align=\"center\">
                <A HREF='$PHP_SELF?sort=5&kier=$kier'>Home Phone $kier_img[5]</a></td>
      </div>   </td>
         <td CLASS='ColumnTD2' nowrap><div align=\"center\">
                <A HREF='$PHP_SELF?sort=6&kier=$kier'>Mobile $kier_img[6]</a></td>
      </div>   </td>
         
           
				</tr>
".$tabletxt;
echo $tabletxt;
include_once("./footer.php");
?>
