<?php
require("./inc/securitycheck.inc.php");

session_start();

require_once("./inc/mysql.inc.php");
require_once('libs/Smarty.class.php');

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

if (!isset($_POST['state'])) $state = 0; else $state = $_POST['state'];

//http://localhost/cl/index.php?clver=1 or empty --> Clocking page No. 1. (without 'daily sun')
//http://localhost/cl/index.php?clver=2 --> Clocking page No. 2. (with 'daily sun')
//http://localhost/cl/index.php?clver=3 --> With UNPAID Staff
if (!isset($_GET['clver'])) $clver = 0; else $clver = $_GET['clver'];

if ( !isset($_SESSION['clockingver']) ) {
    $_SESSION['clockingver'] = 1;
}
if ($clver != 0) $_SESSION['clockingver'] = $clver;

//http://localhost/cl/index.php?clver=1&memo=5
if (!isset($_GET['memo'])) $memocnb = -1; else $memocnb = $_GET['memo'];

if ( !isset($_SESSION['memoclno']) ) {
    $_SESSION['memoclno'] = 0;
}
if ($memocnb != -1) $_SESSION['memoclno'] = $memocnb;
$memocnb = $_SESSION['memoclno'];

if ( !isset($_SESSION['clockingrnd']) ) $_SESSION['clockingrnd'] = 12345678;
$rnd = rand(10000000, 99999999);

//if remote is Brian's computer
$ip = $_SERVER['REMOTE_ADDR'];

if ($ip == '192.168.28.60') {
	$_SESSION['clockingver'] = '3';
	$_SESSION['memoclno'] = '5';
	$clver = '3';
	$memocnb = '5';
}

if (($memocnb == '5') && ($ip != '192.168.28.60')){
	$memocnb = '0';
}

//Set $_SESSION['showtrial'] from the database
if (!$dbtrial->Open()) $dbtrial->Kill();
    $query = "SELECT `id` FROM `ipaddress` WHERE `ipaddress`.`IP` = '$ip' AND `ipaddress`.`showtrial_fl` = '1'";
if (!$dbtrial->Query($query)) $dbtrial->Kill();
if ($dbtrial->Rows() == 0) $_SESSION['showtrial'] = '0'; else $_SESSION['showtrial'] = '1';

//Smarty assign
$smarty->assign("clversion", $_SESSION['clockingver']);
$smarty->assign("memoclno", $_SESSION['memoclno']);
$smarty->assign("rnd", $rnd);
$smarty->assign("ip", $ip);
$smarty->assign("showtrial", $_SESSION['showtrial']);

$msg = "";
$messagesign = "0";

