<?php
include_once("./header.php");
$tytul='Who was in?<BR><BR>';
//include("./inc/uprawnienia.php");
include("./config.php");
include("./languages/$LANGUAGE.php");

if(!isset($state))
{

echo "	<TD ALIGN=JUSTIFY VALIGN=TOP border=0>
	<table width='100%' border=0><tr><td>

<center>
<form action='$PHP_SELF' method='post' name='ed_czl'>
  <font class='FormHeaderFont'>$tytul</font>
  <table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
  

    <tr>
      <td class='FieldCaptionTD'>Start date</td>
      <td class='DataTD'><input class='Input' maxlength='12' name='startd' value='$FirstOfTheMonth'>

      </td>
    </tr>
    <tr>  
      <td class='FieldCaptionTD'>End date</td>
      <td class='DataTD'><input class='Input' maxlength='12' name='endd' value='$yesterday1'></td>
    </tr>

      <tr>
      <td align='right' colspan='2'>
		<input name='state' type='hidden' value='1'>

			<input class='Button' name='Update' type='submit' value='$OKBTN'>
			<input class='Button' name='datesfromlastm' onclick='this.form.startd.value=\"$FirstOfLastMonth\";this.form.endd.value=\"$LastOfLastMonth\";' type='button' value='Prev month'>
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
$dataakt=date("dmY-Hi");
$today=date("Y-m-d");
list($day, $month, $year) = explode("/",$_POST['startd']);
$dod = "$year-$month-$day";
list($day1, $month1, $year1) = explode("/",$_POST['endd']);
$ddo= "$year1-$month1-$day1";
$sd = $_POST['startd'];
$ed = $_POST['endd'];
$title = "Who was in from $sd to $ed" ;
echo "<font class='FormHeaderFont'>$title</font><BR>
<table WIDTH=500 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >";
		echo " <tr>	
		<td class='ColumnTD'>&nbsp;</td>
			 <td class='ColumnTD'>Clocking no</td>
			 <td class='ColumnTD'>Firstname</td>
			 <td class='ColumnTD'>Surname</td>
			<td class='ColumnTD'>Known as</td> ";

$db = new CMySQL;
if (!$db->Open()) $db->Kill();

$sql = "SELECT  `inout`.`date1`, `inout`.`no`, `nombers`.`knownas`, `nombers`.`firstname`, `nombers`.`surname` FROM `inout` LEFT JOIN `nombers` ON `inout`.`no` = `nombers`.`pno` WHERE `inout`.`date1`>=\"$dod\" AND `inout`.`date1`<=\"$ddo\" GROUP BY `inout`.`no` ";
$licz = 0;
if ($db->Query($sql)) 
  {
    while ($row=$db->Row())
    {
		$licz++;
		echo " <tr>	
		<td class='DataTD'>$licz</td>
			 <td class='DataTD'>$row->no</td>
			 <td class='DataTD'>$row->firstname</td>
			 <td class='DataTD'>$row->surname</td>
			<td class='DataTD'>( $row->knownas )</td> ";


	}
  } else {
	echo "  <tr><td class='DataTD'></td>    <td class='DataTD' colspan='5'>SQL Error:".mysql_error()."</td> </tr>";
	$db->Kill();
  }

} //fi state=1
else
{
 echo "<BR><BR><BR>Ostrze¿enie!!!!!<BR><BR><BR>",
	 "Oy! What are you doing? $REMOTE_ADDR <BR>";
} //else state


echo "
</table>

</td></tr>
</table>";
include_once("./footer.php");
?>