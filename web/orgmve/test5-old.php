<?php


function saturdaysThisMonth($clockinginno,$dateod,$datedo){
		$dbWeekends = new CMySQL; 
		unset($weekend);
	if (!$dbWeekends->Open()) $dbWeekends->Kill();
		$weekend = "SELECT COUNT(`saturday`) AS wd1, SUM(`saturday`) AS sumawd1 FROM `totals`  WHERE `date1`>='$dateod' AND `date1`<='$datedo' AND `no`='$clockinginno' AND `saturday`<>'0' GROUP BY `no` ORDER BY `no` ASC";
		if (!$dbWeekends->Query($weekend)) $dbWeekends->Kill();
		$soboty=$dbWeekends->Row();
		$saturdays=$soboty->wd1;
		$saturdayhours=$soboty->sumawd1;
	$dbWeekends->Free();
	return array($saturdays,$saturdayhours);
}

function sundaysThisMonth($clockinginno,$dateod,$datedo){
	$dbWeekends = new CMySQL; 
	unset($weekend2);
	if (!$dbWeekends->Open()) $dbWeekends->Kill();
		$weekend2 = "SELECT COUNT(`sunday`) AS wd2, SUM( `sunday` ) AS sumawd2 FROM `totals`  WHERE `date1`>='$dateod' AND `date1`<='$datedo' AND `no`='$clockinginno' AND `sunday`<>'0' GROUP BY `no` ORDER BY `no` ASC";
		if (!$dbWeekends->Query($weekend2)) $dbWeekends->Kill();
		$niedziele=$dbWeekends->Row();
		$sundays=$niedziele->wd2;
		$sundayhours=$niedziele->sumawd2;
	$dbWeekends->Free();
	return array($sundays,$sundayhours);
}

function weekenddaysTMHoliday($clockinginno,$dateod,$datedo){
		$dbWeekends = new CMySQL; 
		unset($holidsql);
	if (!$dbWeekends->Open()) $dbWeekends->Kill();
		$holidsql = "SELECT `no` , `date1`, `hourgiven` AS hoursg FROM `holidays` WHERE `holidays`.`no` ='$clockinginno' AND `holidays`.`date1` >='$dateod' AND `holidays`.`date1` <='$datedo' ORDER BY `no` ASC";
		if (!$dbWeekends->Query($holidsql)) $dbWeekends->Kill();
		$SundayHoliday = 0;
		$SaturdayHoliday = 0;
		$SundayDaysHP = 0;
		$SaturdayDaysHP = 0;
		while ($holidays=$dbWeekends->Row())
			{
			if(date("w", strtotime("$holidays->date1"))==0) {
				$SundayHoliday=$SundayHoliday+$holidays->hoursg; 
				$SundayDaysHP = $SundayDaysHP + 1; }
			elseif(date("w", strtotime("$holidays->date1"))==6) { 
				$SaturdayHoliday=$SaturdayHoliday+$holidays->hoursg; 
				$SaturdayDaysHP= $SaturdayDaysHP +1; }
			else { echo ""; }
			//$hoursgiven=$holidays->hoursg;
			}
		$dbWeekends->Free();
	$WDHoliday = $SaturdayDaysHP + $SundayDaysHP;
	$WDHolidayHours = $SundayHoliday + $SaturdayHoliday;

	return array($WDHoliday,$WDHolidayHours);
}

function WeekendDaysToDate($clockinginno,$dateod,$datedo){
	$SundaysAllToDate = 0;
	$SaturdaysAllToDate = 0;
	$HolidayDaysToDate = 0;
	$WeekendDaysToDate = 0;
	$dbWeekendsTD = new CMySQL; 

	if (!$dbWeekendsTD->Open()) $dbWeekendsTD->Kill();
		$weekenddbWeekendsTD = "SELECT COUNT(`saturday`) AS wd1, SUM(`saturday`) AS sumawd1 FROM `totals`  WHERE `date1`>='$dateod' AND `date1`<='$datedo' AND `no`='$clockinginno' AND `saturday`<>'0' GROUP BY `no` ORDER BY `no` ASC";
		if (!$dbWeekendsTD->Query($weekenddbWeekendsTD)) $dbWeekendsTD->Kill();
		$soboty1=$dbWeekendsTD->Row();
		$SaturdaysAllToDate=$soboty1->wd1;
		$dbWeekendsTD->Free();

	if (!$dbWeekendsTD->Open()) $dbWeekendsTD->Kill();
		$weekend2new = "SELECT COUNT(`sunday`) AS wd2, SUM( `sunday` ) AS sumawd2 FROM `totals`  WHERE `date1`>='$dateod' AND `date1`<='$datedo' AND `no`='$clockinginno' AND `sunday`<>'0' GROUP BY `no` ORDER BY `no` ASC";
		if (!$dbWeekendsTD->Query($weekend2new)) $dbWeekendsTD->Kill();
		$niedziele1=$dbWeekendsTD->Row();
		$SundaysAllToDate=$niedziele1->wd2;
		$dbWeekendsTD->Free();

	if (!$dbWeekendsTD->Open()) $dbWeekendsTD->Kill();
		$holidNewsql = "SELECT `no` , `date1` FROM `holidays` WHERE `holidays`.`no` ='$clockinginno' AND `holidays`.`sortof`=\"PL\" AND `holidays`.`date1` >='$dateod' AND `holidays`.`date1` <='$datedo' ORDER BY `no` ASC";
		if (!$dbWeekendsTD->Query($holidNewsql)) $dbWeekendsTD->Kill();
		while ($holidaysDTD=$dbWeekendsTD->Row())
			{
			if(date("w", strtotime("$holidaysDTD->date1"))==0) { $HolidayDaysToDate = $HolidayDaysToDate + 1; }
			elseif(date("w", strtotime("$holidaysDTD->date1"))==6) { $HolidayDaysToDate = $HolidayDaysToDate +1; }
			else { $OtherDays=$OtherDays + 1; }
			}
		$dbWeekendsTD->Free();

	$WeekendDaysToDate = $HolidayDaysToDate + $SaturdaysAllToDate + $SundaysAllToDate;

	return $WeekendDaysToDate;
}

