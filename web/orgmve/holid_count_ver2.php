<?php
error_reporting(E_ALL);
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$title="Holiday count for every emploee V2";
include("./inc/holid1.inc.php");
$dataakt=date("d/m/Y H:i:s");

$dod = "$year-$month-01";
$ddo= "$year-$month-31";
$firstDayYear= "$year-01-01";

function RecountLastWeek ($rok, $dataod, $datado) {
$db = new CMySQL;
$db1 = new CMySQL;
$db2 = new CMySQL;
$db3 = new CMySQL;
$db4 = new CMySQL;
$db6 = new CMySQL;
echo "<font class='FormHeaderFont'>Recounting previous week in progres.....<BR></font>";
// petla dla kazdego pracownika !!!!!!!!!!!!!!!!!!!!!!---------------------------------------------------
if (!$db->Open()) $db->Kill();
$prac1 =("SELECT `ID`, `pno`, `firstname`, `surname`, `knownas`, `status` FROM `nombers` ORDER BY `pno`");
if ($db->Query($prac1)){
while ($emploee=$db->Row())
{
$nr=$emploee->pno;

// kasowanie tabeli ------------???--------------------------------------------------------------------------
if (!$db1->Open()) $db1->Kill();
$sql0 ="DELETE FROM `sumofweek` WHERE `sumofweek`.`no`='$nr' AND `sumofweek`.`year` = '$rok' ";
if (!$db1->Query($sql0)) $db1->Kill(); 

// wybranie danych do przeniesienia do tabeli ------------------------------------------------------------
if (!$db2->Open()) $db2->Kill();
$sql1 ="SELECT `dataod`, `datado`, `weekno`  FROM `weeksno` WHERE `dataod`>='$dataod' AND `dataod`<='$datado' ";
if (!$db2->Query($sql1)) $db2->Kill();
while ($row1=$db2->Row())
{
	$weekNomber=$row1->weekno;
	$daysInTheWeek=0;
	$sumFromaWeek=0;
	if (!$db3->Open()) $db3->Kill();
	$sql4 ="SELECT  COUNT(`no`) AS ile, SUM(`workedtime`) AS wd FROM `totals` WHERE `no`='$nr' AND `date1`>='$row1->dataod' AND `date1`<='$row1->datado'  ";
	if (!$db3->Query($sql4)) $db3->Kill();
	while ($row4=$db3->Row())
		{
		//	echo "	<TR><TD>$no</TD><TD>$weekNomber</TD><TD>$row4->ile</TD><TD>$row4->wd</TD></TR>";
		$sumFromaWeek = $sumFromaWeek + $row4->wd;
		$daysInTheWeek = $daysInTheWeek + $row4->ile;
		$DaysWorked=$row4->ile;
		} 

	if (!$db6->Open()) $db6->Kill();
	$hol ="SELECT  COUNT(`no`) AS ile, SUM(`hourgiven`) AS wd FROM `holidays` WHERE `no`='$nr' AND `hourgiven`<>0 AND `sortof`='PL' AND `date1`>='$row1->dataod' AND `date1`<='$row1->datado'  ";
	if (!$db6->Query($hol)) $db6->Kill();
	while ($row6=$db6->Row())
		{
		//	echo "	<TR><TD>$no</TD><TD>$weekNomber</TD><TD>$row6->ile</TD><TD>$row6->wd</TD></TR>";
		$sumFromaWeek = $sumFromaWeek + $row6->wd;
		$daysInTheWeek = $daysInTheWeek + $row6->ile;
		$DaysPL=$row6->ile;
		} 

	if( $sumFromaWeek == 0 ) { //echo "0";
	}
	else { 
		if (!$db4->Open()) $db4->Kill();				
		$zapytanie="INSERT INTO `sumofweek` ( `id` , `week` , `days` , `sumhour` , `Wkd`, `PL`, `no` , `year` )VALUES (NULL , '$weekNomber', '$daysInTheWeek', '$sumFromaWeek',  '$DaysWorked', '$DaysPL', '$nr', '$rok');";
	if (!$db4->Query($zapytanie)) $db4->Kill();
	$db4->Free();
	}
} 

} // koniec while dla kazdego prac _____________________
} // koniec petli dla kazdego pracownika -------------------------------------------------------------------
} //end of the function

############################################################################################

// zmienne przekazane do skryptu

