<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Test</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<SCRIPT LANGUAGE="JavaScript"><!--
setTimeout('document.test.submit()',1);
//--></SCRIPT>
</head>

<?php
session_start();
//unset ($_SESSION['clockingver']);
//session_destroy();

$url = $_GET['url'];

if (!isset($_GET['no'])) {
    $no = '0'; echo "Missing memo group number!<br>";
} else $no = $_GET['no'];

$url .= "?no=".$no;

error_reporting(E_ALL);
ini_set('display_errors','On');

include("./inc/mysql.inc.php");
require('libs/Smarty.class.php');

$db = new CMySQL;

if (!isset($_GET['delid'])) {
    $delid = '0'; echo "Missing delete ID!<br>";
} else $delid = $_GET['delid'];

if (!$db->Open()) $db->Kill();
    $delmemosql="UPDATE `memo0` SET `memo_state` = '0'
                 WHERE `id` = '$delid'";
    if(!$db->Query($delmemosql)) $db->Kill();
    //echo "Update ready!";
?>
    
<body>
<form name="test" id="form1" method="post" action="<?php echo "$url"; ?>">
    <input type='hidden' name='state' value='2'>
    <input type='hidden' name='action' value='Delete memo'>    
</form>
    
</body>
</html>