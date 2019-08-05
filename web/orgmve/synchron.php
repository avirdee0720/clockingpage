<?php

include("./inc/mysql.inc.php");
include("./inc/mysql.ext.inc.php");

require('libs/Smarty.class.php');

/* state = 1 
upload 
Inout|date
IPAddress|full
Newatwork|full
Nombers|full
download 
0

state=2
upload 
IPAddress|full
Newatwork|full
Nombers|full
dowload      
Inout|missing
Newatwork|missing


*/
$smarty = new Smarty;
                    
$db = new CMySQL;
$db_ext = new CMySQL_ext;

if (!$db->Open()) $db->Kill();
if (!$db_ext->Open()) $db_ext->Kill();



$PHP_SELF=$_SERVER['PHP_SELF'];

$state=$_POST['state'];
$ip=$_SERVER['REMOTE_ADDR'];

$sqlcmd = "";
$sqlcmd_ext = "";
 
$state = "2";


if ($state == "1")
{
del_ext("full");
list($inoutid, $ipaddressid,$nombersid,$newatworkid)=upload_init();
upload_inout($inoutid);
upload_IPAddress($ipaddressid);
upload_Newatwork($newatworkid);
upload_Nombers($nombersid);    

save_ext($sqlcmd_ext,$inoutid, $ipaddressid,$nombersid,$newatworkid);

echo "Upload is ok.";

}


if ($state == "2")
{
del_ext("small");
list($inoutid, $ipaddressid,$nombersid,$newatworkid)=upload_init();

upload_IPAddress($ipaddressid);
upload_Newatwork($newatworkid);
upload_Nombers($nombersid);

//list($inoutid, $newatworkid)=download_init();

download_inout();
download_Newatwork();

echo "Download is ok.";

}

function del_ext($what) {


$db_ext = new CMySQL_ext;

if (!$db_ext->Open()) $db_ext->Kill();

//del tables

if ($what == "full") {
$sqlcmd_ext .= "DELETE FROM `inout`\n";
}

$sqlcmd_ext .= "DELETE FROM `ipaddress`\n";
$sqlcmd_ext .="DELETE FROM `newatwork`\n";
$sqlcmd_ext .= "DELETE FROM `nombers`\n";

}


function upload_init() {


$db = new CMySQL;

if (!$db->Open()) $db->Kill();

//del tables


$q0 = "SELECT max( id )+1 AS inoutid FROM `inout`";
if (!$db->Query($q0)) $db->Kill();
$row0=$db->Row();
$inoutid = $row0->inoutid ;

$q0 = "SELECT max( ID )+1 AS ipaddressid FROM `ipaddress`";
if (!$db->Query($q0)) $db->Kill();
$row0=$db->Row();
$ipaddressid= $row0->ipaddressid ;

$q0 = "SELECT max( id )+1 AS newatworkid FROM `newatwork`";
if (!$db->Query($q0)) $db->Kill();
$row0=$db->Row();
$newatworkid = $row0->newatworkid ;

$q0 = "SELECT max( ID )+1 AS nombersid FROM `nombers`";
if (!$db->Query($q0)) $db->Kill();
$row0=$db->Row();
$nombersid= $row0->nombersid;


return array($inoutid, $ipaddressid,$nombersid,$newatworkid);     
     
     
}

function upload_inout($inoutid) { 

$db = new CMySQL;

if (!$db->Open()) $db->Kill();


  $q = "SELECT `id`, `ino`, `date1`, `intime`, `outtime`, `no`, `descin`, `descout`, `ipadr`, `checked`, `cur_timestamp` 
  FROM `inout` 
  Where date1=CURDATE() Order by no;
  ";
  if ($db->Query($q)) 
  {

    while ($row=$db->Row())
    {
     
    $id=$row->id;
    $ino=$row->ino;
    $date1=$row->date1;
    $intime=$row->intime;
    $outtime=$row->outtime;
    $no=$row->no;
    $descin=$row->descin;
    $descout=$row->descout;
    $ipadr=$row->ipadr;
    $checked=$row->checked;
    $cur_timestamp=$row->cur_timestamp;

  $sqlcmd_ext .= "INSERT INTO `inout` 
  VALUES ($id, '$ino', '$date1', '$intime', '$outtime', $no, '$descin', '$descout', '$ipadr', '$checked', '$cur_timestamp');\n";

 }
  
  
   
   }

}



function upload_IPAddress($ipaddressid) { 

$db = new CMySQL;


if (!$db->Open()) $db->Kill();

  $q = "SELECT `ID`, `name`, `IP`, `namefb`, `mac`, `costdep`, `cur_timestamp` FROM `ipaddress`
  ";
  if ($db->Query($q)) 
  {

    while ($row=$db->Row())
    {
    
    $id=$row->ID;
    $name=$row->name;
    $IP=$row->IP;
    $namefb=$row->namefb;
    $mac=$row->mac;
    $costdep=$row->costdep;
    $cur_timestamp=$row->cur_timestamp;
    
     $name = $db->Fix($name);
     $namefb = $db->Fix($namefb);
      
    


   $sqlcmd_ext .="INSERT INTO `ipaddress` VALUES ($id, '$name', '$IP', '$namefb', '$mac', '$costdep', '$cur_timestamp');\n";
   }

  
   }

}


