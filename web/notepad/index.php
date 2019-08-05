<?php
session_start();
//unset ($_SESSION['clockingver']);
//session_destroy();

error_reporting(E_ALL);
ini_set('display_errors','On');

include("./inc/mysql.inc.php");
require('libs/Smarty.class.php');

$smarty = new Smarty;

$db = new CMySQL;
if (!$db->Open()) $db->Kill();
$checkDB = new CMySQL;
$dbmemo = new CMySQL;
$dbmemo2 = new CMySQL;
$dbtrial = new CMySQL;

if (!$checkDB->Open()) $checkDB->Kill();
if (!$dbmemo->Open()) $dbmemo->Kill();
if (!$dbmemo2->Open()) $dbmemo2->Kill();


//http://localhost/cl/index.php?clver=1 or empty --> Clocking page No. 1. (without 'daily sun')
//http://localhost/cl/index.php?clver=2 --> Clocking page No. 2. (with 'daily sun')
//http://localhost/cl/index.php?clver=3 --> With UNPAID Staff

//http://localhost/cl/index.php?clver=1&memo=5
if (!isset($_POST['memo'])) $memocnb = -1; else $memocnb = $_POST['memo'];
if (!isset($_POST['state'])) $state = 0; else $state = $_POST['state'];
if (!isset($_POST['no'])) {
    if (!isset($_GET['no'])) $memocnb = '0'; else $memocnb = $_GET['no'];
    } else $memocnb = $_POST['no'];

//if remote is Brian's computer
$ip = $_SERVER['REMOTE_ADDR'];
//if ($ip == '192.168.40.26') {
//Set $_SESSION['showtrial'] from the database

//Smarty assign
$smarty->assign("memoclno", $memocnb);
$smarty->assign("ip", $ip);

//if 'memo' form is submitted
if ($state == "3") {
    
    $action = $_POST['action'];
        
    if($action == "Add new memo") {
        
		if(!$dbmemo->Open()) $dbmemo->Kill();
        $newmemosql="INSERT INTO `memo0` (`memo_clno`)
        VALUES ('$memocnb')";
        if(!$dbmemo->Query($newmemosql)) $dbmemo->Kill();
                    
        $msg = "New memo has been added!";
        $messagesign = "0";

    }  //Add new memo
    
    if($action == "Save") {
        
        if (!isset($_POST['memotext'])) $memotext = array (); else $memotext = $_POST['memotext'];
	if (!isset($_POST['memoid'])) $memoid = array (); else $memoid = $_POST['memoid'];
        
        $i = 0;
        //$memotext=str_replace("'","","$memotext");
        foreach ($memoid as $mid) {
            $memopices = explode(" ", $memotext[$i]);
            if ( isset($memopices[0]) && isset($memopices[1]) && isset($memopices[2])) {           
                $memodate = date('Y-m-d', strtotime("$memopices[1] $memopices[2]"));
            }
            else $memodate = "9999-12-31";
            if ($memodate == "1970-01-01") $memodate = "9999-12-31";            
            
            if(!$dbmemo->Open()) $dbmemo->Kill();
	    $memotext[$i] = mysql_real_escape_string($memotext[$i]);
            $delmemosql="UPDATE `memo0` SET `memo_text` = '$memotext[$i]', `memo_date` = '$memodate'
                         WHERE `id` = '$mid' AND `memo_clno` = '$memocnb'";
            if(!$dbmemo->Query($delmemosql)) $dbmemo->Kill();
            $i++;
        }
        if ($i == 0)
            $msg = "Memo not saved!";
        else $msg = "$i memo has been saved successfully!";
        
        $messagesign = "0";
        
    }  //Save memos
	
    if($action == "Delete memo") {
        
        $msg = "Memo has been deleted successfully!";        
        $messagesign = "0";
        
    }   //Delete memo
    
    $smarty->assign("messagesign", $messagesign);
    $smarty->assign("message", $msg);

} //state = 3



//Memos
//http://localhost/cl/index.php?clno=5
if ($memocnb != '0') {
    $memos = array();
    $memotableleft = array();
    $memotableright = array();
    
    //memo query
    if (!$dbmemo->Open()) $dbmemo->Kill();
    $query = "SELECT `id`,
       `memo_date`,
       `memo_time`,
       `memo_text`,
       DATEDIFF(memo_date, CURDATE()) AS daydiff
  FROM `memo0`
 WHERE `memo_clno` = $memocnb AND `memo_state` = '1'
ORDER BY `memo_date` ASC, `memo_text` ASC;";
    if (!$dbmemo->Query($query)) $dbmemo->Kill();

    $i=0;
    while ($memorow=$dbmemo->Row()) {
        $memos[$i] = array($memorow->id, $memorow->memo_date, $memorow->memo_time, $memorow->memo_text, $memorow->daydiff);
        $i++;
    }
    $memosnum = $dbmemo->Rows();
    
    //memouser query
    $memouser = 'Brian Abrams';
        
    //is any memos in database
    if ($memosnum == 0 ) {
        $smarty->assign("memotableleft", "0");
        $smarty->assign("memotableright", "0");
        $smarty->assign("memosnum", "0");	
        $smarty->assign("memouser", $memouser);
        
    }
    elseif ($memosnum < 21) {
        $size = count($memos);        
        for ($j=0; $j < $size; $j++) {
            $memotableleft[$j] = $memos[$j];         
        } 
        
        $smarty->assign("memotableleft", $memotableleft);
        $smarty->assign("memotableright", "0");
        $smarty->assign("memosnumright", "0");
        $smarty->assign("memosnum", $memosnum);
        $smarty->assign("memouser", $memouser);
    }
    else {        
        if ($memosnum % 2) $memosnumleft = floor($memosnum / 2) + 1;
        else $memosnumleft = $memosnum / 2;
        
        for ($j=0; $j < $memosnumleft; $j++) {
            $memotableleft[$j] = $memos[$j];         
        }        
        for ($j=$memosnumleft; $j < $memosnum; $j++) {
            $memotableright[$j] = $memos[$j];         
        }
        
        $smarty->assign("memotableleft", $memotableleft);
        $smarty->assign("memotableright", $memotableright);
        $smarty->assign("memosnumright", $memosnum-$memosnumleft);
        $smarty->assign("memosnum", $memosnum);
        $smarty->assign("memouser", $memouser);
        
    }
        
}
$prev="<form ></form>";
$next="";
$smarty->assign("messagesign", 0);
$smarty->assign("trialnum", 0);
$smarty->assign("showtrial", 0);

$smarty->assign("prev", $prev);
$smarty->assign("next", $next);

$smarty->assign("time", floor(1000*microtime(true)));
$smarty->display('clocking_main.html');

?>
