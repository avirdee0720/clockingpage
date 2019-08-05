<HTML>
<HEAD>
<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
uprstr($PU,90);
$dataakt=date("d/m/Y H:i:s");
$msgdb = new CMySQL;
?>
<meta HTTP-EQUIV='cache-control' CONTENT='no-cache, must-revalidate'>
<link rel=stylesheet type=text/css href="hs.css">
<LINK REL='stylesheet' HREF='style/multipads/style.css' TYPE='text/css'>

</HEAD>

<body class=PageBODY bgcolor=#FFFFFF topmargin=0 leftmargin=0 marginwidth=0 marginheight=0 text=#000000 link=#0000FF vlink=#0000FF alink=#FF0000>
<CENTER>

<?php
list($day, $month, $year) = explode("/",$_GET['startd']);
$dod = "$year-$month-$day";
list($day1, $month1, $year1) = explode("/",$_GET['endd']);
$ddo= "$year1-$month1-$day1";
$sd=$_GET['startd'];
$ed=$_GET['endd'];
$DepGroup=$_GET['_grp'];
$limit=$_GET['limit'];
$dir=$_GET['dir'];
$lv=$_GET['lv'];

$DepGroupUpper=strtoupper($_GET['_grp']);

$title="0.8 weekend days of at least 7 hours required: non-qualifiers";
// TO DO: count how many months to work out hours per month
echo "

<font class='FormHeaderFont'>$title</font>


<table bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >
  <tr>
     <td class='FieldCaptionTD'><B>&nbsp;Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</B></td>
     <td class='FieldCaptionTD'><B>Weekend days (week)</B></td>
     <td class='FieldCaptionTD'><B>Average hours/day</B></td>
     
</tr>	
";
if(!isset($sort)) $sort=1;

	switch ($sort)
		{
		case 1:
		 $sortowanie=" ORDER BY `totals`.`no` ASC";
		 break;
		case 2:
		 $sortowanie=" ORDER BY `totals`.`date1` ASC ";
		 break;
		case 3:
		 $sortowanie=" ORDER BY `totals`.`intime` ASC";
		 break;
		case 4:
		 $sortowanie=" ORDER BY `totals`.`outtime` ASC";
		 break;
		case 5:
		 $sortowanie=" ORDER BY `totals`.`ILE` ASC";
		 break;
		default:
		 $sortowanie=" ORDER BY `totals`.`no`  DESC, `totals`.`workedtime` DESC";
		 break;
		}

$db = new CMySQL;
$db1 = new CMySQL; //instance of the object to inside the loop
$db2 = new CMySQL; //saturdays
$db3 = new CMySQL; //sundays
$db4 = new CMySQL; //other

if (!$db->Open()) $db->Kill();
if (!$db1->Open()) $db1->Kill();
if (!$db4->Open()) $db4->Kill();
  $filter = "";
  switch ($DepGroup)
                {
                 case 0:
                 $filter = "AND  `emplcat`.catname_staff Like '%'";
                 break;
                case 1:
                 $filter = " AND DATEDIFF( now( ) , `nombers`.`started` ) < 365 ";
                 break;
                case 2:
                  $filter = " AND DATEDIFF( now( ) , `nombers`.`started` ) >= 365 ";
                 break;
                case 3:
                 $filter = "AND  `emplcat`.catname_staff Like 'GA'";
                 break;
                case 4:
                 $filter = "AND  `emplcat`.catname_staff Like 'GMA'";
                 break;
                case 5:
                $filter = "AND  (`emplcat`.catname_staff Like 'GA' OR `emplcat`.catname_staff Like 'GMA')";
                 break;
                case 6:
                $filter=" AND  `emplcat`.catname_staff Like 'SA'";
                 break;
                case 7:
                $filter=" AND  (`emplcat`.catname_staff Like 'GA' OR `emplcat`.catname_staff Like 'GMA'  OR `emplcat`.catname_staff Like 'buyer')";
                 break;
                default:
                 $filter = "AND  `emplcat`.catname_staff Like '%'";
                 break;
                }
                
              
 if ($dir != "1") {$dir = "0";};
 $weekendfilter = "weekendrequired='$dir'";  
 $q2 = "UPDATE `defaultvalues` SET `value` = '$dir' WHERE `code` ='weekendrequired' LIMIT 1";
  
 if (!$db1->Query($q2)) $db1->Kill();
		$row2=$db1->Row();
  
