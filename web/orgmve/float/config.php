<?php
// folders
$img       = 'images';
$zdjecia   = 'images/photo';
$glowna    = 'index.php?url=main.php';
$docs      = 'dokumenty';
$skr       = 'skrypty';

$ipval="192.168.0.";

// sets
$copyright = 'skrypty/copyright.php';
$email     = 'pz@mveshops.co.uk';
$adres  = 'pz@mveshops.co.uk';

$kolorTekstu = '#FFFFFF';
$kolorTlaRamki = '#0000CC';
$kolorTlaWew = '#C0C0C0';
$kolorWewTabel = '#B7FBF4';
$szerokoscRamkiGL = '100%';

// database access
$DB = "mve0";
$SRVDB = "localhost";
$USERDB = "orgmve";
$PWDB = "z";
define('PaidLeaveEntitlementForRegularStaf', 4.80);
define('PaidLeaveEntitlementForCasualStaf', 0.4);

// czas
$czas      = time();
$miesiac   = date("m",$czas);
$dzien     = date("j",$czas);
$godz      = date("G:m");
$dzis      = date("Y-m-d");
$dzis2      = date("d/m/Y");
$dz_roku   = gmDate("z")+1;
$dz_tyg_ar = array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Fiday", "Saturday");
$dz_tyg    = $dz_tyg_ar[date("w")];
$czas_int  = date("B");
$teraz = $dzis." ".$godz;
$DayYest=date("d")-1;
$YEearMon=date("Y-m");
$LastM=date("m")-1;
$Year=date("Y");
$yesterday=$YEearMon."-".$DayYest;
$YEearMon1=date("m/Y");
$yesterday1=$DayYest."/".$YEearMon1;
$FirstOfTheMonth="01/".$YEearMon1;
if(!$LastM == 0) { 
	$FirstOfLastMonth="01/".$LastM."/".$Year;
	$LastOfLastMonth="31/".$LastM."/".$Year;}
else { 
	$LastYear=date("Y")-1;
	$FirstOfLastMonth="01/12/".$LastYear;
	$LastOfLastMonth="31/12/".$LastYear;
	}


if(!isset($first0)) $first0=1;
if(!isset($start)) $start=1;
if(!isset($next0)) $next0=1;
if(!isset($last0)) $last0=1;
if(!isset($numrows)) $numrows=15;
if(!isset($sort )) $sort =1;

include("./sets.php");
?>
