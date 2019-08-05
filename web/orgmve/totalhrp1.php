<HTML>
<HEAD>
<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;

$dataakt=date("d/m/Y H:i:s");
?>
<meta HTTP-EQUIV='cache-control' CONTENT='no-cache, must-revalidate'>
<link rel=stylesheet type=text/css href="hs.css">
<LINK REL='stylesheet' HREF='style/multipads/style.css' TYPE='text/css'>

</HEAD>

<body class=PageBODY bgcolor=#FFFFFF topmargin=0 leftmargin=0 marginwidth=0 marginheight=0 text=#000000 link=#0000FF vlink=#0000FF alink=#FF0000>
<CENTER>
<?php
function convert_datetime($datetime) {
  //example: 2008/02/07 12:19:32
  $values = explode(" ", $datetime);

  $dates = explode("/", $values[0]);
  $times = explode(":", $values[1]);

  $newtimestamp = mktime($times[0], $times[1], $times[2], $dates[1], $dates[2], $dates[0]);

  return $newtimestamp;
}

list($day, $month, $year) = explode("/",$_GET['startd']);
$dod = "$year-$month-$day";
$dod2 = "$day/$month/$year";
list($day1, $month1, $year1) = explode("/",$_GET['endd']);
$ddo= "$year1-$month1-$day1";
$ddo2 = "$day1/$month1/$year1";

// sprawdzic czy tabela jest przygotowana!------------------------------------------------------------------------
$db = new CMySQL;
$d = new CMySQL;
$d1 = new CMySQL;

echo "
<font class='FormHeaderFont'>Employee's time in dates: $dod2 until $ddo2</font>
<BR>

<table WIDTH=500 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >
  <tr>
	 <td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=1'><B>Firstname</B></A></td>
	 <td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=2'><B>Surname</B></A></td>
     <td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=4'><B>Average IN</B></A></td>
	 <td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=5'><B>Average OUT</B></A></td>
	 <td class='FieldCaptionTD'><B>Total</B></td>
	</tr>	
";
if(!isset($sort)) $sort=1;
	switch ($sort)
		{
		case 1:
		 $sortowanie=" ORDER BY inout.date1 ASC";
		 break;
		case 2:
		 $sortowanie=" ORDER BY inout.intime ASC ";
		 break;
		case 3:
		 $sortowanie=" ORDER BY inout.outtime ASC";
		 break;
		case 4:
		 $sortowanie=" ORDER BY ipaddress.name ASC";
		 break;
		default:
		 $sortowanie=" ORDER BY inout.date1 DESC ";
		 break;
		}


if (!$db->Open()) $db->Kill();
$prac1 =("SELECT ID, pno, firstname, surname, knownas, status FROM nombers WHERE status='OK'");
//$prac=$prac.$sortowanie2;
if (!$db->Query($prac1)) $db->Kill();
  while ($row1=$db->Row())
  {
	  $fname=$row1->firstname; 
	  $sname=$row1->surname;
	  $nr=$row1->pno;
	  $totalh=0;

	$sql = "SELECT DATE_FORMAT(inout.date1, \"%d/%m/%Y\") AS d1,
       DATE_FORMAT(inout.intime, \"%H:%i:%s\") AS t1,
       DATE_FORMAT(inout.outtime, \"%H:%i:%s\") AS t2
  FROM `inout`
 WHERE     `inout`.`no` LIKE '$nr'
       AND `inout`.`date1` >= '$dod'
       AND `inout`.`date1` <= '$ddo'";
	if (!$d->Open()) $d->Kill();
	if (!$d->Query($sql)) $d->Kill();
     while ($row=$d->Row())
     {
	//    if($row->t2!=="00:00:00") {
                   $h4=convert_datetime("$row->d1 $row->t2")-convert_datetime("$row->d1 $row->t1");
		   $h3=$h4/3600; 
	       $totalh=$totalh+$h3;
//        }    
	  } 
	  $sql2 = "SELECT AVG(intime) AS srt1, AVG(outtime) AS srt2 FROM totals WHERE no LIKE '$nr' AND date1>='$dod' AND date1<='$ddo' GROUP BY no";
        $czas1=0;
        $czas2=0;
        
	      if (!$d1->Open()) $d1->Kill();
	      if (!$d1->Query($sql2))  $d1->Kill();
		  $ilosc=$d1->Rows();
          while ($row2=$d1->Row())
           {
     	   if($ilosc!==0) $czas1=date('G:i:s', $row2->srt1); else $czas1="";
           if($ilosc!==0) $czas2=date('G:i:s', $row2->srt2);  else $czas2="";
	       } 

	$total2=number_format($totalh,2,'.','');
	//if($total2=="0.00") {$pokaz="";} else {$pokaz=$total2;}
$pokaz=$total2;
	  	echo "  <tr>
	     <td class='DataTD'>$fname</td>
		 <td class='DataTD'>$sname</td> 
		 <td class='DataTD'><B>$czas1</B></td>
		 <td class='DataTD'><B>$czas2</B></td>
		 <td class='DataTD'><B>$pokaz</B></td></tr>";
  } 

//echo date("w", $dod);
echo "
</table>

</td></tr>
</table>";
include_once("./footer.php");

?>