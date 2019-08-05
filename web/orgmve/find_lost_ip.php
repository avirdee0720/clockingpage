<?php
ini_set("display_errors","2");
ERROR_REPORTING(E_ALL);

include_once("./header.php");
$tytul1='Appraisal<BR>';
$PHP_SELF = $_SERVER['PHP_SELF'];
//include("./inc/uprawnienia.php");
include("./config.php");

$date1 = date("Y-m-d");

      $db = new CMySQL;
     if (!$db->Open()) $db->Kill();



if (!isset($name) && isset($_POST['name'])) $name=$_POST['name'];

if (!isset($name) && isset($_GET['name'])) $name=$_GET['name'];
 

     
if(!isset($name))
{
echo "	<TD ALIGN=JUSTIFY VALIGN=TOP border=0>
	<table width='100%' border=0><tr><td>

<center>
 <font class='FormHeaderFont'>IP</font>
<form action='$PHP_SELF' method='post' name='ed_czl'>
 
  <table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
  
  <tr>                                                                                                                                                       
      <td class='FieldCaptionTD'>Employee category</td>

<td class='DataTD'> First and surname: <input type=\"text\" name=\"name\" /><br />
</td></tr>";

// List of reports


  
echo "
<tr>
      <td align='right' colspan='2'>
	
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
elseif(isset($name))
{
   
  $array=split(' ', $name);
     
 
 $sql = "SELECT inout.no, firstname, surname, inout.ipadr, date1, intime, mobilephone  FROM `inout`, staffdetails, nombers WHERE inout.no=(SELECT pno FROM `nombers` WHERE knownas=\"$array[0]\" AND surname=\"$array[1]\") AND inout.no=staffdetails.no AND (knownas=\"$array[0]\" AND surname=\"$array[1]\") ORDER BY date1 DESC, intime DESC limit 1";
//echo $sql;
if ($db->Query($sql)) 
  {
echo "<TD ALIGN=JUSTIFY VALIGN=TOP border=0>
	<table width='100%' border=0><tr><td>

<center>

  <font class='FormHeaderFont'>IP</font>
  <table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
<tr>
    <td class='DataTD'><b>ID</b></td>
    <td class='DataTD'><b>first name</b></td>
    <td class='DataTD'><b>surname<b/></td>
    <td class='DataTD'><b>ip address</b></td>
    <td class='DataTD'><b>date</b></td>
    <td class='DataTD'><b>in time</b></td>
    <td class='DataTD'><b>mobile phone</b></td>
</tr>";
  
   while ($row=$db->Row())
    {
    echo "<tr>

    
    <td class='DataTD'>$row->no</td>
    <td class='DataTD'>$row->firstname</td>
    <td class='DataTD'>$row->surname</td>
    <td class='DataTD'>$row->ipadr</td>
    <td class='DataTD'>$row->date1</td>
    <td class='DataTD'>$row->intime</td>
    <td class='DataTD'>$row->mobilephone</td>
    
</tr>";
         //echo $row['fisrtname'];   
        }

        echo "
  <tr>                                                                                                                                                                                      
      


</table>
	
<form action='$PHP_SELF' method='post' name='ed_czl'>
  
  <table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
  
  <tr>                                                                                                                                                       
      <td class='FieldCaptionTD'>Employee category</td>

<td class='DataTD'> First and surname: <input type=\"text\" name=\"name\" /><br />
</td></tr>
<tr>
      <td align='right' colspan='2'>
	
			<input class='Button' name='Update' type='submit' value='$OKBTN'>
			</td>
    </tr>
  
</form>
</center>
<BR>
</td></tr>
</table>";



   
      
      
    }
      }
?>
