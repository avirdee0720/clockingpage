<?php   

//query like this: localhost/orgmve/voucherpdf.php?vsha1=2a4d6ebba510d34ae34841cb15cb9c31d1f96aa4

include("./inc/mysql.inc.php");

$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;

if (!$db->Open()) $db->Kill();

if (!isset($_GET['vsha1']))
    $vouchers_sha1code = "";
else
    $vouchers_sha1code = $_GET['vsha1'];

if ($vouchers_sha1code != "") {

    $q = "SELECT * FROM `voucherslips`
    WHERE `vouchers_sha1code` = '$vouchers_sha1code'";

    if (!$db->Query($q)) $db->Kill();    
    $row=$db->Row();
    $rows=$db->Rows();
        
    if ($rows == 1) {
        $vouchers_filename = $row->vouchers_filename;
        //echo "$vouchers_filename";
        $pdffile=$row->vouchers_file;
                        
        header("Content-type: application/pdf");
        header('Content-Disposition: attachment; filename="'.$vouchers_filename.'"');

        echo $pdffile;
        
        echo "<script language='javascript'>window.close();</script>";

    }
    
    else {
        echo "This sha1 code does not exits in the database!";
    }
        
}

else {    
    echo "Voucers sha1code is not set...";
}
       
?>