function HolidaysLastWeek ($WeekNo, $dataod, $datado) {
$dbase2 = new CMySQL;
$dbase3 = new CMySQL;
$dbase4 = new CMySQL;
echo "	<font class='FormHeaderFont'>Holliday</font><BR>
		<table WIDTH=500 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >";


//wyliczenie dla tygodnia
		$licznik=0;
		if (!$dbase2->Open()) $dbase2->Kill();
		$q2 = "SELECT `nombers`.`pno`, `nombers`.`cat`, `nombers`.`regdays`, `holidays`.`id`, `holidays`.`date1`, `holidays`.`sortof`, `holidays`.`hourgiven` FROM `nombers` LEFT JOIN `holidays` ON `nombers`.`pno` = `holidays`.`no` WHERE `holidays`.`date1`>='$dataod' AND `holidays`.`date1`<='$datado' AND `holidays`.`sortof`='PL' ORDER BY `holidays`.`date1`";
		if (!$dbase2->Query($q2)) $dbase2->Kill(); 
		echo "<table WIDTH=500 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >
			  <tr><td class='FieldCaptionTD' colspan='4'>Week: $WeekNo from $dataod to $datado</td>  </tr>";
	
     		while ($row2=$dbase2->Row())
			{
			$SumOf12Weeks = 0;
			$SumOf12WDays = 0;
            $RegDay = $row2->regdays;
			if ( $row2->date1 >= $dataod ) {
				$FreeDay = $row2->date1;
				$LeaveType = $row2->sortof;
				$HourGiv = $row2->hourgiven;
				$cln = $row2->pno;
				$idHOLID =  $row2->id;
				$category = $row2->cat; 
				
				//MAIN PART counting averages 

				if (!$dbase3->Open()) $dbase3->Kill();
				$daystocount = "SELECT `weeksno`.`dataod` , `weeksno`.`datado` , `weeksno`.`weekno` , `sumofweek`.`days` , `sumofweek`.`sumhour` FROM `weeksno` , `sumofweek` WHERE `weeksno`.`weekno` = `sumofweek`.`week` AND DATE_FORMAT( `weeksno`.`dataod` , \"%Y\" ) = `sumofweek`.`year` AND `sumofweek`.`no` =$cln AND `weeksno`.`datado` < '$dataod' ORDER BY `dataod` DESC LIMIT 12 ";
				if (!$dbase3->Query($daystocount)) $dbase3->Kill();
				while ($row3=$dbase3->Row())
				{
					$SumOf12Weeks = $SumOf12Weeks + $row3->sumhour;
					$SumOf12WDays = $SumOf12WDays + $row3->days;
				}
			
			if ( $SumOf12Weeks <> 0 && $category <> 'c') { $HourGiv =number_format(($SumOf12Weeks / $RegDay) / 12,2,'.',' ');   }
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
			}

  echo "</TABLE></table>";
}

# - ---------------------------------- count leavers
function LeaversLastWeek ($WeekNo, $dataod, $datado) {
$leaversdb2 = new CMySQL;
$leaversdb3 = new CMySQL;
$leaversdb4 = new CMySQL;
echo "	<font class='FormHeaderFont'>Leavers Holliday</font><BR>
		<table WIDTH=500 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >";
		$licznik=0;
		if (!$leaversdb2->Open()) $leaversdb2->Kill();
		$lq2 = "SELECT `nombers`.`pno`, `nombers`.`cat`, `nombers`.`regdays`, `hg_leavers`.`id`, `hg_leavers`.`date1`, `hg_leavers`.`sortof`, `hg_leavers`.`hourgiven`, `hg_leavers`.`daysleft` FROM `nombers` LEFT JOIN `hg_leavers` ON `nombers`.`pno` = `hg_leavers`.`no` WHERE `hg_leavers`.`date1`>='$dataod' AND `hg_leavers`.`date1`<='$datado' AND `hg_leavers`.`sortof`='PL' ORDER BY `hg_leavers`.`date1`";

		if (!$leaversdb2->Query($lq2)) $leaversdb2->Kill();

		echo "<table WIDTH=500 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >
			  <tr><td class='FieldCaptionTD' colspan='4'>Week: $WeekNo from $dataod to $datado</td>  </tr>";
	
     		while ($leaverrow2=$leaversdb2->Row())
			{
            $RegDay = $row2->regdays;
			$SumOf12Weeks = 0;
			$SumOf12WDays = 0;
			if ( $leaverrow2->date1 >= $dataod ) {
				$FreeDay = $leaverrow2->date1;
				$LeaveType = $leaverrow2->sortof;
				$HourGiv = $leaverrow2->hourgiven;
				$cln = $leaverrow2->pno;
				$idHL =  $leaverrow2->id;
				$category = $leaverrow2->cat; 
				$lefttopay = $leaverrow2->daysleft;

				//MAIN PART counting averages 
				if (!$leaversdb3->Open()) $leaversdb3->Kill();
				$daystocount = "SELECT `weeksno`.`dataod` , `weeksno`.`datado` , `weeksno`.`weekno` , `sumofweek`.`days` , `sumofweek`.`sumhour` FROM `weeksno` , `sumofweek` WHERE `weeksno`.`weekno` = `sumofweek`.`week` AND DATE_FORMAT( `weeksno`.`dataod` , \"%Y\" ) = `sumofweek`.`year` AND `sumofweek`.`no` =$cln AND `weeksno`.`datado` < '$dataod' ORDER BY `dataod` DESC LIMIT 12 ";
				if (!$leaversdb3->Query($daystocount)) $leaversdb3->Kill();
				while ($row3=$leaversdb3->Row())
				{
					$SumOf12Weeks = $SumOf12Weeks + $row3->sumhour;
					$SumOf12WDays = $SumOf12WDays + $row3->days;
				}
			
			if ( $SumOf12Weeks <> 0 && $category <> 'c') { $HourGiv =number_format(($SumOf12Weeks / $RegDay) / 12,2,'.',' ');   }
			elseif ( $SumOf12Weeks <> 0 && $category == 'c') { $HourGiv =number_format($SumOf12Weeks / 12,2,'.',' ');   }
			else { $HourGiv = "none"; }

			$totaltopay = $HourGiv * $lefttopay;
			if (!$leaversdb4->Open()) $leaversdb4->Kill();
				$toUpdaste = "UPDATE `hg_leavers` SET `hourgiven`='$HourGiv', `total`='$totaltopay' WHERE `id`='$idHL' LIMIT 1 ";
			if (!$leaversdb4->Query($toUpdaste)) $leaversdb4->Kill();

			echo " <tr>	
			 <td class='DataTD'>$leaverrow2->pno</td>
			 <td class='DataTD'><B>$FreeDay</B></td>
			 <td class='DataTD'>$LeaveType</td>
			<td class='DataTD'>$HourGiv </td> 
			<td class='DataTD'>$category </td>"; }
			}

  echo "</TABLE></table>";
}
#------------------------------end of leavers
//if($month == 1) {$yearprzel = $year - 1; $monthprzel = 12; }
//else { $yearprzel = $year; $monthprzel = $month - 1; }
//echo "Przelicz  year= $yearprzel to month= $monthprzel <A HREF='prep_week.php?year=$yearprzel&month=$monthprzel'> _RECOUNT_ALL_ </A><BR>";


echo "<font class='FormHeaderFont'>$title</font><BR>
	  <table WIDTH=500 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >";
$dbase = new CMySQL;
$dbaseOPT = new CMySQL;
//wywolanie przeliczenia poprzedniego miesiaca:

$q = "SELECT MIN( `date1` ) AS yod , MAX( `date1` ) AS ydo, `nr_week` FROM `year` WHERE `date1`>='$dod' AND `date1`<='$ddo' GROUP BY `nr_week` ORDER BY `nr_week`";
if (!$dbase->Open()) $dbase->Kill();
if ($dbase->Query($q)) 
  {
    while ($row=$dbase->Row())
    {
		// wywolanie wszystkich przeliczen
		$WeekNo = $row->nr_week;
		$dataod = substr($row->yod,0,10);
		$datado = substr($row->ydo,0,10);
		$rok = substr($row->ydo,0,4);
		HolidaysLastWeek($WeekNo, $dataod, $datado);
		RecountLastWeek($rok, $dataod, $datado);
		LeaversLastWeek($rok, $dataod, $datado);
			if (!$dbaseOPT->Open()) $dbaseOPT->Kill();
			$optimize = "OPTIMIZE TABLE `sumofweek` ";
			if (!$dbaseOPT->Query($optimize)) $dbaseOPT->Kill();

	} 
} else {
	echo "  <tr><td class='DataTD'></td><td class='DataTD' colspan='5'>SQL Error:".mysql_error()."</td> </tr>";
	$dbase->Kill();
}

echo "</table></td></tr></table>";
include_once("./footer.php");

?>
