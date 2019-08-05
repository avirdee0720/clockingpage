<HTML>
<HEAD>
<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$d1 = new CMySQL;
$d3 = new CMySQL;

$dataakt=date("d/m/Y H:i:s");


?>
<meta HTTP-EQUIV='cache-control' CONTENT='no-cache, must-revalidate'>

</HEAD>

<body class=PageBODY bgcolor=#FFFFFF topmargin=0 leftmargin=0 marginwidth=0 marginheight=0 text=#000000 link=#0000FF vlink=#0000FF alink=#FF0000>
<CENTER>
<?php
$dodget = $_GET['startd'];
$ddoget = $_GET['endd'];
$grp = $_GET['_grp'];

list($day, $month, $year) = explode("/",$_GET['startd']);
$dod = "$year-$month-$day";
list($day1, $month1, $year1) = explode("/",$_GET['endd']);
$ddo= "$year1-$month1-$day1";
$monthT=date("M",mktime(0, 0, 0, $month, $day, $year));
$last_week_no=date("Y-m-d",mktime(0, 0, 0, $month1, $day1, $year1)-31536000);
$LastYear=date("Y-m-d",mktime(0, 0, 0, $month1, $day1, $year1 - 1));
$LastYearget =date("d/m/Y",mktime(0, 0, 0, $month1, $day1, $year1 - 1));
//date("Y-m-d", strtotime("-1 year",$dod)) ;

// sprawdzic czy tabela jest przygotowana!------------------------------------------------------------------------
$db = new CMySQL;
$d = new CMySQL;
$d1 = new CMySQL;

/// Weekenddaysnumber of month

  $sql2 = "SELECT  count(`date1`)  AS satdaysnumber FROM totals WHERE date1>='$dod' AND date1<='$ddo' AND dayofweek(`date1`)='7' group by date1";

	if (!$d1->Open()) $d1->Kill();
		if (!$d1->Query($sql2))  $d1->Kill();
		 	
     	$satdaysnumber=$d1->Rows();

  $sql2 = "SELECT  count(`date1`)  AS sundaysnumber FROM totals WHERE date1>='$dod' AND date1<='$ddo' AND dayofweek(`date1`)='1' group by date1";

    if (!$d1->Open()) $d1->Kill();
		if (!$d1->Query($sql2))  $d1->Kill();

     	$sundaysnumber=$d1->Rows();
  
  
 if ($grp == '%') {$catozn = "ALL MVE Employee";}
 else {
 
  $sql2 = "SELECT `catozn`, `catname` FROM `emplcat` Where `catozn`='$grp'";

    if (!$d1->Open()) $d1->Kill();
		if (!$d1->Query($sql2))  $d1->Kill();
      $r=$db->Row();
     	$catozn=$r->catozn;
 }       
 $title="Staff Weekend attendance /Last 12 Month/<br>Category: $catozn"; 
echo "<b>
<font class='FormHeaderFont'>$title</font><br>
<font >Period: $dodget - $ddoget</font><br>

</b>
<BR>
<!-- XX:$last_week_no -->
<table  bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >
  <tr>
	 <td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=1&kier=$kier&startd=".$_GET['startd']."&endd=".$_GET['endd']."&_grp=".$grp."'><B>Firstname</B>$kier_img[1]</A></td>
	 <td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=2&kier=$kier&startd=".$_GET['startd']."&endd=".$_GET['endd']."&_grp=".$grp."'><B>Surname</B>$kier_img[2]</A></td>
      <td class='FieldCaptionTD'><div align='center'><B>Started</B></div></td>
     <td class='FieldCaptionTD'><div align='center'><B>Weekend<BR>Days</B></div></td>
     <td class='FieldCaptionTD'><div align='center'><B>Number of<BR>Necessary<BR>Weekend<BR>Days per Year</B></div></td>
      <td class='FieldCaptionTD'><div align='center'><B>Regular<BR>Weekend<BR>Days</B></div></td>
     <td class='FieldCaptionTD'><div align='center'><B>SAT - SUN</B></div></td>
    
     <td class='FieldCaptionTD'><div align='center'><B>Weekend<BR>Hours</B></div></td>
     <td class='FieldCaptionTD'><div align='center'><B>Average<BR>Weekend Hours<BR> per Day </B></div></td>
     <td class='FieldCaptionTD'><div align='center'><B>Averegage <br> Weekend days  <BR>per Month</B></div></td>
     <td class='FieldCaptionTD'><div align='center'><B>Average<BR>Weekend Hours<BR> per Month</B></div></td>
     	</tr>	
