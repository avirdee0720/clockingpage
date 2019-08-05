<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$tytul = 'Voucherslips upload';
$date1 = date("Ymd");
$dataakt = date("d/m/Y");

if (!$db->Open()) $db->Kill();

(!isset($_POST['state'])) ? $state = 0 : $state = $_POST['state'];

if ($state == 0) {
// vouchers CSV data file upload form
	echo "
	<td align=justify valign=top border=0>
	<table width='100%' border=0>
	<tr><td>
		<center>
		<form action='$PHP_SELF' method='post' name='ed_czl' enctype='multipart/form-data'>
			<font class='FormHeaderFont'>$tytul</font>
			<table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
				<tr>                                                                                    
					<td class='FieldCaptionTD'>Voucher data
					</td>
					<td class='DataTD'>
						<input type=\"file\" name=\"vouchers_attachment\" id=\"fileField\"/>
					</td> 
				</tr>                                                                                      
				<tr>
					<td align='right' colspan='2'>
						<input name='state' type='hidden' value='1'>
						<input class='Button' name='Update' type='submit' value='$SAVEBTN'>
						<input class='Button'  type='Button' onclick='window.location=\"t_lista.php\"' value='$LISTBTN'>
					</td>
				</tr>
			</table>
		</form>
		</center>
		<br>
	</td></tr>
	</table>
	";
	include_once("./footer.php");
}
elseif ($state == 1) {
// vouchers CSV data file upload and insertion into database
	echo "<p style='font-size: 12px; text-align: center'>";
    $vouchers_attachment = $_FILES['vouchers_attachment']['name'];
    $voucher_date = preg_replace("/[^0-9]/", '', $vouchers_attachment);
 
    $target_path_v = "voucherslips/"; 
    $target_path_v = $target_path_v . basename( $_FILES['vouchers_attachment']['name']);
 
    if(move_uploaded_file($_FILES['vouchers_attachment']['tmp_name'], $target_path_v)) {
        echo "<br>Received file \"".  basename( $_FILES['vouchers_attachment']['name']). "\"<br>";
    } else{
        echo "<br>There was an error uploading the file, please try again!<br>";
    }
    
    $vouchersarray = file($target_path_v);
    
    // find next load_id
    $sql = "SELECT MAX(load_id) AS maxloadid FROM `voucherslips`";
    if ($db->Query($sql)) { 
        $row=$db->Row();
        if (!isset($row->maxloadid))
            $load_id = 0;
        else $load_id = $row->maxloadid;
    }
    $load_id++;
    
    // check if the month is already in the database
    $alreadyexists = 0;
    $sql = "SELECT COUNT(*) AS entries FROM voucherslips WHERE month_id LIKE '$voucher_date'";
    if ($db->Query($sql)) { 
        $row = $db->Row();
        if ($row->entries > 0) $alreadyexists = 1;
    }

	echo "<br>Processing...<br><br>";
	
    if ($alreadyexists == 0) {
		echo "
			<div style='font-size: 12px; text-align: left'>
			<table width='100%' border='0'>
				<tr>
					<td width='40%'>&nbsp</td>
					<td width='20%'>";
		$voucher_rec_c = 0;
        foreach($vouchersarray as $row_data) {
            //skip 1st line
            if ($voucher_rec_c != 0 ) {

                $row = explode(",", $row_data);
				// trim whitespace
                for ($i = 0; $i < count($row); $i++) {
					$row[$i] = trim($row[$i]);
				}
				
				if (!$row[6]) $row[6] = 0;
				if (!$row[7]) $row[7] = 0;
				if (!$row[8]) $row[8] = 0;
				if (!$row[9]) $row[9] = 0;
				if (!$row[11]) $row[11] = 0;
				if (!$row[12]) $row[12] = 0;
				if (!$row[13]) $row[13] = 0;
				if (!$row[14]) $row[14] = 0;
				// WHOLD = withhold, the people who have their vouchers withheld for some reason don't get them generated
                if (!isset($row[17]) || !($row[17]) || strtoupper(substr($row[17], 0, 5) == 'WHOLD')) $row[17] = 0;
                
                
				if ($row[0] != '') {
                    $ins = "INSERT INTO `voucherslips`
                    ( `load_id`, `month_id`, `no`, `knownas`, `surname`,
                      `month`, `cat`, `unit`, `EinWeeks`, `EinDays`,
                      `taken`, `left`, `bonustype`, `wendsTD`, `AVTD`,
                      `NOneed`, `AVneed`,`from`, `to`, `vouchers`) VALUES
                    ( $load_id, '$voucher_date', $row[0], '$row[1]', '$row[2]',
                      '$row[3]', '$row[4]', '$row[5]', $row[6], $row[7],
                      $row[8], $row[9], '$row[10]', $row[11], $row[12],
                      $row[13], $row[14], '$row[15]', '$row[16]', $row[17])";

                    if (!$db->Query($ins)) $db->Kill();
                    echo "Line $voucher_rec_c: $row[0] $row[1] $row[2] OK<br>";                
                }

            }
            $voucher_rec_c++;
        }
        echo "		<br>The import was successful.<br><br>
					</td>
					<td width='40%'>&nbsp</td>
				</tr>
			</table>
			</div>
			";
    }
	else
        echo "The date $voucher_date is already in the database. Import aborted.";
	echo "</p>";
}
?>