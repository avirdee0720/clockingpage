<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$db1 = new CMySQL;
$dataYS=date("Y")."-01-01";
$dataakt=date("Y-m-d");

$tytul='Staff details';

if(!isset($state))
{
echo "	<TD ALIGN=JUSTIFY VALIGN=TOP border=0>
	<table width='100%' border=0><tr><td>
<center>
<form action='$PHP_SELF' method='post' name='ed_czl'>
  <font class='FormHeaderFont'>$tytul</font>
  <table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>";

//uprstr($PU,95);

 if (!$db->Open()) $db->Kill();
 if(isset($cln)){  
  $sql = ("SELECT `nombers`.`pno`, `nombers`.`surname`, `nombers`.`firstname`, `nombers`.`knownas`, `nombers`.`cat`, DATE_FORMAT(`nombers`.`started`, \"%d/%m/%Y\") as d1, `nombers`.`daylyrate`, `nombers`.`regdays`, `nombers`.`displ`, `staffdetails`.`homephone` , `staffdetails`.`mobilephone` , `staffdetails`.`jobtitle` , `staffdetails`.`datehired` , `staffdetails`.`firstregularday` , `staffdetails`.`datephototaken` , `staffdetails`.`photograph` , `staffdetails`.`terminationtype` , `staffdetails`.`noticegiven` , `staffdetails`.`dooraccess` , `staffdetails`.`managament_bonus` , `staffdetails`.`punctuality_bonus` , `staffdetails`.`security_bonus` , `staffdetails`.`travel_card_bonus` , `staffdetails`.`address1` , `staffdetails`.`address2` , `staffdetails`.`address3` , `staffdetails`.`address4` , `staffdetails`.`postcode` , `staffdetails`.`pr14` , `staffdetails`.`pr16` , `staffdetails`.`pr20` , `staffdetails`.`pr28` , `staffdetails`.`pr30` , `staffdetails`.`pr32` , `staffdetails`.`pr34` , `staffdetails`.`nhg34` , `staffdetails`.`nhg36` , `staffdetails`.`nhg38` , `staffdetails`.`nhg40` , `staffdetails`.`nhg42` , `staffdetails`.`nhg56` , `staffdetails`.`chs` , `staffdetails`.`bs` , `staffdetails`.`gcs` , `staffdetails`.`noappraisal` , `staffdetails`.`247` AS D24,`staffdetails`.`decision` , `staffdetails`.`comment1` , `staffdetails`.`comment2` , `staffdetails`.`comment3` , `staffdetails`.`comment4` , `staffdetails`.`comment5` , `staffdetails`.`comment6` , DATE_FORMAT(`staffdetails`.`approvedon` , \"%d/%m/%Y\") as approvedon, `staffdetails`.`grade` , `staffdetails`.`approved` , `staffdetails`.`OLD` , `staffdetails`.`speciality` , `staffdetails`.`aproved`,`staffdetails`.`decisiondate` FROM `nombers` CROSS JOIN  `staffdetails` ON `nombers`.`pno` = `staffdetails`.`no` WHERE `nombers`.`pno` = '$cln' LIMIT 1");
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
		<a CLASS='DataLink' href='advance1.php?cln=$clockingNO'><IMG SRC='images/expand_row.gif' WIDTH='16' HEIGHT='16' BORDER='0' TITLE='ADVANCES'>ADVANCES</a>
		<a CLASS='DataLink' href='pay01.php?cln=$clockingNO'><IMG SRC='images/cons_report.gif' WIDTH='16' HEIGHT='16' BORDER='0' TITLE='PAYs'>PAY</a>
		<a CLASS='DataLink' href='t_of_staff.php?cln=$clockingNO'><IMG SRC='images/last1hr.gif' WIDTH='16' HEIGHT='16' BORDER='0' TITLE='Clocking'>TIME OF STAFF</a>
		<a CLASS='DataLink' href='hollid1.php?cln=$clockingNO'><IMG SRC='images/hollidays.gif' WIDTH='16' HEIGHT='16' BORDER='0' TITLE='Holidays'>HOLIADYS</a>
		<a CLASS='DataLink' href='ed_os_s.php?lp=$clockingNO'><IMG SRC='images/home.gif' WIDTH='16' HEIGHT='16' BORDER='0' TITLE='EDIT SHOP  FOR THE STAFF'>EDIT SHOP</a>
		<a CLASS='DataLink' href='ed_os.php?lp=$clockingNO'><IMG SRC='images/edit.png' BORDER='0' TITLE='EDIT'>EDIT NAME ETC.</a>
		<a CLASS='DataLink' href='del_os.php?cln=$clockingNO'><IMG SRC='images/drop.png' BORDER='0' TITLE='DEL. STAFF'>DEL. STAFF</a>
		</TD>
		      </tr> 
   </table><BR>";

$clockingNO = $row->pno; 
if($row->cat == "c" ) { $POSITION="CASUAL";	 }
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

echo "
<table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
<tr >
<!-- PERSONAL DATA -- >
<td class='DataTD' colspan='4'><table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
	<tr>
      <td class='FieldCaptionTD'>Regular/Casual </td>
	  <td class='DataTD'>$POSITION</td>
 	</tr>
	<tr>     <td class='FieldCaptionTD'>Job Title</td>
	  <td class='DataTD'><input class='Input' size='10' maxlength='10' name='jobtitle' value='$row->jobtitle'></td>
	</tr>
	<tr>
      <td class='FieldCaptionTD'>Date Hired</td>
	  <td class='DataTD'>$row->d1</td>
 	</tr>
	<tr>     <td class='FieldCaptionTD'>Address Line 1</td>
	  <td class='DataTD'><input class='Input' size='20' maxlength='40' name='address1' value='$row->address1'></td>
	</tr>
	<tr>
      <td class='FieldCaptionTD'>Address Line 2</td>
	  <td class='DataTD'><input class='Input' size='20' maxlength='40' name='address2' value='$row->address2'></td>
	</tr>
	<tr>      <td class='FieldCaptionTD'>Address Line 3</td>
	  <td class='DataTD'><input class='Input' size='20' maxlength='40' name='address3' value='$row->address3'></td>
	</tr>
	<tr>
      <td class='FieldCaptionTD'>Address Line 4 </td>
	  <td class='DataTD'><input class='Input' size='20' maxlength='40' name='address4' value='$row->address4'></td>
	</tr>
	<tr>      <td class='FieldCaptionTD'>Post Code</td>
	  <td class='DataTD'><input class='Input' size='10' maxlength='10' name='postcode' value='$row->postcode'></td>
	</tr>
	<tr>
      <td class='FieldCaptionTD'>Reason For Leaving </td>
	  <td class='DataTD'><input class='Input' size='30' maxlength='70' name='terminationtype' value='$row->terminationtype'></td>
	</tr>
	<tr>      <td class='FieldCaptionTD'>Leaving Date</td>
	  <td class='DataTD'><input class='Input' size='10' maxlength='15' name='xx' value=''></td>
	</tr>
	<tr>
      <td class='FieldCaptionTD'>Home Phone </td>
	  <td class='DataTD'><input class='Input' size='13' maxlength='20' name='homephone' value='$row->homephone'></td>
	</tr>
	<tr>      <td class='FieldCaptionTD'>Mobile Phone</td>
	  <td class='DataTD'><input class='Input' size='13' maxlength='20' name='mobilephone' value='$row->mobilephone'></td>
	</tr>
	<tr>
      <td class='FieldCaptionTD'>Aproved </td>
	  <td class='DataTD'>$approved</td>
 	</tr>
	<tr>     <td class='FieldCaptionTD'>Aproved On</td>
	  <td class='DataTD'><input class='Input' size='12' maxlength='15' name='approvedon' value='$row->approvedon'></td>
	</tr>
	<tr>
      <td class='FieldCaptionTD'>Reference </td>
	  <td class='DataTD'><INPUT TYPE='checkbox' NAME='ref'></td>
	</tr>
	<tr>      <td class='FieldCaptionTD'>GRADE</td>
	  <td class='DataTD'><input class='Input' size='10' maxlength='10' name='grade' value='$row->grade'></td>
	</tr>
	<tr>      <td class='FieldCaptionTD'>Regular days total</td>
	  <td class='DataTD'><B>$row->regdays</B></td>
	</tr>
	<tr>      <td class='FieldCaptionTD'>speciality</td>
	  <td class='DataTD'><input class='Input' size='20' maxlength='50' name='speciality' value='$row->speciality'></td>
	</tr>	 
</TABLE></td>

<!-- PHOTO ETC -- >
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
		 $DisplName="1 - [$row->knownas $row->surname] ";
		 break;
		case 2:
		// ( brackets
		 $DisplIndex=2;
		 $DisplName="2 - ($row->knownas $row->surname) ";
		 break;
		case 3:
		//capitals
		 $DisplIndex=3;
		 $str = strtoupper("$row->knownas $row->surname");
		 $DisplName="3 - $str ";
		 break;
		
		default:
		 $DisplIndex=0;
		 $DisplName="0 - $row->knownas $row->surname ";
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


<!-- SHOPS ACCE�SS -- >
<td class='DataTD' colspan='4'>	  
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
	  <td class='DataTD'>� <B>$HR</B></td>
</tr><TR>
	  <td class='FieldCaptionTD'>Daily rate</td>
	  <td class='DataTD' colspan='3'>� $row->daylyrate</td>
</tr><TR>
	  <td class='FieldCaptionTD'>Managament bonus</td>
	  <td class='DataTD' colspan='3'>�  $row->managament_bonus</td>
</tr><TR>
	  <td class='FieldCaptionTD'>Punctuality bonus</td>
	  <td class='DataTD' colspan='3'>� $row->punctuality_bonus</td>
</tr><TR>
	  <td class='FieldCaptionTD'>Security bonus</td>
	  <td class='DataTD' colspan='3'>� $row->security_bonus</td>
		 </tr><TR>
	  <td class='FieldCaptionTD'>Travel card </td>
	  <td class='DataTD' colspan='3'>� $row->travel_card_bonus</td>

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


	for ($i=0;$i=2;$i++)
		{		
		if ($row->default == $i) $selected[$i]=" selected";
		else $selected[$i] = "";
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
      <td class='FieldCaptionTD'>YES</td>
	  <td class='DataTD' colspan='6'><input class='Input' size='90' maxlength='90' name='comment1' value='$row->comment1'></td>
</TR>
<tr>
      <td class='FieldCaptionTD'>NO</td>
	  <td class='DataTD' colspan='10'><input class='Input' size='90' maxlength='90' name='comment2' value='$row->comment2'></td>
</TR>
<tr>
      <td class='FieldCaptionTD'>D.K.</td>
	  <td class='DataTD' colspan='6'><input class='Input' size='90' maxlength='90' name='comment3' value='$row->comment3'></td>
</TR>

 </TD>	</td>
<input name='lp' type='hidden' value='$row->ID'>";
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
//	checkZm("started");
//	checkZm("category");
//	checkZm("regdays");

list($day, $month, $year) = explode("/",$approvedon);
$approvedon = "$year-$month-$day";

if( $approved == "on" ) { $approved = 1; } else { $approved = 0; } 
if( $_pr14 == "on" ) { $_pr14 = 1; } else { $_pr14 = 0; } 
if( $_pr16 == "on" ) { $_pr16 = 1; } else { $_pr16 = 0; } 
if( $_pr20 == "on" ) { $_pr20 = 1; } else { $_pr20 = 0; } 
if( $_pr28 == "on" ) { $_pr28 = 1; } else { $_pr28 = 0; } 
if( $_pr30 == "on" ) { $_pr30 = 1; } else { $_pr30 = 0; } 
if( $_pr32 == "on" ) { $_pr32 = 1; } else { $_pr32 = 0; } 
if( $_pr34 == "on" ) { $_pr34 = 1; } else { $_pr34 = 0; } 
if( $_nhg56 == "on" ) { $_nhg56 = 1; } else { $_nhg56 = 0; } 
if( $_nhg34 == "on" ) { $_nhg34 = 1; } else { $_nhg34 = 0; } 
if( $_nhg36 == "on" ) { $_nhg36 = 1; } else { $_nhg36 = 0; } 
if( $_nhg38 == "on" ) { $_nhg38 = 1; } else { $_nhg38 = 0; } 
if( $_nhg40 == "on" ) { $_nhg40 = 1; } else { $_nhg40 = 0; } 
if( $_nhg42 == "on" ) { $_nhg42 = 1; } else { $_nhg42 = 0; } 
if( $_chs == "on" ) { $_chs = 1; } else { $_chs = 0; } 
if( $_bs == "on" ) { $_bs = 1; } else { $_bs = 0; } 
if( $_gcs == "on" ) { $_gcs = 1; } else { $_gcs = 0; } 
if( $_d247 == "on" ) { $_d247 = 1; } else { $_d247 = 0; } 

if (!$db->Open()) $db->Kill();
	$query = ("UPDATE `staffdetails` SET `jobtitle` = '$jobtitle',`terminationtype` = '$terminationtype' ,`address1` = '$address1',`address2` = '$address2',`address3` = '$address3',`address4` = '$address4',`postcode` = '$postcode',`comment1` ='$comment1' ,`comment2` = '$comment2' , `comment3` = '$comment3' , `homephone`='$homephone' , `mobilephone` = '$mobilephone' , `approvedon` = '$approvedon' , `grade` = '$grade' , `speciality` = '$speciality', `approved` = '$approved', `pr14` = '$_pr14' , `pr16` = '$_pr16', `pr20` = '$_pr20', `pr28` = '$_pr28', `pr30` = '$_pr30', `pr32` = '$_pr32', `pr34` = '$_pr34', `nhg56` = '$_nhg56', `nhg34` = '$_nhg34', `nhg36` = '$_nhg36', `nhg38` = '$_nhg38', `nhg40` = '$_nhg40', `nhg42` = '$_nhg42', `chs` = '$_chs', `bs` = '$_bs', `gcs` = '$_gcs', `247` = '$_d247' WHERE `NO` =$cln LIMIT 1 ;") ;

$query2 = ("UPDATE `nombers` SET `displ` = '$displ' WHERE `pno` = '$cln' LIMIT 1 ;");

   if (!$db->Query($query)) $db->Kill();
	if (!$db->Query($query2)) $db->Kill();
   echo "<script language='javascript'>window.location=\"hr_data.php?cln=$cln\"</script>";
//   }

} //fi state=1
else
{
 echo "<BR><BR><BR>Ostrze�enie!!!!!<BR><BR><BR>",
	 "Ktos z komputera $REMOTE_ADDR probuje sie wlamac<BR>";
} //else state
?>

