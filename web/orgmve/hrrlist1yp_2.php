<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$db2 = new CMySQL;
$tytul='Regular Staff, Post One Year';

uprstr($PU,90);

$decisionarray= array ("No","Yes","Don’t know","Resigned","Dismissed","Casual");
$decisiondontknow = 0;
$tabletxt = "";

if (!$db->Open()) $db->Kill();

if (!$db2->Open()) $db2->Kill();

if(!isset($state))
{

if (!$db->Open()) $db->Kill();

if(!isset($sort)) {$sort="5";$kier_sql ="DESC";}

        switch ($sort)
                {
                case 1:
                 $sortowanie=" ORDER BY `nombers`.`started` DESC";
                 break;
                case 2:
                 $sortowanie=" ORDER BY `nombers`.`knownas` $kier_sql";
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
$q = "SELECT DISTINCT `nombers`.`pno` , `nombers`.`surname` , `nombers`.`firstname` , `nombers`.`knownas` , `nombers`.`cat` , `nombers`.`textpostoneyear` ,`nombers`.`sign` ,DATE_FORMAT( `nombers`.`started` , \"%d/%m/%y\" ) AS d1,  `emplcat`.catname,  `emplcat`.catname_staff  FROM (`nombers` CROSS JOIN  `staffdetails` ON `nombers`.`pno` = `staffdetails`.`no`) INNER JOIN `emplcat` ON `nombers`.`cat`= `emplcat`.catozn WHERE `nombers`.`status` = 'OK' AND  `nombers`.`cat` <> 'c' 
AND  `nombers`.`pno` <> '5'
AND  `nombers`.`pno` <> '2087'
AND  `nombers`.`pno` <> '265'
AND  `nombers`.`pno` <> '1475'
AND  `nombers`.`pno` <> '1598'
AND  `nombers`.`pno` <> '555'
AND  `nombers`.`pno` <> '1051'
AND DATEDIFF( now( ) , started ) >= 365";
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
 
$singlistcode = "";
$q = "SELECT id, value, signcode FROM `singlist`";

  if (!$db2->Query($q)) $db2->Kill();
 
   if ($db2->Query($q)) 
  {
    while ($row2=$db2->Row())
    {
   	if ($row->sign == $row2->value) 
				$singlistcode.= "<option value='$row2->value' selected>$row2->signcode</option>";
		else 
		       $singlistcode.="<option value='$row2->value'>$row2->signcode</option>";
      }
    }
 
	$tabletxt .= "
  <tr>
	<input name='id2[]' type='hidden' value='$row->pno'>
  <td CLASS='$row_color' nowrap=\"nowrap\">$row->knownas</td>
	<td CLASS='$row_color' nowrap=\"nowrap\">$row->surname</td>
  <td CLASS='$row_color' nowrap=\"nowrap\"><div align=\"center\">$row->catname_staff&nbsp;</div></td>
  <td CLASS='$row_color' nowrap=\"nowrap\"><div align=\"right\">$row->d1&nbsp;</div></td>
	<td CLASS='$row_color' nowrap=\"nowrap\" width='310'><div align=\"right\"><input class='Input' size='47' maxlength='120' name='textpostoneyear[]' value=\"$row->textpostoneyear\"></td>
  <td CLASS='$row_color' nowrap=\"nowrap\" width='20'><div align=\"right\">
  <b><select name='signed[]'>
 $singlistcode
</select>
   </b>
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
</table>

</center>
<BR>
</td></tr>
</table>
<table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
            <tr> <td align='right' colspan='2'>
		    
		    <input name='state' type='hidden' value='1'>
		   <input class='Button' name='Update' type='submit' value='$SAVEBTN'>			

</td>  </tr>
</table>
</form>
";


$tabletxt = "  <TD ALIGN=JUSTIFY VALIGN=TOP border=0>

<center>

<font CLASS='FormHeaderFont'>$tytul&nbsp;&nbsp;   &nbsp;&nbsp;  Total:<b> $ileich</b>
<form action='$PHP_SELF' method='post' name='hrlist'>
<table border='0' cellpadding='2' cellspacing='1' CLASS='FormTABLE' width='100%'>
  <tr>
   
    <td CLASS='ColumnTD2' nowrap=\"nowrap\"><div align=\"center\">
                <A HREF='$PHP_SELF?sort=2&kier=$kier'>Known as</a>

       </div>  </td>
    <td CLASS='ColumnTD2' nowrap=\"nowrap\"><div align=\"center\">
                <A HREF='$PHP_SELF?sort=3&kier=$kier'>Surname</a>

       </div>  </td>
   <td CLASS='ColumnTD2' nowrap=\"nowrap\"><div align=\"center\">
                <A HREF='$PHP_SELF?sort=4&kier=$kier'>Job title</a></td>
       </div>  </td>
        <td CLASS='ColumnTD2' nowrap=\"nowrap\"><div align=\"center\">
                <A HREF='$PHP_SELF?sort=5&kier=$kier'>Started</a></td>
      </div>   </td>
         <td CLASS='ColumnTD2' nowrap=\"nowrap\"></td>
         <td CLASS='ColumnTD2' nowrap=\"nowrap\"></td>
     	</tr>
".$tabletxt;
echo $tabletxt;
include_once("./footer.php");
}

elseif($state==1)
{


checkZm("id2");
//checkZm("textpostoneyear");
 $textpostoneyear=  $_POST["textpostoneyear"];
 $signed=  $_POST["signed"];
foreach ($id2 as  $key =>  $value) {



    $sql ="UPDATE `nombers`SET `nombers`.textpostoneyear= '".$textpostoneyear[$key]."' ,`nombers`.sign= '".$signed[$key]."'
       Where pno='$value'
        LIMIT 1";
 if (!$db->Open()) $db1->Kill();
	if (!$db->Query($sql))  $db->Kill();

  
   }   
  
 echo "<script language='javascript'>window.location=\"$PHP_SELF\"</script>";
}

?>
