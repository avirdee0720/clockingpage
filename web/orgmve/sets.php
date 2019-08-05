<?php
ini_set("include_path", ".:./inc/:./languages/:/usr/share/php/DB:/usr/share/php/PEAR:/usr/share/php/Smarty");

if(!isset($_COOKIE['id'])) { echo "No ID - Log in please! <A HREF='/orgmve/'>click Here</A>"; exit; }
 else { $id = $_COOKIE['id']; }
 
if(!isset($_COOKIE['PU'])) { echo "NO PU - Log in please! <A HREF='/orgmve/'>click Here</A>"; exit; }
 else { $PU = $_COOKIE['PU']; }
 
if(!isset($_COOKIE['LANGUAGE'])) { echo "NO PU - Log in please! <A HREF='/orgmve/'>click Here</A>"; exit; }
 else { $LANGUAGE = $_COOKIE['LANGUAGE']; }

if(!isset($_COOKIE['PHPSESSID'])) { echo "NO PHPSESSID - Log in please! <A HREF='/orgmve/'>click Here</A>"; exit; }
 else { $PHPSESSID = $_COOKIE['PHPSESSID']; }
 
if(!isset($_SERVER['REMOTE_ADDR'])) { echo "NO REMOTE_ADDR - Log in please! <A HREF='/orgmve/'>click Here</A>"; exit; }
 else { $REMOTE_ADDR = $_SERVER['REMOTE_ADDR']; }

if(!isset($_COOKIE['nazwa'])) { echo "NAME - Log in please! <A HREF='/orgmve/'>click Here</A>"; exit; }
 else { $nazwa = $_COOKIE['nazwa']; }
 
if(isset($_GET['sort'])) { $sort = $_GET['sort']; }

include("./inc/mysql.inc.php");
include("./inc/person.inc.php");
include("././languages/$LANGUAGE.php");
include("./inc/uprawnienia.php");
include("./inc/orgfunc.inc.php");

if(!isset($_GET['kier'])) { $kier = 0; } else { $kier = $_GET['kier']; }
if($kier == 0){
	$kier_sql="DESC";
	$kier=1;
	$kier_img[$sort]="&nbsp;<IMG SRC='images/gora.PNG' BORDER='0' ALT='DESC'>";
}else{
	$kier_sql="ASC";
	$kier=0;
	$kier_img[$sort]="&nbsp;<IMG SRC='images/dol.PNG' BORDER='0' ALT='ASC'>";
}
//error_reporting(E_ALL);

// check posted variables
function checkzm($zm){ 
	if(!isset($_POST[$zm]) || $_POST[$zm] == "") { print("<h2>Error: $zm not set</h2> <input class='Button'  type='Button' onclick='javascript:history.back()' value='BACK'>"); exit; } else { $zm = $_POST[$zm];  }
return $zm;
}


/*	$search = array('+', '(', ')');
	$replace = array("TEXTPLUS", "TEXTBRACKETLEFT", "TEXTBRACKETRIGHT");
	$rynek1 = str_replace($search, $replace, $rynek1); 
	$rynek1 = $db->Fix($rynek1);
*/

//weekwnd days - current month:

?>