function upload_Newatwork($newatworkid) {

$db = new CMySQL;

if (!$db->Open()) $db->Kill();


  $q = "SELECT `id`, `date1`, `intime`, `no`, `ipadr`, `checked`, `cur_timestamp` FROM `newatwork` WHERE date1=CURDATE() Order by no
  ";
  if ($db->Query($q)) 
  {

    while ($row=$db->Row())
    {
    
    $id=$row->id;
    $date1=$row->date1;
    $intime=$row->intime;
    $no=$row->no;
    $ipadr=$row->ipadr;
    $checked=$row->checked;
    $cur_timestamp=$row->cur_timestamp;


   $sqlcmd_ext .= "INSERT INTO `newatwork` VALUES ($id, '$date1', '$intime', $no, '$ipadr', '$checked', '$cur_timestamp');\n";
  
   }
   
   }


}



function upload_Nombers($nombersid) { 

$db = new CMySQL;

if (!$db->Open()) $db->Kill();


  $q = "SELECT `ID`, `pno`, `code`, `app_state`, `title`, `surname`, `firstname`, `knownas`, `paystru`, `newpayslip`, `daylyrate`,
   `currentratefrom`, `rent`, `status`, `started`, `left1`, `dateforbonus`, `dateforattendence`, `bonusmonth`, `offsetmonth`, 
   `monthforav`, `withholdbonuses`, `cat`, `cattoname`, `tax_code`, `advances`, `bonustype`, `vouchertype`, `previous12m`, `wendbonus`, 
   `weekendrequired`, `puncbonus`, `bonus5`, `bonus7`, `bhmbonus`, `secutitybonus`, `travelcard`, `travelctotal`, `xmasbonus`, `from1`,
    `to1`, `dueend`, `regdays`, `ipadr`, `bonusrate`, `wrate`, `addtowrate`, `newpuncbonus`, `tocheck`, `VCond3`, `VCond375`, `VCond70`, 
    `VE`, `VFV`, `textperson`, `textpostoneyear`, `sign`, `cur_timestamp`, `cloffice`,`cloffice_only`, `displ`, `trusted` 
    FROM `nombers` 
    WHERE status='OK' Order by pno
  ";
  if ($db->Query($q)) 
  {

    while ($row=$db->Row())
    {
       
   
   
   $ID=$row->ID;
    $pno=$row->pno;
    $code=$row->code;
    $app_state=$row->app_state;
    $title=$row->title;
    $surname=$row->surname;
    $firstname=$row->firstname;
    $knownas=$row->knownas;
    $paystru=$row->paystru;
    $newpayslip=$row->newpayslip;
    $daylyrate=$row->daylyrate;   
    $currentratefrom=$row->currentratefrom;
    $rent=$row->rent;
    $status=$row->status;
    $started=$row->started;
    $left1=$row->left1;
    $dateforbonus=$row->dateforbonus;
    $dateforattendence=$row->dateforattendence;
    $bonusmonth=$row->bonusmonth;
    $offsetmonth=$row->offsetmonth;
    $monthforav=$row->monthforav;
    $withholdbonuses=$row->withholdbonuses;
    $cat=$row->cat;
    $cattoname=$row->cattoname;
    $tax_code=$row->tax_code;
    $advances=$row->advances;
    $bonustype=$row->bonustype;
    $vouchertype=$row->vouchertype;
    $previous12m=$row->previous12m;
    $wendbonus=$row->wendbonus;
    $weekendrequired=$row->weekendrequired;
    $puncbonus=$row->puncbonus;
    $bonus5=$row->bonus5;
    $bonus7=$row->bonus7;
    $bhmbonus=$row->bhmbonus;
    $secutitybonus=$row->secutitybonus;
    $travelcard=$row->travelcard;
    $travelctotal=$row->travelctotal;
    $xmasbonus=$row->xmasbonus;
    $from1=$row->from1;
    $to1=$row->to1;
    $dueend=$row->dueend;
    $regdays=$row->regdays;
    $ipadr=$row->ipadr;
    $bonusrate=$row->bonusrate;
    $wrate=$row->wrate;
    $addtowrate=$row->addtowrate;
    $newpuncbonus=$row->newpuncbonus;
    $tocheck=$row->tocheck;
    $VCond3=$row->VCond3;
    $VCond375=$row->VCond375;
    $VCond70=$row->VCond70;
    $VE=$row->VE;
    $VFV=$row->VFV;
    $textperson=$row->textperson;
    $textpostoneyear=$row->textpostoneyear;
    $sign=$row->sign;
    $cur_timestamp=$row->cur_timestamp;
    $cloffice=$row->cloffice;
    $cloffice_only=$row->cloffice_only;
    $displ=$row->displ;
    $trusted=$row->trusted;
    

      $surname= $db->Fix($surname);
      $firstname =$db->Fix($firstname);
      $knownas= $db->Fix($knownas);
      $textperson= $db->Fix($textperson);
       
   
 $sqlcmd_ext .= "INSERT INTO `nombers` VALUES 
  ($ID, $pno, '$code', '$app_state', '$title', '$surname', '$firstname', '$knownas', '$paystru', '$newpayslip', '$daylyrate', '$currentratefrom', $rent, '$status', 
  '$started', '$left1', ' $dateforbonus', '$dateforattendence', '$bonusmonth', '$offsetmonth', '$monthforav', '$withholdbonuses',
   '$cat', '$cattoname', '$tax_code', '$advances', '$bonustype', '$vouchertype','$previous12m', '$wendbonus', '$weekendrequired', '$puncbonus', '$bonus5', '$bonus7',
    '$bhmbonus', '$secutitybonus', '$travelcard', '$travelctotal', '$xmasbonus', '$from1', '$to1', '$dueend', $regdays, '$ipadr', '$bonusrate', '$wrate',
     '$addtowrate', '$newpuncbonus', '$tocheck', '$VCond3', '$VCond375', '$VCond70', '$VE', '$VFV', '$textperson', '$textpostoneyear', '$sign', '$cur_timestamp', '$cloffice','$cloffice_only', '$displ', '$trusted');\n";
        
 
   }
   
   }

}


