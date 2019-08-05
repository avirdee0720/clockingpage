<?php

include("../lock/inc/mysql.inc.php");
include("./config.php");
$ip=$_SERVER['REMOTE_ADDR'];
$db = new CMySQL;

if(date("H") < 12) {$godzinaBlokady=11; }
elseif(date("H") > 12) {$godzinaBlokady=17; }

if(isset($_POST['pass1']) && $_POST['pass1']!=="") {$pw=$_POST['pass1'];}
else {echo "You mus enter correct password<input class='Button' onclick='history.back()' name='Nowy' type='submit' value='Try again'>"; exit; }
  if (!$db->Open()) $db->Kill();
  $sql = "SELECT password FROM passwd1 where password='$pw' LIMIT 1";
  if (!$db->Query($sql)) $db->Kill();
   $wiersz=$db->Row();
if($wiersz->password == "$pw")
  {
	if (!$db->Open()) $db->Kill();
	$sql = "INSERT INTO `locktb` ( `id` , `date1` , `hour` , `locked` , `ipadr` , `add` ) VALUES ( '', '$dzis', '$godzinaBlokady', 'u', '192.168.0.86', '0'),( '', '$dzis', '$godzinaBlokady', 'u', '192.168.0.61', '0'),( '', '$dzis', '$godzinaBlokady', 'u', '192.168.0.59', '0')";
	if (!$db->Query($sql)) $db->Kill();
	echo "<H1>Computer screens have been unlocked!</H1><BR><input class='Button' onclick='window.close()' name='Nowy' type='submit' value='Close this window'>";
   }
  else
	{
     echo "Wrong password, the screen hasn't been unlocked. <BR><input class='Button' onclick='history.back()' name='Nowy' type='submit' value='Try again'>";
    }
?>