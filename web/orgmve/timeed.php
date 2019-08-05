<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
uprstr($PU,90);


(!isset($_POST['idtime'])) ? $idtime = $_GET['idtime'] : $idtime = $_POST['idtime'];
(!isset($_POST['state'])) ? $state = 0 : $state = $_POST['state'];
(!isset($_POST["saveit"])) ? $saveit = "" : $saveit = $_POST["saveit"];

(!isset($_POST['cln'])) ? $cln = "" : $cln = $_POST['cln'];
(!isset($_POST['skrypt'])) ? $skrypt = $_GET['skrypt'] : $skrypt = $_POST['skrypt'];
(!isset($_POST["date1"])) ? $dzis1 = "0000-00-00" : $dzis1 = $_POST["date1"];
(!isset($_POST["date1old"])) ? $date1old = "0000-00-00" : $date1old = $_POST["date1old"];
(!isset($_POST["intime"])) ? $intime = "00:00:00" : $intime = $_POST["intime"];
(!isset($_POST["intimeold"])) ? $intimeold = "00:00:00" : $intimeold = $_POST["intimeold"];
(!isset($_POST["outtime"])) ? $outtime = "00:00:00" : $outtime = $_POST["outtime"];
(!isset($_POST["outtimeold"])) ? $outtimeold = "00:00:00" : $outtimeold = $_POST["outtimeold"];
(!isset($_POST["MessageToLeave"])) ? $MessageToLeave = "" : $MessageToLeave = $_POST["MessageToLeave"];
(!isset($_POST["ipadr"])) ? $ip = "" : $ip = $_POST["ipadr"];
(!isset($_POST["startd"])) ? $startd = $_GET['startd'] : $startd = $_POST["startd"];
(!isset($_POST["endd"])) ? $endd = $_GET['endd']  : $endd = $_POST["endd"];

