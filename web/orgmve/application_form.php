<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$db2 = new CMySQL;
$db3 = new CMySQL;
$db4 = new CMySQL;

 if (!$db->Open()) $db->Kill();
 if (!$db2->Open()) $db2->Kill();
 if (!$db3->Open()) $db3->Kill();
 if (!$db4->Open()) $db4->Kill();
 

$tytul='Application form data';
 
if(!isset($state))
{
$no=$_GET['cln'];
   
 $titletext = array(
    '1' => 'Mr.',
    '2' => 'Mrs.',
    '3' => 'Miss.',
    '4' => 'Ms.'
    );
  
  $yesnotext = array(
    '0' => "no",
    '1' => "yes",
    '2' => "n/a"
      );
      
    $presentcircumtances1text = array(
    '1' => 'This is my first job since last 6 April and I HAVE NOT been receiving taxable Jobseeker\'s Allowance or taxable Incapacity Benefit.',
      '2' => 'This is my only job, but since last 6 April I HAVE had another job, or have received taxable Jobseeker\'s Allowance or Incapacity Benefit. I do not receive a state or occupational pension.',
      '3' => 'I have another job or receive a state or occupational pension.'
      );  
    $presentcircumtances2text = array(
   '0' => "no",
    '1' => "I left a course of Higher Education before last 6 April and received my first Student Loan on or after 1 September 1998 and I have not fully repaid my student loan. " );  
    
    $leavingresontext = array(
    '1' => 'DISMISSED',
    '2' => 'RESIGNED',
    '3' => 'ASKED TO RESIGN',
    '4' => 'END OF TEMPORARY POST',
    '5' => 'MADE REDUNDANT',
    '6' => 'OTHER'  );
   
   


echo "	<TD ALIGN=JUSTIFY VALIGN=TOP border=0>
	<table width='100%' border=0><tr><td>

<center>
<!-- BEGIN Record members -->
<form action='$PHP_SELF' method='post' name='ed_czl'>
  <font class='FormHeaderFont'>$tytul</font>
  <table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>

";

//uprstr($PU,95);

 

 
 if(isset($no)){
 

  $q="SELECT 
    pno, 
    code,
    app_state,
    cat,
    title,
  code,
  firstname,
  surname,
  knownas,
  email,
  DATE_FORMAT(`dateofbirth` , \"%d/%m/%Y\" ) AS dateofbirth,
  nationality, 
  ninumber,
 homephone,
  mobilephone,
  address1,
  address2,
  address3,
  postcode,
 em_name,
 em_tel,
 em_mobile,
 em_address1,
 em_address2,
 em_address3,
 em_postcode,
 bankid,
 bank, 
 bankaccname, 
 sortc, 
 acno,
 criminal_convictions,  
 presentcircumtances1,
 presentcircumtances2,
 education1_date_from,
 education1_date_to,
 education1_name_address,
 education1_subject,
 education2_date_from,
 education2_date_to,
 education2_name_address,
 education2_subject,
 otherqualifications,
 employment1_date_from,
 employment1_date_to,
 employment1_name_address,
 employment1_jobtitle,
 employment1_reason_for_leaving,
 employment1_reason_for_leaving_other,
 employment2_date_from,
 employment2_date_to,
 employment2_name_address,
 employment2_jobtitle,
 employment2_reason_for_leaving,
 employment2_reason_for_leaving_other,
 employment3_date_from,
 employment3_date_to,
 employment3_name_address,
 employment3_jobtitle,
 employment3_reason_for_leaving,
 employment3_reason_for_leaving_other,
 gaps1_date_from,gaps1_date_from,
 gaps1_date_to,
 gaps1_doing,
 gaps2_date_from,
 gaps2_date_to,
 gaps2_doing,
 re1_name,
 re1_email,
 re1_occupation,
 re1_tel,
 re1_mobile,
 re1_address1,
 re1_address2,
 re1_address3,
 re1_postcode,
 re1_relationship,
 re2_name,
 re2_email,
 re2_occupation,
 re2_tel,
 re2_mobile,
 re2_address1,
 re2_address2,
 re2_address3,
 re2_postcode,
 re2_relationship,
 started,
 left1
		 FROM (`nombers` LEFT JOIN  `staffdetails` ON `nombers`.`pno` = `staffdetails`.`no`) LEFT JOIN bankdetails ON  `nombers`.`pno` = `bankdetails`.`no` 
		WHERE `nombers`.`pno`= '$no'
    Limit 1";
  } else { 
  echo "<BR><BR><CENTER><H1>Error in $PHP_SELF</H1></CENTER><BR><BR>";
  exit;
 }

  $db->Query($q);
  $row=$db->Row();
/*
  $q = "SELECT DISTINCT `nombers`.`pno` , `code`, `app_state`,`nombers`.`surname` , `nombers`.`firstname` , `nombers`.`knownas` , `nombers`.`cat` ,DATE_FORMAT( `nombers`.`started` , \"%d/%m/%Y\" ) AS started,  `emplcat`.catname,  `emplcat`.catname_staff  FROM (`nombers` CROSS JOIN  `staffdetails` ON `nombers`.`pno` = `staffdetails`.`no`) INNER JOIN `emplcat` ON `nombers`.`cat`= `emplcat`.catozn WHERE `nombers`.`status` = 'OK'
 AND `nombers`.`pno` = '$no'
 Limit 1
  ";
   $db2->Query($q);
   $row2=$db2->Row();
  */ 
  $cattxt = "";   
  $q = "SELECT catozn,catname FROM emplcat Order by catname";
    
  if ($db3->Query($q)) 
  {
    while ($r=$db3->Row())
    {
		if ($row->cat == $r->catozn) 
				$cattxt = $r->catname;
				}
				}
		else {
echo " 
  <tr>
    <td class='DataTD'></td>
    <td class='DataTD' colspan='3'>SQL Error 1a</td>
  </tr>";
  $db3->Kill();
} 
   
   
    $titletxt = "<select class='Select' name='_title'>\n";   
  $q = "SELECT `titlenum`, `title` FROM `titlelist` Order by `titlenum`";
    
  if ($db3->Query($q)) 
  {
    while ($r=$db3->Row())
    {
		if ($row->title== $r->titlenum) 
				$titletxt  .= "<option value='$r->titlenum' selected>$r->title</option>\n";
		else 
		       $titletxt  .=  "<option value='$r->titlenum'>$r->title</option>\n";
    }
	} else {
echo " 
  <tr>
    <td class='DataTD'></td>
    <td class='DataTD' colspan='3'>SQL Error 1a</td>
  </tr>";
 $db->Kill();
} 
   
   
   $banktext = "<select class='Select' name='_bankid'>\n";   
    $q= "SELECT bankid, bankname	FROM banklist Order by bankid";
    
  if ($db3->Query($q)) 
  {
    while ($r=$db3->Row())
    {
		if ($row->bankid == $r->bankid) 
				 $banktext  .= "<option value='$r->bankid' selected>$r->bankname</option>\n";
		else 
		        $banktext  .=  "<option value='$r->bankid'>$r->bankname</option>\n";
    }
	} else {
echo " 
  <tr>
    <td class='DataTD'></td>
    <td class='DataTD' colspan='3'>SQL Error 1a</td>
  </tr>";
 $db->Kill();
} 
   
   
   
   $banktext  .=  ".</select>"; 
    
  echo "
 
  <tr>
      <td class='FieldCaptionTD'>Clocking in number</td>
      <td class='DataTD'><B>$row->pno</B></td>
    </tr>";
    if  ($row->app_state == "2")
  echo "
   <tr>
      <td class='FieldCaptionTD'>Code</td>
      <td class='DataTD'>$row->code</td>
    </tr>
  ";
    echo "    
    <tr>
     <td class='FieldCaptionTD'>Title</td>
      <td class='DataTD'>$titletxt
      </select>
      </td>
    </tr>
    <tr>
     <td class='FieldCaptionTD'>First name</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_firstname' value='$row->firstname'></td>
    </tr>
    <tr>  
      <td class='FieldCaptionTD'>Surname</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_surname' value='$row->surname'></td>
    </tr>
  <tr>
      <td class='FieldCaptionTD'>Known as</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_knownas' size='64' value='$row->knownas'></td>
    </tr>
    <tr>
      <td class='FieldCaptionTD'>Email</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_email' size='64' value='$row->email'></td>
    </tr>
    <tr>
      <td class='FieldCaptionTD'>Date of birth</td>
      <td class='DataTD'><input class='Input' maxlength='10' name='_dateofbirth' size='10' value='$row->dateofbirth'></td>
    </tr>
    <tr>
      <td class='FieldCaptionTD'>Nationality</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_nationality' size='64' value='$row->nationality'></td>
    </tr>
    <tr>
      <td class='FieldCaptionTD'>National insurance number</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_ninumber' value='$row->ninumber'></td>
    </tr>
    <tr>  
      <td class='FieldCaptionTD'>Telephone number (landline)</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_homephone' value='$row->homephone'></td>
    </tr>
    <tr>
      <td class='FieldCaptionTD'>Telephone number (mobile)</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_mobilephone' size='64' value='$row->mobilephone'></td>
    </tr>
    <tr>
      <td class='FieldCaptionTD'>Address line 1</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_address1' size='64' value='$row->address1'></td>
     </tr>
    <tr>
     <td class='FieldCaptionTD'>Address line 2</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_address2' value='$row->address2'></td>
    </tr>
    <tr>  
      <td class='FieldCaptionTD'>Addrees line 3</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_address3'' value='$row->address3'></td>
    </tr>
    <tr>
      <td class='FieldCaptionTD'>Post Code</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_postcode' size='64' value='$row->postcode'></td>
    </tr>
    <tr>
      <td class='FieldCaptionTD'>Emergency contact name</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_em_name' size='64' value='$row->em_name'></td>
    </tr>
    <tr>
      <td class='FieldCaptionTD'>Contact telephone number (landline)</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_em_tel' size='64' value='$row->em_tel'></td>
    </tr>
    <tr>
      <td class='FieldCaptionTD'>Contact telephone number (mobile)</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_em_mobile' value='$row->em_mobile'></td>
    </tr>
     <tr>
      <td class='FieldCaptionTD'>Address 1 line</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_em_address1' size='64' value='$row->em_address1'></td>
     </tr>
    <tr>
     <td class='FieldCaptionTD'>Address 2 line</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_em_address2' value='$row->em_address2'></td>
    </tr>
    <tr>  
      <td class='FieldCaptionTD'>Address 3 line</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_em_address3' value='$row->em_address3'></td>
    </tr>
    <tr>
      <td class='FieldCaptionTD'>Post Code</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_em_postcode' size='64' value='$row->em_postcode'></td>
    </tr>
    <tr>
      <td class='FieldCaptionTD'>Bank</td>
      <td class='DataTD'>$banktext</td>
    </tr>
   <tr>
      <td class='FieldCaptionTD'>Bank</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_bank' size='64' value='$row->bank'></td>
    </tr>
    <tr>
      <td class='FieldCaptionTD'>Name of account holder</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_bankaccname' size='64' value='$row->bankaccname'></td>
     </tr>
     <tr>
      <td class='FieldCaptionTD'>Sort code</td>
      <td class='DataTD'><input class='Input' maxlength='8' name='_sortc' size='8' value='$row->sortc'></td>
     </tr> 
    <tr>
      <td class='FieldCaptionTD'>Account</td>
      <td class='DataTD'><input class='Input' maxlength='8' name='_acno' size='8' value='$row->acno'></td>
     </tr>
    <tr>
      <td class='FieldCaptionTD'>Criminal convition</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_criminal_convictions' size='64' value='$row->criminal_convictions'></td>
     </tr> 
    <tr>
      <td class='FieldCaptionTD'>Present circumtances 1</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_presentcircumtances1' size='64' value='$row->presentcircumtances1'></td>
    </tr>
    <tr>
      <td class='FieldCaptionTD'>Present circumtances 2</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_presentcircumtances2' size='64' value='$row->presentcircumtances2'></td>
     </tr>
    <tr>
      <td class='FieldCaptionTD'>Educational - from</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_education1_date_from' size='64' value='$row->education1_date_from'></td>
     </tr>
    <tr>
      <td class='FieldCaptionTD'>Educational - to</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_education1_date_to' size='64' value='$row->education1_date_to'></td>
     </tr>
     <tr>
      <td class='FieldCaptionTD'>Name & address</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_education1_name_address' size='64' value='$row->education1_name_address'></td>
    </tr>
    <tr>
      <td class='FieldCaptionTD'>Subject</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_education1_subject' size='64' value='$row->education1_subject'></td>
    </tr>
    <tr>
      <td class='FieldCaptionTD'>From</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_education2_date_from' value='$row->education2_date_from'></td>
    </tr>
     <tr>
      <td class='FieldCaptionTD'>To</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_education2_date_to' value='$row->education2_date_to'></td>
    </tr>
     <tr>
      <td class='FieldCaptionTD'>Name & address</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_education2_name_address' size='64' value='$row->education2_name_address'></td>
     </tr>
    <tr>
     <td class='FieldCaptionTD'>Subject</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_education2_subject' value='$row->education2_subject'></td>
    </tr>
    <tr>  
      <td class='FieldCaptionTD'>Other qualifications</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_otherqualifications' value='$row->otherqualifications'></td>
    </tr>
  <tr>
      <td class='FieldCaptionTD'>Employment - from</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_employment1_date_from' size='8' value='$row->employment1_date_from'></td>
    </tr>
    <tr>
      <td class='FieldCaptionTD'>Employment - to</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_employment1_date_to' size='8' value='$row->employment1_date_to'></td>
    </tr>
    <tr>
      <td class='FieldCaptionTD'>Name & address</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_employment1_name_address' size='64' value='$row->employment1_name_address'></td>
    </tr>
    <tr>  
      <td class='FieldCaptionTD'>Jobtitle</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_employment1_jobtitle' value='$row->employment1_jobtitle'></td>
    </tr>
   <tr>
      <td class='FieldCaptionTD'>Reason for leaving</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_employment1_reason_for_leaving' size='64' value='$row->employment1_reason_for_leaving'></td>
    </tr>
    <tr>
      <td class='FieldCaptionTD'>Other reason for leaving</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_employment1_reason_for_leaving_other' size='64' value='$row->employment1_reason_for_leaving_other'></td>
     </tr> 
    <tr>  
      <td class='FieldCaptionTD'>From</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_employment2_date_from' value='$row->employment2_date_from'></td>
    </tr>
     <tr>  
      <td class='FieldCaptionTD'>To</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_employment2_date_to' value='$row->employment2_date_to'></td>
    </tr>
   <tr>
      <td class='FieldCaptionTD'>Name & address</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_employment2_name_address' size='64' value='$row->employment2_name_address'></td>
    </tr>
    <tr>
      <td class='FieldCaptionTD'>Jobtitle</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_employment2_jobtitle' size='64' value='$row->employment2_jobtitle'></td>
     </tr> 
    <tr>
      <td class='FieldCaptionTD'>Reason for leaving</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_employment2_reason_for_leaving' size='64' value='$row->employment2_reason_for_leaving'></td>
    </tr>
    <tr>
      <td class='FieldCaptionTD'>Other reason for leavin</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_employment2_reason_for_leaving_other' size='64' value='$row->employment2_reason_for_leaving_other'></td>
     </tr>
    <tr>
      <td class='FieldCaptionTD'>From</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_employment3_date_from' size='64' value='$row->employment3_date_from'></td>
     </tr>
     <tr>
      <td class='FieldCaptionTD'>To</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_employment3_date_to' size='64' value='$row->employment3_date_to'></td>
     </tr>
   <tr>
      <td class='FieldCaptionTD'>Name & addresst</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_employment3_name_address' size='64' value='$row->employment3_name_address'></td>
     </tr>
        <tr>  
      <td class='FieldCaptionTD'>Jobtitle</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_employment3_jobtitle' value='$row->employment3_jobtitle'></td>
    </tr>
   <tr>
      <td class='FieldCaptionTD'>Reason for leaving</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_employment3_reason_for_leaving' size='64' value='$row->employment3_reason_for_leaving'></td>
    </tr>
    <tr>
      <td class='FieldCaptionTD'>Other reason for leavin</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_employment3_reason_for_leaving_other' size='64' value='$row->employment3_reason_for_leaving_other'></td>
     </tr> 
    <tr>
      <td class='FieldCaptionTD'>Gaps1 - from</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_gaps1_date_from' size='64' value='$row->gaps1_date_from'></td>
    </tr>
    <tr>
      <td class='FieldCaptionTD'>Gaps1 - to</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_gaps1_date_to' size='64' value='$row->gaps1_date_to'></td>
    </tr>
    <tr>
      <td class='FieldCaptionTD'>Doing what</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_gaps1_doing' size='64' value='$row->gaps1_doing'></td>
     </tr>
    <tr>
      <td class='FieldCaptionTD'>From</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_gaps2_date_from' size='64' value='$row->gaps2_date_from'></td>
     </tr>
       <tr>
      <td class='FieldCaptionTD'>To</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_gaps2_date_to' size='64' value='$row->gaps2_date_to'></td>
     </tr>
   <tr>
      <td class='FieldCaptionTD'>Doing what</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_gaps2_doing' size='64' value='$row->gaps2_doing'></td>
    </tr>
    <tr>
      <td class='FieldCaptionTD'>Referee1 - name</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_re1_name' size='64' value='$row->re1_name'></td>
     </tr> 
    <tr>
      <td class='FieldCaptionTD'>Email</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_re1_email' size='64' value='$row->re1_email'></td>
    </tr>
    <tr>
      <td class='FieldCaptionTD'>Occupation</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_re1_occupation' size='64' value='$row->re1_occupation'></td>
     </tr>
    <tr>
      <td class='FieldCaptionTD'>Telephone number (landline)</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_re1_tel' size='64' value='$row->re1_tel'></td>
     </tr>
   <tr>
      <td class='FieldCaptionTD'>Telephone number (mobile)</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_re1_mobile' size='64' value='$row->re1_mobile'></td>
     </tr>
        <tr>  
      <td class='FieldCaptionTD'>Address line 1</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_re1_address1' value='$row->re1_address1'></td>
    </tr>
   <tr>
      <td class='FieldCaptionTD'>Address line 2</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_re1_address2' size='64' value='$row->re1_address2'></td>
    </tr>
    <tr>
      <td class='FieldCaptionTD'>Address line 3</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_re1_address3' size='64' value='$row->re1_address3'></td>
     </tr> 
       <tr>
      <td class='FieldCaptionTD'>Postcode</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_re1_postcode' size='64' value='$row->re1_postcode'></td>
     </tr>
    <tr>
      <td class='FieldCaptionTD'>Relationship</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_re1_relationship' size='64' value='$row->re1_relationship'></td>
     </tr>
    <tr>
      <td class='FieldCaptionTD'>Referee2 - name</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_re2_name' size='64' value='$row->re2_name'></td>
     </tr> 
    <tr>
      <td class='FieldCaptionTD'>Email</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_re2_email' size='64' value='$row->re2_email'></td>
    </tr>
    <tr>
      <td class='FieldCaptionTD'>Occupation</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_re2_occupation' size='64' value='$row->re2_occupation'></td>
     </tr>
    <tr>
      <td class='FieldCaptionTD'>Telephone number (landline)</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_re2_tel' size='64' value='$row->re2_tel'></td>
     </tr>
   <tr>
      <td class='FieldCaptionTD'>Telephone number (mobile)</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_re2_mobile' size='64' value='$row->re2_mobile'></td>
     </tr>
        <tr>  
      <td class='FieldCaptionTD'>Address line 1</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_re2_address1' value='$row->re2_address1'></td>
    </tr>
   <tr>
      <td class='FieldCaptionTD'>Address line 2</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_re2_address2' size='64' value='$row->re2_address2'></td>
    </tr>
    <tr>
      <td class='FieldCaptionTD'>Address line 3</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_re2_address3' size='64' value='$row->re2_address3'></td>
     </tr> 
    <tr>
      <td class='FieldCaptionTD'>Postcode</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_re2_postcode' size='64' value='$row->re2_postcode'></td>
     </tr>
    <tr>
      <td class='FieldCaptionTD'>Relationship</td>
      <td class='DataTD'><input class='Input' maxlength='255' name='_re2_relationship' size='64' value='$row->re2_relationship'></td>
     </tr>
    <tr>
      <td class='FieldCaptionTD'>&nbsp;</td>
      <td class='DataTD'>&nbsp;</td>
     </tr>
     <tr>
     <td class='FieldCaptionTD'>Start date</td>
      <td class='DataTD'>".$row->started."</td>
    </tr>
    <tr>
     <td class='FieldCaptionTD'>Job title</td>
      <td class='DataTD'>$cattxt</td>
    </tr>
   <tr>
      <td align='right' colspan='2'>
      <input name='no' type='hidden' value='$no'>
		<input name='recid' type='hidden' value='$row->ID'>
		<input name='state' type='hidden' value='1'>
    
    
    ";
			
 
echo "
			<input class='Button' name='Update' type='submit' value='$SAVEBTN'>
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
elseif($state=="1")
{
 $no=$_POST['no'];

  checkzm("_firstname");
   checkzm("_surname");
   checkzm("_knownas");
  

// if(isset($Update) and $Update=='$SAVEBTN'){ 
    if (!$db->Open()) $db->Kill();
	$query = ("UPDATE `nombers` SET `title`='$_title',`firstname`='$_firstname', `surname`='$_surname', `knownas`='$_knownas' WHERE `pno` = '$no' LIMIT 1") ;
//echo $query."<br>";
   if (!$db->Open()) $db->Kill();
   $result = mysql_query($query);
 
   $query = ("UPDATE `staffdetails` SET 
   email='$_email',
 `dateofbirth` =STR_TO_DATE( '$_dateofbirth', '%d/%m/%Y'),
  nationality = '$_nationality', 
  ninumber = '$_ninumber',
 homephone = '$_homephone',
  mobilephone = '$_mobilephone',
  address1 = '$_address1',
  address2 = '$_address2',
  address3 = '$_address3',
  postcode= '$_postcode',
 em_name = '$_em_name',
 em_tel = '$_em_tel',
 em_mobile = '$_em_mobile',
 em_address1 = '$_em_address1',
 em_address2 = '$_em_address2',
 em_address3= '$_em_address3',
 em_postcode = '$_em_postcode',
 criminal_convictions  = '$_criminal_convictions',  
 presentcircumtances1 = '$_presentcircumtances1',
 presentcircumtances2 = '$_presentcircumtances2',
 education1_date_from = '$_education1_date_from',
 education1_date_to = '$_education1_date_to',
 education1_name_address = '$_education1_name_address',
 education1_subject = '$_education1_subject',
 education2_date_from = '$_education2_date_from',
 education2_date_to = '$_education2_date_to',
 education2_name_address = '$_education2_name_address',
 education2_subject  = '$_education2_subject',
 otherqualifications = '$_otherqualifications',
 employment1_date_from = '$_employment1_date_from',
 employment1_date_to = '$_employment1_date_to',
 employment1_name_address = '$_employment1_name_address',
 employment1_jobtitle = '$_employment1_jobtitle',
 employment1_reason_for_leaving = '$_employment1_reason_for_leaving',
 employment1_reason_for_leaving_other = '$_employment1_reason_for_leaving_other',
 employment2_date_from = '$_employment2_date_from',
 employment2_date_to = '$_employment2_date_to',
 employment2_name_address = '$_employment2_name_address',
 employment2_jobtitle = '$_employment2_jobtitle',
 employment2_reason_for_leaving = '$_employment2_reason_for_leaving',
 employment2_reason_for_leaving_other = '$_employment2_reason_for_leaving_other',
 employment3_date_from = '$_employment3_date_from',
 employment3_date_to = '$_employment3_date_to',
 employment3_name_address = '$_employment3_name_address',
 employment3_jobtitle = '$_employment3_jobtitle',
 employment3_reason_for_leaving = '$_employment3_reason_for_leaving',
 employment3_reason_for_leaving_other = '$_employment3_reason_for_leaving_other',
 gaps1_date_from = '$_gaps1_date_from',
 gaps1_date_to = '$_gaps1_date_to',
 gaps1_doing = '$_gaps1_doing',
 gaps2_date_from = '$_gaps2_date_from',
 gaps2_date_to = '$_gaps2_date_to',
 gaps2_doing = '$_gaps2_doing',
 re1_name = '$_re1_name',
 re1_email = '$_re1_email',
 re1_occupation = '$_re1_occupation',
 re1_tel = '$_re1_tel',
 re1_mobile = '$_re1_mobile',
 re1_address1 = '$_re1_address1',
 re1_address2 = '$_re1_address2',
 re1_address3 = '$_re1_address3',
 re1_postcode = '$_re1_postcode',
 re1_relationship = '$_re1_relationship',
 re2_name = '$_re2_name',
 re2_email = '$_re2_email',
 re2_occupation = '$_re2_occupation',
 re2_tel = '$_re2_tel',
 re2_mobile = '$_re2_mobile',
 re2_address1 = '$_re2_address1',
 re2_address2 = '$_re2_address2',
 re2_address3 = '$_re2_address3',
 re2_postcode = '$_re2_postcode',
 re2_relationship = '$_re2_relationship'
  WHERE `no` = '$no' LIMIT 1") ;
//echo $query."<br>";
   if (!$db->Open()) $db->Kill();
   $result = mysql_query($query);
 
 	$query = ("UPDATE `bankdetails` SET
      bankid='$_bankid',
 bank='$_bank', 
 bankaccname='$_bankaccname', 
 sortc='$_sortc', 
 acno='$_acno'
WHERE `no` = '$no' LIMIT 1") ;
//echo $query."<br>";
   if (!$db->Open()) $db->Kill();
   $result = mysql_query($query); 
   
  echo "<script language='javascript'>window.location=\"application_form.php?cln=$no\"</script>";
//   }

//if(isset($Insert) and $Insert=='$NEWBTN')
// { echo "<script language='javascript'>window.location=\"n_os.php\"</script>";   }

} //fi state=1
else
{
 echo "<BR><BR><BR>Ostrze¿enie!!!!!<BR><BR><BR>",
	 "Ktos z komputera $REMOTE_ADDR probuje sie wlamac<BR>";
} //else state
//} //elseif  state
?>