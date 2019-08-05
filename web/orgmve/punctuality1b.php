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
$limit10=$_GET['limit10'];
$dir10=$_GET['dir10'];
$lv10=$_GET['lv10'];

$limit20=$_GET['limit20'];
$dir20=$_GET['dir20'];
$lv20=$_GET['lv20'];


$DepGroupUpper=strtoupper($_GET['_grp']);
$title=" Punctuality";
// TO DO: count how many months to work out hours per month
echo "

<font class='FormHeaderFont'>$title <BR>Dates: $sd until $ed <br></font>


<table bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >
  <tr>
     <td class='FieldCaptionTD'><B>&nbsp;Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</B></td>
     <td class='FieldCaptionTD'><B>Before 10 A.M.</B></td>
     <td class='FieldCaptionTD'><B>After 8 P.M.</B></td>
     <td class='FieldCaptionTD'><B>Total</B></td>
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
                 $filter = " AND DATEDIFF( now( ) , `nombers`.`started` ) < 365*2 ";
                 break;
                case 2:
                  $filter = " AND DATEDIFF( now( ) , `nombers`.`started` ) >= 365*2 ";
                 break;
                case 3:
                 $filter = "AND  (`emplcat`.catname_staff Like 'GA' or `emplcat`.catname_staff Like 'build')";
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
                case 8:
                $filter=" AND  (`emplcat`.catname_staff Like 'acc')";
                 break;
                case 9:
                $filter=" AND  (`emplcat`.catname_staff Like 'IT')";
                 break;
                case 10:
                $filter=" AND  (`emplcat`.catname_staff Like 'buyer')";
                 break;
                case 11:
                $filter=" AND  (`emplcat`.catname_staff Like 'casual')";
                 break;
                case 12:
                    $filter = " AND (`emplcat`.catname_staff NOT IN ('casual', 'buyer', 'director'))";
                break;
                default:
                 $filter = "AND  `emplcat`.catname_staff Like '%'";
                 break;
                }

if ($lv10 == "1") {
                $q2 = "UPDATE `defaultvalues` SET `value` = '$limit10' WHERE `code` ='punctualitylimit10' LIMIT 1;
  ";

 if (!$db1->Query($q2)) $db1->Kill();
		//$row2=$db1->Row();
 if ($limit10 == "0") $dir10 = 'a';
            $q2 = "
UPDATE `defaultvalues` SET `value` = '$dir10' WHERE `code` ='punctualitylimitdir10' LIMIT 1;  ";

 if (!$db1->Query($q2)) $db1->Kill();
		//$row2=$db1->Row();
						
   }

if ($lv20 == "1") {
                $q2 = "UPDATE `defaultvalues` SET `value` = '$limit20' WHERE `code` ='punctualitylimit20' LIMIT 1;
  ";

 if (!$db1->Query($q2)) $db1->Kill();
		//$row2=$db1->Row();
 if ($limit20 == "0") $dir20 = 'a';
            $q2 = "
UPDATE `defaultvalues` SET `value` = '$dir20' WHERE `code` ='punctualitylimitdir20' LIMIT 1;  ";

 if (!$db1->Query($q2)) $db1->Kill();
		//$row2=$db1->Row();
						
   }   

$q = "SELECT DISTINCT `nombers`.`pno` , `nombers`.`surname` , `nombers`.`firstname` , `nombers`.`knownas` , `nombers`.`cat` ,started, `nombers`.`textperson` ,`nombers`.`sign` ,DATE_FORMAT( `nombers`.`started` , \"%d/%m/%Y\" ) AS d1,  `emplcat`.catname,  `emplcat`.catname_staff,`nombers`.`started`>='$dod' As s  FROM (`nombers` CROSS JOIN  `staffdetails` ON `nombers`.`pno` = `staffdetails`.`no`) INNER JOIN `emplcat` ON `nombers`.`cat`= `emplcat`.catozn WHERE `nombers`.`status` = 'OK'
AND  `nombers`.`pno` <> '5'
AND  `nombers`.`pno` <> '555'
$filter
AND (
`staffdetails`.`decision` <> '4'
AND `staffdetails`.`decision` <> '3'
OR `staffdetails`.`decision` IS NULL
)
AND `nombers`.`cat`<>'c'
Order by knownas
";

//$q=$q.$sortowanie;

//echo $q."<br>";

if ($db->Query($q)) 
  {
    while ($row=$db->Row())
    {
	//TO DO: work out - lest than a year, number of months
   //
    $dod2 = $dod; 
    $ddo2 = $ddo;
    
    if ($row->s == "1") {$dod2 = $row->started;} else {$dod2 = $dod;}
    

	 
		if (!$db1->Open()) $db1->Kill();
			$q2 = "SELECT count(*) As daynumber from (SELECT DISTINCT date1
FROM `inout` 
WHERE no ='$row->pno'
AND 
date1 >= '$dod2'
AND date1 <= '$ddo2'
) As x
";

//echo $q2."<br>";
 if (!$db1->Query($q2)) $db1->Kill();
		$row2=$db1->Row();
 $daynumber=   $row2->daynumber;
$q2 = "
SELECT DISTINCT date1, min(intime)
FROM `inout` 
WHERE no ='$row->pno'
AND 
date1 >= '$dod2'
AND date1 <= '$ddo2'
AND
`intime`<'10:00:00'
 group by date1

";
//echo $q2;
    if (!$db1->Query($q2)) $db1->Kill();
		$row2=$db1->Row();
		$rows2=$db1->Rows();
                if ($daynumber == 0) $punctuality10 = 0; else $punctuality10 = round($rows2/ $daynumber,2)*100;

$q2 = "
SELECT DISTINCT date1, max(outtime)
FROM `inout` 
WHERE no ='$row->pno'
AND 
date1 >= '$dod2'
AND date1 <= '$ddo2'
AND
`outtime`>'20:00:00'
 group by date1

";
//echo $q2;
    if (!$db1->Query($q2)) $db1->Kill();
		$row2=$db1->Row();
		$rows2=$db1->Rows();

    if ($daynumber == 0) $punctuality20 = 0; else $punctuality20 = round($rows2/ $daynumber,2)*100;   
   
if ($lv10=="1") {
if ($dir10 == "a" && $punctuality10<$limit10*100)  $punctuality10="&nbsp;"; 
if ($dir10 == "b" && $punctuality10>$limit10*100)  $punctuality10="&nbsp;"; 
}

if ($lv20=="1") {
if ($dir20 == "a" && $punctuality20<$limit20*100)  $punctuality20="&nbsp;"; 
if ($dir20 == "b" && $punctuality20>$limit20*100)  $punctuality20="&nbsp;";  
}
	    

if ($punctuality10!="&nbsp;" || $punctuality20!="&nbsp;") {    

$punctualitytotal = $punctuality10 + $punctuality20;
if ($punctuality10!="&nbsp;")  $punctuality10="$punctuality10%";
if ($punctuality20!="&nbsp;")  $punctuality20="$punctuality20%";

if ($punctuality10 == "0") $punctuality10="0%";
if ($punctuality20 == "0") $punctuality20="0%";

	 echo " <tr>
                    <td class='DataTD'>$row->knownas $row->surname</td>
                    <td class='FieldCaptionTD'><B>$punctuality10</B></td>
                    <td class='FieldCaptionTD'><B>$punctuality20</B></td>
                    <td class='FieldCaptionTD'><B>$punctualitytotal%</B></td>
                </TR>  ";
  
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
} else {
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