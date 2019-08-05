<?php
//ini_set("display_errors","2");
//ERROR_REPORTING(E_ALL);

include_once("./header.php");
$tytul='Last Day Worked<BR>';
//include("./inc/uprawnienia.php");
include("./config.php");
$PHP_SELF = $_SERVER['PHP_SELF'];

$date1 = date("Y-m-d");

     $db = new CMySQL;
     if (!$db->Open()) $db->Kill();
     $db1 = new CMySQL;
     if (!$db1->Open()) $db1->Kill();

if (!isset($_POST['state'])) $state = 0; else $state = $_POST['state'];
if (!isset($_POST['_grp'])) $_grp = 0; else $_grp = $_POST['_grp'];
if (!isset($_POST['prepost'])) $prepost = 0; else $prepost = $_POST['prepost'];
     
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


// Pre two year or more


$q="SELECT value As prepostyearreport FROM `defaultvalues` Where `code`=\"prepostyearreport2\"";
    $db->Query($q);
    $r=$db->Row();
    $prepostyearreport=$r->prepostyearreport;
    
      $prepostyearreporttext = "<select class='Select' name='prepost'>\n";   
    
    if ($prepostyearreport=="pre") {
    $prepostyearreporttext .=  "
    <option value=\"both\">Both</option>
    <option value=\"pre\" selected>Pre Two Years</option>
    <option value=\"post\">Post Tow Years</option>
      ";
    } 
    
    if ($prepostyearreport=="post") {
    $prepostyearreporttext .=  "
    <option value=\"both\">Both</option>
    <option value=\"pre\">Pre Two Years</option>
    <option value=\"post\" selected>Post Two Years</option>
      ";
    } 
    if ($prepostyearreport=="both") {
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
   
  </table>
  	<input name='state' type='hidden' value='1'>
  <input class='Button' name='Update' type='submit' value='$OKBTN'>
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
 
if(!isset($sort)) {$sort="5";$kier_sql ="DESC";}

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
                 case 5:
                 $sortowanie=" ORDER BY d2 $kier_sql";
                 break;
                 case 6:
                 $sortowanie=" ORDER BY decision $kier_sql";
                 break;
                default:
                 $sortowanie=" ORDER BY `nombers`.`knownas` $kier_sql ";
                 break;
                }
if(!isset($letter)) $letter='%';
else $letter=$letter.'%';

		
		 $q2 = "UPDATE `defaultvalues` SET `value` = '$prepost' WHERE `code` ='prepostyearreport2' LIMIT 1;
  ";

 if (!$db1->Query($q2)) $db1->Kill();
		$row3=$db1->Row();
  
$tabletxt2 ="";


if ($DepGroup != "casual") $filterc = "AND `nombers`.`cat`<>'c'";
else  $filterc = "";
 

if ($prepost == "pre") {$filterd = "AND (DATEDIFF( now() , `nombers`.`started` ) < 365*2  or `nombers`.`started` is NULL or `nombers`.`started` = '0000-00-00')"; }
elseif ($prepost == "post") {$filterd = "AND (DATEDIFF( now() , `nombers`.`started` ) >= 365*2  or `nombers`.`started` is NULL or `nombers`.`started` = '0000-00-00')";}
else   {$filterd = "";}


