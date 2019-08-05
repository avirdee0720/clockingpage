<?php
require("./inc/securitycheck.inc.php");

$emp_no = intval(substr($_GET['emp_no'], 0, 10));
$has_dot = intval(substr($_GET['has_dot'], 0, 1));

$db = new CMySQL;
if (!$db->Open()) $dbsec->Kill();
$q = "
	SELECT toggle_empl_dot($emp_no, $has_dot) AS res;
	 ";
if (!$db->Query($q)) $db->Kill();
$r = $db->Row();
if ($r->res != 0) $db->Kill();

header("HTTP/1.0 200 OK");
?>