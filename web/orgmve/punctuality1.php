<?php
ini_set("display_errors","2");
ERROR_REPORTING(E_ALL);

include_once("./header.php");
$tytul='Punctuality<BR>';
//include("./inc/uprawnienia.php");
include("./config.php");
$PHP_SELF = $_SERVER['PHP_SELF'];

$db = new CMySQL;
if (!$db->Open()) $db->Kill();

if (!isset($_POST['state'])) $state = 0; else $state = $_POST['state'];
if (!isset($_POST['_grp'])) $_grp = 0; else $_grp = $_POST['_grp'];
if (!isset($_POST['startd'])) $startd = "00/00/0000"; else $startd = $_POST['startd'];
if (!isset($_POST['endd'])) $endd = "00/00/0000"; else $endd = $_POST['endd'];
if (!isset($_POST['limitvalid10'])) $limitvalid10 = 1; else $limitvalid10 = $_POST['limitvalid10'];
if (!isset($_POST['limit10'])) $limit10 = 0; else $limit10 = $_POST['limit10'];
if (!isset($_POST['dir10'])) $dir10 = 'a'; else $dir10 = $_POST['dir10'];
if (!isset($_POST['limitvalid20'])) $limitvalid20 = 1; else $limitvalid20 = $_POST['limitvalid20'];
if (!isset($_POST['limit20'])) $limit20 = 0; else $limit20 = $_POST['limit20'];
if (!isset($_POST['dir20'])) $dir20 = 'a'; else $dir20 = $_POST['dir20'];
     
if($state==0)
{

    $q="SELECT value As punctualitylimit10 FROM `defaultvalues` Where `code`=\"punctualitylimit10\"";
    $db->Query($q);
    $r=$db->Row();
    $punctualitylimit10=$r->punctualitylimit10;


    $q="SELECT value As punctualitylimitdir10 FROM `defaultvalues` Where `code`=\"punctualitylimitdir10\"";
    $db->Query($q);
    $r=$db->Row();
    $punctualitydir10=$r->punctualitylimitdir10;
    
      $q="SELECT value As punctualitylimit20 FROM `defaultvalues` Where `code`=\"punctualitylimit20\"";
    $db->Query($q);
    $r=$db->Row();
    $punctualitylimit20=$r->punctualitylimit20;


    $q="SELECT value As punctualitylimitdir20 FROM `defaultvalues` Where `code`=\"punctualitylimitdir20\"";
    $db->Query($q);
    $r=$db->Row();
    $punctualitydir20=$r->punctualitylimitdir20;
    
    
      $dirtext10 = "<select class='Select' name='dir10'>\n";   
    if ($punctualitydir10=="a") {
    $dirtext10 .=  "<option value=\"a\" selected>Above</option>
      <option value=\"b\">Below</option>
      ";
    } 
    else {
       $dirtext10 .=  "<option value=\"a\">Above</option>
      <option value=\"b\" selected>Below</option>
      ";
    }   
   
  $dirtext20  =  ".</select>"; 
   
     $dirtext20 = "<select class='Select' name='dir20'>\n";   
    if ($punctualitydir20=="a") {
    $dirtext20 .=  "<option value=\"a\" selected>Above</option>
      <option value=\"b\">Below</option>
      ";
    } 
    else {
       $dirtext20 .=  "<option value=\"a\">Above</option>
      <option value=\"b\" selected>Below</option>
      ";
    }   
   
  $dirtext20  .=  ".</select>";  

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
    <option value='1'>Regular pre 2 years</option>\n
    <option value='2'>Regular post 2 years</option>\n
    <option value='3'>GA+Builders</option>\n
    <option value='4'>GMA</option>\n
    <option value='6'>SA</option>\n
    <option value='7'>Shop staff</option>\n
    <option value='8'>Accounts</option>\n
    <option value='9'>IT</option>\n
    <option value='10'>Buyers</option>\n
    <option value='12'>Non-buyers</option>\n
    <option value='11'>Casuals</option>\n
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
      <td class='FieldCaptionTD'>Limitation - Before 10 a.m.</td>
      <td class='DataTD'> <input name=\"limitvalid10\" type=\"checkbox\" id=\"limitvalidid\" value=\"1\"/></td>
    </tr>
    <tr>  
      <td class='FieldCaptionTD'>Limit</td>
      <td class='DataTD'><input class='Input' maxlength='5' name='limit10' value='$punctualitylimit10'></td>
    </tr>
    <tr>  
      <td class='FieldCaptionTD'>Direction</td>
      <td class='DataTD'>
     $dirtext10
      </td>
    </tr>
    <tr>  
      <td class='FieldCaptionTD'>Limitation - After 8 p.m.</td>
      <td class='DataTD'> <input name=\"limitvalid20\" type=\"checkbox\" id=\"limitvalidid\" value=\"1\"/></td>
    </tr>
     <tr>  
      <td class='FieldCaptionTD'>Limit</td>
      <td class='DataTD'><input class='Input' maxlength='5' name='limit20' value='$punctualitylimit20'></td>
    </tr>
    <tr>  
      <td class='FieldCaptionTD'>Direction</td>
      <td class='DataTD'>
     $dirtext20
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

if (!isset($limitvalid10)) $limitvalid10=0;
if (!isset($limitvalid20)) $limitvalid20=0;  

   echo "<script language='javascript'>window.location=\"punctuality1b.php?startd=$startd&endd=$endd&_grp=$_grp&limit10=$limit10&dir10=$dir10&lv10=$limitvalid10&limit20=$limit20&dir20=$dir20&lv20=$limitvalid20\"</script>";
} //if state=1
else
{
 echo "<BR><BR><BR>Ostrze�enie!!!!!<BR><BR><BR>",
	 "Oy! What are you doing? $REMOTE_ADDR <BR>";
} //else state
?>