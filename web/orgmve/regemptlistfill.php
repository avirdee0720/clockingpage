<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$db1 = new CMySQL;
$tytul='Reg & Employee cat list fill';


uprstr($PU,90);

$tabletxt = "";

if (!$db->Open()) $db->Kill();
if (!$db1->Open()) $db1->Kill();


$q = "SELECT `nombers`.`pno` , `nombers`.`surname` , `nombers`.`firstname` , `nombers`.`knownas` , `nombers`.`cat` ,`nombers`.`regdays`,`nombers`.`started` FROM `nombers` WHERE `status` LIKE 'OK' Order by pno";
  
if (!$db->Query($q)) $db->Kill();
while ($row=$db->Row())
    {
    $pno = $row->pno;
    $started = $row->started;
    $cat = $row->cat;
  
    $q1 = "SELECT `regdayshistory`.`id`  FROM `regdayshistory` WHERE `regdayshistory`.`no`='$pno'";
     if (!$db1->Query($q1)) $db1->Kill();
     $row1=$db1->Row();
      $rows=$db1->Rows();
       if ($rows == 0) {
           $regdays = $row->regdays;
           $id = $row1->id;
       echo "<br> pno. $pno - $regdays - $id";
       
       //insert...
       
       
       $q1 = "SELECT (mon+tue+wed+thu+fri+sat+sun) As rd, datechange, active FROM `regdays` WHERE `regdays`.`no`='$pno'";
     if (!$db1->Query($q1)) $db1->Kill();
     $row1=$db1->Row();
     $row1s=$db1->Rows();
    
                  $rd = $row1->rd;
                  $datechange= $row1->datechange;
                  $active= $row1->active;
                  if  ($row1s != 0 && $rd!=0) $datechange = $started;
       $ins = "INSERT INTO `regdayshistory` ( `no` ,`regdaysold` , `regdays` , `datechange`, `active` ) VALUES ('$pno', '0','$regdays', '$datechange','y' )";
        if (!$db1->Query($ins)) $db1->Kill();


       }

       $q1 = "SELECT `emplcathistory`.`id`  FROM `emplcathistory` WHERE `emplcathistory`.`no`='$pno'";
       echo "sss".$q1;
     if (!$db1->Query($q1)) $db1->Kill();
     $row1=$db1->Row();
      $rows=$db1->Rows();
       if ($rows == 0) {
           $id = $row1->id;
       echo "<br> pno - emplcathistory $pno - $started";
       
       //insert...
       
       $ins = "INSERT INTO `emplcathistory` ( `no`, `catold` , `cat` , `datechange`, `active` ) VALUES ('$pno',  '','$cat',  '$started','y' )";
      if (!$db1->Query($ins)) $db1->Kill(); 
       }

    
    }



include_once("./footer.php");


?>
