<?php

error_reporting(E_ALL);
include("./inc/mysql.inc.php");
include("./inc/holid1.inc.php");
include("./config.php");
include("./languages/$LANGUAGE.php");
$dataakt=date("d/m/Y H:i:s");

$dod = "$year-$month-01";
$ddo= "$year-$month-31";
$firstDayYear= "$year-01-01";
$rok = $year;
$year = $year;
$month = $month;

echo "
<font class='FormHeaderFont'>Holliday</font>
<BR>
<table WIDTH=500 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >";
$r1 = new CMySQL;
$dbase = new CMySQL;
$dbase2 = new CMySQL;
$dbase3 = new CMySQL;
$dbase4 = new CMySQL;
$dbase5 = new CMySQL;

if (!$r1->Open()) $r1->Kill();
$qr1= "SELECT `nr_week`  FROM `year` WHERE `date1`='$dod' LIMIT 1";
if (!$r1->Query($qr1)) $r1->Kill();
$week1 = $r1->Row();

if(!isset($week1->nr_week)) {
$q = "SELECT `dataod`, `datado`, `weekno`  FROM `weeksno` WHERE `dataod`>='$dod' AND `dataod`<='$ddo'  ";
} else { 
$q = "SELECT `dataod`, `datado`, `weekno`  FROM `weeksno` WHERE `weekno`='$week1->nr_week' OR `dataod`>='$dod' AND `dataod`<='$ddo'  ";
}

if (!$dbase->Open()) $dbase->Kill();
$razem=0;
if ($dbase->Query($q)) 
  {
    while ($row=$dbase->Row())
    {
		$WeekNo = $row->weekno;
		$licznik=0;
		if (!$dbase2->Open()) $dbase2->Kill();
		$q2 = "SELECT nombers.pno, nombers.cat, holidays.id, holidays.date1, holidays.sortof, holidays.hourgiven FROM nombers LEFT JOIN holidays ON nombers.pno = holidays.no WHERE holidays.date1>='$row->dataod' AND holidays.date1<='$row->datado' AND holidays.sortof='PL' ORDER BY holidays.date1";
		if (!$dbase2->Query($q2)) $dbase2->Kill();

echo "<table WIDTH=500 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >
			<tr>    <td class='FieldCaptionTD' colspan='4'><FONT COLOR=$colour>
			<A HREF='hollid1.php?cln=$row->no'><B>$row->no</B></A>	
				
			&nbsp;$row3->firstname $row3->surname has taken <B>$row->w</B> days off $dupa</FONT></td>
			  </tr>   ";
	
     		while ($row2=$dbase2->Row())
			{
			$SumOf12Weeks = 0;
			$SumOf12WDays = 0;
			if ( $row2->date1 >= $dod ) {
				$FreeDay = $row2->date1;
				$LeaveType = $row2->sortof;
				$HourGiv = $row2->hourgiven;
				$cln = $row2->pno;
				$idHOLID =  $row2->id;
				$category = $row2->cat; 
				
				//MAIN PART counting averages 

				if (!$dbase3->Open()) $dbase3->Kill();
				$daystocount = "SELECT `days`, `sumhour` FROM `sumofweek` WHERE `week` <'$WeekNo' AND `no` = '$cln' AND `year` = '$rok' ORDER BY `week` DESC LIMIT 12 ";
				if (!$dbase3->Query($daystocount)) $dbase3->Kill();

				while ($row3=$dbase3->Row())
				{
					$SumOf12Weeks = $SumOf12Weeks + $row3->sumhour;
					$SumOf12WDays = $SumOf12WDays + $row3->days;
				}
			
			if ( $SumOf12Weeks <> 0 && $category <> 'c') { $HourGiv =number_format($SumOf12Weeks / $SumOf12WDays,2,'.',' ');   }
			elseif ( $SumOf12Weeks <> 0 && $category == 'c') { $HourGiv =number_format($SumOf12Weeks / 12,2,'.',' ');   }
			else { $HourGiv = "none"; }

			if (!$dbase4->Open()) $dbase4->Kill();
				$toUpdaste = "UPDATE `holidays` SET `hourgiven`='$HourGiv' WHERE `id`='$idHOLID' LIMIT 1 ";
			if (!$dbase4->Query($toUpdaste)) $dbase4->Kill();

			echo " <tr>	
			 <td class='DataTD'>$row2->pno</td>
			 <td class='DataTD'><B>$FreeDay</B></td>
			 <td class='DataTD'>$LeaveType</td>
			<td class='DataTD'>$HourGiv </td> 
			<td class='DataTD'>$category </td>"; }

//RecountEveryOne ($year, $month);

			}

  echo "</TABLE>";
 if($row->sortof = "PL") $razemPL++;
 else $razemUPL++;
  } 
} else {
echo " 
  <tr>
    <td class='DataTD'></td>
    <td class='DataTD' colspan='5'>SQL Error:".mysql_error()."</td>
  </tr>";
 $dbase->Kill();
}

echo "
</table>

</td></tr>
</table>";
include_once("./footer.php");

?>
