<?php

	$MonthsInAVYear = ( strtotime("$ddo")-strtotime("$BonusYearStart"))/2419200;
	$idDot = strpos($MonthsInAVYear, '.');
	$MonthsInAVYear = substr($MonthsInAVYear,0,$idDot);
	$StartedMoreThanMonthAgo = ( strtotime("$FirstOfLastMonth")>strtotime("$emp->started"));

	$WeekendDaysToDate = $HolidayDaysToDate + $SaturdaysAllToDate + $SundaysAllToDate;
	$AVWeekendDays = $WeekendDaysToDate / $MonthsInAVYear;
	
	//conditions to check
		if($VCond3==1) { $condition1=3; $condition2=0; $days=$DaysToCheck; }
		elseif($VCond375==1) { $condition1=3.75;   $condition2=0; $days=0; }
		else { $condition1="NONE"; $condition2=0; $days=0; }
		
		//start of vouchers, vouchers with no conditions
		if($VCond3 == 0 && $VCond375 == 0 && $VCond70 ==0) {
				if($emp->paystru=="OLD") {
					$Vouchers = "Vouchers to count OLD";
					if ($VoucherFixed==0) { $VoucherDue = $BasicGrossPay * $VoucherEntit; }
					else { $VoucherDue = $VoucherFixed; }
					$VoucherDue = number_format($VoucherDue,2,'.',' ');
					$VoucherPayment = number_format($VoucherDue,0,'.',' ');
					$TaxebleVouchers = $VoucherPayment * 0.8;
					$VoucherDue = 0;
				} else {
					if(strtotime("$DateToCheckStart 00:00:00")>=strtotime("$emp->started 00:00:00")) {
					$Vouchers = "Vouchers to count NEW";
					if ($VoucherFixed==0) { $VoucherDue = $GrossPay * $VoucherEntit; }
					else { $VoucherDue = $VoucherFixed; }
					$VoucherDue = number_format($VoucherDue,2,'.',' ');
					$VoucherPayment = number_format($VoucherDue * 2,0,'.',' ');
					$TaxebleVouchers = $VoucherPayment * 0.8;
					$VoucherDue = $VoucherPayment / 2;

					}
				} 		
		} else {			
			//he has worked more than 1 month
			if(($condition1 <> "NONE") && ($AVWeekendDays >= $condition1)) { //first condition 3 or 3.75 ongoing average weekend day
				//check empoee pay structure
				if($emp->paystru=="OLD") {
					$Vouchers = "Sold";
					$Vouchers = "Vouchers to count OLD";
					if ($VoucherFixed==0) { $VoucherDue = $BasicGrossPay * $VoucherEntit; }
					else { $VoucherDue = $VoucherFixed; }
					$VoucherDue = number_format($VoucherDue,0,'.',' ');
					$VoucherPayment = number_format($VoucherDue,0,'.',' ');
					$TaxebleVouchers = $VoucherPayment * 0.8;
					$VoucherDue = 0;
				} elseif($emp->paystru=="NEW") {
					$Vouchers = "Snew";
					if($punctualpercent > 69) { 
						if(strtotime("$DateToCheckStart 00:00:00")>=strtotime("$emp->started 00:00:00")) {
						if ($VoucherFixed==0) { $VoucherDue = $BasicGrossPay * $VoucherEntit; }
						else { $VoucherDue = $VoucherFixed; }
						$VoucherDue = number_format($VoucherDue,0,'.',' ');
						$VoucherPayment = number_format($VoucherDue * 2,0,'.',' ');
						$TaxebleVouchers = $VoucherPayment * 0.8;
						$VoucherDue = $VoucherPayment / 2;
					} 
					} else { $Vouchers = "X"; }
				} else { 
					$Vouchers = "Snone"; }
				//END check empoee pay structure
			} else { 	
					if($emp->paystru=="OLD") {
						if ($VoucherFixed==0) { $VoucherDueWH = $BasicGrossPay * $VoucherEntit; }
						else { $VoucherDueWH = $VoucherFixed; }
						$VoucherDueWH = number_format($VoucherDueWH,0,'.',' ');
						$VoucherPaymentWH = number_format($VoucherDueWH * 2,0,'.',' ');
						$TaxebleVouchersWH = $VoucherPaymentWH * 0.8; 
						$VoucherDueWH = 0;
					} else {
						if(strtotime("$DateToCheckStart 00:00:00")>=strtotime("$emp->started 00:00:00")) {
						if ($VoucherFixed==0) { $VoucherDueWH = $BasicGrossPay * $VoucherEntit; }
						else { $VoucherDueWH = $VoucherFixed; }
						$VoucherDueWH = number_format($VoucherDueWH,0,'.',' ');
						$VoucherPaymentWH = number_format($VoucherDueWH * 2,0,'.',' ');
						$TaxebleVouchersWH = $VoucherPaymentWH * 0.8; 
						$VoucherDueWH = $VoucherPaymentWH / 2;
						}
					} 
			}
		} //End of vouchers
?>