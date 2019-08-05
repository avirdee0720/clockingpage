<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
uprstr($PU,90);

error_reporting(E_ERROR | E_WARNING | E_PARSE);

list($day, $month, $year) = explode("/",$_GET['endd']);
$dataToday = "$year-$month-$day";
$ed=$_GET['endd'];
$prevyear = $year - 1;
$dod = "$prevyear-12-01";
$ddo= "$year-12-31";
$firstDayYear= "$year-01-01";
$DateOfHYStarted = $dod;

$db = new CMySQL;
$db2 = new CMySQL;
$VoucherDB = new CMySQL;

$dataakt = date("dmY-Hi");
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=to-payslips" .$dataakt.".xls");
header("Pragma: no-cache");
header("Expires: 0");
echo "
<style type=\"text/css\">

<!--CSS content in .css file-->

</style>
";
echo "$dataToday
<table border='0' cellpadding='1' cellspacing='1'>
<tr>
    <td>Payroll no</td>
    <td>Known as</td>
    <td>Surname</td>
    <td>month</td>
    <td>Categ</td>
    <td>Unit</td>
    <td>E. in weeks</td>
    <td>E. in days</td>
    <td>Taken</td>
    <td>Left</td>
    <td>BonusType</td>
    <td>wends TD</td>
    <td>AV TD</td>
    <td>NO need</td>
    <td>AV need</td>
    <td>From</td>
    <td>To</td>
    <td>Vouchers</td>
</tr>
";

$pracujeForLessThanYear = datediff( "d", $DateOfHYStarted, date("Y-m-d", time()), false ) ;

if (!$db->Open()) $db->Kill();
$q = "SELECT n.pno,
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
       is_eligible_for_2018_voucher_scheme(n.pno) AS has_2018_voucher_scheme
 FROM nombers n
 JOIN emplcat e ON e.catozn = n.cat
WHERE e.catozn <> 10
ORDER BY n.pno
";

