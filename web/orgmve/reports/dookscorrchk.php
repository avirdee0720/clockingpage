<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

include("./inc/mysql.inc.php");

$db = new CMySQL;

if(!isset($_POST['state'])) $state = 0; else $state = $_POST['state'];
if(!isset($_POST['startd'])) $startd = 0; else $startd = $_POST['startd'];
if(!isset($_POST['endd'])) $endd = 0; else $endd = $_POST['endd'];
if(!isset($_POST['clno'])) $clno = 0; else $clno = $_POST['clno'];

?>
    
<HEAD>
<meta HTTP-EQUIV='cache-control' CONTENT='no-cache, must-revalidate'>
<title>Attendance Information</title>
<LINK REL='stylesheet' HREF='./style/style.css' TYPE='text/css'>
<script language="javascript" type="text/javascript" src="./inc/datetimepicker_css.js">
</script>
</HEAD>


<body class=info>
<CENTER>
<br>
<font class='infoHeaderFont'>Attendance information:<br>
<?php

if (($startd != 0) and ($endd != 0) and ($clno != 0))
    echo "For Clno: $clno From: $startd to: $endd";

?>
</font>
<br>
<br>

<table class='info' width="50%" border="0" cellpadding="12">
<form action='<?php echo $_SERVER['PHP_SELF']; ?>' method='post' name='periodselect'>
    <input type='hidden' name='state' value='1'>
    <tr>
    <td><b>Date from: </b><input type="text" name="startd" id="datepicker" maxlength="12" size="12">
    <img src="images/cal.gif" onclick="javascript:NewCssCal ('datepicker','ddMMyyyy','arrow')" style="cursor:pointer"></td>
    <td><b>Date to: </b><input type="text" name="endd" id="datepicker2" maxlength="12" size="12">
    <img src="images/cal.gif" onclick="javascript:NewCssCal ('datepicker2','ddMMyyyy','arrow')" style="cursor:pointer"></td>
    <td><b>Clno: </b><input type="text" name="clno"></td>
    </tr>    
    <tr>
    <td colspan="3"><input class='Button' name='ok' type='submit' value='OK!'>
    </td>
    </tr>
</form>
</table>    
        
<?php

if($state == 0) {
    
    echo "<font class='infoHeaderFont'><br>Select the period and then click OK!</font>";

}

if($state == 1) {
    
    if (!$db->Open()) $db->Kill();    
    $query = "SELECT `date1`,
       SUM(`sumsec`) AS sec,
       SEC_TO_TIME(SUM(`sumsec`)) AS time,
       CASE
          WHEN SUM(`sumsec`) < 15300 THEN 0
          WHEN 15300 < SUM(`sumsec`) AND SUM(`sumsec`) < 30600 THEN 0.5
          WHEN 30600 < SUM(`sumsec`) THEN 1
       END
          AS att
  FROM (SELECT `id`,
               `date1`,
               TIME_TO_SEC(TIMEDIFF(`outtime`, `intime`)) AS sumsec
          FROM `inout`
         WHERE     `no` = '$clno'
               AND STR_TO_DATE('$startd','%d/%m/%Y') <= `date1`
               AND `date1` <= STR_TO_DATE('$endd','%d/%m/%Y')) AS t
GROUP BY `date1`
ORDER BY `date1` ASC";

    $db->Query($query);
    $rnum=$db->Rows();
    
    if ($rnum == 0)
        echo "<font class='infoHeaderFont'><br>No records found for this period!</font>";
    else {
        
        echo "<br><br><table class='info' width=\"25%\">
              <tr>
              <td class='FieldCaptionTD'><B>Day</B></td>
              <td class='FieldCaptionTD'><B>Hours</B></td>
              <td class='FieldCaptionTD'><B>Attendance</B></td>
              <tr>";
        
        $sumdays = 0;
        $sumtime = 0;
        while ($row=$db->Row()) {
            
            $sumdays = $sumdays + $row->att;          
            $sumtime = $sumtime + $row->sec;
            echo "<tr>";
            echo "<td class='DataTDGrey'><B>$row->date1</B></td>";
            echo "<td class='DataTDGrey'><B>$row->time</B></td>";
            echo "<td class='DataTDGrey'><B>$row->att</B></td>";
            echo "</tr>";
            
        }
        echo "</table>";
        
        $h = intval( ($sumtime/3600) );
        $m = intval( ($sumtime-$h*3600) / 60 );
        $s = $sumtime - ($h*3600) - ($m*60);
              
        echo "<font class='infoHeaderFont'><br>Summary: $h:$m:$s hours and $sumdays days attendance.</font>";

    }
  
}


?>
    
</CENTER>
</BODY>
</HTML>



