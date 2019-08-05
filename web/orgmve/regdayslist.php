<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$tytul='Job Title history';

//init $kier_img by Greg
for ($index = 0; $index <= 5; $index++ ) {
    if (!isset($kier_img[$index]))
        $kier_img[$index] = "";
}
(!isset($_POST['cln'])) ? $cln = $_GET['cln'] : $cln = $_POST['cln'];
(!isset($_POST['state'])) ? $state = 0 : $state = $_POST['state'];
(!isset($_POST['row_count'])) ? $row_count = 0 : $row_count = $_POST['row_count'];
for ($i = 0; $i < $row_count; $i++) {
    (!isset($_POST["id2_$i"])) ? $id2[$i] = 0 : $id2[$i] = $_POST["id2_$i"];
    (!isset($_POST["datechange_$i"])) ? $datechange[$i] = "01/01/1000" : $datechange[$i] = $_POST["datechange_$i"];
}


uprstr($PU,90);

$tabletxt = "";

if (!$db->Open()) $db->Kill();

if($state==0)
{

if(!isset($sort)) {$sort="5";$kier_sql ="DESC";}

        switch ($sort)
                {
                case 1:
                 $sortowanie="  ORDER BY `regdayshistory`.`datechange` DESC, active ASC";
                 break;
                case 2:
                 $sortowanie=" ORDER BY `nombers`.`knownas` $kier_sql";
                 break;
                case 3:
                 $sortowanie=" ORDER BY `nombers`.`surname` $kier_sql";
                 break;
                case 4:
                 $sortowanie=" ORDER BY `nombers`.`cat`";
                 break;
                case 5:
                 $sortowanie=" ORDER BY `regdayshistory`.`datechange` $kier_sql";
                 break;
                default:
                 $sortowanie=" ORDER BY `regdayshistory`.`datechange`, active DESC  ";
                 break;
                }


if (!$db->Open()) $db->Kill();
$q = "SELECT `nombers`.`pno` , `nombers`.`surname` , `nombers`.`firstname` , `nombers`.`knownas` , `nombers`.`cat` ,DATE_FORMAT(`regdayshistory`.`datechange`, \"%d/%m/%Y\") as datechange,`regdayshistory`.`regdays`,`regdayshistory`.`active`,`regdayshistory`.`id` FROM `nombers` INNER JOIN  `regdayshistory` ON `nombers`.`pno` = `regdayshistory`.`no` WHERE `nombers`.`pno` =  '$cln'";
$q=$q.$sortowanie;


$colour_odd = "DataTD2"; 
$colour_even = "DataTDGrey2"; 
$row_count=0;

  if ($db->Query($q)) 
  {
	$ileich=$db->Rows();

    while ($row=$db->Row())
    {

	$clocking = $row->pno;
	$row_color = (($row_count % 2) == 0) ? $colour_even : $colour_odd;
	

	

	$tabletxt .= "<tr>
	<input name='id2_$row_count' type='hidden' value='$row->id'>
  <td CLASS='$row_color' nowrap=\"nowrap\">$row->knownas</td>
	<td CLASS='$row_color' nowrap=\"nowrap\">$row->surname</td>
  <td CLASS='$row_color' nowrap=\"nowrap\"><div align=\"center\">$row->regdays&nbsp;</td>
  <td CLASS='$row_color' nowrap=\"nowrap\"><div align=\"center\">$row->active&nbsp;</td>
  <td CLASS='$row_color' nowrap=\"nowrap\"><div align=\"right\"><input class='Input' size='10' maxlength='10' name='datechange_$row_count' value=\"$row->datechange\"></td>
	  <td CLASS='$row_color' nowrap=\"nowrap\"><div align=\"right\"><a href=\"del_regdayslist.php?id=$row->id&cln=$cln\"><img src=\"images/delete_profile.gif\"></a></td>
 
    
    </tr>"; 
        $row_count++;
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
  <tr>
    <td align='middle' CLASS='FooterTD' colspan='8' nowrap>Total: $ileich </td>
  </tr>
</table>

</center>
<BR>
</td></tr>
</table>
<table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
            <tr> <td align='right' colspan='2'>
		    
		    <input name='state' type='hidden' value='1'>
                    <input name='row_count' type='hidden' value='$row_count'>
		    <input name='cln' type='hidden' value='$cln'>
		   <input class='Button' name='Update' type='submit' value='$SAVEBTN'>			

</td>  </tr>
</table>
 
</form>
";


$tabletxt = "  <TD ALIGN=JUSTIFY VALIGN=TOP border=0>

<center>
<form action='$PHP_SELF' method='post' name='regdayslist'>
<font CLASS='FormHeaderFont'>$tytul</b>
<table border='0' cellpadding='2' cellspacing='1' CLASS='FormTABLE' width=\"98%\">
  <tr>
   
    <td CLASS='ColumnTD2' nowrap=\"nowrap\"><div align=\"center\">
                <A HREF='$PHP_SELF?sort=2&kier=$kier&cln=$cln'>Known as$kier_img[2]</a>

       </div>  </td>
    <td CLASS='ColumnTD2' nowrap=\"nowrap\"><div align=\"center\">
                <A HREF='$PHP_SELF?sort=3&kier=$kier&cln=$cln'>Surname $kier_img[3]</a>

       </div>  </td>
   <td CLASS='ColumnTD2' nowrap=\"nowrap\"><div align=\"center\">
                <A HREF='$PHP_SELF?sort=4&kier=$kier&cln=$cln'>Regular Day</a></td>
       </div>  </td>
       <td CLASS='ColumnTD2' nowrap=\"nowrap\"><div align=\"center\">
                Active?</td>
      </div>   </td>
        <td CLASS='ColumnTD2' nowrap=\"nowrap\"><div align=\"center\">
                <A HREF='$PHP_SELF?sort=5&kier=$kier&cln=$cln'>Date change$kier_img[5]</a></td>
      </div>   </td>
       <td CLASS='ColumnTD2' nowrap=\"nowrap\"><div align=\"center\">
              Delete?</td>
       </td>
        
     	</tr>
".$tabletxt;
echo $tabletxt;
include_once("./footer.php");
}
elseif($state==1)
{
      
    for ($i = 0; $i < $row_count; $i++) {
        if ($id2[$i] !== 0)
            
        $sql ="UPDATE `regdayshistory`SET `regdayshistory`.datechange= STR_TO_DATE( '".$datechange[$i]."', '%d/%m/%Y') WHERE no='$cln' AND id='$id2[$i]' LIMIT 1";
   
        if (!$db->Query($sql))  $db->Kill();
    }  
  
   echo "<script language='javascript'>window.location=\"ed_os_k.php?lp=$cln\"</script>";
}



?>
