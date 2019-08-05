<HTML>
<HEAD>
<?php
include("./inc/mysql.inc.php");
include("./config.php");
include("./languages/$LANGUAGE.php");
$dataakt=date("d/m/Y H:i:s");
$msgdb = new CMySQL;

?>
<meta HTTP-EQUIV='cache-control' CONTENT='no-cache, must-revalidate'>

<LINK REL='stylesheet' HREF='style/multipads/style.css' TYPE='text/css'>

</HEAD>

<body class=PageBODY bgcolor=#FFFFFF topmargin=0 leftmargin=0 marginwidth=0 marginheight=0 text=#000000 link=#0000FF vlink=#0000FF alink=#FF0000>
<CENTER>
<?php

$dod = "$year-$month-01";
$ddo= "$year-$month-31";
$firstDayYear= "$year-01-01";

echo "
<font class='FormHeaderFont'>COUNTING Holliday</font>
<BR>
<table WIDTH=500 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >
 
";

$db2 = new CMySQL;
$db3 = new CMySQL;
$db4 = new CMySQL;
$db5 = new CMySQL;

echo "<table WIDTH=500 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' ><tr>    <td class='FieldCaptionTD' colspan='4'></td> </tr>   ";

		if (!$db2->Open()) $db2->Kill();
		$q2 = "SELECT * FROM `holidays` WHERE `holidays`.`date1`>='$dod' AND `holidays`.`date1`<='$ddo' ORDER BY  `holidays`.`no`, `holidays`.`date1`";
		if (!$db2->Query($q2)) $db2->Kill();
		
     		while ($row2=$db2->Row())
			{
			$FreeDay = $row2->date1;
			$LeaveType = $row2->sortof;
			$HourGiv = $row2->hourgiven;
			$cln=$row2->no;
			//$DateHP=date("w", $row2->date1);
			$DateHP=date("w",strtotime($row2->date1));	
			$DateHP1=date("W",strtotime($row2->date1));	
			$PrevWeek=$DateHP1-1;
			$CountPrevWeeks=0;
			$TotalHours=0;
			$TotalDays=0;
// TODO: the same operations for holidays table
		while ( $CountPrevWeeks < 13 ) :
				$sumFromaWeek=0;
				$daysInTheWeek=0;
				
				if (!$db4->Open()) $db4->Kill();
				    $q4 = "SELECT DATE_FORMAT(MIN(`date1`), \"%Y-%m-%d\") as d1a, DATE_FORMAT(MAX(`date1`), \"%Y-%m-%d\") as d2a FROM `year` WHERE `nr_week`='$PrevWeek' AND `date1`>='$firstDayYear' AND `date1`<='$ddo' ";
				if (!$db4->Query($q4)) $db4->Kill();
				
				$rowDates=$db4->Row();
				$dataOd=$rowDates->d1a;
				$dataDo=$rowDates->d2a;

				if (!$db5->Open()) $db5->Kill();				
				$q5 = "SELECT `date1`, `no`, `workedtime` FROM `totals` WHERE `no`='$cln' AND `date1`>='$dataOd' AND `date1`<='$dataDo'";
				if (!$db5->Query($q5)) $db5->Kill();
				while ($rowDatesW=$db5->Row())
				{
					 $sumFromaWeek=$sumFromaWeek+$rowDatesW->workedtime;
					 $daysInTheWeek=$daysInTheWeek++;
				}

				
					$TotalHours = $TotalHours + $sumFromaWeek;
					$TotalDays = $TotalDays + $daysInTheWeek;
					if($sumFromaWeek <> 0) { 
						$CountPrevWeeks++; 
					$PrevWeek = $PrevWeek - 1;
				}
//$a = array('one' => 'adin');
//foreach ($t as $k => $v) {
			endwhile;  
			echo " <tr>	
			 <td class='DataTD'>$cln</td>
			 <td class='DataTD'><B>$FreeDay</B></td>
			 <td class='DataTD'>$LeaveType</td>
			<td class='DataTD'>$HourGiv <B>TotalHours: $TotalHours</B>&nbsp;<B>TotalDays: $TotalDays</B></td> ";
			}

  echo "</TABLE>";
 if($row->sortof = "PL") $razemPL++;
 else $razemUPL++;


echo "
</table>

</td></tr>
</table>";
include_once("./footer.php");

?>