function save_ext($sqlcmd_ext,$inoutid, $ipaddressid,$nombersid,$newatworkid) {

 $db_ext = new CMySQL_ext;
 
 if (!$db_ext->Open()) $db_ext->Kill();
   if (!$db_ext->Query($sqlcmd_ext)) $db_ext->Kill();
   else " DB_ext saved";
   
  
  $q0 = "ALTER TABLE `nombers` AUTO_INCREMENT = $nombersid; ";
  if (!$db_ext->Query($q0)) $db_ext->Kill();
   
  $q0 = "ALTER TABLE `inout` AUTO_INCREMENT = $inoutid; ";
  if (!$db_ext->Query($q0)) $db_ext->Kill();
 
  $q0 = "ALTER TABLE `ipaddress` AUTO_INCREMENT = $ipaddressid; ";
  if (!$db_ext->Query($q0)) $db_ext->Kill(); 
  
   $q0 = "ALTER TABLE `newatwork` AUTO_INCREMENT = $newatworkid; ";
  if (!$db_ext->Query($q0)) $db_ext->Kill();
   
}


function download_inout() { 

$db = new CMySQL;
$db_ext = new CMySQL_ext;

if (!$db->Open()) $db->Kill();
if (!$db_ext->Open()) $db_ext->Kill();

  $sql_settimezone = "SET SESSION time_zone = \"+0".date("I").":00\"; ";
  $db_ext->Query($sql_settimezone);
  
  $q = "SELECT `id`, `ino`, `date1`, `intime`, `outtime`, `no`, `descin`, `descout`, `ipadr`, `checked`, `cur_timestamp` 
  FROM `inout` 
  Where date1=CURDATE() Order by no ASC, intime DESC;
  ";
  if ($db_ext->Query($q)) 
  {

    while ($row=$db->Row())
    {
            echo "S";
    $id=$row->id;
    $ino=$row->ino;
    $date1=$row->date1;
    $intime=$row->intime;
    $outtime=$row->outtime;
    $no=$row->no;
    $descin=$row->descin;
    $descout=$row->descout;
    $ipadr=$row->ipadr;
    $checked=$row->checked;
    $cur_timestamp=$row->cur_timestamp;

  $q0 = "INSERT INTO `inout2` 
  VALUES ('$ino', '$date1', '$intime', '$outtime', $no, '$descin', '$descout', '$ipadr', '$checked', '$cur_timestamp');
    ";
  if (!$db->Query($q0)) $db->Kill();
  
   }
   
   }


}



function download_Newatwork() {

$db = new CMySQL;
$db_ext = new CMySQL_ext;

if (!$db->Open()) $db->Kill();
if (!$db_ext->Open()) $db_ext->Kill(); 

$sql_settimezone = "SET SESSION time_zone = \"+0".date("I").":00\"; ";
  $db_ext->Query($sql_settimezone) ;

  $q = "SELECT `id`, `date1`, `intime`, `no`, `ipadr`, `checked`, `cur_timestamp` FROM `newatwork` WHERE date1=CURDATE() Order by no
   Order by intime, no";
  if ($db_ext->Query($q)) 
  {

    while ($row=$db->Row())
    {
    
    $id=$row->id;
    $date1=$row->date1;
    $intime=$row->intime;
    $no=$row->no;
    $ipadr=$row->ipadr;
    $checked=$row->checked;
    $cur_timestamp=$row->cur_timestamp;


  $q0 = "INSERT INTO `newatwork2` VALUES ('$date1', '$intime', $no, '$ipadr', '$checked', '$cur_timestamp');";
  if (!$db->Query($q0)) $db->Kill();
  
   }
   
   }

}





?>