";
/* 
	 <td class='FieldCaptionTD'><B>National Rate <BR>(New Pay Struct.)</B></td>
     <td class='FieldCaptionTD'><B>GMA/GA/<BR>BHM Rate (Paid)</B></td>
     <td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=4&kier=$kier'><B>Rate Paid From</B>$kier_img[4]</A></td>
     <td class='FieldCaptionTD'><B>Days Att $month</B></A></td>
     <td class='FieldCaptionTD'><B>Hours per day $monthT</B></td>
     <td class='FieldCaptionTD'><B>Av Hours <BR>per Day </B></td>
     <td class='FieldCaptionTD'><B>Av Days Att <BR>Prev 12 Months</B></td>
     <td class='FieldCaptionTD'><B>Min Days <BR>Per Month</B></td>
     <td class='FieldCaptionTD'><B>Max Days <BR>Per Month</B></td>
     <td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=6&kier=$kier'><B>Reg Days <BR>Per Week</B>$kier_img[6]</A></td>
     <td class='FieldCaptionTD'><B>Bellow / Above <BR>Reg Days <BR>Per Month </B></td>
     <td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=5&kier=$kier'><B>Bonus <BR>Type</B>$kier_img[5]</A></td>
     <td class='FieldCaptionTD'><B>Av W/end Days <BR>Prev 12 Months</B></td>
     <td class='FieldCaptionTD'><B>Av W/end Days <BR>Current Bonus Year</B></td>
     <td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=7&kier=$kier'><B>Start date</B>$kier_img[7]</A></td>
*/

if(!isset($sort)) {$sort=1;$kier_sql = "ASC";}
	switch ($sort)
		{
		case 1:
		 $sortowanie=" ORDER BY `nombers`.`firstname` $kier_sql";
		 break;
		case 2:
		 $sortowanie=" ORDER BY `nombers`.`surname` $kier_sql ";
		 break;
		case 3:
		 $sortowanie=" ORDER BY `nombers`.`daylyrate` $kier_sql";
		 break;
		case 4:
		 $sortowanie=" ORDER BY `nombers`.`currentratefrom` $kier_sql";
		 break;
		case 5:
		 $sortowanie=" ORDER BY `nombers`.`bonustype` $kier_sql";
		 break;
		case 6:
		 $sortowanie=" ORDER BY `nombers`.`regdays` $kier_sql";
		 break;
		case 7:
		 $sortowanie=" ORDER BY `nombers`.`started` $kier_sql";
		 break;		
		}


