<?php
require('tcpdf/tcpdf.php');

$bankno=$_GET['bankno'];



$banktxt = array('Barclays','NatWest','HSBC','Lloyds TSB');

$bank = $banktxt[$bankno];
$keymax =  20000;
$keymax = 2;

 //header("Content-type: image/png");
 
  $dataakt=date("d/m/Y");
  $datam = date("m");
  $datay = date("y");
  $datad = date("d");
  $dataakt2 = date("Y-m-d");
  $data1d =  date("1", mktime(0, 0, 0,$datam, 1, $datay));
 
// echo $dataakt2;
  
  if ($data1d == "Sunday") $data1d = "$datay-$datam-02"; else $data1d = "$datay-$datam-01"; 
  

// ini_set('memory_limit','512M');
// set_time_limit(10000);
// error_reporting(E_ALL);

include("./config.php");
include_once("./header.php");
require_once './Excel/reader.php';

//include_once("./header.php");
echo "ddde".$bankno;

$db = new CMySQL;
//$w = $db->Test("orgmve","localhost","root","");


// ExcelFile($filename, $encoding);
$data = new Spreadsheet_Excel_Reader();

echo "dddd";
// Set output Encoding.
$data->setOutputEncoding('CP1251');

$dir = "bankdata/";

$sql = "DROP TABLE `bankdetails`";

$query = $db->Query($sql);

$sql = "
CREATE TABLE `bankdetails` (
  `bankdetid` int(11) NOT NULL auto_increment,
  `no` int(11) NOT NULL default '0',
  `sortc` char(10) NOT NULL default '',
  `acno` char(10) NOT NULL default '',
  `bank` char(30) NOT NULL default '',
  `accname` char(30) NOT NULL default '',
  `forename` char(30) NOT NULL default '',
  `surename` char(30) NOT NULL default '',
  `date1` datetime NOT NULL default '0000-00-00 00:00:00',
  `userid` int(11) NOT NULL default '0',
  `cur_timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`bankdetid`),
  KEY `no` (`no`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Bank account details' AUTO_INCREMENT=1 ;
";

$query = $db->Query($sql);

$sql = "DROP TABLE `bankchequepayment`";

$query = $db->Query($sql);

$sql = "
CREATE TABLE `bankchequepayment` (
  `bankchequepaymentid` int(11) NOT NULL auto_increment,
  `no` int(11) NOT NULL default '0',
  `forename` char(30) NOT NULL default '',
  `surename` char(30) NOT NULL default '',
  `cheque` double(10,2) NOT NULL default '0',
  `date1` datetime NOT NULL default '0000-00-00 00:00:00',
  `userid` int(11) NOT NULL default '0',
  `cur_timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`bankchequepaymentid`),
  KEY `no` (`no`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Bank Cheque payment' AUTO_INCREMENT=1 
";

$query = $db->Query($sql);

// Open a known directory, and proceed to read its contents

if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
		
if (filetype($dir . $file) == "file") {

if ($file == "d.xls") {
  $data ="";
		$data = new Spreadsheet_Excel_Reader();
		// Set output Encoding.

		$data->setOutputEncoding('CP1251');

			$data->read($dir.$file);

	for ($i = 2; isset($data->sheets[0]['cells'][$i][1]); $i++) {

$sortcode = $data->sheets[0]['cells'][$i][5];
$minus = array("-");
$sortcode  = str_replace($minus, "", $sortcode );

$sql = "
INSERT INTO `bankdetails` ( `no`,`accname`, `sortc`, `acno`,`bank`,`forename` , `surename`,`date1`) 
VALUES ('".$data->sheets[0]['cells'][$i][1]."','".$data->sheets[0]['cells'][$i][2].' '.$data->sheets[0]['cells'][$i][3]."','".$sortcode."','".$data->sheets[0]['cells'][$i][4]."','".$data->sheets[0]['cells'][$i][6]."','".$data->sheets[0]['cells'][$i][2]."','".$data->sheets[0]['cells'][$i][3]."', STR_TO_DATE('".$data1d."', '%Y-%m-%d'));
";

 echo $data->sheets[0]['cells'][$i][1]."<br>";
 $query = $db->Query($sql);

          	}
      }
     
if ($file == "e.xls") {
$data ="";
		$data = new Spreadsheet_Excel_Reader();
		// Set output Encoding.

		$data->setOutputEncoding('CP1251');

		$data->read($dir.$file);
	for ($i = 1; isset($data->sheets[0]['cells'][$i][1]); $i++) {


$sql = "
INSERT INTO  `bankchequepayment` ( `no` , `forename` , `surename`,`cheque`,`date1`) 
VALUES ('".$data->sheets[0]['cells'][$i][1]."','".$data->sheets[0]['cells'][$i][2]."','".$data->sheets[0]['cells'][$i][3]."','".$data->sheets[0]['cells'][$i][4]."', STR_TO_DATE('".$data1d."', '%Y-%m-%d'));
";
   // $sql = $db->Fix($sql);
    $query = $db->Query($sql);

          	}
      }
            
  
      
           }        
        }
      closedir($dh);
    }
}


