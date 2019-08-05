<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$db1 = new CMySQL;

$dataakt=date("d/m/Y H:i:s");
$dataaktn=date("Y-m-d");

$dataakt2=date("d/m/Y");
$day = date("d");
$datac =  date("Y-m");    
$data1d =  "$datac -01";
$datace =  date("m/Y");     

$clearing_day = $dataakt2;
if ($day<=10) $clearing_day="10/$datace";
else if ($day<=20) $clearing_day="20/$datace";

 
//uprstr($PU,90);
$cln=$_GET['lp'];
$tytul='Flat Rent Moving';

if (!$db1->Open()) $db1->Kill();
$prac1 =("SELECT * FROM `nombers` INNER JOIN rent ON nombers.pno=rent.no WHERE `pno`='$cln' and active = 'y';");
if (!$db1->Query($prac1)) $db1->Kill();
   $row1=$db1->Row();
   
echo "
	<font class='FormHeaderFont'>$tytul</font> 
<TABLE><TR><TD>
<FORM METHOD=POST ACTION='flatrent2.php'>
<table>
    <tr>
      <td class='FieldCaptionTD'>Clocking in number</td><td class='DataTD'><FONT COLOR='#000099'><B>$row1->pno</B></FONT></td>
	  <td class='FieldCaptionTD'>Known as</td><td class='DataTD'>$row1->knownas</td>
    </tr>
    <tr>
      <td class='FieldCaptionTD'>First name</td><td class='DataTD'>$row1->firstname</td>
      <td class='FieldCaptionTD'>Surname</td><td class='DataTD'>$row1->surname</td>
    </tr>   
</table>

<TABLE border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
<td class='FieldCaptionTD'>Flat</td>
      <td class='FieldCaptionTD'>Date in</td>
      <td class='FieldCaptionTD'>Date out</td>
      <td class='FieldCaptionTD'>Amount</td>
      <td class='FieldCaptionTD'>Active</td>
    </tr> 
";

if (!$db1->Open()) $db1->Kill();
$prac1 =("SELECT * FROM `rent` INNER JOIN rent_flat ON rent.flatid=rent_flat.flatid WHERE `no`='$cln' and active = 'y';");
if (!$db1->Query($prac1)) $db1->Kill();
   while ($row1=$db1->Row())
    {
      $no=$row1->pno;
      $rentind = $row1->rentid;
      $flatid = $row1->flatid;
      $flatname = $row1->flatname;
      $datein= $row1->datein;
      $dateout= $row1->dateout;
      $amount= $row1->amount;
      $active= $row1->active;
      
    
      
    
echo "

    <tr>
    <td class='DataTD'>$flatname</td>
     <td class='DataTD'>$datein</td>
     <td class='DataTD'>$dateout</td>
      <td class='DataTD'>$amount</td>
     <td class='DataTD'>$active</td>
    </tr> ";  

	}

echo "	
</TABLE>
</FORM><!-- end of new advance -->
</TD>

</TR>
</TABLE>

</TD></TR></TABLE>

</center><BR></td></tr></table>";
include_once("./footer.php");
?>