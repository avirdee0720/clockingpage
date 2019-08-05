<?php

include("../inc/mysql.inc.php");
//include("./config.php");
include_once("header.php");
require 'smarty/libs/Smarty.class.php';

$floatsheetadd1 = $_POST['floatsheetadd1'];
$floatsheetadd2 = $_POST['floatsheetadd2'];

$PHP_SELF = $_SERVER['PHP_SELF'];


$db = new CMySQL;
$smarty = new Smarty;

if (!$db->Open()) $db->Kill();

$dataakt=date("d/m/Y H:i:s");
$dataakt2=date("d/m/Y");
$daytext=date("l");
$daytextnumber=date("w");

//$smarty->compile_check = true;
//$smarty->debugging = true;

if (isset($floatsheetadd1) or isset($floatsheetadd2)) {

echo "Haha";

//insert 


}




$q = "
SELECT fs_float.floatsheetid,user_morning,user_evening,user_floatsheet, DATE_FORMAT(`date`,\"%d/%m/%Y\") AS fsdate,dayofweek(fs_float.date) As doweek,fs_float.valid,fs_tabledesc.tabledescid, fs_tabledesc.tableid, fs_floatfield.floatfieldid, fs_floatfield.fieldname, fs_floatfield.floatfieldsmall,fs_tabledesc.row, fs_tabledesc.coloumn, fs_value.value, fs_float.shopid, fs_departments.name As depname, fs_float.departmentid, fs_shops.name As shopsname
FROM ((((((((fs_float INNER JOIN fs_value ON fs_float.floatsheetid = fs_value.floatsheetid) INNER JOIN fs_tabledesc ON fs_value.tabledescid = fs_tabledesc.tabledescid) INNER JOIN fs_table ON fs_tabledesc.tableid = fs_table.tableid) INNER JOIN fs_floatfield ON fs_tabledesc.floatfieldid = fs_floatfield.floatfieldid) LEFT JOIN fs_expense ON fs_float.floatsheetid = fs_expense.floatsheetid) LEFT JOIN fs_overring ON fs_float.floatsheetid = fs_overring.floatsheetid) LEFT JOIN fs_transfer ON fs_float.floatsheetid = fs_transfer.floatsheetid) LEFT JOIN fs_shops ON fs_float.shopid = fs_shops.id) LEFT JOIN fs_departments ON fs_float.departmentid = fs_departments.dep_id;";

  if (!$db->Query($q)) $db->Kill(); 


while ($row=$db->Row())
    {
    
    $floatsheetid=$row->floatsheetid;
    $tabledescid=$row->tabledescid;
    $shopid=$row->shopid;
    $departmentid=$row->departmentid; 
    $fsdate=$row->fsdate; 
    $fsdateofweek=$row->doweek; 
    $user_morning=$row->user_morning; 
    $user_evening=$row->user_evening; 
    $user_floatsheet=$row->user_floatsheet;    
    $valid=$row->valid;    
    
    $floats[] = array("floatsheetid" => $row->floatsheetid,
                      "tabledescid" => $row->tabledescid,
                      "floatfieldid" => $row->floatfieldid,
                      "fieldname" => $row->fieldname,
                      "value" => $row->value,
                      "shopid" => $row->shopid,
                      "shopsname" => $row->shopsname,
                      "departmentid" => $row->departmentid,
                      "depname" => $row->depname,
                      "user_morning" => $row->user_morning,
                      "user_evening" => $row->user_evening,
                      "user_floatsheet" => $row->user_floatsheet);
                      
    $floatsvalue["$row->tabledescid"] = $row->value;
                      
    }


$q = "SELECT fs_shops.* FROM fs_shops;";

  if (!$db->Query($q)) $db->Kill(); 


while ($row=$db->Row())
    {
    $shop[] = array("shopid" => $row->id,
                      "shopname" => $row->name);
    }

$q = "SELECT fs_departments.dep_id, fs_departments.name FROM fs_departments; ";

  if (!$db->Query($q)) $db->Kill(); 


while ($row=$db->Row())
    {
    $department[] = array("depid" => $row->dep_id,
                      "department" => $row->name);
    }


$q = "SELECT * FROM `hd_users`";

  if (!$db->Query($q)) $db->Kill(); 

while ($row=$db->Row())
    {
    $user[] = array("userid" => $row->lp,
                      "login" => $row->login,
                      "username" => $row->nazwa);
    }


$q = "SELECT fs_state.stateid, fs_state.valid, fs_state.statetxt
FROM fs_state;";

if (!$db->Query($q)) $db->Kill(); 

while ($row=$db->Row())
    {
  
    $state[] = array("stateid" => $row->stateid,
                      "valid" => $row->valid,
                      "statetxt" => $row->statetxt
                      );
    }
    

$q = "SELECT fs_days.id, fs_days.day FROM fs_days where fs_days.id='$fsdateofweek';";

    if (!$db->Query($q)) $db->Kill();
     
                    $row=$db->Row();

                      $fsdateofweektxt = $row->day;
   

$q = "SELECT fs_overring.overringid, fs_overring.floatsheetid, fs_overring.departmentid, fs_department_status.department, fs_overring.cv, fs_overring.amount
FROM fs_overring INNER JOIN fs_department_status ON fs_overring.departmentid = fs_department_status.id
WHERE (((fs_overring.floatsheetid)='$floatsheetid'));";

if (!$db->Query($q)) $db->Kill(); 

while ($row=$db->Row())
    {
    $overring[] = array("overringid" => $row->overringid,
                      "departmentid" => $row->departmentid,
                      "department" => $row->department,
                      "cv" => $row->cv,
                      "amount" => $row->amount
                      );
    }

$q = "SELECT fs_transfer.transferid, fs_transfer.transferfrom, fs_transfer.transferto, fs_transfer.cv, fs_transfer.amountin, fs_transfer.amountout
FROM fs_transfer
WHERE (((fs_transfer.floatsheetid)='$floatsheetid'));";

if (!$db->Query($q)) $db->Kill(); 

while ($row=$db->Row())
    {
    $transfer[] = array("transferid" => $row->transferid,
                      "transferfrom" => $row->transferfrom,
                      "transferto" => $row->transferto,
                      "cv" => $row->cv,
                      "amountin" => $row->amountin,
                      "amountout" => $row->amountout,
                      );
    }

$q = "SELECT fs_expense.expenseid, fs_expense.expense, fs_expense.amount
FROM fs_expense
WHERE (((fs_expense.floatsheetid)='$floatsheetid'));";

if (!$db->Query($q)) $db->Kill(); 

while ($row=$db->Row())
    {
    $expense[] = array("expenseid" => $row->expenseid,
                      "expense" => $row->expense,
                      "amount" => $row->amount
                      );
    }

$q = "SELECT fs_report.reportid, fs_report.reporttext, fs_report.userid
FROM fs_report
WHERE (((fs_report.floatsheetid)='$floatsheetid'));";

if (!$db->Query($q)) $db->Kill(); 

while ($row=$db->Row())
    {
    $user_report = $row->userid;
    $report[] = array("reportid" => $row->reportid,
                      "reporttext" => $row->reporttext,
                      "userid" => $row->userid
                      );
    }
    

    
        
$smarty->assign("dataakt",$dataakt);
$smarty->assign("dataakt2",$dataakt2);
$smarty->assign("daytext",$daytext);
$smarty->assign("daytextnu",$daytextnu);


$smarty->assign("floats",$floats);
$smarty->assign("floatsvalue",$floatsvalue);
$smarty->assign("shop",$shop);
$smarty->assign("shop",$shop);
$smarty->assign("department",$department);
$smarty->assign("user",$user);

$smarty->assign("floatsheetid",$floatsheetid);
$smarty->assign("tabledescid",$tabledescid);
$smarty->assign("shopid",$shopid);
$smarty->assign("departmentid",$departmentid);
$smarty->assign("valid",$valid);
$smarty->assign("fsdate",$fsdate);
$smarty->assign("fsdateofweektxt",$fsdateofweektxt);
$smarty->assign("user_morning",$user_morning);
$smarty->assign("user_evening",$user_evening);
$smarty->assign("user_floatsheet",$user_floatsheet);
$smarty->assign("user_report",$user_report);
$smarty->assign("overring",$overring);
$smarty->assign("transfer",$transfer);
$smarty->assign("expense",$expense);
$smarty->assign("report",$report);
$smarty->assign("report",$report);
$smarty->assign("state",$state);

$smarty->assign("PHP_SELF",$PHP_SELF);

$smarty->display('float_sheet.html');


include_once("../footer.php");

?>
