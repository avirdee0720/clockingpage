<HTML>
<HEAD>
<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
uprstr($PU,90);
$dataakt=date("d/m/Y H:i:s");
$msgdb = new CMySQL;
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
echo "
<font class='FormHeaderFont'>More than 10 hours and 30 mins<BR>Dates: $sd until $ed</font>
<table WIDTH=500 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >
  <tr>
     <td class='FieldCaptionTD'><B>Checked</B></td>
     <td class='FieldCaptionTD'><B>EDIT</B></td>
     <td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=1&startd=$sd&endd=$ed'><B>CL NO.</B></A></td>
     <td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=2&startd=$sd&endd=$ed'><B>Date</B></A></td>
	 <td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=3&startd=$sd&endd=$ed'><B>IN Time</B></A></td>
	 <td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=4&startd=$sd&endd=$ed'><B>OUT Time</B></A></td>
	 <td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=5&startd=$sd&endd=$ed'><B>Worked time</B></A></td>

</tr>	
";
if(!isset($sort)) $sort=1;

	switch ($sort)
		{
		case 1:
		 $sortowanie=" ORDER BY `totals`.`no` ASC";
		 break;
		case 2:
		 $sortowanie=" ORDER BY `totals`.`date1` ASC ";
		 break;
		case 3:
		 $sortowanie=" ORDER BY `totals`.`intime` ASC";
		 break;
		case 4:
		 $sortowanie=" ORDER BY `totals`.`outtime` ASC";
		 break;
		case 5:
		 $sortowanie=" ORDER BY `totals`.`ILE` ASC";
		 break;
		default:
		 $sortowanie=" ORDER BY `totals`.`no`  DESC, `totals`.`workedtime` DESC";
		 break;
		}

$db = new CMySQL;
if (!$db->Open()) $db->Kill();

$sql = "SELECT `totals`.`id`, `totals`.`intime` , `totals`.`outtime` , `totals`.`no` , `totals`.`date1`, `totals`.`workedtime`  FROM `totals` WHERE `totals`.`date1`>='$dod' AND `totals`.`date1`<='$ddo' AND `totals`.`a1030`='0' AND `totals`.`workedtime`>='10.50'";
$q=$sql.$sortowanie;
$totalh=0;
if ($db->Query($q)) 
  {
    while ($row=$db->Row())
    {
		//if($row->ILE<10.50) continue;
     echo "
  <tr>
	 <td class='DataTD'><A HREF='1030edt.php?cln=$row->no&msgid=$row->id&startd=$sd&endd=$ed' onclick='return confirm(\"Do you really want to aprove?\")'>Mark</A></td>
	 <td class='DataTD'><A HREF='totalh2.php?cln=$row->no&startd=$sd&endd=$ed'>edit</A></td>
	 <td class='DataTD'><B>$row->no</B></td>
     <td class='DataTD'>$row->date1</td>
     <td class='DataTD'>$row->intime</td>
	 <td class='DataTD'>$row->outtime</td>
	 <td class='DataTD'><B>$row->workedtime</B></td>
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


echo "
</table>
</center>
<BR>

</td></tr>
</table>";
include_once("./footer.php");

?>