<?php
include("./inc/mysql.inc.php");
$recID=$_GET['recID'];

$db = new CMySQL;
if (!$db->Open()) $db->Kill();
    $query =("UPDATE `newatwork` SET `checked`='c' WHERE `id`='$recID' LIMIT 1");
$db->Query($query);
$db->Free();
$db->Close();
$url = $_SERVER['HTTP_REFERER'];

echo "<script language='javascript'>window.location=\"$url\"</script>";

?>
