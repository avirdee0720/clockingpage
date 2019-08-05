<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;

if (!$db->Open()) $db->Kill();

    $sql1 =("UPDATE `inoutmsg` SET `checked`='c' WHERE `id`='$msgid' ");

  if (!$db->Query($sql1)) $db->Kill();
//      $prd=$db->Row();

echo "<script language='javascript'>window.location=\"tmes.php?startd=$startd&endd=$endd\"</script>";
//echo $sql1;
?>