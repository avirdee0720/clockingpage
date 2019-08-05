<HTML>
<HEAD>
<?php
include("./inc/mysql.spread.php");
include("./config.php");
include("./languages/$LANGUAGE.php");
$dataakt=date("d/m/Y H:i:s");
?>
<meta HTTP-EQUIV='cache-control' CONTENT='no-cache, must-revalidate'>
<link rel=stylesheet type=text/css href="hs.css">
<LINK REL='stylesheet' HREF='style/multipads/style.css' TYPE='text/css'>

</HEAD>

<body class=PageBODY bgcolor=#FFFFFF topmargin=0 leftmargin=0 marginwidth=0 marginheight=0 text=#000000 link=#0000FF vlink=#0000FF alink=#FF0000>
<CENTER>
<?php
echo "
<font class='FormHeaderFont'>$dataakt</font>

<table WIDTH=500 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >

  <tr>
	 <td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=1'>NO</A></td>
     <td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=2'>Known_as</A></td>
     <td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=3'><B>Day</B></A></td>
     <td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=4'><B>IN</B></A></td>
	 <td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=4'><B>OUT</B></A></td>
	 <td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=6'><B>Where/Computer</B></A></td>
	 <td class='FieldCaptionTD'><B>Total</B></td>
	 <td class='FieldCaptionTD'><B>D-IN</B></td>
	 <td class='FieldCaptionTD'><B>D-OUT</B></td>
	 	 <td class='FieldCaptionTD'><B>Checked</B></td>

   </tr>	
";
if(!isset($sort)) $sort=1;

	switch ($sort)
		{
		case 1:
		 $sortowanie=" ORDER BY inout.no ASC";
		 break;
		case 2:
		 $sortowanie=" ORDER BY nombers.knownas ASC";
		 break;
		case 3:
		 $sortowanie=" ORDER BY inout.date1 DESC";
		 break;
		case 4:
		 $sortowanie=" ORDER BY inout.intime DESC ";
		 break;
		case 5:
		 $sortowanie=" ORDER BY inout.outtime ASC";
		 break;
		case 6:
		 $sortowanie=" ORDER BY ipaddress.name ASC";
		 break;


		default:
		 $sortowanie=" ORDER BY inout.date1 DESC ";
		 break;
		}	

$db = new CMySQL;
if (!$db->Open()) $db->Kill();
//$q="SELECT inout.ino, DATE_FORMAT(inout.date1, '%d/%m/%Y') as d1, DATE_FORMAT(inout.intime, '%H:%i:%s') as t1, DATE_FORMAT(inout.outtime, '%H:%i:%s') as t2, inout.no, inout.desc, nombers.knownas, nombers.status, ipaddress.name FROM inout LEFT JOIN nombers ON inout.no = nombers.pno LEFT JOIN ipaddress ON inout.ipadr = ipaddress.IP WHERE (((nombers.status)='OK')) ORDER BY inout.date1 DESC LIMIT 20";

$sql = "SELECT AVG(Stake), SUM(closing-price) as sum-on-closing, SUM(open-pr) AS Open-price, SUM(profit) AS PR FROM myhistory GROUP BY Market-desc ";
$q=$sql.$sortowanie;
if ($db->Query($q)) 
  {
    while ($row=$db->Row())
    {

     echo "
  <tr>
	 <td class='DataTD'>$row->no</td>
     <td class='DataTD'>$row->knownas</td>
     <td class='DataTD'><B>$row->d1</B></td>
     <td class='DataTD'><B>$row->t1</B></td>
	 <td class='DataTD'><B>$d2</B></td>
	 <td class='DataTD'><B>$row->name</B></td>
	 <td class='DataTD'><B>$h1</B></td>
	 <td class='DataTD'>$wiad</td>
	 <td class='DataTD'>$wiad2</td>
	 <td class='DataTD'>$checked</td>
  </tr>
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