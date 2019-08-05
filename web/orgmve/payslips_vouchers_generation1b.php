<HTML>
<HEAD>
<?php
include("./config.php");

include_once("./header.php");
require('./tcpdf/tcpdf.php');
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$db1 = new CMySQL;
$db2 = new CMySQL;

if (!$db->Open()) $db->Kill();
if (!$db1->Open()) $db1->Kill();
if (!$db2->Open()) $db2->Kill();

uprstr($PU,90);
$dataakt=date("d/m/Y H:i:s");
$msgdb = new CMySQL;


//list($day, $month, $year) = explode("/",$_GET['startd']);

$output = "";
$mail_sent = false;

$payslipsmonth = array ("January","February","March","April","May","June","July","August","September","October","November","December");

$date1 = date("Ymd"); 
$date2 = date("H_i");
$time1 = time();
//$date2 = "A";

if (!isset($_POST['_pvno'])) {
    if (!isset($_GET['pvno'])) $pvno = ""; else $pvno = $_GET['pvno'];    
}
else $pvno = $_POST['_pvno'];

echo "PVNO:$pvno";

if (!isset($_POST['cid'])) {
    if (!isset($_GET['cid'])) $cid = ""; else $cid = $_GET['cid'];    
}
else $cid = $_POST['cid'];

echo "CID:$cid";

$current_dir = getcwd();

?>
<meta HTTP-EQUIV='cache-control' CONTENT='no-cache, must-revalidate'>
<link rel=stylesheet type=text/css href="hs.css">
<LINK REL='stylesheet' HREF='style/multipads/style.css' TYPE='text/css'>

</HEAD>

<body class=PageBODY bgcolor=#FFFFFF topmargin=0 leftmargin=0 marginwidth=0 marginheight=0 text=#000000 link=#0000FF vlink=#0000FF alink=#FF0000>
<CENTER>

<?php


$title="Payslips - Vouchers";

echo "<br><b>Welcome to Payslips Generator page!</b><br>";

 

$q = "SELECT payslips_vouchers_no.pvno, payslips_vouchers_no.date1,payslips_vouchers_no.pvfolder,
payslips_vouchers.id, payslips_vouchers.no,payslips_vouchers.status,payslips_vouchers.payslipstype,payslips_vouchers.payslipsno,payslips_vouchers.vouchersno,payslips_vouchers.payslips_filename
FROM  payslips_vouchers_no INNER JOIN payslips_vouchers ON payslips_vouchers_no.pvno=payslips_vouchers.pvno
Where payslips_vouchers_no.pvno='$pvno'
";

//$q=$q.$sortowanie;



