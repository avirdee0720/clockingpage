<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$db1 = new CMySQL;
$dataYS=date("Y")."-01-01";
$dataakt=date("Y-m-d");

$tytul='Staff details';

if (!$db->Open()) $db->Kill();

(!isset($_POST["state"])) ? $state = "0" : $state = $_POST["state"];
(!isset($_POST['cln'])) ? $cln = $_GET['cln'] : $cln = $_POST['cln'];

//initialization
(!isset($_POST["approvedon"])) ? $approvedon = "" : $approvedon = $_POST["approvedon"];
(!isset($_POST["approved"])) ? $approved = 0 : $approved = $_POST["approved"];
(!isset($_POST["_pr14"])) ? $_pr14 = 0 : $_pr14 = $_POST["_pr14"];
(!isset($_POST["_pr16"])) ? $_pr16 = 0 : $_pr16 = $_POST["_pr16"];
(!isset($_POST["_pr20"])) ? $_pr20 = 0 : $_pr20 = $_POST["_pr20"];
(!isset($_POST["_pr28"])) ? $_pr28 = 0 : $_pr28 = $_POST["_pr28"];
(!isset($_POST["_pr30"])) ? $_pr30 = 0 : $_pr30 = $_POST["_pr30"];
(!isset($_POST["_pr32"])) ? $_pr32 = 0 : $_pr32 = $_POST["_pr32"];
(!isset($_POST["_pr34"])) ? $_pr34 = 0 : $_pr34 = $_POST["_pr34"];
(!isset($_POST["_nhg56"])) ? $_nhg56 = 0 : $_nhg56 = $_POST["_nhg56"];
(!isset($_POST["_nhg34"])) ? $_nhg34 = 0 : $_nhg34 = $_POST["_nhg34"];
(!isset($_POST["_nhg36"])) ? $_nhg36 = 0 : $_nhg36 = $_POST["_nhg36"];
(!isset($_POST["_nhg38"])) ? $_nhg38 = 0 : $_nhg38 = $_POST["_nhg38"];
(!isset($_POST["_nhg40"])) ? $_nhg40 = 0 : $_nhg40 = $_POST["_nhg40"];
(!isset($_POST["_nhg42"])) ? $_nhg42 = 0 : $_nhg42 = $_POST["_nhg42"];
(!isset($_POST["_chs"])) ? $_chs = 0 : $_chs = $_POST["_chs"];
(!isset($_POST["_bs"])) ? $_bs = 0 : $_bs = $_POST["_bs"];
(!isset($_POST["_gcs"])) ? $_gcs = 0 : $_gcs = $_POST["_gcs"];
(!isset($_POST["jobtitle"])) ? $jobtitle = "" : $jobtitle = $_POST["jobtitle"];
(!isset($_POST["oldjobtitle"])) ? $oldjobtitle = "" : $oldjobtitle = $_POST["oldjobtitle"];
(!isset($_POST["category"])) ? $category = "" : $category = $_POST["category"];
(!isset($_POST["cattoname"])) ? $cattoname = "" : $cattoname = $_POST["cattoname"];
(!isset($_POST["weekendrequired"])) ? $weekendrequired = 0 : $weekendrequired = $_POST["weekendrequired"];
(!isset($_POST["address1"])) ? $address1 = "" : $address1 = $_POST["address1"];
(!isset($_POST["address2"])) ? $address2 = "" : $address2 = $_POST["address2"];
(!isset($_POST["address3"])) ? $address3 = "" : $address3 = $_POST["address3"];
(!isset($_POST["address4"])) ? $address4 = "" : $address4 = $_POST["address4"];
(!isset($_POST["postcode"])) ? $postcode = "" : $postcode = $_POST["postcode"];
(!isset($_POST["terminationtype"])) ? $terminationtype = "" : $terminationtype = $_POST["terminationtype"];
(!isset($_POST["xx"])) ? $xx = "" : $xx = $_POST["xx"];
(!isset($_POST["homephone"])) ? $homephone = "" : $homephone = $_POST["homephone"];
(!isset($_POST["mobilephone"])) ? $mobilephone = "" : $mobilephone = $_POST["mobilephone"];
(!isset($_POST["email1"])) ? $email1 = "" : $email1 = $_POST["email1"];
(!isset($_POST["ref"])) ? $ref = 0 : $ref = $_POST["ref"];
(!isset($_POST["grade"])) ? $grade = "" : $grade = $_POST["grade"];
(!isset($_POST["speciality"])) ? $speciality = "" : $speciality = $_POST["speciality"];
(!isset($_POST["rent"])) ? $rent = "" : $rent = $_POST["rent"];
(!isset($_POST["advances"])) ? $advances = 0 : $advances = $_POST["advances"];
(!isset($_POST["cloffice"])) ? $cloffice = 0 : $cloffice = $_POST["cloffice"];
(!isset($_POST["moretrialday"])) ? $moretrialday = 0 : $moretrialday = $_POST["moretrialday"];
(!isset($_POST["displ"])) ? $displ = "" : $displ = $_POST["displ"];
(!isset($_POST["_d247"])) ? $_d247 = 0 : $_d247 = $_POST["_d247"];
(!isset($_POST["decisionsave"])) ? $decisionsave = 0 : $decisionsave = $_POST["decisionsave"];
(!isset($_POST["decision"])) ? $decision = 0 : $decision = $_POST["decision"];
(!isset($_POST["comment1"])) ? $comment1 = 0 : $comment1 = $_POST["comment1"];
(!isset($_POST["comment2"])) ? $comment2 = 0 : $comment2 = $_POST["comment2"];
(!isset($_POST["comment3"])) ? $comment3 = 0 : $comment3 = $_POST["comment3"];
(!isset($_POST["lp"])) ? $lp = 0 : $lp = $_POST["lp"];
for ($i = 1; $i <= 20; $i++) {
    (!isset($_POST["knowledge_$i"])) ? $knowledge_cap[$i] = 0 : $knowledge_cap[$i] = $_POST["knowledge_$i"];
    (!isset($_POST["knowledge_$i"."_small"])) ? $knowledge_small[$i] = 0 : $knowledge_small[$i] = $_POST["knowledge_$i"."_small"];
}
for ($i = 1; $i <= 18; $i++) {
    (!isset($_POST["key_$i"])) ? $keys[$i] = 0 : $keys[$i] = $_POST["key_$i"];
}
if (!isset($weekendrequiredtext)) $weekendrequiredtext = "";
if (!isset($advances)) $advances = "";
if (!isset($mon)) $mon = "";
if (!isset($tue)) $tue = "";
if (!isset($wed)) $wed = "";
if (!isset($thu)) $thu = "";
if (!isset($fri)) $fri = "";
if (!isset($sat)) $sat = "";
if (!isset($sun)) $sun = "";
if (!isset($_surname)) $_surname = "";
if (!isset($email)) $email = "";

$YearAct = date("Y");

