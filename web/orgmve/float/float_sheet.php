<?php

ini_set('memory_limit', '16M');

include("../inc/mysql.inc.php");
//include("./config.php");
include_once("header.php");
require 'smarty/libs/Smarty.class.php';

$floatsheetadd1 = $_POST['floatsheetadd1'];
$floatsheetadd2 = $_POST['floatsheetadd2'];
$overringnumber = $_POST["overringnumber"];
$transfernumber = $_POST["transfernumber"];
$expensenumber = $_POST["expensenumber"];
$count = $_POST["count"];

$edit = $_GET['edit'];
if ($edit == "") $edit = $_POST['edit'];

$floatsheetid = $_GET['fsid'];
if ($floatsheetid == "") $floatsheetid = $_POST['floatsheetid'];
if ($floatsheetid == "") $floatsheetid ='%';

$floatsheettype = $_GET['floatsheettype'];
if ($floatsheettype == "") $floatsheettype = $_POST['floatsheettype'];
if ($floatsheettype == "") $floatsheettype ='1';


$PHP_SELF = $_SERVER['PHP_SELF'];

$db = new CMySQL;
$smarty = new Smarty;

if (!$db->Open()) $db->Kill();

$dataakt=date("d/m/Y H:i:s");
$dataakt2=date("d/m/Y");
$daytext=date("l");
$daytextnumber=date("w");

if ($edit == "new" or $edit=="edit") $float_sheet_html = "float_sheet_edit.html";
else $float_sheet_html = "float_sheet.html";

//$smarty->compile_check = true;
//$smarty->debugging = true;


$q = "SELECT fs_tabledesc.tabledescid, fs_tabledesc.tableid, fs_tabledesc.floatsheettype
FROM fs_tabledesc
WHERE (((fs_tabledesc.floatsheettype)='$floatsheettype'));";

  if (!$db->Query($q)) $db->Kill(); 


while ($row=$db->Row())
    {
    $tabledescid[] = $row->tabledescid;
    }


if ((isset($floatsheetadd1) or isset($floatsheetadd2)) && $edit != "new") {

echo "update";

$fsdata = postdata($tabledescid);

//insert 
$edit= "old";
$message = "I have updated the Float Sheet.";
$float_sheet_html = "float_sheet.html";
}

elseif ((isset($floatsheetadd1) or isset($floatsheetadd2) or isset($count)) && $edit == "new") {

echo "insert";
// Post overrings, reports...

$fsdata = postdata($tabledescid);
$overringdata = postdata2("overring");
$transferdata = postdata2("transfer");
$expensedata = postdata2("expense");
//insert
$reporttext = $_POST['reporttext'];
$user_report = $_POST['user_report'];

$fsdata = countnumber ($fsdata);

$numberfsdata =  controllnumber($fsdata);
// $floatsheetid = last_insert( fd_id);
  $query ="INSERT INTO `fs_float` (`floatsheettype`,`user_morning`,`user_evening`,`user_floatsheet`,`shopid`,`departmentid`, `date`, `date_edit`,`valid`) VALUES('1','1','1','1','6','36',NOW(),NOW(),'1')";
  $db->Query($query);

 $query ="SELECT  LAST_INSERT_ID() As id";
  $db->Query($query);
  $row=$db->Row();
  $floatsheetid=$row->id;
/*
foreach ($tabledescid as $key => $value) {

  $query ="INSERT INTO `fs_value` (`floatsheetid`,`tabledescid`,`value`) VALUES('$floatsheetid','$value','$fsdata[$value]')";
  echo  $query . "<br>";
  //$db->Query($query);

}
*/

foreach ($fsdata as $key => $value) {

  $query ="INSERT INTO `fs_value` (`floatsheetid`,`tabledescid`,`value`) VALUES('$floatsheetid','$key','$value')";
  $db->Query($query);

}

for ($i=0;$i<$overringnumber;$i++) {
 $query ="INSERT INTO `fs_overring` (`floatsheetid`,`departmentid`,`cvid`,`amount`) VALUES('".$floatsheetid."','".$overringdata[$i][0]."','".$overringdata[$i][1]."','".$overringdata[$i][2]."')";
   $db->Query($query);
}
for ($i=0;$i<$transfernumber;$i++) {
 $query ="INSERT INTO `fs_transfer` (`floatsheetid`,`transferfrom`,`transferto`,`cvid`,`amountin`,`amountout`) VALUES('".$floatsheetid."','".$transferdata[$i][0]."','".$transferdata[$i][1]."','".$transferdata[$i][2]."','".$transferdata[$i][3]."','".$transferdata[$i][4]."')";
  $db->Query($query);
}

for ($i=0;$i<$expensenumber;$i++) {
 $query ="INSERT INTO `fs_expense` (`floatsheetid`,`expense`,`amount`) VALUES('$floatsheetid','".$expensedata[$i][0]."','".$expensedata[$i][1]."')";
  $db->Query($query);
} 
 
 $query ="INSERT INTO `fs_report` (`floatsheetid`,`reporttext`,`userid`) VALUES('$floatsheetid','$reporttext','$user_report')";
  $db->Query($query);
 
if ($numberfsdata == 1 && !isset($count)) {
$message = "I have added a new Float Sheet.";
$float_sheet_html = "float_sheet.html";
}
else {
$message = "There was bad data!";
$float_sheet_html = "float_sheet_edit.html";
}


}


