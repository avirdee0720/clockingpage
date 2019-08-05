<?php
include("./config.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$db2 = new CMySQL;

(!isset($_GET['month'])) ? $month = date("m") : $month = $_GET['month'];
(!isset($_GET['year'])) ? $year = date("Y") : $year = $_GET['year'];

function download_send_headers($filename) {
    header("Content-type: allpication/ms-excel");
    header("Content-Disposition: attachment; filename={$filename}");
    header("Pragma: no-cache");
    header("Expires: 0");
}

download_send_headers("ClockingData_".$month."-".$year.".xls");
    
//Header
echo "ClNo\tDate\tDayname\tIntime\tOuttime\n";

//query for basic data
if (!$db->Open()) $db->Kill();
$q = "SELECT `inout`.`no`, DATE_FORMAT( `inout`.`date1`, \"%d/%m/%y\" ) AS date1, DAYNAME(`inout`.`date1`) AS dayname, `inout`.`intime`, `inout`.`outtime`
      FROM `inout`
      WHERE MONTH(`inout`.`date1`) = '$month'
      AND YEAR(`inout`.`date1`) = '$year'
      ORDER BY `id` ASC";


if ($db->Query($q)) {
    while ($row=$db->Row()) {
        
        echo "$row->no\t$row->date1\t$row->dayname\t$row->intime\t$row->outtime\n";
                       
            
             
    } //while
    
    
} //if query true
else echo "Error in the query!";


?>