if ($db->Query($q)) 
  {
  

// Folders
     $upd = "UPDATE `payslips_vouchers_no` SET pvfolder='payslips_vouchers_all/$date1' WHERE `pvno`='$pvno' Limit 1";
     if (!$db2->Query($upd)) $db2->Kill();  
  
    while ($row=$db->Row())
    {
    $no=$row->no;
    $id=$row->id;
    $password = "";
    $payslipsno=$row->payslipsno;
    $vouchersno=$row->vouchersno;
    $status=$row->status;
    $payslipstype=$row->payslipstype;         
    $payslips_filename = "";
    $vouchers_filename = "";
    
    if ($payslipstype == "67") {$tc = 0;} // Type column
    else  {$tc = 1;} 
    
      $q = "SELECT payslips_value.valuenumber, payslips_value.value
FROM  payslips_vouchers INNER JOIN payslips_value ON payslips_vouchers.id=payslips_value.pvid
Where payslips_vouchers.id='$id'
Order by valuenumber ASC
";

// AND payslips_state='1'
    
    if ($db1->Query($q)) 
    {
  
    // Payslips Generation
     $payslips=Array();
    while ($row1=$db1->Row())
    {
      if ($row1->value != "") {
      $payslips[$row1->valuenumber]=$row1->value;
      }
      else $payslips[$row1->valuenumber]="";
    }
     list($day, $month, $year) = explode("/",$payslips[61+$tc]);
     
      echo "<br>Payslips: I am creating: ". $payslips[66+$tc]. " - ".$payslips[65+$tc]. " - ".$payslips[61+$tc]. " - ".$payslipsmonth[$month-1];
  // PDF Generation
  
  
       $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true); 
      
      $pdf->SetCreator(PDF_CREATOR);
      $pdf->SetAuthor('Music And Goods Exchange Ltd.');
      $pdf->SetTitle('Payslips: '.$payslips[65].', '.$payslips[61]);
      $pdf->SetSubject('Payslips');
      $pdf->SetKeywords('Music And Goods Exchange Ltd., Payslips, '.$payslips[65].', '.$payslips[61].",$time1,  ");

      //$pdf->SetProtection($permissions=array('print', 'copy'), $user_pass='', $owner_pass=null, $mode=0, $pubkeys=null);
      $pdf->SetProtection($permissions=array('copy','modify','annot-forms','fill-forms','extract','assemble'), $user_pass=$password, $owner_pass=null, $mode=1, $pubkeys=null);
    
      $pdf->SetMargins(0,0);
      $pdf->setPrintHeader(false);
      $pdf->setPrintFooter(false);
      $pdf->SetCellPadding(0);
      $pdf->SetAutoPageBreak(FALSE, PDF_MARGIN_BOTTOM);
      
   //    $pdf->setCellHeightRatio(1.25);
   //  $pdf->setImageScale(0.47);

      // Size of payslip: 210 - 99 mm
      
      $pdf->AddPage("L",array(210,99));
   //   $pdf->SetFont('arialunicid0', "B", 6);
   //$pdf->SetFont('Times')
      $pdf->SetFont('Times', "B", 11);
   
      // output the HTML content
      
  //    $pdf->writeHTML($output, true, false, true, false, '');
 
      // MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)

      $pdf->SetDrawColor(0,128,0); // Bordercolor
      
      $pdf->SetTextColor(0, 0, 0);
         
      // set color for background  - 1
      $pdf->SetFillColor(192, 220, 192);

     // $pdf->MultiCell(55, 40, '[VERTICAL ALIGNMENT - MIDDLE] '.$txt, 1, 'J', 1, 0, '', '', true, 0, false, true, 40, 'M');
      
      $pdf->setCellPaddings(2, 2, 2, 2);
      $pdf->MultiCell(207, 8, $payslips[0], 1, 'C', 1, 0, 2, 8, true, 0, false, true, 0, 'M');
      
      $pdf->setCellPaddings(1, 1, 1, 1);
      
      $pdf->SetFont('Times', "B", 8);
      $pdf->MultiCell( 91, 6, "Department ".$payslips[1]." - ".$payslips[2], 1, 'L', 1, 0, 2, 20, true, 0, false, true, 0, 'M'); 
      $pdf->MultiCell( 57, 6, "Payment Method - ".$payslips[3], 1, 'L', 1, 0, 94, 20, true, 0, false, true, 0, 'M'); 
      $pdf->MultiCell( 57, 6, "Payment Period - ".$payslips[4], 1, 'L', 1, 0, 152, 20, true, 0, false, true, 0, 'M'); 
    //  'arialunicid0'
      $pdf->SetFont('Times', "", 7);
      // 48 - 50
      $pdf->MultiCell( 30, 48, $payslips[5]."\n".$payslips[11]."\n".$payslips[17]."\n".$payslips[22]."\n".$payslips[27]."\n".$payslips[32+$tc]."\n".$payslips[36+$tc]."\n".$payslips[42+$tc]."\n", 1, 'L', 1, 0, 2, 30, true, 0, false, true, 0, 'M'); 
      $pdf->MultiCell( 20, 48, $payslips[6]."\n".$payslips[12]."\n".$payslips[18]."\n".$payslips[23]."\n".$payslips[28]."\n".$payslips[33+$tc]."\n".$payslips[37+$tc]."\n".$payslips[43+$tc]."\n", 1, 'R', 1, 0, 32, 30, true, 0, false, true, 0, 'M'); 
      $pdf->MultiCell( 20, 48, $payslips[7]."\n".$payslips[13]."\n".$payslips[19]."\n".$payslips[24]."\n".$payslips[29]."\n".$payslips[34+$tc]."\n".$payslips[38+$tc]."\n".$payslips[44+$tc]."\n", 1, 'R', 1, 0, 52, 30, true, 0, false, true, 0, 'M');
      if ($tc==0) {
      $pdf->MultiCell( 21, 48, $payslips[8]."\n".$payslips[14]."\n".$payslips[20]."\n".$payslips[25]."\n".$payslips[30]."\n".$payslips[35+$tc]."\n".$payslips[39+$tc]."\n".$payslips[45+$tc]."\n", 1, 'R', 1, 0, 72, 30, true, 0, false, true, 0, 'M');
      
      $pdf->MultiCell( 27, 48, "PAYE Tax\nNational Insurance\n\n\n\n\n".$payslips[40+$tc]."\n".$payslips[46+$tc]."\n".$payslips[48+$tc]."\n".$payslips[51+$tc]."\n", 1, 'L', 1, 0, 94, 30, true, 0, false, true, 0, 'M'); 
      $pdf->MultiCell( 30, 48, $payslips[9]."\n".$payslips[15]."\n\n\n\n\n".$payslips[41+$tc]."\n".$payslips[47+$tc]."\n".$payslips[49+$tc]."\n".$payslips[52+$tc]."\n", 1, 'R', 1, 0, 121, 30, true, 0, false, true, 0, 'M'); 
        }
        
      elseif (trim($payslips[66+$tc])=='2055') {
      $pdf->MultiCell( 30, 48, $payslips[5]."\n".$payslips[11]."\n".$payslips[17]."\n".$payslips[22]."\n".$payslips[27]."\n".$payslips[32]."\n".$payslips[36]."\n".$payslips[42+$tc]."\nSick Pay", 1, 'L', 1, 0, 2, 30, true, 0, false, true, 0, 'M'); 
      $pdf->MultiCell( 21, 48, $payslips[8]."\n".$payslips[14]."\n".$payslips[20]."\n".$payslips[25]."\n".$payslips[35]."\n".$payslips[45+$tc]."\n\n\n".$payslips[51], 1, 'R', 1, 0, 72, 30, true, 0, false, true, 0, 'M');
      
      $pdf->MultiCell( 27, 48, "PAYE Tax\nNational Insurance\n\n\n\n\n".$payslips[40]."\n".$payslips[46+$tc]."\n".$payslips[48+$tc]."\n".$payslips[51+$tc]."\n", 1, 'L', 1, 0, 94, 30, true, 0, false, true, 0, 'M'); 
      $pdf->MultiCell( 30, 48, $payslips[9]."\n".$payslips[15]."\n\n\n\n\n".$payslips[41]."\n".$payslips[47+$tc]."\n".$payslips[52+$tc]."\n", 1, 'R', 1, 0, 121, 30, true, 0, false, true, 0, 'M'); 
       
      }            
      else {
 
      $pdf->MultiCell( 21, 48, $payslips[8]."\n".$payslips[14]."\n".$payslips[20]."\n".$payslips[25]."\n".$payslips[30]."\n".$payslips[35+$tc]."\n".$payslips[39+$tc]."\n".$payslips[45+$tc]."\n", 1, 'R', 1, 0, 72, 30, true, 0, false, true, 0, 'M');
      
      $pdf->MultiCell( 27, 48, "PAYE Tax\nNational Insurance\n\n\nStudent Loan Ded.\n\n".$payslips[40+$tc]."\n".$payslips[46+$tc]."\n".$payslips[48+$tc]."\n".$payslips[51+$tc]."\n", 1, 'L', 1, 0, 94, 30, true, 0, false, true, 0, 'M'); 
      $pdf->MultiCell( 30, 48, $payslips[9]."\n".$payslips[15]."\n\n\n".$payslips[30+$tc]."\n\n".$payslips[41+$tc]."\n".$payslips[47+$tc]."\n".$payslips[49+$tc]."\n".$payslips[52+$tc]."\n", 1, 'R', 1, 0, 121, 30, true, 0, false, true, 0, 'M');      
      
      }            
                  
      if ($payslips[66+$tc]!='2055' && $payslips[64+$tc]!='1948') {           
      $pdf->MultiCell( 30, 48, "Total Gross Pay TD\nGross for Tax TD\nTax paid TD\nEarnings For NI TD\nNational Insurance TD\n\n================\n\nEarnings for NI\nGross for Tax\nTotal Gross Pay\nNat. Insurance No", 1, 'L', 1, 0, 152, 30, true, 0, false, true, 0, 'M');
      $pdf->MultiCell( 27, 48, $payslips[10]."\n".$payslips[16]."\n".$payslips[21]."\n".$payslips[26]."\n".$payslips[31+$tc]."\n\n\n\n".$payslips[50+$tc]."\n".$payslips[53+$tc]."\n".$payslips[56+$tc]."\n".$payslips[59+$tc], 1, 'R', 1, 0, 182, 30, true, 0, false, true, 0, 'M');
           }
      else {
      $pdf->MultiCell( 30, 48, "Total Gross Pay TD\nGross for Tax TD\nTax paid TD\nEarnings For NI TD\nNational Insurance TD\n\n================\n\nEarnings for NI\nGross for Tax\nTotal Gross Pay\nNat. Insurance No", 1, 'L', 1, 0, 152, 30, true, 0, false, true, 0, 'M');
      $pdf->MultiCell( 27, 48, $payslips[10]."\n".$payslips[16]."\n".$payslips[21]."\n".$payslips[26]."\n".$payslips[31]."\n\n\n\n".$payslips[50]."\n".$payslips[53+$tc]."\n".$payslips[56+$tc]."\n".$payslips[59+$tc], 1, 'R', 1, 0, 182, 30, true, 0, false, true, 0, 'M');
      

      
      }     
           
      //  number_format($payslips[13], 2, '.', '')
      //  .$payslips[54] - .$payslips[55
  
      $pdf->SetFont('Times', "B", 8);
      
      $pdf->MultiCell( 11, 8, $payslips[60+$tc], 1, 'C', 1, 0, 2, 84, true, 0, false, true, 0, 'M'); 
      $pdf->MultiCell( 29, 8, $payslips[61+$tc], 1, 'C', 1, 0, 13, 84, true, 0, false, true, 0, 'M'); 
      $pdf->MultiCell( 13, 8, $payslips[63+$tc], 1, 'C', 1, 0, 41, 84, true, 0, false, true, 0, 'M');
      $pdf->MultiCell( 12, 8, '', 1, 'C', 1, 0, 54, 84, true, 0, false, true, 0, 'M');
      
      $pdf->MultiCell( 19, 8, $payslips[64+$tc], 1, 'C', 1, 0, 66, 84, true, 0, false, true, 0, 'M'); 
      $pdf->MultiCell( 17, 8, $payslips[66+$tc], 1, 'C', 1, 0, 85, 84, true, 0, false, true, 0, 'M'); 
      
      $pdf->MultiCell( 80, 8, $payslips[65+$tc], 1, 'C', 1, 0, 102, 84, true, 0, false, true, 0, 'M');
      $pdf->MultiCell( 27, 8, $payslips[62+$tc], 1, 'C', 1, 0, 182, 84, true, 0, false, true, 0, 'M');
      
    
         // set color for background  - 2.
      $pdf->SetFillColor(0, 128, 0);
      $pdf->SetTextColor(255, 255, 255);
       
      $pdf->SetFont('Times', '', 6);
      
      $pdf->MultiCell( 30, 4, "DESCRIPTION", 1, 'C', 1, 0, 2, 26, true, 0, false, true, 0, 'M'); 
      $pdf->MultiCell( 20, 4, "HOURS", 1, 'C', 1, 0, 32, 26, true, 0, false, true, 0, 'M'); 
      $pdf->MultiCell( 20, 4, "RATE", 1, 'C', 1, 0, 52, 26, true, 0, false, true, 0, 'M');
      $pdf->MultiCell( 21, 4, "AMOUNT", 1, 'C', 1, 0, 72, 26, true, 0, false, true, 0, 'M');
    
       // set color for background  - 3.
      
      $pdf->SetFillColor(0, 128, 64);
      
      $pdf->MultiCell( 27, 4, "DESCRIPTION", 1, 'C', 1, 0, 94, 26, true, 0, false, true, 0, 'M'); 
      $pdf->MultiCell( 30, 4, "AMOUNT", 1, 'C', 1, 0, 121, 26, true, 0, false, true, 0, 'M'); 
      
      $pdf->MultiCell( 30, 4, "DESCRIPTION", 1, 'C', 1, 0, 152, 26, true, 0, false, true, 0, 'M');
      $pdf->MultiCell( 27, 4, "AMOUNT", 1, 'C', 1, 0, 182, 26, true, 0, false, true, 0, 'M');
    
    //82 - 80
      
      $pdf->SetFillColor(0, 128, 0);
      $pdf->setCellPaddings(0, 1, 0, 0);
      
      $pdf->MultiCell( 11, 5, "", 1, 'C', 1, 0, 2, 80, true, 0, false, true, 0, 'T'); 
      $pdf->MultiCell( 29, 5, "DATE", 1, 'C', 1, 0, 13, 80, true, 0, false, true, 0, 'T'); 
      $pdf->MultiCell( 13, 5, "DEPT.", 1, 'C', 1, 0, 41, 80, true, 0, false, true, 0, 'T');
      $pdf->MultiCell( 12, 5, "PAY POINT", 1, 'C', 1, 0, 54, 80, true, 0, false, true, 0, 'T');
      
      $pdf->MultiCell( 19, 4, "TAX CODE", 1, 'C', 1, 0, 66, 80, true, 0, false, true, 0, 'T'); 
      $pdf->MultiCell( 17, 4, "EMPLOYEE No.", 1, 'C', 1, 0, 85, 80, true, 0, false, true, 0, 'T'); 
      
      $pdf->MultiCell( 80, 4, "EMPLOYEE NAME", 1, 'C', 1, 0, 102, 80, true, 0, false, true, 0, 'T');
      $pdf->MultiCell( 27, 4, "NET PAY", 1, 'C', 1, 0, 182, 80, true, 0, false, true, 0, 'T');
      
      list($day1, $month1, $year1) = explode("/",$payslips[61]);
      
      $payslips_file =  $pdf->Output("", 'S');
      $payslips_sha1code =sha1($payslips_file);
      
      // Save PDF version
     $myFile_payslips = "payslips_".$payslips[66+$tc]."_".$day1.$month1.$year1."_".$date2."_"."$payslipsno.pdf";
   
    
     //$pdf->Output("payslips_vouchers_all/$date1/$myFile_payslips", 'F');
     // chmod("payslips_vouchers_all/$date1/$myFile_payslips", 0755); 
    
      unset($pdf);
     // $payslips_file = $db->Fix($payslips_file);
     // Save Files into the database
             $payslips_file  = addslashes($payslips_file);
       $upd = "UPDATE `payslips_vouchers` SET payslips_state='2',payslips_filename='$myFile_payslips',payslips_file='$payslips_file',payslips_sha1code='$payslips_sha1code' WHERE `id`='$id' Limit 1";
  if (!$db2->Query($upd)) $db2->Kill();
 
  
    }
     // Payslips PDF Generation - END
      
     // Voucher PDF Generation 
     
    
    $q = "SELECT vouchers_value.valuenumber, vouchers_value.value, nombers.knownas,`nombers`.cat
FROM  payslips_vouchers INNER JOIN vouchers_value ON payslips_vouchers.id=vouchers_value.pvid
INNER JOIN `nombers` ON `payslips_vouchers`.no=nombers.pno
Where payslips_vouchers.id='$id'
Order by valuenumber ASC 
";
//AND vouchers_state='1'
    if ($db1->Query($q)) 
    {

    // Payslips Generation
      $vouchers=Array();
    while ($row1=$db1->Row())
    {
        $knownas=$row1->knownas;
         $cat =  $row->cat;
     if ($row1->value != "") {
      $vouchers[$row1->valuenumber]=$row1->value; }
      else  $vouchers[$row1->valuenumber] = "";
    }
    
    if ($vouchers[17] != "" && $vouchers[17] != "0") {
   
      echo "<br>Voucher: I am creating: ". $vouchers[0]. " - ".$vouchers[1];
  // PDF Generation
  
  
      $pdfv = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true,'UTF-8', false); 
      
      $pdfv->SetCreator(PDF_CREATOR);
      $pdfv->SetAuthor('Music And Goods Exchange Ltd.');
      $pdfv->SetTitle('Voucher: '.$vouchers[0].', '.$vouchers[1]);
      $pdfv->SetSubject('Voucher');
      $pdfv->SetKeywords('Music And Goods Exchange Ltd., voucher, '.$vouchers[0].', '.$vouchers[1].', ');

      //$pdf->SetProtection($permissions=array('print', 'copy'), $user_pass='', $owner_pass=null, $mode=0, $pubkeys=null);
      $pdfv->SetProtection($permissions=array('copy','modify','annot-forms','fill-forms','extract','assemble'), $user_pass=$password, $owner_pass=null, $mode=1, $pubkeys=null);
          
      $pdfv->SetMargins(0,0);
      $pdfv->setPrintHeader(false);
      $pdfv->setPrintFooter(false);
      $pdfv->SetCellPadding(0);
      $pdfv->SetAutoPageBreak(FALSE, PDF_MARGIN_BOTTOM);
      
   //    $pdf->setCellHeightRatio(1.25);
   //  $pdf->setImageScale(0.47);

      // Size of payslip: 210 - 99 mm
      
      $pdfv->AddPage("L",array(88,53));
      $pdfv->setCellPaddings(0, 0, 0, 0);
      $pdfv->SetDrawColor(0,0,0);
     // $pdfv->MultiCell(90, 20, "AA", 1, 'L', 0, 0, 0, 0,false,0,true,false,0,'');
      
      $pdfv->SetTextColor(0, 0, 0);
      
        $pos = strpos($vouchers[17], 'HOLD');


        if ($pos === false) {
        $amount = iconv('iso-8859-1', 'utf-8', "�")." ".number_format($vouchers[17], 2, '.', '');
        }
        else $amount = iconv('iso-8859-1', 'utf-8', "�")." W/HOLD";
     //  'Helvetica'
      $pdfv->SetFont( 'Times' , "BU", 15);
      $pdfv->SetTextColor(255, 255, 255);
      $pdfv->MultiCell(88, 52, " \n \n \n \n \n \n  \n \n", 1, 'L', 0, 0, 0, 0, true, 0, false, true, 0, 'T');
      $pdfv->SetTextColor(0, 0, 0);
      $pdfv->MultiCell(88, 10, "Voucher Entitlement For ".$vouchers[3], 0, 'L', 0, 0, 1, 0, true, 0, false, true, 0, 'M');
      $pdfv->SetFont( 'Times' , "B", 15);
      $pdfv->MultiCell( 88, 10, $vouchers[0]." ".$vouchers[1]." ".$vouchers[2], 0, 'L', 0, 0, 1, 8, true, 0, false, true, 0, 'M');
      $pdfv->SetFont('Helvetica', "", 12); 
      $pdfv->MultiCell( 88, 10, "CASHED IN TILL AT SHOP .....................", 0, 'L', 0, 0, 1, 16, true, 0, false, true, 0, 'M'); 
      $pdfv->MultiCell( 88, 10, "ON ....../....../...... ", 0, 'L', 0, 0, 1, 24, true, 0, false, true, 0, 'M'); 
      $pdfv->SetFont( 'Times' , "B", 14); 
      $pdfv->MultiCell( 88, 10, "AMOUNT $amount", 0, 'L', 0, 0, 1, 32, true, 0, false, true, 0, 'M');
      $pdfv->SetFont( 'Times' , "", 12);
      $pdfv->MultiCell( 88, 10, "Authorised by .................................", 0, 'L', 0, 0, 1, 40, true, 0, false, true, 0, 'M'); 
      $pdfv->SetFont( 'Times' , "", 8);
      $pdfv->MultiCell( 88, 8, "This slip is to be exchanged for vouchers and sent to accounts.", 0, 'L', 0, 0, 1, 48, true, 0, false, true, 0, 'M');
      
//$pdfv->Rect(100, 10, 40, 20, 'DF', $style4, array(220, 220, 200));
      
      // Save PDF version
     $myFile_vouchers = "vouchers_".$vouchers[0]."_".$day1.$month1.$year1."_".$date2."_"."$vouchersno.pdf";
   
      $vouchers_file = $pdfv->Output("", 'S');
      $vouchers_sha1code =sha1($vouchers_file);
    
     // $pdfv->Output("payslips_vouchers_all/$date1/$myFile_vouchers", 'F');
     // chmod("payslips_vouchers_all/$date1/$myFile_payslips", 0755); 
    
      unset($pdfv);
 
     // Save Files into the database
     //  $vouchers_file = $db->Fix($vouchers_file);
       
        $vouchers_file = addslashes($vouchers_file);
       $upd = "UPDATE `payslips_vouchers` SET vouchers_state='2',vouchers_filename='$myFile_vouchers',vouchers_file='$vouchers_file',vouchers_sha1code='$vouchers_sha1code' WHERE `id`='$id' Limit 1";
  if (!$db2->Query($upd)) $db2->Kill();
 
  
    }
  
  
  // Mail generation  
    
    $_text = "
   <html>
   <head>
   </head>
   <body>
   <b>Dear Colleague</b>
   <br>
   <br>
  ";
  /* 
   if ($vouchers[17] == "") {
     $_text .= " for November 2011.<br><br>";
     $myFile_vouchers = 'NONE';
     }
  else {
     $_text .= " and voucher slip for November 2011.<br><br>";
     }
   */
    
   if ($status != "LEAVER") {  
       $_text .= "Please find attached your payslip for May 2012";
     /*
   $_text .= "<b>Paid leave details: ".$vouchers[4]."</b><br>";
   $_text .= "Current leave year: 01/12/10 - 30/11/11<br><br>";
   
   $datetype1 = $vouchers[5];
   $datetype2 = $vouchers[5];
   $datetype3 = $vouchers[5];
   
   if ($vouchers[7] == "1" && $vouchers[5] == "days" ) {$datetype1 ="day";}
   if ($vouchers[8] == "1" && $vouchers[5] == "days" ) {$datetype2 ="day";}
   if ($vouchers[9] == "1" && $vouchers[5] == "days" ) {$datetype3 ="day";}

   if ($vouchers[6] == "1" && $vouchers[5] == "weeks" ) {$datetype1="week";}
   if ($vouchers[8] == "1" && $vouchers[5] == "weeks" ) {$datetype2="week";}
   if ($vouchers[9] == "1" && $vouchers[5] == "weeks" ) {$datetype3="week";}
   
      if ($vouchers[4] != 'Casual') {
   $_text .= "Paid leave entitlement: ".$vouchers[7]." ".$datetype1."<br>";
   }
   else $_text .= "Paid leave entitlement: ".$vouchers[6]." ".$datetype1."<br>";
   
   $_text .= "Paid leave taken: ".$vouchers[8]." ".$datetype2."<br>";
   $_text .= "Paid leave remaining: ".$vouchers[9]." ".$datetype3."<br><br>";
   // Regular
   if ($vouchers[4] != 'Casual' ) {
   $_text .= "If by the 30/11/11 you have not taken your full 5.6 weeks' (or pro rata) paid annual leave you will be entitled to an ex-gratia payment equivalent to your pay for the extra days you have worked. 
   This payment will be added to your Nov 2011 pay.<br><br>"; 
             }
    $_text .=  "<b>Annual weekend bonus details</b>
    <br><br>";
    
    if ($vouchers[10] == "NONE" || $vouchers[10] == "BHM") {$_text .="You are not eligible for a weekend bonus.<br><br>";}
    else {
      if ($no<1708 || $no>2172 && $voucher[10]!='NONE') {
      $_text .="Your bonus year runs from ".$vouchers[15]." to ".$vouchers[16]."<br><br>";
      $_text .="Total weekend days to date:  ".$vouchers[11]."<br>";
      $_text .="Monthly weekend average to date: ".$vouchers[12]."<br>";
      $_text .="Weekend days needed to reach: ".$vouchers[13]."<br>";
      $_text .="Monthly average necessary: ".$vouchers[14]."<br><br>";
            }
      else {
      
        $_text .="You are not eligible for a weekend bonus. However, you must average 3.75 weekend days per month (as well as making 70% punctuality) in order to be allowed to buy vouchers.<br><br> 
        Monthly weekend average to date: ".$vouchers[12];
      }     
            
            
    }
    */
   }  
   
  else  $_text .= "Your P45 will follow in the next couple of weeks.<br>"; 

  
  $_text .= "\n</body>\n</html>\n";
   
    $_text = $db->Fix($_text); 
      
     $upd = "UPDATE `payslips_vouchers` SET text='$_text' WHERE `id`='$id' Limit 1";
  if (!$db2->Query($upd)) $db2->Kill(); 
    
    }
    
     // Vouchers PDF Generation - END
    
    
  }  
       
    
    
   } 

 
echo "
</table>
</center>";

include_once("./footer.php");
 
 ?>