<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$tytul='Update employees pay';

(!isset($_POST['state'])) ? $state = 0 : $state = $_POST['state'];
(!isset($_POST['lp'])) ? $lp = $_GET['lp'] : $lp = $_POST['lp'];
(!isset($_POST['cln'])) ? $cln = 0 : $cln = $_POST['cln'];
(!isset($_POST["paystru"])) ? $paystru = "" : $paystru = $_POST["paystru"];
(!isset($_POST["daylyrate"])) ? $daylyrate = 0 : $daylyrate = $_POST["daylyrate"];
(!isset($_POST["started"])) ? $started = "0000-00-00" : $started = $_POST["started"];
(!isset($_POST["left1"])) ? $left1 = "0000-00-00" : $left1 = $_POST["left1"];
(!isset($_POST["dateforbonus"])) ? $dateforbonus = "0000-00-00" : $dateforbonus = $_POST["dateforbonus"];
(!isset($_POST["bonusmonth"])) ? $bonusmonth = 0 : $bonusmonth = $_POST["bonusmonth"];
(!isset($_POST["oldjobtitle"])) ? $oldjobtitle = "" : $oldjobtitle = $_POST["oldjobtitle"];
(!isset($_POST["category"])) ? $category = "" : $category = $_POST["category"];
(!isset($_POST["emplcathistorydate"])) ? $emplcathistorydate = "00/0000" : $emplcathistorydate = $_POST["emplcathistorydate"];
(!isset($_POST["bonustype"])) ? $bonustype = "" : $bonustype = $_POST["bonustype"];
(!isset($_POST["oldregdays"])) ? $oldregdays = 0 : $oldregdays = $_POST["oldregdays"];
(!isset($_POST["regdays"])) ? $regdays = 0 : $regdays = $_POST["regdays"];
(!isset($_POST["regdayshistorydate"])) ? $regdayshistorydate = "00/0000" : $regdayshistorydate = $_POST["regdayshistorydate"];
(!isset($_POST["_wendbonus"])) ? $_wendbonus = 0 : $_wendbonus = $_POST["_wendbonus"];
(!isset($_POST["_puncbonus"])) ? $_puncbonus = 0 : $_puncbonus = $_POST["_puncbonus"];
(!isset($_POST["_5bonus"])) ? $_5bonus = 0 : $_5bonus = $_POST["_5bonus"];
(!isset($_POST["_7bonus"])) ? $_7bonus = 0 : $_7bonus = $_POST["_7bonus"];
(!isset($_POST["_bhmbonus"])) ? $_bhmbonus = 0 : $_bhmbonus = $_POST["_bhmbonus"];
(!isset($_POST["travelctotal"])) ? $travelctotal = 0 : $travelctotal = $_POST["travelctotal"];
(!isset($_POST["_xmasbonus"])) ? $_xmasbonus = 0 : $_xmasbonus = $_POST["_xmasbonus"];
(!isset($_POST["secutitybonus"])) ? $secutitybonus = 0 : $secutitybonus = $_POST["secutitybonus"];
(!isset($_POST["_cloffice"])) ? $_cloffice = 0 : $_cloffice = $_POST["_cloffice"];
(!isset($_POST["_cloffice_only"])) ? $_cloffice_only = 0 : $_cloffice_only = $_POST["_cloffice_only"];
(!isset($_POST["_bonusrate"])) ? $_bonusrate = "0.00" : $_bonusrate = $_POST["_bonusrate"];
(!isset($_POST["_wrate"])) ? $_wrate = "0.00" : $_wrate = $_POST["_wrate"];
(!isset($_POST["_tocheck"])) ? $_tocheck = "0.00" : $_tocheck = $_POST["_tocheck"];
(!isset($_POST["_addtowrate"])) ? $_addtowrate = "0.00" : $_addtowrate = $_POST["_addtowrate"];
(!isset($_POST["_newpuncbonus"])) ? $_newpuncbonus = "0.00" : $_newpuncbonus = $_POST["_newpuncbonus"];
(!isset($_POST["tax_code"])) ? $tax_code = "" : $tax_code = $_POST["tax_code"];
(!isset($_POST["_VCond3"])) ? $_VCond3 = 0 : $_VCond3 = $_POST["_VCond3"];
(!isset($_POST["_VCond375"])) ? $_VCond375 = 0 : $_VCond375 = $_POST["_VCond375"];
(!isset($_POST["_VCond70"])) ? $_VCond70 = 0 : $_VCond70 = $_POST["_VCond70"];
(!isset($_POST["_VE"])) ? $_VE = "0.0000" : $_VE = $_POST["_VE"];
(!isset($_POST["_VFV"])) ? $_VFV = "0.00" : $_VFV = $_POST["_VFV"];
if (!isset($from1)) $from1 = 0;
if (!isset($to1)) $to1 = 0;
if (!isset($currentratefrom)) $currentratefrom = "";

