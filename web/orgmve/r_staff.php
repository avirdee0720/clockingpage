<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
uprstr($PU,90);
//print_r ($_COOKIE);
$name=$_COOKIE['nazwa'];
echo "

<BR><font class='FormHeaderFont'>Reports - Staff Module</font><BR><BR>

<center>
<TABLE><TR><TD>

<table width=100% border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
<tr>
	 <td class='DataTD'>Regular's contact details - post one year</td>
    <td class='DataTD'><A HREF='srp04.php'>$OKBTN</A></td>
    <td class='DataTD'>$SRP04o</td>
</tr>
<tr>
	 <td class='DataTD'>Regular's contact details</td>
    <td class='DataTD'><A HREF='srp05.php'>$OKBTN</A></td>
    <td class='DataTD'>$SRP05o</td>
</tr>
<tr>
	 <td class='DataTD'>Casual's contact details</td>
    <td class='DataTD'><A HREF='srp06.php'>$OKBTN</A>&nbsp;</td>
    <td class='DataTD'>$SRP06o</td>
</tr>
<tr>
	 <td class='DataTD'>Unpaid's contact details</td>
    <td class='DataTD'><A HREF='srp07.php'>$OKBTN</A>&nbsp;</td>
    <td class='DataTD'>$SRP06o</td>
</tr>
<tr>
	 <td class='DataTD'>$ZLRP55</td>
    <td class='DataTD'><A HREF='r_security.php'>$VIEWBTN</A></td>
    <td class='DataTD'>$ZLRP55o</td>
</tr>
<tr>
	 <td class='DataTD'>$ZLRP56</td>
    <td class='DataTD'><A HREF='r_cl.php'>$VIEWBTN</A></td>
    <td class='DataTD'></td>
</tr>";
if ($name == "Payroll" || $name == "Egert Simson") {
echo "
<tr>
	 <td class='DataTD'>$ZLRP57</td>
    <td class='DataTD'><A HREF='r_paystru.php'>$VIEWBTN</A></td>
    <td class='DataTD'>$ZLRP57o</td>
</tr>";

}
echo "
<tr>
	 <td class='DataTD'>Absentees</td>
    <td class='DataTD'><A HREF='hrnoclock1m.php'>$OKBTN</A></td>
    <td class='DataTD'></td>
</tr>
<tr>
	 <td class='DataTD'>Staff attendance</td>
    <td class='DataTD'><A HREF='listworkhourdayavga.php'>$OKBTN</A></td>
    <td class='DataTD'></td>
</tr>
<tr>
        <td class='DataTD'>Export raw clocking data to Excel</td>
    <td class='DataTD'><A HREF='clockingdata_export1.php'>$OKBTN</A></td>
    <td class='DataTD'></td>
</tr>
<tr>
	 <td class='DataTD'>Staff Weekend attendance [Last year]</td>
    <td class='DataTD'><A HREF='listworkhourweekenddayavga.php'>$OKBTN</A></td>
    <td class='DataTD'></td>
</tr>
";

echo "
<tr>
	 <td class='DataTD'>Email to Employees</td>
    <td class='DataTD'><A HREF='email_sending_all.php'>$OKBTN</A></td>
    <td class='DataTD'></td>
</tr>
";

