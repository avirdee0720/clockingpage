<HTML>
<HEAD>
<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$dataakt=date("d/m/Y H:i:s");
$msgdb = new CMySQL;
?>
<meta HTTP-EQUIV='cache-control' CONTENT='no-cache, must-revalidate'>
<link rel=stylesheet type=text/css href="hs.css">
<LINK REL='stylesheet' HREF='style/multipads/style.css' TYPE='text/css'>

</HEAD>

<body class=PageBODY bgcolor=#FFFFFF topmargin=0 leftmargin=0 marginwidth=0 marginheight=0 text=#000000 link=#0000FF vlink=#0000FF alink=#FF0000>
<CENTER>

<?php
list($day, $month, $year) = explode("/",$_GET['startd']);
$dod = "$year-$month-$day";
list($day1, $month1, $year1) = explode("/",$_GET['endd']);
$ddo= "$year1-$month1-$day1";
$sd=$_GET['startd'];
$ed=$_GET['endd'];
echo "
<!-- <A HREF='./prtmsg.php?sort=$sort&startd=$sd&endd=$ed'>$PRINTBTN</A>
-->
<font class='FormHeaderFont'>9:40 to aprove<BR>Dates: $sd until $ed</font>


<table WIDTH=500 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >
  <tr>
     <td class='FieldCaptionTD'><B>Checked</B></td>
     <td class='FieldCaptionTD'><B>EDIT</B></td>
     <td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=1&startd=$sd&endd=$ed'><B>CL NO.</B></A></td>
     <td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=2&startd=$sd&endd=$ed'><B>Date</B></A></td>
	 <td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=3&startd=$sd&endd=$ed'><B>Time</B></A></td>
	 <td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=4&startd=$sd&endd=$ed'><B>Message</B></A></td>
	 <td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=5&startd=$sd&endd=$ed'><B>Checked</B></A></td>

</tr>	
";


$db = new CMySQL;
if (!$db->Open()) $db->Kill();

$sql = "SELECT `inout`.`id`, `inout`.`ino`, DATE_FORMAT(`inout`.`date1`, \"%d/%m/%Y\") as d1, DATE_FORMAT(`inout`.`intime`, \"%H:%i:%s\") as t1 , 
`inout`.`no`, `nombers`.`surname`, `nombers`.`knownas` FROM `inout` LEFT JOIN `nombers` ON `inout`.`no`=`nombers`.`pno` 
WHERE `inout`.`intime` < '9:40' 
AND `inout`.`ino` ='IN' AND `inout`.`date1`>='$dod' AND `inout`.`date1`<='$ddo' 
ORDER BY `inout`.`no` ASC,`inout`.`date1` DESC";

$q=$sql;

$totalh=0;
if ($db->Query($q)) 
  {
    while ($row=$db->Row())
    {
	
     echo "
  <tr>
	 <td class='DataTD'><A HREF='940del.php?cln=$row->no&ID=$row->id&startd=$sd&endd=$ed' onclick='return confirm(\"Do you want to mark this hour in as corect?\")'>Mark</A></td>
	 <td class='DataTD'><A HREF='totalh2.php?cln=$row->no&startd=$sd&endd=$ed'>edit</A></td>
	 <td class='DataTD'><B>$row->no</B></td>
     <td class='DataTD'><B>$row->d1</B></td>
     <td class='DataTD'><B>$row->t1</B></td>
	 <td class='DataTD'>$row->ino</td>
	 <td class='DataTD'>$row->knownas $row->surname</td>
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