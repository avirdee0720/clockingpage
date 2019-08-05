<?php
require_once("./inc/securitycheck.inc.php");

session_start();

require_once("./inc/mysql.inc.php");
require_once('libs/Smarty.class.php');

function EscapeSpaceAndDashes($str) {
	$str = str_replace(" ", "&nbsp;", $str);
	$str = str_replace("-", "&#x2011;", $str);
	return $str;
}

$smarty = new Smarty;

$PHP_SELF=$_SERVER['PHP_SELF'];
$ip = $_SERVER['REMOTE_ADDR'];
$do=$_GET['do'];

if (array_key_exists('clockingver', $_SESSION))
    $smarty->assign("clversion", $_SESSION['clockingver']);
else
    $smarty->assign("clversion", 0);

$db = new CMySQL;
$db2 = new CMySQL;
$db3 = new CMySQL;
$dbsec = new CMySQL;
if (!$db->Open()) $db->Kill();
if (!$db2->Open()) $db2->Kill();
if (!$db3->Open()) $db3->Kill();
if (!$dbsec->Open()) $dbsec->Kill();

if ($do == "clversion") {
    $q = "
	SELECT value AS clversion
	FROM `defaultvalues`
	WHERE `code` = 'clversion'
	";
    $db->Query($q);
    $r=$db->Row();
    $clversion=$r->clversion;
    echo $clversion;
}

