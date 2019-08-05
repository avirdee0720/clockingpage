<?php
require("./inc/securitycheck.inc.php");

$emp_no = intval(substr($_GET['emp_no'], 0, 10));
$loc = substr($_GET['loc'], 0, 25);

$db = new CMySQL;
if (!$db->Open()) $dbsec->Kill();
$q = "
    UPDATE `inout` io
    INNER JOIN (
        SELECT id
        FROM `inout`
        WHERE `no` = $emp_no
        AND date1 = CURDATE()
        ORDER BY intime DESC
        LIMIT 1
    ) io2 ON io.id = io2.id
    SET io.ipadr = '$loc'
    LIMIT 1;
     ";
if (!$db->Query($q)) $db->Kill();

header("HTTP/1.0 200 OK");
?>