if ($state == 0)
{
echo "	<TD ALIGN=JUSTIFY VALIGN=TOP border=0>
	<table width='100%' border=0><tr><td>
<center>
<form action='$PHP_SELF' method='post' name='ed_czl'>
  <font class='FormHeaderFont'>$tytul</font>
  <table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>";

//uprstr($PU,95);

 
 if(isset($cln)){  
  $sql = ("SELECT `nombers`.`trusted`, `nombers`.`pno`, `nombers`.`surname`, `nombers`.`firstname`, `nombers`.`knownas`, `nombers`.`cat`, `nombers`.`cattoname`,`advances`,`weekendrequired`,`rent`,DATE_FORMAT(`nombers`.`started`, \"%d/%m/%Y\") as d1,DATE_FORMAT(`nombers`.`dateforattendence`, \"%d/%m/%Y\") as dateforattendence, `nombers`.`daylyrate`, `nombers`.`regdays`, `nombers`.`displ`,  `nombers`.`cloffice`, `nombers`.`moretrday`, 
          `staffdetails`.`homephone` , `staffdetails`.`mobilephone` ,`staffdetails`.`email` As email1, `staffdetails`.`jobtitle` , `staffdetails`.`datehired` , `staffdetails`.`firstregularday` , `staffdetails`.`datephototaken` , `staffdetails`.`photograph` , `staffdetails`.`terminationtype` , `staffdetails`.`noticegiven` , `staffdetails`.`dooraccess` , `staffdetails`.`managament_bonus` , `staffdetails`.`punctuality_bonus` , `staffdetails`.`security_bonus` , `staffdetails`.`travel_card_bonus` , `staffdetails`.`address1` , `staffdetails`.`address2` , `staffdetails`.`address3` , `staffdetails`.`address4` , `staffdetails`.`postcode` , `staffdetails`.`pr14` , `staffdetails`.`pr16` , `staffdetails`.`pr20` , `staffdetails`.`pr28` , `staffdetails`.`pr30` , `staffdetails`.`pr32` , `staffdetails`.`pr34` , `staffdetails`.`nhg34` , `staffdetails`.`nhg36` , `staffdetails`.`nhg38` , `staffdetails`.`nhg40` , `staffdetails`.`nhg42` , `staffdetails`.`nhg56` , `staffdetails`.`chs` , `staffdetails`.`bs` , `staffdetails`.`gcs` , `staffdetails`.`noappraisal` , `staffdetails`.`247` AS D24,`staffdetails`.`decision` , `staffdetails`.`comment1` , `staffdetails`.`comment2` , `staffdetails`.`comment3` , `staffdetails`.`comment4` , `staffdetails`.`comment5` , `staffdetails`.`comment6` , DATE_FORMAT(`staffdetails`.`approvedon` , \"%d/%m/%Y\") as approvedon, `staffdetails`.`grade` , `staffdetails`.`approved` , `staffdetails`.`OLD` , `staffdetails`.`speciality` , `staffdetails`.`aproved`,DATE_FORMAT(`staffdetails`.`decisiondate` , \"%d/%m/%Y\") as decisiondate
          FROM `nombers` LEFT JOIN  `staffdetails` ON `nombers`.`pno` = `staffdetails`.`no` WHERE `nombers`.`pno` = '$cln' LIMIT 1");
  } else { 
  echo "<BR><BR><CENTER><H1>Error in $PHP_SELF there is no detailed info about Clocking number: $cln</H1></CENTER><BR><BR>";
  exit;
 }
  if (!$db->Query($sql)) { $db->Kill(); $db->Error(); exit; }
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
		<a CLASS='DataLink' href='dailyappraisal.php?cln=$clockingNO' target='_Blank'>DAILY APPRAISAL</a>
		<a CLASS='DataLink' href='advance1.php?cln=$clockingNO'><IMG SRC='images/expand_row.gif' WIDTH='16' HEIGHT='16' BORDER='0' TITLE='ADVANCES'>ADVANCES</a>
		<a CLASS='DataLink' href='pay01.php?cln=$clockingNO'><IMG SRC='images/cons_report.gif' WIDTH='16' HEIGHT='16' BORDER='0' TITLE='PAYs'>PAY</a>
		<a CLASS='DataLink' href='t_of_staff.php?cln=$clockingNO'><IMG SRC='images/last1hr.gif' WIDTH='16' HEIGHT='16' BORDER='0' TITLE='Clocking'>TIME OF STAFF</a>
		<a CLASS='DataLink' href='hollid1.php?cln=$clockingNO&yearAct=$YearAct'><IMG SRC='images/hollidays.gif' WIDTH='16' HEIGHT='16' BORDER='0' TITLE='Holidays'>HOLIADYS</a>
		<a CLASS='DataLink' href='ed_os_s.php?lp=$clockingNO'><IMG SRC='images/home.gif' WIDTH='16' HEIGHT='16' BORDER='0' TITLE='EDIT SHOP  FOR THE STAFF'>EDIT SHOP</a>
		<a CLASS='DataLink' href='ed_os.php?lp=$clockingNO'><IMG SRC='images/edit.png' BORDER='0' TITLE='EDIT'>EDIT NAME ETC.</a>
		<a CLASS='DataLink' href='del_os.php?cln=$clockingNO'><IMG SRC='images/drop.png' BORDER='0' TITLE='DEL. STAFF'>DEL. STAFF</a>
		<a CLASS='DataLink' href='application_form.php?cln=$clockingNO'>Application form (test)</a>
		<a CLASS='DataLink' href='email_sending.php?cln=$clockingNO'>Email (test)</a>
	  <a CLASS='DataLink' href='tt_column.php?lp=$clockingNO'>TimeTable Column(test)</a>
	  <a CLASS='DataLink' href='flatrent1.php?lp=$clockingNO'>Flat Managment(test)</a>
    </TD>
		      </tr> 
   </table><BR>";

$clockingNO = $row->pno; 
if($row->cat == "c" ) { $POSITION="CASUAL"; }
else if ($row->cat == "ui" || $row->cat == "ut") { $POSITION="UNPAID"; }
else { $POSITION="REGULAR"; }
if($row->pr14 == 0)  {$pr14="<INPUT TYPE='checkbox' NAME='_pr14'>";}
	else {$pr14="<INPUT TYPE='checkbox' NAME='_pr14' checked>";}
	
if($row->pr16 == 0)  {$pr16="<INPUT TYPE='checkbox' NAME='_pr16'>";}
	else {$pr16="<INPUT TYPE='checkbox' NAME='_pr16' checked>";}

if($row->pr20 == 0)  {$pr20="<INPUT TYPE='checkbox' NAME='_pr20'>";}
	else {$pr20="<INPUT TYPE='checkbox' NAME='_pr20' checked>";}
if($row->pr28 == 0)  {$pr28="<INPUT TYPE='checkbox' NAME='_pr28'>";}
	else {$pr28="<INPUT TYPE='checkbox' NAME='_pr30' checked>";}
if($row->pr30 == 0)  {$pr30="<INPUT TYPE='checkbox' NAME='_pr30'>";}
	else {$pr30="<INPUT TYPE='checkbox' NAME='_pr30' checked>";}
if($row->pr32 == 0)  {$pr32="<INPUT TYPE='checkbox' NAME='_pr34'>";}
	else {$pr32="<INPUT TYPE='checkbox' NAME='_pr32' checked>";}

if($row->pr34 == 0)  {$pr34="<INPUT TYPE='checkbox' NAME='_pr32'>";}
	else {$pr34="<INPUT TYPE='checkbox' NAME='_pr32' checked>";}

if($row->nhg56 == 0)  {$nhg56="<INPUT TYPE='checkbox' NAME='_nhg56'>";}
	else {$nhg56="<INPUT TYPE='checkbox' NAME='_nhg56' checked>";}

if($row->nhg34 == 0)  {$nhg34="<INPUT TYPE='checkbox' NAME='_nhg34'>";}
	else {$nhg34="<INPUT TYPE='checkbox' NAME='_nhg34' checked>";}

if($row->nhg36 == 0)  {$nhg36="<INPUT TYPE='checkbox' NAME='_nhg36'>";}
	else {$nhg36="<INPUT TYPE='checkbox' NAME='_nhg36' checked>";}

if($row->nhg38 == 0)  {$nhg38="<INPUT TYPE='checkbox' NAME='_nhg38'>";}
	else {$nhg38="<INPUT TYPE='checkbox' NAME='_nhg38' checked>";}

if($row->nhg40 == 0)  {$nhg40="<INPUT TYPE='checkbox' NAME='_nhg40'>";}
	else {$nhg40="<INPUT TYPE='checkbox' NAME='_nhg40' checked>";}

if($row->nhg42 == 0)  {$nhg42="<INPUT TYPE='checkbox' NAME='_nhg42'>";}
	else {$nhg42="<INPUT TYPE='checkbox' NAME='_nhg42' checked>";}

if($row->chs == 0)  {$chs="<INPUT TYPE='checkbox' NAME='_chs'>";}
	else {$chs="<INPUT TYPE='checkbox' NAME='_chs' checked>";}

if($row->bs == 0)  {$bs="<INPUT TYPE='checkbox' NAME='_bs'>";}
	else {$bs="<INPUT TYPE='checkbox' NAME='_bs' checked>";}

if($row->gcs == 0)  {$gcs="<INPUT TYPE='checkbox' NAME='_gcs'>";}
	else {$gcs="<INPUT TYPE='checkbox' NAME='_gcs' checked>";}

if($row->D24 == 0)  {$d247="<INPUT TYPE='checkbox' NAME='_d247'>";}
	else {$d247="<INPUT TYPE='checkbox' NAME='_d247' checked>";}

if($row->approved == 0)  {$approved="<INPUT TYPE='checkbox' NAME='approved'>";}
	else {$approved="<INPUT TYPE='checkbox' NAME='approved' checked>";}

$HR=number_format($row->daylyrate / 8.5,2,'.',' ');

  $jobtitletxt = "<select class='Select' name='category'>\n";
 
  $q = "SELECT `catozn`, `catname` FROM `emplcat` ORDER BY `catozn`";
  $rc = $row->cat;
//	$db = new CMySQL;
     if (!$db->Open()) $db->Kill();
  if ($db->Query($q)) 
  {
    while ($r=$db->Row())
    {
		if ($rc == $r->catozn) 
			$jobtitletxt .= "<option value='$r->catozn' selected>$r->catname</option>\n";
		else 
		        $jobtitletxt .="<option value='$r->catozn'>$r->catname</option>\n";
    }
	} 
$jobtitletxt .=  "</select>\n";

               
if ($row->weekendrequired=="1") {
    $weekendrequiredtext .=  "<input type=\"checkbox\" name=\"weekendrequired\" id=\"checkbox\" checked=\"checked\"/ value=\"1\">";
    } 
    else {
       $weekendrequiredtext .=  "<input type=\"checkbox\" name=\"weekendrequired\" id=\"checkbox\"/ value=\"1\">";
    } 
    
    
if ($row->advances=="1") {
    $advances .=  "<input type=\"checkbox\" name=\"advances\" id=\"checkbox\" checked=\"checked\"/ value=\"1\">";
    } 
    else {
       $advances .=  "<input type=\"checkbox\" name=\"advances\" id=\"checkbox\"/ value=\"1\">";
    }
    
if ($row->cloffice == 0)  {$cloffice="<INPUT TYPE='checkbox' NAME='cloffice'>";}
	else {$cloffice="<INPUT TYPE='checkbox' NAME='cloffice' checked>";}
	
if ($row->moretrday == 0)  {$moretrialday="<INPUT TYPE='checkbox' NAME='moretrialday'>";}
	else {$moretrialday="<INPUT TYPE='checkbox' NAME='moretrialday' checked>";}
     
echo "
<table border='0' cellpadding='3' cellspacing='1' class='FormTABLE' valign=\"top\">
<tr>
<td class='DataTD' colspan='4'><table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
	<tr>
      <td class='FieldCaptionTD'>Regular/Casual </td>
	  <td class='DataTD'>$POSITION</td>
 	</tr>
	<tr>     <td class='FieldCaptionTD'>Job Title</td>
	  <td class='DataTD'><input class='Input' size='10' maxlength='10' name='jobtitle' value=\"$row->jobtitle\"></td>
	</tr>
	<tr>     <td class='FieldCaptionTD'>Job Title 2</td>
	<input name='oldjobtitle' type='hidden' value='$row->cat'>
	  <td class='DataTD'>$jobtitletxt<br><A HREF='emplcatlist.php?cln=$clockingNO'>Job Title list</A></td>
	</tr>
	<tr>     <td class='FieldCaptionTD'>Category on Clocking Table</td>
	  <td class='DataTD'><input class='Input' size='20' maxlength='10' name='cattoname' value=\"$row->cattoname\"></td>
	</tr>";

//if the person is in Trial Day category
if ($row->cat == 'ut') {
	echo "<tr><td class='FieldCaptionTD'>One more trialday</td>
	  	  <td class='DataTD'>$moretrialday</td>
		  </tr>";
}
	
echo "
	<tr>     <td class='FieldCaptionTD'>Weekend Required</td>
	  <td class='DataTD'>$weekendrequiredtext</td>
	</tr>
	<tr>
      <td class='FieldCaptionTD'>Date Hired</td>
	  <td class='DataTD'><input class='Input' size='10' maxlength='10' name='started' value=\"$row->d1\"> (dd/mm/yyyy)</td></td>
 	</tr>
 	<tr>
      <td class='FieldCaptionTD'>Attendance date</td>
	  <td class='DataTD'><input class='Input' size='10' maxlength='10' name='dateforattendence' value=\"$row->dateforattendence\"> (dd/mm/yyyy)</td></td>
 	</tr>
	<tr>     <td class='FieldCaptionTD'>Address Line 1</td>
	  <td class='DataTD'><input class='Input' size='20' maxlength='40' name='address1' value=\"$row->address1\"></td>
	</tr>
	<tr>
      <td class='FieldCaptionTD'>Address Line 2</td>
	  <td class='DataTD'><input class='Input' size='20' maxlength='40' name='address2' value=\"$row->address2\"></td>
	</tr>
	<tr>      <td class='FieldCaptionTD'>Address Line 3</td>
	  <td class='DataTD'><input class='Input' size='20' maxlength='40' name='address3' value=\"$row->address3\"></td>
	</tr>
	<tr>
      <td class='FieldCaptionTD'>Address Line 4 </td>
	  <td class='DataTD'><input class='Input' size='20' maxlength='40' name='address4' value=\"$row->address4\"></td>
	</tr>
	<tr>      <td class='FieldCaptionTD'>Post Code</td>
	  <td class='DataTD'><input class='Input' size='10' maxlength='10' name='postcode' value=\"$row->postcode\"></td>
	</tr>
	<tr>
      <td class='FieldCaptionTD'>Reason For Leaving </td>
	  <td class='DataTD'><input class='Input' size='30' maxlength='70' name='terminationtype' value=\"$row->terminationtype\"></td>
	</tr>
	<tr>      <td class='FieldCaptionTD'>Leaving Date</td>
	  <td class='DataTD'><input class='Input' size='10' maxlength='15' name='xx' value=''></td>
	</tr>
	<tr>
      <td class='FieldCaptionTD'>Home Phone </td>
	  <td class='DataTD'><input class='Input' size='13' maxlength='20' name='homephone' value=\"$row->homephone\"></td>
	</tr>
	<tr>      <td class='FieldCaptionTD'>Mobile Phone</td>
	  <td class='DataTD'><input class='Input' size='13' maxlength='20' name='mobilephone' value=\"$row->mobilephone\"></td>
	</tr>
		<tr>      <td class='FieldCaptionTD'>Email</td>
	  <td class='DataTD'><input class='Input' size='30' maxlength='50' name='email1' value=\"$row->email1\"></td>
	</tr>
	<tr>
      <td class='FieldCaptionTD'>Aproved </td>
	  <td class='DataTD'>$approved</td>
 	</tr>
	<tr>     <td class='FieldCaptionTD'>Aproved On</td>
	  <td class='DataTD'><input class='Input' size='12' maxlength='15' name='approvedon' value=\"$row->approvedon\"></td>
	</tr>
	<tr>
      <td class='FieldCaptionTD'>Reference </td>
	  <td class='DataTD'><INPUT TYPE='checkbox' NAME='ref'>
      <input type='radio' name='trusted' value='1' ";
    
       if ($row->trusted == 1) echo "checked"; echo ">Appraisal complete<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input type='radio' name='trusted' value='0' "; if ($row->trusted == 0) echo "checked"; echo ">Appraisal incomplete</td>
      
	</tr>
	<tr>      <td class='FieldCaptionTD'>GRADE</td>
	  <td class='DataTD'><input class='Input' size='10' maxlength='10' name='grade' value=\"$row->grade\"></td>
	</tr>
	<tr>      <td class='FieldCaptionTD'>Regular days total</td>
	  <td class='DataTD'><B>$row->regdays</B></td>
	</tr>
	<tr>      <td class='FieldCaptionTD'>speciality</td>
	  <td class='DataTD'><input class='Input' size='20' maxlength='50' name='speciality' value=\"$row->speciality\"></td>
	</tr>
        <tr>
          <td class='FieldCaptionTD'>Flat rent</td>
	  <td class='DataTD'><input class='Input' size='20' maxlength='50' name='rent' value=\"$row->rent\"></td>
	</tr>
        <tr>
          <td class='FieldCaptionTD'>Advances permission</td>
	  <td class='DataTD'>$advances</td>
	</tr>	
        <tr>
          <td class='FieldCaptionTD'>Clock in at the main office</td>
          <td class='DataTD'>$cloffice</td>
	</tr>
</TABLE></td>

<td class='DataTD'><table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
<tr>
      <td class='FieldCaptionTD' colspan='4'>PHOTO</td>
</tr><TR>

	  <td class='DataTD' colspan='4'><CENTER><img src='image1.php?cln=$clockingNO' border='0' width='200'></CENTER>
		<BR><CENTER> <A HREF='HR_nimg.php?cln=$clockingNO'>UPDATE</A></CENTER>
	  
	  </td>


</TR>


<tr>
      <td class='FieldCaptionTD' colspan='4'>ABSENTEEISM (AVG)</td>
</tr><TR>
	  <td class='FieldCaptionTD'>Month</td>
	  <td class='FieldCaptionTD'>Expected</td>
	  <td class='FieldCaptionTD'>Atended</td>
		</tr><TR>";
             echo "RRRF2";
$expected=$row->regdays * 4;

		$sql3 = "SELECT  COUNT(`date1`) AS razemD FROM `totals` WHERE `no` = '$clockingNO' AND `date1`>='$dataYS' AND `date1`<='$dataakt' GROUP BY `no`";
		if (!$db1->Open()) $db1->Kill();
		if (!$db1->Query($sql3)) $db1->Kill();
		while ($row3=$db1->Row())
		{	
			$xxxx = $row3->razemD / 4;
			 echo "  
			 <td class='FieldCaptionTD'>&nbsp;</td>
			<td class='DataTD'>$expected</td>
			<td class='DataTD'>$xxxx</td>
			</tr><TR>";
		}
		 $db->Free();
echo "
</TR>

<tr>
      <td class='FieldCaptionTD' colspan='4'>Display him on the clocking</td>
</tr><TR>

	  <td class='DataTD' colspan='4'>";

echo "	  <select class='Select' name='displ'>";
	 
	 if(!isset($row->displ)) {
		 echo "SYSTEM ERROR Display not set, optimize the DB"; 
		exit;}

	switch ($row->displ)
		{
		case 1:
		// [ brackets
		 $DisplIndex=1;
		 $DisplName="1 - [$row->knownas $row->surname $row->cattoname] ";
		 break;
		case 2:
		// ( brackets
		 $DisplIndex=2;
		 $DisplName="2 - ($row->knownas $row->surname  $row->cattoname) ";
		 break;
		case 3:
		//capitals
		 $DisplIndex=3;
		 $str = strtoupper("$row->knownas $row->surname  $row->cattoname");
		 $DisplName="3 - $str ";
		 break;
		
		default:
		 $DisplIndex=0;
		 $DisplName="0 - $row->knownas $row->surname  $row->cattoname";
		 break;
		}


		$str = strtoupper("$row->knownas $row->surname");
		
		echo "
		<option selected value='$DisplIndex'>$DisplName</option>";
		echo "
		<option value='0'>0 - $row->knownas $row->surname</option>
		<option value='1'>1 - [ $row->knownas $row->surname ]</option>
		<option value='2'>2 - ( $row->knownas $row->surname )</option>
		<option value='3'>3 - UPPERCASE: $str </option>
		</select>

	  </td>


</TR>

</TABLE>
	
</td>
";

 //$q = "SELECT id,knowledgeid,type,value FROM nombersknowledge where `no` = '$cln'";
  $q = "SELECT nombersknowledge.id,knowledgeid,type,nombersknowledge.value,`nombersknowledgetext`.`userknowledgeid`,`nombersknowledgetext`.`value` As textvalue  FROM nombersknowledge LEFT JOIN `nombersknowledgetext` ON `nombersknowledgetext`.`userknowledgeid`=nombersknowledge.id where `no` = '$cln'";

  $db->Query($q);
  $rows=$db->Rows();
   $j=1;
  while ($rq=$db->Row())
    {
         if ($rq->knowledgeid < 19) {
    if ($rq->type == 'C' && $rq->value == '1' ) $knowledge_cap[$rq->knowledgeid]="checked"; 
    if ($rq->type == 'C' && $rq->value != '1' ) $knowledge_cap[$rq->knowledgeid]="";
    if ($rq->type == 'S' && $rq->value == '1' ) $knowledge_small[$rq->knowledgeid]="checked"; 
    if ($rq->type == 'S' && $rq->value != '1' ) $knowledge_small[$rq->knowledgeid]="";  
           }
     else {
     if  ($rq->value == '1') {$knowledge_cap[$rq->knowledgeid]="checked";$knowledge_small[$rq->knowledgeid]=$rq->textvalue; }   
     else  {$knowledge_cap[$rq->knowledgeid]="";$knowledge_small[$rq->knowledgeid]=""; }   
         }  
    $j++;
    }
    
   
//print_r ($knowledge_cap);

 $q = "SELECT id,keysid,value FROM nomberskeys where `no` = '$cln' Order by keysid";
  $db->Query($q);
  $rows=$db->Rows();
   $j=1;
  while ($rq=$db->Row())
    {  
    if ($rq->value == '1') $keys[$rq->keysid]="checked";  else  $keys[$rq->keysid]="";
    $j++;
    }


echo "

<td class='DataTD' colspan='4'>	 
<table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
	<tr>
      <td class='FieldCaptionTD'>Knowledge</td>
	  <td class='FieldCaptionTD'>Cap.</td>
      <td class='FieldCaptionTD'>Small</td>
	  <td class='FieldCaptionTD'></td>
      <td class='FieldCaptionTD'>Cap.</td>
   <td class='FieldCaptionTD'>Small</td><td class='FieldCaptionTD'></td>
      <td class='FieldCaptionTD'>Cap.</td>
       <td class='FieldCaptionTD'>Small</td><td class='FieldCaptionTD'></td>
        <td class='FieldCaptionTD'>Cap.</td>
   <td class='FieldCaptionTD'>Small</td>
      </tr>
	<tr>
      <td class='FieldCaptionTD'>Books and Comics</td>
	  <td class='DataTD'><INPUT TYPE='checkbox' NAME='knowledge_1' value='1' $knowledge_cap[1]></td><td class='DataTD'><INPUT TYPE='checkbox' NAME='knowledge_1_small' value='1' $knowledge_small[1]></td>
      <td class='FieldCaptionTD'>Film</td>
	  <td class='DataTD'><INPUT TYPE='checkbox' NAME='knowledge_2' value='1'  $knowledge_cap[2]></td><td class='DataTD'><INPUT TYPE='checkbox' NAME='knowledge_2_small' value='1' $knowledge_small[2]></td>
      <td class='FieldCaptionTD'>Games</td>
   <td class='DataTD'><INPUT TYPE='checkbox' NAME='knowledge_3' value='1'  $knowledge_cap[3]></td><td class='DataTD'><INPUT TYPE='checkbox' NAME='knowledge_3_small' value='1' $knowledge_small[3]></td>
      <td class='FieldCaptionTD'>Homeware</td>
       <td class='DataTD'><INPUT TYPE='checkbox' NAME='knowledge_4' value='1'  $knowledge_cap[4]></td><td class='DataTD'><INPUT TYPE='checkbox' NAME='knowledge_4_small' value='1' $knowledge_small[4]></td>
      </tr>
    <tr>
      <td class='FieldCaptionTD'>Women's wear</td>
  <td class='DataTD'><INPUT TYPE='checkbox' NAME='knowledge_5' value='1'  $knowledge_cap[5]></td><td class='DataTD'><INPUT TYPE='checkbox' NAME='knowledge_5_small' value='1' $knowledge_small[5]></td>
	    <td class='FieldCaptionTD'>Men's wear</td>
  <td class='DataTD'><INPUT TYPE='checkbox' NAME='knowledge_6' value='1'  $knowledge_cap[6]></td><td class='DataTD'><INPUT TYPE='checkbox' NAME='knowledge_6_small' value='1' $knowledge_small[6]></td>
      <td class='FieldCaptionTD'>Classical</td>
	   <td class='DataTD'><INPUT TYPE='checkbox' NAME='knowledge_7' value='1'  $knowledge_cap[7]></td><td class='DataTD'><INPUT TYPE='checkbox' NAME='knowledge_7_small' value='1' $knowledge_small[7]></td>
      <td class='FieldCaptionTD'>Rock and Indie</td>
	    <td class='DataTD'><INPUT TYPE='checkbox' NAME='knowledge_8' value='1'  $knowledge_cap[8]></td><td class='DataTD'><INPUT TYPE='checkbox' NAME='knowledge_8_small' value='1' $knowledge_small[8]></td>
    </tr>
    <tr>
      <td class='FieldCaptionTD'>Deleted Records and Rarities</td>
	   <td class='DataTD'><INPUT TYPE='checkbox' NAME='knowledge_9' value='1'  $knowledge_cap[9]></td><td class='DataTD'><INPUT TYPE='checkbox' NAME='knowledge_9_small' value='1' $knowledge_small[9]></td>
	    <td class='FieldCaptionTD'>Soul</td>
	    <td class='DataTD'><INPUT TYPE='checkbox' NAME='knowledge_10' value='1'  $knowledge_cap[10]></td><td class='DataTD'><INPUT TYPE='checkbox' NAME='knowledge_10_small' value='1' $knowledge_small[10]></td>
      <td class='FieldCaptionTD'>Dance</td>
     <td class='DataTD'><INPUT TYPE='checkbox' NAME='knowledge_11' value='1'  $knowledge_cap[11]></td><td class='DataTD'><INPUT TYPE='checkbox' NAME='knowledge_11_small' value='1' $knowledge_small[11]></td>
   </tr>
    <tr>   
	    <td class='FieldCaptionTD'>General Assistant</td>
	    <td class='DataTD'><INPUT TYPE='checkbox' NAME='knowledge_12' value='1'  $knowledge_cap[12]></td><td class='DataTD'><INPUT TYPE='checkbox' NAME='knowledge_12_small' value='1' $knowledge_small[12]></td>
      <td class='FieldCaptionTD'>Special Assistant</td>
	   <td class='DataTD'><INPUT TYPE='checkbox' NAME='knowledge_13' value='1'  $knowledge_cap[13]></td><td class='DataTD'><INPUT TYPE='checkbox' NAME='knowledge_13_small' value='1' $knowledge_small[13]></td>
      <td class='FieldCaptionTD'>General Management Assistant</td>
	   <td class='DataTD'><INPUT TYPE='checkbox' NAME='knowledge_14' value='1'  $knowledge_cap[14]></td><td class='DataTD'><INPUT TYPE='checkbox' NAME='knowledge_14_small' value='1' $knowledge_small[14]></td>
      <td class='FieldCaptionTD'>Maintenance</td>
	   <td class='DataTD'><INPUT TYPE='checkbox' NAME='knowledge_15' value='1'  $knowledge_cap[15]></td><td class='DataTD'><INPUT TYPE='checkbox' NAME='knowledge_15_small' value='1' $knowledge_small[15]></td>
   </tr>
    <tr> 
    <td class='FieldCaptionTD'>Accounts Assistant</td>
	    <td class='DataTD'><INPUT TYPE='checkbox' NAME='knowledge_16' value='1'  $knowledge_cap[16]></td><td class='DataTD'><INPUT TYPE='checkbox' NAME='knowledge_16_small' value='1' $knowledge_small[16]></td>       
	   <td class='FieldCaptionTD'>I.T.</td>
  <td class='DataTD'><INPUT TYPE='checkbox' NAME='knowledge_17' value='1'  $knowledge_cap[17]></td><td class='DataTD'><INPUT TYPE='checkbox' NAME='knowledge_17_small' value='1' $knowledge_small[17]></td>
      <td class='FieldCaptionTD'>Buyer Training</td>
	    <td class='DataTD'><INPUT TYPE='checkbox' NAME='knowledge_18' value='1'  $knowledge_cap[18]></td><td class='DataTD'><INPUT TYPE='checkbox' NAME='knowledge_18_small' value='1' $knowledge_small[18]></td>
     </tr>
    <tr>   
	     <td class='FieldCaptionTD'>Time</td>
	   <td class='DataTD'><INPUT TYPE='checkbox' NAME='knowledge_19' value='1'  $knowledge_cap[19]></td><td class='DataTD'></td>
	  <td class='DataTD'  colspan='9'><input class='Input' size='60' maxlength='60' name='knowledge_19_small' value=\"$knowledge_small[19]\"></td>
	  </tr>
    <tr>
      <td class='FieldCaptionTD'>Other Spec.</td>
<td class='DataTD'><INPUT TYPE='checkbox' NAME='knowledge_20'  value='1'  $knowledge_cap[20]></td><td class='DataTD'></td>
	  <td class='DataTD'  colspan='9'><input class='Input' size='60' maxlength='60' name='knowledge_20_small' value=\"$knowledge_small[20]\"></td>
</tr>	

</TABLE>
<br>
<table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>	<tr>
      <td class='FieldCaptionTD' colspan='4'>Key Access</td>
      <td class='FieldCaptionTD' colspan='4'></td>
	</tr>	
	<tr>
      <td class='FieldCaptionTD'>All Shops</td>
	  <td class='DataTD'><INPUT TYPE='checkbox' NAME='key_1'  value='1' $keys[1]></td>
      <td class='FieldCaptionTD'>All shops on Pembridge Road</td>
	  <td class='DataTD'><INPUT TYPE='checkbox' NAME='key_2'  value='1' $keys[2]></td>
      <td class='FieldCaptionTD'>All shops on Notting Hill Gate</td>
	  <td class='DataTD'><INPUT TYPE='checkbox' NAME='key_3'  value='1' $keys[3]></td>
      <td class='FieldCaptionTD'>14 Pembridge Road</td>
	  <td class='DataTD'><INPUT TYPE='checkbox' NAME='key_4'  value='1' $keys[4]></td>
	</tr>
    <tr>
      <td class='FieldCaptionTD'>20 Pembridge Road</td>
	  <td class='DataTD'><INPUT TYPE='checkbox' NAME='key_5'  value='1' $keys[5]></td>
      <td class='FieldCaptionTD'>28 Pembridge Road</td>
	  <td class='DataTD'><INPUT TYPE='checkbox' NAME='key_6'  value='1' $keys[6]></td>
      <td class='FieldCaptionTD'>30 Pembridge Road</td>
	  <td class='DataTD'><INPUT TYPE='checkbox' NAME='key_7'  value='1' $keys[7]></td>
      <td class='FieldCaptionTD'>32 Pembridge Road</td>
	  <td class='DataTD'><INPUT TYPE='checkbox' NAME='key_8'  value='1' $keys[8]></td>
	</tr>	
    <tr>
      <td class='FieldCaptionTD'>34 Pembridge Road</td>
	  <td class='DataTD'><INPUT TYPE='checkbox' NAME='key_9'  value='1' $keys[9]></td>
      <td class='FieldCaptionTD'>36 Notting Hill Gate</td>
	  <td class='DataTD'><INPUT TYPE='checkbox' NAME='key_10'  value='1' $keys[10]></td>
      <td class='FieldCaptionTD'>38 Notting Hill Gate</td>
	  <td class='DataTD'><INPUT TYPE='checkbox' NAME='key_11'  value='1' $keys[11]></td>
      <td class='FieldCaptionTD'>40 Notting Hill Gate</td>
	  <td class='DataTD'><INPUT TYPE='checkbox' NAME='key_12'  value='1' $keys[12]></td>
	</tr>	
<tr>
      <td class='FieldCaptionTD'>42 Notting Hill Gate</td>
	  <td class='DataTD'><INPUT TYPE='checkbox' NAME='key_13'  value='1' $keys[13]></td>
      <td class='FieldCaptionTD'>56 Notting Hill Gate</td>
	  <td class='DataTD'><INPUT TYPE='checkbox' NAME='key_14'  value='1' $keys[14]></td>
      <td class='FieldCaptionTD'>75 Berwick Street</td>
	  <td class='DataTD'><INPUT TYPE='checkbox' NAME='key_15'  value='1' $keys[15]></td>
      <td class='FieldCaptionTD'>95 Berwick Street</td>
	  <td class='DataTD'><INPUT TYPE='checkbox' NAME='key_16'  value='1' $keys[16]></td>
</tr>
	
  <tr>
      <td class='FieldCaptionTD'>208 Camden High Street</td>
	  <td class='DataTD'><INPUT TYPE='checkbox' NAME='key_17'  value='1' $keys[17]></td>
      <td class='FieldCaptionTD'>23 Greenwich Church Street</td>
	  <td class='DataTD'><INPUT TYPE='checkbox' NAME='key_18'  value='1' $keys[18]></td>
      <td class='FieldCaptionTD'></td>
	  <td class='DataTD'></td>
      <td class='FieldCaptionTD'></td>
	  <td class='DataTD'></td>
</tr>
</TABLE> 
<br>
<table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>	<tr>
      <td class='FieldCaptionTD' colspan='4'>DOOR ACCESS  </td>
      <td class='FieldCaptionTD' colspan='4'> 24 Hour $d247</td>
	</tr>	
	<tr>
      <td class='FieldCaptionTD'>PR14 </td>
	  <td class='DataTD'>$pr14</td>
      <td class='FieldCaptionTD'>PR16</td>
	  <td class='DataTD'>$pr16</td>
      <td class='FieldCaptionTD'>PR20 </td>
	  <td class='DataTD'>$pr20</td>
      <td class='FieldCaptionTD'>PR28 </td>
	  <td class='DataTD'>$pr28</td>
	</tr>
    <tr>
      <td class='FieldCaptionTD'>PR30 </td>
	  <td class='DataTD'>$pr30</td>
      <td class='FieldCaptionTD'>PR32</td>
	  <td class='DataTD'>$pr32</td>
      <td class='FieldCaptionTD'>PR34 </td>
	  <td class='DataTD'>$pr34</td>
      <td class='FieldCaptionTD'>NHG56</td>
	  <td class='DataTD'>$nhg56</td>
	</tr>	
    <tr>
      <td class='FieldCaptionTD'>NHG34 </td>
	  <td class='DataTD'>$nhg34</td>
      <td class='FieldCaptionTD'>NHG36</td>
	  <td class='DataTD'>$nhg36</td>
      <td class='FieldCaptionTD'>NHG38</td>
	  <td class='DataTD'>$nhg38</td>
      <td class='FieldCaptionTD'>NHG40</td>
	  <td class='DataTD'>$nhg40</td>
	</tr>	
<tr>
      <td class='FieldCaptionTD'>NHG42 </td>
	  <td class='DataTD'>$nhg42</td>
      <td class='FieldCaptionTD'>CHS</td>
	  <td class='DataTD'>$chs</td>
      <td class='FieldCaptionTD'>BS </td>
	  <td class='DataTD'>$bs</td>
      <td class='FieldCaptionTD'>GCS</td>
	  <td class='DataTD'>$gcs</td>
</tr>

</TABLE>
<BR><table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>	<tr>
<tr>
      <td class='FieldCaptionTD' colspan='4'>PAY DATA</td>
	</tr>
</tr><TR>

	  <td class='FieldCaptionTD'>Hourly rate</td>
	  <td class='DataTD'>&pound; <B>$HR</B></td>
</tr><TR>
	  <td class='FieldCaptionTD'>Daily rate</td>
	  <td class='DataTD' colspan='3'>&pound; $row->daylyrate</td>
</tr><TR>
	  <td class='FieldCaptionTD'>Managament bonus</td>
	  <td class='DataTD' colspan='3'>&pound; $row->managament_bonus</td>
</tr><TR>
	  <td class='FieldCaptionTD'>Punctuality bonus</td>
	  <td class='DataTD' colspan='3'>&pound; $row->punctuality_bonus</td>
</tr><TR>
	  <td class='FieldCaptionTD'>Security bonus</td>
	  <td class='DataTD' colspan='3'>&pound; $row->security_bonus</td>
		 </tr><TR>
	  <td class='FieldCaptionTD'>Travel card </td>
	  <td class='DataTD' colspan='3'>&pound; $row->travel_card_bonus</td>

</TR>
</TABLE>
<BR><table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>	<tr>
<tr>
	

      <td class='FieldCaptionTD' colspan='7'>REGULAR DAYS</td>
	</tr>

	<TR>

	  <td class='FieldCaptionTD'>Mon</td>
	  <td class='FieldCaptionTD'>Tue</td>
	  <td class='FieldCaptionTD'>Wed</td>
	  <td class='FieldCaptionTD'>Thu</td>
	  <td class='FieldCaptionTD'>Fri</td>
	  <td class='FieldCaptionTD'>Sat</td>
	  <td class='FieldCaptionTD'>Sun</td>


</TR>";

$expected=$row->regdays * 4;

		$sql3 = "SELECT * FROM `regdays` WHERE no = '$clockingNO' AND `regdays`.`active` = 'y' LIMIT 1";
		if (!$db1->Open()) $db1->Kill();
		if (!$db1->Query($sql3)) $db1->Kill();
		while ($row4=$db1->Row())
		{		
		if( $row4->mon == 1 ) { $mon="<IMG SRC='./images/tickgreen.jpg'  BORDER='0' ALT=''>"; } else {  $mon="&nbsp;"; }
		if( $row4->tue == 1 ) { $tue="<IMG SRC='./images/tickgreen.jpg'  BORDER='0' ALT=''>"; } else {  $tue="&nbsp;"; }
		if( $row4->wed == 1 ) { $wed="<IMG SRC='./images/tickgreen.jpg'  BORDER='0' ALT=''>"; } else {  $wed="&nbsp;"; }
		if( $row4->thu == 1 ) { $thu="<IMG SRC='./images/tickgreen.jpg'  BORDER='0' ALT=''>"; } else {  $thu="&nbsp;"; }
		if( $row4->fri == 1 ) { $fri="<IMG SRC='./images/tickgreen.jpg'  BORDER='0' ALT=''>"; } else {  $fri="&nbsp;"; }
		if( $row4->sat == 1 ) { $sat="<IMG SRC='./images/tickgreen.jpg'  BORDER='0' ALT=''>"; } else {  $sat="&nbsp;"; }
		if( $row4->sun == 1 ) { $sun="<IMG SRC='./images/tickgreen.jpg'  BORDER='0' ALT=''>"; } else {  $sun="&nbsp;"; }
		}

// Decision...
$selected = array();

	for ($i=0;$i<6;$i++)
		{		
		if ($row->decision == $i) {$selected[$i]=" selected";} 
		else {$selected[$i] = "";}
		}
echo "
<TR>
	<td class='DataTD'>$mon</td>
	<td class='DataTD'>$tue</td>
	<td class='DataTD'>$wed</td>
	<td class='DataTD'>$thu</td>
	<td class='DataTD'>$fri</td>
	<td class='DataTD'>$sat</td>
	<td class='DataTD'>$sun</td>
</TR>
<TR>
	<td class='DataTD' colspan='7'><CENTER><A HREF='hrregday.php?cln=$clockingNO'>UPDATE</A></CENTER></td>

</form>
</TR>
	
	</TABLE>
	</TD>	
<TR>
	

</TR>
</td>
</tr>
<tr>
      <td class='FieldCaptionTD'>Decision</td>
	  <td class='DataTD' colspan='6'>
	  <input class='Input' type='hidden' name='decisionsave' value='$row->decision'>
    <select name=\"decision\">
   <option value=\"0\" ".$selected[0].">No</option>
   <option value=\"1\" ".$selected[1].">Yes</option>
   <option value=\"2\" ".$selected[2].">Don't know</option>
   <option value=\"3\" ".$selected[3].">Resigned</option>
   <option value=\"4\" ".$selected[4].">Dismissed</option>
   <option value=\"5\" ".$selected[5].">Casual</option>
   </select>
    </td>
</TR>
<tr>
      <td class='FieldCaptionTD'>Date of decision</td>
	  <td class='DataTD' colspan='6'>
    $row->decisiondate
    </td>
</TR>
<tr>
      <td class='FieldCaptionTD'>YES</td>
	  <td class='DataTD' colspan='6'><input class='Input' size='90' maxlength='90' name='comment1' value=\"$row->comment1\"></td>
</TR>
<tr>
      <td class='FieldCaptionTD'>NO</td>
	  <td class='DataTD' colspan='10'><input class='Input' size='90' maxlength='90' name='comment2' value=\"$row->comment2\"></td>
</TR>
<tr>
      <td class='FieldCaptionTD'>D.K.</td>
	  <td class='DataTD' colspan='6'><input class='Input' size='90' maxlength='90' name='comment3' value=\"$row->comment3\"></td>
</TR>

 </TD>	</td>
<input name='lp' type='hidden' value='$row->pno'>";
  }


// przyciski i stopka ------------------------------------------------------------------------------
echo "  <table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
            <tr> <td align='right' colspan='2'>
		    <input name='state' type='hidden' value='1'>
		    <input name='cln' type='hidden' value='$clockingNO'>
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
//	checkZm("daylyrate");
//	  checkZm("started");
    checkZm("category");
//	checkZm("regdays");

list($day, $month, $year) = explode("/",$approvedon);
$approvedon = "$year-$month-$day";

if( $approved !== 0 ) $approved = 1;
if( $cloffice !== 0 ) $cloffice = 1;
if( $moretrialday !== 0 ) $moretrialday = 1;
if( $_pr14 !== 0 ) $_pr14 = 1;
if( $_pr16 !== 0 ) $_pr16 = 1;
if( $_pr20 !== 0 ) $_pr20 = 1;
if( $_pr28 !== 0 ) $_pr28 = 1;
if( $_pr30 !== 0 ) $_pr30 = 1;
if( $_pr32 !== 0 ) $_pr32 = 1;
if( $_pr34 !== 0 ) $_pr34 = 1;
if( $_nhg56 !== 0 ) $_nhg56 = 1;
if( $_nhg34 !== 0 ) $_nhg34 = 1;
if( $_nhg36 !== 0 ) $_nhg36 = 1;
if( $_nhg38 !== 0 ) $_nhg38 = 1;
if( $_nhg40 !== 0 ) $_nhg40 = 1;
if( $_nhg42 !== 0 ) $_nhg42 = 1;
if( $_chs !== 0 ) $_chs = 1;
if( $_bs !== 0 ) $_bs = 1;
if( $_gcs !== 0 ) $_gcs = 1;
if( $_d247 !== 0 ) $_d247 = 1;

$started=$_POST['started'];

$dateforattendence=$_POST['dateforattendence'];
 $attsql  = "";
if  ($dateforattendence != "") $attsql = ",`dateforattendence`=STR_TO_DATE( '$dateforattendence', '%d/%m/%Y')";
else  $attsql = ",`dateforattendence`=NULL";
if (!$db->Open()) $db->Kill();

$decisionsql = "";
if ($decision != $decisionsave) $decisionsql = ",`decisiondate` = Now()";

  $jobtitle = $db->Fix($jobtitle);
  $terminationtypee = $db->Fix($terminationtype);
  $cattoname = $db->Fix($cattoname);
  $rent = $db->Fix($rent);
  $address1 = $db->Fix($address1);
  $address2 = $db->Fix($address2);
  $address3 = $db->Fix($address3);
  $address4 = $db->Fix($address4);
  $postcode = $db->Fix($postcode);
  $comment1 = $db->Fix($comment1);
  $comment2 = $db->Fix($comment2);
  $_surname = $db->Fix($comment3);
  $jobtitle = $db->Fix($jobtitle);
  $oldjobtitle = $db->Fix($oldjobtitle);
  $terminationtypee = $db->Fix($terminationtype);
  $homephone = $db->Fix($homephone);
  $mobilephone = $db->Fix($mobilephone);
  $email = $db->Fix($email1);
  $approvedon = $db->Fix($approvedon);
  $grade = $db->Fix($grade);
  $speciality = $db->Fix($speciality);
  $displ = $db->Fix($displ);
  $weekendrequired = $db->Fix($weekendrequired);

  $advances = $db->Fix($advances);

  if ($weekendrequired != "1")  $weekendrequired= "0";
  if ($advances != "1")  $advances= "0"; 

  $trust=$_POST['trusted'];
      

$query = ("UPDATE `staffdetails` SET `jobtitle` = '$jobtitle',`terminationtype` = '$terminationtype' ,`address1` = '$address1',`address2` = '$address2',`address3` = '$address3',`address4` = '$address4',`postcode` = '$postcode',`decision`=$decision, `comment1` ='$comment1' ,`comment2` = '$comment2' , `comment3` = '$comment3' , `homephone`='$homephone' , `mobilephone` = '$mobilephone' ,`email` = '$email', `approvedon` = '$approvedon' , `grade` = '$grade' , `speciality` = '$speciality', `approved` = '$approved', `pr14` = '$_pr14' , `pr16` = '$_pr16', `pr20` = '$_pr20', `pr28` = '$_pr28', `pr30` = '$_pr30', `pr32` = '$_pr32', `pr34` = '$_pr34', `nhg56` = '$_nhg56', `nhg34` = '$_nhg34', `nhg36` = '$_nhg36', `nhg38` = '$_nhg38', `nhg40` = '$_nhg40', `nhg42` = '$_nhg42', `chs` = '$_chs', `bs` = '$_bs', `gcs` = '$_gcs', `247` = '$_d247' $decisionsql WHERE `NO` =$cln LIMIT 1 ;") ;

$query2 = ("UPDATE `nombers` SET `trusted` = '$trust', `displ` = '$displ',`cat`='$category',`cattoname`='$cattoname',`advances`='$advances',`cloffice`='$cloffice',`moretrday`='$moretrialday',`weekendrequired`='$weekendrequired',`rent`='$rent',`started`=STR_TO_DATE( '$started', '%d/%m/%Y') $attsql WHERE `pno` = '$cln' LIMIT 1 ;");
 // echo $query2;
   if (!$db->Query($query)) $db->Kill();
	if (!$db->Query($query2)) $db->Kill();
	
if (  $oldjobtitle != $category) {

$DeleteInDay = "UPDATE `emplcathistory` SET `active` = 'n' WHERE `no`= '$cln'";
if (!$db->Query($DeleteInDay)) $db->Kill();

$ins = "INSERT INTO `emplcathistory` ( `no` ,`catold`, `cat` , `datechange`, `active` ) VALUES ('$cln','$oldjobtitle', '$category',  STR_TO_DATE( '$FirstOfTheMonth', '%d/%m/%Y'),'y' )";
if (!$db->Query($ins)) $db->Kill();

}	


// Knowledge list
// read - update

for ($i=1;$i<=18;$i++) {
  
 // Capital
 
  $q = "SELECT id,knowledgeid,type,value FROM nombersknowledge where `no` = '$cln' and knowledgeid ='$i' AND type = 'C'";
  $db->Query($q);
  $rows=$db->Rows();
  
  if ($rows == 0 ) {   // insert
  
  $ins = "INSERT INTO `nombersknowledge` ( `no` ,`knowledgeid`, `type` , `value` ) VALUES ('$cln','$i', 'C','$knowledge_cap[$i]' )";
  if (!$db->Query($ins)) $db->Kill();
  }
  else {  // update
  
  $upd = "UPDATE `nombersknowledge` SET `value` = '$knowledge_cap[$i]' WHERE `no` = '$cln' and knowledgeid ='$i' AND type = 'C'";
  if (!$db->Query($upd)) $db->Kill();
  
  }
  
// Small
  
  $q = "SELECT id,knowledgeid,type,value FROM nombersknowledge where `no` = '$cln' and knowledgeid ='$i' AND type = 'S';";
  $db->Query($q);
  $rows=$db->Rows();
  
  if ($rows == 0 ) {   // insert
  
  $ins = "INSERT INTO `nombersknowledge` ( `no` ,`knowledgeid`, `type` , `value` ) VALUES ('$cln','$i', 'S','$knowledge_small[$i]' )";
  if (!$db->Query($ins)) $db->Kill();
  }
  else {  // update
  
  $upd = "UPDATE `nombersknowledge` SET `value` = '$knowledge_small[$i]' WHERE `no` = '$cln' and knowledgeid ='$i' AND type = 'S'";
  if (!$db->Query($upd)) $db->Kill();
  
  }
   
 
}


for ($i=19;$i<=20;$i++) {
 
  if ($i == 19) {               
  $tp = "OT";
  }
  else {
   $tp = "OS";
  }
 // Capital
 
  $q = "SELECT id,knowledgeid,type,value FROM nombersknowledge where `no` = '$cln' and knowledgeid ='$i' AND type = '$tp'";
  $db->Query($q);
  $rows=$db->Rows();
  
  $r=$db->Row();
  $userknowledgeid=$r->id;
  
  
  if ($rows == 0) {   // insert
  
  $ins = "INSERT INTO `nombersknowledge` ( `no` ,`knowledgeid`, `type` , `value` ) VALUES ('$cln','$i', '$tp','$knowledge_cap[$i]' )";
  if (!$db->Query($ins)) $db->Kill();
  
  $ins = "INSERT INTO `nombersknowledgetext` ( `userknowledgeid`,`value` ) VALUES (LAST_INSERT_ID(),'$knowledge_small[$i]')";
  if (!$db->Query($ins)) $db->Kill();
 
  }
   else {  // update
  
  $upd = "UPDATE `nombersknowledge` SET `value` = '$knowledge_cap[$i]' WHERE `no` = '$cln' and knowledgeid ='$i' AND type = '$tp'";
  if (!$db->Query($upd)) $db->Kill();
   $upd = "UPDATE `nombersknowledgetext` SET `value` = '$knowledge_small[$i]' WHERE userknowledgeid ='$userknowledgeid'";
  if (!$db->Query($upd)) $db->Kill();
  
  }
  
  
  }

// Update Key



for ($i=1;$i<=18;$i++) {
  
 // Capital
 
  $q = "SELECT id,keysid FROM nomberskeys where `no` = '$cln' and keysid ='$i'";
  $db->Query($q);
  $rows=$db->Rows();
  
  $r=$db->Row();
  if(!isset($r->id))
          $keysid = 0;
  else $keysid = $r->id;
  
  if ($rows == 0) {   // insert
  
  $ins = "INSERT INTO `nomberskeys` ( `no` ,`keysid`,`value` ) VALUES ('$cln','$i', '$keys[$i]' )";
  if (!$db->Query($ins)) $db->Kill();
  }
  else {  // update
  
  $upd = "UPDATE `nomberskeys` SET `keysid` = '$keysid', `value`='$keys[$i]' WHERE `id` = '$keysid'";
  if (!$db->Query($upd)) $db->Kill();
  
  }
   
}



   echo "<script language='javascript'>window.location=\"hr_data.php?cln=$cln\"</script>";
//   }

} //fi state=1
else
{
 echo "<BR><BR><BR>Ostrze¿enie!!!!!<BR><BR><BR>",
	 "Ktos z komputera $REMOTE_ADDR probuje sie wlamac<BR>";
} //else state
?>

