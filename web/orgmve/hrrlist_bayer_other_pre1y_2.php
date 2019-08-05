<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;


if   ($kier_sql == "DESC")   $kier_sql = "ASC";
else        $kier_sql = "DESC" ;

uprstr($PU,90);

$tabletxt = "";

if(!isset($state))
{

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
$tabletxt2 ="";
if ($i==0) {$cat = "  AND `nombers`.`cat`  Like 'b'"; $tytul='Buyers, Pre One Year';}
else {$cat ="  AND `nombers`.`cat`  not Like 'b' AND `nombers`.`cat`  not Like 'c'"; $tytul='Non Buyers, Pre One Year';}



if (!$db->Open()) $db->Kill();
$q = "SELECT DISTINCT `nombers`.`pno` , `nombers`.`surname` , `nombers`.`firstname` , `nombers`.`knownas` , `nombers`.`cat` ,`nombers`.`textpreoneyear` ,  DATE_FORMAT( `nombers`.`started` , \"%d/%m/%y\" ) AS d1,  `emplcat`.catname,  `emplcat`.catname_staff FROM (`nombers` CROSS JOIN  `staffdetails` ON `nombers`.`pno` = `staffdetails`.`no`) INNER JOIN `emplcat` ON `nombers`.`cat`= `emplcat`.catozn WHERE `nombers`.`status` = 'OK'  $cat AND (DATEDIFF( now( ) , `nombers`.`started` ) < 365 or `nombers`.`started` is NULL or `nombers`.`started` = '0000-00-00')
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
	
	$tabletxt2 .= "<tr>
		<input name='id2[]' type='hidden' value='$row->pno'>
  <td CLASS='$row_color' nowrap=\"nowrap\">$row->knownas&nbsp;</td>
	<td CLASS='$row_color' nowrap=\"nowrap\">$row->surname&nbsp;</td>
  <td CLASS='$row_color' nowrap=\"nowrap\"><div align=\"center\">$row->catname_staff&nbsp;</td>
  <td CLASS='$row_color' nowrap=\"nowrap\"><div align=\"right\">$row->d1&nbsp;</td>
   <td CLASS='ColumnTD2' nowrap=\"nowrap\"><input class='Input' size='50' maxlength='120' name='textpreoneyear[]' value=\"$row->textpreoneyear\">
               </td>
  </td>
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
	

<center>


<font CLASS='FormHeaderFont'>$tytul&nbsp;&nbsp;   &nbsp;&nbsp;  Total:<b> $ileich</b>
<form action='$PHP_SELF' method='post' name='hrlist'>
<table border='0' cellpadding='2' cellspacing='1' CLASS='FormTABLE'>
  <tr>
   
    <td CLASS='ColumnTD2' nowrap=\"nowrap\"><div align=\"center\">
                <A HREF='$PHP_SELF?sort=1&kier=$kier'>Known as</a>

      </td>
    <td CLASS='ColumnTD2' nowrap=\"nowrap\"><div align=\"center\">
                <A HREF='$PHP_SELF?sort=2&kier=$kier'>Surname</a>

       </td>
   <td CLASS='ColumnTD2' nowrap=\"nowrap\"><div align=\"center\">
                <A HREF='$PHP_SELF?sort=3&kier=$kier'>Job title</a></td>
       </td>
        <td CLASS='ColumnTD2' nowrap=\"nowrap\"><div align=\"center\">
                <A HREF='$PHP_SELF?sort=4&kier=$kier'>Started</a></td>
       </td>
                 <td CLASS='ColumnTD2' nowrap=\"nowrap\"><div align=\"center\">Message</a></td>
				</tr>
				$tabletxt2
</center>
<BR>
</td></tr>
</table>
 <br>
";

$i++;
}

$tabletxt .=  "
 <table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
            <tr> <td align='right' colspan='2'>
		    
		    <input name='state' type='hidden' value='1'>
		   <input class='Button' name='Update' type='submit' value='$SAVEBTN'>			

</td>  </tr>
</table>
</form>

";



echo $tabletxt;
include_once("./footer.php");
}

elseif($state==1)
{


checkZm("id2");
//checkZm("textpostoneyear");
 $textpostoneyear=  $_POST["textpreoneyear"];

foreach ($id2 as  $key =>  $value) {



    $sql ="UPDATE `nombers`SET `nombers`.textpreoneyear= '".$textpreoneyear[$key]."'
       Where pno='$value'
        LIMIT 1";
 if (!$db->Open()) $db1->Kill();
	if (!$db->Query($sql))  $db->Kill();

  
   }   
  
 echo "<script language='javascript'>window.location=\"$PHP_SELF\"</script>";
}

?>
