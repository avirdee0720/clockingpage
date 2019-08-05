<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$db2 = new CMySQL;

$DepGroup=$_GET['_grp'];
$DepGroupUpper=strtoupper($_GET['_grp']);

if   ($kier_sql == "DESC")   $kier_sql = "ASC";
else        $kier_sql = "DESC" ;

uprstr($PU,90);

$tabletxt = "";

if (!$db->Open()) $db->Kill();
if (!$db2->Open()) $db2->Kill();

if (!isset($_POST['state'])) $state = 0; else $state = $_POST['state'];
if (!isset($_POST['id2'])) $id2 = array(); else $id2 = $_POST['id2'];
if (!isset($_POST['textperson'])) $textperson = array(); else $textperson = $_POST['textperson'];
if (!isset($_POST['signed'])) $signed = array(); else $signed = $_POST['signed'];

if($state==0)
{
 
if(!isset($sort)) {$sort="4";$kier_sql ="DESC";}

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


$tytul='Pre Two Years Staff';
$tabletxt2 ="";


if (!$db->Open()) $db->Kill();
$q = "SELECT DISTINCT `nombers`.`pno` , `nombers`.`surname` , `nombers`.`firstname` , `nombers`.`knownas` , `nombers`.`cat` ,`nombers`.`textperson` , `nombers`.`sign`, DATE_FORMAT( `nombers`.`started` , \"%d/%m/%y\" ) AS d1,  `emplcat`.catname,  `emplcat`.catname_staff FROM (`nombers` CROSS JOIN  `staffdetails` ON `nombers`.`pno` = `staffdetails`.`no`) INNER JOIN `emplcat` ON `nombers`.`cat`= `emplcat`.catozn WHERE `nombers`.`status` = 'OK'  AND `nombers`.`cat`<>'c' AND(DATEDIFF( now( ) , `nombers`.`started` ) < 365*2 or `nombers`.`started` is NULL or `nombers`.`started` = '0000-00-00')
AND  `emplcat`.catname_staff Like '$DepGroup'
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
 
	
	$tabletxt2 .= "<tr>
		<input name='id2[]' type='hidden' value='$row->pno'>
		<td  nowrap=\"nowrap\" width='25'></td>
  <td CLASS='$row_color' nowrap=\"nowrap\"><b>$row->knownas</b></td>
	<td CLASS='$row_color' nowrap=\"nowrap\"><b>$row->surname</b></td>
  <td CLASS='$row_color' nowrap=\"nowrap\"><b><div align=\"center\"><b>$row->catname_staff</b></td>
  <td CLASS='$row_color' nowrap=\"nowrap\"><b><div align=\"right\"><b>$row->d1</b></td>
   <td CLASS='ColumnTD2' nowrap=\"nowrap\"  width='220'><b><input class='Input' size='38' maxlength='120' name='textperson[]' value=\"$row->textperson\"></b>
               </td>
   <td CLASS='$row_color' nowrap=\"nowrap\"  width='18'><div align=\"right\">
    <select name='signed[]'
   <b>$singlistcode</b>
     </select>
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
<form action='$PHP_SELF?_grp=$DepGroup' method='post' name='hrlist'>
<table border='0' cellpadding='0' cellspacing='0'>
  <tr>
     <td  nowrap=\"nowrap\" width='25'></td>
    <td CLASS='ColumnTD2' nowrap=\"nowrap\"><div align=\"center\">
                <A HREF='$PHP_SELF?sort=1&kier=$kier&_grp=$DepGroup'>Known as</a>

      </td>
    <td CLASS='ColumnTD2' nowrap=\"nowrap\"><div align=\"center\">
                <A HREF='$PHP_SELF?sort=2&kier=$kier&_grp=$DepGroup'>Surname</a>

       </td>
   <td CLASS='ColumnTD2' nowrap=\"nowrap\"><div align=\"center\">
                <A HREF='$PHP_SELF?sort=3&kier=$kier&_grp=$DepGroup'>Job title</a></td>
       </td>
        <td CLASS='ColumnTD2' nowrap=\"nowrap\"><div align=\"center\">
                <A HREF='$PHP_SELF?sort=4&kier=$kier&_grp=$DepGroup'>Started</a></td>
       </td>
                 <td CLASS='ColumnTD2' nowrap=\"nowrap\" >&nbsp;</td>
				</td>
                 <td CLASS='ColumnTD2' nowrap=\"nowrap\" >&nbsp;</td>
				</tr>
				$tabletxt2
</center>
<BR>
</td></tr>
</table>
 <br>
";


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
//$textpostoneyear=  $_POST["textpreoneyear"];

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