if($state==0)
{
echo "	<TD ALIGN=JUSTIFY VALIGN=TOP border=0>
	<table width='100%' border=0><tr><td>
<center>
<form action='$PHP_SELF' method='post' name='ed_czl'>
  <font class='FormHeaderFont'>$tytul</font>
  <table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>";

//uprstr($PU,95);

// if (!$db->Open()) $db->Kill();
//  $q = "SELECT MAX(pno) AS pnox FROM nombers";
// if (!$db->Query($q)) $db->Kill();
//  $no=$db->Row();

 if (!$db->Open()) $db->Kill();
 if(isset($lp)){
 
 $q = "SELECT `nombers`.`pno` , `nombers`.`surname` , `nombers`.`firstname` , `nombers`.`knownas` , `nombers`.`cat` ,`emplcat`.catname,DATE_FORMAT(`emplcathistory`.`datechange`, \"%m/%Y\") as datechange,`emplcathistory`.`active` FROM (`nombers` LEFT JOIN  `emplcathistory` ON `nombers`.`pno` = `emplcathistory`.`no`) LEFT JOIN `emplcat` ON `emplcathistory`.`cat`= `emplcat`.catozn WHERE `nombers`.`pno` =  '$lp' ORDER BY  active,`emplcathistory`.`datechange` DESC LIMIT 1";
  
 if (!$db->Query($q)) $db->Kill();
  $row=$db->Row();
  $emplcathistorydate=$row->datechange;
  
 $q = "SELECT `nombers`.`pno` , `nombers`.`surname` , `nombers`.`firstname` , `nombers`.`knownas` , `nombers`.`cat` ,DATE_FORMAT(`regdayshistory`.`datechange`, \"%m/%Y\") as datechange,`regdayshistory`.`regdays`,`regdayshistory`.`active`,`regdayshistory`.`id` FROM `nombers` INNER JOIN  `regdayshistory` ON `nombers`.`pno` = `regdayshistory`.`no` WHERE `nombers`.`pno` =  '$lp' ORDER BY active,`regdayshistory`.`datechange` DESC  LIMIT 1";

  if (!$db->Query($q)) $db->Kill();
  $row=$db->Row();
  if (!isset($row->datechange))
       $regdayshistorydate = "00/0000";
  else
       $regdayshistorydate=$row->datechange;
  
  $q = "SELECT `nombers`.`ID`, `nombers`.`pno`, `nombers`.`surname`, `nombers`.`firstname`, `nombers`.`knownas`, `nombers`.`paystru`,`nombers`.`tax_code`, `nombers`.`newpayslip`, `nombers`.`daylyrate`, `nombers`.`currentratefrom`, `nombers`.`status`, `nombers`.`started`, `nombers`.`left1`, `nombers`.`dateforbonus`, `nombers`.`bonusmonth`, `nombers`.`offsetmonth`, `nombers`.`monthforav`, `nombers`.`withholdbonuses`, `nombers`.`cat`, `nombers`.`bonustype`, `nombers`.`vouchertype`, `nombers`.`previous12m`, `nombers`.`wendbonus`, `nombers`.`puncbonus`, `nombers`.`bonus5`, `nombers`.`bonus7`, `nombers`.`bhmbonus`, `nombers`.`secutitybonus`, `nombers`.`travelcard`, `nombers`.`travelctotal`, `nombers`.`xmasbonus`, `nombers`.`from1`, `nombers`.`to1`, `nombers`.`dueend`, `nombers`.`regdays`, `nombers`.`bonusrate`,`nombers`.`wrate`, `nombers`.`addtowrate`, `nombers`.`newpuncbonus`, `nombers`.`tocheck`, `nombers`.`VCond3`, `nombers`.`VCond375`, `nombers`.`VCond70`, `nombers`.`VE`, `nombers`.`VFV`,`nombers`.`cloffice`,`nombers`.`cloffice_only`, `emplcat`.`catname` FROM `nombers`  LEFT JOIN `emplcat` ON `nombers`.`cat`=`emplcat`.`catozn` WHERE `nombers`.`pno`='$lp'  LIMIT 1 ";
  } else { 
  echo "<BR><BR><CENTER><H1>Error in $PHP_SELF</H1></CENTER><BR><BR>";
  exit;
 }
  if (!$db->Query($q)) $db->Kill();
   while ($row=$db->Row())
    {
	$clockingNO = $row->pno;
    echo "
    <tr>
      <td class='FieldCaptionTD'>Clocking in number</td><td class='DataTDBig'>$row->pno</td>
	  <td class='FieldCaptionTD'>Known as (TimeTable name)</td><td class='DataTDBig'>$row->knownas</td>

      <td class='FieldCaptionTD'>First name</td><td class='DataTDBig'>$row->firstname</td>
      <td class='FieldCaptionTD'>Surname</td><td class='DataTDBig'>$row->surname</td>
    </tr>  
		      <tr>
		  <TD COLSPAN=8>
			<a CLASS='DataLink' href='hr_data.php?cln=$clockingNO'><IMG SRC='images/report.png' WIDTH='16' HEIGHT='16' BORDER='0' TITLE='Staff details'>STAFF DETAILS</a>
		<a CLASS='DataLink' href='advance1.php?cln=$clockingNO'><IMG SRC='images/expand_row.gif' WIDTH='16' HEIGHT='16' BORDER='0' TITLE='ADVANCES'>ADVANCES</a>
		<a CLASS='DataLink' href='pay01.php?cln=$clockingNO'><IMG SRC='images/cons_report.gif' WIDTH='16' HEIGHT='16' BORDER='0' TITLE='PAYs'>PAY</a>
		<a CLASS='DataLink' href='t_of_staff.php?cln=$clockingNO'><IMG SRC='images/last1hr.gif' WIDTH='16' HEIGHT='16' BORDER='0' TITLE='Clocking'>TIME OF STAFF</a>
		<a CLASS='DataLink' href='hollid1.php?cln=$clockingNO'><IMG SRC='images/hollidays.gif' WIDTH='16' HEIGHT='16' BORDER='0' TITLE='Holidays'>HOLIADYS</a>
		<a CLASS='DataLink' href='ed_os_s.php?lp=$clockingNO'><IMG SRC='images/home.gif' WIDTH='16' HEIGHT='16' BORDER='0' TITLE='EDIT SHOP  FOR THE STAFF'>EDIT SHOP</a>
		<a CLASS='DataLink' href='ed_os.php?lp=$clockingNO'><IMG SRC='images/edit.png' BORDER='0' TITLE='EDIT'>EDIT NAME ETC.</a>
		<a CLASS='DataLink' href='del_os.php?cln=$clockingNO'><IMG SRC='images/drop.png' BORDER='0' TITLE='DEL. STAFF'>DEL. STAFF</a>
			<a CLASS='DataLink' href='application_form.php?cln=$clockingNO'>Application form (testing)</a>
				<a CLASS='DataLink' href='payslips_emp1.php?cln=$clockingNO'>Payslips (testing)</a>
    </TD>
		      </tr> 
   </table><BR>";
 // koniec naglowka-----------------------------------------------------------------------edycja ponizej
/*, $row->newpayslip, $row->currentratefrom, $row->offsetmonth, $row->monthforav, $row->withholdbonuses, $row->cat,$row->vouchertype, $row->previous12m, $row->dueend
*/
 
if($row->wendbonus == 0)  {$wedbon="<INPUT TYPE='checkbox' NAME='_wendbonus'>";}
	else {$wedbon="<INPUT TYPE='checkbox' NAME='_wendbonus' checked>";}

if($row->puncbonus == 0) {$punbon="<INPUT TYPE='checkbox' NAME='_puncbonus'>";}
	else {$punbon="<INPUT TYPE='checkbox' NAME='_puncbonus' checked>";}

if($row->bonus5 == 0) {$p5bon="<INPUT TYPE='checkbox' NAME='_5bonus'>";}
	else {$p5bon="<INPUT TYPE='checkbox' NAME='_5bonus' checked>";}

if($row->bonus7 == 0) {$p7bon="<INPUT TYPE='checkbox' NAME='_7bonus'>";}
	else {$p7bon="<INPUT TYPE='checkbox' NAME='_7bonus' checked>";}

if($row->bhmbonus == 0) {$bhm="<INPUT TYPE='checkbox' NAME='_bhmbonus'>";}
	else {$bhm="<INPUT TYPE='checkbox' NAME='_bhmbonus' checked>";}

if($row->xmasbonus == 0) {$xmas="<INPUT TYPE='checkbox' NAME='_xmasbonus'>";}
	else {$xmas="<INPUT TYPE='checkbox' NAME='_xmasbonus' checked>";}

if($row->VCond3 == 0) {$oVCond3="<INPUT TYPE='checkbox' NAME='_VCond3'>";}
	else {$oVCond3="<INPUT TYPE='checkbox' NAME='_VCond3' checked>";}

if($row->VCond375 == 0) {$oVCond375="<INPUT TYPE='checkbox' NAME='_VCond375'>";}
	else {$oVCond375="<INPUT TYPE='checkbox' NAME='_VCond375' checked>";}

if($row->VCond70 == 0) {$oVCond70="<INPUT TYPE='checkbox' NAME='_VCond70'>";}
	else {$oVCond70="<INPUT TYPE='checkbox' NAME='_VCond70' checked>";}

if($row->cloffice == 0) {$ocloffice="<INPUT TYPE='checkbox' NAME='_cloffice'>";}
	else {$ocloffice="<INPUT TYPE='checkbox' NAME='_cloffice' checked>";}
if($row->cloffice_only == 0) {$ocloffice_only="<INPUT TYPE='checkbox' NAME='_cloffice_only'>";}
	else {$ocloffice_only="<INPUT TYPE='checkbox' NAME='_cloffice_only' checked>";}

$hourlyrate = $row->daylyrate / 8.5;
$HR=number_format($hourlyrate,2,'.',' ');

$rc = $row->cat;

echo "
<table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
    <tr >
      <td class='FieldCaptionTD'>Pay structure</td>
	  <td class='DataTD'><!-- <input class='Input' size='3' maxlength='3' name='paystru' value='$row->paystru'> -->
	
	<select class='Select' name='paystru'>
<option selected value='$row->paystru'>$row->paystru</option>
<option value='NEW'>NEW</option>
<option value='OLD'>OLD</option>
</select></td>

	  <td class='FieldCaptionTD'>Hourly rate</td>
	  <td class='DataTD'>&pound; <B>$HR</B></td>
	  <td class='FieldCaptionTD'>Daily rate</td>
	  <td class='DataTD' colspan='3'>&pound; <input class='Input' size='5' maxlength='7' name='daylyrate' value='$row->daylyrate'></td>
    </tr>
    <tr>
      <td class='FieldCaptionTD'>Started</td>
	  <td class='DataTD'><input class='Input' size='10' maxlength='10' name='started' value='$row->started'></td>
      <td class='FieldCaptionTD'>Left</td>
	  <td class='DataTD'><input class='Input' size='10' maxlength='10' name='left1' value='$row->left1'></td>
      <td class='FieldCaptionTD'>Date for bonus</td>
	  <td class='DataTD' colspan='3'><input class='Input' size='10' maxlength='10' name='dateforbonus' value='$row->dateforbonus'> Bonus year starts from the following month</td>
	</tr>
    <tr>
      <td class='FieldCaptionTD'>Bonus month</td>
	  <td class='DataTD'><input class='Input' size='2' maxlength='2' name='bonusmonth' value='$row->bonusmonth'></td>
      <td class='FieldCaptionTD'>Job title</td>
      	<input name='oldjobtitle' type='hidden' value='$rc'>
	  <td class='DataTD'><select class='Select' name='category'>
	";
		  $q = "SELECT catozn,catname FROM emplcat Order by catname";

//	$db = new CMySQL;
     if (!$db->Open()) $db->Kill();
  if ($db->Query($q)) 
  {
    while ($r=$db->Row())
    {
		if ($rc == $r->catozn) 
				echo "<option value='$r->catozn' selected>$r->catname</option>";
		else 
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
echo " </select>
      <br>
      <input class='Input' size='8' maxlength='8' name='emplcathistorydate' value='$emplcathistorydate'>
     <br> <A HREF='emplcatlist.php?cln=$clockingNO'>Job Title list</A>
      <td class='FieldCaptionTD'>Bonus type</td>
	  <td class='DataTD'><input class='Input' size='5' maxlength='5' name='bonustype' value='$row->bonustype'></td>
      <td class='FieldCaptionTD'>Regular days</td>
	  <td class='DataTD'>
    <input name='oldregdays' type='hidden' value='$row->regdays'>
    <input class='Input' size='2' maxlength='2' name='regdays' value='$row->regdays'>
    <br><input class='Input' size='7' maxlength='7' name='regdayshistorydate' value='$regdayshistorydate'>&nbsp;mm/yyyy
    <br><A HREF='regdayslist.php?cln=$clockingNO'>Reg Days list</A></td>
	</tr>	
    <tr>
      <td class='FieldCaptionTD'>W-End Bonus </td>
	  <td class='DataTD'>$wedbon</td>
      <td class='FieldCaptionTD'>Punc bonus</td>
	  <td class='DataTD'>$punbon</td>
      <td class='FieldCaptionTD'>5% Bonus </td>
	  <td class='DataTD'>$p5bon</td>
      <td class='FieldCaptionTD'>7% Bonus </td>
	  <td class='DataTD'>$p7bon</td>
	</tr>
    <tr>
      <td class='FieldCaptionTD'>BHM Bonus </td>
	  <td class='DataTD'>$bhm</td>
      <td class='FieldCaptionTD'>Travel card</td>
	  <td class='DataTD'><input class='Input' size='5' maxlength='5' name='travelctotal' value='$row->travelctotal '></td>
      <td class='FieldCaptionTD' >XMAS Bonus type</td>
	  <td class='DataTD'>$xmas</td>
      <td class='FieldCaptionTD'>Security Bonus </td>
	  <td class='DataTD'>&pound;<input class='Input' size='5' maxlength='5' name='secutitybonus' value='$row->secutitybonus'></td>
	</tr>
    <tr>
<!-- 17/11/2007 <td class='FieldCaptionTD'>From</td>
	  <td class='DataTD'><input class='Input' size='5' maxlength='5' name='from1' value='$row->from1'></td>
      <td class='FieldCaptionTD'>To</td>
	  <td class='DataTD'><input class='Input' size='5' maxlength='5' name='to1' value='$row->to1'></td> 
-->
      <td class='FieldCaptionTD'>Clocking in the office Mon-Fri</td>
	  <td class='DataTD'>$ocloffice</td>
      <td class='FieldCaptionTD'>Clocking in/out only in the office Mon-Fri</td>
	  <td class='DataTD'>$ocloffice_only</td>
<!-- free columns marker -->
      <td class='FieldCaptionTD'>&nbsp;</td>
	  <td class='DataTD'>&nbsp;</td>

      <td class='FieldCaptionTD'>Bonus rate</td>
	  <td class='DataTD'>&pound;&nbsp;<input class='Input' size='5' maxlength='5' name='_bonusrate' value='$row->bonusrate'></td>
      <td class='FieldCaptionTD'>WEnd B rate</td>
	  <td class='DataTD'>&pound;&nbsp;<input class='Input' size='5' maxlength='5' name='_wrate' value='$row->wrate'></td>
	</tr>	
	<tr>
      <td class='FieldCaptionTD'>Days to check<IMG SRC='images/help.gif' WIDTH='16'  title='special Chris condition to check days before bonuses'></td>
	  <td class='DataTD'><input class='Input' size='5' maxlength='5' name='_tocheck' value='$row->tocheck'></td>
      <td class='FieldCaptionTD'>Weekend additional <IMG SRC='images/help.gif' WIDTH='16'  title='(you add this to every weekend day)'></td>
	  <td class='DataTD'>&pound;&nbsp;<input class='Input' size='5' maxlength='5' name='_addtowrate' value='$row->addtowrate'></td>
      <td class='FieldCaptionTD'>Punct. deduction<IMG SRC='images/help.gif' WIDTH='16'  title='Punctuality bonus/penalty for NEW scale employees(% of the min wage to deduct bonuses in case of deduction)'></td>
	  <td class='DataTD'>&nbsp;<input class='Input' size='5' maxlength='5' name='_newpuncbonus' value='$row->newpuncbonus'> &nbsp;%</td>
	 <td class='FieldCaptionTD'>Tax Code</td>
	  <td class='DataTD'><input class='Input' size='10' maxlength='5' name='tax_code' value='$row->tax_code'></td>
  </tr>
<!-- VOUCHERS -->
	<tr>
      <td class='FieldCaptionTD' colspan='8'><CENTER>Vouchers</CENTER> </td>
	</tr>
		  	<tr>
      <td class='DataTD'>Voucher conditions</td>
	  <td class='DataTD' colspan='3'> $oVCond3 3 days, $oVCond375 3.75 days, $oVCond70 70% Punct</td>
      <td class='DataTD'>Help:<IMG SRC='images/help.gif' WIDTH='16'  title='this is help'></td>
	  <td class='DataTD'>Voucher entitlement <input class='Input' size='4' maxlength='7' name='_VE' value='$row->VE'></td>
	  <td class='DataTD'>Fixed amount <input class='Input' size='3' maxlength='5' name='_VFV' value='$row->VFV'></td>
	  <td class='DataTD'>&nbsp;</td>	</tr>

<input name='cln' type='hidden' value='$row->pno'>
<input name='lp' type='hidden' value='$row->ID'>";
  }


// przyciski i stopka ------------------------------------------------------------------------------
echo "  <table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
            <tr> <td align='right' colspan='2'>
		    
		    <input name='state' type='hidden' value='1'>
			<input class='Button' name='Update' type='submit' value='$SAVEBTN'>
			<input class='Button'  type='Button' onclick='window.location=\"t_lista.php\"' value='$LISTBTN'></td>

</td>  </tr>
 
</form>
</center>
<BR>
</td></tr>
</table>";
include_once("./footer.php");
}
elseif($state==1)
{
	checkZm("daylyrate");
	checkZm("started");
	checkZm("category");
	checkZm("regdays");
	checkZm("cln");
  checkZm("oldjobtitle"); 
 // checkZm("emplcathistorydate");
 // checkZm("regdayshistorydate");
  
$newpayslip=0;
if($paystru=="New") $newpayslip=1;

if( $_wendbonus !== 0 ) $_wendbonus = 1;
if( $_puncbonus !== 0 ) $_puncbonus = 1;
if( $_5bonus !== 0 ) $_5bonus = 1;
if( $_7bonus !== 0 ) $_7bonus = 1;
if( $_bhmbonus !== 0 ) $_bhmbonus = 1;
if( $_xmasbonus !== 0 ) $_xmasbonus = 1;
if( $_VCond3 !== 0 ) $_VCond3 = 1;
if( $_VCond375 !== 0 ) $_VCond375 = 1;
if( $_VCond70 !== 0 ) $_VCond70 = 1;
if( $_cloffice !== 0 ) $_cloffice = 1;
if( $_cloffice_only !== 0 ) $_cloffice_only = 1;


if (!$db->Open()) $db->Kill();
	$query = ("UPDATE `nombers` SET  paystru='$paystru', newpayslip='$newpayslip', daylyrate='$daylyrate',tax_code='$tax_code', currentratefrom='$currentratefrom', started='$started', left1='$left1', dateforbonus='$dateforbonus', bonusmonth='$bonusmonth', cat='$category', bonustype='$bonustype', wendbonus='$_wendbonus', puncbonus='$_puncbonus', bonus5='$_5bonus', bonus7='$_7bonus', bhmbonus='$_bhmbonus', secutitybonus='$secutitybonus', travelctotal='$travelctotal', xmasbonus='$_xmasbonus', from1='$from1', to1='$to1', regdays='$regdays', bonusrate='$_bonusrate', wrate='$_wrate', `newpuncbonus`='$_newpuncbonus', `addtowrate`='$_addtowrate', `tocheck`='$_tocheck', `VCond3`='$_VCond3', `VCond375`='$_VCond375', `VCond70`='$_VCond70', `VE`='$_VE' , `VFV`='$_VFV', `cloffice`='$_cloffice',  `cloffice_only`='$_cloffice_only'	WHERE `ID` = '$lp' LIMIT 1") ;
   if (!$db->Query($query)) $db->Kill();
 //  echo "<script language='javascript'>window.location=\"t_lista.php\"</script>";
//   }


if (  $oldjobtitle != $category) {

$DeleteInDay = "UPDATE `emplcathistory` SET `active` = 'n' WHERE `no`= '$cln'";
if (!$db->Query($DeleteInDay)) $db->Kill();
//if ($emplcathistorydate=="" || $emplcathistorydate == "00/00/00" || $emplcathistorydate == "00/00")  $emplcathistorydate=$FirstOfTheMonth;
//else  $emplcathistorydate= "01/$emplcathistorydate" ;
$emplcathistorydate=$FirstOfTheMonth;
$ins = "INSERT INTO `emplcathistory` ( `no`, `catold` , `cat` , `datechange`, `active` ) VALUES ('$cln',  '$oldjobtitle','$category',  STR_TO_DATE( '$emplcathistorydate', '%d/%m/%Y'),'y' )";
if (!$db->Query($ins)) $db->Kill();

}	
 
if (  $oldregdays != $regdays) {


$DeleteInDay = "UPDATE  `nombers`  SET  `nombers`.`regdays` = '$regdays' WHERE `pno`= '$cln' Limit 1";

if (!$db->Query($DeleteInDay)) $db->Kill();

$DeleteInDay = "UPDATE `regdayshistory` SET `active` = 'n' WHERE `no`= '$cln'";
if (!$db->Query($DeleteInDay)) $db->Kill();
//if ($regdayshistorydate=="" || $regdayshistorydate == "00/00/00" || $regdayshistorydate == "00/00")  $regdayshistorydate=$FirstOfTheMonth;
//else $regdayshistorydate="01/$regdayshistorydate";
//$regdayshistorydate=$FirstOfTheMonth;
$regdayshistorydate="01/$regdayshistorydate";
$ins = "INSERT INTO `regdayshistory` ( `no` ,`regdaysold` , `regdays` , `datechange`, `active` ) VALUES ('$cln', '$oldregdays','$regdays',  STR_TO_DATE( '$regdayshistorydate', '%d/%m/%Y'),'y' )";
if (!$db->Query($ins)) $db->Kill();

}	

 
 echo "<script language='javascript'>window.location=\"ed_os_k.php?lp=$cln\"</script>";

} //if state=1
else
{
 echo "<BR><BR><BR>Ostrze�enie!!!!!<BR><BR><BR>",
	 "Ktos z komputera $REMOTE_ADDR probuje sie wlamac<BR>";
} //else state
?>

