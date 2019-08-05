<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$dataakt=date("d/m/Y H:i:s");
$msgdb = new CMySQL;
uprstr($PU,90);

(!isset($_POST['startd'])) ? $sd = $_GET['startd'] : $sd = $_POST['startd'];
(!isset($_POST['endd'])) ? $ed = $_GET['endd'] : $ed = $_POST['endd'];
list($day, $month, $year) = explode("/",$sd);
$dod = "$year-$month-$day";
list($day1, $month1, $year1) = explode("/",$ed);
$ddo= "$year1-$month1-$day1";
(!isset($_POST['cln'])) ? $nr = $_GET['cln'] : $nr = $_POST['cln'];
(!isset($_POST['state'])) ? $state = 0 : $state = $_POST['state'];
(!isset($_POST['licznik'])) ? $licz = 0 : $licz = $_POST['licznik'];
$recid = array();
for ($i = 0; $i < $licz; $i++) {
    (!isset($_POST["id_$i"])) ? $recid[$i] = 0 : $recid[$i] = $_POST["id_$i"];
    (!isset($_POST["t1_$i"])) ? $t1[$i] = "00:00:00:00" : $t1[$i] = $_POST["t1_$i"];
    (!isset($_POST["t2_$i"])) ? $t2[$i] = "00:00:00:00" : $t2[$i] = $_POST["t2_$i"];
    (!isset($_POST["upt_$i"])) ? $upt[$i] = "" : $upt[$i] = $_POST["upt_$i"];
    (!isset($_POST["del_$i"])) ? $del[$i] = "" : $del[$i] = $_POST["del_$i"];
}
for ($i = 0; $i < $licz; $i++) {
    if ($upt[$i] !== "") $upt[$i] = "on";
    if ($del[$i] !== "") $del[$i] = "on";
}

$wynik="";

function SecToTime($Sec){
   $ZH = $Sec / 3600;
   $ZM = $Sec / 60 - $ZH * 60;
   $ZS = $Sec - ($ZH * 3600 + $ZM * 60);
   return("$ZH:$ZM:$ZS");
}

