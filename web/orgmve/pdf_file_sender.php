<?php    // Demo - send a (binary) file

include("./config.php");

//include_once("./header.php");

$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$db1 = new CMySQL;
$db2 = new CMySQL;

if (!$db->Open()) $db->Kill();
if (!$db1->Open()) $db1->Kill();
if (!$db2->Open()) $db1->Kill();

$pvno=$_GET['pvno'];


$file = "payslips_vouchers_all/20110202/payslips_1837_17012011_18_55_1.pdf";
$fp = fopen($file,"r") ;

header( "Content-type: application/pdf");
header('Content-Disposition: attachment; filename="downloaded.pdf"');

while (! feof($fp)) {
       $buff = fread($fp,4096);
       print $buff;
       }
?>