function AllWeekendsDays($dateod,$datedo){
	$AllWeekendsDaysValue = 0;
	$dbWeekendsXX = new CMySQL; 

	if (!$dbWeekendsXX->Open()) $dbWeekendsXX->Kill();
		$weekendaysfroman = "SELECT DATE_FORMAT(`date1`, \"%W\") as t1 FROM `year` WHERE `year`.`date1` >='$dateod' AND `year`.`date1` <='$datedo' AND (DATE_FORMAT(`date1`, \"%W\") = \"Saturday\" OR DATE_FORMAT(`date1`, \"%W\") = \"Sunday\" )";
		if (!$dbWeekendsXX->Query($weekendaysfroman)) $dbWeekendsXX->Kill();
		$AllWeekendsDaysValue=$dbWeekendsXX->Rows();
	$dbWeekendsXX->Free();

	return $AllWeekendsDaysValue;
}

function datediff($interval, $datefrom, $dateto, $using_timestamps = false) {
/*
$interval can be:
yyyy - Number of full years
q - Number of full quarters
m - Number of full months
y - Difference between day numbers
(eg 1st Jan 2004 is "1", the first day. 2nd Feb 2003 is "33". The datediff is "-32".)
d - Number of full days
w - Number of full weekdays
ww - Number of full weeks
h - Number of full hours
n - Number of full minutes
s - Number of full seconds (default)
*/

if (!$using_timestamps) {
$datefrom = strtotime($datefrom, 0);
$dateto = strtotime($dateto, 0);
}
$difference = $dateto - $datefrom; // Difference in seconds

switch($interval) {

case 'yyyy': // Number of full years

$years_difference = floor($difference / 31536000);
if (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom), date("j", $datefrom), date("Y", $datefrom)+$years_difference) > $dateto) {
$years_difference--;
}
if (mktime(date("H", $dateto), date("i", $dateto), date("s", $dateto), date("n", $dateto), date("j", $dateto), date("Y", $dateto)-($years_difference+1)) > $datefrom) {
$years_difference++;
}
$datediff = $years_difference;
break;

case "q": // Number of full quarters

$quarters_difference = floor($difference / 8035200);
while (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom)+($quarters_difference*3), date("j", $dateto), date("Y", $datefrom)) < $dateto) {
$months_difference++;
}
$quarters_difference--;
$datediff = $quarters_difference;
break;

case "m": // Number of full months

$months_difference = floor($difference / 2678400);
while (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom)+($months_difference), date("j", $dateto), date("Y", $datefrom)) < $dateto) {
$months_difference++;
}
$months_difference--;
$datediff = $months_difference;
break;

case 'y': // Difference between day numbers

$datediff = date("z", $dateto) - date("z", $datefrom);
break;

case "d": // Number of full days

$datediff = floor($difference / 86400);
break;

case "w": // Number of full weekdays

$days_difference = floor($difference / 86400);
$weeks_difference = floor($days_difference / 7); // Complete weeks
$first_day = date("w", $datefrom);
$days_remainder = floor($days_difference % 7);
$odd_days = $first_day + $days_remainder; // Do we have a Saturday or Sunday in the remainder?
if ($odd_days > 7) { // Sunday
$days_remainder--;
}
if ($odd_days > 6) { // Saturday
$days_remainder--;
}
$datediff = ($weeks_difference * 5) + $days_remainder;
break;

case "ww": // Number of full weeks

$datediff = floor($difference / 604800);
break;

case "h": // Number of full hours

$datediff = floor($difference / 3600);
break;

case "n": // Number of full minutes

$datediff = floor($difference / 60);
break;

default: // Number of full seconds (default)

$datediff = $difference;
break;
}

return $datediff;

}


/*	$AllWeekendsDayInAVYearSoFar = 0;
	if (!$db4new->Open()) $db4new->Kill();
		$weekendaysfroman = "SELECT `date1` FROM `year` WHERE `year`.`date1` >='$BonusYearStart' AND `year`.`date1` <='$ddo'";
		if (!$db4new->Query($weekendaysfroman)) $db4new->Kill();
		while ($value=$db4new->Row())
			{
			if(date("w", strtotime("$value->date1"))==0) { $AllWeekendsDayInAVYearSoFar = $AllWeekendsDayInAVYearSoFar + 1; }
			elseif(date("w", strtotime("$value->date1"))==6) { $AllWeekendsDayInAVYearSoFar = $AllWeekendsDayInAVYearSoFar +1; }
			else { $OtherDays=$OtherDays + 1; }
			}
	$db4new->Free();
*/
?>
