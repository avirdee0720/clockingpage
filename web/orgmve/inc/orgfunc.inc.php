<?php

function EscapeSpaceAndDashes($str) {
	$str = str_replace(" ", "&nbsp;", $str);
	$str = str_replace("-", "&#x2011;", $str);
	return $str;
}

function Punctuality( $clockingNO, $dateod, $datedo ){
		$PuncBonusDB2 = new CMySQL; 
		if (!$PuncBonusDB2->Open()) $PuncBonusDB2->Kill();
			$percent0 = "SELECT `intime` FROM `totals` WHERE `date1`>='$dateod' AND `date1`<='$datedo' AND `no`='$clockingNO' ORDER BY `intime` ASC";
		if (!$PuncBonusDB2->Query($percent0)) $PuncBonusDB1->Kill();
		$punctualpercent=0;
		$punctualpercent2=0;
		$przedczasem=0;
		$poczasie=0;
		$alldaysINOUT=$PuncBonusDB2->Rows();

	    while ($percent=$PuncBonusDB2->Row())
		    {
			if(strtotime("$percent->intime") < strtotime("10:01:00"))
				{ $przedczasem++; }
			else { $poczasie++; }
			} 
	    $punctualpercent = number_format($przedczasem / $alldaysINOUT,2,'.',' ')*100;
	    $punctualpercent2 = $przedczasem / $alldaysINOUT;	

	return array($punctualpercent,$punctualpercent2);
}
		

function ToolPMenu($clockingNO, $option){
	if($option == 1) {
		$YearAct = date("Y");
        $menuP = "
		<a CLASS='DataLink' href='regdays.php?cln=$clockingNO'><IMG SRC='images/zoom.png' WIDTH='16' HEIGHT='16' BORDER='0' TITLE='Regular Days'></a>
		<a CLASS='DataLink' href='bankac1.php?cln=$clockingNO'><IMG SRC='images/device_icon.gif' WIDTH='16' HEIGHT='16' BORDER='0' TITLE='Bank account details'></a>
		<a CLASS='DataLink' href='advance1.php?cln=$clockingNO'><IMG SRC='images/expand_row.gif' WIDTH='16' HEIGHT='16' BORDER='0' TITLE='Advances'></a>
        <a CLASS='DataLink' href='pay01.php?cln=$clockingNO'><IMG SRC='images/cons_report.gif' WIDTH='16' HEIGHT='16' BORDER='0' TITLE='PAYs'></a>
        <a CLASS='DataLink' href='t_of_staff.php?cln=$clockingNO'><IMG SRC='images/last1hr.gif' WIDTH='16' HEIGHT='16' BORDER='0' TITLE='Clocking'></a>
        <a CLASS='DataLink' href='hollid1.php?cln=$clockingNO&yearAct=$YearAct'><IMG SRC='images/hollidays.gif' WIDTH='16' HEIGHT='16' BORDER='0' TITLE='Holidays'></a>
        <a CLASS='DataLink' href='ed_os_k.php?lp=$clockingNO'><IMG SRC='images/ipgrp.gif' WIDTH='16' HEIGHT='16' BORDER='0' TITLE='Properites'></a>
        <a CLASS='DataLink' href='ed_os_s.php?lp=$clockingNO'><IMG SRC='images/home.gif' WIDTH='16' HEIGHT='16' BORDER='0' TITLE='EDIT SHOP'></a>
        <a CLASS='DataLink' href='ed_os.php?lp=$clockingNO'><IMG SRC='images/edit.png' BORDER='0' TITLE='EDIT'></a>
        <a CLASS='DataLink' href='del_os.php?cln=$clockingNO'><IMG SRC='images/drop.png' BORDER='0' TITLE='DELETE'></a>";
		return $menuP;
	} else {
		$opis = "
		<IMG SRC='images/expand_row.gif' WIDTH='16' HEIGHT='16' BORDER='0' ALT='PAYs'> ADVANCES
		<IMG SRC='images/cons_report.gif' WIDTH='16' HEIGHT='16' BORDER='0' ALT='PAYs'> PAY
		<IMG SRC='images/last1hr.gif' WIDTH='16' HEIGHT='16' BORDER='0' ALT='Clocking'> TIME OF STAFF
		<IMG SRC='images/hollidays.gif' WIDTH='16' HEIGHT='16' BORDER='0' ALT='Holidays'> HOLIDAYS <BR>
		<IMG SRC='images/ipgrp.gif' WIDTH='16' HEIGHT='16' BORDER='0' ALT='Properites'> EDIT PAY STRUCTURE OF THE STAFF
		<IMG SRC='images/home.gif' WIDTH='16' HEIGHT='16' BORDER='0' ALT='EDIT SHOP'> EDIT SHOP FOR THE STAFF
		<IMG SRC='images/edit.png' BORDER='0' ALT='EDIT'> EDIT NAME ETC.
		<IMG SRC='images/drop.png' BORDER='0' ALT='DELETE'> DEL. STAFF";
		return $opis;
	}
}

