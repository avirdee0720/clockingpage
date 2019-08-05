<?php
include("./header.php");
//include("./inc/mysql.inc.php");
//include("./config.php");
//include("./languages/$LANGUAGE.php");
$dataakt=date("d/m/Y H:i:s");
$msgdb = new CMySQL;

echo "
<font class='FormHeaderFont'>$dataakt</font>

<table WIDTH=500 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >

  <tr>
	 <td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=1'>NO</A></td>
     <td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=2'>Known_as</A></td>
     <td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=3'><B>Day</B></A></td>
     <td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=4'><B>IN</B></A></td>
	 <td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=4'><B>OUT</B></A></td>
	 <td class='FieldCaptionTD'><A HREF='$PHP_SELF?sort=6'><B>Where/Computer</B></A></td>
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

$sql = "SELECT inout.id, inout.ino, DATE_FORMAT(inout.date1, \"%d/%m/%Y\") as d1, DATE_FORMAT(inout.intime, \"%H:%i:%s\") as t1, DATE_FORMAT(inout.outtime, \"%H:%i:%s\") as t2, inout.no, inout.checked, nombers.knownas, nombers.status, ipaddress.name FROM inout LEFT JOIN nombers ON inout.no = nombers.pno LEFT JOIN ipaddress ON inout.ipadr = ipaddress.IP WHERE (((nombers.status)=\"OK\"))  ";
$q=$sql.$sortowanie;

if ($db->Query($q)) 
  {
    while ($row=$db->Row())
    {
if($row->checked == "n") { $checked="N";}
else $checked="Y";

		if (!$msgdb->Open()) $msgdb->Kill();
			$sql2ab = "SELECT message FROM `inoutmsg` WHERE idinout='$row->id'";
			if (!$msgdb->Query($sql2ab)) $msgdb->Kill();
			$messagesLeft=$msgdb->Row();
		if($messagesLeft->message <> "") { $wiad="$messagesLeft->message";} else { $wiad=""; }


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
	 <td class='DataTD'>$row->no</td>
     <td class='DataTD'>$row->knownas</td>
     <td class='DataTD'><B>$row->d1</B></td>
     <td class='DataTD'><B>$row->t1</B></td>
	 <td class='DataTD'><B>$d2</B></td>
	 <td class='DataTD'><B>$row->name</B></td>
	 <td class='DataTD'><B>$h1</B></td>
	 <td class='DataTD'>$wiad</td>
	 <td class='DataTD'>$checked</td>
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