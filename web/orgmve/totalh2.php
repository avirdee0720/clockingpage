<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
uprstr($PU,90);

$dataakt=date("d/m/Y H:i:s");
$msgdb = new CMySQL;
$nr=$_GET['cln'];
list($day, $month, $year) = explode("/",$_GET['startd']);
$dod = "$year-$month-$day";
list($day1, $month1, $year1) = explode("/",$_GET['endd']);
$ddo= "$year1-$month1-$day1";
$sd=$_GET['startd'];
$ed=$_GET['endd'];
//&cln=$nr&startd=$sd&endd=$ed

function convert_datetime($datetime) {
  //example: 2008/02/07 12:19:32
  $values = explode(" ", $datetime);

  $dates = explode("/", $values[0]);
  $times = explode(":", $values[1]);

  $newtimestamp = mktime($times[0], $times[1], $times[2], $dates[1], $dates[2], $dates[0]);

  return $newtimestamp;
}

echo "
<font class='FormHeaderFont'>Employee's payrol/ClockingIN-OUT NO: $nr<BR>Dates: $dod until $ddo</font>
<BR>
<A HREF='totalh2e.php?cln=$nr&startd=$sd&endd=$ed'>EDIT</A>
<A HREF='timeadd.php?skrypt=$PHP_SELF&cln=$nr&startd=$sd&endd=$ed'>ADD DAY</A>
<table WIDTH=500 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >
  <tr>
     <td class='FieldCaptionTD'>&nbsp;</td>
     <td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=1&cln=$nr&startd=$sd&endd=$ed'><B>Day</B></A></td>
     <td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=2&cln=$nr&startd=$sd&endd=$ed'><B>IN</B></A></td>
	 <td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=3&cln=$nr&startd=$sd&endd=$ed'><B>OUT</B></A></td>
	 <td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=4&cln=$nr&startd=$sd&endd=$ed'><B>Where/Computer</B></A></td>
	 <td class='FieldCaptionTD'><B>Total</B></td>
	 <td class='FieldCaptionTD'><B>Message</B></td>
	 <td class='FieldCaptionTD'><B>Checked</B></td>
	</tr>	
";
if(!isset($sort)) $sort=1;

	switch ($sort)
		{
		case 1:
		 $sortowanie=" ORDER BY `inout`.`date1` DESC, `inout`.`intime` DESC";
		 break;
		case 2:
		 $sortowanie=" ORDER BY `inout`.`intime` ASC ";
		 break;
		case 3:
		 $sortowanie=" ORDER BY `inout`.`outtime` ASC";
		 break;
		case 4:
		 $sortowanie=" ORDER BY `ipaddress`.`name` ASC";
		 break;

		default:
		 $sortowanie=" ORDER BY `inout`.`date1` DESC, `inout`.`intime` ASC ";
		 break;
		}

$db = new CMySQL;
if (!$db->Open()) $db->Kill();

