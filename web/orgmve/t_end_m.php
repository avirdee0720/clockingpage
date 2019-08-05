<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
uprstr($PU,90);

echo "

<BR><font class='FormHeaderFont'>End of the month procedures</font><BR><BR>

<center>
<TABLE><TR><TD>

<table width=100% border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
<tr>
    <td class='ColumnTD' nowrap width='300'>$DSNAZWA</td>
    <td class='ColumnTD' nowrap  colspan='2'><font class='FormHeaderFont'>Prepare the database for pay day</font></td>
</tr>
  <tr>
    <td class='DataTD'>$ZLRP21</td>
    <td class='DataTD'><A HREF='check_pr.php'>$OKBTN</A></td>
    <td class='DataTD'>$ZLRP21o</td>
</tr>
<tr>
    <td class='DataTD'>$ZLRP2</td>
    <td class='DataTD'><A HREF='ttp_date.php'>$OKBTN</A></td>
    <td class='DataTD'>$ZLRP2o</td>
</tr>
<tr>
    <td class='DataTD'>$ZLRP35</td>
    <td class='DataTD'><A HREF='holid_countver4a.php'>$OKBTN</A></td>
    <td class='DataTD'>Count holidays days ver 4</td>
</tr>
</table>

</TD></TR><TR><TD> <!-- second table -->

<table width=100% border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
<tr>
    <td class='ColumnTD' nowrap width='300'>$DSNAZWA</td>
    <td class='ColumnTD' nowrap  colspan='2'><font class='FormHeaderFont'>Count Pay section</font></td>
</tr>
<tr>
	 <td class='DataTD'>$ZLRP40</td>
    <td class='DataTD'><A HREF='gross_pay.php'>$OKBTN</A></td>
    <td class='DataTD'>$ZLRP40o</td>
</tr>
<tr>
	 <td class='DataTD'>$ZLRP46</td>
    <td class='DataTD'><A HREF='wend_ls_all.php'>$OKBTN</A></td>
    <td class='DataTD'>$ZLRP46o</td>
</tr>
<tr>
	 <td class='DataTD'>$ZLRP36</td>
    <td class='DataTD'><A HREF='punc_bonus.php'>$OKBTN</A></td>
    <td class='DataTD'>$ZLRP36o</td>
</tr>
<tr>
	 <td class='DataTD'>$ZLRP41</td>
    <td class='DataTD'><A HREF='punc_penalty.php'>$OKBTN</A></td>
    <td class='DataTD'>$ZLRP41o</td>
</tr>
<tr>
	 <td class='DataTD'>$ZLRP37</td>
    <td class='DataTD'><A HREF='wend_bonus.php'>$OKBTN</A></td>
    <td class='DataTD'>$ZLRP37o</td>
</tr>
<tr>
	 <td class='DataTD'>$ZLRP42</td>
    <td class='DataTD'><A HREF='bhm_bonus.php'>$OKBTN</A></td>
    <td class='DataTD'>$ZLRP42o</td>
</tr>
<tr>
	 <td class='DataTD'>$ZLRP44</td>
    <td class='DataTD'><A HREF='wend_lumpsum.php'>$OKBTN</A></td>
    <td class='DataTD'>$ZLRP44o</td>
</tr>
<tr>
	 <td class='DataTD'>$ZLRP47</td>
    <td class='DataTD'><A HREF='gross_pay-all.php'>$OKBTN</A></td>
    <td class='DataTD'>$ZLRP47o</td>
</tr>
<!-- vouchers -->
<tr>
	 <td class='DataTD'>$ZLRP43</td>
    <td class='DataTD'><A HREF='voucherpay.php'>$OKBTN</A></td>
    <td class='DataTD'>$ZLRP43o</td>
</tr>
</table>

</TD></TR><TR><TD> <!-- third table -->
<table width=100% border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
<tr>
    <td class='ColumnTD' nowrap width='300'>$DSNAZWA</td>
    <td class='ColumnTD' nowrap  colspan='2'><font class='FormHeaderFont'>Export section</font></td>
</tr>
<tr>
	 <td class='DataTD'>$ZLRP48</td>
    <td class='DataTD'><A HREF='payexports.php'>$OKBTN</A></td>
    <td class='DataTD'>$ZLRP48o</td>
</tr>
</table>
</TD></TR>

<TR><TD> <!-- FOURTH table -->
<table width=100% border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
<tr>
    <td class='ColumnTD' nowrap width='300'>$DSNAZWA</td>
    <td class='ColumnTD' nowrap colspan='2'><font class='FormHeaderFont'>Vouchers Section</font></td>
</tr>
<tr>
    <td class='DataTD'>Upload of vouchers data</td>
    <td class='DataTD'><A HREF='vouchersupload.php'>$OKBTN</A></td>
    <td class='DataTD'>Upload file</td>
</tr>
<tr>
    <td class='DataTD'>Vouchers generation</td>
    <td class='DataTD'><A HREF='vouchers_generation-1.php'>$OKBTN</A></td>
    <td class='DataTD'>Generate vouchers PDF</td>
</tr>
<tr>
    <td class='DataTD'>Vouchers modification</td>
    <td class='DataTD'><A HREF='vouchers_modif.php'>$OKBTN</A></td>
    <td class='DataTD'>Manage uploaded voucher files and PDFs</td>
</tr>
</table>

</TD></TR>



</TABLE>

</center>
<BR>

";

?>