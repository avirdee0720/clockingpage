<HTML>
<HEAD>
<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$d1 = new CMySQL;
$d3 = new CMySQL;
$title="Staff attendance - List of days, hours, avg";
$dataakt=date("d/m/Y H:i:s");
?>
<meta HTTP-EQUIV='cache-control' CONTENT='no-cache, must-revalidate'>

</HEAD>

<body class=PageBODY bgcolor=#FFFFFF topmargin=0 leftmargin=0 marginwidth=0 marginheight=0 text=#000000 link=#0000FF vlink=#0000FF alink=#FF0000>
<CENTER>
<?php
list($day, $month, $year) = explode("/",$_GET['startd']);
$dod = "$year-$month-$day";
list($day1, $month1, $year1) = explode("/",$_GET['endd']);
$ddo= "$year1-$month1-$day1";
$monthT=date("M",mktime(0, 0, 0, $month1, $day1, $year1));
$last_week_no=date("Y-m-d",mktime(0, 0, 0, $month1, $day1, $year1)-31536000);
$LastYear=date("Y-m-d",mktime(0, 0, 0, $month, $day, $year - 1));
//date("Y-m-d", strtotime("-1 year",$dod)) ;

// sprawdzic czy tabela jest przygotowana!------------------------------------------------------------------------
$db = new CMySQL;
$d = new CMySQL;
$d1 = new CMySQL;
$minPay=5.35;
echo "
<font class='FormHeaderFont'>$title - $monthT $year</font>
<BR>
<!-- XX:$last_week_no -->
<table WIDTH=100% bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >
  <tr>
	 <td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=1&kier=$kier'><B>Firstname</B>$kier_img[1]</A></td>
	 <td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=2&kier=$kier'><B>Surname</B>$kier_img[2]</A></td>
     <td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=3&kier=$kier'><B>Basic rate</B>$kier_img[3]</A></td>
	 <td class='FieldCaptionTD'><B>National Rate <BR>(New Pay Struct.)</B></td>
     <td class='FieldCaptionTD'><B>GMA/GA/<BR>BHM Rate (Paid)</B></td>
     <td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=4&kier=$kier'><B>Rate Paid From</B>$kier_img[4]</A></td>
     <td class='FieldCaptionTD'><B>Days Att $monthT</B></A></td>
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
	</tr>	
";
if(!isset($sort)) $sort=1;
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
$prac1 =("SELECT `ID`, `pno`, `firstname`, `surname`, `knownas`, `paystru`, `status`, 
`currentratefrom`, `regdays`, `bonustype`, DATE_FORMAT(`nombers`.`started`, \"%d/%m/%y\") 
as startd , `daylyrate`, `started` FROM `nombers` WHERE `status`='OK' AND `cat`<>'c'");
$prac1=$prac1.$sortowanie;

if (!$db->Query($prac1)) $db->Kill();
  while ($row1=$db->Row())
  {
	  $fname=$row1->firstname; 
	  $sname=$row1->surname;
	  $nr=$row1->pno;
	  $totalh=0;
	  if($row1->paystru == "New") { $basicrate=8.5*$minPay; }
	  else { $basicrate=$row1->daylyrate; }
	  if($row1->paystru == "New") { $natrate=$row1->daylyrate; }
	  else { $natrate=""; }
	  $minDays=($row1->regdays - 1) * 4;
	  $maxDays=($row1->regdays + 1) * 4;
	  $regdays=$row1->regdays;
	  $doSQL3data=date("Y-m-d",$row1->started);

 
		$sql2 = "SELECT AVG(`workedtime`) AS worked, COUNT(`date1`) AS dni FROM totals WHERE no LIKE '$nr' AND date1>='$dod' AND date1<='$ddo' GROUP BY no";
		if (!$d1->Open()) $d1->Kill();
		if (!$d1->Query($sql2))  $d1->Kill();
		  while ($row2=$d1->Row())
		 {		
			 $dniLastM=$row2->dni;
			 $timePDayLM=number_format($row2->worked,2,'.',' ');
			 $ABOVE = $regdays;
			 if($dniLastM > $maxDays)  $ABOVE = "ABOVE";
			 elseif($dniLastM < $minDays)  $ABOVE = "BELOW";
			 else $ABOVE = "";
		 }

		$sql3 = "SELECT AVG(`workedtime`) AS worked1, COUNT(`date1`) AS razemD FROM totals 
		WHERE no LIKE '$nr' AND date1>='$doSQL3data' AND date1<='$ddo' GROUP BY no";
		if (!$d3->Open()) $d3->Kill();
		if (!$d3->Query($sql3)) $d3->Kill();
		$DaysWorked = $d3->Rows();
		  while ($row3=$d3->Row())
		 {		
			 $dniLastS=round($row3->razemD / 12, 1); 
			 $timePDayS=number_format($row3->worked1,2,'.',' ');
		 }

	$total2=number_format($totalh,2,'.',' ');
	//if($total2=="0.00") {$pokaz="";} else {$pokaz=$total2;}
$pokaz=$total2;
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


  } 

//echo date("w", $dod);
echo "
</table>

</td></tr>
</table>";
include_once("./footer.php");

?>