$q = "
SELECT fs_float.floatsheetid, DATE_FORMAT(`date`,\"%d/%m/%Y\") AS fsdate,dayofweek(fs_float.date) As doweek,fs_float.valid,fs_tabledesc.tabledescid, fs_tabledesc.tableid, fs_floatfield.floatfieldid, fs_floatfield.fieldname, fs_floatfield.floatfieldsmall,fs_tabledesc.row, fs_tabledesc.coloumn, fs_value.value, fs_float.shopid, fs_departments.name As depname, fs_float.departmentid, fs_shops.name As shopsname, fs_user.orgmveid As user_morning, fs_user_1.orgmveid As user_evening, fs_user_2.orgmveid As user_floatsheet
FROM (((((((((((fs_float INNER JOIN fs_value ON fs_float.floatsheetid = fs_value.floatsheetid) INNER JOIN fs_tabledesc ON fs_value.tabledescid = fs_tabledesc.tabledescid) INNER JOIN fs_table ON fs_tabledesc.tableid = fs_table.tableid) INNER JOIN fs_floatfield ON fs_tabledesc.floatfieldid = fs_floatfield.floatfieldid) LEFT JOIN fs_expense ON fs_float.floatsheetid = fs_expense.floatsheetid) LEFT JOIN fs_overring ON fs_float.floatsheetid = fs_overring.floatsheetid) LEFT JOIN fs_transfer ON fs_float.floatsheetid = fs_transfer.floatsheetid) LEFT JOIN fs_shops ON fs_float.shopid = fs_shops.id) LEFT JOIN fs_departments ON fs_float.departmentid = fs_departments.dep_id) LEFT JOIN fs_user ON fs_float.user_morning = fs_user.userid) LEFT JOIN fs_user AS fs_user_1 ON fs_float.user_evening = fs_user_1.userid) LEFT JOIN fs_user AS fs_user_2 ON fs_float.user_floatsheet = fs_user_2.userid
Where fs_float.floatsheetid='$floatsheetid'";

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


$q = "SELECT * FROM `hd_users` Where PU<>'0'";

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
    
    $statelist[] = array("stateid" => $row->stateid,
                      "valid" => $row->valid,
                      "statetxt" => $row->statetxt
                      );
                       
    }
  

$q = "SELECT fs_days.id, fs_days.day FROM fs_days where fs_days.id='$fsdateofweek';";

    if (!$db->Query($q)) $db->Kill();
     
                    $row=$db->Row();

                      $fsdateofweektxt = $row->day;

