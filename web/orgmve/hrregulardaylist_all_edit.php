<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$db2 = new CMySQL;
$tytul='Regural list';

uprstr($PU,90);


$DepGroup=$_GET['_grp'];
$DepGroupUpper=strtoupper($_GET['_grp']);


$decisionarray= array ("No","Yes","Don�t know","Resigned","Dismissed","Casual");
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
                 $sortowanie=" ORDER BY `regdays`.`datechange` $kier_sql,`nombers`.`knownas` ASC";
                 break;
                case 7:
                 $sortowanie=" ORDER BY `staffdetails`.`decision` $kier_sql";
                 break;
                default:
                 $sortowanie=" ORDER BY `nombers`.`started` $kier_sql ";
                 break;
        $row_count++;
	$row_color = (($row_count % 2) == 0) ? $colour_even : $colour_odd;        }
if(!isset($letter)) $letter='%';
else $letter=$letter.'%';



if (!$db->Open()) $db->Kill();
$q = "SELECT DISTINCT `nombers`.`pno` , `nombers`.`surname` , `nombers`.`firstname` , `nombers`.`knownas` , `nombers`.`cat` , `nombers`.`textperson` ,`nombers`.`sign` ,`nombers`.`regdays`,DATE_FORMAT( `nombers`.`started` , \"%d/%m/%Y\" ) AS d1,  `emplcat`.catname,  `emplcat`.catname_staff  FROM (`nombers` CROSS JOIN  `staffdetails` ON `nombers`.`pno` = `staffdetails`.`no`) INNER JOIN `emplcat` ON `nombers`.`cat`= `emplcat`.catozn WHERE `nombers`.`status` = 'OK'  
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

    $row_count++;
	  $row_color = (($row_count % 2) == 0) ? $colour_even : $colour_odd;
	
		$sql3 = "SELECT *, (mon+tue+wed+thu+fri+sat+sun) As rd FROM `regdays` WHERE no = '$row->pno' AND `regdays`.`active` = 'y' LIMIT 1";
		if (!$db2->Open()) $db2->Kill();
		if (!$db2->Query($sql3)) $db2->Kill();
		$mon="&nbsp;";
	  $tue="&nbsp;";
    $wed="&nbsp;";
    $thu="&nbsp;"; 
    $fri="&nbsp;";
    $sat="&nbsp;";
    $sun="&nbsp;";
    
    $row4=$db2->Row();
				
		if( $row4->mon == 1 ) { $mon="<IMG SRC='./images/tickgreen.jpg'  BORDER='0' ALT=''>"; } 
		if( $row4->tue == 1 ) { $tue="<IMG SRC='./images/tickgreen.jpg'  BORDER='0' ALT=''>"; } 
		if( $row4->wed == 1 ) { $wed="<IMG SRC='./images/tickgreen.jpg'  BORDER='0' ALT=''>"; } 
		if( $row4->thu == 1 ) { $thu="<IMG SRC='./images/tickgreen.jpg'  BORDER='0' ALT=''>"; } 
		if( $row4->fri == 1 ) { $fri="<IMG SRC='./images/tickgreen.jpg'  BORDER='0' ALT=''>"; } 
		if( $row4->sat == 1 ) { $sat="<IMG SRC='./images/tickgreen.jpg'  BORDER='0' ALT=''>"; } 
		if( $row4->sun == 1 ) { $sun="<IMG SRC='./images/tickgreen.jpg'  BORDER='0' ALT=''>"; }
		
		
  //  <img src='image1.php?cln=$row->pno' border='0' width='40'>
	$tabletxt .= "
  <tr>
	<input name='id2[]' type='hidden' value='$row->pno'>
	<td  nowrap=\"nowrap\" width='25'></td>
    <td CLASS='$row_color' nowrap=\"nowrap\"><b>$row->knownas</b></td>
	<td CLASS='$row_color' nowrap=\"nowrap\"><b>$row->surname</b></td>
  <td CLASS='$row_color' nowrap=\"nowrap\"><b><div align=\"center\">$row->catname_staff&nbsp;</div></b></td>
  <td CLASS='$row_color' nowrap=\"nowrap\"><b><div align=\"right\">$row->d1&nbsp;</div></b></td>
   <td CLASS='$row_color' nowrap=\"nowrap\"><b><div align=\"right\">$row4->datechange&nbsp;</div></b></td>
	<td CLASS='$row_color'><div align=\"center\">$mon</div></td>
	<td CLASS='$row_color'><div align=\"center\">$tue</div></td>
	<td CLASS='$row_color'><div align=\"center\">$wed</div></td>
	<td CLASS='$row_color'><div align=\"center\">$thu</div></td>
	<td CLASS='$row_color'><div align=\"center\">$fri</div></td>
	<td CLASS='$row_color'><div align=\"center\">$sat</div></td>
	<td CLASS='$row_color'><div align=\"center\">$sun</div></td>
	<td CLASS='$row_color'><div align=\"center\">$row4->rd</div></td>
  <td CLASS='$row_color'><div align=\"center\">$row->regdays</div></td>
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
<table border='0' cellpadding='3' cellspacing='1' >
            <tr> <td align='right' colspan='2'>
		    
		    <input name='state' type='hidden' value='1'>
		    <input name='sort' type='hidden' value='$sort'>
		 		

</td>  </tr>
</table>
</form>
";
   // class='FormTABLE'
  //   <input class='Button' name='Update' type='submit' value='$SAVEBTN'>	
  
$tabletxt = "  <TD ALIGN=JUSTIFY VALIGN=TOP border=0>

<center>

<font CLASS='FormHeaderFont'>$tytul&nbsp;&nbsp;   &nbsp;&nbsp;  Total:<b> $ileich</b>
<form action='$PHP_SELF?_grp=$DepGroup' method='post' name='hrlist'>
<table border='0' cellpadding='0' cellspacing='0'>
  <tr>
  <td  nowrap=\"nowrap\"></td>
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
      <td CLASS='ColumnTD2' nowrap=\"nowrap\"><div align=\"center\">
                Change</td>
      </div>   </td>
     		<td CLASS='ColumnTD2'>Mon</td>
	<td CLASS='ColumnTD2'>Tue</td>
	<td CLASS='ColumnTD2'>Wed</td>
	<td CLASS='ColumnTD2'>Thu</td>
	<td CLASS='ColumnTD2'>Fri&nbsp;</td>
	<td CLASS='ColumnTD2'>Sat</td>
	<td CLASS='ColumnTD2'>Sun</td>
  <td CLASS='ColumnTD2'>Sum</td>
  <td CLASS='ColumnTD2'>RD</td>
     </tr>
".$tabletxt;
echo $tabletxt;
include_once("./footer.php");
}

elseif($state==2)
{


checkZm("id2");
//checkZm("textpostoneyear");
 $opinion_id=  $_POST["opinion_id"];
 $sort=  $_POST["sort"];
foreach ($opinion_id as  $key =>  $value) {
 $opinion_date1=  $_POST["opinion_date1_".$value];
 $opinion_who=  $_POST["opinion_who_".$value];
 $opinion_opinion=  $_POST["opinion_opinion_".$value];

    $sql ="UPDATE `opinion`SET `opinion`.date1= STR_TO_DATE( '$opinion_date1', '%d/%m/%y') ,`opinion`.who= '$opinion_who',`opinion`.opinion= '$opinion_opinion'
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