$q = "SELECT DISTINCT `nombers`.`pno`,
                `nombers`.`surname`,
                `nombers`.`firstname`,
                `nombers`.`knownas`,
                `nombers`.`cat`,
                `nombers`.`textperson`,
                `nombers`.`sign`,
                DATE_FORMAT(`nombers`.`started`, \"%d/%m/%y\") AS d1,
                `emplcat`.`catname`,
                `emplcat`.`catname_staff`,
                max(`inout`.`date1`) AS d2,
                DATE_FORMAT(max(`inout`.`date1`), \"%d/%m/%y\") AS d3,
                `staffdetails`.`decision`
  FROM (   `nombers`
        CROSS JOIN
           `staffdetails`
        ON `nombers`.`pno` = `staffdetails`.`no`)
       INNER JOIN `emplcat`
          ON `nombers`.`cat` = `emplcat`.catozn
       INNER JOIN `inout`
          ON `nombers`.`pno` = `inout`.`no`
 WHERE     `nombers`.`status` = 'OK' $filterc $filterd
       AND `emplcat`.catname_staff LIKE '$DepGroup'
       AND (       `staffdetails`.`decision` <> '4'
               AND `staffdetails`.`decision` <> '3'
            OR `staffdetails`.`decision` IS NULL)
       AND `pno` <> '2372'
GROUP BY `pno`
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


  // Decision...
$decision = array("No","Yes","Don�t know" ,"Resigned","Dismissed","Casual");

	
	$tabletxt2 .= "<tr>
		<input name='id2[]' type='hidden' value='$row->pno'>
		<td  nowrap=\"nowrap\" width='5'></td>
  <td CLASS='$row_color' nowrap=\"nowrap\"><b>$row->knownas</b></td>
	<td CLASS='$row_color' nowrap=\"nowrap\"><b>$row->surname</b></td>
  <td CLASS='$row_color' nowrap=\"nowrap\"><b><div align=\"center\"><b>$row->catname_staff</b> </div></td>
  <td CLASS='$row_color' nowrap=\"nowrap\"><b><div align=\"right\"><b>$row->d1</b> </div></td>
   <td CLASS='$row_color' nowrap=\"nowrap\"><b>$row->d3</b></td> 
   <td CLASS='$row_color' nowrap=\"nowrap\"><b>".$decision[$row->decision]."</b></td> 
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
                <A HREF='$PHP_SELF?sort=1&kier=$kier&_grp=$_grp&prepost=$prepost&state=1'>Known as</a>

      </div></td>
    <td CLASS='ColumnTD2' nowrap=\"nowrap\"><div align=\"center\">
                <A HREF='$PHP_SELF?sort=2&kier=$kier&_grp=$_grp&prepost=$prepost&state=1'>Surname</a>

      </div> </td>
   <td CLASS='ColumnTD2' nowrap=\"nowrap\"><div align=\"center\">
                <A HREF='$PHP_SELF?sort=3&kier=$kier&_grp=$_grp&prepost=$prepost&state=1'>Job title</a></td>
       </div></td>
        <td CLASS='ColumnTD2' nowrap=\"nowrap\"><div align=\"center\">
                <A HREF='$PHP_SELF?sort=4&kier=$kier&_grp=$_grp&prepost=$prepost&state=1'>Started</a></td>
       </div></td>
                 <td CLASS='ColumnTD2' nowrap=\"nowrap\"><div align=\"center\"><A HREF='$PHP_SELF?sort=5&kier=$kier&_grp=$_grp&prepost=$prepost&state=1'>Last Day</a></div></td>
				</td>
        </td>
                 <td CLASS='ColumnTD2' nowrap=\"nowrap\"><div align=\"center\"><A HREF='$PHP_SELF?sort=6&kier=$kier&_grp=$_grp&prepost=$prepost&state=1'>Decision</a></div></td>
				</td>
				$tabletxt2
</center>
<BR>
</td></tr>
</table>
 <br>
";


$tabletxt .=  "

</form>

";



echo $tabletxt;
include_once("./footer.php");




 /*  echo "<script language='javascript'>window.location=\"hrrlist_pre1y_edit.php?_grp=$_grp\"</script>"; */
} //fi state=1
elseif($state==2)
{

checkZm("id2");
//checkZm("textpostoneyear");

}
else
{
 echo "<BR><BR><BR>Ostrze�enie!!!!!<BR><BR><BR>",
	 "Oy! What are you doing? $REMOTE_ADDR <BR>";
} //else state
?>