if (($_COOKIE["id"]=="93") || ($_COOKIE["id"]=="50") || ($_COOKIE["id"]=="53")  || ($_COOKIE["id"]=="26")  || ($_COOKIE["id"]=="67" ) || ($_COOKIE["id"]=="74" ) || ($_COOKIE["id"]=="75" ) || ($_COOKIE["id"]=="85" ) || ($_COOKIE["id"]=="91" )) {
echo "
<tr>
	 <td class='DataTD'>Post two years Staff</td>
    <td class='DataTD'><A HREF='hrrlist_post2y_edit_choose.php' target='_Blank'>$OKBTN</A></td>
    <td class='DataTD'></td>
</tr>
<tr>
	 <td class='DataTD'>Pre two years Staff</td>
    <td class='DataTD'><A HREF='hrrlist_pre2y_edit_choose.php' target='_Blank'>$OKBTN</A></td>
    <td class='DataTD'></td>
</tr>
<tr>
	 <td class='DataTD'>All Staff</td>
    <td class='DataTD'><A HREF='hrrlist_all_edit_choose.php' target='_Blank'>$OKBTN</A></td>
    <td class='DataTD'></td>
</tr>
<tr>
	 <td class='DataTD'>Opinion list</td>
    <td class='DataTD'><A HREF='hropinionlist_all_edit_choose.php' target='_Blank'>$OKBTN</A></td>
    <td class='DataTD'></td>
</tr>
<tr>
	 <td class='DataTD'>HR List with pictures</td>
    <td class='DataTD'><A HREF='hrpicturelist_choose.php' target='_Blank'>$OKBTN</A></td>
    <td class='DataTD'></td>
</tr>
<tr>
	 <td class='DataTD'>Regular day list</td>
    <td class='DataTD'><A HREF='hrregulardaylist_all_edit_choose.php' target='_Blank'>$OKBTN</A></td>
    <td class='DataTD'></td>
</tr>
<tr>
	 <td class='DataTD'>Extra reports</td>
    <td class='DataTD'><A HREF='hr_extra_report.php' target='_Blank'>$OKBTN</A></td>
    <td class='DataTD'></td>
</tr>
<tr> 
	 <td class='DataTD'>Average attendance weekend days 0.75</td>
    <td class='DataTD'><A HREF='averweekend1c.php' target='_Blank'>$OKBTN</A></td>
    <td class='DataTD'></td>
</tr>
<tr>
	 <td class='DataTD'>Average Attendances (All days)</td>
    <td class='DataTD'><A HREF='averweek1a.php' target='_Blank'>$OKBTN</A></td>
    <td class='DataTD'></td>
</tr>
<tr>
	 <td class='DataTD'>Average Attendances (All days inc days off)</td>
    <td class='DataTD'><A HREF='averweek1c.php' target='_Blank'>$OKBTN</A></td>
    <td class='DataTD'></td>
</tr>
<tr>
	 <td class='DataTD'>Average Attendances (Week days: Mon-Fri inc days off)</td>
    <td class='DataTD'><A HREF='averweekdays1a.php' target='_Blank'>$OKBTN</A></td>
    <td class='DataTD'></td>
</tr>
<tr>
	 <td class='DataTD'>Average 0.75 weekend days per week required: non-qualifiers below 0.75</td>
    <td class='DataTD'><A HREF='aver0_7weekend_b0_7_1.php' target='_Blank'>$OKBTN</A></td>
    <td class='DataTD'></td>
</tr>
<tr>
	 <td class='DataTD'>Punctuality reports</td>
    <td class='DataTD'><A HREF='punctuality1.php' target='_Blank'>$OKBTN</A></td>
    <td class='DataTD'></td>
</tr>
<tr>
	 <td class='DataTD'>Last Day Worked - Casuals</td>
    <td class='DataTD'><A HREF='last_day_work_cas.php' target='_Blank'>$OKBTN</A></td>
    <td class='DataTD'></td>
</tr>
<tr>
	 <td class='DataTD'>Stefano's reports</td>
    <td class='DataTD'><A HREF='hr_report_stefano.php' target='_Blank'>$OKBTN</A></td>
    <td class='DataTD'></td>
</tr>
<tr>
	 <td class='DataTD'>Knowledge List</td>
    <td class='DataTD'><A HREF='knowledge_list_choose.php' target='_Blank'>$OKBTN</A></td>
    <td class='DataTD'></td>
</tr>
<tr>
	 <td class='DataTD'>Keys List</td>
    <td class='DataTD'><A HREF='keys_list_choose.php' target='_Blank'>$OKBTN</A></td>
    <td class='DataTD'></td>
</tr>
<tr>
	 <td class='DataTD'>Accomodation offset report</td>
    <td class='DataTD'><A HREF='accomodation_offset1.php' target='_Blank'>$OKBTN</A></td>
    <td class='DataTD'></td>
</tr>
<tr>
	 <td class='DataTD'>No Email addresses</td>
    <td class='DataTD'><A HREF='no_emailaddress1.php' target='_Blank'>$OKBTN</A></td>
    <td class='DataTD'></td>
</tr>
<tr>
	 <td class='DataTD'>Email addresses</td>
    <td class='DataTD'><A HREF='emailaddress1.php' target='_Blank'>$OKBTN</A></td>
    <td class='DataTD'></td>
</tr>
<tr>
	 <td class='DataTD'>Holidays accrued or agreed to as of today</td>
    <td class='DataTD'><A HREF='hr_list_holiday.php' target='_Blank'>$OKBTN</A></td>
    <td class='DataTD'></td>
</tr>
<tr>
	 <td class='DataTD'>Average Attendances (Weekend days Transitional)</td>
    <td class='DataTD'><A HREF='averweekend1e.php' target='_Blank'>$OKBTN</A></td>
    <td class='DataTD'></td>
</tr>
"; 

}

echo "
</table>
</TD></TR></TABLE>

</center>
<BR>

";

?>