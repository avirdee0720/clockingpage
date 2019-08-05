<HTML>
<HEAD>
<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$dataakt=date("d/m/Y H:i:s");
$msgdb = new CMySQL;

if (!isset($_POST['state'])) $state = 0; else $state = $_POST['state'];
if (!isset($_POST['cln'])) $cln = 0; else $cln = $_POST['cln'];
if (!isset($_POST['licznik'])) $licznik = 0; else $licznik = $_POST['licznik'];
if (!isset($_POST['year'])) $year = 0; else $year = $_POST['year'];
if (!isset($_POST['month'])) $month = 0; else $month = $_POST['month'];
if (!isset($_POST['day'])) $day = array(); else $day = $_POST['day'];
if (!isset($_POST['sortof'])) $sortof = array(); else $sortof = $_POST['sortof'];

for ($i = 1; $i < 32; $i++) {
    if (!isset($day[$i])) $day[$i] = "off"; else $day[$i] = "on";
}

?>
<meta HTTP-EQUIV='cache-control' CONTENT='no-cache, must-revalidate'>

<LINK REL='stylesheet' HREF='style/multipads/style.css' TYPE='text/css'>

</HEAD>

<body class=PageBODY bgcolor=#FFFFFF topmargin=0 leftmargin=0 marginwidth=0 marginheight=0 text=#000000 link=#0000FF vlink=#0000FF alink=#FF0000>
<CENTER>
<?php

if($state==0)
{
$nr=$_GET['cln'];
$yearact=date("Y");
$rokmniej=date("Y")- 1;
$yearplus=date("Y")+ 1;
$startd="01/12/".$rokmniej;
$endd="30/11/".date("Y");

list($day, $month, $year) = explode("/",$startd);
$dod = "$year-$month-$day";
list($day1, $month1, $year1) = explode("/",$endd);
$ddo= "$year1-$month1-$day1";

echo "
<font class='FormHeaderFont'>Employee's payrol/ClockingIN-OUT NO: $nr</font>
<BR>

<form action='$PHP_SELF' method='post' name='addholliday'>
<table WIDTH=500 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >
<tr>
         <td class='FieldCaptionTD'><B>Year</B></td>
         <td class='FieldCaptionTD'>  
         <select class='Select' name='year'>
				<option value='$yearplus'>$yearplus</option>
				<option selected value='$yearact'>$yearact</option>
				<option  value='$rokmniej'>$rokmniej</option>
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

  <tr>
         <td class='FieldCaptionTD'><B>DAY</B></td>
         <td class='FieldCaptionTD'><B>Type of leave </B></td>
        </tr>";

for($licz=1; $licz<32; $licz++) { 
echo "<tr>
         <td class='DataTD'><INPUT TYPE='checkbox' NAME='day[$licz]'>&nbsp;&nbsp;<B>$licz</B></td>
         <td class='DataTD'><B>PL</B> <INPUT TYPE='radio' NAME='sortof[$licz]' value='PL' > <B>UPL</B> <INPUT TYPE='radio' NAME='sortof[$licz]' value='UPL' checked></td>
</tr>";
}
echo "
</table>
			<input name='licznik' type='hidden' value='$licz'>
			<input name='cln' type='hidden' value='$nr'>
			<input name='startd' type='hidden' value='$startd'>
			<input name='endd' type='hidden' value='$endd'>
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

$db = new CMySQL;
  if (!$db->Open())$db->Kill();
     for ($i = 1; $i < $licznik; $i++) {        
			 if($day[$i]=="on"){
			 $freeday = $year."-".$month."-".$i;
			 //echo "$freeday  $sortof[$i]  <BR>";
			 //if(sortof[$i]=="checked")
			 $query1[$i] =("INSERT INTO `holidays` ( `id` , `no` , `date1` , `sortof` ) VALUES (NULL , '$cln', '$freeday', '$sortof[$i]')");
			 $result1[$i] = mysql_query($query1[$i]);
			 // update message!!!
			}
     }
$yearact=date("Y");
echo "<script language='javascript'>window.location=\"hollid1.php?cln=$cln&yearAct=$yearact\"</script>";
}

?>