//if 'inout' form is submitted
if ($state == "1") {

    $pno=$_POST['pno'];
    $Nowy=$_POST['Nowy'];        
    
    // check last status of this number - check if employee exist in the database
    $datefrom = date("01/m/Y");
    $dateto = date("d/m/Y");
    $dzis1=date("Y-m-d");

    $now = date("H:i:s", time());
	$morningtimelimit = '09:40:00';
 
    if($Nowy == "Enter") {
		if ($pno === "0") {
			$msg = "<script language='javascript'>window.open(\"new_trial_day.php\",'New trial day','width=700,height=600,resizable=0,scrollbars=yes,menubar=no')</script>";
			$messagesign = "2";
		} elseif (!isset($pno) || $pno == "" ) {
            $msg = "Invalid clocking number!<br>";
            $messagesign = "1";
        } elseif ($_SESSION['clockingrnd'] == $_POST['rnd'] ) {
            $msg = "Please type your clocking number again!<br>";
            $messagesign = "1";
        } else {
            //check if user is `newatwork`
            if (!$db->Open()) $db->Kill();
            $work = "SELECT `id` FROM `newatwork` WHERE `newatwork`.`NO` = '$pno' AND `newatwork`.`date1` = CURDATE()";
            if (!$db->Query($work)) $db->Kill();
            if ($db->Rows() == 0) $newatworkflag = 1; else $newatworkflag = 0;
           
            if (!$db->Open()) $db->Kill();
            $q0 = "SELECT COUNT(`pno`) AS nomber, `cloffice`,`cloffice_only`, `overtime_fl`, `status`,`firstname`,`surname`, `cat`, `tempcat`, `moretrday` FROM `nombers` WHERE `pno` = '$pno' GROUP BY `pno` ORDER BY `pno` DESC;";
            if (!$db->Query($q0)) $db->Kill();
            $row0 = $db->Row();

            if ($db->Rows() == 0) {
				//record not found in nombers
                $msg = "Check the clocking number!<br>";
                $messagesign = "1";
            } else {
				//record found in nombers
				$surname = $row0->surname;
				$firstname = $row0->firstname;
				$DayOfWeek = date('w');
				
				// get last clock in/out
				if (!$db->Open()) $db->Kill();
				$q2 = "SELECT `id`, `intime`, `outtime` FROM `inout` WHERE `no` = '$pno' and `date1`=CURDATE() ORDER BY `intime` DESC, id DESC LIMIT 1;";
				if (!$db->Query($q2)) $db->Kill();
				$row2=$db->Row();

				/*//query for the first clock out
				if (!$db->Open()) $db->Kill();
				$q3 = "SELECT `id`, `intime`, `outtime` FROM `inout` WHERE `no` = '$pno' and `date1`=CURDATE() ORDER BY `intime` DESC, id DESC;";
				if (!$db->Query($q3)) $db->Kill();
				$row3numbers=$db->Rows();
				*/

				if(!isset($row2->intime)) $intime = "";
				else $intime = $row2->intime;

				if(!isset($row2->outtime)) $outtime = "";
				else $outtime = $row2->outtime;

				if ( $row0->status <> "OK" ) {
					$msg = "Not 'OK' status clocking number!<br>";
					$messagesign = "1";
				}

				//clock in the main office on first clockin
				elseif( ($row0->cloffice == 1) && ($newatworkflag == 1) && $ip!='192.168.28.60' && $ip!='192.168.28.61' && $ip!='192.168.28.62' &&$ip!='192.168.28.63' && $ip!='192.168.28.64' && $ip!='192.168.28.65' && ($DayOfWeek>0) && ($DayOfWeek<6)) {
					$msg = "$firstname $surname ($pno) should clock in at the main office!<br>";
					$messagesign = "1";
				}

			//first clock out in the main office or after 19
			//elseif(($row0->cloffice_only==1)&&($row3numbers== "1")&&($row2->outtime == "00:00:00")&&($ip!='192.168.28.60')&&($ip!='192.168.28.61')&&($ip!='192.168.28.62')&&($ip!='192.168.28.63')&&($ip!='192.168.28.64')&&($ip!='192.168.28.65')&&($DayOfWeek>0)&&($DayOfWeek<6)&&(date('H:i:s', time()) < date('19:00:00')))
			//	{
				//        $msg = "$firstname $surname ($pno) can clock out only at the main office!<br>";
				//        $messagesign = "1";
			//	}

			//first clock in enywhere, then clock in/out in the main office or after 19

			elseif(($row0->cloffice_only==1)&&($newatworkflag!= 1)&&($ip!='192.168.28.60')&&($ip!='192.168.28.61')&&($ip!='192.168.28.62')&&($ip!='192.168.28.63')&&($ip!='192.168.28.64')&&($ip!='192.168.28.65')&&($DayOfWeek>0)&&($DayOfWeek<6)&&(date('H:i:s', time()) < date('19:00:00')))
			{
					$msg = "$firstname $surname ($pno) can clock in/out only at the main office!<br>";
					$messagesign = "1";
			}   //clock in bef 9.40
				/*elseif (($row0->overtime_fl == 0) &&
						(date('H:i:s', time()) < date('09:40:00'))  &&
						($outtime <> "00:00:00")) {
					$msg = "Please clock in & out after 9.40!<br>";
					$messagesign = "1";
				}*/
				
				elseif($row0->nomber==0) {	
					$msg = "The number $pno is not in the database!<br>";
					$messagesign = "1";
				}

				elseif($row0->nomber>1) {
					$msg = "Database error: duplicate numbers in staff table! Please contact IT office!";
					$messagesign = "1";
				}

				elseif ($messagesign == "0") {
					if (($intime <> "00:00:00") && ($outtime == "00:00:00")) {
						// clock out
						if(!$db->Open()) $db->Kill();						
						if (($row0->overtime_fl == 0) && ($now < date($morningtimelimit))) {
							// if clocking out before 9:40 and clocking in before 9:40 is not paid
							$currout = $morningtimelimit;
						} else {
							$currout = $now;
						}
						$out1 = "UPDATE `inout` SET `outtime` = '$currout' WHERE `id`='$row2->id' LIMIT 1;";
						if (!$db->Query($out1)) $db->Kill();
						$_SESSION['clockingrnd'] = $_POST['rnd'];
						$h1 = "OUT";			 
					}

					else {
						// clock in
						if (($row0->overtime_fl == 0) && ($now < date($morningtimelimit))) {
							// if clocking in before 9:40 and clocking in before 9:40 is not paid
							$currin = $morningtimelimit;
						} else {
							$currin = $now;
						}
						if (!$db->Open()) $db->Kill();
						$in1 = "INSERT INTO `inout` (`date1`, `intime`, `no`, `descin`, `ipadr`) VALUES (CURDATE(), '$currin', '$pno', '', '$ip')";
						if (!$db->Query($in1)) $db->Kill();
						$inoutid = mysql_insert_id();
						
						//add user to the `newatwork`
						if ($newatworkflag == 1) {
							if(!$db->Open()) $db->Kill();
							$work = "INSERT INTO `newatwork` (`date1`, `intime`, `no`, `ipadr`) VALUES (CURDATE(), '$currin', '$pno', '$ip')";
							if(!$db->Query($work)) $db->Kill();
						}
						$_SESSION['clockingrnd'] = $_POST['rnd'];
						$h1 = "IN";
					}
					
					//if somebody TRIAL and will be REGULAR
					if ($row0->cat == 'ut' && $newatworkflag == '1' && $row0->moretrday == '1') {
						$catupdate="UPDATE `nombers` SET `moretrday`= '0' WHERE `pno` = '$pno';";
						if(!$db->Query($catupdate)) $db->Kill();
						$msg = "You are on trial day! $firstname $surname ($pno) is $h1";
					}
					elseif ($row0->cat == 'ut' && $newatworkflag == '1' && $row0->moretrday == '0') {
						$newcat = $row0->tempcat;
						$newcat2 = strtoupper($row0->tempcat).'.';
						$catupdate="UPDATE `nombers` SET `cat`='$newcat', `cattoname`= '$newcat2', `moretrday`= '0',
						`tempcat`= '', `paystru`= 'NEW'
						WHERE `pno` = '$pno';";
						if(!$db->Query($catupdate)) $db->Kill();
						
						$delinout="DELETE FROM `inout` WHERE `no` = '$pno' AND `id` < '$inoutid'";
						if(!$db->Query($delinout)) $db->Kill();
										
						$msg = "You are regular staff from now! $firstname $surname ($pno) is $h1";
					}
					else $msg = "$firstname $surname ($pno) is $h1";
					
					$messagesign = "1";
					$out1="UPDATE `defaultvalues` SET `value`=CONCAT(UNIX_TIMESTAMP(),'T',FLOOR(RAND() * 1000))  WHERE `code`='clversion' LIMIT 1;";
					if(!$db->Query($out1)) $db->Kill();

				} // $messagesign == "0"

            } //record found in nombers
        
        } //valid clocking number      

    } // Enter

    elseif($Nowy=="Information") {        
        if ($pno == 0 || !isset($pno) || $pno == "" ) {
            $msg = "Invalid clocking number!<br>";
            $messagesign = "1";
        }
        else {
        
            $msg = "<script language='javascript'>window.open(\"totalhuser.php?cln=".$pno."\",'hours','width=600,height=600,resizable=0,scrollbars=yes,menubar=no')</script>";         
            
            $messagesign = "2";
        }
    } //Information
    
    $smarty->assign("messagesign", $messagesign);
    $smarty->assign("message", $msg);
    
} //state = 1

