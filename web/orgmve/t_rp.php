<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
uprstr($PU,90);

$name=$_COOKIE['nazwa'];

echo "

<BR><font class='FormHeaderFont'>$BTNWYDR</font><BR>

<center>
<table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
<tr>
    <td class='ColumnTD' nowrap>$DSNAZWA</td>
    <td class='ColumnTD' nowrap>&nbsp;</td>
    <td class='ColumnTD' nowrap>$RPNOPIS</td>
</tr>
 <tr>
    <td class='DataTD'>$ZLRP1</td>
    <td class='DataTD'><A HREF='t_r_ti.php'>$VIEWBTN</A></td>
    <td class='DataTD'>$ZLRP1o</td>
</tr>
<tr>
    <td class='DataTD'>$ZLRP51</td>
    <td class='DataTD'><A HREF='940apr1.php'>$VIEWBTN</A></td>
    <td class='DataTD'>$ZLRP51o</td>
</tr>
<tr>
    <td class='DataTD'>$ZLRP4</td>
    <td class='DataTD'><A HREF='t_r_et.php'>$VIEWBTN</A></td>
    <td class='DataTD'>$ZLRP4o</td>
</tr>
<tr>
    <td class='DataTD'>$ZLRP7</td>
    <td class='DataTD'><A HREF='1030pd1.php'>$VIEWBTN</A></td>
    <td class='DataTD'>$ZLRP7o</td>
</tr>
<tr>
    <td class='DataTD'>$ZLRP8</td>
    <td class='DataTD'><A HREF='0hours1.php'>$VIEWBTN</A></td>
    <td class='DataTD'>$ZLRP8o</td>
</tr>
<tr>
    <td class='DataTD'>$ZLRP10</td>
    <td class='DataTD'><A HREF='3hours1.php'>$VIEWBTN</A></td>
    <td class='DataTD'>$ZLRP10o</td>
</tr>
<tr>
    <td class='DataTD'>$ZLRP11</td>
    <td class='DataTD'><A HREF='r_h_d1.php'>$VIEWBTN</A></td>
    <td class='DataTD'>$ZLRP11o</td>
</tr>
<tr>
    <td class='DataTD'>$ZLRP15</td>
    <td class='DataTD'><A HREF='entitlement1.php'>$VIEWBTN</A></td>
    <td class='DataTD'>$ZLRP15o</td>
</tr>
<tr>
    <td class='DataTD'>$ZLRP23</td>
    <td class='DataTD'><A HREF='r_leavers1.php'>$VIEWBTN</A></td>
    <td class='DataTD'>$ZLRP23o</td>
</tr>
<tr>
    <td class='DataTD'>$ZLRP24</td>
    <td class='DataTD'><A HREF='r_starters1.php'>$VIEWBTN</A></td>
    <td class='DataTD'>$ZLRP24o</td>
</tr>
<tr>
    <td class='DataTD'>$ZLRP49</td>
    <td class='DataTD'><A HREF='punc_time.php'>$VIEWBTN</A></td>
    <td class='DataTD'>$ZLRP49o</td>
</tr>
<tr>
    <td class='DataTD'>$ZLRP54</td>
    <td class='DataTD'><A HREF='r_advance1.php'>$VIEWBTN</A></td>
    <td class='DataTD'>$ZLRP54o</td>
</tr>";
if ($name == "Payroll" || $name == "Egert Simson") {
echo "
<tr>
    <td class='DataTD'>$ZLRP57</td>
    <td class='DataTD'><A HREF='r_paystru.php'>$VIEWBTN</A></td>
    <td class='DataTD'>$ZLRP57o</td>
</tr>
<tr>
    <td class='DataTD'>$ZLRP58</td>
    <td class='DataTD'><A HREF='r-det-os.php'>$VIEWBTN</A></td>
    <td class='DataTD'>$ZLRP58o</td>
</tr>";
}
echo "
<tr>
    <td class='DataTD'>$ZLRP60</td>
    <td class='DataTD'><A HREF='averweek.php'>$VIEWBTN</A></td>
    <td class='DataTD'>$ZLRP60o</td>
</tr><tr>
    <td class='DataTD'>Email addresses</td>
    <td class='DataTD'><A HREF='emailaddress1.php' target='_Blank'>$OKBTN</A></td>
    <td class='DataTD'></td>
</tr>
<tr>
    <td class='DataTD'>Staff status update</td>
    <td class='DataTD'><A HREF='staffsettings.php' target='_Blank'>$VIEWBTN</A></td>
    <td class='DataTD'>Update staff status OK/LEAVER</td>
</tr>
<tr>
    <td class='DataTD'>Holidays entitlement/accrued</td>
    <td class='DataTD'><A HREF='hr_list_holiday_choose.php' target='_Blank'>$VIEWBTN</A></td>
    <td class='DataTD'>Update staff status OK/LEAVER</td>
</tr>
<tr>
    <td align='left' class='FooterTD' nowrap> &nbsp;</td>
    <td align='middle' class='FooterTD' colspan='4' nowrap>&nbsp;</td>
  </tr>

</table>

</center>
<BR>
</td></tr>
</table>
";

?>