if ($db->Query($q)) {
	while ($row=$db->Row()) {
		$clockinginno = $row->pno;
		$monthX=date("M-y", strtotime($dataToday));

			$PYBS = new StaffDates($dataToday,$row->dateforbonus); 
			$BonusYearStart = $PYBS->CurrentBonusYearStarted();
			$BonusYearEnd = $PYBS->CurrentBonusYearEnd();
			$dateforbonus = $row->dateforbonus;
	//		echo "$clockinginno - $dataToday -".$row->dateforbonus."- BYS : $BonusYearStart BYEND $BonusYearEnd<br>";
		
		$DataFrom = date("M",strtotime("$BonusYearStart"));
		$DataTo = date("M",strtotime("$BonusYearEnd"));

		$pracuje=0;
		$pracuje =  datediff( "d", $row->started, date("Y-m-d", time()), false ) ;

		$Vouchers=0;
		if (!$VoucherDB->Open()) $VoucherDB->Kill();
		$VouchersSQL = "SELECT `vouchersdue`, `withold` FROM `payvoucher` WHERE `no` ='$row->pno' AND `date1` = '$dataToday'";
		if (!$VoucherDB->Query($VouchersSQL)) $VoucherDB->Kill();
		$RVouchers = $VoucherDB->Row();
		$Vouchers = $RVouchers->vouchersdue;
		if($RVouchers->withold=="y") $WithHold = "WHOLD";
		else $WithHold = "";

		$HolidayDays=0;
		if (!$db2->Open()) $db2->Kill();
		$sqlHolid = "SELECT holidays.id,holidays.no, holidays.date1 FROM holidays WHERE holidays.no = '$row->pno' AND holidays.date1>=\"$dod\" AND holidays.date1<=\"$ddo\" AND holidays.sortof=\"PL\" ORDER BY holidays.date1 ";
		if (!$db2->Query($sqlHolid)) $db2->Kill();
		while ($rowHol=$db2->Row())
		{
			$HolidayDays = $HolidayDays + 1;
		}
		$heWorks = 0;

		if($row->catname <> "casual" ) { $cat="n"; } else { $cat="y"; }
		list ($entit, $procent, $iledni) = Entitlement( $cat, $row->regdays, $row->started, $DateOfHYStarted);

		if( $pracuje < 334 ) { 
		  if(strtotime("$DateOfHYStarted 00:00:00") < strtotime("$row->started 00:00:00")) {
		  $heWorks = $pracuje;  } else { $heWorks = $pracujeForLessThanYear; }



		  if($row->catname <> "casual" ) { 
			$kategoria =  "<td >$row->catname_account</td>" ; 
			$unit =  "<td >days</td>" ; 
			$left = $entit - $HolidayDays;
			$entit2 = $entit ;
		  } else { 
			$kategoria =  "<td >$row->catname_account</td>" ; 
			$unit =  "<td >weeks</td>" ; 
			$left = $entit - $HolidayDays;
			$entit1 = $entit ;

		  }
		} else {
		  if($row->catname <> "casual" ) { 
			$kategoria =  "<td >$row->catname_account</td>" ; 
			$unit =  "<td >days</td>" ; 
			$left = $entit - $HolidayDays;
			$entit2 = $entit ;
		  } else { 
			$kategoria =  "<td >$row->catname_account</td>" ; 
			$unit =  "<td >weeks</td>" ; 
			$left = $entit - $HolidayDays;
			$entit1 = $entit ;
		  }
		}
		if ( $left < 0 ) { $left1 = "<td >$left</td>" ;}
		else { $left1 = "<td >$left</td>" ; } 

		if ($row->bonustype == "WEND")
			$BT="W/end";
		else
			$BT=$row->bonustype;
		
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
		
		if ($WeekendDaysNeed == 0) { $AVToDo="0.00"; }
			
		if ($row->status == "OK") {
			echo "
			<tr>
				<td><b>$row->pno</b></td>
				<td>$row->knownas</td>
				<td>$row->surname</td>
				<td>$monthX</td>
				<td>$kategoria</td>
				<td>$unit</td>
				<td>$entit1</td>
				<td>$entit2</td>
				<td>$HolidayDays</td>
				<td>$left1</td>
				<td>$BT</td>
				<td>$WeekendDaysToDate</td>
				<td>$AVWeekendDays</td>
				<td>$WeekendDaysNeed</td>
				<td style=\"mso-number-format:Fixed;\">$AVToDo</td>
				<td>$DataFrom</td>
				<td>$DataTo</td>
				<td>$WithHold $Vouchers</td>
			</tr>";
		} elseif ($row->status == "LEAVER" && (strtotime("$year-$month-01 00:00:00") < strtotime("$row->left1 00:00:00"))) {
			$left1 = "<td>0</td>";	 
			echo "
			<tr>
				<td><b>L$row->pno</b></td>
				<td>$row->knownas</td>
				<td>$row->surname</td>
				<td>$monthX</td>
				<td>$kategoria</td>
				<td>$unit</td>
				<td>$entit1</td>
				<td>$entit2</td>
				<td>$HolidayDays</td>
				<td>$left1</td>
				<td>$BT</td>
				<td>$WeekendDaysToDate</td>
				<td>$AVWeekendDays</td>
				<td>$WeekendDaysNeed</td>
				<td>$AVToDo</td>
				<td>$DataFrom</td>
				<td>$DataTo</td>
				<td>$Vouchers</td>
			</tr>
			";
		}

		unset($monthX);
		unset($kategoria);
		unset($unit);
		unset($entit1);
		unset($entit2);
		unset($HolidayDays);
		unset($left1);
		unset($BT);
		unset($WeekendDaysToDate);
		unset($AVWeekendDays);
		unset($WeekendDaysNeed);
		unset($DataFrom);
		unset($DataTo);
		unset($Vouchers);
		unset($AVToDo);
	} 
} else {
	$db->Kill();
}

echo "
</table>
";

include_once("./footer.php");
?>