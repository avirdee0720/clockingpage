<?php

//ERROR_REPORTING(E_ALL);

// Payslips sending script

// MVE's framework
//include("./config.php");
//include_once("header.php");

//require('smarty/libs/Smarty.class.php');
require('./tcpdf/tcpdf.php');

// Initialization
//$smarty = new Smarty;
$output = "";
$mail_sent = false;

$date1 = date("Ymd");

// Load playslip data
$lines = file("data/payslips_data2.csv");

echo "<br><b>Welcome to Payslips sender page!</b><br>";

// Folder checking

if (!is_dir("payslips_all/$date1"))    { 
   if (!mkdir("payslips_all/$date1",0755,true)) {die('Failed to create folders...');    }
    }
   if (!is_dir("payslips_sent/$date1"))    { 
   if (!mkdir("payslips_sent/$date1",0755,true)) {die('Failed to create folders...');    }
    }
   if (!is_dir("payslips_unsent/$date1"))    { 
   if (!mkdir("payslips_unsent/$date1",0755,true)) {die('Failed to create folders...');    }
    }  
 
$k=0;   
        
foreach($lines as $line) {   
$k++;            
      // string to array  
      $line =str_replace('"','',$line);
      $payslips = explode(",", $line);
  
      // $payslips[64] - Clocking number, $payslips[65] - name
       
     echo "<br>I am creating: ". $payslips[64]. " - ".$payslips[65] ." - ";
  
     
      
      // Generation PDF version from HTML
      
      // New payslip
      
      $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true); 
      
      $pdf->SetCreator(PDF_CREATOR);
      $pdf->SetAuthor('Music And Goods Exchange Ltd.');
      $pdf->SetTitle('Payslips: '.$payslips[65].', '.$payslips[61]);
      $pdf->SetSubject('Payslips');
      $pdf->SetKeywords('Music And Goods Exchange Ltd., Payslips, '.$payslips[65].', '.$payslips[61].', ');

      //$pdf->SetProtection($permissions=array('print', 'copy'), $user_pass='', $owner_pass=null, $mode=0, $pubkeys=null);

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
      $pdf->SetFont('arialunicid0', "B", 11);
   
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
      
      $pdf->SetFont('arialunicid0', "B", 8);
      $pdf->MultiCell( 91, 6, "Department ".$payslips[1]." - ".$payslips[2], 1, 'L', 1, 0, 2, 20, true, 0, false, true, 0, 'M'); 
      $pdf->MultiCell( 57, 6, "Payment Method - ".$payslips[3], 1, 'L', 1, 0, 94, 20, true, 0, false, true, 0, 'M'); 
      $pdf->MultiCell( 57, 6, "Payment Period - ".$payslips[4], 1, 'L', 1, 0, 152, 20, true, 0, false, true, 0, 'M'); 
     
      $pdf->SetFont('arialunicid0', "", 7);
      // 48 - 50
      $pdf->MultiCell( 30, 48, $payslips[5]."\n".$payslips[11]."\n".$payslips[17]."\n".$payslips[22]."\n".$payslips[27]."\n".$payslips[32]."\n".$payslips[36]."\n".$payslips[42]."\n", 1, 'L', 1, 0, 2, 30, true, 0, false, true, 0, 'M'); 
      $pdf->MultiCell( 20, 48, $payslips[6]."\n".$payslips[12]."\n".$payslips[18]."\n".$payslips[23]."\n".$payslips[28]."\n".$payslips[33]."\n".$payslips[37]."\n".$payslips[43]."\n", 1, 'R', 1, 0, 32, 30, true, 0, false, true, 0, 'M'); 
      $pdf->MultiCell( 20, 48, $payslips[7]."\n".$payslips[13]."\n".$payslips[19]."\n".$payslips[24]."\n".$payslips[29]."\n".$payslips[34]."\n".$payslips[38]."\n".$payslips[44]."\n", 1, 'R', 1, 0, 52, 30, true, 0, false, true, 0, 'M');
      $pdf->MultiCell( 21, 48, $payslips[8]."\n".$payslips[14]."\n".$payslips[20]."\n".$payslips[25]."\n".$payslips[30]."\n".$payslips[35]."\n".$payslips[39]."\n".$payslips[45]."\n", 1, 'R', 1, 0, 72, 30, true, 0, false, true, 0, 'M');
      
      $pdf->MultiCell( 27, 48, "PAYE Tax\nNational Insurance\n\n\n\n\n".$payslips[40]."\n".$payslips[46]."\n".$payslips[48]."\n".$payslips[51]."\n", 1, 'L', 1, 0, 94, 30, true, 0, false, true, 0, 'M'); 
      $pdf->MultiCell( 30, 48, "SSs".$payslips[9]."\n".$payslips[15]."\n\n\n\n\n".$payslips[41]."\n".$payslips[47]."\n".$payslips[49]."\n".$payslips[52]."\n", 1, 'R', 1, 0, 121, 30, true, 0, false, true, 0, 'M'); 
      
      $pdf->MultiCell( 30, 48, "Total Gross Pay TD\nGross for Tax TD\nTax paid TD\nEarnings For NI TD\nNational Insurance TD\n\n================\n\nEarnings for NI\nGross for Tax\nTotal Gross Pay\nNat. Insurance No", 1, 'L', 1, 0, 152, 30, true, 0, false, true, 0, 'M');
      $pdf->MultiCell( 27, 48, $payslips[10]."\n".$payslips[16]."\n".$payslips[21]."\n".$payslips[26]."\n".$payslips[31]."\n\n\n\n".$payslips[50]."\n".$payslips[53]."\n".$payslips[56]."\n".$payslips[59], 1, 'R', 1, 0, 182, 30, true, 0, false, true, 0, 'M');
           
      //  number_format($payslips[13], 2, '.', '')
      //  .$payslips[54] - .$payslips[55
  
      $pdf->SetFont('arialunicid0', "B", 8);
      
      $pdf->MultiCell( 11, 8, $payslips[60], 1, 'C', 1, 0, 2, 84, true, 0, false, true, 0, 'M'); 
      $pdf->MultiCell( 29, 8, $payslips[61], 1, 'C', 1, 0, 13, 84, true, 0, false, true, 0, 'M'); 
      $pdf->MultiCell( 13, 8, $payslips[62], 1, 'C', 1, 0, 41, 84, true, 0, false, true, 0, 'M');
      $pdf->MultiCell( 12, 8, '', 1, 'C', 1, 0, 54, 84, true, 0, false, true, 0, 'M');
      
      $pdf->MultiCell( 19, 8, $payslips[63], 1, 'C', 1, 0, 66, 84, true, 0, false, true, 0, 'M'); 
      $pdf->MultiCell( 17, 8, $payslips[64], 1, 'C', 1, 0, 85, 84, true, 0, false, true, 0, 'M'); 
      
      $pdf->MultiCell( 80, 8, $payslips[65], 1, 'C', 1, 0, 102, 84, true, 0, false, true, 0, 'M');
      $pdf->MultiCell( 27, 8, $payslips[66], 1, 'C', 1, 0, 182, 84, true, 0, false, true, 0, 'M');
      
    
         // set color for background  - 2.
      $pdf->SetFillColor(0, 128, 0);
      $pdf->SetTextColor(255, 255, 255);
       
      $pdf->SetFont('arialunicid0', '', 6);
      
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
      
      // Save PDF version
      $myFile_payslips = "payslips_".$payslips[64]."_".$year1.$month1.$day1."_".$date1;
   
      $page = $pdf->Output($myFile_payslips.".pdf", 'S');
      $code_payslips =sha1($page);
 

      // New Voucher
    
    // Voucher data in



      $voucher = array();
      
      $pdfv = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true); 
      
      $pdfv->SetCreator(PDF_CREATOR);
      $pdfv->SetAuthor('Music And Goods Exchange Ltd.');
      $pdfv->SetTitle('Voucher: '.$payslips[65].', '.$payslips[61]);
      $pdfv->SetSubject('Voucher');
      $pdfv->SetKeywords('Music And Goods Exchange Ltd., voucher, '.$payslips[65].', '.$payslips[61].', ');

      //$pdf->SetProtection($permissions=array('print', 'copy'), $user_pass='', $owner_pass=null, $mode=0, $pubkeys=null);

      $pdfv->SetMargins(0,0);
      $pdfv->setPrintHeader(false);
      $pdfv->setPrintFooter(false);
      $pdfv->SetCellPadding(0);
      $pdfv->SetAutoPageBreak(FALSE, PDF_MARGIN_BOTTOM);
      
   //    $pdf->setCellHeightRatio(1.25);
   //  $pdf->setImageScale(0.47);

      // Size of payslip: 210 - 99 mm
      
      $pdfv->AddPage("L",array(90,60));
      $pdfv->setCellPaddings(0, 0, 0, 0);
      $pdfv->SetDrawColor(0,0,0);
      $pdfv->MultiCell(90, 20, "AA", 1, 'L', 0, 0, 0, 0,false,0,true,false,0,'');
      
      $pdfv->SetTextColor(0, 0, 0);
      
   
      $pdfv->SetFont('Helvetica', "BU", 9);
      $pdfv->MultiCell(85, 10, "Voucher Entitlement For", 0, 'L', 0, 0, 1, 0, true, 0, false, true, 0, 'M');
      $pdfv->SetFont('Helvetica', "B", 9);
      $pdfv->MultiCell( 85, 10, $payslips[64]." - ".$payslips[65], 0, 'L', 0, 0, 1, 8, true, 0, false, true, 0, 'M');
      $pdfv->SetFont('Helvetica', "", 8); 
      $pdfv->MultiCell( 85, 10, "CASHED IN TILL AT SHOP ...........", 0, 'L', 0, 0, 1, 16, true, 0, false, true, 0, 'M'); 
      $pdfv->MultiCell( 85, 10, "ON ...../..../..... ", 0, 'L', 0, 0, 1, 24, true, 0, false, true, 0, 'M'); 
      $pdfv->SetFont('Helvetica', "B", 9);
      $pdfv->MultiCell( 85, 10, "AMOUNT    £ ".$payslips[4], 0, 'L', 0, 0, 1, 32, true, 0, false, true, 0, 'M');
      $pdfv->SetFont('Helvetica', "", 7);
      $pdfv->MultiCell( 85, 10, "Authorised by ................", 0, 'L', 0, 0, 1, 40, true, 0, false, true, 0, 'M'); 
      $pdfv->SetFont('Helvetica', "", 5);
      $pdfv->MultiCell( 85, 10, "This slip is to be exchanged for vouchers and sent to accounts.", 0, 'L', 0, 0, 1, 48, true, 0, false, true, 0, 'M');
      
      // Save PDF version
      $myFile_vouchers = "voucher_".$payslips[64]."_".$year1.$month1.$day1."_".$date1;
   
      $page = $pdfv->Output($myFile_vouchers.".pdf", 'S');
      $page = $pdfv->Output('save/'.$myFile_vouchers.".pdf", 'F');
      $code_payslips =sha1($page);
  
      
      
