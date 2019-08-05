<?php
if(!isset($PHPSESSID)) $PHPSESSID="";
session_start($PHPSESSID);
function authenticate() {
    Header("Location: index.html");
    exit;
  }

$LANG = 'english';
if (isset($_POST['login']) && isset($_POST['password'])) {
   //global $usr;
   $password = $_POST['password'];
   $password1=md5("$password");
   $login =  $_POST['login'];
   //global $password1;
   		unset($id);
		unset($pw);
		unset($PU);
		unset($LANGUAGE);
		unset($nazwa);
   mysql_connect("localhost", "orgmveapp", "mvep455");
   mysql_select_db("mve0");
   $result = mysql_query("select `login`, `passwd`, `nazwa`, `PU`, `lp` FROM `hd_users` where `login` = '$login' ");
   $row = mysql_fetch_array($result);
   if ($password1==$row[1] and $login==$row[0]) 
	{
		$PHP_AUTH_USER = $login;
		$PHP_AUTH_USER = $password1;
		$PU=$row[3];
		$i=$row[4];
		$nazwa=$row[2];
		//rand ((double) microtime() * 1000000,1500);
		//$s = rand(1000,1500);

		setcookie("id", $i,0);
		setcookie("pw", $password,0);
		setcookie("PU", $PU,0);
		setcookie('LANGUAGE', $LANG,0);
		setcookie('nazwa', $nazwa,0);
		echo "<script language='javascript'>window.location=\"main.php\";</script>";
		//echo "$row[0] $row[1] $row[2] $row[3] $row[4]";

	  } else { echo "<script language='javascript'>window.location=\"index.html\";</script>"; }
} else { authenticate(); }

?>
