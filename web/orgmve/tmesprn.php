<HTML>
<HEAD>
<?php
include("./inc/mysql.inc.php");
include("./config.php");
include("./languages/$LANGUAGE.php");
$dataakt=date("d/m/Y H:i:s");
$msgdb = new CMySQL;
?>
<meta HTTP-EQUIV='cache-control' CONTENT='no-cache, must-revalidate'>
<link rel=stylesheet type=text/css href="hs.css">
<LINK REL='stylesheet' HREF='style/multipads/style.css' TYPE='text/css'>

</HEAD>

<body onload='print();' class=PageBODY bgcolor=#FFFFFF topmargin=0 leftmargin=0 marginwidth=0 marginheight=0 text=#000000 link=#0000FF vlink=#0000FF alink=#FF0000>
<CENTER>

<?php
list($day, $month, $year) = explode("/",$_GET['startd']);
$dod = "$year-$month-$day";
list($day1, $month1, $year1) = explode("/",$_GET['endd']);
$ddo= "$year1-$month1-$day1";
$sd=$_GET['startd'];
$ed=$_GET['endd'];
echo "
<font class='FormHeaderFont'>Messages to check<BR>Dates: $sd until $ed</font>


<table WIDTH=500 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >
  <tr>
     <td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=1&startd=$sd&endd=$ed'><B>CL NO.</B></A></td>
     <td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=2&startd=$sd&endd=$ed'><B>Date</B></A></td>
	 <td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=3&startd=$sd&endd=$ed'><B>Time</B></A></td>
	 <td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=4&startd=$sd&endd=$ed'><B>Message</B></A></td>
</tr>	
";
if(!isset($sort)) $sort=1;

	switch ($sort)
		{
		case 1:
		 $sortowanie=" ORDER BY inoutmsg.no ASC";
		 break;
		case 2:
		 $sortowanie=" ORDER BY inoutmsg.date1 ASC ";
		 break;
		case 3:
		 $sortowanie=" ORDER BY inoutmsg.tm ASC";
		 break;
		case 4:
		 $sortowanie=" ORDER BY inoutmsg.message ASC";
		 break;
		case 5:
		 $sortowanie=" ORDER BY inoutmsg.checked ASC";
		 break;
		default:
		 $sortowanie=" ORDER BY inoutmsg.date1 DESC, inoutmsg.tm ASC ";
		 break;
		}

$db = new CMySQL;
if (!$db->Open()) $db->Kill();

$sql = "SELECT inoutmsg.id, inoutmsg.idinout, DATE_FORMAT(inoutmsg.date1, \"%d/%m/%Y\") as d1, DATE_FORMAT(inoutmsg.tm, \"%H:%i:%s\") as t1, inoutmsg.no, inoutmsg.message, inoutmsg.checked FROM inoutmsg  WHERE inoutmsg.no LIKE '%' AND inoutmsg.date1>='$dod' AND inoutmsg.date1<='$ddo' AND `inoutmsg`.`checked`='n'";
$q=$sql.$sortowanie;
$totalh=0;
if ($db->Query($q)) 
  {
    while ($row=$db->Row())
    {
     echo "
  <tr>
	 <td class='DataTD'><B>$row->no</B></td>
     <td class='DataTD'><B>$row->d1</B></td>
     <td class='DataTD'><B>$row->t1</B></td>
	 <td class='DataTD'>$row->message</td>
  ";
  } 
} else {
echo " 
  <tr>
    <td class='DataTD'></td>
    <td class='DataTD' colspan='5'>SQL Error:".mysql_error()."</td>
  </tr>";
 $db->Kill();
}

$totalhDisp=number_format($totalh,2,'.',' ');

echo "
</table>
</center>
<BR>

</td></tr>
</table>";
include_once("./footer.php");

?>