if($state==0)
{
echo "<font class='FormHeaderFont'>Employees payrol/ClockingIN-OUT NO: $nr<BR>Dates: $dod until $ddo</font>
	<BR>
	<form action='$PHP_SELF' method='post' name='ed_godz'>

		<table WIDTH=500 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >
		 <tr>
		    <td class='FieldCaptionTD'><B>Day</B></td>
		     <td class='FieldCaptionTD'><B>IN</B></td>
			 <td class='FieldCaptionTD'><B>OUT</B></td>
			 <td class='FieldCaptionTD'><B>Upd.</B></td>
			 <td class='FieldCaptionTD'><B>DEL</B></td>
			 <td class='FieldCaptionTD'><B>Message</B></td>
			</tr>";

if(!isset($sort)) $sort=1;
	switch ($sort)
		{
		case 1:
		 $sortowanie=" ORDER BY `inout`.`date1` DESC, `inout`.`intime` DESC";
		 break;
		case 2:
		 $sortowanie=" ORDER BY `nombers`.`knownas` ASC";
		 break;
		case 3:
		 $sortowanie=" ORDER BY `inout`.`date1` ASC";
		 break;
		case 4:
		 $sortowanie=" ORDER BY `inout`.`intime` ASC ";
		 break;
		case 5:
		 $sortowanie=" ORDER BY `inout`.`outtime` ASC";
		 break;
		case 6:
		 $sortowanie=" ORDER BY `ipaddress`.`name` ASC";
		 break;


		default:
		 $sortowanie=" ORDER BY `inout`.`date1` DESC, `inout`.`intime` DESC ";
		 break;
		}

$db = new CMySQL;
if (!$db->Open()) $db->Kill();
$sql = "SELECT `inout`.`id`, `inout`.`ino`, DATE_FORMAT(`inout`.`date1`, \"%d/%m/%Y\") as d1, 
DATE_FORMAT(`inout`.`intime`, \"%H:%i:%s\") as t1, DATE_FORMAT(`inout`.`outtime`, \"%H:%i:%s\") as t2, 
`inout`.`no`, `inout`.`checked`, `nombers`.`knownas`, `nombers`.`firstname`, `nombers`.`surname`, `nombers`.`status`, 
`ipaddress`.`name` 
FROM `inout`
LEFT JOIN `nombers` ON `inout`.`no` = `nombers`.`pno` 
LEFT JOIN `ipaddress` ON `inout`.`ipadr` = `ipaddress`.`IP` 
WHERE  `inout`.`no` LIKE '$nr' AND `inout`.`date1`>='$dod' AND `inout`.`date1`<='$ddo'";
$q=$sql.$sortowanie;
$licz=0;

if ($db->Query($q)) 
  {
    while ($row=$db->Row())
    {
		if (!$msgdb->Open()) $msgdb->Kill();
			$sql2ab = "SELECT message FROM `inoutmsg` WHERE idinout='$row->id'";
			if (!$msgdb->Query($sql2ab)) $msgdb->Kill();
			$messagesLeft=$msgdb->Row();
		if(isset($messagesLeft->message) &&  $messagesLeft->message <> "") { $wiad="$messagesLeft->message";} else { $wiad=""; }

if($row->checked == "n") { $checked="<INPUT TYPE='checkbox' NAME='upt_$licz'>";} else $checked="Y";
if($row->t2!=="00:00:00") { 
	$h4=strtotime("$row->d1 $row->t2")-strtotime("$row->d1 $row->t1"); 
	$h3=$h4/3600; 
	$h2=$h3;
	$h1=number_format($h2,2,'.',' ');
	$d2=$row->t2;
	$colcol="DataTD";
//	$h1="�".$h1;

//	$h1="OUT";
	$godzina="";
	$minuta="";
	$Propozycja="";
	if(!isset($who)) {$who=$row->knownas; $PN=$row->no; $fname=$row->firstname; $sname=$row->surname;}

	}
	else {  			
			$gm1 = explode(":", "20:00");
			$godzina1=$gm1[0];
			$minuty1=$gm1[1];

			$gm2 = explode(":", $row->t1);
			$godzina2=$gm2[0];
			$minuty2=$gm2[1];

			if($minuty1 < $minuty2) { $minuty1=$minuty1+60; $godzina1=$godzina1-1; }

			$minutaW1=$minuty1-$minuty2;
			$godzinaW1=$godzina1-$godzina2;
			$czas1=$godzinaW1.".".$minutaW1;
			$czas2=number_format($czas1*0.85,2,'.',' ');

			$idDot = strpos($czas2, '.');
			$godzdod=substr($czas2,0,$idDot);
			$mindod=substr($czas2,$idDot+1,2);

			$minpodod=$minuty2 + $mindod;
			$godpodod=$godzina2 + $godzdod;

	if(	$minpodod >= 60 ) 
		{ 
			$minpodod = $minpodod - 60; 
			$godpodod = $godpodod + 1;
			if(	strlen($minpodod) < 2 ) 
			{ $minpodod="0".$minpodod;  }
		}
	if(	strlen($minpodod) < 2 ) { $minpodod="0".$minpodod;  }
	if(isset($godpodod) && isset($minpodod)) $wynik  = "$godpodod:$minpodod";
			
			
			$h1="IN";

	       $d2="";
		   	$colcol="DataTDout";}

     echo "
  <tr><input type='hidden' name='id_$licz' value='$row->id'>
     <td class='DataTD'><B>$row->d1</B></td>
     <td class='DataTD'><input class='Input' maxlength='8' name='t1_$licz' size='6' value='$row->t1'></td>
	 <td class=$colcol><input class='Input' maxlength='8' name='t2_$licz' size='6' value='$row->t2'></td>
	  <td class='DataTD'>$checked</td>
	  <td class='DataTD'><INPUT TYPE='checkbox' NAME='del_$licz'></td>
	  <td class='DataTD'>$wiad <FONT COLOR='#FF0000'><B>$wynik </B></FONT></td>
 </tr> ";
  $licz++;
  } 
} else {
echo " 
  <tr>
    <td class='DataTD'></td>
    <td class='DataTD' colspan='5'>SQL Error:".mysql_error()."</td>
  </tr>";
 $db->Kill();
}

echo "
</table>
			<input name='licznik' type='hidden' value='$licz'>
			<input name='cln' type='hidden' value='$nr'>
			<input name='startd' type='hidden' value='$sd'>
			<input name='endd' type='hidden' value='$ed'>
			<input name='state' type='hidden' value='1'>
			<input class='Button' name='Update' type='submit' value='$SAVEBTN'>
			<input class='Button'  type='Button' onclick='history.back()' value='$LISTBTN'></td>

</center>
</center>
<BR>
</FORM>
</td></tr>
</table>";


include_once("./footer.php");
}
elseif($state==1)
{    
function deltime($idtime){
$baza = new CMySQL;
$MsgMysql = new CMySQL;
$db_newatwork = new CMySQL;
if (!$baza->Open()) $baza->Kill();
if (!$db_newatwork->Open()) $db_newatwork->Kill();
    $sqlTime =("SELECT inout.id, inout.date1, inout.intime, inout.outtime, inout.no, inout.ipadr, inout.checked FROM `inout` WHERE  inout.id='$idtime' LIMIT 1");
    $sqlMsg =("SELECT inoutmsg.id, inoutmsg.message FROM inoutmsg WHERE  inoutmsg.idinout='$idtime' LIMIT 1 ");

  if (!$baza->Query($sqlTime)) $baza->Kill();
  $RowTime=$baza->Row();
		 if (!$baza->Query($sqlMsg)) $baza->Kill();
		 $RowMsg=$baza->Row();                 
                 if (!isset($RowMsg->message))
                         $msg = "";
                 else $msg = $RowMsg->message;
		 if (!$MsgMysql->Open()) $MsgMysql->Kill();
		 $sqlArch = "INSERT INTO `timeslog`(`id`, `date1`, `intime`, `outtime`, `no`, `msg`, `ipadr`, `checked`, `oldid`) VALUES(NULL, '$RowTime->date1', '$RowTime->intime', '$RowTime->outtime', '$RowTime->no', '$msg', '$RowTime->ipadr', '$RowTime->checked', '$RowTime->id' )";
			if (!$MsgMysql->Query($sqlArch)) { $MsgMysql->Kill(); }
			else {
				// get clockin number and date before deletion to identify the right record in newatwork later
				$q_newatwork = "SELECT `no`, date1 FROM `inout` WHERE `id` = ".$RowTime->id;
				if (!$db_newatwork->Query($q_newatwork)) $db_newatwork->Kill();
				$r_newatwork = $db_newatwork->Row();
				$clocking_no = $r_newatwork->no;
				$date1 = $r_newatwork->date1;

				$sqlDelIn = "DELETE FROM `inout` WHERE inout.id='$RowTime->id' LIMIT 1";
				if (!$MsgMysql->Query($sqlDelIn)) $MsgMysql->Kill();
				if (!isset($RowMsg->id))
					$rmsg = "";
				else
					$rmsg = $RowMsg->id;
				if($rmsg <> "") {
					$sqlDelMsg = "DELETE FROM `inoutmsg` WHERE inoutmsg.id='$RowMsg->id' LIMIT 1";
					if (!$MsgMysql->Query($sqlDelMsg)) $MsgMysql->Kill();
				}
				
				// delete the record from newatwork only if there are no corresponding records left in inout table
				$q_newatwork = "SELECT COUNT(*) AS cnt FROM `inout` WHERE `no` = ".$clocking_no." AND date1 = '".$date1."'";
				if (!$db_newatwork->Query($q_newatwork)) $db_newatwork->Kill();
				$r_newatwork = $db_newatwork->Row();
				if ($r_newatwork->cnt == 0) {
					$q_newatwork = "DELETE FROM newatwork WHERE `no` = ".$clocking_no." AND date1 = '".$date1."' LIMIT 1";
					if (!$db_newatwork->Query($q_newatwork)) $db_newatwork->Kill();
				}
			}
			$db_newatwork->Close();
}

$db = new CMySQL;
  if (!$db->Open())$db->Kill();
     for ($i = 0; $i < $licz; $i++) {
         if ($recid[$i] > 0) {
			 if($upt[$i]=="on"){
			// select data to update
			  $query0[$i] =("SELECT `intime`, `outtime`, `date1` FROM `inout` WHERE `inout`.`id`=$recid[$i]");  
			  //$result1[$i] = mysql_query($query1[$0]);
			  if ($db->Query($query0[$i])) 
			  {
			  while ($row=$db->Row())
			    {
				$date1old = $row->date1;
				$intimeold = $row->intime;
				$outtimeold = $row->outtime;
				} 
			  } 
			  $db->Free();

			//update the data
			  $query1[$i] =("UPDATE `inout` SET `intime`='$t1[$i]', `outtime`='$t2[$i]', `checked`='c' WHERE `inout`.`id`=$recid[$i]"); 
			  $result1[$i] = mysql_query($query1[$i]);
			  // update message!!!
			  $queryMsg[$i] =("UPDATE `inoutmsg` SET `checked`='c' WHERE `inoutmsg`.`idinout`=$recid[$i]");  
			  //$resultMsg[$i] = mysql_query($queryMsg[$i]);
			// if every update was sukcesful log previous data
				if ($db->Query($queryMsg[$i])) 
				{
					$op = "edit, $nr OLD Val. D:$date1old,I:$intimeold,O:$outtimeold";
					$godz      = date("G:m:s");
					$logi = "INSERT INTO hd_log ( lp, tabela, temat, kiedy, user_id, infodod) VALUES(null, 'inout', '$op', '$dzis $godz', '$id', 'totalh2e.php')";
					if (!$db->Query($logi)) $db->Kill();
				}

			}
	     }
     }
	 for ($i = 0; $i < $licz; $i++) {
         if ($recid[$i] > 0) {
			if($del[$i]=="on"){
			deltime($recid[$i]);
			}
	     }
     }



echo "<script language='javascript'>window.location=\"totalh2.php?cln=$nr&startd=$sd&endd=$ed\"</script>";
}
?>