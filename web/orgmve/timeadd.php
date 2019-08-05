<?php
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
uprstr($PU,90);

(!isset($_POST['state'])) ? $state = 0 : $state = $_POST['state'];
(!isset($_POST['cln'])) ? $cln = $_GET['cln'] : $cln = $_POST['cln'];
(!isset($_POST['skrypt'])) ? $skrypt = $_GET['skrypt'] : $skrypt = $_POST['skrypt'];
(!isset($_POST['saveit'])) ? $saveit = "" : $saveit = $_POST['saveit'];
(!isset($_POST["dateR"])) ? $dateR = "00/00/0000" : $dateR = $_POST["dateR"];
(!isset($_POST["intimeR"])) ? $intimeR = "00:00:00" : $intimeR = $_POST["intimeR"];
(!isset($_POST["outtimeR"])) ? $outtimeR = "00:00:00" : $outtimeR = $_POST["outtimeR"];
(!isset($_POST["ipadresR"])) ? $ipadresR = "0.0.0.0" : $ipadresR = $_POST["ipadresR"];
(!isset($_POST["startd"])) ? $startd = $_GET['startd'] : $startd = $_POST["startd"];
(!isset($_POST["endd"])) ? $endd = $_GET['endd']  : $endd = $_POST["endd"];

if($state==0)
{

echo "

<center>
<form action='$PHP_SELF' method='POST' name='xx'>
  <font class='FormHeaderFont'>Add IN/OUT day</font>

  <table border='0' cellpadding='3' cellspacing='1' class='FormTABLE'>
    <tbody>
<tr><td  colspan='2'>
<table border='0' cellpadding='3' cellspacing='1'>
<tr>
	  	<td class='FieldCaptionTD'>Payroll NO.</td><td class='DataTD'><B>$cln</B></td></tr><tr>
		<td class='FieldCaptionTD'>Date</td><td class='DataTD'><INPUT TYPE='INPUT' size='12' NAME='dateR' VALUE='$dzis' onKeyPress='m_l_data2(this)'></td></tr><tr>
		<td class='FieldCaptionTD'>Time IN</td><td class='DataTD'><INPUT TYPE='INPUT' size='8' NAME='intimeR' VALUE='10:00:00' onKeyPress='m_l_data(this)'></td>	</tr><tr>
	    <td class='FieldCaptionTD'>Time OUT</td><td class='DataTD'><INPUT TYPE='INPUT' size='8' NAME='outtimeR' VALUE='20:00:00' onKeyPress='m_l_data(this)'></td>
	  </tr><tr>
	  		<td class='FieldCaptionTD'>SHOP</td>


<td class='DataTD'>   <select class='Select' name='ipadresR'>
		<option selected value='127.0.0.1'>LOCAL by default</option>";
		  $q = "SELECT `IP`,MIN(`namefb`) AS ipname FROM `ipaddress` GROUP BY `namefb` ORDER BY `namefb`";

//	$db = new CMySQL;
     if (!$db->Open()) $db->Kill();
  if ($db->Query($q)) 
  {
    while ($r=$db->Row())
    {

          echo "<option value='$r->IP'> $r->ipname</option>";
    }
	} else {
echo " 
  <tr>
    <td class='DataTD'></td>
    <td class='DataTD' colspan='3'>SQL Error 1a</td>
  </tr>";
 $db->Kill();
}
echo " </select>
</td>	
	  	  </tr><tr>
	   		<td class='FieldCaptionTD'>Checked</td>
        <td class='DataTD'>(will be set to YES)</td>
</tr>
</TD></tr>
</table></tr>
";

	//employee 
		if (!$db->Open()) $db->Kill();
		$EmpQ= "SELECT pno, surname, firstname, knownas, paystru FROM `nombers` WHERE pno='$cln' LIMIT 1";
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
<tr><td  colspan='2'>

<tr>
        <td align='right' colspan='2'>
			<input  name='skrypt' type='hidden' value='$skrypt'>
			<input  name='state' type='hidden' value='1'>
			<input  name='cln' type='hidden' value='$cln'>
                        <input  name='startd' type='hidden' value='$startd'>
                        <input  name='endd' type='hidden' value='$endd'>
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

include_once("./footer.php");
}
elseif($state==1)
{
if(isset($saveit) and $saveit==strval("$SAVEBTN"))
    {  

				if(!$db->Open()) $db->Kill();
			      $ttt="INSERT INTO `inout` ( `id`, `date1`, `intime`, `outtime`, `no`,  `ipadr`, `checked` ) VALUES ('', '$dateR', '$intimeR', '$outtimeR', '$cln', '$ipadresR', 'c')";
                 if(!$db->Query($ttt)) $db->Kill();
				  $id=mysql_insert_id();
				 if(!$db->Open()) $db->Kill();
			      $in1="INSERT INTO `inoutmsg` ( `id`, `idinout`, `date1`, `tm`, `no`, `message`, `ipadr`, `checked` ) VALUES ('', '$id', '$dateR', '$intimeR', '$cln', 'Added by payroll.', '$ipadresR' , 'c' )";
                 if(!$db->Query($in1)) $db->Kill();

	if (isset($endd) || isset($startd) || isset($cln)) {
            $lok="<script language='javascript'>window.location=\"$skrypt?cln=$cln&startd=$startd&endd=$endd\"</script>"; 
        }
        else {$lok="<script language='javascript'>window.location=\"$skrypt\"</script>";}
	echo $lok;
	}
} 

?>