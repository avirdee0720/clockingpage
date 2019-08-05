<?php

include("../inc/mysql.inc.php");
//include("./config.php");
include_once("../header.php");
require 'smarty/libs/Smarty.class.php';

$PHP_SELF = $_SERVER['PHP_SELF'];

$db = new CMySQL;
$smarty = new Smarty;

if (!$db->Open()) $db->Kill();

$dataakt=date("d/m/Y H:i:s");
$dataakt2=date("d/m/Y");
$daytext=date("l");

//$smarty->compile_check = true;
//$smarty->debugging = true;



$tytul='Start';


$q = "
SELECT fs_float.floatsheetid, fs_tabledesc.tabledescid, fs_tabledesc.tableid, fs_floatfield.floatfieldid, fs_floatfield.fieldname, fs_floatfield.floatfieldsmall,fs_tabledesc.row, fs_tabledesc.coloumn, fs_value.value, fs_float.shopid, fs_departments.name As depname, fs_float.departmentid, fs_shops.name As shopsname
FROM ((((((((fs_float INNER JOIN fs_value ON fs_float.floatsheetid = fs_value.floatsheetid) INNER JOIN fs_tabledesc ON fs_value.tabledescid = fs_tabledesc.tabledescid) INNER JOIN fs_table ON fs_tabledesc.tableid = fs_table.tableid) INNER JOIN fs_floatfield ON fs_tabledesc.floatfieldid = fs_floatfield.floatfieldid) LEFT JOIN fs_expense ON fs_float.floatsheetid = fs_expense.floatsheetid) LEFT JOIN fs_overring ON fs_float.floatsheetid = fs_overring.floatsheetid) LEFT JOIN fs_transfer ON fs_float.floatsheetid = fs_transfer.floatsheetid) LEFT JOIN fs_shops ON fs_float.shopid = fs_shops.id) LEFT JOIN fs_departments ON fs_float.departmentid = fs_departments.dep_id;";

  if (!$db->Query($q)) $db->Kill(); 


while ($row=$db->Row())
    {
    $floats[] = array("floatsheetid" => $row->floatsheetid,
                      "tabledescid" => $row->tabledescid,
                      "floatfieldid" => $row->floatfieldid,
                      "fieldname" => $row->fieldname,
                      "value" => $row->value,
                      "shopid" => $row->shopid,
                      "shopsname" => $row->shopsname,
                      "departmentid" => $row->departmentid,
                      "depname" => $row->depname);
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
                      "depname" => $row->name);
    }


$smarty->assign("dataakt",$dataakt);
$smarty->assign("dataakt2",$dataakt2);
$smarty->assign("daytext",$daytext);

$smarty->assign("floats",$floats);
$smarty->assign("floatsvalue",$floatsvalue);
$smarty->assign("shop",$shop);
$smarty->assign("department",$department);
$smarty->assign("floatsheetid",$floatsheetid);


$smarty->display('float_sheet.html');


include_once("../footer.php");

?>