if ($do == "cltable") {    
    $sql = "
		SELECT COUNT(DISTINCT n.pno) AS num
		FROM nombers n
		  LEFT JOIN `inout` iot ON n.pno = iot.`no`
		WHERE n.`status` = 'OK'
		  AND iot.date1 = CURDATE()
		  AND n.pno <> '5'
		  AND ((LOCATE('.', n.cattoname) <> 0) OR ((LOCATE(',', n.cattoname) <> 0) AND (WEEKDAY(iot.date1) IN (5, 6))))
		  AND iot.ipadr not like '192.168.23.%';
	";
    $db->Query($sql);
    $row=$db->Row();
    $shop=$row->num;
 
    $sql = "
		SELECT COUNT(DISTINCT n.pno) AS num
		FROM nombers n
		  LEFT JOIN `inout` iot ON n.pno = iot.`no`
		WHERE n.`status` = 'OK'
		  AND iot.date1 = CURDATE()
		  AND n.pno <> '5'
		  AND ((LOCATE('.', n.cattoname) <> 0) OR ((LOCATE(',', n.cattoname) <> 0) AND (WEEKDAY(iot.date1) IN (5, 6))))
		  AND iot.ipadr not like '192.168.23.%'
		  AND outtime = '00:00:00';
	";
    $db->Query($sql);
    $row=$db->Row();
    $noshop=$row->num;
 
    $sql = "
	SELECT value AS understaffingvalue
	FROM `defaultvalues`
	WHERE `code` = 'understaffingvalue'
	";
    $db->Query($sql);
    $row = $db->Row();
    $understaffingvalue = $row->understaffingvalue; 
    
    //-----------------------START PAID STAFF-----------------------

    // Clocking table for clocking version 1 and 2
    $clpaidtable[0] = array();
    $clpaidtable[1] = array();
    $sql3 = "
	SELECT trialdays.name,
	       trialdays.surname,
		   trialdays.code,
		   ipaddress.namefb,
		   time(time) AS `in`
	FROM trialdays
	LEFT JOIN ipaddress on trialdays.ip = ipaddress.IP
	WHERE date(time) = CURDATE()
	ORDER BY trialdays.name";
    $db3->Query($sql3);
    
    if ($db3->Rows() < 1) {
    $sql= "
	SELECT n.pno,
		   n.knownas,
		   n.surname,
		   n.assessment,
		   n.cattoname,
		   IF(naw.checked = 'c', 0, naw.id) AS newatwork,
		   (SELECT ip.namefb
		    FROM `inout` io
				LEFT JOIN ipaddress ip ON io.ipadr = ip.IP
		    WHERE io.`no` = n.pno
		      AND io.date1 = CURDATE()
		    ORDER BY io.intime DESC
		    LIMIT 1) AS namefb
	FROM nombers n
		LEFT JOIN newatwork naw ON n.pno = naw.`no`
	WHERE n.`status` = 'OK'  
	  AND n.pno NOT IN (5, 555)
	  AND n.cat NOT IN ('ui', 'ut')
	  AND naw.date1 = CURDATE()
	GROUP BY n.pno
	ORDER BY n.knownas
	";
    $db->Query($sql);
    if (!$db->Query($sql)) $db->Kill();
    $clpaidrowsnumber = $db->Rows();
    $clpaidtablenumber = 0;	
    if ($clpaidrowsnumber % 2)
		$clpaidrowsleft = floor($clpaidrowsnumber / 2) + 1;
    else
		$clpaidrowsleft = $clpaidrowsnumber/2;
    
    $i = 0;
    while ($row=$db->Row()) {
        $clpaidtabletime = array();
    
        if ($i >= $clpaidrowsleft) $clpaidtablenumber = 1;   // cltanlenumber:  0 - left, 1 right
    
		if ($row->assessment == '0')
			$name = $row->knownas."&nbsp;".$row->surname."&nbsp;".$row->cattoname;
		else {			
			$q = "SELECT COUNT(*) AS num
				  FROM ipaddress
				  WHERE IP = '$ip'
					AND UPPER(namefb) IN ('OFFICE');
				 ";
			if (!$dbsec->Query($q)) $dbsec->Kill();
			$r = $dbsec->Row();
			if ($r->num > 0)			
				$name = strtoupper($row->knownas)."&nbsp;".strtoupper($row->surname)."&nbsp;".$row->cattoname;
			else
				$name = $row->knownas."&nbsp;".$row->surname."&nbsp;".$row->cattoname;
		}
		$name = EscapeSpaceAndDashes($name);
		
        if (isset($row->namefb))
			$namefb = EscapeSpaceAndDashes($row->namefb);
        else
			$namefb = "&nbsp;";
             
        $sql2 = "
		SELECT no,
			   DATE_FORMAT(`date1`, \"%d/%m/%Y\") AS d1,
			   DATE_FORMAT(`intime`, \"%H:%i\") AS t1,
			   DATE_FORMAT(`outtime`, \"%H:%i\") AS t2
		FROM (
			SELECT `inout`.`id`,
				   `inout`.`no`,
				   `inout`.`date1`,
				   `inout`.`intime`,
				   `inout`.`outtime`
			FROM `inout`
			WHERE `inout`.`date1` = CURDATE()
			  AND `inout`.`no` = '$row->pno'
			ORDER BY `inout`.`intime` DESC, `inout`.`id` DESC
			LIMIT 5
		) AS x
		ORDER BY intime ASC, id ASC
		";
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
    $sql= "
	SELECT n.pno,
		   n.knownas,
		   n.surname,
		   n.assessment,
		   n.cattoname,
		   IF(naw.checked = 'c', 0, naw.id) AS newatwork,
		   (SELECT ip.namefb
		    FROM `inout` io
				LEFT JOIN ipaddress ip ON io.ipadr = ip.IP
		    WHERE io.`no` = n.pno
		      AND io.date1 = CURDATE()
		    ORDER BY io.intime DESC
		    LIMIT 1) AS namefb
	FROM nombers n
		LEFT JOIN newatwork naw ON n.pno = naw.`no`
	WHERE n.`status` = 'OK'  
	  AND n.pno NOT IN (5, 555)
	  AND n.cat NOT IN ('ui', 'ut')
	  AND naw.date1 = CURDATE()
	GROUP BY n.pno
	ORDER BY n.knownas
	";
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
		if ($row->assessment == '0')
			$name = $row->knownas."&nbsp;".$row->surname."&nbsp;".$row->cattoname;
		else {			
			$q = "SELECT COUNT(*) AS num
				  FROM ipaddress
				  WHERE IP = '$ip'
					AND UPPER(namefb) IN ('OFFICE');
				 ";
			if (!$dbsec->Query($q)) $dbsec->Kill();
			$r = $dbsec->Row();
			if ($r->num > 0)			
				$name = strtoupper($row->knownas)."&nbsp;".strtoupper($row->surname)."&nbsp;".$row->cattoname;
			else
				$name = $row->knownas."&nbsp;".$row->surname."&nbsp;".$row->cattoname;
		}
		$name = EscapeSpaceAndDashes($name);
		
        if (isset($row->namefb))
			$namefb = EscapeSpaceAndDashes($row->namefb);
        else
			$namefb = "&nbsp;";
        $sql2 = "
		SELECT no,
		       DATE_FORMAT(`date1`, \"%d/%m/%Y\") AS d1,
			   DATE_FORMAT(`intime`, \"%H:%i\") AS t1,
			   DATE_FORMAT(`outtime`, \"%H:%i\") AS t2
		FROM (
			SELECT `inout`.`id`,
				   `inout`.`no`,
				   `inout`.`date1`,
				   `inout`.`intime`,
				   `inout`.`outtime`
			FROM `inout`
			WHERE `inout`.`date1` = CURDATE()
			  AND `inout`.`no` = '$row->pno'
			ORDER BY `inout`.`intime` DESC, `inout`.`id` DESC
			LIMIT 5
		) AS x
		ORDER BY intime ASC, id ASC
		";
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
		$name = EscapeSpaceAndDashes($name);
        if (isset($row->namefb))
			$namefb = EscapeSpaceAndDashes($row->namefb);
        else
			$namefb = "&nbsp;";
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
	
        if (($i+$j) >= $clpaidrowsleft) $clpaidtablenumber = 1;   // cltablenumber:  0 - left, 1 right
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

        $sql= "
		SELECT n.pno,
			   n.knownas,
		       n.surname,
		       n.assessment,
		       n.cattoname,
		       IF(naw.checked = 'c', 0, naw.id) AS newatwork,
		       (SELECT ip.namefb
		    	FROM `inout` io
					LEFT JOIN ipaddress ip ON io.ipadr = ip.IP
		    	WHERE io.`no` = n.pno
		      	  AND io.date1 = CURDATE()
		    	ORDER BY io.intime DESC
		    	LIMIT 1) AS namefb
		FROM nombers n
			LEFT JOIN newatwork naw ON n.pno = naw.`no`
		WHERE n.`status` = 'OK'  
		  AND n.pno NOT IN (5, 555)
		  AND n.cat LIKE 'ut'
		  AND naw.date1 = CURDATE()
		GROUP BY n.pno
		ORDER BY n.knownas
		";
        $db->Query($sql);
        if (!$db->Query($sql)) $db->Kill();
        $cltrialrowsnumber=$db->Rows();
        $cltrialtablenumber = 0;

        if ($cltrialrowsnumber % 2) $cltrialrowsleft = floor($cltrialrowsnumber / 2) + 1;
        else $cltrialrowsleft = $cltrialrowsnumber/2;

        $i=0;
        while ($row=$db->Row()) {
            $cltrialtabletime = array();

            if ($i >= $cltrialrowsleft) $cltrialtablenumber = 1;   // cltablenumber:  0 - left, 1 right

            $name = $row->knownas."&nbsp;".$row->surname."&nbsp;".$row->cattoname;
			$name = EscapeSpaceAndDashes($name);

            if (isset($row->namefb))
				$namefb = EscapeSpaceAndDashes($row->namefb);
            else
				$namefb = "&nbsp;";
            $sql2 = "
			SELECT no,
			       DATE_FORMAT(`date1`, \"%d/%m/%Y\") AS d1,
				   DATE_FORMAT(`intime`, \"%H:%i\") AS t1,
				   DATE_FORMAT(`outtime`, \"%H:%i\") AS t2
			FROM (
				SELECT `inout`.`id`,
					   `inout`.`no`,
					   `inout`.`date1`,
					   `inout`.`intime`,
					   `inout`.`outtime`
				FROM `inout`
				WHERE `inout`.`date1` = CURDATE()
				  AND `inout`.`no` = '$row->pno'
				ORDER BY `inout`.`intime` DESC, `inout`.`id` DESC
				LIMIT 5
			) AS x
			ORDER BY intime ASC, id ASC
			";
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

        $sql= "
		SELECT n.pno,
			   n.knownas,
		       n.surname,
		       n.assessment,
		       n.cattoname,
		       IF(naw.checked = 'c', 0, naw.id) AS newatwork,
		       (SELECT ip.namefb
		    	FROM `inout` io
					LEFT JOIN ipaddress ip ON io.ipadr = ip.IP
		    	WHERE io.`no` = n.pno
		      	  AND io.date1 = CURDATE()
		    	ORDER BY io.intime DESC
		    	LIMIT 1) AS namefb
		FROM nombers n
			LEFT JOIN newatwork naw ON n.pno = naw.`no`
		WHERE n.`status` = 'OK'  
		  AND n.pno NOT IN (5, 555)
		  AND n.cat LIKE 'ui'
		  AND naw.date1 = CURDATE()
		GROUP BY n.pno
		ORDER BY n.knownas
		";
        $db->Query($sql);
        if (!$db->Query($sql)) $db->Kill();
        $clinternrowsnumber=$db->Rows();
        $clinterntablenumber = 0;

        if ($clinternrowsnumber % 2) $clinternrowsleft = floor($clinternrowsnumber / 2) + 1;
        else $clinternrowsleft = $clinternrowsnumber/2;

        $i=0;
        while ($row=$db->Row()) {
            $clinterntabletime = array();

            if ($i >= $clinternrowsleft) $clinterntablenumber = 1;   // cltablenumber:  0 - left, 1 right

            $name = $row->knownas."&nbsp;".$row->surname."&nbsp;".$row->cattoname;
			$name = EscapeSpaceAndDashes($name);

            if (isset($row->namefb))
				$namefb = EscapeSpaceAndDashes($row->namefb);
            else
				$namefb = "&nbsp;";
            $sql2 = "
			SELECT no,
			       DATE_FORMAT(`date1`, \"%d/%m/%Y\") AS d1,
				   DATE_FORMAT(`intime`, \"%H:%i\") AS t1,
				   DATE_FORMAT(`outtime`, \"%H:%i\") AS t2
			FROM (
				SELECT `inout`.`id`,
					   `inout`.`no`,
					   `inout`.`date1`,
					   `inout`.`intime`,
					   `inout`.`outtime`
				FROM `inout`
				WHERE `inout`.`date1` = CURDATE()
				  AND `inout`.`no` = '$row->pno'
				ORDER BY `inout`.`intime` DESC, `inout`.`id` DESC
				LIMIT 5
			) AS x
			ORDER BY intime ASC, id ASC
			";
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

    $output = $smarty->fetch('clocking_list.html');
    $output = "$shop<clocking>$noshop<clocking>$understaffingvalue<clocking>$output";
	echo $output;
}

?>
