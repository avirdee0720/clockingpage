<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;

$cmd=shell_exec("mysql -uroot -pDtfD683 < /home2/www/html/orgmve/copydb.sql");
echo " TEST DataBase has been created, if you want to use it, please log in:
		<A HREF='/orgmvetest/'>orgmvetest</A>";

//echo "<script language='javascript'>window.location=\"order1.php?order=$order\"</script>";
?>