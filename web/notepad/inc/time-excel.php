<?php
include("./config.php");
include("./languages/$LANGUAGE.php");
$dataakt=date("d/m/Y H:i:s");


//	$db = new CMySQL; ------------------------------------
  if (!$db->Open()) $db->Kill();
	$result = mysql_query('select * from excel_test');
	$count = mysql_num_fields($result);

  while($row = mysql_fetch_row($result)){
  $line = '';
  foreach($row as $value){
    if(!isset($value) || $value == ""){
      $value = "\t";
    }else{
      $value = str_replace('"', '""', $value);
      $value = '"' . $value . '"' . "\t";
    }
    $line .= $value;
  }
  $data .= trim($line)."\n";
}
  $data = str_replace("\r", "", $data);

if ($data == "") {  $data = "\nno matching records found\n"; }

//-------------------------------------------------------------------
//for ($i = 0; $i < $count; $i++){
//    $header .= mysql_field_name($result, $i)."\t";
//}
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=emploeestime.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo $header."\n".$data; 

?> 