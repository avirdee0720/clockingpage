<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$db2 = new CMySQL;


if   ($kier_sql == "DESC")   $kier_sql = "ASC";
else        $kier_sql = "DESC" ;

uprstr($PU,90);

$tabletxt = "";

if(!isset($state))
{

if (!$db->Open()) $db->Kill();
if (!$db2->Open()) $db2->Kill();
 
if(!isset($sort2)) {$sort2="4";$kier_sql ="DESC";}

        switch ($sort2)
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


$tytul='Regular Staff, Pre One Year';
$tabletxt2 ="";


if (!$db->Open()) $db->Kill();
$q = "SELECT DISTINCT `nombers`.`pno` , `nombers`.`surname` , `nombers`.`firstname` , `nombers`.`knownas` , `nombers`.`cat` ,`nombers`.`textpreoneyear` , `nombers`.`sign`, DATE_FORMAT( `nombers`.`started` , \"%d/%m/%y\" ) AS d1,  `emplcat`.catname,  `emplcat`.catname_staff FROM (`nombers` CROSS JOIN  `staffdetails` ON `nombers`.`pno` = `staffdetails`.`no`) INNER JOIN `emplcat` ON `nombers`.`cat`= `emplcat`.catozn WHERE `nombers`.`status` = 'OK'   AND   `nombers`.`cat` <> 'c' AND(DATEDIFF( now( ) , `nombers`.`started` ) < 365 or `nombers`.`started` is NULL or `nombers`.`started` = '0000-00-00')
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
	
	$singlistcode = "";
$q = "SELECT id, value, signcode FROM `singlist`";

  if (!$db2->Query($q)) $db2->Kill();
 
   if ($db2->Query($q)) 
  {
    while ($row2=$db2->Row())
    {
   	if ($row->sign == $row2->value) 
				$singlistcode= $row2->signcode;
		  }
    }
 
	
	$tabletxt2 .= "
  <tr>
	<input name='id2[]' type='hidden' value='$row->pno'>
	<td  nowrap=\"nowrap\" width='25'></td>
  <td CLASS='$row_color' nowrap=\"nowrap\" width='60'><b>$row->knownas</b></td>
	<td CLASS='$row_color' nowrap=\"nowrap\" width='150'><b>$row->surname</b></td>
  <td CLASS='$row_color' nowrap=\"nowrap\"><b><div align=\"center\" width='60'>$row->catname_staff</b></div></td>
  <td CLASS='$row_color' nowrap=\"nowrap\"><b><div align=\"center\" width='60'>$row->d1</b></div></td>
	<td CLASS='$row_color' nowrap=\"nowrap\" width='310'><b><div align=\"right\">$row->textpreoneyear</b></td>
  <td CLASS='$row_color' nowrap=\"nowrap\" width='18'><b>$singlistcode </b>
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
<table border='0' cellpadding='2' cellspacing='1' align='left'>
  <tr>
    <td  nowrap=\"nowrap\" width='25'></td>
    <td CLASS='ColumnTD2' nowrap=\"nowrap\" width='60'><div align=\"center\">
                <A HREF='$PHP_SELF?sort2=1&kier=$kier'>Known as</a>

       </div>  </td>
    <td CLASS='ColumnTD2' nowrap=\"nowrap\" width='150'><div align=\"center\">
                <A HREF='$PHP_SELF?sort2=2&kier=$kier'>Surname</a>

       </div>  </td>
   <td CLASS='ColumnTD2' nowrap=\"nowrap\" width='60'><div align=\"center\">
                <A HREF='$PHP_SELF?sort2=3&kier=$kier'>Job title</a></td>
       </div>  </td>
        <td CLASS='ColumnTD2' nowrap=\"nowrap\" width='60'><div align=\"center\">
                <A HREF='$PHP_SELF?sort2=4&kier=$kier'>Started</a></td>
      </div>   </td>
         <td CLASS='ColumnTD2' nowrap=\"nowrap\">&nbsp;</td>
         <td CLASS='ColumnTD2' nowrap=\"nowrap\">&nbsp;</td>
     	</tr>
				$tabletxt2
</center>
<BR>
</td></tr>
</table>
 <br>
";


$tabletxt .=  "
 
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
   $signed=  $_POST["signed"];
foreach ($id2 as  $key =>  $value) {


    $sql ="UPDATE `nombers`SET `nombers`.textpreoneyear= '".$textpreoneyear[$key]."' ,`nombers`.sign= '".$signed[$key]."'
       Where pno='$value'
        LIMIT 1";
 if (!$db->Open()) $db1->Kill();
	if (!$db->Query($sql))  $db->Kill();

  
   }   
  
 echo "<script language='javascript'>window.location=\"$PHP_SELF\"</script>";
}

?>