$q = "SELECT fs_cv.cvid, fs_cv.cvtext FROM fs_cv;";

    if (!$db->Query($q)) $db->Kill();
     
 while ($row=$db->Row())
    {
    
    $cvlist[] = array("cvid" => $row->cvid,
                      "cvtext" => $row->cvtext
                      );
                       
    }



$q = "SELECT fs_overring.overringid, fs_overring.floatsheetid, fs_overring.departmentid, fs_department_status.department,fs_cv.cvid As cvid, fs_cv.cvtext As cv, fs_overring.amount
FROM (fs_overring INNER JOIN fs_department_status ON fs_overring.departmentid = fs_department_status.id) LEFT JOIN fs_cv ON fs_overring.cvid = fs_cv.cvid
WHERE (((fs_overring.floatsheetid)='$floatsheetid'));";

if (!$db->Query($q)) $db->Kill(); 

$overringnumber=$db->Rows();
if ($overringnumber == 0) {$overringnumber =1; $overring[] = array();}

while ($row=$db->Row())
    {
    $overring[] = array("overringid" => $row->overringid,
                      "departmentid" => $row->departmentid,
                      "department" => $row->department,
                      "cvid" => $row->cvid,
                      "amount" => $row->amount
                      );
    }

$q = "SELECT fs_transfer.transferid, fs_transfer.transferfrom, fs_transfer.transferto, fs_transfer.cvid,fs_cv.cvtext As cv, fs_transfer.amountin, fs_transfer.amountout
FROM fs_transfer LEFT JOIN fs_cv ON fs_transfer.cvid = fs_cv.cvid
WHERE (((fs_transfer.floatsheetid)='$floatsheetid'));";

if (!$db->Query($q)) $db->Kill(); 

$transfernumber=$db->Rows();
if ($transfernumber == 0) {$transfernumber =1; $transfer[] = array();}

while ($row=$db->Row())
    {
    $transfer[] = array("transferid" => $row->transferid,
                      "transferfrom" => $row->transferfrom,
                      "transferto" => $row->transferto,
                      "cvid" => $row->cvid,
                      "amountin" => $row->amountin,
                      "amountout" => $row->amountout
                      );
    }

$q = "SELECT fs_expense.expenseid, fs_expense.expense, fs_expense.amount
FROM fs_expense
WHERE (((fs_expense.floatsheetid)='$floatsheetid'));";

if (!$db->Query($q)) $db->Kill(); 

$expensenumber=$db->Rows();
if ($expensenumber == 0) {$expensenumber =1; $expense[] = array();}

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
if ($fsdate == "") $fsdate =$dataakt2;    

$smarty->assign("message",$message);  
$smarty->assign("PHP_SELF",$PHP_SELF);
        
$smarty->assign("dataakt",$dataakt);
$smarty->assign("dataakt2",$dataakt2);
$smarty->assign("daytext",$daytext);
$smarty->assign("daytextnu",$daytextnu);



$smarty->assign("floats",$floats);
$smarty->assign("floatsvalue",$floatsvalue);

$smarty->assign("shop",$shop);
$smarty->assign("department",$department);
$smarty->assign("cvlist",$cvlist);
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
$smarty->assign("overringnumber",$overringnumber);
$smarty->assign("transfernumber",$transfernumber);
$smarty->assign("expensenumber",$expensenumber);
$smarty->assign("report",$report);
$smarty->assign("statelist",$statelist);

$smarty->assign("edit",$edit);

$smarty->display($float_sheet_html);


function postdata($tabledescid) {

foreach ($tabledescid as $key => $value) {
if ($_POST["f$value"] != "") $postdata[$value] = $_POST["f$value"];
}

return $postdata;
}

