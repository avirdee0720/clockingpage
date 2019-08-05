<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$tytul='Regular Staff, Pre One Year';

uprstr($PU,90);

$decisionarray= array ("No","Yes","Don’t know","Resigned","Dismissed","Casual");
$decisiondontknow = 0;
$tabletxt = "";

if (!$db->Open()) $db->Kill();

if(!isset($sort)) {$sort="5";$kier_sql ="ASC";}

        switch ($sort)
                {
                case 1:
                 $sortowanie=" ORDER BY `nombers`.`started` DESC";
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
                 $sortowanie=" ORDER BY `nombers`.`started` $kier_sql";
                 break;
                case 6:
                 $sortowanie=" ORDER BY `staffdetails`.`decisiondate` $kier_sql";
                 break;
                case 7:
                 $sortowanie=" ORDER BY `staffdetails`.`decision` $kier_sql";
                 break;
                default:
                 $sortowanie=" ORDER BY `nombers`.`started` $kier_sql ";
                 break;
                }
if(!isset($letter)) $letter='%';
else $letter=$letter.'%';


if (!$db->Open()) $db->Kill();
$q = "SELECT `nombers`.`pno` , `nombers`.`surname` , `nombers`.`firstname` , `nombers`.`knownas` , `nombers`.`cat` , DATE_FORMAT( `nombers`.`started` , \"%d/%m/%y\" ) AS d1, `staffdetails`.`decision` , DATE_FORMAT( `staffdetails`.`decisiondate` , \"%d/%m/%y\" ) AS decisiondate, `emplcat`.catname FROM (`nombers` CROSS JOIN  `staffdetails` ON `nombers`.`pno` = `staffdetails`.`no`) INNER JOIN `emplcat` ON `nombers`.`cat`= `emplcat`.catozn WHERE `nombers`.`status` = 'OK' AND  `nombers`.`cat` <> 'c' AND (DATEDIFF( now( ) , `nombers`.`started` ) < 365 or `nombers`.`started` is NULL or `nombers`.`started` = '0000-00-00')";
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
	
	if ($row->decision == "2" ) $decisiondontknow++;
	
 $decisiontxt = $decisionarray[$row->decision];
	$tabletxt .= "<tr>
  <td CLASS='$row_color' nowrap=\"nowrap\">$row->knownas&nbsp;</td>
	<td CLASS='$row_color' nowrap=\"nowrap\">$row->surname&nbsp;</td>
  <td CLASS='$row_color' nowrap=\"nowrap\"><div align=\"center\">$row->catname&nbsp;</td>
  <td CLASS='$row_color' nowrap=\"nowrap\"><div align=\"right\">$row->d1&nbsp;</td>
	<td CLASS='$row_color' nowrap=\"nowrap\"><div align=\"right\">$row->decisiondate&nbsp;</td>
	<td CLASS='$row_color' nowrap=\"nowrap\"><div align=\"center\">$decisiontxt&nbsp;</td>
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

<font CLASS='FormHeaderFont'>$tytul&nbsp;&nbsp;   &nbsp;&nbsp;  Number of ‘don’t knows’:<b> $decisiondontknow</b>
<table border='0' cellpadding='2' cellspacing='1' CLASS='FormTABLE'>
  <tr>
   
    <td CLASS='ColumnTD2' nowrap=\"nowrap\"><div align=\"center\">
                <A HREF='$PHP_SELF?sort=2&kier=$kier'>Known as $kier_img[2]</a>

       </div>  </td>
    <td CLASS='ColumnTD2' nowrap=\"nowrap\"><div align=\"center\">
                <A HREF='$PHP_SELF?sort=3&kier=$kier'>Surname $kier_img[3]</a>

       </div>  </td>
   <td CLASS='ColumnTD2' nowrap=\"nowrap\"><div align=\"center\">
                <A HREF='$PHP_SELF?sort=4&kier=$kier'>Job title $kier_img[4]</a></td>
       </div>  </td>
        <td CLASS='ColumnTD2' nowrap=\"nowrap\"><div align=\"center\">
                <A HREF='$PHP_SELF?sort=5&kier=$kier'>Started$kier_img[5]</a></td>
      </div>   </td>
         <td CLASS='ColumnTD2' nowrap=\"nowrap\"><div align=\"center\">
                <A HREF='$PHP_SELF?sort=6&kier=$kier'>Decision date$kier_img[6]</a></td>
      </div>   </td>
         <td CLASS='ColumnTD2' nowrap=\"nowrap\" width=\"100\"><div align=\"center\">
                <A HREF='$PHP_SELF?sort=7&kier=$kier'>Decision$kier_img[7]</a></td>
      </div>   </td>  
     
           
				</tr>
".$tabletxt;
echo $tabletxt;
include_once("./footer.php");
?>
