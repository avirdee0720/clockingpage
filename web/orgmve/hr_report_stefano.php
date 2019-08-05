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

//if (!isset($state) && isset($_POST['state'])) $state= $_POST['state'];
if (!isset($DepGroup) && isset($_POST['_grp'])) $DepGroup=$_POST['_grp'];
if (!isset($trust) && isset($_POST['trusted'])) $trust=$_POST['trusted'];

//if (!isset($reportid) && isset($_POST['_report'])) $reportid=$_POST['_report'];   

//if (!isset($state) && isset($_GET['state'])) $state= $_GET['state'];
if (!isset($DepGroup) && isset($_GET['_grp'])) $DepGroup=$_GET['_grp'];
if (!isset($trust) && isset($_GET['trusted'])) $trust=$_GET['trusted'];
if (!isset($sortt) && isset($_GET['sortt'])) $sortt=$_GET['sortt'];
if (!isset($sense) && isset($_GET['sn'])) $sense=$_GET['sn'];
//if (!isset($old) && isset($_GET['old'])) $old=$_GET['old'];
//echo $_GET['sn'];
//echo "<br>--$sense--<br>";
//if (!isset($reportid) && isset($_GET['_report'])) $reportid=$_GET['_report'];   

     
if(!isset($trust))
{
echo "	<TD ALIGN=JUSTIFY VALIGN=TOP border=0>
	<table width='100%' border=0><tr><td>

<center>
<form action='$PHP_SELF' method='post' name='ed_czl'>
  <font class='FormHeaderFont'>Appraisal Complete/Incomplete</font>
  <table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
  
  <tr>                                                                                                                                                       
      <td class='FieldCaptionTD'>Employee category</td>

<td class='DataTD'>   <select class='Select' name='_grp'>
		<option selected value='%'>All</option>";
		  $q = "SELECT DISTINCT  `catname_staff`, `catozn` FROM `emplcat` Where `catname_staff`<>'casual' Order by `catname_staff`";

	
  if ($db->Query($q)) 
  {
    while ($r=$db->Row())
    {

          echo "<option value='$r->catozn'>$r->catname_staff</option>\n";
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
</td></tr>";

// List of reports
echo "
 <tr>
      <td class='FieldCaptionTD'>Appraisal Complete:</td>
      <td class='DataTD'>   <input type=\"radio\" name=\"trusted\" value=\"1\">Yes<br>
<input type=\"radio\" name=\"trusted\" value=\"0\">No<br>
</td></tr>";

  
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
elseif(isset($trust))
{
   
 $str='';
 if($trust==1)  $str2="Appraisal Complete";
 else $str2="Appraisal Incomplete";
 
 if ($DepGroup!="%") $str="AND `cat`  = '$DepGroup'";
 
 if(!isset($sortt)) { $sortt=1; $sense='ASC';  }
//echo "<br>$sense<br>";
 switch ($sortt)
                {
                case 1:
                 $sortowanie=" ORDER BY `nombers`.`knownas` $sense";
                 break;
                case 2:
                 $sortowanie=" ORDER BY `nombers`.`surname` $sense";
                 break;
                case 3:
                 $sortowanie=" ORDER BY `emplcat`.catname_staff $sense";
                 break;
                case 4:
                 $sortowanie=" ORDER BY `nombers`.`started` $sense";
                 break;
                 default:
                 $sortowanie=" ORDER BY `nombers`.`started` $sense ";
                 break;
                }
    //echo $sortowanie;
//else echo "<br>non esiste<br>";
 
 
        
 
 $sql = "SELECT  `pno`,`knownas`, `surname`, `catname_staff`, `started` from nombers, emplcat WHERE trusted =$trust AND `status`='OK' AND `emplcat`.`catozn`=`nombers`.`cat` AND `nombers`.`cat`<>'c' $str $sortowanie";
//echo $sql ;
 
 //echo "<br>first-- $sense<br>";
 $old_sense=$sense;
  if ($sense=='DESC') $sense="ASC";
 else $sense="DESC";
 //echo "second-- $sense<br>";
if ($db->Query($sql)) 
  {
echo "<TD ALIGN=JUSTIFY VALIGN=TOP border=0>
	<table width='100%' border=0><tr><td>

<center>

  <font class='FormHeaderFont'>$str2</font>
  <table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
<tr><td class='FieldCaptionTD'>ID</td>
    <td class='DataTD'><b><A href=$PHP_SELF?sortt=1&trusted=$trust&_grp=$DepGroup&sn="; if($sortt==1) echo $sense; else echo $old_sense; echo ">Known as</A></b></td>
    <td class='DataTD'><b><A href=$PHP_SELF?sortt=2&trusted=$trust&_grp=$DepGroup&sn="; if($sortt==2) echo $sense; else echo $old_sense; echo ">Surname</A></b></td>
    <td class='DataTD'><b><A href=$PHP_SELF?sortt=3&trusted=$trust&_grp=$DepGroup&sn="; if($sortt==3) echo $sense; else echo $old_sense; echo ">Job title</A><b/></td>
    <td class='DataTD'><b><A href=$PHP_SELF?sortt=4&trusted=$trust&_grp=$DepGroup&sn="; if($sortt==4) echo $sense; else echo $old_sense; echo ">Started</A></b></td>
</tr>";
  
   while ($row=$db->Row())
    {
    echo "<tr>

    <td class='FieldCaptionTD'><A href=hr_data.php?cln=$row->pno>$row->pno</A></td>
    <td class='DataTD'> $row->knownas</td>
    <td class='DataTD'> $row->surname</td>
    <td class='DataTD'> $row->catname_staff</td>
    <td class='DataTD'> $row->started</td>
    
</tr>";
         //echo $row['fisrtname'];   
        }

        echo "
  <tr>                                                                                                                                                                                      
      


</table>
";


   
      
      
    }
      }
?>