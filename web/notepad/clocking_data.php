<?php
session_start();

include("./inc/mysql.inc.php");
//include("./config.php");
//include("./languages/$LANGUAGE.php");

require('libs/Smarty.class.php');

$smarty = new Smarty;

$PHP_SELF=$_SERVER['PHP_SELF'];
$do=$_GET['do'];

$smarty->assign("clversion", $_SESSION['clockingver']);

$db = new CMySQL;
$db2 = new CMySQL;
$db3 = new CMySQL;
if (!$db->Open()) $db->Kill();
if (!$db2->Open()) $db2->Kill();
if (!$db3->Open()) $db3->Kill();

if ($do == "clversion") {
    $q="SELECT value As clversion FROM `defaultvalues` Where `code`=\"clversion\"";
    $db->Query($q);
    $r=$db->Row();
    $clversion=$r->clversion;
    echo $clversion;
}

if ($do == "cltable") {    
    $sql = "SELECT  count(*) As num from 
    (SELECT DISTINCT pno FROM `nombers` LEFT JOIN `inout` ON `nombers`.`pno` = `inout`.`no` WHERE `nombers`.`status`='OK' AND `inout`.`date1`=CURDATE() AND `nombers`.`pno` <> '5' AND (LOCATE('.',`cattoname`)<>0 OR cat='c' ) ) AS x";
    $db->Query($sql);
    $row=$db->Row();
    $shop=$row->num;
 
    $sql = "SELECT  count(*) As num from 
    (SELECT DISTINCT pno FROM `nombers` LEFT JOIN `inout` ON `nombers`.`pno` = `inout`.`no` WHERE `nombers`.`status`='OK' AND `inout`.`date1`=CURDATE() AND `nombers`.`pno` <> '5' AND (LOCATE('.',`cattoname`)<>0 OR cat='c') AND outtime = '00:00:00' ) AS x"; 
    $db->Query($sql);
    $row=$db->Row();
    $noshop=$row->num;
 
    $sql="SELECT value As understaffingvalue FROM `defaultvalues` Where `code`=\"understaffingvalue\"";
    $db->Query($sql);
    $row=$db->Row();
    $understaffingvalue=$row->understaffingvalue; 
    
    //-----------------------START PAID STAFF-----------------------

    // Clocking table for clocking version 1 and 2
    $clpaidtable[0] = array();
    $clpaidtable[1] = array();
    $sql3 = "Select trialdays.name, trialdays.surname, trialdays.code, ipaddress.namefb, time(time) as `in` from trialdays left join ipaddress on trialdays.ip = ipaddress.IP where date(time) = curdate() order by name ;";
    $db3->Query($sql3);
    //echo "db3 rows: " . $db3->Row();
    if ($db3->Rows()<1){
    $sql= "SELECT `nombers`.`pno`,
       `nombers`.`knownas`,
       `nombers`.`firstname`,
       `nombers`.`surname`,
       `nombers`.`assessment`,
       `nombers`.`cattoname`,
       `nombers`.`displ`,
       `ipaddress`.`namefb`,
CASE
  WHEN `newatwork`.`checked` = 'c' THEN 0
  ELSE `newatwork`.`id`
END AS newatwork     
FROM `nombers`
  LEFT JOIN `inout` ON `nombers`.`pno` = `inout`.`no`
  LEFT JOIN `ipaddress` ON `inout`.`ipadr` = `ipaddress`.`IP`
  LEFT JOIN `newatwork` ON `nombers`.`pno` = `newatwork`.`no`
WHERE `nombers`.`status` = 'OK'
  AND `inout`.`date1` = CURDATE()
  AND `nombers`.`pno` <> '5'
  AND `nombers`.`cat` <> 'ui'
  AND `nombers`.`cat` <> 'ut'
  AND `newatwork`.`date1` = CURDATE()
GROUP BY `nombers`.`pno`
ORDER BY knownas";
    $db->Query($sql);
    if (!$db->Query($sql)) $db->Kill();
    $clpaidrowsnumber=$db->Rows();
    $clpaidtablenumber = 0;
	
    if ($clpaidrowsnumber % 2) $clpaidrowsleft = floor($clpaidrowsnumber / 2) + 1;
    else $clpaidrowsleft = $clpaidrowsnumber/2;
    
    $i=0;
    while ($row=$db->Row()) {
        $clpaidtabletime = array();
    
        if ($i >= $clpaidrowsleft) $clpaidtablenumber = 1;   // cltanlenumber:  0 - left, 1 right
    
	if ($row->assessment == '0' || (($ip!='192.168.28.60') && ($ip!='192.168.28.61') && ($ip!='192.168.28.62') && ($ip!='192.168.28.63') && ($ip!='192.168.28.64') && ($ip!='192.168.28.65'))) $name = $row->knownas."&nbsp;".$row->surname."&nbsp;".$row->cattoname;
		else  $name = strtoupper($row->knownas)."&nbsp;".strtoupper($row->surname)."&nbsp;".$row->cattoname;
            
        if (!isset($row->namefb)) $namefb = "&nbsp;";
        else $namefb = $row->namefb;
     
        // $sql2 = "SELECT no, d1, t1, t2, descin, descout from (SELECT `inout`.`no`, DATE_FORMAT(`inout`.`date1`, \"%d/%m/%Y\") as d1, DATE_FORMAT(`inout`.`intime`, \"%H:%i\") as t1, DATE_FORMAT(`inout`.`outtime`, \"%H:%i\") as t2, `inout`.`descin`, `inout`.`descout` FROM `inout` WHERE `inout`.`date1`=CURDATE() AND `inout`.`no`='$row->pno' ORDER BY `inout`.`intime` DESC LIMIT 5) As x Order by t1 ASC";
        $sql2 = "SELECT no, DATE_FORMAT(`date1`, \"%d/%m/%Y\") as d1,DATE_FORMAT( `intime`, \"%H:%i\") As t1 , DATE_FORMAT(`outtime`, \"%H:%i\") as t2, descin, descout from (SELECT `inout`.`no`, `inout`.`date1`, `inout`.`intime`, `inout`.`outtime`, `inout`.`descin`, `inout`.`descout` FROM `inout` WHERE `inout`.`date1`=CURDATE() AND `inout`.`no`='$row->pno' ORDER BY `inout`.`intime` DESC LIMIT 5) As x Order by intime ASC";
        if (!$db2->Query($sql2)) $db2->Kill();
        while ($row2=$db2->Row()) {
            $t2 =$row2->t2;
            if ($t2 == "00:00") {
                $inout = 0;
                $t2 = "&nbsp;";
            }
            else {
                $inout = 1;
            }
            $clpaidtabletime[] = array($row2->t1,$t2);
        }
        $inoutnumber = count($clpaidtabletime);
        for ($j=$inoutnumber; $j<5; $j++) {
            $clpaidtabletime[] = array ("&nbsp;","&nbsp;");
        }
        
        $clpaidtable[$clpaidtablenumber][] = array ($row->pno, $inout, $row->newatwork, $name, $namefb, $clpaidtabletime); // [0][0][]
        $i++;
    }
    
    
	
    $smarty->assign("clpaidtableleft", $clpaidtable[0]);
    $smarty->assign("clpaidtableright", $clpaidtable[1]);
    } else
	{
    $sql= "SELECT `nombers`.`pno`,
       `nombers`.`knownas`,
       `nombers`.`firstname`,
       `nombers`.`surname`,
       `nombers`.`cattoname`,
       `nombers`.`displ`,
       `ipaddress`.`namefb`,
CASE
  WHEN `newatwork`.`checked` = 'c' THEN 0
  ELSE `newatwork`.`id`
END AS newatwork     
FROM `nombers`
  LEFT JOIN `inout` ON `nombers`.`pno` = `inout`.`no`
  LEFT JOIN `ipaddress` ON `inout`.`ipadr` = `ipaddress`.`IP`
  LEFT JOIN `newatwork` ON `nombers`.`pno` = `newatwork`.`no`
WHERE `nombers`.`status` = 'OK'
  AND `inout`.`date1` = CURDATE()
  AND `nombers`.`pno` <> '5'
  AND `nombers`.`cat` <> 'ui'
  AND `nombers`.`cat` <> 'ut'
  AND `newatwork`.`date1` = CURDATE()
GROUP BY `nombers`.`pno`
ORDER BY knownas";
    $db->Query($sql);
    if (!$db->Query($sql)) $db->Kill();
    $paidpeople = $db->Rows();
    $trialpeople = $db3->Rows();
    $clpaidrowsnumber=$paidpeople+$trialpeople;
    $clpaidtablenumber = 0;
	
    if ($clpaidrowsnumber % 2) $clpaidrowsleft = floor($clpaidrowsnumber / 2) + 1;
    else $clpaidrowsleft = $clpaidrowsnumber/2;
    
    $i=0;
    while ($row=$db->Row()) {
        $clpaidtabletime = array();
        $name = $row->knownas."&nbsp;".$row->surname."&nbsp;".$row->cattoname;
        if (!isset($row->namefb)) $namefb = "&nbsp;";
        else $namefb = $row->namefb;
     
        // $sql2 = "SELECT no, d1, t1, t2, descin, descout from (SELECT `inout`.`no`, DATE_FORMAT(`inout`.`date1`, \"%d/%m/%Y\") as d1, DATE_FORMAT(`inout`.`intime`, \"%H:%i\") as t1, DATE_FORMAT(`inout`.`outtime`, \"%H:%i\") as t2, `inout`.`descin`, `inout`.`descout` FROM `inout` WHERE `inout`.`date1`=CURDATE() AND `inout`.`no`='$row->pno' ORDER BY `inout`.`intime` DESC LIMIT 5) As x Order by t1 ASC";
        $sql2 = "SELECT no, DATE_FORMAT(`date1`, \"%d/%m/%Y\") as d1,DATE_FORMAT( `intime`, \"%H:%i\") As t1 , DATE_FORMAT(`outtime`, \"%H:%i\") as t2, descin, descout from (SELECT `inout`.`no`, `inout`.`date1`, `inout`.`intime`, `inout`.`outtime`, `inout`.`descin`, `inout`.`descout` FROM `inout` WHERE `inout`.`date1`=CURDATE() AND `inout`.`no`='$row->pno' ORDER BY `inout`.`intime` DESC LIMIT 5) As x Order by intime ASC";
        if (!$db2->Query($sql2)) $db2->Kill();
        while ($row2=$db2->Row()) {
            $t2 =$row2->t2;
            if ($t2 == "00:00") {
                $inout = 0;
                $t2 = "&nbsp;";
            }
            else {
                $inout = 1;
            }
            $clpaidtabletime[] = array($row2->t1,$t2);
        }
        $inoutnumber = count($clpaidtabletime);
        for ($j=$inoutnumber; $j<5; $j++) {
            $clpaidtabletime[] = array ("&nbsp;","&nbsp;");
        }
        
        $temptable[] = array ($row->pno, $inout, $row->newatwork, $name, $namefb, $clpaidtabletime); // [0][0][]
    }
    while ($row=$db3->Row()) {
        $clpaidtabletime = array();
        $name = $row->name."&nbsp;".$row->surname."&nbsp;".$row->code;
        if (!isset($row->namefb)) $namefb = "&nbsp;";
        else $namefb = $row->namefb;

        $inout = 0;
        $t2 = "&nbsp;";
        $clpaidtabletime[] = array(substr($row->in,0,5),$t2);

        $inoutnumber = count($clpaidtabletime);
        for ($j=$inoutnumber; $j<5; $j++) {
            $clpaidtabletime[] = array ("&nbsp;","&nbsp;");
        }
        
        $temptable2[] = array (0, $inout, 0, $name, $namefb, $clpaidtabletime); // [0][0][]
    }
    
    $clpaidtablenumber = 0;    

    $i=0;
    $j=0;    
    while (($i+$j)<$clpaidrowsnumber)
	{
	
        if (($i+$j) >= $clpaidrowsleft) $clpaidtablenumber = 1;   // cltanlenumber:  0 - left, 1 right
	if (($i<$paidpeople) and($j<$trialpeople)){
    	    if (strcmp($temptable[$i][3],$temptable2[$j][3])<=0){
	    $clpaidtable[$clpaidtablenumber][] = $temptable [$i]; // [0][0][]
    	    $i+=1;
    	    }
    	    else {
    	    $temptable2[$j][3] = "<span class = 'blinker' style='visibility: hidden;'><font color=black>".$temptable2[$j][3]."</font></span>" ;
	    $clpaidtable[$clpaidtablenumber][] = $temptable2 [$j]; // [0][0][]
    	    $j+=1;
	    }
	}
	else {
	    if (($i<$paidpeople)){
	    $clpaidtable[$clpaidtablenumber][] = $temptable [$i]; // [0][0][]
    	    $i+=1;

		}
    	    if ($j<$trialpeople){
    	    $temptable2[$j][3] = "<span class = 'blinker' style='visibility: hidden;'><font color=black>".$temptable2[$j][3]."</font></span>" ;
	    $clpaidtable[$clpaidtablenumber][] = $temptable2 [$j]; // [0][0][]
    	    $j+=1;
    	    }
        }
    }
	
    $smarty->assign("clpaidtableleft", $clpaidtable[0]);
    $smarty->assign("clpaidtableright", $clpaidtable[1]);
	
	}
    //$smarty->assign("clpaidrowsnumber", $clpaidrowsnumber);
    //$smarty->assign("clpaidrowsleft", $clpaidrowsleft);
    
    //-----------------------END PAID STAFF-----------------------
    
    if ($_SESSION['clockingver'] == 2 || $_SESSION['clockingver'] == 3) {
 
        //-----------------------START UNPAID STAFF---------------------

        // Clocking table for TRIAL DAY staff
        $cltrialtable[0] = array();
        $cltrialtable[1] = array();

        $sql= "SELECT `nombers`.`pno`,
           `nombers`.`knownas`,
           `nombers`.`firstname`,
           `nombers`.`surname`,
           `nombers`.`cattoname`,
           `nombers`.`displ`,
           `ipaddress`.`namefb`,
    CASE
      WHEN `newatwork`.`checked` = 'c' THEN 0
      ELSE `newatwork`.`id`
    END AS newatwork     
    FROM `nombers`
      LEFT JOIN `inout` ON `nombers`.`pno` = `inout`.`no`
      LEFT JOIN `ipaddress` ON `inout`.`ipadr` = `ipaddress`.`IP`
      LEFT JOIN `newatwork` ON `nombers`.`pno` = `newatwork`.`no`
    WHERE `nombers`.`status` = 'OK'
      AND `inout`.`date1` = CURDATE()
      AND `nombers`.`pno` <> '5'
      AND `nombers`.`cat` = 'ut'
      AND `newatwork`.`date1` = CURDATE()
    GROUP BY `nombers`.`pno`
    ORDER BY knownas";
        $db->Query($sql);
        if (!$db->Query($sql)) $db->Kill();
        $cltrialrowsnumber=$db->Rows();
        $cltrialtablenumber = 0;

        if ($cltrialrowsnumber % 2) $cltrialrowsleft = floor($cltrialrowsnumber / 2) + 1;
        else $cltrialrowsleft = $cltrialrowsnumber/2;

        $i=0;
        while ($row=$db->Row()) {
            $cltrialtabletime = array();

            if ($i >= $cltrialrowsleft) $cltrialtablenumber = 1;   // cltanlenumber:  0 - left, 1 right

            $name = $row->knownas."&nbsp;".$row->surname."&nbsp;".$row->cattoname;

            if (!isset($row->namefb)) $namefb = "&nbsp;";
            else $namefb = $row->namefb;

            // $sql2 = "SELECT no, d1, t1, t2, descin, descout from (SELECT `inout`.`no`, DATE_FORMAT(`inout`.`date1`, \"%d/%m/%Y\") as d1, DATE_FORMAT(`inout`.`intime`, \"%H:%i\") as t1, DATE_FORMAT(`inout`.`outtime`, \"%H:%i\") as t2, `inout`.`descin`, `inout`.`descout` FROM `inout` WHERE `inout`.`date1`=CURDATE() AND `inout`.`no`='$row->pno' ORDER BY `inout`.`intime` DESC LIMIT 5) As x Order by t1 ASC";
            $sql2 = "SELECT no, DATE_FORMAT(`date1`, \"%d/%m/%Y\") as d1,DATE_FORMAT( `intime`, \"%H:%i\") As t1 , DATE_FORMAT(`outtime`, \"%H:%i\") as t2, descin, descout from (SELECT `inout`.`no`, `inout`.`date1`, `inout`.`intime`, `inout`.`outtime`, `inout`.`descin`, `inout`.`descout` FROM `inout` WHERE `inout`.`date1`=CURDATE() AND `inout`.`no`='$row->pno' ORDER BY `inout`.`intime` DESC LIMIT 5) As x Order by intime ASC";
            if (!$db2->Query($sql2)) $db2->Kill();
            while ($row2=$db2->Row()) {
                $t2 =$row2->t2;
                if ($t2 == "00:00") {
                    $inout = 0;
                    $t2 = "&nbsp;";
                }
                else {
                    $inout = 1;
                }
                $cltrialtabletime[] = array($row2->t1,$t2);
            }
            $inoutnumber = count($cltrialtabletime);
            for ($j=$inoutnumber; $j<5; $j++) {
                $cltrialtabletime[] = array ("&nbsp;","&nbsp;");
            }

            $cltrialtable[$cltrialtablenumber][] = array ($row->pno, $inout, $row->newatwork, $name, $namefb, $cltrialtabletime); // [0][0][]
            $i++;
        }

        $smarty->assign("cltrialtableleft", $cltrialtable[0]);
        $smarty->assign("cltrialtableright", $cltrialtable[1]);
        $smarty->assign("cltrialrowsnumber", $cltrialrowsnumber);
        //$smarty->assign("cltrialrowsleft", $cltrialrowsleft);

        //-----------------------END TRIAL DAY STAFF---------------------
        
        // Clocking table for INTERN staff
        $clinterntable[0] = array();
        $clinterntable[1] = array();

        $sql= "SELECT `nombers`.`pno`,
           `nombers`.`knownas`,
           `nombers`.`firstname`,
           `nombers`.`surname`,
           `nombers`.`cattoname`,
           `nombers`.`displ`,
           `ipaddress`.`namefb`,
    CASE
      WHEN `newatwork`.`checked` = 'c' THEN 0
      ELSE `newatwork`.`id`
    END AS newatwork     
    FROM `nombers`
      LEFT JOIN `inout` ON `nombers`.`pno` = `inout`.`no`
      LEFT JOIN `ipaddress` ON `inout`.`ipadr` = `ipaddress`.`IP`
      LEFT JOIN `newatwork` ON `nombers`.`pno` = `newatwork`.`no`
    WHERE `nombers`.`status` = 'OK'
      AND `inout`.`date1` = CURDATE()
      AND `nombers`.`pno` <> '5'
      AND `nombers`.`cat` = 'ui'
      AND `newatwork`.`date1` = CURDATE()
    GROUP BY `nombers`.`pno`
    ORDER BY knownas";
        $db->Query($sql);
        if (!$db->Query($sql)) $db->Kill();
        $clinternrowsnumber=$db->Rows();
        $clinterntablenumber = 0;

        if ($clinternrowsnumber % 2) $clinternrowsleft = floor($clinternrowsnumber / 2) + 1;
        else $clinternrowsleft = $clinternrowsnumber/2;

        $i=0;
        while ($row=$db->Row()) {
            $clinterntabletime = array();

            if ($i >= $clinternrowsleft) $clinterntablenumber = 1;   // cltanlenumber:  0 - left, 1 right

            $name = $row->knownas."&nbsp;".$row->surname."&nbsp;".$row->cattoname;

            if (!isset($row->namefb)) $namefb = "&nbsp;";
            else $namefb = $row->namefb;

            // $sql2 = "SELECT no, d1, t1, t2, descin, descout from (SELECT `inout`.`no`, DATE_FORMAT(`inout`.`date1`, \"%d/%m/%Y\") as d1, DATE_FORMAT(`inout`.`intime`, \"%H:%i\") as t1, DATE_FORMAT(`inout`.`outtime`, \"%H:%i\") as t2, `inout`.`descin`, `inout`.`descout` FROM `inout` WHERE `inout`.`date1`=CURDATE() AND `inout`.`no`='$row->pno' ORDER BY `inout`.`intime` DESC LIMIT 5) As x Order by t1 ASC";
            $sql2 = "SELECT no, DATE_FORMAT(`date1`, \"%d/%m/%Y\") as d1,DATE_FORMAT( `intime`, \"%H:%i\") As t1 , DATE_FORMAT(`outtime`, \"%H:%i\") as t2, descin, descout from (SELECT `inout`.`no`, `inout`.`date1`, `inout`.`intime`, `inout`.`outtime`, `inout`.`descin`, `inout`.`descout` FROM `inout` WHERE `inout`.`date1`=CURDATE() AND `inout`.`no`='$row->pno' ORDER BY `inout`.`intime` DESC LIMIT 5) As x Order by intime ASC";
            if (!$db2->Query($sql2)) $db2->Kill();
            while ($row2=$db2->Row()) {
                $t2 =$row2->t2;
                if ($t2 == "00:00") {
                    $inout = 0;
                    $t2 = "&nbsp;";
                }
                else {
                    $inout = 1;
                }
                $clinterntabletime[] = array($row2->t1,$t2);
            }
            $inoutnumber = count($clinterntabletime);
            for ($j=$inoutnumber; $j<5; $j++) {
                $clinterntabletime[] = array ("&nbsp;","&nbsp;");
            }

            $clinterntable[$clinterntablenumber][] = array ($row->pno, $inout, $row->newatwork, $name, $namefb, $clinterntabletime); // [0][0][]
            $i++;
        }

        $smarty->assign("clinterntableleft", $clinterntable[0]);
        $smarty->assign("clinterntableright", $clinterntable[1]);
        $smarty->assign("clinternrowsnumber", $clinternrowsnumber);
        //$smarty->assign("clinternrowsleft", $clinternrowsleft);

        //-----------------------END INTERN STAFF---------------------
        
    } //end UNPAID clocking list
        

    //echo "aaa". $cltable[0][0]. "BBB". $cltable[0][1][0][0]. "BBB". $cltable[0][1][0][1]. "BBB". "BBB". $cltable[0][1][0][2];
    //echo "<br>DDD". $cltable[1][0]. "BBB". $cltable[1][1][0][0]. "BBB". $cltable[1][1][0][1]. "BBB". "BBB". $cltable[1][1][0][2];

    $output = $smarty->fetch('clocking_list.html');
    $output = "$shop<clocking>$noshop<clocking>$understaffingvalue<clocking>$output";

    //echo "XXX".count($cltable[0][1]);
    //print_r ($cltable[0]);
    echo $output;
}

?>
