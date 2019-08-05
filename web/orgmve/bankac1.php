<?php
include("./config.php");
include_once("./header.php");
  
$PHP_SELF = $_SERVER['PHP_SELF'];

(!isset($_POST['cln'])) ? $cln = $_GET['cln'] : $cln = $_POST['cln'];
$no = $cln;
(!isset($_POST['bankstate'])) ? $bankstate = "" : $bankstate = $_POST['bankstate'];
(!isset($_POST['sortc'])) ? $sortc = "" : $sortc = $_POST['sortc'];
(!isset($_POST['acno'])) ? $acno = "" : $acno = $_POST['acno'];
(!isset($_POST['bankforename'])) ? $bankforename = "" : $bankforename = $_POST['bankforename'];
(!isset($_POST['banksurename'])) ? $banksurename = "" : $banksurename = $_POST['banksurename'];
(!isset($_POST['bank2forename'])) ? $bank2forename = "" : $bank2forename = $_POST['bank2forename'];
(!isset($_POST['bank2surename'])) ? $bank2surename = "" : $bank2surename = $_POST['bank2surename'];
(!isset($_POST['otherbankname'])) ? $otherbankname = "" : $otherbankname = $_POST['otherbankname'];
(!isset($_POST['bankid'])) ? $bankid = "" : $bankid = $_POST['bankid'];
(!isset($_POST['message'])) ? $message = "" : $message = $_POST['message'];  
  
$dataakt=date("d/m/Y");

$db = new CMySQL;
$db1 = new CMySQL;
if (!$db->Open()) $db->Kill();

//uprstr($PU,90);
$tytul='Bank account Details';