if($state==0)
{

 if (!$db->Open()) $db->Kill();

  $q = "SELECT id, date1, intime, outtime, no, ipadr, checked FROM `inout` WHERE id='$idtime' LIMIT 1";

  if (!$db->Query($q)) $db->Kill();
  
    while ($row=$db->Row())
    {
echo "

<center>
<form action='$PHP_SELF' method='POST' name='xx'>
  <font class='FormHeaderFont'>Edit one set IN/OUT</font>

  <table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
    <tbody>
<tr><td  colspan='2'>
<table border='0' cellpadding='3' cellspacing='1'>
<tr>
	  	<td class='FieldCaptionTD'>Payroll NO.</td>
        <td class='DataTD'><B>$row->no</B></td><INPUT TYPE='hidden'  NAME='cln' VALUE='$row->no'>
		<td class='FieldCaptionTD'>Date</td>
        <td class='DataTD'><INPUT TYPE='INPUT' size='12' NAME='date1' VALUE='$row->date1'>
						<INPUT TYPE='hidden' size='12' NAME='date1old' VALUE='$row->date1'></td>
		<td class='FieldCaptionTD'>Time IN</td>
        <td class='DataTD'><INPUT TYPE='INPUT' size='8' NAME='intime' VALUE='$row->intime'>
						<INPUT TYPE='hidden' size='8' NAME='intimeold' VALUE='$row->intime'></td>	
	   		<td class='FieldCaptionTD'>Time OUT</td>
        <td class='DataTD'><INPUT TYPE='INPUT' size='8' NAME='outtime' VALUE='$row->outtime'>
						<INPUT TYPE='hidden' size='8' NAME='outtimeold' VALUE='$row->outtime'></td>
                                                <INPUT TYPE='hidden' size='8' NAME='ipadr' VALUE='$$row->ipadr'></td>
	  </tr><tr>
	  		<td class='FieldCaptionTD'>IP Address</td>
        <td class='DataTD'>$row->ipadr</td>	
	  	  </tr><tr>
	   		<td class='FieldCaptionTD'>Checked</td>
        <td class='DataTD'>$row->checked (will be NO)</td>
</tr>
</TD></tr>
</table></tr>
";
		if (!$db->Open()) $db->Kill();
		$MsgQ= "SELECT id, idinout, date1, tm, no, message, ipadr, checked FROM `inoutmsg` WHERE idinout='$row->id' LIMIT 1";
		if (!$db->Query($MsgQ)) $db->Kill();
	    while ($rowMsg=$db->Row())
		{	
			//id, idinout, date1, tm, no, message, ipadr, checked
		  echo "
		  <tr><td  colspan='2'>
			<table border='0' cellpadding='3' cellspacing='1'>
			<tr>
			    <td class='FieldCaptionTD'>Message connected</td>
				<td class='DataTD'>$rowMsg->message | $rowMsg->date1 |$rowMsg->tm | $rowMsg->checked </td>

			</tr>
		</TD></tr>
		</table>
	
		</tr>";
		}
	//employee 
		if (!$db->Open()) $db->Kill();
		$EmpQ= "SELECT pno, surname, firstname, knownas, paystru FROM `nombers` WHERE pno='$row->no' LIMIT 1";
		if (!$db->Query($EmpQ)) $db->Kill();
	    while ($RowEmp=$db->Row())
		{	
			//id, idinout, date1, tm, no, message, ipadr, checked
		  echo "
			<tr><td  colspan='2'>
			<table border='0' cellpadding='3' cellspacing='1'>
			<tr>
				<td class='DataTD'>$RowEmp->firstname $RowEmp->surname, at TimeTable known as: $RowEmp->knownas </td>

			</tr>
		</TD></tr>
		</table>
	
		</tr>";
		}

echo "
<tr><td  colspan='2'><TEXTAREA NAME='MessageToLeave' ROWS='3' COLS='50'>Unable to clock in / out at (TIME) Shop:	Because:</TEXTAREA></TD>

<tr>
        <td align='right' colspan='2'>
			<input  name='idtime' type='hidden' value='$idtime'>
                        <input  name='skrypt' type='hidden' value='$skrypt'>
                        <input  name='startd' type='hidden' value='$startd'>
                        <input  name='endd' type='hidden' value='$endd'>
			<input  name='state' type='hidden' value='1'>
			<input class='Button' name='saveit' type='submit' value='$SAVEBTN'>
                    <INPUT class='Button' onclick='javascript:history.back()' type='button' name='zmk' value='$BACKBTN'>
		</td>
      </tr>
    </form>
  </tbody>
</table>
</center>
<BR>
</td></tr>
</table>";
}
include_once("./footer.php");
}
elseif($state==1)
{
if(isset($saveit) and $saveit==strval("$SAVEBTN"))
    {  
	$MessageToLeave = $MessageToLeave."Changed from: D:".$date1old.", I:".$intimeold.", O:".$outtimeold;
	if(!$db->Open()) $db->Kill();
	$out1="INSERT INTO `inoutmsg` ( `id`, `idinout`, `date1`, `tm`, `no`, `message`, `ipadr`, `checked` ) VALUES ('', '$idtime', '$dzis1', '$intime', '$cln', '$MessageToLeave', '$ip' , 'c' )";
    if(!$db->Query($out1)) $db->Kill();
	$db->Free();
	
	if (!$db->Open())$db->Kill();
    $query1 =("UPDATE `inout` SET  `intime`='$intime', `outtime`='$outtime', `checked`='c' WHERE id='$idtime' LIMIT 1");
	if ($db->Query($query1)) //$result = mysql_query($query1);
		{
		$op = "edit, $cln OLD Val. (D:$date1old,I:$intimeold,O:$outtimeold)";
		$godz      = date("G:m:s");
		$logi = "INSERT INTO hd_log ( lp, tabela, temat, kiedy, user_id, infodod) VALUES(null, 'inout', '$op', '$dzis $godz', '$id', 'timeed.php')";
		if (!$db->Query($logi)) $db->Kill();
		}

        if (isset($endd) || isset($startd) || isset($cln)) {
            $lok="<script language='javascript'>window.location=\"$skrypt&startd=$startd&endd=$endd\"</script>"; 
        }
        else {$lok="<script language='javascript'>window.location=\"$skrypt\"</script>";}
	echo $lok;
	}
} 
?>