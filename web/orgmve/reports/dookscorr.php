<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

include("./inc/mysql.inc.php");

$db = new CMySQL;

if(!isset($_POST['state'])) $state = 0; else $state = $_POST['state'];
if(!isset($_POST['startd'])) $startd = 0; else $startd = $_POST['startd'];
if(!isset($_POST['endd'])) $endd = 0; else $endd = $_POST['endd'];
if(!isset($_POST['clno'])) $clno = 0; else $clno = $_POST['clno'];

if(!isset($_POST['newid'])) $newid = 0; else $newid = $_POST['newid'];
if(!isset($_POST['newin'])) $newin = 0; else $newin = $_POST['newin'];
if(!isset($_POST['newout'])) $newout = 0; else $newout = $_POST['newout'];
if(!isset($_POST['newtimestamp'])) $newtimestamp = 0; else $newtimestamp = $_POST['newtimestamp'];

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
    <td><b>Date from: </b><input type="text" name="startd" id="datepicker1" maxlength="12" size="12">
    <img src="images/cal.gif" onclick="javascript:NewCssCal ('datepicker1','ddMMyyyy','arrow')" style="cursor:pointer"></td>
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

<br>
<br>
<table class='info' width="50%" border="0" cellpadding="12">
<form action='<?php echo $_SERVER['PHP_SELF']; ?>' method='post' name='updateselect'>
    <input type='hidden' name='state' value='2'>
    <tr>
    <td><b>ID: </b><input type="text" name="newid" maxlength="6" size="6"></td>
    <td><b>Intime: </b><input type="text" name="newin" maxlength="8" size="8"></td>
    <td><b>Outtime: </b><input type="text" name="newout" maxlength="8" size="8"></td>
    <td><b>Timestamp: </b><input type="text" name="newtimestamp" id="datepicker3" maxlength="20" size="20">
    <img src="images/cal.gif" onclick="javascript:NewCssCal ('datepicker3','ddMMyyyy','arrow',true,'24',true)" style="cursor:pointer"/></td>
    </tr>
    <tr>
    <td colspan="4"><input class='Button' name='ok' type='submit' value='OK!'>
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
    $query = "SELECT *, SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(`outtime`, `intime`))) AS timediff
FROM `inout`
WHERE `no` = '$clno'
  AND STR_TO_DATE('$startd', '%d/%m/%Y') <= `date1`
  AND `date1` <= STR_TO_DATE('$endd', '%d/%m/%Y')
ORDER BY `id` ASC";
    
    $db->Query($query);
    $rnum=$db->Rows();
    
    if ($rnum == 0)
        echo "<font class='infoHeaderFont'><br>No records found for this period!</font>";
    else {
        
        echo "<br><br><table class='info' width=\"25%\">
              <tr>
              <td class='FieldCaptionTD'><B>id</B></td>
              <td class='FieldCaptionTD'><B>date1</B></td>
              <td class='FieldCaptionTD'><B>intime</B></td>
              <td class='FieldCaptionTD'><B>outtime</B></td>
              <td class='FieldCaptionTD'><B>timediff</B></td>
              <td class='FieldCaptionTD'><B>no</B></td>
              <td class='FieldCaptionTD'><B>cur_timestamp</B></td>
              <tr>";

        while ($row=$db->Row()) {
            
            echo "<tr>";
            echo "<td class='DataTDGrey'><B>$row->id</B></td>";
            echo "<td class='DataTDGrey'><B>$row->date1</B></td>";
            echo "<td class='DataTDGrey'><B>$row->intime</B></td>";
            echo "<td class='DataTDGrey'><B>$row->outtime</B></td>";
            echo "<td class='DataTDGrey'><B>$row->timediff</B></td>";            
            echo "<td class='DataTDGrey'><B>$row->no</B></td>";
            echo "<td class='DataTDGrey'><B>$row->cur_timestamp</B></td>";
            echo "</tr>";
            
        }
        echo "</table>";
        echo "<br><br>";

    }
  
}

if($state == 2) {
    
    if ( ($newid == 0) or ($newin == 0) or ($newout == 0) or ($newtimestamp == 0) )
        echo "<font class='infoHeaderFont'><br>Missing parameter!</font>";
    else {    
        if (!$db->Open()) $db->Kill();    
        $query = "UPDATE `inout`
    SET `inout`.`intime` = '$newin', `inout`.`outtime` = '$newout', `inout`.`cur_timestamp` = '$newtimestamp'
    WHERE `inout`.`id` = '$newid'";
        $db->Query($query);

        echo "<font class='infoHeaderFont'><br>Update complete!</font>";
    
    }
    
}


?>
    
</CENTER>
</BODY>
</HTML>



