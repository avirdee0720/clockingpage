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

$kier = $_GET['kier'];
for ($index = 0; $index <= 2; $index++ ) {
    if (!isset($kier_img[$index]))
        $kier_img[$index] = "";
}

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
/*
echo "<b>
<font class='FormHeaderFont'>$title</font><br>
<font >Period: $dodget - $ddoget</font><br>

</b>
<BR>
<!-- XX:$last_week_no -->
<table  bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >
  <tr>
  <td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=1&kier=$kier&startd=".$_GET['startd']."&endd=".$_GET['endd']."&_grp=".$grp."'><B>Clocking<br>number</B>$kier_img[1]</A></td>
	 <td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=2&kier=$kier&startd=".$_GET['startd']."&endd=".$_GET['endd']."&_grp=".$grp."'><B>Firstname</B>$kier_img[2]</A></td>
	 <td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=3&kier=$kier&startd=".$_GET['startd']."&endd=".$_GET['endd']."&_grp=".$grp."'><B>Surname</B>$kier_img[3]</A></td>     
     <td class='FieldCaptionTD'><div align='center'><B>Averegage <br> Weekend days  <BR>per Month</B></div></td>
     	</tr>	
";
 */
echo "<b>
<font class='FormHeaderFont'>$title</font><br>
<font >Period: $dodget - $ddoget</font><br>

</b>
<BR>
<!-- XX:$last_week_no -->
<table  bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >
  <tr>
 	 <td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=1&kier=$kier&startd=".$_GET['startd']."&endd=".$_GET['endd']."&_grp=".$grp."'><B>Known as</B>$kier_img[1]</A></td>
	 <td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=2&kier=$kier&startd=".$_GET['startd']."&endd=".$_GET['endd']."&_grp=".$grp."'><B>Surname</B>$kier_img[2]</A></td>     
     <td class='FieldCaptionTD'><div align='center'><B>Averegage <br> Weekend days  <BR>per Month</B></div></td>
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

if(!isset($sort)) {$sort=2;$kier_sql = "ASC";$sortowanie=" ORDER BY `nombers`.`knownas` $kier_sql";}
	switch ($sort)
		{
		case 1:
		 $sortowanie=" ORDER BY `nombers`.`knownas` $kier_sql";
		 break;
		case 2:
		 $sortowanie=" ORDER BY `nombers`.`surname` $kier_sql ";
		 break;
		}


if (!$db->Open()) $db->Kill();
$prac1 =("SELECT DISTINCT `pno`, `firstname`, `surname`, `knownas`,`started` ,`started`<='$dod' As early,month( '$ddo' ) - month( started )  As monthdiff,DATE_SUB((DATE_ADD(started, INTERVAL 1 MONTH)), INTERVAL DAYOFMONTH(started)-1 DAY) As nextmonthday
 FROM `nombers` inner join `totals` ON nombers.pno = totals.no WHERE totals.date1>='$dod'  AND date1<='$ddo' AND `nombers`.`cat` LIKE '$grp' AND `nombers`.`status` = 'OK' And totals.no<>5");
 
$prac1=$prac1.$sortowanie;


if (!$db->Query($prac1)) $db->Kill();
  while ($row1=$db->Row())
  {
	  $fname=$row1->firstname; 
	  $sname=$row1->surname;
	  $knownas=$row1->knownas;
	  $nr=$row1->pno;
	  $started=$row1->started; 
	  $monthdiff=$row1->monthdiff; 
	  $nextmonthday=$row1->nextmonthday; 
	  $dod2 = $dod;
	  
	  list($yearstarted,$monthstarted,$daystarted) = explode("-",$started);
	  
	  $startede=$row1->early;

    $monthnumber =$monthdiff;
    
     	if ($startede == 1) $monthnumber = 12;
      else {
      if ( $monthdiff < 0 ) $monthnumber = 12 + $monthdiff;
      if ($daystarted == "01") {$monthnumber++; }
        else {
      $dod2 =  $nextmonthday;    
        }
      }
	 
	  
	
  	$sql2 = "SELECT (count(`date1`))  AS weekenddays FROM totals WHERE no LIKE '$nr' AND date1>='$dod2' AND date1<='$ddo' AND (sunday<>0 or saturday<>0)";
		if (!$d1->Open()) $d1->Kill();
		if (!$d1->Query($sql2))  $d1->Kill();
	//	echo "<br>". 	$sql2.  "<br>";
     	$row2=$d1->Row();	
     	$weekenddays=$row2->weekenddays;
     	 
        if (!isset($monthnumber) or $monthnumber == 0) $avgweekenddaysmonth = 0;
            else $avgweekenddaysmonth=number_format($weekenddays/$monthnumber,2,'.',' ');

		echo "  <tr>
	     <td class='DataTD'>$knownas</td>
		 <td class='DataTD'>$sname</td>  
      <td class='DataTD'>$avgweekenddaysmonth</td>
		 </tr>";
/*
		echo "  <tr>
		<td class='DataTD'>$nr</td>
	     <td class='DataTD'>$fname</td>
		 <td class='DataTD'>$sname</td>  
      <td class='DataTD'>$avgweekenddaysmonth</td>
		 </tr>";


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