if (!$db->Open()) $db->Kill();
$prac1 =("SELECT DISTINCT `pno`, `firstname`, `surname`, `knownas`,`started`
 FROM `nombers` inner join `totals` ON nombers.pno = totals.no WHERE totals.date1>='$dod' AND date1<='$ddo' AND `nombers`.`cat` LIKE '$grp' AND `nombers`.`status` = 'OK' ");
 
$prac1=$prac1.$sortowanie;


if (!$db->Query($prac1)) $db->Kill();
  while ($row1=$db->Row())
  {
	  $fname=$row1->firstname; 
	  $sname=$row1->surname;
	  $nr=$row1->pno;
	  $started=$row1->started;

	 
	  
		$sql2 = "SELECT AVG(`workedtime`) AS worked, COUNT(`date1`) AS dni,SUM(`workedtime`) AS workedsum, (count(`saturday`)+count(`sunday`))  AS weekenddays,(SUM(`saturday`)+SUM(`sunday`))  AS weekendhours FROM totals WHERE no LIKE '$nr' AND date1>='$dod' AND date1<='$ddo' GROUP BY no";
		if (!$d1->Open()) $d1->Kill();
		if (!$d1->Query($sql2))  $d1->Kill();
		 	
     	$row2=$d1->Row();	
     	
			 $dniLastM=$row2->dni;
			 $timePDayLM=number_format($row2->worked,2,'.',' ');
			 $timePDayLMsum=number_format($row2->workedsum,2,'.',' ');
	
			 $weekendhours=number_format($row2->weekendhours,2,'.',' ');
			 
	
  	$sql2 = "SELECT (count(`date1`))  AS weekenddays FROM totals WHERE no LIKE '$nr' AND date1>='$dod' AND date1<='$ddo' AND (sunday<>0 or saturday<>0)";
		if (!$d1->Open()) $d1->Kill();
		if (!$d1->Query($sql2))  $d1->Kill();
		 	
     	$row2=$d1->Row();	
     	$weekenddays=$row2->weekenddays;
     	 $avgweekendhours=number_format($weekendhours/$weekenddays,2,'.',' ');
     	 
     	 $sql2 = "SELECT DISTINCT Month(date1) FROM totals WHERE no LIKE '$nr' AND date1>='$dod' AND date1<='$ddo' Group by Month(date1)";
		if (!$d1->Open()) $d1->Kill();
		if (!$d1->Query($sql2))  $d1->Kill();
		 	
     	$row2=$d1->Row();	
     	$monthnumber=$d1->Rows();	
     	$avgweekenddaysmonth=number_format($weekenddays/$monthnumber,2,'.',' ');
     	$avgweekendhoursmonth =number_format($weekendhours/$monthnumber,2,'.',' ');
  
			 
	/// number of weekend's regular day
	
	$sql2 = "SELECT sat As rdsat, sun as rdsun,  (sat+sun) as rdweekend  FROM `regdays` Where  no LIKE '$nr' order by datechange desc  limit 1";
		if (!$d1->Open()) $d1->Kill();
		if (!$d1->Query($sql2))  $d1->Kill();
		 	
     	$row2=$d1->Row();	
     	
			 $rdsat=$row2->rdsat;
			 $rdsun=$row2->rdsun;
			 $rdwd=$row2->rdweekend;
	// number of sat, sun and weekend..	
  	 
			 	$totalweekenddays = 0;
			 	
  if ($rdsat !=0 ) $totalweekenddays += $satdaysnumber;
  if ($rdsun !=0 ) $totalweekenddays += $sundaysnumber;
  
if ($totalweekenddays != 0)
     {$percentrdwdnumber = number_format($weekenddays/$totalweekenddays,2,'.',' ')*100;$percentrdwd = $percentrdwdnumber. " %";}
else {
if ($weekenddays == 0) {$percentrdwd = "0 %";}
      else    {$percentrdwd = "Extra work";}
}
		echo "  <tr>
	     <td class='DataTD'>$fname</td>
		 <td class='DataTD'>$sname</td>  
     <td class='DataTD'>$started</td> 
		  <td class='DataTD'><B>$weekenddays</B></td>
		   <td class='DataTD'>$totalweekenddays</td>
		    <td class='DataTD'><B>$rdwd</B></td>
		    <td class='DataTD'>$rdsat - $rdsun</td>
		  <td class='DataTD'>$weekendhours</td>
		  <td class='DataTD'>$avgweekendhours</td>
		  <td class='DataTD'>$avgweekenddaysmonth</td>
		  <td class='DataTD'>	$avgweekendhoursmonth</td>
		 </tr>";

/*
	  	echo "  <tr>
	     <td class='DataTD'>$fname</td>
		 <td class='DataTD'>$sname</td> 
		 <td class='DataTD'>$basicrate</td>
		 <td class='DataTD'>$natrate</td>
		 <td class='DataTD'>to do</td>
		 <td class='DataTD'>$row1->currentratefrom</td>
		 <td class='DataTD'>$dniLastM</td>
		 <td class='DataTD'>$timePDayLM</td>
		 <td class='DataTD'>$timePDayS</td>
		 <td class='DataTD'>$dniLastS</td>
		 <td class='DataTD'>$minDays</td>
		 <td class='DataTD'>$maxDays</td>
		 <td class='DataTD'>$row1->regdays</td>
		 <td class='DataTD'>$ABOVE</td>
		 <td class='DataTD'>$row1->bonustype</td>
		 <td class='DataTD'>to do</td>
		 <td class='DataTD'>to do</td>
		<td class='DataTD'>$row1->startd</td>
		</tr>";

*/
  } 

//echo date("w", $dod);
echo "
</table>

</td></tr>
</table>";
include_once("./footer.php");

?>