function postdata2($type) {
$postdata2= array();
if ($type == "overring") {
$overringnumber = $_POST["overringnumber"];
for ($i=0;$i<$overringnumber;$i++) {
 $postdata2[] = array ($_POST["overringdepartmentid_$i"],$_POST["overringcv_$i"],$_POST["overringamount_$i"]);
}
}
elseif ($type == "transfer") {
$transfernumber = $_POST["transfernumber"];
for ($i=0;$i<$transfernumber;$i++) {
 $postdata2[] = array ($_POST["transferfrom_$i"],$_POST["transferto_$i"],$_POST["transfercv_$i"],$_POST["transferamountin_$i"],$_POST["transferamountout_$i"]);
}
}
elseif ($type == "expense") {
$expensenumber = $_POST["expensenumber"];
for ($i=0;$i<$expensenumber;$i++) {
 $postdata2[] = array ($_POST["expense_$i"],$_POST["expenseamount_$i"]);
}
}

return $postdata2;
}

function controllnumber($number) {
$numberok = 1;
foreach ($number as $key => $value) {
if (is_numeric($value) == FALSE) {$numberok=0;}
}
return $numberok;
}

function countnumber($number) {

$number[15] =
$number[1] + $number[3] + $number[5] +
$number[7] + $number[9] + $number[11] +
$number[13];
$number[16]=
$number[2] + $number[4] + $number[6] +
$number[8] + $number[10] + $number[12] +
$number[14];
$number[21]=
$number[15] + $number[17] + $number[19];
$number[22]=
$number[16] + $number[18] + $number[20];
$number[37]=
$number[23] + $number[25] + $number[27] +
$number[29] + $number[31] + $number[33] +
$number[35];
$number[38]=
$number[24] + $number[26] + $number[27] +
$number[30] + $number[32] + $number[34] +
$number[36];
$number[43]=
$number[37] + $number[39] + $number[41];
$number[44]=
$number[38] + $number[40] + $number[42];
$number[51]=
$number[43] + $number[45] + $number[47] + $number[49];
$number[52]=
$number[44] + $number[46] + $number[48] + $number[50];

$number[55]=
$number[53] + $number[54];
$number[58]=
$number[56] + $number[57];
$number[61]=
$number[59] + $number[60];
$number[62]=
$number[53] + $number[56]+ $number[59];
$number[63]=
$number[54] + $number[57]+ $number[60];
$number[64]=
$number[62] + $number[63];

$number[67]=
$number[65] + $number[66];
$number[70]=
$number[68] + $number[69];
$number[73]=
$number[71] + $number[72];
$number[76]=
$number[74] + $number[75];
$number[77]=
$number[65] + $number[68] + $number[71] + $number[74];
$number[78]=
$number[66] + $number[69] + $number[72] + $number[75];
$number[79]=
$number[67] + $number[70] + $number[73] + $number[76];


$number[113]=
$number[80] + $number[83] + $number[86] + $number[89] + $number[92] + $number[95] + $number[98] + $number[101] + $number[104] + $number[107] + $number[110];

$number[114]=
$number[81] + $number[84] + $number[87] + $number[90] + $number[93] + $number[96] + $number[99] + $number[102] + $number[105] + $number[108] + $number[111];

$number[82] =  $number[80] +  $number[81];
$number[85] =  $number[83] +  $number[84];
$number[88] =  $number[86] +  $number[87];
$number[91] =  $number[89] +  $number[90];
$number[94] =  $number[92] +  $number[93];
$number[97] =  $number[95] +  $number[96];
$number[100] =  $number[98] +  $number[99];
$number[103] =  $number[101] +  $number[102];
$number[106] =  $number[104] +  $number[105];
$number[109] =  $number[107] +  $number[108];
$number[112] =  $number[110] +  $number[111];


$number[115]=
$number[82] + $number[85] + $number[88] + $number[91] + $number[94] + $number[97] + $number[100] + $number[103] + $number[106] + $number[109] + $number[112];



$number[131]=
$number[116] + $number[119] + $number[122] + $number[125] + $number[128];

$number[132]=
$number[117] + $number[120] + $number[123] + $number[126] + $number[129];

$number[118] =  $number[116] +  $number[117];
$number[121] =  $number[119] +  $number[120];
$number[124] =  $number[122] +  $number[123];
$number[127] =  $number[125] +  $number[126];
$number[130] =  $number[128] +  $number[129];
$number[133] =  $number[131] +  $number[132];



return $number;
}


include_once("../footer.php");

?>
