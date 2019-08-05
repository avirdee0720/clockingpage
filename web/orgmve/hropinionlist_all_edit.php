<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$db2 = new CMySQL;
$tytul='Opinion list<br>date - who - opinion';

uprstr($PU,90);

$DepGroup=$_GET['_grp'];
$DepGroupUpper=strtoupper($_GET['_grp']);

$decisionarray= array ("No","Yes","Don't know","Resigned","Dismissed","Casual");
$decisiondontknow = 0;
$tabletxt = "";

if (!$db->Open()) $db->Kill();
if (!$db2->Open()) $db2->Kill();

if (!isset($_POST['state'])) $state = 0; else $state = $_POST['state'];
if (!isset($_POST['id2'])) $id2 = array(); else $id2 = $_POST['id2'];
if (!isset($_POST['opinion_id'])) $opinion_id = array(); else $opinion_id = $_POST['opinion_id'];
if (!isset($_POST['sort'])) $sort = ""; else $sort = $_POST['sort'];

if($state==0)
{

if (!$db->Open()) $db->Kill();

if(!isset($sort)) {$sort="5";$kier_sql ="DESC";}

        switch ($sort)
                {
                case 1:
                 $sortowanie=" ORDER BY `nombers`.`started` DESC";
                 break;
                case 2:
                 $sortowanie=" ORDER BY `nombers`.`knownas` $kier_sql ";
                 break;
                case 3:
                 $sortowanie=" ORDER BY `nombers`.`surname` $kier_sql";
                 break;
                case 4:
                 $sortowanie=" ORDER BY `nombers`.`cat` $kier_sql,`nombers`.`knownas` ASC ";
                 break;
                case 5:
                 $sortowanie=" ORDER BY `nombers`.`started` $kier_sql,`nombers`.`knownas` ASC";
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
$q = "SELECT DISTINCT `nombers`.`pno`, `nombers`.`surname`, `nombers`.`firstname`, `nombers`.`knownas`, `nombers`.`cat`, `nombers`.`textperson`, `nombers`.`sign`, DATE_FORMAT( `nombers`.`started` , \"%d/%m/%Y\" ) AS d1, `staffdetails`.`decision`, `emplcat`.catname, `emplcat`.catname_staff
FROM (`nombers` CROSS JOIN  `staffdetails` ON `nombers`.`pno` = `staffdetails`.`no`)
INNER JOIN `emplcat` ON `nombers`.`cat`= `emplcat`.catozn
WHERE `nombers`.`status` = 'OK'
AND  `nombers`.`pno` <> '5'
AND  `nombers`.`pno` <> '2087'
AND  `nombers`.`pno` <> '265'
AND  `nombers`.`pno` <> '1475'
AND  `nombers`.`pno` <> '1598'
AND  `nombers`.`pno` <> '555'
AND  `nombers`.`pno` <> '1051'
AND  `emplcat`.catname_staff Like '$DepGroup'
AND (
`staffdetails`.`decision` <> '4'
AND `staffdetails`.`decision` <> '3'
OR `staffdetails`.`decision` IS NULL
)
AND `nombers`.`cat`<>'c'
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
  //  <img src='image1.php?cln=$row->pno' border='0' width='40'>
	$tabletxt .= "
  <tr>
	<input name='id2[]' type='hidden' value='$row->pno'>
	<td  nowrap=\"nowrap\" width='25'></td>
  <td  nowrap=\"nowrap\" CLASS='$row_color'><img src='image1.php?cln=$row->pno' border='0' width='40'></td>
    <td CLASS='$row_color' nowrap=\"nowrap\"><b>$row->knownas</b></td>
	<td CLASS='$row_color' nowrap=\"nowrap\"><b>$row->surname</b></td>
  <td CLASS='$row_color' nowrap=\"nowrap\"><b><div align=\"center\">$row->catname_staff&nbsp;</div></b></td>
  <td CLASS='$row_color' nowrap=\"nowrap\"><b><div align=\"right\">$row->d1&nbsp;</div></b></td>
   </tr>";
    
    $q = "SELECT `id`,DATE_FORMAT( `opinion`.`date1` , \"%d/%m/%y\" ) As opiniondate1 , `who` , `opinion` 
    FROM `opinion`
    WHERE no =  '$row->pno'
    order by date1 ASC
    ";
  $c=0; 
  
  $colextra = "<td  nowrap=\"nowrap\" colspan=\"4\" CLASS='$row_color'>"; 
  if ($db2->Query($q)) 
  {
	$rows2=$db2->Rows();
  
    while ($row2=$db2->Row())
    {
    
     if ($c==0) $c=1;
   else $colextra = "<td  nowrap=\"nowrap\" width='50' CLASS='$row_color'></td>
   <td  nowrap=\"nowrap\" colspan=\"4\" CLASS='$row_color'>
   "; 
    
    
      $tabletxt .= " 
     <tr>
     <input name='opinion_id[]' type='hidden' value='$row2->id'>
  <td  nowrap=\"nowrap\" width='25'></td>
 <td  nowrap=\"nowrap\" width='40' CLASS='$row_color'>&nbsp;</td>
   <td  nowrap=\"nowrap\" colspan=\"4\" CLASS='$row_color'>
 <input class='Input' size='10' maxlength='20' name='opinion_date1_$row2->id' value=\"$row2->opiniondate1\">
  <input class='Input' size='30' maxlength='120' name='opinion_who_$row2->id' value=\"$row2->who\">
  <input class='Input' size='50' maxlength='255' name='opinion_opinion_$row2->id' value=\"$row2->opinion\">
     </td>
    </tr>
     ";
    }
    
   if ($rows2 == 0) $colextra = "<td  nowrap=\"nowrap\" colspan=\"4\" CLASS='$row_color'>"; 
  else $colextra = "<td  nowrap=\"nowrap\" width='50' CLASS='$row_color'></td>
   <td  nowrap=\"nowrap\" colspan=\"4\" CLASS='$row_color'>
   ";
   
      $tabletxt .= " 
     <tr>
  <td  nowrap=\"nowrap\" width='25'></td>
  <td  nowrap=\"nowrap\" width='40' CLASS='$row_color'>&nbsp;</td>
   <td  nowrap=\"nowrap\" colspan=\"4\" CLASS='$row_color'>
 <input class='Input' size='10' maxlength='20' name='add_opinion_date1_$row->pno'>
  <input class='Input' size='30' maxlength='120' name='add_opinion_who_$row->pno'>
  <input class='Input' size='50' maxlength='120' name='add_opinion_opinion_$row->pno'>
     </td>
    </tr>
 <tr>
  <td  nowrap=\"nowrap\" width='25'></td>
	<td  nowrap=\"nowrap\" colspan=\"5\" CLASS='$row_color'>
 &nbsp;
     </td>
    </tr>   
     ";
    
    
  }
  
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
		    <input name='sort' type='hidden' value='$sort'>
		   <input class='Button' name='Update' type='submit' value='$SAVEBTN'>			

</td>  </tr>
</table>
</form>
";


$tabletxt = "  <TD ALIGN=JUSTIFY VALIGN=TOP border=0>

<center>

<font CLASS='FormHeaderFont'>$tytul&nbsp;&nbsp;   &nbsp;&nbsp;  Total:<b> $ileich</b>
<form action='$PHP_SELF?_grp=$DepGroup' method='post' name='hrlist'>
<table border='0' cellpadding='0' cellspacing='0'>
  <tr>
  <td  nowrap=\"nowrap\"></td>
  <td  nowrap=\"nowrap\" CLASS='ColumnTD2' width='50'>&nbsp;</td>
    <td CLASS='ColumnTD2' nowrap=\"nowrap\" width='100'><div align=\"center\">
                <A HREF='$PHP_SELF?sort=2&kier=$kier&_grp=$DepGroup'>Known as</a>
       </div>  </td>
    <td CLASS='ColumnTD2' nowrap=\"nowrap\" width='100'><div align=\"center\">
                <A HREF='$PHP_SELF?sort=3&kier=$kier&_grp=$DepGroup'>Surname</a>
       </div>  </td>
   <td CLASS='ColumnTD2' nowrap=\"nowrap\" width='100'><div align=\"center\">
                <A HREF='$PHP_SELF?sort=4&kier=$kier&_grp=$DepGroup'>Job title</a></td>
       </div>  </td>
        <td CLASS='ColumnTD2' nowrap=\"nowrap\" width='50'><div align=\"center\">
                <A HREF='$PHP_SELF?sort=5&kier=$kier&_grp=$DepGroup'>Started</a></td>
      </div>   </td>
     	</tr>
".$tabletxt;
echo $tabletxt;
include_once("./footer.php");
}

elseif($state==1)
{


checkZm("id2");
//checkZm("textpostoneyear");
foreach ($opinion_id as  $key =>  $value) {
 $opinion_date1 = $_POST["opinion_date1_".$value];
 $opinion_who = $_POST["opinion_who_".$value];
 $opinion_opinion = $_POST["opinion_opinion_".$value];

    $sql ="UPDATE `opinion` SET `opinion`.date1= STR_TO_DATE( '$opinion_date1', '%d/%m/%y') ,`opinion`.who= '$opinion_who',`opinion`.opinion= '$opinion_opinion'
       Where id='$value'
        LIMIT 1";
 if (!$db->Open()) $db1->Kill();
	if (!$db->Query($sql))  $db->Kill();

  
   } 
   
 
foreach ($id2 as  $key =>  $value) {
  
    $opinion_date1=  $_POST["add_opinion_date1_".$value];
    $opinion_who =  $_POST["add_opinion_who_".$value];
    $opinion_opinion =  $_POST["add_opinion_opinion_".$value];
 
  if ($opinion_who != "" &&  $opinion_opinion!="") {
  
    if ($opinion_date1 == "")  $opinion_date1=date("d/m/y");

    $ins = "INSERT INTO `opinion` ( `no`,`date1`, `who` , `opinion` ) VALUES ('$value',STR_TO_DATE( '$opinion_date1', '%d/%m/%y'),'$opinion_who','$opinion_opinion')";
    if (!$db->Query($ins)) $db->Kill();

    }
  
   }      
   
     
  
 echo "<script language='javascript'>window.location=\"$PHP_SELF?_grp=$DepGroup&sort=$sort&kier=$kier\"</script>";
}

?>
