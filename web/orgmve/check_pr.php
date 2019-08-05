<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$dataakt=date("dmY-Hi");

echo "
<table border='0' cellpadding='0' cellspacing='0'>
<tr>
    <td colspan='2' >Clocking NO</td>
    <td >Problem </td></tr>
";
list($day1, $month1, $year1) = explode("/",$FirstOfLastMonth);
$ddo= "$year1-$month1-$day1";

if (!$db->Open()) $db->Kill();
$sql = "SELECT nombers.ID, nombers.pno, nombers.knownas, nombers.firstname, nombers.surname, nombers.status, nombers.regdays, nombers.cat, nombers.started, nombers.left1 , nombers.cat, nombers.regdays FROM nombers  ORDER BY nombers.pno ";
$q=$sql;

  if ($db->Query($q)) 
  {
    while ($row=$db->Row())
    {
	$edit="<tr><td ><A HREF='ed_os_k.php?lp=$row->pno'> Edit </A>&nbsp;&nbsp;</td>";
	$edit2="<tr><td ><A HREF='ed_os.php?lp=$row->pno'> Edit </A>&nbsp;&nbsp;</td>";
	$leftlongtimeago="";
	if ($row->left1<>"" || $row->left1<>"0000-00-00") {
		if (strtotime("$row->left1") < strtotime("$ddo")) {$leftlongtimeago="YES";} else {$leftlongtimeago="NO";}
	}
	if($row->cat == "" )  echo "$edit<td ><B>$row->pno</B>&nbsp;&nbsp;</td><td >Category is Missing!</td></tr>";
	if($row->knownas == "" )  echo "$edit2<td ><B>$row->pno</B>&nbsp;&nbsp;</td><td >knownas Missing!</td></tr>";
	if($row->firstname == "" )  echo "$edit2<td ><B>$row->pno</B>&nbsp;&nbsp;</td><td >firstname Missing!</td></tr>";
	if($row->surname == "" )  echo "$edit2<td ><B>$row->pno</B>&nbsp;&nbsp;</td><td >surname Missing!</td></tr>";
	if($row->status == "" )  echo "$edit<td ><B>$row->pno</B>&nbsp;&nbsp;</td><td >status Missing!</td></tr>";

	//if($row->regdays == "" )  {
	//	if(($leftlongtimeago=="" ||  $leftlongtimeago=="YES" ) {echo "$edit<td ><B>$row->pno</B>&nbsp;&nbsp;</td><td >Regular days Missing!</td></tr>";}
	//}

	if($row->started == "" && $row->status == "OK" )  echo "$edit<td ><B>$row->pno</B>&nbsp;&nbsp;</td><td >started date is empty but status = OK</td></tr>";
	if($row->left1 == "" && $row->left1 <> "0000-00-00" && $row->status == "LEAVER")  echo "$edit<td ><B>$row->pno</B>&nbsp;&nbsp;</td><td >left date is empty but status = LEAVER </td></tr>";
	if(($row->started <> "" && $row->started <> "0000-00-00") && ($row->left1 <> "" && $row->left1 <> "0000-00-00" ) && $row->status == "OK" )  echo "$edit<td ><B>$row->pno</B></td><td >started and left dates are filled but status = OK employee should be a LEAVER</td></tr>";
	if($row->regdays == "" || $row->regdays == 0 && $row->cat <> "c" && $leftlongtimeago<>"YES")  echo "$edit<td ><B>$row->pno</B></td><td >regdays Missing!</td></tr>";
	} 
} else {
echo " 
  <tr>
    <td ></td>
    <td  colspan='3'>No errors</td>
  </tr>";
 $db->Kill();
}
echo "
</table>
";
include_once("./footer.php");
?>
