<?php
include("./inc/mysql.inc.php");
include("./config.php");

function countWeeks( $Week, $firstDayYear,  $ddo ) {

	if (!$db4->Open()) $db4->Kill();
	$q4 = "SELECT DATE_FORMAT(MIN(`date1`), \"%Y-%m-%d\") as d1a, DATE_FORMAT(MAX(`date1`), \"%Y-%m-%d\") as d2a FROM `year` WHERE `nr_week`='$Week' AND `date1`>='$firstDayYear' AND `date1`<='$ddo'";
	if (!$db4->Query($q4)) $db4->Kill();
	$rowDates=$db4->Row();

	$db5 = new CMySQL;
	if (!$db5->Open()) $db5->Kill();
		$q5 = "SELECT `date1`, `no`, `workedtime` FROM `totals` WHERE `no`='$row->no' AND `date1`>='$rowDates->d1a' AND `date1`<='$rowDates->d2a'";
	if (!$db5->Query($q5)) $db5->Kill();
		//$worked=0;
		while ($rowDatesW=$db5->Row())
		{
			$worked=$worked+$rowDatesW->workedtime;
		}

return $worked;
}

function countDaysInWeek( $Week , $firstDayYear,  $ddo ) {
	$db6 = new CMySQL;
	if (!$db6->Open()) $db6->Kill();
	$q6 = "SELECT DATE_FORMAT(MIN(`date1`), \"%Y-%m-%d\") as d1a, DATE_FORMAT(MAX(`date1`), \"%Y-%m-%d\") as d2a FROM `year` WHERE `nr_week`='$Week' AND `date1`>='$firstDayYear' AND `date1`<='$ddo'";
	if (!$db6->Query($q6)) $db6->Kill();
	$rowDates=$db6->Row();

	$db7 = new CMySQL;
	if (!$db7->Open()) $db7->Kill();
		$q7 = "SELECT `date1`, `no`, `workedtime` FROM `totals` WHERE `no`='$row->no' AND `date1`>='$rowDates->d1a' AND `date1`<='$rowDates->d2a'";
	if (!$db7->Query($q7)) $db7->Kill();
		//$worked=0;
	$DaysWorked=$db7->Rows();
		//while ($rowDatesW=$db5->Row())
		//{
		//	$worked=$worked+$rowDatesW->workedtime;
		//	$DaysWorked=$DaysWorked+1;
		//}

return $DaysWorked;
}
?>
