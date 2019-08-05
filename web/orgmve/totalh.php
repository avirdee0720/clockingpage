<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$dataakt=date("d/m/Y H:i:s");
$msgdb = new CMySQL;

$startd = $_GET['startd'];
$endd = $_GET['endd'];

list($day, $month, $year) = explode("/",$startd);
$dod = "$year-$month-$day";
list($day1, $month1, $year1) = explode("/",$endd);
$ddo= "$year1-$month1-$day1";

function convert_datetime($datetime) {
  //example: 2008/02/07 12:19:32
  $values = explode(" ", $datetime);

  $dates = explode("/", $values[0]);
  $times = explode(":", $values[1]);

  $newtimestamp = mktime($times[0], $times[1], $times[2], $dates[1], $dates[2], $dates[0]);

  return $newtimestamp;
}

echo "
<font class='FormHeaderFont'>$dataakt</font>

<table WIDTH=500 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >
  <tr>
	 <td class='FieldCaptionTD'><A HREF='$PHP_SELF?startd=$startd&endd=$endd&sort=1'>NO</A></td>
     <td class='FieldCaptionTD'><A HREF='$PHP_SELF?startd=$startd&endd=$endd&sort=2'>Known_as</A></td>
     <td class='FieldCaptionTD'><A HREF='$PHP_SELF?startd=$startd&endd=$endd&sort=3'><B>Day</B></A></td>
     <td class='FieldCaptionTD'><A HREF='$PHP_SELF?startd=$startd&endd=$endd&sort=4'><B>IN</B></A></td>
	 <td class='FieldCaptionTD'><A HREF='$PHP_SELF?startd=$startd&endd=$endd&sort=5'><B>OUT</B></A></td>
	 <td class='FieldCaptionTD'><A HREF='$PHP_SELF?startd=$startd&endd=$endd&sort=6'><B>Where/Computer</B></A></td>
	 <td class='FieldCaptionTD'><B>Total</B></td>
	 <td class='FieldCaptionTD'><B>Message</B></td>
	 	 <td class='FieldCaptionTD'><B>Checked</B></td>

   </tr>	
";
if(!isset($sort)) $sort=1;

	switch ($sort)
		{
		case 1:
		 $sortowanie=" ORDER BY `inout`.`no` ASC";
		 break;
		case 2:
		 $sortowanie=" ORDER BY `nombers`.`knownas` ASC";
		 break;
		case 3:
		 $sortowanie=" ORDER BY `inout`.`date1` DESC";
		 break;
		case 4:
		 $sortowanie=" ORDER BY `inout`.`intime` DESC ";
		 break;
		case 5:
		 $sortowanie=" ORDER BY `inout`.`outtime` ASC";
		 break;
		case 6:
		 $sortowanie=" ORDER BY `ipaddress`.`name` ASC";
		 break;


		default:
		 $sortowanie=" ORDER BY `inout`.`date1` DESC ";
		 break;
		}	


if (!$db->Open()) $db->Kill();

$sql = "SELECT `inout`.`id`, `inout`.`ino`, DATE_FORMAT(`inout`.`date1`, \"%d/%m/%Y\") as d1, DATE_FORMAT(`inout`.`intime`, \"%H:%i:%s\") as t1, DATE_FORMAT(`inout`.`outtime`, \"%H:%i:%s\") as t2, `inout`.`no`, `inout`.`checked`, `nombers`.`knownas`, `nombers`.`status`, `ipaddress`.`name` FROM `inout` LEFT JOIN `nombers` ON `inout`.`no` = `nombers`.`pno` LEFT JOIN `ipaddress` ON `inout`.`ipadr` = `ipaddress`.`IP` WHERE (((`nombers`.`status`)=\"OK\")) AND  `inout`.`date1`>='$dod'  AND `inout`.`date1`<='$ddo'";
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
		if(isset($messagesLeft->message) && $messagesLeft->message <> "") { $wiad="$messagesLeft->message";} else { $wiad=""; }


if($row->t2!=="00:00:00") { 
	$h4=convert_datetime("$row->d1 $row->t2")-convert_datetime("$row->d1 $row->t1");
	$h3=$h4/3600; 
	$h2=$h3;
	$h1=number_format($h2,2,'.',' ');
	$d2=$row->t2;

	}
	else { $h1="IN";
	       $d2="";}
     echo "
  <tr>
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