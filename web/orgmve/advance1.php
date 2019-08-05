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
$data1d =  "$datac-01";
$datace =  date("m/Y");     

$clearing_day = $dataakt2;
if ($day<=10) $clearing_day="10/$datace";
else if ($day<=20) $clearing_day="20/$datace";

 
//uprstr($PU,90);
$cln=$_GET['cln'];
$tytul='Advances of the Employee';

if (!$db1->Open()) $db1->Kill();
$prac1 =("SELECT `ID`, `pno`, `firstname`, `surname`, `knownas`, `status`,daylyrate,VE,VFV, tax_code FROM `nombers` WHERE `pno`='$cln' LIMIT 1;");
if (!$db1->Query($prac1)) $db1->Kill();
   while ($row1=$db1->Row())
    {
    
      $rate = round(($row1->daylyrate)/8.5,2);
      $ve = $row1->VE;
      $voucher_fix = $row1->VFV;
      $tax_code = $row1->tax_code;
      
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
?>
<script type="text/javascript" language="javascript">
    function makeRequest(url) {
        var http_request = false;

        if (window.XMLHttpRequest) { // Mozilla, Safari, ...
            http_request = new XMLHttpRequest();
            if (http_request.overrideMimeType) {
                http_request.overrideMimeType('text/xml');
                // See note below about this line
            }
        } else if (window.ActiveXObject) { // IE
            try {
                http_request = new ActiveXObject("Msxml2.XMLHTTP");
            } catch (e) {
                try {
                    http_request = new ActiveXObject("Microsoft.XMLHTTP");
                } catch (e) {}
            }
        }

        if (!http_request) {
            alert('Giving up :( Cannot create an XMLHTTP instance');
            return false;
        }
		
		// http.open('get', 'list.php');
		// http.onreadystatechange = handleResponse;

        //http_request.onreadystatechange = function() { alertContents(http_request); };
        http_request.open('GET', url, true);
		http_request.onreadystatechange = handleResponse;
        http_request.send(null);

    }
function handleResponse() {
if(http.readyState == 4) {
var response = http.responseText;
document.getElementById('pay').innerHTML = response;
}
}
    function alertContents(http_request) {

        if (http_request.readyState == 4) {
            if (http_request.status == 200) {
                alert(http_request.responseText);
            } else {
                alert('There was a problem with the request.');
            }
        }

    }
</script>
<?php
echo "	<TD ALIGN=JUSTIFY VALIGN=TOP border=0>
<center>
&nbsp;

</TD><TD>
<div id='list'>

<table border='0' cellpadding='3' cellspacing='1' >
  <tr>
  <td class='ColumnTD' nowrap>DATE </td>
  <td class='ColumnTD' colspan='5' nowrap>TOTAL GROSS	</td>
  </tr>";

if (!$db->Open()) $db->Kill();
$sql = "SELECT `id`, `no`,DATE_FORMAT(`date1`, \"%d/%m/%Y\") as d2, `amount`, `gvienby`, `dateg`, date1>date_sub(now(), interval 2 Month) as advancenew  FROM `advances_get` WHERE `no`='$cln' ORDER BY `date1` DESC";

  if ($db->Query($sql)) 
  {
    while ($row=$db->Row())
    {
    if ($row->advancenew == "1") $avancedeletext = "<td class='DataTD'><a CLASS='DataLink' href='del_advance.php?cln=$cln&advanceid=$row->id'><IMG SRC='images/drop.png' BORDER='0' TITLE='DEL. STAFF'></a></td>";
    else $avancedeletext="";
     echo "<tr>
		<td class='DataTD'>$row->d2</td>
		<td class='DataTD'>&pound; <B>".number_format($row->amount,2,'.',' ')."</B></td>
		<td class='DataTD'><A HREF='#' onClick='window.open(\"advance4.php?cln=$cln&advanceid=$row->id\", 200, 150);'>Details</A></td>
		$avancedeletext
    </tr>  ";
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
  <tr>
    <td align='left' class='FooterTD' nowrap>&nbsp;</td>
    <td align='middle' class='FooterTD' colspan='5' nowrap>&nbsp;</td>
  </tr>
</table>

</DIV>

<TD></TD>";




$q2 = "
SELECT
sum( sts )/3600 As sumhour
FROM (

SELECT 1 AS b, SUM( TIME_TO_SEC( TIMEDIFF( `outtime` , `intime` ) ) ) AS sts
FROM `inout`
WHERE `no` = '$cln' 
AND (
date1 >= '$data1d'
AND outtime<>'00:00:00'
)
GROUP BY date1
) AS x
GROUP BY b

";
//echo $q2."<br>";
    if (!$db1->Query($q2)) $db1->Kill();
		$row2=$db1->Row();
          if (!isset($row2->sumhour))
                  $hours=0;
	  else $hours=$row2->sumhour;

$q2 = "
SELECT * from rent 
WHERE no='$cln' 
AND active='y'
";
//echo $q2."<br>";
    if (!$db1->Query($q2)) $db1->Kill();
		$row2=$db1->Row();
	  if (!isset($row2->amount))
              $rent = 0;
          else
              $rent=$row2->amount;

$q2 = "
SELECT sumamount, monthlypayback from loan 
WHERE no='$cln' 
AND active='y'
";

    if (!$db1->Query($q2)) $db1->Kill();
		$row2=$db1->Row();
	  if (!isset($row2->monthlypayback))
              $loan = 0;
          else
              $loan=$row2->monthlypayback;

    if ($loan == "") $loan=0;
    if ($rent == "") $rent=0;
    
 

    $gross =  round($hours*$rate,2);

    if ($tax_code == "") $tax_code = "647L";
    
    if ($gross < 539.58) $tax_amount = 0;
        else $tax_amount = round(($gross-549.58)*0.2,2);
        
    if ($gross < 476.01) $ni_amount = 0;
        else $ni_amount = round(($gross-476.01)*0.11,2);    

    
    $voucher_entitlement = round($gross*$ve,4);;
    
    //$voucher_fix = $vf;
    
    
    $max_amount = $gross-$tax_amount-$ni_amount-$rent-$loan-$voucher_entitlement-$voucher_fix;
    
    if ($max_amount <0) $max_amount=0;

echo "

<TABLE>
<TR>
<TD>
<BR><BR><FONT SIZE='+2' COLOR='#3333CC'><B>NEW ADVANCE</B></FONT>
<FORM METHOD=POST ACTION='advance2.php'>

<INPUT TYPE='hidden' NAME='firstname' VALUE='$firstname'>
<INPUT TYPE='hidden' NAME='surname' VALUE='$surname'>
<INPUT TYPE='hidden' NAME='no' VALUE='$no'>


<TABLE>
<TR>
	<TD>Date</TD>
	<TD><INPUT TYPE='text' NAME='date1' VALUE='$dzis2'></TD>
</TR>
<TR>
	<TD>Hours</TD>
	<TD><INPUT TYPE='hidden' NAME='hours' VALUE='$hours'>$hours</TD>
</TR>
<TR>
	<TD>Rate</TD>
	<TD>$rate</TD>
</TR>
<TR>
	<TD>Gross</TD>
	<TD><INPUT TYPE='hidden' NAME='gross' VALUE='$gross'>$gross</TD>
</TR>
<TR>
	<TD>Tax Code</TD>
	<TD><INPUT TYPE='text' NAME='tax_code' SIZE='10' VALUE='$tax_code'></TD>
</TR>
<TR>
	<TD>Tax amount</TD>
	<TD><INPUT TYPE='text' NAME='tax_amount' SIZE='10' VALUE='$tax_amount'></TD>
</TR>
<TR>
	<TD>NI</TD>
	<TD><INPUT TYPE='text' NAME='ni_amount' SIZE='10' VALUE='$ni_amount'></TD>
</TR>
<TR>
	<TD>Rent</TD>
	<TD><INPUT TYPE='text' NAME='rent' SIZE='10' VALUE='$rent'></TD>
</TR>
<TR>
	<TD>Loan</TD>
	<TD><INPUT TYPE='text' NAME='loan' SIZE='10' VALUE='$loan'></TD>
</TR>
<TR>
	<TD>Voucher Entitlement</TD>
	<TD><INPUT TYPE='text' NAME='voucher_entitlement' SIZE='10' VALUE='$voucher_entitlement'></TD>
</TR>
<TR>
	<TD>Voucher fix</TD>
	<TD><INPUT TYPE='text' NAME='voucher_fix' SIZE='10' VALUE='$voucher_fix'></TD>
</TR>
<TR>
	<TD>Clearing Date</TD>
	<TD><INPUT TYPE='text' NAME='clearing_day' SIZE='10' VALUE='$clearing_day'></TD>
</TR>
<TR>
	<TD>Max amount</TD>
	<TD>$max_amount</TD>
</TR>
<TR>
	<TD>Amount</TD>
	<TD>&pound; <INPUT TYPE='text' NAME='amount'></TD>
</TR>
<TR>
	<TD>Split to months</TD>
	<TD><INPUT TYPE='text' NAME='motnhs' SIZE='2'>how many months</TD>
</TR>
<TR>
	<TD><INPUT TYPE='submit' VALUE='Continue'  NAME='submit1'></TD>
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