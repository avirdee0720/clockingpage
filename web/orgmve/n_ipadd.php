<?php
//this file made by Greg from n_sup.php
// edit contact: ed_con.php?CID=$cid
include("./config.php");
include_once("./header.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;

if (!isset($_POST['state'])) $state = 0; else $state = $_POST['state'];

if (!isset($_POST['_name'])) $_name = ''; else $_name = addslashes($_POST['_name']);
if (!isset($_POST['_IP'])) $_IP = ''; else $_IP = addslashes($_POST['_IP']);    
if (!isset($_POST['_mac'])) $_mac = ''; else $_mac = addslashes($_POST['_mac']);    
if (!isset($_POST['_namefb'])) $_namefb = ''; else $_namefb = addslashes($_POST['_namefb']);
if (!isset($_POST['_showtrial'])) $_showtrial  = 0; else $_showtrial  = $_POST["_showtrial"];
if( $_showtrial !== 0 ) $_showtrial = 1;

if($state == 0) {
    echo "</TABLE>";
    echo "<table width='100%' border=0><tr><td>

<center>
<form action='$PHP_SELF' method='post' name='new_contact'>
<font class='FormHeaderFont'>Add new IP address</font>
<br><br>
<table WIDTH=700 bordercolorlight='black' border='border' style='border-collapse: collapse; background-color: white' >
    <tr>
      <td class='FieldCaptionTD'>Computer name</td> 
      <td class='DataTD'><input class='Input' maxlength='55' name='_name' size='60' value=''></td> 
    </tr>
    <tr>
      <td class='FieldCaptionTD'>IP Address</td> 
      <td class='DataTD'><input class='Input' maxlength='55' name='_IP' size='60' value=''></td> 
    </tr>
    <tr>
      <td class='FieldCaptionTD'>MAC Address</td> 
      <td class='DataTD'><input class='Input' maxlength='55' name='_mac' size='60' value=''></td> 
    </tr>
    <tr>
      <td class='FieldCaptionTD'>Clocking page name</td> 
      <td class='DataTD'><input class='Input' maxlength='55' name='_namefb' size='60' value=''></td> 
    </tr>    
    <tr>
      <td class='FieldCaptionTD'>Show trial memo</td>
      <td class='DataTD'><input type=\"checkbox\" name=\"_showtrial\"></td> 
    </tr>

    <tr>
      <td align='center' colspan='2'>
            <input name='state' type='hidden' value='1'>
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

elseif($state == 1) {

    if (!$db->Open())$db->Kill();     
    $query =("INSERT INTO `ipaddress` (ID, name, IP, namefb, mac, showtrial_fl)
              VALUES (NULL, '$_name', '$_IP', '$_namefb', '$_mac', '$_showtrial')");     
    $result = mysql_query($query);
    
    if (!$db->Open())$db->Kill();
    $ipid=mysql_insert_id();
         
     echo "<script language='javascript'>window.location=\"ipinfo.php\"</script>";

} 

?>