if ($bankstate == "1") {

$sql = " select 
 `bankdetails`.`no`, DATE_FORMAT(`bankdetails`.`date1`, \"%d/%m/%Y\") as d2,`bankdetails`.`sortc`,`bankdetails`.`acno`,`bankdetails`.`bank`,`bankdetails`.`accname`,`bankdetails`.`forename`, `bankdetails`.`surename`,DATE_FORMAT(`bankdetails`.`date1` , \"%d/%m/%y\" ) AS date1,
 `bankdetails`.`forename` As forename, `bankdetails`.`surename` As surename,`bankdetails`.`bankforename` As bankforename, `bankdetails`. `banksurename` As banksurename,`bankchequepayment`.`cheque`,`bankchequepayment`.`date1` as bankdate1,`bankdetails`.`message` as message
 from  `bankdetails` LEFT JOIN `bankchequepayment`  on `bankdetails`.`no`=`bankchequepayment`.`no`
Where `bankdetails`.`no`='$no'
 ";

  if ($db->Query($sql))  {
  $rows=$db->Rows();
   $bankforename = $db->Fix($bankforename);
   $banksurename= $db->Fix($banksurename);
   $bank2forename = $db->Fix($bank2forename);
   $bank2surename= $db->Fix($bank2surename);
   $message= $db->Fix($message);
  
  if ($rows== 0) {
  //insert
 $sql = "SELECT * FROM `banklist` Where bankid='$bankid'";
  $query = $db->Query($sql);
  $row=$db->Row();
  $bankname= $row->bankname;
  
 $sql=" INSERT INTO `bankdetails` ( `no`, `banknonumber`,`sortc`, `acno`, `bank`, `bankid`, `otherbank`, `accname`, `forename`, `surename`, `bankaccname`, `bankforename`, `banksurename`,`message`,`date1`, `userid`) VALUES
( '$no', '1','$sortc', '$acno', '$bankname', '$bankid', '$otherbankname', '$bank2forename $bank2surename', '$bank2forename', '$bank2surename','$bankforename $banksurename', '$bankforename', '$banksurename', '$message',STR_TO_DATE('$dataakt', '%d/%m/%y'), '0')";

 $query = $db->Query($sql);
  }
  else {
  
  $sql = "SELECT * FROM `banklist` Where bankid='$bankid'";
  $query = $db->Query($sql);
  $row=$db->Row();
  $bankname= $row->bankname;
  
  //update
  $sql=" UPDATE `bankdetails` SET 
   `sortc`='$sortc', `acno`='$acno', `bank`='$bankname', `bankid`='$bankid', `otherbank`='$otherbankname', `accname`='$bank2forename $bank2surename', `forename`='$bank2forename', `surename`='$bank2surename', `bankaccname`='$bankforename $banksurename', `bankforename`='$bankforename', `banksurename`='$banksurename', `date1`=STR_TO_DATE('$dataakt', '%d/%m/%y'), `userid`='0', `message`='$message'
  WHERE `bankdetails`.`no` ='$no' LIMIT 1 ;";

 $query = $db->Query($sql);

  }
  
  }
 else {
  echo "
	<font class='FormHeaderFont'>$tytul</font> 
<TABLE>
  <tr>
    <td class='DataTD'></td>
    <td class='DataTD' colspan='5'>Error</td>
  </tr>
  </TABLE>
  ";
 $db->Kill();
 }

}


if (!$db1->Open()) $db1->Kill();
$prac1 =("SELECT `ID`, `pno`, `firstname`, `surname`, `knownas`, `status` FROM `nombers` WHERE `pno`='$cln' LIMIT 1;");
if (!$db1->Query($prac1)) $db1->Kill();
   while ($row1=$db1->Row())
    {
    echo "
	<font class='FormHeaderFont'>$tytul</font> 
<TABLE><TR><TD>
<div id='name'>

<table>
    <tr>
      <td class='FieldCaptionTD'>Clocking in number</td><td class='DataTD'><FONT COLOR='#000099'><B>$row1->pno</B></FONT></td>
	  <td class='FieldCaptionTD'>Known as</td><td class='DataTD'>$row1->knownas</td>
    </tr>
    <tr>
      <td class='FieldCaptionTD'>First name</td><td class='DataTD'>$row1->firstname</td>
      <td class='FieldCaptionTD'>Surname</td><td class='DataTD'>$row1->surname</td>
    </tr>   
</table>";
$no=$row1->pno;
$firstname=$row1->firstname;
$surname=$row1->surname;
	}

echo "	<TD ALIGN=JUSTIFY VALIGN=TOP border=0>
<center>
&nbsp;

</TR><TR></TD><TD>
<div id='list'>

<table border='0' cellpadding='3' cellspacing='1' >
  <tr>
  <td class='ColumnTD' nowrap>DATE </td>
  <td class='ColumnTD' nowrap>Bank Sort Code</td>
  <td class='ColumnTD' nowrap>Bank Account Number</td>
  <td class='ColumnTD' nowrap>Bank Account Name</td>
  <td class='ColumnTD' nowrap>Bank / Building Soc.</td>
</tr>";

$bankhtml= "";

if (!$db->Open()) $db->Kill();


$sql = "SELECT `bankdetid`, `sortc`,`acno`, `pno`, `accname`,`bank`,`bankid`,`userid`, DATE_FORMAT(`date1`, \"%d/%m/%Y\") as d2 FROM `bankdetails` WHERE `pno`='$cln' ";
$sql = " select 
 `bankdetails`.`no`, DATE_FORMAT(`bankdetails`.`date1`, \"%d/%m/%Y\") as d2,`bankdetails`.`sortc`,`bankdetails`.`acno`,`bankdetails`.`bank`,`bankdetails`.`bankid`,`bankdetails`.`otherbank`,`bankdetails`.`accname`,`bankdetails`.`forename`, `bankdetails`.`surename`,DATE_FORMAT(`bankdetails`.`date1` , \"%d/%m/%y\" ) AS date1,
`bankdetails`.`bankaccname`,`bankdetails`.`bankforename` As bankforename,`bankdetails`.`banksurename` As banksurename,`bankchequepayment`.`cheque`,`bankchequepayment`.`date1` as bankdate1,`bankdetails`.`message` as message
 from  `bankdetails` LEFT JOIN `bankchequepayment`  on `bankdetails`.`no`=`bankchequepayment`.`no`
Where `bankdetails`.`no`='$cln' 
order by `bankdetails`.cur_timestamp DESC
 ";
  if ($db->Query($sql)) 
  {
    while ($row=$db->Row())
    {
     echo "<tr>
		<td class='DataTD'><B>$row->d2</B></td>
		<td class='DataTD'> <B>".$row->sortc."</B></td>
		<td class='DataTD'> <B>$row->acno</B></td>
		<td class='DataTD'> <B>$row->accname</B></td>
		<td class='DataTD'> <B>$row->bank</B></td>
		</tr>  ";
		$sortc = $row->sortc;
		$acno= $row->acno;
		$bankforename=$row->bankforename;
		$banksurename=$row->banksurename;
		$bank2forename=$row->forename;
		$bank2surename=$row->surename;
		$bankid=$row->bankid;
		$message=$row->message;
		$otherbankname=$row->otherbank;
		$bankaccname=$row->accname;
  } 
$sql = "SELECT * FROM `banklist`";
if ($db->Query($sql)) 
  {
    while ($row=$db->Row())
    {
    if ($row->bankid == $bankid) {
    $bankhtml.= "<OPTION value='$bankid' selected>$row->bankname</OPTION>\n";
    }
    else {
    $bankhtml.= "<OPTION value='$row->bankid'>$row->bankname</OPTION>\n";
    }
  }
}

} else {
echo " 
  <tr>
    <td class='DataTD'></td>
    <td class='DataTD' colspan='5'>Error</td>
  </tr>";
 $db->Kill();
}
echo "

</table>

</DIV>

<TD></TD>

<TABLE>
<TR>
<TD>
<BR><BR><FONT SIZE='+2' COLOR='#3333CC'><B>Change Bank account Details</B></FONT>
<FORM METHOD=POST ACTION='$PHP_SELF'>

<INPUT TYPE='hidden' NAME='cln' VALUE='$cln'>
<INPUT TYPE='hidden' NAME='bankstate' VALUE='1'>

<TABLE>
<TR>
	<TD><B>Bank Sort Code</B></TD>
	<TD><INPUT TYPE='text' NAME='sortc' SIZE='12' value='$sortc' maxlength='6'></TD>
</TR>
<TR>
	<TD><B>Bank Account number</B></TD>
	<TD><INPUT TYPE='text' NAME='acno' SIZE='12' value='$acno' maxlength='8'></TD>
</TR>
<TR>
	<TD>Bank Account Name</TD>
	<TD><INPUT TYPE='text' NAME='bank2forename' SIZE='12' value='$bankaccname'></TD>
</TR>
<TR>
	<TD><B>Bank / Building soc.</B></TD>
	<TD><SELECT NAME='bankid'>
	$bankhtml
	</SELECT></TD>
</TR>
<TR>
	<TD>Other Bank Name</TD>
	<TD><INPUT TYPE='text' NAME='otherbankname' SIZE='12' value='".$otherbankname."'></TD>
</TR>
<TR>
	<TD>Message</TD>
	<TD><INPUT TYPE='text' NAME='message' SIZE='40' maxlength='255' value='$message'></TD>
</TR>
<TR>
	<TD><INPUT TYPE='submit' VALUE='Change'></TD>
	<TD>&nbsp;</TD>
</TR>




</TABLE>
</FORM><!-- end of new advance -->
</TD>

</TR>
</TABLE>

</TD></TR></TABLE>

</center><BR></td></tr></table>";
include_once("./footer.php");
?>