// Save HTML Version
      
//      $fh = fopen($myFile.".html", 'w') or die("can't open file");
//      fwrite($fh, $output);
//      fclose($fh);


// Save payslips && voucher to folder    

   //if (!is_dir("payslips_sent/$date1"))  mkdir("payslips_sent/$date1",0755);
   //if (!is_dir("payslips_unsent/$date1"))  mkdir("payslips_unsent/$date1",0755);
   
   $pdf->Output("payslips_all/$date1/$myFile_payslips"."_$k.pdf", 'F');
       
// mail sending 
    
 //  $mail_sent=mail_send ($email1, $_text,"payslips_all/$date1/".$myFile.".pdf");
  
// Save to database

   if ($mail_sent) {

   $pdf->Output("payslips_sent/$date1/".$myFile_payslips.".pdf", 'F');
   
   
   
   }

  else {
  
  $pdf->Output("payslips_unsent/$date1/".$myFile_payslips.".pdf", 'F');
   
  
  
  }  
   
// Destroy pdf
      
      unset($pdf);
 
}

 //$pdf->Output();
    
 echo "Ok.";


// MVE's framework
//include_once("./footer.php");

function _mail_send ($who, $body, $attachment) {

$value = false;
 
require("phpmailer/class.phpmailer.php");

$mail = new PHPMailer();
$mail->IsSMTP(); // send via SMTP
//IsSMTP(); // send via SMTP

$mail->SMTPAuth = true; // turn on SMTP authentication
$mail->Username = "applicationform@mgeshops.com"; // SMTP username
$mail->Password = "2010abcde"; // SMTP password
$from = "applicationform@mgeshops.com"; //Reply to this email ID
// $email="mail@bodony.com"; // Recipients email ID
$name=""; // Recipient's name
$mail->From = $from;
$mail->FromName = "MGE Office";
$mail->AddAddress($who,$name);
$mail->AddAddress("jbodony@freemail.hu","Jani2");
$mail->AddAddress("mail@bodony.com","Jani");
$mail->AddReplyTo($from,"MGE Office");
$mail->WordWrap = 50; // set word wrap
$mail->AddAttachment($attachment); // attachment
//$mail->AddAttachment("/tmp/image.jpg", "new.jpg"); // attachment
$mail->IsHTML(true); // send as HTML
$mail->Subject = "MGE Payslip & voucher";
$mail->Body = $body; //HTML Body
$mail->AltBody = $body; //Text Body
/*
if(!$mail->Send())
{
echo "Mailer Error: " . $mail->ErrorInfo . "<br>";
}
else
{
echo "Message has been sent.<br>";
$value = true;
}

*/
 
return $value; 
}

function payslips() {


return $output;
}

 


?>  