<?php
include_once("./header.php");
$tytul='Enter start date and end date to prepare payday tables';
//include("./inc/uprawnienia.php");
include("./config.php");


for ($i=1;$i<10;$i++) {
   echo "<script language='javascript'>window.location=\"tmptprep.php?startd=01/$i/2006&endd=31/$i/2006\"</script>";
}
?>