//if 'trialmemo' form is submitted
if ($state == "2") {
    
    $action = $_POST['action'];
        
    if($action == "Add new trial day") {
        
	if(!$dbtrial->Open()) $dbtrial->Kill();
        $newtrialsql="INSERT INTO `trialmemo` (`trialmemo_state`, `trialmemo_text`) VALUES ('1', '')";
        if(!$dbtrial->Query($newtrialsql)) $dbtrial->Kill();
                    
        $msg = "New trial memo has been added!";
        $messagesign = "0";

    }  //Add new memo
    
    if($action == "Save trial day") {
        
        if (!isset($_POST['trialtext'])) $trialtext = array (); else $trialtext = $_POST['trialtext'];
	if (!isset($_POST['trialid'])) $trialid = array (); else $trialid = $_POST['trialid'];
        
        $i = 0;
        foreach ($trialid as $tid) {
            $trialdate = "9999-12-31";
                        
            if(!$dbtrial->Open()) $dbtrial->Kill();
            $updatetrialsql="UPDATE `trialmemo` SET `trialmemo_text` = '$trialtext[$i]', `trialmemo_date` = '$trialdate'
                         WHERE `id` = '$tid'";
            if(!$dbtrial->Query($updatetrialsql)) $dbtrial->Kill();
            $i++;
        }
        if ($i == 0) $msg = "Trial memo not saved!";
        else $msg = "$i trial memo has been saved successfully!";
        
        $messagesign = "0";
        
    }  //Save trial memos
    
    if($action == "Delete trialmemo") {
        
        $msg = "Trial memo has been deleted successfully!";        
        $messagesign = "0";
        
    }   //Delete trialmemo
    
    $smarty->assign("messagesign", $messagesign);
    $smarty->assign("message", $msg);

} //state = 2