function WeekendsThisMonth($clockinginno,$dateod,$datedo){
		$dbWeekends = new CMySQL; 
		unset($weekend);
	if (!$dbWeekends->Open()) $dbWeekends->Kill();
		$weekend = "SELECT COUNT(`saturday`) AS wd1, SUM(`saturday`) AS sumawd1 FROM `totals`  WHERE `date1`>='$dateod' AND `date1`<='$datedo' AND `no`='$clockinginno' AND `saturday`<>'0' GROUP BY `no` ORDER BY `no` ASC";
		if (!$dbWeekends->Query($weekend)) $dbWeekends->Kill();
		$soboty=$dbWeekends->Row();
                if (!isset($soboty->wd1)) $saturdays = 0; else $saturdays = $soboty->wd1;
                if (!isset($soboty->sumawd1)) $saturdayhours = 0; else $saturdayhours = $soboty->sumawd1;
	$dbWeekends->Free();

	unset($weekend2);
	if (!$dbWeekends->Open()) $dbWeekends->Kill();
		$weekend2 = "SELECT COUNT(`sunday`) AS wd2, SUM( `sunday` ) AS sumawd2 FROM `totals`  WHERE `date1`>='$dateod' AND `date1`<='$datedo' AND `no`='$clockinginno' AND `sunday`<>'0' GROUP BY `no` ORDER BY `no` ASC";
		if (!$dbWeekends->Query($weekend2)) $dbWeekends->Kill();
		$niedziele=$dbWeekends->Row();
                if (!isset($niedziele->wd2)) $sundays = 0; else $sundays = $niedziele->wd2;
                if (!isset($niedziele->sumawd2)) $sundayhours = 0; else $sundayhours = $niedziele->sumawd2;
	$dbWeekends->Free();
 
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


	$WeekenDayTotal = $saturdays + $sundays + $WDHoliday;
	$WeekendHoursTotal = $saturdayhours + $sundayhours + $WDHolidayHours;
	return array($WeekenDayTotal,$WeekendHoursTotal);
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
                if (!isset($soboty1->wd1)) $SaturdaysAllToDate = 0; else $SaturdaysAllToDate = $soboty1->wd1;
		$dbWeekendsTD->Free();

	if (!$dbWeekendsTD->Open()) $dbWeekendsTD->Kill();
		$weekend2new = "SELECT COUNT(`sunday`) AS wd2, SUM( `sunday` ) AS sumawd2 FROM `totals`  WHERE `date1`>='$dateod' AND `date1`<='$datedo' AND `no`='$clockinginno' AND `sunday`<>'0' GROUP BY `no` ORDER BY `no` ASC";
		if (!$dbWeekendsTD->Query($weekend2new)) $dbWeekendsTD->Kill();
		$niedziele1=$dbWeekendsTD->Row();
                if (!isset($niedziele1->wd2)) $SundaysAllToDate = 0; else $SundaysAllToDate = $niedziele1->wd2;
		$dbWeekendsTD->Free();

	if (!$dbWeekendsTD->Open()) $dbWeekendsTD->Kill();
		$holidNewsql = "SELECT `no` , `date1` FROM `holidays` WHERE `holidays`.`no` ='$clockinginno' AND `holidays`.`sortof`=\"PL\" AND `holidays`.`date1` >='$dateod' AND `holidays`.`date1` <='$datedo' ORDER BY `no` ASC";
    
    if (!$dbWeekendsTD->Query($holidNewsql)) $dbWeekendsTD->Kill();
		while ($holidaysDTD=$dbWeekendsTD->Row())
			{
			if(date("w", strtotime("$holidaysDTD->date1"))==0) { $HolidayDaysToDate = $HolidayDaysToDate + 1; }
			elseif(date("w", strtotime("$holidaysDTD->date1"))==6) { $HolidayDaysToDate = $HolidayDaysToDate +1; }
			else {
                            if(!isset($OtherDays)) $OtherDays = 0;
                            $OtherDays=$OtherDays + 1;
                        }
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


function WeekendsDays45($clockinginno,$BonusYearStart,$dod,$datedo){
	$AllWeekendsDaysValue = 0;
	$HolidayDaysToDate = 0;
	$OtherDays= 0;
	$date45 = 0;
	$dbWeekendsXX = new CMySQL; 
	if (!$dbWeekendsXX->Open()) $dbWeekendsXX->Kill();
	
	
	$holidNewsql = "SELECT count(`no`)  as weekendcount, date1 FROM `holidays` WHERE `holidays`.`no` ='$clockinginno' AND `holidays`.`sortof`=\"PL\" AND `holidays`.`date1` >='$BonusYearStart' AND `holidays`.`date1` <='$datedo' AND (DATE_FORMAT(`date1`, \"%W\") = \"Saturday\" OR DATE_FORMAT(`date1`, \"%W\") = \"Sunday\" ) group by no ";
    
    if (!$dbWeekendsXX->Query($holidNewsql)) $dbWeekendsXX ->Kill();
    $holidaysDTD=$dbWeekendsXX->Row();
    $HolidayDaysToDate = $holidaysDTD->weekendcount;
    
	   $we45number = 45 - $HolidayDaysToDate;
	   if ($we45number < 0) $we45number =0;

	
		$weekendaysfroman = "SELECT DATE_FORMAT(`date1`, \"%W\") as t1,date1 FROM `totals` WHERE `no`='$clockinginno' AND `totals`.`date1` >='$BonusYearStart'  AND `totals`.`date1` <='$datedo' AND (DATE_FORMAT(`date1`, \"%W\") = \"Saturday\" OR DATE_FORMAT(`date1`, \"%W\") = \"Sunday\" ) Order by date1 ASC LIMIT $we45number,200;";
		if (!$dbWeekendsXX->Query($weekendaysfroman)) $dbWeekendsXX->Kill();
		$AllWeekendsDaysValue=$dbWeekendsXX->Rows();
	//echo "1".$weekendaysfroman."<br>";

	if ($AllWeekendsDaysValue != 0) {
	  $row45=$dbWeekendsXX->Row();
		$date45=$row45->date1;
	  //$date45="2009-12-01";
		$weekendaysfroman = "SELECT DATE_FORMAT(`date1`, \"%W\") as t1,date1 FROM `totals` WHERE `no`='$clockinginno' AND `totals`.`date1` >'$date45' AND `totals`.`date1` >='$dod' AND `totals`.`date1` <='$datedo' AND (DATE_FORMAT(`date1`, \"%W\") = \"Saturday\" OR DATE_FORMAT(`date1`, \"%W\") = \"Sunday\" ) Order by date1 ASC";
		if (!$dbWeekendsXX->Query($weekendaysfroman)) $dbWeekendsXX->Kill();
		$row45=$dbWeekendsXX->Row();
		$date45=$row45->date1;
		//$date45="2009-12-01";
		//	echo "2".$weekendaysfroman."<br>";
  }
  else $date45=$dod;
  
	return $date45;
}


function WeekendsDays452 ($clockinginno,$BonusYearStart,$dod,$datedo){
	$AllWeekendsDaysValue = 0;
	$HolidayDaysToDate = 0;
	$OtherDays= 0;
	$date45 = 0;
	$dbWeekendsXX = new CMySQL; 
	if (!$dbWeekendsXX->Open()) $dbWeekendsXX->Kill();
	
	$sql = "
	
	(
SELECT DISTINCT `totals`.date1 AS date2, `totals`.date1<'$dod' As date3,1
FROM `totals`
WHERE `totals`.no =$clockinginno
AND `totals`.date1 >= '$BonusYearStart'
AND (
`totals`.saturday <>0
OR `totals`.sunday <>0)
)
UNION (
SELECT DISTINCT `holidays`.`date1`, `holidays`.date1<'$dod',2
FROM `holidays`
WHERE `holidays`.no =$clockinginno
AND `holidays`.date1 >= '$BonusYearStart'
AND (
DATE_FORMAT( `holidays`.`date1` , \"%W\" ) = \"Saturday\"
OR DATE_FORMAT( `holidays`.`date1` , \"%W\" ) = \"Sunday\"
)
)
order by date2
Limit 45, 200

";	

//echo $sql;
//echo $sql."<br>";


            if (!$dbWeekendsXX->Query($sql)) $dbWeekendsXX ->Kill();
        	 $row45=$dbWeekendsXX->Row();
        	$AllWeekendsDaysValue=$dbWeekendsXX->Rows();
	$c=0;
	if ($AllWeekendsDaysValue != 0) {
	for ($i=0;($i<$AllWeekendsDaysValue && $c==0);$i++) {
	 
    if ($row45->date3 == "0") {$date45=$row45->date2;$c=1;}
    $row45=$dbWeekendsXX->Row();
    }
        
  }  
	else $date45=$dod;
	
	return $date45;
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

//to call the function: Entitlement( $casual, $regday, $DateOfHire, $StartOfHilidYear);
function Entitlement( $catCasual, $RegDay, $startedDAY, $ENYearStart ) {
	$HowManyDaysFromStart =  datediff( "d", $startedDAY, date("Y-m-d", time()), false ) ;
	$daysFrom0112 =  datediff( "d", $ENYearStart, date("Y-m-d", time()), false ) ;
	$LL = PaidLeaveEntitlementForRegularStaf;
	$PerCent = 0;

	if($HowManyDaysFromStart < 365) {
	 if($HowManyDaysFromStart > $daysFrom0112) { $HowManyDaysFromStart =  $daysFrom0112; }

	  $PerCentInYear = ($HowManyDaysFromStart / 365);
	  $PerCent = round( ($HowManyDaysFromStart / 365) * 100);

	 if($catCasual=="y") { 		
		  $PLEntitlement = round( $LL * $PerCentInYear, 2);
	 } else {  
		  $PLEntitlement = round(( $LL * $RegDay) * $PerCentInYear, 2);
	 }
	} else {

		if($catCasual=="n") { round($PLEntitlement = $LL * $RegDay, 2); 
		} else { $PLEntitlement = $LL ; }
	}

	return array( $PLEntitlement, $PerCent, $HowManyDaysFromStart, $LL );
}

function Entitlement3( $catCasual, $RegDay, $startedDAY, $ENYearStart,$dataToday ){


	$HowManyDaysFromStart =  datediff( "d", $startedDAY, $dataToday, false ) ;
  $HowManyMonthsFromStart =  datediff( "m", $startedDAY,$dataToday, false )+1 ;
	$daysFrom0112 =  datediff( "d", $ENYearStart, date("Y-m-d", time()), false ) ;
	$LL = PaidLeaveEntitlementForRegularStaf;
  $LL = 5.6;
  $Entitlementconstans = array (
  array(0.5, 0.9, 1.4, 1.9, 2.3),
  array(0.4, 1.0, 1.4, 1.8, 2.4),
  array(0.5, 0.9, 1.4, 1.9, 2.3),
  array(0.5, 0.9, 1.4, 1.9, 2.3),
  array(0.4, 1.0, 1.4, 1.8, 2.4),
  array(0.5, 0.9, 1.4, 1.9, 2.3),
  array(0.5, 0.9, 1.4, 1.9, 2.3),
  array(0.4, 1.0, 1.4, 1.8, 2.4),
  array(0.5, 0.9, 1.4, 1.9, 2.3),
  array(0.5, 0.9, 1.4, 1.9, 2.3),
  array(0.4, 1.0, 1.4, 1.8, 2.4),
  array(0.5, 0.9, 1.4, 1.9, 2.3)
                                
  );
  
  
  $Entitlementconstans = array (
  array(0.5, 0.9, 1.4, 1.9, 2.3),
  array(0.9, 1.9, 2.8, 3.7, 4.7),
  array(1.4, 2.8, 4.2, 5.6, 7.0),
  array(1.9, 3.7, 5.6, 7.5, 9.3),
  array(2.3, 4.7, 7.0, 9.3, 11.7),
  array(2.8, 5.6, 8.4, 11.2, 14.0),
  array(3.3, 6.5, 9.8, 13.1, 16.3),
  array(3.7, 7.5, 11.2, 14.9, 18.7),
  array(4.2, 8.4, 12.6, 16.8, 21.0),
  array(4.7, 9.3, 14.0, 18.7, 23.3),
  array(5.1, 10.3, 15.4, 20.5, 25.7),
  array(5.6, 11.2, 16.8, 22.4, 28.0)
                                
  );
  
  
  
   $PLEntitlement2 =0;	
     
	if($HowManyMonthsFromStart < 12) {
	 $HowManyMonthsFromStart++;
   if($HowManyDaysFromStart > $daysFrom0112) { $HowManyDaysFromStart =  $daysFrom0112;
   
   $HowManyMonthsFromStart =  datediff( "m", $ENYearStart,$dataToday, false )+2 ;
   
    }

	  $PerCentInYear = ($HowManyMonthsFromStart / 12);
	  $PerCent = round( ($HowManyDaysFromStart / 365) * 100);
    $RegDay2 = $RegDay;
    if ($RegDay >5) $RegDay2=5;
    
	 if($catCasual=="y") { 		
		  $PLEntitlement = round( $LL * $HowManyMonthsFromStart/12, 2);
		   $PLEntitlement2 = $Entitlementconstans[$HowManyMonthsFromStart-1][0];
	//	        echo  "sss - $HowManyMonthsFromStart, $RegDay<br>". $Entitlementconstans[$HowManyMonthsFromStart-1][0];
	 } else {  
		  $PLEntitlement = round(( $LL * $RegDay2) * $HowManyMonthsFromStart/12, 2);
		  $PLEntitlement2 = $Entitlementconstans[$HowManyMonthsFromStart-1][$RegDay2-1];
//		       echo   "sss - $HowManyMonthsFromStart, $RegDay<br>". $Entitlementconstans[$HowManyMonthsFromStart-1][$RegDay-1];
	 }
	} else {

		if($catCasual=="n") { round($PLEntitlement = $LL * $RegDay, 2); 
		} else { $PLEntitlement = $LL ; }
	}
   if ($PLEntitlement > $LL*5)  $PLEntitlement = $LL*5;
   
   if ($PLEntitlement2 ==0) $PLEntitlement2 =$PLEntitlement;    
	return array( $PLEntitlement, $PerCent, $HowManyMonthsFromStart, $LL,$PLEntitlement2 );
}



//to call the function: Entitlement( $casual, $regday, $DateOfHire, $StartOfHilidYear);
function Entitlement2( $catCasual, $RegDay, $startedDAY, $ENYearStart ){
	$HowManyDaysFromStart =  datediff( "d", $startedDAY, date("Y-m-d", time()), false ) ;
	$HowManyMonthsFromStart = datediff( "m", $startedDAY, date("Y-m", time())."-01", false ) ;
	//echo "HM ".	$HowManyMonthsFromStart."  d ";
	$daysFrom0112 =  datediff( "d", $ENYearStart, date("Y-m-d", time()), false ) ;
	$LL = PaidLeaveEntitlementForRegularStaf;
	$LC =PaidLeaveEntitlementForCasualStaf;

	if($HowManyDaysFromStart < 365) {
	 if($HowManyDaysFromStart > $daysFrom0112) { $HowManyDaysFromStart =  $daysFrom0112;
          $HowManyMonthsFromStart = datediff( "m", $daysFrom0112, date("Y-m", time())."-01", false ) ; }
    echo "Number of Months ".	$HowManyMonthsFromStart.",   ";
	  $PerCentInYear = ($HowManyDaysFromStart / 365);
	  $PerCent = round( ($HowManyDaysFromStart / 365) * 100);

	 if($catCasual=="y") { 		
		  $PLEntitlement = round( $LC* ($HowManyMonthsFromStart+1), 2);
	 } else {  
	//	  $PLEntitlement = round(( $LL * $RegDay) * $PerCentInYear, 2);
		    $PLEntitlement = round(( $LL * $RegDay) * ($HowManyMonthsFromStart+1)/12, 2);
	 }
	} else {
                $PerCent = round( ($HowManyDaysFromStart / 365) * 100);
		if($catCasual=="n") { round($PLEntitlement = $LL * $RegDay, 2); 
		} else { $PLEntitlement = $LC* ($HowManyMonthsFromStart+1); }
	}

	return array( $PLEntitlement, $PerCent, $HowManyDaysFromStart, $LL );
}

function Years() {

$thisyear = date ("Y");
$years = array();
for ($i=2006;$i<=$thisyear+1;$i++) {
$years[]=$i;
}
return $years;
}

function Yearsp1() {

$thisyear = date ("Y");
$years = array();
for ($i=2006;$i<=$thisyear+2;$i++) {
$years[]=$i;
}
return $years;
}


function YearsSelect() {

$YearsSelectHtml ="";
$thisyear = date ("Y");
$years=Years();

foreach ($years as $key => $value) {
    if ($value != $thisyear) { $YearsSelectHtml.= "<option value='$value'>$value</option>\n";}
    else   { $YearsSelectHtml.= "<option value='$value' selected>$value</option>\n";}
}
return $YearsSelectHtml;
}


function TaxYearsSelect() {

$TaxYearsSelectHtml ="a";
$thisyear = date ("Y");
$thismonth = date ("m");

if ($thismonth>3) $thisyear++;

$years=Yearsp1();

foreach ($years as $key => $value) {
$value2 = $value-1;
     if ($value != $thisyear) { $TaxYearsSelectHtml.= "<option value='$value'>$value2 - $value</option>\n";}
    else   { $TaxYearsSelectHtml.= "<option value='$value' selected>$value2 - $value</option>\n";}
}

return $TaxYearsSelectHtml;
}


function MonthsSelect() {

$monthlist = array("January","February","March","April","May","June","July","August","September","October","November","December");
$monthlistvalue = array("01","02","03","04","05","06","07","08","09","10","11","12" ); 

$MonthsSelectHtml ="";
$thismonth = date ("m");

foreach ($monthlist as $key => $value) {
    if ($key != $thismonth-1) { $MonthsSelectHtml.= "<option value='$monthlistvalue[$key]'>$value</option>\n";}
    else   { $MonthsSelectHtml.= "<option value='$monthlistvalue[$key]' selected>$value</option>\n";}
}


return $MonthsSelectHtml;
}


 /*
	$AllWeekendsDayInAVYearSoFar = 0;
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
