<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$msgdb = new CMySQL;
uprstr($PU,90);

if (!$db->Open()) $db->Kill();
    $sqlTime =("SELECT inout.id, inout.date1,inout.intime, inout.outtime, inout.no, inout.ipadr, inout.checked FROM inout WHERE  inout.id='$idtime' LIMIT 1");
	$sqlMsg =("SELECT inoutmsg.id, inoutmsg.message FROM inoutmsg WHERE  inoutmsg.idinout='$idtime' LIMIT 1 ");

  if (!$db->Query($sqlTime)) $db->Kill();
  $RowTime=$db->Row();
		 if (!$db->Query($sqlMsg)) $db->Kill();
		 $RowMsg=$db->Row();
		 if (!$msgdb->Open()) $msgdb->Kill();
		 $sqlArch = "INSERT INTO `timeslog`(`id`, `date1`, `intime`, `outtime`, `no`, `msg`, `ipadr`, `checked`, `oldid`) VALUES(NULL, '$RowTime->date1', '$RowTime->intime', '$RowTime->outtime', '$RowTime->no', '$RowMsg->message', '$RowTime->ipadr', '$RowTime->checked', '$RowTime->id')";
			if (!$msgdb->Query($sqlArch)) { $msgdb->Kill(); }
			else {
				$sqlDelIn = "DELETE FROM `inout` WHERE inout.id='$RowTime->id' LIMIT 1";
				if (!$msgdb->Query($sqlDelIn)) $msgdb->Kill();

				if($RowMsg->id<>"") {
					$sqlDelMsg = "DELETE FROM `inoutmsg` WHERE inoutmsg.id='$RowMsg->id' LIMIT 1";
					if (!$msgdb->Query($sqlDelMsg)) $msgdb->Kill();
				}
				$sqlOpt = "OPTIMIZE TABLE `inout` , `inoutmsg` , `timeslog` ";
				if (!$msgdb->Query($sqlOpt)) $msgdb->Kill();
			}

//      $prd=$db->Row();

echo "<script language='javascript'>window.location=\"ehours.php\"</script>";
//echo $sql1;
?>