//error_reporting(E_ALL ^ E_NOTICE);
 

$sql = " select 
 `bankdetails`.`no`, `bankdetails`.`sortc`,`bankdetails`.`acno`,`bankdetails`.`bank`,`bankdetails`.`accname`,`bankdetails`.`forename`, `bankdetails`.`surename`,DATE_FORMAT(`bankdetails`.`date1` , \"%d/%m/%y\" ) AS date1,
`bankchequepayment`.`forename` As bankforename,`bankchequepayment`. `surename` As banksurename,`bankchequepayment`.`cheque`,`bankchequepayment`.`date1` as bankdate1
 from  `bankdetails` INNER JOIN `bankchequepayment`  on `bankdetails`.`no`=`bankchequepayment`.`no`
Where bank='Barclays' or bank='NatWest' or bank='HSBC' or bank='Lloyds TSB'
 order by bank, surename
";


$sql = " select 
 `bankdetails`.`no`, `bankdetails`.`sortc`,`bankdetails`.`acno`,`bankdetails`.`bank`,`bankdetails`.`accname`,`bankdetails`.`forename`, `bankdetails`.`surename`,DATE_FORMAT(`bankdetails`.`date1` , \"%d/%m/%y\" ) AS date1,
`bankchequepayment`.`forename` As bankforename,`bankchequepayment`. `surename` As banksurename,`bankchequepayment`.`cheque`,`bankchequepayment`.`date1` as bankdate1
 from  `bankdetails` INNER JOIN `bankchequepayment`  on `bankdetails`.`no`=`bankchequepayment`.`no`
Where bank='$bank'
 order by bank, surename
";

$data = array();

 if ($db->Query($sql)) {  
 while ($row=$db->Row())
    { 
    
  $data[] =  array (
        "type"=>$row->bank,
        "date"=>$row->date1,
        "accountname"=>$row->bankforename.' '.$row->banksurename,
        "sortcode" => $row->sortc,
        "accountnumber"=>$row->acno,
        "total"=>$row->cheque
        ) ;  
     }
  }
 
 
 $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true); 
//    $pdf->setPageUnit( 'pt');
    $pdf->SetMargins(0,0);
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $pdf->SetCellPadding(0);
    $pdf->SetAutoPageBreak(FALSE, PDF_MARGIN_BOTTOM);
    $pdf->SetFont("times", "", 11);

foreach ($data as $key => $value) {

   $bordery = 0;
      
    
  //  echo "Key: $key; Value: ".$value["accountname"]."<br />\n";
   if (($value["type"] == "Barclays") && ($key<$keymax)) {
  
  // if ($key > 0) $bordery = 8;
  
   $offsetx=-2;
   $offsety=0;
  
    $inttotal=substr($value["total"],0,strpos(($value["total"]).'.','.',0));
    $parttotal=substr($value["total"],strpos(($value["total"]).'.','.',0)+1,2);
    $inttotalx = $pdf->GetStringWidth( $inttotal );
   
    $pdf->AddPage("P",'BARCLAYS');
   
    $pdf->SetXY(16+$offsetx, 2+$offsety);$pdf->Cell(0,0, $value["date"]);
    $pdf->SetXY(16+$offsetx, 9+$offsety);$pdf->Cell(0, 0, $value["accountname"]);
    $pdf->SetXY(16+$offsetx, 15+$offsety);$pdf->Cell(0,0, $value["accountnumber"]);
    
  
    $pdf->SetXY(31-$inttotalx+$offsetx, 63+$offsety);   $pdf->Cell(0,0, $inttotal);
    $pdf->SetXY(37+$offsetx, 63+$offsety);    $pdf->Cell(0, 0, $parttotal);
    $pdf->SetXY(31-$inttotalx+$offsetx, 70+$offsety);    $pdf->Cell(0,0, $inttotal);
    $pdf->SetXY(37+$offsetx, 70+$offsety);  $pdf->Cell(0, 0, $parttotal);
    $pdf->SetXY(73+$offsetx, 11+$offsety); $pdf->Cell(0, 0, $value["date"]);
    $pdf->SetXY(93+$offsetx, 41+$offsety);$pdf->Cell(0, 0, $value["accountname"]);
    $pdf->SetXY(100+$offsetx, 55+$offsety);$pdf->Cell(0, 0, $value["sortcode"][2]);
    $pdf->SetXY(105+$offsetx, 55+$offsety);$pdf->Cell(0, 0, $value["sortcode"][3]);
    $pdf->SetXY(109+$offsetx, 55+$offsety);$pdf->Cell(0, 0, $value["sortcode"][4]);
    $pdf->SetXY(113+$offsetx, 55+$offsety);$pdf->Cell(0, 0, $value["sortcode"][5]);
    $pdf->SetXY(123+$offsetx, 55+$offsety);$pdf->Cell(0, 0, $value["accountnumber"][0]);
    $pdf->SetXY(127+$offsetx, 55+$offsety);$pdf->Cell(0, 0, $value["accountnumber"][1]);
    $pdf->SetXY(131+$offsetx, 55+$offsety);$pdf->Cell(0, 0, $value["accountnumber"][2]);
    $pdf->SetXY(135+$offsetx, 55+$offsety);$pdf->Cell(0, 0, $value["accountnumber"][3]);
    $pdf->SetXY(139+$offsetx, 55+$offsety);$pdf->Cell(0, 0, $value["accountnumber"][4]);
    $pdf->SetXY(143+$offsetx, 55+$offsety);$pdf->Cell(0, 0, $value["accountnumber"][5]);
    $pdf->SetXY(148+$offsetx, 55+$offsety);$pdf->Cell(0, 0, $value["accountnumber"][6]);
    $pdf->SetXY(152+$offsetx, 55+$offsety);$pdf->Cell(0, 0, $value["accountnumber"][7]);
       
    $pdf->SetXY(182-$inttotalx+$offsetx, 47+$offsety);    $pdf->Cell(0, 0, $inttotal);
    $pdf->SetXY(187+$offsetx, 47+$offsety);    $pdf->Cell(0, 0, $parttotal);
    $pdf->SetXY(182-$inttotalx+$offsetx, 56+$offsety);    $pdf->Cell(0, 0, $inttotal);
    $pdf->SetXY(187+$offsetx, 56+$offsety);    $pdf->Cell(0, 0, $parttotal);
          

   }
      
 elseif (($value["type"] == "HSBC") && ($key<$keymax)) {
 
   // if ($key  > 0) $bordery = 8;
  
    $inttotal=substr($value["total"],0,strpos(($value["total"]).'.','.',0));
    $parttotal=substr($value["total"],strpos(($value["total"]).'.','.',0)+1,2);
    $inttotalx = $pdf->GetStringWidth( $inttotal );
   
    $pdf->AddPage("P",array(254,88));
    
     $offsetx=-2;
     $offsety=-1;
     
    //   $pdf->SetXY(0,0);   $pdf->Cell(0,0, 'M');
    
    $pdf->SetXY(15 +$offsetx, 7+$offsety);   $pdf->Cell(0,0, $value["date"]);
    $pdf->SetXY(15 +$offsetx, 17+$offsety);   $pdf->Cell(0,0, $value["accountname"]);
    $pdf->SetXY(50-$inttotalx+$offsetx, 74+$offsety);   $pdf->Cell(0,0, $inttotal);
    $pdf->SetXY(52+$offsetx, 74+$offsety);   $pdf->Cell(0,0, $parttotal);
    $pdf->SetXY(37 +$offsetx, 82+$offsety);   $pdf->Cell(0,0, $value["total"]);
    $pdf->SetXY(75 +$offsetx, 8+$offsety);   $pdf->Cell(0,0, $value["date"]);

    $pdf->SetXY(119 +$offsetx, 34+$offsety);   $pdf->Cell(0,0, $value["accountname"]);
    $pdf->SetXY(122 +$offsetx, 62+$offsety);   $pdf->Cell(0,0, $value["sortcode"][2]);
    $pdf->SetXY(128 +$offsetx, 62+$offsety);   $pdf->Cell(0,0, $value["sortcode"][3]);
    $pdf->SetXY(134 +$offsetx, 62+$offsety);   $pdf->Cell(0,0, $value["sortcode"][4]);
    $pdf->SetXY(141 +$offsetx, 62+$offsety);   $pdf->Cell(0,0, $value["sortcode"][5]);
    $pdf->SetXY(152 +$offsetx, 62+$offsety);   $pdf->Cell(0,0, $value["accountnumber"][0]);
    $pdf->SetXY(159 +$offsetx, 62+$offsety);   $pdf->Cell(0,0, $value["accountnumber"][1]);
    $pdf->SetXY(166 +$offsetx, 62+$offsety);   $pdf->Cell(0,0, $value["accountnumber"][2]);
    $pdf->SetXY(173 +$offsetx, 62+$offsety);   $pdf->Cell(0,0, $value["accountnumber"][3]);
    $pdf->SetXY(180 +$offsetx, 62+$offsety);   $pdf->Cell(0,0, $value["accountnumber"][4]);
    $pdf->SetXY(187 +$offsetx, 62+$offsety);   $pdf->Cell(0,0, $value["accountnumber"][5]);
    $pdf->SetXY(194 +$offsetx, 62+$offsety);   $pdf->Cell(0,0, $value["accountnumber"][6]);
    $pdf->SetXY(201+$offsetx, 62+$offsety);   $pdf->Cell(0,0, $value["accountnumber"][7]);
       
    $pdf->SetXY(240-$inttotalx+$offsetx, 54+$offsety);   $pdf->Cell(0,0, $inttotal);
    $pdf->SetXY(242+$offsetx, 54+$offsety);   $pdf->Cell(0,0, $parttotal);
    $pdf->SetXY(225+$offsetx, 63+$offsety);   $pdf->Cell(0,0, $value["total"]);
          
   }
 elseif (($value["type"] == "Lloyds TSB") && ($key<$keymax)) {
 
    $inttotal=substr($value["total"],0,strpos(($value["total"]).'.','.',0));
    $parttotal=substr($value["total"],strpos(($value["total"]).'.','.',0)+1,2);
    $inttotalx = $pdf->GetStringWidth( $inttotal );
   
    $pdf->AddPage("P",array(155,99));
    
     $offsetx=-2;
     $offsety=-1;
     
       $pdf->SetXY(0,0);   $pdf->Cell(0,0, 'M');
    
    $pdf->SetXY(135-$inttotalx+$offsetx, 35+$offsety);   $pdf->Cell(0,0, $inttotal);
    $pdf->SetXY(142+$offsetx, 35+$offsety);   $pdf->Cell(0,0, $parttotal);
    $pdf->SetXY(135-$inttotalx+$offsetx, 44+$offsety);   $pdf->Cell(0,0, $inttotal);
    $pdf->SetXY(142+$offsetx, 44+$offsety);   $pdf->Cell(0,0, $parttotal);
    
    $pdf->SetXY(9 +$offsetx, 38+$offsety);   $pdf->Cell(0,0, $value["sortcode"][0]);
    $pdf->SetXY(15 +$offsetx, 38+$offsety);   $pdf->Cell(0,0, $value["sortcode"][1]);
    $pdf->SetXY(22 +$offsetx, 38+$offsety);   $pdf->Cell(0,0, $value["sortcode"][2]);
    $pdf->SetXY(29 +$offsetx, 38+$offsety);   $pdf->Cell(0,0, $value["sortcode"][3]);
    $pdf->SetXY(35 +$offsetx, 38+$offsety);   $pdf->Cell(0,0, $value["sortcode"][4]);
    $pdf->SetXY(42 +$offsetx, 38+$offsety);   $pdf->Cell(0,0, $value["sortcode"][5]);
 
    $pdf->SetXY(9 +$offsetx, 51+$offsety);   $pdf->Cell(0,0, $value["accountnumber"][0]);
    $pdf->SetXY(15 +$offsetx, 51+$offsety);   $pdf->Cell(0,0, $value["accountnumber"][1]);
    $pdf->SetXY(23 +$offsetx, 51+$offsety);   $pdf->Cell(0,0, $value["accountnumber"][2]);
    $pdf->SetXY(29 +$offsetx, 51+$offsety);   $pdf->Cell(0,0, $value["accountnumber"][3]);
    $pdf->SetXY(35 +$offsetx, 51+$offsety);   $pdf->Cell(0,0, $value["accountnumber"][4]);
    $pdf->SetXY(42 +$offsetx, 51+$offsety);   $pdf->Cell(0,0, $value["accountnumber"][5]);
    $pdf->SetXY(48 +$offsetx, 51+$offsety);   $pdf->Cell(0,0, $value["accountnumber"][6]);
    $pdf->SetXY(54+$offsetx, 51+$offsety);   $pdf->Cell(0,0, $value["accountnumber"][7]);
    
    $pdf->SetXY(20 +$offsetx, 65+$offsety);   $pdf->Cell(0,0, $value["accountname"]);
    $pdf->SetXY(100 +$offsetx, 72+$offsety);   $pdf->Cell(0,0, $value["date"]);
    
    
    
   }

 elseif (($value["type"] == "NatWest") && ($key<$keymax)) {
  
   $inttotal=substr($value["total"],0,strpos(($value["total"]).'.','.',0));
    $parttotal=substr($value["total"],strpos(($value["total"]).'.','.',0)+1,2);
    $inttotalx = $pdf->GetStringWidth( $inttotal );
   
    $pdf->AddPage("P",array(203,145));
    
     $offsetx=-1;
     $offsety=-1;
     
       $pdf->SetXY(0,0);   $pdf->Cell(0,0, 'M');
    
    $pdf->SetXY(45 +$offsetx, 5+$offsety);   $pdf->Cell(0,0, $value["accountname"]);
    $pdf->SetXY(170 +$offsetx, 5+$offsety);   $pdf->Cell(0,0, $value["date"]);
    $pdf->SetXY(188-$inttotalx +$offsetx, 20+$offsety);   $pdf->Cell(0,0, $value["total"]);
    $pdf->SetXY(188-$inttotalx +$offsetx, 34+$offsety);   $pdf->Cell(0,0, $value["total"]);
    $pdf->SetXY(25 +$offsetx, 50+$offsety);   $pdf->Cell(0,0, $value["date"]);

    $pdf->SetXY(70 +$offsetx, 94+$offsety);   $pdf->Cell(0,0, $value["accountname"]);
    $pdf->SetXY(56 +$offsetx, 121+$offsety);   $pdf->Cell(0,0, $value["sortcode"][0]);
    $pdf->SetXY(62 +$offsetx, 121+$offsety);   $pdf->Cell(0,0, $value["sortcode"][1]);
    $pdf->SetXY(68 +$offsetx, 121+$offsety);   $pdf->Cell(0,0, $value["sortcode"][2]);
    $pdf->SetXY(74 +$offsetx, 121+$offsety);   $pdf->Cell(0,0, $value["sortcode"][3]);
    $pdf->SetXY(80 +$offsetx, 121+$offsety);   $pdf->Cell(0,0, $value["sortcode"][4]);
    $pdf->SetXY(86 +$offsetx, 121+$offsety);   $pdf->Cell(0,0, $value["sortcode"][5]);
    $pdf->SetXY(103 +$offsetx, 121+$offsety);   $pdf->Cell(0,0, $value["accountnumber"][0]);
    $pdf->SetXY(109 +$offsetx, 121+$offsety);   $pdf->Cell(0,0, $value["accountnumber"][1]);
    $pdf->SetXY(115 +$offsetx, 121+$offsety);   $pdf->Cell(0,0, $value["accountnumber"][2]);
    $pdf->SetXY(121 +$offsetx, 121+$offsety);   $pdf->Cell(0,0, $value["accountnumber"][3]);
    $pdf->SetXY(127 +$offsetx, 121+$offsety);   $pdf->Cell(0,0, $value["accountnumber"][4]);
    $pdf->SetXY(133 +$offsetx, 121+$offsety);   $pdf->Cell(0,0, $value["accountnumber"][5]);
    $pdf->SetXY(139 +$offsetx, 121+$offsety);   $pdf->Cell(0,0, $value["accountnumber"][6]);
    $pdf->SetXY(145 +$offsetx, 121+$offsety);   $pdf->Cell(0,0, $value["accountnumber"][7]);
       
    $pdf->SetXY(188-$inttotalx+$offsetx, 108+$offsety);   $pdf->Cell(0,0, $inttotal);
    $pdf->SetXY(193+$offsetx, 108+$offsety);   $pdf->Cell(0,0, $parttotal);
    $pdf->SetXY(188-$inttotalx+$offsetx, 117+$offsety);   $pdf->Cell(0,0, $inttotal);
    $pdf->SetXY(193+$offsetx, 117+$offsety);   $pdf->Cell(0,0, $parttotal);
    
   
   }
  
// if ($key<$keymax) echo "<IMG SRC=\"aa$key.png\" ><br>"; 
}

 $pdf->Output();
    
?>
