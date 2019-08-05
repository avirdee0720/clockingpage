<HTML>
<HEAD>
<?php
include("./inc/mysql.inc.php");
include("./config.php");
include("./languages/$LANGUAGE.php");
$dataakt=date("d/m/Y H:i:s");
$msgdb = new CMySQL;
?>
<meta HTTP-EQUIV='cache-control' CONTENT='no-cache, must-revalidate'>

<LINK REL='stylesheet' HREF='style/multipads/style.css' TYPE='text/css'>

</HEAD>

<body class=PageBODY bgcolor=#FFFFFF topmargin=0 leftmargin=0 marginwidth=0 marginheight=0 text=#000000 link=#0000FF vlink=#0000FF alink=#FF0000>
<CENTER>
<?php

$dod = "$year-$month-01";
$ddo= "$year-$month-31";

echo "
<font class='FormHeaderFont'>Holliday</font>
<BR>
<table WIDTH=500 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >
 
";

$db = new CMySQL;
if (!$db->Open()) $db->Kill();
$q = "SELECT COUNT(`no`) as w, no FROM `holidays` WHERE `holidays`.`date1`>='$dod' AND `holidays`.`date1`<='$ddo' GROUP BY `holidays`.`no` ";

$razem=0;
if ($db->Query($q)) 
  {
    while ($row=$db->Row())
    {
		$db2 = new CMySQL;
		if (!$db2->Open()) $db2->Kill();
		$q2 = "SELECT * FROM `holidays` WHERE `holidays`.`date1`>='$dod' AND `holidays`.`date1`<='$ddo' AND `no`='$row->no' ORDER BY `holidays`.`date1`";
		if (!$db2->Query($q2)) $db2->Kill();

		$db3 = new CMySQL;
		if (!$db3->Open()) $db3->Kill();
		$q3 = "SELECT `firstname`,`surname`,`cat` FROM `nombers` WHERE `pno`='$row->no' ";
		if (!$db3->Query($q3)) $db3->Kill();
		$row3=$db3->Row();
		if($row3->cat == "c" ) { $colour='#FF0000'; $dupa="(CASUAL)"; }
		else  { $colour=''; $dupa="";  }
echo "<table WIDTH=500 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >
			<tr>    <td class='FieldCaptionTD' colspan='4'><FONT COLOR=$colour>
			<A HREF='hollid1.php?cln=$row->no'><B>$row->no</B></A>	
			
				
			&nbsp;$row3->firstname $row3->surname has taken <B>$row->w</B> days off $dupa</FONT></td>
			  </tr>   ";
			// counting is going to be here ! 
		
     		while ($row2=$db2->Row())
			{echo " <tr>
         <td class='DataTD'>&nbsp;&nbsp;</td>
         <td class='DataTD'><B>$row2->date1</B></td>
         <td class='DataTD'>$row2->sortof </td>
		<td class='DataTD'>$row2->hourgiven </td>
		 ";}

  echo "</TABLE>";
 if($row->sortof = "PL") $razemPL++;
 else $razemUPL++;
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
<BLOCKQUOTE><H2><B>He has taken $razemPL days paid leave , and $razemUPL unpaid.</B></H2></BLOCKQUOTE></center>
<BR>

</td></tr>
</table>";
include_once("./footer.php");

?>
