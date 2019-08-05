<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
uprstr($PU,90);

if (!$db->Open()) $db->Kill();

    $sql1 =("UPDATE `totals` SET `a1030`='1' WHERE id='$msgid' ");
  if (!$db->Query($sql1)) $db->Kill();
//      $prd=$db->Row();

echo "<script language='javascript'>window.location=\"1030pd.php?startd=$startd&endd=$endd\"</script>";
//echo $sql1;
?>