$q = "SELECT DISTINCT `nombers`.`pno` , `nombers`.`surname` , `nombers`.`firstname` , `nombers`.`knownas` , `nombers`.`cat` ,started, `nombers`.`textperson` ,`nombers`.`sign` ,DATE_FORMAT( `nombers`.`started` , \"%d/%m/%Y\" ) AS d1,`nombers`.`dateforattendence`, DATE_FORMAT( `nombers`.`dateforattendence` , \"%d/%m/%Y\" ) AS dateforattendence2, `emplcat`.catname,  `emplcat`.catname_staff,`nombers`.`started`>='$dod' As s,`nombers`.`dateforattendence`>='$dod' As a FROM (`nombers` CROSS JOIN  `staffdetails` ON `nombers`.`pno` = `staffdetails`.`no`) INNER JOIN `emplcat` ON `nombers`.`cat`= `emplcat`.catozn WHERE `nombers`.`status` = 'OK'
AND  `nombers`.`pno` <> '5'
AND  `nombers`.`pno` <> '555'
$filter
AND (
`staffdetails`.`decision` <> '4'
AND `staffdetails`.`decision` <> '3'
OR `staffdetails`.`decision` IS NULL
)
AND `nombers`.`cat`<>'c'
AND $weekendfilter 
Order by knownas
";

//$q=$q.$sortowanie;



if ($db->Query($q)) 
  {
    while ($row=$db->Row())
    {
	//TO DO: work out - lest than a year, number of months
   //
    $dod2 = $dod; 
    $ddo2 = $ddo;
    
    if ($row->s == "1") {$dod2 = $row->started;}
    if ($row->a == "1") {$dod2 = $row->dateforattendence;}
    
	//	$WorkedDays =  datediff( "d", $dod2, date("Y-m-d", $ddo), false ) ;
	//	$WorkedMonths = datediff( "m", $dod2, date("Y-m-d", $ddo), false ) ;

	 
		if (!$db1->Open()) $db1->Kill();
			$q2 = "SELECT count(*) As weekendnumber from (SELECT DISTINCT date1
from inout
Where
date1 >= '$dod2'
AND date1 <= '$ddo2'
AND (
WEEKDAY( date1 ) =5
OR WEEKDAY( date1 ) =6)) As x
";

//echo $q2;
 if (!$db1->Query($q2)) $db1->Kill();
		$row2=$db1->Row();
    
$q2 = "
SELECT(COUNT(*)/($row2->weekendnumber/2)) As wenddaynumberweek,sum( sts ) /COUNT(*)/3600 As avgtime2
FROM (

SELECT 1 AS b, SUM( TIME_TO_SEC( TIMEDIFF( `outtime` , `intime` ) ) ) AS sts
FROM `inout` AS inout
WHERE no ='$row->pno'
AND (
date1 >= '$dod2'
AND date1 <= '$ddo2'
AND (
WEEKDAY( date1 ) =5
OR WEEKDAY( date1 ) =6
)
)
GROUP BY date1
) AS x
GROUP BY b

";
//echo $q2;
    if (!$db1->Query($q2)) $db1->Kill();
		$row2=$db1->Row();
		

if (round($row2->wenddaynumberweek,2)<0.8 || round($row2->avgtime2,2)<7) {		
   	 echo " <tr>
			<td class='DataTD'>$row->knownas $row->surname</td>
    <td class='FieldCaptionTD'><B>".round($row2->wenddaynumberweek,2)."</B></td>
     <td class='FieldCaptionTD'><B>".round($row2->avgtime2,2)."</B></td>
    
			</TR>  ";
			}
	

}			
			
	 	 /* echo " <tr>
			<td class='sobota'>($row->pno) $row->knownas $row->surname</td>
			<td class='sobota' colspan='6'>below 1 month</td>

      	<td class='DataTD'>$row2->avin</td>
			<td class='DataTD'>$row2->avout</td>
			<td class='DataTD'>".round($row2->hours,2)."</td>
			<td class='DataTD'>".round($row2->days / $WorkedMonths,2)."</td>
			<td class='DataTD'>".round(($row2->hours / $WorkedMonths) / 4.33 ,2)."</td>
			<td class='DataTD'>$WeekendDaysPerWeek</td>
			<td class='DataTD'>$row2->hours</td>

			</TR>  ";
		*/
	

	unset($WorkedDays);
	unset($WorkedMonths);

  } 
 else {
echo " 
  <tr>
    <td class='DataTD'></td>
    <td class='DataTD' colspan='5'>SQL Error:".mysql_error()."</td>
  </tr>";
 $db->Kill();
}

echo "
</table>
</center>
<BR>

</td></tr>
</table>";
include_once("./footer.php");

?>