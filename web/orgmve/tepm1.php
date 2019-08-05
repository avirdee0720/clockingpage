<?php
error_reporting(E_ALL);
include("./inc/mysql.inc.php");
include("./config.php");
include("./languages/$LANGUAGE.php");
$dataakt=date("d/m/Y H:i:s");
$msgdb = new CMySQL;

?>
<HTML>
<HEAD>
<meta HTTP-EQUIV='cache-control' CONTENT='no-cache, must-revalidate'>
<LINK REL='stylesheet' HREF='style/multipads/style.css' TYPE='text/css'>
</HEAD>
<body class=PageBODY bgcolor=#FFFFFF topmargin=0 leftmargin=0 marginwidth=0 marginheight=0 text=#000000 link=#0000FF vlink=#0000FF alink=#FF0000>
<CENTER>
<?php
$year="2007";
$firstDayYear= "$year-01-01";
$dod = $year."-".$month."-01";
$ddo= $year."-12-31";

$db3 = new CMySQL;
$db4 = new CMySQL;


			for($i=0; $i < 53 ; $i++) {
			
				if (!$db4->Open()) $db4->Kill();
				    $q4 = "SELECT DATE_FORMAT(MIN(`date1`), \"%Y-%m-%d\") as d1a, DATE_FORMAT(MAX(`date1`), \"%Y-%m-%d\") as d2a FROM `year` WHERE `nr_week`='$i' AND `date1`>='$firstDayYear' AND `date1`<='$ddo' ";
				if (!$db4->Query($q4)) $db4->Kill();
				
				while($rowDates=$db4->Row()) {
				$dataOd=$rowDates->d1a;
				$dataDo=$rowDates->d2a;
				if (!$db3->Open()) $db3->Kill();				
					   $zapytanie="INSERT INTO `weeksno` ( `id` , `dataod` , `datado` , `weekno` )  VALUES (NULL , '$dataOd', '$dataDo', '$i');";
				if (!$db3->Query($zapytanie)) $db3->Kill();
				}
			}

  echo "dupa";

include_once("./footer.php");

?>
