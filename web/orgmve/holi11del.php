<?php
include_once("./header.php");
$tytul='Enter date which you added to count holiday for November<BR><BR>';
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
      <td class='DataTD'><input class='Input' maxlength='12' name='day' value=''>

      </td>
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
//include("./config.php");
//include("./languages/$LANGUAGE.php");
$dataakt=date("dmY-Hi");
list($day, $month, $year) = explode("/",$_POST['day']);
$day = "$year-$month-$day";




$db = new CMySQL; 
	echo "<TABLE><tr><td>CL no</td><td>TIME WORKED</td><td>WEEKEND TIME</td><td>TOTAL DAYS</td><td>WEEKEND DAYS</td><td>Punct %</td></tr>";

if (!$db->Open()) $db->Kill();
$prac1 =("INSERT INTO `holidays11` SELECT * FROM `holidays` WHERE ` date1`='day';");
if (!$db->Query($prac1)) $db->Kill();
while ($emp=$db->Row())
{

	echo "<tr><td>Data has been moved $day</td></tr>";

} // koniec dla prac
echo "</TABLE>";

} //fi state=1
else
{
 echo "<BR><BR><BR>Ostrze¿enie!!!!!<BR><BR><BR>",
	 "Oy! What are you doing? $REMOTE_ADDR <BR>";
} //else state
include_once("./footer.php");
?>