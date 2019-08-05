<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];

if (!isset($_POST['state'])) $state = 0; else $state = $_POST['state'];
if (!isset($_POST['year'])) $year = 0; else $year = $_POST['year'];
if (!isset($_POST['month'])) $month = 0; else $month = $_POST['month'];

if ($state == 0) {

    $YearsSelectHtml = Yearsselect();
    $MonthsSelectHtml = Monthsselect();

    echo "
    <font class='FormHeaderFont'>Export clocking data to Excel</font>
    <BR>

    <form action='$PHP_SELF' method='post' name='addholliday'>
    <table WIDTH=300 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >
    <tr>
        <td class='FieldCaptionTD'><B>Year</B></td>
        <td class='FieldCaptionTD'><select class='Select' name='year'>$YearsSelectHtml</select></td>
    </tr>     
    <tr>
        <td class='FieldCaptionTD'><B>Month</B></td>
        <td class='FieldCaptionTD'><select class='Select' name='month'>$MonthsSelectHtml</select></td>
    </tr>
    </table>
    <input name='state' type='hidden' value='1'>
    <input class='Button' name='Update' type='submit' value='Export'>
    </center>
    </FORM>
    </td></tr>
    </table>";

    include_once("./footer.php");

}

elseif ($state == 1) {
    
    echo "<script language='javascript'>window.location=\"clockingdata_export2.php?month=$month&year=$year\"</script>";

} //if state=1

else {
    echo "<BR>What are you doing? (IP: $REMOTE_ADDR)<BR>";
} //else state

?>
