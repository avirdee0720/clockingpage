<HTML>
<HEAD>
<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;

$dataakt=date("d/m/Y H:i:s");
$msgdb = new CMySQL;
$sd=$_GET['startd'];
$ed=$_GET['endd'];

function deltime($idtime){
$MsgMysql = new CMySQL;
if (!$db->Open()) $db->Kill();
    $sqlTime =("SELECT inout.id, inout.date1,inout.intime, inout.outtime, inout.no, inout.ipadr, inout.checked FROM inout WHERE  inout.id='$idtime' LIMIT 1");
	$sqlMsg =("SELECT inoutmsg.id, inoutmsg.message FROM inoutmsg WHERE  inoutmsg.idinout='$idtime' LIMIT 1 ");

  if (!$db->Query($sqlTime)) $db->Kill();
  $RowTime=$db->Row();
		 if (!$db->Query($sqlMsg)) $db->Kill();
		 $RowMsg=$db->Row();
		 if (!$MsgMysql->Open()) $MsgMysql->Kill();
		 $sqlArch = "INSERT INTO `timeslog`(`id`, `date1`, `intime`, `outtime`, `no`, `msg`, `ipadr`, `checked`, `oldid`) VALUES(NULL, '$RowTime->date1', '$RowTime->intime', '$RowTime->outtime', '$RowTime->no', '$RowMsg->message', '$RowTime->ipadr', '$RowTime->checked', '$RowTime->id')";
			if (!$MsgMysql->Query($sqlArch)) { $MsgMysql->Kill(); }
			else {
				$sqlDelIn = "DELETE FROM `inout` WHERE inout.id='$RowTime->id' LIMIT 1";
				if (!$MsgMysql->Query($sqlDelIn)) $MsgMysql->Kill();

				if($RowMsg->id<>"") {
					$sqlDelMsg = "DELETE FROM `inoutmsg` WHERE inoutmsg.id='$RowMsg->id' LIMIT 1";
					if (!$MsgMysql->Query($sqlDelMsg)) $MsgMysql->Kill();
				}
				$sqlOpt = "OPTIMIZE TABLE `inout` , `inoutmsg` , `timeslog` ";
				if (!$MsgMysql->Query($sqlOpt)) $MsgMysql->Kill();
			}
}

?>
<meta HTTP-EQUIV='cache-control' CONTENT='no-cache, must-revalidate'>
<link rel=stylesheet type=text/css href="hs.css">
<LINK REL='stylesheet' HREF='style/multipads/style.css' TYPE='text/css'>

</HEAD>

<body class=PageBODY bgcolor=#FFFFFF topmargin=0 leftmargin=0 marginwidth=0 marginheight=0 text=#000000 link=#0000FF vlink=#0000FF alink=#FF0000>
<CENTER>
<?php
echo "
<font class='FormHeaderFont'>$dataakt</font>

<table WIDTH=500 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >

  <tr>
	 <td class='FieldCaptionTD'>&nbsp;</td>
	 <td class='FieldCaptionTD'>&nbsp;</td>
	 <td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=1&startd=$sd&endd=$ed'>NO</A></td>
     <td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=2&startd=$sd&endd=$ed'>Known_as</A></td>
     <td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=3&startd=$sd&endd=$ed'><B>Day</B></A></td>
     <td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=4&startd=$sd&endd=$ed'><B>IN</B></A></td>
	 <td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=5&startd=$sd&endd=$ed'><B>OUT</B></A></td>
	 <td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=6&startd=$sd&endd=$ed'><B>Where/Computer</B></A></td>
	 <td class='FieldCaptionTD'><B>Total</B></td>
	 <td class='FieldCaptionTD'><B>Message</B></td>
	 	 <td class='FieldCaptionTD'><B>Checked</B></td>



   </tr>	
";
if(!isset($sort)) $sort=1;

	switch ($sort)
		{
		case 1:
		 $sortowanie=" ORDER BY inout.no ASC";
		 break;
		case 2:
		 $sortowanie=" ORDER BY nombers.knownas ASC";
		 break;
		case 3:
		 $sortowanie=" ORDER BY inout.date1 DESC";
		 break;
		case 4:
		 $sortowanie=" ORDER BY inout.intime DESC ";
		 break;
		case 5:
		 $sortowanie=" ORDER BY inout.outtime ASC";
		 break;
		case 6:
		 $sortowanie=" ORDER BY ipaddress.name ASC";
		 break;


		default:
		 $sortowanie=" ORDER BY inout.date1 DESC ";
		 break;
		}	

$db = new CMySQL;
if (!$db->Open()) $db->Kill();

$sql = "SELECT `inout`.`id`,
       `inout`.`ino`,
       DATE_FORMAT(`inout`.`date1`, \"%d/%m/%Y\") AS d1,
       DATE_FORMAT(`inout`.`intime`, \"%H:%i:%s\") AS t1,
       DATE_FORMAT(`inout`.`outtime`, \"%H:%i:%s\") AS t2,
       `inout`.`no`,
       `inout`.`checked`,
       `nombers`.`knownas`,
       `nombers`.`status`,
       `ipaddress`.`name`
  FROM `inout`
       LEFT JOIN `nombers`
          ON `inout`.`no` = `nombers`.`pno`
       LEFT JOIN `ipaddress`
          ON `inout`.`ipadr` = `ipaddress`.`IP`
 WHERE     (((`nombers`.`status`) = \"OK\"))
       AND `inout`.`date1` <> '$dzis'
       AND `inout`.`outtime` LIKE '00:00:00'";
$q=$sql.$sortowanie;

if ($db->Query($q)) 
  {
    while ($row=$db->Row())
    {
if($row->checked == "n") { $checked="<td class='DataTD'>NO</td>";}
else $checked="<td class='DataTDin'>YES SIR</td>";

		if (!$msgdb->Open()) $msgdb->Kill();
			$sql2ab = "SELECT `message`,`checked` FROM `inoutmsg` WHERE idinout='$row->id'";
			if (!$msgdb->Query($sql2ab)) $msgdb->Kill();
			$messagesLeft=$msgdb->Row();
                if (!isset($messagesLeft->message)) $messagesLeftmessage = 0; else $messagesLeftmessage = $messagesLeft->message;
		if($messagesLeftmessage <> "") { $wiad="$messagesLeftmessage";} else { $wiad=""; }


if($row->t2!=="00:00:00") { 
	$h4=strtotime("$row->d1 $row->t2")-strtotime("$row->d1 $row->t1"); 
	$h3=$h4/3600; 
	$h2=$h3;
	$h1=number_format($h2,2,'.',' ');
	$d2=$row->t2;

	}
	else { $h1="IN";
	       $d2="";}
     echo "
  <tr>
	 <td class='DataTD'><A HREF='timedel.php?idtime=$row->id&skrypt=$PHP_SELF' onclick='return confirm(\"Do you really want to DELETE?\")'>delete</A></td>
	 <td class='DataTD'><A HREF='totalh2.php?cln=$row->no&startd=$sd&endd=$ed'>edit</A></td>
	 <td class='DataTD'>$row->no</td>
     <td class='DataTD'>$row->knownas</td>
     <td class='DataTD'><B>$row->d1</B></td>
     <td class='DataTD'><B>$row->t1</B></td>
	 <td class='DataTD'><B>$d2</B></td>
	 <td class='DataTD'><B>$row->name</B></td>
	 <td class='DataTD'><B>$h1</B></td>
	 <td class='DataTD'>$wiad</td>
	 $checked
  </tr>
  ";
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

</center>
<BR>

</td></tr>
</table>";
include_once("./footer.php");

?>