<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

include("../inc/mysql.inc.php");

$db = new CMySQL;

if(!isset($_POST['state'])) $state = 0; else $state = $_POST['state'];

?>
    
<HEAD>
<meta HTTP-EQUIV='cache-control' CONTENT='no-cache, must-revalidate'>
<title>Dooks Attendance Information</title>
<LINK REL='stylesheet' HREF='style.css' TYPE='text/css'>
<script language="javascript" type="text/javascript" src="datetimepickerdooks_css.js">
</script>
</HEAD>


<body class=info>
<CENTER>
<br>
<font class='infoHeaderFont'>Dooks (cl.no. 2574) attendance information<br><br>
0.5 day attendance if: 4.25 hours < working hours < 8.5 hours<br>
1 day attendance if: 8.5 hours < working hours<br></font>
<br>

<table class='info' width="50%" border="0" cellpadding="12">
<form action='<?php echo $_SERVER['PHP_SELF']; ?>' method='post' name='periodselect'>
    <input type='hidden' name='state' value='1'>
    <tr>
    <td colspan="2"><input class='Button' name='ok' type='submit' value='Run report!'>
    </td>
    </tr>
</form>
</table>    
        
<?php

if($state == 0) {
    
    echo "<font class='infoHeaderFont'><br>Click on the button to run Dook's report!</font>";

}

if($state == 1) {
    
    //query week no.-s
    if (!$db->Open()) $db->Kill();    
    $query = "SELECT MIN(WEEK(`date1`)) AS minweek, MAX(WEEK(`date1`)) AS maxweek
FROM `inout`
WHERE `no` = '2574'";    
    $db->Query($query);
    $row=$db->Row();
    $minweek = $row->minweek;
    //just from 23.04.2012
    $minweek = 17;    
    $maxweek = $row->maxweek;
    
    echo "<font class='infoHeaderFont'><br>Dook's attendance information from week: nr. $minweek./2012 to nr. $maxweek./2012:</font>";
    
    $sumsec = 0;
    $sumatt = 0; 
    $sumrownum = 0;
    for ($w = $minweek; $w <= $maxweek; $w++) {
        
        echo "<font class='infoHeaderFont'><br>Week nr. $w:</font>";

        if (!$db->Open()) $db->Kill();
        
        $query = "SELECT DAYNAME(`date1`) AS dayname, WEEK(`date1`) AS week, DATE_FORMAT(`date1`, '%d.%m') AS date,
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
               CASE
                  WHEN `outtime` = '00:00:00' THEN 0
                  ELSE TIME_TO_SEC(TIMEDIFF(`outtime`, `intime`))
               END
                  AS sumsec
          FROM `inout`
         WHERE `no` = '2574'
               AND WEEK(`date1`) = '$w') AS t
GROUP BY `date1`
ORDER BY `date1` ASC";
        
        $db->Query($query);
        
        echo "<br><br><table class='info' width=\"25%\">
              <tr>
              <td class='FieldCaptionTD'><B>Dayname</B></td>
              <td class='FieldCaptionTD'><B>Date</B></td>
              <td class='FieldCaptionTD'><B>Hours (hour:min:sec)</B></td>
              <td class='FieldCaptionTD'><B>Attendance</B></td>
              <tr>";
        
        $weeksec = 0;
        $weekatt = 0;      
        $rownum = $db->Rows();
        $sumrownum += $rownum;
        while ($row=$db->Row()) {
            echo "<tr>
                  <td class='DataTDGrey'><B>$row->dayname</B></td>
                  <td class='DataTDGrey'><B>$row->date</B></td>
                  <td class='DataTDGrey'><B>$row->time</B></td>
                  <td class='DataTDGrey'><B>$row->att</B></td>
                  </tr>";
            $weeksec += $row->sec;
            $weekatt += $row->att;
            $sumsec += $row->sec;
            $sumatt += $row->att;
            
        }
        
        $weekh = intval( ($weeksec/3600) );
        $weekm = intval( ($weeksec-$weekh*3600) / 60 );
        $weeks = $weeksec - ($weekh*3600) - ($weekm*60);
        
        $sumh = intval( ($sumsec/3600) );
        $summ = intval( ($sumsec-$sumh*3600) / 60 );
        $sums = $sumsec - ($sumh*3600) - ($summ*60);
        
        $weekavgsec = $weeksec / $rownum;
        $weekavgh = intval( ($weekavgsec/3600) );
        $weekavgm = intval( ($weekavgsec-$weekavgh*3600) / 60 );
        $weekavgs = (int) $weekavgsec - ($weekavgh*3600) - ($weekavgm*60);
        
        $weekavgatt = round($weekatt / $rownum, 2);
        
        $sumavgsec = $sumsec / $sumrownum;        
        $sumavgh = intval( ($sumavgsec/3600) );
        $sumavgm = intval( ($sumavgsec-$sumavgh*3600) / 60 );
        $sumavgs = (int) $sumavgsec - ($sumavgh*3600) - ($sumavgm*60);
        
        $sumavgatt = round($sumatt / $sumrownum, 2);
        
        echo "<tr>
              <td class='FieldCaptionTD' colspan=\"2\"><B>Week total:</B></td>
              <td class='FieldCaptionTD'><B>$weekh:$weekm:$weeks</B></td>
              <td class='FieldCaptionTD'><B>$weekatt days</B></td>
              </tr>
              <tr>
              <td class='FieldCaptionTD' colspan=\"2\"><B>Total time from 23/04/2012:</B></td>
              <td class='FieldCaptionTD'><B>$sumh:$summ:$sums</B></td>
              <td class='FieldCaptionTD'><B>$sumatt days</B></td>
              </tr>
              <tr>
              <td class='FieldCaptionTD' colspan=\"2\"><B>Week average:</B></td>
              <td class='FieldCaptionTD'><B>$weekh:$weekm:$weeks / $rownum = $weekavgh:$weekavgm:$weekavgs</B></td>
              <td class='FieldCaptionTD'><B>$weekatt / $rownum = $weekavgatt day</B></td>
              </tr>
              <tr>
              <td class='FieldCaptionTD' colspan=\"2\"><B>Total average from 23/04/2012:</B></td>
              <td class='FieldCaptionTD'><B>$sumh:$summ:$sums / $sumrownum = $sumavgh:$sumavgm:$sumavgs</B></td>
              <td class='FieldCaptionTD'><B>$sumatt / $sumrownum = $sumavgatt day</B></td>
              </tr>";
        
        echo "</table><br>";
        
        
    } //end for
  
} //end state == 1


?>
    
</CENTER>
</BODY>
</HTML>



