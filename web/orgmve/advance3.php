<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$dataakt=date("d/m/Y H:i:s");
$msgdb = new CMySQL;
uprstr($PU,90);
$title="Advance ";

$no=$_POST['no'];
$firstname=$_POST['firstname'];
$surname=$_POST['surname'];
$date1a=$_POST['date1'];
$amount=$_POST['amount'];
$mamount=$_POST['mamount'];
$licz=$_POST['licz'];
$mm=$_POST['mm'];
$year=$_POST['year'];

list($day, $month, $year1) = explode("/",$_POST['date1']);
$dod = "$year1-$month-$day";
$dateday=$_POST['date1'];

echo "<font class='FormHeaderFont'>$title</font>";
	$db = new CMySQL;
	if (!$db->Open()) $db->Kill();
	$sql = "INSERT INTO `advances_get` (`id`, `no`, `date1`, `amount`, `gvienby`, `dateg`) 
			VALUES (NULL, '$no', '$dod', '$amount', '$id', '$dzis $godz:00');";
	if ($db->Query($sql)) 
	{
	$idadv=mysql_insert_id();
	echo "<table>
    <tr>
      <td class='FieldCaptionTD'>Clocking in number</td><td class='DataTD'><FONT COLOR='#000099'><B>$no</B></FONT></td>
	  <td class='FieldCaptionTD'>&nbsp;</td><td class='DataTD'>&nbsp;</td>
    </tr>
    <tr>
      <td class='FieldCaptionTD'>First name</td><td class='DataTD'>$firstname</td>
      <td class='FieldCaptionTD'>Surname</td><td class='DataTD'>$surname</td>
    </tr>
	<TR>
	<TD>Date</TD>
	<TD>$date1a</TD>
	</TR>
	<TR>
	<TD>Amount</TD>
	<TD>&pound; $amount</TD>
	</TR>
	<TR>
	<TD>ADDED BY</TD>
	<TD>$nazwa</TD>
	</TR>
</TABLE>";
//add to monthly payment
	$db2 = new CMySQL;

	for ($i = 0; $i <= $licz-1; $i++) {
		if (!$db2->Open()) $db2->Kill();
		$sql2 = "INSERT INTO `advances` ( `id` , `no` , `month` , `topay` , `idadv`, `year` ) VALUES (NULL , '$no', '$mm[$i]', '$mamount[$i]', '$idadv', '$year[$i]')";
		if (!$db2->Query($sql2)) $db2->Kill();
	}
	

	} else {
		echo " 
		 <tr><td class='DataTD'></td><td class='DataTD' colspan='5'>SQL Error:".mysql_error()."</td></tr>";
		$db->Kill();
	}

	echo "
	</table>
			<BR><A HREF='t_lista.php'><input class='Button' name='Update' type='submit' value='$SAVEBTN'></A>
	</center>
	</td></tr>
	</table>";


include_once("./footer.php");
?>