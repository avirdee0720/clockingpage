<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
uprstr($PU,90);
$dataakt=date("d/m/Y H:i:s");
$msgdb = new CMySQL;

if (!$db->Open()) $db->Kill();

if (!isset($_POST['state'])) $state = 0; else $state = $_POST['state'];
if (!isset($_POST['year'])) $year = 0; else $year = $_POST['year'];
if (!isset($_POST['month'])) $month = 0; else $month = $_POST['month'];
if (!isset($_POST['sareport'])) $sareport = 0; else $sareport = $_POST['sareport'];
 
if($state==0)
{

$rokmniej=date("Y")- 1;
$startd="01/12/".$rokmniej;
$endd="30/11/".date("Y");

list($day, $month, $year) = explode("/",$startd);
$dod = "$year-$month-$day";
list($day1, $month1, $year1) = explode("/",$endd);
$ddo= "$year1-$month1-$day1";

$YearsSelectHtml = Yearsselect();
$MonthsSelectHtml = Monthsselect();


 $q="SELECT value As smallaccomodationreport FROM `defaultvalues` Where `code`=\"smallaccomodationreport\"";
    $db->Query($q);
    $r=$db->Row();
    $smallaccomodationreport =$r->smallaccomodationreport ;
     $smallaccomodationreporttext  = "";
  
    if ($smallaccomodationreport =="1") {
    $smallaccomodationreporttext .=  "<input type=\"checkbox\" name=\"sareport\" id=\"checkbox\" checked=\"checked\"/ value=\"1\">";
    } 
    else {
       $smallaccomodationreporttext .=  "<input type=\"checkbox\" name=\"sareport\" id=\"checkbox\"/  value=\"1\">";
    } 


//&cln=$nr&startd=$sd&endd=$ed
echo "
<font class='FormHeaderFont'>Accomodation offset report</font>
<BR>

<form action='$PHP_SELF' method='post' name='addholliday'>
<table WIDTH=500 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >
<tr>
         <td class='FieldCaptionTD'><B>Year</B></td>
         <td class='FieldCaptionTD'>  
         <select class='Select' name='year'>
              $YearsSelectHtml
                 </select></td>
</tr>     
<tr>
         <td class='FieldCaptionTD'><B>Month</B></td>
         <td class='FieldCaptionTD'>  
         <select class='Select' name='month'>
                 $MonthsSelectHtml
                 </select></td>
</tr>
 <tr>  
      <td class='FieldCaptionTD'>Small Report</td>
      <td class='DataTD'>$smallaccomodationreporttext</td>
    </tr>
";


echo "
</table>

			<input name='state' type='hidden' value='1'>
			<input class='Button' name='Update' type='submit' value='OK'>
</center>
</FORM>
</td></tr>
</table>";
include_once("./footer.php");
}
elseif($state==1)
{
//   echo "month=$month&year=$year";
 echo "<script language='javascript'>window.location=\"accomodation_offset1b.php?month=$month&year=$year&sareport=$sareport\"</script>";
}

?>
