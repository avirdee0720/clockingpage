<HTML>
<HEAD>
<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
uprstr($PU,90);
$dataakt=date("d/m/Y H:i:s");

if (!isset($_POST['state'])) $state = 0; else $state = $_POST['state'];
if (!isset($_POST['year'])) $year = 0; else $year = $_POST['year'];
if (!isset($_POST['datado'])) $datado = 0; else $datado = $_POST['datado'];

$msgdb = new CMySQL;

?>
<meta HTTP-EQUIV='cache-control' CONTENT='no-cache, must-revalidate'>

<LINK REL='stylesheet' HREF='style/multipads/style.css' TYPE='text/css'>

</HEAD>

<body class=PageBODY bgcolor=#FFFFFF topmargin=0 leftmargin=0 marginwidth=0 marginheight=0 text=#000000 link=#0000FF vlink=#0000FF alink=#FF0000>
<CENTER>
<?php

if($state==0)
{

$rokmniej=date("Y")- 1;
$startd="01/12/".$rokmniej;
$endd="30/11/".date("Y");

list($day, $month, $year) = explode("/",$startd);
$dod = "$year-$month-$day";
list($day1, $month1, $year1) = explode("/",$endd);
$ddo= "$year1-$month1-$day1";

//&cln=$nr&startd=$sd&endd=$ed
echo "
<font class='FormHeaderFont'>Paid Leave Entitlement Report - Choose a date</font>
<BR>

<form action='$PHP_SELF' method='post' name='addholliday'>
<table WIDTH=500 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >
<tr>
         <td class='FieldCaptionTD'><B>Year</B></td>
         <td class='FieldCaptionTD'>  
         <select class='Select' name='year'>
   			 <option  value='2009'>2009</option>
				 <option  value='2010' selected>2010</option>
				  <option  value='2011'>2009</option>
				 <option  value='2012'>2012</option>
                </select></td>
</tr>  
<tr>  
      <td class='FieldCaptionTD'>End date</td>
      <td class='DataTD'><input class='Input' maxlength='12' name='datado' value='$LastOfLastMonth'></td>
</tr>
";


echo "
</table>

			<input name='state' type='hidden' value='1'>
			<input class='Button' name='Update' type='submit' value='$SAVEBTN'>
</center>
</FORM>
</td></tr>
</table>";
include_once("./footer.php");
}
elseif($state==1)
{

echo "<script language='javascript'>window.location=\"entitlement2.php?year=$year&datado=$datado\"</script>";
}

?>
