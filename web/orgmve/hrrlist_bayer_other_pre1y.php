<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;


if   ($kier_sql == "DESC")   $kier_sql = "ASC";
else        $kier_sql = "DESC" ;

uprstr($PU,90);

$tabletxt = "";

if (!$db->Open()) $db->Kill();
 
if(!isset($sort)) {$sort="1";$kier_sql ="ASC";}

        switch ($sort)
                {
                case 1:
                 $sortowanie=" ORDER BY `nombers`.`knownas` $kier_sql";
                 break;
                case 2:
                 $sortowanie=" ORDER BY `nombers`.`surname` $kier_sql";
                 break;
                case 3:
                 $sortowanie=" ORDER BY `emplcat`.catname $kier_sql";
                 break;
                case 4:
                 $sortowanie=" ORDER BY `nombers`.`started` $kier_sql";
                 break;
                default:
                 $sortowanie=" ORDER BY `nombers`.`knownas` $kier_sql ";
                 break;
                }
if(!isset($letter)) $letter='%';
else $letter=$letter.'%';

$i = 0;

while ($i<=1) {

if ($i==0) {$cat = "  AND `nombers`.`cat`  Like 'b'"; $tytul='Buyers, Pre One Year';}
else {$cat ="  AND `nombers`.`cat`  not Like 'b' AND `nombers`.`cat`  not Like 'c'"; $tytul='Non Buyers, Pre One Year';}

$tabletxt .= "  <TD ALIGN=JUSTIFY VALIGN=TOP border=0>

<center>

<font CLASS='FormHeaderFont'>$tytul</b>
<table border='0' cellpadding='2' cellspacing='1' CLASS='FormTABLE'>
  <tr>
   
    <td CLASS='ColumnTD2' nowrap=\"nowrap\"><div align=\"center\">
                <A HREF='$PHP_SELF?sort=1&kier=$kier'>Known as $kier_img[1]</a>

       </div>  </td>
    <td CLASS='ColumnTD2' nowrap=\"nowrap\"><div align=\"center\">
                <A HREF='$PHP_SELF?sort=2&kier=$kier'>Surname $kier_img[2]</a>

       </div>  </td>
   <td CLASS='ColumnTD2' nowrap=\"nowrap\"><div align=\"center\">
                <A HREF='$PHP_SELF?sort=3&kier=$kier'>Job title $kier_img[3]</a></td>
       </div>  </td>
        <td CLASS='ColumnTD2' nowrap=\"nowrap\"><div align=\"center\">
                <A HREF='$PHP_SELF?sort=4&kier=$kier'>Started$kier_img[4]</a></td>
      </div>   </td>
           
				</tr>
";


if (!$db->Open()) $db->Kill();
$q = "SELECT DISTINCT `nombers`.`pno` , `nombers`.`surname` , `nombers`.`firstname` , `nombers`.`knownas` , `nombers`.`cat` , DATE_FORMAT( `nombers`.`started` , \"%d/%m/%y\" ) AS d1,  `emplcat`.catname FROM (`nombers` CROSS JOIN  `staffdetails` ON `nombers`.`pno` = `staffdetails`.`no`) INNER JOIN `emplcat` ON `nombers`.`cat`= `emplcat`.catozn WHERE `nombers`.`status` = 'OK'  $cat AND (DATEDIFF( now( ) , `nombers`.`started` ) < 365 or `nombers`.`started` is NULL or `nombers`.`started` = '0000-00-00')
 AND (
`staffdetails`.`decision` <> '4'
AND `staffdetails`.`decision` <> '3'
OR `staffdetails`.`decision` IS NULL
)

";
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
  <td CLASS='$row_color' nowrap=\"nowrap\">$row->knownas&nbsp;</td>
	<td CLASS='$row_color' nowrap=\"nowrap\">$row->surname&nbsp;</td>
  <td CLASS='$row_color' nowrap=\"nowrap\"><div align=\"center\">$row->catname&nbsp;</td>
  <td CLASS='$row_color' nowrap=\"nowrap\"><div align=\"right\">$row->d1&nbsp;</td>
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

$i++;
}


echo $tabletxt;
include_once("./footer.php");
?>
