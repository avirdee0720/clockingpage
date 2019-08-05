<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;

$title="Daily appraisal";
$dataakt=date("d/m/Y H:i:s");
$cln = $_GET['cln'];
$edit=$_GET["edit"];
$ID=$_GET["ID"];

if ($cln != "" || $ID !="") {
if (!$db->Open()) $db->Kill();
if ($edit != "1") {
$sql1 ="SELECT DISTINCT `pno`, `firstname`, `surname`, `knownas`, DATE_FORMAT(`nombers`.`started`, \"%d/%m/%Y\") as started, `catname`
 FROM `nombers` inner join `emplcat` ON nombers.cat = emplcat.catozn WHERE pno = $cln";
 $sql2="SELECT `speciality` FROM `staffdetails`  WHERE no = $cln";
 $pictcode = "cln=$cln";
}
else {
$sql1 ="SELECT DISTINCT `pno`, `firstname`, `surname`, `knownas`, DATE_FORMAT(`temp_nombers`.`started`, \"%d/%m/%Y\") as started, `catname`
 FROM `temp_nombers` inner join `emplcat` ON temp_nombers.cat = emplcat.catozn WHERE temp_nombers.ID = $ID";

$sql2 ="SELECT DISTINCT `speciality`
 FROM `temp_nombers` inner join `emplcat` ON temp_nombers.cat = emplcat.catozn WHERE temp_nombers.ID = $ID";
 
 $pictcode = "edit=1&ID=$ID";
}
 
if (!$db->Query($sql1)) { $db->Kill(); $db->Error(); exit; } 
 
 $row1=$db->Row();
 
    $firstname=$row1->firstname; 
    $knownas=$row1->knownas; 
	  $surname=$row1->surname;
	  $jobtitle=$row1->catname;
	  $started=$row1->started;


 
if (!$db->Query($sql2)) { $db->Kill(); $db->Error(); exit; } 
 
 $row1=$db->Row();
 
    $specialisms=$row1->speciality; 
	    
 if ($started == "00/00/0000") $started="";
 
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
      <td width=133 rowspan=3 valign=top><div align=\"left\"><img src=\"image1.php?$pictcode\" height=\"100\" ></div></td>
    </tr>
    
    <tr valign=\"bottom\">
      <td width=115 height=\"32\"><p><b><span lang=EN-US style='font-size:11.0pt;font-family:Tahoma'>JOB
          TITLE</span></b></p></td>
      <td width=480 colspan=3>$jobtitle</td>
    </tr>
    
    <tr valign=\"bottom\">
      <td><b><span style=\"font-size:11.0pt;font-family:Tahoma\">SPECIALISMS</span></b></td>
      <td colspan=3>$specialisms</td>
    </tr>
  </table>

  
  <p>&nbsp;</p>
 <table width=\"100%\" border=1 cellpadding=0 cellspacing=0 bordercolor=\"#000000\" class=\"sample\">
 ";
 for ($i=0;$i<94;$i++) {
 echo "   
     <tr style='mso-yfti-irow:1;mso-yfti-lastrow:yes;height:15.9pt'>
  <td width=172 valign=top style='width:80pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;mso-border-bottom-themecolor:text1;
  border-right:solid black 1.0pt;mso-border-right-themecolor:text1;mso-border-top-alt:
  solid black .5pt;mso-border-top-themecolor:text1;mso-border-top-alt:solid black .5pt;
  mso-border-top-themecolor:text1;mso-border-bottom-alt:solid black .5pt;
  mso-border-bottom-themecolor:text1;mso-border-right-alt:solid black .5pt;
  mso-border-right-themecolor:text1;padding:0cm 5.4pt 0cm 5.4pt;height:15.9pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'><o:p>&nbsp;</o:p></p>
  </td>
  <td width=1071 valign=top style='width:802.95pt;border:none;border-bottom:
  solid black 1.0pt;mso-border-bottom-themecolor:text1;mso-border-top-alt:solid black .5pt;
  mso-border-top-themecolor:text1;mso-border-left-alt:solid black .5pt;
  mso-border-left-themecolor:text1;mso-border-top-alt:solid black .5pt;
  mso-border-top-themecolor:text1;mso-border-left-alt:solid black .5pt;
  mso-border-left-themecolor:text1;mso-border-bottom-alt:solid black .5pt;
  mso-border-bottom-themecolor:text1;padding:0cm 5.4pt 0cm 5.4pt;height:15.9pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'><o:p>&nbsp;</o:p></p>
  </td>
 </tr>
 ";
 }
 echo "
  </table>
</div>
</body>
</html>


 ";

 
 
}

else {
echo "There is no clocking number!";

}

include_once("./footer.php");

?>