//if 'memo' form is submitted
if ($state == "3") {
    
    $action = $_POST['action'];
        
    if($action == "Add new memo") {
        
		if(!$dbmemo->Open()) $dbmemo->Kill();
        $newmemosql="INSERT INTO `memo` (`memo_clno`)
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
            $delmemosql="UPDATE `memo` SET `memo_text` = '$memotext[$i]', `memo_date` = '$memodate'
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


//if state = 0
elseif ($state == "0") {
    $smarty->assign("messagesign", "0");
}


//Trial memo
if ($_SESSION['showtrial'] != '0') {
    $trials = array();
    $trialtableleft = array();
    $trialtableright = array();
    
    //trial query
    if (!$dbtrial->Open()) $dbtrial->Kill();
    $query = "SELECT `id`,
       `trialmemo_date`,
       `trialmemo_time`,
       `trialmemo_text`
    FROM `trialmemo`
    WHERE `trialmemo_state` = '1'
    ORDER BY `id`;";
    if (!$dbtrial->Query($query)) $dbtrial->Kill();

    $i=0;
    while ($trialrow=$dbtrial->Row()) {
        $trials[$i] = array($trialrow->id, $trialrow->trialmemo_date, $trialrow->trialmemo_time, $trialrow->trialmemo_text);
        $i++;
    }
    $trialnum = $dbtrial->Rows();
            
    //is any trials in database
    if ($trialnum == 0 ) {
        $smarty->assign("trialtableleft", "0");
        $smarty->assign("trialtableright", "0");
        $smarty->assign("trialnum", "0");        
    }
    
    elseif ($trialnum < 6) {
        $size = count($trials);        
        for ($j=0; $j < $size; $j++) {
            $trialtableleft[$j] = $trials[$j];         
        } 
        
        $smarty->assign("trialtableleft", $trialtableleft);
        $smarty->assign("trialtableright", "0");
        $smarty->assign("trialnumright", "0");
        $smarty->assign("trialnum", $trialnum );
    }
    else {        
        if ($trialnum % 2) $trialnumleft = floor($trialnum / 2) + 1;
        else $trialnumleft = $trialnum / 2;
        
        for ($j=0; $j < $trialnumleft; $j++) {
            $trialtableleft[$j] = $trials[$j];         
        }        
        for ($j=$trialnumleft; $j < $trialnum; $j++) {
            $trialtableright[$j] = $trials[$j];         
        }
        
        $smarty->assign("trialtableleft", $trialtableleft);
        $smarty->assign("trialtableright", $trialtableright);
        $smarty->assign("trialnumright", $trialnum-$trialnumleft);
        $smarty->assign("trialnum", $trialnum);      
    }
        
}


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
  FROM `memo`
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
    if (!$dbmemo2->Open()) $dbmemo2->Kill();
    $query = "SELECT `nombers`.`knownas`
              FROM `nombers` WHERE `nombers`.`pno` = $memocnb;";
    if (!$dbmemo2->Query($query)) $dbmemo2->Kill(); 
	$memouser = $dbmemo2->Row();
        
    //is any memos in database
    if ($memosnum == 0 ) {
        $smarty->assign("memotableleft", "0");
        $smarty->assign("memotableright", "0");
        $smarty->assign("memosnum", "0");	
        $smarty->assign("memouser", $memouser->knownas);
        
    }
    elseif ($memosnum < 11) {
        $size = count($memos);        
        for ($j=0; $j < $size; $j++) {
            $memotableleft[$j] = $memos[$j];         
        } 
        
        $smarty->assign("memotableleft", $memotableleft);
        $smarty->assign("memotableright", "0");
        $smarty->assign("memosnumright", "0");
        $smarty->assign("memosnum", $memosnum);
        $smarty->assign("memouser", $memouser->knownas);
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
        $smarty->assign("memouser", $memouser->knownas);
        
    }
        
}
$smarty->assign("time", floor(1000*microtime(true)));
$smarty->display('clocking_main.html');

?>
