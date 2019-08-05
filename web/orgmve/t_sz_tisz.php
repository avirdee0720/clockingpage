<?php
include_once("./header.php");
$tytul='Operations on times, time edit';
include("./inc/uprawnienia.php");
include("./config.php");

if(!isset($state))
{
echo "	<TD ALIGN=JUSTIFY VALIGN=TOP border=0>
	<table width='100%' border=0><tr><td>

<center>
<form action='$PHP_SELF' method='post' name='ed_czl'>
  <font class='FormHeaderFont'>$tytul</font>
  <table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
  
  <tr>
      <td class='FieldCaptionTD'>Employee clocking in number</td>

<td class='DataTD'>   <select class='Select' name='_cln'>
		<option selected value='%'>chose or leave for all</option>";
		  $q = "SELECT nombers.knownas, nombers.firstname, nombers.surname, nombers.pno FROM `nombers` LEFT JOIN inout ON inout.no=nombers.pno WHERE nombers.status=\"OK\" GROUP BY nombers.pno ORDER BY nombers.pno ASC";

//	$db = new CMySQL;
     if (!$db->Open()) $db->Kill();
  if ($db->Query($q)) 
  {
    while ($r=$db->Row())
    {

          echo "<option value='$r->pno'>$r->pno: $r->firstname $r->surname</option>";
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
      <td class='DataTD'><input class='Input' maxlength='12' name='startd' value='$FirstOfTheMonth'>

      </td>
    </tr>
    <tr>  
      <td class='FieldCaptionTD'>End date</td>
      <td class='DataTD'><input class='Input' maxlength='12' name='endd' value='$dzis2'></td>
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
   if (!$db->Open()) $db->Kill();

   echo "<script language='javascript'>window.location=\"totalh2.php?cln=$_cln&startd=$startd&endd=$endd\"</script>";
} //fi state=1
else
{
 echo "<BR><BR><BR>Ostrze�enie!!!!!<BR><BR><BR>",
	 "Oy! What are you doing? $REMOTE_ADDR <BR>";
} //else state
?>