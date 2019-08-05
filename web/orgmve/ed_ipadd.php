<?php
//this file made by Greg from n_sup.php
// edit contact: ed_ipadd.php?IPID=$ipid
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;

if (!isset($_POST['state'])) $state = 0; else $state = $_POST['state'];
if (!isset($_GET['ipid'])) {
    if (!isset($_POST['ipid'])) $state = '-1'; else $ipid = $_POST['ipid'];
}
else $ipid = $_GET['ipid'];

if($state == 0)
{
    if (!$db->Open()) $db->Kill();     
    $query =("SELECT * FROM `ipaddress`
              WHERE `ID` = '$ipid'");
    if (!$db->Query($query)) $db->Kill();
    $computer=$db->Row();

    $_name = $computer->name;
    $_IP = $computer->IP;
    $_mac = $computer->mac;  
    $_namefb = $computer->namefb;
    $_showtrial = $computer->showtrial_fl;
    
    if ($_showtrial == "1") {
        $showtrialtext = "<input type=\"checkbox\" name=\"_showtrial\" checked=\"checked\">";
    } 
    else { $showtrialtext =  "<input type=\"checkbox\" name=\"_showtrial\">"; } 
    
    echo "</TABLE>";
    echo "<table width='100%' border=0><tr><td>

<center>
<form action='$PHP_SELF' method='post' name='new_contact'>
<font class='FormHeaderFont'>Edit IP address</font>
<br><br>
<table WIDTH=700 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >
    <tr>
      <td class='FieldCaptionTD'>Computer name</td> 
      <td class='DataTD'><input class='Input' maxlength='55' name='_name' size='60' value=\"$_name\"></td> 
    </tr>
    <tr>
      <td class='FieldCaptionTD'>IP Address</td> 
      <td class='DataTD'><input class='Input' maxlength='55' name='_IP' size='60' value=\"$_IP\"></td> 
    </tr>
    <tr>
      <td class='FieldCaptionTD'>MAC Address</td> 
      <td class='DataTD'><input class='Input' maxlength='55' name='_mac' size='60' value=\"$_mac\"></td> 
    </tr>
    <tr>
      <td class='FieldCaptionTD'>Clocking page name</td> 
      <td class='DataTD'><input class='Input' maxlength='55' name='_namefb' size='60' value=\"$_namefb\"></td> 
    </tr>    
    <tr>
      <td class='FieldCaptionTD'>Show trial memo</td>
      <td class='DataTD'>$showtrialtext</td> 
    </tr>

    <tr>
      <td align='center' colspan='2'>
            <input name='state' type='hidden' value='1'>
            <input name='ipid' type='hidden' value='$ipid'>
            <input class='Button' name='Nowy' type='submit' value='$SAVEBTN'>
            <input class='Button' type='Button' onclick='javascript:history.back()' value='$BACKBTN'>
      </td> 
    </tr>
 
  </table>
</form>

</center>
<BR>
</td>
</tr>
</table>";
        
echo "
</CENTER>
</BODY>
</HTML>";
}

elseif($state == 1)
{
    $ipid = $_POST['ipid'];
    
    if (!isset($_POST['_name'])) $_name = ''; else $_name = addslashes($_POST['_name']);
    if (!isset($_POST['_IP'])) $_IP = ''; else $_IP = addslashes($_POST['_IP']);    
    if (!isset($_POST['_mac'])) $_mac = ''; else $_mac = addslashes($_POST['_mac']);    
    if (!isset($_POST['_namefb'])) $_namefb = ''; else $_namefb = addslashes($_POST['_namefb']);
    if (!isset($_POST['_showtrial'])) $_showtrial  = 0; else $_showtrial  = $_POST["_showtrial"];
    if( $_showtrial !== 0 ) $_showtrial = 1;
    
    if (!$db->Open()) $db->Kill();     
        $query = ("UPDATE `ipaddress` SET `name` = '$_name', `IP` = '$_IP', `mac` = '$_mac', `namefb` = '$_namefb', `showtrial_fl` = '$_showtrial'
                   WHERE `ID` = '$ipid'");
           
     $result = mysql_query($query);
     if (!$db->Open()) $db->Kill();
     
     echo "<script language='javascript'>window.location=\"ipinfo.php\"</script>";
}

elseif($state == '-1') {
    echo "<font class='FormHeaderFont'><BR>Invalid IPID!<BR>What are you doing???</font>";
}

?>