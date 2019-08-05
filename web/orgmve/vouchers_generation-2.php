<?php
ini_set("display_errors","2");
include("./config.php");

include_once("./header.php");
require('./tcpdf/tcpdf.php');
//date_default_timezone_set('Europe/London');
$PHP_SELF = $_SERVER['PHP_SELF'];
$db1 = new CMySQL;
$db2 = new CMySQL;

if (!$db1->Open()) $db1->Kill();
if (!$db2->Open()) $db2->Kill();

uprstr($PU,90);
$dataakt=date("d/m/Y H:i:s");
$msgdb = new CMySQL;

$pvno=$_GET['pvno'];

$current_dir = getcwd();
$password = "";

$title="Vouchers";

echo "<br><b>Welcome to Vouchers Generator page!</b><br>";

$q = "SELECT `id`, `month_id`, `no`, `knownas`, `surname`, `month`, `vouchers`
FROM `voucherslips` WHERE `vouchers` != '0' AND `month_id` = '$pvno'";

if ($db1->Query($q)) {
    
    while ($row=$db1->Row()) {        
            
        echo "I am generating voucher PDF for ".$row->knownas." - ".$row->month;
                
        // Voucher PDF Generation
        
        $pdfv = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true,'UTF-8', false); 
      
        $pdfv->SetCreator(PDF_CREATOR);
        $pdfv->SetAuthor('Music And Goods Exchange Ltd.');
        $pdfv->SetTitle('Voucher: '.$row->no.', '.$row->knownas);
        $pdfv->SetSubject('Voucher');
        $pdfv->SetKeywords('Music And Goods Exchange Ltd., voucher, '.$row->no.', '.$row->knownas.', ');

        $pdfv->SetProtection($permissions=array('copy','modify','annot-forms','fill-forms','extract','assemble'), $user_pass=$password, $owner_pass=null, $mode=1, $pubkeys=null);
          
        $pdfv->SetMargins(0,0);
        $pdfv->setPrintHeader(false);
        $pdfv->setPrintFooter(false);
        $pdfv->SetCellPadding(0);
        $pdfv->SetAutoPageBreak(FALSE, PDF_MARGIN_BOTTOM);
      
   
        // Size of payslip: 210 - 99 mm      
        $pdfv->AddPage("L",array(88,53));
        $pdfv->setCellPaddings(0, 0, 0, 0);
        $pdfv->SetDrawColor(0,0,0);
      
        $pdfv->SetTextColor(0, 0, 0);
      
        $amount = "£ ".number_format($row->vouchers, 2, '.', '');        
        //$amount = iconv('iso-8859-1', 'utf-8', "£")." ".number_format($row->vouchers, 2, '.', '');
        
        //  'Helvetica'        
        $pdfv->SetFont( 'Times' , "BU", 15);
        $pdfv->SetTextColor(255, 255, 255);
        $pdfv->MultiCell(88, 52, " \n \n \n \n \n \n  \n \n", 1, 'L', 0, 0, 0, 0, true, 0, false, true, 0, 'T');
        $pdfv->SetTextColor(0, 0, 0);
        $pdfv->MultiCell(88, 10, "Voucher Entitlement For ".$row->month, 0, 'L', 0, 0, 1, 0, true, 0, false, true, 0, 'M');
        $pdfv->SetFont( 'Times' , "B", 15);
        $pdfv->MultiCell( 88, 10, $row->no." ".$row->knownas." ".$row->surname, 0, 'L', 0, 0, 1, 8, true, 0, false, true, 0, 'M');
        $pdfv->SetFont('Helvetica', "", 12); 
        $pdfv->MultiCell( 88, 10, "CASHED IN TILL AT SHOP .....................", 0, 'L', 0, 0, 1, 16, true, 0, false, true, 0, 'M'); 
        $pdfv->MultiCell( 88, 10, "ON ....../....../...... ", 0, 'L', 0, 0, 1, 24, true, 0, false, true, 0, 'M'); 
        $pdfv->SetFont( 'Times' , "B", 14); 
        $pdfv->MultiCell( 88, 10, "AMOUNT $amount", 0, 'L', 0, 0, 1, 32, true, 0, false, true, 0, 'M');
        $pdfv->SetFont( 'Times' , "", 12);
        $pdfv->MultiCell( 88, 10, "Authorised by .................................", 0, 'L', 0, 0, 1, 40, true, 0, false, true, 0, 'M'); 
        $pdfv->SetFont( 'Times' , "", 8);
        $pdfv->MultiCell( 88, 8, "This slip is to be exchanged for vouchers and sent to accounts.", 0, 'L', 0, 0, 1, 48, true, 0, false, true, 0, 'M');
      
        // Vouchers PDF Generation - END
              
        // Save PDF version
        $myFile_vouchers = "vouchers_".$row->no."_".$row->month_id.".pdf";
   
        $vouchers_file = $pdfv->Output("", 'S');
        $vouchers_sha1code =sha1($vouchers_file);
    
        unset($pdfv);
 
        // Save Files into the database
        $vouchers_file = addslashes($vouchers_file);
        $upd = "UPDATE `voucherslips`
        SET `vouchers_state`='1', `vouchers_filename`='$myFile_vouchers', `vouchers_file`='$vouchers_file', `vouchers_sha1code`='$vouchers_sha1code', `vouchers_time`='$dataakt'
        WHERE `id`='$row->id' LIMIT 1";
        if (!$db2->Query($upd)) $db2->Kill();
        echo " --> OK<br>";
    
    }   
    
}
else
    echo "Error during the Voucher PDF generation!";


echo "
</table>
</center>
<BR>

</td></tr>
</table>";
include_once("./footer.php");
 
?>