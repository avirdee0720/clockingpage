<HTML>
<HEAD>
<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];

$dataakt=date("d/m/Y H:i:s");
list($day, $month, $year) = explode("/",$_GET['startd']);
$dod = "$year-$month-$day";
list($day1, $month1, $year1) = explode("/",$_GET['endd']);
$ddo= "$year1-$month1-$day1";
$sd=$_GET['startd'];
$ed=$_GET['endd'];

?>
<meta HTTP-EQUIV='cache-control' CONTENT='no-cache, must-revalidate'>
<link rel=stylesheet type=text/css href="hs.css">
<LINK REL='stylesheet' HREF='style/multipads/style.css' TYPE='text/css'>

</HEAD>

<body class=PageBODY bgcolor=#FFFFFF topmargin=0 leftmargin=0 marginwidth=0 marginheight=0 text=#000000 link=#0000FF vlink=#0000FF alink=#FF0000>
<CENTER>
 <?php
// przygotowanie tabeli ----------------------------------- totals

// $yesterday
//echo "<font class='FormHeaderFont'>Preparation of TMP Table in progres.....<BR></font>";
//echo "<table WIDTH=500 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' ><TR><TD>";

// petla dla kazdego pracownika !!!!!!!!!!!!!!!!!!!!!!---------------------------------------------------

function convert_datetime($datetime) {
  //example: 2008/02/07 12:19:32
  $values = explode(" ", $datetime);

  $dates = explode("/", $values[0]);
  $times = explode(":", $values[1]);

  $newtimestamp = mktime($times[0], $times[1], $times[2], $dates[1], $dates[2], $dates[0]);

  return $newtimestamp;
}

$db = new CMySQL;
$db1 = new CMySQL;
$db2 = new CMySQL;
$db3 = new CMySQL;
$db4 = new CMySQL;

if (!$db->Open()) $db->Kill();
$prac1 =("SELECT `ID`, `pno`, `firstname`, `surname`, `knownas`, `status` FROM `nombers` WHERE `cat` <> 'ui' AND `cat` <> 'ut'");
if ($db->Query($prac1)){
$iluPrac=$db->Rows();
//echo "Emploees to process: $iluPrac<BR>";
//echo "<FONT SIZE='3' COLOR='#0033FF'><B>WAIT!...</B></FONT><BR><BR>";
while ($emploee=$db->Row())
{
$nr=$emploee->pno;
$fname=$emploee->firstname;
$sname=$emploee->surname;

//echo "<TABLE><TR><TD>";
//echo "<H1>Processing - $nr : $fname $sname</H1> <BR>";
// kasowanie tabeli ------------???--------------------------------------------------------------------------
if (!$db1->Open()) $db1->Kill();
$sql0 ="DELETE FROM `totals` WHERE `totals`.`no`='$nr' AND `totals`.`date1` >= '$dod' AND `a1030`<>'1'";
//echo "Deleting data from totals: ".$sql0."<BR>";
if (!$db1->Query($sql0)) $db1->Kill(); 

// wybranie danych do przeniesienia do tabeli ------------------------------------------------------------
if (!$db2->Open()) $db2->Kill();
$sql1 ="SELECT `inout`.`id` , `inout`.`no` , `inout`.`date1` , MIN( `inout`.`intime` ) AS w , MAX( `inout`.`outtime` ) AS z FROM `inout` WHERE `inout`.`no`='$nr' AND `inout`.`date1` >= '$dod' AND `inout`.`date1`<='$ddo' group by `inout`.`date1` ORDER BY `inout`.`date1` ASC ";
if (!$db2->Query($sql1)) $db2->Kill();
//if($db2-Rows() > 0) $

while ($row1=$db2->Row())
{
	$totalh=0;
	$Saturday=0;
	$Sunday=0;
	if (!$db4->Open()) $db4->Kill();
	$sql4 ="SELECT DATE_FORMAT(`inout`.`date1`, \"%d/%m/%Y\") as d1, DATE_FORMAT(`inout`.`intime`, \"%H:%i:%s\") as t1, DATE_FORMAT(`inout`.`outtime`, \"%H:%i:%s\") as t2 FROM `inout` WHERE `inout`.`no`='$nr' AND `inout`.`date1` = '$row1->date1' ";
	if (!$db4->Query($sql4)) $db4->Kill();
	while ($row4=$db4->Row())
		{
                $h4=convert_datetime("$row4->d1 $row4->t2")-convert_datetime("$row4->d1 $row4->t1");
		$h3=$h4/3600; 
        $totalh=$totalh+$h3;
		$totalh=number_format($totalh,2,'.',' ');
		if(date("w", strtotime("$row1->date1"))==0) $Sunday=$totalh;
		if(date("w", strtotime("$row1->date1"))==6) $Saturday=$totalh;
		$idDot = strpos($totalh, '.');
		$godzina=substr($totalh,0,$idDot);
		$minuta=number_format(((substr($totalh,$idDot+1,2)/100)*60),0,'.',' ');
		if(strlen($minuta)==1) { $alltime=$godzina.":0".$minuta; }
		else { $alltime=$godzina.":".$minuta; }
		} 
   if($row1->z!=="00:00:00")
 	{ 	
	   if (!$db3->Open()) $db3->Kill();
	  $sql2 = "INSERT INTO `totals` (`id`, `date1`, `intime`, `outtime`, `no`, `workedtime`, `workedmin`, `saturday`, `sunday`) VALUES('', '$row1->date1', '$row1->w', '$row1->z', '$row1->no', '$totalh', '$alltime', '$Saturday', '$Sunday')";
	  if (!$db3->Query($sql2)) $db3->Kill();
		//echo "Day: $row1->date1, $row1->w, $row1->z TOTAL Hours: $totalh, Sun: $Sunday, Sat: $Saturday <BR>"; 
    } //else { echo "<FONT COLOR='#FF0000'>Emty times! I can't copy! $fname $sname: $row1->no, $row1->date1, $row1->w, $row1->z</FONT><BR> ";  }
} 
//echo "</TD></TR></TABLE>";
} // koniec while dla kazdego prac _____________________




} // koniec petli dla kazdego pracownika -------------------------------------------------------------------
//echo date("w", $dod);
//echo "</td></tr></table>";
echo "<script language='javascript'>window.location=\"end.php?startd=$sd&endd=$ed\"</script>";
//include_once("./footer.php");
?>