<HTML>
<HEAD>
<?php
include("./inc/mysql.inc.php");
include("./config.php");
include("./languages/$LANGUAGE.php");
$dataakt=date("d/m/Y H:i:s");
?>
<meta http-equiv="refresh" content="10;URL=list.php",\"GLOWNA\">
<meta HTTP-EQUIV='cache-control' CONTENT='no-cache, must-revalidate'>
<!-- <link rel=stylesheet type=text/css href="hs.css"> -->
<LINK REL='stylesheet' HREF='style/multipads/style.css' TYPE='text/css'>

</HEAD>

<body class=PageBODY bgcolor=#FFFFFF topmargin=0 leftmargin=0 marginwidth=0 marginheight=0 text=#000000 link=#0000FF vlink=#0000FF alink=#FF0000>
<CENTER>
<?php
echo "
<font class='FormHeaderFont'>$dataakt</font>

<table WIDTH=500 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >
  <tr>
	 <td class='FieldCaptionTD'>NO</td>
     <td class='FieldCaptionTD'>Known as</td>
     <td class='FieldCaptionTD'><B>Day</B></td>
     <td class='FieldCaptionTD'><B>IN</B></td>
	 <td class='FieldCaptionTD'><B>OUT</B></td>
	 <td class='FieldCaptionTD'><B>Where</B></td>
	 <td class='FieldCaptionTD'><B>Total</B></td>
   </tr>	
";
	
$db = new CMySQL;
if (!$db->Open()) $db->Kill();
//$q="SELECT inout.ino, DATE_FORMAT(inout.date1, '%d/%m/%Y') as d1, DATE_FORMAT(inout.intime, '%H:%i:%s') as t1, DATE_FORMAT(inout.outtime, '%H:%i:%s') as t2, inout.no, inout.desc, nombers.knownas, nombers.status, ipaddress.name FROM inout LEFT JOIN nombers ON inout.no = nombers.pno LEFT JOIN ipaddress ON inout.ipadr = ipaddress.IP WHERE (((nombers.status)='OK')) ORDER BY inout.date1 DESC LIMIT 20";

$sql = "SELECT inout.ino, DATE_FORMAT(inout.date1, \"%d/%m/%Y\") as d1, DATE_FORMAT(inout.intime, \"%H:%i:%s\") as t1, DATE_FORMAT(inout.outtime, \"%H:%i:%s\") as t2, inout.no, inout.descin, nombers.knownas, nombers.status, ipaddress.name FROM inout LEFT JOIN nombers ON inout.no = nombers.pno LEFT JOIN ipaddress ON inout.ipadr = ipaddress.IP WHERE (((nombers.status)=\"OK\")) ORDER BY inout.date1 DESC, inout.intime DESC LIMIT 20";

if ($db->Query($sql)) 
  {
    while ($row=$db->Row())
    {
//if($row->desc <> "") { $wiad="<IMG SRC='images/spadaj.gif' WIDTH='16' HEIGHT='14' BORDER='0' ALT='$row->desc'>";}
//else $wiad="";
if($row->t2!=="00:00:00") { 
/*	$h4=strtotime("$row->d1 $row->t2")-strtotime("$row->d1 $row->t1"); 
	$h3=$h4/3600; 
	$h2=$h3 * 5.05;
	$h1=number_format($h2,2,'.',' ');
	$h1="£".$h1;
*/
	$h1="OUT";
	}
	else { $h1="IN"; }
     echo "
  <tr>
	 <td class='DataTD'>$row->no</td>
     <td class='DataTD'>$row->knownas</td>
     <td class='DataTD'><B>$row->d1</B></td>
     <td class='DataTD'><B>$row->t1</B></td>
	 <td class='DataTD'><B>$row->t2</B></td>
	 <td class='DataTD'><B>$row->name</B></td>
	 <td class='DataTD'><B>$h1</B></td>
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