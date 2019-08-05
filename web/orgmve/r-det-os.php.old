<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$tytul='Pay structure - all staff';
 	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=excel-pay-stru" .$ddo.".xls");
	header("Pragma: no-cache");
	header("Expires: 0");
?>

<center>
<table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
<tr>
          <td class='FieldCaptionTD'>CL NO</td>
          <td class='FieldCaptionTD'>Pay structure</td> 
          <td class='FieldCaptionTD'>Hourly rate</td> 
          <td class='FieldCaptionTD'>Daily rate</td> 
          <td class='FieldCaptionTD'>Started</td>
          <td class='FieldCaptionTD'>Left</td>
          <td class='FieldCaptionTD'>Date for bonus</td>
          <td class='FieldCaptionTD'>Bonus month</td> 
          <td class='FieldCaptionTD'>Category</td>
          <td class='FieldCaptionTD'>Bonus type</td>
          <td class='FieldCaptionTD'>Regular days</td>
          <td class='FieldCaptionTD'>W-End Bonus </td>
          <td class='FieldCaptionTD'>Punc bonus</td>
          <td class='FieldCaptionTD'>5% Bonus </td> 
          <td class='FieldCaptionTD'>7% Bonus </td>         
          <td class='FieldCaptionTD'>BHM Bonus </td>
          <td class='FieldCaptionTD'>Travel card</td>
          <td class='FieldCaptionTD' >XMAS Bonus type</td> 
          <td class='FieldCaptionTD'>Security Bonus </td>
          <td class='FieldCaptionTD'>Clocking at the office</td>
          <td class='FieldCaptionTD'>Bonus rate</td> 
          <td class='FieldCaptionTD'>WEnd B rate</td>
          <td class='FieldCaptionTD'>Days to check</td>
          <td class='FieldCaptionTD'>Weekend additional </td> 
          <td class='FieldCaptionTD'>New punc bonus   </td>
          <td class='FieldCaptionTD'>V 3 days</td>
          <td class='FieldCaptionTD'>V 3.75 days</td>       
          <td class='FieldCaptionTD'>V 70% Punct</td>       
          <td class='FieldCaptionTD'>Voucher entitlement</td>       
          <td class='FieldCaptionTD'>V Fixed amount</td>                  
</tr>

<?php
 if (!$db->Open()) $db->Kill();
  $q = "SELECT `nombers`.`ID`, `nombers`.`pno`, `nombers`.`surname`, `nombers`.`firstname`, `nombers`.`knownas`, `nombers`.`paystru`, `nombers`.`newpayslip`, `nombers`.`daylyrate`, `nombers`.`currentratefrom`, `nombers`.`status`, `nombers`.`started`, `nombers`.`left1`, `nombers`.`dateforbonus`, `nombers`.`bonusmonth`, `nombers`.`offsetmonth`, `nombers`.`monthforav`, `nombers`.`withholdbonuses`, `nombers`.`cat`, `nombers`.`bonustype`, `nombers`.`vouchertype`, `nombers`.`previous12m`, `nombers`.`wendbonus`, `nombers`.`puncbonus`, `nombers`.`bonus5`, `nombers`.`bonus7`, `nombers`.`bhmbonus`, `nombers`.`secutitybonus`, `nombers`.`travelcard`, `nombers`.`travelctotal`, `nombers`.`xmasbonus`, `nombers`.`from1`, `nombers`.`to1`, `nombers`.`dueend`, `nombers`.`regdays`, `nombers`.`bonusrate`,`nombers`.`wrate`, `nombers`.`addtowrate`, `nombers`.`newpuncbonus`, `nombers`.`tocheck`, `nombers`.`VCond3`, `nombers`.`VCond375`, `nombers`.`VCond70`, `nombers`.`VE`, `nombers`.`VFV`,`nombers`.`cloffice`, `emplcat`.`catname` FROM `nombers` LEFT JOIN `emplcat` ON `nombers`.`cat`=`emplcat`.`catozn` WHERE `nombers`.`status`=\"OK\" ORDER BY `nombers`.`pno`";

  if (!$db->Query($q)) $db->Kill();
   while ($row=$db->Row())
    {
	$clockingNO = $row->pno;
    echo "
    <tr><td class='DataTD'>$row->pno</td>";
 // koniec naglowka-----------------------------------------------------------------------edycja ponizej
/*, $row->newpayslip, $row->currentratefrom, $row->offsetmonth, $row->monthforav, $row->withholdbonuses, $row->cat,$row->vouchertype, $row->previous12m, $row->dueend
*/

$hourlyrate = $row->daylyrate / 8.5;
$HR=number_format($hourlyrate,2,'.',' ');
echo "
	  <td class='DataTD'>$row->paystru</td>
      <td class='DataTD'>$HR</td>
	  <td class='DataTD' >$row->daylyrate</td>
      <td class='DataTD'>$row->started</td>
      <td class='DataTD'>$row->left1</td>
	  <td class='DataTD'>$row->dateforbonus</td>
      <td class='DataTD'>$row->bonusmonth</td>
	  <td class='DataTD'>$row->catname</td>
      <td class='DataTD'>$row->bonustype</td>
      <td class='DataTD'>$row->regdays</td>
      <td class='DataTD'>$row->wendbonus</td>
      <td class='DataTD'>$row->puncbonus</td>      
      <td class='DataTD'>$row->bonus5</td>
      <td class='DataTD'>$row->bonus7</td>                                   
	  <td class='DataTD'>$row->bhmbonus</td>
	  <td class='DataTD'>$row->travelctotal</td>
	  <td class='DataTD'>$row->xmasbonus</td>
      <td class='DataTD'>£$row->secutitybonus</td>
      <td class='DataTD'>$row->cloffice</td>
      <td class='DataTD'>$row->bonusrate</td>
      <td class='DataTD'>$row->wrate</td>
	  <td class='DataTD'>$row->tocheck</td>
      <td class='DataTD'>$row->addtowrate</td>    
 	  <td class='DataTD'>$row->newpuncbonus</td>
	  <td class='DataTD'>$row->VCond3</td>
      <td class='DataTD'>$row->VCond375</td>      
      <td class='DataTD'>$row->VCond70</td>
	  <td class='DataTD'>$row->VE</td>
	  <td class='DataTD'>$row->VFV</td>
</tr>  ";
  }
include_once("./footer.php");

?>

