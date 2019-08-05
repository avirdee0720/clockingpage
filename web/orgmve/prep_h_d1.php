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

<LINK REL='stylesheet' HREF='style/multipads/style.css' TYPE='text/css'>

</HEAD>

<body class=PageBODY bgcolor=#FFFFFF topmargin=0 leftmargin=0 marginwidth=0 marginheight=0 text=#000000 link=#0000FF vlink=#0000FF alink=#FF0000>
<CENTER>
<?php

if(!isset($state))
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
<font class='FormHeaderFont'>TITLE write it yourself Gus</font>
<BR>

<form action='$PHP_SELF' method='post' name='addholliday'>
<table WIDTH=500 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >
<tr>
         <td class='FieldCaptionTD'><B>Year</B></td>
         <td class='FieldCaptionTD'>  
         <select class='Select' name='year'>
                <option selected value='2006'>2006</option>
                <option value='2007'>2007</option>
                 </select></td>
</tr>     
<tr>
         <td class='FieldCaptionTD'><B>Month</B></td>
         <td class='FieldCaptionTD'>  
         <select class='Select' name='month'>
                <option selected value='01'>01 January</option>
                <option value='02'>02 February</option>
                <option value='03'>03 March</option>
                <option value='04'>04 April</option>
                <option value='05'>05 May</option>
                <option value='06'>06 June</option>
                <option value='07'>07 July</option>
                <option value='08'>08 August</option>
                <option value='09'>09 September</option>
                <option value='10'>10 October</option>
                <option value='11'>11 November</option>
                <option value='12'>12 December</option>
                 </select></td>
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

echo "<script language='javascript'>window.location=\"prep_h_d2.php?month=$month&year=$year\"</script>";
}

?>
