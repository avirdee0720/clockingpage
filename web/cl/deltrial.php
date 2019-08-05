<?php
require("./inc/securitycheck.inc.php");
?>
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

error_reporting(E_ALL);
ini_set('display_errors','On');

require_once("./inc/mysql.inc.php");
require_once('libs/Smarty.class.php');

$db = new CMySQL;

if (!isset($_GET['url'])) {
    $url = '0'; echo "Missing url!<br>";
} else $url = $_GET['url'];

if (!isset($_GET['clver'])) {
    $clver = '0'; echo "Missing clocking version!<br>";
} else $clver = $_GET['clver'];

$memo = $_GET['memo'];

if (!isset($_GET['delid'])) {
    $delid = '0'; echo "Missing delete ID!<br>";
} else $delid = $_GET['delid'];

if (!$db->Open()) $db->Kill();
    $delmemosql="UPDATE `trialmemo` SET `trialmemo_state` = '0'
                 WHERE `id` = '$delid'";
    if(!$db->Query($delmemosql)) $db->Kill();
    //echo "Update ready!";
?>
    
<body>
<form name="test" id="form1" method="post" action="<?php echo "$url?clver=$clver&memo=$memo"; ?>">
    <input type='hidden' name='state' value='2'>
    <input type='hidden' name='action' value='Delete trialmemo'>    
</form>
    
</body>
</html>