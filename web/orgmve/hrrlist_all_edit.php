<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$db2 = new CMySQL;
$tytul='All Staff';

uprstr($PU,90);


$DepGroup=$_GET['_grp'];
$DepGroupUpper=strtoupper($_GET['_grp']);

$tytul=$DepGroupUpper.' Staff';



switch ($DepGroup)
                {
                case '%':
                 $tytul='All Staff';
                 break;
                case 'acc':
                 $tytul='Account Staff';
                 break;
                case 'build':
                 $tytul='Builder Staff';
                 break;
                case 'buyer':
                 $tytul='Buyer Staff';
                 break;
                 case 'casual':
                 $tytul='Casual Staff';
                 break;
                 case 'GA':
                 $tytul='GA Staff';
                 break;
                 case 'GMA':
                 $tytul='GMA Staff';
                 break;
                 case 'IT':
                 $tytul='IT Staff';
                 break;
                 case 'OMA':
                 $tytul='OMA Staff';
                 break;
                  case 'SA':
                 $tytul='SA Staff';
                 break;
                  case 'nonbuyers':
                 $tytul='Non-buyers Staff';
                 break; 
                }

$decisionarray= array ("No","Yes","Don't know","Resigned","Dismissed","Casual");
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
  
if ($DepGroup != 'nonbuyers') {

$q = "SELECT DISTINCT `nombers`.`pno`, `nombers`.`surname`, `nombers`.`firstname`, `nombers`.`knownas`, `nombers`.`cat`, `nombers`.`textperson`,`nombers`.`sign`, DATE_FORMAT( `nombers`.`started`, \"%d/%m/%y\" ) AS d1, `staffdetails`.`decision`, `emplcat`.catname, `emplcat`.catname_staff
    FROM (`nombers` CROSS JOIN  `staffdetails` ON `nombers`.`pno` = `staffdetails`.`no`)
    INNER JOIN `emplcat` ON `nombers`.`cat`= `emplcat`.catozn
    WHERE `nombers`.`status` = 'OK'
AND  `nombers`.`pno` <> '5'
AND  `nombers`.`pno` <> '555'
AND  `emplcat`.catname_staff Like '$DepGroup'
AND (
`staffdetails`.`decision` <> '4'
AND `staffdetails`.`decision` <> '3'
OR `staffdetails`.`decision` IS NULL
)
"; }
else {
 
$q = "SELECT DISTINCT `nombers`.`pno`, `nombers`.`surname`, `nombers`.`firstname` , `nombers`.`knownas` , `nombers`.`cat` , `nombers`.`textperson`, `nombers`.`sign`, DATE_FORMAT( `nombers`.`started`, \"%d/%m/%y\" ) AS d1, `staffdetails`.`decision`, `emplcat`.catname, `emplcat`.catname_staff
    FROM (`nombers` CROSS JOIN  `staffdetails` ON `nombers`.`pno` = `staffdetails`.`no`)
    INNER JOIN `emplcat` ON `nombers`.`cat`= `emplcat`.catozn
    WHERE `nombers`.`status` = 'OK'
AND  `nombers`.`pno` <> '5'
AND  `nombers`.`pno` <> '555'
AND  `emplcat`.catname_staff <> 'buyer'
AND (
`staffdetails`.`decision` <> '4'
AND `staffdetails`.`decision` <> '3'
OR `staffdetails`.`decision` IS NULL
)
AND cat<> 'c'
";


}


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
	<td  nowrap=\"nowrap\" width='25'></td>
  <td CLASS='$row_color' nowrap=\"nowrap\"><b>$row->knownas</b></td>
	<td CLASS='$row_color' nowrap=\"nowrap\"><b>$row->surname</b></td>
  <td CLASS='$row_color' nowrap=\"nowrap\"><b><div align=\"center\">$row->catname_staff&nbsp;</div></b></td>
  <td CLASS='$row_color' nowrap=\"nowrap\"><b><div align=\"right\">$row->d1&nbsp;</div></b></td>
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
</form>
";


$tabletxt = "  <TD ALIGN=JUSTIFY VALIGN=TOP border=0>

<center>

<font CLASS='FormHeaderFont'>$tytul&nbsp;&nbsp;   &nbsp;&nbsp;  Total:<b> $ileich</b>
<form action='$PHP_SELF?_grp=$DepGroup' method='post' name='hrlist'>
<table border='0' cellpadding='0' cellspacing='0'>
  <tr>
      <td  nowrap=\"nowrap\" width='25'></td>
    <td CLASS='ColumnTD2' nowrap=\"nowrap\"><div align=\"center\">
                <A HREF='$PHP_SELF?sort=2&kier=$kier&_grp=$DepGroup'>Known as</a>

       </div>  </td>
    <td CLASS='ColumnTD2' nowrap=\"nowrap\"><div align=\"center\">
                <A HREF='$PHP_SELF?sort=3&kier=$kier&_grp=$DepGroup'>Surname</a>

       </div>  </td>
   <td CLASS='ColumnTD2' nowrap=\"nowrap\"><div align=\"center\">
                <A HREF='$PHP_SELF?sort=4&kier=$kier&_grp=$DepGroup'>Job title</a></td>
       </div>  </td>
        <td CLASS='ColumnTD2' nowrap=\"nowrap\"><div align=\"center\">
                <A HREF='$PHP_SELF?sort=5&kier=$kier&_grp=$DepGroup'>Started</a></td>
      </div>   </td>
     	</tr>
".$tabletxt;
echo $tabletxt;
include_once("./footer.php");
}

elseif($state==x)
{


checkZm("id2");
//checkZm("textpostoneyear");
 $textpostoneyear=  $_POST["textpostoneyear"];
 $signed=  $_POST["signed"];
foreach ($id2 as  $key =>  $value) {



    $sql ="UPDATE `nombers`SET `nombers`.textperson= '".$textperson[$key]."' ,`nombers`.sign= '".$signed[$key]."'
       Where pno='$value'
        LIMIT 1";
 if (!$db->Open()) $db1->Kill();
	if (!$db->Query($sql))  $db->Kill();

  
   }   
  
 echo "<script language='javascript'>window.location=\"$PHP_SELF?_grp=$DepGroup\"</script>";
}

?>
