<?php
ini_set("display_errors","2");
//ERROR_REPORTING(E_ALL);

include_once("./header.php");
$tytul='Average 0.8 weekend days per week required: non-qualifiers below 0.8<BR>';
//include("./inc/uprawnienia.php");
include("./config.php");

 $db = new CMySQL;
 if (!$db->Open()) $db->Kill();
     
if(!isset($state))
{

    $q="SELECT value As weekendrequired FROM `defaultvalues` Where `code`=\"weekendrequired\"";
    $db->Query($q);
    $r=$db->Row();
    $weekendrequired =$r->weekendrequired ;
     $weekendrequiredtext  = "";
      $dirtext = "";   
    if ($weekendrequired =="1") {
    $weekendrequiredtext .=  "<input type=\"checkbox\" name=\"dir\" id=\"checkbox\" checked=\"checked\"/ value=\"1\">";
    } 
    else {
       $weekendrequiredtext .=  "<input type=\"checkbox\" name=\"dir\" id=\"checkbox\"/  value=\"1\">";
    }   
   
  $dirtext  .=  ".</select>"; 
    

$q = "SELECT DATE_FORMAT(DATE_SUB( DATE_SUB( CURDATE( ) , INTERVAL 1 YEAR ) , INTERVAL DAYOFWEEK( CURDATE( ) ) -3
DAY ) , \"%d/%m/%Y\") as datefrom,DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL DAYOFWEEK(CURDATE()-1)  DAY), \"%d/%m/%Y\") as dateto ;";

	  
     $db->Query($q);
     $r=$db->Row();
     $FirstOfTheMonth=$r->datefrom;
     $dzis2=$r->dateto;
     
     


echo "	<TD ALIGN=JUSTIFY VALIGN=TOP border=0>
	<table width='100%' border=0><tr><td>

<center>
<form action='$PHP_SELF' method='post' name='ed_czl'>
  <font class='FormHeaderFont'>$tytul</font>
  <table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
  
  <tr>
      <td class='FieldCaptionTD'>Employee category</td>

<td class='DataTD'>   <select class='Select' name='_grp'>
		<option selected value='0'>All</option>
    <option value='1'>Regular pre 1 year</option>\n
    <option value='2'>Regular post 1 year</option>\n
    <option value='3'>GA</option>\n
    <option value='4'>GMA</option>\n
    <option value='6'>SA</option>\n
    <option value='7'>Shop staff</option>\n
    ";
		
	/*	
		  $q = "SELECT `catozn`, `catname` FROM `emplcat`";

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

*/

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
      <td class='FieldCaptionTD'>Weekend Required</td>
      <td class='DataTD'>$weekendrequiredtext</td>
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
$limit = 0;
$limitvalid = 0;
if (!isset($limitvalid)) $limitvalid=0; 
   echo "<script language='javascript'>window.location=\"aver0_8weekend_b0_8_1b.php?startd=$startd&endd=$endd&_grp=$_grp&limit=$limit&dir=$dir&lv=$limitvalid\"</script>";
} //fi state=1
else
{
 echo "<BR><BR><BR>Ostrze¿enie!!!!!<BR><BR><BR>",
	 "Oy! What are you doing? $REMOTE_ADDR <BR>";
} //else state
?>