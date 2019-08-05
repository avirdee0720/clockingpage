<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$db2 = new CMySQL;

$dataakt=date("d/m/Y H:i:s");
$datam = date("m");
$datay = date("y");
$datad = date("d");

$datam--;
if ($datam == 0) {$datam=12;$datay--;}
 
$tytul="No Email addresses";

uprstr($PU,90);

$tabletxt = "";

if (!$db->Open()) $db->Kill();

if(!isset($sort)) {$sort="1";$kier_sql ="ASC";}

        switch ($sort)
                {
                case 1:
                 $sortowanie=" ORDER BY `nombers`.`pno` DESC";
                 break;
                case 2:
                 $sortowanie=" ORDER BY `nombers`.`knownas` $kier_sql";
                 break;
                case 3:
                 $sortowanie=" ORDER BY `nombers`.`firstname` $kier_sql";
                 break;
                case 4:
                 $sortowanie=" ORDER BY `nombers`.`surname` $kier_sql";
                 break;
                default:
                 $sortowanie=" ORDER BY `nombers`.`pno` $kier_sql ";
                 break;
                }
if(!isset($letter)) $letter='%';
else $letter=$letter.'%';



if (!$db->Open()) $db->Kill();

 

//$q = "SELECT DISTINCT `nombers`.`pno` , `nombers`.`surname` , `nombers`.`firstname` , `nombers`.`knownas` , `nombers`.`cat` , DATE_FORMAT( `nombers`.`started` , \"%d/%m/%y\" ) AS d1, `staffdetails`.`decision` , DATE_FORMAT( `staffdetails`.`decisiondate` , \"%d/%m/%y\" ) AS decisiondate, `emplcat`.catname FROM ((`nombers` CROSS JOIN  `staffdetails` ON `nombers`.`pno` = `staffdetails`.`no`) INNER JOIN `emplcat` ON `nombers`.`cat`= `emplcat`.catozn) INNER JOIN inout ON `nombers`.`pno` = `inout`.`no`  WHERE `nombers`.`status` = 'OK' AND `nombers`.`pno`<>5 AND `nombers`.`pno`<>1684 AND `nombers`.`pno`<>555 $notxt";

$q="
SELECT DISTINCT pno, knownas,`firstname`,`surname` 
FROM `staffdetails` INNER JOIN nombers ON nombers.pno=staffdetails.no INNER JOIN inout ON `nombers`.`pno` = `inout`.`no` 
WHERE (status='OK' or DATEDIFF( now( ) , `inout`.`date1` ) <= 60) AND email=''
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

	
	$row_count++;
	$row_color = (($row_count % 2) == 0) ? $colour_even : $colour_odd;
	
	$tabletxt .= "<tr>
	<td CLASS='$row_color' nowrap=\"nowrap\"><b><a href='hr_data.php?cln=$row->pno'>$row->pno</a></b></td>
  <td CLASS='$row_color' nowrap=\"nowrap\">$row->knownas&nbsp;</td>
  <td CLASS='$row_color' nowrap=\"nowrap\"><div align=\"center\">$row->firstname&nbsp;</td>
	<td CLASS='$row_color' nowrap=\"nowrap\">$row->surname&nbsp;</td>
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

<font CLASS='FormHeaderFont'>$tytul
<table border='0' cellpadding='2' cellspacing='1' CLASS='FormTABLE'>
  <tr>
     <td CLASS='ColumnTD2' nowrap=\"nowrap\"><div align=\"center\">
              &nbsp;</td>
      </div>   </td>
    <td CLASS='ColumnTD2' nowrap=\"nowrap\"><div align=\"center\">
                <A HREF='$PHP_SELF?sort=2&kier=$kier'>Known as $kier_img[2]</a>

       </div>  </td>
        <td CLASS='ColumnTD2' nowrap=\"nowrap\"><div align=\"center\">
                <A HREF='$PHP_SELF?sort=3&kier=$kier'>Firstname $kier_img[5]</a></td>
      </div>   </td>
          <td CLASS='ColumnTD2' nowrap=\"nowrap\"><div align=\"center\">
                <A HREF='$PHP_SELF?sort=4&kier=$kier'>Surname $kier_img[3]</a>
       </div>  </td>
        </tr>
".$tabletxt;
echo $tabletxt;
include_once("./footer.php");
?>