$sql = "SELECT `inout`.`id`, `inout`.`ino`, `inout`.`date1`, DATE_FORMAT(`inout`.`date1`, \"%d/%m/%Y\") as d1, 
DATE_FORMAT(`inout`.`intime`, \"%H:%i:%s\") as t1, DATE_FORMAT(`inout`.`outtime`, \"%H:%i:%s\") as t2, 
`inout`.`no`, `inout`.`checked`, `nombers`.`knownas`, `nombers`.`firstname`, `nombers`.`surname`, `nombers`.`status`, 
`ipaddress`.`name` 
FROM `inout` 
LEFT JOIN `nombers` ON `inout`.`no` = `nombers`.`pno` 
LEFT JOIN `ipaddress` ON `inout`.`ipadr` = `ipaddress`.`IP` 
WHERE  `inout`.`no` LIKE '$nr' AND `inout`.`date1`>='$dod' AND `inout`.`date1`<='$ddo' ";

$q=$sql.$sortowanie;
$totalh = 0;
$Sunday = 0;
$Saturday = 0;
$ActualRow = 0;
$DateOfPrevLoop = 0;
$RowsStyle = "";
$DT1 = 0;
if ($db->Query($q)) 
  {
    while ($row=$db->Row())
    {
       
		$DT1 = strtotime("$row->date1");
		if($DT1 <> $DateOfPrevLoop) { 
			if($RowsStyle == "DataTDGrey")
			{ $RowsStyle="DataTD"; 
			   } else { $RowsStyle="DataTDGrey"; }
			} else { $RowsStyle=$RowsStyle; }

		if($row->checked == "n") { $checked="<td class='$RowsStyle'>NO</td>";}
		else $checked="<td class='DataTDin'>YES</td>";

		if (!$msgdb->Open()) $msgdb->Kill();
			$sql2ab = "SELECT `message` FROM `inoutmsg` WHERE `idinout`='$row->id'";
			if (!$msgdb->Query($sql2ab)) $msgdb->Kill();
			$messagesLeft=$msgdb->Row();
		if(isset($messagesLeft->message) && $messagesLeft->message <> "") { $wiad="$messagesLeft->message";} else { $wiad=""; }

	if($row->t2!=="00:00:00") {
                $h4=convert_datetime("$row->d1 $row->t2")-convert_datetime("$row->d1 $row->t1");
		$h3=$h4/3600; 
		$h2=$h3;
		$h1=number_format($h2,2,'.',' ');
		$d2="<td class='$RowsStyle'><B>$row->t2</B></td>";
		$totalh=$totalh+$h3;
		if(date("w", $DT1)==0) $Sunday=$Sunday+$h2;
		if(date("w", $DT1)==6) $Saturday=$Saturday+$h2;
		if(date("w", $DT1)==0) $DataDay="<td class='niedziela'><B>$row->d1</B></td>";
		elseif(date("w", $DT1)==6) $DataDay="<td class='sobota'><B>$row->d1</B></td>";
		else $DataDay="<td class='$RowsStyle'><B>$row->d1</B></td>";
	
        if(!isset($who)) {
            $PN=$row->no;
            $fname=$row->firstname;
            $sname=$row->surname;
            $who=$row->knownas;
        }
	} else { 
            $h1="IN";
	    $d2="<td class='DataTDout'><B></B></td>";
	    $DataDay="<td class='$RowsStyle'><B>$row->d1</B></td>";
        }
     echo "
  <tr>
	 <td class='$RowsStyle'><A HREF='timeed.php?idtime=$row->id&skrypt=$PHP_SELF?cln=$nr&startd=$sd&endd=$ed'>edit</A></td>
     $DataDay
     <td class='$RowsStyle'><B>$row->t1</B></td>
	 $d2
	 <td class='$RowsStyle'><B>$row->name</B></td>
	 <td class='$RowsStyle'><B>$h1</B></td>
	 <td class='$RowsStyle'>$wiad</td>
	 $checked   ";
	$DateOfPrevLoop = strtotime("$row->date1");
	$ActualRow++;
  } 
} else {
echo " 
  <tr>
    <td class='DataTD'></td>
    <td class='DataTD' colspan='5'>SQL Error:".mysql_error()."</td>
  </tr>";
 $db->Kill();
}

$totalhDisp=number_format($totalh,2,'.',' ');
$sun=number_format($Sunday,2,'.',' ');
$sat=number_format($Saturday,2,'.',' ');

if(!isset($who)) {
    $PN = 0;
    $fname = "";
    $sname = "";
    $who = "";
}            

echo "
</table>
<BLOCKQUOTE><H2><B>Employee $fname $sname, TimeTable name: $who, <BR>with payroll no $PN
<BR>total hours in this period: <FONT COLOR='#FF0000'>$totalhDisp</FONT></B></H2>
On saturdays $sat, and sundays $sun.</BLOCKQUOTE></center>
<BR>

</td></tr>
</table>";
include_once("./footer.php");

?>