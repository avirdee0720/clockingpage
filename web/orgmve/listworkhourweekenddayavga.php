<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$tytul='Staff Weekend attendance';

$db = new CMySQL;

uprstr($PU,70);

if (!isset($_POST['state'])) $state = 0; else $state = $_POST['state'];
if (!isset($_POST['_grp'])) $_grp = 0; else $_grp = $_POST['_grp'];
if (!isset($_POST['startd'])) $startd = "00/00/0000"; else $startd = $_POST['startd'];
if (!isset($_POST['endd'])) $endd = "00/00/0000"; else $endd = $_POST['endd'];   

list($day, $month, $year) = explode("/",$LastOfLastMonth);
$dod = "$year-$month-$day";
list($day1, $month1, $year1) = explode("/",$LastOfLastMonth);
$ddo= "$year1-$month1-$day1";

 $sql = "SELECT PERIOD_ADD($year$month,-11) AS period;";

	if (!$db->Open()) $db->Kill();
		if (!$db->Query($sql))  $db->Kill();
		  $r=$db->Row();
     	$period=$r->period;

$LastYearStartget = "01/".substr($period,4,2)."/".substr($period, 0,4);
$monthT=date("M",mktime(0, 0, 0, $month, $day, $year));
$last_week_no=date("Y-m-d",mktime(0, 0, 0, $month1, $day1, $year1)-31536000);
$LastYearEnd=date("Y-m-d",mktime(0, 0, 0, $month1, $day1, $year1 - 1));
$LastYearStart=date("Y-m-d",mktime(0, 0, 0, $month, $day, $year - 1));
//$LastYearStartget =date("d/m/Y",mktime(0, 0, 0, $month, $day, $year - 1));
$LastYearEndget =date("d/m/Y",mktime(0, 0, 0, $month1, $day1, $year1 - 1));
$LastOfLastMonth = date("d/m/Y",mktime(0, 0, 0, $month1, $day1, $year1));
//$LastYearStartget =date("d/m/Y",mktime(0, 0, 0, 1, 1, $year));
//  $LastYearStartget2=date("Y-m-d",mktime(0, 0, 0, $month1, $day1, $year1)-31536000);

if($state==0)
{
echo "	<TD ALIGN=JUSTIFY VALIGN=TOP border=0>
	<table width='100%' border=0><tr><td>

<center>
<form action='$PHP_SELF' method='post' name='ed_czl'>
  <font class='FormHeaderFont'>$tytul</font>
  <table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
   <tr>
      <td class='FieldCaptionTD'>Employee category</td>

<td class='DataTD'>   <select class='Select' name='_grp'>
		<option selected value='%'>chose or leave for all</option>";
		  $q = "SELECT `catozn`, `catname` FROM `emplcat`";

	$db = new CMySQL;
     if (!$db->Open()) $db->Kill();
  if ($db->Query($q)) 
  {
    while ($r=$db->Row())
    {

          echo "<option value='$r->catozn'>$r->catname</option>";
    }
	} else {
echo " 
  <tr>
    <td class='DataTD'></td>
    <td class='DataTD' colspan='3'>SQL Error 1a</td>
  </tr>";
 $db->Kill();
}
echo " </select>
</td></tr>

    <tr>
      <td class='FieldCaptionTD'>Start date</td>
      <td class='DataTD'><input class='Input' maxlength='12' name='startd' value='$LastYearStartget'>

      </td>
    </tr>
    <tr>  
      <td class='FieldCaptionTD'>End date</td>
      <td class='DataTD'><input class='Input' maxlength='12' name='endd' value='$LastOfLastMonth'></td>
    </tr>

      <tr>
      <td align='right' colspan='2'>
		<input name='state' type='hidden' value='1'>
	

		<input class='Button' name='Update' type='submit' value='$OKBTN'>
	</td>
    </tr>
  </table>
</form>
</center>
<BR>
</td></tr>
</table>";
include_once("./footer.php");
}
elseif($state==1)
{
   if (!$db->Open()) $db->Kill();

   echo "<script language='javascript'>window.location=\"listworkhourweekenddayavg.php?kier=1&startd=$startd&endd=$endd&_grp=$_grp\"</script>";
} //fi state=1
else
{
 echo "<BR><BR><BR>Ostrze�enie!!!!!<BR><BR><BR>",
	 "Oy! What are you doing? $REMOTE_ADDR <BR>";
} //else state
?>