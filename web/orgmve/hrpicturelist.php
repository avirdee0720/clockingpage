 <?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$db2 = new CMySQL;
$tytul='HR List ';

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

if($state==0)
{


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
                 $sortowanie=" ORDER BY  `emplcat`.catname_staff $kier_sql,`nombers`.`knownas` ASC ";
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


/*
$q = "SELECT DISTINCT `nombers`.`pno` , `nombers`.`surname` , `nombers`.`firstname` , `nombers`.`knownas` , `nombers`.`cat` , `nombers`.`textperson` ,`nombers`.`sign` ,DATE_FORMAT( `nombers`.`started` , \"%d/%m/%Y\" ) AS d1,  `emplcat`.catname,  `emplcat`.catname_staff  FROM (`nombers` CROSS JOIN  `staffdetails` ON `nombers`.`pno` = `staffdetails`.`no`) INNER JOIN `emplcat` ON `nombers`.`cat`= `emplcat`.catozn WHERE `nombers`.`status` = 'OK'
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
*/


if(!isset($DepGroup)) {$DepGroup = "0";}
        $filter = "";
        switch ($DepGroup)
                {
                 case 0:
                 $filter = "AND  `emplcat`.catname_staff Like '%'";
                 $tytul = "ALL REGULAR";
                 break;
                case 1:
                 $filter = " AND DATEDIFF( now( ) , `nombers`.`started` ) < 730 ";
                $tytul = "REGULAR PRE - 2 YEARS";
                 break;
                case 2:
                  $filter = " AND DATEDIFF( now( ) , `nombers`.`started` ) >= 730 ";
                  $tytul = "REGULAR POST - 2 YEARS";
                 break;
                case 3:
                 $filter = "AND ( `emplcat`.catname_staff Like 'GA' or `emplcat`.catname_staff Like 'M')";
                 $tytul = "GA and Builders";
                 break;
                case 4:
                 $filter = "AND  `emplcat`.catname_staff Like 'GMA'";
                 $tytul = "GMA";
                 break;
                case 5:
                $filter = "AND  (`emplcat`.catname_staff Like 'GA' OR `emplcat`.catname_staff Like 'GMA')";
                $tytul = "GA and GMA";
                 break;
                case 6:
                $filter=" AND  `emplcat`.catname_staff Like 'SA'";
                $tytul = "SA";
                 break;
                 case 7:
                $filter=" AND  (`emplcat`.catname_staff Like 'GA' OR `emplcat`.catname_staff Like 'GMA'  OR `emplcat`.catname_staff Like 'SA')";
                 $tytul = "GA & GMA & SA";
                 break;
                case 8:
                $filter=" AND  (`emplcat`.catname_staff Like 'GA' OR `emplcat`.catname_staff Like 'GMA'  OR `emplcat`.catname_staff Like 'buyer')";
                 $tytul = "GA & GMA & BUYER";
                 break;
		case 9:
                $filter=" AND `emplcat`.`catozn` = 'ui'";
                 $tytul = "Intern";
                 break;
                case 10:
                $filter=" AND `emplcat`.`catozn` = 'ut'";
                 $tytul = "Trial Day";
                 break;
                case 11:
                $filter=" AND `emplcat`.`catozn` = 'e'";
                 $tytul = "Accounts";
                 break;
                case 12:
                $filter=" AND `emplcat`.`catozn` = 'b'";
                 $tytul = "Buyers";
                 break;
                case 13:
                $filter=" AND `emplcat`.`catozn` = 'c'";
                 $tytul = "Casuals";
                 break;
                case 14:
                $filter=" AND `emplcat`.`catozn` = 'i'";
                 $tytul = "IT";
                 break;
                default:
                 $filter = "AND  `emplcat`.catname_staff Like '%'";
                 $tytul = "ALL REGULAR";
                 break;
                }

$q = "SELECT DISTINCT `nombers`.`pno` , `nombers`.`surname` , `nombers`.`firstname` , `nombers`.`knownas` , `nombers`.`cat` , `nombers`.`textperson` ,`nombers`.`sign` ,DATE_FORMAT( `nombers`.`started` , \"%d/%m/%y\" ) AS d1,  `emplcat`.catname,  `emplcat`.catname_staff  FROM (`nombers` CROSS JOIN  `staffdetails` ON `nombers`.`pno` = `staffdetails`.`no`) INNER JOIN `emplcat` ON `nombers`.`cat`= `emplcat`.catozn WHERE `nombers`.`status` = 'OK'
AND  `nombers`.`pno` <> '5'
AND  `nombers`.`pno` <> '2087'
AND  `nombers`.`pno` <> '265'
AND  `nombers`.`pno` <> '1475'
AND  `nombers`.`pno` <> '1598'
AND  `nombers`.`pno` <> '555'
AND  `nombers`.`pno` <> '1051'
$filter
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
$pad = "0.01cm 0.01cm 0.01cm 0.01cm";
$pad = "padding:1pt 1pt 1pt 1pt";
$pad = "";
$pagebreak = "no";

  if ($db->Query($q)) 
  {
	$ileich=$db->Rows();
    $j=0;

    while ($row=$db->Row())
    {
    $j++;
    
    //  <p class='pagestart'></p>

    if ($j % 19 == 0) {$pagebreak = "
   </table>
     <DIV style=\"page-break-after:always\"></DIV>
    <table class=MsoTableGrid border=1 border='1' cellpadding='0' cellspacing='0' style='border-collapse:collapse;border:none'> 
    ";
    } else $pagebreak="";
    
	$clocking = $row->pno;
	$row_count++;
	$row_color = (($row_count % 2) == 0) ? $colour_even : $colour_odd;
	
	
	$q = "SELECT `id`,DATE_FORMAT( `opinion`.`date1` , \"%d/%m/%y\" ) As opiniondate1 , `who` , `opinion`,`opinion2`,`opinion3`  ,`opinion4`
    FROM `opinion`
    WHERE no =  '$row->pno'
    order by date1 ASC
    Limit 1
    ";

    $db2->Query($q);
    $row2=$db2->Row();
    $rows2=$db2->Rows();
    
    if (!isset($row2->id))
            $row2id = "";
    else $row2id = $row2->id;
    if (!isset($row2->opinion))
            $row2opinion = "";
    else $row2opinion = $row2->opinion;
    
    if (!isset($row->pno))
        $rowpno = "";
    else $rowpno = $row->pno;
	
  //  <img src='image1.php?cln=$row->pno' border='0' width='40'>
	$tabletxt .= "
    $pagebreak
   <tr>
   	<input name='id2[]' type='hidden' value='$row->pno'>
  <td rowspan=2 valign=top style='border:solid black 2.5pt;
  $pad' CLASS='$row_color' valign=\"middle\" >
 <img src='image1.php?cln=$row->pno' border='0' width='40'  height=\"52\"> </td>
  <td  valign=top style='border-top:solid black 2.5pt;
  border-left:none;border-bottom:solid black 1.0pt;border-right:solid black 0.5pt;
  $pad' CLASS='$row_color' valign=\"middle\" >
  <p class=MsoNormal style='margin:0cm;margin-bottom:.0001pt'><span
  style='font-size:11.0pt'><b>$row->knownas</b></span></p>
  </td>
  <td  valign=top style='border-top:solid black 2.5pt;border-right:solid black 0.5pt;border-bottom:solid black 1.0pt;
  $pad' CLASS='$row_color' valign=\"middle\">
  <p class=MsoNormal style='margin:0cm;margin-bottom:.0001pt'><span
  style='font-size:11.0pt'><b>$row->surname</b></span></p>
  </td>
  <td valign=top style='border-top:solid black 2.5pt;
  border-left:none;border-bottom:solid black 1.0pt;border-right:solid black 0.5pt; $pad' CLASS='$row_color'  width='60' valign=\"middle\">
  <p class=MsoNormal style='margin:0cm;margin-bottom:.0001pt'><span
  style='font-size:11.0pt'><b>$row->catname_staff</b></span></p>
  </td>
  <td valign=top style='border-top:solid black 2.5pt;
  border-left:none;border-bottom:solid black 1.0pt;border-right:solid black 2.5pt;
  $pad' CLASS='$row_color'  height=\"26\" width='50' valign=\"middle\">
  <p class=MsoNormal style='margin:0cm;margin-bottom:.0001pt'><span
  style='font-size:11.0pt'><b>$row->d1</b></span></p>
  </td>
 </tr>
 <tr>
  <input name='old_opinion_opinion_$row2id' type='hidden' value='$row2opinion'>
  <td  colspan=4 valign=top style='border-top:none;
  border-left:none;border-bottom:solid black 1.5pt;border-right:solid black 2.5pt;
  $pad' valign=\"middle\" >
  <p ><input style=\"border: 0px;\" size='100' maxlength='255' name='opinion_opinion_$row->pno' value=\"$row2opinion\"></p>
  </td>
 </tr>
   ";
    
  
    
    
  
   }
   
} else {
	$echo=  " 
  <tr>
    <td CLASS='DataTD'></td>
    <td CLASS='DataTD' colspan='3'>Brak dzialow</td>
  </tr>";
 $db->Kill();
}

$tabletxt .= "
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


$tabletxt = "  

<style>
<!--
 /* Font Definitions */
 @font-face
	{font-family:\"Cambria Math\";
	panose-1:2 4 5 3 5 4 6 3 2 4;}
@font-face
	{font-family:Calibri;
	panose-1:2 15 5 2 2 2 4 3 2 4;}
 /* Style Definitions */
 p.MsoNormal, li.MsoNormal, div.MsoNormal
	{margin-top:6.0pt;
	margin-right:0cm;
	margin-bottom:6.0pt;
	margin-left:0cm;
	text-align:justify;
	font-size:12.0pt;
	font-family:\"Times New Roman\",\"serif\";}
h1
	{mso-style-link:\"C�msor 1 Char\";
	margin-top:24.0pt;
	margin-right:0cm;
	margin-bottom:0cm;
	margin-left:0cm;
	margin-bottom:.0001pt;
	text-align:justify;
	page-break-after:avoid;
	font-size:14.0pt;
	font-family:\"Cambria\",\"serif\";}
h2
	{mso-style-link:\"C�msor 2 Char\";
	margin-right:0cm;
	margin-bottom:18.0pt;
	margin-left:0cm;
	text-align:justify;
	page-break-after:avoid;
	font-size:13.0pt;
	font-family:\"Cambria\",\"serif\";}
h3
	{mso-style-link:\"C�msor 3 Char\";
	margin-top:10.0pt;
	margin-right:0cm;
	margin-bottom:0cm;
	margin-left:0cm;
	margin-bottom:.0001pt;
	text-align:justify;
	page-break-after:avoid;
	font-size:12.0pt;
	font-family:\"Cambria\",\"serif\";}
span.Cmsor3Char
	{mso-style-name:\"C�msor 3 Char\";
	mso-style-link:\"C�msor 3\";
	font-family:\"Cambria\",\"serif\";
	font-weight:bold;}
span.Cmsor2Char
	{mso-style-name:\"C�msor 2 Char\";
	mso-style-link:\"C�msor 2\";
	font-family:\"Cambria\",\"serif\";
	font-weight:bold;}
span.Cmsor1Char
	{mso-style-name:\"C�msor 1 Char\";
	mso-style-link:\"C�msor 1\";
	font-family:\"Cambria\",\"serif\";
	font-weight:bold;}
.MsoPapDefault
	{margin-top:6.0pt;
	margin-right:0cm;
	margin-bottom:6.0pt;
	margin-left:0cm;
	text-align:justify;}
@page Section1
	{size:21.0cm 842.0pt;
	margin:2.0cm 2.0cm 2.0cm 2.0cm;}
div.Section1
	{page:Section1;}
-->

@media print
{
.pagestart
{
page-break-before: always;
}
}

</style>

<TD ALIGN=JUSTIFY VALIGN=TOP border=0>

<center>

<font CLASS='FormHeaderFont'>$tytul&nbsp;&nbsp;   &nbsp;&nbsp;  Total:<b> $ileich</b>
<form action='$PHP_SELF?_grp=$DepGroup' method='post' name='hrlist'>
<table class=MsoTableGrid border=1 border='1' cellpadding='0' cellspacing='0' style='border-collapse:collapse;border:none'>
   <tr>
   	<input name='id2[]' type='hidden' value='$rowpno'>
  <td valign=\"middle\" style='border:solid black 2.5pt;
  padding:0cm 0cm 0cm 0cm' CLASS='ColumnTD2'>
  </td>
  <td  valign=top style='border-top:solid black 2.5pt;
  border-left:none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0cm 0cm 0cm 0cm' CLASS='ColumnTD2'>
  <p class=MsoNormal style='margin:0cm;margin-bottom:.0001pt'><span
  style='font-size:11.0pt'><b> <A HREF='$PHP_SELF?sort=2&kier=$kier&_grp=$DepGroup'>Known as</a></b></span></p>
  </td>
  <td  valign=top style='border-top:solid black 2.5pt;
  border-left:none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0cm 0cm 0cm 0cm' CLASS='ColumnTD2'>
  <p class=MsoNormal style='margin:0cm;margin-bottom:.0001pt'><span
  style='font-size:11.0pt'><b><A HREF='$PHP_SELF?sort=3&kier=$kier&_grp=$DepGroup'>Surname</a></b></span></p>
  </td>
  <td valign=top style='border-top:solid black 2.5pt;
  border-left:none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0cm 0cm 0cm 0cm' CLASS='ColumnTD2'>
  <p class=MsoNormal style='margin:0cm;margin-bottom:.0001pt'><span
  style='font-size:11.0pt'><b><A HREF='$PHP_SELF?sort=4&kier=$kier&_grp=$DepGroup'>Job title</a></b></span></p>
  </td>
  <td valign=top style='border-top:solid black 2.5pt;
  border-left:none;border-bottom:solid black 1.0pt;border-right:solid black 2.5pt;
  padding:0cm 0cm 0cm 0cm' CLASS='ColumnTD2'>
  <p class=MsoNormal style='margin:0cm;margin-bottom:.0001pt'><span
  style='font-size:11.0pt'><b><A HREF='$PHP_SELF?sort=5&kier=$kier&_grp=$DepGroup'>Started</a></b></span></p>
  </td>
 </tr>  	
     	
     	
     	
".$tabletxt;
echo $tabletxt;
include_once("./footer.php");
}

elseif($state==1)
{


checkZm("id2");
//checkZm("textpostoneyear");
 $opinion_id=  $_POST["opinion_id"];
 $sort=  $_POST["sort"];
    $opinion_date1=date("d/m/y");
  
  if (!$db->Open()) $db->Kill();
     
foreach ($id2 as  $key =>  $value) {


 $sql ="SELECT id from `opinion` Where no='$value'";


	if (!$db->Query($sql))  $db->Kill();     
       
    $db->Query($sql);
    $rows=$db->Rows();
    

 $opinion_opinion=  mysql_real_escape_string($_POST["opinion_opinion_".$value]);
 $opinion_opinion2=  mysql_real_escape_string($_POST["opinion_opinion2_".$value]);
 $opinion_opinion3=  mysql_real_escape_string($_POST["opinion_opinion3_".$value]);
 $opinion_opinion4=  mysql_real_escape_string($_POST["opinion_opinion4_".$value]);
 $opinion_who = $_COOKIE['nazwa'];
 $opinion_whoid = $_COOKIE["id"];

  if ($rows>0) {
 
 $sql ="UPDATE `opinion` SET `opinion`.date1= STR_TO_DATE( '$opinion_date1', '%d/%m/%y'),`opinion`.who= '".$_COOKIE["nazwa"]."' ,`opinion`.whoid= '".$_COOKIE['id']."',`opinion`.opinion= '$opinion_opinion',`opinion`.opinion2= '$opinion_opinion2',`opinion`.opinion3= '$opinion_opinion3',`opinion`.opinion4= '$opinion_opinion4'
       Where no='$value'
        LIMIT 1";

	if (!$db->Query($sql))  $db->Kill();

}

else {    
     
    $ins = "INSERT INTO `opinion` ( `no`,`date1`, `who` ,`whoid`, `opinion`, `opinion2`, `opinion3`, `opinion4` ) VALUES ('$value',STR_TO_DATE( '$opinion_date1', '%d/%m/%y'),'$opinion_who','$opinion_whoid','$opinion_opinion','$opinion_opinion2','$opinion_opinion3','$opinion_opinion4')";
    if (!$db->Query($ins)) $db->Kill();

    }
  
   }      
   
     
  
echo "<script language='javascript'>window.location=\"$PHP_SELF?_grp=$DepGroup&sort=$sort&kier=$kier\"</script>";
}

?>
