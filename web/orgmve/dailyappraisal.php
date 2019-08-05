<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$db2 = new CMySQL;

$title="Daily appraisal";
$appid = array();

if (!isset($_POST['state'])) $state = 0; else $state = $_POST['state'];
if (!isset($_POST['col1'])) $col1 = array(); else $col1 = $_POST['col1'];
if (!isset($_POST['col2'])) $col2 = array(); else $col2 = $_POST['col2'];
if (!isset($_GET['cln'])) $cln = $_POST['cln']; else $cln = $_GET['cln'];

if($state==0)
{

if (!$db->Open()) $db->Kill();

$sql1 ="SELECT DISTINCT `pno`, `firstname`, `surname`, `knownas`, DATE_FORMAT(`nombers`.`started`, \"%d/%m/%Y\") as started, `catname`
 FROM `nombers` inner join `emplcat` ON nombers.cat = emplcat.catozn WHERE pno = $cln";

if (!$db->Query($sql1)) { $db->Kill(); $db->Error(); exit; }
	$row=$db->Row();
    $firstname=$row->firstname; 
    $knownas=$row->knownas; 
	$surname=$row->surname;
	$jobtitle=$row->catname;
	$started=$row->started;

if ($started == "00/00/0000") $started="";
$pictcode = "cln=$cln";

//read user knowledge
if (!$db->Open()) $db->Kill();

$sql2="SELECT `knowledgelist`.`name`,
       `nombersknowledge`.`type`,
       `nombersknowledge`.`knowledgeid`,
       `nombersknowledgetext`.`value`
  FROM `nombersknowledge`
       LEFT JOIN `knowledgelist`
          ON `nombersknowledge`.`knowledgeid` = `knowledgelist`.`id`
       LEFT JOIN `nombersknowledgetext`
          ON `nombersknowledge`.`id` =
                `nombersknowledgetext`.`userknowledgeid`
 WHERE `nombersknowledge`.`no` = '$cln' AND `nombersknowledge`.`value` = 1";
 
if (!$db->Query($sql2)) { $db->Kill(); $db->Error(); exit; }

//fill the arrays from `appraisal` table
if (!$db2->Open()) $db2->Kill();

$sql3="SELECT `appraisalID`, `appcolumn1`, `appcolumn2` FROM `appraisal` WHERE `pno` = $cln ORDER BY `appraisalID` ASC";

if (!$db2->Query($sql3)) { $db2->Kill(); $db2->Error(); exit; }
$line=0;
while ($row2=$db2->Row()) {
	if ($row2->appcolumn1 != "") { $col1[$line] = $row2->appcolumn1; $appid[$line] = $row2->appraisalID; }
	if ($row2->appcolumn2 != "") { $col2[$line] = $row2->appcolumn2; $appid[$line] = $row2->appraisalID; }
	
    $line++;			
} //end while

//init the rest of the arrays
for ($i = 0; $i < 30; $i++) {
    if (!isset($col1[$i])) $col1[$i] = "";
	if (!isset($col2[$i])) $col2[$i] = "";
	if (!isset($appid[$i])) $appid[$i] = 0;
}

echo "
<html xmlns=\"http://www.w3.org/TR/REC-html40\">
<head>
<meta http-equiv=Content-Type content=\"text/html; charset=windows-1250\">
<title>NAME</title>
<style type=\"text/css\">
table.sample {
	border-width: 1px 0px 0px 0px;
	border-spacing: 0px;
	border-style: solid solid solid solid;
	border-color: black black black black;
	border-collapse: separate;
	background-color: white;
}
table.sample th {
	border-width: 0px 0px 0px 0px;
	padding: 0px 0px 0px 0px;
	border-style: solid solid solid solid;
	border-color: black black black black;
	background-color: white;
	-moz-border-radius: 0px 0px 0px 0px;
}
table.sample td {
	border-width: 0px 0px 0px 0px;
	padding: 0px 0px 0px 0px;
	border-style: solid solid solid solid;
	border-color: black black black black;
	background-color: white;
	-moz-border-radius: 0px 0px 0px 0px;
}
</style>
</head>
<body bgcolor=\"#FFFFFF\" lang=HU>
<div class=Section1>

<table width=\"90%\" border=0 cellpadding=0 cellspacing=0>
    <tr>
      <td height=\"30\" valign=bottom><b><span style=\"font-size:11.0pt;font-family:Tahoma\">NAME</span></b></td>
      <td valign=bottom>$knownas $surname</td>
      <td valign=bottom><b><span style=\"font-size:11.0pt;font-family:Tahoma\">START
      DATE</span></b></td>
      <td valign=bottom><b><span style=\"font-size:11.0pt;font-family:Tahoma\">$started</span></b></td>
      <td width=200 rowspan=3 valign=top><div align=\"left\"><img src=\"image1.php?$pictcode\" height=\"150\" ></div></td>
    </tr>
    
    <tr valign=\"bottom\">
      <td width=115 height=\"32\"><p><b><span lang=EN-US style='font-size:11.0pt;font-family:Tahoma'>JOB
          TITLE</span></b></p></td>
      <td width=480 colspan=3>$jobtitle</td>
    </tr>
    
    <tr valign=\"bottom\">
      <td><b><span style=\"font-size:11.0pt;font-family:Tahoma\">SPECIALISMS</span></b></td>
    </tr>
  </table>
</div>

<center>
<form action='$PHP_SELF' method='POST' name='appraisalform'>
<table border='0' cellpadding='3' cellspacing='0' class='FormTABLE'>
<tr><td colspan=\"2\"><b><span style=\"font-size:11.0pt;font-family:Tahoma\">";

$rows=$db->Rows();
$knowledgenum=0;
while ($row=$db->Row()) {
	$knowledgenum++;
	if ($row->type == 'C') {
		if ($row->knowledgeid == '20') $knowledgetext = "</span></b></td></tr><tr><td colspan=\"2\"><b><span style=\"font-size:11.0pt;font-family:Tahoma\">Other Spec.: ".strtoupper($row->value);
		else $knowledgetext = strtoupper($row->name);	
	}
	else {
		if ($row->knowledgeid == '20') $knowledgetext = "</span></b></td></tr><tr><td colspan=\"2\"><b><span style=\"font-size:11.0pt;font-family:Tahoma\">Other Spec.: ".strtolower($row->value);
		else $knowledgetext = strtolower($row->name);	
	}
	echo "$knowledgetext";
	if ($knowledgenum != $rows) echo ", ";	
} //end while
echo "</span></b></td></tr>";

for($line=0; $line<30; $line++) { 
echo "<tr>
		<td><input class='Input' maxlength='255' size='25' name='col1[$line]' value='$col1[$line]'></td>
		<td><input class='Input' maxlength='255' size='150' name='col2[$line]' value='$col2[$line]'></td>
		<td><CENTER><A HREF='del_app.php?cln=$cln&appid=$appid[$line]'><IMG SRC='images/down.gif' BORDER='0' title='Delete appraisal'></A></CENTER></td>
	  </tr>";
}

echo "
	<tr>
        <td align='center' colspan='2'>
		<input name='state' type='hidden' value='1'>
		<input name='cln' type='hidden' value='$cln'>
		<input class='Button' name='Submit' type='submit' value='Save'>
	</tr>
</table>
</form>
</center>

</body>
</html>";

} // if($state==0)

elseif($state==1) {
	//delete previous appraisal records from `appraisal` table
	if (!$db->Open()) $db->Kill();
    	$delsql="DELETE FROM `appraisal` WHERE `pno` = $cln";
	$db->Query($delsql);

	//insert new appraisal records into `appraisal` table
	if (!$db->Open())$db->Kill();
	for ($i = 0; $i < 30; $i++) {
		if($col1[$i] != "" || $col2[$i] != ""){
			$query1[$i] =("INSERT INTO `appraisal` (`appraisalID` , `pno`, `appcolumn1`, `appcolumn2`) VALUES ('' , '$cln', '$col1[$i]', '$col2[$i]')");
			$result1[$i] = mysql_query($query1[$i]);
		}
	}
	echo "<script language='javascript'>window.location=\"dailyappraisal.php?cln=$cln\"</script>";

} //$state==1

include_once("./footer.php");

?>