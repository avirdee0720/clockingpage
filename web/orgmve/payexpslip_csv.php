<?php
include("./config.php");

list($day, $month, $year) = explode("/",$_GET['endd']);
$dataToday = "$year-$month-$day";
$dod = ($year - 1)."-12-01";
$ddo = "$year-12-31";

$dataakt = date("dmY-Hi");
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=to-payslips" .$dataakt.".csv");
header("Pragma: no-cache");
header("Expires: 0");

// start of CSV file
echo "Payroll no,Known as,Surname,Month,Category,Unit,E. in weeks,E. in days,Taken,Left,BonusType,Wends TD,AV TD,NO need,AV need,From,To,Vouchers".PHP_EOL;

$db = new CMySQL;
$vouchers_db = new CMySQL;
$holiday_db = new CMySQL;

if (!$db->Open()) $db->Kill();
// fetch all employees who are actively employed or who have left the company
// at or after the start of the month the export was generated for
$q = "
SELECT CASE WHEN n.`status` = 'LEAVER' THEN CONCAT('L', n.pno) ELSE n.pno END pno,
       n.knownas,
       n.firstname,
       n.surname,
       n.`status`,
       n.regdays,
       n.started,
       n.left1 ,
       n.dateforbonus,
       n.cat,
       n.from1,
       n.to1,
       n.bonustype,
       e.catname_account,
       e.catname,
       (n.regdays * 4) AS enti,
       is_eligible_for_2018_voucher_scheme(n.pno) AS has_2018_voucher_scheme,
	   n.VE AS voucher_entitlement
 FROM nombers n
	INNER JOIN emplcat e ON n.cat = e.catozn
WHERE (n.`status` = 'OK' OR (n.`status` = 'LEAVER' AND n.left1 >= '$year-$month-01'))
  AND n.cat NOT IN ('con')
ORDER BY n.pno
";

if (!$db->Query($q)) $db->Kill();

while ($row = $db->Row()) {
	$clockinginno = $row->pno;
	$monthX = date("M-y", strtotime($dataToday));
	$dateforbonus = $row->dateforbonus;
	if (!isset($dateforbonus) || !$dateforbonus) {
		$dateforbonus = "";
		$BonusYearStart = "";
		$BonusYearEnd = "";
		$DataFrom = "";
		$DataTo = "";
	}
	else {
		$PYBS = new StaffDates($dataToday, $dateforbonus);
		$BonusYearStart = $PYBS->CurrentBonusYearStarted();
		$BonusYearEnd = $PYBS->CurrentBonusYearEnd();
		$DataFrom = date("M", strtotime("$BonusYearStart"));
		$DataTo = date("M", strtotime("$BonusYearEnd"));
	}
	
	$WithHold = "";
	if ($row->voucher_entitlement > 0) {
		if (!$vouchers_db->Open()) $vouchers_db->Kill();
		$q = "SELECT vouchersdue, withold FROM payvoucher WHERE `no` = '$row->pno' AND date1 = '$dataToday'";
		if (!$vouchers_db->Query($q)) $vouchers_db->Kill();
		if ($vouchers_db->Rows() > 0) {
			$vouchers_row = $vouchers_db->Row();
			$Vouchers = $vouchers_row->vouchersdue;
			if ($vouchers_row->withold == "y")
				$WithHold = "WHOLD";
		}
		else {
			$Vouchers = 0;
		}
	} else {
		$Vouchers = "";
	}
	
	$HolidayDays = 0;
	if (!$holiday_db->Open()) $holiday_db->Kill();
	$q = "SELECT COUNT(*) AS holidays FROM holidays WHERE `no` = '$row->pno' AND date1 >= \"$dod\" AND date1 <= \"$ddo\" AND `sortof` = \"PL\" ORDER BY date1";
	if (!$holiday_db->Query($q)) $holiday_db->Kill();
	$holiday_row = $holiday_db->Row();
	$HolidayDays = $holiday_row->holidays;

	$row->catname == "casual" ? $cat = "y" : $cat = "n";
	list ($entit, $procent, $iledni) = Entitlement($cat, $row->regdays, $row->started, $dod);

	$category = "$row->catname_account";
	$left = $entit - $HolidayDays;
	$entit1 = "";
	$entit2 = "";
	if ($row->catname <> "casual" ) { 
		$unit = "days";
		$entit2 = $entit;
	} else { 
		$unit =  "weeks";
		$entit1 = $entit;
	}

	if ($row->bonustype == "WEND")
		$BT = "W/end";
	else
		$BT = $row->bonustype;
	
	$WeekendDaysToDate = "";
	$WeekendDaysNeed = "";
	$AVWeekendDays = "";
	$AVToDo = "";
	//Calculate the numbers only for when the bonustype is weekend (WEND) or when the bonustype is NONE but the
	//new 2018 voucher conditions are satisfied
	if (($row->bonustype == "WEND") || (($row->bonustype == "NONE") && ($row->has_2018_voucher_scheme == 1))) {
		$WeekendDaysToDate = WeekendDaysToDate($clockinginno,$BonusYearStart,$dataToday);
		
		$MonthsInAVYear =  round(datediff( "d", $BonusYearStart, $dataToday, false ) / 30.5);
		$AVWeekendDays = round($WeekendDaysToDate / $MonthsInAVYear , 2);

		$AVWeekendDays = number_format($WeekendDaysToDate / $MonthsInAVYear,2,'.',' ');
		$WeekendDaysNeed = 45 - $WeekendDaysToDate;
		if ($WeekendDaysNeed < 0) { $WeekendDaysNeed = 0; }
		else {
			$MonthsLeft = 12 - $MonthsInAVYear;
						if ($MonthsLeft == 0) $AVToDo = 0; else
			$AVToDo = number_format((45 - $WeekendDaysToDate)/$MonthsLeft,2,'.',' ');
		}
	}
	
	if ($WeekendDaysNeed == "0")
		$AVToDo = "0";
	
	if ($WithHold <> "") 
		$Vouchers = $WithHold." ".$Vouchers;
	
	echo "$row->pno,$row->knownas,$row->surname,$monthX,$category,$unit,$entit1,$entit2,$HolidayDays,$left,$BT,$WeekendDaysToDate,$AVWeekendDays,$WeekendDaysNeed,$AVToDo,$DataFrom,$DataTo,$Vouchers".PHP_EOL;

	unset($monthX);
	unset($category);
	unset($unit);
	unset($entit1);
	unset($entit2);
	unset($HolidayDays);
	unset($left);
	unset($BT);
	unset($WeekendDaysToDate);
	unset($AVWeekendDays);
	unset($WeekendDaysNeed);
	unset($DataFrom);
	unset($DataTo);
	unset($Vouchers);
	unset($AVToDo);
}
?>