<?php
//ini_set("display_errors","2");
//ERROR_REPORTING(E_ALL);

include_once("./header.php");
$tytul='Staff Report<BR>';
//include("./inc/uprawnienia.php");
include("./config.php");
$PHP_SELF = $_SERVER['PHP_SELF'];

$date1 = date("Y-m-d");

      $db = new CMySQL;
     if (!$db->Open()) $db->Kill();
     $db1 = new CMySQL;
     if (!$db1->Open()) $db1->Kill();
      $db3 = new CMySQL;
     if (!$db3->Open()) $db3->Kill();

if (!isset($_POST['state'])) $state = 0; else $state = $_POST['state'];
if (!isset($DepGroup) && isset($_POST['_grp'])) $DepGroup=$_POST['_grp'];
if (!isset($reportid) && isset($_POST['_report'])) $reportid=$_POST['_report'];   

if (!isset($DepGroup) && isset($_GET['_grp'])) $DepGroup=$_GET['_grp'];
if (!isset($reportid) && isset($_GET['_report'])) $reportid=$_GET['_report'];   

if (!isset($prepost) && isset($_POST['prepost'])) $prepost=$_POST['prepost'];     

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
		<option selected value='%'>All</option>";
	//	  $q = "SELECT DISTINCT  `catname_staff` FROM `emplcat` Where `catname_staff`<>'casual' Order by `catname_staff`";

	     $q = "SELECT DISTINCT  `catname_staff` FROM `emplcat`  Order by `catname_staff`";
	     
  if ($db->Query($q)) 
  {
    while ($r=$db->Row())
    {

          echo "<option value='$r->catname_staff'>$r->catname_staff</option>\n";
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
      <td class='FieldCaptionTD'>Report:</td>

<td class='DataTD'>   <select class='Select' name='_report'>";

		  $q = "SELECT DISTINCT  `id`,`title`,`state` FROM `staffreport` Where `state`='1' Order by `date1`";

	
  if ($db->Query($q)) 
  {
    while ($r=$db->Row())
    {

          echo "<option value='$r->id'>$r->title</option>\n";
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

// Pre two years or more


$q="SELECT value As prepostyearreport FROM `defaultvalues` Where `code`=\"prepostyearreport\"";
    $db->Query($q);
    $r=$db->Row();
    $prepostyearreport=$r->prepostyearreport;

      $prepostyearreporttext = "<select class='Select' name='prepost'>\n";   

    if ($prepostyearreport=="pre") {
    $prepostyearreporttext .=  "
    <option value=\"both\">Both</option>
    <option value=\"pre\" selected>Pre Two Years</option>
    <option value=\"post\">Post Two Years</option>
      ";
    } 
    
    if ($prepostyearreport=="post") {
    $prepostyearreporttext .=  "
     <option value=\"both\">Both</option>
    <option value=\"pre\">Pre Two Years</option>
    <option value=\"post\" selected>Post Two Years</option>
      ";
    } 
    if (($prepostyearreport=="both" )or ($prepostyearreport=="")) {
    $prepostyearreporttext .=  "
      <option value=\"both\" selected>Both</option>
     <option value=\"pre\">Pre Two Years</option>
    <option value=\"post\">Post Two Years</option>
      ";
    } 

   
  $prepostyearreporttext  .=  ".</select>"; 

echo "
 <tr>
      <td class='FieldCaptionTD'>Pre/Post Two Years Report</td>

<td class='DataTD'>$prepostyearreporttext 
</td></tr>";

  
echo "
<tr>
      <td align='right' colspan='2'>
		<input name='state' type='hidden' value='1'>
      <a CLASS='DataLink' href='hr_extra_report_edit.php?do=new'><IMG SRC='images/new_interface.png' BORDER='0' TITLE='NEW'>New report</a>
		<a CLASS='DataLink' href='hr_extra_report_edit.php?do=edit'><IMG SRC='images/edit.png' BORDER='0' TITLE='EDIT'>Edit name</a>
		<a CLASS='DataLink' href='hr_extra_report_edit.php?do=del'><IMG SRC='images/delete_profile.gif' BORDER='0' TITLE='DELETE'>Delete report</a>
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





$db2 = new CMySQL;

$DepGroupUpper=strtoupper($DepGroup);

if   ($kier_sql == "DESC")   $kier_sql = "ASC";
else        $kier_sql = "DESC" ;

uprstr($PU,90);



 $sql = "SELECT  `id`,`title`,`state` FROM `staffreport` Where `state`='1' and id ='$reportid' Limit 1";
 
if (!$db->Query($sql))  $db->Kill();

      $row=$db->Row();
      $title =$row->title;    



$tabletxt = "";




if (!$db2->Open()) $db2->Kill();
 
if(!isset($sort)) {$sort="4";$kier_sql ="DESC";}

        switch ($sort)
                {
                case 1:
                 $sortowanie=" ORDER BY `nombers`.`knownas` $kier_sql";
                 break;
                case 2:
                 $sortowanie=" ORDER BY `nombers`.`surname` $kier_sql";
                 break;
                case 3:
                 $sortowanie=" ORDER BY `emplcat`.catname $kier_sql";
                 break;
                case 4:
                 $sortowanie=" ORDER BY `nombers`.`started` $kier_sql";
                 break;
                default:
                 $sortowanie=" ORDER BY `nombers`.`knownas` $kier_sql ";
                 break;
                }
if(!isset($letter)) $letter='%';
else $letter=$letter.'%';

// Title question

$tytul = $title;

  
// $q3 = "UPDATE `defaultvalues` SET `value` = '$_prepostyearreport' WHERE `code` ='prepostyearreport' LIMIT 1;";

  
// if (!$db3->Query($q3)) $db3->Kill();
//		$row3=$db3->Row();
		
		
		 $q2 = "UPDATE `defaultvalues` SET `value` = '$prepost' WHERE `code` ='prepostyearreport' LIMIT 1;
  ";

 if (!$db1->Query($q2)) $db1->Kill();
		$row3=$db1->Row();
  
$tabletxt2 ="";


if ($DepGroup != "casual") $filterc = "AND `nombers`.`cat`<>'c'";
else  $filterc = "";

if ($prepost == "pre") {$filterd = "AND (DATEDIFF( now() , `nombers`.`started` ) < 365*2  or `nombers`.`started` is NULL or `nombers`.`started` = '0000-00-00')"; }
elseif ($prepost == "post") {$filterd = "AND (DATEDIFF( now() , `nombers`.`started` ) >= 365*2  or `nombers`.`started` is NULL or `nombers`.`started` = '0000-00-00')";}
else   {$filterd = "";}

$q = "SELECT DISTINCT `nombers`.`pno` , `nombers`.`surname` , `nombers`.`firstname` , `nombers`.`knownas` , `nombers`.`cat` ,`nombers`.`textperson` , `nombers`.`sign`, DATE_FORMAT( `nombers`.`started` , \"%d/%m/%y\" ) AS d1,  `emplcat`.catname,  `emplcat`.catname_staff FROM (`nombers` CROSS JOIN  `staffdetails` ON `nombers`.`pno` = `staffdetails`.`no`) INNER JOIN `emplcat` ON `nombers`.`cat`= `emplcat`.catozn  WHERE `nombers`.`status` = 'OK'  $filterc $filterd
AND  `emplcat`.catname_staff Like '$DepGroup'
AND (
`staffdetails`.`decision` <> '4'
AND `staffdetails`.`decision` <> '3'
OR `staffdetails`.`decision` IS NULL
)
AND pno<>'2372'
";


$q=$q.$sortowanie;

 //echo $q;
 
$colour_odd = "DataTD2"; 
$colour_even = "DataTDGrey2"; 
$row_count=0;



  if ($db->Query($q)) 
  {
	$ileich=$db->Rows();

    while ($row=$db->Row())
    {

	$clocking = $row->pno;
	$row_count++;
	$row_color = (($row_count % 2) == 0) ? $colour_even : $colour_odd;
	
	

$q = "SELECT `staffreport_text`.id, `staffreport_text`.`text` 
FROM `staffreport_text`  WHERE `staffreport_text`.no = '$row->pno'
AND   `staffreport_text`.staffreportid='$reportid'
";

  if (!$db2->Query($q)) $db2->Kill();
 
  $row2=$db2->Row();
  $rows = $db2->Rows();
  
  if ($rows > 0) {$text = $row2->text; $textid = $row2->id;}
  else  {$text = "";  $textid = "NEW&$row->pno";}
  
	
	
	$singlistcode = "";

$q = "SELECT id, value, signcode FROM `singlist`";

  if (!$db2->Query($q)) $db2->Kill();
 
   if ($db2->Query($q)) 
  {
    while ($row2=$db2->Row())
    {
   	if ($row->sign == $row2->value) 
				$singlistcode.= "<option value='$row2->value' selected>$row2->signcode</option>";
		else 
		       $singlistcode.="<option value='$row2->value'>$row2->signcode</option>";
      }
    }
 
	
	$tabletxt2 .= "<tr>
		<input name='id2[]' type='hidden' value='$row->pno'>
		<td  nowrap=\"nowrap\" width='5'></td>
  <td CLASS='$row_color' nowrap=\"nowrap\"><b>$row->knownas</b></td>
	<td CLASS='$row_color' nowrap=\"nowrap\"><b>$row->surname</b></td>
  <td CLASS='$row_color' nowrap=\"nowrap\"><b><div align=\"center\"><b>$row->catname_staff</b></td>
  <td CLASS='$row_color' nowrap=\"nowrap\"><b><div align=\"right\"><b>$row->d1</b></td>
   <td CLASS='ColumnTD2' nowrap=\"nowrap\"  width='220'>
   <input name='textid[]' type='hidden' value='$textid'>
   <b><input class='Input' size='50' maxlength='255' name='textperson[]' value=\"$text\"></b>
               </td> 
  </td>
    </tr>"; 
  } 
} else {
	$echo=  " 
  <tr>
    <td CLASS='DataTD'></td>
    <td CLASS='DataTD' colspan='3'>Brak dzialow</td>
  </tr>";
 $db->Kill();
}
	$tabletxt .=  "
	

<center>


<font CLASS='FormHeaderFont'>$tytul&nbsp;&nbsp;   &nbsp;&nbsp;  Total:<b> $ileich</b>
<form action='$PHP_SELF?_grp=$DepGroup' method='post' name='hrlist'>
<input name='reportid' type='hidden' value='$reportid'>
<table border='0' cellpadding='0' cellspacing='0'>
  <tr>
     <td  nowrap=\"nowrap\" width='25'></td>
    <td CLASS='ColumnTD2' nowrap=\"nowrap\"><div align=\"center\">
                <A HREF='$PHP_SELF?sort=1&kier=$kier&_grp=$_grp&_report=$reportid&prepost=$prepost&state=1'>Known as</a>

      </td>
    <td CLASS='ColumnTD2' nowrap=\"nowrap\"><div align=\"center\">
                <A HREF='$PHP_SELF?sort=2&kier=$kier&_grp=$_grp&_report=$reportid&prepost=$prepost&state=1'>Surname</a>

       </td>
   <td CLASS='ColumnTD2' nowrap=\"nowrap\"><div align=\"center\">
                <A HREF='$PHP_SELF?sort=3&kier=$kier&_grp=$_grp&_report=$reportid&prepost=$prepost&state=1'>Job title</a></td>
       </td>
        <td CLASS='ColumnTD2' nowrap=\"nowrap\"><div align=\"center\">
                <A HREF='$PHP_SELF?sort=4&kier=$kier&_grp=$_grp&_report=$reportid&prepost=$prepost&state=1'>Started</a></td>
       </td>
                 <td CLASS='ColumnTD2' nowrap=\"nowrap\" >&nbsp;</td>
				</td>
        
				$tabletxt2
</center>
<BR>
</td></tr>
</table>
 <br>
";


$tabletxt .=  "
 <table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
            <tr> <td align='right' colspan='2'>
		    
		    <input name='state' type='hidden' value='2'>
		   <input class='Button' name='Update' type='submit' value='$SAVEBTN'>			

</td>  </tr>
</table>
</form>

";



echo $tabletxt;
include_once("./footer.php");




 //  echo "<script language='javascript'>window.location=\"hrrlist_pre2y_edit.php?_grp=$_grp\"</script>";
} //fi state=1
elseif($state==2)
{
//var_dump($_POST);
checkzm("id2");
//checkZm("textpostoneyear");
$id2 = $_POST["id2"];
$reportid= $_POST["reportid"];
$textperson = $_POST["textperson"];
foreach ($id2 as  $key =>  $value) {

 $sql = "SELECT DISTINCT  `id` FROM `staffreport_text` Where `no`='$value' and `staffreportid` ='$reportid' Limit 1";
if (!$db->Query($sql))  $db->Kill();

      $row=$db->Row();
      $rows=$db->Rows();
      $text=$textperson[$key];
      //$text= $db->Fix($textperson[$key]); 
    if ($rows>0) {
    $sql ="UPDATE `staffreport_text` SET `staffreport_text`.`text`= '$text' ,`staffreport_text`.`date1`= '$date1'
       Where `no`='$value'
       and `staffreportid` ='$reportid'
        LIMIT 1";
 	if (!$db->Query($sql))  $db->Kill();
           }
     else {
     
    $sql =" INSERT INTO `staffreport_text`
				(`staffreportid`,`no`,`text`,`date1`,`state`) 
				VALUES 
				('$reportid','$value','$text','$date1','1')
				";
	//echo $sql . "/n";
 	if (!$db->Query($sql))  $db->Kill();
           
           }
     
     
     }      
           
           
    
 echo "<script language='javascript'>window.location=\"$PHP_SELF?_grp=$DepGroup&_report=$reportid&state=1\"</script>";


}
else
{
 echo "<BR><BR><BR>Ostrze�enie!!!!!<BR><BR><BR>",
	 "Oy! What are you doing? $REMOTE_ADDR <BR>";
} //else state
?>